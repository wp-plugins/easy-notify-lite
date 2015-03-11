<?php


/*-----------------------------------------------------------------------------------*/
/*  Featured Image Meta
/*-----------------------------------------------------------------------------------*/
function easynotify_customposttype_image_box() {
	remove_meta_box( 'postimagediv', 'easynotify', 'side' );
	if ( enoty_get_option( 'easynotify_disen_admnotify' ) == '1' ) {
			add_meta_box( 'notybuydiv', __( 'Upgrade to Pro Version' ), 'easynotify_upgrade_metabox', 'easynotify', 'side', 'default' );
		}
	add_meta_box( 'notyrevdiv', __( 'Preview' ), 'easynotify_preview_metabox', 'easynotify', 'side', 'default' );
	add_meta_box( 'notynewdiv', __( 'New Plugin' ), 'easynotify_new_plug_metabox', 'easynotify', 'side', 'default' );


}
add_action( 'do_meta_boxes', 'easynotify_customposttype_image_box' );


/*-----------------------------------------------------------------------------------*/
/*	META CORE
/*-----------------------------------------------------------------------------------*/

	
	add_action( "admin_head", 'easynotify_admin_head_script' );
	add_action( 'admin_enqueue_scripts', 'easynotify_load_script', 10, 1 );
	

			function easynotify_load_script() {

    			if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {
					
        			if ( get_post_type( get_the_ID() ) == 'easynotify' ) {
					
					wp_enqueue_style( 'enoty-sldr' );	
					wp_enqueue_style( 'enoty-colorpicker' );		
					wp_enqueue_script( 'enoty-colorpickerjs' );
					wp_enqueue_script( 'enoty-cookie' );	
					wp_enqueue_script( 'jquery-ui-slider' );
					wp_enqueue_script( 'jquery-effects-highlight' );
					wp_enqueue_style( 'enoty-bootstrap-css' );		
					wp_enqueue_script( 'enoty-bootstrap-js' );
					wp_enqueue_style( 'enoty-admin-styles', plugins_url('css/admin.css' , __FILE__ ) );
					wp_enqueue_script( 'enoty-metascript', plugins_url( 'functions/easynotify-script.js' , __FILE__ ) );
					wp_enqueue_script( 'enoty-ibutton-js', plugins_url( 'js/jquery/jquery.ibutton.js' , __FILE__ ) );
					wp_enqueue_style( 'enoty-ibutton-css', plugins_url( 'css/ibutton.css' , __FILE__ ), false, ENOTIFY_VERSION );
					
					add_action('admin_footer', 'enoty_upgrade_popup' );
					
						}
					}
				}

			function easynotify_admin_head_script () {

    			if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {
					
        			if ( get_post_type( get_the_ID() ) == 'easynotify' ) {
					
					?>
                    
                     <style type="text/css" media="screen">
					 #minor-publishing {display: none !important }
		@media only screen and (min-width: 1150px) {	
		    #side-sortables.fixed { position: fixed; top: 55px; right: 20px; width: 280px; }
		}	
		</style>
		<script>
		jQuery(document).ready(function($) {
			
			 // Upgrade Popup
 			$('#notifyprcngtableclr').on( 'click', function() {
				
				$("#myModalupgrade").modal({
					keyboard: false,
					backdrop: 'static'
					});
					return false;
					
				});	
			

			
		// Help Control	
		jQuery('.helpicon').bind('click', function() {

			var plugurl = '<?php echo ENOTIFY_URL; ?>/inc/help/';
			var filetoload = jQuery(this).data('toload');
			var ppwidth = jQuery(this).data('ppw');
			var ppheight = jQuery(this).data('pph');
			
			var newwindow = window.open(plugurl+filetoload, '', 'width='+ppwidth+',height='+ppheight+',scrollbars=1');
				if (window.focus) {
					newwindow.focus();
					}
		
				return false;
			});
			
		    var snpprevPosition = $('#side-sortables').offset();
		    $(window).scroll(function(){
			    if($(window).scrollTop() > snpprevPosition.top)
			    {
				$('#side-sortables').addClass('fixed');
			    } 
			    else 
			    {
				$('#side-sortables').removeClass('fixed');
			    }    
		    });
			
	function enoty_gradient(hex, lum) {
				// validate hex string
				hex = String(hex).replace(/[^0-9a-f]/gi, '');
				if (hex.length < 6) {
					hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
				}
				lum = lum || 0;
				// convert to decimal and change luminosity
				var rgb = "#", c, i;
				for (i = 0; i < 3; i++) {
					c = parseInt(hex.substr(i*2,2), 16);
					c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
					rgb += ("00"+c).substr(c.length);
				}
				return rgb;
			}
			
			jQuery('.button_color_calc').bind('click', function() {
				var cfrm = '#' + jQuery(this).prev().prev().prev('input').attr('id');
				var cto = '#' + jQuery(this).prev('input').attr('id');
				var divfrm = '#' + jQuery(this).prev().prev().prev().prev('div').attr('id');
				var divto = '#' + jQuery(this).prev().prev('div').attr('id');
				
				jQuery(''+cto+'').val(enoty_gradient(jQuery(''+cfrm+'').val(), -0.3));
				jQuery(''+divfrm+'').children('div').css('background-color', jQuery(''+cfrm+'').val());
				jQuery(''+divto+'').children('div').css('background-color', jQuery(''+cto+'').val());
				jQuery(''+cto+'').keyup();
			});
			
			jQuery("#preview-notify").click(function(){
				jQuery("#post").attr("target","_blank");
				jQuery("#post").attr("action","admin-ajax.php");
				jQuery("#hiddenaction").val("easynotify_generate_preview");
				jQuery("#originalaction").val("easynotify_generate_preview");
				jQuery("<input>").attr("type","hidden").attr("name","action").attr("id","easynotify_preview").val("easynotify_generate_preview").appendTo("#post");
				jQuery("#post").submit();
				jQuery("#post").attr("target","");
				jQuery("#post").attr("action","post.php");
				jQuery("#hiddenaction").val("editpost");
				jQuery("#easynotify_preview").remove();
				jQuery("#originalaction").val("editpost");
				});
			
		});
		</script>
        
            <script type="text/javascript">
			/*<![CDATA[*/
			jQuery(document).ready(function($) {
				jQuery('#wp-enoty_cp_maincontent-media-buttons a').not('#insert-media-button').hide();	

				jQuery(document).on( 'scroll', function(){
					if (jQuery(window).scrollTop() > 700) {
						jQuery('.enoty-scroll-top-wrapper').addClass('show');
						} else {
							jQuery('.enoty-scroll-top-wrapper').removeClass('show');
							}
					});
 
    			jQuery('.enoty-scroll-top-wrapper').on('click', scrollToTop);
			
				});
  	/*]]>*/
		</script>  
                    
                    <?php

						}
					}
				}


/**
 * Add a custom Meta Box
 *
 * @param array $enotymeta_box Meta box input data
 */
 
function enoty_add_meta_box( $enotymeta_box )
{
    if ( !is_array( $enotymeta_box ) ) return false;
    
    // Create a callback function
    $callback = create_function( '$post,$enotymeta_box', 'enoty_create_meta_box( $post, $enotymeta_box["args"] );' );
    add_meta_box( $enotymeta_box['id'], $enotymeta_box['title'], $callback, $enotymeta_box['page'], $enotymeta_box['context'], $enotymeta_box['priority'], $enotymeta_box );
}

/**
 * Create content for a custom Meta Box
 *
 * @param array $enotymeta_box Meta box input data
 */
function enoty_create_meta_box( $post, $enotymeta_box )
{
	if ( NOTY_WP_VER == "l35" ) {
		$uploaderclass = 'thickbox button add_media';
		$notyhref = "media-upload.php?type=image&TB_iframe=1";
		$isdatacnt = ' data-editor="content" ';
		$notyepver = NOTY_WP_VER;
			} else {
				$uploaderclass = 'button';
				$notyhref = "#";
				$isdatacnt = '';
				$notyepver = NOTY_WP_VER;
					}	
					
	echo '<div class="enoty-scroll-top-wrapper">
    		<span class="enoty-scroll-top-inner">
        		<i class="enotyfa"></i>
    			</span>
			</div>';
	
    if ( !is_array( $enotymeta_box ) ) return false;
    
    if ( isset( $enotymeta_box['description'] ) && $enotymeta_box['description'] != '' ){
    	echo '<p>'. $enotymeta_box['description'] .'</p>';
    }
    
	wp_nonce_field( basename( __FILE__ ), 'enoty_meta_box_nonce' );
	echo '<table class="form-table enoty-metabox-table">';
 
	foreach ( $enotymeta_box['fields'] as $field ){
		// Get current post meta data
		$meta = get_post_meta( $post->ID, $field['id'], true );
		
		echo '<tr class="'. $field['id'] .' '. ( isset ( $field['onefunc'] ) ? $field['onefunc'] : '' ) .' '. ( isset ( $field['ispro'] ) ? $field['ispro'] : '' ) .'"><th><label for="'. $field['id'] .'"><strong>'. $field['name'] .'<br></strong><span>'. $field['desc'] .'</span></label></th>';
		
		switch( $field['type'] ){	
			case 'text':
				echo '<td><input type="text" name="enoty_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['std']) .'" size="30" /></td>';
				break;	
				
			case 'shorttext':
				echo '<td><input style="width:43px !important;" type="text" name="enoty_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['std']) .'"/>'.$field['aftr'].'
				<br><br><input id="notify-'.$post->ID.'" class="button" type="button" value="Clear this Notify Cookie"></input></td>';
				
				?>
                <script type="text/javascript">
				jQuery(document).ready(function($) { 
					jQuery('#<?php echo 'notify-'.$post->ID; ?>').click(function() {
						jQuery.removeCookie('<?php echo 'notify-'.$post->ID; ?>', { path: '/' }); 
						alert("Successfully cleared this Notify cookies!");						
						});
                
				    });
                    </script>
				<?php
				
				break;	
				
			case 'textarea':
				echo '<td><textarea name="enoty_meta['. $field['id'] .']" id="'. $field['id'] .'" rows="10" cols="5">'. ($meta ? $meta : $field['std']) .'</textarea></td>';
				break;
				
			case 'wpeditor':	
			echo '<td>';			
				wp_editor( ($meta ? $meta : $field['std']) , $field['id'], array(
				'textarea_name' => 'enoty_meta['. $field['id'] .']',
				'media_buttons' => true,
				'textarea_rows' => 11,
				'wpautop' => true
				 ) );
				 echo '</td>';
				break;	

			case 'theshortcode':
				echo '<td><input type="hidden" name="enoty_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['std']) .'"/><span class="enoty-sc-metabox">'. ($meta ? $meta : $field['std']) .'</span></td>';
				break;				
				
			case 'checkboxopt':
			
			    echo '<td>';
			   	$checked = '';
				$checked = get_post_meta($post->ID, $field['id'].'_swc', true);
                if ( $checked ) {
                    if ( $checked == 'on' ) { $checked = ' checked="checked"';
					
					echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#'.$field['elid'].'").show("slow");
    });
    </script>'; }
	
		else {
		
	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#'.$field['elid'].'").hide("slow");
    });
    </script>';
	}
                } else {
						echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#'.$field['elid'].'").hide("slow");
    });
    </script>';
					
                    if ( $field['io'] == 'on' ) { $checked = ' checked="checked"';
					
	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#'.$field['elid'].'").show("slow");
    });
    </script>';
					}
	else {	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#'.$field['elid'].'").hide("slow");
    });
    </script>';
	}
                }

                echo '<div><input type="hidden" name="enoty_meta['. $field['id'] .'_swc]" value="off" />
                <input class="enotyswitch" type="checkbox" id="'. $field['id'] .'" name="enoty_meta['. $field['id'] .'_swc]" value="on" '. $checked .' /></div>
			<div id="'.$field['elid'].'" style="border-top: 1px solid #ccc; padding-top: 10px; margin-top:10px;">
				 	Custom size : <div style="margin-top:10px; margin-bottom:10px;"><strong>Width</strong> <input style="margin-right:5px !important; margin-left:3px; width:43px !important; float:none !important;" name="enoty_meta['. $field['id'] .'_'.$field['width'].']" id="'. $field['id'] .'[width]" type="text" value="' .(get_post_meta($post->ID, 'enoty_cp_thumbsize_'. $field['width'] .'', true) ? get_post_meta($post->ID, 'enoty_cp_thumbsize_'. $field['width'] .'', true) : $field['stdw']).'" />  ' .$field['pixopr']. '



<span style="border-right:solid 1px #CCC;margin-left:9px; margin-right:10px !important; "></span>

 	<strong>Height</strong> <input style="margin-left:3px; margin-right:5px !important; width:43px !important; float:none !important;" name="enoty_meta['. $field['id'] .'_'.$field['height'].']" id="'. $field['id'] .'[height]" type="text" value="' .(get_post_meta($post->ID, 'enoty_cp_thumbsize_'. $field['height'] .'', true) ? get_post_meta($post->ID, 'enoty_cp_thumbsize_'. $field['height'] .'', true) : $field['stdh']).'" /> ' .$field['pixopr']. ' </div></div>

				';
			    echo '</td>';
			    break;				
				
	
				
			case 'checkboxoptdef':
			    echo '<td>';
			    $val = '';
                if ( $meta ) {
                    if ( $meta == 'on' ) { $val = ' checked="checked"';
					}
                } else {

                    if ( $field['std'] == 'on' ) { $val = ' checked="checked"';
					}
                }

                echo '<div><input type="hidden" name="enoty_meta['. $field['id'] .']" value="off" />
                <input class="enotyswitch" type="checkbox" id="'. $field['id'] .'" name="enoty_meta['. $field['id'] .']" value="on" '. $val .' /></div>
				';
			    echo '</td>';
			    break;				
		
			case 'select':
				echo'<td><select class="chosen-select" style="width:300px;" name="enoty_meta['. $field['id'] .']" id="'. $field['id'] .'">';
				foreach ( $field['options'] as $key => $option ){
					echo '<option value="' . $key . '"';

						if ( $meta ){
							if ( $meta == $key ) echo ' selected="selected"'; 
							} else {
								if ( $field['std'] == $key ) echo ' selected="selected"';
								}
					
					echo'>'. $option .'</option>';
				}
				echo'</select></td>';
				
				if ( $field['id'] == 'enoty_cp_ribbon_container' ) { ?>
				
	<script type="text/javascript">
       jQuery(document).ready(function($) { 
	   		ribbonrelayout('<?php echo ($meta ? $meta : $field['std']);?>');
			});
    </script> 
    
    <?php }
				break;								
				

			case 'radio':
				echo '<td>';
				
				if ( easynotify_check_browser_version_admin( get_the_ID() ) != 'ie8' ) {
					foreach ( $field['options'] as $key => $option ){
						echo '<input id="'. $key .'" type="radio" name="enoty_meta['. $field['id'] .']" value="'. $key .'" class="css-checkbox"';
						if ( $meta ){
							if ( $meta == $key ) echo ' checked="checked"'; 
							} else {
								if ( $field['std'] == $key ) echo ' checked="checked"';
								}
								echo ' /><label for="'. $key .'" class="css-label">'. $option .'</label> ';
								}
							}
							
				else {
					foreach ( $field['options'] as $key => $option ){
						echo '<label class="radio-label"><input type="radio" name="enoty_meta['. $field['id'] .']" value="'. $key .'" class="radio"';
						if ( $meta ){
							if ( $meta == $key ) echo ' checked="checked"';
							} else {
								if ( $field['std'] == $key ) echo ' checked="checked"';
								}
								echo ' /> '. $option .'</label> ';
								}
							}							
												
				echo '</td>';
				
				break;
			
			case 'color':

			
				?>
				  <script type="text/javascript">
				  /*<![CDATA[*/
				  
				 jQuery(document).ready(function($) { 
				  
				 jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '<?php echo ($meta ? $meta : $field['std']); ?>');    
				 jQuery('#<?php echo $field['id']; ?>_picker').ColorPicker({
					color: '<?php echo ($meta ? $meta : $field['std']); ?>',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						//jQuery(this).css('border','1px solid red');
						jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '#' + hex);						
						jQuery('#<?php echo $field['id']; ?>_picker').next('input').attr('value','#' + hex);
					}
				  });
				  
				  });				

				  /*]]>*/
                  </script>   
                
                <?php
			

			    echo '<td>';
				echo'<div id="'. $field['id'] .'_picker" class="colorSelector"><div></div></div>
				<input style="margin-left:10px; width:75px !important;" name="enoty_meta['. $field['id'] .']" id="'. $field['id'] .'" type="text" value="'.($meta ? $meta : $field['std']).'" />';
                echo '</td>';
			    break;
				
				
			case 'typo':
				?>
				  <script type="text/javascript">
				  /*<![CDATA[*/
				  
				 jQuery(document).ready(function($) { 
				  
				 jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '<?php echo (get_post_meta($post->ID, $field['id'].'_'. $field['color'] .'', true) ? get_post_meta($post->ID, $field['id'].'_'. $field['color'], true) : $field['stcol']); ?>');    
				 jQuery('#<?php echo $field['id']; ?>_picker').ColorPicker({
					color: '<?php echo (get_post_meta($post->ID, $field['id'].'_'. $field['color'], true) ? get_post_meta($post->ID, $field['id'].'_'. $field['color'], true) : $field['stcol']); ?>',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						//jQuery(this).css('border','1px solid red');
						jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '#' + hex);						
						jQuery('#<?php echo $field['id']; ?>_picker').next('input').attr('value','#' + hex);
					}
				  });
				  
				  });				

				  /*]]>*/
                  </script>   
                
                <?php

			    echo '<td>';
				
				echo'<select class="eselect" style="float: left !important; width:65px; margin-right:10px;" name="enoty_meta['. $field['id'] .'_'.$field['font'].']" id="'. $field['id'] .'[font]">';
					
				$fonts = array();
				foreach (range(10, 72) as $i) {
						$fonts[$i.'px'] = $i.'px';
					}					
				
				foreach ($fonts as $key => $option) {
					echo '<option value="' . $key . '"';
					$defmeta = $field['stf'];
					if ( get_post_meta($post->ID, $field['id'].'_'. $field['font'], true) ){ 
						if ( get_post_meta($post->ID, $field['id'].'_'. $field['font'], true) == $key ) echo ' selected="selected"'; 
					} else {
							if ( $defmeta == $key ) echo ' selected="selected"'; 	
						}
					echo'>'. $option .'</option>';
				}
				echo'</select>';
				
				echo'<div id="'. $field['id'] .'_picker" class="colorSelector" style="display:inline-block !important;"><div></div></div>
				<input style="margin-left:10px; width:75px !important;" name="enoty_meta['. $field['id'] .'_'.$field['color'].']" id="'. $field['id'] .'[color]" type="text" value="'.(get_post_meta($post->ID, $field['id'].'_'. $field['color'], true) ? get_post_meta($post->ID, $field['id'].'_'. $field['color'], true) : $field['stcol']).'" />';
                echo '</td>';
			    break;							


			case 'checkbox':
			    echo '<td>';
			    $val = '';
                if ( $meta ) {
                    if ( $meta == 'on' ) $val = ' checked="checked"';
                } else {
                    if ( $field['std'] == 'on' ) $val = ' checked="checked"';
                }

                echo '<input type="hidden" name="enoty_meta['. $field['id'] .']" value="off" />
                <input class="switch" type="checkbox" id="'. $field['id'] .'" name="enoty_meta['. $field['id'] .']" value="on"'. $val .' /> ';
			    echo '</td>';
			    break;	
	
	
	
			case 'bullet':
			    echo '<td>';
				
				
			    $checked = '';
				$checked = get_post_meta($post->ID, $field['id'].'_swc', true);
                if ( $checked ) {
                    if ( $checked == 'on' ) { $checked = ' checked="checked"';
					
					echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#'.$field['elid'].'").show("slow");
    });
    </script>'; }
	
		else {
		
	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#'.$field['elid'].'").hide("slow");
    });
    </script>';
	}
                } else {
						echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#'.$field['elid'].'").hide("slow");
    });
    </script>';
					
                    if ( $field['io'] == 'on' ) { $checked = ' checked="checked"';
					
	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#'.$field['elid'].'").show("slow");
    });
    </script>';
					}
	else {	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#'.$field['elid'].'").hide("slow");
    });
    </script>';
	}
                }
	echo'<div><input type="hidden" name="enoty_meta['. $field['id'] .'_swc]" value="off" />
                <input class="enotyswitch" type="checkbox" id="'. $field['id'] .'" name="enoty_meta['. $field['id'] .'_swc]" value="on" '. $checked .' /></div>';
    echo '<div id="'.$field['elid'].'" style="border-top: 1px solid #ccc; padding-top: 10px; margin-top:10px;"><ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';		
    $i = 0;
    if ($meta) {
        foreach($meta as $row) {
            echo '<li><span class="thesort"></span><input style="width:395px !important;" type="text" name="enoty_meta['.$field['id'].']['.$i.']" id="'.$field['id'].'" value="'.($row ? $row : $field['std']).'" size="30" /><span class="repeatableremove"></span></li>';
            $i++;
		} 
    } else {
        foreach($field['std'] as $row) {
            echo '<li><span class="thesort"></span><input style="width:395px !important;" type="text" name="enoty_meta['.$field['id'].']['.$i.']" id="'.$field['id'].'" value="'.($row ? $row : '').'" size="30" /><span class="repeatableremove"></span></li>';
            $i++;
		} 
    }
    echo '</ul>';
	echo '<a class="repeatable-add button" href="#">Add New</a></td></div>';
				
?>

    <script type="text/javascript">
       jQuery(document).ready(function($) { 
			var vcnt; 
jQuery('.repeatable-add').click(function() {
    field = jQuery(this).closest('td').find('.custom_repeatable li:last').clone(true);
    fieldLocation = jQuery(this).closest('td').find('.custom_repeatable li:last');
    jQuery('input', field).val('').attr('name', function(index, name) {
				return name.replace(/(\d+)/, function(fullMatch, n) {
					vcnt = n;
					return Number(n) + 1;	
       		 		});
				
    	})
			
		if ( vcnt >= 2 ) {
			alert('You have to upgrade to PRO Version to add more bullet.');
			return false;
			} else {
    			field.insertAfter(fieldLocation, jQuery(this).closest('td'));
				field.hide().fadeIn('slow');
				}
    return false;
});

 
jQuery('.repeatableremove').click(function(){
	jQuery(this).parent().fadeOut(500, function() { jQuery(this).remove();});
    return false;
});
     
jQuery('.custom_repeatable').sortable({
    opacity: 0.6,
    revert: true,
    cursor: 'move',
    handle: '.thesort'
});


        });
    </script>

<?php
				
			    break;	
				
				
			case 'images': 
			
$dsplynone = 'display:none;';				
if ( $meta ) {
	$notyimage = get_post_meta( $post->ID, 'enoty_cp_img', true );
    $dsply = 'display:;';
	} else {
		$notyimage = ENOTIFY_URL.'/inc/images/default-image.png';
		$dsply = 'display:;';
	}

echo '<td id="imgupld"><input id="notify_image" type="text" name="enoty_meta['. $field['id'] .']" value="'. ($meta ? $meta : $field['std']) .'"/><div id"notycontrolcon"><div class="addimage"><a rel="image-'.$notyepver.'" class="' . $uploaderclass . '" title="Add Image" '.$isdatacnt.' href="'.$notyhref.'"><span class="enoty-media-buttons-icon"></span>Add Image</a></div>
<div class="delimage"><a data-img="'.ENOTIFY_URL.'/inc/images/no_image_available.png'.'" onClick="return false;" style="'. $dsply .'" class="deleteimage button" title="Delete Image" href="#"><span class="enoty-media-buttons-icon-del"></span>Delete Image</a></div></div>
<div id="enotyimgpreviewbox" class="enotyimgpreviewbox">
<img id="imgthumbnailprv" src="' . $notyimage . '"/>
</div>
</td>';
			    break;	
				
				
			case 'pattern': 
			echo '<td>';				
		?>		
    <input type="hidden" value="<?php if ( $meta != "") { echo $meta; } else { echo $field['std']; } ?>" name="enoty_meta[<?php echo $field['id']; ?>]" id="<?php echo $field['id']; ?>" />
    
    <div class="enoty_pattern_box">
    
                	<!--<div style="float: left;" class="enoty_pattern_overlay <?php //if (!$field['id'] || $field['id'] == 'none') {echo 'enoty_pattern_selected';} ?>" id="no_pattern"> no pattern </div>-->
    
                <?php 
				foreach ( easynotify_get_list('patterns') as $pattern ) {
					($pattern == $field['std']) ? $defpat = 'defaultpattern' : $defpat = '';
					($meta == $pattern) ? $sel = 'enoty_pattern_selected' : $sel = '';  
					echo '<div class="enoty_pattern_overlay '.$sel.' '.$defpat.'" id="'.$pattern.'" style="background: url('.plugins_url( 'css/images/patterns/' , dirname(__FILE__) ).$pattern.') repeat top left transparent;"></div>';	
					
				}
				?>
                </div> 
      <script type="text/javascript">
       jQuery(document).ready(function($) { 
	    <?php if ( $meta == '') { echo "jQuery('.defaultpattern').addClass('enoty_pattern_selected'); "; } ?>               
 	jQuery('.enoty_pattern_overlay').on('click', function() {
		var pattern = jQuery(this).attr('id');
		jQuery('.enoty_pattern_overlay').removeClass('enoty_pattern_selected');
		jQuery(this).addClass('enoty_pattern_selected'); 
		jQuery('#enoty_cp_pattern').val(pattern);
	});		               
                
          });
    </script>                    				
				<?php	
				echo '</td>';
				
				break;
				
				
			case 'layoutmode': 
			echo '<td>';				
		?>		
    <input type="hidden" value="<?php if ( $meta != "") { echo $meta; } else { echo $field['std']; } ?>" name="enoty_meta[<?php echo $field['id']; ?>]" id="<?php echo $field['id']; ?>" />
    
    <div class="enoty_layout_box">
    
                	<!--<div style="float: left;" class="enoty_layout_overlay <?php //if (!$field['id'] || $field['id'] == 'none') {echo 'enoty_layout_selected';} ?>" id="no_layout"> no layout </div>-->
    
                <?php 
				foreach ( easynotify_get_list('layouts') as $layout ) {
					($layout == $field['std']) ? $deflay = 'defaultlayout' : $deflay = '';
					($meta == $layout) ? $sel = 'enoty_layout_selected' : $sel = '';  
					echo '<div class="enoty_layout_overlay '.$sel.' '.$deflay.'" id="'.$layout.'" style="background: url('.plugins_url( 'css/images/layouts/' , dirname(__FILE__) ).$layout.') repeat top left transparent;"></div>';	
					
				}
				?>
                </div> 
      <script type="text/javascript">
       jQuery(document).ready(function($) { 
	   notyLayoutctrl('<?php echo ($meta ? $meta : $field['std']);?>');  
	   <?php if ( $meta == '') { echo "jQuery('.defaultlayout').addClass('enoty_layout_selected'); "; } ?>             
 	jQuery('.enoty_layout_overlay').on('click', function() {
		if ( jQuery(this).index() <= 1 ) {
			var layout = jQuery(this).attr('id');
			jQuery('.enoty_layout_overlay').removeClass('enoty_layout_selected');
			jQuery(this).addClass('enoty_layout_selected');
			jQuery('#enoty_cp_layoutmode').val(layout);
			notyLayoutctrl(layout);
		} else {
			alert('You have to upgrade to Pro Version to use this layout.');
			return false;	
			}
	});		               
                
          });
    </script>                    	 
                       				
				<?php	
				echo '</td>';
				
				break;	
				
				
			case 'slider': 
			echo '<td>';
	?>	
    
				  <script type="text/javascript">
				  /*<![CDATA[*/
				  
				 jQuery(document).ready(function($) { 
				  
/* Slider init */
		jQuery(function() {
	
        jQuery( '#<?php echo $field['id']; ?>_slider' ).slider({
            range: 'min',
            min: <?php echo $field['min']; ?>,
            max: <?php echo $field['max']; ?>,
			<?php if ( $field['usestep'] == '1' ) { ?>
			step: <?php echo $field['step']; ?>,
			<?php } ?>
            value: '<?php if ( $meta != "") { echo $meta; } else { echo $field['std']; } ?>',
            slide: function( event, ui ) {
                jQuery( "#<?php echo $field['id']; ?>" ).val( ui.value );
            	}
        	});
		});
				  
				  });				

				  /*]]>*/
                  </script>   
    
    <div class="eno_metaslider"><div id="<?php echo $field['id']; ?>_slider" ></div><input style="margin-left:10px; margin-right:5px !important; width:40px !important;" name="enoty_meta[<?php echo $field['id']; ?>]" id="<?php echo $field['id']; ?>" type="text" value="<?php if ( $meta != "") { echo $meta; } else { echo $field['std']; } ?>" /><?php echo $field['pixopr']; ?></div> 
  
                <?php
			

				echo '</td>';
			    break;	
				
				
			case 'gradient':

			
				?>
				  <script type="text/javascript">
				  /*<![CDATA[*/
				  
				 jQuery(document).ready(function($) { 
				  
		  
				  
				  
				 jQuery('#<?php echo $field['id']; ?>_<?php echo $field['from'];?>_picker').children('div').css('backgroundColor', '<?php echo (get_post_meta($post->ID, $field['id'].'_'. $field['from'], true) ? get_post_meta($post->ID, $field['id'].'_'. $field['from'], true) : $field['stdfrom']); ?>');    
				 jQuery('#<?php echo $field['id']; ?>_<?php echo $field['from'];?>_picker').ColorPicker({
					color: '<?php echo (get_post_meta($post->ID, $field['id'].'_'. $field['from'], true) ? get_post_meta($post->ID, $field['id'].'_'. $field['from'], true) : $field['stdfrom']); ?>',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						//jQuery(this).css('border','1px solid red');
						jQuery('#<?php echo $field['id']; ?>_<?php echo $field['from'];?>_picker').children('div').css('backgroundColor', '#' + hex);						
						jQuery('#<?php echo $field['id']; ?>_<?php echo $field['from'];?>_picker').next('input').attr('value','#' + hex);
					}
				  });
				  
				  
				 jQuery('#<?php echo $field['id']; ?>_<?php echo $field['to'];?>_picker').children('div').css('backgroundColor', '<?php echo (get_post_meta($post->ID, $field['id'].'_'. $field['to'], true) ? get_post_meta($post->ID, $field['id'].'_'. $field['to'], true) : $field['stdto']); ?>');    
				 jQuery('#<?php echo $field['id']; ?>_<?php echo $field['to'];?>_picker').ColorPicker({
					color: '<?php echo (get_post_meta($post->ID, $field['id'].'_'. $field['to'], true) ? get_post_meta($post->ID, $field['id'].'_'. $field['to'], true) : $field['stdto']); ?>',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						//jQuery(this).css('border','1px solid red');
						jQuery('#<?php echo $field['id']; ?>_<?php echo $field['to'];?>_picker').children('div').css('backgroundColor', '#' + hex);						
						jQuery('#<?php echo $field['id']; ?>_<?php echo $field['to'];?>_picker').next('input').attr('value','#' + hex);
					}
				  });
				  
				  
				  
				  });				

				  /*]]>*/
                  </script>   
                
                <?php
			

			    echo '<td>';
				echo'<div id="'.$field['id'].'_'.$field['from'].'_picker" class="colorSelector" style="top: 7px !important;"><div></div></div>
				<input style="margin-left:10px; width:75px !important;" name="enoty_meta['. $field['id'] .'_'.$field['from'].']" id="'. $field['id'].$field['from'].'" type="text" value="'.(get_post_meta($post->ID, $field['id'].'_'.$field['from'], true) ? get_post_meta($post->ID, $field['id'].'_'. $field['from'], true) : $field['stdfrom']).'" /> to<div id="'.$field['id'].'_'.$field['to'].'_picker" class="colorSelector" style="float:none !important; top: 7px !important; margin-left: 20px !important;"><div></div></div>
				<input style="margin-left:10px; width:75px !important;" name="enoty_meta['.$field['id'] .'_'.$field['to'].']" id="'. $field['id'] .$field['to'].'" type="text" value="'.(get_post_meta($post->ID, $field['id'].'_'. $field['to'], true) ? get_post_meta($post->ID, $field['id'].'_'. $field['to'], true) : $field['stdto']).'" /><input class="button button_color_calc" type="button" value="Generate Gradient" style="margin-top: 7px;"></input>';
                echo '</td>';
			    break;
		
						
		}
		
		echo '</tr>';
	}
 
	echo '</table>';
}

/*-----------------------------------------------------------------------------------*/
/*	Register related Scripts and Styles
/*-----------------------------------------------------------------------------------*/

	// SELECT MEDIA METABOX
add_action( 'add_meta_boxes', 'enoty_metabox_work' );
function enoty_metabox_work(){

	//  Settings Panel METABOX
	    $enotymeta_box = array(
		'id' => 'enoty_metaboxmediacp',
		'title' =>  __( 'Notify Content', 'easynotify' ),
		'description' => __( 'With this options, you can customizing the look and feel of your Notify to fit your needs.<span class="enotystepone"></span>', 'easynotify' ),
		'page' => 'easynotify',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
		
		
			array(
					'name' => __( 'Layout Mode<span data-ppw="940" data-pph="500" data-toload="layoutmode.html" class="helpicon" id="fornotify"></span>', 'easynotify' ),
					'desc' => __( 'Please choose notify layout to fit your needs.', 'easynotify' ),
					'id' => 'enoty_cp_layoutmode',
					'type' => 'layoutmode',
					'std' => 'head_img_txt_list.png',
				 ),			
		
		
			array(
					'name' => __( 'Notify Size', 'easynotify' ),
					'desc' => __( 'Use this option to set custom width and height of Notify, or you can use the default setting. Width : 740px and height : auto', 'easynotify' ),
					'id' => 'enoty_cp_thumbsize',
					'type' => 'checkboxopt',
					'elid' => 'thumbsz',
					'width' => 'tw',
					'height' => 'th',
					'stdw' => '740',
					'stdh' => 'auto',					
					"pixopr" => 'px',
					'io' => 'on',
					'onefunc' => 'onefuncnsize',
					),	
						
			array(
					'name' => __( 'Text Header<span data-ppw="550" data-pph="570" data-toload="header.html" class="helpicon"></span>', 'easynotify' ),
					'desc' => __( 'Set your header text here. For best result the maximum number of characters is 25.', 'easynotify' ),
					'id' => 'enoty_cp_header_text',
					'type' => 'text',
					'onefunc' => 'onefunc',
					'std' => 'I am Header, You Can Change Me as You Wish'
					),			
		
			array(
					'name' => __( 'Header Font Size and Color', 'easynotify' ),
					'desc' => __( 'You can change the font size and color here. Default size: 20px and font color : #f28613', 'easynotify' ),
					'id' => 'enoty_cp_header_text_size_col',
					'type' => 'typo',				
					'color' => 'clr',
					'font' => 'fnt',
					'onefunc' => 'onefunc',
					'stf' => '20px',
					'stcol' => '#f28613',
					),
					
			array(
					'name' => __( 'Header Background Color', 'easynotify' ),
					'desc' => __( 'Set your header background color. Default: #2e2e2e', 'easynotify' ),
					'id' => 'enoty_cp_header_back_col',
					'type' => 'color',
					'onefunc' => 'onefunc',
					'std' => '#2e2e2e'
					),	
							
			array(
					'name' => __( 'Main Text<span data-ppw="550" data-pph="570" data-toload="maintext.html" class="helpicon"></span>', 'easynotify' ),
					'desc' => __( 'Set your main text here. You can use to describe your product, etc.', 'easynotify' ),
					'id' => 'enoty_cp_maincontent',
					'type' => 'wpeditor',
					'onefunc' => 'onefunctext',
					'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam vestibulum quis diam non sagittis. Aliquam posuere, mauris non tincidunt tincidunt, ante felis tincidunt enim, dapibus eleifend erat felis pulvinar orci. Nam mattis risus ut eros congue varius. Morbi vulputate ligula augue, et auctor ipsum euismod sed.'
					),
					
			array(
					'name' => __( 'Main Text Font Size and Color', 'easynotify' ),
					'desc' => __( 'You can change the font size and color here. Default size: 14px and font color : #a1a1a1', 'easynotify' ),
					'id' => 'enoty_cp_main_text_size_col',
					'type' => 'typo',				
					'color' => 'clr',
					'font' => 'fnt',
					'stf' => '14px',
					'stcol' => '#a1a1a1',
					'onefunc' => 'onefunctext',
					),	
					
			array(
					'name' => __( 'Video Embed Code', 'easynotify' ),
					'desc' => __( 'Copy video embed code from Youtube or Vimeo and paste to this field.', 'easynotify' ),
					'id' => 'enoty_cp_video',
					'type' => 'textarea',
					'onefunc' => 'onefuncimg',
					'std' => ''
					),
					
			array(
					'name' => __( 'Youtube & Vimeo Auto Play', 'easynotify' ),
					'desc' => __( ' Use this to enable/disable video auto play. This option only work on Youtube & Vimeo. Default : Auto', 'easynotify' ),
					'id' => 'enoty_cp_video_autoplay',
					'type' => 'checkboxoptdef',
					'onefunc' => 'onefuncimg',
					'std' => 'on'
					),	
					
			array(
					'name' => __( 'Image<span data-ppw="550" data-pph="500" data-toload="image.html" class="helpicon"></span>', 'easynotify' ),
					'desc' => __( 'Select or upload your Notify image.', 'easynotify' ),
					'id' => 'enoty_cp_img',
					'type' => 'images',
					'onefunc' => 'onefuncimg',
					'std' => ENOTIFY_URL.'/inc/images/default-image.png'
				 ),	

			array(
					'name' => __( 'Bullet List', 'easynotify' ),
					'desc' => __( 'Use this option to create the text list of you Notify. Make sure to turn it ON.', 'easynotify' ),
					'id' => 'enoty_cp_bullet',
					'type' => 'bullet',
					'elid' => 'customfileds',
					'std' => array ( '0' => 'Sample bullet 1', '1' => 'Sample bullet 2', '2' => 'Sample bullet 3' ),
					'io' => 'on',
					'onefunc' => 'onefuncbull',
					),			
		
		
			array(
					'name' => __( 'Bullet List Font Size and Color', 'easynotify' ),
					'desc' => __( 'You can change the font size and color here. Default size: 12px and font color : #e8e8e8', 'easynotify' ),
					'id' => 'enoty_cp_bullet_list_text',
					'type' => 'typo',				
					'color' => 'clr',
					'font' => 'fnt',
					'stf' => '12px',
					'stcol' => '#e8e8e8',
					'onefunc' => 'onefuncbull',
					),	
					
			array(
					'name' => __( 'Bullet List Style & Color<span data-ppw="550" data-pph="550" data-toload="bullets.html" class="helpicon"></span>', 'easynotify' ),
					'desc' => __( 'You can change the bullet style and color here. Default: Rounded Blue', 'easynotify' ),
					'id' => 'enoty_cp_bullet_style_color',
					'type' => 'select',				
					'std' => 'bullroundedorange',
					'onefunc' => 'onefuncbull',
					'options' => array (
								'bullroundedorange'=> 'Round Orange',
								'bullroundedblue'=> 'Round Blue ( PRO Version Only )',
								'bullroundedred'=> 'Round Red ( PRO Version Only )',
								'bullroundedgrey'=> 'Round Grey ( PRO Version Only )',
								'bullroundedgreen'=> 'Round Green ( PRO Version Only )',
								'bullroundedyellow'=> 'Round Yellow ( PRO Version Only )',
								'bulltickblue'=> 'Tick Blue ( PRO Version Only )',
								'bulltickred'=> 'Tick Red ( PRO Version Only )',
								'bulltickgrey'=> 'Tick Grey ( PRO Version Only )',
								'bulltickgreen'=> 'Tick Green ( PRO Version Only )',
								'bulltickorange'=> 'Tick Orange ( PRO Version Only )',
								'bulltickyellow'=> 'Tick Yellow ( PRO Version Only )'),
								
							),
		
			array(
					'name' => __( 'Footer Container<span data-ppw="750" data-pph="550" data-toload="footer_cont.html" class="helpicon"></span>', 'easynotify' ),
					'desc' => __( 'Please select the content for your footer, you can use it to display social sharing buttons, Opt-in ( subscribe form ) or custom button with custom text.', 'easynotify' ),
					'id' => 'enoty_cp_ribbon_container',
					'type' => 'select',				
					'std' => 'none',
					'usejquery' => 'yes',
					'options' => array (
								'optin'=> 'Subscribe Form ( PRO Version Only )',
								'socialbutton'=> 'Social Sharing Buttons  ( PRO Version Only )',
								'button'=> 'Custom Text & Button  ( PRO Version Only )',
								'none'=> 'None ( Disabled )'),
					),
					
					
			/* Custom Button */
			array(
					'name' => __( 'Custom Text', 'easynotify' ),
					'desc' => __( 'Set your custom text here. For best result the maximum number of characters is 35.', 'easynotify' ),
					'id' => 'enoty_cp_ribbon_text',
					'type' => 'text',
					'std' => ''
					),	
					
			array(
					'name' => __( 'Text Font Size and Color', 'easynotify' ),
					'desc' => __( 'You can change the font size and color here. Default size: 26px and font color : #ffffff', 'easynotify' ),
					'id' => 'enoty_cp_ribbon_text_fcol',
					'type' => 'typo',				
					'color' => 'clr',
					'font' => 'fnt',
					'stf' => '26px',
					'stcol' => '#ffffff',
					),
					
			array(
					'name' => __( 'Button Text', 'easynotify' ),
					'desc' => __( 'Set your button text here. For best result the  maximum number of characters is 15.', 'easynotify' ),
					'id' => 'enoty_cp_ribbon_button_text',
					'type' => 'text',
					'std' => 'Get Access Now!'
					),	
					
			array(
					'name' => __( 'Button Link / URL', 'easynotify' ),
					'desc' => __( 'Your visitor will go to this link when they press the button.', 'easynotify' ),
					'id' => 'enoty_cp_ribbon_button_link',
					'type' => 'text',
					'std' => ''
					),
					
			array(
					'name' => __( 'Open link in new window ', 'easynotify' ),
					'desc' => __( 'If ON, your link will open in new window.', 'easynotify' ),
					'id' => 'enoty_cp_ribbon_button_link_target',
					'type' => 'checkboxoptdef',
					'std' => 'on'
					),	
					
			array(
					'name' => __( 'Button Text Font Size and Color', 'easynotify' ),
					'desc' => __( 'You can change the font size and color here. Default size: 16px and font color : #f5f5f5', 'easynotify' ),
					'id' => 'enoty_cp_button_text_fcol',
					'type' => 'typo',				
					'color' => 'clr',
					'font' => 'fnt',
					'stf' => '16px',
					'stcol' => '#f5f5f5',
					),	
					
			array(
					'name' => __( 'Button Background Gradient', 'easynotify' ),
					'desc' => __( 'Use this option to generate button gradient color. Default : #42424C to #25262B', 'easynotify' ),
					'id' => 'enoty_cp_ribbon_button_gradient_color',
					'type' => 'gradient',
					'from' => 'from',
					'to' => 'to',
					'stdfrom' => '#42424C',
					'stdto' => '#25262B',
					),
					
					
			/* Opt-in */
			array(
					'name' => __( 'Disable / Enable Name Field', 'easynotify' ),
					'desc' => __( 'You can use Name field in your subscribe form or disable it if you want to use Email only.', 'easynotify' ),
					'id' => 'enoty_cp_option_name_opt',
					'type' => 'radio',
					'options' => array (	
										'use-name'=> 'Enable',
										'no-name'=> 'Disable'),				
					'std' => 'use-name'
					),
			
			array(
					'name' => __( 'Name Placeholder', 'easynotify' ),
					'desc' => __( 'Set Name Placeholder here.', 'easynotify' ),
					'id' => 'enoty_cp_optin_phldr_name',
					'type' => 'text',
					'std' => 'Your Name...'
					),	
				
			array(
					'name' => __( 'E-mail Placeholder', 'easynotify' ),
					'desc' => __( 'Set your e-mail Placeholder here.', 'easynotify' ),
					'id' => 'enoty_cp_optin_phldr_email',
					'type' => 'text',
					'std' => 'Your E-mail...'
					),	
					
			array(					
					'name' => __( 'Submit Button Text', 'easynotify' ),
					'desc' => __( 'Set your submit button here. For best result the  maximum number of characters is 15.', 'easynotify' ),
					'id' => 'enoty_cp_optin_submit_text',
					'type' => 'text',
					'std' => 'Subscribe Now!'
					),				
					
			array(
					'name' => __( 'Submit Button Font Size & Color', 'easynotify' ),
					'desc' => __( 'You can change the font size and color here. Default size: 16px and font color : #f5f5f5', 'easynotify' ),
					'id' => 'enoty_cp_optin_text_fcol',
					'type' => 'typo',				
					'color' => 'clr',
					'font' => 'fnt',
					'stf' => '16px',
					'stcol' => '#f5f5f5',
					),
					
			array(
					'name' => __( 'Submit Button Background Gradient', 'easynotify' ),
					'desc' => __( 'Use this option to generate button gradient color. Default : #42424C to #25262B', 'easynotify' ),
					'id' => 'enoty_cp_option_submit_gradient_color',
					'type' => 'gradient',
					'from' => 'from',
					'to' => 'to',
					'stdfrom' => '#42424C',
					'stdto' => '#25262B',
					),	
								
			array(
					'name' => __( 'Privacy Note', 'easynotify' ),
					'desc' => __( 'Set your privacy note here. For example : Your privacy is protected & your email address will never be shared with any 3rd parties.', 'easynotify' ),
					'id' => 'enoty_cp_optin_privacy_note',
					'type' => 'text',
					'std' => ''
					),	
					
					
			/* Share Button */		
			array(
					'name' => __( 'Share Button Position', 'easynotify' ),
					'desc' => __( 'Set the position of your share button. Default: Center', 'easynotify' ),
					'id' => 'enoty_cp_share_pos',
					'type' => 'radio',
					'options' => array (	
										'left'=> 'Left',
										'center'=> 'Center',
										'right'=> 'Right'),				
					'std' => 'center'
					),
					
			array(
					'name' => __( 'Show Facebook Button', 'easynotify' ),
					'desc' => __( 'Use this to show/hide Facebook Button.', 'easynotify' ),
					'id' => 'enoty_cp_share_fb',
					'type' => 'checkboxoptdef',
					'std' => 'on'
					),	
					
			array(
					'name' => __( 'Show Twitter Button', 'easynotify' ),
					'desc' => __( 'Use this to show/hide Twitter Button.', 'easynotify' ),
					'id' => 'enoty_cp_share_twtr',
					'type' => 'checkboxoptdef',
					'std' => 'on'
					),	
					
			array(
					'name' => __( 'Show Google+ Button', 'easynotify' ),
					'desc' => __( 'Use this to show/hide Google+ Button.', 'easynotify' ),
					'id' => 'enoty_cp_share_gplus',
					'type' => 'checkboxoptdef',
					'std' => 'on'
					),						
					
			array(
					'name' => __( 'Show Pinterest Button', 'easynotify' ),
					'desc' => __( 'Use this to show/hide Pinterest Button.', 'easynotify' ),
					'id' => 'enoty_cp_share_pin',
					'type' => 'checkboxoptdef',
					'std' => 'on'
					),	
					
			array(
					'name' => __( 'Show Email Button', 'easynotify' ),
					'desc' => __( 'Use this to show/hide Email Button.', 'easynotify' ),
					'id' => 'enoty_cp_share_email',
					'type' => 'checkboxoptdef',
					'std' => 'on'
					),	
					
					
			array(
					'name' => __( 'Footer Styles', 'easynotify' ),
					'desc' => __( 'You can change the ribbon ( background for share button or Opt-In ) styles here. Default: Blue Ribbon', 'easynotify' ),
					'id' => 'enoty_cp_ribbon',
					'type' => 'select',				
					'std' => 'noribbon',
					'options' => array (
								'noribbon'=> 'No Ribbon',
								'blue'=> 'Blue Ribbon ( PRO Version Only )',
								'red'=> 'Red Ribbon ( PRO Version Only )',
								'grey'=> 'Grey Ribbon ( PRO Version Only )',
								'black'=> 'Black Ribbon ( PRO Version Only )',
								'green'=> 'Green Ribbon ( PRO Version Only )',
								'orange'=> 'Orange Ribbon ( PRO Version Only )',
								'yellow'=> 'Yellow Ribbon ( PRO Version Only )'),
					),	
					

			)
	);
    enoty_add_meta_box( $enotymeta_box );	

		
	//  Styling METABOX
	    $enotymeta_box = array(
		'id' => 'enoty_metaboxmediastyle',
		'title' =>  __( 'Styling', 'easynotify' ),
		'description' => __( 'Now you can change the look of your notify to fit your needs here.<span class="enotysteptwo"></span>', 'easynotify' ),
		'page' => 'easynotify',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
		
			array(
					'name' => __( 'Overlay Pattern<span data-ppw="745" data-pph="620" data-toload="overlay_pattern.html" class="helpicon"></span>', 'easynotify' ),
					'desc' => __( 'Please define pattern for yor Notify overlay.', 'easynotify' ),
					'id' => 'enoty_cp_pattern',
					'type' => 'pattern',
					'std' => 'pattern-01.png'
				 ),	
				 
			array(
					'name' => __( 'Overlay Color', 'easynotify' ),
					'desc' => __( 'Set your Notify overlay color. Default: #c7c7c7', 'easynotify' ),
					'id' => 'enoty_cp_overlay_col',
					'type' => 'color',
					'std' => '#c7c7c7'
					),
					
			array(
					'name' => __( 'Overlay Opacity', 'easynotify' ),
					'desc' => __( 'Opacity of the fullpage overlay when an Notify is opened. Default : 70%', 'easynotify' ),
					'id' => 'enoty_cp_overlay_opcty',
					'type' => 'slider',
					'std' => '70',
					'max' => '100',
					'min' => '0',
					'step' => '10',
					'usestep' => '1',
					'pixopr' => '%',
					),	
					
			array(
					'name' => __( 'Notify Gradient Background Color<span data-ppw="680" data-pph="580" data-toload="notybg.html" class="helpicon"></span>', 'easynotify' ),
					'desc' => __( 'Use this option to generate Notify gradient background color. Default : #383838 to #272727', 'easynotify' ),
					'id' => 'enoty_cp_background_color',
					'type' => 'gradient',
					'from' => 'from',
					'to' => 'to',
					'stdfrom' => '#383838',
					'stdto' => '#272727',
					),
					
			array(
					'name' => __( 'Notify Gradient Background Type', 'easynotify' ),
					'desc' => __( 'You can change the gradient type here. Default: Linear', 'easynotify' ),
					'id' => 'enoty_cp_background_type',
					'type' => 'radio',
					'options' => array (
										'grad-linear'=> 'Linear',	
										'grad-radial'=> 'Radial'),			
					'std' => 'grad-linear'
					),
					
			array(
					'name' => __( 'Open Notify Delay', 'easynotify' ),
					'desc' => __( 'This option allow you to delay the automatic load of your Notify. Default : 1 second', 'easynotify' ),
					'id' => 'enoty_cp_notify_delay',
					'type' => 'slider',
					'std' => '1',
					'max' => '900',
					'min' => '1',
					'step' => '1',
					'usestep' => '1',
					'pixopr' => 'seconds',
					),	
					
			array(
					'name' => __( 'Open Effect', 'easynotify' ),
					'desc' => __( 'Animation effect when your Notify show up. Default: Fade', 'easynotify' ),
					'id' => 'enoty_cp_open_effect',
					'type' => 'radio',
					'options' => array (
										'open-fade'=> 'Fade',	
										'open-elastic'=> 'Elastic'),			
					'std' => 'open-fade'
					),
					
			array(
					'name' => __( 'Close Effect', 'easynotify' ),
					'desc' => __( 'Animation effect when your Notify disappear. Default: Fade', 'easynotify' ),
					'id' => 'enoty_cp_close_effect',
					'type' => 'radio',
					'options' => array (
										'close-fade'=> 'Fade',	
										'close-elastic'=> 'Elastic'),				
					'std' => 'close-fade'
					),
					
			array(
					'name' => __( 'Close Button Icon<span data-ppw="500" data-pph="400" data-toload="closeicon.html" class="helpicon"></span>', 'easynotify' ),
					'desc' => __( 'You can change the close button icon to fit your needs. Default: Red Square', 'easynotify' ),
					'id' => 'enoty_cp_close_icon',
					'type' => 'select',				
					'std' => 'default',
					'options' => array (
								'default'=> 'Default',
								'red_square.png'=> 'Red Square ( PRO Version Only )',
								'red_cross.png'=> 'Red Cross ( PRO Version Only )',
								'red_circle.png'=> 'Red Circle ( PRO Version Only )',
								'black_square.png'=> 'Black Square ( PRO Version Only )',
								'black_cross.png'=> 'Black Cross ( PRO Version Only )'),
					),	
					
			)
	);
    enoty_add_meta_box( $enotymeta_box );		
		

	
	//  Cookies METABOX	
	    $enotymeta_box = array(
		'id' => 'enoty_select_cookies',
		'title' =>  __( 'Cookies', 'easynotify' ),
		'description' => __( 'When user close the notify, how long should it be before the Notify is shown again?<span class="enotystepthree"></span>', 'easynotify' ),
		'page' => 'easynotify',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
			array(
					'name' => __( 'Cookie Time on Close<span data-ppw="680" data-pph="375" data-toload="cookies.html" class="helpicon"></span>', 'easynotify' ),
					'desc' => __( 'You can set the days when the Notify will shown again, for example 7 for every week.<br /><span style="color:red; font-weight:bold;">Set with -1 If you want to notify appear at any time.</span>', 'easynotify' ),
					'id' => 'enoty_cp_cookies',
					'type' => 'shorttext',
					'aftr' => 'day(s)',
					'std' => '7')
				),				
				
	);
    enoty_add_meta_box( $enotymeta_box );		
		
		
	//  Publish METABOX
	    $enotymeta_box = array(
		'id' => 'enoty_metaboxmediasc',
		'title' =>  __( 'Shortcode Generator', 'easynotify' ),
		'description' => __( 'This is the final steps. Now you can copy the shortcode and paste to your New/Old Post/Page to show your Notify. If you want to set Notify to show on everywhere you can go <a href="'.admin_url( 'edit.php?post_type=easynotify&page=easynotify_settings' ).'">'.__('here', 'easynotify').'</a> under <strong>Default Notify</strong> > select the notify from dropdown list.<br /><strong style="color:#0678CC;">Make sure to Save/Update Notify before/after copy the shortcode.</strong><span class="enotystepfour"></span>', 'easynotify' ),
		'page' => 'easynotify',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
		
			array(
					'name' => __( 'Shortcode', 'easynotify' ),
					'desc' => __( 'Move cursor on blue area, right click and copy the shortcode.', 'easynotify' ),
					'id' => 'enoty_metabox_media_shortcode',
					'type' => 'theshortcode',	
					'std' => '&#91;easy-notify id='. get_the_ID() .'&#93;'
					)		
			)
	);
    enoty_add_meta_box( $enotymeta_box );				
				

}

//-----------------------------------------------------------------------------------------------------------------

/**
 * Save custom Meta Box
 *
 * @param int $post_id The post ID
 */
function enoty_save_meta_box( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
	
	if ( !isset( $_POST['enoty_meta'] ) || !isset( $_POST['enoty_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['enoty_meta_box_nonce'], basename( __FILE__ ) ) )
		return;
	
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) ) return;
	}
			foreach( $_POST['enoty_meta'] as $key => $val ) {
			if ( !is_array( $val ) ) {
				$_POST['enoty_meta'][$key] = stripslashes( $val );
			}
			else {
				$_POST['enoty_meta'][$key] = array();
				foreach( $val as $arr_val ) {$_POST['enoty_meta'][$key][] = stripslashes( $arr_val );}
			}
		}
		// save data
	
		foreach( $_POST['enoty_meta'] as $key => $val ) {
																
			delete_post_meta( $post_id, $key );
			add_post_meta( $post_id, $key, $_POST['enoty_meta'][$key], true ); 
		}
}
add_action( 'save_post', 'enoty_save_meta_box' );


function enoty_upgrade_popup() {
	
echo '<!-- Modal -->
<div class="modal fade" id="myModalupgrade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Pricing Table</h4>
            </div>
            <div class="modal-body" style="background-color: #f5f5f5;">
            
           
            <div class="row flat"> <!-- Content Start -->
            
            
              <div class="col-lg-3 col-md-3 col-xs-6">
                <ul class="plan plan1">
                    <li class="plan-name">
                        Pro
                    </li>
                    <li class="plan-price">
                        <strong>$'.ENOTY_PRO_PRICE.'</strong>
                    </li>
                    <li>
                        <strong>1 site</strong>
                    </li>
                    <li class="plan-action">
                        <a href="http://ghozylab.com/plugins/ordernow.php?order=enotypro&utm_source=easynotify&utm_medium=editor&utm_campaign=orderfromeditor" target="_blank" class="btn btn-danger btn-lg">BUY NOW</a>
                    </li>
                </ul>
            </div> 
            
              <div class="col-lg-3 col-md-3 col-xs-6"><span class="featured"></span>
                <ul class="plan plan1">
                    <li class="plan-name">
                        Pro+
                    </li>
                    <li class="plan-price">
                        <strong>$'.ENOTY_PRO_PLUS_PRICE.'</strong>
                    </li>
                    <li>
                        <strong>3 sites</strong>
                    </li>
                    <li class="plan-action">
                        <a href="http://ghozylab.com/plugins/ordernow.php?order=enotyproplus&utm_source=easynotify&utm_medium=editor&utm_campaign=orderfromeditor" target="_blank" class="btn btn-danger btn-lg">BUY NOW</a>
                    </li>
                </ul>
            </div> 
            
              <div class="col-lg-3 col-md-3 col-xs-6">
                <ul class="plan plan1">
                    <li class="plan-name">
                        Pro++
                    </li>
                    <li class="plan-price">
                        <strong>$'.ENOTY_PRO_PLUS_PLUS_PRICE.'</strong>
                    </li>
                    <li>
                        <strong>5 sites</strong>
                    </li>
                    <li class="plan-action">
                        <a href="http://ghozylab.com/plugins/ordernow.php?order=enotyproplusplus&utm_source=easynotify&utm_medium=editor&utm_campaign=orderfromeditor" target="_blank" class="btn btn-danger btn-lg">BUY NOW</a>
                    </li>
                </ul>
            </div>
			
              <div class="col-lg-3 col-md-3 col-xs-6">
                <ul class="plan plan1">
                    <li class="plan-name">
                        Developer
                    </li>
                    <li class="plan-price">
                        <strong>Contact Us</strong>
                    </li>
                    <li>
                        <strong>+15 sites</strong>
                    </li>
                    <li class="plan-action">
                        <a href="http://ghozylab.com/plugins/submit-support-request/#tab-1399384216-2-4" target="_blank" class="btn btn-danger btn-lg">CONTACT US</a>
                    </li>
                </ul>
            </div>
            
            </div><!-- Content End  --> 
            
            </div>
        </div>
    </div>
</div>
    
<!--  END HTML (to Trigger Modal) -->';	
	
	
}

?>