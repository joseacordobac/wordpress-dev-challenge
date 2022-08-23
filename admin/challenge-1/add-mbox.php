<?php if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}

//Create wordpress metaboxes
function jac_add_box_quotes(){

	$screens = array( 'post', 'page' );
	add_meta_box(
		'jac_quote_meta_box',
		'Citation',
		'jac_meta_box_quote_html',
		$screens
	);
}

add_action('add_meta_boxes', 'jac_add_box_quotes');

//Createn html call back
function jac_meta_box_quote_html($post){ 

	$id = $post->ID;
	$jac_quote = get_post_meta( $post->ID, '_add_quotes', true );

	wp_editor( 
		$jac_quote, 
		'add_quotes', 
		 array(
				'media_buttons' => true
			)
		);	
		
		echo 'Short code: [mc-citacion post_id='.$id.']';

}

//Save data
function jac_save_quote_meta_box($post_id){
	
	if( array_key_exists('add_quotes', $_POST)){

		update_post_meta(
			$post_id, 
			'_add_quotes',
			$_POST['add_quotes'],
		);

	}
}

add_action( 'save_post', 'jac_save_quote_meta_box' );