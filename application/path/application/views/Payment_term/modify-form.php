<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									<?php foreach($payment_term as $row):?>
									<tr>
										<td class="label">Net Days <span style="color:red;">*</span>  :</td>
										<td><input type="text" name="net_days" maxlength="3" size="3" value="<?php echo set_value('net_days',$row->net_days);?>" />
										<input type="hidden" name="id" value="<?php echo set_value('id',$row->id);?>" /></td>
									</tr>

									<tr>
										<td class="label">Payment Term <span style="color:red;">*</span> :</td>
										<td><input type="text" name="payment_term" maxlength="50" size="50" value="<?php echo set_value('payment_term',$row->lang_description);?>" /></td>
									</tr>

									<?php endforeach;?>	
						</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
</form>
