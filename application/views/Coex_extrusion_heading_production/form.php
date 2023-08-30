<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();	
		$("#job_card_no_1").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});
	});//Jquery closed

    $(document).ready(function() {
      $( ".ok_by_qc" ).live( "change", function() {
	    var tr = $(this).closest("tr");
	    tr.find(".hold_by_qc").val(Number(tr.find(".ok_qty").val()) - Number(tr.find(".ok_by_qc").val()));	    
	  });
	});
</script>

<style>
	input[readonly]{background: #f7f7f7;cursor:no-drop;}
	select[readonly]{
    background: #f7f7f7;
    cursor:no-drop;
}

select[readonly] option{
    display:none;
}
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<?php foreach($coex_extrusion as $coex_extrusion_row):?>
			
		<input type="hidden" name="heading_id" value="<?php echo $coex_extrusion_row->heading_id;?>">
		<table class="form_table_design">
			<tr>
				<td width="45%">
					<table class="form_table_inner">

						<tr>
							<td class="label"><b>Inspection Name</b><span style="color:red;">*</span>  :</td>
							<td><input type="text" name="inspection_name" size="30" required/></td>
						</tr>

						<tr>
							<td class="label"><b>Date</b></td>
							<td><input type="date" name="extrusion_date"  id="extrusion_date" size="10" value="<?php echo set_value('release_date',$coex_extrusion_row->release_date);?>" readonly required/>


								<b>Shift</b>
								<select name="shift" id="shift" readonly required/><option value=''>--Shift--</option>
								<?php if($shift_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($shift_master as $shift_master_row){
											$selected=($shift_master_row->shift_id==$coex_extrusion_row->shift_id ? 'selected' :'');
											echo "<option value='".$shift_master_row->shift_id."'  $selected ".set_select('shift',''.$shift_master_row->shift_id.'').">".$shift_master_row->shift_name."</option>";
										}
								}?></select>

								<b>Machine</b>
								<select name="machine" id="machine" readonly required/><option value=''>--Machine--</option>
							<?php if($coex_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($coex_machine_master as $machine_row){
										$selected=($machine_row->machine_id==$coex_extrusion_row->machine_id ? 'selected' :'');
										echo "<option value='".$machine_row->machine_id."' $selected ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
									}
							}?>
							</select>
							<b>Operator</b>
							<input type="text" name="operator" size="20" value="<?php echo set_value('operator',$coex_extrusion_row->operator);?>" readonly required/>

								</td>							
						</tr>

					</table>			
				</td>							
			</tr>
		</table>
		<?php endforeach;?>					
	</div>
	<div class="middle_form_design" style="min-height:0px !important;">
		<div class="middle_form_inner_design">
			<table class="record_table_design_without_fixed" style="font-size:12px;">
				<thead>
				<tr>
         <th>Order No</th>
         <th>Product No</th>
         <th>Job No</th>
			   <th>Sleeve Weight</th>
         <th>Dia</th>
         <th>Length</th>
				 <th>Production Qty</th>
				 <th>Ok by QC<span style="color:red;">*</span></th>
				 <th>Hold by QC<span style="color:red;">*</span></th> 
				</tr>
				</thead>
			<tbody>
		    <?php
			if($coex_extrusion==FALSE){
				echo "<tr><td colspan='6'>No Record</td></tr>";
			}else{
				foreach ($coex_extrusion as $coex_extrusion_row) {
			?>
			<tr id="tr_1">
        <td><input type="text" name="order_no" id="order_no" value="<?php echo set_value('order_no',$coex_extrusion_row->order_no);?>" placeholder="Order No" readonly required/ ></td>
        <td><input type="text" name="article_no" id="article_no" value="<?php echo set_value('article_no',$coex_extrusion_row->article_no);?>" placeholder="Product No" readonly required/ ></td>
			  <td><input type="text" name="jobcard_no" id="job_card_no_1" value="<?php echo set_value('jobcard_no',$coex_extrusion_row->jobcard_no);?>" placeholder="JOBCARD" readonly required/ ></td>
			  <td><input type="text" name="sleeve_weight_gm" id="sleeve_weight_gm" value="<?php echo set_value('sleeve_weight_gm',$coex_extrusion_row->sleeve_weight_gm);?>" placeholder="Sleeve Weight GM" readonly required > GM</td>
			  <td><input type="text" name="diameter" id="diameter" value="<?php echo set_value('diameter',$coex_extrusion_row->diameter);?>" placeholder="Diameter" readonly required/ ></td>
			  <td><input type="text" name="length" id="length" value="<?php echo set_value('length',$coex_extrusion_row->length);?>" placeholder="Length" readonly required/ > MM</td>
			  <td><input type="text" name="production_qty"  id="ok_qty_1" class="ok_qty" value="<?php echo set_value('production_qty',$coex_extrusion_row->heading_qty);?>" maxlength="15" size="10" readonly required/> No</td>
        <td><input type="text" name="ok_by_qc"  id="ok_by_qc" class="ok_by_qc" value="<?php echo set_value('ok_by_qc');?>" maxlength="15" size="10" required/> NOS</td>
        <td><input type="text" name="hold_by_qc"  id="hold_by_qc" class="hold_by_qc" value="<?php echo set_value('hold_by_qc');?>" maxlength="15" size="10" required/> NOS</td> 
			</tr>
			<?php 
				}
			}
			?>
			</tbody>
			</table>
		</div>
	</div>

	<div class="form_design" style="margin: 0px auto 0px auto !important;">
		<div class="ui buttons">
	  		<button class="ui positive button">Save</button>
		</div>
	</div>
</form>			