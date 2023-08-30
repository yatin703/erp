<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design">
				<tr>
					<th>PARENT GROUP NAME</th>
					<th>GROUP NAME</th>
					<th>HSN DESC</th>
					<th>HSN / SAC NO</th>
					<th>TAXABILITY</th>
					<th>REVERSE CHARGE APPL?</th>
					<th>IGST RATE</th>
					<th>CGST RATE</th>
					<th>SGST RATE</th>
					<th>CESS</th>
				</tr>
				<?php if($main_group==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
							foreach($main_group as $row){

								echo "<tr>
									<td>Primary</td>
									<td>".strtoupper($row->lang_main_group_desc)."</td>
									<td>".strtoupper($row->hsn_desc)."</td>
									<td>$row->tariff_no</td>
									<td>YES</td>
									<td>NO</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
							</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>