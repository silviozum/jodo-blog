<?php
if (!function_exists('magazine_base_trending_news')) :
    /**
     * Banner Slider
     *
     * @since magazine-base 1.0.0
     *
     */
    function magazine_base_trending_news()
    {
        if (1 != magazine_base_get_option('show_trending_news_section')) {
            return null;
        }
        $magazine_base_trending_news_category = esc_attr(magazine_base_get_option('select_category_for_trending_news'));
        $magazine_base_trending_news_title = esc_html(magazine_base_get_option('trending_news_title'));
        $magazine_base_trending_news_number = 4;
        ?>
        <!-- slider News -->
        <section class="trending-news-corousal pb-30 section-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="trending-title">
                            <h2>
                                <span class="white-bgcolor"><?php echo esc_html($magazine_base_trending_news_title); ?></span>
                            </h2>
                        </div>

                        <?php
                        $magazine_base_trending_news_args = array(
                            'post_type' => 'post',
                            'cat' => absint($magazine_base_trending_news_category),
                            'ignore_sticky_posts' => true,
                            'posts_per_page' => absint( $magazine_base_trending_news_number ),
                        ); ?>
                        <div class="trending-slider pt-10">
                        <?php $magazine_base_trending_news_post_query = new WP_Query($magazine_base_trending_news_args);
                        if ($magazine_base_trending_news_post_query->have_posts()) :
                            while ($magazine_base_trending_news_post_query->have_posts()) : $magazine_base_trending_news_post_query->the_post();
                                if(has_post_thumbnail()){
                                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'magazine-base-1140-600' );
                                    $url = $thumb['0'];
                                }
                                else{
                                    $url = get_template_directory_uri().'/images/no-image-1200x800.jpg';
                                }
                                ?>
                                <div class="slider-nav-item">
                                    <figure class="tm-article tm-article-slides tm-article-corousal-slides">
                                        <a href="<?php the_permalink(); ?>" class="tm-article-item">
                                            <div class="article-item-image tm-hover primary-bgcolor data-bg data-bg-1" data-background="<?php echo esc_url($url); ?>">
                                                <figcaption class="secondary-bgcolor">
                                                    <h4 class="secondary-font slide-nav-title"><?php the_title(); ?></h4>
                                                </figcaption>
                                            </div>
                                        </a>
                                    </figure>
                                </div>
                            <?php
                            endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- end slider-section -->
        <?php
    }
endif;
add_action('magazine_base_action_trending_slider', 'magazine_base_trending_news', 30);
