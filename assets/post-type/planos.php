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
    'supports'      => ['title','editor','thumbnail','excerpt','page-attributes'],
    'menu_icon'     => 'dashicons-tickets',
    'show_in_rest'  => true,
  ];

  register_post_type('planos', $args);

  // Metas (REST + sanitização)
  register_post_meta('planos','_pl_preco_operacao',[
    'type'=>'string','single'=>true,'show_in_rest'=>true,
    'auth_callback'=>function(){ return current_user_can('edit_posts'); },
    'sanitize_callback'=>'sanitize_text_field'
  ]);
  register_post_meta('planos','_pl_preco_infraestrutura',[
    'type'=>'string','single'=>true,'show_in_rest'=>true,
    'auth_callback'=>function(){ return current_user_can('edit_posts'); },
    'sanitize_callback'=>'sanitize_text_field'
  ]);
  register_post_meta('planos','_pl_recursos_operacao',[
    'type'=>'string','single'=>true,'show_in_rest'=>true,
    'auth_callback'=>function(){ return current_user_can('edit_posts'); },
    'sanitize_callback'=>'sanitize_textarea_field'
  ]);
  register_post_meta('planos','_pl_recursos_infraestrutura',[
    'type'=>'string','single'=>true,'show_in_rest'=>true,
    'auth_callback'=>function(){ return current_user_can('edit_posts'); },
    'sanitize_callback'=>'sanitize_textarea_field'
  ]);
  // legados e comuns
  register_post_meta('planos','_pl_preco_mensal',['type'=>'string','single'=>true,'show_in_rest'=>true]);
  register_post_meta('planos','_pl_preco_anual',['type'=>'string','single'=>true,'show_in_rest'=>true]);
  register_post_meta('planos','_pl_cta_txt',['type'=>'string','single'=>true,'show_in_rest'=>true,'sanitize_callback'=>'sanitize_text_field']);
  register_post_meta('planos','_pl_cta_url',['type'=>'string','single'=>true,'show_in_rest'=>true,'sanitize_callback'=>'esc_url_raw']);
  register_post_meta('planos','_pl_recursos',['type'=>'string','single'=>true,'show_in_rest'=>true,'sanitize_callback'=>'sanitize_textarea_field']); // fallback
}
add_action('init','kubee_register_post_type_planos');

/* =========================
 * Metabox
 * ========================= */
function kubee_add_planos_metabox() {
  add_meta_box('planos_extra','Detalhes do Plano','kubee_planos_metabox_cb','planos','normal','high');
}
add_action('add_meta_boxes','kubee_add_planos_metabox');

function kubee_planos_metabox_cb($post){
  $preco_oper   = get_post_meta($post->ID,'_pl_preco_operacao',true);
  $preco_infra  = get_post_meta($post->ID,'_pl_preco_infraestrutura',true);
  // fallback de preço
  if($preco_oper==='')  $preco_oper  = get_post_meta($post->ID,'_pl_preco_mensal',true);
  if($preco_infra==='') $preco_infra = get_post_meta($post->ID,'_pl_preco_anual',true);

  $rec_oper   = get_post_meta($post->ID,'_pl_recursos_operacao',true);
  $rec_infra  = get_post_meta($post->ID,'_pl_recursos_infraestrutura',true);
  // fallback de recursos antigo
  if($rec_oper==='' && $rec_infra===''){
    $legacy = get_post_meta($post->ID,'_pl_recursos',true);
    $rec_oper = $legacy; $rec_infra = $legacy;
  }

  $cta_txt  = get_post_meta($post->ID,'_pl_cta_txt',true) ?: 'Assinar plano';
  $cta_url  = get_post_meta($post->ID,'_pl_cta_url',true);

  wp_nonce_field('kubee_planos_nonce','kubee_planos_nonce');
  ?>
  <style>.kubee-field{margin:10px 0}.kubee-field label{font-weight:600;display:block;margin-bottom:6px}</style>

  <div class="kubee-field">
    <label>Preço OPERAÇÃO</label>
    <input type="text" name="pl_preco_operacao" value="<?php echo esc_attr($preco_oper); ?>" style="width:200px">
  </div>

  <div class="kubee-field">
    <label>Preço INFRAESTRUTURA</label>
    <input type="text" name="pl_preco_infraestrutura" value="<?php echo esc_attr($preco_infra); ?>" style="width:200px">
  </div>

  <div class="kubee-field">
    <label>Recursos de OPERAÇÃO (1 por linha)</label>
    <textarea name="pl_recursos_operacao" rows="6" style="width:100%" placeholder="✔ Item 1&#10;✔ Item 2"><?php echo esc_textarea($rec_oper); ?></textarea>
  </div>

  <div class="kubee-field">
    <label>Recursos de INFRAESTRUTURA (1 por linha)</label>
    <textarea name="pl_recursos_infraestrutura" rows="6" style="width:100%" placeholder="✔ Item 1&#10;✔ Item 2"><?php echo esc_textarea($rec_infra); ?></textarea>
  </div>

  <div class="kubee-field">
    <label>Texto do botão (CTA)</label>
    <input type="text" name="pl_cta_txt" value="<?php echo esc_attr($cta_txt); ?>" style="width:300px">
  </div>

  <div class="kubee-field">
    <label>Link do botão (CTA)</label>
    <input type="url" name="pl_cta_url" value="<?php echo esc_url($cta_url); ?>" style="width:100%" placeholder="https://...">
  </div>
  <p class="description">Se os campos de recursos novos ficarem vazios, usa o campo antigo como fallback.</p>
  <?php
}

/* =========================
 * Salvamento
 * ========================= */
function kubee_save_planos_metabox($post_id){
  if( !isset($_POST['kubee_planos_nonce']) || !wp_verify_nonce($_POST['kubee_planos_nonce'],'kubee_planos_nonce') ) return;
  if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
  if( get_post_type($post_id)!=='planos' ) return;

  update_post_meta($post_id,'_pl_preco_operacao',          sanitize_text_field($_POST['pl_preco_operacao']          ?? ''));
  update_post_meta($post_id,'_pl_preco_infraestrutura',    sanitize_text_field($_POST['pl_preco_infraestrutura']    ?? ''));
  update_post_meta($post_id,'_pl_recursos_operacao',       sanitize_textarea_field($_POST['pl_recursos_operacao']   ?? ''));
  update_post_meta($post_id,'_pl_recursos_infraestrutura', sanitize_textarea_field($_POST['pl_recursos_infraestrutura'] ?? ''));
  update_post_meta($post_id,'_pl_cta_txt',                 sanitize_text_field($_POST['pl_cta_txt']                 ?? ''));
  update_post_meta($post_id,'_pl_cta_url',                 esc_url_raw($_POST['pl_cta_url']                         ?? ''));
}
add_action('save_post','kubee_save_planos_metabox');

/* =========================
 * Ordenação via arrastar
 * ========================= */
function kubee_planos_order_assets($hook){
  if ($hook !== 'edit.php' || (isset($_GET['post_type']) && $_GET['post_type'] !== 'planos')) return;
  wp_enqueue_script('jquery-ui-sortable');
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

function kubee_sort_planos_ajax(){
  check_ajax_referer('kubee_sort_planos','nonce');
  if (!current_user_can('edit_others_posts')) wp_send_json_error('perm');
  $ids = isset($_POST['order']) ? array_map('intval',(array)$_POST['order']) : [];
  if (!$ids) wp_send_json_error('noids');
  foreach($ids as $index=>$post_id){
    wp_update_post(['ID'=>$post_id,'menu_order'=>$index]);
  }
  wp_send_json_success();
}
add_action('wp_ajax_kubee_sort_planos','kubee_sort_planos_ajax');

/* =========================
 * Helpers
 * ========================= */
function kubee_plano_precos($post_id){
  $oper  = get_post_meta($post_id,'_pl_preco_operacao',true);
  $infra = get_post_meta($post_id,'_pl_preco_infraestrutura',true);
  if($oper==='')  $oper  = get_post_meta($post_id,'_pl_preco_mensal',true);
  if($infra==='') $infra = get_post_meta($post_id,'_pl_preco_anual',true);
  return ['operacao'=>$oper,'infraestrutura'=>$infra];
}

/**
 * Retorna array de linhas preservando quebras e linhas vazias.
 * Não usa trim nem array_filter.
 */
function kubee_plano_recursos($post_id, $kind){ // 'operacao' | 'infraestrutura'
  if($kind==='infraestrutura'){
    $txt = get_post_meta($post_id,'_pl_recursos_infraestrutura',true);
  } else {
    $txt = get_post_meta($post_id,'_pl_recursos_operacao',true);
  }
  if($txt===''){ // fallback legado
    $txt = get_post_meta($post_id,'_pl_recursos',true);
  }
  if($txt === '' || $txt === null){
    return [];
  }
  // mantém TODAS as quebras e linhas vazias
  return preg_split("/\r\n|\r|\n/", (string)$txt);
}
