<style>	
   tr:hover {background-color:#e4e4e4;}
</style>		
<div class="record_form_design">
<h3>Received Records</h3>
<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>From</th>
					<th>To</th>
					<th>Record No</th>
					<th>Order No.</th>
					<th>Article No.</th>
					<th>Jobcard No.</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($followup_received==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
					$i=1;
							$order_no='';
							$article_no='';
							$jobcard_no='';
							$job_id='';
							$spec_id='';
							$spec_version_no='';
							foreach($followup_received as $followup_received_row){

								if($followup_received_row->record_no!=''){

									$arr=explode("@@@",$followup_received_row->record_no);
									$jobcard_no=$arr[0];
									$job_id=$arr[1];

									$data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$job_id);

									foreach ($data['springtube_printing_jobsetup_master'] as  $springtube_printing_jobsetup_master_row) {
										
										$order_no=$springtube_printing_jobsetup_master_row->order_no;
										$article_no=$springtube_printing_jobsetup_master_row->article_no;
										
									}

									


									$data=array('order_no'=>$order_no,
									'article_no'=>$article_no);
									$order_details_result=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$data);

									foreach ($order_details_result as $key => $order_details_row) {

										$spec_id=$order_details_row->spec_id;
										$spec_version_no=$order_details_row->spec_version_no;
										
									}									

								}


								
								echo "<tr>
									<td>$i</td>
									<td>".$this->common_model->view_date($followup_received_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<td>".strtoupper($followup_received_row->from_user)."</td>
									<td>".strtoupper($followup_received_row->to_user)."</td>
									<td><a href=".base_url('index.php/springtube_printing_jobsetup/view/'.$job_id)." target='_blank'>".str_replace('@@@', '_', $followup_received_row->record_no)."</a>
									</td>
									<!--<td>".str_replace('@@@', '_', $followup_received_row->record_no)."</td>-->
									<td><a href=".base_url('index.php/sales_order_book/view/'.$order_no)." target='_blank'>$order_no</a></td>
									<td>".$article_no."</td>
									<td><a href=".base_url('index.php/sales_order_item_parameterwise/view_new/'.$jobcard_no.'/'.$spec_id.'/'.$spec_version_no)." target='_blank'>$jobcard_no</a></td>
									
									<td>".($followup_received_row->status==1 ? 'PENDING' : '')."</td>
									<td>";

									$a="'Are you sure?'";
									foreach($formrights as $formrights_row){ 
										
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/springtube_printing_jobsetup/view/'.$job_id).'" target="_blank"  ><i class="print icon"></i></a> &nbsp;&nbsp; ' : '');

										echo ($formrights_row->new==1 ? 
											'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/approved/'.$jobcard_no.'/'.$job_id).'/'.$followup_received_row->transaction_no.'" onClick="return confirm('.$a.');"><i class="thumbs outline up icon"></i> 
											&nbsp;
											&nbsp;  

											<a href="'.base_url('index.php/'.$this->router->fetch_class().'/notapproved/'.$jobcard_no.'/'.$job_id).'/'.$followup_received_row->transaction_no.'" onClick="return confirm('.$a.');" ><i class="thumbs outline down icon"></i>'
											 : 
											 '');

										echo ($formrights_row->copy==1 ? '<a href="#">Copy</a> ' : '');

										echo ($formrights_row->modify==1 ? '<a href="">Modify</a> ' : '');

										echo ($formrights_row->delete==1 ? '<a href="">Delete</a> ' : '');
									}
									echo "</td>
									</tr>";
								//}	


							    $i++;

							}

					}?>
								
			</table>
	</div>


</div>