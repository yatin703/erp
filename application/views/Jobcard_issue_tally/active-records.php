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
			<table class="ui very compact celled table" style="font-size:10px;">
				<thead>
				<tr>
					<th>Sr No</th>
					<th>Id</th>
					<th>Issue Date</th>
					<th>Process</th>
					<th>Jobcard No</th>
					<th>Group</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Qty</th>
					<th>Unit</th>
					<th>Status</th>
					<th>Remark</th>
					<th>Transaction Date</th>
					<th>Action</th>


				</tr>
			</thead>
			<tbody>
				<?php if($tally_material_issue_master==FALSE){
					echo "<tr><td colspan='10'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));

							$order_type='';
							$process_name='';
							$main_group='';
							$sub_group='';
							$second_sub_group='';
							$sum_qty=0;
							foreach($tally_material_issue_master as $row){		

								$order_type='';
								$process_name='';
								$main_group='';
								$sub_group='';
								$second_sub_group='';
								$uom='';
								
								$arr=explode("/", $row->jobcard_no);
								$order_no=$arr[1];
								
								$order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);							
								
								if($order_master_result==TRUE){
									foreach ($order_master_result as $key => $order_master_row) {
										$order_type=$order_master_row->order_flag;
									}

								}
								if(strtolower(substr($row->jobcard_no,0,6))=="manual"){
									$arr_manual=explode("_",$row->jobcard_no);
									if(count($arr_manual)>0){
										$process_name= $arr_manual[3];
									}
								}


								$article_result=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$row->part_no);

								if($article_result==TRUE){
									foreach ($article_result as $key => $article_row) {
										$main_group=$article_row->main_group;
										$sub_group=$article_row->sub_group;
										$second_sub_group=$article_row->second_sub_group;
										$uom=$article_row->uom;
									}
								}


								$sum_qty+=$row->qty;

								echo "<tr>
									<td>".++$i."</td>
									<td>".$row->id."</td>
									<td>".$row->issue_date."</td>
									<td>".($process_name!=''?strtoupper('MANUAL-'.$process_name):($order_type==0?"COEX":"SPRING"))."</td>
									<td>".$row->jobcard_no."</td>
									<td>".($sub_group!=''?$sub_group:$main_group)."</td>
									<td>".$row->part_no."</td>
									<td>".$this->common_model->get_article_name($row->part_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".number_format($row->qty,2,'.',',')."</td>
									<td>".$uom."</td>
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

							echo'<tr style="font-weight:bold;">
								<td colspan="8">TOTAL</td>
								<td>'.number_format($sum_qty,2,'.',',').'</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								</tr>';
						}?>
						</tbody>	
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>