<style>
	.tableFixHead {
		overflow-y: auto;
		height: 500px;
		opacity: 1;
	}

	.tableFixHead thead th {
		position: sticky;
		top: 0;
		opacity: 1;
	}
</style>
<div class="record_form_design">
	<h4>RFD <?php echo ($this->input->post('from_date') != '' ? 'From ' . $this->input->post('from_date') . ' To ' . $this->input->post('to_date') : '') ?></h4>
	<div class="record_inner_design" style="white-space: nowrap;">
		<div class="tableFixHead">
			<table class="ui green sortable selectable celled table" style="font-size:10px;">
				<thead>
					<tr>

						<th>Sr no.</th>
						<th>Action</th>
						<th><i class="expand icon"></i></th>
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
						<th>Dispatched Qty</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php


					$sum_bm_wip_qty = 0;
					$sum_rfd_qty = 0;
					$sum_release_qty = 0;
					// $sum_total_bodymaking_rejected=0;
					// $sum_total_printing_rejected=0;
					// $sum_total_rejected=0;

					//$sum_reels=0;
					//$sum_reels_release=0;

					if ($springtube_rfd_master == FALSE) {
						echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
					} else {
						$i = ($this->uri->segment(3) == "" ? 1 : $this->uri->segment(3) + 1);

						$reel_length = $this->config->item('springtube_reel_length');

						//$sum_total_meters_produced=0;

						$count = 1;
						foreach ($springtube_rfd_master as $master_row) {

							$customer = '';
							$order_date = '';
							$ad_id = '';
							$version_no = '';
							$body_making_type = '';
							$print_type_artwork = '';
							$bom_no = '';
							$bom_id = '';
							$bom_version_no = '';
							$total_order_quantity = 0;

							$jobcard_qty = 0;


							//Jobcard details  //production_master----
							$production_master_result = $this->common_model->select_one_active_record('production_master', $this->session->userdata['logged_in']['company_id'], 'mp_pos_no', $master_row->jobcard_no);

							foreach ($production_master_result as $production_master_row) {
								$order_no = $production_master_row->sales_ord_no;
								$article_no = $production_master_row->article_no;
								$jobcard_qty = $this->common_model->read_number($production_master_row->actual_qty_manufactured, $this->session->userdata['logged_in']['company_id']);
							}
							//Order details-----------
							$order_master_result = $this->sales_order_book_model->select_one_active_record('order_master', $this->session->userdata['logged_in']['company_id'], 'order_master.order_no', $order_no);

							$hold_flag = 0;
							foreach ($order_master_result as $order_master_row) {
								$customer = $order_master_row->customer_no;
								$order_date = $order_master_row->order_date;
								$hold_flag = $order_master_row->hold_flag;
							}

							$data_order_details = array(
								'order_no' => $order_no,
								'article_no' => $article_no
							);

							$order_details_result = $this->common_model->select_active_records_where('order_details', $this->session->userdata['logged_in']['company_id'], $data_order_details);
							foreach ($order_details_result as $order_details_row) {
								$bom_no = $order_details_row->spec_id;
								$bom_version_no = $order_details_row->spec_version_no;
							}
							// BOM Details---------
							$data = array('bom_no' => $bom_no, 'bom_version_no' => $bom_version_no);

							$bill_of_material_result = $this->common_model->select_active_records_where('bill_of_material', $this->session->userdata['logged_in']['company_id'], $data);

							foreach ($bill_of_material_result as $bill_of_material_row) {
								$bom_id = $bill_of_material_row->bom_id;
								$film_code = $bill_of_material_row->sleeve_code;
							}

							//SLEEVE---------------------------------

							$film_spec_id = '';
							$film_spec_version = '';

							$film_code_result = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $film_code);

							foreach ($film_code_result as $film_code_row) {
								$film_spec_id = $film_code_row->spec_id;
								$film_spec_version = $film_code_row->spec_version_no;
							}

							$specs['spec_id'] = $film_spec_id;
							$specs['spec_version_no'] = $film_spec_version;

							$specs_result = $this->sales_order_book_model->select_film_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $specs);

							if ($specs_result) {

								foreach ($specs_result as $specs_row) {
									$sleeve_diameter = $specs_row->SLEEVE_DIA;
									$sleeve_length = $specs_row->SLEEVE_LENGTH;
									$sleeve_mb_2 = $specs_row->FILM_MASTER_BATCH_2;
									$sleeve_mb_6 = $specs_row->FILM_MASTER_BATCH_6;
								}
							}
					?>

							<script>
								$(document).ready(function() {
									$(".tr_<?php echo $count; ?>").hide();
									$("#id_<?php echo $count; ?>").on("click", function() {
										//alert(1);
										$(".tr_<?php echo $count; ?>").slideToggle(1000);
										$("#idd_<?php echo $count; ?>").toggleClass('plus icon');
										$("#idd_<?php echo $count; ?>").toggleClass('minus icon');
									});

								});
							</script>
					<?php
							echo "<tr id='id_" . $count . "'>
										
									<td >" . $i++ . "</td><td>";
							foreach ($formrights as $formrights_row) {
								//echo ($formrights_row->new==1 && $master_row->status!=1 ? '<input type="checkbox" name="aql_id[]" value="'.$master_row->aql_id.'">' : '');

								echo ($formrights_row->new == 1 && $master_row->status == 0 && $hold_flag <> 1 ? '<a href="' . base_url('index.php/' . $this->router->fetch_class() . '/rfd_consume/' . $order_no . '/' . $article_no) . '" title="Consume RFD"><i class="edit icon"></i></a>' : '');

								echo ($formrights_row->new == 1 && $master_row->status == 0 && $hold_flag <> 1 ? '<a href="' . base_url('index.php/' . $this->router->fetch_class() . '/rfd_qty_transfer/' . $order_no . '/' . $article_no) . '" title="TRANSFER RFD"><i class="exchange alternate icon"></i></a>' : '');

								//echo ($master_row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$master_row->rfd_id).'"><i class="trash icon archive"></i></a></div> ' : '');




							}
							echo "</td>
									<td>";
							foreach ($formrights as $formrights_row) {

								echo ($formrights_row->new == 1 && $master_row->status == 0 && $hold_flag <> 1 ? "<i id='idd_" . $count . "' class='plus icon'></i>" : '');
							}
							echo "</td>	
									<td>" . $this->common_model->view_date($master_row->rfd_date, $this->session->userdata['logged_in']['company_id']) . "</td>
									<!--<td>" . $this->common_model->get_customer_name($customer, $this->session->userdata['logged_in']['company_id']) . "</td>
									-->
									<td>" . $this->common_model->get_parent_name($article_no, $this->session->userdata['logged_in']['company_id']) . "</td>									
									<td><a href='" . base_url('index.php/sales_order_book/view/' . $order_no) . "' target='_blank'> " . $order_no . "</a></td>
									<!--<td>" . $this->common_model->view_date($order_date, $this->session->userdata['logged_in']['company_id']) . "</td>
									-->
									
									<td title='" . $this->common_model->get_article_name($article_no, $this->session->userdata['logged_in']['company_id']) . "'>" . $article_no . "</td>

									<td >" . $this->common_model->get_article_name($article_no, $this->session->userdata['logged_in']['company_id']) . "</td>

									<!--<td><a href='" . base_url('index.php/bill_of_material/view/' . $bom_id) . "' target='_blank'>" . $bom_no . "_" . $bom_version_no . "</td>

											
									<td><a href='" . base_url('index.php/spring_film_specification/view/' . $film_spec_id . '/' . $film_spec_version) . "' target='_blank'>" . $master_row->film_code . "</td>
									-->
									<td>" . $master_row->total_microns . "</td>
									<td>" . $master_row->sleeve_dia . " X " . $master_row->sleeve_length . "</td>
									<!--<td>" . $master_row->sleeve_length . "</td>
									-->

									<td>" . $this->common_model->get_article_name($master_row->second_layer_mb, $this->session->userdata['logged_in']['company_id']) . "</td>									
									<td>" . $this->common_model->get_article_name($master_row->sixth_layer_mb, $this->session->userdata['logged_in']['company_id']) . "</td>
									
									<!--<td><a href='" . base_url('index.php/sales_order_item_parameterwise/view_new/' . $master_row->jobcard_no . '/' . $bom_no . '/' . $bom_version_no) . "' target='_blank'>" . $master_row->jobcard_no . "
									</td>-->
									<td class='positive' style='text-align:right;'><b>" . number_format($master_row->rfd_qty, 0, '.', ',') . "</b>
									</td>
									
									<td class='positive' style='text-align:right;'><b>" . ($master_row->release_qty != '' ? number_format($master_row->release_qty, 0, '.', ',') . "</b>" : '') . "
									</td>
									<td>" . ($master_row->status == 1 ? "<i style='color:#06c806;'class='check circle icon'></i>" : "") . "
									</td></tr>";



							//$sum_bm_wip_qty+=$master_row->bm_wip_qty;
							if ($master_row->status == 0) {
								$sum_rfd_qty += $master_row->rfd_qty;
							}

							$data_search = array('order_no' => $order_no);

							$data['springtube_rfd_master'] = $this->springtube_rfd_model->active_record_search('springtube_rfd_master', $this->session->userdata['logged_in']['company_id'], $data_search, '', '');

							//echo $this->db->last_query();

							//echo "<br/>";

							if ($data['springtube_rfd_master'] == TRUE) {
								$sum_pending_to_go_rfd_qty = 0;
								$summ_release_qty = 0;
								echo "<tr class='tr_" . $count . "'>
											<td colspan='5'>&nbsp;</td>
											<td colspan='4'>



												<table class='ui very compact table' style='font-size:8px;'>
											<thead>
												<tr>
													<th>DATE</th>
													<th>OPENING</th>
													<th>INWARD</th>
													<th>OUTWARD</th>
													<th>CLOSING</th>
													<th><i class='exchange alternate icon'></i> QTY</th>
													<th><i class='exchange alternate icon'></i> TO </th>
												</tr>
											</thead><tbody>";
								$i = 0;
								foreach ($data['springtube_rfd_master'] as $row) {

									$opening = ($i == 0 ? '0' : $j);
									$inward = 0;
									$inward = ($row->status <> 0 ? $row->rfd_qty : 0) + ($row->resive_trns_qty <> '' ? $row->resive_trns_qty : 0);
									$outward = 0;
									$outward = ($row->release_qty != '' ? $row->release_qty : 0) + ($row->transfer_qty <> '' ? $row->transfer_qty : 0);
									$closing = $opening + $inward - $outward;

									echo "<tr>
																		<td>" . $this->common_model->view_date($row->rfd_date, $this->session->userdata['logged_in']['company_id']) . "</td>
																		<td>" . $opening . "</td>
																		<td>+" . $inward . "

																		</td>
																		<td>-" . $outward . "</td>
																		<td>" . $closing . " </td>
																		<td>" . ($row->transfer_qty <> '' ? "<span class='negative'>-" . $row->transfer_qty . "</span>" : '') . " " . ($row->resive_trns_qty <> '' ? "+" . $row->resive_trns_qty : '') . "</td>
												<td>" . ($row->transfer_qty <> '' ? $row->transfer_so_no : '') . " " . ($row->resive_trns_qty <> '' ? $row->resive_trns_so_no : '') . "</td>

														</tr>";
									$i++;
									$j = 0;
									$j = $closing;
								}

								echo "
									<tr>
										<td colspan='2'>TOTAL</td>
										<td></td>
										<td></td>
										</tr>
									</tbody></table>


											
											</td></tr>";
							} else {
							}

							$count++;


							// $sum_total_bodymaking_rejected+=$master_row->total_rejected_bodymaking_issue;
							// $sum_total_printing_rejected+=$master_row->total_rejected_printing_issue;
							// $sum_total_rejected+=$master_row->total_rejected_qty;




						} //master Foreach

						echo "<tr><td colspan='12' style='text-align:right;'><b>TOTAL</b></td>
					<td class='positive right aligned'><b>" . number_format($sum_rfd_qty, 0, '.', ',') . "</b></td>
					<td class='positive right aligned'><b>" . number_format($sum_release_qty, 0, '.', ',') . "</b></td>

					</tr>";
					} ?>
				</tbody>
			</table>
		</div>
		<!--<div class="pagination"><?php echo $this->pagination->create_links(); ?></div>-->
	</div>
</div>
<!-- <?php if ($formrights) {
			foreach ($formrights as $formrights_row) {
				if ($formrights_row->new == '1') { ?>

					<div class="form_design">
						<div class="ui buttons">
					  		<a href="<?php echo base_url('index.php/' . $this->router->fetch_class() . ''); ?>" class="ui button">Cancel</a>
					  		<div class="or"></div>
					  		<button id="btn_close" class="ui positive button" onClick="return confirm('Are you sure?');">Consume</button>
						</div>
				  	</div>
<?php			}
			}
		}
?>

</form>	 -->