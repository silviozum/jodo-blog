<?php
if (!function_exists('magazine_base_banner_slider')) :
    /**
     * Banner Slider
     *
     * @since magazine-base 1.0.0
     *
     */
    function magazine_base_banner_slider()
    {
        if (1 != magazine_base_get_option('show_slider_section')) {
            return null;
        }
        $magazine_base_slider_category = esc_attr(magazine_base_get_option('select_category_for_slider'));
        $magazine_base_slider_double_post_category = esc_attr(magazine_base_get_option('select_category_for_slider_double_post'));
        $magazine_base_slider_number = 3;
        ?>
        <!-- slider News -->
        <section class="main-banner white-bgcolor pb-30 pt-30 section-block">
            <div class="container">
                <div class="row">
                    <?php 
                    $magazine_base_banner_slider_args = array(
                        'post_type' => 'post',
                        'cat' => absint($magazine_base_slider_category),
                        'ignore_sticky_posts' => true,
                        'posts_per_page' => absint( $magazine_base_slider_number ),
                    ); ?>
                    <div class="col-sm-8">
                        <div class="mainbanner-jumbotron tm-hover-2">
                            <?php
                            $magazine_base_banner_slider_post_query = new WP_Query($magazine_base_banner_slider_args);
                            if ($magazine_base_banner_slider_post_query->have_posts()) :
                                while ($magazine_base_banner_slider_post_query->have_posts()) : $magazine_base_banner_slider_post_query->the_post();
                                    if(has_post_thumbnail()){
                                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'magazine-base-1140-600' );
                                        $url = $thumb['0'];
                                    }
                                    else{
                                        $url = get_template_directory_uri().'/assets/images/no-image-1200x800.jpg';
                                    }
                                    global $post;
                                    $author_id = $post->post_author;
                                    ?>
                                        <figure class="slick-item primary-bgcolor">
                                            <a href="<?php the_permalink(); ?>" class="data-bg data-bg-slide" data-background="<?php echo esc_url($url); ?>">
                                            </a>
                                            <figcaption class="slider-figcaption">
                                                <h2 class="slide-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h2>
                                                <div class="grid-item-metadata mb-10">
                                                    <div class="item-metadata posts-date mb-10 pb-10 big-font text-uppercase">
                                                        <span><?php echo esc_html__( 'Published on : ', 'magazine-base' );?></span>
                                                        <?php the_time('j M Y'); ?>
                                                    </div>
                                                    <div class="item-metadata tm-article-author">
                                                        <span><?php echo esc_html('Published by : ', 'magazine-base'); ?></span>
                                                        <a href="<?php echo esc_url(get_author_posts_url($author_id)) ?>">
                                                            <?php echo esc_html(get_the_author_meta('display_name', $author_id)); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    <?php
                                    endwhile;
                            endif;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4 pad-l0">
                    <?php 
                    $magazine_base_banner_slider_double_post_args = array(
                        'post_type' => 'post',
                        'cat' => absint($magazine_base_slider_double_post_category),
                        'ignore_sticky_posts' => true,
                        'posts_per_page' => 3,
                    ); ?>
                    <?php 
                    $magazine_base_banner_slider_double_post_query = new WP_Query($magazine_base_banner_slider_double_post_args);
                    if ($magazine_base_banner_slider_double_post_query->have_posts()) :
                        while ($magazine_base_banner_slider_double_post_query->have_posts()) : $magazine_base_banner_slider_double_post_query->the_post();
                            if(has_post_thumbnail()){
                                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'magazine-base-1140-600' );
                                $url = $thumb['0'];
                            }
                            else{
                                $url = get_template_directory_uri().'/assets/images/no-image-1200x800.jpg';
                            }
                            global $post;
                            $author_id = $post->post_author;
                            ?>
                                <div class="slider-aside-item mb-10 mb-xs-0 pt-10 pt-xs-10 pt-sm-0">
                                    <figure class="tm-article tm-article-slides">
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="tm-article-item">
                                                <div class="article-item-image tm-hover tm-hover-enable primary-bgcolor data-bg data-bg-1" data-background="<?php echo esc_url($url); ?>">
                                                    <figcaption class="tertiary-bgcolor">
                                                        <h4 class="secondary-font slide-nav-title">
                                                            <?php the_title(); ?>
                                                        </h4>
                                                    </figcaption>
                                                    <div class="fig-overlay"></div>
                                                </div>
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
        </section>

        <!-- end slider-section -->
        <?php
    }
endif;
add_action('magazine_base_action_front_page', 'magazine_base_banner_slider', 40);
