<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<style type="text/css">
		/*body{
			margin-top: 100px;
			font-family: 'Trebuchet MS', serif;
			line-height: 1.6
		}*/
		.container{
			/*width: 800px;*/
			margin: 0 auto;
		}
		ul.tabs{
			margin: 0px;
			padding: 0px;
			list-style: none;
		}
		ul.tabs li{
			background: none;
			/*color: #222;*/
			color:#4183c4;
			display: inline-block;
			padding: 10px 15px;
			cursor: pointer;
			border-right: 1px solid #8cacbb;
			border-left: 1px solid #8cacbb; 
			border-top: 1px solid #8cacbb;
			border-bottom: 1px solid #8cacbb;   
		}

		ul.tabs li.current{
			/*background: #ededed;*/
			background: #dee7ec;
			/*color: #222;*/
			color:#4183c4;
		}

		.tab-content{
			display: none;
			/*background: #ededed;*/
			background: #ededed;
			padding: 15px;
		}

		.tab-content.current{
			display: inherit;
			/*width:100%;*/
		}
		textarea{
			width:375px;
			height:60px;
		}
</style>
<script type="text/javascript">
	$(document).ready(function() {

		$("#loading").hide(); $("#cover").hide();

		$('ul.tabs li').click(function(){

			var tab_id = $(this).attr('data-tab');

			$('ul.tabs li').removeClass('current');
			$('.tab-content').removeClass('current');

			$(this).addClass('current');
			$("#"+tab_id).addClass('current');
		});


		// ------------------------------------------

		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_so_no');?>", {selectFirst: true});

		$("#abg1_ink_id_1").autocomplete("<?php echo base_url('index.php/ajax_springtube/springtube_ink_autocomplete');?>", {selectFirst: true});
		$("#abg1_ink_id_2").autocomplete("<?php echo base_url('index.php/ajax_springtube/springtube_ink_autocomplete');?>", {selectFirst: true});
		$("#abg1_ink_id_3").autocomplete("<?php echo base_url('index.php/ajax_springtube/springtube_ink_autocomplete');?>", {selectFirst: true});
		$("#abg1_ink_id_4").autocomplete("<?php echo base_url('index.php/ajax_springtube/springtube_ink_autocomplete');?>", {selectFirst: true});

		$("#abg2_ink_id_1").autocomplete("<?php echo base_url('index.php/ajax_springtube/springtube_ink_autocomplete');?>", {selectFirst: true});
		$("#abg2_ink_id_2").autocomplete("<?php echo base_url('index.php/ajax_springtube/springtube_ink_autocomplete');?>", {selectFirst: true});



		$("#order_no").bind('blur',function() {
			$("#loading").hide(); $("#cover").hide();
		   var order_no = $('#order_no').val();
		   var order_no_length=order_no.length;

		   		$("#article_no").html("<option value=''>---Please Select---</option>");
			   	$("#loading").show();
						$("#cover").show();
						$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			   $.ajax({type: "POST",url: "<?php echo base_url("index.php/ajax_springtube/spsm_spsp_no"); ?>",data: {order_no : $('#order_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
			       $("#article_no").html(html);
			    	} 
			    });

   		});

   		$("#article_no").change(function() {
   			$("#loading").hide(); $("#cover").hide();
   			$("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');		    
	   		var article_no = $(this).find(':selected').val();
	    	//var selectedText = $(this).find(':selected').text();
	    	$.ajax({type: "POST",url: "<?php echo base_url("index.php/ajax_springtube/spring_printing_jobcards"); ?>",data: {article_no : article_no,order_no : $('#order_no').val() },cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
			       $("#jobcard_no").html(html);
			    } 
			});		   
		    
		});

		$("#jobcard_no").change(function() {

			var jobcard_no = $('#jobcard_no').val();
			//alert($('#jobcard_no').val());
			if(jobcard_no!=''){		

			   $.ajax({

				   	type: "POST",
				   	url: "<?php echo base_url("index.php/ajax_springtube/get_order_details_for_printing_jobsetup");?>",
				   	data: {jobcard_no : $('#jobcard_no').val()},
				   	cache: false,
				   	success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);

				    		if(html!=''){
				    			$("#order_details").html(html);			       			 
				    		}else{
				    			$("#order_details").html('');
				    		}
		 
				    },
					beforeSend: function(){
									$("#loading").show();
									$("#cover").show();
									$('#loading').html('<img src="images/loading.gif"> Loading...');	
									
					},
					complete: function(){
					 				$("#loading").hide(); $("#cover").hide();
									
									
					} 
			    });//AJAX Closed

		   }else{
		   		$("#order_details").html('');
		   } 		   

   		});

   		//---------------------
   		var jobcard_no = $('#jobcard_no').val();
			//alert($('#jobcard_no').val());
			if(jobcard_no!=''){		

			   $.ajax({

				   	type: "POST",
				   	url: "<?php echo base_url("index.php/ajax_springtube/get_order_details_for_printing_jobsetup");?>",
				   	data: {jobcard_no : $('#jobcard_no').val()},
				   	cache: false,
				   	success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);

				    		if(html!=''){
				    			$("#order_details").html(html);			       			 
				    		}else{
				    			$("#order_details").html('');
				    		}
		 
				    },
					beforeSend: function(){
									$("#loading").show();
									$("#cover").show();
									$('#loading').html('<img src="images/loading.gif"> Loading...');	
									
					},
					complete: function(){
					 				$("#loading").hide(); $("#cover").hide();
									
									
					} 
			    });//AJAX Closed

		   }else{
		   		$("#order_details").html('');
		   }



   		//---------------------

   		$("#tr_abg2_extended_uv_power_2").hide();   		
		$("#abg2_extended_uv_power_2").attr("required",false);

		$("#tr_abg2_extended_uv_speed_2").hide();   		
		$("#abg2_extended_uv_speed_2").attr("required",false);

		$("#tr_abg2_extended_uv_hours_2").hide();   		
		$("#abg2_extended_uv_hours_2").attr("required",false);


		$(".radio").click(function() {
   			 
   			if($(this).val()=='YES'){

   				$("#tr_abg2_extended_uv_power_2").show();   		
				$("#abg2_extended_uv_power_2").attr("required",true);

				$("#tr_abg2_extended_uv_speed_2").show();   		
				$("#abg2_extended_uv_speed_2").attr("required",true);

				$("#tr_abg2_extended_uv_hours_2").show();   		
				$("#abg2_extended_uv_hours_2").attr("required",true);

				$("#tr_abg2_uv_power_2").hide();   		
				$("#abg2_uv_power_2").attr("required",false);

				$("#tr_abg2_uv_speed_2").hide();   		
				$("#abg2_uv_speed_2").attr("required",false);

				$("#tr_abg2_uv_hours_2").hide();   		
				$("#abg2_uv_hours_2").attr("required",false);

   			}
   			else{

   				$("#tr_abg2_uv_power_2").show();   		
				$("#abg2_uv_power_2").attr("required",true);

				$("#tr_abg2_uv_speed_2").show();   		
				$("#abg2_uv_speed_2").attr("required",true);

				$("#tr_abg2_uv_hours_2").show();   		
				$("#abg2_uv_hours_2").attr("required",true);

   				$("#tr_abg2_extended_uv_power_2").hide();   		
				$("#abg2_extended_uv_power_2").attr("required",false);

				$("#tr_abg2_extended_uv_speed_2").hide();   		
				$("#abg2_extended_uv_speed_2").attr("required",false);

				$("#tr_abg2_extended_uv_hours_2").hide();   		
				$("#abg2_extended_uv_hours_2").attr("required",false);

   			} 


	   	});

	   	$("#jobcard_no").change(function() {

			var jobcard_no = $('#jobcard_no').val();
			//alert($('#jobcard_no').val());
			if(jobcard_no!=''){		

			   $.ajax({

				   	type: "POST",
				   	url: "<?php echo base_url();?>/index.php/ajax_springtube/get_foils_for_printing_jobsetup",
				   	data: {jobcard_no : $('#jobcard_no').val()},
				   	cache: false,
				   	success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);

				    var obj=JSON.parse(html);
				    if(obj.cold_foil_1!=''){
				    	$('#cold_foil_1').val(obj.cold_foil_1);
				    	$('#cold_foil_1_width').val(obj.cold_foil_1_width);
				    	$('#cold_foil_1_length').val(obj.total_meters);
				    	$('#cold_foil_1_area').val(obj.cold_foil_1_area);
				    }else{
				    	$('#cold_foil_1').val('');
				    	$('#cold_foil_1_width').val('');
				    	$('#cold_foil_1_length').val('');
				    	$('#cold_foil_1_area').val('');

				    }
				    if(obj.cold_foil_2!=''){
				    	$('#cold_foil_2').val(obj.cold_foil_2);
				    	$('#cold_foil_2_width').val(obj.cold_foil_2_width);
				    	$('#cold_foil_2_length').val(obj.total_meters);
				    	$('#cold_foil_2_area').val(obj.cold_foil_2_area);
				    }else{

				    	$('#cold_foil_2').val('');
				    	$('#cold_foil_2_width').val('');
				    	$('#cold_foil_2_length').val('');
				    	$('#cold_foil_2_area').val('');
				    }
				    			    
		 
				    },
					beforeSend: function(){
									$("#loading").show();
									$("#cover").show();
									$('#loading').html('<img src="images/loading.gif"> Loading...');	
									
					},
					complete: function(){
					 				$("#loading").hide(); $("#cover").hide();
									
									
					} 
			    });//AJAX Closed

		   }else{
		   		$("#order_details").html('');
		   } 		   

   		});
   		
		$("#cold_foil_1_length").bind('keyup',function() {

			var cold_foil_1_width=Number($('#cold_foil_1_width').val());
			var cold_foil_1_length=Number($("#cold_foil_1_length").val());
			if(!isNaN(cold_foil_1_width) && !isNaN(cold_foil_1_length)){
				var cold_foil_1_area=(cold_foil_1_width/1000)*cold_foil_1_length;
				cold_foil_1_area=cold_foil_1_area>0?cold_foil_1_area.toFixed(2):0;
				$('#cold_foil_1_area').val(cold_foil_1_area);
			}else{
				$('#cold_foil_1_area').val('');

			}			

		});

		$("#cold_foil_2_length").bind('keyup',function() {
			var cold_foil_2_width=Number($('#cold_foil_2_width').val());
			var cold_foil_2_length=Number($("#cold_foil_2_length").val());
			//alert(cold_foil_2_width);
			//alert(cold_foil_2_length);
			if(!isNaN(cold_foil_2_width) && !isNaN(cold_foil_2_length)){
				var cold_foil_2_area=(cold_foil_2_width/1000)*cold_foil_2_length;
				cold_foil_2_area=cold_foil_2_area>0?cold_foil_2_area.toFixed(2):0;
				$('#cold_foil_2_area').val(cold_foil_2_area);
			}else{
				$('#cold_foil_2_area').val('');
			}

		});








	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_copy');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<?php foreach ($springtube_printing_jobsetup_master as $master_row):?>

		<?php
			$ink_1='';
			$ink_1_desc='';
			if($master_row->abg1_ink_id_1!='' || $master_row->abg1_ink_id_1!=0){

				$ink_1_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$master_row->abg1_ink_id_1);
				foreach ($ink_1_result as $ink_1_row) {
					$ink_1=$ink_1_row->ink_id;
					$ink_1_desc=$ink_1_row->ink_desc;
				}

			}

			$ink_2='';
			$ink_2_desc='';
			if($master_row->abg1_ink_id_2!='' || $master_row->abg1_ink_id_2!=0){

				$ink_2_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$master_row->abg1_ink_id_2);
				foreach ($ink_2_result as $ink_2_row) {
					 $ink_2=$ink_2_row->ink_id;
					$ink_2_desc=$ink_2_row->ink_desc;
				}

			}

			$ink_3='';
			$ink_3_desc='';
			if($master_row->abg1_ink_id_3!='' || $master_row->abg1_ink_id_3!=0){

				$ink_3_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$master_row->abg1_ink_id_3);
				foreach ($ink_3_result as $ink_3_row) {
					 $ink_3=$ink_3_row->ink_id;
					$ink_3_desc=$ink_3_row->ink_desc;
				}

			}


			$ink_4='';
			$ink_4_desc='';
			if($master_row->abg1_ink_id_4!='' || $master_row->abg1_ink_id_4!=0){

				$ink_4_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$master_row->abg1_ink_id_4);
				foreach ($ink_4_result as $ink_4_row) {
					 $ink_4=$ink_4_row->ink_id;
					$ink_4_desc=$ink_4_row->ink_desc;
				}

			}


			$ink_5='';
			$ink_5_desc='';
			if($master_row->abg2_ink_id_1!='' || $master_row->abg2_ink_id_1!=0){

				$ink_5_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$master_row->abg2_ink_id_1);
				foreach ($ink_5_result as $ink_5_row) {
					$ink_5=$ink_5_row->ink_id;
					$ink_5_desc=$ink_5_row->ink_desc;
				}

			}

			$ink_6='';
			$ink_6_desc='';
			if($master_row->abg2_ink_id_2!='' || $master_row->abg2_ink_id_2!=0){

				$ink_6_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$master_row->abg2_ink_id_2);
				foreach ($ink_6_result as $ink_6_row) {
					 $ink_6=$ink_6_row->ink_id;
					$ink_6_desc=$ink_6_row->ink_desc;
				}

			}




		?>	

		<table class="form_table_design">
			<tr>
				<td>		 
					<div class="container">

						<ul class="tabs">
							<li class="tab-link current" data-tab="tab-1">ORDER DETAILS</li>
							<li class="tab-link" data-tab="tab-2">ABG 1</li>
							<li class="tab-link" data-tab="tab-3">DURST</li>
							<li class="tab-link" data-tab="tab-4">ABG 2</li>
							<li class="tab-link" data-tab="tab-5">FOIL</li>
						</ul>								
						<!-- TAB ORDER DETAILS -->
						<div id="tab-1" class="tab-content current">

							<table class="form_table_inner">
								<tr>
									<td width="100%">

										<table class="form_table_inner" >
											<tr>
												<td class="label">Order No. <span style="color:red;">*</span> :</td>
												<td>
													<input type="hidden" name="job_id" value="<?php echo set_value('job_id',$master_row->job_id);?>">
													<input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no');?>" required placeholder="Order No"/></td>
												
											</tr>
											<tr>
												<td class="label">SPSM/SPSP No.  <span style="color:red;">*</span> :</td>
												<td>
													<select name="article_no" id="article_no" required >
													<option value="">----Select Article No.---</option>	
													</select>
												</td>
											</tr>
											<tr>
												<td class="label">Jobcard No. <span style="color:red;">*</span> :</td>
												<td><select name="jobcard_no" id="jobcard_no" required >
														<option value="">----Select Jobcard No.--</option>	
													</select>
												</td>
												 
											</tr>
											<tr>
												<td class="label">Approval Authority :</td>
												<td><select name="approval_authority">
													<option value=''>----Select Authority----</option>
													<?php 
														foreach ($approval_authority as $approval_authority_row) {
														echo "<option value='".$approval_authority_row->employee_id."' ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
														}
													?>
													</select></td>
											</tr>
											<tr>
												<td colspan="2"><div id="order_details"></div></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>		

						</div>

						<!-- TAB ABG 1 -->

						<div id="tab-2" class="tab-content">

							<table class="form_table_inner">
								<tr>
									<td width="50%">

										<table class="form_table_inner">
											<tr><td class="label" colspan="2"><b>ABG 1 - FLEXO UNIT - 1</b></td></tr>							
											<tr>
												<td class="label">Carona. <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_carona_1" id="abg1_carona_1" min="0" max="200" step="1"  value="<?php echo set_value('abg1_carona_1',$master_row->abg1_carona_1);?>" /></td>
												
											</tr>
											<tr>
												<td class="label">Color/Ink Name <span style="color:red;">*</span> :</td>
												<td>
												<input type="text" name="abg1_ink_id_1" id="abg1_ink_id_1" value="<?php echo set_value('abg1_ink_id_1',($ink_1!=''?$ink_1_desc."//".$ink_1:''));?>" size="50"/>	 
												</td>
											</tr>
											<tr>
												<td class="label">Anilox <span style="color:red;">*</span> :</td>
												<td><select name="abg1_anilox_1" id="abg1_anilox_1">					
														<option value="">--Please Select--</option>
														<?php if($springtube_anilox_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_anilox_master as $row) {
																$selected=($master_row->abg1_anilox_1==$row->anilox_id?'selected':'');
																echo'<option value="'.$row->anilox_id.'" '.set_select('abg1_anilox_1',$row->abg1_anilox_1).$selected.'>'.$row->anilox_lpi.'</option>';
															}
														}?>
													</select>
												</td>
												 
											</tr>
											<tr>
												<td class="label">Applying Method<span style="color:red;">*</span> :</td>
												<td><select name="abg1_applying_method_1" id="abg1_applying_method_1">
													<option value="">--Please Select--</option>
													<option value="1" <?php echo set_select('abg1_applying_method_1','1');?> <?php echo ($master_row->abg1_applying_method_1==1?"selected":"");?>>Plate Through</option>
													<option value="2" <?php echo set_select('abg1_applying_method_1','2');?> <?php echo ($master_row->abg1_applying_method_1==2?"selected":"");?>>Roller Through</option>
												</select>
											</tr>

											<tr>
												<td class="label">Cylinder Teeth<span style="color:red;">*</span> :</td>
												<td><select name="abg1_cylinder_teeth_1" id="abg1_cylinder_teeth_1">					
														<option value="">--Please Select--</option>
														<?php if($springtube_cylinder_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_cylinder_master as $springtube_cylinder_master_row) {

																$selected=($master_row->abg1_cylinder_teeth_1==$springtube_cylinder_master_row->cylinder_id?'selected':'');

																echo'<option value="'.$springtube_cylinder_master_row->cylinder_id.'" '.set_select('abg1_cylinder_teeth_1',$springtube_cylinder_master_row->cylinder_id).$selected.'>'.$springtube_cylinder_master_row->teeth.'</option>';
															}
														}?>
													</select>
												</td>											 
											</tr>
											<tr>
												<td class="label">Semi/Full Rotary<span style="color:red;">*</span> :</td>
												<td><select name="abg1_rotary_1" id="abg1_rotary_1">
													<option value="">--Please Select--</option>
													<option value="1" <?php echo set_select('abg1_rotary_1','1'); ?> <?php echo ($master_row->abg1_rotary_1==1?"selected":"");?> >[SR]-Semi Rotary</option>
													<option value="2" <?php echo set_select('abg1_rotary_1','2'); ?> <?php echo ($master_row->abg1_rotary_1==2?"selected":"");?> >[FR]-Full Rotary </option>
												</select>
											</tr>

											<tr>
												<td class="label">UV Power <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_power_1" id="abg1_uv_power_1" min="5" max="100" step="1"  size="20" value="<?php echo set_value('abg1_uv_power_1',$master_row->abg1_uv_power_1);?>" /></td>
												
											</tr>
											<tr>
												<td class="label">UV Speed <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_speed_1" id="abg1_uv_speed_1" min="5" max="100" step="1" size="20" value="<?php echo set_value('abg1_uv_speed_1',$master_row->abg1_uv_speed_1);?>" /></td>
												
											</tr>
											<tr>
												<td class="label">UV Lamp Hours <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_hours_1" id="abg1_uv_hours_1" min="1" max="1500" step="1"  size="20" value="<?php echo set_value('abg1_uv_hours_1');?>" /></td>
												
											</tr>
											<tr>
												<td class="label">Total Ink Consumption (Grams) <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_ink_usage_1" id="abg1_ink_usage_1" min="1" max="100000"  size="20" step="any" value="<?php echo set_value('abg1_ink_usage_1');?>" /></td>
												
											</tr>
											<tr>
												<td class="label">Comment  <span style="color:red;">*</span> :</td>
												<td><textarea name="abg1_unit_1_comment" value="<?php echo set_value('abg1_unit_1_comment');?>"><?php echo $master_row->abg1_unit_1_comment;?></textarea></td>
											</tr>
										</table>
									</td>
									<td width="50%">
										<table class="form_table_inner">
											<tr>
												<td class="label" colspan="2"><b>ABG 1 - FLEXO UNIT - 2</b></td>
											</tr>
											<tr><td>&nbsp;</td></tr>
											<tr>
												<td class="label">Color/Ink Name <span style="color:red;">*</span> :</td>
												<td>
													<input type="text" name="abg1_ink_id_2" id="abg1_ink_id_2" value="<?php echo set_value('abg1_ink_id_2',($ink_2!=''?$ink_2_desc."//".$ink_2:''));?>" size="50"/>
												</td>
											</tr>
											<tr>
												<td class="label">Anilox. <span style="color:red;">*</span> :</td>
												<td><select name="abg1_anilox_2" id="abg1_anilox_2">
														<option value="">--Please Select--</option>
														<?php if($springtube_anilox_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_anilox_master as $row) {

																$selected=($master_row->abg1_anilox_2==$row->anilox_id?'selected':'');

																echo'<option value="'.$row->anilox_id.'" '.set_select('abg1_anilox_2',$row->anilox_id).$selected.'>'.$row->anilox_lpi.'</option>';
															}
														}?>
													</select>
												</td>
												 
											</tr>
											<tr>
												<td class="label">Applying Method<span style="color:red;">*</span> :</td>
												<td><select name="abg1_applying_method_2" id="abg1_applying_method_2">
													<option value=""  >--Please Select--</option>
													<option value="1" <?php echo set_select('abg1_applying_method_2','1');?>  <?php echo ($master_row->abg1_applying_method_2==1?"selected":"");?>>Plate Through</option>
													<option value="2" <?php echo set_select('abg1_applying_method_2','2');?> <?php echo ($master_row->abg1_applying_method_2==2?"selected":"");?>>Roller Through</option>
													</select>
												</td>
											</tr>
											<tr>
												<td class="label">Cylinder Teeth<span style="color:red;">*</span> :</td>
												<td><select name="abg1_cylinder_teeth_2" id="abg1_cylinder_teeth_2">					
														<option value="">--Please Select--</option>
														<?php if($springtube_cylinder_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_cylinder_master as $row) {
																$selected=($master_row->abg1_cylinder_teeth_2==$row->cylinder_id?"selected":"");

																echo'<option value="'.$row->cylinder_id.'" '.set_select('abg1_cylinder_teeth_2',$row->anilox_id).$selected.'>'.$row->teeth.'</option>';
															}
														}?>
													</select>
												</td>											 
											</tr>
											<tr>
												<td class="label">Semi/Full Rotary<span style="color:red;">*</span> :</td>
												<td><select name="abg1_rotary_2" id="abg1_rotary_2">
													<option value="">--Please Select--</option>
													<option value="1" <?php echo set_select('abg1_rotary_2',1);?>
													<?php echo ($master_row->abg1_rotary_2==1?"selected":"");?> >[SR]-Semi Rotary</option>
													<option value="2" <?php echo set_select('abg1_rotary_2',2);?> <?php echo ($master_row->abg1_rotary_2==2?"selected":"");?> >[FR]-Full Rotary </option>
												</select>
											</tr>

											<tr>
												<td class="label">UV Power <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_power_2" id="abg1_uv_power_2" min="5" max="100" step="1"  size="20" value="<?php echo set_value('abg1_uv_power_2',$master_row->abg1_uv_power_2);?>" /></td>
												
											</tr>
											<tr>
												<td class="label">UV Speed <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_speed_2" id="abg1_uv_speed_2" min="5" max="100" step="1" size="20" value="<?php echo set_value('abg1_uv_speed_2',$master_row->abg1_uv_speed_2);?>" /></td>												
											</tr>
											<tr>
												<td class="label">UV Lamp Hours <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_hours_2" id="abg1_uv_hours_2" min="1" max="1500" step="1"  size="20" value="<?php echo set_value('abg1_uv_hours_2');?>" /></td>												
											</tr>
											<tr>
												<td class="label">Total Ink Consumption (Grams) <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_ink_usage_2" id="abg1_ink_usage_2" min="1" max="100000"  size="20" step="any" value="<?php echo set_value('abg1_ink_usage_2');?>" /></td>									
											</tr>
											<tr>
												<td class="label">Comment  <span style="color:red;">*</span> :</td>
												<td ><textarea name="abg1_unit_2_comment" value="<?php echo set_value('abg1_unit_2_comment');?>"><?php echo $master_row->abg1_unit_2_comment;?></textarea></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr><td colspan="2">-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
								</td></tr>
								<tr>
									<td width="50%">
										<table class="form_table_inner">
											<tr><td class="label" colspan="2"><b>ABG 1 - FLEXO UNIT - 3</b></td></tr>							
											 
											<tr>
												<td class="label">Color/Ink Name <span style="color:red;">*</span> :</td>
												<td>
													<input type="text" name="abg1_ink_id_3" id="abg1_ink_id_3" value="<?php echo set_value('abg1_ink_id_3',($ink_3!=''?$ink_3_desc."//".$ink_3:''));?>" size="50"/>
												</td>
											</tr>
											<tr>
												<td class="label">Anilox. <span style="color:red;">*</span> :</td>
												<td><select name="abg1_anilox_3" id="abg1_anilox_3">					
														<option value="">--Please Select--</option>
														<?php if($springtube_anilox_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_anilox_master as $row) {

															$selected=($master_row->abg1_anilox_3==$row->anilox_id?"selected":"");	
																echo'<option value="'.$row->anilox_id.'" '.set_select('abg1_anilox_3',$row->anilox_id).$selected.'>'.$row->anilox_lpi.'</option>';
															}
														}?>
													</select>
												</td>
												 
											</tr>
											<tr>
												<td class="label">Applying Method<span style="color:red;">*</span> :</td>
												<td><select name="abg1_applying_method_3" id="abg1_applying_method_3">
													<option value="">--Please Select--</option>
													<option value="1" <?php echo set_select('abg1_applying_method_3','1');?> <?php echo ($master_row->abg1_applying_method_3==1?"selected":"");?>>Plate Through</option>
													<option value="2" <?php echo set_select('abg1_applying_method_3','2');?> <?php echo ($master_row->abg1_applying_method_3==2?"selected":"");?>>Roller Through</option>
												</select>
											</tr>

											<tr>
												<td class="label">Cylinder Teeth<span style="color:red;">*</span> :</td>
												<td><select name="abg1_cylinder_teeth_3" id="abg1_cylinder_teeth_3">					
														<option value="">--Please Select--</option>
														<?php if($springtube_cylinder_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_cylinder_master as $row) {
																$selected=($master_row->abg1_cylinder_teeth_3==$row->cylinder_id?"selected":"");
																echo'<option value="'.$row->cylinder_id.'" '.set_select('abg1_cylinder_teeth_3',$row->cylinder_id).$selected.'>'.$row->teeth.'</option>';
															}
														}?>
													</select>
												</td>											 
											</tr>
											<tr>
												<td class="label">Semi/Full Rotary<span style="color:red;">*</span> :</td>
												<td><select name="abg1_rotary_3" id="abg1_rotary_3">
													<option value="">--Please Select--</option>
													<option value="1" <?php echo set_select('abg1_rotary_3','1');?> <?php echo ($master_row->abg1_rotary_3==1?"selected":"");?> >[SR]-Semi Rotary</option>
													<option value="2" <?php echo set_select('abg1_rotary_3','2');?> <?php echo ($master_row->abg1_rotary_3==2?"selected":"");?> >[FR]-Full Rotary </option>
												</select>
											</tr>

											<tr>
												<td class="label">UV Power <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_power_3" id="abg1_uv_power_3" min="5" max="100" step="1"  size="20" value="<?php echo set_value('abg1_uv_power_3',$master_row->abg1_uv_power_3);?>" /></td>
												
											</tr>
											<tr>
												<td class="label">UV Speed <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_speed_3" id="abg1_uv_speed_3" min="5" max="100" step="1" size="20" value="<?php echo set_value('abg1_uv_speed_3',$master_row->abg1_uv_speed_3);?>" /></td>
												
											</tr>
											<tr>
												<td class="label">UV Lamp Hours <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_hours_3" id="abg1_uv_hours_3" min="1" max="1500" step="1"  size="20" value="<?php echo set_value('abg1_uv_hours_3');?>" /></td>
												
											</tr>
											<tr>
												<td class="label">Total Ink Consumption (Grams) <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_ink_usage_3" id="abg1_ink_usage_3" min="1" max="100000"  size="20" step="any" value="<?php echo set_value('abg1_ink_usage_3');?>" /></td>
												
											</tr>
											<tr>
												<td class="label">Comment  <span style="color:red;">*</span> :</td>
												<td ><textarea name="abg1_unit_3_comment" value="<?php echo set_value('abg1_unit_3_comment');?>"></textarea></td>
											</tr>
										</table>
									</td>
									<td width="50%">
										<table class="form_table_inner">
											<tr>
												<td class="label" colspan="2"><b>ABG 1 - FLEXO UNIT - 4</b></td>
											</tr>
											<tr>
												<td class="label">Color/Ink Name <span style="color:red;">*</span> :</td>
												<td>
													<input type="text" name="abg1_ink_id_4" id="abg1_ink_id_4" value="<?php echo set_value('abg1_ink_id_4',($ink_4!=''?$ink_4_desc."//".$ink_4:''));?>" size="50"/>
												</td>
											</tr>
											<tr>
												<td class="label">Anilox. <span style="color:red;">*</span> :</td>
												<td><select name="abg1_anilox_4" id="abg1_anilox_4">
														<option value="">--Please Select--</option>
														<?php if($springtube_anilox_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_anilox_master as $row) {
																$selected=($master_row->abg1_anilox_4==$row->anilox_id?"selected":"");

																echo'<option value="'.$row->anilox_id.'" '.set_select('abg1_anilox_4',$row->anilox_id).$selected.'>'.$row->anilox_lpi.'</option>';
															}
														}?>
													</select>
												</td>
												 
											</tr>
											<tr>
												<td class="label">Applying Method<span style="color:red;">*</span> :</td>
												<td><select name="abg1_applying_method_4" id="abg1_applying_method_4">
													<option value="">--Please Select--</option>
													<option value="1" <?php echo set_select('abg1_applying_method_4','1');?> <?php echo ($master_row->abg1_applying_method_4==1?"selected":"");?>>Plate Through</option>
													<option value="2" <?php echo set_select('abg1_applying_method_4','2');?> <?php echo ($master_row->abg1_applying_method_4==2?"selected":"");?>>Roller Through</option>
												</select>
											</tr>
											<tr>
												<td class="label">Cylinder Teeth<span style="color:red;">*</span> :</td>
												<td><select name="abg1_cylinder_teeth_4" id="abg1_cylinder_teeth_4">					
														<option value="">--Please Select--</option>
														<?php if($springtube_cylinder_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_cylinder_master as $row) {
																$selected=($master_row->abg1_cylinder_teeth_4==$row->cylinder_id?"selected":"");
																echo'<option value="'.$row->cylinder_id.'" '.set_select('abg1_cylinder_teeth_4',$row->cylinder_id).$selected.'>'.$row->teeth.'</option>';
															}
														}?>
													</select>
												</td>											 
											</tr>
											<tr>
												<td class="label">Semi/Full Rotary<span style="color:red;">*</span> :</td>
												<td><select name="abg1_rotary_4" id="abg1_rotary_4">
													<option value="">--Please Select--</option>
													<option value="1" <?php echo set_select('abg1_rotary_4','1');?> <?php echo($master_row->abg1_rotary_4==1?"selected":""); ?> >[SR]-Semi Rotary</option>
													<option value="2" <?php echo set_select('abg1_rotary_4','2');?> <?php echo($master_row->abg1_rotary_4==2?"selected":""); ?> >[FR]-Full Rotary </option>
												</select>
											</tr>

											<tr>
												<td class="label">UV Power <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_power_4" id="abg1_uv_power_4" min="5" max="100" step="1"  size="20" value="<?php echo set_value('abg1_uv_power_4',$master_row->abg1_uv_power_4);?>" /></td>
												
											</tr>
											<tr>
												<td class="label">UV Speed <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_speed_4" id="abg1_uv_speed_4" min="5" max="100" step="1" size="20" value="<?php echo set_value('abg1_uv_speed_4',$master_row->abg1_uv_speed_4);?>" /></td>												
											</tr>
											<tr>
												<td class="label">UV Lamp Hours <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_uv_hours_4" id="abg1_uv_hours_4" min="1" max="1500" step="1"  size="20" value="<?php echo set_value('abg1_uv_hours_4');?>" /></td>												
											</tr>
											<tr>
												<td class="label">Total Ink Consumption (Grams) <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg1_ink_usage_4" id="abg1_ink_usage_4" min="1" max="100000"  size="20" step="any" value="<?php echo set_value('abg1_ink_usage_4');?>" /></td>									
											</tr>
											<tr>
												<td class="label">Comment  <span style="color:red;">*</span> :</td>
												<td ><textarea name="abg1_unit_4_comment" value="<?php echo set_value('abg1_unit_4_comment');?>"></textarea><?php echo $master_row->abg1_unit_4_comment;?></td>
											</tr>
										</table>
									</td>
								</tr>

							</table>
						</div>

						<!-- TAB DURST -->

						<div id="tab-3" class="tab-content">
									 
							<table class="form_table_inner">
								<tr>
									<td width="50%">
										<table class="form_table_inner">
											<tr><td class="label" colspan="2"><input type="checkbox" name="is_durst" value="1" <?php echo set_checkbox('is_durst',1);?> <?php echo ($master_row->is_durst==1?"checked":""); ?> > <b>DURST</b></td></tr>							
											<tr>
												<td class="label">Carona. <span style="color:red;">*</span> :</td>
												<td><input type="number" name="durst_corona" id="durst_corona" min="0" max="200" step="1"  value="<?php echo set_value('durst_corona',$master_row->durst_corona);?>"   /></td>
												
											</tr>
											<tr>
												<td class="label">Print Configuration<span style="color:red;">*</span>:</td>
												<td>
													<input type="radio" name="print_confg" id="print_confg" value="HD" <?php echo($this->input->post('print_confg')=="HD" || $master_row->print_confg=='HD'? "checked":"");?>/> HD &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													<input type="radio" name="print_confg" id="print_confg" value="SD" <?php echo($this->input->post('print_confg')=="SD" || $master_row->print_confg =='SD'? "checked":"");?> /> SD

												</td>
											</tr>
											<tr>
												<td class="label">Digital White In Use<span style="color:red;">*</span>:</td>
												<td>
													<input type="radio" name="digital_white" id="digital_white" value="YES" <?php echo($this->input->post('digital_white')=="YES" || $master_row->digital_white=='YES'? "checked":"");?>/> YES &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													<input type="radio" name="digital_white" id="digital_white" value="NO" <?php echo($this->input->post('digital_white')=="NO"|| $master_row->digital_white=='NO'? "checked":"");?> /> NO

												</td>
											</tr>
											<tr>
												<td class="label">Colour Policy<span style="color:red;">*</span> :</td>
												<td><select name="colour_policy" id="colour_policy">					
														<option value="">--Please Select--</option>
														<?php if($springtube_printing_color_policy_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_printing_color_policy_master as $row) {
																$selected=($master_row->colour_policy==$row->id?"selected":"");
																echo'<option value="'.$row->id.'" '.set_select('colour_policy',$row->id).$selected.'>'.$row->colour_policy.'</option>';
															}
														}?>
													</select>
											</tr>
											<tr>
												<td class="label">Substrate Defination<span style="color:red;">*</span> :</td>
												<td><select name="substrate_defination" id="substrate_defination" >
													<option value="">--Please Select--</option>
													<option value="DEFAULT WHITE" <?php echo set_select('substrate_defination','DEFAULT WHITE');?> <?php echo($master_row->substrate_defination=="DEFAULT WHITE"?"selected":"");?> >DEFAULT WHITE</option>
													<
												</select>
											</tr>
											<tr>
												<td class="label">Printing Speed<span style="color:red;">*</span> :</td>
												<td><input type="number" name="printing_speed" id="printing_speed" min="18" max="60" step="1"  size="30" value="<?php echo set_value('printing_speed',$master_row->printing_speed);?>" /></td>
												
											</tr>
											<tr>
												<td class="label">Tension<span style="color:red;">*</span> :</td>
												<td><input type="text" name="unwind_tension" id="unwind_tension" maxlength="50" size="30" value="<?php echo set_value('unwind_tension',$master_row->unwind_tension);?>"/></td> 
											</tr>
											<tr>
												<td class="label">Pinning W <span style="color:red;">*</span> :</td>
												<td><input type="number" name="pinning_w" id="pinning_w" maxlength="3" size="20" step="any" value="<?php echo set_value('pinning_w',$master_row->pinning_w);?>"  /></td>									
											</tr>
											<tr>
												<td class="label">Pinning K <span style="color:red;">*</span> :</td>
												<td><input type="number" name="pinning_k" id="pinning_k" min="15" max="100"  size="20" step="any" value="<?php echo set_value('pinning_k',$master_row->pinning_k);?>" /></td>
											</tr>
										</table>	
									
									</td>

								
									<td width="50%">
										<table>

											<tr>
												<td class="label">UV Curing - 1<span style="color:red;">*</span> :</td>
												<td><input type="number" name="durst_uv_curing_1" id="durst_uv_curing_1" min="5" max="100" size="20" value="<?php echo set_value('durst_uv_curing_1',$master_row->durst_uv_curing_1);?>" /></td> 
											</tr>
											<tr>
												<td class="label">Lamp 1 Hours <span style="color:red;">*</span> :</td>
												<td><input type="number" name="durst_uv_lamp_hrs_1" id="durst_uv_lamp_hrs_1" min="1" max="1500"  size="20" step="any" value="<?php echo set_value('durst_uv_lamp_hrs_1');?>"  /></td>
											</tr>
											<tr>
												<td class="label">UV Curing - 2<span style="color:red;">*</span> :</td>
												<td><input type="number" name="durst_uv_curing_2" id="durst_uv_curing_2" min="5" max="100" size="20" value="<?php echo set_value('durst_uv_curing_2',$master_row->durst_uv_curing_2);?>" />
												</td> 
											</tr>
											<tr>
												<td class="label">Lamp 2 Hours <span style="color:red;">*</span> :</td>
												<td><input type="number" name="durst_uv_lamp_hrs_2" id="durst_uv_lamp_hrs_2" min="1" max="1500"  size="20" step="any" value="<?php echo set_value('durst_uv_lamp_hrs_2');?>" /></td>
											</tr>
											<tr>
												<td class="label">Nitrogen Used<span style="color:red;">*</span>:</td>
												<td>
													<input type="radio" name="nitrogen" id="nitrogen" value="YES" <?php echo($this->input->post('nitrogen')=='YES' || $master_row->nitrogen=='YES' ? "checked":"");?> /> YES &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													<input type="radio" name="nitrogen" id="nitrogen" value="NO" <?php echo($this->input->post('nitrogen')=='NO' || $master_row->nitrogen=='NO' ? "checked":"");?> /> NO

												</td>
											</tr>
											<tr>
												<td class="label">Digital Cost In Euro <span style="color:red;">*</span> :</td>
												<td><input type="number" name="digital_cost_in_euro" id="digital_cost_in_euro" min="0" max="1000"  size="20" step="any" value="<?php echo set_value('digital_cost_in_euro');?>" />
													TRACK(UPS)
													<input type="number" name="digital_cost_per_qty" min="1" max="2" value="<?php echo set_value('digital_cost_per_qty');?>" /></td>

												</td>
											</tr>
											<tr>
												<td class="label">Comment  <span style="color:red;">*</span> :</td>
												<td ><textarea name="durst_comment" value="<?php echo set_value('durst_comment');?>"></textarea></td>
											</tr>									
											
										</table>
									</td>
								</tr>
							</table>		

						</div>

						<!-- TAB ABG 2 -->

						<div id="tab-4" class="tab-content">
							
							<table class="form_table_inner">
								<tr>
									<td width="50%">
										<table class="form_table_inner">
											<tr><td class="label" colspan="2"><b>ABG 2 - FLEXO UNIT - 1</b></td></tr>							
											<tr>
												<td class="label">Carona. <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_carona_1" id="abg2_carona_1" min="0" max="200" step="1"  value="<?php echo set_value('abg2_carona_1',$master_row->abg2_carona_1);?>" /></td>
												
											</tr>
											<tr>
												<td class="label">Color/Ink Name <span style="color:red;">*</span> :</td>
												<td>
													<input type="text" name="abg2_ink_id_1" id="abg2_ink_id_1" value="<?php echo set_value('abg2_ink_id_1',($ink_5!=''?$ink_5_desc."//".$ink_5:''));?>" size="50"/> 
												</td>	

											</tr>
											<tr>
												<td class="label">Anilox. <span style="color:red;">*</span> :</td>
												<td><select name="abg2_anilox_1" id="abg2_anilox_1">					
														<option value="">--Please Select--</option>
														<?php if($springtube_anilox_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_anilox_master as $row) {
																$selected=($master_row->abg2_anilox_1==$row->anilox_id?"selected":"");
																echo'<option value="'.$row->anilox_id.'" '.set_select('abg2_anilox_1',$row->anilox_id).$selected.'>'.$row->anilox_lpi.'</option>';
															}
														}?>
													</select>
												</td>
												 
											</tr>
											<tr>
												<td class="label">Applying Method<span style="color:red;">*</span> :</td>
												<td><select name="abg2_applying_method_1" id="abg2_applying_method_1">
													<option value="">--Please Select--</option>
													<option value="1" <?php echo set_select('abg2_applying_method_1','1');?> <?php echo($master_row->abg2_applying_method_1==1?"selected":"");?>>Plate Through</option>
													<option value="2" <?php echo set_select('abg2_applying_method_1','2');?> <?php echo($master_row->abg2_applying_method_1==2?"selected":"");?>>Roller Through</option>
												</select>
											</tr>

											<tr>
												<td class="label">Cylinder Teeth<span style="color:red;">*</span> :</td>
												<td><select name="abg2_cylinder_teeth_1" id="abg2_cylinder_teeth_1">					
														<option value="">--Please Select--</option>
														<?php if($springtube_cylinder_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_cylinder_master as $row) {

																$selected=($master_row->abg2_cylinder_teeth_1==$row->cylinder_id?"selected":"");
																echo'<option value="'.$row->cylinder_id.'" '.set_select('abg2_cylinder_teeth_1',$row->cylinder_id).$selected.'>'.$row->teeth.'</option>';
															}
														}?>
													</select>
												</td>											 
											</tr>
											<tr>
												<td class="label">Semi/Full Rotary<span style="color:red;">*</span> :</td>
												<td><select name="abg2_rotary_1" id="abg2_rotary_1">
													<option value="">--Please Select--</option>
													<option value="1" <?php echo set_select('abg2_rotary_1','1');?> <?php echo($master_row->abg2_rotary_1==1?"selected":"");?> >[SR]-Semi Rotary</option>
													<option value="2" <?php echo set_select('abg2_rotary_1','2');?> <?php echo($master_row->abg2_rotary_1==2?"selected":"");?> >[FR]-Full Rotary </option>
												</select>
											</tr>

											<tr>
												<td class="label">UV Power <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_uv_power_1" id="abg2_uv_power_1" min="5" max="100" step="1"  size="20" value="<?php echo set_value('abg2_uv_power_1',$master_row->abg2_uv_power_1);?>" /></td>
												
											</tr>
											<tr>
												<td class="label">UV Speed <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_uv_speed_1" id="abg2_uv_speed_1" min="5" max="100" step="1" size="20" value="<?php echo set_value('abg2_uv_speed_1',$master_row->abg2_uv_speed_1);?>" /></td>
												
											</tr>
											<tr>
												<td class="label">UV Lamp Hours <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_uv_hours_1" id="abg2_uv_hours_1" min="1" max="1500" step="1"  size="20" value="<?php echo set_value('abg2_uv_hours_1');?>" /></td>
												
											</tr>
											<tr>
												<td class="label">Total Ink Consumption (Grams) <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_ink_usage_1" id="abg2_ink_usage_1" min="1" max="100000"  size="20" step="any" value="<?php echo set_value('abg2_ink_usage_1');?>" /></td>
												
											</tr>
											<tr>
												<td class="label">Comment  <span style="color:red;">*</span> :</td>
												<td ><textarea name="abg2_unit_1_comment" value="<?php echo set_value('abg2_unit_1_comment');?>"></textarea><?php echo $master_row->abg2_unit_1_comment;?></td>
											</tr>
										</table>
									</td>
									<td width="50%">
										<table class="form_table_inner">
											<tr>
												<td class="label" colspan="2"><b>ABG 2 - FLEXO UNIT - 2</b></td>
											</tr>
											<tr>
												<td class="label">Color/Ink Name <span style="color:red;">*</span> :</td>
												<td>
													<input type="text" name="abg2_ink_id_2" id="abg2_ink_id_2" value="<?php echo set_value('abg2_ink_id_2',($ink_6!=''?$ink_6_desc."//".$ink_6:''));?>" size="50"/>
												</td>
											</tr>
											<tr>
												<td class="label">Anilox. <span style="color:red;">*</span> :</td>
												<td><select name="abg2_anilox_2" id="abg2_anilox_2">
														<option value="">--Please Select--</option>
														<?php if($springtube_anilox_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_anilox_master as $row) {

																$selected=($master_row->abg2_anilox_2==$row->anilox_id?'selected':'');

																echo'<option value="'.$row->anilox_id.'" '.set_select('abg2_anilox_2',$row->anilox_id).$selected.'>'.$row->anilox_lpi.'</option>';
															}
														}?>
													</select>
												</td>
												 
											</tr>
											<tr>
												<td class="label">Applying Method<span style="color:red;">*</span> :</td>
												<td><select name="abg2_applying_method_2" id="abg2_applying_method_2">
													<option value="">--Please Select--</option>
													<option value="1" <?php echo set_select('abg2_applying_method_2','1');?> <?php echo($master_row->abg2_applying_method_2==1?"selected":"");?> >Plate Through</option>
													<option value="2" <?php echo set_select('abg2_applying_method_2','2');?> <?php echo($master_row->abg2_applying_method_2==2?"selected":"");?>>Roller Through</option>
												</select>
											</tr>
											<tr>
												<td class="label">Cylinder Teeth<span style="color:red;">*</span> :</td>
												<td><select name="abg2_cylinder_teeth_2" id="abg2_cylinder_teeth_2">					
														<option value="">--Please Select--</option>
														<?php if($springtube_cylinder_master==FALSE){
															echo'<option>--Setup Required--</option>';
														}
														else{
															foreach ($springtube_cylinder_master as $row) {

																$selected=($master_row->abg2_cylinder_teeth_2==$row->cylinder_id?"selected":"");
																echo'<option value="'.$row->cylinder_id.'" '.set_select('abg2_cylinder_teeth_2',$row->cylinder_id).$selected.'>'.$row->teeth.'</option>';
															}
														}?>
													</select>
												</td>											 
											</tr>
											<tr>
												<td class="label">Semi/Full Rotary<span style="color:red;">*</span> :</td>
												<td><select name="abg2_rotary_2" id="abg2_rotary_2">
													<option value="">--Please Select--</option>
													<option value="1" <?php echo set_select('abg2_rotary_2','1');?> <?php echo($master_row->abg2_rotary_2==1?"selected":"");?> >[SR]-Semi Rotary</option>
													<option value="2" <?php echo set_select('abg2_rotary_2','2');?> <?php echo($master_row->abg2_rotary_2==2?"selected":"");?> >[FR]-Full Rotary </option>
												</select>
											</tr>

											<tr>
												<td class="label">Extended Web Path<span style="color:red;">*</span>:</td>
												<td>
													<input class="radio" type="radio" name="is_extended_path" id="is_extended_path" value="YES" <?php echo($this->input->post('is_extended_path')=='YES' || $master_row->is_extended_path=='YES'?"checked":"");?>/> YES &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
													<input class="radio" type="radio" name="is_extended_path" id="is_extended_path" value="NO" <?php echo($this->input->post('is_extended_path')=='NO'|| $master_row->is_extended_path=='NO'? "checked":"");?> /> NO

												</td>
											</tr>
											<tr id="tr_abg2_uv_power_2">
												<td class="label">UV Power <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_uv_power_2" id="abg2_uv_power_2" min="5" max="100" step="1"  size="20" value="<?php echo set_value('abg2_uv_power_2',$master_row->abg2_uv_power_2);?>" /></td>
												
											</tr>
											<tr id="tr_abg2_uv_speed_2">
												<td class="label">UV Speed <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_uv_speed_2" id="abg2_uv_speed_2" min="5" max="100" step="1" size="20" value="<?php echo set_value('abg2_uv_speed_2',$master_row->abg2_uv_speed_2);?>" /></td>												
											</tr>
											<tr id="tr_abg2_uv_hours_2">
												<td class="label">UV Lamp Hours <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_uv_hours_2" id="abg2_uv_hours_2" min="1" max="1500" step="1"  size="20" value="<?php echo set_value('abg2_uv_hours_2');?>" /></td>												
											</tr>

											<tr id="tr_abg2_extended_uv_power_2">
												<td class="label">Extended UV Power <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_extended_uv_power_2" id="abg2_extended_uv_power_2" min="5" max="100" step="1"  size="20" value="<?php echo set_value('abg2_extended_uv_power_2',$master_row->abg2_extended_uv_power_2);?>" /></td>
												
											</tr>
											<tr id="tr_abg2_extended_uv_speed_2">
												<td class="label">Extended UV Speed <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_extended_uv_speed_2" id="abg2_extended_uv_speed_2" min="5" max="100" step="1" size="20" value="<?php echo set_value('abg2_extended_uv_speed_2',$master_row->abg2_extended_uv_speed_2);?>" /></td>												
											</tr>
											<tr id="tr_abg2_extended_uv_hours_2">
												<td class="label">Extended UV Lamp Hours <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_extended_uv_hours_2" id="abg2_extended_uv_hours_2" min="1" max="1500" step="1"  size="20" value="<?php echo set_value('abg2_extended_uv_hours_2');?>" /></td>												
											</tr>
											<tr>
												<td class="label">Total Ink Consumption (Grams) <span style="color:red;">*</span> :</td>
												<td><input type="number" name="abg2_ink_usage_2" id="abg2_ink_usage_2" min="1" max="100000"  size="20" step="any" value="<?php echo set_value('abg2_ink_usage_2');?>" /></td>									
											</tr>
											<tr>
												<td class="label">Comment  <span style="color:red;">*</span> :</td>
												<td ><textarea name="abg2_unit_2_comment" value="<?php echo set_value('abg2_unit_2_comment');?>"></textarea></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>		 

						</div>

						<!-- TAB FOIL  -->						
						<div id="tab-5" class="tab-content">

							<table class="form_table_inner">
								<tr>
									<td width="40%">

										<table class="form_table_inner" >
											<tr>
												<td class="label">Cold Foil 1 <span style="color:red;">*</span></td>
												<td><input type="text" name="cold_foil_1" id="cold_foil_1"  size="50" value="<?php echo set_value('cold_foil_1',($master_row->cold_foil_1!=''?$this->common_model->get_article_name($master_row->cold_foil_1,$this->session->userdata['logged_in']['company_id']).'//'.$master_row->cold_foil_1:''));?>"  placeholder="Cold foil 1" readonly/>
												</td>
											</tr>
											<tr><td>&nbsp;</td></tr>

											<tr>
												<td class="label">Cold Foil 2 <span style="color:red;">*</span></td>
												<td><input type="text" name="cold_foil_2" id="cold_foil_2"  size="50" value="<?php echo set_value('cold_foil_2',($master_row->cold_foil_2!=''?$this->common_model->get_article_name($master_row->cold_foil_2,$this->session->userdata['logged_in']['company_id']).'//'.$master_row->cold_foil_2:''));?>"  placeholder="Cold foil 2" readonly/>
												</td>
											</tr>
																					

										</table>
									</td>
									<td width="60%">

										<table class="form_table_inner" >
											<tr>											
												<!-- <td class="label">Foil 1 Area<span style="color:red;">*</span> 
												</td> -->
												<td>
													Width=<input type="text" name="cold_foil_1_width" id="cold_foil_1_width" readonly placeholder="Width" size="10" value="<?php echo set_value('cold_foil_1_width',$master_row->cold_foil_1_width);?>">MM, 
													Length=<input type="number" name="cold_foil_1_length" id="cold_foil_1_length"  placeholder="Length" size="10" step="any" value="<?php echo set_value('cold_foil_1_length',$master_row->cold_foil_1_length);?>">MTRS, 
													&nbsp; Area=<input type="text" name="cold_foil_1_area" id="cold_foil_1_area"  placeholder="Area" size="10"  value="<?php echo set_value('cold_foil_1_area',$master_row->cold_foil_1_area);?>" readonly>SQMTRS
												</td>
												
											</tr>
											<tr><td>&nbsp;</td></tr>

											<tr>											
												<!-- <td class="label">Foil 1 Area<span style="color:red;">*</span> 
												</td> -->
												<td>
													Width=
													<input type="text" name="cold_foil_2_width" id="cold_foil_2_width" readonly placeholder="Width" size="10" value="<?php echo set_value('cold_foil_2_width',$master_row->cold_foil_2_width);?>">
													MM, Length=
													<input type="number" name="cold_foil_2_length" id="cold_foil_2_length"  placeholder="Length" size="10" step="any" value="<?php echo set_value('cold_foil_2_length',$master_row->cold_foil_2_length);?>">
													MTRS, Area=<input type="text" name="cold_foil_2_area" id="cold_foil_2_area"  placeholder="Area" size="10" value="<?php echo set_value('cold_foil_2_area',$master_row->cold_foil_2_area);?>" readonly>SQMTRS
												</td>
												
											</tr>
																					

										</table>
									</td>

								</tr>
							</table>
						</div>

					</div><!-- container --> 

				</td>
			</tr>
						
		</table>

		<?php endforeach;?>		

	 
	<div class="middle_form_design">

		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" onClick="return confirm('Are you sure to save record!');" >Save</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

	</div>
		
</form>
				
				
				
				
				
			