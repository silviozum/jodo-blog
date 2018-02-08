<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function magazine_base_widgets_init()
{

    register_sidebar(array(
        'name' => esc_html__('Main Sidebar', 'magazine-base'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'magazine-base'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-border-title secondary-font">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Off-Canvas Sidebar', 'magazine-base'),
        'id' => 'tab-sidebar-1',
        'description' => esc_html__('Add widgets here.', 'magazine-base'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-border-title secondary-font">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Home Page Sidebar One', 'magazine-base'),
        'id' => 'sidebar-home-1',
        'description' => esc_html__('Add widgets here.', 'magazine-base'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title secondary-font"><span>',
        'after_title' => '</span></h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Home Page Sidebar Two', 'magazine-base'),
        'id' => 'sidebar-home-2',
        'description' => esc_html__('Add widgets here.', 'magazine-base'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-border-title secondary-font"><span>',
        'after_title' => '</span></h2>',
    ));

    $magazine_base_footer_widgets_number = magazine_base_get_option('number_of_footer_widget');
    if ($magazine_base_footer_widgets_number > 0) {
        register_sidebar(array(
            'name' => esc_html__('Footer Column One', 'magazine-base'),
            'id' => 'footer-col-one',
            'description' => esc_html__('Displays items on footer section.', 'magazine-base'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title widget-border-title secondary-font">',
            'after_title' => '</h2>',
        ));
        if ($magazine_base_footer_widgets_number > 1) {
            register_sidebar(array(
                'name' => esc_html__('Footer Column Two', 'magazine-base'),
                'id' => 'footer-col-two',
                'description' => esc_html__('Displays items on footer section.', 'magazine-base'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h2 class="widget-title widget-border-title secondary-font">',
                'after_title' => '</h2>',
            ));
        }
        if ($magazine_base_footer_widgets_number > 2) {
            register_sidebar(array(
                'name' => esc_html__('Footer Column Three', 'magazine-base'),
                'id' => 'footer-col-three',
                'description' => esc_html__('Displays items on footer section.', 'magazine-base'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h2 class="widget-title widget-border-title secondary-font">',
                'after_title' => '</h2>',
            ));
        }
    }
}

add_action('widgets_init', 'magazine_base_widgets_init');
