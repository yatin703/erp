 
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design" style="white-space: nowrap;overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Issue Date</th>
					<th>Process</th>
					<th>Doc.No</th>	
					<th>Jobcard No</th>
					<th>Main Group</th>
					<th>Sub Group</th>
					<th>Article Name</th>
					<th>Article No.</th>					
					<th>Qty</th>
					<th>Unit</th>
					<th>Rate</th>
					<th>Amount</th>
					<th>Status</th>	
									
					<!-- <th>Action</th> -->
				</tr>
				<?php 

				$sum_qty=0;
				$sum_amount=0;

				if($reserved_quantity_manu==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
					$n=1;
					foreach($reserved_quantity_manu as $row){

						$uom='';
						$main_group='';
						$sub_group='';
						$result_article=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$row->article_no);
						foreach ($result_article as $key => $article_row) {
							$uom=$article_row->uom;
							$main_group=$article_row->main_group;
							$sub_group=$article_row->sub_group;
						}

						$search=array('jobcard_no'=>$row->manu_order_no,
                                          'part_no'=>$row->article_no,
                                          'qty'=>$this->common_model->read_number($row->qty,$this->session->userdata['logged_in']['company_id'])
                                      );
                        $data['tally_material_issue_master']=$this->jobcard_issue_tally_model->active_record_search('tally_material_issue_master',$search,'','');
                            //echo $this->db->last_query();
                            //print_r($data['tally_material_issue_master_extr']);
                        $error='';
                        foreach ($data['tally_material_issue_master'] as $key => $tally_row) {
                            $error= $tally_row->remarks;    
                        }							
						echo "<tr>
							<td>".$n++."</td>
							<td>".$this->common_model->view_date($row->date_required,$this->session->userdata['logged_in']['company_id'])."</td>
							<td>".($row->grn!=''?($row->grn==1?'Spring Tube':'Coex'):'')."</td>			
							<td>$row->document_no</td>
							<td>$row->manu_order_no</td>
							<td>".$main_group."</td>
							<td>".$sub_group."</td>
							<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
							<td>$row->article_no</td>
														
							<td style='text-align:right'>".number_format($this->common_model->read_number($row->qty,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
							<td>".$uom."</td>
							<td style='text-align:right'>&#x20B9; ".number_format($this->common_model->read_number($row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
							<td style='text-align:right'>&#x20B9;".number_format($this->common_model->read_number($row->qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
							<td>".($row->calculated_purchase_price>0?"<i class='check green circle icon'></i>":($error!=""?"<i class='x red circle icon'></i>"."(<i>".$error."</i>)" :""))."</td>
							
							</tr>";

							$sum_qty+=$this->common_model->read_number($row->qty,$this->session->userdata['logged_in']['company_id']);
							$sum_amount+=$this->common_model->read_number($row->qty,$this->session->userdata['logged_in']['company_id'])* $this->common_model->read_number($row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

						}

						echo"<tr>
							<td colspan='9'>TOTAL</td>
							<td style='text-align:right;font-weight:bold'>".number_format($sum_qty,2,'.',',')."</td>
							<td></td>
							<td></td>
							<td style='text-align:right;font-weight:bold'>&#x20B9;".number_format($sum_amount,2,'.',',')."</td>
						</tr>";



					}?>


								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>