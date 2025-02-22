<?php if ( ! defined( 'ABSPATH' ) ) exit; 
	 $params = $_REQUEST;  
	 $category_id =( isset( $params["category_id"] ) ? intval( $params["category_id"] ) : 0 ); 
	 $_limit_start =( isset( $params["limit_start"] ) ? intval( $params["limit_start"] ) : 0 );
	 $_limit_end = intval( $params["number_of_post_display"] );
	 $is_default_category_with_hidden = 0; 
	 
	?><script language='javascript'>
		var request_obj_<?php echo esc_js( $params["vcode"] ); ?> = {
			category_id:'<?php echo esc_js( $category_id ); ?>',  
			hide_post_title:'<?php echo esc_js( $params["hide_post_title"] ); ?>',  
			post_title_color:'<?php echo esc_js( $params["post_title_color"] ); ?>', 
			category_tab_text_color:'<?php echo esc_js( $params["category_tab_text_color"] ); ?>',
			category_tab_background_color:'<?php echo esc_js( $params["category_tab_background_color"] ); ?>', 
			header_text_color:'<?php echo esc_js( $params["header_text_color"] ); ?>', 
			header_background_color:'<?php echo esc_js( $params["header_background_color"] ); ?>',
			display_title_over_image:'<?php echo esc_js( $params["display_title_over_image"] ); ?>', 
			number_of_post_display:'<?php echo esc_js( $params["number_of_post_display"] ); ?>',
			vcode:'<?php echo esc_js( $params["vcode"] ); ?>'
		}
	</script><?php  
	echo "<input type='hidden' value='".$category_id."' class='ik-drp-post-category' />"; 
	$_total_posts = $this->getTotalPosts( $category_id, 1, $is_default_category_with_hidden );
	if( $_total_posts <= 0 ) {
		?><div class="ik-post-no-items"><?php echo __( 'No posts found.', 'categoryposttab' ); ?></div><?php
		die();
	}  
	$post_list = $this->getPostList( $category_id, $_limit_end ); 
	foreach ( $post_list as $_post ) { 
		$image  = $this->getPostImage( $_post->post_image ); 
		?>
		<div class='ik-post-item pid-<?php echo esc_attr( $_post->post_id ); ?>'> 
			<div class='ik-post-image' onmouseout="cpt_pr_item_image_mouseout(this)" onmouseover="cpt_pr_item_image_mousehover(this)">
					<a href="<?php echo get_permalink( $_post->post_id ); ?>">
					<div class="ov-layer" > 
						 <?php if( sanitize_text_field( $params["display_title_over_image"] ) == 'yes' ) { ?> 
								<div class='ik-overlay-post-content'>
									<?php if( sanitize_text_field( $params["hide_post_title"] ) == 'no' ) { ?> 
										<div class='ik-post-name' style="color:<?php echo esc_attr( $params["post_title_color"] ); ?>" >
											 <?php echo esc_html( $_post->post_title ); ?>
										</div>
									<?php } ?>  
									<div class="clr"></div>
								</div>
								<div class="clr"></div>
						<?php } ?>
					</div>
					<div class="clr"></div>
				</a>
				<div class="clr"></div>
				<a href="<?php echo get_permalink( $_post->post_id ); ?>"> 
					<?php echo $image; ?>
				</a>   
			</div>  
			<?php if( sanitize_text_field( $params["display_title_over_image"] ) == 'no' ) { ?> 
				<div class='ik-post-content'>
					<?php if( sanitize_text_field( $params["hide_post_title"] ) =='no'){ ?> 
						<div class='ik-post-name'>
							<a href="<?php echo get_permalink( $_post->post_id ); ?>" style="color:<?php echo esc_attr( $params["post_title_color"] ); ?>" >
								<?php echo esc_html( $_post->post_title ); ?>
							</a>	
						</div>
					<?php } ?>	 
					
				</div>	
			<?php } ?> 
		</div> 
		<?php 
	}
	
	if( $_total_posts > sanitize_text_field( $params["number_of_post_display"] ) ) { ?>
			<div class="clr"></div>
			<div class='ik-post-load-more'  align="center" onclick='CPT_loadMorePosts( <?php echo esc_js( $category_id ); ?>, "<?php echo esc_js( $_limit_start+$_limit_end ); ?>", "<?php echo esc_js( $params["vcode"]."-".$category_id ); ?>", "<?php echo esc_js( $_total_posts ); ?>", request_obj_<?php echo esc_js( $params["vcode"] ); ?> )'>
				<?php echo __('Load More', 'categoryposttab' ); ?>
			</div>
		<?php  
	} else {
		?><div class="clr"></div><?php
	}