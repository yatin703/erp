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



		<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_issue_jobcard');?>" method="POST">

				<h3 class="ui top attached header">ISSUE <?php echo $jobcard_no=($this->uri->segment(3)=='' ? $this->input->post('jobcard_no') : $this->uri->segment(3));?>

					<?php $production_master=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
						if($production_master==TRUE){

							$order_no='';
							$article_no='';
							foreach ($production_master as $production_master_row) {
								$order_no=$production_master_row->sales_ord_no;
								$article_no=$production_master_row->article_no;

								echo '&nbsp;&nbsp;&nbsp;&nbsp;
									<div class="ui compact menu">
									  
									  <a class="item">
									    <i class="recycle icon"></i> Reused
									  </a>

									  <a class="item">
									    <div class="ui checked checkbox">
										  <input type="checkbox" name="top_box_flag" value="1" '.set_checkbox('top_box_flag', '1').' '.($production_master_row->top_box_flag==1 ? 'value="1" checked' : 'value="0"').'>
										  <label>Top Box</label>
										</div>
									  </a>
									  
									  <a class="item">
									    <div class="ui checked checkbox">
										  <input type="checkbox" name="bottom_box_flag" value="1" '.set_checkbox('bottom_box_flag', '1').' '.($production_master_row->bottom_box_flag==1 ? 'value="1" checked' : 'value="0"').'>
										  <label>Bottom Box</label>
										</div>
									  </a>

									</div>';
									
							}
						}else{

						}
						?>
			

				</h3>

					<input type="hidden" name="jobcard_no" value="<?php echo $jobcard_no=($this->uri->segment(3)=='' ? $this->input->post('jobcard_no') : $this->uri->segment(3));?>">
		
					<table class="ui very compact celled table" style="font-size:10px;">
						<thead>
							<tr>
								<th><input type="checkbox" name="all_chk[]" onClick="chkall(this)"></th>
								<th>Sr No</th>
								<th>Process</th>
								<th>Main Group</th>
								<th>Sub Group</th>
								<th>Article</th>
								<th>Article No</th>
								<!--<th>Available Quantity</th>-->
								<th>Required Quantity</th>
								<th>UOM</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
					<?php 
					setlocale(LC_MONETARY, 'en_IN');
					$i=1;
					foreach ($job_card as $job_card_row):

						$batch_no_1="NA";
						$batch_no_2="NA";
						
						$article_desc='';
						$sub_group='';
						$main_group='';
						$uom='';

						$article_desc="";
						$calculated_purchase_price="";

							$data['article']=$this->article_model->select_one_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
							foreach($data['article'] as $article_row){
								$article_desc=$article_row->article_name;
								$sub_group=$article_row->sub_group;
								$main_group=$article_row->main_group;
								$uom=$article_row->uom;
							}

							$data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);

							//print_r($data['workprocedure_types_master']);


							foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
								$process=$row_workprocedure_types_master->lang_description;
							}

							//$available_qty_explode=explode("//",$this->job_card_model->get_available_qty($job_card_row->article_no));

							$available_qty=0;
							$calculated_purchase_price=0;

							// if(count($available_qty_explode)>1){
							// 	$available_qty=$available_qty_explode[0];
							// 	$calculated_purchase_price=$available_qty_explode[1];
							// }


							echo "<tr>

										<td><input type='checkbox' name='mm_id[]' value='$job_card_row->mm_id' '".set_checkbox('mm_id[]',"$job_card_row->mm_id")."'></td>
										<td>".$i."<input type='hidden' name='calculated_purchase_price_$job_card_row->mm_id' value='$calculated_purchase_price'>
												<input type='hidden' name='sr_no' value='".$i."'>
										</td>
										<td>".$process."-".$job_card_row->work_proc_no."<input type='hidden' name='from_job_card_$job_card_row->mm_id' value='$job_card_row->from_job_card'></td>
										<td>".$main_group."</td>
										<td>".$sub_group."</td>
										<td>".$article_desc."</td>
										<td>".$job_card_row->article_no."<input type='hidden' name='article_no_$job_card_row->mm_id' value='$job_card_row->article_no'></td>
										<!--<td class='label'><input type='hidden' name='available_qty_$job_card_row->mm_id' value='$available_qty'>".$available_qty."</td>
										-->
										<td><input type='text' name='quantity_$job_card_row->mm_id' value='".($job_card_row->work_proc_no=='11' ? '0' : $this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id']))."' size='8'>
										</td>
										<td>".$uom."</td>
										<td>";
										foreach ($formrights as $formrights_row) {
											if($formrights_row->delete==1){
												echo '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete_material/'.$job_card_row->mm_id).'" title="delete"><i class="trash icon"></i></a>';
											}
										}										

										echo"</td>
										<!--<td>".$batch_no_1=($batch_no_1!="NA" ? '<input type="hidden" name="delivery_purchase_no_1_'.$job_card_row->mm_id.'" value="'.$delivery_purchase_no_1.'"><input type="hidden" name="batch_no_1_'.$job_card_row->mm_id.'" value="'.$batch_no_1.'">
											<input type="hidden" name="remaining_batch_qty_1_'.$job_card_row->mm_id.'" value="'.$remaining_batch_qty_1.'">'.$batch_no_1.'-'.$remaining_batch_qty_1 : "NA")."</td>
										<td>".$batch_no_2=($batch_no_2!="NA" ? '<input type="hidden" name="delivery_purchase_no_2_'.$job_card_row->mm_id.'" value="'.$delivery_purchase_no_2.'"><input type="hidden" name="batch_no_2_'.$job_card_row->mm_id.'" value="'.$batch_no_2.'">
											<input type="hidden" name="remaining_batch_qty_2_'.$job_card_row->mm_id.'" value="'.$remaining_batch_qty_2.'">'.$batch_no_2.'-'.$remaining_batch_qty_2 : "NA")."</td>
										-->
										
									</tr>";
				$i++;
			
			endforeach;?>
						</tbody>
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



			<h3 class="ui top attached header">ALREADY ISSUED MATERIALS OF <?php echo $jobcard_no=($this->uri->segment(3)=='' ? $this->input->post('jobcard_no') : $this->uri->segment(3));?>

			<?php $production_master=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);

			//echo $this->db->last_query();
						if($production_master==TRUE){

							$order_no='';
							$article_no='';

							foreach ($production_master as $production_master_row) {

								$order_no=$production_master_row->sales_ord_no;
								$article_no=$production_master_row->article_no;

								echo '&nbsp;&nbsp;&nbsp;&nbsp;<div class="ui compact menu">
									  
									  <a class="item">
									    <i class="recycle icon"></i> Reused
									  </a>

									  <a class="item">
									    <i class="stop white icon"></i> Top Box
									    '.($production_master_row->top_box_flag==1 ? "<i class='check green circle icon'></i>" : "<i class='x red circle icon'></i>").'
									  </a>
									  <a class="item">
									    <i class="icon brown inbox"></i> Bottom Box
									    '.($production_master_row->bottom_box_flag==1 ? "<i class='check green circle icon'></i>" : "<i class='x red circle icon'></i>").'
									  </a>
									</div>';
									
							}
						}else{

						}
						

						//echo "//";

                        //echo'&nbsp;&nbsp;<a href="http://123.252.171.218:8181/3dtechnopack/projects/twerp/tracking-report.php?sono='.$order_no.'&psppsm_no='.$article_no.'&jobcardno='.$jobcard_no.'" target="_blank">PRODUCTION</a>';
                                echo'&nbsp';			
				?>
			</h3>



			

			<table class="ui very compact celled table" style="font-size:10px;">
				<thead>
					<tr>
								<th>Sr NO</th>
								<th>Process</th>
								<th>Main Group</th>
								<th>Sub Group</th>
								<th>Article</th>
								<th>Article No</th>
								<th>Issued Quantity</th>
								
								<th>Rate</th>
								<th>Amount</th>
								<th>Tally Status</th>

						</tr>
				</thead>
				<tbody>
					
					<?php 
					$i=1;
					$sum_qty=0;
					$sum_amount=0;

					foreach ($job_card_issued as $job_card_row):

						$article_desc="";
						$calculated_purchase_price="";

						$sub_group='';
						$main_group='';
						$uom='';

						$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
						foreach($data['article'] as $article_row){
							$article_desc=$article_row->article_name;
							$sub_group=$article_row->sub_group;
							$main_group=$article_row->main_group;
							$uom=$article_row->uom;
						}


						$abc=array('manu_order_no'=>$job_card_row->manu_order_no,
							'article_no'=>$job_card_row->article_no);

						$work_proc_no='';
						$material_manufacturing_result=$this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$abc);

						foreach ($material_manufacturing_result as $key => $material_manufacturing_row) {
							$work_proc_no=$material_manufacturing_row->work_proc_no;
						}

						$data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$work_proc_no);
						foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
							$process=$row_workprocedure_types_master->lang_description;
						}

						//echo $this->common_model->read_number($job_card_row->qty,$this->session->userdata['logged_in']['company_id']);

						//echo "<br/>";

						$search=array('jobcard_no'=>$job_card_row->manu_order_no,
                                       'part_no'=>$job_card_row->article_no,
                                       'qty'=>$this->common_model->read_number($job_card_row->qty,$this->session->userdata['logged_in']['company_id'])
                                   );

                        $data['tally_material_issue_master']=$this->jobcard_issue_tally_model->active_record_search('tally_material_issue_master',$search,'','');
                        //echo $this->db->last_query();


                        $error='';
                        foreach ($data['tally_material_issue_master'] as $key => $tally_row) {
                            $error= $tally_row->remarks;    
                        } 

							

							echo "<tr>
										<td>".$i."</td>
										
										<td>".$process."</td>
										<td>".$main_group."</td>
										<td>".$sub_group."</td>
										<td>".$article_desc."</td>
										<td>".$job_card_row->article_no."</td>
										<td class='positive right aligned'>";
										echo $this->common_model->read_number($job_card_row->qty,$this->session->userdata['logged_in']['company_id']);
										
										
										// Eknath New Logic for issued Labels 8-Feb-2019

										 // $data_reserved_quantity_manu=array('manu_order_no' =>$jobcard_no,
           //                                  'article_no' =>$job_card_row->article_no);
										 
           //                              $result_reserved_qty_manu=$this->sales_order_item_parameterwise_model->get_total_issue_qty('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$data_reserved_quantity_manu);

			        //                     foreach ($result_reserved_qty_manu as  $rqml_row) {
			        //                         echo $this->common_model->read_number($rqml_row->qty,$this->session->userdata['logged_in']['company_id']);
			        //                     } 
										// if($job_card_row->demand_qty==0){
										// 	$data_reserved_quantity_manu=array('manu_order_no' =>$job_card_row->manu_order_no,
										// 		'article_no'=>$job_card_row->article_no );
										// 	$data['reserved_quantity_manu']=$this->common_model->select_one_active_record_nonlanguage_without_archives('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$data_reserved_quantity_manu);
										// 	foreach ($data['reserved_quantity_manu'] as  $reserved_quantity_manu_row) {
										// 		echo $this->common_model->read_number($reserved_quantity_manu_row->qty,$this->session->userdata['logged_in']['company_id']);
										// 	}
										// }
										// else{
										// 	echo $this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id']);
										// }

										echo " <i>".$uom."</i></td>
										<td class='positive right aligned'>&#8377; ".$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])."
										</td>
										<td class='positive right aligned'>&#8377; ".round($this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
										<!--<td>".$this->common_model->read_number($job_card_row->amt_manual,$this->session->userdata['logged_in']['company_id'])."
										</td>-->
										<td>".($error!=''?"<i class='x red circle icon'></i>":"<i class='check green circle icon'></i>")."</td>
									</tr>";


									$sum_qty+=$this->common_model->read_number($job_card_row->qty,$this->session->userdata['logged_in']['company_id']);
									$sum_amount+=round($this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->qty,$this->session->userdata['logged_in']['company_id']),2);









				$i++;
				endforeach;?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="6">TOTAL</th>
							<th class='positive right aligned'><?php echo $sum_qty?></th>
							<th></th>
							<th class='positive right aligned'><?php echo $sum_amount?></th>
							<th></th>
						</tr>
					</tfoot>
				</table>

				
</div>

				


						



	

				
				
				
				
				
			