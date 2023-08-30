<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>


<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();	
		
		$("#machine").live('change',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/machine_start');?>",data: {extrusion_date : $("#extrusion_date").val(),shift:$("#shift").val(),machine:$("#machine").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#machine_start_load_details").html(html);
				} 
			});

		});


		$("#machine_start").live('click',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			if($("#coex_extrusion_machine_start_reasons").val()!=""){
				$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/machine_start_entry');?>",data: {machine:$("#machine").val(),coex_extrusion_machine_start_reasons:$("#coex_extrusion_machine_start_reasons").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#machine_start_load_details").html(html);
				} 
				});
			}else{
				alert('Select Machine Start Reason');
				$("#loading").hide();$("#cover").hide();
			}
		});

		$("#job_card_no_1").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});

		var counter=0;

		var x = document.getElementsByName("sr_no[]");

		var counter=x.length+1;
		$("#add").live('click',function () {

			var newtr = $(document.createElement('tr')).attr("id", 'tr_'+counter);
			newtr.html('<td><input type="hidden" name="sr_no[]" value="'+counter+'"/>'+counter+'</td><td><input type="text" name="job_card_no_'+counter+'" id="job_card_no_'+counter+'" value="<?php echo set_value('job_card_no_"+counter+"');?>"  placeholder="JOBCARD"/></td><td><input type="text" name="rm_mixing_'+counter+'" id="rm_mixing_'+counter+'" value="<?php echo set_value('rm_mixing_"+counter+"');?>" maxlength="15" size="10"/> Kg</td><td><input type="text" name="ok_qty_'+counter+'" id="ok_qty_'+counter+'" value="<?php echo set_value('ok_qty_"+counter+"');?>" maxlength="15" size="10"/> No</td><td><input type="text" name="scrap_weight_'+counter+'" id="scrap_weight_'+counter+'" value="<?php echo set_value('scrap_weight_"+counter+"');?>" maxlength="15" size="10"/> Kg</td><td><input type="text" name="cutting_speed_'+counter+'" id="cutting_speed_'+counter+'" value="<?php echo set_value('cutting_speed_"+counter+"');?>" maxlength="15" size="10"/></td>');
			var lastcounter=counter-1;
			newtr.insertAfter("#tr_"+lastcounter);
			$("#job_card_no_"+counter).autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});
					
			counter++;
		});

		$("#remove").click(function(){
			if(counter==2){ alert("No more textbox to remove"); return false;}
			counter--;
			$("#tr_" + counter).remove();
		});

		$("#add").click(function(){
			if(counter>6){ alert("No more textbox"); return false;}
			
			
		});

	});//Jquery closed

</script>
<style type="text/css">
	table.record_table_design_without_fixed {
    margin-bottom: 10px;
    width: 60%;
    border-collapse: collapse;
}
table.form_table_design {
    border-collapse: collapse;
    width: 60%;
}
table.form_table_inner{
	width: 100%;
}
</style>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
                <td>
					<table class="form_table_inner">
						<tr>
							<td colsapn="2" class="label"><b>Date</b><span style="color:red;">*</span> :</td>
							<td colsapn="2"><input type="date" name="extrusion_date"  id="extrusion_date" size="10" value="<?php echo set_value('extrusion_date',date('Y-m-d'));?>" required/ style="width: 100%;"></td>
							
							<td class="label"><b>Shift</b><span style="color:red;">*</span> :</td>
							<td><select name="shift" id="shift" required style="width: 100%;">
								<option value=''>--Shift--</option>
								<?php if($shift_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($shift_master as $shift_master_row){

											echo "<option value='".$shift_master_row->shift_id."'  ".set_select('shift',''.$shift_master_row->shift_id.'').">".$shift_master_row->shift_name."</option>";
										}
								}?></select>
							</td>
						</tr>
						<tr>
							<td colsapn="2" class="label"><b>Machine</b> <span style="color:red;">*</span> :</td>
							<td colsapn="2">
								<select name="machine" id="machine" required style="width: 100%;">
									<option value=''>--Machine--</option>
								<?php if($coex_machine_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($coex_machine_master as $machine_row){
											echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
										}
								}?>
								</select>
						    </td>

							<td colsapn="2" class="label"><b>Operator</b><span style="color:red;">*</span> :</td>
							<td colsapn="2"><input type="text" name="operator" size="20" value="<?php echo set_value('operator');?>" required style="width: 100%;"></td>							
						</tr>
					</table>			
				</td>							
			</tr>
		</table>					
	</div>

<br/>
			<br/>
	<div class="middle_form_design" style="min-height: 20px;">
		<div class="middle_form_inner_design">
			<div class="ui buttons">
				<input type="button" value="Remove" id="remove" class="ui button">
			<div class="or"></div>
				<input type="button" value="Add" id="add" class="ui positive button">
			</div>
			<br/>
			<br/>
			<table class="record_table_design_without_fixed" style="font-size:12px;">
			<thead>
			   <tr>
			    	<th>SR NO</th>
			    	<th>JOB CARD</th>
			    	<th>RM MIXED FOR JOB</th>
			    	<th>PRODUCTION QTY</th>
			    	<th>SCRAP</th>
			    	<th>CUTTING SPEED</th>
			  </tr>
			</thead>

			<tbody>
				<?php if($this->input->post('sr_no')){
						for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){?>
							<script>
							$(document).ready(function(){
							$("#job_card_no_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});
							});
						</script>
						<tr id="tr_<?php echo $i;?>">
							<td><input type="hidden" name="sr_no[]" value="<?php echo $i;?>"/><?php echo $i;?></td>
							<td><input type="text" name="job_card_no_<?php echo $i;?>" id="job_card_no_<?php echo $i;?>" value="<?php echo set_value('job_card_no_'.$i.'');?>" placeholder="JOBCARD"/></td>
							<td><input type="text" name="rm_mixing_<?php echo $i;?>"  id="rm_mixing_<?php echo $i;?>" class="rm_mixing" value="<?php echo set_value('rm_mixing_'.$i.'');?>" maxlength="15" size="10"/> Kg</td>
							<td><input type="text" name="ok_qty_<?php echo $i;?>"  id="ok_qty_<?php echo $i;?>" class="ok_qty" value="<?php echo set_value('ok_qty_'.$i.'');?>" maxlength="15" size="10"/> No</td>
							<td><input type="text" name="scrap_weight_<?php echo $i;?>"  id="scrap_weight_<?php echo $i;?>" class="scrap_weight" value="<?php echo set_value('scrap_weight_'.$i.'');?>" maxlength="15" size="10"/> Kg</td>
							<td><input type="text" name="cutting_speed_<?php echo $i;?>"  id="cutting_speed_<?php echo $i;?>" class="cutting_spee" value="<?php echo set_value('cutting_speed_'.$i.'');?>" maxlength="15" size="10"/></td>
						</tr>

					<?php }
					}else{?>
						<tr id="tr_1">
							<td><input type="hidden" name="sr_no[]" value="1"/>1</td>
							<td><input type="text" name="job_card_no_1" id="job_card_no_1" value="<?php echo set_value('job_card_no_1');?>" placeholder="JOBCARD"/></td>
							<td><input type="text" name="rm_mixing_1"  id="rm_mixing_1" class="rm_mixing" value="<?php echo set_value('rm_mixing_1');?>" maxlength="15" size="10"/> Kg</td>
							<td><input type="text" name="ok_qty_1"  id="ok_qty_1" class="ok_qty" value="<?php echo set_value('ok_qty_1');?>" maxlength="15" size="10"/> No</td>
							<td><input type="text" name="scrap_weight_1"  id="scrap_weight_1" class="scrap_weight" value="<?php echo set_value('scrap_weight_1');?>" maxlength="15" size="10"/> Kg</td>
							<td><input type="text" name="cutting_speed_1"  id="cutting_speed_1" class="cutting_speed" value="<?php echo set_value('cutting_speed_1');?>" maxlength="15" size="10"/></td>
						</tr>
				<?php }?>
			</tbody>

			</table>
		</div>
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Save</button>
		</div>
	</div>
 
	
</form>




				
				
				
			