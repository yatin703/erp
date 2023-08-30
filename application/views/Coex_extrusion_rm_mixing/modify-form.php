<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});	
		
		$("#jobcard_no").live('keyup',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/jobcard_no');?>",data: {jobcard_no : $("#jobcard_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#jobcard_order_details").html(html);
				} 
			});
		});

		$("#jobcard_no").live('keyup',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/jobcard_material_details');?>",data: {jobcard_no : $("#jobcard_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#jobcard_material_details").html(html);
				} 
			});
		});	

		

	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<?php foreach($coex_extrusion_rm_mixing as $coex_extrusion_rm_mixing_row):?>
		<table class="form_table_design">
			<tr>

				<td width="45%">
					<table class="form_table_inner">

						<tr>
							<td class="label"><b>Date</b><span style="color:red;">*</span> :</td>
							<td><input type="date" name="mixing_date"  size="10" value="<?php echo set_value('mixing_date',$coex_extrusion_rm_mixing_row->mixing_date);?>" required/>
								<input type='hidden' name='cerm_id' value='<?php echo $coex_extrusion_rm_mixing_row->cerm_id;?>'></td>
							
						</tr>

						<tr>
							<td class="label"><b>Shift</b><span style="color:red;">*</span> :</td>
							<td><select name="shift" id="shift" required><option value=''>--Shift--</option>
								<?php if($shift_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($shift_master as $shift_master_row){
											$selected=($shift_master_row->shift_id==$coex_extrusion_rm_mixing_row->shift_id ? 'selected' :'');
											echo "<option value='".$shift_master_row->shift_id."' $selected ".set_select('shift',''.$shift_master_row->shift_id.'').">".$shift_master_row->shift_name."</option>";
										}
								}?></select></td>
						</tr> 

						<tr>
							<td class="label"><b>Machine</b> <span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine" required><option value=''>--Machine--</option>
							<?php if($coex_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($coex_machine_master as $machine_row){
										$selected=($machine_row->machine_id==$coex_extrusion_rm_mixing_row->machine_id ? 'selected' :'');
										echo "<option value='".$machine_row->machine_id."' $selected ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
							
						</tr>

						<tr>
							<td class="label">Operator <span style="color:red;">*</span> :</td>
							<td><input type="text" name="operator" size="10" value="<?php echo set_value('operator',$coex_extrusion_rm_mixing_row->operator);?>" required>
						</tr>

						
						<tr>
							<td class="label"><b>Job Card</b> <span style="color:red;">*</span> :</td>
							<td><input type="text" name="jobcard_no" id="jobcard_no"  size="15" value="<?php echo set_value('jobcard_no',$coex_extrusion_rm_mixing_row->jobcard_no);?>" required/>
							</td>
						</tr>

						<tr>
							<td class="label"><b>Order No</b> <span style="color:red;">*</span> :</td>
							<td><span id="jobcard_order_details"><select name="order_no" id="order_no" required><option value='<?php echo $coex_extrusion_rm_mixing_row->order_no;?>'><?php echo $coex_extrusion_rm_mixing_row->order_no;?></option></select>&nbsp;&nbsp;&nbsp;<b>Product No </b> <span style="color:red;">*</span> : &nbsp;&nbsp;&nbsp;<select name="article_no" id="article_no" required><option value='<?php echo $coex_extrusion_rm_mixing_row->article_no;?>'><?php echo $coex_extrusion_rm_mixing_row->article_no;?></option></select></span></td>
						</tr>
						
						

					</table>
			
				</td>
				
				<td>
					<table class="form_table_inner">
					

					<tr>
						<td class="label">Single Sleeve Weight <i>(Grams)</i><span style="color:red;">*</span> :</td>
						<td><input type="text" name="sleeve_weight" id="sleeve_weight"  size="15" value="<?php echo set_value('sleeve_weight',$this->common_model->read_number($coex_extrusion_rm_mixing_row->sleeve_weight,$this->session->userdata['logged_in']['company_id']));?>" required/></td>
					</tr>

					<tr>
						<td class="label">Initial Counter<span style="color:red;">*</span> :</td>
						<td><input type="text" name="initial_counter_reading" id="initial_counter_reading"  size="15" value="<?php echo set_value('initial_counter_reading',$this->common_model->read_number($coex_extrusion_rm_mixing_row->initial_counter_reading,$this->session->userdata['logged_in']['company_id']));?>" required/>
							Final Counter <span style="color:red;">*</span> : <input type="text" name="final_counter_reading" id="final_counter_reading"  size="15" value="<?php echo set_value('final_counter_reading',$this->common_model->read_number($coex_extrusion_rm_mixing_row->final_counter_reading,$this->session->userdata['logged_in']['company_id']));?>" required/></td>
					</tr>

					<tr>
						<td class="label">Number of Sleeves<span style="color:red;">*</span> :</td>
						<td><input type="text" name="number_of_sleeves" id="number_of_sleeves"  size="15" value="<?php echo set_value('number_of_sleeves',$this->common_model->read_number($coex_extrusion_rm_mixing_row->number_of_sleeves,$this->session->userdata['logged_in']['company_id']));?>" required/>
							Total Sleeves Weight <i>(KG)</i><span style="color:red;">*</span> : <input type="text" name="sleeves_weight" id="sleeves_weight"  size="15" value="<?php echo set_value('sleeves_weight');?>" required/></td>
					</tr>

					<tr>
						<td class="label">Scrap Weight <i>(KG)</i><span style="color:red;">*</span> :</td>
						<td><input type="text" name="scrap_weight" id="number_of_sleeves"  size="15" value="<?php echo set_value('scrap_weight',$this->common_model->read_number($coex_extrusion_rm_mixing_row->scrap_weight,$this->session->userdata['logged_in']['company_id']));?>" required/>
							Lumps Weight <i>(KG)</i><span style="color:red;">*</span> : <input type="text" name="lumps_weight" size="15" value="<?php echo set_value('lumps_weight',$this->common_model->read_number($coex_extrusion_rm_mixing_row->lumps_weight,$this->session->userdata['logged_in']['company_id']));?>" required/></td>
					</tr>

					<tr>
						<td class="label">Output Weight <i>(KG)</i><span style="color:red;">*</span> :</td>
						<td><input type="text" name="output_weight"  size="15" value="<?php echo set_value('output_weight',$this->common_model->read_number($coex_extrusion_rm_mixing_row->output_weight,$this->session->userdata['logged_in']['company_id']));?>" required/></td>
					</tr>
					
					<tr>
						<td class="label">Prepared By<span style="color:red;">*</span> :</td>
						<td><input type="text" name="prepared_by"  size="15" value="<?php echo set_value('prepared_by',$coex_extrusion_rm_mixing_row->prepared_by);?>" required/>
							Checked By<span style="color:red;">*</span> : <input type="text" name="checked_by" size="15" value="<?php echo set_value('checked_by',$coex_extrusion_rm_mixing_row->checked_by);?>" required/></td>
					</tr>
					
					</table>
				</td>
							
			</tr>

		</table>
					
	</div>
	
	<span id="jobcard_material_details">

		<div class="middle_form_design">
		<div class="middle_form_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>SR NO</th>
					<th>RM</th>
					<th>RM Code</th>
					<th>MIXING QTY</th>
					<th>BATCH NO</th>
				</tr>
				<?php if($coex_extrusion_rm_mixing_details==FALSE){

				}else{
					$total_mixing_qty=0;
					$i=1;
					foreach($coex_extrusion_rm_mixing_details as $coex_extrusion_rm_mixing_details){
						echo "<tr>
								<td><input type='hidden' name='sr_no[]' value='$coex_extrusion_rm_mixing_details->sr_no'>".$coex_extrusion_rm_mixing_details->sr_no."</td>
								<td>".$this->common_model->get_article_name($coex_extrusion_rm_mixing_details->material_code,$this->session->userdata['logged_in']['company_id'])."</td>
								<td><input type='hidden' name='article_no_$i' value='$coex_extrusion_rm_mixing_details->material_code'>".$coex_extrusion_rm_mixing_details->material_code."</td>
								
								<td><input type='text' name='mixing_qty_$i' class='mixing_qty' value='".set_value('mixing_qty_$i',$this->common_model->read_number($coex_extrusion_rm_mixing_details->qty_mixed,$this->session->userdata['logged_in']['company_id']))."'> Kg</td>
								<td><input type='text' name='batch_no_$i' value='".set_value('batch_no_$i',$coex_extrusion_rm_mixing_details->batch_no)."'></td>
							 </tr>";
							 $total_mixing_qty+=$coex_extrusion_rm_mixing_details->qty_mixed;
						$i++;
					}
				}?>
				<tr>
					<td colspan='3'>TOTAL</td><td><?php echo $this->common_model->read_number($total_mixing_qty,$this->session->userdata['logged_in']['company_id']);?> Kg</td><td><span class='total_mixing_qty'></span><td></td></td>
				</tr>
			</table>
		</div>
	</div>
			
	</span>

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Update</button>
		</div>
	</div>

<?php endforeach;?>
	
</form>




				
				
				
			