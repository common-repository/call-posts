function cps_notice_dismiss(){
	var data = {
		'action': 'cps_notice_dismiss',
	};
	jQuery.post(ajaxurl, data, function(response) {
		jQuery('#cps-post-notice').hide();
	});
}
jQuery(document).ready(function(){
	jQuery('body').on('click', '#cps-post-notice .notice-dismiss', function(){
		cps_notice_dismiss();
	});
	jQuery('body').on('click', '#cps-post-notice .custom-notice-dismiss', function(){
		cps_notice_dismiss();
	});
});