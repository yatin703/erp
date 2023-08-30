<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax/so_no');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/article_no_springtube');?>", {selectFirst: true});

		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});

		$("#film_code").autocomplete("<?php echo base_url('index.php/ajax_springtube/film_autocomplete');?>", {selectFirst: true});
	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		

		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>Printing Inspection Search</b></legend>


		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<tr>
							<td class="label">From Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="from_date" id="from_date" size="30" value="<?php echo set_value('from_date',date('Y-m-d'));?>" ></td>
							<td class="label">To Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="to_date" id="to_date" size="30" value="<?php echo set_value('to_date',date('Y-m-d'));?>" ></td>
						</tr>
						<tr>
							<td class="label">SO No :</td>
							<td><input type="text" name="order_no" id="order_no"  value="<?php echo set_value('order_no');?>" maxlength="20" size="20"/></td>
							<td class="label">Jobcard No. :</td>
							<td><input type="text" name="jobcard_no" id="jobcard_no"  value="<?php echo set_value('jobcard_no');?>" maxlength="20" size="20"/></td>
						</tr>

						<tr>
							<td class="label">Sleeve Dia :</td>
							<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Dia--</option>
							<?php   if($sleeve_dia==FALSE){
											echo "<option value=''>--Setup Required--</option>";
									}
								else{
									foreach($sleeve_dia as $sleeve_dia_row){
										echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
									}
							}?></select>
							<td class="label">Sleeve Length :</td>
							 <td>
							 	<input type="number" name="sleeve_length" min="10"  max="500" step="0.1"  id="sleeve_length" size="5" maxlength="5" value="<?php echo set_value('sleeve_length');?>">
							 </td>							
						</tr>
						
						<!--<tr>
							
							<td class="label">Machine <span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine" readonly><option value=''>----Select Machine-----</option>
							<?php if($springtube_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_machine_master as $machine_row){
										$selected=($machine_row->machine_id==1?'selected':'');
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').$selected.">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
							<td class="label">Created By :</td>
							<td colspan="3"><select name="user_id" id="user_id">
								<option value=''>--Select User--</option>
								<?php 
								foreach ($user_master as $user_master_row) {
				             echo "<option value='".$user_master_row->user_id."' ".set_select('user_id',$user_master_row->user_id).">".strtoupper($user_master_row->login_name)."</option>";
				             }
				             ?>
				            </select></td>
						</tr>	

						-->					
											
									


					</table>			
								
				</td>
				<td>
					<table>
						<tr>
							<td class="label">Customer :</td>
							<td colspan="3"><input type="text" name="customer" id="customer"  value="<?php echo set_value('customer');?>" maxlength="200" size="60"/></td>
							
						</tr>
						<tr>
							<td class="label">SPSM/SPSP :</td>
							<td colspan="3"><input type="text" name="article_no" id="article_no"  value="<?php echo set_value('article_no');?>" maxlength="200" size="60"/></td>
							
						</tr>
					</table>
				</td>
										
			</tr>
			<tr>
				<td colspan="4">
					<div class="ui buttons">
					  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
					  <div class="or"></div>
					  <button class="ui positive button" id="btnsubmit" >Search</button>
					<!-- <input type="submit" class="ui positive button" value="Save"/>-->
					</div>
				</td>
			</tr>
		</table>
	</fieldset>	

</div>
		
</form>
				
				
				
				
				
			