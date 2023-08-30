<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax_coextube/coex_so_no');?>", {selectFirst: true});

		$("#release_to_order_no").autocomplete("<?php echo base_url('index.php/ajax_coextube/coex_so_no');?>", {selectFirst: true});

		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax_coextube/article_no');?>", {selectFirst: true});

		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_coextube/jobcard_no');?>", {selectFirst: true});
	});
</script>
<style>
	.on-hower {
    background-color: #e4e4e4;
}
</style>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<!-- <h4>WIP search</h4> -->
		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>WIP Search</b></legend>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
				  
					<tr>
						<td class="label" >From Date <span style="color:red;">*</span>  :</td>
						<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',date('Y-m-d'));?>"/ style="width: 100%;""></td>
						<td class="label" >To Date <span style="color:red;">*</span>  :</td>
						<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/ style="width: 100%;"></td>
					</tr>

                    <tr>
						<td class="label">Shift :</td>
						<td>
						    <select style="width:100% !important;" name="shift" id="shift">
							<option value=''>--Shift--</option>
								<?php if($shift_master==FALSE){
									echo "<option value=''>--Setup Required--</option>";}
									else{
									foreach($shift_master as $shift_row){
										echo "<option value='".$shift_row->shift_id."'  ".set_select('shift',''.$shift_row->shift_id.'').">".$shift_row->shift_name."</option>";
									}
								}?>
							</select>
						</td>	

						<td class="label">Machine :</td>
						<td>
						    <select style="width:100% !important;" name="machine" id="machine">
							<option value=''>--Machine--</option>
								<?php if($coex_machine_master==FALSE){
									echo "<option value=''>--Setup Required--</option>";}
									else{
									foreach($coex_machine_master as $machine_row){
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
									}
								}?>
						    </select>
						</td>
					</tr>						
			<tr>						
				    <tr>
						<td class="label">Sleeve Dia :</td>
						    <td>
						    	<select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Dia--</option>
									<?php   if($sleeve_dia==FALSE){
													echo "<option value=''>--Setup Required--</option>";
											}
										else{
											foreach($sleeve_dia as $sleeve_dia_row){
												echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
											}
								}?></select>
						    </td>
						    <td class="label">Length :</td>
						    <td>
						    	<input type="number" name="length" Placeholder="Length" min="10"  max="500" step="0.1"  id="length" size="5" maxlength="5" value="<?php echo set_value('length');?>">
						    </td>
					</tr>
						
					<tr>
						<!--
						<td class="label">Status:</td>
						<td>
							<select name="status" style="width: 100%;">
								<option value=''>--Select Status--</option>
								<option value='0' <?php echo set_select('status',0); ?>>Extrusion WIP</option>
								<option value='1' <?php echo set_select('status',1); ?>>Extrusion QC</option>
								
								<option value='2' <?php echo set_select('status',2); ?>>Extrusion WIP Scrap</option>
							</select>
						</td>-->
						<td class="label">RLSE Order No.:</td>
						<td><input type="text" name="release_to_order_no" id="release_to_order_no" Placeholder="Search Release Order No." value="<?php echo set_value('release_to_order_no');?>" maxlength="20" size="20" style="width: 100%;">
						</td>

						<td class="label">RLSE Jobcard No.:</td>
						<td><input type="text" name="release_jobcard_no" id="release_jobcard_no" Placeholder="Search Release Jobcard No." value="<?php echo set_value('release_jobcard_no');?>" maxlength="20" size="20" style="width: 100%;">
						</td>
					</tr>	
					
				</table>											
				</td>
				<td width="50%">
					<table>
						<tr>
							<td class="label">Order No. :</td>
							<td colspan="3"><input type="text" name="order_no" id="order_no"  Placeholder="Search Order No." value="<?php echo set_value('order_no');?>" maxlength="200" size="60"/></td>
						</tr>
						<tr>
							<td class="label">Article No. :</td>
							<td colspan="3"><input type="text" name="article_no" id="article_no"  Placeholder="Search Article No." value="<?php echo set_value('article_no');?>" maxlength="200" size="60"/></td>
						</tr>						
						<tr>
							<td class="label">Jobcard No. :</td>
							<td colspan="3"><input type="text" name="jobcard_no" id="jobcard_no" Placeholder="Search Jobcard No." value="<?php echo set_value('jobcard_no');?>" maxlength="200" size="60"/></td>
						</tr>
						<tr>
							<td class="label" >RLSE From Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="release_from_date" id="release_from_date" value="<?php echo set_value('release_from_date');?>"/ style="width: 100%;"></td>
							<td class="label" >RLSE To Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="release_to_date" id="release_to_date" value="<?php echo set_value('release_to_date');?>"/ style="width: 100%;"></td>
						</tr>
					</table>
				</td>
											
			</tr>
			<tr>
				<td colspan="2">
					<div class="ui buttons">
						<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
						<div class="or"></div>
						<button class="ui positive button" id="btnsubmit" >Search</button>
						 
					</div>
				</td>
			</tr>
		</table>
	</fieldset>	
	

</div>
		
</form>