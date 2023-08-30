

<div class="record_form_design">
<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Printing Time Summury From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h4>
	<div class="record_inner_design" style="overflow: scroll;">

		<?php foreach ($coex_machine_runtime_jobcards as $key => $coex_machine_runtime_jobcards_row){
            
            echo'<div class="row">
            	<table class="ui sortable selectable celled table"  style="font-size:10px;">
            		<thead>
            		<tr>
            		<th colspan="12"><a class="ui orange label">'.$this->common_model->get_parent_name($coex_machine_runtime_jobcards_row->article_no,$this->session->userdata['logged_in']['company_id']).'</a>&nbsp;'.'<a class="ui blue label">'.$coex_machine_runtime_jobcards_row->sales_ord_no.'</a>&nbsp;<a class="ui olive label">'.$coex_machine_runtime_jobcards_row->mp_pos_no.'</a>&nbsp;<a class="ui green label">'.$this->common_model->get_article_name($coex_machine_runtime_jobcards_row->article_no,$this->session->userdata['logged_in']['company_id']).'</a></th>
            		</tr>
            		</thead>
					<thead>
						<tr>
							<th>Id</th>
							<th>Date</th>
							<th>Machine</th>
							<th>Customer</th>
							<th>Order No</th>
							<th>Product</th>
							<th>Jobcard No.</th>
							<th>Started/Stopped For</th>
							<th colspan="2">Time</th>
							<th colspan="2">In Minuts</th>
						</tr>
					</thead>
					<tbody>';

			$data=array('coex_machine_runtime.mp_pos_no'=>$coex_machine_runtime_jobcards_row->mp_pos_no);
            $coex_machine_runtime_result=$this->coex_runtime_downtime_model->active_record_search('coex_machine_runtime',$data,$this->session->userdata['logged_in']['company_id']);

            $total_run_time=0;
			$total_down_time=0;			 
			$array_total=array();

            $i=1;
            foreach($coex_machine_runtime_result as $coex_machine_runtime_row){



            	echo "<tr style='color:green' class='item'>
						<td>".$i++."</td>
						<td>".date("d-M-Y",strtotime($coex_machine_runtime_row->machine_start_time))."</td>
						<td>".$coex_machine_runtime_row->machine_name."</td>
						<td>".$this->common_model->get_parent_name($coex_machine_runtime_jobcards_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
						<td>".$coex_machine_runtime_jobcards_row->sales_ord_no."</td>
						<td>".$coex_machine_runtime_jobcards_row->article_no."</td>
						<td>".$coex_machine_runtime_row->mp_pos_no."</td>
						<td>".$coex_machine_runtime_row->coex_machine_start_stop_reasons."</td>
						<td>
						<a class='ui basic label'>".date("h:i A",strtotime($coex_machine_runtime_row->machine_start_time))."</a></td>
						<td>".($coex_machine_runtime_row->machine_stop_time=='0000-00-00 00:00:00' ? "-" : "
						<a class='ui basic label'>".date("h:i A",strtotime($coex_machine_runtime_row->machine_stop_time))."</a>")."</td>
						<td>".($coex_machine_runtime_row->machine_stop_time=='0000-00-00 00:00:00' ? '<a class="ui green label">Running</a>' : $this->common_model->time_diffrence($coex_machine_runtime_row->machine_stop_time,$coex_machine_runtime_row->machine_start_time))."</td>
						<td >".($coex_machine_runtime_row->machine_stop_time=='0000-00-00 00:00:00' ? '<a class="ui red label">Running</a>' : round((strtotime($coex_machine_runtime_row->machine_stop_time)-strtotime($coex_machine_runtime_row->machine_start_time))/60))."</td>

						</tr>";

						$total_run_time+=($coex_machine_runtime_row->machine_stop_time=='0000-00-00 00:00:00'?0:round((strtotime($coex_machine_runtime_row->machine_stop_time)-strtotime($coex_machine_runtime_row->machine_start_time))/60));	

						$data=array('coex_machine_downtime.machine_id'=>$coex_machine_runtime_row->machine_id,'coex_machine_downtime.process_id'=>'3','machine_stop_time'=>$coex_machine_runtime_row->machine_stop_time);
						$data_1 = array_filter($data);
			            $this->load->model('coex_runtime_downtime_model');
			            
			            $coex_machine_downtime_result=$this->coex_runtime_downtime_model->active_record_search('coex_machine_downtime',$data_1,$this->session->userdata['logged_in']['company_id']);
			            //echo $this->db->last_query();
			            
			            if($coex_machine_downtime_result==TRUE){

			            	foreach($coex_machine_downtime_result as $row){

								echo "<tr style='color:red' class='item'>
									<td>".$i++."</td>
									<td>".date("d-M-Y",strtotime($row->machine_stop_time))."</td>
									<td>".$row->machine_name."</td>
									<td>".$this->common_model->get_parent_name($coex_machine_runtime_jobcards_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>						
									<td>".$coex_machine_runtime_jobcards_row->sales_ord_no."</td>
									<td>".$coex_machine_runtime_jobcards_row->article_no."</td>
									<td>".$coex_machine_runtime_row->mp_pos_no."</td>
									<td>".$row->coex_machine_start_stop_reasons."</td>
									<td>
									<a class='ui basic label'>".date("h:i A",strtotime($row->machine_stop_time))."</a></td>
									<td>".($row->machine_start_time=='0000-00-00 00:00:00' ? "-" : "
									<a class='ui basic label'>".date("h:i A",strtotime($row->machine_start_time))."</a>")."</td>
									<td>".($row->machine_start_time=='0000-00-00 00:00:00' ? '<a class="ui red label">Stopped</a>' : $this->common_model->time_diffrence($row->machine_start_time,$row->machine_stop_time))."</td>

									<td>".($row->machine_start_time=='0000-00-00 00:00:00' ? '<a class="ui red label">Stopped</a>' : round((strtotime($row->machine_start_time)-strtotime($row->machine_stop_time))/60))."</td>
								</tr>";

								$min=0;
								$min=($row->machine_start_time=='0000-00-00 00:00:00'?0:round((strtotime($row->machine_start_time)-strtotime($row->machine_stop_time))/60));
								//echo '<br/>';
								$total_down_time+=$min;

								$key=$row->coex_machine_start_stop_reasons;
								$value=$min; 
								if (array_key_exists($key, $array_total)) {									$array_total[$key]+=$min;									
								}
								else{
									$array_total[$key]=$min;
								}
								
							}
						}				

			        }
            		echo'
            			</tbody> 
            		</table>

            		<table class="ui sortable selectable celled table"  style="font-size:10px;">
            			<thead>
            			<tr>
							<th colspan="6">
								SUMMARY
							</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td style=" color:green;">RUNTIME</td>
							<td style=" color:green;">'.$total_run_time.' Min</td>
							<td style="color:red;">DOWNTIME</td>
							<td style="color:red;">'.$total_down_time.' Min</td>
							<td>TOTAL</td>
							<td>'.($total_run_time+$total_down_time).' Min</td>
						</tr>
						<tr>
							<td style="color:green;">RUNTIME</td>
							<td style="color:green;">'.$this->costsheet_model->get_time($total_run_time*60).'</td>
							<td style="color:red;">DOWNTIME</td>
							<td style="color:red;">'.$this->costsheet_model->get_time($total_down_time*60).'</td>
							<td>TOTAL</td>
							<td>'.$this->costsheet_model->get_time(($total_run_time+$total_down_time)*60).'</td>
						</tr>
						</tbody>
					</table>

					<table class="ui sortable selectable celled table"  style="font-size:10px;">
            			<thead>
            			<tr>
							<th colspan="3">
								DOWNTIME SUMMARY
							</th>
						</tr>						
						<tr>
							<th>SR NO</th>
							<th>DOWN TIME REASONS</th>
							<th>TIME</th>							
						</tr>
						</thead>
						<tbody>';

						$sn=1;
						foreach ($array_total as $key => $value) {
							echo'<tr>
							<td>'.$sn++.'</td>
							<td style="color:red;">'.$key.'</td>
							<td style="color:red;">'.$this->costsheet_model->get_time($value*60).'</td>';
						}

						echo'<tbody>
					</table>';
			
			echo'
		</div>
		<br/>
		<br/>';

		}
		?>	
						 
	</div>
</div>