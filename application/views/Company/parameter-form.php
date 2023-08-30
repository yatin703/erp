
<div class="form_design">
	<form name="" action="<?php echo base_url('index.php/'.$this->router->fetch_class() .'/parameter_update');?>" method="POST" enctype="multipart/form-data">
	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
	<?php foreach($company_parameter as $row):?>
		<table class="form_table_design">
		<tr>
			<td>
				<table class="form_table_inner" >
									<tr>
										<td class="label">Logo <span style="color:red;">*</span> :</td>
										<td><input type="file" name="logo" value="<?php echo set_value('logo',$row->logo);?>"/>
										<img src="<?php echo base_url('uploads/'.$row->company_id.'/'.$row->logo.'');?>" >
										<input type="hidden" name="company_id" value="<?php echo $row->company_id;?>" /></td>
									</tr>

									<tr>
										<td class="label">Payment Clearance Days <span style="color:red;">*</span> :</td>
										<td><input type="text" name="payment_clearance_days" value="<?php echo set_value('payment_clearance_days',$row->payment_clearance_days);?>" /></td>
									</tr>

									<tr>
										<td class="label">Discount Clearance Days <span style="color:red;">*</span> :</td>
										<td><input type="text" name="discount_clearance_days" value="<?php echo set_value('discount_clearance_days',$row->discount_clearance_days);?>" /></td>
									</tr>

									<tr>
										<td class="label">Margin <span style="color:red;">*</span> :</td>
										<td><input type="text" name="margin" value="<?php echo set_value('margin',$row->margin);?>" /></td>
									</tr>

									<tr>
										<td class="label">Decimal Seperator <span style="color:red;">*</span> :</td>
										<td><input type="text" name="decimal_seperator" value="<?php echo set_value('decimal_seperator',$row->decimal_seperator);?>" /></td>
									</tr>

									<tr>
										<td class="label">Digit Seperator <span style="color:red;">*</span> :</td>
										<td><input type="text" name="digit_seperator" value="<?php echo set_value('digit_seperator',$row->digit_seperator);?>" /></td>
									</tr>

									<tr>
										<td class="label">Read Format <span style="color:red;">*</span> :</td>
										<td><input type="text" name="read_format" value="<?php echo set_value('read_format',$row->read_format);?>" /></td>
									</tr>

									<tr>
										<td class="label">Decimal Places <span style="color:red;">*</span> :</td>
										<td><input type="text" name="decimal_places" value="<?php echo set_value('decimal_places',$row->decimal_places);?>" /></td>
									</tr>

				</table>
				</td>
			</tr>
		</table>
			<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/company');?>">Back</a>
	<?php endforeach;?>
	</form>
</div>
				
				
				
				
				
			