<?php
/**
* Call Posts Functions class
*
* @since 1.0.0
*/
class cps_functions {

	/**
	* Call Posts Constructor
	*
	* @since 1.0.0
	*/
	public function __construct() {

		$this->dummy_starter();
		add_action( 'admin_enqueue_scripts', array( $this, 'cps_admin_style_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'cps_front_style_scripts' ) );
		add_action( 'admin_menu', array( $this, 'cps_menu') );
		add_action( 'media_buttons', array( $this, 'cps_media_button' ), 15 );
		add_action( 'wp_ajax_cps_ajax', array( $this, 'cps_ajax') );
		add_action( 'wp_ajax_cps_delete', array( $this, 'cps_delete') );
		add_action( 'wp_ajax_cps_clone', array( $this, 'cps_clone') );

	}

	/**
	* Enqueues core styles and scripts, Admin only
	*
	* @since 1.0
	*/
	public function cps_admin_style_scripts() {

		if( is_admin() ){

			if( isset($_GET['page']) ){

				if( $_GET['page'] == cps_plugin_slug || $_GET['page'] == cps_plugin_slug.'-new' ){
					wp_enqueue_style('cps-css', cps_dir_url . '/assests/css/cps-admin.css');
					wp_enqueue_style('cps-css-ie', cps_dir_url . '/assests/css/cps-admin-ie.css');
					wp_style_add_data( 'cps-css-ie', 'conditional', 'IE' );
					wp_enqueue_script('cps-js', cps_dir_url . '/assests/js/cps-admin.js', array(), false, true);
					wp_enqueue_script('jquery');
					wp_enqueue_script('jquery-ui-datepicker', array('jquery'));
					wp_register_style('jquery-ui', cps_dir_url . '/assests/css/jquery-ui.css');
					wp_enqueue_style('jquery-ui');
					wp_enqueue_script('jquery-ui-sortable');
					wp_localize_script('cps-js', 'cps', array(
						'ajax' 	  => admin_url('admin-ajax.php'),
						'nonce'   => wp_create_nonce( cps_nonce ),
						'get' 	  => ( isset($_GET['id']) )? sanitize_text_field( $_GET['id'] ) : '',
						'page' 	  => ( isset($_GET['page']) )? sanitize_text_field( $_GET['page'] ) : '',
						'blogurl' => get_bloginfo('url'),
					));
				}

			}
			wp_enqueue_style('cps-all-admin-css', cps_dir_url . '/assests/css/cps-all-admin.css');
			wp_enqueue_script('cps-all-admin-js', cps_dir_url . '/assests/js/cps-all-admin.js', array(), false, true);
			wp_localize_script('cps-all-admin-js', 'cpsalladmin', array(
				'plugindir' => cps_dir_url
			));

		}

	}

	/**
	* Enqueues core styles and scripts, Admin only - media button
	*
	* @since 1.0
	*/
	public function cps_editor_style_scripts() {

		wp_enqueue_style('cps_editor_btn_css', cps_dir_url . '/assests/css/cps-editor-btn.css');
		wp_enqueue_script('cps_editor_btn_js', cps_dir_url . '/assests/js/cps-editor-btn.js', array(), false, true);

	}

	/**
	* Enqueues core styles and scripts, Frontend only
	*
	* @since 1.0
	*/
	public function cps_front_style_scripts() {

		wp_enqueue_style('cps-front-css', cps_dir_url . '/assests/css/cps-frontend.css');

	}

	/**
	* Inizialise Call Posts Plugin menu
	*
	* @since 1.0
	*/
	public function cps_menu() {

		//Main menu defined
		add_menu_page(
			cps_plugin_name,
			cps_plugin_name,
			'manage_options',
			cps_plugin_slug,
			array( $this, 'cps_admin_page' ),
			'dashicons-excerpt-view',
			60
		);

		//Side menu defined
		add_submenu_page(
			cps_plugin_slug,
			__( cps_plugin_name .' : Dashboard', 'call-posts' ),
			__( 'Dashboard', 'call-posts' ),
			'manage_options',
			cps_plugin_slug,
			array( $this, 'cps_admin_page' )
		);

		//Side menu defined
		add_submenu_page(
			cps_plugin_slug,
			__( cps_plugin_name .' : Add New', 'call-posts' ),
			__( 'Add New', 'call-posts' ),
			'manage_options',
			cps_plugin_slug . '-new',
			array( $this, 'cps_admin_page' )
		);

	}

	/**
	* Call Posts menu page (Dashboard)
	*
	* @since 1.0
	*/
	public function cps_admin_page() {

		$cp   = callposts();
		$arr  = array();
		$dash = $cp->render_skin(
			'div',
			array('class' => 'wrap call-posts'),
			$cp->render_skin(
				'h1',
				array('class' => 'wp-heading-inline'),
				$cp->render_skin(
					'span',
					$arr,
					cps_plugin_name
				).
				$cp->render_skin(
					'a',
					array('href' => admin_url( "admin.php?page=".cps_plugin_slug."-new" ), 'class' => 'page-title-action'),
					'Add New'
				)
			).
			$cp->render_skin(
				'table',
				array('class' => 'widefat fixed cps_layout_table'),
				$cp->render_skin(
					'tbody',
					$arr,
					$cp->render_skin(
						'tr',
						$arr,
						$cp->render_skin('th',$arr,__( 'No', 'call-posts' )).
						$cp->render_skin('th',$arr,__( 'Name', 'call-posts' )).
						$cp->render_skin('th',$arr,__( 'Short Code', 'call-posts' )).
						$cp->render_skin('th',$arr,__( 'Options', 'call-posts' ))
					)
				).
				$cp->render_skin(
					'tbody',
					array('class' => 'row cps-dashboard'),
					$cp->core->cps_dashboard($cp)
				).
				$cp->render_skin(
					'tbody',
					$arr,
					$cp->render_skin(
						'tr',
						$arr,
						$cp->render_skin('th',$arr,__( 'No', 'call-posts' )).
						$cp->render_skin('th',$arr,__( 'Name', 'call-posts' )).
						$cp->render_skin('th',$arr,__( 'Short Code', 'call-posts' )).
						$cp->render_skin('th',$arr,__( 'Options', 'call-posts' ))
					)
				)
			)
		);

		echo $dash;
		include( cps_dir_path . '/cps-admin-popup.php' );

	}

	/**
	* Create post media button
	*
	* @since 1.0
	*/
	public function cps_media_button( $editor_id ) {

		if ( ! apply_filters( 'cps_display_media_button', is_admin(), $editor_id ) ) {
			return;
		}
		$icon = '<span class="dashicons dashicons-excerpt-view"></span>';
		printf( '<a href="#" class="button cps_insert_btn" data-editor="%s" title="%s">%s %s</a>',
			esc_attr( $editor_id ),
			'Add Call Posts',
			$icon,
			cps_plugin_name
		);
		add_action( 'admin_footer', array( $this, 'cps_shortcode_modal' ) );

	}

	/**
	* Media button view
	*
	* @since 1.0
	*/
	public function cps_shortcode_modal() {

		$this->cps_editor_style_scripts();

		$cps   = callposts();
		$html  = $cps->render_skin('div', array('id' => 'cps_model_bg'), '');
		$html .= $cps->render_skin(
			'div',
			array('id' => 'cps_model_div'),
			$cps->render_skin(
				'form',
				array('id' => 'cps_model_body', 'tabindex' => '-1'),
				$cps->render_skin(
					'div',
					array('id' => 'cps_model_title'),
					cps_plugin_name . $cps->render_skin(
						'button',
						array('type' => 'button', 'id' => 'cps_model_close'),
						$cps->render_skin(
							'span',
							array('class' => 'screen-reader-text'),
							'Close'
						)
					)
				).
				$cps->render_skin(
					'div',
					array('id' => 'cps_model_inner', 'class' => 'cps_tab'),
					$cps->render_skin(
						'select',
						array('id' => 'cps_source', 'class' => 'widefat', 'type' => 'text'),
						$cps->render_skin('option', array('value'=>'none'),'Select') . $cps->core->cps_widget()
					)
				).
				$cps->render_skin(
					'div',
					array('class' => 'submitbox'),
					$cps->render_skin(
						'div',
						array('id' => 'cps_model_cancel'),
						$cps->render_skin(
							'a',
							array('class'=>'submitdelete deletion', 'href' => '#'),
							'Cancel'
						)
					).
					$cps->render_skin(
						'div',
						array('id' => 'cps_model_update'),
						$cps->render_skin(
							'button',
							array('class'=>'button button-primary', 'id' => 'cps_model_submit'),
							'Add'
						)
					)
				)
			)
		);

		echo $html;

	}

	/**
	* Check for Ajax call
	*
	* @since 1.0
	*/
	public function checkNonce( $pg, $value ){

		$check = ( $pg == 'post' )? sanitize_text_field( $_POST[$value] ) : sanitize_text_field( $_GET[$value] );
		if ( !wp_verify_nonce( $check , cps_nonce )) {
			exit( __('Wrong Nonce', '') );
		}else{
			return;
		}

	}

	/**
	* Call Posts Dummy content for starters
	*
	* @since 1.0
	*/
	public function dummy_starter() {

		if(get_option("cps_data") === false){
			update_option(
				"cps_data",
				array(
					'cps_1' => array(
						'status' => 'publish','name' => 'Homepage','Category' => '','post per page' => '5','order' => 'ASC','order by' => 'ID','post status' => 'publish','Author' => '','exclude current post' => '','desktop' => '4','tablet' => '2','mobile' => '1','skin' => $this->dummy_skin(),'skin_meta' => $this->dummy_skinmeta(),'excerpt length' => '20','after excerpt' => '...','link' => '','link to' => '1','set date' => '','from date' => '','to date' => '','img size' => 'medium_large','date format' => 'F j, Y','button text' => 'Read More','meta data' => ''
					)
				)
			);
		}

	}

	/**
	* Call Posts Dummy Skin
	*
	* @since 1.0
	*/
	public function dummy_skin() {

		return '["cps_skin_one_cps_img","cps_skin_one_cps_title","cps_skin_one_cps_date","cps_skin_one_cps_content","cps_skin_one_cps_tag","cps_skin_one_cps_category","cps_skin_one_cps_author","cps_skin_one_cps_button_link","cps_skin_one_cps_metadata","cps_skin_one_cps_metadataa","cps_skin_one_cps_metadatab","cps_skin_one_cps_metadatac","cps_skin_one_cps_metadatad","cps_skin_one_cps_metadatae"]';

	}

	/**
	* Call Posts Dummy Skin Meta
	*
	* @since 1.0
	*/
	public function dummy_skinmeta() {

		return '[{"cps_img":[{"active":true,"width":"100%","link":true}],"cps_title":[{"active":true,"width":"100%","link":true}],"cps_content":[{"active":true,"width":"100%"}],"cps_date":[{"active":true,"width":"100%"}],"cps_tag":[{"active":true,"width":"100%","link":true,"seperator":"|"}],"cps_category":[{"active":true,"width":"100%","link":true,"seperator":"|"}],"cps_author":[{"active":true,"width":"100%","link":true}],"cps_button_link":[{"active":true,"width":"100%"}],"cps_metadata":[{"active":false,"width":"100%"}],"cps_metadataa":[{"active":false,"width":"100%"}],"cps_metadatab":[{"active":false,"width":"100%"}],"cps_metadatac":[{"active":false,"width":"100%"}],"cps_metadatad":[{"active":false,"width":"100%"}],"cps_metadatae":[{"active":false,"width":"100%"}]}]';

	}

	/**
	* Call Posts value clone Ajax
	*
	* @since 1.0
	*/
	public function cps_clone() {

		$this->checkNonce('post','nonce');

		$get 	  = get_option('cps_data');
		$arrcount = count($get) + 1;
		$Id 	  = 'cps_' . $arrcount;
		$result   = array();

		if( isset($_REQUEST["main"]) ){

			$requested 	 = sanitize_text_field( $_REQUEST["main"] );
			$update 	 = $get[$requested];
			$result[$Id] = $update;

		}

		$arrange = array_merge($get,$result);
		update_option('cps_data',$arrange);
		echo json_encode(array('status' => 'cloned'));

		die();

	}

	/**
	* Call Posts add and update value Ajax
	*
	* @since 1.0
	*/
	public function cps_ajax() {

		$this->checkNonce('post','nonce');

		if(isset($_REQUEST["main"])){

			$requested 	 = sanitize_text_field( $_REQUEST["main"] );
			$get 	  	 = get_option('cps_data');
			$jsonData 	 = json_decode( stripslashes( $requested ), true );
			$cp 	  	 = callposts()->core;

			foreach( $jsonData as $x => $y ){

				$update = array(
					$y['cps_unique_id'] => array(
						'status' 		=> 'publish',
						'name' 			=> sanitize_text_field( $y['cps_parent_class'] ),
						'Category' 		=> sanitize_text_field( $y['cps_category_list'] ),
						'post per page' => (int) $y['cps_ppp'],
						'order' 		=> sanitize_text_field( $y['cps_order'] ),
						'order by' 		=> sanitize_text_field( $y['cps_order_by'] ),
						'post status' 	=> sanitize_text_field( $y['cps_post_status']),
						'Author' 		=> sanitize_text_field( $y['cps_author'] ),
						'exclude current post' => $y['cps_exclude_post'],
						'desktop' 		=> (int) $y['cps_desktop'],
						'tablet' 		=> (int) $y['cps_tablet'],
						'mobile' 		=> (int) $y['cps_mobile'],
						'skin' 			=> sanitize_text_field( $y['cps_skin'] ),
						'skin_meta' 	=> sanitize_text_field( $y['cps_skin_meta'] ),
						'excerpt length'=> (int) $y['cps_excerpt_length'],
						'after excerpt' => sanitize_text_field( $y['cps_after_excerpt'] ),
						'link' 			=> $y['cps_link'],
						'link to' 		=> (int) $y['cps_link_to'],
						'set date' 		=> $y['cps_set_date'],
						'from date' 	=> sanitize_text_field( $y['cps_from_date'] ),
						'to date' 		=> sanitize_text_field( $y['cps_to_date'] ),
						'img size' 		=> sanitize_text_field( $y['cps_image_size'] ),
						'date format' 	=> sanitize_text_field( $y['cps_date_format'] ),
						'button text' 	=> sanitize_text_field( $y['cps_button_text'] ),
						'meta data' 	=> sanitize_text_field( $y['cps_metadata'] ),
						'meta data a' 	=> sanitize_text_field( $y['cps_metadataa'] ),
						'meta data b' 	=> sanitize_text_field( $y['cps_metadatab'] ),
						'meta data c' 	=> sanitize_text_field( $y['cps_metadatac'] ),
						'meta data d' 	=> sanitize_text_field( $y['cps_metadatad'] ),
						'meta data e' 	=> sanitize_text_field( $y['cps_metadatae'] ),
					)
				);

			}
			$arrange = array_merge($get,$update);
			update_option('cps_data',$arrange);

		}
		echo json_encode(array('status' => 'added'));

		die();

	}

	/**
	* Call Posts value delete Ajax
	*
	* @since 1.0
	*/
	public function cps_delete() {

		$this->checkNonce('post','nonce');

		if(isset($_REQUEST["main"])){

			$requested 	 = sanitize_text_field( $_REQUEST["main"] );
			$get 		 = get_option('cps_data');

			$get[$requested]['status'] = 'deleted';
			update_option( 'cps_data', $get );

		}
		echo json_encode(array('status' => 'deleted'));

		die();

	}

	/**
	* Call Posts value delete Ajax
	*
	* @since 1.0
	*/
	public function cps_datequery($condition, $after, $before) {

		if(!empty($condition)){

			$query = array(
				array(
					'after'     => $after,
					'before'    => $before,
					'inclusive' => true,
				),
			);

		}else{
			$query = array();
		}

		return $query;

	}

}