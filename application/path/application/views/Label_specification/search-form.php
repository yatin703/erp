<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#label_code").autocomplete("<?php echo base_url('index.php/ajax/label_autocomplete');?>", {selectFirst: true});
		$("#label_name").autocomplete("<?php echo base_url('index.php/ajax/label');?>", {selectFirst: true});
		
	});
</script>

<script>
	function validate_form(){

		var x=document.getElementById("form1");
		var flag=0;
		for(i=0;i<x.length;i++){
			
			if(x.elements[i].value!='' && x.elements[i].name!='' &&  x.elements[i].name!='from_date' && x.elements[i].name!='to_date'){
				flag=1;								
			}
			if(document.getElementById('from_date').value!='' && document.getElementById('to_date').value!=''){
				flag=1;	
			}
		}

		if(flag==1){
			return true;
		}else{
			alert('From Date And To Date Should not be Blank.');

			if(document.getElementById('from_date').value==''){
				document.getElementById('from_date').focus();
				return false;
			}
			else{
				document.getElementById('to_date').focus();
				return false;
			}
			    
		}		
					
		
	}

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" id="form1" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
									
									
									<tr>
										<td class="label" >From Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>"/></td>
										<td class="label" >To Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"/></td>
									</tr>
									<tr>
										<td class="label">Label No. :</td>
										<td colspan="3"><input type="text" name="label_code" id="label_code" size="60" value="<?php echo set_value('label_code');?>" /></td>
									</tr>								

									<tr>
										<td class="label">Label Material :</td>
										<td colspan="3"><input type="text" name="label_name" id="label_name" size="60" value="<?php echo set_value('label_name');?>"/></td>
									</tr>

									<tr id="lacquer_type_1">
										<td class="label">Lacquer Type 1 <span style="color:red;">*</span>:</td>
										<td colspan="3"><select name="lacquer_type_1" id="lacquer_type_1" ><option value=''>--Select Lacquer--</option>
										<?php if($lacquer==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($lacquer as $lacquer_row){
													echo "<option value='".$lacquer_row->article_no."'   ".set_select('lacquer_type_1',$lacquer_row->article_no).">".$lacquer_row->lang_article_description."</option>";
												}
										}?></select><input type="number" min="0" max="100" step="1"  name='lacquer_mixing_pc_1' id="lacquer_mixing_pc_1" size="3" value='<?php echo set_value('lacquer_mixing_pc_1');?>'  placeholder="%"></td>
									</tr>

									<tr id="lacquer_type_2">
										<td class="label">Lacquer Type 2 :</td>
										<td colspan="3"><select name="lacquer_type_2" id="lacquer_type_2"><option value=''>--Select Lacquer--</option>
										<?php if($lacquer==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($lacquer as $lacquer_row){
													echo "<option value='".$lacquer_row->article_no."'  ".set_select('lacquer_type_2',$lacquer_row->article_no).">".$lacquer_row->lang_article_description."</option>";
												}
										}?></select><input type="number"  min="0" max="100" step="1" name='lacquer_mixing_pc_2' id="lacquer_mixing_pc_2" size="3" value='<?php echo set_value('lacquer_mixing_pc_2');?>'  placeholder="%"></td>
									</tr>

									<tr>
										<td class="label">Non Lacquering Height by Open End <span style="color:red;">*</span>:</td>
										<td colspan="3"><input type="number" min="0" max="100" step="1" name="non_lacquering_height_by_open_end" id="non_lacquering_height_by_open_end" size="3" value='<?php echo set_value('non_lacquering_height_by_open_end');?>' ></td>
									</tr>

									<tr>
										<td class="label">Non Labeling Height by Shoulder End <span style="color:red;">*</span>:</td>
										<td colspan="3"><input type="number" min="0" max="100" step="1" name="non_labeling_height_by_shoulder_end" id="non_labeling_height_by_shoulder_end" size="3" value='<?php echo set_value('non_labeling_height_by_shoulder_end');?>' ></td>
									</tr>

									<tr>
										<td class="label">Approval Status  :</td>
										<td colspan="3"><select name="final_approval_flag" id="final_approval_flag" >
														<option value="" <?php echo (set_value('final_approval_flag')==""?"selected":"")?>>All</option>
														<option value="1" <?php echo (set_value('final_approval_flag')=="1"?"selected":"")?> >Approved</option>
														<option value="0" <?php echo (set_value('final_approval_flag')=="0"?"selected":"")?>>Not Approved</option>
														</select>
										</td>
									</tr>

									<tr>
										<td class="label">Created By :</td>
										<td colspan="3"><select name="user_id">
											<option value=''>--Select user--</option>
											<?php 
											foreach ($user_master as $user_master_row) {
								             echo "<option value='".$user_master_row->user_id."' ".set_select('user_id',$user_master_row->user_id).">".strtoupper($user_master_row->login_name)."</option>";
								             }
								             ?>
								            </select></td>
      								</tr>
										
									
								</table>
							</td>
							
						</tr>
			</table>
				
			

	</div>

	<div class="form_design">
		<div class="ui buttons">
	  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  <div class="or"></div>
	  <button class="ui positive button" onClick="return validate_form();">Search</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			