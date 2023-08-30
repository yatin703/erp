<style>
	input[readonly]{background: #f7f7f7;cursor:no-drop;}
	select[readonly]{
    background: #f7f7f7;
    cursor:no-drop;
}

select[readonly] option{
    display:none;
}
input[type="checkbox"][readonly] {
  pointer-events: none;
}
fieldset{
		border: 1px solid #8cacbb;
	  width: 59%;
	}
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/jobcard_update');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<?php
		if($coex_extrusion_wip!='False'){
			foreach ($coex_extrusion_wip as $row) {
		?>
<input type="hidden" name="wip_id" value="<?php echo set_value('wip_id',$row->cewip_id);?>">
		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>Jobcard Plan Check</b></legend>
		<table class="form_table_design">
			<tr>
				<td width="60%">
					<table class="form_table_inner">
					<?php
						if($coex_extrusion_wip!=''){
						foreach ($coex_extrusion_wip as $row) {
					?>

                    <tr>
					    <td class="label">Extrusion Date <span style="color:red;">*</span> :</td>
						<td><input type="date" name="release_date" value="<?php echo set_value('release_date',date('Y-m-d'));?>" readonly / style="width: 100%;"></td>
						<td class="label">Operator  :</td>
					    <td ><input type="text" name="operator" id="operator" size="20" value="<?php echo set_value('operator',$row->operator);?>" placeholder="Operator" readonly required/ ></td>
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
							<td class="label">Order No.  :</td>
							<td>
							    <input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$row->order_no);?>" readonly/></td>
							<td class="label">Product No :</td>
							<td>
                                <input type="text" name="article_no" id="article_no"  size="20" value="<?php echo set_value('article_no',$row->article_no);?>" readonly/></td>
							</td>
						</tr>
						
						<tr>
							<td class="label">Job No:</td>
							<td>
							    <input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" readonly/>
							</td>
							<td class="label">Sleeve Weight :</td>
                            <td>
							<input type="text" name="sleeve_weight_gm" id="sleeve_weight_gm"  size="20" value="<?php echo set_value('sleeve_weight_gm',$row->sleeve_weight_gm);?>" readonly/></td>
						</tr>

						<tr>
							<td class="label">Dia:</td>
							<td >
							    <input type="text" name="diameter" id="diameter"  size="20" value="<?php echo set_value('diameter',$row->diameter);?>" readonly/>
							<td class="label">Length :</td>
							<td >
							    <input type="text" name="length" id="length"  size="20" value="<?php echo set_value('length',$row->length);?>" readonly/></td>
						</tr>

						
						<tr>
							<td class='label' >Release Towards <span style='color:red;'>*</span>:</td>
							<td><select name='next_process_print' id='next_process_print' style='width:100%'>				
								<option value=''>--Please select--</option>
								<option value='5' <?php echo set_select('heading','5') ?>>Heading</option>
								<option value='6' <?php echo set_select('printing','6') ?>>Printing</option>
							</select>
							</td>
						</tr>


						<tr>
							<td class='label'>Jobcard Issue <span style='color:red;'>*</span> :</td>
							<td><input type='checkbox' name='jobcard_issue' value='1' <?php echo set_checkbox('jobcard_issue','1') ?> /></td>
						</tr>

						<tr>
							<td class='label'>Jobcard Extrusion Close <span style='color:red;'>*</span> :</td>
							<td><input type='checkbox' name='jobcard_close' value='1' "<?php echo set_checkbox('jobcard_issue','1') ?> /></td>
						</tr>
						
						<tr>
							<td class="label">Inspector Name <span style="color:red;">*</span>:</td>
							<td><input type="text" name="jobcard_issue_name" id="jobcard_issue_name"  size="20" value="<?php echo set_value('jobcard_issue_name');?>"></td>
						</tr>

						<tr>
							<td class="label">Remark :</td>
							<td ><textarea  name="jobcard_issue_remark" id="jobcard_issue_remark" value="<?php echo set_value('jobcard_issue_remark');?>" rows="3"></textarea></td>
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