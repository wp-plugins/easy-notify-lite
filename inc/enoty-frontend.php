<?php


/*-------------------------------------------------------------------------------*/
/* Get the default Notify
/*-------------------------------------------------------------------------------*/
function easynotify_init() {
if ( enoty_get_option( 'easynotify_disen_loggedusr' ) ) {
	if ( !is_user_logged_in() ) {
		$defaultnoty = enoty_get_option( 'easynotify_defaultnotify' );
		if ( $defaultnoty != 'disabled' && !isset( $_COOKIE["notify-".$defaultnoty.""] ) ) {
			add_action( 'wp_enqueue_scripts', 'easynotify_enqueue_default');
			add_filter( 'the_content', 'easynotify_strip_default_noty' );
			add_filter( 'wp_footer', 'generate_global_notify' );
			}
		} else {
			add_filter( 'the_content', 'easynotify_not_logged_in' );
		}
	} else {
		$defaultnoty = enoty_get_option( 'easynotify_defaultnotify' );
		if ( $defaultnoty != 'disabled' && !isset( $_COOKIE["notify-".$defaultnoty.""] ) ) {
			add_action( 'wp_enqueue_scripts', 'easynotify_enqueue_default');
			add_filter( 'the_content', 'easynotify_strip_default_noty' );
			add_filter( 'wp_footer', 'generate_global_notify' );
			}
		}
	}		
add_action('init', 'easynotify_init');

function easynotify_not_logged_in( $content ) {
 	$new_content = $content;
	$new_content = easynotify_strip_shortcode('easy-notify', $new_content);
	return $new_content;
}

/*-------------------------------------------------------------------------------*/
/* Strip Notify from Post / Page
/*-------------------------------------------------------------------------------*/
function easynotify_strip_default_noty( $content ) {
	
 	$new_content = $content; $ishome = enoty_get_option( 'easynotify_swhome' ); $ispage	= enoty_get_option( 'easynotify_swpage' ); $ispost	= enoty_get_option( 'easynotify_swpost' ); $isctach = enoty_get_option( 'easynotify_swcatarch' ); $fromcp = enoty_get_option( 'easynotify_defaultnotify' );
	
	if ( !isset( $_COOKIE["notify-".$fromcp.""] ) || get_post_meta( $fromcp, 'enoty_cp_cookies', true ) == '-1' ) {
	
		if( $ispage && is_page() ) {
			$new_content = easynotify_strip_shortcode('easy-notify', $content);
			}
			
		elseif( $ispost && is_single() ) {
			$new_content = easynotify_strip_shortcode('easy-notify', $content);
			}
			
		elseif( ( $ishome && is_home() ) || ( $ishome && is_front_page() ) ) {
			$new_content = easynotify_strip_shortcode('easy-notify', $content);
			}	
				
		elseif( ( $isctach && is_category() ) || ( $isctach && is_archive() ) ) {
			$new_content = easynotify_strip_shortcode('easy-notify', $content);
			}
			
		}
		return $new_content;
}

/*-------------------------------------------------------------------------------*/
/* Generate & Launch global Notify
/*-------------------------------------------------------------------------------*/
function generate_global_notify(){
	
 	$ishome	= enoty_get_option( 'easynotify_swhome' ); $ispage	= enoty_get_option( 'easynotify_swpage' ); $ispost	= enoty_get_option( 'easynotify_swpost' ); $isctach = enoty_get_option( 'easynotify_swcatarch' ); $fromcp = enoty_get_option( 'easynotify_defaultnotify' );
	
	if ( !isset( $_COOKIE["notify-".$fromcp.""] ) || get_post_meta( $fromcp, 'enoty_cp_cookies', true ) == '-1' ) {
	
		if( $ispage && is_page() && !is_front_page() && !is_home() ) {
			echo do_shortcode( '[easy-notify id="'.$fromcp.'"]' );
			}
			
		elseif( $ispost && is_single() && !is_front_page() && !is_home() ) {
			echo do_shortcode( '[easy-notify id="'.$fromcp.'"]' );
			}
			
		elseif( ( $ishome && is_home() ) || ( $ishome && is_front_page() ) ) {
			echo do_shortcode( '[easy-notify id="'.$fromcp.'"]' );
			}
			
		elseif( ( $isctach && is_category() ) || ( $isctach && is_archive() ) ) {
			echo do_shortcode( '[easy-notify id="'.$fromcp.'"]' );
			}	
				
		}
}	


/*-------------------------------------------------------------------------------*/
/*Put Script if has Shortcode Function
/*-------------------------------------------------------------------------------*/
function easynotify_old_has_shortcode($shortcode = '') {
	$post_to_check = get_post(get_the_ID());
	$found = false;
	
	if (!$shortcode) {
		return $found;
		}  

    if ( stripos($post_to_check->post_content, '[' . $shortcode) !== false ) {
		$found = true;
		}  
		
    return $found;  
}  

function easynotify_enqueue_sanitize(){ 
	global $post;

	if( function_exists('has_shortcode') )
	{
		if( @has_shortcode( $post->post_content, 'easy-notify') ) {
			add_action( 'wp_head', 'easynotify_script' );
			add_action( 'wp_print_styles', 'easynotify_style' );
			}
		}
		else
		{
			if( easynotify_old_has_shortcode('easy-notify') ) {
				add_action( 'wp_head', 'easynotify_script' );
				add_action( 'wp_print_styles', 'easynotify_style' );
				}
		}
		
}

add_action( 'wp_enqueue_scripts', 'easynotify_enqueue_sanitize');


function easynotify_script() {
	
		wp_enqueue_script( 'enoty-enotybox-js' );
		wp_enqueue_script( 'enoty-cookie-front' );
		
ob_start(); ?>

<!-- <?php echo ENOTIFY_NAME; ?> -->    
<!-- Version : <?php echo ENOTIFY_VERSION; ?> --> 
		
<?php echo ob_get_clean();	
	
}

function easynotify_style() {
	
		wp_enqueue_style( 'enoty_enotybox_style', ENOTIFY_URL .'/css/enotybox/jquery.enotybox.css' );
		wp_enqueue_style( 'enoty_frontend_style', ENOTIFY_URL .'/css/frontend.css' );

}

function easynotify_enqueue_default(){
	add_action( 'wp_head', 'easynotify_script' );
	add_action( 'wp_print_styles', 'easynotify_style' );
	add_action( 'wp_footer', 'easynotify_custom_css', 100 );
	}
	
function easynotify_custom_css() {
	if ( enoty_get_option( 'easynotify_custom_css' ) ) {
		echo '<style type="text/css">';
		echo enoty_get_option( 'easynotify_custom_css' );
		echo '</style>';
		}
	}
	
function easynotify_remove_shortcode_from_index($content) {
  if ( is_home() || is_front_page() || is_category() || is_archive() ) {
    $content = easynotify_strip_shortcode('easy-notify', $content);
  }
  return $content;
}
add_filter('the_content', 'easynotify_remove_shortcode_from_index');
	

?>