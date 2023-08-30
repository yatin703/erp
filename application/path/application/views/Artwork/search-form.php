<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		$("#article_no").live('keyup',function() {
   var article_no = $('#article_no').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/version_no",data: {article_no : $('#article_no').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#version_no").html(html);
    } 
    });
   });
	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" id="artwork">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
									<tr>
										<td class="label" width="25%">From Date <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',date('Y-m-d'));?>"/></td>
										<td class="label" width="25%">To Date <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
									<tr>
										<td class="label">Customer  :</td>
										<td colspan="3" ><input type="text" name="adr_company_id" id="adr_company_id"  size="60" value="<?php echo set_value('adr_company_id');?>" /></td>
									</tr>

									<tr>
										<td class="label">Article   :</td>
										<td colspan="3"><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>

									<tr>
										<td class="label">Artwork No  :</td>
										<td colspan="3"><input type="text" name="artwork_no"   size="10" value="<?php echo set_value('artwork_no');?>"  /></td>
									</tr>
										
									<tr>
										<td class="label">Version No  :</td>
										<td colspan="3"><input type="text" name="version_no"   size="10" value="<?php echo set_value('version_no');?>" /></td>
									</tr>
									<tr>
										<td class="label">Sleeve Length  :</td>
										<td colspan="3"><input type="text" name="sleeve_length"   size="10" value="<?php echo set_value('sleeve_length');?>" /></td>
									</tr>
									<tr>
										<td class="label">Sleeve Color  :</td>
										<td colspan="3"><input type="text" name="sleeve_color"   size="10" value="<?php echo set_value('sleeve_color');?>" /></td>
									</tr>
									<tr>
										<td class="label">Approval Status   :</td>
										<td colspan="3"><select name="final_approval_flag">
											<option value="">--Please Select--</option>
											<option value="1" <?php echo set_select('final_approval_flag',1);?>>Approved</option>
											<option value="0" <?php echo set_select('final_approval_flag',0);?>>Not Approved</option>
										</select></td>
									</tr>
									
				</table>			
				</td>

				<td width="50%">
					<table class="form_table_inner">

									
									<tr>
										<td class="label">Sleeve Diameter   :</td>
										<td><select name="sleeve_dia" id="sleeve_diameter">
											<option value=''>--Please Select--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Sleeve Dia Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $row){
													
													echo '<option value="'.$row->sleeve_diameter.'"'.set_select('sleeve_dia',''.$row->sleeve_diameter.'').' >'.$row->sleeve_diameter.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Print Type   :</td>
										<td><select name="print_type" id="print_type">
											<option value=''>--Please Select--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Print Type Setup Required--</option>";}
											else{
												foreach($print_type as $row){
													
													echo '<option value="'.$row->lacquer_type.'"'.set_select('print_type',''.$row->lacquer_type.'').' >'.$row->lacquer_type.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Print Upto Neck   :</td>
										<td><select name="print_upto_neck" id="print_upto_neck">
											<option value="--">--Please Select--</option>
											<option value="YES" <?php echo set_select('print_upto_neck','YES');?>>Yes</option>
											<option value=" " <?php echo set_select('print_upto_neck',' ');?>>No</option></td>
									</tr>
									<tr>
										<td class="label">Foil   :</td>
										<td><select name="hot_foil" id="hot_foil">
											<option value="--">--Please Select--</option>
											<option value="YES" <?php echo set_select('hot_foil','YES');?>>Yes</option>
											<option value=" " <?php echo set_select('hot_foil',' ');?>>No</option></td>
									</tr>

									<tr>
										<td class="label">Lacquer Type  :</td>
										<td><input type="text" name="lacquer_type"   size="10" value="<?php echo set_value('lacquer_type');?>" /></td>
									</tr>
									<tr>
										<td class="label"> Non Lacquer Area  :</td>
										<td><input type="text" name="non_lacquer_area"   size="10" value="<?php echo set_value('non_lacquer_area');?>" /></td>
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
	  <button class="ui positive button">Search</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			