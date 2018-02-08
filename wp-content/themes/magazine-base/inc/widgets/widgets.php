<?php
/**
 * Theme widgets.
 *
 * @package Magazine Base
 */

// Load widget base.
require_once get_template_directory() . '/inc/widgets/widget-base-class.php';

if (!function_exists('magazine_base_load_widgets')) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function magazine_base_load_widgets()
    {
        // Magazine_Base_Grid_Panel widget.
        register_widget('Magazine_Base_widget_style_1');

        //  Magazine_Base_slider
        register_widget('Magazine_Base_widget_slider');

        // list panel widget.
        register_widget('Magazine_Base_widget_style_2');

        register_widget('Magazine_Base_widget_social');

        // Recent Post widget.
        register_widget('Magazine_Base_sidebar_widget');

        // Tabbed widget.
        register_widget('Magazine_Base_Tabbed_Widget');

        // Auther widget.
        register_widget('Magazine_Base_Author_Post_widget');

    }
endif;
add_action('widgets_init', 'magazine_base_load_widgets');

/*Grid Panel widget*/
if (!class_exists('Magazine_Base_widget_style_1')) :

    /**
     * Latest news widget Class.
     *
     * @since 1.0.0
     */
    class Magazine_Base_widget_style_1 extends Magazine_Base_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'magazine_base_grid_panel_widget',
                'description' => __('Displays posts from selected category in grid.', 'magazine-base'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'description' => array(
                    'label' => __('Description:', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'post_category' => array(
                    'label' => __('Select Category:', 'magazine-base'),
                    'type' => 'dropdown-taxonomies',
                    'show_option_all' => __('All Categories', 'magazine-base'),
                ),
                'post_number' => array(
                    'label' => __('Number of Posts:', 'magazine-base'),
                    'type' => 'number',
                    'default' => 4,
                    'css' => 'max-width:60px;',
                    'min' => 1,
                    'max' => 10,
                ),
            );

            parent::__construct('magazine-base-grid-layout', __('MB: Grid Widget', 'magazine-base'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            echo "<div class='widget-header-wrapper'>";
            if (!empty($params['title'])) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            }

            if (!empty($params['description'])) {
            echo "<p class='widget-description secondary-font'>";
                echo esc_html($params['description']);
            echo "</p>";
            }
            echo "</div>";

            $qargs = array(
                'posts_per_page' => esc_attr($params['post_number']),
                'no_found_rows' => true,
            );
            if (absint($params['post_category']) > 0) {
                $qargs['category'] = absint($params['post_category']);
            }
            $all_posts = get_posts($qargs);
            ?>
            <?php if (!empty($all_posts)) : ?>

            <?php global $post;
            $author_id = $post->post_author;
            ?>
            <div class="grid-item clearfix">
                <div class="tm-row row">
                    <?php foreach ($all_posts as $key => $post) : ?>
                        <?php setup_postdata($post); ?>
                        <div class="col col-half clear-col">
                            <div class="grid-item-image item-image">
                                <figure class="tm-article">
                                    <div class="tm-article-item">
                                        <div class="article-item-image">
                                            <?php if (has_post_thumbnail()) {
                                                $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'magazine-base-900-600');
                                                $url = $thumb['0'];
                                            } else {
                                                $url = get_template_directory_uri() . '/assets/images/no-image-900x600.jpg';
                                            }
                                            ?>
                                            <a href="<?php the_permalink(); ?>"
                                               class="tm-hover tm-hover-zoom primary-bgcolor tm-hover-enable">
                                                <img src="<?php echo esc_url($url); ?>"
                                                     alt="<?php the_title_attribute(); ?>">
                                            </a>
                                            <div class="categories-list">
                                                <?php $categories_list = get_the_category_list(wp_kses_post(' ')); ?>
                                                <?php if (!empty($categories_list)) { ?>
                                                    <?php echo $categories_list; ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </figure>
                            </div>
                            <div class="grid-item-details">
                                <div class="grid-item-content">
                                    <h3 class="grid-item-title item-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>

                                    <div class="grid-item-metadata mb-10">
                                        <div class="item-metadata posts-date">
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
                                    <div class="grid-item-desc">
                                        <?php
                                        $excerpt = magazine_base_words_count(30, get_the_content());
                                        echo wp_kses_post(wpautop($excerpt));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    endforeach; ?>
                </div>
            </div>
            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
            <?php echo $args['after_widget'];
        }
    }
endif;
/*Grid Panel widget*/
if (!class_exists('Magazine_Base_widget_slider')) :

    /**
     * Latest news widget Class.
     *
     * @since 1.0.0
     */
    class Magazine_Base_widget_slider extends Magazine_Base_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'magazine_base_slider_widget',
                'description' => __('Displays posts from selected category in slider', 'magazine-base'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'description' => array(
                    'label' => __('Description:', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'post_category' => array(
                    'label' => __('Select Category:', 'magazine-base'),
                    'type' => 'dropdown-taxonomies',
                    'show_option_all' => __('All Categories', 'magazine-base'),
                ),
                'post_number' => array(
                    'label' => __('Number of Posts:', 'magazine-base'),
                    'type' => 'number',
                    'default' => 4,
                    'css' => 'max-width:60px;',
                    'min' => 1,
                    'max' => 5,
                ),
            );

            parent::__construct('magazine-base-slider-layout', __('MB: Slider Widget', 'magazine-base'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            echo "<div class='widget-header-wrapper'>";
            if (!empty($params['title'])) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            }
            if (!empty($params['description'])) {
            echo "<p class='widget-description secondary-font'>";
                echo esc_html($params['description']);
            echo "</p>";
            }
            echo "</div>";

            $qargs = array(
                'posts_per_page' => esc_attr($params['post_number']),
                'no_found_rows' => true,
            );
            if (absint($params['post_category']) > 0) {
                $qargs['category'] = absint($params['post_category']);
            }
            $all_posts = get_posts($qargs);
            ?>
            <?php if (!empty($all_posts)) : ?>

            <?php global $post;
            $author_id = $post->post_author;
            ?>
            <div class="tm-slider-widget clearfix">
                <?php foreach ($all_posts as $key => $post) : ?>
                    <?php setup_postdata($post); ?>
                    <?php if (has_post_thumbnail()) {
                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'magazine-base-1140-600');
                        $url = $thumb['0'];
                    } else {
                        $url = get_template_directory_uri() . '/assets/images/no-image-1200x800.jpg';
                    }
                    ?>
                    <figure class="slick-item primary-bgcolor">
                        <a href="<?php the_permalink(); ?>" class="data-bg data-bg-slide data-bg-slide-widget"
                           data-background="<?php echo esc_url($url); ?>">
                        </a>
                        <figcaption class="slider-figcaption">
                            <div class="slider-figcaption-inner">
                                <div class="grid-item-metadata">
                                    <div class="post-category-label">
                                        <?php $categories_list = get_the_category_list(wp_kses_post(' ')); ?>
                                        <?php if (!empty($categories_list)) { ?>
                                            <?php echo $categories_list; ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <h2 class="slide-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="tm-article-meta">
                                    <div class="item-metadata tm-article-author">
                                        <span><?php echo esc_html('Published by : ', 'magazine-base'); ?></span>
                                        <a href="<?php echo esc_url(get_author_posts_url($author_id)) ?>">
                                            <?php echo esc_html(get_the_author_meta('display_name', $author_id)); ?>
                                        </a>
                                    </div>
                                    <div class="item-metadata posts-date">
                                        <span><?php echo esc_html__( 'Published on : ', 'magazine-base' );?></span>
                                        <?php the_time('j M Y'); ?>
                                    </div>
                                </div>
                            </div>
                        </figcaption>
                        <div class="fig-overlay"></div>
                    </figure>
                <?php endforeach; ?>
            </div>
            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
            <?php echo $args['after_widget'];
        }
    }
endif;

/*Grid Panel widget*/
if (!class_exists('Magazine_Base_widget_style_2')) :

    /**
     * Latest news widget Class.
     *
     * @since 1.0.0
     */
    class Magazine_Base_widget_style_2 extends Magazine_Base_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'magazine_base_list_panel_widget',
                'description' => __('Displays post form selected category on List Format.', 'magazine-base'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'description' => array(
                    'label' => __('Description:', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'post_category' => array(
                    'label' => __('Select Category:', 'magazine-base'),
                    'type' => 'dropdown-taxonomies',
                    'show_option_all' => __('All Categories', 'magazine-base'),
                ),
                'post_number' => array(
                    'label' => __('Number of Posts:', 'magazine-base'),
                    'type' => 'number',
                    'default' => 6,
                    'css' => 'max-width:60px;',
                    'min' => 1,
                    'max' => 6,
                ),
                'excerpt_length' => array(
                    'label' => __('Excerpt Length:', 'magazine-base'),
                    'description' => __('Number of words', 'magazine-base'),
                    'type' => 'number',
                    'css' => 'max-width:60px;',
                    'default' => 20,
                    'min' => 0,
                    'max' => 200,
                ),
            );

            parent::__construct('magazine-base-list-layout', __('MB: Two Column Widget', 'magazine-base'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            echo "<div class='widget-header-wrapper'>";
            if (!empty($params['title'])) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            }
            if (!empty($params['description'])) {
            echo "<p class='widget-description secondary-font'>";
                echo esc_html($params['description']);
            echo "</p>";
            }
            echo "</div>";

            $qargs = array(
                'posts_per_page' => 2,
                'no_found_rows' => true,
            );
            $qargs2 = array(
                'posts_per_page' => 4,
                'no_found_rows' => true,
                'offset' => 2,
            );
            if (absint($params['post_category']) > 0) {
                $qargs['category'] = absint($params['post_category']);
                $qargs2['category'] = absint($params['post_category']);
            }
            $all_posts = get_posts($qargs);
            $all_short_posts = get_posts($qargs2);
            ?>
            <?php global $post;
            $author_id = $post->post_author;
            ?>
            <?php if (!empty($all_posts)) : ?>
            <div class="tm-widget-wrapper clearfix">
                <div class="tm-top-figure mb-30 clearfix">
                    <?php
                    $i = 1;
                    foreach ($all_posts as $key => $post) : ?>
                        <?php setup_postdata($post);
                        if ($i == 1) {
                            $mb_coll_widget = 'col-half-left';
                        } else {
                            $mb_coll_widget = 'col-half-right';
                        }
                        $i++; ?>
                        <div class="col-half <?php echo esc_attr($mb_coll_widget) ?>">
                            <figure class="tm-figure">
                                <a href="<?php the_permalink(); ?>">
                                    <div class="tm-article-format secondary-bgcolor">
                                        <i class="tm-icon ion-paper-airplane"></i>
                                    </div>
                                    <?php if (has_post_thumbnail()) {
                                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'magazine-base-900-600');
                                        $url = $thumb['0'];
                                    } else {
                                        $url = get_template_directory_uri() . '/assets/images/no-image-900x600.jpg';
                                    }
                                    ?>
                                    <img src="<?php echo esc_url($url); ?>" alt="<?php the_title_attribute(); ?>">
                                </a>
                            </figure>
                            <div class="tm-article-body">
                                <div class="tm-article-inner">
                                    <h3 class="grid-item-title item-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>

                                    <div class="tm-article-meta">
                                        <div class="item-metadata posts-date">
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

                                    <div class="entry-content">
                                        <?php if (absint($params['excerpt_length']) > 0) : ?>
                                            <?php
                                            $excerpt = magazine_base_words_count(absint($params['excerpt_length']), get_the_content());
                                            echo wp_kses_post(wpautop($excerpt));
                                            ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="tm-bottom-figure mt-30 mb-20 clearfix">
                    <?php foreach ($all_short_posts as $key => $post) : ?>
                        <?php setup_postdata($post); ?>
                        <div class="col-four">
                            <div class="grid-item-image item-image">
                                <figure class="tm-article">
                                    <div class="tm-article-item">
                                        <div class="article-item-image">
                                            <a href="<?php the_permalink(); ?>" class="tm-hover tm-hover-zoom primary-bgcolor tm-hover-enable">
                                                <?php if (has_post_thumbnail()) {
                                                    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'magazine-base-900-600');
                                                    $url = $thumb['0'];
                                                } else {
                                                    $url = get_template_directory_uri() . '/assets/images/no-image-900x600.jpg';
                                                }
                                                ?>
                                                <img src="<?php echo esc_url($url); ?>" alt="<?php the_title_attribute(); ?>">
                                            </a>
                                        </div>
                                    </div>
                                </figure>
                            </div>

                            <div class="tm-article-sm">
                                <h3 class="grid-item-title item-title item-title-small">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="tm-article-meta hidden-xs">
                                    <div class="item-metadata posts-date">
                                        <?php the_time('j M Y'); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
            <?php echo $args['after_widget'];
        }
    }
endif;

/*Grid Panel widget*/
if (!class_exists('Magazine_Base_sidebar_widget')) :

    /**
     * Popular widget Class.
     *
     * @since 1.0.0
     */
    class Magazine_Base_sidebar_widget extends Magazine_Base_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'magazine_base_popular_post_widget',
                'description' => __('Displays post form selected category specific for popular post in sidebars.', 'magazine-base'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'description' => array(
                    'label' => __('Description:', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'post_category' => array(
                    'label' => __('Select Category:', 'magazine-base'),
                    'type' => 'dropdown-taxonomies',
                    'show_option_all' => __('All Categories', 'magazine-base'),
                ),
                'enable_discription' => array(
                    'label' => __('Enable Discription:', 'magazine-base'),
                    'type' => 'checkbox',
                    'default' => true,
                ),
                'excerpt_length' => array(
                    'label' => __('Excerpt Length:', 'magazine-base'),
                    'description' => __('Number of words', 'magazine-base'),
                    'default' => 15,
                    'css' => 'max-width:60px;',
                    'min' => 0,
                    'max' => 200,
                ),
                'post_number' => array(
                    'label' => __('Number of Posts:', 'magazine-base'),
                    'type' => 'number',
                    'default' => 4,
                    'css' => 'max-width:60px;',
                    'min' => 1,
                    'max' => 6,
                ),
            );

            parent::__construct('magazine-base-popular-sidebar-layout', __('MB: Recent/Popular Post Widget', 'magazine-base'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];
            echo "<div class='widget-header-wrapper'>";
            if (!empty($params['title'])) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            }
            if (!empty($params['description'])) {
            echo "<p class='widget-description secondary-font'>";
                echo esc_html($params['description']);
            echo "</p>";
            }
            echo "</div>";

            $qargs = array(
                'posts_per_page' => esc_attr($params['post_number']),
                'no_found_rows' => true,
            );
            if (absint($params['post_category']) > 0) {
                $qargs['category'] = absint($params['post_category']);
            }
            $all_posts = get_posts($qargs);
            $count = 1;
            ?>
            <?php global $post;
            $author_id = $post->post_author;
            ?>
            <?php if (!empty($all_posts)) : ?>
            <div class="tm-recent-widget">
                <ul class="recent-widget-list">
                    <?php foreach ($all_posts as $key => $post) : ?>
                        <?php setup_postdata($post); ?>
                        <li class="full-item pt-20 pb-20 clearfix">
                            <div class="tm-row row">
                                <div class="full-item-image item-image col col-four pull-left">
                                    <?php if (has_post_thumbnail()) {
                                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'magazine-base-400-260');
                                        $url = $thumb['0'];
                                    } else {
                                        $url = get_template_directory_uri() . '/images/no-image.jpg';
                                    }
                                    ?>
                                    <figure class="tm-article">
                                        <div class="tm-article-item">
                                            <div class="article-item-image">
                                                <a href="<?php the_permalink(); ?>" class="tm-hover">
                                                    <img src="<?php echo esc_url($url); ?>"
                                                         alt="<?php the_title_attribute(); ?>">
                                                </a>
                                            </div>
                                        </div>
                                    </figure>

                                </div>
                                <div class="full-item-details col col-six">
                                    <div class="full-item-content">
                                        <h3 class="full-item-title item-title">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                    </div>

                                    <div class="tm-article-meta">
                                        <div class="item-metadata posts-date">
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

                                    <div class="full-item-discription">
                                        <?php if (true === $params['enable_discription']) { ?>
                                            <div class="post-description">
                                                <?php if (absint($params['excerpt_length']) > 0) : ?>
                                                    <?php
                                                    $excerpt = magazine_base_words_count(absint($params['excerpt_length']), get_the_content());
                                                    echo wp_kses_post(wpautop($excerpt));
                                                    ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php
                        $count++;
                    endforeach; ?>
                </ul>
            </div>

            <?php wp_reset_postdata(); ?>

        <?php endif; ?>
            <?php echo $args['after_widget'];
        }
    }
endif;

/*tabed widget*/
if (!class_exists('Magazine_Base_Tabbed_Widget')) :

    /**
     * Tabbed widget Class.
     *
     * @since 1.0.0
     */
    class Magazine_Base_Tabbed_Widget extends Magazine_Base_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {

            $opts = array(
                'classname' => 'magazine_base_widget_tabbed',
                'description' => __('Tabbed widget.', 'magazine-base'),
            );
            $fields = array(
                'popular_heading' => array(
                    'label' => __('Popular', 'magazine-base'),
                    'type' => 'heading',
                ),
                'popular_number' => array(
                    'label' => __('No. of Posts:', 'magazine-base'),
                    'type' => 'number',
                    'css' => 'max-width:60px;',
                    'default' => 5,
                    'min' => 1,
                    'max' => 10,
                ),
                'enable_discription' => array(
                    'label' => __('Enable Discription:', 'magazine-base'),
                    'type' => 'checkbox',
                    'default' => true,
                ),
                'excerpt_length' => array(
                    'label' => __('Excerpt Length:', 'magazine-base'),
                    'description' => __('Number of words', 'magazine-base'),
                    'default' => 30,
                    'css' => 'max-width:60px;',
                    'min' => 0,
                    'max' => 200,
                ),
                'recent_heading' => array(
                    'label' => __('Recent', 'magazine-base'),
                    'type' => 'heading',
                ),
                'recent_number' => array(
                    'label' => __('No. of Posts:', 'magazine-base'),
                    'type' => 'number',
                    'css' => 'max-width:60px;',
                    'default' => 5,
                    'min' => 1,
                    'max' => 10,
                ),
                'comments_heading' => array(
                    'label' => __('Comments', 'magazine-base'),
                    'type' => 'heading',
                ),
                'comments_number' => array(
                    'label' => __('No. of Comments:', 'magazine-base'),
                    'type' => 'number',
                    'css' => 'max-width:60px;',
                    'default' => 5,
                    'min' => 1,
                    'max' => 10,
                ),
            );

            parent::__construct('magazine-base-tabbed', __('MB: Sidebar Tab Widget', 'magazine-base'), $opts, array(), $fields);

        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);
            $tab_id = 'tabbed-' . $this->number;

            echo $args['before_widget'];
            ?>
            <div class="tabbed-container clearfix">
                <div class="section-head mb-20 mt-20">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="tab tab-popular active">
                            <a href="#<?php echo esc_attr($tab_id); ?>-popular"
                               aria-controls="<?php esc_html_e('Popular', 'magazine-base'); ?>" role="tab"
                               data-toggle="tab" class="tab-popular-bgcolor">
                                <?php esc_html_e('Popular', 'magazine-base'); ?>
                            </a>
                        </li>
                        <li class="tab tab-recent">
                            <a href="#<?php echo esc_attr($tab_id); ?>-recent"
                               aria-controls="<?php esc_html_e('Recent', 'magazine-base'); ?>" role="tab"
                               data-toggle="tab" class="tab-popular-bgcolor">
                                <?php esc_html_e('Recent', 'magazine-base'); ?>
                            </a>
                        </li>
                        <li class="tab tab-comments">
                            <a href="#<?php echo esc_attr($tab_id); ?>-comments"
                               aria-controls="<?php esc_html_e('Comments', 'magazine-base'); ?>" role="tab"
                               data-toggle="tab" class="tab-popular-bgcolor">
                                <?php esc_html_e('Comments', 'magazine-base'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="<?php echo esc_attr($tab_id); ?>-popular" role="tabpanel" class="tab-pane active">
                        <?php $this->render_news('popular', $params); ?>
                    </div>
                    <div id="<?php echo esc_attr($tab_id); ?>-recent" role="tabpanel" class="tab-pane">
                        <?php $this->render_news('recent', $params); ?>
                    </div>
                    <div id="<?php echo esc_attr($tab_id); ?>-comments" role="tabpanel" class="tab-pane">
                        <?php $this->render_comments($params); ?>
                    </div>
                </div>
            </div>
            <?php

            echo $args['after_widget'];

        }

        /**
         * Render news.
         *
         * @since 1.0.0
         *
         * @param array $type Type.
         * @param array $params Parameters.
         * @return void
         */
        function render_news($type, $params)
        {

            if (!in_array($type, array('popular', 'recent'))) {
                return;
            }

            switch ($type) {
                case 'popular':
                    $qargs = array(
                        'posts_per_page' => $params['popular_number'],
                        'no_found_rows' => true,
                        'orderby' => 'comment_count',
                    );
                    break;

                case 'recent':
                    $qargs = array(
                        'posts_per_page' => $params['recent_number'],
                        'no_found_rows' => true,
                    );
                    break;

                default:
                    break;
            }

            $all_posts = get_posts($qargs);
            ?>
            <?php if (!empty($all_posts)) : ?>
            <?php global $post;
            ?>

            <ul class="article-item article-list-item article-tabbed-list article-item-left">
                <?php foreach ($all_posts as $key => $post) : ?>
                    <?php setup_postdata($post); ?>
                    <li class="full-item pt-20 pb-20 clearfix">
                        <div class="tm-row row">
                            <div class="full-item-image item-image col col-four pull-right">
                                <a href="<?php the_permalink(); ?>" class="news-item-thumb">
                                    <?php if (has_post_thumbnail($post->ID)) : ?>
                                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'magazine-base-900-600'); ?>
                                        <?php if (!empty($image)) : ?>
                                            <img src="<?php echo esc_url($image[0]); ?>"
                                                 alt="<?php the_title_attribute(); ?>"/>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <img
                                            src="<?php echo get_template_directory_uri() . '/assets/images/no-image-900x600.jpg'; ?>"
                                            alt="<?php the_title_attribute(); ?>"/>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="full-item-details col col-six">

                                <div class="full-item-content">
                                    <h3 class="full-item-title item-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>

                                    <div class="full-item-metadata mb-10">
                                        <div class="item-metadata posts-date">
                                            <span><?php echo esc_html__( 'Published on : ', 'magazine-base' );?></span>
                                            <?php the_time('j M Y'); ?>
                                        </div>
                                    </div>

                                    <div class="full-item-desc">
                                        <?php if (true === $params['enable_discription']) { ?>
                                            <div class="post-description">
                                                <?php if (absint($params['excerpt_length']) > 0) : ?>
                                                    <?php
                                                    $excerpt = magazine_base_words_count(absint($params['excerpt_length']), get_the_content());
                                                    echo wp_kses_post(wpautop($excerpt));
                                                    ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .news-content -->
                    </li>
                <?php endforeach; ?>
            </ul><!-- .news-list -->

            <?php wp_reset_postdata(); ?>

        <?php endif; ?>

            <?php

        }

        /**
         * Render comments.
         *
         * @since 1.0.0
         *
         * @param array $params Parameters.
         * @return void
         */
        function render_comments($params)
        {

            $comment_args = array(
                'number' => $params['comments_number'],
                'status' => 'approve',
                'post_status' => 'publish',
            );

            $comments = get_comments($comment_args);
            ?>
            <?php if (!empty($comments)) : ?>
            <ul class="article-item article-list-item article-item-left comments-tabbed--list">
                <?php foreach ($comments as $key => $comment) : ?>
                    <li class="article-panel clearfix">
                        <figure class="article-thumbmnail">
                            <?php $comment_author_url = get_comment_author_url($comment); ?>
                            <?php if (!empty($comment_author_url)) : ?>
                                <a href="<?php echo esc_url($comment_author_url); ?>"><?php echo get_avatar($comment, 65); ?></a>
                            <?php else : ?>
                                <?php echo get_avatar($comment, 65); ?>
                            <?php endif; ?>
                        </figure><!-- .comments-thumb -->
                        <div class="comments-content">
                            <?php echo get_comment_author_link($comment); ?>
                            &nbsp;<?php echo esc_html_x('on', 'Tabbed Widget', 'magazine-base'); ?>&nbsp;<a
                                href="<?php echo esc_url(get_comment_link($comment)); ?>"><?php echo get_the_title($comment->comment_post_ID); ?></a>
                        </div><!-- .comments-content -->
                    </li>
                <?php endforeach; ?>
            </ul><!-- .comments-list -->
        <?php endif; ?>
            <?php
        }

    }
endif;


/*author widget*/
if (!class_exists('Magazine_Base_Author_Post_widget')) :

    /**
     * Author widget Class.
     *
     * @since 1.0.0
     */
    class Magazine_Base_Author_Post_widget extends Magazine_Base_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'magazine_base_author_widget',
                'description' => __('Displays authors details in post.', 'magazine-base'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'author-name' => array(
                    'label' => __('Name:', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'discription' => array(
                    'label' => __('Discription:', 'magazine-base'),
                    'type' => 'textarea',
                    'class' => 'widget-content widefat'
                ),
                'image_url' => array(
                    'label' => __('Author Image:', 'magazine-base'),
                    'type' => 'image',
                ),
                'url-fb' => array(
                    'label' => __('Facebook URL:', 'magazine-base'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-tw' => array(
                    'label' => __('Twitter URL:', 'magazine-base'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
                'url-gp' => array(
                    'label' => __('Googleplus URL:', 'magazine-base'),
                    'type' => 'url',
                    'class' => 'widefat',
                ),
            );

            parent::__construct('magazine-base-author-layout', __('MB: Author Widget', 'magazine-base'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            if (!empty($params['title'])) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            } ?>

            <!--cut from here-->
            <div class="author-info">
                <div class="author-image">
                    <?php if (!empty($params['image_url'])) { ?>
                        <div class="profile-image bg-image">
                            <img src="<?php echo esc_url($params['image_url']); ?>">
                        </div>
                    <?php } ?>
                </div> <!-- /#author-image -->
                <div class="author-details">
                    <?php if (!empty($params['author-name'])) { ?>
                        <h3 class="author-name"><?php echo esc_html($params['author-name']); ?></h3>
                    <?php } ?>
                    <?php if (!empty($params['discription'])) { ?>
                        <p><?php echo wp_kses_post($params['discription']); ?></p>
                    <?php } ?>
                </div> <!-- /#author-details -->
                <div class="author-social">
                    <?php if (!empty($params['url-fb'])) { ?>
                        <a href="<?php echo esc_url($params['url-fb']); ?>"><i
                                class="meta-icon ion-social-facebook"></i></a>
                    <?php } ?>
                    <?php if (!empty($params['url-tw'])) { ?>
                        <a href="<?php echo esc_url($params['url-tw']); ?>"><i class="meta-icon ion-social-twitter"></i></a>
                    <?php } ?>
                    <?php if (!empty($params['url-gp'])) { ?>
                        <a href="<?php echo esc_url($params['url-gp']); ?>"><i
                                class="meta-icon ion-social-googleplus"></i></a>
                    <?php } ?>
                </div>
            </div>
            <?php echo $args['after_widget'];
        }
    }
endif;

/*author widget*/
if (!class_exists('Magazine_Base_widget_social')) :

    /**
     * Author widget Class.
     *
     * @since 1.0.0
     */
    class Magazine_Base_widget_social extends Magazine_Base_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $opts = array(
                'classname' => 'magazine_base_social_widget',
                'description' => __('Displays social menu if you have set it(social menu)', 'magazine-base'),
                'customize_selective_refresh' => true,
            );
            $fields = array(
                'title' => array(
                    'label' => __('Title:', 'magazine-base'),
                    'description' => __('Note: Displays social menu if you have set it(social menu)', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'description' => array(
                    'label' => __('Description:', 'magazine-base'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
            );
            parent::__construct('magazine-base-social-layout', __('MB: Social Menu Widget', 'magazine-base'), $opts, array(), $fields);
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget($args, $instance)
        {

            $params = $this->get_params($instance);

            echo $args['before_widget'];

            echo "<div class='widget-header-wrapper'>";
            if (!empty($params['title'])) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            }
                if (!empty($params['description'])) {
            echo "<p class='widget-description secondary-font'>";
                    echo esc_html($params['description']);
            echo "</p>";
                }
            echo "</div>";
            ?>

            <!--cut from here-->
            <div class="social-widget-menu">
                <?php
                if ( has_nav_menu( 'social' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'social',
                        'link_before'    => '<span>',
                        'link_after'     => '</span>',
                    ) );
                } ?>
            </div>
            <?php if ( ! has_nav_menu( 'social' ) ) : ?>
            <p>
                <?php esc_html_e( 'Social menu is not set. You need to create menu and assign it to Social Menu on Menu Settings.', 'magazine-base' ); ?>
            </p>
            <?php endif; ?>
            <?php echo $args['after_widget'];
        }
    }
endif;
