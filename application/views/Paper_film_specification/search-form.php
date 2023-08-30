<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
   $(document).ready(function(){
      $("#loading").hide(); $("#cover").hide();
      $("#article_no").autocomplete("<?php echo base_url('index.php/ajax/paper_film_autocomplete');?>", {selectFirst: true});

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

<style type="text/css">
	input{width: 100%;}
	select{width: 100%;}
	.form_table_design:hover{background: #dbdcdd;}
</style>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" id="form1" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="100%">
					<table class="form_table_inner">
								<?php foreach ($account_periods_master as $account_periods_master_row ):?> 
              
            		
									<tr>
										<td class="label" >From Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>"/></td>
										<td class="label" >To Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"/></td>
									</tr>
								<?php endforeach;?>
									<tr>
										<td class="label">Paper Film No * :</td>
										<td colspan="3">
											<input type="text" name="article_no" id="article_no" size="50" maxlength="200" value="<?php echo set_value('article_no');?>"/>
										</td>
									</tr>

									<tr>
										<td class="label">Dia  :</td>
										<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select></td>
										<td class="label">Total Thickness  :</td>
										<td> <input type="text" name="pf_thickness" id="sleeve_length" size="17" maxlength="6" value="<?php echo set_value('sleeve_length');?>">
										</td>
									</tr>

									<tr>
										<td class="label">Layer  :</td>
										<td><select name="layer_no" id="layer_no"><option value=''>--Select Layer--</option>
											<option value='1'>1 Layer</option>
											<option value='2'>2 Layer</option>
											<option value='3'>3 Layer</option>
											<option value='4'>4 Layer</option>
											<option value='5'>5 Layer</option>
											<option value='6'>6 Layer</option>
											<option value='7'>7 Layer</option>
										</select>
										<td class="label"> Width :</td>
										<td> <input type="text" name="pf_width" id="pf_width" size="17" maxlength="6" value="<?php echo set_value('sleeve_length');?>">
										</td>
									</tr>
									<tr>
										<td class="label"> Approval Status :</td>
										<td >
											<select name="final_approval_flag" id="final_approval_flag" >
												<option value="">--Please Select--</option>
												<option value="1" <?php echo set_select('final_approval_flag','1'); ?> >Approved</option>
												<option value="0" <?php echo set_select('final_approval_flag','0'); ?>>Not Approved</option>
											</select>

										</td>
										<td class="label">Created By :</td>
										<td><select name="user_id" id="user_id">
											<option value=''>--Select User--</option>
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
						<tr>
					<td>
						<div class="" style="margin:5px 0px 5px 2px;">
							<div class="ui buttons">
						  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
						  <div class="or"></div>
						  <button class="ui positive button" onClick="return validate_form();">Search</button>
							</div>
						</div>
					</td>
				</tr>
			</table>
	   </div>	
</form>
				
				
				
				
				
			