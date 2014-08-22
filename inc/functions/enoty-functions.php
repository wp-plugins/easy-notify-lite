<?php


/*-------------------------------------------------------------------------------*/
/* Get Control Panel Options
/*-------------------------------------------------------------------------------*/
function enoty_get_option( $name ){
    $pnp_values = get_option( 'easynotify_opt' );
    if ( is_array( $pnp_values ) && array_key_exists( $name, $pnp_values ) ) return $pnp_values[$name];
    return false;
} 

/*-------------------------------------------------------------------------------*/
/*   Register CSS & JS ( ADMIN AREA )
/*-------------------------------------------------------------------------------*/
function easynotify_reg_script() {
	wp_register_style( 'enoty-ui-themes-redmond', plugins_url( 'css/jquery/jquery-ui/themes/smoothness/jquery-ui-1.10.0.custom.min.css' , dirname(__FILE__) ), false, ENOTIFY_VERSION );

	wp_register_style( 'enoty-multiselect-css', plugins_url( 'css/jquery/multiselect/jquery.multiselect.css' , dirname(__FILE__) ), false, ENOTIFY_VERSION );
	
	wp_register_script( 'enoty-multi-sel', plugins_url( 'js/jquery/multiselect/jquery.multiselect.js' , dirname(__FILE__) ) );	

	wp_register_style( 'enoty-colorpicker', plugins_url( 'css/colorpicker.css' , dirname(__FILE__) ), false, ENOTIFY_VERSION );
	wp_register_script( 'enoty-colorpickerjs', plugins_url( 'js/colorpicker/colorpicker.js' , dirname(__FILE__) ), false );	
	wp_register_script( 'enoty-eye', plugins_url( 'js/colorpicker/eye.js' , dirname(__FILE__) ), false );
	wp_register_script( 'enoty-utils', plugins_url( 'js/colorpicker/utils.js' , dirname(__FILE__) ), false );		
	wp_register_script( 'enoty-cookie', plugins_url( 'js/jquery/jquery.cookie.js' , dirname(__FILE__) ), false );	
	
	wp_register_style( 'enoty-cpstyles', plugins_url( 'css/funcstyle.css' , dirname(__FILE__) ), false, ENOTIFY_VERSION, 'all');
	wp_register_style( 'enoty-sldr', plugins_url( 'css/slider.css' , dirname(__FILE__) ), false, ENOTIFY_VERSION );
	
	wp_register_script( 'enoty-comparison-js', plugins_url( 'js/compare.js' , dirname(__FILE__) ) );
	wp_register_style( 'enoty-comparison-css', plugins_url( 'css/compare.css' , dirname(__FILE__) ), false, ENOTIFY_VERSION );
	
	}
		
add_action( 'admin_init', 'easynotify_reg_script' );


/*-------------------------------------------------------------------------------*/
/*   Register CSS & JS ( FRONT END )
/*-------------------------------------------------------------------------------*/
function easynotify_frontend_js() {

		wp_register_script( 'enoty-enotybox-js', ENOTIFY_URL. '/js/enotybox/jquery.enotybox.js' );
		wp_register_script( 'enoty-cookie-front', ENOTIFY_URL. '/js/jquery/jquery.cookie.js' );
		
}
add_action( 'wp_enqueue_scripts', 'easynotify_frontend_js' );


/*-------------------------------------------------------------------------------*/
/*   Load Control Panel & Metabox
/*-------------------------------------------------------------------------------*/
if ( is_admin() ){
	include_once( ENOTIFY_DIR . '/layouts/enoty-preview.php' );
    include_once( ENOTIFY_DIR . '/inc/enoty-options.php' );
	include_once( ENOTIFY_DIR . '/inc/enoty-settings.php' );
	include_once( ENOTIFY_DIR . '/inc/enoty-metaboxes.php' );
 }
 
 
/*-------------------------------------------------------------------------------*/
/*   Load Frontend
/*-------------------------------------------------------------------------------*/
include_once( ENOTIFY_DIR . '/inc/enoty-frontend.php' );
include_once( ENOTIFY_DIR . '/inc/enoty-shortcode.php' );
include_once( ENOTIFY_DIR . '/inc/functions/enoty-loader.php' );


/*-------------------------------------------------------------------------------*/
/*   Ajax Init
/*-------------------------------------------------------------------------------*/
add_action('wp_ajax_nopriv_easynotify_ajax_content', 'easynotify_ajax_content');
add_action('wp_ajax_easynotify_ajax_content', 'easynotify_ajax_content');


/*-------------------------------------------------------------------------------*/
/*   CHECK BROWSER VERSION ( IE ONLY )
/*-------------------------------------------------------------------------------*/
function easynotify_check_browser_version_admin( $sid ) {
	
	if ( is_admin() && get_post_type( $sid ) == 'easynotify' ){

		preg_match( '/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches );
		if ( count( $matches )>1 ){
			$version = explode(".", $matches[1]);
			switch(true){
				case ( $version[0] <= '8' ):
				$msg = 'ie8';

			break; 
			  
				case ( $version[0] > '8' ):
		  		$msg = 'gah';
			  
			break; 			  

			  default:
			}
			return $msg;
		} else {
			$msg = 'notie';
			return $msg;
			}
	}
}
 
/*-------------------------------------------------------------------------------*/
/*  RENAME POST BUTTON
/*-------------------------------------------------------------------------------*/
add_filter( 'gettext', 'easynotify_publish_button', 10, 2 );
function easynotify_publish_button( $translation, $text ) {
if ( 'easynotify' == get_post_type())
if ( $text == 'Publish' ) {
    return 'Save Notify'; }
else if ( $text == 'Update' ) {
    return 'Update Notify'; }	

return $translation;
} 

/*-------------------------------------------------------------------------------*/
/*  Get the pattern/layout list 
/*-------------------------------------------------------------------------------*/
function easynotify_get_list( $list ) {
	$lst = array();
	$lst_list = scandir( ENOTIFY_DIR."/css/images/".$list );
	
	foreach( $lst_list as $lst_name ) {
		if ( $lst_name != '.' && $lst_name != '..' ) {
			$lst[] = $lst_name;
		}
	}
	return $lst;	
}

/*-------------------------------------------------------------------------------*/
/*  Strip current shortcode when using default notify
/*-------------------------------------------------------------------------------*/
function easynotify_strip_shortcode($code, $content){
    global $shortcode_tags;

    $stack = $shortcode_tags;
    $shortcode_tags = array($code => 1);

    $content = strip_shortcodes($content);

    $shortcode_tags = $stack;
    return $content;
}	

/*-------------------------------------------------------------------------------*/
/* Generate Notify Script
/*-------------------------------------------------------------------------------*/
function easynotify_ajax_script( $id, $val ) {

	$offect = explode("-", get_post_meta( $id, 'enoty_cp_open_effect', true ));
	$cffect = explode("-", get_post_meta( $id, 'enoty_cp_close_effect', true )); 
	
	ob_start(); ?>
    
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		function easynotify_notify_loader() {
				var notydata = {
				action: "easynotify_ajax_content",
				security: "<?php echo wp_create_nonce( "easynotify-nonce"); ?>",	
				notyid: <?php echo $id; ?>
				};
			
				jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", notydata, function(response) {
					jQuery('#noty-<?php echo $id; ?>').append(response);
					
					var timerId;
					if(timerId != undefined){clearInterval(timerId);}
 					timerId =  setInterval(function (){
					jQuery('#launcher-<?php echo $id; ?>').easynotify({
						type: 'inline',
						maxWidth: '100%',
						width: '<?php echo get_post_meta( $id, 'enoty_cp_thumbsize_tw', true ); ?>',
						height: '<?php echo get_post_meta( $id, 'enoty_cp_thumbsize_th', true ); ?>',
						padding : 0,
						margin: [60, 60, 60, 60],
						modal: false,
						hideLoading	: true,
						openSpeed: 500,
						closeSpeed: 500,
						openEffect: '<?php echo $offect[1]; ?>', 
						closeEffect: '<?php echo $cffect[1]; ?>',
						autoSize: false,
						fitToView: false,
						scrolling: 'no',
						keys : {
							 close  : null
							 },
						helpers: {
							overlay : {
								closeClick : false,
								locked : false
								}
							}, 
						tpl: { 
							wrap:'<div class="enotybox-wrap"><div class="enotybox-skin enoty-custom-wrapper"><div class="enotybox-outer"><div class="enotybox-inner"></div></div></div></div>'
							},
						afterLoad: function(){
							    clearInterval(timerId);
								}
						}).trigger("click");
						}, <?php echo get_post_meta( $id, 'enoty_cp_notify_delay', true ); ?>000);
				});
			}
				
			// COOKIE CONFIG
			var check_cookie = jQuery.cookie('notify-<?php echo $id; ?>');
			var ex_cookie = <?php echo get_post_meta( $id, 'enoty_cp_cookies', true ); ?>;
			if (check_cookie == null || ex_cookie == '-1') {
				easynotify_notify_loader();
					}  <?php $ckonset = get_post_meta( $id, 'enoty_cp_cookies', true ); if ( $ckonset != '-1' || $ckonset != '0' ) { ?>
					jQuery.cookie('notify-<?php echo $id; ?>', 'true', {
					expires: <?php echo get_post_meta( $id, 'enoty_cp_cookies', true ); ?>,
					path: '/' 
					}); <?php } ?>
			});
</script>

<?php

$contnt = ob_get_clean();
echo $contnt;  

}


/*-------------------------------------------------------------------------------*/
/* Generate Notify Content
/*-------------------------------------------------------------------------------*/
function easynotify_ajax_content() {
		
		if ( !isset( $_POST['notyid'] ) || !isset( $_POST['security'] ) ) {
			die;
		}
		
		else {
			check_ajax_referer( 'easynotify-nonce', 'security' );
			$lyot = get_post_meta( $_POST['notyid'], 'enoty_cp_layoutmode', true );
			$layout = preg_replace('/\\.[^.\\s]{3,4}$/', '', $lyot);
			
			if ( $layout ) {
				include_once( ENOTIFY_DIR . '/layouts/'.str_replace('_', '-', $layout ).'.php' );
				$layoutfunc = $layout;
			}

			ob_start();
			
			$layoutfunc( $_POST['notyid'] );
			
			$contnt = ob_get_clean();
			
			echo $contnt; 
			die;		
	
		}

	}


/*-------------------------------------------------------------------------------*/
/*  Get WP Info
/*-------------------------------------------------------------------------------*/
$easymemory = (int) ini_get('memory_limit');
$easymemory = empty($easymemory) ? __('N/A') : $easymemory . __(' MB');

function easynotify_get_wpinfo() {
	
// Get Site URL	
$getwpinfo = array();
$getwpinfo[0] = "- Site URL : " .get_site_url();

// Get Multisite status
if ( is_multisite() ) { $getwpinfo[1] = '- WP Multisite : YES'; } else { $getwpinfo[1] = '- WP Multisite : NO'; }

global $wp_version, $easymemory;		
echo "- WP Version : ".$wp_version."\n";	
echo $getwpinfo[0]."\n";
echo $getwpinfo[1]."\n";
echo "- Memory Limit : ".$easymemory."\n";
$theme_name = wp_get_theme();
echo "- Active Theme : ".$theme_name->get('Name')."\n";
echo "- Active Plugins : \n";

// Get Active Plugin
if ( is_multisite() ) { 
	$the_plugs = get_site_option('active_sitewide_plugins');
	foreach($the_plugs as $key => $value) {
		$string = explode('/',$key);
		$string[0] = str_replace( "-"," ",$string[0] );
        echo " &nbsp;&nbsp;&nbsp;&nbsp;".ucwords( $string[0] ) ."\n";
	}
} else {
	$the_plugs = get_option('active_plugins');
	foreach($the_plugs as $key => $value) {
		$string = explode('/',$value);
		$string[0] = str_replace( "-"," ",$string[0] );
        echo " &nbsp;&nbsp;&nbsp;&nbsp;".ucwords( $string[0] ) ."\n";
		}
	}
}


/*-------------------------------------------------------------------------------*/
/*  AJAX RESET SETTINGS
/*-------------------------------------------------------------------------------*/
function easynotify_cp_reset() {
	
	check_ajax_referer( 'easynotify-nonce', 'security' );
	
	if ( !isset( $_POST['cmd'] ) ) {
		echo '0';
		die;
		}
		
		else {
			if ( $_POST['cmd'] == 'reset' ){
				echo '1';
				easynotify_restore_to_default($_POST['cmd']);			
				die;
				}
	}
}
add_action( 'wp_ajax_easynotify_cp_reset', 'easynotify_cp_reset' );


/*-------------------------------------------------------------------------------*/
/*  Clear Cookies from Notify List
/*-------------------------------------------------------------------------------*/
function easynotify_enqueue_script_on_notify_list( ) {
		
		global $post_type;
		
		    if( 'easynotify' == $post_type ) {
				wp_enqueue_script( 'enoty-cookie' );
				wp_enqueue_style( 'enoty-admin-styles', plugins_url('../css/admin.css' , __FILE__ ) );

				
				?>
                <script type="text/javascript">
				jQuery(document).ready(function($) { 
					jQuery('.resetcookie').bind('click', function() {
						jQuery.removeCookie(jQuery(this).attr('id'), { path: '/' }); 
						alert("Successfully cleared this Notify cookies!");						
						});
                
				    });
                    </script>
				<?php
		}
				
}

if (is_admin()) {
	add_action( 'admin_head', 'easynotify_enqueue_script_on_notify_list' );
	}


/*-------------------------------------------------------------------------------*/
/*  Create Preview Metabox
/*-------------------------------------------------------------------------------*/
function easynotify_preview_metabox () {
	$enotyprev = '<div style="text-align:center;">';
	$enotyprev .= '<img id="preview-notify" style="cursor:pointer;" src="'.plugins_url( 'images/preview.png' , dirname(__FILE__) ).'" width="65" height="65" alt="Preview" >';
	$enotyprev .= '</div>';
echo $enotyprev;	
}


/*-------------------------------------------------------------------------------*/
/*  Create Upgrade Metabox
/*-------------------------------------------------------------------------------*/
function easynotify_upgrade_metabox () {
	$enobuy = '<div style="text-align:center;">';
	$enobuy .= '<a style="outline: none !important;" href="http://ghozylab.com/plugins/pricing/#tab-1408601400-2-44" target="_blank"><img style="cursor:pointer; margin-top: 7px;" src="'.plugins_url( 'images/buy-now.png' , dirname(__FILE__) ).'" width="241" height="95" alt="Buy Now!" ></a>';
	$enobuy .= '</div>';
echo $enobuy;	
}


/*-------------------------------------------------------------------------------*/
/*  Create Preview ( AJAX )
/*-------------------------------------------------------------------------------*/
function easynotify_generate_preview () {
	
	if ( !isset( $_POST['post_ID'] ) && !isset( $_GET['noty_id'] )) {
		echo 'Failed to generate Preview! Please try again.';
		die;
		}
		
		$theval = array();
		$allval = array();
		
		if ( isset ( $_POST['post_ID'] ) ) {
			
			$thepost = intval( $_POST['post_ID'] );
			
			$_POST['enoty_meta'] = stripslashes_deep( $_POST['enoty_meta'] );
			
			 foreach ((array) $_POST['enoty_meta'] as $k => $v){
				 $allval[$k] = $v;
				 }
					easynotify_preview( $thepost, $allval );
				}
				
			elseif ( isset( $_GET['noty_id'] ) && easynotify_post_exists( intval( $_GET['noty_id'] ) ) ) {
				
				$thepost = intval( $_GET['noty_id'] ); 

				foreach ( get_post_meta( $_GET['noty_id'] ) as $k => $v){
					$theval[$k] = $v;
					
					foreach ( $theval as $k => $v){
						$tmp = get_post_meta( $_GET['noty_id'], $k, true );
						$allval[$k] = $tmp;
						}
					}

					easynotify_preview( $thepost, $allval );

				} else {
					die('Ooops!');
					}

		die('');
		
}
add_action('wp_ajax_easynotify_generate_preview', 'easynotify_generate_preview');


/*-------------------------------------------------------------------------------*/
/*  If Post/Page Exist
/*-------------------------------------------------------------------------------*/
function easynotify_post_exists( $id ) {
	return is_string( get_post_status( $id ) );
}
	
/*-------------------------------------------------------------------------------*/
/*  Slug to Name
/*-------------------------------------------------------------------------------*/
function easynotify_slug_to_name($slug) {
	$vals = array(
				"optin"=> "Opt-in ( Subscribe Form )",
				"socialbutton"=> "Social Sharing Buttons",
				"button"=> "Custom Text & Button",
				"none"=> "Disabled",
				"" => "None"
		);
	return $vals[$slug];	
}


/*-------------------------------------------------------------------------------*/
/*  Apply Individual Layout & Styles
/*-------------------------------------------------------------------------------*/	
function easynotify_apply_layout_style( $layout ) {
	wp_enqueue_style( 'enoty_enotybox_layout_'.$layout.'', ENOTIFY_URL .'/css/layouts/'.$layout.'.css' );
}

function easynotify_dynamic_styles( $id, $val = '', $type = '' ) {
	
			$getdata = array( 'pattern', 'overlaycol', 'overlayopct', 'headerback' );
			$data = easynotify_loader( $getdata, $id, $val, $type );

  			$pattopctymz = $data['overlayopct'] / 100;	

  echo '
       <style type="text/css">
            .enoty-enotybox-overlay {
				background: url('.ENOTIFY_URL.'/css/images/patterns/'.$data['pattern'].') !important; background-repeat: repeat;
				background-color:'.$data['overlaycol'].' !important;
				filter: alpha(opacity='.$data['overlayopct'].');
   				filter: progid:DXImageTransform.Microsoft.Alpha(opacity='.$data['overlayopct'].');
   				opacity:'.$pattopctymz.';
   				-moz-opacity:'.$pattopctymz.'0; 
				}
				
			.enoty-custom-wrapper {
				background: #272727;
				background-image: -webkit-linear-gradient(top, #272727 0, #383838 30%, #383838 70%, #272727 100%);
				background-image: -moz-linear-gradient(top, #272727 0, #383838 30%, #383838 70%, #272727 100%);
				background-image: -ms-linear-gradient(top, #272727 0, #383838 30%, #383838 70%, #272727 100%);
				background-image: -o-linear-gradient(top, #272727 0, #383838 30%, #383838 70%, #272727 100%);
				background-image: linear-gradient(top, #272727 0, #383838 30%, #383838 70%, #272727 100%);
				}
				
			.noty-text-header {
				background: '.$data['headerback'].'; 
			}
				
       </style>
    ';
}


/*-------------------------------------------------------------------------------*/
/*   Admin Notifications
/*-------------------------------------------------------------------------------*/
function easynotify_admin_bar_menu(){
            global $wp_admin_bar;

            /* Add the main siteadmin menu item */
                $wp_admin_bar->add_menu( array(
                    'id'     => 'enoty-upgrade-bar',
                    'href' => 'http://ghozylab.com/plugins/pricing/#tab-1408601400-2-44',
                    'parent' => 'top-secondary',
					'title' => __('<img src="'.plugins_url( 'images/enoty-cp-icon.png' , dirname(__FILE__) ).'" style="vertical-align:middle;margin-right:5px" alt="Upgrade Now!" title="Upgrade Now!" />Upgrade Easy Notify to PRO Version', 'easynotify' ),
                    'meta'   => array('class' => 'enoty-upgrade-to-pro', 'target' => '_blank' ),
                ) );
}
if ( enoty_get_option( 'easynotify_disen_admnotify' ) == '1' ) {
add_action( 'admin_bar_menu', 'easynotify_admin_bar_menu', 1000);
}


/*-------------------------------------------------------------------------------*/
/*  WordPress Pointers 
/*-------------------------------------------------------------------------------*/
add_action( 'admin_enqueue_scripts', 'easynotify_pointer_pointer_header' );
function easynotify_pointer_pointer_header() {
    $enqueue = false;

    $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    if ( ! in_array( 'easynotify_pointer_pointer', $dismissed ) ) {
        $enqueue = true;
        add_action( 'admin_print_footer_scripts', 'easynotify_pointer_footer' );
    }

    if ( $enqueue ) {
        // Enqueue pointers
        wp_enqueue_script( 'wp-pointer' );
        wp_enqueue_style( 'wp-pointer' );
    }
}

function easynotify_pointer_footer() {
    $pointer_content = '<h3>Thank You!</h3>';
	  $pointer_content .= '<p>You&#39;ve just installed '.ENOTIFY_NAME.' Version. Click on <img src="'.plugins_url( 'images/help.png' , dirname(__FILE__) ).'" width="22" height="22" > icon to get short tutorial and user guide plugin.</p><p>To close this notify permanently just click dismiss button below.</p>';
?>

<script type="text/javascript">// <![CDATA[
jQuery(document).ready(function($) {
	
if (typeof(jQuery().pointer) != 'undefined') {	
    $('#fornotify').pointer({
        content: '<?php echo $pointer_content; ?>',
        position: {
            edge: 'right',
            align: 'center'
        },
        close: function() {
            $.post( ajaxurl, {
                pointer: 'easynotify_pointer_pointer',
               action: 'dismiss-wp-pointer'
            });
        }
    }).pointer('open');
	
}

});
// ]]></script>
<?php
}


/*-------------------------------------------------------------------------------*/
/*   Comparison Page
/*-------------------------------------------------------------------------------*/
function easynotify_create_comparison_page() {
    $enoty_comparison_page = add_submenu_page('edit.php?post_type=easynotify', 'Comparison', __('UPGRADE to PRO', 'easynotify'), 'edit_posts', 'enoty_comparison', 'easynotify_comparison');
}
add_action( 'admin_menu', 'easynotify_create_comparison_page' );

function easynotify_put_compare_style() {
	if ( is_admin() && isset( $_GET['page'] ) && $_GET['page'] == 'enoty_comparison' ){
		wp_enqueue_style( 'enoty-comparison-css' );	
		wp_enqueue_script( 'enoty-comparison-js' );
		}
}
add_action( 'admin_enqueue_scripts', 'easynotify_put_compare_style' );

/*-------------------------------------------------------------------------------*/
/*   Generate Comparison Page
/*-------------------------------------------------------------------------------*/
function easynotify_comparison() {
?>

<!-- DC Pricing Tables:3 Start -->

    <div class="wrap">
        <div id="icon-edit" class="icon32"><br /></div>
        <h2><?php _e('Comparison', 'easynotify'); ?></h2>      
  <div class="tsc_pricingtable03 tsc_pt3_style1" style="margin-bottom:110px; height:600px;">
    <div class="caption_column">
      <ul>
        <li class="header_row_1 align_center radius5_topleft"></li>
        <li class="header_row_2" style="text-align: center;">
          <img style="display:inline-block; margin-right: 15px;" src="<?php echo plugins_url( 'images/logo.png' , dirname(__FILE__) ); ?>" width="60" height="60"/><h2 class="caption" style="display:inline-block; font-size: 25px; vertical-align:top; margin-top: 7px;">Easy Notify Lite</h2>
        </li> 
         <li class="row_style_2"><span>License</span></li>
         <li class="row_style_4"><span>Unlimited Notify</span></li>
         <li class="row_style_2"><span>Unlimited Colors</span></li>
         <li class="row_style_4"><span>Layouts</span></li>
         <li class="row_style_2"><span>Patterns</span></li>  
        <li class="row_style_4"><span>Basic Notify</span><a target="_blank" href="http://ghozylab.com/plugins/easy-notify-pro/demo/demo-basic-notify-and-a-simple-announcement/" style="text-decoration:underline !important;"> Click for Sample</a>&nbsp;&nbsp;<span class="newftr"></span></li>   
                      
        <li class="row_style_2"><span>Popup Opt-in ( Subscribe Form )</span><a target="_blank" href="http://ghozylab.com/plugins/easy-notify-pro/demo/popup-opt-in-subscribe-form/" style="text-decoration:underline !important;"> Click for Sample</a>&nbsp;&nbsp;<span class="newftr"></span></li>
        
        <li class="row_style_4"><span>Integrates with all major email marketing softwares</span><span class="newftr"></span></li>
        
        <li class="row_style_2"><span>Popup with Social Share Buttons</span><a target="_blank" href="http://ghozylab.com/plugins/easy-notify-pro/demo/demo-popup-with-social-share-buttons/" style="text-decoration:underline !important;"> Click for Sample</a></li>  
        
         <li class="row_style_4"><span>Popup with Custom Text & Button</span><a target="_blank" href="http://ghozylab.com/plugins/easy-notify-pro/demo/demo-popup-with-custom-text-button/" style="text-decoration:underline !important;"> Click for Sample</a></li>                     
         
        <li class="row_style_2"><span>Popup with Video</span><a target="_blank" href="http://ghozylab.com/plugins/easy-notify-pro/demo/demo-popup-with-video/" style="text-decoration:underline !important;"> Click for Sample</a>&nbsp;&nbsp;<span class="newftr"></span></li>
        
        <li class="row_style_4"><span>WP Multisite</span></li>
        <li class="row_style_2"><span>Support</span></li>
        <li class="row_style_4"><span>Update</span></li>
        <li class="footer_row"></li>
      </ul>
    </div>
    <div class="column_1">
      <ul>
        <li class="header_row_1 align_center">
          <h2 class="col1">Lite</h2>
        </li>
        <li class="header_row_2 align_center">
          <h1 class="col1">Free</h1>
        </li>
        <li class="row_style_3 align_center">None</li>
        <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_1 align_center">2</li>
        <li class="row_style_3 align_center">3</li>
        <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
		<li class="row_style_3 align_center"><span class="pricing_no"></span></li>        
        <li class="row_style_1 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_3 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_1 align_center"><span class="pricing_yes"></span></li>
         
        <li class="footer_row"></li>
      </ul>
    </div>
    
    <div class="column_2">
      <ul>
        <li class="header_row_1 align_center">
          <h2 class="col2">Pro</h2>
        </li>
        <li class="header_row_2 align_center">
          <h1 class="col2">$<span><?php echo ENOTY_PRO_PRICE; ?></span></h1>
        </li>
        <li class="row_style_4 align_center"><span style="font-weight: bold; color:#F77448; font-size:14px;">1 Site</span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center">6</li>
        <li class="row_style_4 align_center">18</li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
		<li class="row_style_4 align_center"><span class="pricing_yes"></span></li>        
        <li class="row_style_2 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_4 align_center"><span>1 Month</span></li>
        <li class="row_style_2 align_center"><span>1 Year</span></li>
        <li class="footer_row"><a target="_blank" href="http://ghozylab.com/plugins/ordernow.php?order=enotypro&utm_source=comparisonpage&utm_medium=pricingpage&utm_campaign=comparison" class="tsc_buttons2 red">Upgrade Now</a></li>
      </ul>
    </div>    
    
    <div class="column_2">
      <ul>
        <li class="header_row_1 align_center">
          <h2 class="col2">Pro+</h2>
        </li>
        <li class="header_row_2 align_center">
          <h1 class="col2">$<span><?php echo ENOTY_PRO_PLUS_PRICE; ?></span></h1>
        </li>
        <li class="row_style_4 align_center"><span style="font-weight: bold; color:#F77448; font-size:14px;">3 Sites</span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center">6</li>
        <li class="row_style_4 align_center">18</li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
		<li class="row_style_4 align_center"><span class="pricing_yes"></span></li>        
        <li class="row_style_2 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_4 align_center"><span>1 Month</span></li>
        <li class="row_style_2 align_center"><span>1 Year</span></li>
        <li class="footer_row"><a target="_blank" href="http://ghozylab.com/plugins/ordernow.php?order=enotyproplus&utm_source=comparisonpage&utm_medium=pricingpage&utm_campaign=comparison" class="tsc_buttons2 red">Upgrade Now</a></li>
      </ul>
    </div>
    <div class="column_2">
      <ul>
        <li class="header_row_1 align_center">
          <h2 class="col2">Pro++</h2>
        </li>
        <li class="header_row_2 align_center">
          <h1 class="col2">$<span><?php echo ENOTY_PRO_PLUS_PLUS_PRICE; ?></span></h1>
        </li>
        <li class="row_style_4 align_center"><span style="font-weight: bold; color:#F77448; font-size:14px;">5 Sites</span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center">6</li>
        <li class="row_style_4 align_center">18</li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_4 align_center"><span class="pricing_yes"></span></li>
        <li class="row_style_2 align_center"><span class="pricing_yes"></span></li>
		<li class="row_style_4 align_center"><span class="pricing_yes"></span></li>        
        <li class="row_style_2 align_center"><span class="pricing_no"></span></li>
        <li class="row_style_4 align_center"><span>1 Month</span></li>
        <li class="row_style_2 align_center"><span>1 Year</span></li>
        <li class="footer_row"><a target="_blank" href="http://ghozylab.com/plugins/ordernow.php?order=enotyproplusplus&utm_source=comparisonpage&utm_medium=pricingpage&utm_campaign=comparison" class="tsc_buttons2 red">Upgrade Now</a></li>
      </ul>
    </div>    

    </div>
  </div>
<!-- DC Pricing Tables:3 End -->
<div class="tsc_clear"></div> <!-- line break/clear line -->

<?php
}
	 
?>