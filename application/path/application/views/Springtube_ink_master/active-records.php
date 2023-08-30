<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design"  style="overflow: scroll; white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				
				<tr>
					<th>Sr No.</th>
					<th>Action</th>
					<!-- <th>Ink Id</th> -->
					<th>Date</th>
					<th>Composition</th>
					<th>Mixing Status</th>
					<th>Ink Desc</th>	
					<th>Substrate</th>
					<th>Manufacturer</th>
					<th>Ink Name</th>
					<th>Ink Code</th>					
					<th>Ink Category</th> 
					<th>Ink Migration</th>					
					<th>Article No</th>
					<th>Article Name</th>					 
					<th>Comment</th>
									
					
				</tr>
				<?php 				 

				if($springtube_ink_master==FALSE){
					echo "<tr><td colspan='19'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
							 	
						foreach($springtube_ink_master as $row){

							// $mixing_status=0;

							// if($row->ink_composition==2){

							// 	$data=array('ink_id'=>$row->ink_id);
							// 	$springtube_ink_mixing_master_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_master',$data,$this->session->userdata['logged_in']['company_id']);

							// 	if($springtube_ink_mixing_master_result){

							// 		$mixing_status=1;
							// 	}
							// 	else{
							// 		$mixing_status=0;
							// 	}
							// }
							
								
							echo"<tr>
								<td>".$i."</td>
								<td>";
									foreach($formrights as $formrights_row){ 


										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ink_id).'" target="_blank"><i class="edit icon"></i></a> ' : '');										
										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ink_id).'" target="_blank"><i class="trash icon"></i></a> ' : '');
																														
									}

							echo "</td>


								<!--<td title='".$row->ink_desc."'>".$row->ink_id."</td>-->
								<td>".$this->common_model->view_date($row->ink_creation_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".($row->ink_composition=='2'?"MIXER INK":"DIRECT")."</td>
								<td>".($row->ink_composition=='2'?($row->mixing_status==1?"<a href='#' style='color:#06c806;'><i class='check circle icon'></i>Mix. Done<a>":"<a style='color:#f10606;'><i class='times circle icon'></i> Pending<a>"):"")."</td>

								<td>".$row->ink_desc."</td>
								<td>".$row->substrate."</td>
								<td>".$row->ink_manufacturer."</td>
								<td>".$row->ink_name."</td>
								<td>".$row->ink_code."</td>
								<td>".$row->ink_category."</td>
								<td>".$row->ink_migration."</td>								
								<td>".$row->article_no."</td>
								<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$row->comment."</td>
								

								<!--<td>";
									foreach($formrights as $formrights_row){ 


										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ink_id).'" target="_blank"><i class="edit icon"></i></a> ' : '');										
										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ink_id).'" target="_blank"><i class="trash icon"></i></a> ' : '');
																														
									}

							echo "</td>
							-->

							</tr>";				 


							$i++;
							}
						}?>							 
							 	
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>