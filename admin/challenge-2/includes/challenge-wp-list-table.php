<?php

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Class jac_list_Table
 */
class jac_list_Table extends WP_List_Table {

	/**
	 * Prepares the list of items for displaying.
	 */
	public function prepare_items() {

		$order_by = isset( $_GET['orderby'] ) ? $_GET['orderby'] : '';
		$order = isset( $_GET['order'] ) ? $_GET['order'] : '';
		$search_term = isset( $_POST['s'] ) ? $_POST['s'] : '';

		$this->items = $this->jac_list_table_data( $order_by, $order, $search_term );

		$jac_columns = $this->get_columns();
		$jac_hidden = $this->get_hidden_columns();
		$ldul_sortable = $this->get_sortable_columns();

		$this->_column_headers = [ $jac_columns, $jac_hidden, $ldul_sortable ];

	}

	/**
	 * Wp list table bulk actions 
	 */
	public function get_bulk_actions() {

		return array(

			'jac_delete'	=> __( 'Delete', '' ),
			'jac_edit'		=> __( 'Edit', '' )
		);
	}

	/**
	 * WP list table row actions
	 */
	public function handle_row_actions( $item, $column_name, $primary ) {

		if( $primary !== $column_name ) {
			return '';
		}

	}

	/**
	 * Display columns datas
	 */
	public function jac_list_table_data( $order_by = '', $order = '', $search_term = '' ) {

		?><section style="margin: 30px 0 0 0; ">
	<h2><?php _e( 'Error Anchor list' ); ?></h2>

	<?php
		$data_array = [];
		$args = [
		    'post_type'      	=> 'any',
		    'post_status'    	=> 'publish',
		    'posts_per_page' 	=> -1,
		];

		$my_data = get_posts( $args );

		for ($i=0; $i < count($my_data); $i++) { 
			
			$post_id = $my_data[$i]->ID;
			echo get_the_title($post_id);
			$data_array[] = [
				'jac_id'			=> 'id',
				'jac_state'			=> 'Estado',
				'jac_origin' => '<a href="'.get_the_permalink($post_id).'" class="title-anchor">'.get_the_title($post_id).'<a>'
			];
		}
		

		?>
</section><?php
	    return $data_array;

	}

	/**
	 * Gets a list of all, hidden and sortable columns
	 */
	public function get_hidden_columns() {
		return [];
	}

	/**
	 * Gets a list of columns.
	 */
	public function get_columns() {	

		$columns = array(
			'cb'				=> '<input type="checkbox" class="jac-selected" />',
			'jac_id'			=> __( 'URL' ),
			'jac_state'			=> __( 'State' ),
			'jac_origin'	=> __( 'Origin'),
		);
		
		return $columns;
	}

	/**
	 * Return column value
	 */

	public function column_cb( $items ) {

		$top_checkbox = '<input type="checkbox" class="jac-selected" />';
		return $top_checkbox; 
	}
}

$object = new jac_list_Table();
$object->prepare_items();
$object->display();