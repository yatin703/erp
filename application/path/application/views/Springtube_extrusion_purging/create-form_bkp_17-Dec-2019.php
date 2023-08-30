<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#ref_jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});

		$("#article_no_1").autocomplete("<?php echo base_url('index.php/ajax/raw_material_article_no');?>", {selectFirst: true});	
				
		
		
		$("#add").live('click',function () {
			var header_row=1;
			var counter=$("#table_article tr").length;
			var mark_up='<tr id="tr_'+ counter +'"><td><input type="hidden" name="sr_no[]" value="'+counter+'"/>'+counter+'</td><td><input type="text" name="article_no_'+counter+'"  id="article_no_'+counter+'" class="quantity" value="<?php echo set_value('article_no_"+counter+"');?>" size="60" required/></td><td><input type="number" name="quantity_'+counter+'"  id="quantity_'+counter+'" class="quantity" value="<?php echo set_value('quantity_"+counter+"');?>" min="1" max="1000" step="0.1" size="30" required/></td></tr>';

				//alert(mark_up);
				$("#table_article").append(mark_up);

				$("#article_no_"+counter).autocomplete("<?php echo base_url('index.php/ajax/raw_material_article_no');?>", {selectFirst: true});


					
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



	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<tr>
							<td class="label">Purging Date. <span style="color:red;">*</span> :</td>
							<td><input type="date" name="purging_date" id="purging_date"  size="20" value="<?php echo set_value('purging_date',date('Y-m-d'));?>" readonly /></td>							
							<td class="label">Jobcard No. <span style="color:red;">*</span> :</td>
							<td><input type="text" name="ref_jobcard_no" id="ref_jobcard_no" value="<?php echo set_value('ref_jobcard_no');?>" required>
							</td>
						</tr>
						
						<tr>
							<td class="label">Reason <span style="color:red;">*</span> :</td>
							<td><select name="reason" id="reason">					
								<option value="">--Please Reasons--</option>
								<?php if($springtube_shift_issues_master==FALSE){
									echo'<option>--Setup Required--</option>';
								}
								else{
									foreach ($springtube_shift_issues_master as $row) {
										echo'<option value="'.$row->shift_issue.'" '.set_select('shift_issue',$row->shift_issue).'>'.strtoupper($row->shift_issue).'</option>';
									}
								}?>
							</select>
						</td>
							<td class="label">Remarks <span style="color:red;">*</span> :</td>
							<td ><textarea name="remarks" value="<?php echo set_value('remarks');?>" ></textarea>
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
			
				<br/><br/>

				<table class="middle_form_table_design" id="table_article" >
				<tr>
					<th>Sr No.</th>
					<th>Purging Materials</th>									
					<th>Purging Quantity (Kg)</th>					
				</tr>

			<?php
				if(!empty($this->input->post('sr_no'))){

					$total_quantity=0;

					for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){?>

						<script>
							$(document).ready(function(){

							$("#loading").hide(); $("#cover").hide();

							$("#article_no_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax/raw_material_article_no');?>", {selectFirst: true});

							});
						</script>
						<tr id="tr_<?php echo $i;?>">

							<td><input type="hidden" name="sr_no[]" value="<?php echo $i;?>"/> <?php echo $i;?>
							</td>
							<td>
							<input type="text" name="article_no_<?php echo $i;?>"  id="article_no_<?php echo $i;?>" class="quantity" value="<?php echo set_value('article_no_'.$i.'');?>"  size="60" required/>
							</td>
							<td>
							<input type="number" name="quantity_<?php echo $i;?>"  id="quantity_<?php echo $i;?>" class="quantity" value="<?php echo set_value('quantity_<?php echo $i;?>');?>" size="30" min="1" max="1000" step="0.1" required />
						</td>
							
						</tr>

			<?php 
							$total_quantity+=$this->input->post('quantity_'.$i.'');
					}

				}else{ 

			?>

					<tr id="tr_1">

						<td>
							<input type="hidden" name="sr_no[]" value="1"/> 1
						</td>					
						<td>
							<input type="text" name="article_no_1"  id="article_no_1" class="quantity" value="<?php echo set_value('article_no_1');?>" maxlength="50" size="60" required />
						</td>						
						<td>
							<input type="number" name="quantity_1"  id="quantity_1" class="quantity" value="<?php echo set_value('quantity_1');?>" size="30" min="1" max="1000" step="0.1" required />
						</td>
						

					</tr>
				
			<?php
				
				}
			?>


			</table>				
			
		
</div>
<div class="middle_form_design">

	
		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" >Save</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

</div>
		
</form>
				
				
				
				
				
			