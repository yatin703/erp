<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax/so_no');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});


	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<tr>
							<td class="label">From Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="from_date" id="from_date" size="30" value="<?php echo set_value('from_date');?>" ></td>
							<td class="label">To Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="to_date" id="to_date" size="30" value="<?php echo set_value('to_date');?>" ></td>
						</tr>
						<tr>
							<td class="label">Order No. * :</td>
							<td><input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no');?>" placeholder="Order No"/></td>
							<td class="label">Jobcard No. * :</td>
							<td><input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no');?>" placeholder="Jobcard No"/></td>
							
						</tr>
						<tr>
							<td class="label">PSM/PSP No.  * :</td>
							<td colspan="3"><input type="text" name="article_no" id="article_no"  size="58" value="<?php echo set_value('article_no');?>" placeholder="PSM/PSP No"/>
							</td>
						</tr>
						<tr>
							<td class="label">Artwork  * :</td>
							<td><input type="text" name="artwork_no" id="artwork_no"  size="20" value="<?php echo set_value('artwork_no');?>" placeholder="Artwork"/></td>
							<td class="label">Version  * :</td>
							<td><input type="text" name="version_no" id="version_no"  size="20" value="<?php echo set_value('version_no');?>" placeholder="Version"/></td>
						</tr>
						


					</table>			
								
				</td>
				<td width="50%">
					<table class="form_table_inner">									
						<tr>
							<td class="label">Machine  * :</td>
							<td><select name="machine_id" id="machine_id">					
								<option value="">------Please Select------</option>
								<?php if($graphics_machine_master==FALSE){
									echo'<option>--Setup Required--</option>';
								}
								else{
									foreach ($graphics_machine_master as $row) {
										echo'<option value="'.$row->machine_id.'" '.set_select('machine_id',$row->machine_id).'>'.$row->machine_name.'</option>';
									}
								}?>
								</select>
							</td>
							<td class="label">Shift  * :</td>
							<td><select name="shift_id" id="shift_id">					
										<option value="">------Please Select------</option>
										<?php if($graphics_shift_master==FALSE){
											echo'<option>--Setup Required--</option>';
										}
										else{
											foreach ($graphics_shift_master as $row) {
												echo'<option value="'.$row->shift_id.'" '.set_select('shift_id',$row->shift_id).'>'.$row->shift_name.'</option>';
											}
										}?>
										</select>
							</td>
						</tr>
						<tr>
							
							<td class="label">Reason  * :</td>
							<td><select name="reason_id" id="reason_id">					
								<option value="">--Please Select--</option>
								<?php if($graphics_plate_making_reasons==FALSE){
									echo'<option>--Setup Required--</option>';
								}
								else{
									foreach ($graphics_plate_making_reasons as $row) {
										echo'<option value="'.$row->reason_id.'" '.set_select('reason_id',$row->reason_id).'>'.$row->reason.'</option>';
									}
								}?>
								</select>
							</td>
							<td class="label">Plate Maker  * :</td>
						<td><select name="operator_id" id="operator_id">					
								<option value="">------Please Select------</option>
								<?php if($graphics_operator_master==FALSE){
									echo'<option>--Setup Required--</option>';
								}
								else{
									foreach ($graphics_operator_master as $row) {
										echo'<option value="'.$row->operator_id.'" '.set_select('operator_id',$row->operator_id).'>'.strtoupper($row->operator_name).'</option>';
									}
								}?>
							</select>
						</td>
						</tr>
						<tr><td class="label">Comment  * :</td>
							<td ><textarea name="comment" value="<?php echo set_value('comment');?>"></textarea></td>
						
						
						</tr>
											
					</table>	
				</td>							
			</tr>
		</table>

		<div class="middle_form_design">
			
		
</div>
<div class="middle_form_design">

	
		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" >Search</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

</div>
		
</form>
				
				
				
				
				
			