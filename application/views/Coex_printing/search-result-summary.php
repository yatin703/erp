

<div class="record_form_design">
<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Downtime Summary From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="ui very basic collapsing celled table"  style="font-size:12px;">
				<thead>
				<tr>
					<th>Id</th>
					<th>Reason</th>
					<th>FLEXO1</th>
					<th>FLEXO2</th>
					<th>ISIMAT SCREEN</th>
					<th>MOSS</th>
					<th>BONMAC</th>
					<th>POLYTYPE</th>
					<th>TOTAL</th>
				</tr>
				</thead>
				<tbody>
				<?php if($coex_machine_downtime==FALSE){
					echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
				}else{
						$i=1;
						foreach($coex_machine_downtime as $row){

							
							echo "<tr>
									<td>".$i."</td>
									<td>".$row->downtime_reason."</td>
									<td class='negative right aligned'>".($row->FLEXO1_DONWTIME=="0h 0m" ? "-" : $row->FLEXO1_DONWTIME)."</td>
									<td class='negative right aligned'>".($row->FLEXO2_DONWTIME=="0h 0m" ? "-" : $row->FLEXO2_DONWTIME)."</td>
									<td class='negative right aligned'>".($row->ISIMATSCREEN_DONWTIME=="0h 0m" ? "-" : $row->ISIMATSCREEN_DONWTIME)."</td>
									<td class='negative right aligned'>".($row->MOSS_DONWTIME=="0h 0m" ? "-" : $row->MOSS_DONWTIME)."</td>
									<td class='negative right aligned'>".($row->BONMAC_DONWTIME=="0h 0m" ? "-" : $row->BONMAC_DONWTIME)."</td>
									<td class='negative right aligned'>".($row->POLYTYPE_DONWTIME=="0h 0m" ? "-" : $row->POLYTYPE_DONWTIME)."</td>
									<td class='warning right aligned'>".($row->TOTAL_DOWNTIME=="0h 0m" ? "-" : $row->TOTAL_DOWNTIME)."</td>";

									/*echo "
									<td>".$row->machine_name."</td>
									<td><a class='ui basic label'>".date("d-M-Y",strtotime($row->machine_start_time))."</a>
									<a class='ui basic label'>".date("h:i A",strtotime($row->machine_start_time))."</a></td>
									<td>".$row->coex_machine_start_stop_reasons."</td>
									<td>".($row->machine_stop_time=='0000-00-00 00:00:00' ? "-" : "<a class='ui basic label'>".date("d-M-Y",strtotime($row->machine_stop_time))."</a>
									<a class='ui basic label'>".date("h:i A",strtotime($row->machine_stop_time))."</a>")."</td>
									<td>".($row->machine_stop_time=='0000-00-00 00:00:00' ? '<a class="ui green label">Running</a>' : $this->common_model->time_diffrence($row->machine_stop_time,$row->machine_start_time))."</td>
									<td>".($row->machine_stop_time=='0000-00-00 00:00:00' ? '<a class="ui red label">Running</a>' : round((strtotime($row->machine_stop_time)-strtotime($row->machine_start_time))/60))."</td>
									*/
									echo "</tr>";
							$i++;
						}

						echo "</tbody>";
						if($coex_machine_downtime_total==FALSE){

							echo "<tr><td colspan='9'>NO RECORD</td></tr>";

						}else{
							foreach($coex_machine_downtime_total as $row_total){
							echo "<tfoot>
							<tr>
							<th colspan='2'><b>TOTAL</b></th>
							<th>".($row_total->FLEXO1_DONWTIME=="0h 0m" ? "-" : $row_total->FLEXO1_DONWTIME)."</th>
							<th>".($row_total->FLEXO2_DONWTIME=="0h 0m" ? "-" : $row_total->FLEXO2_DONWTIME)."</th>
							<th>".($row_total->ISIMATSCREEN_DONWTIME=="0h 0m" ? "-" : $row_total->ISIMATSCREEN_DONWTIME)."</th>
							<th>".($row_total->MOSS_DONWTIME=="0h 0m" ? "-" : $row_total->MOSS_DONWTIME)."</th>
							<th>".($row_total->BONMAC_DONWTIME=="0h 0m" ? "-" : $row_total->BONMAC_DONWTIME)."</th>
							<th>".($row_total->POLYTYPE_DONWTIME=="0h 0m" ? "-" : $row_total->POLYTYPE_DONWTIME)."</th>
							<th>".($row_total->TOTAL_DOWNTIME=="0h 0m" ? "-" : $row_total->TOTAL_DOWNTIME)."</th>
							</tr>
							</tfoot>";
							}
						}
						
					}
					?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>