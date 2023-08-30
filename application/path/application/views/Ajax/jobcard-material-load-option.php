
<div class="middle_form_design">
		<div class="middle_form_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>SR NO</th>
					<th>RM</th>
					<th>RM Code</th>
					<th>ISSUED QTY BY STORE</th>
					<th>REMAINING QTY TO MIXED</th>
					<th>MIXING QTY</th>
					<th>BATCH NO</th>
				</tr>
				<?php if($jobcard_material_details==FALSE){

				}else{
					$total_issued_qty=0;
					$i=1;
					foreach($jobcard_material_details as $jobcard_material_details_row){

						$result=$this->coex_extrusion_rm_mixing_model->select_rm_sum_record('coex_extrusion_rm_mixing_details',$this->session->userdata['logged_in']['company_id'],$jobcard_material_details_row->manu_order_no,$jobcard_material_details_row->article_no);
						if($result==FALSE){
							$total_qty_mixed=0;
						}else{
							foreach($result as $row){
								$total_qty_mixed=$row->total_mixed;
							}
						}

						echo "<tr>
								<td><input type='hidden' name='sr_no[]' value='$i'>
								<input type='hidden' name='jobcard_no' value='".$jobcard_material_details_row->manu_order_no."'>".$i."</td>

								<td>".$this->common_model->get_article_name($jobcard_material_details_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
								<td><input type='hidden' name='article_no_$i' value='$jobcard_material_details_row->article_no'>".$jobcard_material_details_row->article_no."</td>
								<td><input type='hidden' name='issued_qty_$i' value='".$jobcard_material_details_row->demand_qty."'>".$this->common_model->read_number($jobcard_material_details_row->demand_qty,$this->session->userdata['logged_in']['company_id'])." Kg</td>
								<td>".$this->common_model->read_number($jobcard_material_details_row->demand_qty-$total_qty_mixed,$this->session->userdata['logged_in']['company_id'])." Kg</td>
								<td><input type='text' name='mixing_qty_$i' class='mixing_qty' value='".set_value('mixing_qty_$i')."'> Kg</td>
								<td><input type='text' name='batch_no_$i' value='".set_value('batch_no_$i')."'></td>
							 </tr>";
							 $total_issued_qty+=$jobcard_material_details_row->demand_qty;
						$i++;
					}
				}?>
				<tr>
					<td colspan='3'>TOTAL</td><td><?php echo $this->common_model->read_number($total_issued_qty,$this->session->userdata['logged_in']['company_id']);?> Kg</td><td><span class='total_mixing_qty'></span><td></td></td><td></td>
				</tr>
			</table>
		</div>
	</div>