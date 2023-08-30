<div class="form_design">
	<form name="" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST">
	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		
			<table class="form_table_design" >
				<tr>
					<td>
						<table class="form_table_inner" >
							<tr>
								<td class="label">Customer <span style="color:red;">*</span> :</td>
								<td><select name="customer"><option value=''>--Select Customer--</option>
								<?php 
									if($customer==FALSE){
										echo "<option value=''>--Setup Required--</option>";
									}else{
										foreach($customer as $customer_row){
											echo "<option value='$customer_row->adr_company_id'  ".set_select('customer',$customer_row->adr_company_id).">$customer_row->adr_company_id - $customer_row->name1</option>";
										}
									}
								?>
								</select></td>
							</tr>

							<tr>
								<td class="label">Relate To <span style="color:red;">*</span> :</td>
								<td><select name="relate"><option value=''>--Select Relate--</option>
								<?php 
									if($relate==FALSE){
										echo "<option value=''>--Setup Required--</option>";
									}else{
										foreach($relate as $relate_row){
											echo "<option value='$relate_row->adr_company_id'  ".set_select('relate',$relate_row->adr_company_id).">$relate_row->adr_company_id - $relate_row->name1</option>";
										}
									}
								?>
								</select></td>
							</tr>

							<tr>
										<td class="label">Property <span style="color:red;">*</span> :</td>
										<td><select name="property"><option value=''>--Select Property--</option>
										<?php if($property==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($property as $property_row){
													echo "<option value='".$property_row->property_id."'  ".set_select('property',''.$property_row->property_id.'').">".$property_row->lang_property_name."</option>";
												}
										}?>
										</select></td>
							</tr>

						</table>
					</td>
				</tr>
			</table>
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</form>
</div>
				
				