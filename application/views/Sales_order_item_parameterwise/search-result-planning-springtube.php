<div class="record_form_design">
<!--<script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
<h4>Springtube Planning Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h4>
	 <div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
		
					<table class="ui very basic collapsing celled table" style="font-size:10px;" >
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Hold/Unhold</th>
							<th>So Date</th>
							<th>Approval Date</th>
							<th>So No.</th>
							<!-- <th>So No.(HO)</th>							 -->
							<th>Customer</th>
							<th>Article Code</th>
							<th>Article Name</th>								
							<th>Sleeve Dia</th>							
							<th>Sleeve Length</th>
							<th>Layer</th>
							<th>Sleeve MB 2 Layer</th>
							<th>Sleeve MB 6 Layer</th>							
							<th>Shoulder Type</th>
							<th>Shoulder Orifice</th>
							<th>Shoulder MB</th>							
							<th>Cap Mold Finish</th>
							<th>Cap Orifice</th>
							<th>Cap MB</th>
							<th>Laminate Color</th>
							<th>Seam Type</th>
							<th>Spring Artwork(HO)</th>
							<th>Spring Artwork(Factory)</th>
							<th>Print Type</th>
							<th>Delivery Date</th>
							<th>Foil 1</th>							
							<th>Foil 1 Width(MM)</th>
							<th>Foil 2</th>
							<th>Foil 2 Width(MM)</th>
							<th>Cap Foil</th>
							<th>Cap foil Width</th>
							<th>Cap Shrink Sleeve</th>
							<th>Cap Metalization</th>
							<th>Order Qty</th>
							<th>Pending Qty</th>
							<th>Sleeve Length For Extrusion</th>
							<th>SO Comment</th>
							<th>Specs Comment</th>
							<th>Cap Code</th>
							<th>Specs(HO)</th>
							<th>Specs(Factory)</th>
							<th>Action</th>					
						</tr>
					</thead>
					<tbody>	
				<?php if($order_master==FALSE){
					echo "<tr><td colspan='15'>No Records Found</td></tr>";
				}
				else{
					$n=1;
					foreach ($order_master as $order_master_row) {
						$print_type_artwork='';
						$print_type_bom='';
						$ship_to='';
						$ship_to_gst='';
						$currency='';
						$exchange_rate='';						
						$sleeve_diameter='';
						$sleeve_length='';
						$sleeve_mb_2='';
						$sleeve_mb_6='';
						$sleeve_print_type='';
						$shoulder_type='';
						$shoulder_orifice='';
						$shoulder_master_batch='';
						//$shoulder_foil_tag='';
						$cap_code='';
						$cap_finish='';
						$cap_orifice='';
						$cap_master_batch='';
						$cap_foil_color='';
						$cap_foil_width='';
						$cap_height='';
						$cap_shrink_sleeve='';
						$cap_metalization='';
						
						$foil_1='';
						$foil_1_width='';
						$foil_2='';
						$foil_2_width='';
						$lacquer='';
						$lacquer_1='';
						$lacquer_2='';
						$specs_comment='';

						$layer_no='';
						$bom_id='';

						$artwork_image_name='';
						$body_making_type='';
						$laminate_color='';

												
						$search=array();
						
						if(!empty($this->input->post('sleeve_diameter'))){
                      		$search['sleeve_diameter']=$this->input->post('sleeve_diameter');
		                }
		                if(!empty($this->input->post('sleeve_print_type'))){
                      		$search['sleeve_print_type']=$this->input->post('sleeve_print_type');
		                }
		                if(!empty($this->input->post('shoulder_type'))){
		                    $search['shoulder_type']=$this->input->post('shoulder_type');
		                }
		                 if(!empty($this->input->post('shoulder_orifice'))){
		                    $search['shoulder_orifice']=$this->input->post('shoulder_orifice');
		                }
	                  	if(!empty($this->input->post('cap_orifice'))){
	                      $search['cap_orifice']=$this->input->post('cap_orifice');
	                  	}
	                  	if(!empty($this->input->post('cap_finish'))){
	                      $search['cap_finish']=$this->input->post('cap_finish');
		                }
		                $flag=0;
		                $spec_id='';
		                $spec_version_no='';	

		                //ARTWORK DEATILS-----------------

						if($order_master_row->ad_id!=''){

							$artwork['ad_id']=$order_master_row->ad_id;
							$artwork['version_no']=$order_master_row->version_no;
							$search='';
							$from='';
							$to='';
							$artwork_springtube_result=$this->artwork_springtube_model->active_record_search('springtube_artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
							//print_r($artwork_springtube_result);
							foreach ($artwork_springtube_result as $artwork_springtube_row) {
								$print_type_artwork=$artwork_springtube_row->print_type;	
								$artwork_image_name=$artwork_springtube_row->artwork_image_nm;
								$body_making_type=$artwork_springtube_row->body_making_type;
								$laminate_color=$artwork_springtube_row->laminate_color;
								$foil_1=$this->common_model->get_article_name($artwork_springtube_row->cold_foil_1,$this->session->userdata['logged_in']['company_id']);
								$foil_1_width=$artwork_springtube_row->cold_foil_1_width;
								//$foil_2=$artwork_springtube_row->cold_foil_2;
								$foil_2=$this->common_model->get_article_name($artwork_springtube_row->cold_foil_2,$this->session->userdata['logged_in']['company_id']);
								$foil_2_width=$artwork_springtube_row->cold_foil_2_width;				
							}							


						}
	                

	                	$spec_id=$order_master_row->spec_id;
	                	$spec_version_no=$order_master_row->spec_version_no;


	                	if($spec_id!='' && $spec_version_no!=''){
	                		//SPECS DETAILS BY BOM
	                		if(strtoupper(substr($spec_id, 0,3))=='BOM'){
						//  BOM DETAILS--------------
	                			$film_spec_id='';
	                			$film_spec_version='';
	                			$shoulder_spec_id='';
	                			$shoulder_spec_version='';
	                			$cap_spec_id='';
								$cap_spec_version='';

	                			$bom_no=$spec_id;
	                			$bom_version_no=$spec_version_no;
	                			$data=array('bom_no'=>$bom_no,
	                						'bom_version_no'=>$bom_version_no);

	                			$bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

	                			foreach (
	                				$bill_of_material_result as $bill_of_material_row) {
	                				$bom_id=$bill_of_material_row->bom_id;
	                				$film_code=$bill_of_material_row->sleeve_code;
						    		$shoulder_code=$bill_of_material_row->shoulder_code;
						    		$cap_code=$bill_of_material_row->cap_code;
						    		$label_code=$bill_of_material_row->label_code;
						    		$print_type_bom=$bill_of_material_row->print_type;
						    		$specs_comment=strtoupper($bill_of_material_row->comment);
	                			}

	                			//SLEEVE------------
	                			$film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

					    		foreach($film_code_result as $film_code_row){										
					    			$film_spec_id=$film_code_row->spec_id;
					    			$film_spec_version=$film_code_row->spec_version_no;
					    		}

					    		$specs['spec_id']=$film_spec_id;
								$specs['spec_version_no']=$film_spec_version;

								$specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
										if($specs_master_result){
											foreach($specs_master_result as $specs_master_row){
												$layer_arr=explode("|", $specs_master_row->dyn_qty_present);
												$layer_no=substr($layer_arr[1],0,1);			

											}
									    }

								$specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
										if($specs_result){
											foreach($specs_result as $specs_row){
												$sleeve_diameter=$specs_row->SLEEVE_DIA;
												$sleeve_length=$specs_row->SLEEVE_LENGTH;
												$sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
												$sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;											

											}
									    }
									    //SHOULDER----------

										$shoulder_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);

							    		foreach($shoulder_code_result as $shoulder_code_row){										
							    			$shoulder_spec_id=$shoulder_code_row->spec_id;
							    			$shoulder_spec_version=$shoulder_code_row->spec_version_no;
							    		}

							    		$shoulder_specs['spec_id']=$shoulder_spec_id;
										$shoulder_specs['spec_version_no']=$shoulder_spec_version;

										$shoulder_specs_result=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$shoulder_specs);
										if($shoulder_specs_result){
											foreach($shoulder_specs_result as $shoulder_specs_row){
												$shoulder_type=$shoulder_specs_row->SHOULDER_STYLE;
												$shoulder_orifice=$shoulder_specs_row->SHOULDER_ORIFICE;
												$shoulder_foil=$shoulder_specs_row->SHOULDER_FOIL_TAG;	
												$shoulder_foil_tag=$this->common_model->get_article_name($shoulder_foil,$this->session->userdata['logged_in']['company_id']);
												$shoulder_master_batch=$shoulder_specs_row->SHOULDER_MASTER_BATCH;								
											}
									    }

									   //CAP----------------------
									    $cap_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);

							    		foreach($cap_code_result as $cap_code_row){										
							    			$cap_spec_id=$cap_code_row->spec_id;
							    			$cap_spec_version=$cap_code_row->spec_version_no;
							    		}

							    		$cap_specs['spec_id']=$cap_spec_id;
										$cap_specs['spec_version_no']=$cap_spec_version;

										$cap_specs_result=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$cap_specs);
										//print_r($cap_specs_result);
										
										if($cap_specs_result){
											foreach($cap_specs_result as $cap_specs_row){
												$cap_dia=$cap_specs_row->CAP_DIA;
												$cap_type=$cap_specs_row->CAP_STYLE;
												$cap_finish=$cap_specs_row->CAP_MOLD_FINISH;
												$cap_orifice=$cap_specs_row->CAP_ORIFICE;
												$cap_master_batch=$cap_specs_row->CAP_MASTER_BATCH;
												$cap_foil_color=$this->common_model->get_article_name($cap_specs_row->CAP_FOIL_CODE,$this->session->userdata['logged_in']['company_id']);
												$cap_foil_width=$cap_specs_row->CAP_FOIL_WIDTH;
												$cap_shrink_sleeve=$this->common_model->get_article_name($cap_specs_row->CAP_SHRINK_SLEEVE_CODE,$this->session->userdata['logged_in']['company_id']);
												$cap_metalization=$cap_specs_row->CAP_METALIZATION;							

											}

										}	



	                		} // END SPECS DETAILS BY SPECS      	

	                	}


							// REST QUANTITY-----------------
								$total_order_quantity=$this->common_model->read_number($order_master_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
								$total_arid_qty=0;
								$supplyqty=0;
								$rest_qty=0;
								$search_arr=array('ref_ord_no'=>$order_master_row->order_no,
												  'article_no'=>$order_master_row->article_no);
								
								$ar_invoice_details_result=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$search_arr);

								foreach ($ar_invoice_details_result as $ar_invoice_details_row) {
									$total_arid_qty+=$ar_invoice_details_row->arid_qty;
								}

								$supplyqty=$this->common_model->read_number($total_arid_qty,$this->session->userdata['logged_in']['company_id']);

								$rest_qty=$total_order_quantity-$supplyqty;

	             		//  ROWS------------------------------------------------------

	                	echo"<tr>
								<td>".$n++."</td>
								<td>".($order_master_row->hold_flag==1 ?"<a class='ui red label'>HOLD</a>" : "<a class='ui green label'>UNHOLD</a>")."</td>
								<td>".$this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$this->common_model->view_date($order_master_row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>	
								<td>".($order_master_row->final_approval_flag==1 ? "<i style='color:#06c806;' class='check circle icon'></i>" : "")."<a href='".base_url('/index.php/sales_order_book/view/'.$order_master_row->order_no)."'   target='_blank'>".$order_master_row->order_no."</a>
								</td>

								<!--<td>".($order_master_row->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/sales_order_book/view/'.$order_master_row->order_no)." target='_blank'>".$order_master_row->order_no."</a>
								</td>
								-->
																						
								<td>".$order_master_row->name1."</td>";
								echo"																
								<td>".$order_master_row->article_no."</td>
								<td>".$this->common_model->get_article_name($order_master_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>			
								<td>".$sleeve_diameter."</td>								
								<td>".$sleeve_length."</td>
								<td>".($layer_no!=''?($layer_no>1?"MULTI":"MONO"):"")."</td>
								<td>".$this->common_model->get_article_name($sleeve_mb_2,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$this->common_model->get_article_name($sleeve_mb_6,$this->session->userdata['logged_in']['company_id'])."</td>				
								
								<td>".$shoulder_type."</td>
								<td>".$shoulder_orifice."</td>
								<td>".$this->common_model->get_article_name($shoulder_master_batch,$this->session->userdata['logged_in']['company_id'])."</td>

								<td>".$cap_finish."</td>
								<td>".$cap_orifice."</td>
								<td>".($cap_master_batch!=""?$this->common_model->get_article_name($cap_master_batch,$this->session->userdata['logged_in']['company_id']):"")."</td>
								<td>".$laminate_color."</td>
								<td>".$body_making_type."</td>
								<td><a href='".base_url()."/index.php/artwork_springtube/view/".$order_master_row->ad_id."/".$order_master_row->version_no." ' target='blank'>".($order_master_row->ad_id!=""? $order_master_row->ad_id."_R".$order_master_row->version_no:"")."</a>
								&nbsp;";

								// if($artwork_image_name!=''){
								// 	echo'<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$artwork_image_name.'').'" target="_blank"><i class="file pdf outline icon"></i></a>';
								// }
								echo"</td>
								<td><a href='http://123.252.171.218:3030/erp/index.php/artwork_springtube/view/".$order_master_row->ad_id."/".$order_master_row->version_no." ' target='blank'>".($order_master_row->ad_id!=""? $order_master_row->ad_id."_R".$order_master_row->version_no:"")."</a>
								&nbsp;&nbsp;";							

								echo"</td>
								<td>".($print_type_artwork==''?$print_type_bom:$print_type_artwork)."
								<td>".($order_master_row->delivery_date!='0000-00-00'? $this->common_model->view_date($order_master_row->delivery_date,$this->session->userdata['logged_in']['company_id']):"")."</td>
								<td>".$foil_1."</td>
								<td>".$foil_1_width."</td>
								<td>".$foil_2."</td>
								<td>".$foil_2_width."</td>
								<td>".$cap_foil_color."</td>
								<td>".$cap_foil_width."</td>
								<td>".$cap_shrink_sleeve."</td>	
								<td>".$cap_metalization."</td>

								<td>".number_format($this->common_model->read_number($order_master_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']),0,'.',',')."</td>
								<td>".number_format($rest_qty,0,'.',',')."</td>
								<!--<td>".$lacquer."</td>-->
								<td>".($sleeve_length!=''?$sleeve_length+2.5:'')."</td>
								<td>".$order_master_row->lang_addi_info."</td>
								<td>".$specs_comment."</td>	
								<td> <a href='".base_url('/index.php/cap_specification/view_cap/'.$cap_spec_id.'/'.$cap_spec_version)."' target='_blank'>".$cap_code."<a/></td>	
								<td><a href='".base_url().(substr($order_master_row->spec_id,0,1)=='S'? "/index.php/specification/view/$order_master_row->spec_id/$order_master_row->spec_version_no":"/index.php/bill_of_material/view/$bom_id")." ' target='blank'>".($order_master_row->spec_id!=""? $order_master_row->spec_id."_R".$order_master_row->spec_version_no:"")."</a></td>
								<td><a href='http://123.252.171.218:3030/erp/".(substr($order_master_row->spec_id,0,1)=='S'? "/index.php/specification/view/$order_master_row->spec_id/$order_master_row->spec_version_no":"/index.php/bill_of_material/view/$bom_id")." ' target='blank'>".($order_master_row->spec_id!=""? $order_master_row->spec_id."_R".$order_master_row->spec_version_no:"")."</a></td>

								<td><a href='".base_url()."/index.php/springtube_extrusion_planning/save/$order_master_row->order_no/$order_master_row->article_no' target='blank'>Add to Planning sheet</a></td>
				

							</tr>";



						
					}//FOREACH

				}//ELSE
			?>	
				</tbody>			
				</table>
					<div class="pagination"><?php echo $this->pagination->create_links();?></div>

					
		</div>
</div>

				
				
				
				
				
			