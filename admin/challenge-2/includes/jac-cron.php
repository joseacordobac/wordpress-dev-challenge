<?php 

/** Register  CRON */


function custom_times($custom_times){

	$custom_times['five-minutes'] = array(
		'intervar' => 120,
		'display'  => __('Each minute')
	);
	
	return $custom_times;
}
add_filter('cron_schedules', 'custom_times');


function starter_cron(){
	if(!wp_next_scheduled('jac_run_cron')){
		wp_schedule_event(time(), 'elementor_1_custom_task_manger_cron_interval', 'jac_run_cron');
	}
}
add_action('init', 'starter_cron');

function start_table_error(){

			global $wpdb;
			$sql = "SELECT ID, post_content FROM wp_posts WHERE (post_content LIKE '%href=%');";

			$results = $wpdb->get_results($sql, ARRAY_A);

			foreach($results as $r) {
						$arr = explode('href="', $r['post_content']);
					
				 		foreach($arr as $key => $a) {
				 				if ($key > 0) {
										$x = explode('"', $a);
									
										$post_id = $r['ID'];
										$url = $x[0];
										$posturl = get_the_permalink($post_id);
										$title = get_the_title($post_id);

										$response = wp_remote_get( $url );
										$response_code = wp_remote_retrieve_response_code( $response );
										$message_code = $response_code;
									
									if($response_code != 200){

										if ( !str_starts_with($url, 'https://')) {
												$message_code = 'Protocolo no especificado';
										}
										
										if(str_contains($url, 'http://')){ 
											$message_code = 'Enlace inseguro';
										}
										
										if(str_starts_with($response_code, '40') || str_starts_with($response_code, '50') ){
											$message_code = 'Enlace que retorna un Status Code incorrecto';
										}
										
											
										$data_array[] = [
											'cb'		=> '<input type="checkbox" class="jac-selected" />',
											'id'	=> $post_id,
											'url' 		=> 	$url,
											'state'			=> '<span class="message">'.$message_code.'</span>',
											'origin' => '<a target="_blank" href="'.$posturl.'" class="title-anchor">'.$title.'<a>'
										];
									}

								}
						}
			}

			return $data_array;
}


add_action('jac_run_cron', 'start_table_error');