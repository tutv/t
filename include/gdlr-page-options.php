<?php
/*
*	Goodlayers Framework File
*	---------------------------------------------------------------------
*	This file contains the admin option setting
*	---------------------------------------------------------------------
*/

// page excerpt
add_action( 'init', 'gdlr_init_page_feature' );
if ( ! function_exists( 'gdlr_init_page_feature' ) ) {
	function gdlr_init_page_feature() {
		add_post_type_support( 'page', 'excerpt' );

		// create page categories
		register_taxonomy(
			'page_category', array( "page" ), array(
			'hierarchical'   => true,
			'label'          => __( 'Page Categories', 'gdlr_translate' ),
			'singular_label' => __( 'Page Category', 'gdlr_translate' ),
			'rewrite'        => array( 'slug' => 'page_category' )
		) );
		register_taxonomy_for_object_type( 'page_category', 'page' );
	}
}