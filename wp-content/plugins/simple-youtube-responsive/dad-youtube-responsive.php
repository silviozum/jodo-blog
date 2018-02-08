<?php
/*
Plugin Name: Simple YouTube Responsive
Plugin URI: https://eirudo.com/portfolios/wordpress-plugins/youtube-responsive
Text Domain: dad-youtube-responsive
Description: Embed YouTube video and Responsive using simple shortcode, and keep the video's Aspect Ratio. Use [youtube v="xxxxx"] change xxxxx with YouTube's video ID.
Version: 1.2.5
Author: Eirudo
Author URI: https://eirudo.com/
License: GPL2
Requires: WordPress version 2.5 and later
*/

if ( !defined('ABSPATH') ){
	die;
}

/*
Hijack shortcode for AMP.
Thanks to John Regan
https://johnregan3.co/2016/08/03/a-comprehensive-guide-to-supporting-amp-in-wordpress/#handling-shortcodes
 */
 if( has_action( 'amp_post_template_head' ) ){
	function dad_youtube_responsive_amp( $content ) {
		global $shortcode_tags;
		if ( ! is_amp_endpoint() || empty( $shortcode_tags ) || ! is_array( $shortcode_tags ) ) {
			return $content;
		}

		$regex = get_shortcode_regex( array( 'youtube' ) );
		
		if ( ! $videoID = dad_shortcode_attr( $content, $regex, 'v' ) ) {
			if( ! $videoID = dad_shortcode_attr( $content, $regex, 'video' ) ){
				return preg_replace( "/$regex/", '', $content );
			}
		}
		
		if( ! $videoRatio =  dad_shortcode_attr( $content, $regex, 'ratio' ) ){
			$videoRatio = '16:9';
		}
		
		/* Fix Ratio format */
		if( count(explode(':',$videoRatio)) !== 2 ){
			$videoRatio = '16:9';
		}
		
		$ratio = explode(':',$videoRatio);
		$ratio1 = floatval($ratio[0]);
		$ratio2 = floatval($ratio[1]);
		$videoWidth = $ratio1 * 40;
		$videoHeight = $ratio2 * 40;

		ob_start();
		?>
		 <amp-youtube width="<?php echo $videoWidth; ?>" height="<?php echo $videoHeight; ?>" layout="responsive" data-videoid="<?php echo $videoID; ?>"></amp-youtube>
		<?php
		$dad_youtube_amp_ver = ob_get_clean();
		$content = preg_replace( "/$regex/", $dad_youtube_amp_ver, $content );
		return $content;
	}
	add_filter( 'the_content', 'dad_youtube_responsive_amp' );

	/* Include YouTube AMP Scripts */
	add_action( 'amp_post_template_head', 'dad_youtube_responsive_amp_scripts' );

	function dad_youtube_responsive_amp_scripts( $amp_template ) {
		$post_id = $amp_template->get( 'post_id' );
		?>
		<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
		<?php
	}
}

/* Get Shortcode Attr from Content */
function dad_shortcode_attr( $content, $regex, $search ) {
	
	preg_match( "/$regex/", $content, $shortcode_atts );

	$search = $search . '=';

	if ( empty( $shortcode_atts ) ) {
		return false;
	}

	$matches = array_filter( $shortcode_atts, function( $var ) use ( $search ) {
		return ( 0 === strpos( trim( $var ), $search ) );
	}
	);

	if ( empty( $matches ) ) {
		return false;
	}

	$value_string = array_shift( array_values( $matches ) );
	$val = str_replace( $search , '', $value_string );

	$val = str_replace( '"', '', $val );
	$val = str_replace( "'", '', $val );
	return trim( $val );
}

function dad_youtube_responsive( $a ) {
    $tags = shortcode_atts( array(
		'v' => '',
        'video' => '',
        'ratio' => '16:9',
		'class' => '',
		'id' => '',
		'style' => '',
		'maxwidth' => '100%'
    ), $a );
	if($tags['v']!='' || $tags['video']!=''){
		if($tags['v']!=''){
			$youtubeID=$tags['v'];
		}else{
			$youtubeID=$tags['video'];
		}
		$css='width:100%;max-width:'.$tags['maxwidth'].';margin:0 auto;display:block;clear:both;position:relative;';
		$classing='';
		$iding='';
		$ratio=explode(':',$tags['ratio']);
		$ratio1=floatval($ratio[0]);
		$ratio2=floatval($ratio[1]);
		$setRatio=(floatval($ratio2) / floatval($ratio1)) * 100;
		$cssRatio='padding-bottom:'.$setRatio.'%;';
		if($tags['style']!=''){
			$css=$css.$tags['style'];
		}
		if($tags['class']!=''){
			$classing=$classing.' '.$tags['class'];
		}
		if($tags['id']!=''){
			$iding='id="'.$tags['id'].'"';
		}
		$css=' style="'.$css.'"';
		
		return '<div class="dad-youtube-responsive'.$classing.'" '.$iding.' '.$css.'><div style="position:relative;width:100%;height:0;display:block;clear:both;'.$cssRatio.'"><iframe src="https://www.youtube.com/embed/'.$youtubeID.'?rel=0" frameborder="0" allowfullscreen="" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div></div>';
		
	}else{
		return '';
	}
}
add_shortcode( 'youtube', 'dad_youtube_responsive' );

/* Enable YouTube on sidebar text */
add_filter('widget_text','do_shortcode');

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'dad_youtube_responsive_links' );
function dad_youtube_responsive_links( $links ){
 $helpLinks = array(
 '<a href="https://eirudo.com/portfolios/wordpress-plugins/youtube-responsive#shortcodes" target="_blank">Shortcodes</a>',
 );
return array_merge( $links, $helpLinks );
}

/* TinyMCE Editor Supported */
/* Add Shortcode Button to TinyMCE Editor Toolbar */
add_action('init', 'dad_youtube_responsive_tinymce_init');
function dad_youtube_responsive_tinymce_init() {
	//Abort early if the user will never see TinyMCE
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
		return;

	//Add a callback to regiser our tinymce plugin   
	add_filter("mce_external_plugins", "dad_youtube_responsive_register_tinymce"); 

	// Add a callback to add our button to the TinyMCE toolbar
	add_filter('mce_buttons', 'dad_youtube_responsive_tinymce_button');
}


//This callback registers our plug-in
function dad_youtube_responsive_register_tinymce($plugin_array) {
	$plugin_array['dad_youtube_responsive'] = plugin_dir_url( __FILE__ ) . 'js/tinymce-buttons.js';
	return $plugin_array;
}

//This callback adds our button to the toolbar
function dad_youtube_responsive_tinymce_button($buttons) {
	//Add the button ID to the $button array
	$buttons[] = "dad_youtube_responsive";
	return $buttons;
}
