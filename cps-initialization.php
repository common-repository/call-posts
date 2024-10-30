<?php
/**
* Call Posts Plugin Initialization class
*
* @since 1.0
*/

// Check if { Call Posts } Plugin does not exist
if ( ! class_exists( 'Call_Posts' ) ) {

	class Call_Posts {

		/**
		* Plugin Version
		*
		* @since 1.0
		* @access public
		* @var string
		*/
		public $plugin_version = '1.0';

		/**
		* Plugin Name
		*
		* @since 1.0
		* @access public
		* @var string
		*/
		public $plugin_name = 'Call Posts';

		/**
		* Plugin Slug
		*
		* @since 1.0
		* @access public
		* @var string
		*/
		public $slug = 'call-posts';

		/**
		* Plugin Donate URL
		*
		* @since 1.0
		* @access public
		* @var string
		*/
		public $donate = 'http://callposts.com/donate/';

		/**
		* Plugin Premium URL
		*
		* @since 1.0
		* @access public
		* @var string
		*/
		public $premium = 'http://premium.callposts.com/';

		/**
		* Plugin Security Nonce
		*
		* @since 1.0
		* @access public
		* @var string
		*/
		public $nonce = 'cps';

		/**
		* Plugin ini var
		*
		* @since 1.0
		* @access public
		*/
		public $callposts;

		/**
		* Call Posts Constructor
		*
		* @since 1.0.0
		*/
		public function __construct() {

			//Functions to run after/Before plugin activation/deactivation respectively
			register_activation_hook( cps_file, array( $this, 'cps_activate' ) );
			register_deactivation_hook( cps_file, array( $this, 'cps_deactivation' ) );

			//Important initializations
			$this->cps_define();
			$this->cps_require();
			$this->localize_plugin();

			add_action('init', array( $this, 'cps_admin_ini'));
			add_filter('plugin_action_links_' . plugin_basename(cps_file), array( $this, 'cps_link'));
			//add_filter('plugin_row_meta', array( $this, 'cps_upgrade_link' ), 10, 2 );

		}

		/**
		* Define Call Posts Constants
		*
		* @since 1.0
		*/
		public function cps_define() {

			define( 'cps_ver', $this->plugin_version );
			define( 'cps_plugin_slug', $this->slug );
			define( 'cps_plugin_name', $this->plugin_name );
			define( 'cps_premium', $this->premium );
			define( 'cps_donate', $this->donate );
			define( 'cps_nonce', $this->nonce );
			define( 'cps_dir_path', untrailingslashit( dirname( cps_file ) ) );
			define( 'cps_dir_url', untrailingslashit( plugin_dir_url( cps_file ) ) );

		}

		/**
		* Include Call Posts required core files
		*
		* @since 1.0
		*/
		public function cps_require() {

			require_once cps_dir_path . "/cps-widgets.php";
			require_once cps_dir_path . "/cps-skin.php";
			require_once cps_dir_path . "/cps-functions.php";
			require_once cps_dir_path . "/cps-core.php";

		}

		/**
		* Get class assigned from another
		*
		* @since 1.0
		*/
		public function __get( $prop ) {

			if ( array_key_exists( $prop, $this->callposts ) ) {
				return $this->callposts[ $prop ];
			}
			return $this->{$prop};

		}

		/**
		* Check isset(variable)
		*
		* @since 1.0
		*/
		public function __isset( $prop ) {

			return isset( $this->{$prop} ) || isset( $this->callposts[ $prop ] );

		}

		/**
		* Classes initialization
		*
		* @since 1.0
		*/
		public function cps_admin_ini() {

			$this->callposts['skin']  = new cps_skin();
			$this->callposts['func']  = new cps_functions();
			$this->callposts['core']  = new cps_core();

		}

		/**
		* Comparing value
		*
		* @since 1.0
		*/
		public function cps_compare( $check, $compare, $value ){

			$val = '';
			if(!empty($check)){
				$val = ($check == $compare)? $value : '';
			}
			return $val;

		}

		/**
		* Call Post dynamic select -> option selection
		*
		* @since 1.0
		*/
		public function cps_option( $get, $call, $value ){

			$varcheck = $this->cps_getvalue($get, $call, '');
			$val = '';
			if(!empty($varcheck)){
				$val = ($varcheck == $value)? 'selected' : '';
			}
			return $val;

		}

		/**
		* Call Post dynamic checkbox selection
		*
		* @since 1.0
		*/
		public function cps_checkbox( $get, $call, $value ){

			$varcheck = $this->cps_getvalue($get, $call, '');
			$val = (!empty($varcheck))? 'checked' : '';
			return $val;

		}

		/**
		* Get value from final data
		*
		* @since 1.0
		*/
		public function cps_getvalue( $get, $call, $default ){

			$data = get_option('cps_data');
			if(!empty($get)){
				if(isset($data[$get][$call])){
					return $data[$get][$call];
				}
			}else{
				return $default;
			}

		}

		/**
		* Call skin for respective Call Posts element
		*
		* @since 1.0
		*/
		public function cps_call( $id, $meta, $val ){

			$dummymeta 	   = callposts()->func->dummy_skinmeta();
			$meta_sortable = json_decode($this->cps_getvalue($id,'skin_meta',$dummymeta), true);
			foreach($meta_sortable as $x => $y){
				$gs = $y[$meta];
				foreach($gs as $z => $a){
					if(isset($a[$val])){
						return $a[$val];
					}
				}
			}

		}

		/**
		* Checks value is empty or not
		*
		* @since 1.0
		*/
		public function cps_ifhas( $check, $value ){

			$val = (!empty($check))? $value : '';
			return $val;

		}

		/**
		* Call Post get all terms
		*
		* @since 1.0
		*/
		public function get_all_terms() {

			$terms_list = array();
			$post_terms = array();
			$builtin_post_types = array(
				'post' => 'post'
			);
			$custom_post_types = get_post_types(
				array('_builtin' => false)
			);
			$post_types = array_merge( $builtin_post_types, $custom_post_types );

			foreach ( $post_types as $post_type => $name ) {
				$taxonomies = get_object_taxonomies( $post_type, 'objects' );
				if ( $taxonomies ) {
					$taxonomies_slug = array();
					foreach ( $taxonomies as $taxonomy => $settings ) {
						if( $taxonomy == 'category' ){
							if ( ! $settings->publicly_queryable && ! $settings->public && ! $settings->show_ui && ! $settings->show_tagcloud ) {
								unset( $taxonomies[ $taxonomy ] );
								continue;
							}
							// if this taxonomy was already proceeded
							if ( isset($post_terms[$taxonomy]) ) {
								$terms_list[$post_type]['taxonomies'][$taxonomy] = $post_terms[$taxonomy];
							} else {
								$taxonomies_slug[] = $taxonomy;
							}
						}else{}
					}
					if ( $taxonomies_slug ) {
						// get all terms from current taxonomy
						$terms = get_terms($taxonomies_slug, array('hide_empty' => false, 'pad_counts' => false));
						if ( $terms ) {
							foreach ( $terms as $term ) {
								if ( !isset($terms_list[$post_type]['taxonomies'][$term->taxonomy]['terms'][$term->slug]) ) {
									$terms_list[$post_type]['taxonomies'][$term->taxonomy]['terms'][$term->slug] = array(
										'id'       		 => (int) $term->term_id,
										'slug'     		 => (string) $term->slug,
										'name'     		 => (string) $term->name,
										'taxonomy' 		 => (string) $term->taxonomy,
										'numbe of posts' => (int) $term->count,
										'parent'   		 => (int) $term->parent,
									);
								}
							}
						}
					}
				}
			}

			return $terms_list;

		}

		/**
		* Call Post get all Categories list
		*
		* @since 1.0
		*/
		public function category_list($data) {

			$cat_val = $this->get_all_terms();
			$html 	 = '';
			$html 	.= $this->render_skin('option',array('value' => ''), __('All Categories','call-posts') );

			foreach( $cat_val as $a => $b){
				foreach( $b as $c => $d){
					foreach( $d as $e => $f){
						foreach( $f as $g => $h){
							foreach( $h as $i => $j){
								$cat_v	= $j['name'];
								$val 	= ($data == $cat_v)? 'selected':'';
								$html  .= $this->render_skin('option',array('value' => $cat_v, $val => ''),$cat_v);
							}
						}
					}
				}
			}

			return $html;

		}

		/**
		* Get all authors
		*
		* @since 1.0
		*/
		public function author_list($data) {

			$users = get_users( array( 'role__in' => array( 'administrator', 'editor', 'author', 'contributor' ) ));
			$html  = $this->render_skin('option',array('value' => ''),'All');

			foreach ($users as $user) {
				$usr = $user->display_name;
				$val = ($data == $usr)?'selected':'';
				$html .= $this->render_skin('option',array('value' => $usr, $val => ''),$usr);
			}

			return $html;

		}

		/**
		* Inizialised during Activation only
		*
		* @since 1.0
		*/
		public function cps_activate() {

			update_site_option( 'cps_show_notice', 1 );
			update_site_option( 'cps_installed_date', date('Y-m-d H:i:s') );

		}

		/**
		* Inizialised during Deactivation only
		*
		* @since 1.0
		*/
		public function cps_deactivation() {
			//Nothing as of now
		}

		/**
		* Adds a settings link to Call Posts plugin list
		*
		* @since 1.0
		*/
		public function cps_link( $links ) {

			$links[] = '<a href="'.admin_url( 'admin.php?page='. cps_plugin_slug .'' ).'">' . __('Settings') . '</a>';
			return $links;

		}

		/**
		* Adds a Donate and Premium link to Call Posts plugin list
		*
		* @since 1.0
		*/
		public function cps_upgrade_link( $links, $file ) {

			$plugin = plugin_basename(cps_file);
			if ( $file == $plugin ) {
				return array_merge(
					$links,
					array(
						'<a href="'.$this->premium.'" style="font-weight:bold">' . __( 'Premium', 'egl-text' ) . '</a>',
						'<a href="'.$this->donate.'" style="font-weight:bold">' . __( 'Donate', 'egl-text' ) . '</a>'
					)
				);
			}
			return $links;

		}

		/**
		* Renders Categories of post in Frontend
		*
		* @since 1.0
		*/
		public function get_cat($sep,$link) {

			$allcat = wp_get_post_categories( get_the_ID() );
			$count	= count($allcat);
			$i		= 0;
			$hh		= '';

			foreach($allcat as $c){
			  $seperator = (++$i === $count)? '' : $sep;
			  $cat = get_category( $c );
			  $cat_id = get_cat_ID( $cat->name );
			  if(!empty($link)){
				$hh .= $this->render_skin(
					'p',
					array('class' => 'category-'.$cat->slug.''),
					$this->render_skin(
						'a',
						array( 'href' => esc_url( get_category_link( $cat->term_id ) ) ),
						$cat->name
					) . $seperator
				);
			  }else{
				$hh .= $this->render_skin(
					'p',
					array('class' => 'category-'.$cat->slug.''),
					$cat->name . $seperator
				);
			  }
			}

			return $hh;

		}

		/**
		* Renders Button text in Frontend
		*
		* @since 1.0
		*/
		public function button_link($text) {

			return sprintf( '<a class="read-more" href="%1$s">%2$s</a>',
				get_permalink(),
				$text
			);

		}

		/**
		* Renders Meta data in Frontend
		*
		* @since 1.0
		*/
		public function meta_render($text) {

			if( !empty($text) ){
				return get_post_meta( get_the_ID(), $text, true );
			}

		}

		/**
		* Renders Tags of post in Frontend
		*
		* @since 1.0
		*/
		public function get_tag($sep,$link) {

			$terms	= wp_get_post_terms(get_the_ID(), 'post_tag', array("fields" => "all"));
			$count 	= count($terms);
			$i 		= 0;
			$tag 	= '';

			foreach($terms as $a => $b){
				$seperator = (++$i === $count)? '' : $sep;
				if(!empty($link)){
					$tag .= $this->render_skin(
						'p',
						array('class' => 'tag-'.$b->slug.''),
						$this->render_skin(
							'a',
							array( 'href' => esc_url( get_category_link( $b->term_id ) ) ),
							$b->name
						) . $seperator
					);
				}else{
					$tag .= $this->render_skin(
						'p',
						array('class' => 'tag-'.$b->slug.''),
						$b->name . $seperator
					);
				}
			}

			return $tag;

		}

		/**
		* Renders Tags of post in Frontend
		*
		* @since 1.0
		*/
		public function get_auth($link) {

			if( !empty($link) ){
				$auth = $this->render_skin(
					'a',
					array('href' => get_author_posts_url( get_the_author_meta( 'ID' ) )),
					get_the_author()
				);
			}else{
				$auth = get_the_author();
			}
			return $auth;

		}

		/**
		* Assigns html element as per skin format
		*
		* @since 1.0
		*/
		public function cpss_replace( $name, $id ) {

			switch ($name) {
				case "cps_img":
					$ret = ( !empty($this->cps_call($id, 'cps_img','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-post-img', 'style' => 'width:'.$this->cps_call($id, 'cps_img','width')),
						(!empty($this->cps_call($id, 'cps_img','link')))? '<a href="'.get_permalink().'">'.get_the_post_thumbnail(null,$this->cps_getvalue($id,'img size','post-thumbnail')).'</a>' : get_the_post_thumbnail(null,$this->cps_getvalue($id,'img size','post-thumbnail'))
					): '';
					break;
				case "cps_title":
					$ret = ( !empty($this->cps_call($id, 'cps_title','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-post-title', 'style' => 'width:'.$this->cps_call($id, 'cps_title','width')),
						(!empty($this->cps_call($id, 'cps_title','link')))? '<a href="'.get_permalink().'">'.get_the_title().'</a>' : get_the_title()
					): '';
					break;
				case "cps_author":
					$ret = ( !empty($this->cps_call($id, 'cps_author','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-post-author', 'style' => 'width:'.$this->cps_call($id, 'cps_author','width')),
						$this->get_auth($this->cps_call($id, 'cps_author', 'link'))
					) : '';
					break;
				case "cps_content":
					$ret = ( !empty($this->cps_call($id, 'cps_content','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-post-content', 'style' => 'width:'.$this->cps_call($id, 'cps_content','width')),
						wp_strip_all_tags(
							wp_trim_words(
								get_the_content(),
								$this->cps_getvalue($id,'excerpt length','15'),
								$this->cps_getvalue($id,'after excerpt','...')
							)
						)
					) : '';
					break;
				case "cps_date":
					$ret = ( !empty($this->cps_call($id, 'cps_date','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-post-date', 'style' => 'width:'.$this->cps_call($id, 'cps_date','width')),
						get_the_date($this->cps_getvalue($id,'date format','l F j, Y'))
					) : '';
					break;
				case "cps_tag":
					$ret = ( !empty($this->cps_call($id, 'cps_tag','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-post-tag', 'style' => 'width:'.$this->cps_call($id, 'cps_tag','width')),
						$this->get_tag($this->cps_call($id, 'cps_tag','seperator'),$this->cps_call($id, 'cps_tag','link'))
					) : '';
					break;
				case "cps_category":
					$ret = ( !empty($this->cps_call($id, 'cps_category','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-post-category', 'style' => 'width:'.$this->cps_call($id, 'cps_category','width')),
						$this->get_cat($this->cps_call($id, 'cps_category', 'seperator'),$this->cps_call($id, 'cps_category', 'link'))
					) : '';
					break;
				case "cps_button_link":
					$ret = ( !empty($this->cps_call($id, 'cps_button_link','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-button-link', 'style' => 'width:'.$this->cps_call($id, 'cps_button_link','width')),
						$this->button_link($this->cps_getvalue($id,'button text','Read More'))
					) : '';
					break;
				case "cps_metadata":
					$ret = ( !empty($this->cps_call($id, 'cps_metadata','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-metadata', 'style' => 'width:'.$this->cps_call($id, 'cps_metadata','width')),
						$this->meta_render($this->cps_getvalue($id,'meta data',''))
					) : '';
					break;
				case "cps_metadataa":
					$ret = ( !empty($this->cps_call($id, 'cps_metadataa','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-metadataa', 'style' => 'width:'.$this->cps_call($id, 'cps_metadataa','width')),
						$this->meta_render($this->cps_getvalue($id,'meta data a',''))
					) : '';
					break;
				case "cps_metadatab":
					$ret = ( !empty($this->cps_call($id, 'cps_metadatab','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-metadatab', 'style' => 'width:'.$this->cps_call($id, 'cps_metadatab','width')),
						$this->meta_render($this->cps_getvalue($id,'meta data b',''))
					) : '';
					break;
				case "cps_metadatac":
					$ret = ( !empty($this->cps_call($id, 'cps_metadatac','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-metadatac', 'style' => 'width:'.$this->cps_call($id, 'cps_metadatac','width')),
						$this->meta_render($this->cps_getvalue($id,'meta data c',''))
					) : '';
					break;
				case "cps_metadatad":
					$ret = ( !empty($this->cps_call($id, 'cps_metadatad','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-metadatad', 'style' => 'width:'.$this->cps_call($id, 'cps_metadatad','width')),
						$this->meta_render($this->cps_getvalue($id,'meta data d',''))
					) : '';
					break;
				case "cps_metadatae":
					$ret = ( !empty($this->cps_call($id, 'cps_metadatae','active')) )? $this->render_skin(
						'div',
						array('class' => 'cps-metadatae', 'style' => 'width:'.$this->cps_call($id, 'cps_metadatae','width')),
						$this->meta_render($this->cps_getvalue($id,'meta data e',''))
					) : '';
					break;
				default:
					$ret = "NONE";
			}
			return $ret;

		}

		/**
		* construct HTML elements easily ( MAIN )
		*
		* @since 1.0
		*/
		public function render_skin( $tag = '', $attrs = array(), $content = '' ) {

			$html 	  = '';
			$attr 	  = '';
			$contents = '';

			if($tag != 'style'){

				foreach($attrs as $assign => $value){
					$attr .= $assign .' = "'. $value .'" ';
				}
				if($tag != 'input'){
					$html .= '<'.$tag.' '.$attr.'>';
					$html .= $content;
					$html .= '</'.$tag.'>';
				}else{
					$html .= '<'.$tag.' '.$attr.'/>' . $content;
				}

			}else{

				foreach($attrs as $a => $b){
					//class
					$numItems = count($b['class']);
					$i = 0;
					foreach($b['class'] as $c => $d){
						if(++$i === $numItems) {
							$seperator = '';
						}else{
							$seperator = ',';
						}
						$contents .= (isset($d) ? str_replace(":"," ",str_replace(" ",".",$d)).$seperator : '');
					}
					$contents .= '{';
					//style
					foreach($b['value'] as $e => $f){
						$contents .= $e .' : '. $f .';';
					}
					$contents .= '}';
				}

				$html .= '<'.$tag.'>';
				$html .= $contents;
				$html .= '</'.$tag.'>';

			}

			return $html;

		}

		/**
		* Convert Call Posts to different languages
		*
		* @since 1.0
		*/
		public function localize_plugin() {

			load_plugin_textdomain(
				'call-posts',
				false,
				plugin_basename( dirname( cps_file ) ) . '/languages'
			);

		}

		/**
		* Inizialize all of Call Posts Plugin elements
		*
		* @since 1.0
		*/
		public static function init() {

			static $instance = false;
			if ( ! $instance ) {
				$instance = new Call_Posts();
			}
			return $instance;

		}

	}

	// Call Call_Posts class
	function callposts() {
		return Call_Posts::init();
	}

	// Initialize Call Posts Plugin
	callposts();

}
