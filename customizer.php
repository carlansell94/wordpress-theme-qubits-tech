<?php
/**
 * @package QubitsTech
 */

function qb_customizer_css()
{
    ?>
    <style type="text/css">
        :root {
            --qb-colour-accent:
                <?= get_theme_mod('colour_site_accent', '#800080') ?>;
            --qb-colour-accent-font:
                <?= get_theme_mod('colour_site_accent_font', '#fff') ?>;
            --qb-colour-header-font:
                <?= get_theme_mod('colour_header_font', '#fff') ?>;
            --qb-colour-header-bg:
                <?= get_theme_mod('colour_header_bg', '#222') ?>;
            --qb-colour-header-bg-hover:
                <?= get_theme_mod('colour_header_bg_hover', '#bbb') ?>;
            --qb-colour-content-meta-font:
                <?= get_theme_mod('colour_content_meta_font', '#fff') ?>;
            --qb-colour-content-meta-bg:
                <?= get_theme_mod('colour_content_meta_bg', '#222') ?>;
            --qb-colour-footer-font:
                <?= get_theme_mod('colour_footer_font', '#fff') ?>;
            --qb-colour-footer-bg:
                <?= get_theme_mod('colour_footer_bg', '#222') ?>;
            --qb-media-post-thumb-bg:
                <?= get_theme_mod('media_post_thumb_bg', '#bbb') ?>;
        }
    </style>
    <?php
}

function qb_customizer_site_info($wp_customize)
{
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    $controls = array(
        'site_copyright'    => array(
            'default'       => 'Copyright &copy;',
            'control_settings'  => array(
                'label'     => __( 'Copyright Text', 'qb' ),
                'priority'  => 50
            )
        ),
        'site_start_year'   => array(
            'default'           => 1,
            'sanitize_callback' => 'absint',
            'control_settings'  => array(
                'label'         => __( 'Site Start Year', 'qb' ),
                'type'          => 'number',
                'priority'      => 50,
                'input_attrs'   => array(
                    'min' => 1980,
                    'max' => date('Y')
                )
            )
        ),
        'site_show_dates'  => array(
            'default'       => 1,
            'control_settings'  => array(
                'label'     => __('Display Site Start Year In Footer', 'qb' ),
                'type'      => 'checkbox',
                'priority'  => 50
            )
        ),
    );

    foreach ($controls as $name => $settings) {
        $settings['control_settings'] += array(
            'section'       => 'title_tagline',
            'settings'      => $name
        );

        if (isset($settings['sanitize_callback'])) {
            $settings['control_settings'] += array(
                'sanitize_callback' => 'absint');
        }
    
        $wp_customize->add_setting(
            $name,
            array(
                'default'   => $settings['default'],
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            $name,
            $settings['control_settings']
        );
    }
}

function qb_customizer_colours($wp_customize)
{
    $colour_controls = array(
        'colour_site_accent'    => array(
            'default'           => '#800080',
            'control_settings'  => array(
                'label'         => __( 'Site Accent Colour', 'qb' ),
                'description'   => 'Used for pagination (active page), the 
                    search box, and archive/category/tag on-hover background.'
            )
        ),
        'colour_site_accent_font' => array(
            'default'           => '#fff',
            'control_settings'  => array(
                'label'         => __( 'Site Accent Text Colour', 'qb' ),
                'description'   => 'Used for pagination (active page), the 
                    search box, and archive/category/tag on-hover background.'
            )
        ),
        'header_textcolor'      => array(
            'default'           => '#fff',
            'control_settings'  => array(
                'label'         => __( 'Header Font Colour', 'qb' ),
                'description'   => 'Font colour used for the header bar.'
            )
        ),
        'colour_header_bg'      => array(
            'default'           => '#222',
            'control_settings'  => array(
                'label'         => __( 'Header Background Colour', 'qb' ),
                'description'   => 'Background colour used for the header bar.'
            )
        ),
        'colour_header_bg_hover' => array(
            'default'           => '#bbb',
            'control_settings'  => array(
                'label'     => __( 'Header Hover Background Colour', 'qb' ),
                'description'   => 'Used when hovering over a navigation 
                    element in the header bar.'
            )
        ),
        'colour_content_meta_font' => array(
            'default'           => '#fff',
            'control_settings'  => array(
                'label'         => __( 'Content Meta Font Colour', 'qb' ),
                'description'   => 'Font colour for post meta links 
                    (tags/categories) and table headers/footers.'
            )
        ),
        'colour_content_meta_bg' => array(
            'default'           => '#222',
            'control_settings'  => array(
                'label' => __( 'Content Meta Background Colour', 'qb' ),
                'description'   => 'Background for post meta links 
                    (tags/categories) and table headers/footers.'
            )
        ),
        'colour_footer_font' => array(
            'default'           => '#fff',
            'control_settings'  => array(
                'label'         => __( 'Site Info Font Colour', 'qb' ),
                'description'   => 'Font colour for the site info 
                    footer section.'
            )
        ),
        'colour_footer_bg' => array(
            'default'           => '#222',
            'control_settings'  => array(
                'label' => __( 'Site Info Background Colour', 'qb' ),
                'description'   => 'Background for the site info 
                    footer section.'
            )
        ),
        'colour_browser_theme_preference' => array(
            'default'       => 1,
            'control_settings'  => array(
                'label'         => __('Enable Dark Mode', 'qb'),
                'description'   => __('When turned on, the theme will abide by 
                    the browser light/dark theme preference. Reload the page
                    for this setting to take effect.'),
                'type'          => 'checkbox',
                'priority'      => 50
            )
        )
    );

    foreach ($colour_controls as $name => $settings) {
        $settings['control_settings'] += array(
            'section'       => 'colors',
            'settings'      => $name
        );
    
        $wp_customize->add_setting(
            $name,
            array(
                'default'   => $settings['default'],
                'transport' => 'postMessage'
            )
        );

        if (!isset($settings['control_settings']['type'])) {
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    $name,
                    $settings['control_settings']
                )
            );
        } else {
            $wp_customize->add_control(
                $name,
                $settings['control_settings']
            );
        }
    }
}

function qb_customizer_media($wp_customize)
{
    $wp_customize->get_section('header_image')->title = __( 'Media' );

    $wp_customize->add_setting(
        'media_default_post_thumb'
    );

    $wp_customize->add_control(
        new WP_Customize_Cropped_Image_Control(
            $wp_customize,
            'media_default_post_thumb',
            array(
                'label' => __( 'Default Post/Article Thumbnail', 'qb' ),
                'description' => 'Select a default thumbnail to show if a post/
                    article thumbnail is not set.',
                'section' => 'header_image',
                'width' => 1500,
                'height' => 750
            )
        )
    );

    $wp_customize->add_setting(
        'media_page_default_to_parent_thumb',
        array(
            'default'   => 1
        )
    );

    $wp_customize->add_control(
        'media_page_default_to_parent_thumb',
        array(
            'label' => __( 'Use Parent Page Thumbnail as Default Page 
                Thumbnail', 'qb' ),
            'description' => 'If a page has a parent, use the thumbnail 
                of the parent page as the default thumbnail instead of 
                the post default.',
            'type' => 'checkbox',
            'section' => 'header_image'
        )
    );

    $wp_customize->add_setting(
        'media_post_thumb_bg',
        array(
            'default'   => '#ddd',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'media_post_thumb_bg',
            array(
                'label' => __( 'Default Post/Article Thumbnail Colour', 'qb' ),
                'description' => 'Select a colour to show, either as a
                    background for transparent thumbnails, or as a thumbnail
                    where an image is not set.',
                'section' => 'header_image'
            )
        )
    );
}

function qb_customizer_live_preview()
{
	wp_enqueue_script( 
		'qb_customizer_live_preview',
		get_template_directory_uri() . '/js/customizer.js',
		array(
            'jquery',
            'customize-preview'
        ),
		'',
		true
	);
}

add_action( 'wp_head', 'qb_customizer_css' );
add_action( 'customize_register', 'qb_customizer_site_info' );
add_action( 'customize_register', 'qb_customizer_colours' );
add_action( 'customize_register', 'qb_customizer_media' );
add_action( 'customize_preview_init', 'qb_customizer_live_preview' );
