<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package magazine-base
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>


<!-- full-screen-layout/boxed-layout -->
<?php if (magazine_base_get_option('homepage_layout_option') == 'full-width') {
    $magazine_base_homepage_layout = 'full-screen-layout';
} elseif (magazine_base_get_option('homepage_layout_option') == 'boxed') {
    $magazine_base_homepage_layout = 'boxed-layout';
}
?>
<?php if (1 == magazine_base_get_option('single_page_first_text')) {
    $magazine_base_single_page_text = 'text-capitalized';
} else {
    $magazine_base_single_page_text = '';
} ?>
  <div class="jod0-banner"></div>
<div id="page" class="site tiled <?php echo esc_attr($magazine_base_homepage_layout); ?> <?php echo esc_attr($magazine_base_single_page_text); ?>">
    <a class="skip-link screen-reader-text" href="#main"><?php esc_html_e('Skip to content', 'magazine-base'); ?></a>
    <header id="masthead" class="site-header white-bgcolor site-header-second" role="banner">
        <div class="top-bar container-fluid no-padding">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-xs-12">
                        <div class="tm-social-share">
                            <?php if (magazine_base_get_option('social_icon_style') == 'circle') {
                                $magazine_base_social_icon = 'bordered-radius';
                            } else {
                                $magazine_base_social_icon = '';
                            } ?>
                            <div class="social-icons <?php echo esc_attr($magazine_base_social_icon); ?>">
                                <?php
                                wp_nav_menu(
                                    array('theme_location' => 'social',
                                        'link_before' => '<span class="screen-reader-text">',
                                        'link_after' => '</span>',
                                        'menu_id' => 'social-menu',
                                        'fallback_cb' => false,
                                        'menu_class' => false
                                    )); ?>
                                <span aria-hidden="true" class="stretchy-nav-bg secondary-bgcolor"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12 pull-right icon-search">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="site-branding">
                            <?php
                            if (is_front_page() && is_home()):?>
                                <span class="site-title secondary-font">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </span>
                            <?php else : ?>
                                <span class="site-title secondary-font">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </span>
                            <?php endif;
                            magazine_base_the_custom_logo();
                            $description = get_bloginfo('description', 'display');
                            if ($description || is_customize_preview()):?>
                                <p class="site-description"><?php echo $description; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                    $banner_adv = magazine_base_get_option('top_section_advertisement');
                    $banner_adv_url = magazine_base_get_option('top_section_advertisement_url');
                    if (!empty($banner_adv)) { ?>
                        <div class="col-sm-7 col-sm-offset-1">
                            <div class="tm-adv-header">
                                <a href="<?php echo esc_url($banner_adv_url); ?>" target="_blank">
                                    <img src="<?php echo esc_url($banner_adv); ?>">
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="top-header primary-bgcolor">
            <?php
            $navigation_collaps_enable = absint(magazine_base_get_option('show_navigation_collaps'));
            ?>
            <div class="container">
                <nav class="main-navigation" role="navigation">
                    <?php if ($navigation_collaps_enable == 1) { ?>
                        <span class="popular-post">
                               <a href="#trendingCollapse" class="trending-news">
                                   <div class="burger-bars">
                                       <span class="mbtn-top"></span>
                                       <span class="mbtn-mid"></span>
                                       <span class="mbtn-bot"></span>
                                   </div>
                               </a>
                        </span>
                    <?php } ?>
                    <span class="toggle-menu" aria-controls="primary-menu" aria-expanded="false">
                         <span class="screen-reader-text">
                            <?php esc_html_e('Primary Menu', 'magazine-base'); ?>
                        </span>
                        <i class="ham"></i>
                    </span>

                    <?php wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                        'container' => 'div',
                        'container_class' => 'menu',
                    )); ?>
                </nav><!-- #site-navigation -->
            </div>
        </div>
    </header>
    <?php if ($navigation_collaps_enable == 1) { ?>
        <div class="primary-bgcolor" id="sidr">
            <a class="sidr-class-sidr-button-close" href="#sidr-nav"><i class="ion-ios-close"></i></a>
            <?php if (is_active_sidebar('tab-sidebar-1')) { ?>
                <div class="tm-sidr-recent-posts">
                    <?php dynamic_sidebar('tab-sidebar-1'); ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <!-- #masthead -->
    <?php
    if (is_front_page()) {
        // Default homepage
        do_action('magazine_base_action_trending_slider');
    } ?>
    <!-- Innerpage Header Begins Here -->
    <?php
    if (is_front_page() && !is_home()) {
    } else {
        do_action('magazine-base-page-inner-title');
    }
    ?>
    <!-- Innerpage Header Ends Here -->
    <div id="content" class="site-content">
