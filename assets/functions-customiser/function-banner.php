<?php
function kubee_banner_customizer($wp_customize) {
    $wp_customize->add_section('kubee_banner_section', [
        'title' => __('Banner Home', 'kubee'),
        'priority' => 25,
    ]);

    // Título
    $wp_customize->add_setting('kubee_banner_title', [
        'default' => 'atendimentos e vendas para equipes de alta performance',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('kubee_banner_title_control', [
        'label' => __('Título Grande', 'kubee'),
        'section' => 'kubee_banner_section',
        'settings' => 'kubee_banner_title',
        'type' => 'text',
    ]);

    // Subtítulo
    $wp_customize->add_setting('kubee_banner_subtitle', [
        'default' => 'Plataforma que unifica',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('kubee_banner_subtitle_control', [
        'label' => __('Subtítulo', 'kubee'),
        'section' => 'kubee_banner_section',
        'settings' => 'kubee_banner_subtitle',
        'type' => 'text',
    ]);

    // Descrição
    $wp_customize->add_setting('kubee_banner_desc', [
        'default' => 'com inteligência artificial e chatbots',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('kubee_banner_desc_control', [
        'label' => __('Descrição', 'kubee'),
        'section' => 'kubee_banner_section',
        'settings' => 'kubee_banner_desc',
        'type' => 'text',
    ]);

    // Imagens rotativas
    for ($i=1; $i<=3; $i++) {
        $wp_customize->add_setting("kubee_banner_img_$i", [
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control(
            new WP_Customize_Image_Control($wp_customize, "kubee_banner_img_{$i}_control", [
                'label' => __("Imagem Banner $i", 'kubee'),
                'section' => 'kubee_banner_section',
                'settings' => "kubee_banner_img_$i",
            ])
        );
    }
}
add_action('customize_register', 'kubee_banner_customizer');
