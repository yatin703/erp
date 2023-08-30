<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();	
		$("#job_card_no_1").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});
	});//Jquery closed

  $(document).ready(function() {	
      $( ".scrap_by_qc" ).live( "change", function() {
	    var tr = $(this).closest("tr");
	    tr.find(".ok_qty").val(Number(tr.find(".ok_qty").val()) - Number(tr.find(".scrap_by_qc").val()));
			if($("#hold_by_qc").val() <= 0){
				alert('Enter a valid quantity.');
			  $('#btnsubmit').addClass('disabled');
			}   
	  });
	});

	$(document).ready(function() {
      $( ".ok_by_qc" ).live( "change", function() {
	    var tr = $(this).closest("tr");
	    tr.find(".ok_qty").val(Number(tr.find(".ok_qty").val()) - Number(tr.find(".ok_by_qc").val()));
	    if($("#hold_by_qc").val() <= 0){
	    	alert('Enter a valid quantity.');
			  $('#btnsubmit').addClass('disabled');
			}   
	  });
	});
</script>

<style>
	.on-hower {
    background-color: #e4e4e4;
}
input[readonly]{background: #f7f7f7;cursor:no-drop;}
	select[readonly]{
    background: #f7f7f7;
    cursor:no-drop;
}

select[readonly] option{
    display:none;
}
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<?php
		if($hold_data!=''){
			foreach ($hold_data as $coex_extrusion_row) {
		?>
	  <input type="hidden" name="hqc_id" value="<?php echo $coex_extrusion_row->hqc_id;?>">	
	  <input type="hidden" name="heading_id" value="<?php echo $coex_extrusion_row->heading_id;?>">
		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>QC Create</b></legend>
		<table class="form_table_design">
			<tr>
				<td width="100%">
					<table class="form_table_inner">
					<?php
						if($hold_data!=''){
						foreach ($hold_data as $coex_extrusion_row) {
					?>

						<tr>
							<td class="label" >Date :</td>
							<td><input type="date" name="extrusion_date"  id="extrusion_date" size="10" value="<?php echo set_value('extrusion_date',$coex_extrusion_row->extrusion_date);?>" readonly required style="width:168px;"></td>
							<td class="label">Operator :</td>
							<td>
							    <input type="text" name="operator" id="operator" value="<?php echo set_value('operator',$coex_extrusion_row->operator);?>" placeholder="Operator" readonly required >
						  </td>
						</tr>

            <tr>
            	<td class="label" >Shift :</td>
							<td>
								<select name="shift" id="shift" readonly required style="width:168px;">
								    <option value=''>--Shift--</option>
									<?php if($shift_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($shift_master as $shift_master_row){
											$selected=($shift_master_row->shift_id==$coex_extrusion_row->shift_id ? 'selected' :'');
											echo "<option value='".$shift_master_row->shift_id."'  $selected ".set_select('shift',''.$shift_master_row->shift_id.'').">".$shift_master_row->shift_name."</option>";
										}
								    }?>
							    </select>
							</td>
							<td class="label">Machine :</td>
							<td>
							    <select name="machine" id="machine" readonly required style="width:168px;">
								    <option value=''>--Machine--</option>
									<?php if($coex_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($coex_machine_master as $machine_row){
												$selected=($machine_row->machine_id==$coex_extrusion_row->machine_id ? 'selected' :'');
												echo "<option value='".$machine_row->machine_id."' $selected ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
											}
									}?>
							    </select>
							</td>								
						</tr>						
									
						<tr>
							<td class="label">Order No :</td>
							<td>
							    <input type="text" name="order_no" id="order_no" value="<?php echo set_value('order_no',$coex_extrusion_row->order_no);?>" placeholder="Order No" readonly required/ >
						    </td>
							<td class="label">Product No :</td>
							<td>
							    <input type="text" name="article_no" id="article_no" value="<?php echo set_value('article_no',$coex_extrusion_row->article_no);?>" placeholder="Product No" readonly required/ >
							</td>
						</tr>
						
						<tr>
							<td class="label">Job No:</td>
							<td>
							    <input type="text" name="jobcard_no" id="job_card_no_1" value="<?php echo set_value('jobcard_no',$coex_extrusion_row->jobcard_no);?>" placeholder="Jobcard No" readonly required/ >
							</td>
							<td class="label">Sleeve Weight :</td>
              <td><input type="text" name="sleeve_weight_gm" id="sleeve_weight_gm" value="<?php echo set_value('sleeve_weight_gm',$coex_extrusion_row->sleeve_weight_gm);?>" placeholder="Sleeve Weight GM" readonly required/ ></td>
						</tr>

						<tr>
							<td class="label">Dia:</td>
							<td>
							    <input type="text" name="diameter" id="diameter" value="<?php echo set_value('diameter',$coex_extrusion_row->diameter);?>" placeholder="Diameter"  readonly required/ >
							</td>
							<td class="label">Length :</td>
              <td><input type="text" name="length" id="length" value="<?php echo set_value('length',$coex_extrusion_row->length);?>" placeholder="Length" readonly required/ ></td>
						</tr>
            
            <input type="hidden" name="production_qty"  id="ok_qty_1" class="" value="<?php echo set_value('production_qty',$coex_extrusion_row->hold_by_qc);?>" >

						<tr>
							<th style="background: #dee7ec;">Hold by QC</th>
							<th style="background: #dee7ec;">Ok by QC<span style="color:red;">*</span></th>
							<th style="background: #dee7ec;">Scrap by QC<span style="color:red;">*</span></th>
							<th style="background: #dee7ec;">Inspection Name<span style="color:red;">*</span></th>
						</tr>

						<tr>
							<td><input type="text" name="hold_by_qc"  id="hold_by_qc" class="ok_qty" value="<?php echo set_value('hold_by_qc',$coex_extrusion_row->hold_by_qc);?>"  readonly required ></td>
							<td ><input type="text" name="ok_by_qc"  id="ok_by_qc" class="ok_by_qc" value="<?php echo set_value('ok_by_qc');?>"  required ></td>
							<td><input type="text" name="scrap_by_qc"  id="scrap_by_qc" class="scrap_by_qc" value="<?php echo set_value('scrap_by_qc');?>"  required ></td>
							<td><input type="text" name="inspection_name" required/></td>
						</tr>

						<tr>
							<td class="label" colspan="2">Remark</td>
						</tr>
            
            <tr>
							<td colspan="4">
								  <textarea id="remark" name="remark" rows="5" cols="45"></textarea>
							</td>
						</tr>

					<?php 
						}
					}
					?>						
					</table>											
				</td>											
			</tr>
			
			<tr>
				<td colspan="2">
					<div class="ui buttons">
						<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
						<div class="or"></div>
						<button class="ui positive button" id="btnsubmit" class="disabled">Save</button>
						 
					</div>
				</td>
			</tr>
			
		</table>
	    </fieldset>	
        <?php 
		    }
		}
		?>	
</div>	
</form>