<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}
if(!class_exists('Nicacowfw_Setting')){	
	
	include_once('nioacowfw-function.php');
	class Nicacowfw_Setting extends Nicacowfw_Function{
		var $nioacowfw_constant = array();  
		public function __construct($nioacowfw_constant = array()){
			$this->nioacowfw_constant = $nioacowfw_constant;

		}
		function page_init(){
			/*
			*Name*: {{product_name}}
			*URL:* {{product_url}}
			*SKU*:  {{product_sku}}
			*Price:* {{product_price}}
			*Category*: {{product_category}}
			
			_yoursite name_
			*/
			$mobile_no = $this->get_settings('mobile_no');
			$button_text = $this->get_settings('button_text','WhatsApp Me');
			$message = $this->get_settings('message','');
			$chat_message = $this->get_settings('chat_message','');
			$openinnewtab = $this->get_settings('openinnewtab','no');
			$enable_whatsapp_button = $this->get_settings('enable_whatsapp_button','no');
			$enable_whatsapp_chat_button = $this->get_settings('enable_whatsapp_chat_button','no');
			$postion_whatsapp_chat = $this->get_settings('postion_whatsapp_chat','left_bottom');
			$whatsapp_chat_icon_background_color = $this->get_settings('whatsapp_chat_icon_background_color','#25D366');
			$whatsapp_chat_icon_color = $this->get_settings('whatsapp_chat_icon_color','#FFFFFF');
			
			
			$chatopeninnewtab = $this->get_settings('chatopeninnewtab','no');
		
			$postion = $this->get_postion_whatsapp_chat_button();	
		?>
        <style>
        body #nioacowfw{}
		#nioacowfw .card {
		  padding: 0px;
		  max-width: 100%;
		}
		 #nioacowfw .valid-feedback {
		 display:block;
		 }
        </style>
        
       <div class="container-fluid" id="nioacowfw">
       		<div class="card"  style="max-width:60%;">
              <div class="card-header">
               <i class="fa fa-cog text-primary" aria-hidden="true"></i> <?php esc_html_e('Setting', 'nioacowfw' );?>
              </div>
              <div class="card-body">
              <form method="post" id="frm_nioacowfw_settings" name="frm_settings">
                  
                  <div class="form-group row">
                   <label for="enable_whatsapp_button"  class="col-sm-3 col-form-label"><?php esc_html_e('Enter WhatsApp No', 'nioacowfw' );?></label>
                    <div class="col-sm-3">
                      <input type="checkbox" id="enable_whatsapp_button" name="enable_whatsapp_button" <?php echo($enable_whatsapp_button =='yes')?'checked':'' ?>  />
                       
                    </div>
                    <div class="valid-feedback col-sm-6">
                      <?php esc_html_e('Yes, Display whatsapp button on product detail page', 'nioacowfw' );?>
                   </div>
                  </div>
                  
                  <!--Whatsapp number-->
                   <div class="form-group row">
                  		 <label for="mobile_no"  class="col-sm-3 col-form-label"><?php esc_html_e('Enter WhatsApp No', 'nioacowfw' );?></label>
                    	<div class="col-sm-3">
                      		<input type="text"  name="mobile_no" id="mobile_no" value="<?php echo $mobile_no; ?>"  class="form-control" />
                        </div>
                    	<div class="valid-feedback col-sm-6">
                      	<?php esc_html_e('Enter WhatsApp number with country code.  example: 91xxxxxxxxxx ', 'nioacowfw' );?>
                   		</div>
                  </div>
                  
                  
                    <!--Whatsapp Button Text-->
                   <div class="form-group row">
                  		<label for="button_text" class="col-sm-3 col-form-label"><?php esc_html_e('Button Text', 'nioacowfw' );?></label>
                    	<div class="col-sm-3">
                      			<input type="text"  name="button_text" id="button_text" value="<?php echo $button_text; ?>"  class="form-control" />
                        </div>
                    	<div class="valid-feedback col-sm-6">
                      	<?php esc_html_e('Enter Whatsapp button text like Whatsapp Me!', 'nioacowfw' );?>
                   		</div>
                  </div>
                  
                   <!--Whatsapp Message-->
                   <div class="form-group row">
                  		<label for="message" class="col-sm-3 col-form-label"><?php esc_html_e('Message', 'nioacowfw' );?></label>
                    	<div class="col-sm-6">
                      			<textarea id="message" rows="10" cols="50" name="message" class="form-control"><?php echo $message ; ?></textarea>
                        </div>
                    	<div class="valid-feedback col-sm-3">
                         <p><?php esc_html_e('Short Code:', 'nioacowfw' );?></p>
                        <p><?php esc_html_e('{{product_name}},{{product_url}}, {{product_price}}, {{product_sku}}, {{product_category}}', 'nioacowfw' );?> </p>
                         <p><?php esc_html_e('Bold: ', 'nioacowfw' );?></p>
						<p> <?php esc_html_e('*{{product_name}}*  ', 'nioacowfw' );?></p>
                        <p><?php esc_html_e('Italic:', 'nioacowfw' );?></p>
                        <p>  <?php esc_html_e(' _{{product_name}}_  ', 'nioacowfw' );?></p>
                        <p><?php esc_html_e('Strikethrough:  ', 'nioacowfw' );?></p>
                        <p><?php esc_html_e(' ~{{product_name}}~ ', 'nioacowfw' );?></p>
                         
                   		</div>
                  </div>
                
                  <!--Open windows -->
                   <div class="form-group row">
                  		<label for="openinnewtab"  class="col-sm-3 col-form-label"><?php esc_html_e('Open whatsapp in new tab?', 'nioacowfw' );?></label>
                    	<div class="col-sm-3">
                      			<input type="checkbox" name="openinnewtab" id="openinnewtab" <?php echo($openinnewtab =='yes')?'checked':'' ?>   class="form-check-input"  />
                        </div>
                    	<div class="valid-feedback col-sm-6">
                      	<?php esc_html_e('Yes, open whatsapp in new tab', 'nioacowfw' );?>
                   		</div>
                  </div>	
                  
                  
                     <!--Seprater-->
                   <div class="form-group row">
                  		 
                    	<div class="col-sm-12">
                      		<hr />
                        </div>
                    	
                  </div>
                  
                   <!--Chat Button Enable -->
                   <div class="form-group row">
                  		<label for="enable_whatsapp_chat_button"   class="col-sm-3 col-form-label"><?php esc_html_e('Enable WhatsApp Chat Button', 'nioacowfw' );?></label>
                    	<div class="col-sm-3">
                      		<input type="checkbox" id="enable_whatsapp_chat_button"  class="form-check-input" name="enable_whatsapp_chat_button" <?php echo($enable_whatsapp_chat_button =='yes')?'checked':'' ?>  />
                        </div>
                    	<div class="valid-feedback col-sm-6">
                      	<?php esc_html_e('Yes, Enable chat button', 'nioacowfw' );?>
                   		</div>
                  </div>
                  
                  
                  <!--Chat Button Enable -->
                   <div class="form-group row">
                  		<label for="postion_whatsapp_chat" class="col-sm-3 col-form-label"> <?php esc_html_e('Chat button postion', 'nioacowfw' );?></label>
                    	<div class="col-sm-3">
                      		<select name="postion_whatsapp_chat" id="postion_whatsapp_chat"   class="form-control" >
                        	<?php foreach($postion as $key=>$value): ?>
                            	<option value="<?php echo esc_attr($key); ?>" <?php echo($postion_whatsapp_chat ==$key)?'selected':'' ?>><?php echo esc_attr($value); ?></option>
                            <?php endforeach;?>
                        	</select>
                        </div>
                    	<div class="valid-feedback col-sm-6">
                      	<?php esc_html_e('Choose the chat button postion', 'nioacowfw' );?>
                   		</div>
                  </div>	
                    
                
                   <!--Chat button Background color-->
                   <div class="form-group row">
                  		<label for="whatsapp_chat_icon_background_color" class="col-sm-3 col-form-label"><?php esc_html_e('Chat button background color', 'nioacowfw' );?></label>
                    	<div class="col-sm-3">
                      			<input type="text" value="<?php echo 	$whatsapp_chat_icon_background_color; ?>" class="nioacowfw-color-field" name="whatsapp_chat_icon_background_color" data-default-color="#effeff"  class="form-control"  />
                        </div>
                    	<div class="valid-feedback col-sm-6">
                      	<?php esc_html_e('Change chat button background color', 'nioacowfw' );?>
                   		</div>
                  </div>
                  
                   <!--Chat button Background color-->
                   <div class="form-group row">
                  		<label for="whatsapp_chat_icon_background_color" class="col-sm-3 col-form-label"><?php esc_html_e('Chat button forecolor', 'nioacowfw' );?></label>
                    	<div class="col-sm-3">
                      		  <input type="text" value="<?php echo 	$whatsapp_chat_icon_color; ?>" class="nioacowfw-color-field" name="whatsapp_chat_icon_color" data-default-color="#effeff" class="form-control"  />
                        </div>
                    	<div class="valid-feedback col-sm-6">
                      	<?php esc_html_e('Change chat button forecolor', 'nioacowfw' );?>
                   		</div>
                  </div>
                
                
                  <!--Chat Whatsapp Message-->
                   <div class="form-group row">
                  		<label for="message" class="col-sm-3 col-form-label"><?php esc_html_e('Message', 'nioacowfw' );?></label>
                    	<div class="col-sm-6">
                      			<textarea id="chat_message" rows="10" cols="50" name="chat_message" class="form-control"><?php echo $chat_message ; ?></textarea>
                        </div>
                    	<div class="valid-feedback col-sm-3">
                       <?php esc_html_e('Message for chat', 'nioacowfw' );?>
                         
                   		</div>
                  </div>
                	
                    
                            <!--Chat Open windows -->
                   <div class="form-group row">
                  		<label for="chatopeninnewtab"  class="col-sm-3 col-form-label"><?php esc_html_e('Open whatsapp in new tab?', 'nioacowfw' );?></label>
                    	<div class="col-sm-3">
                      			<input type="checkbox" name="chatopeninnewtab" id="chatopeninnewtab" <?php echo($chatopeninnewtab =='yes')?'checked':'' ?>   class="form-check-input"  />
                        </div>
                    	<div class="valid-feedback col-sm-6">
                      	<?php esc_html_e('Yes, open whatsapp chat in new tab', 'nioacowfw' );?>
                   		</div>
                  </div>	
                    
                    <div class="form-group row">
                  		 
                    	<div class="col-sm-6 text-left">
                      		<div class="please_wait"></div>
                        </div>
                        <div class="col-sm-6 text-right">
                         <button type="submit" class="btn btn-primary"><i class="fa fa-home"></i> <?php esc_html_e('Save', 'nioacowfw' );?></button>
                       </div>
                    	
                  </div>
               
            	<input type="hidden" name="action" value="nioacowfw_action" />
				<input type="hidden" name="sub_action" value="settings" />
                <input type="hidden" name="call" value="save_setting" />
              </form>	
              </div>
            </div>      	
	   </div>

        
        	
        <?php
		}
		function get_postion_whatsapp_chat_button(){
			$postion = array();
			$postion['right_bottom']  = esc_html('Right Bottom', 'nioacowfw' );  
			$postion['right_top']  = esc_html('Right Top', 'nioacowfw' ); 
			$postion['left_top']  = esc_html('Left Top', 'nioacowfw' );  
			$postion['left_bottom']  = esc_html('Left Bottom', 'nioacowfw' );  
			
			
			return $postion; 
		}
		function ajax_init(){
			$nioacowfw_options = array();
			$nioacowfw_options["mobile_no"] 			= sanitize_text_field(isset($_REQUEST["mobile_no"])?$_REQUEST["mobile_no"]: '');
			$nioacowfw_options["button_text"] 			= sanitize_text_field(isset($_REQUEST["button_text"])?$_REQUEST["button_text"]: '');
			$nioacowfw_options["message"] 				= sanitize_textarea_field(isset($_REQUEST["message"])?$_REQUEST["message"]: '');
			
			$nioacowfw_options["chat_message"] 				= sanitize_textarea_field(isset($_REQUEST["message"])?$_REQUEST["chat_message"]: '');
			
			
			
			$nioacowfw_options["postion_whatsapp_chat"] = sanitize_text_field(isset($_REQUEST["postion_whatsapp_chat"])?$_REQUEST["postion_whatsapp_chat"]: '');
			
			$nioacowfw_options["whatsapp_chat_icon_background_color"] 			= sanitize_hex_color(isset($_REQUEST["whatsapp_chat_icon_background_color"])?$_REQUEST["whatsapp_chat_icon_background_color"]: '');
			$nioacowfw_options["whatsapp_chat_icon_color"] 			= sanitize_hex_color(isset($_REQUEST["whatsapp_chat_icon_color"])?$_REQUEST["whatsapp_chat_icon_color"]: '');
		
			$openinnewtab 					= 'no';
			$enable_whatsapp_button 		= 'no';
			$enable_whatsapp_chat_button 	= 'no';
			$chatopeninnewtab = 'no';
			
			if (isset($_REQUEST["chatopeninnewtab"])){
				$chatopeninnewtab = 'yes';
			}
			if (isset($_REQUEST["openinnewtab"])){
				$openinnewtab = 'yes';
			}
			if (isset($_REQUEST["enable_whatsapp_button"])){
				$enable_whatsapp_button = 'yes';
			}
			if (isset($_REQUEST["enable_whatsapp_chat_button"])){
				$enable_whatsapp_chat_button = 'yes';
			}
			$nioacowfw_options["enable_whatsapp_chat_button"] 	= $enable_whatsapp_chat_button;
			$nioacowfw_options["openinnewtab"] 					= $openinnewtab;
			$nioacowfw_options["enable_whatsapp_button"] 		= $enable_whatsapp_button;
			$nioacowfw_options["chatopeninnewtab"] 		= $chatopeninnewtab;
			
			update_option("nioacowfw_options",$nioacowfw_options);
			
			echo "Setting saved."	;
		}
	}
}

?>