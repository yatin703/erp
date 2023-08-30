<script type="text/javascript">
$(document).ready(function() {
		$("#loading").hide();
		$("#cover").hide();
		//Sub group AJAX for Article no Generation 
		var main_group='<?php echo $this->uri->segment(3); ?>';
		var sub_group='<?php echo $this->uri->segment(4); ?>';
		//$("#main_group").attr('disabled',true);
		//$("#sub_group").attr('disabled',true);
		// if(main_group!='' && sub_group!=''){

		// 	$.ajax({
		// 		type: "POST",
		// 		url: "<?php echo base_url(); ?>" + "index.php/ajax/second_sub_group",
		// 		data: {sub_group : sub_group, main_group : main_group },
		// 		cache: false,
		// 		success: function(html){
		//     		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		// 	        $("#second_sub_group").html(html);
		//     	} 
	 //   		});

		// }
		

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

	$('#color').keyup(function(){
		var txt='';
		var article_name='';
		if($('#color').val()!=''){
			txt = $('#color').val()+' ';
		}
		if($('#finish_type option:selected').val()!=''){
			txt+=$('#finish_type option:selected').val()+' ';
		}
		if($('#print_type option:selected').val()!=''){
			txt+=$('#print_type option:selected').val()+' ';
		}
		if($('#short_code option:selected').val()!=''){
			txt+=$('#short_code option:selected').val()+' ';
		}
		if($('#grade').val()!=''){
			txt+=$('#grade').val()+' ';
		}
		article_name=txt.toUpperCase();
		$('#article_name').html(article_name);
		$('#lang_article_description').val(article_name);
		
	});

	$('#finish_type').change(function(){
		
		var txt='';
		var article_name='';
		if($('#color').val()!=''){
			txt = $('#color').val()+' ';
		}
		if($('#finish_type option:selected').val()!=''){
			txt+=$('#finish_type option:selected').val()+' ';
		}
		if($('#print_type option:selected').val()!=''){
			txt+=$('#print_type option:selected').val()+' ';
		}
		if($('#short_code option:selected').val()!=''){
			txt+=$('#short_code option:selected').val()+' ';
		}
		if($('#grade').val()!=''){
			txt+=$('#grade').val()+' ';
		}

		article_name=txt.toUpperCase();
		$('#article_name').html(article_name);
		$('#lang_article_description').val(article_name);
	});

	$('#print_type').change(function(){
		
		var txt='';
		var article_name='';
		if($('#color').val()!=''){
			txt = $('#color').val()+' ';
		}
		if($('#finish_type option:selected').val()!=''){
			txt+=$('#finish_type option:selected').val()+' ';
		}
		if($('#print_type option:selected').val()!=''){
			txt+=$('#print_type option:selected').val()+' ';
		}
		if($('#short_code option:selected').val()!=''){
			txt+=$('#short_code option:selected').val()+' ';
		}
		if($('#grade').val()!=''){
			txt+=$('#grade').val()+' ';
		}

		article_name=txt.toUpperCase();
		$('#article_name').html(article_name);
		$('#lang_article_description').val(article_name);
		
	});

	$('#short_code').change(function(){
		
		var txt='';
		var article_name='';
		if($('#color').val()!=''){
			txt = $('#color').val()+' ';
		}
		if($('#finish_type option:selected').val()!=''){
			txt+=$('#finish_type option:selected').val()+' ';
		}
		if($('#print_type option:selected').val()!=''){
			txt+=$('#print_type option:selected').val()+' ';
		}
		if($('#short_code option:selected').val()!=''){
			txt+=$('#short_code option:selected').val()+' ';
		}
		if($('#grade').val()!=''){
			txt+=$('#grade').val()+' ';
		}

		article_name=txt.toUpperCase();
		$('#article_name').html(article_name);
		$('#lang_article_description').val(article_name);
		
	});
	$('#grade').keyup(function(){
		var txt='';
		var article_name='';
		if($('#color').val()!=''){
			txt = $('#color').val()+' ';
		}
		if($('#finish_type option:selected').val()!=''){
			txt+=$('#finish_type option:selected').val()+' ';
		}
		if($('#print_type option:selected').val()!=''){
			txt+=$('#print_type option:selected').val()+' ';
		}
		if($('#short_code option:selected').val()!=''){
			txt+=$('#short_code option:selected').val()+' ';
		}
		if($('#grade').val()!=''){
			txt+=$('#grade').val()+' ';
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
										<td class="label">Color  :</td>
										<td><input type="text" name="color" id="color" maxlength="25" size="15" value="<?php echo set_value('color');?>"></td>
									</tr>
									<tr>
										<td class="label">Finish Type  :</td>
										<td><select name="finish_type" id="finish_type"><option value="">--Select Finish Type--</option>
										<?php if($cap_finish_master==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_finish_master as $cap_finish_master_row){
													echo "<option value='".$cap_finish_master_row->cap_finish."'  ".set_select('finish_type',''.$cap_finish_master_row->cap_finish.'').">".strtoupper($cap_finish_master_row->cap_finish)."</option>";
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Print Type  :</td>
										<td><select name="print_type" id="print_type"><option value="">--Select Print Type--</option>
										<?php if($print_types_master==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($print_types_master as $print_types_master_row){
													echo "<option value='".$print_types_master_row->lacquer_type."'  ".set_select('print_type',''.$print_types_master_row->lacquer_type.'').">".strtoupper($print_types_master_row->lacquer_type)."</option>";
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Short Code * :</td>
										<td><select name="short_code" id="short_code"><option value="">--Select Short Code--</option>
										<?php if($article_short_code==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($article_short_code as $article_short_code_row){
													echo "<option value='".$article_short_code_row->short_code."'  ".set_select('short_code',''.$article_short_code_row->short_code.'').">".strtoupper($article_short_code_row->short_code)."</option>";
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Grade * :</td>
										<td><input type="text" name="grade" id="grade" maxlength="25" size="15" value="<?php echo set_value('grade');?>"></td>
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
				
				
				
				
				
			