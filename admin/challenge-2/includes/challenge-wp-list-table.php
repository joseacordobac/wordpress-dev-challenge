<?php

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class JAC_table_list extends WP_List_Table{

	public function get_all_data(){
		$data_array = [];

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

								var_dump($response->status_code);

								$data_array[] = [
									'cb'		=> '<input type="checkbox" class="jac-selected" />',
									'id'	=> $post_id,
									'url' 		=> 	$url,
									'state'			=> $response_code,
									'origin' => '<a target="_blank" href="'.$ulr.'" class="title-anchor">'.$title.'<a>'
								];
								//var_dump($data_array);
						}
				}
		}

		return $data_array;
		
	}

	public function prepare_items_data(){

		$this->items = $this->get_all_data();
		$columns = $this->get_columns();
		
		$this->_column_headers = array($columns);

	}

	public function get_columns(){

		$columns = array(
			'cb'		=> '<input type="checkbox" class="jac-selected" />',
			'id'		=> __('ID'),
			'url' 	=> 	__('Url'),
			'state'	=> __('Estado'),
			'origin'=> __('Origen')
		);

		return $columns;

	}

	public function column_default($items, $columns){
		switch($columns){
			case 'cb':
			case 'id':
			case 'url':
			case 'state':
			case 'origin':
				return $items[$columns];
			default:
				return "no value";
		}
	}

}

function JAC_table_data_list(){

	$JAC_table_list = new JAC_table_list();
	$JAC_table_list -> prepare_items_data();
	$JAC_table_list -> display();

}

JAC_table_data_list();