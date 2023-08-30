
<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
			<table class="ui very basic collapsing celled table"  style="font-size:9px;">
				<tr>
					<thead>
					<th>Sr no.</th>					
					<th>Action</th>		
					<th>RFD Date</th>
					<th>Customer</th>					
					<th>Order No</th>									
					<th>Article No.</th>
					<th>Article Desc</th>					
					<th>Microns</th>
					<th>Dia X Length</th>
					<th>Second layer MB</th>					
					<th>Sixth Layer MB</th>
					<!-- <th>Jobcard No.</th> -->
					<th>RFD Qty</th>					
					<th>Dispatch Qty</th>
					<th>Dispatch Status</th>
				</tr>
			</thead>
			<tbody>
				<?php 

					
					$sum_bm_wip_qty=0;
					$sum_rfd_qty=0;
					$sum_release_qty=0;
					// $sum_total_bodymaking_rejected=0;
					// $sum_total_printing_rejected=0;
					// $sum_total_rejected=0;

					//$sum_reels=0;
					//$sum_reels_release=0;

				if($springtube_rfd_master==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						$reel_length=$this->config->item('springtube_reel_length');

						//$sum_total_meters_produced=0;
						

						foreach($springtube_rfd_master as $master_row){

							$customer='';
							$order_date='';
							$ad_id='';
							$version_no='';
							$body_making_type='';
							$print_type_artwork='';
							$bom_no='';
							$bom_id='';
							$bom_version_no='';
							$total_order_quantity=0;

							$jobcard_qty=0;

							//Jobcard details  //production_master----
							$production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $master_row->jobcard_no);
  
		                    foreach($production_master_result as $production_master_row) {
		                      $order_no=$production_master_row->sales_ord_no;
		                      $article_no=$production_master_row->article_no;
		                      $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
		                    }
		                    //Order details-----------
		                    $order_master_result=$this->sales_order_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$order_no);

							$hold_flag=0;
							foreach($order_master_result as $order_master_row){
								$customer=$order_master_row->customer_no;
								$order_date=$order_master_row->order_date;
								$hold_flag=$order_master_row->hold_flag;
							}

		                    $data_order_details=array(
		                    'order_no'=>$order_no,
		                    'article_no'=>$article_no
		                    );

		                    $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
		                    foreach($order_details_result as $order_details_row){
		                      $bom_no=$order_details_row->spec_id;
		                      $bom_version_no=$order_details_row->spec_version_no;
		                    }
		                    // BOM Details---------
		                    $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

		                    $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

		                    foreach ($bill_of_material_result as $bill_of_material_row) {
		                      $bom_id=$bill_of_material_row->bom_id;
		                      $film_code=$bill_of_material_row->sleeve_code;
		                       
		                    }			                    				

	                		//SLEEVE---------------------------------

	                		$film_spec_id='';
	                		$film_spec_version='';

	                		$film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

				    		foreach($film_code_result as $film_code_row){										
				    			$film_spec_id=$film_code_row->spec_id;
				    			$film_spec_version=$film_code_row->spec_version_no;
				    		}

					    	$specs['spec_id']=$film_spec_id;
							$specs['spec_version_no']=$film_spec_version;

							$specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
							
							if($specs_result){

								foreach($specs_result as $specs_row){
										$sleeve_diameter=$specs_row->SLEEVE_DIA;
										$sleeve_length=$specs_row->SLEEVE_LENGTH;
										$sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
										$sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;			

								}											
							}
							

							echo"<tr>
										
									<td >".$i++."</td><td>";
									foreach($formrights as $formrights_row){ 												
										//echo ($formrights_row->new==1 && $master_row->status!=1 ? '<input type="checkbox" name="aql_id[]" value="'.$master_row->aql_id.'">' : '');

										echo ($formrights_row->new==1 && $master_row->status==0 && $hold_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/rfd_consume/'.$order_no.'/'.$article_no).'" title="Consume RFD"><i class="edit icon"></i></a>' : '');

										//echo ($formrights_row->delete==1 && $master_row->status==0 && $hold_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/rfd_consume/'.$order_no.'/'.$article_no).'" title="Consume RFD"><i class="edit icon"></i></a>' : '');

										echo ($master_row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$master_row->rfd_id).'"><i class="trash icon"></i></a> ' : '');


												
												
									}
									echo"</td>	
									<td>".$this->common_model->view_date($master_row->rfd_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<!--<td>".$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id'])."</td>
									-->
									<td>".$this->common_model->get_parent_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>									
									<td><a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'> ".$order_no."</a></td>
									<!--<td>".$this->common_model->view_date($order_date,$this->session->userdata['logged_in']['company_id'])."</td>
									-->
									
									<td title='".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."'>".$article_no."</td>

									<td >".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>

									<!--<td><a href='".base_url('index.php/bill_of_material/view/'.$bom_id)."' target='_blank'>".$bom_no."_".$bom_version_no."</td>

											
									<td><a href='".base_url('index.php/spring_film_specification/view/'.$film_spec_id.'/'.$film_spec_version)."' target='_blank'>".$master_row->film_code."</td>
									-->
									<td>".$master_row->total_microns."</td>
									<td>".$master_row->sleeve_dia." X ".$master_row->sleeve_length."</td>
									<!--<td>".$master_row->sleeve_length."</td>
									-->

									<td>".$this->common_model->get_article_name($master_row->second_layer_mb,$this->session->userdata['logged_in']['company_id'])."</td>									
									<td>".$this->common_model->get_article_name($master_row->sixth_layer_mb,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<!--<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->jobcard_no."
									</td>-->
									<td class='positive' style='text-align:right;'><b>".number_format($master_row->rfd_qty,0,'.',',')."</b> <i>NOS</i>
									</td>
									
									<td class='positive' style='text-align:right;'><b>".($master_row->release_qty!=''?number_format($master_row->release_qty,0,'.',',')."</b> <i>NOS</i>":'')."
									</td>
									<td>".($master_row->status==1?"<i style='color:#06c806;'class='check circle icon'></i>":"")."
									</td>";
									
								//$sum_bm_wip_qty+=$master_row->bm_wip_qty;
								if($master_row->status==0){
								$sum_rfd_qty+=$master_row->rfd_qty;	
								}	
								
								$sum_release_qty+=$master_row->release_qty;
								// $sum_total_bodymaking_rejected+=$master_row->total_rejected_bodymaking_issue;
								// $sum_total_printing_rejected+=$master_row->total_rejected_printing_issue;
								// $sum_total_rejected+=$master_row->total_rejected_qty;
										

						}//master Foreach

					echo"<tr><td colspan='11' style='text-align:right;'><b>TOTAL</b></td>
					<td class='positive right aligned'><b>".number_format($sum_rfd_qty,0,'.',',')."</b> <i>NOS</i></td>
					<td class='positive right aligned'><b>".number_format($sum_release_qty,0,'.',',')."</b> <i>NOS</i></td>

					</tr>";	

					}?>
				</tbody>				
			</table>
			<!--<div class="pagination"><?php echo $this->pagination->create_links();?></div>-->
	</div>
</div>
<!-- <?php   if($formrights){
		    foreach ($formrights as $formrights_row) {
			    if($formrights_row->new=='1'){ ?>

					<div class="form_design">
						<div class="ui buttons">
					  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
					  		<div class="or"></div>
					  		<button id="btn_close" class="ui positive button" onClick="return confirm('Are you sure?');">Consume</button>
						</div>
				  	</div>
<?php			}
			}						
		}
?>

</form>	 -->

