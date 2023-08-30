
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>

<script>

	$(document).ready(function(){

		$("#release_qty").bind('keyup blur',function(){
			//alert();

			if($("#release_qty").val()!=''){
				
				var total_rfd_qty=Number($("#total_rfd_qty").val());
				var release_qty=Number($("#release_qty").val());

				if(release_qty>total_rfd_qty){

					alert('Release Qty less than or equal to Total RFD Qty');
					$("#release_qty").val('');
					$("#pending_rfd_qty").val('');
					$("#release_qty").focus();
				}else{
					var remaining_rfd=total_rfd_qty-release_qty;
					$("#pending_rfd_qty").val(remaining_rfd);
				 
				}
			}else{

				$("#pending_rfd_qty").val('');

			}
			
		});

	});
</script>	


<?php 
$order_flag=0;
foreach ($order as $order_row):
	$order_flag=$order_row->order_flag; ?>



<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_rfd_consume');?>" method="POST" >
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
										<td>
											<input type="hidden" name="order_flag" value="<?php echo $order_row->order_flag;?>">
											<input type="text" name="order_no" id="order_no"value="<?php echo $order_row->order_no;?>" readonly>
										</td>
									</tr>

									<tr>
										<td class="label">Order Date * :</td>
										<td><input type="text" name="order_date" value="<?php echo $order_row->order_date;?>" disabled>
										</td>
									</tr>

									<tr>
										<td class="label">Bill To * :</td>
										<td>
											<input type="hidden" name="customer" value="<?php echo $order_row->customer_no;?>">
											<select name="adr_company_id" disabled>
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
										<td><input type="text" name="article_no" id="article_no" value="<?php echo $order_details_row->article_no;?>" readonly>
										<input type="hidden" name="ord_pos_no" value="<?php echo $order_details_row->ord_pos_no;?>"></td>
							</tr>
							<tr>
										<td class="label">Product Name * :</td>
										<td><input type="text" name="article_name" size="50" value="<?php echo $order_details_row->description;?>" disabled></td>
							</tr>

				 
							<?php 
								$total_rfd_qty=0;								 
								$i=0;
								
								if($springtube_rfd_master==TRUE){

									foreach ($springtube_rfd_master as  $springtube_rfd_master_row) {
										$total_rfd_qty+=$springtube_rfd_master_row->rfd_qty;
										$i++;
									}
								}								
							?>						 
							<tr>
								<td class="label">Total RFD Qty <span style="color:red">*</span> :</td>
								<td><input type="text" name="total_rfd_qty" id="total_rfd_qty" value="<?php echo set_value('total_rfd_qty',$total_rfd_qty);?>" readonly></td>
							</tr>
							<tr>
								<td class="label">Invoice Qty<span style="color:red">*</span> :</td>
								<td><input type="number" name="release_qty" id="release_qty" value="<?php echo set_value('release_qty');?>" size="10" min="1" steps="1" max="<?php echo $total_rfd_qty;?>"></td>
							</tr>
							<tr>
								<td class="label">Pending RFD Qty<span style="color:red">*</span> :</td>
								<td><input type="text" name="pending_rfd_qty" id="pending_rfd_qty" value="<?php echo set_value('pending_rfd_qty');?>" readonly ></td>
							</tr>						

							
						<?php endforeach;?>
				</table>

			</td>

		</tr>
		<tr><td colspan="2"><div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Consume</button>
		</div></td></tr>
	</table>
	</div>				
	
</form>
<?php endforeach;?>
				
				
				
				
				
			