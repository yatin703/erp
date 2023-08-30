<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		//$("#consin_adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#ar_invoice_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});

		$("#adr_company_id").live('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/ship_to');?>",data: {adr_company_id : $("#adr_company_id").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#consin_adr_company_id").html(html);
				} 
			});
		});


		$("#check-all").hide();
		$('#check-all').click(function(){
			$("input:checkbox").attr('checked', true);
			$("#uncheck-all").show();
			$("#check-all").hide();
		});
		$('#uncheck-all').click(function(){
			$("#check-all").show();
			$("input:checkbox").attr('checked', false);
			$("#uncheck-all").hide();
		});

	});

</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >

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
										<td class="label">Bill To   :</td>
										<td colspan="3" ><input type="text" name="adr_company_id" id="adr_company_id"  size="60" value="<?php echo set_value('adr_company_id');?>" /></td>
									</tr>
									<tr>
										<td class="label">Ship To   :</td>
										<td colspan="3">
											<select name="consin_adr_company_id" id="consin_adr_company_id">
												<option value=''>--Same As Bill To--</option>
												<?php
													foreach ($ship_to as $ship_to_row){
										           	 	echo "<option value='".$ship_to_row->related_company_id."' ".set_select('consin_adr_company_id',''.$ship_to_row->related_company_id.'').">".$ship_to_row->relate."//".$ship_to_row->related_company_id."//".$ship_to_row->lang_property_name."</option>";
										        	}
										          ?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">Article  :</td>
										<td colspan="3"><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>
									<tr>
										<td class="label">Dia :</td>
										<td colspan="3"><select name="sleeve_dia"><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?>
										</select>
									Length : <input type="text" name="sleeve_length" size="10" value="<?php echo set_value('sleeve_length');?>"></td>
									</tr>
									<tr>
										<td class="label">Print Type :</td>
										<td colspan="3"><select name="print_type"><option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($print_type as $print_type_row){
													echo "<option value='".$print_type_row->lacquer_type."'  ".set_select('print_type',''.$print_type_row->lacquer_type.'').">".$print_type_row->lacquer_type."</option>";
												}
										}?>
										</select>
									</td>
									</tr>
									<tr>
										<td class="label">Order Type :</td>
										<td colspan="3">
											<select name="order_flag">
												<option value=''>--Select Order Type--</option>
											<option value='0' <?php echo set_select('order_flag','0');?>>Coex</option>
											<option value='1' <?php echo set_select('order_flag','1');?>>Spring Tube</option>		
											</select>
										</td>
									</tr>		

									<tr>
										<td class="label">Invoice No  :</td>
										<td colspan="3"><input type="text" name="ar_invoice_no" id="ar_invoice_no" size="17" value="<?php echo set_value('ar_invoice_no');?>"/></td>
									</tr>
									
									
					</table>			
								
				</td>
				<td width="50%">
					<table class="form_table_inner">

								<!--<tr>
										<td class="label">Article  :</td>
										<td colspan="3"><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>
									<tr>
										<td class="label">Invoice No  :</td>
										<td colspan="3"><input type="text" name="ar_invoice_no" id="ar_invoice_no" size="17" value="<?php echo set_value('ar_invoice_no');?>"/></td>
									</tr>
								-->									
								<!--<tr>
										<td class="label"> Invoice Type  :</td>
										<td colspan="3">
											<select name="for_export" id="for_export" >

												<option value="">--Please Select--</option>
												<option value="2" <?php echo set_select('for_export','2');?>>Local</option>
												<option value="1" <?php echo set_select('for_export','1');?> >Export</option>
												
											</select>

										</td>
									</tr>
								-->

									<tr>
										<td class="label"> Invoice Types  :</td>
										<td colspan="3">
											<a id="check-all" class="submit-green" href="javascript:void(0);">Check all</a>
											<a id="uncheck-all" class="submit-green" href="javascript:void(0);">Uncheck all</a>
											<br/>
										<?php
											$check_box="";
											foreach ($invoice_types_master_lang as $row) {

												$check_box="<input type='checkbox' name='inv_type[]' value='".$row->inv_type_id."'";
												if(!empty($this->input->post('inv_type[]'))){ 
													$check_box.= in_array($row->inv_type_id,$this->input->post('inv_type[]'),TRUE)?"checked" :"";
												 }
												else{ 
													$check_box.="checked";
												} 
												$check_box.=">".$row->lang_inv_type."</br>";
												echo $check_box;		
											}
																						
										?>

										</td>
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
				
				
				
				
				
			