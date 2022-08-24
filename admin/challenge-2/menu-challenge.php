<?php 
//Creatin custom plugin menu
 if ( ! defined('ABSPATH') ) {
	die('Direct access not permitted.');
}


if( !function_exists('jac_menu_error_anchor')){

	add_action('admin_menu', 'jac_menu_error_anchor');
	function jac_menu_error_anchor(){

		add_menu_page(
			'JAC Challenge #2',
			'JAC Challenge #2',
			'manage_options',
			'jac_challenge_2',
			'jac_challenge_2_page_display',
			'dashicons-smiley',
			10
		);

	}

}

if(!function_exists('jac_challenge_2_page_display')){
	function jac_challenge_2_page_display(){
		
		if( file_exists( __DIR__.'./includes/challenge-wp-list-table.php')){
			require_once __DIR__.'./includes/challenge-wp-list-table.php';
		}

	}
}