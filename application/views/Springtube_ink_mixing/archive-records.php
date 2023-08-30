<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Archive Records</h4>
	<div class="record_inner_design"  style="overflow: scroll; white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				
				<tr>
					<th>Sr No.</th>
					<th>Date</th>
					<th>Ink Manufacturer</th>
					<th>Ink Name</th>
					<th>Ink Code</th>					
					<th>Ink Category</th> 
					<th>Ink Migration</th>
					<th>Ink Composition</th>
					<!--<th>Approved Date</th>
					<th>Approved By</th>-->
					<th>Action</th>
				</tr>
				<?php 


				if($springtube_ink_mixing_master==FALSE){
					echo "<tr><td colspan='19'>No Archive Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);

							 	
							foreach($springtube_ink_mixing_master as $row){

							
								echo"<tr>
									<td>".$i."</td>
									<td>".$this->common_model->view_date($row->ink_mixing_date,$this->session->userdata['logged_in']['company_id'])."</td> 
									
									<td>".$row->ink_manufacturer."</td>
									<td>".$row->ink_name."</td>
									<td>".$row->ink_code."</td>	
									<td>".$row->ink_category."</td>
									<td>".$row->ink_migration."</td>
									<td>".$row->ink_composition."</td>		 							 
									<td>";
										foreach($formrights as $formrights_row){

											echo ( $formrights_row->dearchive=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->mixing_id).'">Dearchive</a>' : '');
																														
										}	

							echo "</td></tr>";

							 


							$i++;
							}
						}?>
							 
							 	
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>