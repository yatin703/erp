

<?php foreach ($order as $order_row):?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_job_card');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									<tr>
										<td class="label">Order No * :</td>
										<td><input type="text" name="order_no" value="<?php echo $order_row->order_no;?>" readonly>
										</td>
									</tr>

									<tr>
										<td class="label">Order Date * :</td>
										<td><input type="text" name="order_date" value="<?php echo $order_row->order_date;?>" disabled>
										</td>
									</tr>

									<tr>
										<td class="label">Bill To * :</td>
										<td><select name="adr_company_id" disabled>
											<?php 
												foreach($customer as $customer_row){
													$selected=($customer_row->adr_company_id==$order_row->customer_no ? 'selected' :'');
            echo "<option value='".$customer_row->name1."//".$customer_row->adr_company_id."//".$customer_row->lang_property_name."' $selected ".set_select('adr_company_id',''.$customer_row->adr_company_id.'').">".$customer_row->name1."//".$customer_row->adr_company_id."//".$customer_row->lang_property_name."</option>";
												}
											?>
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
          } ?> 
										</select></td>
									</tr>

									<tr>
										<td class="label">Po No * :</td>
										<td><input type="text" name="po_no" value="<?php echo set_value('po_no',$order_row->cust_order_no);?>" disabled/></td>
									</tr>
									
									<tr>
										<td class="label">Po Date * :</td>
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
											<td class="label">Approval Authority :</td>
											<td><select name="approval_authority" disabled>
												<option value=''>--Select Authority--</option>
												<?php 
													foreach ($approval_authority as $approval_authority_row) {
														$selected=($approval_authority_row->employee_id==$order_row->approved_by ? 'selected' : '' );
													echo "<option value='".$approval_authority_row->employee_id."' $selected ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
													}
												?>
											</select></td>
									</tr>


				</table>
			</td>
			<td>
				<table class="form_table_inner">
						<?php foreach($order_details as $order_details_row):?>
							<tr>
										<td class="label">Product Code * :</td>
										<td><input type="text" name="article_no" value="<?php echo $order_details_row->article_no;?>" readonly>
										<input type="hidden" name="ord_pos_no" value="<?php echo $order_details_row->ord_pos_no;?>"></td>
							</tr>
							<tr>
										<td class="label">Product Name * :</td>
										<td><input type="text" name="article_name" size="50" value="<?php echo $order_details_row->description;?>" disabled></td>
								</tr>

							<tr>
										<td class="label">Spec No * :</td>
										<td><input type="text" name="spec_id" value="<?php  echo ($order_details_row->spec_id!='' ? $order_details_row->spec_id."_R".$order_details_row->spec_version_no : '');?>" readonly>
										<input type="hidden" name="spec_no" value="<?php  echo $order_details_row->spec_id;?>">
										<input type="hidden" name="spec_version_no" value="<?php  echo $order_details_row->spec_version_no;?>">
										 <?php  echo ($order_details_row->spec_id!='' ? "<a href='".base_url()."/index.php/specification/view/".$order_details_row->spec_id."/".$order_details_row->spec_version_no."' target='_blank'>".$order_details_row->spec_id."_R".$order_details_row->spec_version_no."</a>" : '');?></td>
							</tr>

							<tr>
										<td class="label">Artwork No * :</td>
										<td><input type="text" name="ad_id" value="<?php echo ($order_details_row->ad_id!='' ? $order_details_row->ad_id."_R".$order_details_row->version_no : '');?>" readonly> 
										<?php  echo ($order_details_row->ad_id!='' ? "<a href='".base_url()."/index.php/artwork/view/".$order_details_row->ad_id."/".$order_details_row->version_no."' target='_blank'>".$order_details_row->ad_id."_R".$order_details_row->version_no."</a>" : '');?></td>
							</tr>


							<tr>
										<td class="label">Order Quantity * :</td>
										<td><input type="text" name="order_qty" value="<?php echo $this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);?>" readonly></td>
							</tr>
							<?php
								$dia='';	
								$length='';
								$print_type='';

								$specs['spec_id']=$order_details_row->spec_id;
								$specs['spec_version_no']=$order_details_row->spec_version_no;

								$specs_result=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
								if($specs_result){
										foreach($specs_result as $specs_row){
											$dia=$specs_row->SLEEVE_DIA;
											$length=$specs_row->SLEEVE_LENGTH;
											$print_type=$specs_row->SLEEVE_PRINT_TYPE;

										}
								}
							?>
							<tr>
										<td class="label">Dia * :</td>
										<td><input type="text" name="dia" value="<?php echo $dia;?>" disabled></td>
							</tr>

							<tr>
										<td class="label">Length * :</td>
										<td><input type="text" name="length" value="<?php echo $length;?>" disabled></td>
							</tr>

							<tr>
										<td class="label">Print Type * :</td>
										<td><input type="text" name="print_type" value="<?php echo $print_type;?>" disabled></td>
							</tr>

							<tr>
										<td class="label">Job Card Quantity * :</td>
										<td><input type="text" name="job_card_quantity" value="<?php echo set_value('job_card_quantity');?>"></td>
							</tr>

							<?php endforeach;?>
				</table>

			</td>

		</tr>
	</table>
	</div>


					
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Create Job Card</button>
		</div>
	</div>
		
</form>
<?php endforeach;?>
				
				
				
				
				
			