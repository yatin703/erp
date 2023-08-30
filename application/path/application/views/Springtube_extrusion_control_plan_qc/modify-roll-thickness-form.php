<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});	
				
		var counter=0;
		var x = document.getElementsByName("sr_no[]");
		var counter=x.length+1;

		$("#add").live('click',function () {
			// var header_row=1;
			// var counter=$("#table_article tr").length;
			var mark_up='<tr id="tr_'+ counter +'"><td><input type="hidden" name="sr_no[]" value="'+counter+'"/>ROLL '+counter+'</td><td><input type="number" name="top_pos_1_roll_'+counter+'"  id="top_pos_1_roll_'+counter+'" value="<?php echo set_value('top_pos_1_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="top_pos_2_roll_'+counter+'"  id="top_pos_2_roll_'+counter+'" value="<?php echo set_value('top_pos_2_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="top_pos_3_roll_'+counter+'"  id="top_pos_3_roll_'+counter+'" value="<?php echo set_value('top_pos_3_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="top_pos_4_roll_'+counter+'"  id="top_pos_4_roll_'+counter+'" value="<?php echo set_value('top_pos_4_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="top_pos_5_roll_'+counter+'"  id="top_pos_5_roll_'+counter+'" value="<?php echo set_value('top_pos_5_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="top_pos_6_roll_'+counter+'"  id="top_pos_6_roll_'+counter+'" value="<?php echo set_value('top_pos_6_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="top_pos_7_roll_'+counter+'"  id="top_pos_7_roll_'+counter+'" value="<?php echo set_value('top_pos_7_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="top_pos_8_roll_'+counter+'"  id="top_pos_8_roll_'+counter+'" value="<?php echo set_value('top_pos_8_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="top_pos_9_roll_'+counter+'"  id="top_pos_9_roll_'+counter+'" value="<?php echo set_value('top_pos_9_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="top_pos_10_roll_'+counter+'"  id="top_pos_10_roll_'+counter+'" value="<?php echo set_value('top_pos_10_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="bot_pos_1_roll_'+counter+'"  id="bot_pos_1_roll_'+counter+'" value="<?php echo set_value('bot_pos_1_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="bot_pos_2_roll_'+counter+'"  id="bot_pos_2_roll_'+counter+'" value="<?php echo set_value('bot_pos_2_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="bot_pos_3_roll_'+counter+'"  id="bot_pos_3_roll_'+counter+'" value="<?php echo set_value('bot_pos_3_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="bot_pos_4_roll_'+counter+'"  id="bot_pos_4_roll_'+counter+'" value="<?php echo set_value('bot_pos_4_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="bot_pos_5_roll_'+counter+'"  id="bot_pos_5_roll_'+counter+'" value="<?php echo set_value('bot_pos_5_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="bot_pos_6_roll_'+counter+'"  id="bot_pos_6_roll_'+counter+'" value="<?php echo set_value('bot_pos_6_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="bot_pos_7_roll_'+counter+'"  id="bot_pos_7_roll_'+counter+'" value="<?php echo set_value('bot_pos_7_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="bot_pos_8_roll_'+counter+'"  id="bot_pos_8_roll_'+counter+'" value="<?php echo set_value('bot_pos_8_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="bot_pos_9_roll_'+counter+'"  id="bot_pos_9_roll_'+counter+'" value="<?php echo set_value('bot_pos_9_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td><td><input type="number" name="bot_pos_10_roll_'+counter+'"  id="bot_pos_10_roll_'+counter+'" value="<?php echo set_value('bot_pos_10_roll_"+counter+"');?>" maxlength="6" required style="width:60px;"/></td></tr>';

				//alert(mark_up);
				$("#table_article").append(mark_up);

				counter++;


					
		});


		$("#remove").click(function(){
			if(counter==2){ alert("No more textbox to remove"); return false;}
			counter--;
			$("#tr_" + counter).remove();
		});


	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update_roll_thickness');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
					<?php foreach ($springtube_extrusion_control_plan_qc as $row):?>
						<tr>
							<td class="label">Jobcard No. :</td>
							<td><input type="hidden" name="cp_id" value="<?php echo set_value('cp_id',$row->cp_id);?>">
								<input type="text" name="jobcard_no" id="jobcard_no"  size="30" value="<?php echo set_value('jobcard_no',$row->jobcard_no);?> " readonly />
							</td>
							<td class="label">Operator Name :</td>
							<td><input type="text" name="operator" id="operator"  size="30" value="<?php echo set_value('operator',$row->operator);?> " readonly />
							</td>
						</tr>
					<?php endforeach;?>	


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
		<div class="middle_form_inner_design" style="overflow: scroll;width:100%">
		<table class="middle_form_table_design" id="table_article"  >
			<tr>
			<th></th>					
				<th colspan="10">THICKNESS OF ROLL FROM TOP SIDE</th>
				<th colspan="10">THICKNESS OF ROLL FROM BOTTOM SIDE</th>
			</tr>
			<tr>
				<th>Sr No.</th>
				<th>Top Pos 1</th>									
				<th>Top Pos 2</th>					
				<th>Top Pos 3</th>
				<th>Top Pos 4</th>
				<th>Top Pos 5</th>									
				<th>Top Pos 6</th>					
				<th>Top Pos 7</th>
				<th>Top Pos 8</th>
				<th>Top Pos 9</th>									
				<th>TopPos10</th>
				<th>Bot Pos 1</th>									
				<th>Bot Pos 2</th>					
				<th>Bot Pos 3</th>
				<th>Bot Pos 4</th>
				<th>Bot Pos 5</th>									
				<th>Bot Pos 6</th>					
				<th>Bot Pos 7</th>
				<th>Bot Pos 8</th>
				<th>Bot Pos 9</th>									
				<th>BotPos10</th>
			</tr>

				<?php
					if(!empty($this->input->post('sr_no'))){

						for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){
				?>

							
							<tr id="tr_<?php echo $i;?>">
								<td>
									<input type="hidden" name="sr_no[]" value="<?php echo $i;?>"/>ROLL <?php echo $i;?>
								</td>
								
								<td>
									<input type="number" name="top_pos_1_roll_<?php echo $i;?>"  id="top_pos_1_roll_<?php echo $i;?>" value="<?php echo set_value('top_pos_1_roll_'.$i);?>" maxlength="6" required style="width:60px;" />
								</td>
								<td>
									<input type="number" name="top_pos_2_roll_<?php echo $i;?>"  id="top_pos_2_roll_<?php echo $i;?>" value="<?php echo set_value('top_pos_2_roll_'.$i);?>" maxlength="6" required style="width:60px;"/>
								</td>
								<td>
									<input type="number" name="top_pos_3_roll_<?php echo $i;?>"  id="top_pos_3_roll_<?php echo $i;?>"value="<?php echo set_value('top_pos_3_roll_'.$i);?>" maxlength="6" required style="width:60px;"/>
								</td>
								<td>
									<input type="number" name="top_pos_4_roll_<?php echo $i;?>"  id="top_pos_4_roll_<?php echo $i;?>"value="<?php echo set_value('top_pos_4_roll_'.$i);?>" maxlength="6" required style="width:60px;" />
								</td>
								<td>
									<input type="number" name="top_pos_5_roll_<?php echo $i;?>"  id="top_pos_5_roll_<?php echo $i;?>"  value="<?php echo set_value('top_pos_5_roll_'.$i);?>" maxlength="6" required style="width:60px;" />
								</td>
								<td>
									<input type="number" name="top_pos_6_roll_<?php echo $i;?>"  id="top_pos_6_roll_<?php echo $i;?>" value="<?php echo set_value('top_pos_6_roll_'.$i);?>" maxlength="6" required style="width:60px;" />
								</td>
								<td>
									<input type="number" name="top_pos_7_roll_<?php echo $i;?>"  id="top_pos_7_roll_<?php echo $i;?>"  value="<?php echo set_value('top_pos_7_roll_'.$i);?>" maxlength="6" required style="width:60px;"/>
								</td>
								<td>
									<input type="number" name="top_pos_8_roll_<?php echo $i;?>"  id="top_pos_8_roll_<?php echo $i;?>" value="<?php echo set_value('top_pos_8_roll_'.$i);?>" maxlength="6" required style="width:60px;"/>
								</td>
								<td>
									<input type="number" name="top_pos_9_roll_<?php echo $i;?>"  id="top_pos_9_roll_<?php echo $i;?>"  value="<?php echo set_value('top_pos_9_roll_'.$i);?>" maxlength="6" required  style="width:60px;"/>
								</td>
								<td>
									<input type="number" name="top_pos_10_roll_<?php echo $i;?>"  id="top_pos_10_roll_<?php echo $i;?>"  value="<?php echo set_value('top_pos_10_roll_'.$i);?>"  maxlength="6" required style="width:60px;"/>
								</td>

								<!----------BOTTOM POSITION------------------->

								<td>
									<input type="number" name="bot_pos_1_roll_<?php echo $i;?>"  id="bot_pos_1_roll_<?php echo $i;?>" value="<?php echo set_value('bot_pos_1_roll_'.$i);?>" maxlength="6" required style="width:60px;" />
								</td>
								<td>
									<input type="number" name="bot_pos_2_roll_<?php echo $i;?>"  id="bot_pos_2_roll_<?php echo $i;?>" value="<?php echo set_value('bot_pos_2_roll_'.$i);?>" maxlength="6" required style="width:60px;"/>
								</td>
								<td>
									<input type="number" name="bot_pos_3_roll_<?php echo $i;?>"  id="bot_pos_3_roll_<?php echo $i;?>"value="<?php echo set_value('bot_pos_3_roll_'.$i);?>" maxlength="6" required style="width:60px;"/>
								</td>
								<td>
									<input type="number" name="bot_pos_4_roll_<?php echo $i;?>"  id="bot_pos_4_roll_<?php echo $i;?>"value="<?php echo set_value('bot_pos_4_roll_'.$i);?>" maxlength="6" required style="width:60px;" />
								</td>
								<td>
									<input type="number" name="bot_pos_5_roll_<?php echo $i;?>"  id="bot_pos_5_roll_<?php echo $i;?>"  value="<?php echo set_value('bot_pos_5_roll_'.$i);?>" maxlength="6" required style="width:60px;" />
								</td>
								<td>
									<input type="number" name="bot_pos_6_roll_<?php echo $i;?>"  id="bot_pos_6_roll_<?php echo $i;?>" value="<?php echo set_value('bot_pos_6_roll_'.$i);?>" maxlength="6" required style="width:60px;" />
								</td>
								<td>
									<input type="number" name="bot_pos_7_roll_<?php echo $i;?>"  id="bot_pos_7_roll_<?php echo $i;?>"  value="<?php echo set_value('bot_pos_7_roll_'.$i);?>" maxlength="6" required style="width:60px;"/>
								</td>
								<td>
									<input type="number" name="bot_pos_8_roll_<?php echo $i;?>"  id="bot_pos_8_roll_<?php echo $i;?>" value="<?php echo set_value('bot_pos_8_roll_'.$i);?>" maxlength="6" required style="width:60px;"/>
								</td>
								<td>
									<input type="number" name="bot_pos_9_roll_<?php echo $i;?>"  id="bot_pos_9_roll_<?php echo $i;?>"  value="<?php echo set_value('bot_pos_9_roll_'.$i);?>" maxlength="6" required  style="width:60px;"/>
								</td>
								<td>
									<input type="number" name="bot_pos_10_roll_<?php echo $i;?>"  id="bot_pos_10_roll_<?php echo $i;?>"  value="<?php echo set_value('bot_pos_10_roll_'.$i);?>"  maxlength="6" required style="width:60px;"/>
								</td>
								
							</tr>

					<?php 
						
						}		

						}else{ 

				   ?>

				   <?php foreach ($springtube_extrusion_control_plan_qc_film_thickness as $film_thickness_row):?>

						<tr id="tr_<?php echo $film_thickness_row->roll_no;?>">

							<td>
								<input type="hidden" name="sr_no[]" value="<?php echo $film_thickness_row->roll_no;?>"/>ROLL <?php echo $film_thickness_row->roll_no;?>
							</td>					
							<td>
								<input type="number" name="top_pos_1_roll_<?php echo $film_thickness_row->roll_no;?>"  id="top_pos_1_roll_<?php echo $film_thickness_row->roll_no;?>" value="<?php echo set_value('top_pos_1_roll_'.$film_thickness_row->roll_no.'',$film_thickness_row->top_pos_1);?>" maxlength="6" required style="width:60px;" />
							</td>
							<td>
								<input type="number" name="top_pos_2_roll_<?php echo $film_thickness_row->roll_no;?>"  id="top_pos_2_roll_<?php echo $film_thickness_row->roll_no;?>" value="<?php echo set_value('top_pos_2_roll_'.$film_thickness_row->roll_no,$film_thickness_row->top_pos_2);?>" maxlength="6" required style="width:60px;"/>
							</td>
							<td>
								<input type="number" name="top_pos_3_roll_<?php echo $film_thickness_row->roll_no;?>"  id="top_pos_3_roll_<?php echo $film_thickness_row->roll_no;?>"value="<?php echo set_value('top_pos_3_roll_'.$film_thickness_row->roll_no,$film_thickness_row->top_pos_3);?>" maxlength="6" required style="width:60px;"/>
							</td>
							<td>
								<input type="number" name="top_pos_4_roll_<?php echo $film_thickness_row->roll_no;?>"  id="top_pos_4_roll_<?php echo $film_thickness_row->roll_no;?>"value="<?php echo set_value('top_pos_4_roll_'.$film_thickness_row->roll_no,$film_thickness_row->top_pos_4);?>" maxlength="6" required style="width:60px;" />
							</td>
							<td>
								<input type="number" name="top_pos_5_roll_<?php echo $film_thickness_row->roll_no;?>"  id="top_pos_5_roll_<?php echo $film_thickness_row->roll_no;?>"  value="<?php echo set_value('top_pos_5_roll_'.$film_thickness_row->roll_no,$film_thickness_row->top_pos_5);?>" maxlength="6" required style="width:60px;" />
							</td>
							<td>
								<input type="number" name="top_pos_6_roll_<?php echo $film_thickness_row->roll_no;?>"  id="top_pos_6_roll_<?php echo $film_thickness_row->roll_no;?>" value="<?php echo set_value('top_pos_6_roll_'.$film_thickness_row->roll_no,$film_thickness_row->top_pos_6);?>" maxlength="6" required style="width:60px;" />
							</td>
							<td>
								<input type="number" name="top_pos_7_roll_<?php echo $film_thickness_row->roll_no;?>"  id="top_pos_7_roll_<?php echo $film_thickness_row->roll_no;?>"  value="<?php echo set_value('top_pos_7_roll_'.$film_thickness_row->roll_no,$film_thickness_row->top_pos_7);?>" maxlength="6" required style="width:60px;"/>
							</td>
							<td>
								<input type="number" name="top_pos_8_roll_<?php echo $film_thickness_row->roll_no;?>"  id="top_pos_8_roll_<?php echo $film_thickness_row->roll_no;?>" value="<?php echo set_value('top_pos_8_roll_'.$film_thickness_row->roll_no,$film_thickness_row->top_pos_8);?>" maxlength="6" required style="width:60px;"/>
							</td>
							<td>
								<input type="number" name="top_pos_9_roll_<?php echo $film_thickness_row->roll_no;?>"  id="top_pos_9_roll_<?php echo $film_thickness_row->roll_no;?>"  value="<?php echo set_value('top_pos_9_roll_'.$film_thickness_row->roll_no,$film_thickness_row->top_pos_9);?>" maxlength="6" required  style="width:60px;"/>
							</td>
							<td>
								<input type="number" name="top_pos_10_roll_<?php echo $film_thickness_row->roll_no;?>"  id="top_pos_10_roll_<?php echo $film_thickness_row->roll_no;?>"  value="<?php echo set_value('top_pos_10_roll_'.$film_thickness_row->roll_no,$film_thickness_row->top_pos_10);?>"  maxlength="6" required style="width:60px;"/>
							</td>

							<!----------BOTTOM POSITION------------------->

							<td>
								<input type="number" name="bot_pos_1_roll_<?php echo $film_thickness_row->roll_no;?>"  id="bot_pos_1_roll_<?php echo $film_thickness_row->roll_no;?>" value="<?php echo set_value('bot_pos_1_roll_'.$film_thickness_row->roll_no,$film_thickness_row->bot_pos_1);?>" maxlength="6" required style="width:60px;" />
							</td>
							<td>
								<input type="number" name="bot_pos_2_roll_<?php echo $film_thickness_row->roll_no;?>"  id="bot_pos_2_roll_<?php echo $film_thickness_row->roll_no;?>" value="<?php echo set_value('bot_pos_2_roll_'.$film_thickness_row->roll_no,$film_thickness_row->bot_pos_2);?>" maxlength="6" required style="width:60px;"/>
							</td>
							<td>
								<input type="number" name="bot_pos_3_roll_<?php echo $film_thickness_row->roll_no;?>"  id="bot_pos_3_roll_<?php echo $film_thickness_row->roll_no;?>"value="<?php echo set_value('bot_pos_3_roll_'.$film_thickness_row->roll_no,$film_thickness_row->bot_pos_3);?>" maxlength="6" required style="width:60px;"/>
							</td>
							<td>
								<input type="number" name="bot_pos_4_roll_<?php echo $film_thickness_row->roll_no;?>"  id="bot_pos_4_roll_<?php echo $film_thickness_row->roll_no;?>"value="<?php echo set_value('bot_pos_4_roll_'.$film_thickness_row->roll_no,$film_thickness_row->bot_pos_4);?>" maxlength="6" required style="width:60px;" />
							</td>
							<td>
								<input type="number" name="bot_pos_5_roll_<?php echo $film_thickness_row->roll_no;?>"  id="bot_pos_5_roll_<?php echo $film_thickness_row->roll_no;?>"  value="<?php echo set_value('bot_pos_5_roll_'.$film_thickness_row->roll_no,$film_thickness_row->bot_pos_5);?>" maxlength="6" required style="width:60px;" />
							</td>
							<td>
								<input type="number" name="bot_pos_6_roll_<?php echo $film_thickness_row->roll_no;?>"  id="bot_pos_6_roll_<?php echo $film_thickness_row->roll_no;?>" value="<?php echo set_value('bot_pos_6_roll_'.$film_thickness_row->roll_no,$film_thickness_row->bot_pos_6);?>" maxlength="6" required style="width:60px;" />
							</td>
							<td>
								<input type="number" name="bot_pos_7_roll_<?php echo $film_thickness_row->roll_no;?>"  id="bot_pos_7_roll_<?php echo $film_thickness_row->roll_no;?>"  value="<?php echo set_value('bot_pos_7_roll_'.$film_thickness_row->roll_no,$film_thickness_row->bot_pos_7);?>" maxlength="6" required style="width:60px;"/>
							</td>
							<td>
								<input type="number" name="bot_pos_8_roll_<?php echo $film_thickness_row->roll_no;?>"  id="bot_pos_8_roll_<?php echo $film_thickness_row->roll_no;?>" value="<?php echo set_value('bot_pos_8_roll_'.$film_thickness_row->roll_no,$film_thickness_row->bot_pos_8);?>" maxlength="6" required style="width:60px;"/>
							</td>
							<td>
								<input type="number" name="bot_pos_9_roll_<?php echo $film_thickness_row->roll_no;?>"  id="bot_pos_9_roll_<?php echo $film_thickness_row->roll_no;?>"  value="<?php echo set_value('bot_pos_9_roll_'.$film_thickness_row->roll_no,$film_thickness_row->bot_pos_9);?>" maxlength="6" required  style="width:60px;"/>
							</td>
							<td>
								<input type="number" name="bot_pos_10_roll_<?php echo $film_thickness_row->roll_no;?>"  id="bot_pos_10_roll_<?php echo $film_thickness_row->roll_no;?>"  value="<?php echo set_value('bot_pos_10_roll_'.$film_thickness_row->roll_no,$film_thickness_row->bot_pos_10);?>"  maxlength="6" required style="width:60px;"/>
							</td>											

						</tr>
					<?php endforeach;?>		
					
				<?php
					
					}
				?>
		</table>
	</div>	
		
	</div>
					
</div>

					
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Update</button>
		</div>
	</div>
		
</form>




				
				
				
			