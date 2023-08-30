<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		//$("#loading").hide(); $("#cover").hide();
		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax/spring_so_no_for_production');?>", {selectFirst: true});	


		$("#order_no").live('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');

			if($("#order_no").val()!='' && $("#order_no").val().length>='13'){
				//$("#article_no").html('');
				$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax_springtube/spsm_spsp_no');?>",data: {order_no : $("#order_no").val()},cache: false,success: function(html){
					setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
					
					$("#article_no").html(html);

					} 
				});
			}
		});

		$("#order_no").blur(function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');

			var order_no=$("#order_no").val();
			//alert($("#order_no").val().length);
			if($("#order_no").val()!='' && $("#order_no").val().length>='13'){
				//$("#article_no").html('');
				$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax_springtube/spsm_spsp_no');?>",data: {order_no : $("#order_no").val()},cache: false,success: function(html){
					setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
					
					$("#article_no").html(html);

					} 
				});
			}

		});

		$("#article_no").change(function(){

			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			
			if($("#article_no").val()!=''){
				//$("#article_no").html('');
				$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax_springtube/spring_extrusion_jobcards');?>",data: {article_no : $("#article_no").val()},cache: false,success: function(html){
					setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
					
					$("#jobcard_no").html(html);

					} 
				});
			}
		});

		$("#jobcard_no").change(function(){

			//alert($("#jobcard_no").val());
			$("#actual_qty_manufactured").val('');
			$("#reels_planned").val('');		
			
			if($("#jobcard_no").val()!=''){
				
				//$("#article_no").html('');
				$.ajax({type: "POST",
					url: "<?php echo base_url('index.php/ajax_springtube/jobcard_qty_to_reels');?>",
					data: {jobcard_no : $("#jobcard_no").val()},
					cache: false,
					success: function(html){
					//setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
					//alert(html);
					var arr=html.split("//");
					$("#actual_qty_manufactured").val(arr[0]);
					$("#reels_planned").val(arr[1]);

					},
					beforeSend: function(){
						$("#loading").show();
						$("#cover").show();
						$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');	
												
					},
					complete: function(){
						$("#loading").hide();
						$("#cover").hide();
											
					}  
				});
			}else{
				$("#actual_qty_manufactured").val('');
				$("#reels_planned").val('');
			}
		});

		$("#reels_produced").blur(function(){			
						
			if($("#reels_produced").val()!=''){

				$.ajax({
					type: "POST",
					url: "<?php echo base_url('index.php/ajax_springtube/jobcard_reels_to_qty');?>",
					data: {jobcard_no : $("#jobcard_no").val(), reels_produced : $("#reels_produced").val()},
					cache: false,
					success: function(html){

					$("#expected_tubes").val(html);

					},
					beforeSend: function(){
						$("#loading").show();
						$("#cover").show();
						$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');											
					},
					complete: function(){
						$("#loading").hide();
						$("#cover").hide();											
					}  
				});
			}else{				
				$("#expected_tubes").val('');
			}
		});




	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
	<?php foreach($springtube_extrusion_production_master as $row): ?>	
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

						<tr>
							<td class="label">Production Date <span style="color:red;">*</span> :</td>
							<td>
								<input type="hidden" name="production_id" value="<?php echo $row->production_id;?>">
								<input type="date" name="production_date"   value="<?php echo set_value('production_date',$row->production_date);?>" /></td>
						</tr>
						<tr>
							<td class="label">Process Name <span style="color:red;">*</span> :</td>
							<td><select name="process" id="process" readonly><option value=''>--Select Process--</option>
							<?php if($springtube_process_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_process_master as $process_row){
										$selected=($process_row->process_id==1?'selected':'');
										echo "<option value='".$process_row->process_id."'  ".set_select('process',''.$process_row->process_id.'').$selected.">".$process_row->process_name."</option>";
									}
							}?>
							</select></td>
						</tr>
						 <tr>
							<td class="label">Operator Name <span style="color:red;">*</span> :</td>
							<td><select name="operator" id="operator"><option value=''>--Select Operator--</option>
							<?php if($springtube_operator_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_operator_master as $springtube_operator_master_row){
										$selected=($springtube_operator_master_row->operator_id==$row->operator_id?'selected':'');
										echo "<option value='".$springtube_operator_master_row->operator_id."'  ".set_select('operator',''.$springtube_operator_master_row->operator_id.'').$selected.">".$springtube_operator_master_row->operator_name."</option>";
									}
							}?>
							</select></td>
						</tr>
						<tr>
							<td class="label">Shift <span style="color:red;">*</span> :</td>
							<td><select name="shift" id="shift"><option value=''>--Select Shift--</option>
							<?php if($springtube_shift_master==FALSE){
									echo "<option value=''>--Setup Required--</option>";
								}
								else{
									foreach($springtube_shift_master as $shift_row){
										$selected=($shift_row->shift_id==$row->shift_id?'selected':'');
										echo "<option value='".$shift_row->shift_id."'  ".set_select('shift',''.$shift_row->shift_id.'').$selected.">".$shift_row->shift_name."</option>";
									}
							}?>
							</select></td>
						</tr>
									
				</table>			
								
			</td>
			<td>
					<table class="form_table_inner">

						<tr>
							<td class="label">Sales Order No. <span style="color:red;">*</span>:</td>
							<td><input type="text" name="order_no" id="order_no" size="20" value="<?php echo set_value('order_no',$row->order_no);?>"/></td>
						</tr>

						<tr>
							<td class="label">SPSM/SPSP No. <span style="color:red;">*</span> :</td>
							<td><select name="article_no" id="article_no">
							<option value='<?php echo $row->article_no;?>'><?php echo $row->article_no;?></option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Job card No. <span style="color:red;">*</span> :</td>
							<td><select name="jobcard_no" id="jobcard_no">
								<option value='<?php echo $row->jobcard_no;?>'><?php echo $row->jobcard_no;?></option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Job Qty. <span style="color:red;">*</span> :</td>
							<td><input type="text" name="actual_qty_manufactured" id="actual_qty_manufactured" size="20" value="<?php echo set_value('actual_qty_manufactured',$row->jobcard_qty);?>" readonly/></td>
						</tr>

						<tr>
							<td class="label">No. Of Reels Planned <span style="color:red;">*</span>:</td>
							<td><input type="text" name="reels_planned" id="reels_planned" size="20" value="<?php echo set_value('reels_planned',$row->reels_planned);?>"/></td>
						</tr>

						<tr>
							<td class="label">No. Of Reels Produced <span style="color:red;">*</span>:</td>
							<td><input type="text" name="reels_produced" id="reels_produced" size="20" value="<?php echo set_value('reels_produced',$row->reels_produced);?>"/></td>
						</tr>
						<tr>
							<td class="label">Expected tubes <span style="color:red;">*</span>:</td>
							<td><input type="text" name="expected_tubes" id="expected_tubes" size="20" value="<?php echo set_value('expected_tubes',$row->expected_tubes);?>"/></td>
						</tr>

					</table>
			</td>
				
							
			</tr>
		</table>

	<?php endforeach;?>	
					
	</div>

	<div class="form_design">
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>

<?php if($this->input->post('order_no')!=''){?>

	<script>
		$(document).ready(function(){

			if($("#order_no").val()!='' && $("#order_no").val().length>='13'){
				//$("#article_no").html('');
				$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax_springtube/spsm_spsp_no');?>",data: {order_no : $("#order_no").val()},cache: false,success: function(html){								
					$("#article_no").html(html);
					} 
				});
			}

			if($("#article_no").val()!=''){
					//$("#article_no").html('');
				$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax_springtube/spring_extrusion_jobcards');?>",data: {article_no : $("#article_no").val()},cache: false,success: function(html){
					setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
					
					$("#jobcard_no").html(html);

					} 
				});
			}		

		});	
		
			
<?php } ?>



	</script>
		
</form>			
				
				
			