<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package magazine-base
 */

?>
</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="container-fluid">
        <!-- end col-12 -->
        <div class="row">
            <?php $magazine_base_footer_widgets_number = magazine_base_get_option('number_of_footer_widget');
            if (1 == $magazine_base_footer_widgets_number) {
                $col = 'col-md-12';
            } elseif (2 == $magazine_base_footer_widgets_number) {
                $col = 'col-md-6';
            } elseif (3 == $magazine_base_footer_widgets_number) {
                $col = 'col-md-4';
            } elseif (4 == $magazine_base_footer_widgets_number) {
                $col = 'col-md-3';
            } else {
                $col = 'col-md-3';
            }
            if (is_active_sidebar('footer-col-one') || is_active_sidebar('footer-col-two') || is_active_sidebar('footer-col-three') || is_active_sidebar('footer-col-four')) { ?>
                <section class="wrapper block-section footer-widget pt-40 pb-20">
                    <div class="container overhidden">
                        <div class="contact-inner">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <?php if (is_active_sidebar('footer-col-one') && $magazine_base_footer_widgets_number > 0) : ?>
                                            <div class="contact-list <?php echo esc_attr($col); ?>">
                                                <?php dynamic_sidebar('footer-col-one'); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (is_active_sidebar('footer-col-two') && $magazine_base_footer_widgets_number > 1) : ?>
                                            <div class="contact-list <?php echo esc_attr($col); ?>">
                                                <?php dynamic_sidebar('footer-col-two'); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (is_active_sidebar('footer-col-three') && $magazine_base_footer_widgets_number > 2) : ?>
                                            <div class="contact-list <?php echo esc_attr($col); ?>">
                                                <?php dynamic_sidebar('footer-col-three'); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (is_active_sidebar('footer-col-four') && $magazine_base_footer_widgets_number > 3) : ?>
                                            <div class="contact-list <?php echo esc_attr($col); ?>">
                                                <?php dynamic_sidebar('footer-col-four'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } ?>

            <div class="footer-bottom pt-30 pb-30">
                <div class="container">
                    <div class="row">
                        <div class="site-info">
                            <div class="col-md-4 col-sm-12 col-xs-12">
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
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="footer-logo text-center mt-xs-20 mb-xs-20">
                                        <span class="site-title secondary-font">
                                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                                <?php bloginfo('name'); ?>
                                            </a>
                                        </span>
                                    <?php $description = get_bloginfo('description', 'display');
                                    if ($description || is_customize_preview()) : ?>
                                        <p class="site-description"><?php echo $description; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .site-info -->
            </div>
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end container -->
</footer>
</div><!-- #page -->
<a id="scroll-up" class="tertiary-bgcolor"><i class="ion-ios-arrow-up"></i></a>
<?php wp_footer(); ?>

</body>
</html>
