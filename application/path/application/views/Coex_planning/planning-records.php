
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/javascript/semantic.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.address/1.6/jquery.address.min.js"></script>
<script>

	$(document).ready(function(){
$('.menu .item')
  .tab()
;
});
</script>
<div class="record_form_design">
<h3>Planned Orders</h3>
	<div class="record_inner_design">
		<div class="ui pointing secondary menu">
			<?php if($process==FALSE){

			}else{
				foreach($process as $process_row){
					echo "<a class='item' data-tab='".$process_row->lang_description."'>".$process_row->lang_description."</a>";
				}
			}?>
										
		</div>

		<?php if($process==FALSE){
		}else{
			foreach($process as $process_row){
			echo '<div class="ui tab segment" data-tab="'.$process_row->lang_description.'">
		  <div class="ui top attached tabular menu">';
		  	$dataa = array('process_id' =>$process_row->work_proc_type_id);
        $coex_machine_master=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
        if($coex_machine_master==FALSE){

        }else{
        	foreach($coex_machine_master as $coex_machine_master_row){
        	echo '<a class="active item" data-tab="'.$process_row->lang_description.'/'.$coex_machine_master_row->machine_id.'">'.$coex_machine_master_row->machine_name.'</a>';
        	}
        }

		    echo '
		  </div>';
		  $coex_machine_master=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
        if($coex_machine_master==FALSE){
        }else{
        	foreach($coex_machine_master as $coex_machine_master_row){
        	echo '<div class="ui bottom attached active tab segment" data-tab="'.$process_row->lang_description.'/'.$coex_machine_master_row->machine_id.'">

									<div class="tableFixHead">
										<table class="record_table_design_without_fixed">
											<thead>
												<tr>
												<th>Id</th>
												<th>Customer</th>
												<th>Order No</th>
												<th>Article No</th>
												<th>Dia</th>
												<th>Print Type</th>
												<th>Planned Qty</th>
												<th>Shift No</th>
												<th>Planned On</th>
												</tr>
											</thead>
											<tbody>';

										$planned_data=array('coex_planning.coex_machine_id'=>$coex_machine_master_row->machine_id);
		  								$planned_records=$this->coex_planning_model->select_planned_records('coex_planning',$planned_data,$this->session->userdata['logged_in']['company_id']);
		  								//echo $this->db->last_query();
		  								if($planned_records==FALSE){
		  									echo '<tr>
		  											<td colspan="8">NO RECORD FOUND</td>
		  										  </tr>';
		  								}else{
		  									$i=1;
		  									foreach($planned_records as $planned_records_row){
		  									echo '<tr>
		  											<td>'.$i.'</td>
		  											<td>'.$planned_records_row->name1.'</td>
		  											<td>'.$planned_records_row->order_no.'</td>
		  											<td>'.$planned_records_row->article_no.'</td>
		  											<td>'.$planned_records_row->sleeve_dia.'</td>
		  											<td>'.$planned_records_row->print_type.'</td>
		  											<td>'.$planned_records_row->quantity.'</td>
		  											<td>'.$planned_records_row->shift_id.'</td>
		  											<td>'.$planned_records_row->shift_start_time.'</td>
		  										  </tr>';
		  										  $i++;
		  										}
		  								}

									  echo '</tbody>
										</table>
									</div>
									
        				</div>';
        	}
        }
		  echo '
		</div>';
			}
		}?>
	</div>
</div>