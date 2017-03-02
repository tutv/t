<?php
/*
*	Goodlayers Post Option file
*	---------------------------------------------------------------------
*	This file creates all post options to the post page
*	---------------------------------------------------------------------
*/

// add a post admin option
add_filter( 'gdlr_admin_option', 'gdlr_register_post_admin_option' );
if ( ! function_exists( 'gdlr_register_post_admin_option' ) ) {
	function gdlr_register_post_admin_option( $array ) {
		if ( empty( $array['general']['options'] ) ) {
			return $array;
		}

		global $gdlr_sidebar_controller;
		$post_option = array(
			'title'   => __( 'Blog Style', 'gdlr_translate' ),
			'options' => array(
				'post-title'            => array(
					'title'   => __( 'Default Post Title', 'gdlr_translate' ),
					'type'    => 'text',
					'default' => 'Single Blog Title'
				),
				'post-caption'          => array(
					'title'   => __( 'Default Post Caption', 'gdlr_translate' ),
					'type'    => 'textarea',
					'default' => 'This is a single blog caption'
				),
				'post-thumbnail-size'   => array(
					'title'   => __( 'Single Post Thumbnail Size', 'gdlr_translate' ),
					'type'    => 'combobox',
					'options' => gdlr_get_thumbnail_list(),
					'default' => 'post-thumbnail-size'
				),
				'post-meta-data'        => array(
					'title'       => __( 'Disable Post Meta Data', 'gdlr_translate' ),
					'type'        => 'multi-combobox',
					'options'     => array(
						'date'     => 'Date',
						'tag'      => 'Tag',
						'category' => 'Category',
						'comment'  => 'Comment',
						'author'   => 'Author',
					),
					'description' => __( 'Select this to remove the meta data out of the post.<br><br>', 'gdlr_translate' ) .
					                 __( 'You can use Ctrl/Command button to select multiple option or remove the selected option.', 'gdlr_translate' )
				),
				'single-post-author'    => array(
					'title' => __( 'Enable Single Post Author', 'gdlr_translate' ),
					'type'  => 'checkbox'
				),
				'post-sidebar-template' => array(
					'title'   => __( 'Default Post Sidebar', 'gdlr_translate' ),
					'type'    => 'radioimage',
					'options' => array(
						'no-sidebar'    => GDLR_PATH . '/include/images/no-sidebar.png',
						'both-sidebar'  => GDLR_PATH . '/include/images/both-sidebar.png',
						'right-sidebar' => GDLR_PATH . '/include/images/right-sidebar.png',
						'left-sidebar'  => GDLR_PATH . '/include/images/left-sidebar.png'
					),
					'default' => 'right-sidebar'
				),
				'post-sidebar-left'     => array(
					'title'         => __( 'Default Post Sidebar Left', 'gdlr_translate' ),
					'type'          => 'combobox',
					'options'       => $gdlr_sidebar_controller->get_sidebar_array(),
					'wrapper-class' => 'left-sidebar-wrapper both-sidebar-wrapper post-sidebar-template-wrapper',
				),
				'post-sidebar-right'    => array(
					'title'         => __( 'Default Post Sidebar Right', 'gdlr_translate' ),
					'type'          => 'combobox',
					'options'       => $gdlr_sidebar_controller->get_sidebar_array(),
					'wrapper-class' => 'right-sidebar-wrapper both-sidebar-wrapper post-sidebar-template-wrapper',
				),
			)
		);


		$array['general']['options']['blog-style'] = $post_option;

		return $array;
	}
}

add_action( 'pre_post_update', 'gdlr_save_post_meta_option' );
if ( ! function_exists( 'gdlr_save_post_meta_option' ) ) {
	function gdlr_save_post_meta_option( $post_id ) {
		if ( get_post_type() == 'post' && isset( $_POST['post-option'] ) ) {
			$post_option = gdlr_preventslashes( gdlr_stripslashes( $_POST['post-option'] ) );
			$post_option = json_decode( gdlr_decode_preventslashes( $post_option ), true );

			if ( ! empty( $post_option['rating'] ) ) {
				update_post_meta( $post_id, 'gdlr-post-rating', floatval( $post_option['rating'] ) * 100 );
			} else {
				delete_post_meta( $post_id, 'gdlr-post-rating' );
			}
		}
	}
}

?>