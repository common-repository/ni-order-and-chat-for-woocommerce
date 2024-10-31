<?php
/*
Plugin Name: Ni Order and Chat for WooCommerce
Description: Ni Order and Chat for WooCommerce provide the option to chat and order directly from the shop owner.
Author: anzia
Version: 1.1
Author URI: http://naziinfotech.com/
Plugin URI: https://wordpress.org/plugins/ni-order-and-chat-for-wooCommerce
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/agpl-3.0.html
Tested up to: 5.6.x
WC requires at least: 5.0.x
WC tested up to:5.0.x
Requires PHP: 7.0
Text Domain: nioacowfw
Domain Path: languages/
 
*/
if ( ! defined( 'ABSPATH' ) ) { exit;}
if(!class_exists('Ni_Order_And_Chat_On_WhatsApp_For_WooCommerce')){	
	class Ni_Order_And_Chat_On_WhatsApp_For_WooCommerce{
		
		var $nioacowfw_constant = array();  
		public function __construct(){
			$this->nioacowfw_constant = array();
			
			$this->nioacowfw_constant['__FILE__'] = __FILE__;
			$this->nioacowfw_constant['plugin_dir_url'] = plugin_dir_url( __FILE__ );
			$this->nioacowfw_constant['manage_options'] = 'manage_options';
			$this->nioacowfw_constant['menu_name'] = 'nioacowfw-dashboard';
			$this->nioacowfw_constant['menu_icon'] = 'dashicons-media-document';
			add_action('plugins_loaded', array($this, 'plugins_loaded'));
			add_action('admin_notices', array($this, 'nioacowfw_check_woocommece_active'));

		}
		function plugins_loaded(){
			require_once("includes/nioacowfw-order-and-chat-on-whatsapp-for-woocommerce-init.php");
			$obj = new Nicacowfw_Order_And_Chat_On_WhatsApp_For_WooCommerce_Init($this->nioacowfw_constant);
			
			require_once("includes/nioacowfw-product-detail-page.php");
			$obj = new Nicacowfw_Product_Detail_Page($this->nioacowfw_constant);
			
		}
		function nioacowfw_check_woocommece_active(){
			if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				echo "<div class='error'><p><strong>Ni Order and Chat on WhatsApp for WooCommerce</strong> requires <strong> WooCommerce active plugin</strong> </p></div>";
			}
		}
		
	
	}/*End Class*/
}/*End Class Check*/

$obj = new Ni_Order_And_Chat_On_WhatsApp_For_WooCommerce();



