
<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Shoulder Foil</th>
					<th>Sleeve Dia</th>
					<th>Foil Width</th>
					<th>Foil Length</th>
					<th>Foil Area</th>
					<th>Foil Area/Tube</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($shoulder_foil_master==FALSE){
					echo "<tr><td colspan='5'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($shoulder_foil_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>$row->article_name</td>
									<td>$row->sleeve_diameter</td>
									<td>$row->one_roll_width_in_meter</td>
									<td>$row->one_roll_length_in_meter</td>
									<td>$row->one_roll_sqm_area</td>
									<td>$row->sqm_per_tube</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->sfm_id.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>