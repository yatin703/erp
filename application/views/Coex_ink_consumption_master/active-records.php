<div class="record_form_design">
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="ui very basic collapsing celled table"  style="font-size:11px;">
				<thead>
				<tr>
					<th colspan="10">INK GM/TUBE </th>
				</tr>
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Product</th>
					<th>Artwork</th>
					<th>Version No</th>
					<th>Flexo</th>
					<th>Screen</th>
					<th>Offset</th>
					<th>Special Screen</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$sum_total_rm=0;
				if($coex_ink_consumption_master==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						foreach($coex_ink_consumption_master as $row){


							echo "<tr>
									<td>".$i."</td>
									<td>".$this->common_model->view_date($row->entry_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->article_no."</td>
									<td>".$row->artwork_no."</td>
									<td>".$row->artwork_version_no."</td>
									<td>".$row->flexo_ink_gm_tube."</td>
									<td>".$row->screen_ink_gm_tube."</td>
									<td>".$row->offset_ink_gm_tube."</td>
									<td>".$row->special_ink_gm_tube."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->cicm_id).'" target="_blank"><i class="print icon"></i></a> ' : '');


										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->cicm_id).'"><i class="edit icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->cicm_id).'"><i class="trash icon"></i></a> ' : '');
										
									} 
									echo "</td>

									</tr>";
									
							$i++;
						}
					}
					?>		
						</tbody>
					</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>