(function($){

    // Close modal
    var close_win = function() {
        $('#cps_model_bg, #cps_model_div').css('display','none');
        $( document.body ).removeClass( 'modal-open' );
    };

    // Open modal when media button is clicked
    $(document).on('click', '.cps_insert_btn', function(e) {
        e.preventDefault();
        $('#cps_model_bg, #cps_model_div').css('display','block');
        $( document.body ).addClass( 'modal-open' );
    });

    // Close modal on close or cancel links
    $(document).on('click', '#cps_model_close, #cps_model_cancel a', function(e) {
        e.preventDefault();
        close_win();
    });

    // Insert shortcode into TinyMCE
    $(document).on('click', '#cps_model_submit', function(e) {
        e.preventDefault();
        var shortcode;
		var cps_source = ($('#cps_source').val()!="") ? 'id="' + $('#cps_source').val() + '"' : '';
        shortcode = '[cps ' + cps_source + ']';
        wp.media.editor.insert(shortcode);
        close_win();
    });

}(jQuery));