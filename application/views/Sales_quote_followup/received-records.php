<div class="record_form_design">
<h3>Received Records</h3>
<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<div class="record_inner_design" style="font-size:10px;">
			<table class="ui green sortable celled table">
				<thead>
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>From</th>
					<th>To</th>
					<th>Record No</th>

					<th>Customer</th>
					<th>Product</th>
					 
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php if($followup_received==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
							$i=1;
							
							foreach($followup_received as $followup_received_row){

								if($followup_received_row->record_no!=''){
									$customer_no="";
									$product_name="";
									$data_search=array('quotation_no'=>substr(str_replace('@@@', '_', $followup_received_row->record_no), 0, strpos(str_replace('@@@', '_', $followup_received_row->record_no), '_')));
									$this->load->model('sales_quote_model');
									$sales_quote_master=$this->sales_quote_model->active_record_search('sales_quote_master',$this->session->userdata['logged_in']['company_id'],$data_search,'','');
									//echo $this->db->last_query();

									foreach($sales_quote_master as $sales_quote_row){
										$customer_no=$sales_quote_row->customer_no;
										$product_name=$sales_quote_row->product_name;
									}
									 

									$customer_name='';

									$customer_category_result=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'adr_category_id',$customer_no);

									foreach ($customer_category_result as $key => $customer_category_row) {
										$customer_name=$customer_category_row->category_name;
									}

								//if($customer_artwork_pdf!=''){	
								echo "<tr>
									<td>$i</td>
									<td>".$this->common_model->view_date($followup_received_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<td>".strtoupper($followup_received_row->from_user)."</td>
									<td>".strtoupper($followup_received_row->to_user)."</td>
									<td>".str_replace('@@@', '_', $followup_received_row->record_no)."</td>
									 </td>
									 <td>".$customer_name."</td>
									 <td>".$product_name."</td>
									<td>".($followup_received_row->status==1 ? 'PENDING' : '')."
									</td>
									<td>";

									$a="'Are you sure?'";
									foreach($formrights as $formrights_row){ 
										
										// echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/sales_quote/view/'.$followup_received_row->record_no).'" target="_blank"  ><i class="print icon"></i></a> &nbsp;&nbsp; ' : '');

										echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/sales_quote/approval/'.substr($followup_received_row->record_no,0,13).'/'.substr($followup_received_row->record_no,16)).'/'.$followup_received_row->transaction_no.'" target="_blank"  ><i class="thumbs outline up icon"></i>	</a> &nbsp;&nbsp; ' : '');

										echo ($formrights_row->new==1 ? 
											'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/notapproved/'.substr($followup_received_row->record_no,0,13).'/'.substr($followup_received_row->record_no,16)).'/'.$followup_received_row->transaction_no.'" onClick="return confirm('.$a.');" ><i class="thumbs outline down icon"></i>'
											 : 
											 '');

										echo ($formrights_row->copy==1 ? '<a href="#">Copy</a> ' : '');


										echo ($formrights_row->delete==1 ? '<a href="">Delete</a> ' : '');
									}
									echo "</td>
									</tr>";
								//}	


							    $i++;

							}

						}

					}?>
			</tbody>		
			</table>
	</div>


</div>