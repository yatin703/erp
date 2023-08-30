 <style>
      .tableFixHead {
        overflow-y: auto;
        height: 500px;
      }
      .tableFixHead thead th {
        position: sticky;
        top: 0;
      }
  </style>
<script type='text/javascript'>	
function chkall(source) {
	checkboxes = document.getElementsByName('costsheet_id[]');
	for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	}
}
</script>
<div class="record_form_design">
<h4>Search Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?> <i>Note : Green color records states the spethisfic order numbers dispatches has been completed and closed</i></h4>
	 <div class="record_inner_design">
	 	<div class="tableFixHead">
					<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/compare');?>" method="POST" target="_blank">

						<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
						<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
						<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
					<table class="record_table_design_without_fixed">
					<thead>
						<tr>
							<th><div class='ui checkbox'><input type="checkbox" name="all_chk[]" onClick="chkall(this)"><label>Sr No</label></div></th>
							<th>Invoice Date</th>
							<th>Invoice</th>
							<th>Customer</th>
							<th>Order</th>
							<th>Status</th>
							<th>Dia</th>
							<th>Length</th>
							<th>Print Type</th>
							<th>Article No</th>
							<th>Article Description</th>
							<th>Dispatch Quantity</th>
							<th>Unit Rate</th>
							<th>Net Amount</th>
							<th>Film</th>
							<th>Purg</th>
							<th>Shoulder</th>
							<th>Printing</th>
							<th>Digital Ink</th>
							<th>Consumable</th>
							<th>Label</th>
							<th>Foil</th>
							<th>Shoulder Foil</th>
							<th>Cap</th>
							<th>Shrink Sleeve</th>
							<th>Packing</th>
							<th>Stores & Spares</th>
							<th>Additional</th>
							<th>Freight</th>
							<th>Total Cost</th>
						</tr>
					</thead>
					<tbody>
					<?php
					setlocale(LC_MONETARY, 'en_IN');
 
					if($ar_invoice_master==FALSE){
						echo "<tr><td colspan='7'>No Records Found</td></tr>";
					}else{
						$n=1;
						foreach($ar_invoice_master as $mrow){
							$details_data=array();
							$details_data['ar_invoice_no']=$mrow->ar_invoice_no;
							if(!empty($this->input->post('article_no'))){
									$arr=explode("//",$this->input->post('article_no'));
									$article_no=$arr[1];
									$details_data['article_no']=$article_no;
							}

					if(!empty($this->input->post('sleeve_dia'))){$details_data['sleeve_dia']=$this->input->post('sleeve_dia');}
					if($this->input->post('order_flag')!=''){$details_data['order_flag']=$this->input->post('order_flag');}
					if($this->input->post('order_no')!=''){$details_data['ref_ord_no']=$this->input->post('order_no');}
					if($this->input->post('print_type')!=''){$print=$this->input->post('print_type');}else{$print="";}

					$result=$this->costsheet_model->active_details_records('ar_invoice_details',$details_data,$print,$this->session->userdata['logged_in']['company_id']);
					$rowspan=count($result);
					if($rowspan>0){

					$currency=($mrow->currency_id!='' ? $mrow->currency_id:'');
							if($mrow->invoice_date>='2019-06-01'){
								$exchange_rate=($mrow->exchange_rate!='0' ?$mrow->exchange_rate:'');
								}else{
									$exchange_rate=($mrow->exchange_rate!='0' ? $this->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']):'');
									}

									foreach ($result as $drow){
										$total_final_cost=0;
										$order_details=array('ref_ord_no'=>$drow->ref_ord_no,'article_no'=>$drow->article_no);
										$result_dispatch=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$order_details);
										$total_dispatch=0;
										foreach($result_dispatch as $row_total_dispatch){
												$total_dispatch+=$this->common_model->read_number($row_total_dispatch->arid_qty,$this->session->userdata['logged_in']['company_id']);
																		
										}

										$order_no=$drow->ref_ord_no;								
										$order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
										
										$so_data=array();
										$so_data['order_no']=$drow->ref_ord_no;
										$so_data['article_no']=$drow->article_no;
										$so_result=$this->sales_invoice_book_model->active_details_records('order_details',$so_data,$this->session->userdata['logged_in']['company_id']);

										foreach ($order_master_result as $order_master_row) {
											$po_no=$order_master_row->cust_order_no;
											$po_date=$order_master_row->cust_order_date;
											$trans_closed=$order_master_row->trans_closed;
											//$so_quantity=$order_master_row->total_order_quantity;
											//$pr_pos_complete_flag=$order_master_row->pr_pos_complete_flag;
										}

										foreach ($so_result as $so_row) {
											$spec_id=$so_row->spec_id;
											$spec_version_no=$so_row->spec_version_no;
											$ad_id=$so_row->ad_id;
											$version_no=$so_row->version_no;
											$so_quantity=$so_row->total_order_quantity;
											$pr_pos_complete_flag=$so_row->pr_pos_complete_flag;
											

										}

										$unit_rate='';
										if($mrow->for_export=='1'){

											$unit_rate_in_rupees=$drow->calc_sell_price*$this->common_model->read_number($exchange_rate,$this->session->userdata['logged_in']['company_id']);
											$net_amount_in_rupees=$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*($unit_rate_in_rupees);
											$total_tax_in_rupees=$this->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
											//$gross_amount_in_rupees=$drow->calc_sell_price*$exchange_rate;

										}else{

											$unit_rate_in_rupees=$this->common_model->read_number($drow->selling_price,$this->session->userdata['logged_in']['company_id']);
											$net_amount_in_rupees=$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$unit_rate_in_rupees;								
											$total_tax_in_rupees=$this->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']);
											//$gross_amount_in_rupees=$drow->calc_sell_price*$exchange_rate;
										}

										$master_array= array('article_no' => $drow->article_no,
		                                                'sales_ord_no'=>$drow->ref_ord_no);
		                          
		                          		$data1=array_filter($master_array);                      
		                          		$data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
		                          	
				                        $address_master_result=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$mrow->customer_no);

									foreach ($address_master_result as $address_master_row) {

										$total_order_quantity=$this->common_model->read_number($so_quantity,$this->session->userdata['logged_in']['company_id']);									
										//Factory Tolerance-------	
										$factory_tolerance=30;
										$factory_tolerance_qty=($total_order_quantity*$factory_tolerance)/100;
										$minus_factory_dispatch_qty=$total_order_quantity-$factory_tolerance_qty;

										//Customer Tolerance-------		
										//$customer_tolerance=10;
										$customer_tolerance=0;
										$customer_tolerance=($address_master_row->dispatch_tolerance!=''?$address_master_row->dispatch_tolerance:0);

										if($customer_tolerance!=0){
											$tolerance_qty=($total_order_quantity*$customer_tolerance)/100;
											$plus_tolerance_qty=$total_order_quantity+$tolerance_qty;
											$minus_tolerance_qty=$total_order_quantity-$tolerance_qty;
										}
										else{
											
											$tolerance_qty=0;
											$plus_tolerance_qty=$total_order_quantity+$tolerance_qty;
											$minus_tolerance_qty=$total_order_quantity-$tolerance_qty;
											
										}
									}


									// Conditions-----------------
							$total_arid_qty=0;
							$supplyqty=0;
							$cancel_qty=0;
							$search_arr=array('ref_ord_no'=>$drow->ref_ord_no,
											  'article_no'=>$drow->article_no);
							
							$ar_invoice_details_result=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$search_arr);

							foreach ($ar_invoice_details_result as $ar_invoice_details_row) {
								$total_arid_qty+=$ar_invoice_details_row->arid_qty;
							}

							$supplyqty=$this->common_model->read_number($total_arid_qty,$this->session->userdata['logged_in']['company_id']);
							$flag=0;
							if($trans_closed==1){
								$flag=1;
								if($supplyqty==0)
								{	$status="Cancel Order";

									$cancel_qty=$total_order_quantity;
								}else if($supplyqty<$minus_factory_dispatch_qty){																
									$status="Manual Closed Order Cancelled";
									$cancel_qty=number_format($total_order_quantity- $supplyqty,2,'.',',');
									//$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
								}
								else if($supplyqty<$minus_tolerance_qty && $supplyqty>$minus_factory_dispatch_qty){																
									$status="Manual Closed Below Tolerance";
									$cancel_qty=number_format($total_order_quantity - $supplyqty,2,'.',',');
									$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
								}
								elseif($supplyqty>=$minus_tolerance_qty && $supplyqty<$total_order_quantity){
									$status="Short Closed";
									//$cancel_qty=number_format(get_value($row_order_details['total_order_quantity'])- $supplyqty,2,'.',',');
									//$status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
								}
								else{
									
									$status="Completed";
								}
								
							}else{								
								
								if($total_order_quantity<=$supplyqty && $supplyqty<>0){
									$status="Completed";
									$flag=1;

									//$status="Completed (INV)";
								}
								elseif($total_order_quantity>$supplyqty && $supplyqty<>0){
									$status="Partial Dispatch";
									//$status="Partially Completed (INV)";
									//$status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
									$flag=0;

								}
								else{
									$flag=0;
									$status="Pending";
								}
								
							}
							
							echo "<tr ".($flag==1 ? "style='background-color:#c2fbc2'" : "").">
									<td><div class='ui checkbox'>
											<input type='checkbox' name='costsheet_id[]' value='$mrow->ar_invoice_no/$drow->ref_ord_no/$drow->article_no/$status/$flag'><label>".$n++."</label></div></td>
											<td>".$this->common_model->view_date($mrow->invoice_date,$this->session->userdata['logged_in']['company_id'])."</td>
											<td><a href='".base_url('index.php/costsheet/view/'.$mrow->ar_invoice_no.'/'.$drow->ref_ord_no.'/'.$drow->article_no)."' target='_blank'>".$mrow->ar_invoice_no."</a></td>
											<td>".$mrow->name1."</td>
											<td><a href=".base_url('index.php/sales_order_book/view/'.$drow->ref_ord_no)." target='_blank'>".$drow->ref_ord_no."</a></td>
											<td>".$status."</td>
											<td>".$drow->sleeve_dia."</td>
											<td>".$drow->sleeve_length	."</td>
											<td>".$drow->print_type."</td>
											<td>".$drow->article_no."</td>
											<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
											<td>".money_format('%!.0n',$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']))."</td>
											<td>".$unit_rate_in_rupees."</td>
											<td>".number_format($net_amount_in_rupees)."</td>
											<td>";

											$total_extrusion_cost=0;
									        $extrusion_cost=0;
									        $total_extrusion_quantity=0;
									        $extrusion_quantity=0;
									        $master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
									        $data1=array_filter($master_array);
									        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
									        foreach($data2['job_card'] as $job_card_row){
									        	if($drow->order_flag==1){
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

									            $extrusion_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

									            $extrusion_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

									           
									                $total_extrusion_cost+=$extrusion_cost;
									                $total_extrusion_quantity+=$extrusion_quantity;
									                
									            endforeach;
									            }else{
									                    //echo "<tr><td colspan='8'>NO EXTRUSION FOR THIS JOB</td></tr>";
									                }
									            }
									            echo money_format('%!.0n',$total_extrusion_cost);
											echo "</td><td>";
											$total_purging_cost=0;
									        $purging_cost=0;
									        $total_purging_quantity=0;
									        $purging_quantity=0;
									        $master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
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

									            $purging_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

									            $purging_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

									           
									                $total_purging_cost+=$purging_cost;
									                $total_purging_quantity+=$purging_quantity;
									                
									            endforeach;
									            }else{
									                //echo "<tr><td colspan='8'>NO PURGING FOR THIS JOB</td></tr>";
									            }
									        }
									        echo money_format('%!.0n',$total_purging_cost);
											echo "</td><td>";

											$total_heading_cost=0;
					        $heading_cost=0;
					        $total_heading_quantity=0;
					        $heading_quantity=0;
					        $master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
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

					            $heading_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

					            $heading_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

					                $total_heading_cost+=$heading_cost;
					                $total_heading_quantity+=$heading_quantity;
					                
					            endforeach;
					        }else{
					                //echo "<tr><td colspan='8'>NO HEADING FOR THIS JOB</td></tr>";
					            }
					        }
					        	echo money_format('%!.0n',$total_heading_cost);

								echo "</td><td>";

							$total_printing_cost=0;
					        $printing_cost=0;
					        $total_printing_quantity=0;
					        $printing_quantity=0;
					        $master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
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

					                    $ar_printing_cost=($this->common_model->read_number($result_printing_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_printing_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

					                    $ar_printing_quantity=($this->common_model->read_number($result_printing_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
					                }

					                $m_printing_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

					                $m_printing_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

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

					        echo money_format('%!.0n',$total_printing_cost);
								echo "</td>
								<td>";
								$total_digital_ink_value=0;
								$query=$this->db->query("SELECT * from digital_ink_price_master where ink_id='5' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");

								//echo $this->db->last_query();
								$result_digital_ink_pc=0;
								$result_digital_ink_rate=0;
								$result_digital_ink_pc_value=$query->result();
								foreach($result_digital_ink_pc_value as $result_digital_ink_pc_value_row){
										$result_digital_ink_pc=$result_digital_ink_pc_value_row->other_charges_pc;
										$result_digital_ink_rate=$result_digital_ink_pc_value_row->rate_of_exchange;
								}

								if($result_digital_ink_pc<>0){
									$query_digi=$this->db->query("SELECT * FROM `springtube_printing_jobsetup_master` WHERE `order_no`='$drow->ref_ord_no' AND article_no='$drow->article_no'");

									$digital_ink_value=0;
									$digital_ink_valuee=0;
									$digital_ink_valueee=0;
									$result_digital_ink_value=$query_digi->result();
									foreach($result_digital_ink_value as $result_digital_ink_value_row){
										$digital_ink_valuee=((($result_digital_ink_value_row->digital_cost_in_euro/2000)*$result_digital_ink_rate)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']));
										$digital_ink_valueee=($digital_ink_valuee/100)*$result_digital_ink_pc;
										$digital_ink_value=$digital_ink_valuee+$digital_ink_valueee;
										$total_digital_ink_value+=$digital_ink_value;
									}

								}

								echo round($total_digital_ink_value,2);

								echo "</td>
								<td>";
								$total_consumable=0;
							if($drow->order_flag==1){
			                $decoseam_consumable=0;
			                $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='6' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
			                $result_decoseam_consumable_value=$query->result();
				            if($result_decoseam_consumable_value==TRUE){
				            foreach($result_decoseam_consumable_value as $result_decoseam_consumable_value_row){
				                $decoseam_consumable=$result_decoseam_consumable_value_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
				                    $total_consumable+=$decoseam_consumable;
				                }
				                }else{
				                   // echo "<tr><td colspan='8'>OTHER DECOSEAM CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
				                }



				            $flexo_plates=0;
                            $total_flexo_plate_quantity=0;

                            $data_springtube_plates=array('order_no'=>$drow->ref_ord_no,'article_no'=>$drow->article_no,'archive'=>0);
                            $springtube_daily_plates_master_result=$this->common_model->select_active_records_where('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],$data_springtube_plates);
                            foreach ($springtube_daily_plates_master_result as $key => $springtube_daily_plates_master_row) {

                                $flexo_plates+=$springtube_daily_plates_master_row->total_plates;                                
                            }

                            $total_flexo_plate_quantity=($flexo_plates)*($this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch);

                            if($total_flexo_plate_quantity!=0){

                                $query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='8' OR lacquer_type_id='6' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");

                                $result_flexo_value=$query->result();
                                if($result_flexo_value==TRUE){
                                    foreach($result_flexo_value as $result_flexo_value_row){
                                       $flexo_plate_rate=$result_flexo_value_row->consumption_unit_rate;
                                    }

                                    $flexo_plates_value=$total_flexo_plate_quantity*$flexo_plate_rate;
                                    $flexo_plates_cost_per_tube=$flexo_plates_value/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                                    $total_consumable+=$flexo_plates_value;
                                    
                                }else{
                                //echo "Please set the Flexo Plate Price in Master'";
                                	}
                            	}
                            }

				            $hygenic_consumable=0;
				            $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='2' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
				            $result_hygenic_consumable_value=$query->result();
				            if($result_hygenic_consumable_value==TRUE){
				            foreach($result_hygenic_consumable_value as $result_hygenic_consumable_value_row){
				                $hygenic_consumable=$result_hygenic_consumable_value_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
				                    $total_consumable+=$hygenic_consumable;
				                }
				                }else{
				                    //echo "<tr><td colspan='8'>OTHER HYGENIC CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
				                }

				            $other_consumable=0;
			                $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='1' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
			                $result_other_consumable_value=$query->result();
			                if($result_other_consumable_value==TRUE){
			                foreach($result_other_consumable_value as $result_other_consumable_value_row){
			                    $other_consumable=$result_other_consumable_value_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
			                    $total_consumable+=$other_consumable;
			                    }
			                }else{
			                    //echo "<tr><td colspan='8'>OTHER  CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
			                }

			                $data['lacquer_types_master']=$this->costsheet_model->select_one_active_record('lacquer_types_master',$this->session->userdata['logged_in']['company_id'],'lacquer_type',$drow->print_type);

			                    $m=0;
			                    foreach($data['lacquer_types_master'] as $lacquer_types_row){
			                        $lacquer_type_id=$lacquer_types_row->lacquer_type_id;
			                        $lacquer_array[$m] = $lacquer_type_id;
			                        $m++;

			                    }

			                $query=$this->db->query("SELECT * from uv_consumption_master where lacquer_type_id='$lacquer_type_id' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
			                    $result_uv_lamp=$query->result();
			                    $uv_lamp_cost=0;
			                    if($result_uv_lamp==TRUE){
			                    foreach($result_uv_lamp as $result_uv_lamp_row){
			                        $uv_lamp_cost=$result_uv_lamp_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
			                            $total_consumable+=$uv_lamp_cost;
			                        }
			                        }else{
			                            //echo "<tr><td colspan='8'>UV MASTER IS NOT ENTERED</td></tr>";
			                    }
				            echo money_format('%!.0n', $total_consumable);
								echo "</td><td>";


							 $total_labeling_cost=0;
		        $labeling_cost=0;
		        $total_labeling_quantity=0;
		        $labeling_quantity=0;
		        $master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
		        $data1=array_filter($master_array);
		        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
		        foreach($data2['job_card'] as $job_card_row){
		            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'5',
		                );
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
		                //echo $job_card_row->demand_qty;

		            $labeling_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
		            if($labeling_cost==0){
		                $query=$this->db->query("SELECT * from reserved_quantity_manu where manu_order_no='$job_card_row->manu_order_no' and article_no='$job_card_row->article_no' ");
		                $result_label_value=$query->result();
		                foreach($result_label_value as $result_label_value_row){

		                    $labeling_cost=($this->common_model->read_number($result_label_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_label_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
		                }
		            }

		            $labeling_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

		            if($labeling_quantity==0){
		                $query=$this->db->query("SELECT * from reserved_quantity_manu where manu_order_no='$job_card_row->manu_order_no' and article_no='$job_card_row->article_no' ");
		                $result_label_value=$query->result();
		                foreach($result_label_value as $result_label_value_row){

		                    $labeling_quantity=($this->common_model->read_number($result_label_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
		                }
		            }

		            
		                $total_labeling_cost+=$labeling_cost;
		                $total_labeling_quantity+=$labeling_quantity;
		                
		            endforeach;
		            }else{
		                //echo "<tr><td colspan='6'>NO LABELING FOR THIS JOB</td></tr>";
		            }
        		}

        		echo money_format('%!.0n', $total_labeling_cost);

				echo "</td><td>";

		$total_foiling_cost=0;
        $foiling_cost=0;
        $total_foiling_quantity=0;
        $foiling_quantity=0;
        $master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
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
            $foiling_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $foiling_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

          
                $total_foiling_cost+=$foiling_cost;
                $total_foiling_quantity+=$foiling_quantity;
                
            endforeach;
            }else{
                //echo "<tr><td colspan='6'>NO FOILING FOR THIS JOB</td></tr>";
            }
        }

        echo money_format('%!.0n', $total_foiling_cost);

				echo "</td><td>";
		$total_shoulderfoil_cost=0;
            $total_shoulderfoil_quantity=0;
            $shouldefoil_quantity=0;
            $shouldefoil_cost=0;
            $master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
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

                $shouldefoil_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                $shouldefoil_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

            
                $total_shoulderfoil_cost+=$shouldefoil_cost;
                $total_shoulderfoil_quantity+=$shouldefoil_quantity;
               
            endforeach;
            }else{
                //echo "<tr><td colspan='6'>NO SHOULDER FOILING FOR THIS JOB</td></tr>";
            	}
        	}

        	echo money_format('%!.0n', $total_shoulderfoil_cost);

			echo "</td><td>";


			$order_master_data=array('order_no'=>$drow->ref_ord_no,'article_no'=>$drow->article_no);
			$data['order_details_data']=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$order_master_data);

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

			$total_capping_cost=0;
            $capping_cost=0;
            $total_capping_quantity=0;
            $capping_quantity=0;
            $master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
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

		                    $ar_capping_cost=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

		                    $ar_capping_quantity=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

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

            echo money_format('%!.0n', $total_capping_cost);

			echo "</td><td>";

			$total_capping_s_cost=0;
            $capping_s_cost=0;
            $total_capping_s_quantity=0;
            $capping_s_quantity=0;
            $master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            if($data2['job_card']!=FALSE){
            foreach ($data2['job_card'] as $job_card_row){
                $job_card_no=$job_card_row->mp_pos_no;
           

            $query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price,article_no from reserved_quantity_manu where manu_order_no='$job_card_no' and article_no like '%RM-CAS-%'");

             $this->db->last_query();

                $result_capping_s_value=$query->result();
                if($result_capping_s_value==TRUE){
                foreach($result_capping_s_value as $result_capping_value_row){
                     $cap_article=$this->common_model->get_article_name($result_capping_value_row->article_no,$this->session->userdata['logged_in']['company_id']);

                    $ar_capping_s_cost=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                    $ar_capping_s_quantity=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

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

    echo money_format('%!.0n', $total_capping_s_cost);

			echo "</td><td>";


			$total_packing_cost=0;
            $packing_quantity=0;
            $packing_cost=0;
            $total_packing_quantity=0;
            $master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
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

            $packing_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $packing_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

            
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
                $query=$this->db->query("SELECT * from packing_material_consumption_master where apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
            }else{
                $query=$this->db->query("SELECT * from packing_material_consumption_master where apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1 and for_export<>1");
            }
            

            $result_other_packing=$query->result();
            //echo $this->db->last_query();
            if($result_other_packing==TRUE){
            foreach($result_other_packing as $result_other_packing_row){
                $other_packing=$result_other_packing_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

                
                    $total_other_packing_cost+=$other_packing;
                }
                }else{
                    //echo "<tr><td colspan='8'>PACKING MASTER IS NOT ENTERED</td></tr>";
                }
            $total_total_packing_cost=0;
            $total_total_packing_cost=$total_other_packing_cost+$total_packing_cost;

            echo money_format('%!.0n', $total_total_packing_cost);

			echo "</td><td>";

			$total_stores_spares_cost=0;
            $query=$this->db->query("SELECT * from stores_and_spares_consumption_master where apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
            $result_stores_spares=$query->result();
            if($result_stores_spares==TRUE){
            foreach($result_stores_spares as $stores_spares_row){
                $stores_spares_cost=$stores_spares_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
                $total_stores_spares_cost+=$stores_spares_cost;
                }
                }else{
                    //echo "<tr><td colspan='8'>STORES AND SPARES MASTER IS NOT ENTERED</td></tr>";
                }
            echo money_format('%!.0n', $total_stores_spares_cost);

			echo "</td><td>";

		$total_additional_cost=0;
        $additional_cost=0;
        $total_additional_quantity=0;
        $additional_quantity=0;
        $master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
        $data1=array_filter($master_array);
        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
        foreach($data2['job_card'] as $job_card_row){
            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','from_job_card'=>'0','work_proc_no!='=>'5','work_proc_no!='=>'11');


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

            $m_additional_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $m_additional_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);



            $query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price from reserved_quantity_manu where manu_order_no='$job_card_row->manu_order_no' and article_no='$job_card_row->article_no' and type_flag='4' and article_no NOT LIKE '%LBL-'");

            $this->db->last_query();

                $result_additional_value=$query->result();
                foreach($result_additional_value as $result_additional_value_row){

                    $ar_additional_cost=($this->common_model->read_number($result_additional_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_additional_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                   $ar_additional_quantity=($this->common_model->read_number($result_additional_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);

                   
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

           echo money_format('%!.0n', $total_additional_cost);


			echo "</td>";

			echo "<td>";

			$total_freight=0;
			$total_freight_amount=0;
			$query=$this->db->query("SELECT * from freight_master where sleeve_id='$dia' and customer_no='$mrow->customer_no' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
			$result_freight_value=$query->result();

			if($result_freight_value==TRUE){
				foreach($result_freight_value as $result_freight_value_row){
					$total_freight=$result_freight_value_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
					$total_freight_amount+=$total_freight;
												                
					}
				}else{

				} 
				echo $total_freight_amount;
			
			echo "</td>";


			echo "<td>";

				$total_final_cost=$total_extrusion_cost+$total_purging_cost+$total_heading_cost+$total_printing_cost+$total_consumable+$total_labeling_cost+$total_foiling_cost+$total_shoulderfoil_cost+$total_capping_cost+$total_capping_s_cost+$total_total_packing_cost+$total_stores_spares_cost+$total_additional_cost+$total_freight_amount;

				echo money_format('%!.0n',$total_final_cost);

			echo "</td></tr>";



									}

								 }

							}
						}
			?>
					</tbody>	
					</table>
					<table id="header-fixed"></table>
					<button class="ui green button" type ="submit" name="submit">Compare</button>
					<br/>
					<br/>
				</form>
			</div>
					</div>
				</div>
				
				
				
				
				
			