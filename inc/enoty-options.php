<?php

/*------------------------------------------------------------------------------------*/
/*  Option Control Panel
/*  require_once enoty-settings.php
/*------------------------------------------------------------------------------------*/

// VARIABLES
$enplugname = ENOTIFY_NAME;
$enshort = "easynotify";

// Set the Options Array
$entheopt = array (
 
array( "name" => $enplugname." Options",
	"type" => "title"),

array( "name" => "Default Notify",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Select Default Notify",
	"desc" => "Select your default Notify. Default : Disabled",
	"id" => $enshort."_defaultnotify",
	"type" => "defaultnotify",
	"std" => "disabled"),	
	
array( "name" => "Show on Home/Frontpage",
	"desc" => "If ON, your default notify will appear on your homepage or frontpage.",
	"id" => $enshort."_swhome",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Show on Page",
	"desc" => "If ON, your default notify will appear on your Page.",
	"id" => $enshort."_swpage",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Show on Post",
	"desc" => "If ON, your default notify will appear on your Post.",
	"id" => $enshort."_swpost",
	"type" => "checkbox",
	"std" => "1"),
	
array( "name" => "Show on Categories/Archive",
	"desc" => "If ON, your default notify will appear on your Categories/Archive page.",
	"id" => $enshort."_swcatarch",
	"type" => "checkbox",
	"std" => "1"),				
	
array( "name" => "Disable for logged users",
	"desc" => "Enable or temporarily disable the DEFAULT Notify for logged users.",
	"id" => $enshort."_disen_loggedusr",
	"type" => "checkbox",
	"std" => "0"),	
	
array( "type" => "close"),

array( "name" => "Miscellaneous",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Enable Plugin",
	"desc" => "Enable or temporarily disable this plugin.",
	"id" => $enshort."_disen_plug",
	"type" => "checkbox",
	"std" => "1"),
	
array( "name" => "Auto Update Plugin",
	"desc" => "Enable or temporarily disable auto update plugin.",
	"id" => $enshort."_disen_autoupdt",
	"type" => "checkbox",
	"std" => "1"),
	
array( "name" => "Upgrade Notification",
	"desc" => "Enable/Disable upgrade notifications.",
	"id" => $enshort."_disen_admnotify",
	"type" => "checkbox",
	"std" => "1"),	

array( "name" => "Keep data when uninstall",
	"desc" => "Enable this option to keep all plugin data and settings before you uninstall for update this plugin.",
	"id" => $enshort."_disen_databk",
	"type" => "checkbox",
	"std" => "1"),

array( "name" => "Wordpress Info",
	"desc" => "You can provide this wordpress information to our support staff when you face any issue with this plugin.",
	"id" => $enshort."_plugin_wpinfo",
	"type" => "textareainfo",
	"std" => ""),
	
array( "type" => "close")
	
);


/*------------------------------------------------------------------------------------*/
/*  RESTORE DEFAULT SETTINGS
/*------------------------------------------------------------------------------------*/

function easynotify_restore_to_default($cmd) {
	
	if ( $cmd == 'reset' ) {
		
		delete_option( 'easynotify_opt' );
		
				$enshort = "easynotify";
		
				$arr = array(
				$enshort.'_deff_init' => '1',																				
				$enshort.'_disen_databk' => '1',			
				$enshort.'_disen_plug' => '1',
				$enshort.'_disen_upchk' => '1',	
				$enshort.'_disen_autoupdt' => '1',
				$enshort.'_disen_loggedusr' => '0',
				$enshort.'_disen_admnotify' => '1',
				$enshort.'_defaultnotify' => 'disabled',				
				$enshort.'_swhome' => '1',				
				$enshort.'_swpage' => '1',
				$enshort.'_swpost' => '1',
				$enshort.'_swcatarch' => '1',												
													
				);
				update_option('easynotify_opt', $arr);
				return;
	}
}



/*------------------------------------------------------------------------------------*/
/*  1ST CONFIGURATION
/*------------------------------------------------------------------------------------*/

function easynotify_1st_config() {

				$thshort = "easynotify";
				
				$arr = array(
				$thshort.'_deff_init' => '1',																				
				$thshort.'_disen_databk' => '1',			
				$thshort.'_disen_plug' => '1',
				$thshort.'_disen_upchk' => '1',	
				$thshort.'_disen_autoupdt' => '1',
				$thshort.'_disen_loggedusr' => '0',
				$thshort.'_disen_admnotify' => '1',
				$thshort.'_defaultnotify' => 'disabled',				
				$thshort.'_swhome' => '1',				
				$thshort.'_swpage' => '1',
				$thshort.'_swpost' => '1',
				$thshort.'_swcatarch' => '1',	
				
				);
				update_option( 'easynotify_opt', $arr, '', 'yes' );
				return;
}


?>