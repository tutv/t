<?php

global $google_map_api;
$google_map_api = 'AIzaSyAxLgc9R29uy6aD_xntFx01epwWmy49WNw';

include_once 'meta-box-group/meta-box-group.php';

add_filter( 'rwmb_meta_boxes', 'max_register_meta_boxes' );
function max_register_meta_boxes( $meta_boxes ) {
	global $google_map_api;

	$prefix = 'rw_';
	// 1st meta box
	$meta_boxes[] = array(
		'id'         => 'personal',
		'title'      => __( 'Prices', 'textdomain' ),
		'post_types' => array( 'room' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'fields'     => array(
			array(
				'name'   => __( 'Price', 'textdomain' ),
				'desc'   => 'Gia theo khung gio',
				'id'     => $prefix . 'fname',
				'type'   => 'group',
				'clone'  => true,
				'fields' => array(
					array(
						'name' => 'Start',
						'id'   => $prefix . 'time_start',
						'type' => 'time',
						'std'  => '18:00'
					),
					array(
						'name' => 'Finish',
						'id'   => $prefix . 'time_finish',
						'type' => 'time',
						'std'  => '20:00'
					),
					array(
						'name' => 'Price (₫)',
						'id'   => $prefix . 'time_price',
						'type' => 'number',
						'min'  => 0,
						'std'  => 0
					)
				)
			),
		)
	);
	// 2nd meta box
	$meta_boxes[] = array(
		'title'      => __( 'Map', 'textdomain' ),
		'post_types' => array( 'room' ),
		'fields'     => array(
			array(
				'id'   => $prefix . 'address',
				'name' => __( 'Address', 'your-prefix' ),
				'type' => 'text',
				'std'  => __( 'Hanoi, Vietnam', 'your-prefix' ),
			),
			array(
				'name'          => __( 'Address', 'textdomain' ),
				'id'            => $prefix . 'map',
				'address_field' => $prefix . 'address',
				'type'          => 'map',
				'api_key'       => $google_map_api,
				'region'        => '.vn'
			),
		)
	);

	return $meta_boxes;
}