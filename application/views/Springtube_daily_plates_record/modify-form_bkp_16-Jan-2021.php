<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();
		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax/so_no');?>", {selectFirst: true});
		//$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		// if($('#order_no').val()!=''){
		// 	$.ajax({
		// 		type: "POST",
		// 		url: "<?php echo base_url(); ?>" + "index.php/ajax/psm_psp_no",
		// 		data: {order_no : $('#order_no').val()},cache: false,
		// 		success: function(html){
		// 	    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		// 	    		//alert(html);
		// 	    	$("#article_no").html(html);
		// 	    } 
		// 	});

		// }


		$("#order_no").bind('keyup blur',function() {
			$("#loading").hide(); $("#cover").hide();
		    var order_no = $('#order_no').val();
		    var order_no_length=order_no.length;
		    //if(order_no_length==13){
		   	$("#article_no").html("<option value=''>--Please Select--</option>");
			$("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "index.php/ajax/psm_psp_no",data: {order_no : $('#order_no').val()},
				cache: false,
				success: function(html){
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
	    	$.ajax({
	    		type: "POST",
	    		url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_printing_jobcards",
	    		data: {article_no : article_no,order_no : $('#order_no').val() },
	    		cache: false,
	    		success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
			       $("#jobcard_no").html(html);
			    } 
			});

	    	$.ajax({
	    		type: "POST",
	    		url: "<?php echo base_url(); ?>" + "index.php/ajax/get_artwork_details",
	    		data: {order_no : $('#order_no').val(),article_no : article_no },
	    		cache: false,
	    		success: function(html){
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
			var markup = '<tr id="'+ counter +'"><td><input type="checkbox" name="record"></td><td><select name="artwork_para_id[]"><option value="18">Flexo</option></select><td><input type="text" name="pantone[]" placeholder="Pantone Name"></td><td><input type="date"  name="date_on_plate[]" placeholder="Date On Plate"/></td><td><input type="text" name="label_on_plate[]" placeholder="Label On Plate" ></td><td><input type="number" name="plate_count[]"  placeholder="No. of Plates"></td></tr>';
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
			if($("#ups").val()==""){
				alert('Select the Ups');
				$("#ups").focus();
				return false;
			}
			if($("#repeat").val()==""){
				alert('Select the Repeat');
				$("#repeat").focus();
				return false;
			}
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
				alert('Select the Plate Making Reason');
				$("#reason_id").focus();
				return false;
			}
			 		
			
			var flag_pantone=1;
			$("#tablePanton").find('input[name="pantone[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_pantone=0;
				}
								
			});

			var flag_plate_nature=1;
			$("#tablePanton").find('input[name="artwork_para_id[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_plate_nature=0;
				}
								
			});

			var flag_plate_date=1;
			$("#tablePanton").find('input[name="date_on_plate[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_plate_date=0;
				}
								
			});

			var flag_plate_label=1;
			$("#tablePanton").find('input[name="label_on_plate[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_plate_label=0;
				}
								
			});

			var flag_plate_count=1;
			$("#tablePanton").find('input[name="plate_count[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_plate_count=0;
				}
								
			});

			if(flag_pantone==0 || flag_plate_nature==0 || flag_plate_date==0 || flag_plate_label==0 || flag_plate_count==0){
				alert('Enter all the Plate Details');
				return false;

			}

			return true;


         });
	



	});
</script>

<?php foreach ($springtube_daily_plates_master as $springtube_daily_plates_master_row):?>
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
							<td class="label">Order No.<span style="color:red;">*</span> :</td>
							<td>
								<input type="hidden" name="dpr_id" value="<?php echo set_value('dpr_id',$springtube_daily_plates_master_row->dpr_id );?>" />
								<input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$springtube_daily_plates_master_row->order_no);?>" required placeholder="Order No"/></td>
							<td class="label">SPSM/SPSP No.<span style="color:red;">*</span> :</td>
							<td>
								<select name="article_no" id="article_no" >
									<option value="<?php echo $springtube_daily_plates_master_row->article_no;?>"><?php echo $springtube_daily_plates_master_row->article_no;?></option>	
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Artwork<span style="color:red;">*</span> :</td>
							<td><input type="text" name="artwork_no" id="artwork_no"  size="20" value="<?php echo set_value('artwork_no',$springtube_daily_plates_master_row->artwork_no);?>"   placeholder="Artwork" readonly/></td>
							<td class="label">Version<span style="color:red;">*</span> :</td>
							<td><input type="text" name="version_no" id="version_no"  size="20" value="<?php echo set_value('version_no',$springtube_daily_plates_master_row->version_no);?>"    placeholder="Version" readonly/></td>
						</tr>
						<tr>
							<td class="label">Jobcard No. <span style="color:red;">*</span> :</td>
							<td><select name="jobcard_no" id="jobcard_no" >
									<option value="<?php echo $springtube_daily_plates_master_row->jobcard_no;?>"><?php echo $springtube_daily_plates_master_row->jobcard_no;?></option>	
								</select>
							</td>
							<td class="label">Shift  <span style="color:red;">*</span> :</td>
							<td><select name="shift_id" id="shift_id">					
										<option value="">--Please Select--</option>
										<?php if($graphics_shift_master==FALSE){
											echo'<option>--Setup Required--</option>';
										}
										else{
											foreach ($graphics_shift_master as $row) {
												$selected=($springtube_daily_plates_master_row->shift_id==$row->shift_id?'selected':'');

												echo'<option value="'.$row->shift_id.'" '.set_select('shift_id',$row->shift_id).' '.$selected.'>'.$row->shift_name.'</option>';
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
							
							<td class="label">Ups  <span style="color:red;">*</span> :</td>
							<td><input type="number" name="ups" id="ups"  size="20" value="<?php echo set_value('ups',$springtube_daily_plates_master_row->ups);?>" min="1" max="3" steps="1"  required/></td>
							<td class="label">Repeat  <span style="color:red;">*</span> :</td>
							<td><input type="number" name="repeat" id="repeat"  size="20" value="<?php echo set_value('repeat',$springtube_daily_plates_master_row->repeat);?>" min="1" max="10" steps="1" requird /></td>
						</tr>
						<tr>
							<td class="label">Reason<span style="color:red;">*</span> :</td>
							<td><select name="reason_id" id="reason_id">					
								<option value="">--Please Select--</option>
								<?php if($graphics_plate_making_reasons==FALSE){
									echo'<option>--Setup Required--</option>';
								}
								else{
									foreach ($graphics_plate_making_reasons as $row) {
										$selected=($springtube_daily_plates_master_row->plate_making_reason==$row->reason_id?'selected':'');
										echo'<option value="'.$row->reason_id.'" '.set_select('reason_id',$row->reason_id).''.$selected.'>'.$row->reason.'</option>';
									}
								}?>
								</select>
							</td>
							<td class="label">Comment  <span style="color:red;">*</span> :</td>
							<td ><textarea name="comment" value="<?php echo set_value('comment',$springtube_daily_plates_master_row->comment);?>"><?php echo set_value('comment',$springtube_daily_plates_master_row->comment);?></textarea></td>
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
										<th>Plate Nature</th>
										<th>Pantone Name</th>
										<th>Date On Plate</th>
										<th>Label On Plate</th>
										<th>No. Of Plates</th>
										
								</tr>
								

								<?php

									if(!empty($this->input->post('pantone[]'))){
										$j=1;
										for($i=0;$i<count($this->input->post('pantone[]'));$i++){

											echo'<tr id="'.$j++.'">
												<td><input type="checkbox" name="record"></td>
												<td><select name="artwork_para_id[]">			
													<option value="18">Flexo</option></select>
												</td> 
												<td><input type="text" name="pantone[]"   value="'.set_value("pantone[]").'"  placeholder="Pantone Name"></td>
												<td><input type="date" name="date_on_plate[]" value="'.set_value('date_on_plate[]').'"   placeholder="Date On Plate"/></td>
												<td><input type="text"   name="label_on_plate[]" value="'.set_value('label_on_plate[]').'"  placeholder="Lable On Plate" ></td>
												<td><input type="number" name="plate_count[]" value="'.set_value('plate_count[]').'"    placeholder="No. Of Plate"></td></tr>';

										}
										
									} 
									else{

										$result_springtube_daily_plates_details=$this->common_model->select_one_details_record_noncompany('springtube_daily_plates_details','dpr_id',$springtube_daily_plates_master_row->dpr_id);

										$j=1;
										foreach($result_springtube_daily_plates_details as $details_row ){

											echo'<tr id="'.$j++.'">
												<td><input type="checkbox" name="record"></td>
												<td><select name="artwork_para_id[]">		
														<option value="18">Flexo</option>
													</select>
												</td>';
												echo'<td><input type="text"   name="pantone[]"   value="'.set_value("pantone[]",$details_row->pantone_name).'"  placeholder="Pantone Name"></td>
												<td><input type="date" name="date_on_plate[]" value="'.set_value('date_on_plate[]',$details_row->date_on_plate).'"   placeholder="Date On Plate"/></td>
												<td><input type="text"   name="label_on_plate[]" value="'.set_value('label_on_plate[]',$details_row->label_on_plate).'"  placeholder="Lable On Plate" ></td>
												<td><input type="number" name="plate_count[]" value="'.set_value('plate_count[]',$details_row->no_of_plates).'"    placeholder="No. Of Plate"></td>
											</tr>';
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

		
				
				
				
				
			