<?php
/**
* Call Posts Core Functions class
*
* @since 1.0.0
*/
class cps_core {

	/**
	* Call Posts Constructor
	*
	* @since 1.0.0
	*/
	public function __construct() {

		add_action('admin_init', array( $this, 'cps_post_notice') );
		add_action('wp_ajax_cps_notice_dismiss', array( $this, 'cps_notice_dismiss' ) );
		add_shortcode('cps', array( $this, 'cps_shortcode_get') );

	}

	/**
	* Dashboard Content
	*
	* @since 1.0
	*/
	public function cps_dashboard($cp){

		$get_data = get_option('cps_data');
		$count 	  = 1;
		$loop 	  = '';

		if(!empty($get_data)){

			foreach($get_data as $num => $val){
				if($val['status'] == 'publish'){
					$edit  	 = admin_url( "admin.php?page=".cps_plugin_slug."&id=$num&action=edit" );
					$delete  = admin_url( "admin.php?page=".cps_plugin_slug."&id=$num&action=trash" );
					$loop 	.= $cp->render_skin(
						'tr',
						array(),
						$cp->render_skin('td',array(),$count).
						$cp->render_skin('td',array(),$val['name']).
						$cp->render_skin('td',array( 'onclick' => esc_js('cps_copy(this)') ),'[cps id="'.$this->cps_replace("cps_","",$num).'"]').
						$cp->render_skin(
							'td',
							array(),
							$cp->render_skin(
								'span',
								array('class' => 'edit'),
								$cp->render_skin('a', array('href' => $edit),'Edit')
							).
							$cp->render_skin('span',array(),' | ').
							$cp->render_skin(
								'span',
								array('class' => 'edit'),
								$cp->render_skin('span', array('class' => 'cps-clone-post', 'data-id' => $num),'Clone').
								$cp->render_skin('span', array('class' => 'cps_loader_del'),'')
							).
							$cp->render_skin('span',array(),' | ').
							$cp->render_skin(
								'span',
								array('class' => 'edit'),
								$cp->render_skin('span', array('class' => 'cps-trash-post', 'data-id' => $num),'Trash').
								$cp->render_skin('span', array('class' => 'cps_loader_del'),'')
							)
						)
					);
					$count++;
				}
			}

		}
		return $loop;

	}

	/**
	* String Replace
	*
	* @since 1.0
	*/
	public function cps_replace($override, $overridewith, $string){

		return str_replace( $override, $overridewith, $string );

	}

	/**
	* Responsive class value
	*
	* @since 1.0
	*/
	public function cps_responsive($arg){

		return (12/$arg);

	}

	/**
	* create dynamic link
	*
	* @since 1.0
	*/
	public function cps_linkit($linkthis,$tag,$href = ''){

		$link = (!empty($href))? $href : get_permalink();
		if($tag == 'a'){
			$tagfinal = '<a href="'. $link .'">'. $linkthis .'</a>';
		}else{
			$renderatag = "window.open( '". $link ."','_top' ); return false;";
			$tagfinal = '<div class="cps-linked" onclick="'.$renderatag.'">'. $linkthis .'</a>';
		}
		return $tagfinal;

	}

	/**
	* Get Data over Widget and media button
	*
	* @since 1.0
	*/
	public function cps_widget($title=''){

		$get_data = get_option('cps_data');
		$cp 	  = callposts();
		$arr 	  = array();
		$data 	  = '';

		if(!empty($get_data)){

			foreach($get_data as $num => $val){
				if(!empty($title)){
					if($val['status'] == 'publish'){
						$data .= $cp->render_skin(
							'option',
							array('value' => $num, ((esc_attr( $title ) == $num)? 'selected' : '') => ''),
							$val['name']
						);
					}
				}else{
					if($val['status'] == 'publish'){
						$data .= $cp->render_skin(
							'option',
							array('value' => $this->cps_replace("cps_","",$num)),
							$val['name']
						);
					}
				}
			}

		}
		return $data;

	}

	/**
	* Call Posts Shortcode
	*
	* @since 1.0
	*/
	public function cps_shortcode_get($atts) {

		$cpsData = get_option( 'cps_data' );
		$final 	 = '';
		if(! empty($cpsData)){
			extract(
				shortcode_atts(
					apply_filters( 'cps_shortcode_attributes' ,array('id' => '') ),
					$atts
				)
			);
		}
		$final .= $this->final_call("cps_{$id}");
		return $final;

	}

	/**
	* Call Posts Shortcode
	*
	* @since 1.0
	*/
	public function cps_orderby_options($id) {

		$options 		= array('ID', 'author', 'title', 'name', 'type', 'date', 'modified', 'parent', 'rand', 'comment_count', 'menu_order');
		$return_options = '';

		foreach($options as $num => $value){
			$return_options .= callposts()->render_skin(
				'option',
				array('value' => $value, callposts()->cps_option($id,'order by',$value) => ''),
				$value
			);
		}

		return $return_options;

	}

	/**
	* Call Posts Shortcode
	*
	* @since 1.0
	*/
	public function cps_poststatus_options($id) {

		$options 		= array('publish', 'draft', 'future', 'private', 'trash');
		$return_options = '';

		foreach($options as $num => $value){
			$return_options .= callposts()->render_skin(
				'option',
				array('value' => $value, callposts()->cps_option($id,'post status',$value) => ''),
				$value
			);
		}

		return $return_options;
	}

	/**
	* Construct Skin element
	*
	* @since 1.0
	*/
	public function cpss_construct_skin( $skin,$id ) {

		$html = '';
		foreach($skin as $num => $value){
			$html .= callposts()->cpss_replace($this->cps_replace("cps_skin_one_","",$value),$id);
		}
		return $html;

	}

	/**
	* Construct Widget element
	*
	* @since 1.0
	*/
	public function cps_construct_widget( $attrone,$attrtwo,$title ) {

		$cp   = callposts();
		$arr  = array();
		$html = $cp->render_skin(
			'table',
			array('class' => 'cps_widget_class'),
			$cp->render_skin(
				'tr',
				$arr,
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin('label',$arr,'Source:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'select',
						array('class'=>'widefat', 'type'=>'text', 'id'=>$attrone, 'name'=>$attrtwo),
						$cp->render_skin(
							'option',
							array('value' => 'none'),
							'select'
						) . $cp->core->cps_widget($title)
					)
				)
			)
		);

		return $html;

	}

	/**
	* Get DB used across Call Posts plugin
	*
	* @since 1.0
	*/
	public function cps_db($select) {

		return get_option($select);

	}

	/**
	* Renders final output
	*
	* @since 1.0
	*/
	public function final_call($id){

		$cpsData 		= get_option( 'cps_data' );
		$cps 			= callposts()->func;
		$final_content	= '';

		if(array_key_exists($id,$cpsData)){

			if($cpsData[$id]['status'] == 'publish'){

				$render = $cpsData[$id];
				$argsss = array(
					'author_name' => $render['Author'],
					'category_name' => $render['Category'],
					'date_query' => $cps->cps_datequery($render['set date'], $render['from date'], $render['to date']),
					'post_status' => $render['post status'],
					'order'	=> $render['order'],
					'orderby' => $render['order by'],
					'posts_per_page' => $render['post per page'],
					'post__not_in' => (!empty($render['exclude current post']))? array(get_the_ID()) : '',
					'offset' => (!empty($render['link']))? $render['link to'] : 0,
				);
				$bipass_arg = array(
					'dt' => $render['desktop'],
					'lt' => $render['tablet'],
					'm'	=> $render['mobile'],
					'skin' => $render['skin'],
					'customcss' => $render['name'],
				);

				$cpsQuery = new WP_Query( apply_filters( 'cps_posts_args', $argsss ) );
				while ( $cpsQuery->have_posts() ) :
					$cpsQuery->the_post();
					global $post;
					$final_content .= $this->assign_skin($bipass_arg,$id);
				endwhile;
				wp_reset_postdata();

				$final = callposts()->render_skin(
					'div',
					array('id' => $id, 'class' => 'cps-row', 'name' => $bipass_arg['customcss']),
					$final_content
				);

			}else{
				$final = callposts()->render_skin(
					'div',
					array('class' => 'cps-already-deleted-element'),
					''
				);
			}

			return $final;

		}

	}

	/**
	* Renders Frontend skin for respective element
	*
	* @since 1.0
	*/
	public function assign_skin($all_arg,$id) {

		$skin 			  = $all_arg['skin'];
		$response_desktop = $this->cps_replace(".","-",$this->cps_responsive($all_arg['dt']));
		$response_tablet  = $this->cps_replace(".","-",$this->cps_responsive($all_arg['lt']));
		$response_mobile  = $this->cps_replace(".","-",$this->cps_responsive($all_arg['m']));

		if(!empty($skin)){

			return callposts()->render_skin(
				'div',
				array('class' => "cps-child cps-dt-col-{$response_desktop} cps-lt-col-{$response_tablet} cps-m-col-{$response_mobile}"),
				(callposts()->cps_getvalue($id,'link to','15') == 'all')? $this->cps_linkit($this->cpss_construct_skin(json_decode($skin),$id),'div') : callposts()->render_skin('div',array('class' => $id),$this->cpss_construct_skin(json_decode($skin),$id))
			);

		}else{
			return;
		}

	}

	/**
	* Get number of Days plugins active
	*
	* @since 1.0
	*/
	public function cps_days_notice() {

		$cps_installed  =  get_option( 'cps_installed_date', '');
		$cps_installed  =  date_create( $cps_installed );
		$current_date   =  date_create( date('Y-m-d H:i:s') );
		$date_diff      =  date_diff( $cps_installed, $current_date );

		if ( $date_diff->format("%d") < 7 ) {
			return true;
		}else{
			return;
		}

	}

	/**
	* Call Posts Notice ( Give Ratings )
	*
	* @since 1.0
	*/
	public function cps_show_update_notice() {

		global $wp_version;

		if( !current_user_can( 'manage_options') ){
			return;
		}

		if( !empty( $this->cps_days_notice() ) ){
			return;
		}

		$message = '<h2 style="margin: 10px 0;border-right: 2px solid black;padding-right: 15px;">CallPosts</h2><p style="margin-left: 15px;">Awesome, you\'ve been using the for more than 1 week. May we ask you to give it a 5-star rating on WordPress? | <a href="https://wordpress.org/plugins/call-posts/" target="_blank">Ok, you deserved it</a> | <span class="custom-notice-dismiss">I already did</span> | <span class="custom-notice-dismiss">No, not good enough</span></p>';

		if( version_compare($wp_version, '4.2') < 0 ){
			$message .= '<a id="cps-post-notice" href="javascript:cps_notice_dismiss();">'. __('Dismiss this notice.', 'call-posts') .'</a>';
		}

		$notice = '<div id="cps-post-notice" class="notice is-dismissible" style="margin-top: 10px;border: 1px solid #ccd0d4;"><div style="display: flex;justify-content: left;">'. $message .'</div></div>';

		echo $notice;

	}

	/**
	* Call Posts Dismiss Notice ( Give Ratings Notice - Ajax Function )
	*
	* @since 1.0
	*/
	public function cps_notice_dismiss() {

		$result = update_site_option('cps_show_notice', 0);
		return $result;
		wp_die();

	}

	/**
	* Call Posts control Notice ( Give Ratings )
	*
	* @since 1.0
	*/
	public function cps_post_notice() {

		if (get_site_option('cps_show_notice') == 1){

			// Check for multisite
			if(is_multisite()){
				add_action( 'network_admin_notices', array( $this, 'cps_show_update_notice' ) );
			} else {
				add_action( 'admin_notices', array( $this, 'cps_show_update_notice' ) );
			}

		}

	}

	/**
	* Pass skin structure in admin popup
	*
	* @since 1.0
	*/
	public function getskin($id) {

		$cps 	  = callposts();
		$arr 	  = array();
		$sortable = json_decode($cps->cps_getvalue($id,'skin',$cps->func->dummy_skin()));
		$html 	  = '';

		if(! empty($sortable)){

			foreach($sortable as $num => $element){

				$ele_name = str_replace("cps_skin_one_cps_","",$element);
				if($ele_name == 'button_link'){
					$element_name = str_replace("_link","",$ele_name);
				}elseif($ele_name == 'metadata' || $ele_name == 'metadataa' || $ele_name == 'metadatab' || $ele_name == 'metadatac' || $ele_name == 'metadatad' || $ele_name == 'metadatae'){
					$element_name = 'Meta Data';
				}else{
					$element_name = $ele_name;
				}

				$checked = (!empty($cps->cps_call($id, 'cps_'.$ele_name,'active')))? 'checked="checked"' : '';
				$addClass = (!empty($cps->cps_call($id, 'cps_'.$ele_name,'active')))? 'checked-cps-element' : 'unchecked-cps-element';

				$html .= $cps->render_skin(
					'div',
					array('id' => $element),
					$cps->render_skin(
						'div',
						array('class' => 'custom-container '.$addClass.''),
						$cps->render_skin(
							'p',
							$arr,
							$cps->render_skin(
								'input',
								array( 'type' => 'checkbox', 'class' => 'skin-checkbox', 'name' => 'cps_'.$ele_name.'[active]', $checked => '' ),
								$element_name
							)
						).
						$cps->render_skin(
							'span',
							array('class' => 'dashicons dashicons-admin-generic'),
							''
						)
					).
					$cps->render_skin(
						'div',
						array('class' => 'custom-container-settings'),
						$cps->skin->cps_skin_settings($ele_name,$id)
					)
				);

			}

		}

		return $html;

	}

}