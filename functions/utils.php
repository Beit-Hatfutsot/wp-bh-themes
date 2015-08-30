<?php
/**
 * Utilities
 *
 * @author 		Beit Hatfutsot
 * @package 	bh/functions
 * @version     2.0
 */

/**
 * remove more jump link
 */

function BH_remove_more_jump_link($link) { 
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}

	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}

	return $link;
}
add_filter('the_content_more_link', 'BH_remove_more_jump_link');

/**
 * excerpt more link
 */

function BH_excerpt_more_link($more) {
	global $post;
	
	$read_more_btn = get_field('acf-options_event_btn_read_more', 'option');
	
	//return '...<div class="read-more"><a class="btn inline-btn red-btn big" href="' . get_permalink($post->ID) . '">' . $read_more_btn . '</a></div>';
	return ' [...]';
}
add_filter('excerpt_more', 'BH_excerpt_more_link');

/**
 * archive posts per page
 */

function archive_posts_per_page($query) {
	if ( is_admin() || ! $query->is_main_query() )
		return;
		
	if ( is_archive() ) {
		// Display unlimited posts for archive pages
		$query->set('posts_per_page', -1);
		return;
	}
}
add_action('pre_get_posts', 'archive_posts_per_page', 1);

/**
 * separate media categories from post categories
 * use a custom category called 'category_media' for the categories in the media library
 */
add_filter( 'wpmediacategory_taxonomy', function(){ return 'category_media'; }, 1 ); //requires PHP 5.3 or newer

/**
 * BH_strip_tags_content
 * 
 * Strip tags from HTML string
 * 
 * Examples:
 * Sample text:
 * $text = '<b>sample</b> text with <div>tags</div>';
 * 
 * Result for strip_tags_content($text, '<b>'):
 * <b>sample</b> text with
 * 
 * Result for strip_tags_content($text, '<b>', TRUE);
 * text with <div>tags</div>
 * 
 * @param	string	$text		HTML string
 * @param	string	$tags		HTML tags to include/exclude
 * @param	bool	$invert		include (false) / exclude (true)
 */
function BH_strip_tags_content($text, $tags = '', $invert = FALSE) {
	preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
	$tags = array_unique($tags[1]);
	
	if(is_array($tags) AND count($tags) > 0) {
		if($invert == FALSE) {
			return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
		}
		else {
			return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
		}
	}
	elseif($invert == FALSE) {
		return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
	}
	
	return $text;
}

/**
 * BH_mejskin_enqueue_styles
 * 
 * Custom MediaLayer skin
 */
function BH_mejskin_enqueue_styles() {
	$library = apply_filters('wp_audio_shortcode_library', 'mediaelement');
	
	if ( 'mediaelement' === $library && did_action('init') ) {
		wp_enqueue_style( 'mejskin', CSS_DIR . '/libs/mediaelement/skin/mediaelementplayer.css', false, null );
	}
}
add_action('wp_footer', 'BH_mejskin_enqueue_styles', 11);

/**
 * BH_setpost_limits
 * 
 * Set post limits in case of feed display
 * 
 * @param	string	$s			maximum posts to display
 * @return	string				modified number of posts to display
 */
function BH_setpost_limits($s) {
	if(is_feed() && !empty($_GET['nolimit']) )
		return '';
	else
		return $s;
}
add_filter('post_limits','BH_setpost_limits');

/**
 * BH_background_post
 * 
 * Send POST request in the background
 * 
 * @param	string	$url		url to be sent
 */
function BH_background_post($url) {
	$parts = parse_url($url);

	$fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30);

	if (!$fp) {
		return false;
	} else {
		$out = "POST ".$parts['path']." HTTP/1.1\r\n";
		$out.= "Host: ".$parts['host']."\r\n";
		$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out.= "Content-Length: ".strlen($parts['query'])."\r\n";
		$out.= "Connection: Close\r\n\r\n";

		if (isset($parts['query']))
			$out.= $parts['query'];

		fwrite($fp, $out);
		fclose($fp);

		return true;
	}
}