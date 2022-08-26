<?php 

/*** Create a new Cron jobs */


require_once __DIR__.'./challenge-wp-list-table.php';

class JAC_Cron {
		
		public function custom_times($custom_times){

			echo "<pre>";

			var_dump(wp_get_schedules());
		
			echo "<pre>";
				var_dump(_get_cron_array());

				$custom_times['five'] = [
					'intervar' => 5,
					'display'  => __('Each five second')
				];
				return $custom_times;
		}


		public function starter(){

			if(!wp_next_scheduled('jac_crom')){
				
				wp_schedule_event(time()+10, 'hourly', 'jac_crom');

			}

	}

	add_action('cron_schedules', $this->JAC_Cron,'intervals');
	add_action('init', JAC_Cron,$this->JAC_Cron, 'starter');

}

JAC_Cron();

JAC_table_data_list();