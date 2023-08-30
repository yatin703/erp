<div class="record_form_design">
<!--<script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
<h4>COEX Planning Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h4>
	 <div class="record_inner_design" style="overflow: scroll; white-space: nowrap">
		
					<table class="ui very basic collapsing celled table" style="font-size:10px;" >
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Hold/Unhold</th>
							<th>Approval Date</th>
							<th>So No., So Date</th>
							<!-- <th>So No.And So Date(HO)</th> -->
							<th>Customer</th>
							<th>Article Code</th>
							<th>Article Name</th>								
							<th>Sleeve Dia</th>							
							<th>Sleeve Length</th>
							<th>Layer</th>
							<th>Sleeve Master Batch</th>
							<th>Sleeve Print Type</th>
							<th>Shoulder Neck Type</th>
							<th>Shoulder Orifice</th>
							<th>Shoulder Master Batch</th>							
							<th>Cap Mold Finish</th>
							<th>Cap Orifice</th>
							<th>Cap Master Batch</th>
							<th>Artwork(HO)</th>
							<th>Artwork(Factory)</th>
							<th>Hot Foil</th>
							<th>Shoulder Foil Tag</th>
							<th>Delivery Date</th>
							<th>Cap Foil Color</th>
							<th>Cap foil Width</th>
							<th>Cap Shrink Sleeve</th>
							<th>Cap Metalization</th>
							<th>Quantity</th>
							<th>Pending Qty</th>
							<th>Lacquer</th>
							<th>SO Comment</th>
							<th>Specs Comment</th>
							<th>Cap Code</th>
							<th>Specs(HO)</th>
							<th>Specs(Factory)</th>

					
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
						$sleeve_master_batch='';
						$sleeve_print_type='';
						$shoulder_type='';
						$shoulder_orifice='';
						$shoulder_master_batch='';
						$shoulder_foil_tag='';
						$cap_finish='';
						$cap_orifice='';
						$cap_master_batch='';
						$cap_foil_color='';
						$cap_foil_width='';
						$cap_height='';
						$cap_shrink_sleeve='';
						$cap_metalization='';
						$hot_foil='';
						$hot_foil_1='';
						$hot_foil_2='';
						$lacquer='';
						$lacquer_1='';
						$lacquer_2='';
						$specs_comment='';

						$layer_no='';
						$bom_id='';

						$artwork_image_name='';

												
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
							$artwork_result=$this->artwork_model->active_record_search_new('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
							//print_r($artwork_result);
							foreach ($artwork_result as $artwork_row) {
								$print_type_artwork=$artwork_row->print_type;	
								$artwork_image_name=$artwork_row->artwork_image_nm;				
							}
							$artwork_details_result=$this->common_model->select_active_records_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],$artwork);

							foreach ($artwork_details_result as $artwork_details_row) {
								if($artwork_details_row->artwork_para_id==11){
									$foil_arr=explode('||',$artwork_details_row->parameter_value);
									$hot_foil=($foil_arr[1]!=''?str_replace('^',',',$foil_arr[1]):'');								

								}
								if($artwork_details_row->artwork_para_id==12){									
									$lacquer_arr=explode('||',$artwork_details_row->parameter_value);
									$lacquer=($lacquer_arr[1]!=''?str_replace('^',',',$lacquer_arr[1]):'');
								}
								if($artwork_details_row->artwork_para_id==23){
									$hot_foil_1=$this->common_model->get_article_name($artwork_details_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
								}
								if($artwork_details_row->artwork_para_id==25){
									$hot_foil_2=$this->common_model->get_article_name($artwork_details_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
								}
								if($artwork_details_row->artwork_para_id==27){
									$lacquer_1=$this->common_model->get_article_name($artwork_details_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
								}
								if($artwork_details_row->artwork_para_id==29){
									$lacquer_2=$this->common_model->get_article_name($artwork_details_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
								}
								if($hot_foil_1!=''){
									$hot_foil=($hot_foil_2!=''?$hot_foil_1.','.$hot_foil_2:$hot_foil_1);
								}
								if($lacquer_1!=''){
									$lacquer=($lacquer_2!=''?$lacquer_1.','.$lacquer_2:$lacquer_1);
								}
								
							}


						}
	                

	                	$spec_id=$order_master_row->spec_id;
	                	$spec_version_no=$order_master_row->spec_version_no;

	                	if($spec_id!='' && $spec_version_no!=''){

	                		//SPECS DETAILS BY BOM
	                		if(strtoupper(substr($spec_id, 0,3))=='BOM'){
						//  BOM DETAILS--------------
	                			$sleeve_spec_id='';
	                			$sleeve_spec_version='';
	                			$shoulder_spec_id='';
	                			$shoulder_spec_version='';
	                			$cap_spec_id='';
								$cap_spec_version='';


								$cap_code='';
	                			$bom_no=$spec_id;
	                			$bom_version_no=$spec_version_no;
	                			$data=array('bom_no'=>$bom_no,
	                						'bom_version_no'=>$bom_version_no);

	                			$bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

	                			foreach (
	                				$bill_of_material_result as $bill_of_material_row) {
	                				$bom_id=$bill_of_material_row->bom_id;
	                				$sleeve_code=$bill_of_material_row->sleeve_code;
						    		$shoulder_code=$bill_of_material_row->shoulder_code;
						    		$cap_code=$bill_of_material_row->cap_code;
						    		$label_code=$bill_of_material_row->label_code;
						    		$print_type_bom=$bill_of_material_row->print_type;
						    		$specs_comment=strtoupper($bill_of_material_row->comment);
	                			}

	                			//SLEEVE------------
	                			$sleeve_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

					    		foreach($sleeve_code_result as $sleeve_code_row){										
					    			$sleeve_spec_id=$sleeve_code_row->spec_id;
					    			$sleeve_spec_version=$sleeve_code_row->spec_version_no;
					    		}

					    		$specs['spec_id']=$sleeve_spec_id;
								$specs['spec_version_no']=$sleeve_spec_version;

								$specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
										if($specs_master_result){
											foreach($specs_master_result as $specs_master_row){
												$layer_arr=explode("|", $specs_master_row->dyn_qty_present);
												$layer_no=substr($layer_arr[1],0,1);			

											}
									    }

								$specs_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
										if($specs_result){
											foreach($specs_result as $specs_row){
												$sleeve_diameter=$specs_row->SLEEVE_DIA;
												$sleeve_length=$specs_row->SLEEVE_LENGTH;
												$sleeve_master_batch=$specs_row->SLEEVE_MASTER_BATCH;											

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



	                		}else{
	                			// SPECS DETAILS BY SPECS----------------               			           			

	                			$data=array('spec_id'=>$spec_id,
	                						'spec_version_no'=>$spec_version_no);
	                			$specification_result=$this->sales_order_item_parameterwise_model->select_specs_by_parameter('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data,$search);

	                			if(count($specification_result)>0){

	                				$flag=1;
		                			$specs['spec_id']=$spec_id;
									$specs['spec_version_no']=$spec_version_no;

									$specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
									if($specs_master_result){
										foreach($specs_master_result as $specs_master_result_row){
											$layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
											$layer_no=substr($layer_arr[1],0,1);					

										}
									}
									$specs_lang_result=$this->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$specs);
								    if($specs_lang_result){

								    	foreach ($specs_lang_result as $specs_lang_row) {

								    		$specs_comment= strtoupper($specs_lang_row->lang_comments);

									    	$a_ss=strpos(strtoupper($specs_lang_row->lang_comments),'SHRINK');
											$a_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTL');
											$b_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTLST');
											$c_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTLS');
												
											if($a_ss){
												$cap_shrink_sleeve='YES';
											}
												
											if($a_met OR $b_met OR $c_met){
												$cap_metalization='YES';
											}
								    	}

								    	

								    }

	                				foreach($specification_result as $specification_row){

										$sleeve_diameter=$specification_row->sleeve_diameter;
										$sleeve_length=$specification_row->sleeve_length;
										$sleeve_master_batch=$specification_row->sleeve_master_batch;
										$sleeve_print_type=$specification_row->sleeve_print_type;
										$shoulder_type=$specification_row->shoulder_type;
										$shoulder_orifice=$specification_row->shoulder_orifice;
										$shoulder_master_batch=$specification_row->shoulder_master_batch;
										$shoulder_foil_tag=$specification_row->shoulder_foil_tag;
										$cap_finish=$specification_row->cap_finish;
										$cap_orifice=$specification_row->cap_orifice;
										$cap_master_batch=$specification_row->cap_master_batch;
										$cap_foil_color=$specification_row->cap_foil_color;
										$cap_foil_width=$specification_row->cap_foil_width;
										$cap_height=$specification_row->cap_height;
									}
								}else{

	                				continue;
	                			}

	                		} // END SPECS DETAILS BY SPECS      	

	                	}else{
	                		$sleeve_diameter='';
							$sleeve_length='';
							$sleeve_master_batch='';
							$sleeve_print_type='';
							$shoulder_type='';
							$shoulder_orifice='';
							$shoulder_master_batch='';
							$shoulder_foil_tag='';
							$cap_finish='';
							$cap_orifice='';
							$cap_master_bacth='';
							$cap_foil_color='';
							$cap_foil_width='';
							$cap_height='';
							$cap_code='';
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
								<td>".($order_master_row->hold_flag==1 ?"<a class='ui red label'>HOLD</a>" : "")."</td>
								<td>".$this->common_model->view_date($order_master_row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".($order_master_row->final_approval_flag==1 ? "<i style='color:#06c806;' class='check circle icon'></i>" : "")."<a href='".base_url('/index.php/sales_order_book/view/'.$order_master_row->order_no)."'"."   target='_blank'>".$order_master_row->order_no." / ".$this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id'])."</a>
								</td>
								<!--<td>".($order_master_row->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/sales_order_book/view/'.$order_master_row->order_no)." target='_blank'>".$order_master_row->order_no." / ".$this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id'])."</a>
								</td>
								-->

																
								<td>".$order_master_row->name1."</td>";
								echo"																
								<td>".$order_master_row->article_no."</td>
								<td>".$this->common_model->get_article_name($order_master_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>			
								<td>".$sleeve_diameter."</td>								
								<td>".$sleeve_length."</td>
								<td>".($layer_no!=''?($layer_no>1?"MULTI":"MONO"):"")."</td>
								<td>".$this->common_model->get_article_name($sleeve_master_batch,$this->session->userdata['logged_in']['company_id'])."</td>				
								<td>".($print_type_artwork==''?$print_type_bom:$print_type_artwork)."
								<td>".$shoulder_type."</td>
								<td>".$shoulder_orifice."</td>
								<td>".$this->common_model->get_article_name($shoulder_master_batch,$this->session->userdata['logged_in']['company_id'])."</td>

								<td>".$cap_finish."</td>
								<td>".$cap_orifice."</td>
								<td>".($cap_master_batch!=""?$this->common_model->get_article_name($cap_master_batch,$this->session->userdata['logged_in']['company_id']):"")."</td>								
								
								<td><a href='".base_url()."/index.php/artwork_new/view/".$order_master_row->ad_id."/".$order_master_row->version_no." ' target='blank'>".($order_master_row->ad_id!=""? $order_master_row->ad_id."_R".$order_master_row->version_no:"")."</a>
								&nbsp;";

								// if($artwork_image_name!=''){
								// 	echo'<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$artwork_image_name.'').'" target="_blank"><i class="file pdf outline icon"></i></a>';
								// }
								echo"</td>
								<td><a href='http://123.252.171.218:3030/erp/index.php/artwork_new/view/".$order_master_row->ad_id."/".$order_master_row->version_no." ' target='blank'>".($order_master_row->ad_id!=""? $order_master_row->ad_id."_R".$order_master_row->version_no:"")."</a>
								&nbsp;&nbsp;";

								// if($artwork_image_name!=''){
								// 	echo'<a href="'.'http://123.252.171.218:3030/erp/assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$artwork_image_name.'" target="_blank"><i class="file pdf outline icon"></i></a>';
								// }

								echo"</td>
								<td>".$hot_foil."</td>
								<td>".$shoulder_foil_tag."</td>
								<td>".($order_master_row->delivery_date!='0000-00-00'? $this->common_model->view_date($order_master_row->delivery_date,$this->session->userdata['logged_in']['company_id']):"")."</td>
								<td>".$cap_foil_color."</td>
								<td>".$cap_foil_width."</td>
								<td>".$cap_shrink_sleeve."</td>	
								<td>".$cap_metalization."</td>

								<td>".number_format($this->common_model->read_number($order_master_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']),0,'.',',')."</td>
								<td>".number_format($rest_qty,0,'.',',')."</td>
								<td>".$lacquer."</td>
								<td>".$order_master_row->lang_addi_info."</td>
								<td>".$specs_comment."</td>
								<td> <a href='".base_url('/index.php/cap_specification/view_cap/'.$cap_spec_id.'/'.$cap_spec_version)."' target='_blank'>".$cap_code."<a/></td>		
								<td><a href='".base_url().(substr($order_master_row->spec_id,0,1)=='S'? "/index.php/specification/view/$order_master_row->spec_id/$order_master_row->spec_version_no":"/index.php/bill_of_material/view/$bom_id")." ' target='blank'>".($order_master_row->spec_id!=""? $order_master_row->spec_id."_R".$order_master_row->spec_version_no:"")."</a></td>
								<td><a href='http://123.252.171.218:3030/erp/".(substr($order_master_row->spec_id,0,1)=='S'? "/index.php/specification/view/$order_master_row->spec_id/$order_master_row->spec_version_no":"/index.php/bill_of_material/view/$bom_id")." ' target='blank'>".($order_master_row->spec_id!=""? $order_master_row->spec_id."_R".$order_master_row->spec_version_no:"")."</a></td>
				

							</tr>";



						
					}//FOREACH

				}//ELSE
			?>		
				</tbody>		
				</table>
					<div class="pagination"><?php echo $this->pagination->create_links();?></div>

					
		</div>
</div>

				
				
				
				
				
			