<?php
/**
* Call Posts Creating the widget
*
* @since 1.0
*/
class cps_widget extends WP_Widget {

	function __construct() {

		parent::__construct(

			// Base ID of your widget
			'cps_widget',

			// Widget name will appear in UI
			__('Call Posts', 'call-posts'),

			// Widget description
			array( 'description' => __( 'Easy post grid layout', 'call-posts' ) )

		);

	}

	// Creating widget front-end
	public function widget( $args, $instance ) {

		$title = sanitize_text_field( $instance['title'] );

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		echo do_shortcode( '[cps id="'.str_replace("cps_","",$title).'"]' );
		echo $args['after_widget'];

	}

	// Widget Backend
	public function form( $instance ) {

		$title = ( isset( $instance[ 'title' ] ) )? $instance[ 'title' ] : __( '', 'call-posts' );
		$cps   = callposts();
		echo $cps->core->cps_construct_widget( $this->get_field_id( 'title' ), $this->get_field_name( 'title' ), $title );

	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {

		$instance 	 	 	= array();
		$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;

	}
}

add_action( 'widgets_init', function() {
    return register_widget( 'cps_widget' );
});