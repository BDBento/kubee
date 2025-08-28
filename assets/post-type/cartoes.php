<?php
/* =========================
 * CPT: Botões/Cartões (Home)
 * ========================= */
if (!function_exists('kubee_register_cc_botao_cpt')) {
  function kubee_register_cc_botao_cpt() {
    $labels = array(
      'name'          => 'Botões',
      'singular_name' => 'Botão',
      'menu_name'     => 'Botões (Home)',
      'add_new_item'  => 'Adicionar novo Botão',
      'edit_item'     => 'Editar Botão',
      'all_items'     => 'Todos os Botões',
    );
    register_post_type('cc_botao', array(
      'labels'        => $labels,
      'public'        => true,
      'show_ui'       => true,
      'menu_icon'     => 'dashicons-screenoptions',
      'supports'      => array('title','page-attributes'),
      'has_archive'   => false,
      'rewrite'       => array('slug' => 'cc-botao'),
      'show_in_rest'  => true,
    ));
  }
  add_action('init', 'kubee_register_cc_botao_cpt');
}

/* ===== Metabox ===== */
function kubee_add_cc_botao_metabox() {
  add_meta_box('cc_botao_meta', 'Dados do Botão', 'kubee_cc_botao_meta_cb', 'cc_botao', 'normal', 'high');
}
add_action('add_meta_boxes', 'kubee_add_cc_botao_metabox');

function kubee_cc_botao_meta_cb($post){
  $texto = get_post_meta($post->ID, '_cc_texto', true);
  $link  = get_post_meta($post->ID, '_cc_link', true);
  $imgID = (int) get_post_meta($post->ID, '_cc_image_id', true);
  $src   = $imgID ? wp_get_attachment_image_url($imgID, 'medium') : '';
  wp_nonce_field('cc_botao_save','cc_botao_nonce');
  ?>
  <p><label><strong>Título curto/Texto do botão</strong><br>
    <input type="text" name="cc_texto" value="<?php echo esc_attr($texto); ?>" class="widefat">
  </label></p>

  <p><label><strong>Link</strong><br>
    <input type="url" name="cc_link" value="<?php echo esc_url($link); ?>" class="widefat" placeholder="https://...">
  </label></p>

  <p><strong>Imagem</strong></p>
  <div style="display:flex;gap:12px;align-items:center">
    <img id="cc_img_preview" src="<?php echo esc_url($src); ?>" style="max-width:120px;height:auto;border:1px solid #ddd;<?php echo $src?'':'display:none'; ?>">
    <input type="hidden" id="cc_image_id" name="cc_image_id" value="<?php echo (int)$imgID; ?>">
    <button type="button" class="button" id="cc_pick_img">Selecionar imagem</button>
    <button type="button" class="button" id="cc_remove_img" <?php echo $imgID?'':'style="display:none"'; ?>>Remover</button>
  </div>
  <script>
  jQuery(function($){
    var frame;
    $('#cc_pick_img').on('click', function(e){
      e.preventDefault();
      if(frame){ frame.open(); return; }
      frame = wp.media({ title:'Escolher imagem', button:{ text:'Usar esta imagem' }, multiple:false });
      frame.on('select', function(){
        var att = frame.state().get('selection').first().toJSON();
        $('#cc_image_id').val(att.id);
        var url = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
        $('#cc_img_preview').attr('src', url).show();
        $('#cc_remove_img').show();
      });
      frame.open();
    });
    $('#cc_remove_img').on('click', function(){
      $('#cc_image_id').val('');
      $('#cc_img_preview').hide().attr('src','');
      $(this).hide();
    });
  });
  </script>
  <?php
}

function kubee_cc_botao_admin_media($hook){
  if($hook === 'post.php' || $hook === 'post-new.php'){ wp_enqueue_media(); }
}
add_action('admin_enqueue_scripts', 'kubee_cc_botao_admin_media');

function kubee_cc_botao_save($post_id){
  if(!isset($_POST['cc_botao_nonce']) || !wp_verify_nonce($_POST['cc_botao_nonce'],'cc_botao_save')) return;
  if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if(!current_user_can('edit_post', $post_id)) return;

  $texto  = isset($_POST['cc_texto']) ? sanitize_text_field($_POST['cc_texto']) : '';
  $link   = isset($_POST['cc_link']) ? esc_url_raw($_POST['cc_link']) : '';
  $img_id = isset($_POST['cc_image_id']) ? (int) $_POST['cc_image_id'] : 0;

  update_post_meta($post_id, '_cc_texto', $texto);
  update_post_meta($post_id, '_cc_link',  $link);
  update_post_meta($post_id, '_cc_image_id', $img_id);
}
add_action('save_post_cc_botao', 'kubee_cc_botao_save', 10, 1);
