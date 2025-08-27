<?php
function kubee_enqueue_styles() {
    wp_enqueue_style(
    'bootstrap-icons',
    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css',
    [],
    '1.10.5'
);
    
    // Bootstrap CSS via CDN
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css',
        [],
        '5.3.7'
    );

    // Estilo principal do tema
    wp_enqueue_style(
        'kubee-main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        ['bootstrap-css'], // garante que o Bootstrap carregue antes
        '1.0.0'
    );

    // Bootstrap JS via CDN
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js',
        [],
        '5.3.7',
        true // carrega no footer
    );
}

add_action( 'wp_enqueue_scripts', 'kubee_enqueue_styles' );



// -----------------------------------------------------------------------------------------------------------------

// Suporte ao Elementor
function kubee_elementor_support() {
    add_theme_support( 'elementor' );
}
add_action( 'after_setup_theme', 'kubee_elementor_support' );

// Registrar menu
function kubee_register_menus() {
    register_nav_menus([
        'main_menu' => 'Menu Principal',
        'footer_menu_1' => 'Menu Rodapé 1',
        'footer_menu_2' => 'Menu Rodapé 2'
    ]);
}
add_action('after_setup_theme', 'kubee_register_menus');

function kubee_customize_register( $wp_customize ) {
    // Seção para contato
    $wp_customize->add_section('kubee_contato_section', [
        'title' => __('Contato', 'kubee'),
        'priority' => 30,
    ]);

    // Campo para o número do WhatsApp
    $wp_customize->add_setting('kubee_whatsapp_number', [
        'default' => '5567999999999', // Coloque o número padrão
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh'
    ]);

    $wp_customize->add_control('kubee_whatsapp_number_control', [
        'label' => __('Número do WhatsApp', 'kubee'),
        'section' => 'kubee_contato_section',
        'settings' => 'kubee_whatsapp_number',
        'type' => 'text',
        'description' => __('Digite o número com DDI, exemplo: 556799999xxxx', 'kubee'),
    ]);
}
add_action('customize_register', 'kubee_customize_register');


function kubee_clientes_admin_enqueue( $hook ) {
    global $typenow;
    if ( $typenow !== 'clientes' ) {
        return;
    }

    wp_enqueue_media();

    wp_enqueue_script(
        'kubee-clientes-media',
        get_template_directory_uri() . '/assets/js/clientes-media.js',
        array( 'jquery' ),
        '1.0',
        true
    );
}
add_action( 'admin_enqueue_scripts', 'kubee_clientes_admin_enqueue' );



add_action('after_setup_theme', function(){
  add_theme_support('align-wide'); // Gutenberg com alignwide/alignfull
});




// Função para carregar os campos do Customizer do banner
require get_template_directory() . '/assets/functions-customiser/function-banner.php';

// Função para registrar o post type "Serviços"
require get_template_directory() . '/assets/post-type/negocios.php';

// Função para registrar o post type "Nossos Clientes"
require get_template_directory() . '/assets/post-type/nossos-clientes.php';

// Função para registrar o post type "Planos"
require get_template_directory() . '/assets/post-type/planos.php';

// Função para registrar o post type "Depoimentos"
require get_template_directory() . '/assets/post-type/depoimentos.php';

// Função para registrar o post type "Ferramentas Usadas"
require get_template_directory() . '/assets/post-type/ferramentas-usadas.php';


function kubee_format_preco_label($raw){
  $raw = trim((string)$raw);
  if ($raw === '') return '';
  $digits = preg_replace('/\D+/', '', $raw); // só números
  if ($digits === '') return '';
  $valor = (int)$digits;
  return 'A partir de R$ ' . number_format($valor, 2, ',', '.');
}


