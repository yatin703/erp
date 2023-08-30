<script type="text/javascript">
$(document).ready(function() {
		$("#loading").hide();
		$("#cover").hide();
		

	$("#main_group").change(function(event) {
   var main_group = $('#main_group').val();
   $("#loading").show();
		$("#cover").show();
		$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/sub_group",data: {main_group : $('#main_group').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#sub_group").html(html);
       
    } 
    });
   });

		$("#sub_group").change(function(event) {
   var sub_group = $('#sub_group').val();
   $("#loading").show();
			$("#cover").show();
		$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/second_sub_group",data: {sub_group : $('#sub_group').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#second_sub_group").html(html);
    } 
    });
   });

		$("#main_group").change(function(event) {
   var main_group = $('#main_group').val();
   $("#loading").show();
		$("#cover").show();
		$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/main_group_article",data: {main_group : $('#main_group').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#article_no").html(html);
    } 
    });
   });


		$("#sub_group").change(function(event) {
   var main_group = $('#main_group').val();
   var sub_group = $('#sub_group').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/sub_group_article",data: {sub_group : $('#sub_group').val(),main_group : $('#main_group').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#article_no").html(html);
    } 
    });
   });


		$("#second_sub_group").change(function(event) {

   var main_group = $('#main_group').val();
   var sub_group = $('#sub_group').val();
   var second_sub_group = $('#second_sub_group').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/second_sub_group_article",data: {second_sub_group : $('#second_sub_group').val(),sub_group : $('#sub_group').val(),main_group : $('#main_group').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#article_no").html(html);
    } 
    });
   });


		$("#lot_wise").click(function () {
			if ($(this).is(":checked")) {
				$(".lot_wise_details").css('display','block');
				$(".lot_wise_details").show();
			} else {
				$(".lot_wise_details").hide();
			}

		});

	// Article Description-----------------------

	$('#machine_name').change(function(){
		var txt='';
		var article_name='';
		if($('#machine_name option:selected').val()!=''){
			txt=$('#machine_name option:selected').val()+' ';
		}	
		if($('#manufacturer').val()!=''){
			txt+=$('#manufacturer').val()+' ';
		}
		if($('#spare_name').val()!=''){
			txt+=$('#spare_name').val()+' ';
		}
		if($('#part_no').val()!=''){
			txt+=$('#part_no').val()+' ';
		}
		article_name=txt.toUpperCase();
		$('#article_name').html(article_name);
		$('#lang_article_description').val(article_name);
		
	});
	

	
	$('#manufacturer').keyup(function(){
		var txt='';
		var article_name='';
		if($('#machine_name option:selected').val()!=''){
			txt=$('#machine_name option:selected').val()+' ';
		}	
		if($('#manufacturer').val()!=''){
			txt+=$('#manufacturer').val()+' ';
		}
		if($('#spare_name').val()!=''){
			txt+=$('#spare_name').val()+' ';
		}
		if($('#part_no').val()!=''){
			txt+=$('#part_no').val()+' ';
		}
		article_name=txt.toUpperCase();
		$('#article_name').html(article_name);
		$('#lang_article_description').val(article_name);
		
	});


	$('#spare_name').keyup(function(){
		var txt='';
		var article_name='';
		if($('#machine_name option:selected').val()!=''){
			txt=$('#machine_name option:selected').val()+' ';
		}	
		if($('#manufacturer').val()!=''){
			txt+=$('#manufacturer').val()+' ';
		}
		if($('#spare_name').val()!=''){
			txt+=$('#spare_name').val()+' ';
		}
		if($('#part_no').val()!=''){
			txt+=$('#part_no').val()+' ';
		}
		article_name=txt.toUpperCase();
		$('#article_name').html(article_name);
		$('#lang_article_description').val(article_name);
		
	});
	$('#part_no').keyup(function(){
		var txt='';
		var article_name='';
		if($('#machine_name option:selected').val()!=''){
			txt=$('#machine_name option:selected').val()+' ';
		}	
		if($('#manufacturer').val()!=''){
			txt+=$('#manufacturer').val()+' ';
		}
		if($('#spare_name').val()!=''){
			txt+=$('#spare_name').val()+' ';
		}
		if($('#part_no').val()!=''){
			txt+=$('#part_no').val()+' ';
		}
		article_name=txt.toUpperCase();
		$('#article_name').html(article_name);
		$('#lang_article_description').val(article_name);
		
	});

});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_article');?>" method="POST" >
	<div class="form_design ">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									<tr>
										<td class="label">Main Group * :</td>
										<td><select name="main_group" id="main_group"><option value="">--Select Main Group--</option>
										<?php if($main_group==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($main_group as $main_group_row){
													$selected=($main_group_row->main_group_id==$this->uri->segment(3)?'selected':'');
													
													echo "<option value='".$main_group_row->main_group_id."'  ".set_select('main_group',''.$main_group_row->main_group_id.'')." ".$selected.">".strtoupper($main_group_row->lang_main_group_desc)."-".$main_group_row->main_group_id."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Sub Group :</td>
										<td><select name="sub_group" id="sub_group"><option value="">--Select Sub Group--</option>
										<?php if($sub_group==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sub_group as $sub_group_row){
													//$selected=($sub_group_row->article_group_id==$this->uri->segment(4)?'selected':'');

													echo "<option value='".$sub_group_row->article_group_id."'  ".set_select('sub_group',''.$sub_group_row->article_group_id.'')."".">".strtoupper($sub_group_row->sub_group)."-".$sub_group_row->article_group_id."</option>";
												}
										}?>
										</select></td>
									</tr>
									
									<tr>
										<td class="label">Second Sub Group  :</td>
										<td><select name="second_sub_group" id="second_sub_group"><option value="">--Select Second Sub Group--</option>
										<?php if($second_sub_group==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($second_sub_group as $second_sub_group_row){
													echo "<option value='".$second_sub_group_row->sub_sub_grp_id."'  ".set_select('second_sub_group',''.$second_sub_group_row->sub_sub_grp_id.'').">".strtoupper($second_sub_group_row->second_sub_group)."</option>";
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Article No * :</td>
										<td><select name="article_no" id="article_no">
											<?php if($number!=''){
												echo '<option value="'.$number.'">'.$number.'</option>';
											}?>
														
										</select></td>
									</tr>
									<tr>
										<td class="label">Machine Name * :</td>
										<td><select name="machine_name" id="machine_name"><option value="">--Select Machine--</option>
										<?php if($machines_master==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($machines_master as $machines_master_row){
													echo "<option value='".$machines_master_row->machine_name."'  ".set_select('machine_name',''.$machines_master_row->machine_name.'').">".strtoupper($machines_master_row->machine_name)."</option>";
												}
										}?>
										</select></td>
									</tr>
									
									<tr>
										<td class="label">Manufacturer * :</td>
										<td><input type="text" name="manufacturer" id="manufacturer" maxlength="25" size="20" value="<?php echo set_value('manufacturer');?>"></td>
									</tr>
									<tr>
										<td class="label">Spare Name * :</td>
										<td><input type="text" name="spare_name" id="spare_name" maxlength="25" size="20" value="<?php echo set_value('spare_name');?>"></td>
									</tr>
									<tr>
										<td class="label">Part No. * :</td>
										<td><input type="text" name="part_no" id="part_no" maxlength="15" size="20" value="<?php echo set_value('part_no');?>"></td>
									</tr>
									<tr>
										<td class="label">Article Name * :</td>
										<td><span name="article_name" id="article_name" style="color:green;font-weight: bold"><?php echo $this->input->post('lang_article_description');?></span>
											<input type="hidden" name="lang_article_description" id="lang_article_description" value="<?php echo set_value('lang_article_description');?>"/>
										</td>
									</tr>			
									
					</table>				
				</td>
				<td>
					<table class="form_table_inner">
									<tr>
										<td class="label">HSN/SAC * :</td>
										<td><select name="tariff"><option value="">--Select Tariff--</option>
										<?php if($tariff==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($tariff as $tariff_row){
													echo "<option value='".$tariff_row->erm_id."'  ".set_select('tariff',''.$tariff_row->erm_id.'').">".strtoupper($tariff_row->tariff_heading)."-".$tariff_row->cetsh_no."</option>";
												}
										}?>
										</select></td>
									</tr>									
									<tr>
										<td class="label">UOM * :</td>
										<td><select name="uom"><option value="">--Select UOM--</option>
										<?php if($uom==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($uom as $uom_row){
													echo "<option value='".$uom_row->uom_id."'  ".set_select('uom',''.$uom_row->uom_id.'').">".strtoupper($uom_row->lang_uom_desc)."</option>";
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Opening Stock :</td>
										<td><input type="text" name="opening_stock" maxlength="10" size="10" value="<?php echo set_value('opening_stock');?>"></td>
									</tr>
									<tr>
										<td class="label">Opening Stock Valuation :</td>
										<td><input type="text" name="opening_stock_valuation" maxlength="10" size="10" value="<?php echo set_value('opening_stock_valuation');?>"></td>
									</tr>									
									<tr>
										<td class="label">Lot Wise :</td>
										<td><input type="checkbox" name="lot_wise" id="lot_wise" value="1" <?php echo set_checkbox('lot_wise',1);?></td>
									</tr>
									<tr class="lot_wise_details" style="display: none;">
										<td class="label">Standard Lot Size :</td>
										<td><input type="textbox" name="std_lot_size" value="<?php echo set_value('std_lot_size');?>"></td>
									</tr>
									<tr class="lot_wise_details" style="display: none;">
										<td class="label">Expiary Days:</td>
										<td><input type="textbox" name="expiary_period" maxlength="10" size="10" value="<?php echo set_value('expiary_period');?>"></td>
									</tr>
									<tr>
										<td class="label">QC Check :</td>
										<td><input type="checkbox" name="qc_flag" value="1" <?php echo set_checkbox('qc_flag',1);?> /></td>
									</tr>
									<tr>
										<td class="label">Imported :</td>
										<td><input type="checkbox" name="imported_flag" value="1" <?php echo set_checkbox('imported_flag',1);?> /></td>
									</tr>
									<tr>
										<td class="label">For Specification :</td>
										<td><input type="checkbox" name="spec_item_flag" value="1" <?php echo set_checkbox('spec_item_flag',1);?> /></td>
									</tr>
					</table>
				</td>

				
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			