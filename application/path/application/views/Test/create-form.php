 
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		
		$('input[name="jobcard_no[]"]').each(function(){
			$(this).autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_bodymaking_autocomplete');?>", {selectFirst: true});
			// $(this).bind('blur',function(){
			// 	alert();
			// });
		});
			       				

			
		$("#add").live('click',function () {
			var header_row=1;
			var counter=$("#table_article tr").length;
			var mark_up='<tr id="tr_'+ counter +'"><td>JOB '+counter+'</td><td><input type="text" name="jobcard_no[]" id="jobcard_no[]" /></td><td><input type="number" name="total_sleeve_produced[]"  id="total_sleeve_produced[]" /></td></tr>';

				//alert(mark_up);
				$("#table_article").append(mark_up);				

				// var inps = document.getElementsByName('jobcard_no[]');
				// alert(inps.length);
				// for (var i = 0; i <inps.length; i++) {					
				// 	var inp=inps[i];
				// 	inp.autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_bodymaking_autocomplete');?>", {selectFirst: true});
				// 	alert(inp.val());
					    
				// }

				$('input[name="jobcard_no[]"]').each(function(){

					$(this).autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_bodymaking_autocomplete');?>", {selectFirst: true});

					// $(this).bind('blur',function(){
					// 	alert();
					// });

				});
        	

        		
				 
					
		});


		$("#remove").click(function(e){

				var header_row=1;
				var counter=$("#table_article tr").length;
				counter=counter-header_row;
				if(counter>1){
					if(confirm('Confirm delete!')){
						$("#tr_"+counter).remove();
					}
				}
				else{
					alert('No more textbox to remove');
				}
			
									
		});

		




	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_input_array_example');?>" method="POST" >
	<!-- <form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	 --><div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design" style="white-space:nowrap;">
			<tr>
				<td width="55%">
					
					<table class="form_table_inner">									
						<tr>
							<td class="label">Production Date <span style="color:red;">*</span> :</td>
							<td><input type="date" name="production_date"   value="<?php echo set_value('production_date',date('Y-m-d'));?>" />
							</td>							 
						</tr>
					</table>
				</td>							
			</tr>
		</table>					
	</div>

	<div class="middle_form_design">
		<div class="middle_form_inner_design">
			<div class="ui buttons">
				<input type="button" value="Remove" id="remove" class="ui button">
				<div class="or"></div>
				<input type="button" value="Add" id="add" class="ui positive button">
			</div>

			<br/><br/>
			<table class="middle_form_table_design" id="table_article">
				<tr>
					<th>Sr No.</th>
					<th>Jobcard No</th>									
					<th>Total Sleeve Produced (Qty)</th>					
					 					
				</tr>
				<?php

									if(!empty($this->input->post('jobcard_no[]'))){
										$j=1;
										for($i=0;$i<count($this->input->post('jobcard_no[]'));$i++)	{

											echo'<tr id="'.$j.'">
											<td>JOB-'.$j.'</td>
											<td><input type="text" name="jobcard_no[]" id="jobcard_no[]" value="'.set_value('jobcard_no[]').'" />
											</td>
											<td><input type="number" name="total_sleeve_produced[]" id="total_sleeve_produced[]" value="'.set_value('total_sleeve_produced[]').'" />
											</td>
											</tr>';

											$j++;

										}
									} 
									else{
										echo'<tr id="1">
										<td>JOB-1</td>
										<td>
											<input type="text" name="jobcard_no[]" id="jobcard_no[]" value="'.set_value('jobcard_no[]').'" >
										</td>
										<td>
										<input type="number" name="total_sleeve_produced[]" id="total_sleeve_produced[]" value="'.set_value('total_sleeve_produced[]').'"/>
										</td>
										</tr>';
									}							 

								?>
	

				

				
			</table>
		</div>
	</div>
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to save record!');">Save</button>
		</div>
	</div>	
</form>




				
				
				
			