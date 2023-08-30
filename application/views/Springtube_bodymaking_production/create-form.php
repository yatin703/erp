
<style type="text/css">
	/* The Modal (background) */
	.modal {
	  display: none; /* Hidden by default */
	  position: fixed; /* Stay in place */
	  z-index: 1; /* Sit on top */
	  padding-top: 100px; /* Location of the box */
	  left: 0;
	  top: 0;
	  width: 100%; /* Full width */
	  height: 100%; /* Full height */
	  overflow: auto; /* Enable scroll if needed */
	  background-color: rgb(0,0,0); /* Fallback color */
	  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modal-content {
	  	background-color: #fefefe;
	  	margin: auto;
	  	padding: 20px;
	  	border: 1px solid #888;
	 	width: 80%;
	}

	/* The Close Button */
	.close {
	  	color: #aaaaaa;
	  	float: right;
	  	font-size: 28px;
	  	font-weight: bold;
	}

	.close:hover,
	.close:focus {
	  	color: #000;
	  	text-decoration: none;
	  	cursor: pointer;
	}

	table {
		width:90%;
	    border-collapse: collapse;
	    /*text-align: center;*/
	}

	table, td, th {
	  	border: 1px solid black;
	}

	input[type=number]{
    	width: 150px;
    }	
	</style>
  
<script type="text/javascript">	
	// Get the modal
	var modal = document.getElementById("myModal");

	// Get the button that opens the modal
	//var btn = document.getElementById("myBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsById("span_order");

	// When the user clicks on the button, open the modal
	// btn.onclick = function() {
	//   modal.style.display = "block";
	// }

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
	    modal.style.display = "none";
	  }
	}
</script>


<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		//$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no_1").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_bodymaking_autocomplete');?>", {selectFirst: true});				
		
		
		$("#add").live('click',function () {
			var header_row=1;
			var counter=$("#table_article tr").length;
			var mark_up='<tr id="tr_'+ counter +'"><td><input type="hidden" name="sr_no[]" value="'+counter+'"/>JOB '+counter+'</td><td><input type="text" name="jobcard_no_'+counter+'"  id="jobcard_no_'+counter+'" class="quantity" value="<?php echo set_value('jobcard_no_"+counter+"');?>" maxlength="50" size="20" required/></td><td><input type="number" name="total_sleeve_produced_'+counter+'"  id="total_sleeve_produced_'+counter+'" class="quantity" value="<?php echo set_value('total_sleeve_produced_"+counter+"');?>" min="1" max="80000" step="1" size="20" required maxlength="10"/></td><td><input type="number" name="sleeve_with_heading_'+counter+'"  id="sleeve_with_heading_'+counter+'" class="quantity" value="<?php echo set_value('sleeve_with_heading_"+counter+"');?>" min="1" max="80000" step="1" size="20" required maxlength="10"/></td><td><input type="number" name="sleeve_with_cap_'+counter+'"  id="sleeve_with_cap_'+counter+'" class="quantity" value="<?php echo set_value('sleeve_with_cap_"+counter+"');?>" min="1" max="80000" step="1" size="20" required maxlength="10"/></td><td><input type="checkbox" name="bodymaking_done_'+counter+'" value="1" <?php echo set_checkbox('bodymaking_done_"+counter+"',0,false);?> title="Is complete Bodymaking done for this Jobcard?"></td></tr>';

				//alert(mark_up);
				$("#table_article").append(mark_up);

				$("#jobcard_no_"+counter).autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_bodymaking_autocomplete');?>", {selectFirst: true});

				$("#jobcard_no_"+counter).bind('blur',function() {			

					$("#loading").hide(); $("#cover").hide();
				    var jobcard_no = $('#jobcard_no_'+counter).val();
				    var jobcard_no_length=jobcard_no.length;
				    //alert(jobcard_no_length);
				   		    
				    if(jobcard_no_length==15){
				   		
					    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/get_bodymaking_jobcard_details_autocomplete",data: {jobcard_no : $('#jobcard_no_'+counter).val()},cache: false,success: function(html){
					    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
					    		//alert(html);
					       	$("#p_order_details").html(html);
					       	var modal = document.getElementById("myModal");
					       	modal.style.display = "block";

					    	} 
					    });
					   
				    }				   

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

		$("#jobcard_no_1").bind('blur',function() {			

			$("#loading").hide(); $("#cover").hide();
		   var jobcard_no = $('#jobcard_no_1').val();
		   var jobcard_no_length=jobcard_no.length;
		   //alert(jobcard_no_length);
		   		    
		    if(jobcard_no_length==15){
		   		
			    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/get_bodymaking_jobcard_details_autocomplete",data: {jobcard_no : $('#jobcard_no_1').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
			       	$("#p_order_details").html(html);
			       	var modal = document.getElementById("myModal");
			       	modal.style.display = "block";

			    	} 
			    });
			   
		    }		   

   		});

   		$("#span_order").click(function(e){

   			var modal = document.getElementById("myModal");
   			modal.style.display = "none";
												
		});





	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design" style="white-space:nowrap;">
			<tr>
				<td width="55%">
					
					<table class="form_table_inner">									
						<tr>
							<td class="label">Production Date <span style="color:red;">*</span> :</td>
							<td><input type="date" name="production_date"   value="<?php echo set_value('production_date',date('Y-m-d'));?>" /></td>
							<td class="label">Shift <span style="color:red;">*</span> :</td>
							<td><select class="ui dropdown" name="shift" id="shift" ><option value=''>--Select Shift--</option>
							<?php if($springtube_shift_master==FALSE){
									echo "<option value=''>--Setup Required--</option>";
									}
									else{
										foreach($springtube_shift_master as $shift_row){
											echo "<option value='".$shift_row->shift_id."'  ".set_select('shift',''.$shift_row->shift_id.'').">".$shift_row->shift_name."</option>";
										}
							}?>
								</select>
							</td>
						</tr>						
						<tr>
							<td class="label">Process Name <span style="color:red;">*</span> :</td>
							<td><select class="ui dropdown" name="process" id="process" disabled><option value=''>--Select Process-</option>
							<?php   if($springtube_process_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";
									}
									else{
										foreach($springtube_process_master as $process_row){
											$selected=($process_row->process_id=='5'?'selected':'');
											echo "<option value='".$process_row->process_id."'  ".set_select('process',''.$process_row->process_id.'').$selected.">".$process_row->process_name."</option>";
										}
									}?>
								</select>
							</td>
						<td class="label">Machine <span style="color:red;">*</span> :</td>
							<td><select class="ui dropdown" name="machine" id="machine" ><option value=''>----Select Machine-----</option>
							<?php  if($springtube_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";
									}
								    else{
									foreach($springtube_machine_master as $machine_row){
										$selected=($machine_row->machine_id==3?'selected':'');
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').$selected.">".$machine_row->machine_name."</option>";
									}
								}?>
							</select></td>
						</tr>
						<tr>
							<td class="label">Qc Incharge Name: <span style="color:red;">*</span> :</td>
							<td><div class="ui input"><input type="text" name="qc_incharge" id="qc_incharge"  value="<?php echo set_value('qc_incharge');?>" maxlength="100" size="20" required/>
							</div></td>
						</tr>
					</table>
							
				</td>
				<td>
					<table>
						<tr>
							<td class="label">Shift Issues :</td>
							<td><select name="shift_issue[]" id="shift_issue[]" multiple size="6"><option value=''>--Select shift issues--</option>
							<?php if($springtube_shift_issues_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_shift_issues_master as $shift_issues_master_row){
										
										echo "<option value='".$shift_issues_master_row->shift_issue."'  ".set_select('shift_issue[]',$shift_issues_master_row->shift_issue).">".$shift_issues_master_row->shift_issue."</option>";
									}
							}?>
							</select></td>
						</tr>

						<tr>
							<td class="label">Remarks :</td>
							<td>
								<textarea name="remarks" id="remarks" cols="40" rows="3" value="<?php echo trim(set_value('remarks'));?>" maxlength="500">
								<?php echo trim(set_value('remarks'));?>	
								</textarea>
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
					<th>Sleeve with Heading (Qty)</th>
					<th>Sleeve with Cap (Qty)</th>
					<th>Is Job Finished? </th>					
				</tr>

			<?php
				if(!empty($this->input->post('sr_no'))){

					$total_quantity=0;

					for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){?>

						<script>
							$(document).ready(function(){

								$("#loading").hide(); $("#cover").hide();

								$("#jobcard_no_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_bodymaking_autocomplete');?>", {selectFirst: true});

								$("#jobcard_no_<?php echo $i;?>").bind('blur',function() {			

									$("#loading").hide(); $("#cover").hide();
								    var jobcard_no = $('#jobcard_no_<?php echo $i;?>').val();
								    var jobcard_no_length=jobcard_no.length;
								    //alert(jobcard_no_length);
								   		    
								    if(jobcard_no_length==15){
								   		
									    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/get_bodymaking_jobcard_details_autocomplete",data: {jobcard_no : $('#jobcard_no_<?php echo $i;?>').val()},cache: false,success: function(html){
									    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
									    		//alert(html);
									       	$("#p_order_details").html(html);
									       	var modal = document.getElementById("myModal");
									       	modal.style.display = "block";

									    	} 
									    });
									   
								    }		   

						   		});

							});
						</script>
						<tr id="tr_<?php echo $i;?>">
							<td><input type="hidden" name="sr_no[]" value="<?php echo $i;?>"/>JOB <?php echo $i;?>
							</td>
							<td>
							<input type="text" name="jobcard_no_<?php echo $i;?>"  id="jobcard_no_<?php echo $i;?>" class="quantity" value="<?php echo set_value('jobcard_no_'.$i.'');?>" maxlength="50" size="20" required/>
							</td>
							<td>
								<input type="number" name="total_sleeve_produced_<?php echo $i;?>"  id="sleeve_produced_<?php echo $i;?>" class="quantity" value="<?php echo set_value('total_sleeve_produced_'.$i.'');?>" min="1" max="80000" step="1" size="40" required maxlength="10"/>
							</td>
							<td>
								<input type="number" name="sleeve_with_heading_<?php echo $i;?>"  id="sleeve_with_heading_<?php echo $i;?>" class="quantity" value="<?php echo set_value('sleeve_with_heading_'.$i.'');?>" min="1" max="80000" step="1" size="40" maxlength="10" required/>
							</td>
							<td>
								<input type="number" name="sleeve_with_cap_<?php echo $i;?>"  id="sleeve_with_cap_<?php echo $i;?>" class="quantity" value="<?php echo set_value('sleeve_with_cap_'.$i.'');?>" min="1" max="80000" maxlength="10" step="1" size="40" required/>
							</td>
							<td>
							<input type="checkbox" name="bodymaking_done_<?php echo $i;?>" value="1" <?php echo set_checkbox('bodymaking_done_<?php echo $i;?>',0,false);?> title="Is complete Bodymaking done for this Jobcard?" >
							</td>							
						</tr>
					<?php 
					
						$total_quantity+=$this->input->post('quantity_'.$i.'');
					}

				}else{ 
			?>

					<tr id="tr_1">

						<td>
							<input type="hidden" name="sr_no[]" value="1"/>JOB 1
						</td>					
						<td>
							<input type="text" name="jobcard_no_1"  id="jobcard_no_1" class="quantity" value="<?php echo set_value('jobcard_no_1');?>" maxlength="50" size="20" required />
						</td>
						<td>
							<input type="number" name="total_sleeve_produced_1"  id="total_sleeve_produced_1" class="quantity" value="<?php echo set_value('total_sleeve_produced_1');?>" maxlength="10" min="1" max="80000" step="1" size="30" required/>
						</td>
						<td>
							<input type="number" name="sleeve_with_heading_1"  id="sleeve_with_heading_1" class="quantity" value="<?php echo set_value('sleeve_with_heading_1');?>" maxlength="10" size="30" min="1" max="80000" step="1" required />
						</td>
						<td>
							<input type="number" name="sleeve_with_cap_1"  id="sleeve_with_cap_1" class="quantity" value="<?php echo set_value('sleeve_with_cap_1');?>" size="30" maxlength="10" min="1" max="80000" step="1" required />
						</td>
						<td>
							<input type="checkbox" name="bodymaking_done_1" value="1" <?php echo set_checkbox('bodymaking_done_1',0,false);?> title="Is complete Bodymaking done for this Jobcard?" >
						</td>

					</tr>
				
			<?php
				
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

	<div id="myModal" class="modal">
		<div class="modal-content" >
            <span class="close" id="span_order">&times;</span>
            <p id="p_order_details"></p>
        </div>    
	</div>	

	
</form>




				
				
				
			