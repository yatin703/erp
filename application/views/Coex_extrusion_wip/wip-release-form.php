<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#release_to_order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_open_so_no');?>", {selectFirst: true});		
		$("#tr_release_to_order_no").hide();
		$("#td_release_order").hide()
	});//Jquery closed


$(document).ready(function() {
   $(".scrap_qty").live("change", function() {
	   var ok_qty      = Number($('input[name=ok_by_qc]').val());
	   var release_qty = Number($("#scrap_qty").val());
      

      if(release_qty > ok_qty){
       	alert('Ok Qty Greater Than Release Qty');
		   Number($('#scrap_qty').removeAttr('value'));
		   location.reload();
      }else{
       	$("#wip_qty").val(ok_qty - release_qty);
  
      }

	});
});

$(function() {
  $('.scrap_qty').click(function() {
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
fieldset{
		border: 1px solid #8cacbb;
	  width: 59%;
	}
</style>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/wip_release_save');?>" method="POST"  >

	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<?php foreach($coex_extrusion_wip as $row):?>

		
		
		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>WIP Quantity Check </b></legend>
		<table class="form_table_design">
			<tr>
				<td width="100%">
					<table class="form_table_inner">
					
                        <input type="hidden" name="ce_id" value="<?php echo set_value('ce_id',$row->ce_id);?>">
						<input type="hidden" name="qc_id" value="<?php echo set_value('qc_id',$row->qc_id);?>">
						<input type="hidden" name="wip_id" value="<?php echo set_value('wip_id',$row->cewip_id);?>">
						<input type="hidden" name="cost" value="<?php echo set_value('cost',$row->cost);?>">

						<tr>
							<td class="label" >Date :</td>
							<td><input type="date" name="extrusion_date"  id="extrusion_date" size="10" value="<?php echo set_value('extrusion_date',$row->extrusion_date);?>" readonly required style="width:168px;"></td>
							<td class="label">Operator :</td>
							<td>
							    <input type="text" name="operator" id="operator" size="20" value="<?php echo set_value('operator',$row->operator);?>" placeholder="Operator" readonly required/ >
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
								    echo "<option value=''>--Setup Required--</option>";
										}else{
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
							    <input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$row->order_no);?>" readonly/>
						    </td>
							<td class="label">Article No. :</td>
							<td>
							    <input type="text" name="article_no" id="article_no"  size="20" value="<?php echo set_value('diameter',$row->article_no);?>" readonly/>
							</td>
						</tr>
						
						<tr>
							<td class="label">Job No:</td>
							<td>
							    <input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" readonly/>
							</td>
							<td class="label">Sleeve Weight :</td>
                            <td><input type="text" name="sleeve_weight_gm" id="sleeve_weight_gm"  size="20" value="<?php echo set_value('sleeve_weight_gm',$row->sleeve_weight_gm);?>" readonly/></td>
						</tr>

						<tr>
							<td class="label">Dia:</td>
							<td>
							    <input type="text" name="diameter" id="diameter"  size="20" value="<?php echo set_value('diameter',$row->diameter);?>" readonly/>
							</td>
							<td class="label">Length :</td>
                            <td><input type="text" name="length" id="length"  size="20" value="<?php echo set_value('length',$row->length);?>" readonly/></td>
						</tr>

                         <input type="hidden" name="layer_no" id="layer_no"  value="<?php echo set_value('layer_no',$row->layer_no);?>" >
                         
						<tr>
							<th style="background: #dee7ec;text-align: left;">Ok Qty</th>
							<th style="background: #dee7ec;text-align: left;">Release OK Qty<span style="color:red;">*</span></th>
							<th style="background: #dee7ec;text-align: left;">Release Towards<span style="color:red;">*</span></th>
							<th style="background: #dee7ec;text-align: left;">Inspector Name<span style="color:red;">*</span></th>
						</tr>
                           <input type="hidden" name="ok_qty" id="ok_qty"   size="20" value="<?php echo set_value('ok_by_qc',$row->ok_by_qc);?>" >
						<tr>

							<td><input type="number" name="ok_by_qc" id="wip_qty" class="wip_qty"  size="20" min="0" value="<?php echo set_value('ok_by_qc',$row->ok_by_qc);?>" readonly/ style="font-weight: 600;"></td>
							
							<td><input type="number" name="release_qty" id="scrap_qty" class="scrap_qty" size="20" min="0" value="<?php echo set_value('release_qty');?>" style="font-weight: 600;"></td>
                     
							<td><select name="to_process" id="to_process">				
								<option value="">--Please select--</option>
								<option value="4" <?php echo set_select('WIP Scrap','4');?>>WIP Scrap</option>
								<option value="7" <?php echo set_select('Return Extrusion QC','7');?>>Return Extrusion QC</option>
								<option value="2" <?php echo set_select('Heading','2');?>>Heading</option>
								<option value="3" <?php echo set_select('Printing','3');?>>Printing</option>
								
							</select>
							</td>
							<td><input type="text" name="inspection_name" id="release_by"  size="20" value="<?php echo set_value('inspection_name');?>"></td>
						</tr>

						<tr>
							<td class="label" colspan="2">Remark</td>
						</tr>
            
            <tr>
							<td colspan="4">
								  <textarea id="remark" name="remark" rows="5" cols="45"></textarea>
							</td>
						</tr>						
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
       <?php endforeach;?>	
</div>
<div style="visibility: hidden" id="output">0</div>	
</form>