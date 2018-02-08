<?php

/**
 * Theme Options Panel.
 *
 * @package magazine-base
 */

$default = magazine_base_get_default_theme_options();

// Trending News Section.
$wp_customize->add_section('trending_news_section_settings',
	array(
		'title'      => esc_html__('Trending News Section', 'magazine-base'),
		'priority'   => 50,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting - show_trending_news_section.
$wp_customize->add_setting('show_trending_news_section',
	array(
		'default'           => $default['show_trending_news_section'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_checkbox',
	)
);
$wp_customize->add_control('show_trending_news_section',
	array(
		'label'    => esc_html__('Enable Trending News', 'magazine-base'),
		'section'  => 'trending_news_section_settings',
		'type'     => 'checkbox',
		'priority' => 10,
	)
);

// Setting - trending_news_title.
$wp_customize->add_setting('trending_news_title',
	array(
		'default'           => $default['trending_news_title'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control('trending_news_title',
	array(
		'label'    => esc_html__('Section Title', 'magazine-base'),
		'section'  => 'trending_news_section_settings',
		'type'     => 'text',
		'priority' => 15,

	)
);

// Setting - drop down category for Trending Newssection.
$wp_customize->add_setting('select_category_for_trending_news',
	array(
		'default'           => $default['select_category_for_trending_news'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(new Magazine_Base_Dropdown_Taxonomies_Control($wp_customize, 'select_category_for_trending_news',
		array(
			'label'       => esc_html__('Category for Trending News', 'magazine-base'),
			'description' => esc_html__('Select category to be shown on tab ', 'magazine-base'),
			'section'     => 'trending_news_section_settings',
			'type'        => 'dropdown-taxonomies',
			'taxonomy'    => 'category',
			'priority'    => 20,
		)));

// Slider Main Section.
$wp_customize->add_section('slider_section_settings',
	array(
		'title'      => esc_html__('Slider Section', 'magazine-base'),
		'priority'   => 60,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting - show_slider_section.
$wp_customize->add_setting('show_slider_section',
	array(
		'default'           => $default['show_slider_section'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_checkbox',
	)
);
$wp_customize->add_control('show_slider_section',
	array(
		'label'    => esc_html__('Enable Slider', 'magazine-base'),
		'section'  => 'slider_section_settings',
		'type'     => 'checkbox',
		'priority' => 100,
	)
);

// Setting - drop down category for slider.
$wp_customize->add_setting('select_category_for_slider',
	array(
		'default'           => $default['select_category_for_slider'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(new Magazine_Base_Dropdown_Taxonomies_Control($wp_customize, 'select_category_for_slider',
		array(
			'label'    => esc_html__('Category For Main slider', 'magazine-base'),
			'section'  => 'slider_section_settings',
			'type'     => 'dropdown-taxonomies',
			'taxonomy' => 'category',
			'priority' => 130,
		)));

// Setting - drop down category for slider.
$wp_customize->add_setting('select_category_for_slider_double_post',
	array(
		'default'           => $default['select_category_for_slider_double_post'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(new Magazine_Base_Dropdown_Taxonomies_Control($wp_customize, 'select_category_for_slider_double_post',
		array(
			'label'       => esc_html__('Category For 2 Pined Post ', 'magazine-base'),
			'description' => esc_html__('Select category to be shown on side of slider i.e the 2 pined posts', 'magazine-base'),
			'section'     => 'slider_section_settings',
			'type'        => 'dropdown-taxonomies',
			'taxonomy'    => 'category',
			'priority'    => 140,
		)));

// Latest featured Section.
$wp_customize->add_section('top_section_settings',
	array(
		'title'      => esc_html__('Header Section', 'magazine-base'),
		'priority'   => 10,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting top_section_advertisement.
$wp_customize->add_setting('top_section_advertisement',
	array(
		'default'           => $default['top_section_advertisement'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_image',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control($wp_customize, 'top_section_advertisement',
		array(
			'label'       => esc_html__('Top Section Advertisement', 'magazine-base'),
			'description' => sprintf(esc_html__('Recommended Size %1$s px X %2$s px', 'magazine-base'), 728, 90),
			'section'     => 'top_section_settings',
			'priority'    => 120,
		)
	)
);

/*top_section_advertisement_url*/
$wp_customize->add_setting('top_section_advertisement_url',
	array(
		'default'           => $default['top_section_advertisement_url'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control('top_section_advertisement_url',
	array(
		'label'    => esc_html__('URL Link', 'magazine-base'),
		'section'  => 'top_section_settings',
		'type'     => 'text',
		'priority' => 130,
	)
);

// Setting - show_navigation_collaps.
$wp_customize->add_setting('show_navigation_collaps',
	array(
		'default'           => $default['show_navigation_collaps'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_checkbox',
	)
);
$wp_customize->add_control('show_navigation_collaps',
	array(
		'label'       => esc_html__('Enable navigation collapse', 'magazine-base'),
		'description' => esc_html__('Navigation collapse will be shown with the popular post on the basis of comments', 'magazine-base'),
		'section'     => 'top_section_settings',
		'type'        => 'checkbox',
		'priority'    => 140,
	)
);

// Add Theme Options Panel.
$wp_customize->add_panel('theme_option_panel',
	array(
		'title'      => esc_html__('Theme Options', 'magazine-base'),
		'priority'   => 200,
		'capability' => 'edit_theme_options',
	)
);

/*layout management section start */
$wp_customize->add_section('theme_option_section_settings',
	array(
		'title'      => esc_html__('Layout Management', 'magazine-base'),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting social_icon_style.
$wp_customize->add_setting('single_page_first_text',
	array(
		'default'           => $default['single_page_first_text'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_checkbox',
	)
);
$wp_customize->add_control('single_page_first_text',
	array(
		'label'       => esc_html__('Enable Large letter ', 'magazine-base'),
		'description' => esc_html__('Change the first letter to normal one in single page', 'magazine-base'),
		'section'     => 'theme_option_section_settings',
		'type'        => 'checkbox',
		'priority'    => 140,
	)
);
/*Home Page Layout*/
$wp_customize->add_setting('home_page_content_status',
	array(
		'default'           => $default['home_page_content_status'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_checkbox',
	)
);
$wp_customize->add_control('home_page_content_status',
	array(
		'label'    => esc_html__('Enable Static Page Content', 'magazine-base'),
		'section'  => 'static_front_page',
		'type'     => 'checkbox',
		'priority' => 150,
	)
);

/*Home Page Layout*/
$wp_customize->add_setting('enable_overlay_option',
	array(
		'default'           => $default['enable_overlay_option'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_checkbox',
	)
);
$wp_customize->add_control('enable_overlay_option',
	array(
		'label'    => esc_html__('Enable Banner Overlay', 'magazine-base'),
		'section'  => 'theme_option_section_settings',
		'type'     => 'checkbox',
		'priority' => 150,
	)
);

/*Home Page Layout*/
$wp_customize->add_setting('homepage_layout_option',
	array(
		'default'           => $default['homepage_layout_option'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_select',
	)
);
$wp_customize->add_control('homepage_layout_option',
	array(
		'label'       => esc_html__('Home Page Layout', 'magazine-base'),
		'section'     => 'theme_option_section_settings',
		'choices'     => array(
			'full-width' => esc_html__('Full Width', 'magazine-base'),
			'boxed'      => esc_html__('Boxed', 'magazine-base'),
		),
		'type'     => 'select',
		'priority' => 160,
	)
);

/*Global Layout*/
$wp_customize->add_setting('global_layout',
	array(
		'default'           => $default['global_layout'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_select',
	)
);
$wp_customize->add_control('global_layout',
	array(
		'label'          => esc_html__('Global Layout', 'magazine-base'),
		'section'        => 'theme_option_section_settings',
		'choices'        => array(
			'right-sidebar' => esc_html__('Content - Primary Sidebar', 'magazine-base'),
			'left-sidebar'  => esc_html__('Primary Sidebar - Content', 'magazine-base'),
			'no-sidebar'    => esc_html__('No Sidebar', 'magazine-base')
		),
		'type'     => 'select',
		'priority' => 170,
	)
);

/*content excerpt in global*/
$wp_customize->add_setting('excerpt_length_global',
	array(
		'default'           => $default['excerpt_length_global'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_positive_integer',
	)
);
$wp_customize->add_control('excerpt_length_global',
	array(
		'label'       => esc_html__('Set Global Archive Length', 'magazine-base'),
		'section'     => 'theme_option_section_settings',
		'type'        => 'number',
		'priority'    => 175,
		'input_attrs' => array('min' => 1, 'max' => 200, 'style' => 'width: 150px;'),

	)
);

/*Archive Layout text*/
$wp_customize->add_setting('archive_layout',
	array(
		'default'           => $default['archive_layout'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_select',
	)
);
$wp_customize->add_control('archive_layout',
	array(
		'label'         => esc_html__('Archive Layout', 'magazine-base'),
		'section'       => 'theme_option_section_settings',
		'choices'       => array(
			'excerpt-only' => esc_html__('Excerpt Only', 'magazine-base'),
			'full-post'    => esc_html__('Full Post', 'magazine-base'),
		),
		'type'     => 'select',
		'priority' => 180,
	)
);

/*Archive Layout image*/
$wp_customize->add_setting('archive_layout_image',
	array(
		'default'           => $default['archive_layout_image'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_select',
	)
);
$wp_customize->add_control('archive_layout_image',
	array(
		'label'     => esc_html__('Archive Image Alocation', 'magazine-base'),
		'section'   => 'theme_option_section_settings',
		'choices'   => array(
			'full'     => esc_html__('Full', 'magazine-base'),
			'right'    => esc_html__('Right', 'magazine-base'),
			'left'     => esc_html__('Left', 'magazine-base'),
			'no-image' => esc_html__('No image', 'magazine-base')
		),
		'type'     => 'select',
		'priority' => 185,
	)
);

/*single post Layout image*/
$wp_customize->add_setting('single_post_image_layout',
	array(
		'default'           => $default['single_post_image_layout'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_select',
	)
);
$wp_customize->add_control('single_post_image_layout',
	array(
		'label'     => esc_html__('Single Post/Page Image Alocation', 'magazine-base'),
		'section'   => 'theme_option_section_settings',
		'choices'   => array(
			'full'     => esc_html__('Full', 'magazine-base'),
			'right'    => esc_html__('Right', 'magazine-base'),
			'left'     => esc_html__('Left', 'magazine-base'),
			'no-image' => esc_html__('No image', 'magazine-base')
		),
		'type'     => 'select',
		'priority' => 190,
	)
);

// Pagination Section.
$wp_customize->add_section('pagination_section',
	array(
		'title'      => esc_html__('Pagination Options', 'magazine-base'),
		'priority'   => 110,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting pagination_type.
$wp_customize->add_setting('pagination_type',
	array(
		'default'           => $default['pagination_type'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_select',
	)
);
$wp_customize->add_control('pagination_type',
	array(
		'label'    => esc_html__('Pagination Type', 'magazine-base'),
		'section'  => 'pagination_section',
		'type'     => 'select',
		'choices'  => array(
			'default' => esc_html__('Default (Older / Newer Post)', 'magazine-base'),
			'numeric' => esc_html__('Numeric', 'magazine-base'),
		),
		'priority' => 100,
	)
);

// Footer Section.
$wp_customize->add_section('footer_section',
	array(
		'title'      => esc_html__('Footer Options', 'magazine-base'),
		'priority'   => 130,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting social_content_heading.
$wp_customize->add_setting('number_of_footer_widget',
	array(
		'default'           => $default['number_of_footer_widget'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_select',
	)
);
$wp_customize->add_control('number_of_footer_widget',
	array(
		'label'    => esc_html__('Number Of Footer Widget', 'magazine-base'),
		'section'  => 'footer_section',
		'type'     => 'select',
		'priority' => 100,
		'choices'  => array(
			0         => esc_html__('Disable footer sidebar area', 'magazine-base'),
			1         => esc_html__('1', 'magazine-base'),
			2         => esc_html__('2', 'magazine-base'),
			3         => esc_html__('3', 'magazine-base'),
		),
	)
);

// Setting copyright_text.
$wp_customize->add_setting('copyright_text',
	array(
		'default'           => $default['copyright_text'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control('copyright_text',
	array(
		'label'    => esc_html__('Footer Copyright Text', 'magazine-base'),
		'section'  => 'footer_section',
		'type'     => 'text',
		'priority' => 120,
	)
);

// Preloader Section.
$wp_customize->add_section('enable_preloader_option',
	array(
		'title'      => __('Preloader Options', 'magazine-base'),
		'priority'   => 120,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting enable_preloader.
$wp_customize->add_setting('enable_preloader',
	array(
		'default'           => $default['enable_preloader'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_checkbox',
	)
);
$wp_customize->add_control('enable_preloader',
	array(
		'label'    => __('Enable Preloader', 'magazine-base'),
		'section'  => 'enable_preloader_option',
		'type'     => 'checkbox',
		'priority' => 150,
	)
);

// Breadcrumb Section.
$wp_customize->add_section('breadcrumb_section',
	array(
		'title'      => esc_html__('Breadcrumb Options', 'magazine-base'),
		'priority'   => 120,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting breadcrumb_type.
$wp_customize->add_setting('breadcrumb_type',
	array(
		'default'           => $default['breadcrumb_type'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'magazine_base_sanitize_select',
	)
);
$wp_customize->add_control('breadcrumb_type',
	array(
		'label'       => esc_html__('Breadcrumb Type', 'magazine-base'),
		'description' => sprintf(esc_html__('Advanced: Requires %1$sBreadcrumb NavXT%2$s plugin', 'magazine-base'), '<a href="https://wordpress.org/plugins/breadcrumb-navxt/" target="_blank">', '</a>'),
		'section'     => 'breadcrumb_section',
		'type'        => 'select',
		'choices'     => array(
			'disabled'   => esc_html__('Disabled', 'magazine-base'),
			'simple'     => esc_html__('Simple', 'magazine-base'),
			'advanced'   => esc_html__('Advanced', 'magazine-base'),
		),
		'priority' => 100,
	)
);