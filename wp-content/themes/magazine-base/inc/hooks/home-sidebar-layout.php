<?php
if ( ! function_exists( 'magazine_base_widget_section' ) ) :
    /**
     *
     * @since Magazine Base 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function magazine_base_widget_section() {
        $sidebar_home_1 = '';
        ?>
        <!-- Main Content section -->
        <?php if (! is_active_sidebar( 'sidebar-home-2') ) {
            $sidebar_home_1 = "full-width";
        }?>
        <?php if ( is_active_sidebar( 'sidebar-home-1') || is_active_sidebar( 'sidebar-home-2') ) {  ?>
            <section class="section-block section-block-upper pt-40 pb-40">
                <div class="container">
                    <div class="row">
                        <div id="primary" class="content-area <?php echo esc_attr($sidebar_home_1); ?>">
                            <main id="main" class="site-main">
                                <?php dynamic_sidebar('sidebar-home-1'); ?>
                            </main>
                        </div>
                        <?php if (is_active_sidebar( 'sidebar-home-2') ) { ?>
                            <aside id="secondary" class="widget-area">
                                <?php dynamic_sidebar('sidebar-home-2'); ?>
                            </aside>
                        <?php } ?>
                    </div>
                </div>
            </section>
        <?php } ?>
    <?php
    }
endif;
add_action( 'magazine_base_action_sidebar_section', 'magazine_base_widget_section', 50 );