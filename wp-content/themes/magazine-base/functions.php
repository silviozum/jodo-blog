<?php
/**
 * magazine-base functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package magazine-base
 */


if (!function_exists('magazine_base_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function magazine_base_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on magazine-base, use a find and replace
         * to change 'magazine-base' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'magazine-base', get_template_directory() . '/languages' );


        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for custom logo.
         */
        add_theme_support('custom-logo', array(
            'header-text' => array('site-title', 'site-description'),
        ));
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        add_image_size('magazine-base-1140-600', 1140, 600, true);
        add_image_size('magazine-base-400-260', 400, 260, true);
        add_image_size('magazine-base-900-600', 900, 600, true);


        // Set up the WordPress core custom header feature.
        add_theme_support('custom-header', apply_filters('magazine_base_custom_header_args', array(
            'width' => 1400,
            'height' => 380,
            'flex-height' => true,
            'header-text' => false,
            'default-text-color' => '000',
            'default-image' => get_template_directory_uri() . '/images/banner-image.jpg',
        )));

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'magazine-base'),
            'social' => esc_html__('Social Menu', 'magazine-base'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('magazine_base_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        /**
         * Load Init for Hook files.
         */
        require get_template_directory() . '/inc/hooks/hooks-init.php';

    }
endif;
add_action('after_setup_theme', 'magazine_base_setup');

if (!function_exists('magazine_base_ocdi_files')) :
    /**
     * OCDI files.
     *
     * @since 1.0.0
     *
     * @return array Files.
     */
    function magazine_base_ocdi_files() {

        return array(
            array(
                'import_file_name'             => esc_html__( 'Theme Demo Content', 'magazine-base' ),
                'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo-content/magazine-base.xml',
                'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo-content/magazine-base.wie',
                'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo-content/magazine-base.dat',
                ),
            );
    }
endif;
add_filter( 'pt-ocdi/import_files', 'magazine_base_ocdi_files');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function magazine_base_content_width()
{
    $GLOBALS['content_width'] = apply_filters('magazine_base_content_width', 640);
}

add_action('after_setup_theme', 'magazine_base_content_width', 0);

/**
 * function for google fonts
 */
if (!function_exists('magazine_base_fonts_url')) :

    /**
     * Return fonts URL.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function magazine_base_fonts_url()
    {

        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Roboto, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Roboto font: on or off', 'magazine-base')) {
            $fonts[] = 'Roboto:300,300i,400,400i';
        }

        /* translators: If there are characters in your language that are not supported by Oswald, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Oswald font: on or off', 'magazine-base')) {
            $fonts[] = 'Oswald:400,700';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urldecode(implode('|', $fonts)),
                'subset' => urldecode($subsets),
            ), '//fonts.googleapis.com/css');
        }
        return $fonts_url;
    }
endif;
/**
 * Enqueue scripts and styles.
 */
function magazine_base_scripts()
{
    $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
    wp_enqueue_style('jquery-slick', get_template_directory_uri() . '/assets/libraries/slick/css/slick' . $min . '.css');
    wp_enqueue_style('ionicons', get_template_directory_uri() . '/assets/libraries/ionicons/css/ionicons' . $min . '.css');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/libraries/bootstrap/css/bootstrap' . $min . '.css');
    wp_enqueue_style('sidr-nav', get_template_directory_uri() . '/assets/libraries/sidr/css/jquery.sidr.dark.css');
    wp_enqueue_style('magazine-base-style', get_stylesheet_uri());
    wp_add_inline_style('magazine-base-style', magazine_base_trigger_custom_css_action());

    $fonts_url = magazine_base_fonts_url();
    if (!empty($fonts_url)) {
        wp_enqueue_style('magazine-base-google-fonts', $fonts_url, array(), null);
    }
    wp_enqueue_script('magazine-base-navigation', get_template_directory_uri() . '/assets/libraries/js/navigation.js', array(), '20151215', true);

    wp_enqueue_script('magazine-base-skip-link-focus-fix', get_template_directory_uri() . '/assets/libraries/js/skip-link-focus-fix.js', array(), '20151215', true);

    wp_enqueue_script('jquery-slick', get_template_directory_uri() . '/assets/libraries/slick/js/slick' . $min . '.js', array('jquery'), '', true);
    wp_enqueue_script('jquery-bootstrap', get_template_directory_uri() . '/assets/libraries/bootstrap/js/bootstrap' . $min . '.js', array('jquery'), '', true);
    wp_enqueue_script('jquery-sidr', get_template_directory_uri() . '/assets/libraries/sidr/js/jquery.sidr.min.js', array('jquery'), '', true);

    wp_enqueue_script('magazine-base-script', get_template_directory_uri() . '/assets/libraries/custom/js/custom-script.js', array('jquery'), '', 1);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'magazine_base_scripts');

/**
 * Enqueue admin scripts and styles.
 */
function magazine_base_admin_scripts($hook)
{
    if ('widgets.php' === $hook) {
        wp_enqueue_media();
        wp_enqueue_script('magazine-base-custom-widgets', get_template_directory_uri() . '/assets/libraries/custom/js/widgets.js', array('jquery'), '1.0.0', true);
    }

}

add_action('admin_enqueue_scripts', 'magazine_base_admin_scripts');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load about.
 */
if ( is_admin() ) {
    require_once trailingslashit( get_template_directory() ) . 'inc/about/class.about.php';
    require_once trailingslashit( get_template_directory() ) . 'inc/about/about.php';
}

/**
 * Customizer control scripts and styles.
 *
 * @since 1.0.5
 */
function magazine_base_customizer_control_scripts()
{

    wp_enqueue_style('magazine-base-customize-controls', get_template_directory_uri() . '/assets/libraries/custom/css/customize-controls.css');

}

add_action('customize_controls_enqueue_scripts', 'magazine_base_customizer_control_scripts', 0);