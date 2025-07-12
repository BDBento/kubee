<?php
function kubee_register_post_type_clientes() {

    $labels = array(
        'name'               => 'Nossos Clientes',
        'singular_name'      => 'Cliente',
        'menu_name'          => 'Nossos Clientes',
        'name_admin_bar'     => 'Cliente',
        'add_new'            => 'Adicionar Novo',
        'add_new_item'       => 'Adicionar Novo Cliente',
        'new_item'           => 'Novo Cliente',
        'edit_item'          => 'Editar Cliente',
        'view_item'          => 'Ver Cliente',
        'all_items'          => 'Todos os Clientes',
        'search_items'       => 'Buscar Clientes',
        'not_found'          => 'Nenhum cliente encontrado',
        'not_found_in_trash' => 'Nenhum cliente na lixeira'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => false, // pode ser true se quiser página de arquivo
        'rewrite'            => array('slug' => 'clientes'),
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon'          => 'dashicons-groups', // ícone do admin
        'show_in_rest'       => true,
        'hierarchical'       => false
    );

    register_post_type('clientes', $args);
}
add_action('init', 'kubee_register_post_type_clientes');
