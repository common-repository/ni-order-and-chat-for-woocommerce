<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}
if(!class_exists('Nicacowfw_Setting')){	
	include_once('nioacowfw-function.php');
	class Nicacowfw_Product_Detail_Page extends Nicacowfw_Function{
		var $nioacowfw_constant = array();  
		public function __construct($nioacowfw_constant = array()){
			$this->nioacowfw_constant = $nioacowfw_constant;
			
			$enable_whatsapp_button = $this->get_settings('enable_whatsapp_button','no');
			if ($enable_whatsapp_button  =="yes"){
				add_action('woocommerce_after_add_to_cart_form', array($this,'woocommerce_after_add_to_cart_form'));
				add_action('wp_ajax_ni_whatsapp',  array(&$this,'ni_whatsapp_action'));
				add_action('wp_enqueue_scripts',array(&$this,'wp_enqueue_scripts'));
			}
			
			
		}
		function wp_enqueue_scripts(){			
			wp_enqueue_script( 'ajax-script-ni_whatsapp', plugins_url( '../admin/js/script.js', __FILE__ ), array('jquery') );
			wp_localize_script( 'ajax-script-ni_whatsapp', 'ni_whatsapp_obj',array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'action' => 'ni_whatsapp' ) );
		}
		
		
		
		function woocommerce_after_add_to_cart_form(){
			global $product;
			 $product_id		= $product->get_id();
			 $target = '';	
			
			 $button_text = $this->get_settings('button_text','WhatsApp Me');
			 $openinnewtab = $this->get_settings('openinnewtab','no');
			 
			 if ( $openinnewtab =='yes'){
			 	 $target  =" target='_blank'";
			 }
			
			$link_btn = $this->get_url($product_id,$product_id);			
			
			if ($product->is_type( 'variable' )) {
				echo "<a href='{$link_btn}' class='single_add_to_cart_button button alt nioacowfw_button disabled' {$target} ><i class='fa fa-whatsapp' aria-hidden='true'></i>  {$button_text}</a>";				
			}else{	
				echo "<a href='{$link_btn}' class='single_add_to_cart_button button alt' {$target}><i class='fa fa-whatsapp' aria-hidden='true'></i>  {$button_text}</a>";
			}
		}
		
		function get_url($product_id = 0,$parent_id = ""){
			$short_code 	 =  $this->get_short_code();
			
			$mobile_no = $this->get_settings('mobile_no','910000000000');
			$message = $this->get_settings('message','{{product_name}}');
			
			$product_detail = wc_get_product( $product_id );

			$product_name 	= $product_detail->get_title();
			$product_url 	= $product_detail->get_permalink();
			$product_price	= $product_detail->get_price() ;
			
			$product_sku = get_post_meta($product_id,'_sku',true);
			$product_category = '';
			
			$terms = get_the_terms ( $parent_id, 'product_cat' );
			if($terms){
				foreach ( $terms as $term ) {
					
					 if ( strlen($product_category)> 0){
						 $product_category =  $product_category .', '. $term->name;
					 }else{
						$product_category = $term->name;
					 }
					// $cat_id = $term->name;
				}
			}
			
			if ($product_detail->is_type( 'variation' )) {
				$product_name = strip_tags($product_detail->get_formatted_name());
				//$product_name = urlencode($product_name);
			}
			
			foreach ($short_code as $key=>$value){
				switch($key){
					case "product_name":
						$message = str_replace($value, $product_name ,$message);
					break;
					case "product_url":
						$message = str_replace($value, $product_url ,$message);
					break;
					case "product_price":
						$message = str_replace($value, $product_price ,$message);
					break;
					case "product_sku":
						$message = str_replace($value, $product_sku ,$message);
					break;
					case "product_category":						
						$message = str_replace($value, $product_category  ,$message);
					break;
				}
			}
			
			//$message .= $product_name2 ;
			
			//$message = "ssssssssss";
			
			$whatsapp_message = urlencode($message);
			
			
			
			$link_btn = 'https://wa.me/'.$mobile_no.'?text='.$whatsapp_message;
			
			
			
			return $link_btn;
		}
		
		function ni_whatsapp_action(){
			$variation_id = intval(isset($_POST['variation_id']) ? $_POST['variation_id'] : 0);
			$product_id = intval(isset($_POST['product_id']) ? $_POST['product_id'] : 0);
			echo $this->get_url($variation_id,$product_id);
			die;
		}	
	}
}
?>