"use strict"
jQuery(function($){
	
	
	$('.color-field').wpColorPicker();	
	$('.order_status_color').wpColorPicker();	
	 $('.nioacowfw-color-field').wpColorPicker();
	 
	
	
			
	$( "#frm_nioacowfw_settings" ).submit(function( event ) {
		event.preventDefault();
		$.ajax({
			beforeSend: function(){
			 $(".please_wait","#frm_nioacowfw_settings").html('<i class="fa fa-clock-o text-info" aria-hidden="true"></i> <span class="text-warning font-weight-normal">Please wait..</span>');
			 $(".please_wait","#frm_nioacowfw_settings").show();
			 
		    },
			url:nioacowfw_ajax_object.nioacowfw_ajaxurl,
			data: $(this).serialize(),
			success:function(response) {
				//$(".ajax_content").html(data);
				//alert(JSON.stringify(response));
				$(".please_wait","#frm_nioacowfw_settings").html('<i class="fa fa-floppy-o text-warning" aria-hidden="true"></i>   <span class="text-success font-weight-normal">'+response+'</span>');
				$(".please_wait","#frm_nioacowfw_settings").show();
				
				$(".please_wait","#frm_nioacowfw_settings").delay(9000).fadeOut('slow');
			},
			error: function(response){
				console.log(response);
				alert(JSON.stringify(response));
				//alert("e");
			}
		}); 
		return false; 
	});
});