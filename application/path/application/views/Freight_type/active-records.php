
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Sr. No.</th>
					<th>Freight Type Description</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($freight_type_master_lang==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));
							foreach($freight_type_master_lang as $row){
								echo "<tr>
									<td>".++$i."</td>
									<td>".strtoupper($row->lang_freight_type)."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->freight_type_id.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->freight_type_id.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>