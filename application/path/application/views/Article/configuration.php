<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Main Group</th>
					<!--<th>Sub Group</th>-->
					<th>Action</th>
				</tr>
				<?php if($article_main_group==FALSE){
					echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
				}else{
						$this->load->model('sub_group_model');
      					$this->load->model('second_sub_group_model');		
								
							foreach($article_main_group as $row){
								
								//$sub_group=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.main_group_id',$row->main_group_id);

								//foreach($sub_group as $sub_group_row){

											echo "<tr>
												<td>".$row->main_group_id."</td>
												<td>".strtoupper($row->lang_main_group_desc)."</td>
												<td>";
												foreach($formrights as $formrights_row){ 
													echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create_article/'.$row->main_group_id).'"><i class="add circle icon"></i></a> ' : '');
													
												}
												echo "</td>
											</tr>";

								//}
									
							}
						}?>
								
						</table>
						
					</div>
				</div>