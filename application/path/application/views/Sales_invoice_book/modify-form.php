

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" autocomplete="off" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
				
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner" >

						<tr>
							<?php  

							if(!empty($ar_invoice_master )){
								foreach($ar_invoice_master as $ar_invoice_master_row) :?>
							   
								<td class="label">Invoice No * :</td>
								     <td><input type="text" name="ar_invoice_no" value="<?php echo set_value('ar_invoice_no', $ar_invoice_master_row->ar_invoice_no)?>" readonly/>
								</td>						
							
						</tr>
						<tr>
							<td class="label"> Invoice Types  :</td>
							<td colspan="3">
								
							<?php foreach ($invoice_types_master_lang as $row):?>

									<input type="checkbox" name="inv_type[]" value="<?php echo $row->inv_type_id?>" <?php echo($row->inv_type_id==$ar_invoice_master_row->inv_type?"checked":""); ?>><?php echo $row->lang_inv_type;?>
									</br>
									
							<?php endforeach;?>	

							</td>
						</tr>	
					
					<tr>
							
							<td colspan="4">&nbsp;</td>
					</tr>
					<tr>
							
							<td colspan="4">&nbsp;</td>
					</tr>
						<tr>
							<td class="label">Invoice Status :</td>
							<td>
								<select name="cancel_invoice">
									<option value="">--Select Invoice Status--</option>
									<option value="0" <?php echo($ar_invoice_master_row->cancel_invoice=='0'?"selected":"");?>>Active</option>
									<option value="1" <?php echo($ar_invoice_master_row->cancel_invoice=='1'?"selected":"");?>>Cancel</option>
								</select>	
							</td>						
								
						</tr>

					<?php endforeach;
					
					} ?>		
								
					</table>			
								
				</td>										
			</tr>
		</table>
				
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  <div class="or"></div>
	  <button class="ui positive button" id="btnupload" >Update</button>


		</div>
	</div>
	<!--<input type="submit" value="upload" />-->
		
</form>