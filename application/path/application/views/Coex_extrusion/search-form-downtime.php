<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/downtime_search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<tr>
							<td class="label"><b>From Date</b><span style="color:red;">*</span> :</td>
							<td><input type="date" name="from_date" size="10" value="<?php echo set_value('from_date',date('Y-m-d'));?>" required/>
							<b>To Date</b><span style="color:red;">*</span> :
							<input type="date" name="to_date" size="10" value="<?php echo set_value('to_date',date('Y-m-d'));?>" required/></td>
						</tr>
					</table>
				</td>
				<td>
					<table class="form_table_inner">
						<tr>
							<td class="label"><b>Machine</b><span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine"><option value=''>--Machine--</option>
							<?php if($coex_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($coex_machine_master as $machine_row){
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div class="form_design">
		<button class="submit" name="submit">Search</button> <a href="<?php echo base_url('index.php/coex_extrusion');?>">Cancel</a>
	</div>
</form>