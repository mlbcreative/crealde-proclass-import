<?php
/**
 * Plugin Name: Proclass Class / Workshop Importer
 * Plugin URI: http://mlbcreative.com
 * Description: This plugin loads classes from Proclass Into the WP Admin
 * Version: 1.0.0
 * Author: Charles Rosenberger
 * Author URI: http://mlbcreative.com
 * License: GPL2
 */
 

require_once plugin_dir_path( __FILE__ ) . 'inc/pi-proclass-class-import.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/pi-register-class-post-type.php';

function myplugin_activate() {
	
    flush_rewrite_rules() ;
    
}


function myplugin_deactivate() {
	flush_rewrite_rules() ;
}



register_activation_hook( __FILE__, 'myplugin_activate' );
register_deactivation_hook( __FILE__, 'myplugin_deactivate' );

 

 
function pci_admin_page() {
	global $pci_settings;
	$pci_settings = add_submenu_page(
	 	'edit.php?post_type=proclass',
	 	'Import Class or Workshop',
	 	'Import',
	 	'manage_options',
	 	'import_proclass',
	 	'pci_render_admin'
	 	);
}

 add_action('admin_menu', 'pci_admin_page');

function pci_render_admin() {
	?>
	 	<div class="wrap">
		 	<h2><?php _e('ProClass Class / Workshop Importer', 'pci'); ?> </h2>
		 	<p><?php _e('This plugin allows you to import all current Crealdé Instructors into the Wordpress admin dashboard. Just click the button, sit back and let the magic happen.'); ?></p>
		 	<form id="pci-form" action="" method="POST">
			 	<div>
				 	<label for="class_id">Enter the Proclass Id<br />
				 		<input type="text" placeholder="Proclass ID" name="classid" id="class_id"/>
				 	</label><br />
				 	<br />
				 	<input type="submit" name="instructor-import" class="button-primary" value="<?php _e('Import Class Or Workshop' ,'pci') ?>"/>
				 	<div id="loadingMsg">Fetching class information from ProClass.</div>
			 	</div>
		 	</form>
		 	
	 	</div>
	 <?php
}

 function pci_load_scripts($hook) {
	 global $pci_settings;
	 
	 if( $hook != $pci_settings)
	 	return;
	 //wp_enqueue_style( 'pii-styles', plugin_dir_url(__FILE__) . 'css/pii-styles.css');
	 wp_enqueue_script('pci-ajax', plugin_dir_url(__FILE__) . 'js/pci-ajax.js', array('jquery'));
	 wp_localize_script('pci-ajax', 'pciImport', array ('ajaxurl' => admin_url( 'admin-ajax.php' )));
	 
 }
add_action('admin_enqueue_scripts', 'pci_load_scripts');

 function getProClassData() {
	 
	 
	 if ( isset($_POST['classid'])) {
		 
		 $classid = $_POST['classid'];
		 
		 $importer = new ProClassImport($_POST['classid']);
		 $importer->fetchClass();
	 } 
	 
	 die();
 }
 add_action('wp_ajax_pci_get_results', 'getProClassData');