<div class="record_form_design">
<h4>Archive Records</h4>
	<div class="record_inner_design"  style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				
				<tr>
					<th>Sr No.</th>
					<th>Cap Article No.</th>
					<th>Cap Descr</th>
					<th>Cap Metalization Charges Article No.</th>
					<th>Cap Metalization Charges Descr</th>					
					<th>Action</th>
				</tr>
				<?php if($cap_combination_master==FALSE){
					echo "<tr><td colspan='10'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($cap_combination_master as $row){
																
								echo"<tr>
									<td>".$i."</td>
									<td>".$row->article_no."</td>
									<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->ref_article_no."</td>
									<td>".$this->common_model->get_article_name($row->ref_article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>";
										
									foreach($formrights as $formrights_row){ 

											echo($row->archive=='1' && $formrights_row->dearchive=='1'?'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->id).'">Dearchive</a>':'');
																														
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