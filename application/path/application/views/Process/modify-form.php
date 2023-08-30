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



});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design ">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<?php foreach ($workprocedure_types_master as $workprocedure_types_master_row) :?>
				
			<tr>
				<td>
					<table class="form_table_inner">
									<tr>
										<td class="label">Main Group  :</td>
										<td><select name="main_group" id="main_group"><option value="">--Select Main Group--</option>
										<?php if($main_group==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($main_group as $main_group_row){
													$selected=($main_group_row->main_group_id==$workprocedure_types_master_row->main_group_id?'selected':'');
													
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
													
													$selected=($sub_group_row->article_group_id==$workprocedure_types_master_row->article_group_id?'selected':'');

													echo "<option value='".$sub_group_row->article_group_id."'  ".set_select('sub_group',''.$sub_group_row->article_group_id.'')." ".$selected.">".strtoupper($sub_group_row->sub_group)."-".$sub_group_row->article_group_id."</option>";
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
													$selected=($second_sub_group_row->sub_sub_grp_id==$workprocedure_types_master_row->sub_sub_grp_id?'selected':'');

													echo "<option value='".$second_sub_group_row->sub_sub_grp_id."'  ".set_select('second_sub_group',''.$second_sub_group_row->sub_sub_grp_id.'')." ".$selected.">".strtoupper($second_sub_group_row->second_sub_group)."</option>";
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Work Procedure Type * :</td>
										<td>
											<input type="text" name="lang_description" id="lang_description" value="<?php echo set_value('lang_description',$workprocedure_types_master_row->lang_description);?>" size="20"/>
										</td>
									</tr>
									<tr>
										<td class="label">Tube Process * :</td>
										<td>
											<select name="tube_process_id" id="tube_process_id" >
												<option value="">--Select Tube Process--</option>							 
												<option value="1" <?php echo set_select('tube_process_id',1);?>  <?php echo($workprocedure_types_master_row->tube_process_id=='1'?"selected":"");?>>COEX</option>
												<option value="2" <?php echo set_select('tube_process_id',2);?> <?php echo($workprocedure_types_master_row->tube_process_id=='2'?"selected":"");?>>SPRING</option>
																								
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Position :</td>
										<td colspan="3"><input type="number"  name="position"  id="position" size="5" maxlength="5" value="<?php echo set_value('position',$workprocedure_types_master_row->position);?>">
										</td>
									</tr>

									


									<tr>
										<td class="label">Rejection % :</td>
										<td><input type="text" name="rejection_perc" id="rejection_perc" maxlength="5" size="20" value="<?php echo set_value('rejection_perc',$this->common_model->read_number($workprocedure_types_master_row->rejection_perc,$this->session->userdata['logged_in']['company_id']));?>">

											<input type="hidden" name="work_proc_type_id"  value="<?php echo set_value('work_proc_type_id',$workprocedure_types_master_row->work_proc_type_id);?>" />

										</td>
									</tr>
												
									
					</table>				
				</td>
							
			</tr>
			<?php endforeach;?>
		</table>					
	</div>

	<div class="form_design">
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			