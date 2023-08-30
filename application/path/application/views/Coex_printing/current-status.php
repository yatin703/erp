

	
	

<span= id="check">
<div class="record_form_design">
	<div class="record_inner_design" style="overflow: scroll;">

		<div class="ui equal width grid">
		  <div class="equal width row">
		    <div class="column">

		    	<div class="ui red segments">
		    		<div class="ui red segment">
					    <p><a  class="ui orange label">PRINTING CURRENT OVERVIEW</a></p>
					</div>
					<div class="ui segment">
						<table class="ui very basic collapsing celled table"  style="font-size:10px;">
						  <thead>
						    <tr>
						    	<th>SR NO</th>
						    	<th>MACHINE</th>
						    	<th>STATUS</th>
						    	<th>SINCE</th>
						  </tr></thead>
						  <tbody>
						   <?php
						   if($coex_machine_master==FALSE){

						   }else{
						   	$i=1;
						   	foreach($coex_machine_master as $coex_machine_master_row){
						   		echo "<tr>
						   				<td>".$i."</td>
						   				<td>".$coex_machine_master_row->machine_name."</td>
						   				<td>";

						   				$result=$this->coex_runtime_downtime_model->coex_printing_machine_current_status('coex_printing_machine_start_stop',$this->session->userdata['logged_in']['company_id'],$coex_machine_master_row->machine_id);

						   				//echo $this->db->last_query();
						   				$time=0;
						   				if($result==FALSE){

						   				}else{
						   					
						   					foreach($result as $machine_status){
						   						echo ($machine_status->machine_start_stop_flag==0 ? "<a class='ui red label'>STOPPED</a> <a class='ui red label'> ".$machine_status->coex_machine_start_stop_reasons."</a>" : "<a class='ui green label'>RUNNING</a> <a class='ui green label'> ".$machine_status->coex_machine_start_stop_reasons."</a>");

						   						$time=$this->common_model->time_diffrence(date('Y-m-d H:i:s'),$machine_status->machine_start_stop_time);
						   					}
						   				}

						   				echo "</td>
						   				<td><a class='ui label'>".$time."</a></td>
						   			</tr>";
						   	$i++;
						   	}
						   }
						   ?>
						  </tbody>
						</table>
					</div>
				</div>

		    </div>

		    <div class="column">
		    </div>

		  </div>
		</div>
	</div>
</div>
</span>