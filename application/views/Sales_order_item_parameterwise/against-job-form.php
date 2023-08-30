<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#product_name_1").autocomplete("<?php echo base_url('index.php/ajax/purchase_article_no');?>", {selectFirst: true});


  var counter=0;

		var x = document.getElementsByName("sr_no[]");

		var counter=x.length+1;

		$("#add").live('click',function () {
					var newtr = $(document.createElement('tr')).attr("id", 'tr_'+counter);
					newtr.html('<td><input type="hidden" name="sr_no[]" value="'+counter+'"/>'+counter+'</td><td><select name="process[]"><option value="">--SELECT Process--</option><?php if($process_master==FALSE){echo"<option>--Setup Required--</option>";}else{foreach($process_master as $row_process){echo'<option value="'.$row_process->work_proc_type_id.'">'.$row_process->lang_description.'</option>';}}?></select><input type="text" name="product_name_'+	counter+'" id="product_name_'+	counter+'" value="<?php echo set_value('product_name_"+counter+"');?>"size="120" placeholder="Goods Information"/></td><td><input type="text" name="quantity_'+counter+'" id="quantity_'+counter+'"  value="<?php echo set_value('quantity_"+counter+"');?>" maxlength="15" size="10" class="quantity" /></td>');

					var lastcounter=counter-1;
					newtr.insertAfter("#tr_"+lastcounter);
					$("#product_name_"+counter).autocomplete("<?php echo base_url('index.php/ajax/purchase_article_no');?>", {selectFirst: true});
				counter++;
				});


		$("#remove").click(function(){
			if(counter==2){ alert("No more textbox to remove"); return false;}
			counter--;
			$("#tr_" + counter).remove();
		});


	});

</script>



<div class="form_design">

<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

	<h3 class="ui top attached header">
  <?php echo $jobcard_no=($this->uri->segment(3)=='' ? $this->input->post('job_card') : $this->uri->segment(3));?>
  
</h3>
		
		
					<table class="middle_form_table_design">
					<tr>
								<th>Sr NO</th>
								<th>Process</th>
								<th>Main Group</th>
								<th>Sub Group</th>
								<th>Article</th>
								<th>Article No</th>
								<th>Quantity</th>
								<th>Uom</th>
						</tr>
					<?php 
					$i=1;
					foreach ($job_card as $job_card_row):

						$article_desc="";
							$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
							foreach($data['article'] as $article_row){
								$article_desc=$article_row->article_name;
								$sub_group=$article_row->sub_group;
								$main_group=$article_row->main_group;
								$uom=$article_row->uom;
							}

							$data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
							foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
								$process=$row_workprocedure_types_master->lang_description;
							}

						if($job_card_row->demand_qty!='0'){

							echo "<tr>
										<td>".$i."</td>
										<td class='label'>".$process."-".$job_card_row->work_proc_no."</td>
										<td class='label'>".$main_group."</td>
										<td class='label'>".$sub_group."</td>
										<td class='label'>".$article_desc."</td>

										<td class='label'>".$job_card_row->article_no."</td>
										<td class='label'>".$this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])."</td>
										<td>".$uom."</td>
										
									</tr>";
				$i++;
			}
			endforeach;?>
				</table>

				<br/>
				<br/>

				
				<table class="middle_form_table_design">
						<tr>
								<th>Sr No</th>
								<th>Process</th>
								<th>Main Group</th>
								<th>Sub Group</th>
								<th>Article</th>
								<th>Article No</th>
								<th>Quantity</th>
								<th>Uom</th>
								<th>Action</th>
						</tr>
					<?php 
					$i=1;
					foreach ($job_card as $job_card_row):
						$article_desc="";
							$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
							foreach($data['article'] as $article_row){
								$article_desc=$article_row->article_name;
								$sub_group=$article_row->sub_group;
								$main_group=$article_row->main_group;
								$uom=$article_row->uom;
							}

							$data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
							foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
								$process=$row_workprocedure_types_master->lang_description;
							}

						if($job_card_row->demand_qty==0){


							echo "<form  action='".base_url('index.php/'.$this->router->fetch_class().'/save_against_job_card')."' method='POST'>
										<input type='hidden' name='job_card' value='$jobcard_no'><tr>
										<input type='hidden' name='mm_id_$i' value='$job_card_row->mm_id' />
										<tr>
										<td><input type='hidden' name='sr_noo[]'' value='$i'/>".$i."</td>
										<td class='label'>".$process."-".$job_card_row->work_proc_no."</td>
										<td class='label'>".$main_group."</td>
										<td class='label'>".$sub_group."</td>
										<td class='label'>".$article_desc."

										<input type='hidden' name='product_namee_$i' id='product_namee_$i'  value='$article_desc//$job_card_row->article_no' />
									</td>

										<td class='label'>".$job_card_row->article_no."</td>
										<td class='label'><input type='text' name='quantityy_$i' id='quantityy_$i' value='".set_value('quantityy_'.$i.'')."' class='quantity' /></td>
										<td>".$uom."</td>
										<td><button class='mini ui green button'>Update</button></td>
										
									</tr>
									</form>";
						$i++;
					}
					endforeach;?>
				</table>

				
			

<br>
<br>

	<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_against_job_card_additional');?>" method="POST">
		<input type="hidden" name="job_card" value="<?php echo $jobcard_no;?>">

		<h3 class="ui top attached header">
		  ADDITIONAL AGAINST JOB CARD
		   &nbsp; &nbsp; &nbsp; &nbsp;

		   <div class="mini ui buttons">
						<input type="button" value="Remove" id="remove" class="ui button">
						<div class="or"></div>
						<input type="button" value="Add" id="add" class="ui positive button">
					</div>
		</h3>

		<table class="middle_form_table_design">
						<tr>
								<th>Sr NO</th>
								<th>Product</th>
								<th>Quantity</th>
						</tr>

						<?php
						if($this->input->post('sr_no')){
							$total_quantity=0;
							for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){?>

								<script>
								$(document).ready(function(){
								$("#loading").hide(); $("#cover").hide();

								$("#product_name_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax/purchase_article_no');?>", {selectFirst: true});

								});
							</script>
						<tr id="tr_<?php echo $i;?>">
								<td><input type="hidden" name="sr_no[]" value="<?php echo $i;?>"/><?php echo $i;?></td>
								<td>
									<select name="process[]">
										<option value="">--SELECT Process--</option>
										<?php
										if($process_master==FALSE){
											echo'<option>--Setup Required--</option>';
										}else{
											foreach ($process_master as $row_process) {
												echo'<option value="'.$row_process->work_proc_type_id.'" '.set_select('process[]',$row_process->work_proc_type_id).'>'.$row_process->lang_description.'</option>';
											}
										}
										?>
									</select>

									<input type="text" name="product_name_<?php echo $i;?>" id="product_name_<?php echo $i;?>"size="120" value="<?php echo set_value('product_name_'.$i.'');?>" placeholder="Goods Information"/>
								</td>
								<td><input type="text" name="quantity_<?php echo $i;?>" id="quantity_<?php echo $i;?>" value="<?php echo set_value('quantity_'.$i.'');?>" maxlength="15" size="10" class="quantity" /></td>
								
							</tr>

							<?php 
						$total_quantity+=$this->input->post('quantity_'.$i.'');
							}
						}else{?>
						<tr id="tr_1">
							<td>
								<input type="hidden" name="sr_no[]" value="1"/>1</td>
							<td>

								<select name="process[]">
										<option value="">--SELECT Process--</option>
										<?php
										if($process_master==FALSE){
											echo'<option>--Setup Required--</option>';
										}else{
											foreach ($process_master as $row_process) {
												echo'<option value="'.$row_process->work_proc_type_id.'" '.set_select('process[]',$row_process->work_proc_type_id).'>'.$row_process->lang_description.'</option>';
											}
										}
										?>
									</select>
								<input type="text" name="product_name_1" id="product_name_1"size="120"  value="<?php echo set_value('product_name_1');?>" placeholder="Goods Information"/>
								</td>
								
							<td>
								<input type="text" name="quantity_1"  id="quantity_1" class="quantity" value="<?php echo set_value('quantity_1');?>" maxlength="15" size="10" /></td>
							</tr>
						
						<?php
						}
						?>
						

</table>

	<div class="mini ui buttons">
				<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
				<div class="or"></div>
				<button class="ui positive button">Save Additional</button>
	</div>

</form>



</div>

				


						



	

				
				
				
				
				
			