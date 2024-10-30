<?php
/**
* Call Posts Add new and edit popup
*
* @since 1.0.0
*/

$arr 	 = array();
$cps 	 = callposts();
$getdata = $cps->core->cps_db('cps_data');
$count 	 = count($getdata)+1;

$id 	 = ( isset($_GET['id']) )? sanitize_text_field( $_GET['id'] ) : '';
$action  = ( isset($_GET['action']) )? sanitize_text_field( $_GET['action'] ) : '';
$page 	 = ( isset($_GET['page']) )? sanitize_text_field( $_GET['page'] ) : '';

$condition = (!empty($id))? $id : 'cps_'.$count;
$cps_popup = $cp->render_skin('div', array( "id" => "cps-main-overlay", 'class' => $cps->cps_ifhas($id,'cps-active') . $cps->cps_compare($page,'call-posts-new',' cps-active') ), '') . $cp->render_skin(
	'div',
	array( "id" => "cps-overlay", 'class' => $cps->cps_ifhas($id,'cps-active') . $cps->cps_compare($page,'call-posts-new',' cps-active') ),
	$cp->render_skin(
		'form',
		array("id" => "Call_Posts", 'class' => 'cps-wrapper ' . $cps->cps_compare($action,'edit','cps-active') . $cps->cps_compare($page,'call-posts-new',' cps-active') ),
		$cp->render_skin('div', array("id" => "cps-close"), 'X').
		$cp->render_skin(
			'div',
			array("class" => "cps-new-value"),
			$cp->render_skin(
				'table',
				$arr,
				$cp->render_skin(
					'tbody',
					$arr,
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('colspan' => '2', 'id' => 'cps_unique_id'),
							$cps->render_skin(
								'input',
								array( 'type' => 'text', 'class' => 'widefat cps_unique_id', 'value' => $condition ),
								$cp->render_skin('i',$arr,'Unique ID')
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('scope' => 'row'),
							$cp->render_skin( 'label', $arr, __( 'Name:', 'call-posts' ) )
						).
						$cp->render_skin(
							'td',
							$arr,
							$cps->render_skin(
								'input',
								array( 'type' => 'text','class' =>'widefat cps_parent_class','value'=>$cps->cps_getvalue($id,'name',''),'required'=>''),
								''
							)
						)
					).
					$cp->render_skin(
						'tr',
						$arr,
						$cp->render_skin('td', array('colspan' => '2'), '&nbsp;')
					).
					$cp->render_skin(
						'tr',
						array('class' => 'cps-header'),
						$cp->render_skin(
							'td',
							array('colspan' => '2'),
							$cp->render_skin( 'h4', $arr, __( 'Basic Settings', 'call-posts' ) )
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('scope' => 'row'),
							$cp->render_skin( 'label', $arr, __( 'Category:', 'call-posts' ) )
						).
						$cp->render_skin(
							'td',
							$arr,
							$cp->render_skin(
								'select',
								array('class' => 'widefat cps_category_list', 'type' => 'text'),
								$cps->category_list($cps->cps_getvalue($id,'Category',''))
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('scope' => 'row'),
							$cp->render_skin( 'label', $arr, __( 'Post per page:', 'call-posts' ) )
						).
						$cp->render_skin(
							'td',
							$arr,
							$cps->render_skin(
								'input',
								array( 'type' => 'number', 'class' =>'widefat cps_ppp', 'value'=> $cps->cps_getvalue($id,'post per page','5'), 'min'=>'1'),
								''
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('scope' => 'row'),
							$cp->render_skin( 'label', $arr, __( 'Order:', 'call-posts' ) )
						).
						$cp->render_skin(
							'td',
							$arr,
							$cp->render_skin(
								'select',
								array('class' => 'widefat cps_order', 'type' => 'text'),
								$cp->render_skin(
									'option',
									array('value' => 'ASC', $cps->cps_option($id,'order','ASC') => ''),
									'ASC'
								).
								$cp->render_skin(
									'option',
									array('value' => 'DESC', $cps->cps_option($id,'order','DESC') => ''),
									'DESC'
								)
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('scope' => 'row'),
							$cp->render_skin( 'label', $arr, __( 'Order By:', 'call-posts' ) )
						).
						$cp->render_skin(
							'td',
							$arr,
							$cp->render_skin(
								'select',
								array('class' => 'widefat cps_order_by', 'type' => 'text'),
								$cps->core->cps_orderby_options($id)
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('scope' => 'row'),
							$cp->render_skin( 'label', $arr, __( 'Post Status:', 'call-posts' ) )
						).
						$cp->render_skin(
							'td',
							$arr,
							$cp->render_skin(
								'select',
								array('class' => 'widefat cps_post_status', 'type' => 'text'),
								$cps->core->cps_poststatus_options($id)
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('scope' => 'row'),
							$cp->render_skin( 'label', $arr, __( 'Author:', 'call-posts' ) )
						).
						$cp->render_skin(
							'td',
							$arr,
							$cp->render_skin(
								'select',
								array('class' => 'widefat cps_author', 'type' => 'text'),
								$cps->author_list($cps->cps_getvalue($id,'Author',''))
							)
						)
					).
					$cp->render_skin(
						'tr',
						$arr,
						$cp->render_skin('td', array('colspan' => '2'), '&nbsp;')
					).
					$cp->render_skin(
						'tr',
						array('class' => 'cps-header'),
						$cp->render_skin(
							'td',
							array('colspan' => '2'),
							$cp->render_skin( 'h4', $arr, __( 'Advanced Settings', 'call-posts' ) )
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('colspan' => '2'),
							$cps->render_skin(
								'input',
								array( 'id' => 'cps_exclude_post', 'type' => 'checkbox', 'class' =>'widefat cps_exclude_post', $cps->cps_checkbox($id,'exclude current post','ID') => ''),
								''
							).
							$cp->render_skin(
								'label',
								array('for' => 'cps_exclude_post', 'title' => ''),
								__( 'Exclude Current Posts', 'call-posts' )
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('colspan' => '2'),
							$cps->render_skin(
								'input',
								array( 'id' => 'cps_link', 'type' => 'checkbox', 'class' =>'widefat cps_link', $cps->cps_checkbox($id,'link','ID') => ''),
								''
							).
							$cp->render_skin(
								'label',
								array('for' => 'cps_link', 'title' => ''),
								__( 'Start with Post', 'call-posts' )
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top', 'data-id' => 'cps_link'),
						$cp->render_skin(
							'td',
							array('scope' => 'row'),
							$cp->render_skin( 'label', $arr, __( 'Post offset:', 'call-posts' ) )
						).
						$cp->render_skin(
							'td',
							$arr,
							$cps->render_skin(
								'input',
								array( 'type' => 'number', 'class' =>'widefat cps_link_to', 'value' => $cps->cps_getvalue($id,'link to','1'), 'min' => '1'),
								''
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('colspan' => '2'),
							$cps->render_skin(
								'input',
								array( 'id' => 'cps_set_date', 'type' => 'checkbox', 'class' =>'widefat cps_set_date', $cps->cps_checkbox($id,'set date','ID') => ''),
								''
							).
							$cp->render_skin(
								'label',
								array('for' => 'cps_set_date', 'title' => ''),
								__( 'Post Between Dates', 'call-posts' )
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top', 'data-id' => 'cps_set_date'),
						$cp->render_skin(
							'td',
							array('scope' => 'row'),
							$cp->render_skin( 'label', $arr, __( 'From:', 'call-posts' ) )
						).
						$cp->render_skin(
							'td',
							$arr,
							$cps->render_skin(
								'input',
								array( 'type' => 'text', 'class' =>'widefat cps_from_date', 'value' => $cps->cps_getvalue($id,'from date','1') ),
								''
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top', 'data-id' => 'cps_set_date'),
						$cp->render_skin(
							'td',
							array('scope' => 'row'),
							$cp->render_skin( 'label', $arr, __( 'To:', 'call-posts' ) )
						).
						$cp->render_skin(
							'td',
							$arr,
							$cps->render_skin(
								'input',
								array( 'type' => 'text', 'class' =>'widefat cps_to_date', 'value' => $cps->cps_getvalue($id,'to date','1') ),
								''
							)
						)
					).
					$cp->render_skin(
						'tr',
						$arr,
						$cp->render_skin('td', array('colspan' => '2'), '&nbsp;')
					).
					$cp->render_skin(
						'tr',
						array('class' => 'cps-header'),
						$cp->render_skin(
							'td',
							array('colspan' => '2'),
							$cp->render_skin( 'h4', $arr, __( 'Responsive', 'call-posts' ) )
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('scope' => 'row', 'colspan' => '2'),
							$cp->render_skin( 'label', $arr, __( 'No of colwmns:', 'call-posts' ) )
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('class' => 'cps-float', 'colspan' => '2'),
							$cp->render_skin(
								'div',
								$arr,
								$cp->render_skin('span', array('class' => 'dashicons dashicons-desktop cps-dashicons'), '').
								$cp->render_skin( 'span', $arr, __( 'Desktop', 'call-posts' ) ).
								$cps->render_skin(
									'input',
									array( 'type' => 'number', 'class' =>'widefat cps_desktop', 'value' => $cps->cps_getvalue($id,'desktop','4'), 'min' => '1', 'max' => '5' ),
									''
								)
							).
							$cp->render_skin(
								'div',
								$arr,
								$cp->render_skin('span', array('class' => 'dashicons dashicons-tablet cps-dashicons'), '').
								$cp->render_skin( 'span', $arr, __( 'Tablet', 'call-posts' ) ).
								$cps->render_skin(
									'input',
									array( 'type' => 'number', 'class' =>'widefat cps_tablet', 'value' => $cps->cps_getvalue($id,'tablet','4'), 'min' => '1', 'max' => '5' ),
									''
								)
							).
							$cp->render_skin(
								'div',
								$arr,
								$cp->render_skin('span', array('class' => 'dashicons dashicons-smartphone cps-dashicons'), '').
								$cp->render_skin( 'span', $arr, __( 'Mobile', 'call-posts' ) ).
								$cps->render_skin(
									'input',
									array( 'type' => 'number', 'class' =>'widefat cps_mobile', 'value' => $cps->cps_getvalue($id,'mobile','4'), 'min' => '1', 'max' => '5' ),
									''
								)
							)
						)
					).
					$cp->render_skin(
						'tr',
						$arr,
						$cp->render_skin('td', array('colspan' => '2'), '&nbsp;')
					).
					$cp->render_skin(
						'tr',
						array('class' => 'cps-header'),
						$cp->render_skin(
							'td',
							array('colspan' => '2'),
							$cp->render_skin(
								'h4',
								$arr,
								__( 'Skin', 'call-posts' ) .
								$cp->render_skin(
									'span',
									array( 'class' => 'dashicons dashicons-admin-generic cps-expandallsettings', 'style' => 'float: right;' ),
									''
								)
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('valign' => 'top'),
						$cp->render_skin(
							'td',
							array('colspan' => '2'),
							$cp->render_skin(
								'textarea',
								array('class' => 'cps_skin_array'),
								esc_textarea( $cps->cps_getvalue($id,'skin',$cps->func->dummy_skin()) )
							).
							$cp->render_skin(
								'div',
								array('class' => 'cps_skin'),
								$cp->render_skin(
									'div',
									array('class' => 'cps_skin_content'),
									$cp->render_skin(
										'div',
										array('id' => 'cps_skin_one', 'class' => 'cps_skin_element'),
										$cps->core->getskin($id)
									)
								)
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('class' => 'cps-header cps-premium-version'),
						$cp->render_skin(
							'td',
							array('colspan' => '2'),
							$cp->render_skin(
								'h4',
								$arr,
								$cp->render_skin(
									'a',
									array( 'target' => '_blank', 'href' => cps_premium ),
									__( 'Get Premium version', 'call-posts' ) . $cp->render_skin( 'span', array( 'class' => 'dashicons dashicons-external' ), '' )
								)
							)
						)
					).
					$cp->render_skin(
						'tr',
						array('class' => 'cps-premium-version'),
						$cp->render_skin(
							'td',
							array('colspan' => '2'),
							$cp->render_skin(
								'p',
								array('class' => 'premium-notice', 'style' => 'margin-top: 0;'),
								__( 'Get Premium to unlock for all Post types (product, event etc)', 'call-posts' )
							)
						)
					)
				)
			).
			$cp->render_skin('span', array("style" => "vertical-align: middle;", 'class' => 'cps_loader'), '').
			$cp->render_skin(
				'button',
				array('type' => 'submit' ,'class' => 'cps-button-add-new page-title-action submit button button-secondary cps_save_button'),
				'Save'
			)
		)
	)
);

//Echo Final rendered output
echo $cps_popup;
