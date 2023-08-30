<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax/so_no_only_open');?>", {selectFirst: true});
		//$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		if($('#order_no').val()!=''){

			 $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/psm_psp_no",data: {order_no : $('#order_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
			       $("#article_no").html(html);
			    	} 
			    });

		}


		$("#order_no").live('keyup',function() {
			$("#loading").hide(); $("#cover").hide();
		   var order_no = $('#order_no').val();
		   var order_no_length=order_no.length;
		   //if(order_no_length==13){
		   		$("#article_no").html("<option value=''>--Please Select--</option>");
			   	$("#loading").show();
						$("#cover").show();
						$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/psm_psp_no",data: {order_no : $('#order_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
			       $("#article_no").html(html);
			    	} 
			    });
			   
		   //}
		   

   		});

   		$("#article_no").change(function() {
   			$("#loading").hide(); $("#cover").hide();
   			$("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');		    
	   		var article_no = $(this).find(':selected').val();
	    	//var selectedText = $(this).find(':selected').text();
	    	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/psm_psp_jobcards",data: {article_no : article_no,order_no : $('#order_no').val() },cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
			       $("#jobcard_no").html(html);
			    } 
			});

	    	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_artwork_details",data: {order_no : $('#order_no').val(),article_no : article_no },cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		
			       var arr = html.split('//');
			       $("#artwork_no").val(arr[0]);
			       $("#version_no").val(arr[1]);
			    } 
			});
		   
		    
		});

		

		// $("#tablePanton").find('input[name="pantone[]"]').each(function(e){
		// 		$(this).val();
				
		// 	}
		
   		$("#add").click(function(e){   			
		 	var counter= $('#tablePanton tr').length;		 	
			var markup = '<tr id="'+ counter +'"><td><input type="checkbox" name="record"></td><td><select name="artwork_para_id[]"><option value="">--SELECT SCREEN NATURE--</option><?php if($graphics_plate_nature_master==FALSE){echo"<option>--Setup Required--</option>";}else{foreach($graphics_plate_nature_master as $row){$selected=($row->artwork_para_id=='10'?'selected':'');echo'<option value="'.$row->artwork_para_id.'"'.$selected.'>'.$row->plate_nature.'</option>';}}?></select><td><input type="text" name="pantone[]" placeholder="Pantone Name"></td><td><input type="text" name="mesh[]" placeholder="Mesh"></td><td><input type="date"  name="date_on_screen[]" placeholder="Date On Screen"/></td><td><input type="text" name="label_on_screen[]" placeholder="Label On Screen" ></td><td><input type="number" name="screen_count[]"  placeholder="No. of Screen"></td></tr>';
			$("#tablePanton").append(markup);
		});

   		$("#remove").click(function(e){

   			var flag=0;
								
			$("#tablePanton").find('input[name="record"]').each(function(){

				var tr_number=$(this).parents("tr").attr('id');
				if(tr_number>1){
					if($(this).is(":checked")){
						$(this).parents("tr").remove();
					}
					
				}
				else{
					alert('Please enter atleast one record.');	
				}
													
				// if($('#tablePanton tr').length>2){
				// 	if($(this).is(":checked")){
				// 		if(confirm('Confirm delete!')){
				// 			$(this).parents("tr").remove();
				// 		}
				// 	}
				// }
				// else{
				// alert('Please enter atleast one record.');	
					
				// }
			});	
			
				
		});

		//VALIDATION STARTS--------------------------------------------------------
		

         $("#btnsubmit").click(function(e){

			if($("#order_no").val()==""){
				alert('Select the Order No.');
				$("#order_no").focus();
				return false;
			}
			if($("#article_no").val()==""){
				alert('Select the PSM/PSP No.');
				$("#article_no").focus();
				return false;
			}
			/*if($("#artwork_no").val()==""){
				alert('Select the Artwork ');
				$("#artwork_no").focus();
				return false;
			}
			if($("#version_no").val()==""){
				alert('Select the Artwork Version');
				$("#version_no").focus();
				return false;
			}
			*/
			if($("#jobcard_no").val()==""){
				alert('Select the Jobcard No.');
				$("#jobcard_no").focus();
				return false;
			}
			if($("#shift_id").val()==""){
				alert('Select the Shift');
				$("#shift_id").focus();
				return false;
			}
			if($("#reason_id").val()==""){
				alert('Select the Screen Making Reason');
				$("#reason_id").focus();
				return false;
			}
			if($("#machine_id").val()==""){
				alert('Select the Machine');
				$("#machine_id").focus();
				return false;
			}		
			
			var flag_pantone=1;
			$("#tablePanton").find('input[name="pantone[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_pantone=0;
				}
								
			});

			var flag_mesh=1;
			$("#tablePanton").find('input[name="mesh[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_mesh=0;
				}
								
			});

			var flag_screen_nature=1;
			$("#tablePanton").find('input[name="artwork_para_id[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_screen_nature=0;
				}
								
			});

			var flag_screen_date=1;
			$("#tablePanton").find('input[name="date_on_screen[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_screen_date=0;
				}
								
			});

			var flag_screen_label=1;
			$("#tablePanton").find('input[name="label_on_screen[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_screen_label=0;
				}
								
			});

			var flag_screen_count=1;
			$("#tablePanton").find('input[name="screen_count[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_screen_count=0;
				}
								
			});

			if(flag_pantone==0 || flag_screen_nature==0 || flag_screen_date==0 || flag_screen_label==0 || flag_plate_count==0|| flag_mesh==0){
				alert('Enter all the Plate Details');
				return false;

			}

			return true;


         });
	



	});
</script>




<?php foreach ($graphics_daily_screen_master as $graphics_daily_screen_master_row):?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<tr>
							<td class="label">Order No. * :</td>
							<td>
								<input type="hidden" name="dsr_id" value="<?php echo set_value('dsr_id',$graphics_daily_screen_master_row->dsr_id );?>" />
								<input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$graphics_daily_screen_master_row->order_no);?>" required placeholder="Order No"/></td>
							<td class="label">PSM/PSP No.  * :</td>
							<td>
								<select name="article_no" id="article_no" >
									<option value="">--Please Select--</option>	
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Artwork  * :</td>
							<td><input type="text" name="artwork_no" id="artwork_no"  size="20" value="<?php echo set_value('artwork_no',$graphics_daily_screen_master_row->artwork_no);?>" placeholder="Artwork"/></td>
							<td class="label">Version  * :</td>
							<td><input type="text" name="version_no" id="version_no"  size="20" value="<?php echo set_value('version_no',$graphics_daily_screen_master_row->version_no);?>" placeholder="Version"/></td>
						</tr>
						<tr><td class="label">Comment  * :</td>
							<td ><textarea name="comment" value="<?php echo set_value('comment',$graphics_daily_screen_master_row->comment);?>"><?php echo set_value('comment',$graphics_daily_screen_master_row->comment);?></textarea></td>
						
						<td class="label">Screen Maker  * :</td>
						<td><select name="operator_id" id="operator_id">					
								<option value="">--Please Select--</option>
								<?php if($graphics_operator_master==FALSE){
									echo'<option>--Setup Required--</option>';
								}
								else{
									foreach ($graphics_operator_master as $row) {
										$selected=($graphics_daily_screen_master_row->operator_id==$row->operator_id?'selected':'');
										echo'<option value="'.$row->operator_id.'" '.set_select('operator_id',$row->operator_id).' '.$selected.'>'.strtoupper($row->operator_name).'</option>';
									}
								}?>
							</select>
						</td>
						</tr>

					</table>			
								
				</td>
				<td width="50%">
					<table class="form_table_inner">									
						<tr>
							<td class="label">Jobcard No. * :</td>
							<td><select name="jobcard_no" id="jobcard_no" >
									<option value="">--Please Select--</option>	
								</select>
							</td>
							<td class="label">Shift  * :</td>
							<td><select name="shift_id" id="shift_id">					
										<option value="">--Please Select--</option>
										<?php if($graphics_shift_master==FALSE){
											echo'<option>--Setup Required--</option>';
										}
										else{
											foreach ($graphics_shift_master as $row) {

												$selected=($graphics_daily_screen_master_row->shift_id==$row->shift_id?'selected':'');
												echo'<option value="'.$row->shift_id.'" '.set_select('shift_id',$row->shift_id).''.$selected.'>'.$row->shift_name.'</option>';
											}
										}?>
										</select>
									</td>
						</tr>
						<tr>
							<td class="label">Machine  * :</td>
							<td><select name="machine_id" id="machine_id">					
								<option value="">--Please Select--</option>
								<?php if($graphics_machine_master==FALSE){
									echo'<option>--Setup Required--</option>';
								}
								else{
									foreach ($graphics_machine_master as $row) {
										$selected=($graphics_daily_screen_master_row->machine_id==$row->machine_id?'selected':'');
										echo'<option value="'.$row->machine_id.'" '.set_select('machine_id',$row->machine_id).''.$selected.'>'.$row->machine_name.'</option>';
									}
								}?>
								</select></td>
							<td class="label">Reason  * :</td>
							<td><select name="reason_id" id="reason_id">					
								<option value="">--Please Select--</option>
								<?php if($graphics_plate_making_reasons==FALSE){
									echo'<option>--Setup Required--</option>';
								}
								else{
									foreach ($graphics_plate_making_reasons as $row) {
										$selected=($graphics_daily_screen_master_row->screen_making_reason==$row->reason_id?'selected':'');
										echo'<option value="'.$row->reason_id.'" '.set_select('reason_id',$row->reason_id).''.$selected.'>'.$row->reason.'</option>';
									}
								}?>
								</select>
							</td>
						</tr>
											
					</table>	
				</td>							
			</tr>
		</table>

		<div class="middle_form_design">
			
						
				<div class="ui buttons">
				<input type="button" value="Remove" id="remove" class="ui button">
				<div class="or"></div>
				<input type="button" value="Add" id="add" class="ui positive button">
				</div>
			


				<table class="middle_form_table_design" id="tablePanton">
								<tr>
										<th>Select</th>
										<th>Screen Nature</th>
										<th>Pantone Name</th>
										<th>Mesh</th>
										<th>Date On Screen</th>
										<th>Label On Screen</th>
										<th>No. Of Screen</th>
										
								</tr>
								

								<?php

									if(!empty($this->input->post('pantone[]'))){
										$j=1;
										for($i=0;$i<count($this->input->post('pantone[]'));$i++)	{

											echo'<tr id="'.$j++.'">
												<td><input type="checkbox" name="record"></td>
												<td><select name="artwork_para_id[]">					
													<option value="">--SELECT SCREEN NATURE--</option>';
													if($graphics_plate_nature_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($graphics_plate_nature_master as $row) {
															$selected=($details_row->artwork_para_id==$row->artwork_para_id?'selected':'');
															echo'<option value="'.$row->artwork_para_id.'" '.set_select('artwork_para_id[]',$row->artwork_para_id).' '.$selected.'>'.$row->plate_nature.'</option>';
														}
													}
										
													echo'</select>
												</td>';
												echo'<td><input type="text"   name="pantone[]"   value="'.set_value("pantone[]").'"  placeholder="Pantone Name"></td><td><input type="text"   name="mesh[]"   value="'.set_value("mesh[]").'"  placeholder="Mesh"></td><td><input type="date" name="date_on_screen[]" value="'.set_value('date_on_screen[]').'"   placeholder="Date On Screen"/></td><td><input type="text"   name="label_on_screen[]" value="'.set_value('label_on_screen[]').'"  placeholder="Lable On Screen" ></td><td><input type="number" name="screen_count[]" value="'.set_value('screen_count[]').'"    placeholder="No. Of Screen"></td></tr>';

										}
										
									} 
									else{

										$result_graphics_daily_screen_details=$this->common_model->select_one_details_record_noncompany('graphics_daily_screen_details','dsr_id',$graphics_daily_screen_master_row->dsr_id);

										$j=1;
										foreach($result_graphics_daily_screen_details as $details_row ){

											echo'<tr id="'.$j++.'">
												<td><input type="checkbox" name="record"></td>
												<td><select name="artwork_para_id[]">					
													<option value="">--SELECT SCREEN NATURE--</option>';
													if($graphics_plate_nature_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($graphics_plate_nature_master as $row) {
															$selected=($details_row->artwork_para_id==$row->artwork_para_id?'selected':'');
															echo'<option value="'.$row->artwork_para_id.'" '.set_select('artwork_para_id[]',$row->artwork_para_id).''.$selected.'>'.$row->plate_nature.'</option>';
														}
													}
										
													echo'</select>
												</td>';
												echo'<td><input type="text"   name="pantone[]"   value="'.set_value("pantone[]",$details_row->pantone_name).'"  placeholder="Pantone Name"></td>
												<td><input type="text"   name="mesh[]"   value="'.set_value("mesh[]",$details_row->mesh).'"  placeholder="Mesh"></td><td><input type="date" name="date_on_screen[]" value="'.set_value('date_on_screen[]',$details_row->date_on_screen).'"   placeholder="Date On Screen"/></td><td><input type="text"   name="label_on_screen[]" value="'.set_value('label_on_screen[]',$details_row->label_on_screen).'"  placeholder="Lable On Screen" ></td><td><input type="number" name="screen_count[]" value="'.set_value('screen_count[]',$details_row->no_of_screen).'"    placeholder="No. Of Screen"></td></tr>';
										}

										
										
									}

								?>

				</table>				
			
		
</div>
<div class="middle_form_design">

	
		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" >Update</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

</div>
		
</form>
<?php endforeach;?>	

		
				
				
				
				
			