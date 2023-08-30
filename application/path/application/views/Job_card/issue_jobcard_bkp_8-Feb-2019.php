<script type='text/javascript'>	
function chkall(source) {
	checkboxes = document.getElementsByName('mm_id[]');
	for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	}
}					
					</script>
<div class="form_design">

<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

	<h3 class="ui top attached header">ISSUE <?php echo $jobcard_no=($this->uri->segment(3)=='' ? $this->input->post('jobcard_no') : $this->uri->segment(3));?></h3>

		<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_issue_jobcard');?>" method="POST">

					<input type="hidden" name="jobcard_no" value="<?php echo $jobcard_no=($this->uri->segment(3)=='' ? $this->input->post('jobcard_no') : $this->uri->segment(3));?>">
		
					<table class="middle_form_table_design">
					<tr>
								<th><input type="checkbox" name="all_chk[]" onClick="chkall(this)"></th>
								<th>Sr No</th>
								<th>Process</th>
								<th>Main Group</th>
								<th>Sub Group</th>
								<th>Article</th>
								<th>Article No</th>
								<th>Available Quantity</th>
								<th>Required Quantity</th>
								<th>Batch</th>
								<th>Batch Quantity</th>
						</tr>
					<?php 
					$i=1;
					foreach ($job_card as $job_card_row):

						$result_batch_no=$this->job_card_model->select_active_batch_records($limit=1,$start=0,'article_history',$this->session->userdata['logged_in']['company_id'],$job_card_row->article_no);
						//$this->db->last_query();
						if($result_batch_no){
							foreach($result_batch_no as $result_batch_no_row){
								$batch_no_1=$result_batch_no_row->batch_no;
								$delivery_purchase_no_1=$result_batch_no_row->delivery_purchase_no;
								if($result_batch_no_row->remaining_batch_qty==''){
									$remaining_batch_qty_1=$this->common_model->read_number($result_batch_no_row->ah_qty,$this->session->userdata['logged_in']['company_id']);
								}else{
									$remaining_batch_qty_1=$result_batch_no_row->remaining_batch_qty;
								}
							}
						}else{
							$batch_no_1="NA";
							$remaining_batch_qty_1="NA";
							$delivery_purchase_no_1="";
						}


						$result_batch_no_2=$this->job_card_model->select_active_batch_records_2($limit=2,$start=1,'article_history',$this->session->userdata['logged_in']['company_id'],$job_card_row->article_no);
						//echo $this->db->last_query();
						if($result_batch_no_2){
							foreach($result_batch_no_2 as $result_batch_no_row_2){
								$batch_no_2=$result_batch_no_row_2->batch_no;
								$delivery_purchase_no_2=$result_batch_no_row_2->delivery_purchase_no;
								if($result_batch_no_row_2->remaining_batch_qty==''){
									$remaining_batch_qty_2=$this->common_model->read_number($result_batch_no_row_2->ah_qty,$this->session->userdata['logged_in']['company_id']);
								}else{
									$remaining_batch_qty_2=$result_batch_no_row_2->remaining_batch_qty;
								}
							}
						}else{
							$batch_no_2="NA";
							$remaining_batch_qty_2="NA";
						}

						$article_desc="";
						$calculated_purchase_price="";
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

							$available_qty_explode=explode("//",$this->job_card_model->get_available_qty($job_card_row->article_no));

							$available_qty=0;
							$calculated_purchase_price=0;

							if(count($available_qty_explode)>1){
								$available_qty=$available_qty_explode[0];
								$calculated_purchase_price=$available_qty_explode[1];
							}


							echo "<tr>

										<td><input type='checkbox' name='mm_id[]' value='$job_card_row->mm_id' '".set_checkbox('mm_id[]',"$job_card_row->mm_id")."'></td>
										<td>".$i."<input type='hidden' name='calculated_purchase_price_$job_card_row->mm_id' value='$calculated_purchase_price'></td>
										<td class='label'>".$process."-".$job_card_row->work_proc_no."<input type='hidden' name='from_job_card_$job_card_row->mm_id' value='$job_card_row->from_job_card'></td>
										<td class='label'>".$main_group."</td>
										<td class='label'>".$sub_group."</td>
										<td class='label'>".$article_desc."</td>
										<td class='label'>".$job_card_row->article_no."<input type='hidden' name='article_no_$job_card_row->mm_id' value='$job_card_row->article_no'></td>
										<td class='label'><input type='hidden' name='available_qty_$job_card_row->mm_id' value='$available_qty'>".$available_qty."</td>
										<td class='label'><input type='text' name='quantity_$job_card_row->mm_id' value='".$this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])."' size='8'>".$uom."</td>
										<td>".$batch_no_1=($batch_no_1!="NA" ? '<input type="hidden" name="delivery_purchase_no_1_'.$job_card_row->mm_id.'" value="'.$delivery_purchase_no_1.'"><input type="hidden" name="batch_no_1_'.$job_card_row->mm_id.'" value="'.$batch_no_1.'">
											<input type="hidden" name="remaining_batch_qty_1_'.$job_card_row->mm_id.'" value="'.$remaining_batch_qty_1.'">'.$batch_no_1.'-'.$remaining_batch_qty_1 : "NA")."</td>
										<td>".$batch_no_2=($batch_no_2!="NA" ? '<input type="hidden" name="delivery_purchase_no_2_'.$job_card_row->mm_id.'" value="'.$delivery_purchase_no_2.'"><input type="hidden" name="batch_no_2_'.$job_card_row->mm_id.'" value="'.$batch_no_2.'">
											<input type="hidden" name="remaining_batch_qty_2_'.$job_card_row->mm_id.'" value="'.$remaining_batch_qty_2.'">'.$batch_no_2.'-'.$remaining_batch_qty_2 : "NA")."</td>
										
									</tr>";
				$i++;
			
			endforeach;?>
				</table>
				<div class="mini ui buttons">
				<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
				<div class="or"></div>
				<button class="ui positive button">Save</button>
				</div>
			</form>



			<br/>
			<br/>
			<br/>



			<h3 class="ui top attached header">ALREADY ISSUED MATERIALS OF <?php echo $jobcard_no=($this->uri->segment(3)=='' ? $this->input->post('jobcard_no') : $this->uri->segment(3));?></h3>

			<table class="middle_form_table_design">
					<tr>
								<th>Sr NO</th>
								<th>Process</th>
								<th>Main Group</th>
								<th>Sub Group</th>
								<th>Article</th>
								<th>Article No</th>
								<th>Required Quantity</th>
								<th>Uom</th>
						</tr>
					<?php 
					$i=1;
					foreach ($job_card_issued as $job_card_row):

						$article_desc="";
						$calculated_purchase_price="";
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

							echo "<tr>
										<td>".$i."</td>
										<td class='label'>".$process."-".$job_card_row->work_proc_no."<input type='hidden' name='from_job_card_$job_card_row->mm_id' value='$job_card_row->from_job_card'></td>
										<td class='label'>".$main_group."</td>
										<td class='label'>".$sub_group."</td>
										<td class='label'>".$article_desc."</td>
										<td class='label'>".$job_card_row->article_no."</td>
										<td class='label'>".$this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])."</td>
										<td>".$uom."</td>
										
									</tr>";
				$i++;
			
			endforeach;?>
				</table>

				
</div>

				


						



	

				
				
				
				
				
			