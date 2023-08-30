<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?> 
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
									<?php 
									
									if($account_periods_master==FALSE){
										echo "<tr><td>PLEASE SET THE FISCAL YEAR</td>";
									}else{
									foreach ($account_periods_master as $account_periods_master_row ):?>
									<tr>
										<td class="label"  width="25%">From Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="from_date" class="from_date" value="<?php echo set_value('from_date',$account_periods_master_row->fin_year_start);?>"/></td>
										<td class="label"  width="25%">To Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="to_date" class="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
									<?php endforeach;
										}?>
									<!--
									<tr>
										<td class="label">Customer Group :</td>
										<td colspan="3" ><select name="customer_category" id="customer_category" ><option value=''>--Select Category--</option>
										</select></td>
									</tr>-->
									<!--
									<tr>
										<td class="label">Customer   :</td>
										<td colspan="3" ><input type="text" name="customer" id="customer"  size="60" value="<?php echo set_value('customer');?>" /></td>
									</tr>
									-->

										<tr>
							<td class="label" width="25%">Convert</td>
							<td colspan="3"><select name="convert" class="convert">
								<option value="0">INR</option>
								<option value="1">Millions</option
							</select></td>
						</tr>
							
								
									<tr>
										<td>
											<div class="ui buttons">
										  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
										  		<div class="or"></div>
										  		<button class="ui positive button" id="search">Search</button>
											</div>
										</td>
									</tr>
					</table>
				</td>
				
																						
									
					
					</table>
					<!--
					<table class="form_table_inner">
						<tr>
							<td class="label" width="25%"></td>
							<td width="75%"><span id="hello"></span></td>
						</tr>
					</table>-->
				</td>
			</tr>
		</table>
					
	</div>
