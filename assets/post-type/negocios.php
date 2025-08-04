<?php
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
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'negocios'),
        'supports'           => array('title', 'editor', 'thumbnail'),
        'menu_icon'          => 'dashicons-cart',
        'show_in_rest'       => true,
        'hierarchical'       => false
    );

    register_post_type('negocios', $args);
}
add_action('init', 'kubee_register_post_type_negocios');

// Adiciona metabox para campos personalizados no post type Negócios
function kubee_add_negocios_metabox() {
    add_meta_box(
        'negocios_extra',
        'Detalhes do Negócio',
        'kubee_negocios_metabox_callback',
        'negocios',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kubee_add_negocios_metabox');

function kubee_negocios_metabox_callback($post) {
    // Recupera valores salvos (caso existam)
    $icon_url  = get_post_meta($post->ID, '_negocio_icon_url', true);
    $resumo    = get_post_meta($post->ID, '_negocio_resumo', true);
    $subtitulo = get_post_meta($post->ID, '_negocio_subtitulo', true); // NOVO CAMPO

    // Campo para imagem (ícone)
    ?>
    <label for="negocio_icon_url"><strong>URL do Ícone (imagem PNG/SVG):</strong></label>
    <input type="text" id="negocio_icon_url" name="negocio_icon_url" value="<?php echo esc_attr($icon_url); ?>" style="width:90%;" />
    <button type="button" class="button" id="upload_icon_button">Selecionar Imagem</button>
    <br><br>

    <label for="negocio_subtitulo"><strong>Subtítulo:</strong></label>
    <input type="text" id="negocio_subtitulo" name="negocio_subtitulo" value="<?php echo esc_attr($subtitulo); ?>" style="width:90%;" />
    <br><br>

    <label for="negocio_resumo"><strong>Resumo do Negócio:</strong></label>
    <textarea id="negocio_resumo" name="negocio_resumo" rows="3" style="width:90%;"><?php echo esc_textarea($resumo); ?></textarea>

    <script>
    jQuery(document).ready(function($){
        $('#upload_icon_button').click(function(e) {
            e.preventDefault();
            var image = wp.media({ 
                title: 'Selecionar Ícone',
                multiple: false
            }).open().on('select', function(){
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                $('#negocio_icon_url').val(image_url);
            });
        });
    });
    </script>
    <?php
}

// Salva os campos personalizados
function kubee_save_negocios_metabox($post_id) {
    // Não processa em autosave ou se não for tipo 'negocios'
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['post_type']) || $_POST['post_type'] != 'negocios') return;

    // Ícone
    if (array_key_exists('negocio_icon_url', $_POST)) {
        update_post_meta($post_id, '_negocio_icon_url', esc_url_raw($_POST['negocio_icon_url']));
    }
    // Subtítulo (NOVO)
    if (array_key_exists('negocio_subtitulo', $_POST)) {
        update_post_meta($post_id, '_negocio_subtitulo', sanitize_text_field($_POST['negocio_subtitulo']));
    }
    // Resumo
    if (array_key_exists('negocio_resumo', $_POST)) {
        update_post_meta($post_id, '_negocio_resumo', sanitize_text_field($_POST['negocio_resumo']));
    }
}
add_action('save_post', 'kubee_save_negocios_metabox');
