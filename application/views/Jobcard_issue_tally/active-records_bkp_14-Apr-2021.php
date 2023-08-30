<script>
function ConfirmDelete()
{
  var result=confirm("Are you sure you want to delete?");
  if(result){
  	return true;
  }
  return false;
}
</script>
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design" style="overflow: scroll;white-space: nowrap; ">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Sr No</th>
					<th>Id</th>
					<th>Issue Date</th>
					<th>Jobcard No</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Qty</th>
					<th>Status</th>
					<th>Remark</th>
					<th>Transaction Date</th>
					<th>Action</th>


				</tr>
				<?php if($tally_material_issue_master==FALSE){
					echo "<tr><td colspan='10'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));
							foreach($tally_material_issue_master as $row){
								echo "<tr>
									<td>".++$i."</td>
									<td>".$row->id."</td>
									<td>".$row->issue_date."</td>
									<td>".$row->jobcard_no."</td>
									<td>".$row->part_no."</td>
									<td>".$this->common_model->get_article_name($row->part_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->qty."</td>
									<td>".$row->status."</td>
									<td>".$row->remarks."</td>
									<td>".$row->transaction_date."</td>	

									<td>";
									foreach($formrights as $formrights_row){ 

										echo($formrights_row->modify=='1'?"<a title='Modify' href='".base_url('index.php/'.$this->router->fetch_class()."/modify/".$row->id.'')."' target='_blank'><i class='edit icon'></i></a>|":"");
										if($row->status=='ERROR'){

											echo($formrights_row->delete=='1'?"<a title='Delete' href='".base_url('index.php/'.$this->router->fetch_class()."/delete/".$row->id.'')."' target='_blank' onClick='return ConfirmDelete();'><i class='delete icon'></i></a>":"");
										}
									}
											
									
									echo"</td>						

							</tr>";
							//print_r($formrights);
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>