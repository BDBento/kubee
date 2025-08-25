<?php
/* === CPT: Negócios com ordenação por arrastar === */

// 1) Registrar CPT com suporte a "page-attributes" (usa menu_order)
function kubee_register_post_type_negocios() {
    $labels = array(
        'name'               => 'Negócios',
        'singular_name'      => 'Negócio',
        'menu_name'          => 'Negócios',
        'name_admin_bar'     => 'Negócio',
        'add_new'            => 'Adicionar Novo',
        'add_new_item'       => 'Adicionar Novo Negócio',
        'new_item'           => 'Novo Negócio',
        'edit_item'          => 'Editar Negócio',
        'view_item'          => 'Ver Negócio',
        'all_items'          => 'Todos os Negócios',
        'search_items'       => 'Buscar Negócios',
        'not_found'          => 'Nenhum negócio encontrado',
        'not_found_in_trash' => 'Nenhum negócio na lixeira'
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => array('slug' => 'negocios'),
        'supports'      => array('title', 'editor', 'thumbnail', 'page-attributes'), // <= importante
        'menu_icon'     => 'dashicons-cart',
        'show_in_rest'  => true,
        'hierarchical'  => false
    );

    register_post_type('negocios', $args);
}
add_action('init', 'kubee_register_post_type_negocios');

/* 2) ADMIN: ordenar lista por menu_order ASC por padrão e permitir ordenar pela coluna */
add_action('pre_get_posts', function($q){
    if (is_admin() && $q->is_main_query() && $q->get('post_type') === 'negocios') {
        // Apenas define padrão se não houver "orderby" explícito
        if (!$q->get('orderby')) {
            $q->set('orderby', array('menu_order' => 'ASC', 'date' => 'DESC'));
        }
    }
});

add_filter('manage_edit-negocios_sortable_columns', function($cols){
    $cols['menu_order'] = 'menu_order';
    return $cols;
});

/* 3) ADMIN: coluna "Ordem" visível */
add_filter('manage_negocios_posts_columns', function($cols){
    $new = array();
    // coloca a coluna de ordem logo após o checkbox
    foreach ($cols as $k => $v) {
        $new[$k] = $v;
        if ($k === 'cb') $new['menu_order'] = 'Ordem';
    }
    return $new;
});
add_action('manage_negocios_posts_custom_column', function($col, $post_id){
    if ($col === 'menu_order') {
        $post = get_post($post_id);
        echo intval($post->menu_order);
    }
}, 10, 2);

/* 4) ADMIN: drag-and-drop na lista de posts e salvamento via AJAX */
add_action('admin_enqueue_scripts', function($hook){
    // Apenas na tela de listagem do CPT
    if ($hook !== 'edit.php' || (isset($_GET['post_type']) && $_GET['post_type'] !== 'negocios')) return;

    wp_enqueue_script('jquery-ui-sortable');
    $screen = get_current_screen();
    // "itens por página" definido em Opções de Tela; default 20
    $per_page = (int) get_user_option('edit_negocios_per_page', get_current_user_id());
    if ($per_page <= 0) $per_page = 20;

    $paged = isset($_GET['paged']) ? max(1, (int) $_GET['paged']) : 1;

    wp_add_inline_script('jquery-ui-sortable', sprintf(
        'jQuery(function($){
            var $tbody = $(".wp-list-table.posts tbody");
            $tbody.sortable({
                items: "> tr.type-negocios",
                cursor: "move",
                axis: "y",
                containment: "parent",
                helper: function(e, ui){
                    ui.children().each(function(){ $(this).width($(this).width()); });
                    return ui;
                },
                update: function(){
                    var ids = [];
                    $tbody.find("tr.type-negocios").each(function(){
                        ids.push($(this).attr("id").replace("post-", ""));
                    });
                    var data = {
                        action: "kubee_sort_negocios",
                        nonce: "%s",
                        ids: ids,
                        paged: %d,
                        per_page: %d
                    };
                    $.post(ajaxurl, data, function(resp){
                        if (!resp || !resp.success) {
                            alert("Falha ao salvar a nova ordem.");
                        } else {
                            // Recarrega para refletir a nova numeração da coluna
                            location.reload();
                        }
                    });
                }
            }).disableSelection();
            // Dica visual de que é arrastável
            $tbody.find("tr.type-negocios").css("cursor","move");
        });',
        esc_js(wp_create_nonce('kubee_sort_negocios')),
        (int) $paged,
        (int) $per_page
    ));
});

// AJAX: salvar nova ordem
add_action('wp_ajax_kubee_sort_negocios', function(){
    if (!current_user_can('edit_others_posts')) {
        wp_send_json_error('perm');
    }
    check_ajax_referer('kubee_sort_negocios', 'nonce');

    $ids = isset($_POST['ids']) && is_array($_POST['ids']) ? array_map('intval', $_POST['ids']) : array();
    $paged = isset($_POST['paged']) ? max(1, (int) $_POST['paged']) : 1;
    $per_page = isset($_POST['per_page']) ? max(1, (int) $_POST['per_page']) : 20;

    if (empty($ids)) wp_send_json_error('ids');

    // Calcula deslocamento considerando paginação atual
    $offset = ($paged - 1) * $per_page;

    // Reatribui menu_order sequencialmente a partir do offset
    $order = $offset;
    foreach ($ids as $post_id) {
        wp_update_post(array(
            'ID' => $post_id,
            'menu_order' => $order
        ));
        $order++;
    }
    wp_send_json_success(true);
});

/* 5) FRONT-END: exemplo de WP_Query usando a ordem definida */
function kubee_get_negocios_ordenados($args = array()){
    $defaults = array(
        'post_type'      => 'negocios',
        'posts_per_page' => -1,
        'orderby'        => array('menu_order' => 'ASC', 'date' => 'DESC'),
        'order'          => 'ASC',
        'no_found_rows'  => true,
    );
    return new WP_Query( wp_parse_args($args, $defaults) );
}

/* === Metaboxes existentes (seus campos) permanecem iguais === */
function kubee_add_negocios_metabox() {
    add_meta_box('negocios_extra','Detalhes do Negócio','kubee_negocios_metabox_callback','negocios','normal','high');
}
add_action('add_meta_boxes', 'kubee_add_negocios_metabox');

function kubee_negocios_metabox_callback($post) {
    $icon_url  = get_post_meta($post->ID, '_negocio_icon_url', true);
    $resumo    = get_post_meta($post->ID, '_negocio_resumo', true);
    $subtitulo = get_post_meta($post->ID, '_negocio_subtitulo', true);
    ?>
    <label for="negocio_icon_url"><strong>URL do Ícone (PNG/SVG):</strong></label>
    <input type="text" id="negocio_icon_url" name="negocio_icon_url" value="<?php echo esc_attr($icon_url); ?>" style="width:90%;" />
    <button type="button" class="button" id="upload_icon_button">Selecionar Imagem</button>
    <br><br>

    <label for="negocio_subtitulo"><strong>Subtítulo:</strong></label>
    <input type="text" id="negocio_subtitulo" name="negocio_subtitulo" value="<?php echo esc_attr($subtitulo); ?>" style="width:90%;" />
    <br><br>

    <label for="negocio_resumo"><strong>Resumo do Negócio:</strong></label>
    <textarea id="negocio_resumo" name="negocio_resumo" rows="3" style="width:90%;"><?php echo esc_textarea($resumo); ?></textarea>

    <script>
    jQuery(function($){
        $('#upload_icon_button').on('click', function(e){
            e.preventDefault();
            var frame = wp.media({ title: 'Selecionar Ícone', multiple: false });
            frame.on('select', function(){
                var img = frame.state().get('selection').first().toJSON();
                $('#negocio_icon_url').val(img.url);
            });
            frame.open();
        });
    });
    </script>
    <?php
}

function kubee_save_negocios_metabox($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if ((isset($_POST['post_type']) && $_POST['post_type'] !== 'negocios')) return;

    if (isset($_POST['negocio_icon_url'])) {
        update_post_meta($post_id, '_negocio_icon_url', esc_url_raw($_POST['negocio_icon_url']));
    }
    if (isset($_POST['negocio_subtitulo'])) {
        update_post_meta($post_id, '_negocio_subtitulo', sanitize_text_field($_POST['negocio_subtitulo']));
    }
    if (isset($_POST['negocio_resumo'])) {
        update_post_meta($post_id, '_negocio_resumo', sanitize_text_field($_POST['negocio_resumo']));
    }
}
add_action('save_post', 'kubee_save_negocios_metabox');
