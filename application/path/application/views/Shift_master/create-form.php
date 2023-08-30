<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		//$("#loading").hide(); $("#cover").hide();				
		
		
		$("#add").live('click',function () {
			var header_row=1;
			var counter=$("#table_article tr").length;
			var mark_up='<tr id="tr_'+ counter +'"><td><input type="hidden" name="sr_no[]" value="'+counter+'"/>SHIFT '+counter+'</td><td><input type="time" name="shift_start_time_'+counter+'"  id="shift_start_time'+counter+'" class="quantity" value="<?php echo set_value('shift_start_time_"+counter+"');?>"  /></td><td><input type="time" name="shift_end_time_'+counter+'"  id="shift_end_time'+counter+'" class="quantity" value="<?php echo set_value('shift_end_time_"+counter+"');?>" /></td></tr>';

				//alert(mark_up);
				$("#table_article").append(mark_up);									
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
							<td class="label" >Shift From Date <span style="color:red;">* </span> :</td>
							<td><input type="date" name="shift_start_date" id="shift_start_date" value="<?php echo set_value('shift_start_date');?>">
							<input type="date" name="shift_end_date" id="shift_end_date" value="<?php echo set_value('shift_end_date');?>"></td>
						</tr>

						<tr>
							<td class="label">Machine Name <span style="color:red;">* </span> :</td>
							<td><select name="machine_id"><option value=''>--Select Machine --</option>
							<?php if($machine==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($machine as $machine_row){
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine_id',''.$machine_row->machine_id.'').">".$machine_row->machine_name."/ Capacity Per day ".$machine_row->machine_capacity."</option>";
									}
							}?>
							</select></td>
						</tr>

						<tr>
							<td class="label" >Prefix <span style="color:red;">* </span> :</td>
							<td><input type="text" name="prefix" id="" value="<?php echo set_value('');?>">
							</td>
						</tr>

						<tr>
							<td class="label" >Start No. <span style="color:red;">* </span> :</td>
							<td><input type="number" name="start_no" id="" value="<?php echo set_value('');?>">
							</td>
						</tr>

						<tr>
							<td class="label" >Width Of Numerical Part <span style="color:red;">* </span> :</td>
							<td><input type="number" name="width_no" id="" value="<?php echo set_value('');?>">
							</td>
						</tr>

						<tr>
							<td class="label" >Prefilled with 0 <span style="color:red;">* </span> :</td>
							<td><select name="prefilled_no" id="prefilled_no">
								<option value=''>--Select Option--</option>
								<option value='yes'>Yes</option>		
								<option value='no'>No</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class="label" >Suffix  :</td>
							<td><input type="text" name="suffix" id="" value="<?php echo set_value('');?>">
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
			<table class="ui very basic collapsing celled table" id = "table_article">
				<thead>
				<tr>
					<th>Sr No.</th>
					<th>Shift from Time</th>
					<th>Shift to Time</th>										
																			
				</tr>
			</thead>
			<tbody>

			<?php
			
				if(!empty($this->input->post('sr_no'))){

					$total_quantity=0;

					for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){?>

							<tr id="tr_<?php echo $i;?>">
							<td><input type="hidden" name="sr_no[]" value="<?php echo $i;?>"/>SHIFT <?php echo $i;?>
							</td>
							<td>
							<input type="time" name="shift_start_time_<?php echo $i;?>"  id="shift_start_time<?php echo $i;?>" value="<?php echo set_value('shift_start_time_'.$i.'');?>"/>
							</td>
							<td>
							<input type="time" name="shift_end_time_<?php echo $i;?>"  id="shift_end_time<?php echo $i;?>" value="<?php echo set_value('shift_end_time_'.$i.'');?>" />
							</td>
														
						</tr>
					<?php 
					
					}

				}else{ 
			?>

					<tr id="tr_1">

						<td>
							<input type="hidden" name="sr_no[]" value="1"/>SHIFT 1
						</td>					
						<td>
							<input type="time" name="shift_start_time_1"  id="shift_start_time" class="quantity" value="<?php echo set_value('shift_start_time_1');?>" maxlength="50" size="20"  /></td>
						<td><input type="time" name="shift_end_time_1"  id="shift_start_time" class="quantity" value="<?php echo set_value('shift_end_time_1');?>" maxlength="50" size="20"  />

						</td>
						

					</tr>
				
			<?php
				
				}
			?>
		</tbody>
			</table>
			<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to save record!');">Save</button>
			</div>



		</div>


	</div>		


	

	<div id="myModal" class="modal">
		<div class="modal-content" >
            <span class="close" id="span_order">&times;</span>
            <p id="p_order_details"></p>
        </div>    
	</div>	

	
</form>			
				
			