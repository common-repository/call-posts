jQuery(window).load(function() {
    //jQuery('#Call_Posts').center();
});
jQuery(document).ready(function(){
	if( pagenow == 'toplevel_page_call-posts' || pagenow == 'call-posts_page_call-posts-new'){
		jQuery('ul.cpss-tabs li').click(function(){
			var tab_id = jQuery(this).attr('data-tab');
			jQuery('ul.cpss-tabs li').removeClass('current');
			jQuery('.cpss-tab-content').removeClass('current');
			jQuery(this).addClass('current');
			jQuery('.tab-content-'+ tab_id +'').addClass('current');
		});

		jQuery(".cps_skin_content").trigger("sortupdate");

		jQuery('.cps_skin_content .cps_skin_element').sortable({
		  //connectWith: '.sortable_skin_element',
		  update: function(event, ui) {
			var changedList = this.id;
			var order = jQuery(this).sortable('toArray');
			jQuery('.cps_skin_array').text(function(){
				return JSON.stringify(order);
			});
		  }
		});

		if(cps.get){
			jQuery('body.toplevel_page_call-posts').addClass('cps-remove-overflow');
			jQuery('body.call-posts_page_call-posts-new').addClass('cps-remove-overflow');
		}

		jQuery('#cps-close, .cps_ignore').click(function(){
			jQuery('.cps-wrapper, #cps-overlay, .cps-delete-div, #cps-main-overlay').removeClass('cps-active');
			jQuery('body.toplevel_page_call-posts').removeClass('cps-remove-overflow');
			jQuery('body.call-posts_page_call-posts-new').removeClass('cps-remove-overflow');
			jQuery('.toplevel_page_call-posts > .wp-submenu > li').removeClass('current');
			jQuery('.toplevel_page_call-posts > .wp-submenu > li.wp-first-item').addClass('current');
			cps_url('admin.php?page=call-posts');
		});

		jQuery('.cps_skin span.dashicons').click(function(){
			jQuery(this).parent().parent().find('.custom-container-settings').slideToggle(230);
		});

		jQuery('.cps-expandallsettings').click(function(){
			jQuery('.custom-container-settings').slideToggle(230);
		});

		jQuery('.cps-clone-post').click(function(){
			var id = jQuery(this).attr('data-id');
			jQuery(this).next().append('<img src="' + cps.blogurl + '/wp-admin/images/spinner.gif">');
			cps_clone(id);
		});

		jQuery('.skin-checkbox').click(function(){
            if(jQuery(this).prop("checked") == true){
				jQuery(this).parent().parent().removeClass('skin-nonavailable');
                jQuery(this).parent().parent().addClass('skin-available');
            }
            else if(jQuery(this).prop("checked") == false){
				jQuery(this).parent().parent().removeClass('skin-available');
                jQuery(this).parent().parent().addClass('skin-nonavailable');
            }
		});

		cps_on_submit();
		//cps_on_delete();
		cps_checkbox_attr('cps_link');
		cps_checkbox_attr('cps_set_date');
		cps_alertbox();

		jQuery(".cps_from_date, .cps_to_date").datepicker();
	}
});

jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("left", Math.max(0, ((jQuery(window).width() - jQuery(this).outerWidth()) / 2) + jQuery(window).scrollLeft()) + "px");
    return this;
}

function cps_alertbox(){
	jQuery('.cps-trash-post').click(function(){
		var id = jQuery(this).attr('data-id');
		var out = confirm("Are you sure?");
		if (out == true) {
			jQuery(this).next().append('<img src="' + cps.blogurl + '/wp-admin/images/spinner.gif">');
			cps_delete(id);
		} else {
			console.log("You pressed Cancel!");
		}
	});
}

function functionConfirm(msg, myYes, myNo, cancel) {
   var confirmBox = jQuery(".wp-heading-inline");
   confirmBox.find(".message").text(msg);
   confirmBox.find(".yes,.no,.cancel").unbind().click(function() {
      confirmBox.hide();
   });
   confirmBox.find(".yes").click(myYes);
   confirmBox.find(".no").click(myNo);
   confirmBox.find(".no").click(cancel);
   confirmBox.show();
}

function cps_checkbox_attr(classname){
	if(jQuery('.'+classname).prop("checked") == true){
		jQuery('tr[data-id="'+classname+'"]').removeClass(classname);
	}
	else if(jQuery('.'+classname).prop("checked") == false){
		jQuery('tr[data-id="'+classname+'"]').addClass(classname);
	}
	jQuery('.'+classname).click(function(){
		if(jQuery(this).prop("checked") == true){
			jQuery('tr[data-id="'+classname+'"]').removeClass(classname);
		}
		else if(jQuery(this).prop("checked") == false){
			jQuery('tr[data-id="'+classname+'"]').addClass(classname);
		}
	});
}

function cps_meta_old(classname){
	var cpsmeta = [];
	jQuery('[name*="'+ classname +'"]').each(function(){
		cpsmeta.push(jQuery(this).attr('value'));
	});
	return cpsmeta;
}

function cps_clone(data){
	jQuery.ajax({
		method: "POST",
		data: { action: "cps_clone", nonce: cps.nonce, main:data },
		url: cps.ajax,
		dataType: 'json',
        success: function (response) {
			load_url('admin.php?page=call-posts');
		}
	});
}

function cps_meta(classname){
	var cpsmeta = [];
	cpsmeta.push({
		active		:  jQuery('[name="'+classname+'[active]"]').prop('checked'),
		width		:  jQuery('[name="'+classname+'[width]"]').val(),
		link		:  jQuery('[name="'+classname+'[link]"]').prop('checked'),
		seperator	:  jQuery('[name="'+classname+'[seperator]"]').val(),
	});
	return cpsmeta;
}

function data_render(){
    var cpsFields = [];
    var cpsmeta = [];
    var $cps = jQuery('.cps-new-value');

	// Pull in shortcode attributes and set defaults.
    var cps_unique_id	 	=  $cps.find('.cps_unique_id').val();
    var cps_parent_class	=  $cps.find('.cps_parent_class').val();
    var cps_category_list 	=  $cps.find('.cps_category_list').children("option:selected").val();
    var cps_ppp				=  $cps.find('.cps_ppp').val();
    var cps_order			=  $cps.find('.cps_order').children("option:selected").val();
    var cps_order_by		=  $cps.find('.cps_order_by').children("option:selected").val();
    var cps_post_status		=  $cps.find('.cps_post_status').children("option:selected").val();
    var cps_author			=  $cps.find('.cps_author').children("option:selected").val();
    var cps_exclude_post	=  $cps.find('.cps_exclude_post').prop('checked');
    var cps_desktop			=  $cps.find('.cps_desktop').val();
    var cps_tablet			=  $cps.find('.cps_tablet').val();
    var cps_mobile			=  $cps.find('.cps_mobile').val();
    var cps_skin			=  $cps.find('.cps_skin_array').val();
    var cps_skin_meta		=  $cps.find('.cps_skin_meta').val();
    var cps_excerpt_length	=  $cps.find('.cps_excerpt_length').val();
    var cps_after_excerpt	=  $cps.find('.cps_after_excerpt').val();
    var cps_link			=  $cps.find('.cps_link').prop('checked');
    var cps_link_to			=  $cps.find('.cps_link_to').val();
	var cps_set_date		=  $cps.find('.cps_set_date').prop('checked');
    var cps_from_date		=  $cps.find('.cps_from_date').val();
    var cps_to_date			=  $cps.find('.cps_to_date').val();
    var cps_image_size		=  $cps.find('.cps_image_size').children("option:selected").val();
	var cps_date_format		=  $cps.find('.cps_date_format').val();
	var cps_button_text		=  $cps.find('.cps_button_text').val();
	var cps_meta_data		=  $cps.find('.cps_metadata').val();
	var cps_meta_data_a		=  $cps.find('.cps_metadataa').val();
	var cps_meta_data_b		=  $cps.find('.cps_metadatab').val();
	var cps_meta_data_c		=  $cps.find('.cps_metadatac').val();
	var cps_meta_data_d		=  $cps.find('.cps_metadatad').val();
	var cps_meta_data_e		=  $cps.find('.cps_metadatae').val();

	//cps Meta
	cpsmeta.push({
		cps_img 		:  cps_meta('cps_img'),
		cps_title 		:  cps_meta('cps_title'),
		cps_content 	:  cps_meta('cps_content'),
		cps_date	 	:  cps_meta('cps_date'),
		cps_tag		 	:  cps_meta('cps_tag'),
		cps_category 	:  cps_meta('cps_category'),
		cps_author	 	:  cps_meta('cps_author'),
		cps_button_link	:  cps_meta('cps_button_link'),
		cps_metadata	:  cps_meta('cps_metadata'),
		cps_metadataa	:  cps_meta('cps_metadataa'),
		cps_metadatab	:  cps_meta('cps_metadatab'),
		cps_metadatac	:  cps_meta('cps_metadatac'),
		cps_metadatad	:  cps_meta('cps_metadatad'),
		cps_metadatae	:  cps_meta('cps_metadatae'),
    });

	//cps Fields
    cpsFields.push({
		cps_unique_id 		:  cps_unique_id,
		cps_parent_class 	:  cps_parent_class,
		cps_category_list 	:  cps_category_list,
		cps_ppp 			:  cps_ppp,
		cps_order 			:  cps_order,
		cps_order_by		:  cps_order_by,
		cps_post_status		:  cps_post_status,
		cps_author			:  cps_author,
		cps_exclude_post	:  cps_exclude_post,
		cps_desktop			:  cps_desktop,
		cps_tablet			:  cps_tablet,
		cps_mobile			:  cps_mobile,
		cps_skin			:  cps_skin,
		cps_skin_meta		:  JSON.stringify(cpsmeta),
		cps_excerpt_length	:  cps_excerpt_length,
		cps_after_excerpt	:  cps_after_excerpt,
		cps_link			:  cps_link,
		cps_link_to			:  cps_link_to,
		cps_set_date		:  cps_set_date,
		cps_from_date		:  cps_from_date,
		cps_to_date			:  cps_to_date,
		cps_image_size		:  cps_image_size,
		cps_date_format		:  cps_date_format,
		cps_button_text		:  cps_button_text,
		cps_metadata		:  cps_meta_data,
		cps_metadataa		:  cps_meta_data_a,
		cps_metadatab		:  cps_meta_data_b,
		cps_metadatac		:  cps_meta_data_c,
		cps_metadatad		:  cps_meta_data_d,
		cps_metadatae		:  cps_meta_data_e,
    });

	return cpsFields;
}

function cps_on_submit(){
    jQuery("#Call_Posts").submit(function(event) {
        event.preventDefault();
		jQuery(".cps_loader").append('<img src="' + cps.blogurl + '/wp-admin/images/spinner.gif">');
		cps_ajax(JSON.stringify(data_render()));
    });
}
/*
function cps_on_delete(){
    jQuery('.cps_delete').click(function(){
        event.preventDefault();
		//cps_delete(JSON.stringify(data_render()));
		cps_delete(jQuery(this).attr('data-id'));
    });
}
*/
function cps_ajax(data){
	jQuery.ajax({
		method: "POST",
		data: { action: "cps_ajax", nonce: cps.nonce, main:data },
		url: cps.ajax,
		dataType: 'json',
        success: function (response) {
			var id = jQuery('.cps-new-value').find('.cps_unique_id').val();
			load_url('admin.php?page=call-posts&id='+id+'&action=edit');
		}
	});
}

function cps_delete(data){
	jQuery.ajax({
		method: "POST",
		data: { action: "cps_delete", nonce: cps.nonce, main:data },
		url: cps.ajax,
		dataType: 'json',
        success: function (response) {
			load_url('admin.php?page=call-posts');
			//console.log(response.test);
		}
	});
}

function cps_url(url){
	var href = window.location.href;
	lastIndex = href.substr(href.lastIndexOf('/') + 1);
	href = href.replace(lastIndex, url);
	if (history.pushState) {
		history.pushState(null, null, href);
	} else {
		window.location.href = href;
	}
}

function load_url(url){
	var href = window.location.href;
	lastIndex = href.substr(href.lastIndexOf('/') + 1);
	href = href.replace(lastIndex, url);
	window.location.href = href;
}

function cps_copy(element) {
	var $temp = jQuery("<input>");
	jQuery("body").append($temp);
	$temp.val(jQuery(element).text()).select();
	document.execCommand("copy");
	$temp.remove();
	alert('Shortcode copied');
}

function cps_checkbox(boxclass) {
	jQuery(boxclass).click(function(){
		if(jQuery(this).prop("checked") == true){
			var dataval = 'checked';
		}
		else if(jQuery(this).prop("checked") == false){
			alert("Checkbox is unchecked.");
			var dataval = 'notchecked';
		}
	});
	return dataval;
}