jQuery(document).ready(function(e) {
	
	jQuery('a.nioacowfw_button').click( function(){
		if(jQuery(this).hasClass("disabled")){
			return false;
		}
		return true;
	});
	
	jQuery('input.variation_id').change( function(){
		var variation_id = jQuery(this).val();
		console.log(variation_id);
		
		
		if(variation_id != ""){
			jQuery('a.nioacowfw_button').removeClass("disabled");
			var product_id = jQuery(this).parent().find("input[name='product_id']").val();
				
			
			/*Disable button*/								
			jQuery(".nioacowfw_button").addClass("disable");
			
			var form_data = {
				"action" : ni_whatsapp_obj.action,
				"sub_action" : "whatsapp_link",
				"variation_id" : variation_id,
				"product_id" : product_id,
			};
			
			jQuery.ajax({
				type:"post",
				url:ni_whatsapp_obj.ajax_url,
				data: form_data,
				success:function(response) {
					
					jQuery(".nioacowfw_button").attr("href",response);
					jQuery(".nioacowfw_button").removeClass("disable");
					
				},
				error: function(response){
					console.log(response);
				}
			});
		}else{
			/*enable button*/
			jQuery('a.nioacowfw_button').addClass("disabled");
		}
	});
});