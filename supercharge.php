<?php
/**
* Plugin Name: SuperCharge
* Plugin URI: http://www.supercharge.co
* Description: This plugin adds SuperCharge tab to your website to manage your site apps.
* Version: 1.0.0
* Author: SuperCharge
* Author URI: http://www.supercharge.co
* License: GPL2
*/
//add_action( 'wp_head', 'supercharge_init' );
add_action('wp_enqueue_scripts', 'supercharge_init');

function supercharge_init() {
	if(get_option('sc_siteid')){
		wp_enqueue_script('sc_script', '//now.supercharge.co/api/v1/' . get_option('sc_siteid') . '/load.js', null, '1.0.0', false);
	}
}

add_action('admin_menu', 'sc_plugin_settings');

function sc_plugin_settings() {
    add_menu_page('SuperCharge', 'SuperCharge', 'administrator', 'sc_settings', 'sc_display_settings');
}

function sc_display_settings(){
	$siteid = (get_option('sc_siteid') != '') ? get_option('sc_siteid') : sc_generateCoded();
	$url = plugin_dir_url( __FILE__ );
	$html = '</pre>
	<div id="supercharge">
	<div class="wrap">
		<h1>SuperCharge Settings</h1>
	</div>
	<div class="row step-1">
		<div class="row">
			<div class="large-8 columns">
				<h3> Step 1: Auto-generated site ID:</h2>
				<h4> Here is a unique site ID for your website to generate the SuperCharge Button on your website. </h4>
				<form action="options.php" method="post" name="options">			
					' . wp_nonce_field('update-options') . '			
					<label>Site ID: </label><input type="text" name="sc_siteid" id="siteid_input" style="width: 540px" value="' . $siteid . '" READONLY/>
				</form>
			</div>		
		</div>
		
	</div>
	<hr>
	<div class="row step-2">
		<div class="row">
			<div class="large-4 columns">
				<img src="'.$url.'/images/step2img.png">
			</div>
			<div class="large-8 columns">
				<h3> Step 2: Register Your Account</h2>
				<h4> Go to your site and click on the SuperCharge badge in the bottom right. Sign up to register your account and get rolling.</h4>
			</div>
			
		</div>
	</div>
	<hr>
	<div class="row step-2">
		<div class="row">
			<div class="large-8 columns">
				<h3> Step 3: Install Apps!</h2>
				<h4> Click on the SuperCharge Store icon to browse and install the different apps. Each take only seconds and one-click for installation.</h4>
			</div>
			<div class="large-4 columns">
				<img src="'.$url.'/images/step3	img.png">
			</div>
		</div>
	</div>
	</div>
	<pre>';
    echo $html;
	
}

function sc_generateCoded(){
	$timestamp = time();
	$salt = "rdduiKLtPnUjZP9X1sunG3uqfQ76NWqn";
	$randomno = rand(10000,99999);
	$siteid = sha1($timestamp + $salt + $randomno);
	add_option( 'sc_siteid', $siteid, '', 'yes' );
	return $siteid;
}

function load_custom_wp_admin_style() {
	wp_register_style('custom_wp_admin_css', plugin_dir_url( __FILE__ ) . 'css/sc_admin_style.css', false, '1.0.0' );
	wp_enqueue_style('custom_wp_admin_css');
}

add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

?>