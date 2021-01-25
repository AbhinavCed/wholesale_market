jQuery(document).ready(function()
{
	jQuery('input[type="checkbox"]').click(function()
	{
		if (jQuery('#g_checkbox_wholesale_price').prop("checked") == true) {         
			jQuery("input[name='g_radio_dislpay_price_to']").show();
		} else if (jQuery(this).prop("checked") == false) {
			jQuery("input[name='g_radio_dislpay_price_to']").hide();
		}
	});
});

jQuery(document).ready(function()
{
	jQuery('#custom_text_field_wholesale_price').focusout(function()
	{	
		var wholesale_price = jQuery('#custom_text_field_wholesale_price').val();
		var reg_price = jQuery('#_regular_price').val();
	
		if (parseInt(wholesale_price) > parseInt(reg_price)) 
		{
			jQuery('#custom_text_field_wholesale_price').css('border', 'solid 2px red');
			jQuery("#publish").attr("disabled", true); 
		} 
		else 
		{
			jQuery('#custom_text_field_wholesale_price').css('border', 'solid 2px green');
			jQuery("#publish").attr("disabled", false);
		}
	});
});
