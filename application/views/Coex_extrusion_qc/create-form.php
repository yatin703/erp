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
			if($("#hold_by_qc").val() < 0){
				alert('Check Production Qty');
			  //$('#btnsubmit').addClass('disabled');
			  location.reload();
			}  
	  });
	});

	$(document).ready(function() {
      $( ".ok_by_qc" ).live( "change", function() {
	    var tr = $(this).closest("tr");
	    tr.find(".ok_qty").val(Number(tr.find(".ok_qty").val()) - Number(tr.find(".ok_by_qc").val()));
	    if($("#hold_by_qc").val() < 0){
	    	alert('Check Production Qty');
			  //$('#btnsubmit').addClass('disabled');
			  location.reload();
			}  
	  });
	});

	$(function() {
  $('.ok_by_qc').click(function() {
    $('#output').html(function(i, val) {   
      if(val == 1){
         alert('ReEnter Qty');
         location.reload();
      }else{
      	return val * 1 + 1;
      }
    });
   
  });
});


$(function() {
  $('#scrap_by_qc').click(function() {
    $('#output_scrap').html(function(i, val) {   
      if(val == 1){
         alert('ReEnter Qty');
         location.reload();
      }else{
      	return val * 1 + 1;
      }
    });
   
  });
});


</script>

<style>
	.on-hower {
    background-color: #e4e4e4;
}
input[readonly]{background: #f7f7f7;cursor:no-drop;}
input[type="checkbox"][readonly] {
  pointer-events: none;
}

	select[readonly]{
    background: #f7f7f7;
    cursor:no-drop;
}

select[readonly] option{
    display:none;
}
fieldset{
	border: 1px solid #8cacbb;
  width: 59%;
}
input[type="checkbox"]{margin-right: 2px;}
span.px-1{margin-right: 8px;}
	li {list-style: none;}
	ul {
    display: block;
    list-style-type: disc;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    padding-inline-start: 10px;
}
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_qc');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<?php
		if($hold_qc!='False'){
			foreach ($hold_qc as $coex_extrusion_row) {
		?>
		<input type="hidden" name="ceqc_id" value="<?php echo $coex_extrusion_row->qc_id;?>">	
	  <input type="hidden" name="ce_id" value="<?php echo $coex_extrusion_row->ce_id;?>">
		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>Hold Quality Check</b></legend>
		<table class="form_table_design">
			<tr>
				<td width="60%">
					<table class="form_table_inner">
					<?php
						if($hold_qc!=''){
						foreach ($hold_qc as $coex_extrusion_row) {
					?>
					  
					  

						<tr>
							<td class="label" >Extrusion Date :</td>
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

						<input type="hidden" name="layer_no" id="layer_no" value="<?php echo set_value('layer_no',$coex_extrusion_row->layer_no);?>" >

						<tr>
							<td class="label">Qc Hold Qty Date:</td>
							<td>
							    <input type="text" name="" id="" value="<?php echo set_value('', date("m-d-Y", strtotime($coex_extrusion_row->created_date)));?>" placeholder="Qc Hold Qty Date/Time"  readonly required/ >
							</td>
							<td class="label">QC Inspector Name :</td>
              <td><input type="text" name="" id="" value="<?php echo set_value('',$coex_extrusion_row->inspection_name);?>" placeholder="QC Inspector Name" readonly required/ ></td>
						</tr>
            
            <?php if($coex_extrusion_row->defect!=''){
                 echo"
               <tr>
							<td class='label' colspan='4'>Qc Defects</td>
						</tr>
                 ";
            }?>
						

						<tr>
							<td colspan="4">
								  <?php	
								   $d_arr = $coex_extrusion_row->defect;
								   $defect_arr = explode(",",$d_arr);
								   if(!empty($defect_arr)){				    
										foreach($defect_arr as $defect_id){
											$def=$this->coex_extrusion_model->get_defect_details_by_id($defect_id);
											//echo '<pre>'; print_r($def);
								  ?>
                   <?php if($def['defect']!=''){ echo'&#x2022'.$def['defect'];}else{echo' ';} ?>
                   
									<?php }} else{echo ' ';}?> 
							</td>
						</tr>
            
            <input type="hidden" name="production_qty"  id="ok_qty_1" class="" value="<?php echo set_value('production_qty',$coex_extrusion_row->hold_by_qc);?>" >

						<tr>
							<th style="background: #dee7ec;text-align: left;">Qc Hold</th>
							<th style="background: #dee7ec;text-align: left;">QC Hold Ok<span style="color:red;">*</span></th>
							<th style="background: #dee7ec;text-align: left;">QC Hold Scrap<span style="color:red;">*</span></th>
							<th style="background: #dee7ec;text-align: left;">QC Hold Inspector Name<span style="color:red;">*</span></th>
						</tr>

						<tr>
							<td><input type="number" name="hold_by_qc"  id="hold_by_qc" class="ok_qty" value="<?php echo set_value('hold_by_qc',$coex_extrusion_row->hold_by_qc);?>"  readonly required style="font-weight: 600;"></td>
							<td ><input type="number" name="ok_by_qc"  id="ok_by_qc" class="ok_by_qc" value="<?php echo set_value('ok_by_qc');?>"  style="font-weight: 600;"></td>
							<td><input type="number" name="scrap_by_qc"  id="scrap_by_qc" class="scrap_by_qc" value="<?php echo set_value('scrap_by_qc');?>"  style="font-weight: 600;"></td>
							<td><input type="text" name="inspection_name" required/></td>
						</tr>
            
            <!-- <tr>
							<th style="background: #dee7ec;text-align: left;" colspan="4">QC Hold Defect</th>
						</tr>

            <tr>
							<td colspan="4">
                <?php foreach($defect as $row_defect){?>
                  <input type="checkbox" name="defect[]" value="<?php echo $row_defect->id?>"><span class="px-1"><?php echo $row_defect->defect?></span>
                <?php }?>          
							</td>
						</tr>  --> 

         
            	
            <tr>
							<td class="label" colspan="4">Remark</td>
						</tr>
            
            <tr>
							<td colspan="4">
								  <textarea id="remark" name="remark" rows="3" cols="100"></textarea>
							</td>
						</tr>

					<?php 
						}
					}
					?>						
					</table>											
				</td>	
        <td width="40%">
					<table class="form_table_inner" style="width: 300px;">
					<?php
						if($hold_qc!=''){
						foreach ($hold_qc as $coex_extrusion_row) {
					?>
            <tr>
							<td class="label">QC Hold Defect</td>
						</tr>
            <tr>
							<td>
								<ul>
									<?php foreach($defect as $row_defect){?>
                  	<li><input type="checkbox" name="defect[]" value="<?php echo $row_defect->id?>"><span class="px-1"><?php echo $row_defect->defect?></span></li>                  
                  <?php }?>
                </ul>
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
<div style="visibility: hidden" id="output">0</div>	
<div style="visibility: hidden" id="output_scrap">0</div>
</form>