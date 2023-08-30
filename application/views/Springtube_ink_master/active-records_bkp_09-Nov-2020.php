<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design"  style="overflow: scroll; white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				
				<tr>
					<th>Sr No.</th>
					<th>Ink Id</th>
					<th>Ink Creation Date</th>
					<th>Substrate</th>
					<th>Ink Manufacturer</th>
					<th>Ink Name</th>
					<th>Ink Code</th>					
					<th>Ink Category</th> 
					<th>Ink Migration</th>
					<th>Ink Composition</th>
					<th>Article No</th>
					<th>Article Name</th>					 
					<th>Comment</th>
					<th>Ink Desc</th>					
					<th>Action</th>
				</tr>
				<?php 				 

				if($springtube_ink_master==FALSE){
					echo "<tr><td colspan='19'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
							 	
						foreach($springtube_ink_master as $row){
								
							echo"<tr>
								<td>".$i."</td>
								<td title='".$row->ink_desc."'>".$row->ink_id."</td>
								<td>".$row->ink_creation_date."</td>
								<td>".$row->substrate."</td>
								<td>".$row->ink_manufacturer."</td>
								<td>".$row->ink_name."</td>
								<td>".$row->ink_code."</td>
								<td>".$row->ink_category."</td>
								<td>".$row->ink_migration."</td>
								<td>".($row->ink_composition=='1'?"DIRECT":"MIXER INK")."</td>
								<td>".$row->article_no."</td>
								<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$row->comment."</td>
								<td>".$row->ink_desc."</td>

								<td>";
									foreach($formrights as $formrights_row){ 


										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ink_id).'" target="_blank"><i class="edit icon"></i></a> ' : '');										
										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ink_id).'" target="_blank"><i class="trash icon"></i></a> ' : '');
																														
									}

							echo "</td>

							</tr>";				 


							$i++;
							}
						}?>							 
							 	
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>