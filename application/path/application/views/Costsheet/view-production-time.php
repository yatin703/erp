

<table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
				<tr class="heading item">
					<th style="border-right:1px solid #D9d9d9;">Id</th>
					<th style="border-right:1px solid #D9d9d9;">Date</th>
					<th style="border-right:1px solid #D9d9d9;">Machine</th>
					<th style="border-right:1px solid #D9d9d9;">Customer</th>
					<th style="border-right:1px solid #D9d9d9;">Started/Stopped For</th>
					
					<th colspan='2' style="border-right:1px solid #D9d9d9;">Time</th>
					<th style="border-right:1px solid #D9d9d9;">In Minutes</th>
				</tr>
				<?php 

				$total_run_time=0;
				$total_down_time=0;
				$row_data=array();

				$array_total=array();	

				if($coex_machine_runtime==FALSE){
					echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
				}else{
						$i=1;

						
						$j=0;

						foreach($coex_machine_runtime as $row){
							$job_data=array('mp_pos_no'=>$row->mp_pos_no);
							$production_data=$this->job_card_model->active_record_search('production_master',$job_data,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
							//echo $this->db->last_query();
							$so_no="";
							$article_no="";
							if($production_data==FALSE){

							}else{


							foreach($production_data as $production_row){
								$so_no=$production_row->sales_ord_no;
								$article_no=$production_row->article_no;
							}
						}

							echo "<tr style='color:green' class='item'>
									<td style='border-right:1px solid #D9d9d9;'>".$i."</td>
									<td style='border-right:1px solid #D9d9d9;'>".date("d-M-Y",strtotime($row->machine_start_time))."</td>
									<td style='border-right:1px solid #D9d9d9;'>".$row->machine_name."</td>
									<td style='border-right:1px solid #D9d9d9;'>".$this->common_model->get_parent_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>


									<td style='border-right:1px solid #D9d9d9;'>".$row->coex_machine_start_stop_reasons."</td>
									<td>
									<a class='ui basic label'>".date("h:i A",strtotime($row->machine_start_time))."</a></td>
									<td style='border-right:1px solid #D9d9d9;'>".($row->machine_stop_time=='0000-00-00 00:00:00' ? "-" : "
									<a class='ui basic label'>".date("h:i A",strtotime($row->machine_stop_time))."</a>")."</td>
									<td style='border-right:1px solid #D9d9d9;'>".($row->machine_stop_time=='0000-00-00 00:00:00' ? '<a class="ui green label">Running</a>' : $this->common_model->time_diffrence($row->machine_stop_time,$row->machine_start_time))."</td>
									<td style='border-right:1px solid #D9d9d9;'>".($row->machine_stop_time=='0000-00-00 00:00:00' ? '<a class="ui red label">Running</a>' : round((strtotime($row->machine_stop_time)-strtotime($row->machine_start_time))/60))."</td>

									</tr>";

								$total_run_time+=($row->machine_stop_time=='0000-00-00 00:00:00'?0:round((strtotime($row->machine_stop_time)-strtotime($row->machine_start_time))/60));	


						$data=array('coex_machine_downtime.machine_id'=>$row->machine_id,'coex_machine_downtime.process_id'=>'3','machine_stop_time'=>$row->machine_stop_time);
			            $this->load->model('coex_runtime_downtime_model');
			             $data = array_filter($data);
			            $coex_machine_downtime=$this->coex_runtime_downtime_model->active_record_search('coex_machine_downtime',$data,$this->session->userdata['logged_in']['company_id']);
			            //echo $this->db->last_query();
			                
              			if($coex_machine_downtime==FALSE){
					//echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
						}else{

												
						foreach($coex_machine_downtime as $row){

							echo "<tr style='color:red' class='item'>
									<td style='border-right:1px solid #D9d9d9;'></td>
									<td style='border-right:1px solid #D9d9d9;'>".date("d-M-Y",strtotime($row->machine_stop_time))."</td>
									<td style='border-right:1px solid #D9d9d9;'>".$row->machine_name."</td>
									<td></td>
									<td style='border-right:1px solid #D9d9d9;'>".$row->coex_machine_start_stop_reasons."</td>
									<td>
									<a class='ui basic label'>".date("h:i A",strtotime($row->machine_stop_time))."</a></td>
									<td style='border-right:1px solid #D9d9d9;'>".($row->machine_start_time=='0000-00-00 00:00:00' ? "-" : "
									<a class='ui basic label'>".date("h:i A",strtotime($row->machine_start_time))."</a>")."</td>
									<td style='border-right:1px solid #D9d9d9;'>".($row->machine_start_time=='0000-00-00 00:00:00' ? '<a class="ui red label">Stopped</a>' : $this->common_model->time_diffrence($row->machine_start_time,$row->machine_stop_time))."</td>

									<td style='border-right:1px solid #D9d9d9;'>".($row->machine_start_time=='0000-00-00 00:00:00' ? '<a class="ui red label">Stopped</a>' : round((strtotime($row->machine_start_time)-strtotime($row->machine_stop_time))/60))."</td>
								</tr>";
								$min=0;
								$min=($row->machine_stop_time=='0000-00-00 00:00:00'?0:round((strtotime($row->machine_start_time)-strtotime($row->machine_stop_time))/60));
								//echo '<br/>';
								$total_down_time+=$min;
								 
								$j++;

								//-------------------------------------------------------
								 
								$key=$row->coex_machine_start_stop_reasons;
								$value=$min; 
								if (array_key_exists($key, $array_total)) {									$array_total[$key]+=$min;									
								}
								else{
									$array_total[$key]=$min;
								}								
							
						}
					}
					

							$i++;
						}
					}
					?>
								
						</table>
						<br/>
						<table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
							<tr class="heading item">
								<th colspan="6" style="border-right:1px solid #D9d9d9;">
									SUMMARY
								</th>
							</tr>
							<tr>
								<th style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9; color:green;">RUNTIME</th>
								<th style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;color:green;"><?php echo $total_run_time;?> Min</th>
								<th style="color:red; border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;">DOWNTIME</th>
								<th style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;color:red;"><?php echo $total_down_time;?> Min</th>
								<th style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;">TOTAL</th>
								<th style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;"><?php echo ($total_run_time+$total_down_time);?> Min</th>
							</tr>
							<tr>
								<th style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9; color:green;">RUNTIME</th>
								<th style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;color:green;"><?php echo $this->costsheet_model->get_time($total_run_time*60);?></th>
								<th style="color:red; border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;">DOWNTIME</th>
								<th style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;color:red;"><?php echo  $this->costsheet_model->get_time($total_down_time*60);?></th>
								<th style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;">TOTAL</th>
								<th style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;"><?php echo $this->costsheet_model->get_time(($total_run_time+$total_down_time)*60);?></th>
							</tr>
							
						</table>

						<br/>
						<table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
							<tr class="heading item">
								<th colspan="3" style="border-right:1px solid #D9d9d9;">
									DOWNTIME SUMMARY
								</th>
							</tr>
							<tr>	
								<th width="2" style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;">
									SR NO
								</th>
								<th width="10" style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;">
									DOWN TIME REASONS
								</th>
								<th width="88"style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;">
									TIME
								</th>
							</tr>
							<?php

							//print_r($array_total);
							$sn=1;					

							foreach ($array_total as $key => $value) {
								echo '<tr>
									<td width="2" style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;">'.$sn++.'</td>
									<td width="10"style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;text-align:left;color:red">'.$key.'</td>
									<td width="88"style="border-right:1px solid #D9d9d9;border-top:1px solid #D9d9d9;color:red;">'.$this->costsheet_model->get_time($value*60).'</td>
								<tr>';
							}								
						
							?>

						</table>		
							


			