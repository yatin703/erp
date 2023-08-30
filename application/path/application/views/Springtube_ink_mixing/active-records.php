<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Active Records</h4>
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

				$total_offset=0;

				if($springtube_ink_mixing_master==FALSE){
					echo "<tr><td colspan='19'>No Active Records Found</td></tr>";
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
									<td>".($row->ink_composition==1?"DIRECT":"MIXTURE INK")."</td>							 							 
									<td>";
										foreach($formrights as $formrights_row){ 

											echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->mixing_id).'" target="_blank"><i class="print icon"></i></a> ' : '');					

											echo ($formrights_row->modify==1 && $row->final_approval_flag<>1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->mixing_id).'"><i class="edit icon"></i></a> ' : '');										
											echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->mixing_id).'"><i class="trash icon"></i></a> ' : '');											 
																														
										}	


							echo "</td></tr>";

							//$total_offset+=$offset;
							// $total_screen+=$screen;
							// $total_flexo+=$flexo;


							$i++;
							}
						}?>
							 
							 	
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>