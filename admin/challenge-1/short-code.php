<?php if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}

function jac_citation_callback($attr, $content = null){

	$citationId = get_the_ID();

	$a = shortcode_atts( 
					array('id' => $citationId ), 
					$attr
				);
		
	$post_meta = get_post_meta( $a['id'], '_add_quotes', true );
	return $post_meta;

}

add_shortcode('citation', 'jac_citation_callback');