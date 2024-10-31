<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}
if(!class_exists('Nicacowfw_Order_And_Chat_On_WhatsApp_For_WooCommerce_Init')){	
	include_once('nioacowfw-function.php');
	class Nicacowfw_Order_And_Chat_On_WhatsApp_For_WooCommerce_Init extends Nicacowfw_Function{
		
		var $nioacowfw_constant = array();  
		public function __construct($nioacowfw_constant = array()){
			$this->nioacowfw_constant = $nioacowfw_constant;
			add_action( 'admin_menu',  array(&$this,'admin_menu' ),130);
			add_action( 'admin_enqueue_scripts',  array(&$this,'admin_enqueue_scripts' ));
			add_action( 'wp_ajax_nioacowfw_action',  array(&$this,'nioacowfw_ajax_action' )); 
			
			
			add_action( 'wp_head',array(&$this,'wp_head'));
			add_action( 'wp_enqueue_scripts',array(&$this,'wp_enqueue_scripts'));
			
			add_action('wp_footer', array($this,'wp_footer'));	
			//add_action('admin_head', array($this,'fontawesome_icon_dashboard'));	
		}
		function fontawesome_icon_dashboard(){
			echo '<style type="text/css" media="screen">
			  icon16.icon-media:before, #adminmenu .toplevel_page_nioacowfw-dashboard div.wp-menu-image:before {
			  font-family:"FontAwesome" !important;
			  content: "\\f232";
			  font-style:normal;
			  font-weight:400;
			}
        </style>';
		}
		function wp_head(){
			
			 wp_enqueue_style( 'font-awesome',  plugins_url('../public/css/font-awesome.min.css',__FILE__ ) );
		}
		function wp_footer(){
			$enable_whatsapp_chat_button = $this->get_settings('enable_whatsapp_chat_button','no');
			$postion_whatsapp_chat = $this->get_settings('postion_whatsapp_chat','left_bottom');
			
			$whatsapp_chat_icon_background_color = $this->get_settings('whatsapp_chat_icon_background_color','#25D366');
			$whatsapp_chat_icon_color = $this->get_settings('whatsapp_chat_icon_color','#FFFFFF');
			$mobile_no = $this->get_settings('mobile_no','910000000000');
			$chat_message = $this->get_settings('chat_message','Hello');
			$chatopeninnewtab = $this->get_settings('chatopeninnewtab','no');
			
			 $target = '';
			 if ( $chatopeninnewtab =='yes'){
			 	 $target  =" target='_blank'";
			 }
			
			$chat_message =  urlencode($chat_message);
			
			$link_btn = "https://api.whatsapp.com/send?phone={$mobile_no}&text={$chat_message}"; 
			
			
			
			if ($enable_whatsapp_chat_button =='yes'){
				?>
            	<div class="nioacowfw_chat_link"><a href='<?php echo $link_btn; ?>' <?php  echo $target;?> class="nioacowfw_whatsaap_btn <?php echo $postion_whatsapp_chat; ?> "><i class="fa fa-whatsapp chat_link_float"></i></a></div>
           		<?php
			}
			?>
            <script>
            	jQuery(function($){
					  $('.nioacowfw_whatsaap_btn').attr('style','background-color: <?php echo $whatsapp_chat_icon_background_color;  ?> !important; color:<?php echo $whatsapp_chat_icon_color;  ?>');
				});
            </script>
            <?php
			
		}
		
		function wp_enqueue_scripts(){
		 	wp_enqueue_style( 'nioacowfw-frontend', plugins_url('../public/css/nioacowfw-frontend.css',__FILE__ ) );
			wp_enqueue_script( 'nioacowfw-frontend-script',  plugins_url('../public/js/nioacowfw-frontend.js',__FILE__ ), array('jquery') );
		}
		function admin_menu(){
			add_menu_page(
			esc_html__(  'Ni WhatsApp', 'nicacowfw'),
			esc_html__(  'Ni WhatsApp', 'nicacowfw'),
			$this->nioacowfw_constant['manage_options'], 
			$this->nioacowfw_constant['menu_name'],
			array(&$this,'add_page'),
			$this->nioacowfw_constant['menu_icon']
			,61.369);
		   
		  
		   
		    add_submenu_page($this->nioacowfw_constant['menu_name'], 
			 esc_html__(  'Dashboard', 'nicacowfw'), 
			 esc_html__(  'Dashboard', 'nicacowfw'), 
			$this->nioacowfw_constant['manage_options'], 
			$this->nioacowfw_constant['menu_name'],
			array(&$this,'add_page')
			);
		   
		    add_submenu_page($this->nioacowfw_constant['menu_name'], 
			esc_html__(  'Settings', 'nicacowfw'),
			esc_html__(  'Settings', 'nicacowfw'),
			$this->nioacowfw_constant['manage_options'], 
			'nicacowfw-settings', 
			array(&$this,'add_page')
			);
		  
		}
		function admin_enqueue_scripts(){
			$page = $this->get_single_request('page');
			$admin_pages = $this->get_admin_pages();
			if (in_array($page,$admin_pages)){
				
				
				if ($page =='nicacowfw-settings'){
					
					wp_enqueue_style( 'wp-color-picker' );
					wp_enqueue_script('nioacowfw-setting-script', plugins_url( '../admin/js/nioacowfw-setting.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
				}
				
				wp_enqueue_script( 'nioacowfw-popper-script', plugins_url( '../admin/js/bootstrap/popper.min.js', __FILE__ ), array('jquery') );
				wp_enqueue_script( 'nioacowfw-bootstrap-script', plugins_url( '../admin/js/bootstrap/bootstrap.min.js', __FILE__ ), array('jquery') );
					
				wp_enqueue_style( 'nioacowfw-bootstrap', plugins_url('../admin/css/bootstrap/bootstrap.css',__FILE__ ) );
				 wp_enqueue_style( 'font-awesome', plugins_url('../public/css/font-awesome.min.css',__FILE__ ) );
				
				
				wp_enqueue_style( 'nioacowfw-admin', plugins_url('../admin/css/nioacowfw-admin.css',__FILE__ ) );
				
				wp_enqueue_script( 'nioacowfw-script', plugins_url( '../admin/js/script.js', __FILE__ ), array('jquery') );
				wp_localize_script( 'nioacowfw-script','nioacowfw_ajax_object',array('nioacowfw_ajaxurl'=>admin_url('admin-ajax.php')));
			}
		}
		
		function get_admin_pages(){
			$page = $this->get_single_request('page');
			$admin_pages = array();
			$admin_pages[] = 'nicacowfw-settings';
			$admin_pages[] = 'nioacowfw-dashboard';
			$admin_pages = apply_filters('nioacowfw_admin_enqueue_script_pages',$admin_pages, $page);
			return $admin_pages;
		}
		function nioacowfw_ajax_action(){
			$sub_action = $this->get_single_request('sub_action');
			
			do_action('nicacowfw_ajax_action',$sub_action, $this->nioacowfw_constant);
			
			if ($sub_action == "settings"){
				include_once('nioacowfw-setting.php');
				$obj = new Nicacowfw_Setting();
				$obj->ajax_init();
			}
			die;	
		}
		function add_page(){
			 $page = $this->get_single_request('page');
		
			do_action('nicacowfw_before_admin_menu_page',$page, $this->nioacowfw_constant);
			
			if ($page == "nicacowfw-settings"){
				include_once('nioacowfw-setting.php');
				$obj = new Nicacowfw_Setting();
				$obj->page_init();
			}
			if ($page == "nioacowfw-dashboard"){
				
				include_once('nioacowfw-dashboard.php');
				$obj = new Nicacowfw_Dashboard();
				$obj->page_init();
			}
		}
		
		
	
	}/*End Class*/
}/*End Class Check*/


