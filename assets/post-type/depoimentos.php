<?php
/* CPT: Depoimentos */
function kubee_register_post_type_depoimentos() {
  register_post_type('depoimentos', [
    'labels' => [
      'name' => 'Depoimentos',
      'singular_name' => 'Depoimento',
      'add_new_item' => 'Adicionar Depoimento',
      'edit_item' => 'Editar Depoimento',
      'all_items' => 'Todos os Depoimentos',
    ],
    'public' => true,
    'has_archive' => false,
    'rewrite' => ['slug' => 'depoimentos'],
    'supports' => ['title','editor','excerpt'],
    'menu_icon' => 'dashicons-format-quote',
    'show_in_rest' => true,
  ]);
}
add_action('init','kubee_register_post_type_depoimentos');

/* Metabox: cargo, nota, foto */
function kubee_add_deps_metabox(){
  add_meta_box('deps_extra','Dados do Depoimento','kubee_deps_metabox_cb','depoimentos','normal','high');
}
add_action('add_meta_boxes','kubee_add_deps_metabox');

function kubee_deps_metabox_cb($post){
  $cargo   = get_post_meta($post->ID,'_dep_cargo',true);
  $nota    = get_post_meta($post->ID,'_dep_nota',true) ?: 5;
  $mediaID = get_post_meta($post->ID,'_dep_media_id',true);
  $thumb   = $mediaID ? wp_get_attachment_image_url($mediaID,'thumbnail') : '';
  wp_nonce_field('kubee_dep_nonce','kubee_dep_nonce');
  ?>
  <style>.kubee-field{margin:10px 0}.kubee-field label{font-weight:600;display:block;margin-bottom:6px}</style>
  <div class="kubee-field">
    <label>Foto (avatar)</label>
    <?php if($thumb): ?><img src="<?php echo esc_url($thumb); ?>" style="max-width:60px;display:block;margin-bottom:8px"><?php endif; ?>
    <button type="button" class="button" id="dep_upload_btn"><?php echo $thumb?'Alterar imagem':'Selecionar imagem'; ?></button>
    <input type="hidden" id="dep_media_id" name="dep_media_id" value="<?php echo esc_attr($mediaID); ?>">
  </div>
  <div class="kubee-field">
    <label>Cargo</label>
    <input type="text" name="dep_cargo" value="<?php echo esc_attr($cargo); ?>" style="width:100%">
  </div>
  <div class="kubee-field">
    <label>Nota (1–5)</label>
    <input type="number" min="1" max="5" step="1" name="dep_nota" value="<?php echo esc_attr($nota); ?>" style="width:120px">
  </div>
  <script>
  jQuery(function($){
    $('#dep_upload_btn').on('click', function(e){
      e.preventDefault();
      const frame = wp.media({title:'Selecionar foto', multiple:false});
      frame.on('select', function(){
        const att = frame.state().get('selection').first().toJSON();
        $('#dep_media_id').val(att.id);
        if(att.sizes && att.sizes.thumbnail) $('#dep_upload_btn').prev('img').remove();
        $('#dep_upload_btn').before('<img src="'+(att.sizes?.thumbnail?.url||att.url)+'" style="max-width:60px;display:block;margin-bottom:8px">');
      });
      frame.open();
    });
  });
  </script>
  <?php
}

function kubee_save_deps_metabox($post_id){
  if(!isset($_POST['kubee_dep_nonce']) || !wp_verify_nonce($_POST['kubee_dep_nonce'],'kubee_dep_nonce')) return;
  if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if(get_post_type($post_id)!=='depoimentos') return;

  update_post_meta($post_id,'_dep_cargo',     sanitize_text_field($_POST['dep_cargo'] ?? ''));
  update_post_meta($post_id,'_dep_nota',      max(1, min(5, intval($_POST['dep_nota'] ?? 5))));
  update_post_meta($post_id,'_dep_media_id',  intval($_POST['dep_media_id'] ?? 0));
}
add_action('save_post','kubee_save_deps_metabox');
