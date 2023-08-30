<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Sr No.</th>
					<th>Date</th>
					<th>Substrate</th> 
					<th>Pantone Code</th> 
					<th>Action</th>
				</tr>
				<?php 

				if($coextube_ink_mixing_master==FALSE){
					echo "<tr><td colspan='4'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);

							 	
							foreach($coextube_ink_mixing_master as $row){

							
								echo"<tr>
									<td>".$i."</td>
									<td>".$this->common_model->view_date($row->ink_mixing_date,$this->session->userdata['logged_in']['company_id'])."</td> 
									<td>".$row->substrate."</td>
									<td>".$row->pantone_code."</td>						 							 
									<td>";
										foreach($formrights as $formrights_row){ 

											echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->mixing_id).'" target="_blank"><i class="print icon"></i></a> ' : '');					

											echo ($formrights_row->modify==1   ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->mixing_id).'"><i class="edit icon"></i></a> ' : '');										
											echo ($row->archive<>1 && $formrights_row->delete==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->mixing_id).'"><i class="trash icon"></i></a> ' : '');											 
																														
										}	


							echo "</td></tr>";


							$i++;
							}
						}?>		 
			</table>
		<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>