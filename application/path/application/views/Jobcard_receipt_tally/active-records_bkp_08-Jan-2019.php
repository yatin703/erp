
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Sr No</th>
					<th>Id</th>
					<th>Issue Date</th>
					<th>Jobcard No</th>
					<th>Article No</th>
					<th>Qty</th>
					<th>Avg Rate</th>
					<th>Status</th>
					<th>Remark</th>
					<th>Transaction Date</th>
					


				</tr>
				<?php if($tally_issued_material_receipt==FALSE){
					echo "<tr><td colspan='10'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));
							foreach($tally_issued_material_receipt as $row){
								echo "<tr>
									<td>".++$i."</td>
									<td>".$row->id."</td>
									<td>".$row->issue_date."</td>
									<td>".$row->jobcard_no."</td>
									<td>".$row->part_no."</td>
									<td>".$row->qty."</td>
									<td>".$row->avg_rate."</td>
									<td>".$row->status."</td>
									<td>".$row->remarks."</td>
									<td>".$row->transaction_date."</td>							

							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>