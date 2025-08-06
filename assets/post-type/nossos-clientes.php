<?php

// 1. Registra o CPT Clientes
function kubee_register_post_type_clientes()
{
    register_post_type('clientes', [
        'labels' => [
            'name'               => 'Nossos Clientes',
            'singular_name'      => 'Cliente',
            'menu_name'          => 'Nossos Clientes',
            'add_new_item'       => 'Adicionar Novo Cliente',
            'edit_item'          => 'Editar Cliente',
            'all_items'          => 'Todos os Clientes',
        ],
        'public'       => true,
        'has_archive'  => false,
        'rewrite'      => ['slug' => 'clientes'],
        'supports'     => ['title'], // só título
        'menu_icon'    => 'dashicons-groups',
        'show_in_rest' => true,
    ]);
}
add_action('init', 'kubee_register_post_type_clientes');

// 2. Adiciona metabox customizado
function kubee_add_clientes_metabox()
{
    add_meta_box(
        'clientes_extra',
        'Detalhes do Cliente',
        'kubee_clientes_metabox_callback',
        'clientes',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kubee_add_clientes_metabox');

// 3. Conteúdo do metabox
function kubee_clientes_metabox_callback($post)
{
    $link = get_post_meta($post->ID, '_cliente_link', true);
    $media_id = get_post_meta($post->ID, '_cliente_media_id', true);
    $thumb = $media_id ? wp_get_attachment_image_url($media_id, 'thumbnail') : '';
    wp_nonce_field('kubee_save_cliente', 'kubee_cliente_nonce');
?>
    <div>
        <p>
            <label for="cliente_media"><strong>Logo/Ícone:</strong></label><br>
            <?php if ($thumb): ?>
                <img src="<?php echo esc_url($thumb); ?>" style="max-width:80px; display:block; margin-bottom:8px;">
            <?php endif; ?>
            <button type="button" class="button" id="upload_cliente_media">
                <?php echo $thumb ? 'Alterar imagem' : 'Selecionar imagem'; ?>
            </button>
            <input type="hidden" id="cliente_media_id" name="cliente_media_id" value="<?php echo esc_attr($media_id); ?>">

        </p>
        <p>
            <label for="cliente_link"><strong>Link (opcional):</strong></label><br>
            <input type="url" name="cliente_link" id="cliente_link" value="<?php echo esc_attr($link); ?>" style="width:100%;" placeholder="https://...">
        </p>
    </div>
   
<?php
}

// 4. Salva os dados do metabox
function kubee_save_cliente_metabox($post_id)
{
    if (
        !isset($_POST['kubee_cliente_nonce'])
        || !wp_verify_nonce($_POST['kubee_cliente_nonce'], 'kubee_save_cliente')
        || defined('DOING_AUTOSAVE') && DOING_AUTOSAVE
        || get_post_type($post_id) !== 'clientes'
    ) {
        return;
    }
    if (isset($_POST['cliente_media_id'])) {
        update_post_meta($post_id, '_cliente_media_id', intval($_POST['cliente_media_id']));
    }
    if (isset($_POST['cliente_link'])) {
        update_post_meta($post_id, '_cliente_link', esc_url_raw($_POST['cliente_link']));
    }
}
add_action('save_post', 'kubee_save_cliente_metabox');
