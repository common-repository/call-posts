<?php
/**
* Call Posts Render Skin elements
*
* @since 1.0
*/
class cps_skin {

	/**
	* Call Posts Image Settings
	*
	* @since 1.0
	*/
	public function cps_img_func($element,$id) {

		$cp  	 = callposts();
		$arr 	 = array();
		$checked = (!empty($cp->cps_call($id, 'cps_'.$element,'link')))? 'checked="checked"' : '';

		return $cp->render_skin(
			'table',
			$arr,
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_image_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Width:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[width]', 'value' => $cp->cps_call($id, 'cps_'.$element,'width') ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_image_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Image Size:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'select',
						array('class' => 'widefat cps_image_size' ,'type' => 'text'),
						$cp->render_skin('option',array('value'=>'thumbnail', $cp->cps_option($id,'img size','thumbnail') => ''),'Thumbnail (150px × 150px)').
						$cp->render_skin('option',array('value'=>'medium', $cp->cps_option($id,'img size','medium') => ''),'Medium (300px × 300px)').
						$cp->render_skin('option',array('value'=>'medium_large', $cp->cps_option($id,'img size','medium_large') => ''),'Medium Large (768px × auto)').
						$cp->render_skin('option',array('value'=>'large', $cp->cps_option($id,'img size','large') => ''),'Large (1024px × 1024px)')
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_image_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Link to inner page:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'checkbox', 'name' => 'cps_'.$element.'[link]', $checked => '' ),
						''
					)
				)
			)
		);

	}

	/**
	* Call Posts Title Settings
	*
	* @since 1.0
	*/
	public function cps_title_func($element,$id) {

		$cp 	 = callposts();
		$arr 	 = array();
		$checked = (!empty($cp->cps_call($id, 'cps_'.$element,'link')))? 'checked="checked"' : '';

		return $cp->render_skin(
			'table',
			$arr,
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_image_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Width:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[width]', 'value' => $cp->cps_call($id, 'cps_'.$element,'width') ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_image_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Link to inner page:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'checkbox', 'name' => 'cps_'.$element.'[link]', $checked => '' ),
						''
					)
				)
			)
		);

	}

	/**
	* Call Posts Author Settings
	*
	* @since 1.0
	*/
	public function cps_author_func($element,$id) {

		$cp 	 = callposts();
		$arr 	 = array();
		$checked = (!empty($cp->cps_call($id, 'cps_'.$element,'link')))? 'checked="checked"' : '';

		return $cp->render_skin(
			'table',
			$arr,
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_image_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Width:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[width]', 'value' => $cp->cps_call($id, 'cps_'.$element,'width') ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_image_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Link to Author:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'checkbox', 'name' => 'cps_'.$element.'[link]', $checked => '' ),
						''
					)
				)
			)
		);

	}

	/**
	* Call Posts Content Settings
	*
	* @since 1.0
	*/
	public function cps_content_func($element,$id) {

		$cp 	 = callposts();
		$arr 	 = array();
		$checked = (!empty($cp->cps_call($id, 'cps_'.$element,'link')))? 'checked="checked"' : '';

		return $cp->render_skin(
			'table',
			$arr,
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_excerpt'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Width:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[width]', 'value' => $cp->cps_call($id, 'cps_'.$element,'width') ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_excerpt'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Max Content Length:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array('type'=>'number','class'=>'widefat cps_excerpt_length','value'=> $cp->cps_getvalue($id,'excerpt length','15'),'min'=>'5'),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_excerpt'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'After Max Content:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array('type' => 'text', 'class' => 'widefat cps_after_excerpt', 'value' => $cp->cps_getvalue($id,'after excerpt','...') ),
						''
					)
				)
			)
		);

	}

	/**
	* Call Posts Date Settings
	*
	* @since 1.0
	*/
	public function cps_date_func($element,$id) {

		$cp 	 = callposts();
		$arr 	 = array();
		$checked = (!empty($cp->cps_call($id, 'cps_'.$element,'link')))? 'checked="checked"' : '';

		return $cp->render_skin(
			'table',
			$arr,
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_date_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Width:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[width]', 'value' => $cp->cps_call($id, 'cps_'.$element,'width') ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_date_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Date Format:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array('type' => 'text', 'class' => 'widefat cps_date_format', 'value' => $cp->cps_getvalue($id,'date format','l F j, Y') ),
						''
					)
				)
			)
		);

	}

	/**
	* Call Posts Meta Data Settings
	*
	* @since 1.0
	*/
	public function cps_meta_func($element,$id) {

		$cp  = callposts();
		$arr = array();

		return $cp->render_skin(
			'table',
			$arr,
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_meta_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Width:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[width]', 'value' => $cp->cps_call($id, 'cps_'.$element,'width') ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_meta_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Meta Name:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array('type' => 'text', 'class' => 'widefat cps_metadata', 'value' => $cp->cps_getvalue($id,'meta data','') ),
						''
					)
				)
			)
		);

	}

	/**
	* Call Posts Tags Settings
	*
	* @since 1.0
	*/
	public function cps_tags_func($element,$id) {

		$cp 	 = callposts();
		$arr 	 = array();
		$checked = (!empty($cp->cps_call($id, 'cps_'.$element,'link')))? 'checked="checked"' : '';

		return $cp->render_skin(
			'table',
			$arr,
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_button_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Width:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[width]', 'value' => $cp->cps_call($id, 'cps_'.$element,'width') ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_image_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Link to Tags:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'checkbox', 'name' => 'cps_'.$element.'[link]', $checked => '' ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_image_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Seperator:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[seperator]', 'value' => $cp->cps_call($id, 'cps_'.$element,'seperator') ),
						''
					)
				)
			)
		);

	}

	/**
	* Call Posts Category Settings
	*
	* @since 1.0
	*/
	public function cps_category_func($element,$id) {

		$cp 	 = callposts();
		$arr 	 = array();
		$checked = (!empty($cp->cps_call($id, 'cps_'.$element,'link')))? 'checked="checked"' : '';

		return $cp->render_skin(
			'table',
			$arr,
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_button_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Width:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[width]', 'value' => $cp->cps_call($id, 'cps_'.$element,'width') ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_image_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Link to Category:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'checkbox', 'name' => 'cps_'.$element.'[link]', $checked => '' ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_image_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Seperator:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[seperator]', 'value' => $cp->cps_call($id, 'cps_'.$element,'seperator') ),
						''
					)
				)
			)
		);

	}

	/**
	* Call Posts Button Settings
	*
	* @since 1.0
	*/
	public function cps_button_func($element,$id) {

		$cp 	 = callposts();
		$arr 	 = array();
		$checked = (!empty($cp->cps_call($id, 'cps_'.$element,'link')))? 'checked="checked"' : '';

		return $cp->render_skin(
			'table',
			$arr,
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_button_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Width:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[width]', 'value' => $cp->cps_call($id, 'cps_'.$element,'width') ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_button_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Button Text:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array('type' => 'text', 'class' => 'widefat cps_button_text', 'value' => $cp->cps_getvalue($id,'button text','Read More') ),
						''
					)
				)
			)
		);

	}

	/**
	* Call Posts Meta Data Settings
	*
	* @since 1.0
	*/
	public function cps_meta_custom_func($element,$id,$metaid) {

		$cp  = callposts();
		$arr = array();

		return $cp->render_skin(
			'table',
			$arr,
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_meta_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Width:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array( 'type' => 'text', 'name' => 'cps_'.$element.'[width]', 'value' => $cp->cps_call($id, 'cps_'.$element,'width') ),
						''
					)
				)
			).
			$cp->render_skin(
				'tr',
				array('valign' => 'top' ,'data-id' => 'cps_meta_settings'),
				$cp->render_skin(
					'td',
					array('scope' => 'row'),
					$cp->render_skin('label',$arr,'Meta Name:')
				).
				$cp->render_skin(
					'td',
					$arr,
					$cp->render_skin(
						'input',
						array('type' => 'text', 'class' => 'widefat cps_metadata'.$metaid.'', 'value' => $cp->cps_getvalue($id,'meta data '.$metaid.'','') ),
						''
					)
				)
			)
		);

	}

	/**
	* Call Posts Skin Settings
	*
	* @since 1.0
	*/
	public function cps_skin_settings($element,$id) {

		$ret = '';

		switch ('cps_' . $element) {
			case "cps_img":
				$ret .= $this->cps_img_func($element,$id);
				break;
			case "cps_title":
				$ret .= $this->cps_title_func($element,$id);
				break;
			case "cps_author":
				$ret .= $this->cps_author_func($element,$id);
				break;
			case "cps_content":
				$ret .= $this->cps_content_func($element,$id);
				break;
			case "cps_date":
				$ret .= $this->cps_date_func($element,$id);
				break;
			case "cps_tag":
				$ret .= $this->cps_tags_func($element,$id);
				break;
			case "cps_category":
				$ret .= $this->cps_category_func($element,$id);
				break;
			case "cps_button_link":
				$ret .= $this->cps_button_func($element,$id);
				break;
			case "cps_metadata":
				$ret .= $this->cps_meta_func($element,$id);
				break;
			case "cps_metadataa":
				$ret .= $this->cps_meta_custom_func($element,$id,'a');
				break;
			case "cps_metadatab":
				$ret .= $this->cps_meta_custom_func($element,$id,'b');
				break;
			case "cps_metadatac":
				$ret .= $this->cps_meta_custom_func($element,$id,'c');
				break;
			case "cps_metadatad":
				$ret .= $this->cps_meta_custom_func($element,$id,'d');
				break;
			case "cps_metadatae":
				$ret .= $this->cps_meta_custom_func($element,$id,'e');
				break;
			default:
				$ret .= "NONE";
		}

		return $ret;

	}

}