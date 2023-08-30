<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();


		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});

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
		<legend><b>QC Search</b></legend>
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
							<td class="label">Dia <span style="color:red;">*</span> :</td>
							<td><select name="sleeve_diameter" id="sleeve_diameter"><option value=''>----Select Dia-----</option>
							<?php if($sleeve_diameter_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($sleeve_diameter_master as $dia_row){
										 
										echo "<option value='".$dia_row->sleeve_diameter."'  ".set_select('sleeve_diameter',''.$dia_row->sleeve_diameter.'').">".$dia_row->sleeve_diameter."</option>";
									}
							}?>
							</select>
							</td>
							<td class="label">Status:</td>
							<td><select name="status">
									<option value=''>--Select Status--</option>
									<option value='1' <?php echo set_select('status',1); ?>>Released</option>
									<option value='0' <?php echo set_select('status',0); ?>>Hold</option>
								</select>
							</td>
							
						</tr>
						 	

					</table>			
								
				</td>
				<td width="50%">
					<table>

						<tr>
							<td class="label">Customer :</td>
							<td colspan="3"><input type="text" name="customer" id="customer"  value="<?php echo set_value('customer');?>" maxlength="200" size="60"/></td>
							
						</tr
						
						<tr>
							<td class="label">Article No. :</td>
							<td colspan="3"><input type="text" name="article_no" id="article_no"  value="<?php echo set_value('article_no');?>" maxlength="200" size="60"/></td>
							
						</tr>
						<tr>
							<td class="label">Film Code :</td>
							<td colspan="3"><input type="text" name="film_code" id="film_code"  value="<?php echo set_value('film_code');?>" maxlength="500" size="60"/></td>
							
						</tr>						

					</table>
				</td>
											
			</tr>
			<tr>
				<td  colspan="2">
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
				
				
				
				
				
			