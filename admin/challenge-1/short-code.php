<?php if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}

function jac_citation_callback($attr, $content = null){

	$citationId = get_the_ID();

	$a = shortcode_atts( 
					array('post_id' => $citationId ), 
					$attr
				);
		
	$post_meta = get_post_meta( $a['post_id'], '_add_quotes', true );
	return $post_meta;

}

add_shortcode('mc-citacion', 'jac_citation_callback');