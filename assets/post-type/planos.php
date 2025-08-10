<?php
/* =========================
 * CPT: Planos
 * ========================= */
function kubee_register_post_type_planos() {
  $labels = [
    'name'          => 'Planos',
    'singular_name' => 'Plano',
    'menu_name'     => 'Planos',
    'add_new_item'  => 'Adicionar novo Plano',
    'edit_item'     => 'Editar Plano',
    'all_items'     => 'Todos os Planos',
    'search_items'  => 'Buscar Planos',
  ];

  $args = [
    'labels'        => $labels,
    'public'        => true,
    'has_archive'   => false,
    'rewrite'       => ['slug' => 'planos'],
    'supports' => ['title','editor','thumbnail','excerpt','page-attributes'],
    'menu_icon'     => 'dashicons-tickets',
    'show_in_rest'  => true,
  ];

  register_post_type('planos', $args);
}
add_action('init', 'kubee_register_post_type_planos');

/* =========================
 * Metabox: Detalhes do Plano
 * ========================= */
function kubee_add_planos_metabox() {
  add_meta_box(
    'planos_extra',
    'Detalhes do Plano',
    'kubee_planos_metabox_cb',
    'planos',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes', 'kubee_add_planos_metabox');

function kubee_planos_metabox_cb($post){
  // valores salvos
  $preco_mensal = get_post_meta($post->ID, '_pl_preco_mensal', true);
  $preco_anual  = get_post_meta($post->ID, '_pl_preco_anual',  true);
  $cta_txt      = get_post_meta($post->ID, '_pl_cta_txt',      true) ?: 'Assinar plano';
  $cta_url      = get_post_meta($post->ID, '_pl_cta_url',      true);
  $recursos     = get_post_meta($post->ID, '_pl_recursos',     true); // 1 por linha

  wp_nonce_field('kubee_planos_nonce', 'kubee_planos_nonce');
  ?>
  <style>.kubee-field{margin:10px 0}.kubee-field label{font-weight:600;display:block;margin-bottom:6px}</style>

  <div class="kubee-field">
    <label>Preço MENSAL (somente número)</label>
    <input type="text" name="pl_preco_mensal" value="<?php echo esc_attr($preco_mensal); ?>" style="width:200px">
  </div>

  <div class="kubee-field">
    <label>Preço ANUAL (somente número)</label>
    <input type="text" name="pl_preco_anual" value="<?php echo esc_attr($preco_anual); ?>" style="width:200px">
  </div>

  <div class="kubee-field">
    <label>Texto do botão (CTA)</label>
    <input type="text" name="pl_cta_txt" value="<?php echo esc_attr($cta_txt); ?>" style="width:300px">
  </div>

  <div class="kubee-field">
    <label>Link do botão (CTA)</label>
    <input type="url" name="pl_cta_url" value="<?php echo esc_url($cta_url); ?>" style="width:100%" placeholder="https://...">
  </div>

  <div class="kubee-field">
    <label>Recursos (1 por linha)</label>
    <textarea name="pl_recursos" rows="8" style="width:100%" placeholder="✔ Item 1&#10;✔ Item 2"><?php echo esc_textarea($recursos); ?></textarea>
  </div>
  <?php
}

/* =========================
 * Salvamento do Metabox
 * ========================= */
function kubee_save_planos_metabox($post_id){
  if ( !isset($_POST['kubee_planos_nonce']) || !wp_verify_nonce($_POST['kubee_planos_nonce'], 'kubee_planos_nonce') ) return;
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
  if ( get_post_type($post_id) !== 'planos' ) return;

  update_post_meta($post_id, '_pl_preco_mensal', sanitize_text_field($_POST['pl_preco_mensal'] ?? '') );
  update_post_meta($post_id, '_pl_preco_anual',  sanitize_text_field($_POST['pl_preco_anual']  ?? '') );
  update_post_meta($post_id, '_pl_cta_txt',      sanitize_text_field($_POST['pl_cta_txt']      ?? '') );
  update_post_meta($post_id, '_pl_cta_url',      esc_url_raw($_POST['pl_cta_url']              ?? '') );
  update_post_meta($post_id, '_pl_recursos',     sanitize_textarea_field($_POST['pl_recursos'] ?? '') );
}
add_action('save_post', 'kubee_save_planos_metabox');




// admin: carrega jQuery UI Sortable e nosso JS só em edit.php?post_type=planos
function kubee_planos_order_assets($hook){
  if ($hook !== 'edit.php' || (isset($_GET['post_type']) && $_GET['post_type'] !== 'planos')) return;

  wp_enqueue_script('jquery-ui-sortable'); // já vem no WP
  wp_enqueue_script(
    'kubee-planos-sort',
    get_template_directory_uri().'/assets/js/kubee-planos-sort.js',
    ['jquery','jquery-ui-sortable'],
    '1.0',
    true
  );
  wp_localize_script('kubee-planos-sort','KubeePlanosOrder',[
    'ajax'  => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('kubee_sort_planos')
  ]);
}
add_action('admin_enqueue_scripts','kubee_planos_order_assets');

// AJAX: salva a ordem recebida
function kubee_sort_planos_ajax(){
  check_ajax_referer('kubee_sort_planos','nonce');

  if (!current_user_can('edit_others_posts')) wp_send_json_error('perm');

  $ids = isset($_POST['order']) ? array_map('intval', (array) $_POST['order']) : [];
  if (!$ids) wp_send_json_error('noids');

  // reordena em sequência crescente (0,1,2...)
  foreach ($ids as $index => $post_id){
    // atualiza menu_order
    wp_update_post([
      'ID'         => $post_id,
      'menu_order' => $index
    ]);
  }
  wp_send_json_success();
}
add_action('wp_ajax_kubee_sort_planos','kubee_sort_planos_ajax');


