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

// Função para carregar os campos do Customizer do banner
require get_template_directory() . '/assets/functions-customiser/function-banner.php';
// Função para registrar o post type "Serviços"
require get_template_directory() . '/assets/post-type/negocios.php';