


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/outsource_inspection_save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">									
						<tr>
							<td class="label">Production Date <span style="color:red;">*</span> :</td>
							<td>

								<input type="date" name="production_date"   value="<?php echo set_value('production_date');?>" required/></td>
							<td class="label">Shift <span style="color:red;">*</span> :</td>
							<td><select name="shift" id="shift" required><option value=''>--Select Shift--</option>
							<?php if($springtube_shift_master==FALSE){
									echo "<option value=''>--Setup Required--</option>";
								}
								else{
									foreach($springtube_shift_master as $shift_row){
										echo "<option value='".$shift_row->shift_id."'  ".set_select('shift',''.$shift_row->shift_id.'').">".$shift_row->shift_name."</option>";
									}
							}?>
							</select></td>
						</tr>
						<tr>
							<td class="label">Process Name <span style="color:red;">*</span> :</td>
							<td ><select name="process" id="process" disabled><option value=''>--Select Process-</option>
							<?php if($springtube_process_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_process_master as $process_row){
										$selected=($process_row->process_id=='15'?'selected':'');
										echo "<option value='".$process_row->process_id."'  ".set_select('process',''.$process_row->process_id.'').$selected.">".$process_row->process_name."</option>";
									}
							}?>
							</select></td>
							<td class="label">Machine <span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine" ><option value=''>----Select Machine-----</option>
							<?php if($springtube_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_machine_master as $machine_row){
										$selected=($machine_row->machine_id==4?'selected':'');
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').$selected.">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
						</tr>

					</table>
			
				</td>
				<td>
					<table>
						<tr>
							<td class="label">Shift Issues :</td>
							<td><select name="shift_issue[]" id="shift_issue[]" multiple size="6"><option value=''>--Select shift issues--</option>
							<?php if($springtube_shift_issues_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_shift_issues_master as $shift_issues_master_row){
										
										echo "<option value='".$shift_issues_master_row->shift_issue."'  ".set_select('shift_issue[]',$shift_issues_master_row->shift_issue).">".$shift_issues_master_row->shift_issue."</option>";
									}
							}?>
							</select></td>
						</tr>

						<tr>
							<td class="label">Remarks :</td>
							<td>
								<textarea name="remarks" id="remarks" cols="40" rows="3" value="<?php echo trim(set_value('remarks'));?>" maxlength="500">
								<?php echo trim(set_value('remarks'));?>	
								</textarea>
							</td>
						</tr>
					</table>
				</td>							
			</tr>
		</table>					
	</div>

	<div class="middle_form_design">
		<div class="middle_form_inner_design">
		
			<table class="middle_form_table_design" id="table_article">
				<tr>
					<th>Order No</th>
					<th>Total Printed Output (Qty)</th>									
					<!-- <th>Input Taken For Inspection (Qty)</th> -->
					<th>Inspected Output (Qty)</th>
					<th>Side Trim Waste (Kg) </th>					
					<!-- <th>Inspected Output (Meters)</th> -->
					<th>Is Job Finished? </th>
					
					<!-- <th>Total Waste (Qty)</th>	 -->				
				</tr>

			<?php 
			$so_no='';
            foreach($springtube_outsource_for_printing as $rows){
                    $so_no=$rows->order_no;
                    $length=$rows->sleeve_length+2.5;
                    $qty=($rows->received_qty_in_meter*1000)/$length;
                    $qty=$qty*2;

                }
                //echo $so_no;
			 ?>


					    <tr>
							
							<td><input type="hidden" name="sofp_id" value="<?php echo $rows->sofp_id;?>">
							<input type="text" name="so_no"  id="so_no" value="<?php echo set_value('so_no
tex',$so_no);?>" maxlength="50" size="20" readonly/>
							</td>
							<td>
							<input type="text" name="total_printed_output"  id="total_printed_output" value="<?php echo set_value('total_printed_output
tex',round($qty));?>" maxlength="50" size="20" readonly/>
							</td>
							<td>
							<input type="text" name="inspected_output"  id="inspected_output" value="<?php echo set_value('total_printed_output
inspected_output');?>" maxlength="50" size="20" />
							</td>
							<td>
							<input type="text" name="side_trim_waste"  id="side_trim_waste" value="<?php echo set_value('total_printed_output
side_trim_waste');?>" maxlength="50" size="20"/>
							</td>
							<td>
							<input type="checkbox" name="inspection_done" value="1" />
							</td>	
												
						</tr>
			
					
			

			</table>
		</div>
	</div>		


	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to save record!');">Save</button>
		</div>
	</div>

	

	
</form>




				
				
				
			