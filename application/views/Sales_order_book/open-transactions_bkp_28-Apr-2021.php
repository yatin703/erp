<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	function chkall(source) {
			checkboxes = document.getElementsByName('order_no[]');
			for(var i=0, n=checkboxes.length;i<n;i++) {
				checkboxes[i].checked = source.checked;
			}
	}

	$(document).ready(function(){
			

	});

</script>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/close_transactions');?>" method="POST" >

<div class="form_design">
	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

	<?php if(isset($note_1)){
		foreach ($note_1 as  $note_1_row) {
		 	echo "<p class='alert alert-success'>".$note_1_row." </p>";		
		}
	}?>
	<?php if(isset($error_1)){

		foreach ($error_1 as  $error_1_row) {

		 	echo "<p class='alert alert-error'>".($error_1_row)." </p>";	
		}

	}?>
	 <div class="record_inner_design" style="overflow: scroll;">
					<table class="record_table_design_without_fixed" >

						<tr>
							<th>Sr. No.</th>
							<th>Order No.</th>
							<th>Order Date</th>
							<th>Bill To</th>
							<th>Ship To</th>
							<th>Article Code</th>
							<th>Article Name</th>
							<th>Quantity</th>
							<th>Created By</th>
							<th>Approve By</th>
							<th>Approval Date</th>
							<th>Order Type</th>
							<th>Is Sample</th>
							<th>Order Status</th>
							<th>Transaction Status</th>
							<th>Comments</th>
							<th>
								<input type="checkbox" name="allchk[]" onClick="chkall(this)">All
							</th>
					
						</tr>

				<?php if($order_master==FALSE){
					echo "<tr><td colspan='17'>No Records Found</td></tr>";
				}
				else 
				{
					$ci =&get_instance();
					$ci->load->model('sales_order_book_model');
				    $ci->load->model('common_model');
				    $ci->load->model('article_model');
				    $ci->load->model('customer_model');

				    $sum_quantity=0;
				    $sum_net_amount=0;
				    $sum_total_tax=0;
				    $sum_gross_amount=0;

				    $n=1;
					foreach($order_master as $mrow){

						$details_data=array();
						$details_data['order_no']=$mrow->order_no;
						if(!empty($this->input->post('article_no'))){
							$arr=explode("//",$this->input->post('article_no'));
							$article_no=$arr[1];
							$details_data['article_no']=$article_no;
						}
							
						$result=$ci->sales_order_book_model->active_details_records('order_details',$details_data,$this->session->userdata['logged_in']['company_id']);
						//echo $this->db->last_query();
						
						$rowspan=count($result);
					    $tr=$rowspan;

					    if($rowspan>0){

							$ship_to='';
							$ship_to_gst='';
							if($mrow->consin_adr_company_id!=''){

								$arr=explode("|",$mrow->consin_adr_company_id);
								$consignee=$arr[0];
								$result_consignee=$ci->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$consignee);
								foreach ($result_consignee as $row_consignee){
									$ship_to=$row_consignee->name1.' ('.$row_consignee->lang_property_name.')';
									$ship_to_gst=$row_consignee->isdn_local;
								}


							}
							else{

								$ship_to=$mrow->name1." (".strtoupper($mrow->lang_property_name).")";
							}

							$currency=($mrow->currency_id!='' ? $mrow->currency_id:'');
							$exchange_rate=($mrow->exchange_rate!='0' ?number_format($ci->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']),2,'.',','):'');
								
							echo "<tr>
							<td rowspan='".$rowspan."'>".$n++."</td>
							<td rowspan='".$rowspan."'>".($mrow->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." ".$mrow->order_no."</td>
							<td rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td rowspan='".$rowspan."'>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>							
							<td rowspan='".$rowspan."'>".$ship_to."</td>
							
							";
								
							$r=0;
							foreach ($result as $drow){


								$article_result=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$drow->article_no);
								
								foreach($article_result as $article_row){
									$article_name=$article_row->article_name;

								}

								$dia='';	
								$length='';
								$print_type='';

								$specs['spec_id']=$drow->spec_id;
								$specs['spec_version_no']=$drow->spec_version_no;

								$specs_result=$ci->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
								if($specs_result){
										foreach($specs_result as $specs_row){
											$dia=$specs_row->SLEEVE_DIA;
											$length=$specs_row->SLEEVE_LENGTH;
											$print_type=$specs_row->SLEEVE_PRINT_TYPE;

										}
							    }

							    

								if($mrow->for_export==1){

									$net_amount=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$drow->calc_sell_price;

								}else{

									$net_amount=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id'])* $ci->common_model->read_number($drow->selling_price,$this->session->userdata['logged_in']['company_id']);
								}
								

									echo"
									<td>".$drow->article_no."</td>
									<td>".$article_name."</td>
									<td>".number_format($ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>";
									
					    			if($r==0){

					    				$sum_gross_amount+=$ci->common_model->read_number($mrow->total_amount,$this->session->userdata['logged_in']['company_id']);

					    				echo"
					    					<td class='ellipses' rowspan='".$rowspan."'>".strtoupper($ci->common_model->get_user_name($mrow->user_id,$this->session->userdata['logged_in']['company_id']))."</td>
											<td class='ellipses' rowspan='".$rowspan."'>".($mrow->final_approval_flag==1 ? "".substr(strtoupper($ci->common_model->get_user_name($mrow->approved_by,$this->session->userdata['logged_in']['company_id'])),0,strpos($ci->common_model->get_user_name($mrow->approved_by,$this->session->userdata['logged_in']['company_id']),' '))."" : '')."</td>
								            <td  rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
								            <td  rowspan='".$rowspan."'>".($mrow->for_export==1 ? "EXPORT":"LOCAL")."</td>
								            <td  rowspan='".$rowspan."'>".($mrow->for_sampling==1 ? "SAMPLE":"")."</td>
								            <td  rowspan='".$rowspan."'>";
								             	if($mrow->order_closed==0){
								             		echo "OPEN";
								             	}
								             	if($mrow->order_closed==1){
								             		echo "COMPLETED";
								             	}
								             	if($mrow->order_closed==2){
								             		echo "PARTIALLY COMPLETED";
								             	}
											echo "</td>
												<td  rowspan='".$rowspan."'>";
								             	if($mrow->trans_closed==1){
								             		echo "MANUALLY CLOSED";
								             	}
								             	
											echo "</td>
											<td rowspan='".$rowspan."'>".$mrow->lang_addi_info."</td>
											<td rowspan='".$rowspan."'>";
											foreach($formrights as $formrights_row){ 												
												echo ($formrights_row->modify==1 ? '<input type="checkbox" name="order_no[]" value="'.$mrow->order_no.'"> ' : '');
												
											}
											echo "</td>";

					    			}

									echo"</tr>";
									if($rowspan>1 && --$tr>0){
											echo'<tr>';
									}			

									$r++;

									//------TOTAL----------
									$sum_quantity+=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
									
							}

						}//detail if	
						
					}


				} 
				?>
								
					</table>
				</div>
			</div>
					<?php if($formrights){
						foreach ($formrights as $formrights_row) {
							if($formrights_row->modify=='1'){ ?>

								<div class="form_design">
									<div class="ui buttons">
								  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
								  		<div class="or"></div>
								  		<button id="btn_close" class="ui positive button" onClick="return confirm('Are you sure to close the orders');">Close transactions</button>
									</div>
							  	</div>
					<?php	}
						}
						
					}?>						
									
					
			</form>	
				
				
				
				
				
			