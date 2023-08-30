<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>


<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();	
		$("#job_card_no_1").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});
	});//Jquery closed

  $(document).ready(function () {
    $(".hold_by_qc").click(function () {
    	var total_qty = Number($('input[name=production_qty]').val());
			var ok_qty    = Number($("#ok_by_qc").val());
				
				if(total_qty < ok_qty){
		        alert('Check Production Qty');
		        //$('#btnsubmit').addClass('disabled');
		        Number($('#hold_by_qc').removeAttr('value'));
		        location.reload();
				}else{
					  $("#hold_by_qc").val(total_qty - ok_qty);
				}

		});    

		 $("#ok_by_qc").keyup(function () {
    	var total_qty = Number($('input[name=production_qty]').val());
			var ok_qty    = Number($("#ok_by_qc").val());
				
				if(total_qty < ok_qty){
		        alert('Check Production Qty');
		        //$('#btnsubmit').addClass('disabled');
		        Number($('#hold_by_qc').removeAttr('value'));
		        location.reload();
				}else{
					  $("#hold_by_qc").val(total_qty - ok_qty);
				}

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

	table.form_table_design {
	    border-collapse: collapse;
	    width: 58%;
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
table.form_table_design:hover{
	background: #e4e4e4;
}
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/qc_save');?>" method="POST" >
	<div class="form_design">
		
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<fieldset>
		<legend><b>Quality Check</b></legend>
		<table class="form_table_design">
			<tr>
				<td width="60%">
					<table class="form_table_inner" width="100%">
					<?php foreach($coex_extrusion as $row):?>
          <input type="hidden" name="ce_id" value="<?php echo $row->ce_id;?>">
						<tr>
							<td class="label" >Extrusion Date :</td>
							<td><input type="date" name="extrusion_date"  id="extrusion_date" size="10" value="<?php echo set_value('extrusion_date',$row->extrusion_date);?>" readonly required/ style="width:168px;"></td>

							<td class="label">Operator :</td>
							<td>
							    <input type="text" name="operator" size="20" value="<?php echo set_value('operator',$row->operator);?>" readonly required/>
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
											$selected=($shift_master_row->shift_id==$row->shift_id ? 'selected' :'');
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
												$selected=($machine_row->machine_id==$row->machine_id ? 'selected' :'');
												echo "<option value='".$machine_row->machine_id."' $selected ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
											}
									}?>
							    </select>
							</td>								
						</tr>						
									
						<tr>
							<td class="label">Order No :</td>
							<td>
							    <input type="text" name="order_no" id="order_no" value="<?php echo set_value('order_no',$row->order_no);?>" placeholder="Order No" readonly required/ >
						  </td>

							<td class="label">Product No :</td>
							<td>
							    <input type="text" name="article_no" id="article_no" value="<?php echo set_value('article_no',$row->article_no);?>" placeholder="Product No" readonly required/ >
							</td>
						</tr>
						
						<tr>
							<td class="label">Job No:</td>
							<td>
							    <input type="text" name="jobcard_no" id="job_card_no_1" value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" placeholder="JOBCARD" readonly required/ >
							</td>
							<td class="label">Sleeve Weight :</td>
              <td><input type="text" name="sleeve_weight_gm" id="sleeve_weight_gm" value="<?php echo set_value('sleeve_weight_gm',$row->sleeve_weight_kg*1000);?>" placeholder="Sleeve Weight GM" readonly required ></td>
						</tr>

						<tr>
							<td class="label">Dia:</td>
							<td>
							    <input type="text" name="diameter" id="diameter" value="<?php echo set_value('diameter',$row->diameter);?>" placeholder="Diameter" readonly required/ >
							</td>
							<td class="label">Length :</td>
              <td><input type="text" name="length" id="length" value="<?php echo set_value('length',$row->length);?>" placeholder="Length" readonly required/ ></td>
						</tr>
            
            <input type="hidden" name="layer_no" id="layer_no" value="<?php echo set_value('layer_no',$row->layer_no);?>" >

						<tr>
							<th style="background: #dee7ec;text-align: left;">Production Qty</th>
							<th style="background: #dee7ec;text-align: left;">Qc Ok Qty<span style="color:red;">*</span></th>
							<th style="background: #dee7ec;text-align: left;">Qc Hold Qty<span style="color:red;">*</span></th>
							<th style="background: #dee7ec;text-align: left;">QC Inspector Name<span style="color:red;">*</span></th>
						</tr>

						<tr>
							<td><input type="number" name="production_qty"  id="ok_qty_1" class="ok_qty" value="<?php echo set_value('production_qty',$row->ok_qty_no);?>" maxlength="15" size="10" readonly required/ style="font-weight: 600;"></td>
							<td ><input type="number" name="ok_by_qc"  id="ok_by_qc" class="ok_by_qc" value="<?php echo set_value('ok_by_qc');?>" maxlength="15" size="10" style="font-weight: 600;">
							</td>
							<td><input type="number" name="hold_by_qc"  id="hold_by_qc" class="hold_by_qc" value="<?php echo set_value('hold_by_qc');?>" maxlength="15" size="10" readonly style="font-weight: 600;"></td>
							<td><input type="text" name="inspection_name" id="inspection_name"  size="20" value="<?php echo set_value('inspection_name');?>"></td>
						</tr>
           
            <!-- <tr>
							<td class="label" colspan="4">QC Defect</td>
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
								  <textarea id="remark" name="remark" rows="5" cols="100"></textarea>
							</td>
						</tr>

					<?php endforeach;?>						
					</table>											
				</td>
				<td width="40%">
					<table class="form_table_inner" style="width: 300px;">
					<?php foreach($coex_extrusion as $row):?>
            <tr>
							<td class="label">QC Defect</td>
						</tr>
            <tr>
							<td>
								<ul>
									<?php foreach($defect as $row_defect){?>
                  	<li style=""><input type="checkbox" name="defect[]" value="<?php echo $row_defect->id?>"><span class="px-1"><?php echo $row_defect->defect?></span></li>
                  
                <?php }?>
              </ul>
							</td>
						</tr>
						</table>
						<?php endforeach;?>
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
	
</div>	
</form>


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.category').select2();
  });
</script> -->
