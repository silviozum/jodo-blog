<?php
/**
 * Default theme options.
 *
 * @package magazine-base
 */

if (!function_exists('magazine_base_get_default_theme_options')):

/**
 * Get default theme options
 *
 * @since 1.0.0
 *
 * @return array Default theme options.
 */
function magazine_base_get_default_theme_options() {

	$defaults = array();

	// Top Section.
	$defaults['top_section_advertisement']     = '';
	$defaults['top_section_advertisement_url'] = '';
	$defaults['show_navigation_collaps']       = 1;

	$defaults['home_grid_layout'] = 'homepage-style-1';

	/*trending news section*/
	$defaults['show_trending_news_section']        = 1;
	$defaults['select_category_for_trending_news'] = 1;
	$defaults['trending_news_title']               = esc_html__('Trending Now', 'magazine-base');

	// Slider Section.
	$defaults['show_slider_section']                    = 0;
	$defaults['number_of_home_slider']                  = 3;
	$defaults['select_category_for_slider']             = 1;
	$defaults['select_category_for_slider_double_post'] = 1;

	/*Latest Blog Default Value*/
	$defaults['show_featured_section']        = 0;
	$defaults['main_title_featured_section']  = '';
	$defaults['select_category_for_featured'] = 0;

	/*layout*/
	$defaults['home_page_content_status'] = 1;
	$defaults['enable_overlay_option']    = 1;
	$defaults['homepage_layout_option']   = 'full-width';
	$defaults['global_layout']            = 'right-sidebar';
	$defaults['excerpt_length_global']    = 50;
	$defaults['archive_layout']           = 'excerpt-only';
	$defaults['archive_layout_image']     = 'full';
	$defaults['single_post_image_layout'] = 'full';
	$defaults['pagination_type']          = 'default';
	$defaults['copyright_text']           = esc_html__('Copyright All right reserved', 'magazine-base');
	$defaults['single_page_first_text']   = 1;
	$defaults['enable_preloader']         = 1;

	$defaults['social_icon_style']       = 'square';
	$defaults['number_of_footer_widget'] = 3;
	$defaults['breadcrumb_type']         = 'simple';

	// Pass through filter.
	$defaults = apply_filters('magazine_base_filter_default_theme_options', $defaults);

	return $defaults;

}

endif;
