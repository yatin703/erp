

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >

	<div class="form_design">

		<div class="ui grid container">

			

			<?php
				$count = 1;
			   		for($i=0;$i<count($this->input->post('costsheet_id[]'));$i++){

					$total_dispatch=0;
			   			$costsheet=array();
			   			if($count%3==1){
			   			echo '<div class="four wide column">
			   					<div class="ui vertical menu">
								  <div class="item">
								    <div class="header">Product</div>
								    <div class="menu">
									    <a class="item">Dia X Length</a>
									    <a class="item">Print Type</a>
									    <a class="item">Name</a>
									    <a class="item">-</a>
								    </div>
								  </div>
								  <div class="item">
								    <div class="header">Customer</div>
								    <div class="menu">
								      <a class="item">Invoice</a>
								      <a class="item">Quantity</a>
								      <a class="item">Unit Price</a>
								      <a class="item">Value</a>
								    </div>
								  </div>

								  <div class="item">
								    <div class="header">Cost Summary</div>
								    <div class="menu">
								      <a class="item">Sleeve</a>
								      <a class="item">Purging</a>
								      <a class="item">Shoulder</a>
								      <a class="item">Printing</a>
								      <a class="item">Consumable</a>
								      <a class="item">Label</a>
								      <a class="item">Foil</a>
								      <a class="item">Shoulder Foil</a>
								      <a class="item">Capping</a>
								      <a class="item">Shrink SLeeve</a>
								      <a class="item">Metalization</a>
								      <a class="item">Packaging</a>
								      <a class="item">Stores & Spares</a>
								      <a class="item">Additional</a>
								      <a class="item">Freight</a>
								      <a class="item">Other Cost</a>
								    </div>
								  </div>


								  <div class="item">
								    <div class="header">Total</div>
								    <div class="menu">
								      <a class="item">Contribution</a>
								    </div>
								  </div>

								</div>
							</div>';
						}
						$costsheet=explode('/',$this->input->post('costsheet_id['.$i.']'));
			   			
			   			$ar_invoice_master=$this->sales_invoice_book_model->select_one_active_record('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_master.ar_invoice_no',$costsheet[0]);

            			$ar_invoice_details=$this->sales_invoice_book_model->active_details_records('ar_invoice_details',array('ar_invoice_no'=>$costsheet[0],'ref_ord_no'=>$costsheet[1]),$this->session->userdata['logged_in']['company_id']);

            			foreach ($ar_invoice_master as $ar_invoice_master_row):
            				$for_export=$ar_invoice_master_row->for_export;
						    $exchange_rate=($ar_invoice_master_row->exchange_rate!='0' ? $this->common_model->read_number($ar_invoice_master_row->exchange_rate,$this->session->userdata['logged_in']['company_id']) : '');
						    $unit_rate='';
						    $currency_id=($ar_invoice_master_row->currency_id!='' ? $ar_invoice_master_row->currency_id : '');
						    
            				foreach($ar_invoice_details as $ar_invoice_details_row):


            					$order_details=array('ref_ord_no'=>$costsheet[1],'article_no'=>$costsheet[2]);
						        $result_dispatch=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$order_details);
						        $order_flag=0;
						         foreach($result_dispatch as $row_total_dispatch){
						            $total_dispatch+=$this->common_model->read_number($row_total_dispatch->arid_qty,$this->session->userdata['logged_in']['company_id']);
						            $order_flag=$row_total_dispatch->order_flag;
						        }

            					if($for_export==1){
						        $unit_rate_in_rupees=round($ar_invoice_details_row->calc_sell_price*$exchange_rate,2);
						        $net_amount_in_rupees=$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*($unit_rate_in_rupees);
						        $total_tax_in_rupees=$this->common_model->read_number($ar_invoice_details_row->total_tax,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
						        }else{
						            $unit_rate_in_rupees=$this->common_model->read_number($ar_invoice_details_row->selling_price,$this->session->userdata['logged_in']['company_id']);
						            $net_amount_in_rupees=$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$unit_rate_in_rupees;                             
						            $total_tax_in_rupees=$this->common_model->read_number($ar_invoice_details_row->total_tax,$this->session->userdata['logged_in']['company_id']);
						        }

            				$order_master_data=array('order_no'=>$costsheet[1],'article_no'=>$costsheet[2]);
						        $data['order_details_data']=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$order_master_data);
						       // echo $this->db->last_query();
						        $total_order_quantity=0;
						        foreach($data['order_details_data'] as $order_details_row){
						            $total_order_quantity=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
						            $pr_pos_complete_flag=$order_details_row->pr_pos_complete_flag;
						            $ad_id=$order_details_row->ad_id;
						            $version_no=$order_details_row->version_no;
						            $so_quantity=$order_details_row->total_order_quantity;

						            $bom_data['bom_no']=$order_details_row->spec_id;
						            $bom_data['bom_version_no']=$order_details_row->spec_version_no;
						            $bom_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$bom_data);
						            if($bom_result){
						                foreach($bom_result as $bom_result_row){                                        
						                    $sleeve_code=$bom_result_row->sleeve_code;
						                    $shoulder_code=$bom_result_row->shoulder_code;
						                    $cap_code=$bom_result_row->cap_code;
						                    $label_code=$bom_result_row->label_code;
						                    $print_type_bom=$bom_result_row->print_type;
						                    $specs_comment=strtoupper($bom_result_row->comment);
						                    $packing_type=$bom_result_row->for_export;
						                }
						                $sleeve_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);
						                $sleeve_spec_id="";
						                $sleeve_spec_version="";
						                foreach($sleeve_code_result as $sleeve_code_row){
						                    $sleeve_spec_id=$sleeve_code_row->spec_id;
						                    $sleeve_spec_version=$sleeve_code_row->spec_version_no;
						                }

						                $specs['spec_id']=$sleeve_spec_id;
						                $specs['spec_version_no']=$sleeve_spec_version;

						                $specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
						                if($specs_master_result){
						                        foreach($specs_master_result as $specs_master_result_row){
						                            $layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
						                            $layer_no=substr($layer_arr[1],0,1);                            

						                        }
						                    $specs_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
						                    if($specs_result){
						                        foreach($specs_result as $specs_row){
						                            $dia=$specs_row->SLEEVE_DIA;
						                            $length=$specs_row->SLEEVE_LENGTH;
						                            $sleeve_mb=$specs_row->SLEEVE_MASTER_BATCH;                             

						                        }
						                    }
						                    //SHOULDER----------

						                    $shoulder_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);
						                    $shoulder_spec_id="";
						                    $shoulder_spec_version="";
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
						                            $shoulder_foil=($shoulder_specs_row->SHOULDER_FOIL_TAG!=''?'YES':'');
						                            $shoulder_mb=$shoulder_specs_row->SHOULDER_MASTER_BATCH;                                

						                        }
						                    }

						                    //CAP------------

						                    $cap_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);
						                    $cap_spec_id="";
						                    $cap_spec_version="";
						                    foreach($cap_code_result as $cap_code_row){                                     
						                        $cap_spec_id=$cap_code_row->spec_id;
						                        $cap_spec_version=$cap_code_row->spec_version_no;
						                    }

						                    $cap_specs['spec_id']=$cap_spec_id;
						                    $cap_specs['spec_version_no']=$cap_spec_version;

						                    $cap_specs_result=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$cap_specs);
						                    
						                    if($cap_specs_result){
						                        foreach($cap_specs_result as $cap_specs_row){
						                            $cap_dia=$cap_specs_row->CAP_DIA;
						                            $cap_type=$cap_specs_row->CAP_STYLE;
						                            $cap_finish=$cap_specs_row->CAP_MOLD_FINISH;
						                            $cap_orifice=$cap_specs_row->CAP_ORIFICE;
						                            $cap_mb=$cap_specs_row->CAP_MASTER_BATCH;
						                            $cap_foil=$this->common_model->get_article_name($cap_specs_row->CAP_FOIL_CODE,$this->session->userdata['logged_in']['company_id']);
						                            $cap_shrink_sleeve=$this->common_model->get_article_name($cap_specs_row->CAP_SHRINK_SLEEVE_CODE,$this->session->userdata['logged_in']['company_id']);
						                            $cap_metalization=$cap_specs_row->CAP_METALIZATION;                         

						                        }
						                    }


						                }//SPECS MASTER

						            }


						        }


						        if(!empty($ad_id)){

						            $artwork['ad_id']=$ad_id;
						            $artwork['version_no']=$version_no;
						            $search='';
						            $from='';
						            $to='';
						            $artwork_result=$this->artwork_model->active_record_search('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
									if($artwork_result){
										foreach ($artwork_result as $artwork_row) {
						                $print_type_artwork=$artwork_row->print_type;
										}
									}else{
										$artwork_result=$this->artwork_springtube_model->active_record_search('springtube_artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
										$this->db->last_query();
										if($artwork_result){
										foreach ($artwork_result as $artwork_row) {
						                $print_type_artwork=$artwork_row->print_type;
										}
										}else{
										$print_type_artwork="";
										}
									}
						            
						        }else{
									
						            $print_type_artwork="";
						            ($print_type_artwork=='' ? $print_type_bom : $print_type_artwork);
						        }
						        //Extrusion Cost Start

						        $total_extrusion_cost=0;
						        $extrusion_cost=0;
						        $total_extrusion_quantity=0;
						        $extrusion_quantity=0;
						        $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
						        $data1=array_filter($master_array);
						        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
						        foreach($data2['job_card'] as $job_card_row){
						        	if($ar_invoice_details_row->order_flag==1){
						        		$data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'1','from_job_card'=>'1','sfg_flag'=>'1');

						        	}else{
						        		$data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'1','from_job_card'=>'1','sfg_flag'=>'0');

						        	}

						            
						            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');
						            if($data['job_card_issued']==TRUE){
						           
						            foreach ($data['job_card_issued'] as $job_card_row):
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

						            $extrusion_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

						            $extrusion_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

						           
						                $total_extrusion_cost+=$extrusion_cost;
						                $total_extrusion_quantity+=$extrusion_quantity;
						                
						            endforeach;
						            }else{
						                    //echo "<tr><td colspan='8'>NO EXTRUSION FOR THIS JOB</td></tr>";
						                }
						            }
						        
						           //Purging Cost

			
					        $total_purging_cost=0;
					        $purging_cost=0;
					        $total_purging_quantity=0;
					        $purging_quantity=0;
					        $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
					        $data1=array_filter($master_array);
					        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
					        foreach($data2['job_card'] as $job_card_row){
					            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'9');
					            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');
					            if($data['job_card_issued']==TRUE){
					                
					            foreach ($data['job_card_issued'] as $job_card_row):
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

					            $purging_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

					            $purging_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

					           
					                $total_purging_cost+=$purging_cost;
					                $total_purging_quantity+=$purging_quantity;
					                
					            endforeach;
					            }else{
					                //echo "<tr><td colspan='8'>NO PURGING FOR THIS JOB</td></tr>";
					            }
					        }

					        //Heading STrat

					        $total_heading_cost=0;
					        $heading_cost=0;
					        $total_heading_quantity=0;
					        $heading_quantity=0;
					        $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
					        $data1=array_filter($master_array);
					        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
					        foreach($data2['job_card'] as $job_card_row){
					            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'2','from_job_card'=>'1');
					            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');
					            if($data['job_card_issued']==TRUE){
					            
					           foreach ($data['job_card_issued'] as $job_card_row):
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

					                if($ar_invoice_details_row->order_flag==1){


						            $query=$this->db->query("SELECT * from reserved_quantity_manu where manu_order_no='$job_card_row->manu_order_no' and article_no='$job_card_row->article_no' and ref_mm_id='$job_card_row->mm_id'");

						            $result_heading_value=$query->result();
						            if($result_heading_value==TRUE){

						            foreach($result_heading_value as $result_heading_value_row){
						                if($result_heading_value_row->total_qty!=$job_card_row->demand_qty){

						                $heading_cost=($this->common_model->read_number($result_heading_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

						                $heading_quantity=($this->common_model->read_number($result_heading_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

						                        }else{

						                        	$heading_cost=($this->common_model->read_number($result_heading_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

						                        	$heading_quantity=($this->common_model->read_number($result_heading_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                        }
						                    }
						                }

						            }else{

						                $heading_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

						                $heading_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

						            }

					                $total_heading_cost+=$heading_cost;
					                $total_heading_quantity+=$heading_quantity;
					                
					            endforeach;
					        }else{
					                //echo "<tr><td colspan='8'>NO HEADING FOR THIS JOB</td></tr>";
					            }
					        }


					        //Printing Start

					        $total_printing_cost=0;
					        $printing_cost=0;
					        $total_printing_quantity=0;
					        $printing_quantity=0;
					        $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
					        $data1=array_filter($master_array);
					        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
					        foreach($data2['job_card'] as $job_card_row){
					            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'3');
					            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');
					            if($data['job_card_issued']==TRUE){
					            
					           foreach ($data['job_card_issued'] as $job_card_row):
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

					                $query=$this->db->query("SELECT * from reserved_quantity_manu where manu_order_no='$job_card_row->manu_order_no' and article_no='$job_card_row->article_no' ");

					                $result_printing_value=$query->result();
					                foreach($result_printing_value as $result_printing_value_row){

					                    $ar_printing_cost=($this->common_model->read_number($result_printing_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_printing_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

					                    $ar_printing_quantity=($this->common_model->read_number($result_printing_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
					                }

					                $m_printing_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

					                $m_printing_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

					                if($ar_printing_quantity==$m_printing_quantity){
					                
					                    $printing_quantity=$m_printing_quantity;
					                    $printing_cost=$m_printing_cost;
					                }else{
					                    $printing_quantity=$ar_printing_quantity;
					                    $printing_cost=$ar_printing_cost;
					                }
					                $total_printing_cost+=$printing_cost;
					                $total_printing_quantity+=$printing_quantity;
					                
					            endforeach;
					        }else{
					                //echo "<tr><td colspan='8'>NO LACQUERING FOR THIS JOB</td></tr>";
					            }
					        }

					        $total_ink_cost=0;
					        if(strcmp($print_type_artwork, 'SCREEN') == 0 || strcmp($print_type_artwork, 'SCREEN+UPTO NECK') == 0 || strcmp($print_type_artwork, 'SCREEN + LABEL') == 0 || strcmp($print_type_artwork, 'SCREEN+FLEXO') == 0 || strcmp($print_type_artwork, 'OFFSET SCREEN') == 0 || strcmp($print_type_artwork, 'FLEXO+SCREEN') == 0 || strcmp($print_type_artwork, 'Screen') == 0){
					        	if($ar_invoice_master_row->invoice_date<'2020-10-01'){
					            $screen_ink_value_row=0;
					            $query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='3' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
					            $result_screen_ink_value=$query->result();
					            if($result_screen_ink_value==TRUE){
					            foreach($result_screen_ink_value as $result_screen_ink_value_row){
					                $screen_ink_value_row=$result_screen_ink_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
					                    $total_ink_cost+=$screen_ink_value_row;
					                }
					            }else{
					                //echo "<tr><td colspan='8'>SCREEN INK COSTSHEET MASTER IS NOT ENTERED</td></tr>";
					            }

					        	}else{

					        		$screen_ink_value_row=0;
					                $s_screen_ink_value_row=0;
					                $screen_ink_value_cost_per_kg=0;
					                $s_screen_ink_value_cost_per_kg=0;
					                $screen_ink_value_gm_tube=0;
					                $s_screen_ink_value_gm_tube=0;

									$query=$this->db->query("SELECT * from ink_price_master where ink_id='3' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
										$result_screen_ink_value=$query->result();
										foreach($result_screen_ink_value as $result_screen_ink_value_row){
											$screen_ink_value_cost_per_kg=$result_screen_ink_value_row->cost_per_kg;
										}

									$query=$this->db->query("SELECT * from ink_price_master where ink_id='4' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
										$result_s_screen_ink_value=$query->result();
										foreach($result_s_screen_ink_value as $result_s_screen_ink_value_row){
											$s_screen_ink_value_cost_per_kg=$result_s_screen_ink_value_row->cost_per_kg;
										}

										$query=$this->db->query("SELECT * from coex_ink_consumption_master where article_no='$costsheet[2]' and artwork_no='$ad_id' and artwork_version_no='$version_no' and archive<>1 limit 0,1");
										$result_screen_ink_gm_tube_result=$query->result();
										if($result_screen_ink_gm_tube_result==FALSE){

										}else{
											foreach($result_screen_ink_gm_tube_result as $result_screen_ink_gm_tube_row){
												$screen_ink_value_row=(($result_screen_ink_gm_tube_row->screen_ink_gm_tube*($ar_invoice_details_row->arid_qty/100))/1000)*$screen_ink_value_cost_per_kg;
												
												$s_screen_ink_value_row=(($result_screen_ink_gm_tube_row->special_ink_gm_tube*($ar_invoice_details_row->arid_qty/100))/1000)*$s_screen_ink_value_cost_per_kg;
											}
										}

										$total_ink_cost+=$screen_ink_value_row+$s_screen_ink_value_row;

					        	}
					        }

					        if(strcmp($print_type_artwork, 'OFFSET') == 0 || strcmp($print_type_artwork, 'OFFSET SCREEN') == 0 || strcmp($print_type_artwork, 'PLAIN') == 0 || strcmp($print_type_artwork, 'LABEL OFFSET') == 0){
					        	if($ar_invoice_master_row->invoice_date<'2020-10-01'){
					            $offset_ink_value_row=0;
					            $query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='2' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
					            $result_offset_ink_value=$query->result();
					            if($result_offset_ink_value==TRUE){
					            foreach($result_offset_ink_value as $result_offset_ink_value_row){
					                $offset_ink_value_row=$result_offset_ink_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

					                    $total_ink_cost+=$offset_ink_value_row;
					                }
					            }else{
					                //echo "<tr><td colspan='8'>OFFSET INK COSTSHEET MASTER IS NOT ENTERED</td></tr>";
					            	}
					        	}else{
					        		$offset_ink_value_row=0;
					        		$offset_ink_value_cost_per_kg=0;
					        		$offset_ink_value_gm_tube=0;
					        		$query=$this->db->query("SELECT * from ink_price_master where ink_id='2' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
					        		$result_offset_ink_value=$query->result();
									foreach($result_offset_ink_value as $result_offset_ink_value_row){
										$offset_ink_value_cost_per_kg=$result_offset_ink_value_row->cost_per_kg;
									}
									$query=$this->db->query("SELECT * from coex_ink_consumption_master where article_no='$costsheet[2]' and artwork_no='$ad_id' and artwork_version_no='$version_no' and archive<>1 limit 0,1");
									$result_offset_ink_gm_tube_result=$query->result();
									if($result_offset_ink_gm_tube_result==FALSE){

									}else{
										foreach($result_offset_ink_gm_tube_result as $result_offset_ink_gm_tube_row){
											$offset_ink_value_row=(($result_offset_ink_gm_tube_row->offset_ink_gm_tube*($ar_invoice_details_row->arid_qty/100))/1000)*$offset_ink_value_cost_per_kg;
											}
										}

										$total_ink_cost+=$offset_ink_value_row;
					        	}
					        }


					        if(strcmp($print_type_artwork, 'FLEXO') == 0 || strcmp($print_type_artwork, 'SCREEN+FLEXO') == 0 || strcmp($print_type_artwork, 'FLEXO+SCREEN') == 0){

					        	if($ar_invoice_master_row->invoice_date<'2020-10-01'){

					            $flexo_ink_value_row=0;
					            $query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='8' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
					            $result_flexo_ink_value=$query->result();
					            if($result_flexo_ink_value==TRUE){
					            foreach($result_flexo_ink_value as $result_flexo_ink_value_row){
					                $flexo_ink_value_row=$result_flexo_ink_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
					                $total_ink_cost+=$flexo_ink_value_row;
					                }
					            }else{
					                //echo "<tr><td colspan='8'>FLEXO INK COSTSHEET MASTER IS NOT ENTERED</td></tr>";
					            	}

					        	}else{

					        		$flexo_ink_value_row=0;
					        		$flexo_ink_value_cost_per_kg=0;
					        		$flexo_ink_value_gm_tube=0;
					        		$query=$this->db->query("SELECT * from ink_price_master where ink_id='1' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
					        		$result_flexo_ink_value=$query->result();
					        		foreach($result_flexo_ink_value as $result_flexo_ink_value_row){
					        			$flexo_ink_value_cost_per_kg=$result_flexo_ink_value_row->cost_per_kg;
									}
									$query=$this->db->query("SELECT * from coex_ink_consumption_master where article_no='$costsheet[2]' and artwork_no='$ad_id' and artwork_version_no='$version_no' and archive<>1 limit 0,1");
									$result_flexo_ink_gm_tube_result=$query->result();
									if($result_flexo_ink_gm_tube_result==FALSE){

									}else{
										foreach($result_flexo_ink_gm_tube_result as $result_flexo_ink_gm_tube_row){
											$flexo_ink_value_row=(($result_flexo_ink_gm_tube_row->flexo_ink_gm_tube*($ar_invoice_details_row->arid_qty/100))/1000)*$flexo_ink_value_cost_per_kg;
										}
									}

									$total_ink_cost+=$flexo_ink_value_row;
					        	}

					        }

					        if(strcmp($print_type_artwork, 'DIGITAL+FLEXO') == 0 || strcmp($print_type_artwork, 'FLEXO+DIGITAL') == 0 || strcmp($print_type_artwork, 'FLEXO+DIGITAL+FLEXO') == 0 ){
					        	if($ar_invoice_master_row->invoice_date<'2020-11-01'){
					            $digital_ink_value_row=0;
					            $query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='12' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
					            $result_digital_ink_value=$query->result();
					            if($result_digital_ink_value==TRUE){
					            foreach($result_digital_ink_value as $result_digital_ink_value_row){
					                $digital_ink_value_row=$result_digital_ink_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

					                    $total_ink_cost+=$digital_ink_value_row;
					                }
					            }else{
					                //echo "<tr><td colspan='8'>DIGITAL INK COSTSHEET MASTER IS NOT ENTERED</td></tr>";
					            }
					        	}else{
					        		$digital_ink_value=0;

					        		$query=$this->db->query("SELECT * from digital_ink_price_master where ink_id='5' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");

								//echo $this->db->last_query();
					        	$total_digi_ink=0;
								$result_digital_ink_pc=0;
								$result_digital_ink_rate=0;
								$result_digital_ink_pc_value=$query->result();
								foreach($result_digital_ink_pc_value as $result_digital_ink_pc_value_row){
										$result_digital_ink_pc=$result_digital_ink_pc_value_row->other_charges_pc;
										$result_digital_ink_rate=$result_digital_ink_pc_value_row->rate_of_exchange;
								}

								if($result_digital_ink_pc<>0){
									$query_digi=$this->db->query("SELECT * FROM `springtube_printing_jobsetup_master` WHERE `order_no`='$costsheet[1]' AND article_no='$costsheet[2]'");

									$digital_ink_value=0;
									$digital_ink_valuee=0;
									$digital_ink_valueee=0;
									$result_digital_ink_value=$query_digi->result();
									foreach($result_digital_ink_value as $result_digital_ink_value_row){
										$digital_ink_valuee=((($result_digital_ink_value_row->digital_cost_in_euro/2000)*$result_digital_ink_rate)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']));
										$digital_ink_valueee=($digital_ink_valuee/100)*$result_digital_ink_pc;
										$digital_ink_value=$digital_ink_valuee+$digital_ink_valueee;
										$total_digi_ink+=$digital_ink_value;
										//echo round($digital_ink_value,2);
									}

								}

								$total_ink_cost+=$total_digi_ink;

					        	}
					        }

					        $total_total_printing_cost=0;
					        $total_total_printing_cost=$total_ink_cost+$total_printing_cost;

					        $total_consumable=0;
				            if(strcmp($print_type_artwork, 'SCREEN') == 0 || strcmp($print_type_artwork, 'SCREEN+UPTO NECK') == 0 || strcmp($print_type_artwork, 'SCREEN + LABEL') == 0 || strcmp($print_type_artwork, 'SCREEN+FLEXO') == 0 || strcmp($print_type_artwork, 'FLEXO+SCREEN') == 0 || strcmp($print_type_artwork, 'Screen') == 0){
				            $other_screen_consumable=0;
				            $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='5' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
				            $result_other_screen_consumable_value=$query->result();
				            if($result_other_screen_consumable_value==TRUE){
				            foreach($result_other_screen_consumable_value as $result_other_screen_consumable_value_row){
				                $other_screen_consumable=$result_other_screen_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
				                $total_consumable+=$other_screen_consumable;
				                }
				                }else{
				                    //echo "<tr><td colspan='8'>OTHER SCREEN CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
				                }
				            }

				            if(strcmp($print_type_artwork, 'OFFSET') == 0 || strcmp($print_type_artwork, 'OFFSET SCREEN') == 0 || strcmp($print_type_artwork, 'PLAIN') == 0 || strcmp($print_type_artwork, 'LABEL OFFSET') == 0){
				            $other_offset_consumable=0;
				            $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='4' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
				            $result_other_offset_consumable_value=$query->result();
				            if($result_other_offset_consumable_value==TRUE){
				            foreach($result_other_offset_consumable_value as $result_other_offset_consumable_value_row){
				                $other_offset_consumable=$result_other_offset_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
				                	$total_consumable+=$other_offset_consumable;
				                }
				                }else{
				                    //echo "<tr><td colspan='8'>OTHER OFFSET CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
				                }
				            }

				            if(strcmp($print_type_artwork, 'FLEXO') == 0 || strcmp($print_type_artwork, 'SCREEN+FLEXO') == 0 || strcmp($print_type_artwork, 'FLEXO+SCREEN') == 0){
				            $other_flexo_consumable=0;
				            $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='3' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
				            $result_other_flexo_consumable_value=$query->result();
				            if($result_other_flexo_consumable_value==TRUE){
				            foreach($result_other_flexo_consumable_value as $result_other_flexo_consumable_value_row){
				                $other_flexo_consumable=$result_other_flexo_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
				                    $total_consumable+=$other_flexo_consumable;
				                }
				                }else{
				                   // echo "<tr><td colspan='8'>OTHER FLEXO CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
				                }
				            }

				             if($order_flag==1){
			                $decoseam_consumable=0;
			                $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='6' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
			                $result_decoseam_consumable_value=$query->result();
				            if($result_decoseam_consumable_value==TRUE){
				            foreach($result_decoseam_consumable_value as $result_decoseam_consumable_value_row){
				                $decoseam_consumable=$result_decoseam_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
				                    $total_consumable+=$decoseam_consumable;
				                }
				                }else{
				                   // echo "<tr><td colspan='8'>OTHER DECOSEAM CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
				                }
				            }


				            $hygenic_consumable=0;
				            $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='2' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
				            $result_hygenic_consumable_value=$query->result();
				            if($result_hygenic_consumable_value==TRUE){
				            foreach($result_hygenic_consumable_value as $result_hygenic_consumable_value_row){
				                $hygenic_consumable=$result_hygenic_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
				                    $total_consumable+=$hygenic_consumable;
				                }
				                }else{
				                    //echo "<tr><td colspan='8'>OTHER HYGENIC CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
				                }


				            $other_consumable=0;
			                $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='1' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
			                $result_other_consumable_value=$query->result();
			                if($result_other_consumable_value==TRUE){
			                foreach($result_other_consumable_value as $result_other_consumable_value_row){
			                    $other_consumable=$result_other_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
			                    $total_consumable+=$other_consumable;
			                    }
			                }else{
			                    //echo "<tr><td colspan='8'>OTHER  CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
			                }


			                $data['daily_plate_master']=$this->common_model->select_one_active_record('graphics_daily_plates_master',$this->session->userdata['logged_in']['company_id'],'order_no',$ar_invoice_details_row->ref_ord_no);
				            if($data['daily_plate_master']==TRUE){
				                $total_offset_plates=0;
				                $total_screen_positive=0;
				                $total_flexo_plates=0;
				                $offset_plates=0;
				                $screen_positive=0;
				                $flexo_plates=0;
				                foreach($data['daily_plate_master'] as $row_plate_record){

				                    $data_plates=array('dpr_id'=>$row_plate_record->dpr_id);
				                    //$this->load->model('daily_plates_record_model');
				                    $result_plates=$this->daily_plates_record_model->select_no_plates('graphics_daily_plates_details',$data_plates);
				                    //echo $this->db->last_query();
				                    foreach ($result_plates as $row_plates) {
				                        $offset_plates=$row_plates->offset;
				                        $screen_positive=$row_plates->screen;
				                        $flexo_plates=$row_plates->flexo;
				                    }
				                    $total_offset_plates+=($offset_plates/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
				                    $total_screen_positive+=($screen_positive/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
				                    $total_flexo_plates+=($flexo_plates/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
				                }
				            }else{
				                $total_offset_plates=0;
				                $total_screen_positive=0;
				                $total_flexo_plates=0;
				                $offset_plates=0;
				                $screen_positive=0;
				                $flexo_plates=0;
				            }



				$total_screens=0;
                $screens=0;
                $data['daily_screen_master']=$this->common_model->select_one_active_record('graphics_daily_screen_master',$this->session->userdata['logged_in']['company_id'],'order_no',$ar_invoice_details_row->ref_ord_no);
                if($data['daily_screen_master']==TRUE){
                    foreach($data['daily_screen_master'] as $row_screen_record){
                        $data_screens=array('dsr_id'=>$row_screen_record->dsr_id);
                        //$this->load->model('daily_plates_record_model');
                        $result_screens=$this->daily_screen_record_model->select_no_screen('graphics_daily_screen_details',$data_screens);
                        foreach ($result_screens as $row_screens) {
                        $screens=$row_screens->screen;
                        }
                    $total_screens+=($screens/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                    }
                }

                $total_screen_and_plate_cost=0;
                $total_screen_and_plate_cost_per_tube=0;
                $screen_value=0;
                //$total_screens=0;
                ($print_type_artwork=='' ? $print_type_bom : $print_type_artwork);

                if(strpos($print_type_artwork, 'SCREEN+FLEXO') !== false || strpos($print_type_artwork, 'FLEXO+SCREEN') !== false || strpos($print_type_artwork, 'SCREEN') !== false || strpos($print_type_artwork, 'SCREEN + LABEL') !== false  || strpos($print_type_artwork, 'SCREEN+UPTO NECK') !== false || strpos($print_type_artwork, 'OFFSET SCREEN') !== false || strpos($print_type_artwork, 'Screen') !== false){

                $query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='3' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                $result_screen_value=$query->result();
                        if($result_screen_value==TRUE){
                            foreach($result_screen_value as $result_screen_value_row){
                                $screen_rate=$result_screen_value_row->consumption_unit_rate;
                            }

                            $screen_value=$total_screens*$screen_rate;
                            $screen_cost_per_tube=$screen_value/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                            
                            //$total_screens+=$invoice_wise_screen_value;
                            $total_screen_and_plate_cost+=$screen_value;
                            $total_screen_and_plate_cost_per_tube+=$screen_cost_per_tube;

                        }else{
                        //echo "Please Set the  Screen Price in Master";
                        }
                    }

                    $offset_plates_value=0;
                    ($print_type_artwork=='' ? $print_type_bom:$print_type_artwork);
                    //$total_offset_plates=0;
                    if(strpos($print_type_artwork, 'OFFSET') !== false || strpos($print_type_artwork, 'OFFSET SCREEN') !== false){

                        $query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='2' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                            $result_offset_value=$query->result();
                            if($result_offset_value==TRUE){
                                foreach($result_offset_value as $result_offset_value_row){
                                    $offset_plate_rate=$result_offset_value_row->consumption_unit_rate;
                                }
                                $offset_plates_value=$total_offset_plates*$offset_plate_rate;
                                $offset_plates_cost_per_tube=$offset_plates_value/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                                //echo round($invoice_wise_offset_plates_value,2);
                                //$total_offset_plates+=$invoice_wise_offset_plates_value;
                                $total_screen_and_plate_cost+=$offset_plates_value;
                                $total_screen_and_plate_cost_per_tube+=$offset_plates_cost_per_tube;
                            }else{
                            //echo "Please set the Offset Plate Price in Master";  
                            }
                        }

                        $flexo_plates_value=0;
                        ($print_type_artwork==''? $print_type_artwork=$print_type_bom : $print_type_artwork);
                        //$total_flexo_plates=0;
                            if(strpos($print_type_artwork, 'FLEXO') !== false || strpos($print_type_artwork, 'SCREEN+FLEXO') !== false || strpos($print_type_artwork, 'FLEXO+SCREEN') !== false || strpos($print_type_artwork, 'FLEXO+DIGITAL')!== false || strpos($print_type_artwork, 'FLEXO+DIGITAL+FLEXO')!== false || strpos($print_type_artwork, 'DIGITAL+FLEXO')!== false || strpos($print_type_artwork, 'SCREEN') !== false){
                                $query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='8' OR lacquer_type_id='6' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");

                                $result_flexo_value=$query->result();
                                if($result_flexo_value==TRUE){
                                    foreach($result_flexo_value as $result_flexo_value_row){
                                        $flexo_plate_rate=$result_flexo_value_row->consumption_unit_rate;
                                    }

                                    $flexo_plates_value=$total_flexo_plates*$flexo_plate_rate;
                                    $flexo_plates_cost_per_tube=$flexo_plates_value/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                                   // $invoice_wise_flexo_plates_value=$flexo_plates_cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                                    //echo round($invoice_wise_flexo_plates_value,2);
                                    //$total_flexo_plates+=$invoice_wise_flexo_plates_value;
                                    $total_screen_and_plate_cost+=$flexo_plates_value;
                                    $total_screen_and_plate_cost_per_tube+=$flexo_plates_cost_per_tube;
                                }else{
                                //echo "Please set the Flexo Plate Price in Master'";
                                }

                            }
                        $total_screen_plate_quantity=0;
                        $total_screen_plate_quantity=$total_screens+$total_offset_plates+$total_flexo_plates;

                        if($order_flag==1){

                            //echo $order_flag;
                            $flexo_plates=0;
                            $total_flexo_plate_quantity=0;

                            $data_springtube_plates=array('order_no'=>$ar_invoice_details_row->ref_ord_no,'article_no'=>$ar_invoice_details_row->article_no,'archive'=>0);
                            $springtube_daily_plates_master_result=$this->common_model->select_active_records_where('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],$data_springtube_plates);
                            foreach ($springtube_daily_plates_master_result as $key => $springtube_daily_plates_master_row) {

                                $flexo_plates+=$springtube_daily_plates_master_row->total_plates;                                
                            }

                            $total_flexo_plate_quantity=($flexo_plates)*($this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch);

                            if($total_flexo_plate_quantity!=0){

                                $query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='8'  OR lacquer_type_id='6' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");

                                $result_flexo_value=$query->result();
                                if($result_flexo_value==TRUE){
                                    foreach($result_flexo_value as $result_flexo_value_row){
                                       $flexo_plate_rate=$result_flexo_value_row->consumption_unit_rate;
                                    }

                                    $flexo_plates_value=$total_flexo_plate_quantity*$flexo_plate_rate;
                                    $flexo_plates_cost_per_tube=$flexo_plates_value/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                                    
                                    $total_screen_and_plate_cost=$flexo_plates_value;
                                    $total_screen_and_plate_cost_per_tube=$flexo_plates_cost_per_tube;
                                    
                                }else{
                                //echo "Please set the Flexo Plate Price in Master'";
                                }


                            }
                        }



                        

                    $data['lacquer_types_master']=$this->costsheet_model->select_one_active_record('lacquer_types_master',$this->session->userdata['logged_in']['company_id'],'lacquer_type',$print_type_bom);

                    $m=0;
                    foreach($data['lacquer_types_master'] as $lacquer_types_row){
                        $lacquer_type_id=$lacquer_types_row->lacquer_type_id;
                        $lacquer_array[$m] = $lacquer_type_id;
                        $m++;

                    }

                    $query=$this->db->query("SELECT * from uv_consumption_master where lacquer_type_id='$lacquer_type_id' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                    $result_uv_lamp=$query->result();
                    $uv_lamp_cost=0;
                    if($result_uv_lamp==TRUE){
                    foreach($result_uv_lamp as $result_uv_lamp_row){
                        $uv_lamp_cost=$result_uv_lamp_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                            $total_consumable+=$uv_lamp_cost;
                        }
                        }else{
                            //echo "<tr><td colspan='8'>UV MASTER IS NOT ENTERED</td></tr>";
                    }

                     $total_screen_and_plate_cost;

                    $total_consumable+=$total_screen_and_plate_cost;


                    //Labeling Start

                 $total_labeling_cost=0;
		        $labeling_cost=0;
		        $total_labeling_quantity=0;
		        $labeling_quantity=0;
		        $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
		        $data1=array_filter($master_array);
		        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
		        foreach($data2['job_card'] as $job_card_row){
		        	 $job_card_no=$job_card_row->mp_pos_no;
		        }

		        $query=$this->db->query("SELECT * from reserved_quantity_manu where manu_order_no='$job_card_no' and article_no like 'LBL%'");
		                $result_label_value=$query->result();
		            foreach($result_label_value as $result_label_value_row){

		             $labeling_cost=($this->common_model->read_number($result_label_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_label_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);


		             $labeling_quantity=($this->common_model->read_number($result_label_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
		             
		             $total_labeling_cost+=$labeling_cost;
		             $total_labeling_quantity+=$labeling_quantity;
		          }

        		
            

        $total_foiling_cost=0;
        $foiling_cost=0;
        $total_foiling_quantity=0;
        $foiling_quantity=0;
        $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
        $data1=array_filter($master_array);
        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
        foreach($data2['job_card'] as $job_card_row){
            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'6');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');
            if($data['job_card_issued']==TRUE){
            
            foreach ($data['job_card_issued'] as $job_card_row):
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
            $foiling_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $foiling_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

          
                $total_foiling_cost+=$foiling_cost;
                $total_foiling_quantity+=$foiling_quantity;
                
            endforeach;
            }else{
                //echo "<tr><td colspan='6'>NO FOILING FOR THIS JOB</td></tr>";
            }
        }


        	$total_shoulderfoil_cost=0;
            $total_shoulderfoil_quantity=0;
            $shouldefoil_quantity=0;
            $shouldefoil_cost=0;
            $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            foreach($data2['job_card'] as $job_card_row){
                $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'7');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');

            if($data['job_card_issued']==TRUE){
                
            foreach ($data['job_card_issued'] as $job_card_row):
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

                $shouldefoil_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                $shouldefoil_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

            
                $total_shoulderfoil_cost+=$shouldefoil_cost;
                $total_shoulderfoil_quantity+=$shouldefoil_quantity;
               
            endforeach;
            }else{
                //echo "<tr><td colspan='6'>NO SHOULDER FOILING FOR THIS JOB</td></tr>";
            	}
        	}

        	$total_capping_cost=0;
            $capping_cost=0;
            $total_capping_quantity=0;
            $capping_quantity=0;
            $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            
            if($data2['job_card']!=FALSE){
            	foreach ($data2['job_card'] as $job_card_row){
            	$job_card_no=$job_card_row->mp_pos_no;

            		if($cap_metalization!=''){
            			$query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price,article_no from reserved_quantity_manu where manu_order_no='$job_card_no' and article_no like '%CAME-%'");
            		}else{
            			$query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price,article_no from reserved_quantity_manu where manu_order_no='$job_card_no' and article_no like '%CAPS-000%'");
            		}
            		

		           // echo $this->db->last_query();

		                $result_capping_value=$query->result();
		                if($result_capping_value==TRUE){
		                foreach($result_capping_value as $result_capping_value_row){
		                     $cap_article=$this->common_model->get_article_name($result_capping_value_row->article_no,$this->session->userdata['logged_in']['company_id']);

		                    $ar_capping_cost=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

		                    $ar_capping_quantity=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

		                    $ar_cap_price=$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
		                }
		                    $capping_quantity=$ar_capping_quantity;
		                    $capping_cost=$ar_capping_cost;
		                    $cap_price=$ar_cap_price;


		            
		                $total_capping_cost+=$capping_cost;
		                $total_capping_quantity+=$capping_quantity;
		               
		            
		            }else{
		                //echo "<tr><td colspan='6'>NO CAPPING FOR THIS JOB</td></tr>";
		            	}


            	}
            }else{
            	$job_card_no="";
            }    
            


            $total_capping_s_cost=0;
            $capping_s_cost=0;
            $total_capping_s_quantity=0;
            $capping_s_quantity=0;
            $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            if($data2['job_card']!=FALSE){
            foreach ($data2['job_card'] as $job_card_row){
                $job_card_no=$job_card_row->mp_pos_no;
           

            $query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price,article_no from reserved_quantity_manu where manu_order_no='$job_card_no' and article_no like 'RM-CAS%'");

             $this->db->last_query();

                $result_capping_s_value=$query->result();
                if($result_capping_s_value==TRUE){
                foreach($result_capping_s_value as $result_capping_value_row){
                     $cap_article=$this->common_model->get_article_name($result_capping_value_row->article_no,$this->session->userdata['logged_in']['company_id']);

                    $ar_capping_s_cost=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                    $ar_capping_s_quantity=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                    $ar_cap_s_price=$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
                }
                    $capping_s_quantity=$ar_capping_s_quantity;
                    $capping_s_cost=$ar_capping_s_cost;
                    $cap_s_price=$ar_cap_s_price;

                $total_capping_s_cost+=$capping_s_cost;
                $total_capping_s_quantity+=$capping_s_quantity;
                
            }
            else{

            }
        }
    }else{
    	$job_card_no="";
    }

    	$total_capping_m_cost=0;
    	/*
            $capping_m_cost=0;
            $total_capping_m_quantity=0;
            $capping_m_quantity=0;
            $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            
            if($data2['job_card']!=FALSE){
            	foreach ($data2['job_card'] as $job_card_row){
            	$job_card_no=$job_card_row->mp_pos_no;

            		$query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price,article_no from reserved_quantity_manu where manu_order_no='$job_card_no' and article_no like '%CAP-CAME-%'");

		            $this->db->last_query();

		                $result_capping_m_value=$query->result();
		                if($result_capping_m_value==TRUE){
		                foreach($result_capping_m_value as $result_capping_m_value_row){
		                     $cap_m_article=$this->common_model->get_article_name($result_capping_m_value_row->article_no,$this->session->userdata['logged_in']['company_id']);

		                    $ar_capping_m_cost=($this->common_model->read_number($result_capping_m_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_capping_m_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

		                    $ar_capping_m_quantity=($this->common_model->read_number($result_capping_m_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

		                    $ar_cap_m_price=$this->common_model->read_number($result_capping_m_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
		                }
		                    $capping_m_quantity=$ar_capping_m_quantity;
		                    $capping_m_cost=$ar_capping_m_cost;
		                    $cap_m_price=$ar_cap_m_price;


		            
		                $total_capping_m_cost+=$capping_m_cost;
		                $total_capping_m_quantity+=$capping_m_quantity;
		               
		            
		            }else{
		                //echo "<tr><td colspan='6'>NO CAPPING FOR THIS JOB</td></tr>";
		            	}


            	}
            }else{
            	$job_card_no="";
            }
            
        	*/

        	$total_packing_cost=0;
            $packing_quantity=0;
            $packing_cost=0;
            $total_packing_quantity=0;
            $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            foreach($data2['job_card'] as $job_card_row){
             $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'10','from_job_card'=>'1');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');

            if($data['job_card_issued']==TRUE){
            foreach ($data['job_card_issued'] as $job_card_row):
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

            $packing_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $packing_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

            
                $total_packing_cost+=$packing_cost;
                $total_packing_quantity+=$packing_quantity;
                
            endforeach;
            }else{
               // echo "<tr><td colspan='6'>NO PACKING FOR THIS JOB</td></tr>";
            }
        }

            $total_other_packing_cost=0;
            $packing_type;
            if($packing_type==1){
                $query=$this->db->query("SELECT * from packing_material_consumption_master where apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            }else{
                $query=$this->db->query("SELECT * from packing_material_consumption_master where apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1 and for_export<>1");
            }
            

            $result_other_packing=$query->result();
            //echo $this->db->last_query();
            if($result_other_packing==TRUE){
            foreach($result_other_packing as $result_other_packing_row){
                $other_packing=$result_other_packing_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                
                    $total_other_packing_cost+=$other_packing;
                }
                }else{
                    //echo "<tr><td colspan='8'>PACKING MASTER IS NOT ENTERED</td></tr>";
                }
            $total_total_packing_cost=0;
            $total_total_packing_cost=$total_other_packing_cost+$total_packing_cost;


            $total_stores_spares_cost=0;
            $query=$this->db->query("SELECT * from stores_and_spares_consumption_master where apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_stores_spares=$query->result();
            if($result_stores_spares==TRUE){
            foreach($result_stores_spares as $stores_spares_row){
                $stores_spares_cost=$stores_spares_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                
                    $total_stores_spares_cost+=$stores_spares_cost;
                }
                }else{
                    //echo "<tr><td colspan='8'>STORES AND SPARES MASTER IS NOT ENTERED</td></tr>";
                }



        $total_additional_cost=0;
        $additional_cost=0;
        $total_additional_quantity=0;
        $additional_quantity=0;
        $master_array= array('article_no' =>$costsheet[2],'sales_ord_no'=>$costsheet[1]);
        $data1=array_filter($master_array);
        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
        foreach($data2['job_card'] as $job_card_row){
            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','from_job_card'=>'0');

            $in=array('5','11');

            $data['job_card_issued']=$this->costsheet_model->select_additional('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,$in,'article_no','work_proc_no');

            if($data['job_card_issued']==TRUE){
            foreach ($data['job_card_issued'] as $job_card_row):
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

            $m_additional_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $m_additional_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);



            $query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price from reserved_quantity_manu where manu_order_no='$job_card_row->manu_order_no' and article_no='$job_card_row->article_no' and type_flag='4' and article_no NOT LIKE '%LBL-'");

            $this->db->last_query();

                $result_additional_value=$query->result();
                foreach($result_additional_value as $result_additional_value_row){

                    $ar_additional_cost=($this->common_model->read_number($result_additional_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_additional_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                   $ar_additional_quantity=($this->common_model->read_number($result_additional_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                   
                }

                if($ar_additional_quantity==$m_additional_quantity){
                    
                    $additional_quantity=$m_additional_quantity;
                    $additional_cost=$m_additional_cost;
                }else{
                    $additional_quantity=$ar_additional_quantity;
                    $additional_cost=$ar_additional_cost;
                    //$cap_price=$ar_cap_price;
                }

                $total_additional_cost+=$additional_cost;
                $total_additional_quantity+=$additional_quantity;
                
            endforeach;
            }else{
                    //echo "<tr><td colspan='8'>NO ADDITIONAL MATERIAL FOR THIS JOB</td></tr>";
                }
            }

             
            $total_freight=0;
            $total_freight_amount=0;
            $query=$this->db->query("SELECT * from freight_master where sleeve_id='$dia' and customer_no='$ar_invoice_master_row->customer_no' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_freight_value=$query->result();
            //echo $this->db->last_query();
            if($result_freight_value==TRUE){
            foreach($result_freight_value as $result_freight_value_row){
                $total_freight=$result_freight_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                    $total_freight_amount+=$total_freight;
                }
                }else{
                    //echo "<tr><td colspan='8'>FREIGHT IS NOT ENTERED</td></tr>";
                }


                $total_other_cost=0;
	            $total_other_cost_amount=0;
	            $query=$this->db->query("SELECT * from other_cost_master where company_id='000020' and archive<>1 and (order_flag=".$order_flag." or order_flag=3) and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
				$result_other_cost=$query->result();

				if($result_other_cost==TRUE){
					foreach($result_other_cost as $other_cost_row){
						$total_other_cost=$other_cost_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
						$total_other_cost_amount+=$total_other_cost;
													                
						}
					}else{

					} 
			
                

            
        
        	 $total_final_cost=$total_extrusion_cost+$total_purging_cost+$total_heading_cost+$total_total_printing_cost+$total_consumable+$total_labeling_cost+$total_foiling_cost+$total_shoulderfoil_cost+$total_capping_cost+$total_capping_s_cost+$total_capping_m_cost+$total_total_packing_cost+$total_stores_spares_cost+$total_additional_cost+$total_freight_amount+$total_other_cost_amount;

        	$contribution=0;
            $contribution=$unit_rate_in_rupees*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])-$total_final_cost;
            $contribution_cost_per_tube=$unit_rate_in_rupees-round($total_final_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);



            $count=$this->common_model->active_record_count_where('costsheet_master',$this->session->userdata['logged_in']['company_id'],'invoice_no',$ar_invoice_master_row->ar_invoice_no,'article_no',$costsheet[2],'archive','0');

       
            if($count==0){
            	$data=array(
            		'invoice_no'=>$ar_invoice_master_row->ar_invoice_no,
					'company_id'=>$this->session->userdata['logged_in']['company_id'],
					'invoice_date'=>$ar_invoice_master_row->invoice_date,
					'order_type'=>$order_flag,
						                'order_no'=>$costsheet[1],
						                'customer_id'=>$ar_invoice_master_row->customer_no,
						                'article_no'=>$costsheet[2],
						                'dia'=>$dia,
						                'length'=>$length,
						                'print_type'=>$print_type_artwork,
						                'dispatch_quantity'=>$ar_invoice_details_row->arid_qty/100,
						                'unit_rate'=>$unit_rate_in_rupees,
						                'archive'=>'0',
						                'sleeve_cost'=>$total_extrusion_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'purging_cost'=>$total_purging_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'shoulder_cost'=>$total_heading_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'printing_cost'=>$total_total_printing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'cosumable_cost'=>$total_consumable/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'label_cost'=>$total_labeling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'foil_cost'=>$total_foiling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'shoulder_foil_cost'=>$total_shoulderfoil_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'capping_cost'=>$total_capping_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'shrink_sleeve_cost'=>$total_capping_s_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'metalization_cost'=>$total_capping_m_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'packaging_cost'=>$total_total_packing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'stores_spares_cost'=>$total_stores_spares_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'additional_cost'=>$total_additional_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'freight_cost'=>$total_freight_amount/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'other_cost'=>$total_other_cost_amount/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                
						                'total_cost'=>$total_final_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'con_per_tube'=>$contribution_cost_per_tube,
						                'con_percentage'=>round((($unit_rate_in_rupees-($total_final_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])))/$unit_rate_in_rupees)*100),
						                'status'=>$costsheet[3],
						                'status_flag'=>$costsheet[4],
						                'total_costing'=>round($total_final_cost,2)
						                );

									 $result=$this->common_model->save('costsheet_master',$data);
									}else{
										$data=array(
										'order_type'=>$order_flag,
						                'order_no'=>$costsheet[1],
						                'customer_id'=>$ar_invoice_master_row->customer_no,
						                'article_no'=>$costsheet[2],
						                'dia'=>$dia,
						                'length'=>$length,
						                'print_type'=>$print_type_artwork,
						                'dispatch_quantity'=>$ar_invoice_details_row->arid_qty/100,
						                'unit_rate'=>$unit_rate_in_rupees,
						                'archive'=>'0',
						                'sleeve_cost'=>$total_extrusion_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'purging_cost'=>$total_purging_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'shoulder_cost'=>$total_heading_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'printing_cost'=>$total_total_printing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'cosumable_cost'=>$total_consumable/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'label_cost'=>$total_labeling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'foil_cost'=>$total_foiling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'shoulder_foil_cost'=>$total_shoulderfoil_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'capping_cost'=>$total_capping_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'metalization_cost'=>$total_capping_m_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'shrink_sleeve_cost'=>$total_capping_s_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'packaging_cost'=>$total_total_packing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'stores_spares_cost'=>$total_stores_spares_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'additional_cost'=>$total_additional_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'freight_cost'=>$total_freight_amount/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),

						                'other_cost'=>$total_other_cost_amount/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                
						                'total_cost'=>$total_final_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),
						                'con_per_tube'=>$contribution_cost_per_tube,
						                'con_percentage'=>round((($unit_rate_in_rupees-($total_final_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])))/$unit_rate_in_rupees)*100),
						                'status'=>$costsheet[3],
						                'status_flag'=>$costsheet[4],
						                'total_costing'=>round($total_final_cost,2)
						              );
										$result=$this->common_model->update_one_active_record_where('costsheet_master',$data,'invoice_no',$ar_invoice_master_row->ar_invoice_no,'article_no',$costsheet[2],$this->session->userdata['logged_in']['company_id']);
									}
        
            			//Actual Start
			   			echo '<div class="four wide column">
			   					<div class="ui vertical menu">
								  <div class="item">
								    <div class="header">'; print_r($costsheet[2]); echo '</div>
								    <div class="menu">
								      	<a class="item">'.$dia.' X '.$length.'</a>
								      	<a class="item">'.$print_type_artwork.'/ <i>'.$order_details_row->order_no.'</i></a>
								      	<a class="item"><i>'.str_pad(substr($this->common_model->get_article_name($costsheet[2],$this->session->userdata['logged_in']['company_id']),0,40),40,"-").'</i></a>
								    </div>
								  </div>
								  <div class="item">
								    <div class="header">'.substr(ucwords(strtolower($ar_invoice_master_row->customer_name)),0,20).'</div>
								    <div class="menu">
								      <a class="item" href='.base_url('index.php/costsheet/view/'.$costsheet[0].'/'.$costsheet[1].'/'.$costsheet[2]).' target="_blank">'.$ar_invoice_master_row->ar_invoice_no.'</a>
								      <a class="item">'.$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']).'</a>
								      <a class="item">&#8377;'.$unit_rate_in_rupees.'</a>
								      <a class="item">&#8377;'.number_format($unit_rate_in_rupees*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])).'</a>
								    </div>
								  </div>

								  <div class="item">
								    <div class="header">Cost/Tube</div>
								    <div class="menu">
								      <a class="item">'.round($total_extrusion_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_purging_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_heading_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_total_printing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_consumable/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_labeling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_foiling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_shoulderfoil_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_capping_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_capping_s_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_capping_m_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_total_packing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_stores_spares_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_additional_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_freight_amount/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								      <a class="item">'.round($total_other_cost_amount/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</a>
								    </div>
								  </div>

								  <div class="item">
								    <div class="header">'.round($total_final_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2).'</div>
								    <div class="menu">
								      <a class="item"><b>'.round($contribution_cost_per_tube,2).'</b></a>
								    </div>
								  </div>

								</div>
							</div>';
							$count++;
							endforeach;
							endforeach;
					//Actual End
	              }
             ?>

		  
		  
		</div>
	</div>
</form>
				
				
				
				
				
			