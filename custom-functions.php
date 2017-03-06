<?php

global $google_map_api;
$google_map_api = 'AIzaSyA6QdNw-1wE-ldNziLjjLC2BolS4toQ4SI';

include_once 'meta-box-group/meta-box-group.php';

add_filter( 'rwmb_meta_boxes', 'max_register_meta_boxes' );
function max_register_meta_boxes( $meta_boxes ) {
	global $google_map_api;

	$prefix = 'tennis_course_';
	// 1st meta box
	$meta_boxes[] = array(
		'id'         => $prefix . 'prices',
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

function max_get_image_map( $pos, $address_text ) {
	global $google_map_api;

	$arr = explode( ',', $pos );

	if ( count( $arr ) < 3 ) {
		return;
	}

	$lat  = $arr[0];
	$long = $arr[1];
	$zoom = $arr[2];

	echo "<div class='address'>";
	echo "<img class='map' src='https://maps.googleapis.com/maps/api/staticmap?center=$lat,$long&zoom=$zoom&size=400x400&markers=color:red%7Clabel:C%7C$lat,$long&key=$google_map_api'>";
	echo "<div class='address-text'>$address_text</div>";
	echo "</div>";
}

function max_room_price( $post ) {
	$postID = $post->ID;

	$prefix = 'tennis_course_';

	$map          = get_post_meta( $postID, $prefix . 'map', true );
	$address_text = get_post_meta( $postID, $prefix . 'address', true );

	$group_value = rwmb_meta( $prefix . 'fname', array(), $postID );

	echo "<div class='container'>";

	echo "<div class='columns six'>";
	max_get_image_map( $map, $address_text );
	echo "</div>";

	echo "<div class='columns six'>";
	max_room_price_detail( $group_value );
	echo "</div>";

	echo "</div>";

	echo "<div class='clear-fix'></div>";
}

function max_room_price_detail( $array ) {
	if ( ! is_array( $array ) ) {
		return;
	}

	$prefix = 'tennis_course_';

	echo "<table>";
	echo "<thead>
		<tr>
			<th>Start</th>
			<th>Finish</th>
			<th>Price</th>
		</tr>
	</thead>";

	echo "<tbody>";
	foreach ( $array as $index => $price ) {
		$start  = $price[ $prefix . 'time_start' ];
		$finish = $price[ $prefix . 'time_finish' ];
		$price  = $price[ $prefix . 'time_price' ];
		$price  = money_format( '%i (đ)', $price );

		echo "<tr>
				<td>$start</td>
				<td>$finish</td>
				<td>$price</td>
			</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}

function max_add_admin_css() {
	wp_enqueue_style( 'max-admin', get_template_directory_uri() . '/admin.css', array() );
}

add_action('admin_enqueue_scripts', 'max_add_admin_css');