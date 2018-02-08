<?php
/**
 * The template for displaying home page.
 * @package magazine-base
 */

get_header();
if ('posts' == get_option('show_on_front')) {
    include(get_home_template());
} else {
    /**
     * magazine_base_action_front_page hook
     * @since magazine-base 0.0.2
     *
     * @hooked magazine_base_action_front_page -  10
     * @sub_hooked magazine_base_action_front_page -  10
     */
    do_action('magazine_base_action_front_page');

    /**
     * magazine_base_action_sidebar_section hook
     * @since Magazine Base 0.0.1
     *
     * @hooked magazine_base_action_sidebar_section -  20
     * @sub_hooked magazine_base_action_sidebar_section -  20
     */
    do_action('magazine_base_action_sidebar_section');

    if (magazine_base_get_option('home_page_content_status') == 1) {
        ?>
        <section class="section-block recent-blog">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <?php
                        while (have_posts()) : the_post();
                            the_title('<h2 class="section-title"> <span class="secondary-bgcolor">', '</span></h2>');
                            get_template_part('template-parts/content', 'page');

                        endwhile; // End of the loop.
                        ?>
                    </div><!-- #primary -->
                        <?php get_sidebar(); ?>
                </div>
            </div>
        </section>
    <?php }
}
get_footer();