<?php
/**
 * CPT: Ferramentas Usadas
 */
function kubee_register_cpt_ferramentas_usadas() {
  $labels = [
    'name'               => 'Ferramentas usadas',
    'singular_name'      => 'Ferramenta usada',
    'menu_name'          => 'Ferramentas usadas',
    'add_new'            => 'Adicionar nova',
    'add_new_item'       => 'Adicionar ferramenta',
    'edit_item'          => 'Editar ferramenta',
    'new_item'           => 'Nova ferramenta',
    'view_item'          => 'Ver ferramenta',
    'search_items'       => 'Buscar ferramentas',
    'not_found'          => 'Nenhuma encontrada',
    'not_found_in_trash' => 'Nenhuma na lixeira',
  ];

  $args = [
    'labels'        => $labels,
    'public'        => true,
    'show_in_rest'  => true,
    'menu_position' => 22,
    'menu_icon'     => 'dashicons-hammer',
    'supports'      => ['title','thumbnail','page-attributes'], // usa menu_order
    'has_archive'   => false,
    'rewrite'       => ['slug' => 'ferramentas-usadas'],
  ];

  register_post_type('ferramentas_usadas', $args);
}
add_action('init', 'kubee_register_cpt_ferramentas_usadas');

/**
 * Suportes e tamanhos
 */
add_action('after_setup_theme', function () {
  add_theme_support('post-thumbnails');
  add_post_type_support('ferramentas_usadas','thumbnail');
  add_image_size('kubee_icon', 128, 128, false);
});

/**
 * Helper: URL da Imagem Destacada (com fallback para SVG sem sizes)
 */
function kubee_ferramenta_icon_url($post_id, $size = 'kubee_icon'){
  $thumb_id = get_post_thumbnail_id($post_id);
  if ($thumb_id) {
    $url = wp_get_attachment_image_url($thumb_id, $size);
    if (!$url) $url = wp_get_attachment_url($thumb_id); // ex.: SVG
    if ($url) return $url;
  }
  return '';
}

/**
 * Colunas no admin: ícone, título, ordem, data
 */
function kubee_ferramenta_columns($cols) {
  $new = [];
  $new['cb']         = $cols['cb'];
  $new['thumbnail']  = 'Ícone';
  $new['title']      = 'Título';
  $new['menu_order'] = 'Ordem';
  $new['date']       = $cols['date'];
  return $new;
}
add_filter('manage_ferramentas_usadas_posts_columns', 'kubee_ferramenta_columns');

function kubee_ferramenta_columns_content($col, $post_id) {
  if ($col === 'thumbnail') {
    $u = kubee_ferramenta_icon_url($post_id, 'kubee_icon');
    echo $u ? '<img src="'.esc_url($u).'" style="width:40px;height:40px;object-fit:contain;">' : '—';
  }
  if ($col === 'menu_order') {
    $p = get_post($post_id);
    echo intval($p->menu_order);
  }
}
add_action('manage_ferramentas_usadas_posts_custom_column', 'kubee_ferramenta_columns_content', 10, 2);

/**
 * Permitir SVG (opcional)
 */
add_filter('upload_mimes', function($m){ $m['svg'] = 'image/svg+xml'; return $m; });
