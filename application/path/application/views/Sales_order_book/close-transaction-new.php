<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
 





	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_close_transaction_new');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		

		<?php 						
			foreach($order_master as $order_row):

				//echo $order_row->customer_no;

				$data=array('order_no'=>$order_row->order_no);
				$order_details_result=$this->sales_order_book_model->active_details_records('order_details',$data,$this->session->userdata['logged_in']['company_id']);	

		?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
					
						 
							<tr>
								<td class="label">Order No <span style="color: red;"><b>*</b></span> :</td>
								<td>
									<input type="hidden" name="order_flag" id="order_flag" value="<?php echo $order_row->order_flag;?>">
									<!-- <input type="hidden" name="order_no" id="order_no" value="<?php echo $order_row->order_no;?>"> -->
									<input type="text" name="order_no" id="order_no" value="<?php echo set_value('order_no',$order_row->order_no);?>" readonly>
								</td>
							</tr>

							<tr>
								<td class="label">Order Date <span style="color: red;"><b>*</b></span> :</td>
								<td><input type="text" name="order_date" value="<?php echo $order_row->order_date;?>" disabled>
								</td>
							</tr>

							<tr>
								<td class="label">Bill To <span style="color: red;"><b>*</b></span> :</td>
								<td>
									<input type="hidden" name="customer" value="<?php echo $order_row->customer_no;?>">
									<select name="adr_company_id" disabled>
										<option value="<?php echo $order_row->customer_no;?>"><?php echo $this->common_model->get_customer_name($order_row->customer_no,$this->session->userdata['logged_in']['company_id']).'//'.$order_row->customer_no;?></option>	
									
								</select></td>
							</tr>
							<tr>
								<td class="label">Ship To   :</td>
								<td><select name="consin_adr_company_id" id="consin_adr_company_id" disabled>
									<option value=''>--Same As Bill To--</option>
									<?php
									foreach ($ship_to as $ship_to_row){
										$selected=($ship_to_row->related_company_id==explode("|",$order_row->consin_adr_company_id)[0] ? 'selected' :'');
									    echo "<option value='".$ship_to_row->related_company_id."' ".set_select('consin_adr_company_id',''.$ship_to_row->related_company_id.'').">".$ship_to_row->relate."//".$ship_to_row->related_company_id."//".$ship_to_row->lang_property_name."</option>";
									} 
									?> 
								</select></td>
							</tr>

							<tr>
								<td class="label">Po No <span style="color: red;"><b>*</b></span> :</td>
								<td><input type="text" name="po_no" value="<?php echo set_value('po_no',$order_row->cust_order_no);?>" disabled/></td>
							</tr>
							
							<tr>
								<td class="label">Po Date <span style="color: red;"><b>*</b></span> :</td>
								<td><input type="date" name="po_date" value="<?php echo set_value('po_date',$order_row->order_date);?>" disabled/></td>
							</tr>

							<tr>
								<td class="label">Export  :</td>
								<td><input type="checkbox" name="export"  value="1" <?php echo set_checkbox('export',1);?> <?php echo ($order_row->for_export==1 ? 'value="1" checked' : 'value="0"');?> disabled/></td>
							</tr>

							<tr>
								<td class="label">For Sample  :</td>
								<td><input type="checkbox" name="for_sampling"  value="1" <?php echo set_checkbox('for_sampling',1);?> <?php echo ($order_row->for_sampling==1 ? 'value="1" checked' : 'value="0"');?> disabled/></td>
							</tr>
							<tr>
								<td class="label">For Stock  :</td>
								<td><input type="checkbox" name="for_stock"  value="1" <?php echo set_checkbox('for_stock',1);?> <?php echo ($order_row->for_stock==1 ? 'value="1" checked' : 'value="0"');?> disabled/></td>
							</tr>
							<tr>
								<td class="label">Created By :</td>
								<td><select name="user_id" disabled >
									<option value=''>--Select user--</option>
									<?php 
									foreach ($user_master as $user_master_row) {
						             	$selected=($user_master_row->user_id==$order_row->user_id?'selected':'');
						             	echo "<option value='".$user_master_row->user_id."' ".set_select('user_id',$user_master_row->user_id)." ".$selected.">".strtoupper($user_master_row->login_name)."</option>";
						            }
						             ?>
						            </select>
						        </td>
							</tr>

							<tr>
								<td class="label">Approval Authority :</td>
								<td><select name="approval_authority" disabled>
									<option value=''>--Select Authority--</option>
									<?php 
										foreach ($approval_authority as $approval_authority_row) {
											$selected=($approval_authority_row->employee_id==$order_row->approved_by ? 'selected' : '' );
										echo "<option value='".$approval_authority_row->employee_id."' $selected ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
										}
									?>
								</select>
								</td>
							</tr>
							 
					</table>			
				</td>
				<td width="50%">
				<?php foreach($order_details_result as $order_details_row):

					$jobcard_qty=0;

					if($order_row->order_flag==1){

						$data_search=array('sales_ord_no'=>$order_details_row->order_no,'article_no'=>$order_details_row->article_no,'archive'=>0,
							'jobcard_type'=>2);
       					$production_master_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'], $data_search);
  
	                    foreach($production_master_result as $row) {
	                      $jobcard_qty+=$this->common_model->read_number($row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
	                    }

					}else{

						$data_search=array('sales_ord_no'=>$order_details_row->order_no,'article_no'=>$order_details_row->article_no,'archive'=>0
							);
       					$production_master_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'], $data_search);
  
	                    foreach($production_master_result as $row) {
	                      $jobcard_qty+=$this->common_model->read_number($row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
	                    }

					}
					$supply_qty=0;
					$invoice=array();
	                $invoice['ref_ord_no']=$order_details_row->order_no;
	                $invoice['article_no']=$order_details_row->article_no;
	                $supply_qty_result=$this->sales_order_status_model->sum_supply_qty('ar_invoice_master',$invoice,$this->session->userdata['logged_in']['company_id']);              

	                foreach($supply_qty_result as $supply_qty_row){
	                    $supply_qty=$supply_qty_row->supply_qty;

	                }

	                $supply_qty=$this->common_model->read_number($supply_qty,$this->session->userdata['logged_in']['company_id']);

				?>
				<table class="form_table_inner">						
					<tr>
						<td class="label">Product Code <span style="color: red;"><b>*</b></span> :</td>
						<td>
							<input type="text" name="article_no" id="article_no" value="<?php echo $order_details_row->article_no;?>" readonly>
							<input type="hidden" name="ord_pos_no" value="<?php echo $order_details_row->ord_pos_no;?>">
						</td>
					</tr>
					<tr>
						<td class="label">Product Name <span style="color: red;"><b>*</b></span> :</td>
						<td >
							<input type="text" name="article_name" size="60" value="<?php echo $order_details_row->description;?>" disabled>
						</td>
					</tr>
					<tr>
						<td class="label">Spec No <span style="color: red;"><b>*</b></span> :</td>
						<td>
							<input type="text" name="spec_id" value="<?php  echo ($order_details_row->spec_id!='' ? $order_details_row->spec_id."_R".$order_details_row->spec_version_no : '');?>" readonly>
							<input type="hidden" name="spec_no" value="<?php  echo $order_details_row->spec_id;?>">
							<input type="hidden" name="spec_version_no" value="<?php  echo $order_details_row->spec_version_no;?>">
						 
							<?php
							if(!empty($order_details_row->spec_id)){
								if(substr($order_details_row->spec_id,0,1)=="S"){
								echo ($order_details_row->spec_id!='' ? "<a href='".base_url()."/index.php/specification/view/".$order_details_row->spec_id."/".$order_details_row->spec_version_no."' target='_blank'>".$order_details_row->spec_id."_R".$order_details_row->spec_version_no."</a>" : '');
							}else{
								$bom=array('bom_no'=>$order_details_row->spec_id,
                                'bom_version_no'=>$order_details_row->spec_version_no);
                            	$data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
                                foreach($data['bom'] as $bom_row){                                          
                                    echo "<a href='".base_url()."/index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$order_details_row->spec_id."_".$order_details_row->spec_version_no."</a>";
                                	}                                   
                            	}
                        	}

							?>								
						</td>
					</tr>
					<tr>
						<td class="label">Artwork No <span style="color: red;"><b>*</b></span> :</td>
						<td>
							<input type="hidden" name="artwork_no" value="<?php  echo $order_details_row->ad_id;?>">
							<input type="hidden" name="artwork_version_no" value="<?php  echo $order_details_row->version_no;?>">
							<input type="text" name="ad_id" value="<?php echo ($order_details_row->ad_id!='' ? $order_details_row->ad_id."_R".$order_details_row->version_no : '');?>" readonly>						
						 	
						<?php  
						if($order_row->order_flag==1){
							
							echo ($order_details_row->ad_id!='' ? "<a href='".base_url()."/index.php/artwork_springtube/view/".$order_details_row->ad_id."/".$order_details_row->version_no."' target='_blank'>".$order_details_row->ad_id."_R".$order_details_row->version_no."</a>" : '');

						}else{

							echo ($order_details_row->ad_id!='' ? "<a href='".base_url()."/index.php/artwork_new/view/".$order_details_row->ad_id."/".$order_details_row->version_no."' target='_blank'>".$order_details_row->ad_id."_R".$order_details_row->version_no."</a>" : '');

						}					

						?>
							
						</td>
					</tr>					 
					<tr>
						<td class="label">Order Quantity <span style="color: red;"><b>*</b></span> :</td>
						<td>
							<input type="text" name="order_qty" id="order_qty" value="<?php echo $this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);?>" readonly>
						</td>
					</tr>

					<tr>
						<td class="label">Jobcard Quantity <span style="color: red;"><b>*</b></span> :</td>
						<td>
							<input type="text" name="jobcard_qty" id="jobcard_qty" value="<?php echo $jobcard_qty;?>" readonly>
						</td>
					</tr>
					<tr>
						<td class="label">Supply Quantity <span style="color: red;"><b>*</b></span> :</td>
						<td>
							<input type="text" name="supply_qty" id="supply_qty" value="<?php echo $supply_qty;?>" readonly>
						</td>
					</tr>	
					</table>							
					<?php endforeach;?>			

				</td>							
			</tr>
		</table>
		<table>
			<tr>
				<td class="label">Order Close Reasons :</td>
				<td>
					<select class="ui dropdown" name="trans_closed_reason" id="trans_closed_reason" required="required" ><option value=''>--Select Reasons--</option>
					<?php if($order_close_reasons_master==FALSE){
							echo "<option value=''>--Setup Required--</option>";
							}
							else{
								foreach($order_close_reasons_master as $order_close_reasons_master_row){
									echo "<option value='".$order_close_reasons_master_row->id."'  ".set_select('trans_closed_reason',''.$order_close_reasons_master_row->id.'').">".$order_close_reasons_master_row->reasons."</option>";
								}
					}?>
						</select>
				</td>	
			</tr>							 
			<tr>
				<td class="label">Remarks <span style="color:red;">*</span> :</td>
				<td>
					<textarea name="trans_closed_remarks" id="trans_closed_remarks" cols="40" rows="3" value="<?php echo trim(set_value('trans_closed_remarks'));?>" maxlength="256" required><?php echo trim(set_value('trans_closed_remarks'));?></textarea>
				</td>
			</tr>
			<!-- <tr>
								<td class="label">Factory Approval:</td>
								<td><select name="approval_authority_factory" >
									<option value=''>--Select Authority--</option>
									<?php 
										foreach ($approval_authority_factory as $approval_authority_factory_row) {
											 
										echo "<option value='".$approval_authority_factory_row->employee_id."' $selected ".set_select('approval_authority_factory',$approval_authority_factory_row->employee_id).">".strtoupper($approval_authority_factory_row->username)."</option>";
										}
									?>
								</select>
								</td>
							</tr> -->
			

		</table>	

							
	</div>
		<?php if($order_row->trans_closed==0){?>
			<div class="form_design">
				<div class="ui buttons">
			  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
			  		<div class="or"></div>
			  		<button class="ui positive button">Close Transaction</button>
				</div>
			</div>


		<?php
		}
	endforeach;?>
	
</form>




				
				
				
			