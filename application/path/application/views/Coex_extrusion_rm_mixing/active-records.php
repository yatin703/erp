<div class="record_form_design">
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="ui very basic collapsing celled table"  style="font-size:11px;">
				<thead>
				<tr>
					<th colspan="12">RM MIXING REPORT</th>
				</tr>
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Machine</th>
					<th>Shift</th>
					<th>Customer</th>
					<th>Order No</th>
					<th>Product No</th>
					<th>Job No</th>
					<th>Total RM Mixed</th>
					<th>Prepared By</th>
					<th>Checked By</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$sum_total_rm=0;
				if($coex_extrusion_rm_mixing==FALSE){
					echo "<tr><td colspan='16'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						foreach($coex_extrusion_rm_mixing as $row){

							$order_flag='';								
							$data['order_master']=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$row->order_no);
							if($data['order_master']==FALSE){
								$order_flag='';	
							}else{
								foreach ($data['order_master'] as $order_master_row) {
									$order_flag=$order_master_row->order_flag;
								}
							}

							$data=array('order_no'=>$row->order_no,'article_no'=>$row->article_no);
							$data['spec']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$data);
							//echo $this->db->last_query();
							if($data['spec']==FALSE){
								$spec_id="";
								$version="";
							}else{
								foreach($data['spec'] as $spec_row){
									$spec_id=$spec_row->spec_id;
									$version=$spec_row->spec_version_no;
								}
							}

							$result=$this->coex_extrusion_rm_mixing_model->select_total_rm_sum_record('coex_extrusion_rm_mixing_details',$this->session->userdata['logged_in']['company_id'],$row->jobcard_no,$row->cerm_id);

							if($result==FALSE){
							$total_qty_mixed=0;
							}else{
								foreach($result as $roww){
									$total_qty_mixed=$roww->total_mixed;
									
								}
							}

							echo "<tr>
									<td>".$i."</td>
									<td>".$this->common_model->view_date($row->mixing_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->machine_name."</td>
									<td>".$row->shift_name."</td>
									<td>".$this->common_model->get_parent_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->order_no."</td>
									<td>".$row->article_no."</td>
									<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$row->jobcard_no.'/'.$spec_id.'/'.$version)."' target='_blank'>".$row->jobcard_no."</a></td>
									<td class='positive right aligned'><b>".$this->common_model->read_number($total_qty_mixed,$this->session->userdata['logged_in']['company_id'])."</b><i> Kg</i></td>
									<td>".strtoupper($row->prepared_by)."</td>
									<td>".strtoupper($row->checked_by)."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->cerm_id).'" target="_blank"><i class="print icon"></i></a> ' : '');


										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->cerm_id).'"><i class="edit icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->cerm_id).'"><i class="trash icon"></i></a> ' : '');
										
									} 
									echo "</td>

									</tr>";

									$sum_total_rm+=$total_qty_mixed;
									
							$i++;
						}
					}
					?>	
							<td colspan="8"><b>TOTAL</td>
							<td class='positive right aligned'>
								<b> <?php echo $this->common_model->read_number($sum_total_rm,$this->session->userdata['logged_in']['company_id']);?></b><i> Kg</i>
							</td>
							<td colspan="3"></td>	
						</tbody>
					</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>