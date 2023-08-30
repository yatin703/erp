<script type='text/javascript'>	
function chkall(source) {
	checkboxes = document.getElementsByName('costsheet_id[]');
	for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	}
}
</script>
<div class="record_form_design">
<h4>Search Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?> <i>Note : Green color records states the specific order numbers dispatches has been completed and closed</i></h4>
	 <div class="record_inner_design" style="overflow: scroll;">
					<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/compare');?>" method="POST" target="_blank">

						<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
						<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
						<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
					<table class="ui very basic collapsing celled table"  style="font-size:11px;">
					<thead>
						<tr>
							<th>Sr No</th>

							<th>Customer</th>
							<th>Product No</th>
							<th>Sleeve Dia</th>
							<th>Print Type</th>
							<th>Layer</th>
							<th>Sleeve Mb</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Sale Price</th>
							<th>Net Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if($ar_invoice_master!=FALSE){
							setlocale(LC_MONETARY, 'en_IN');
							$i=1;
							foreach($ar_invoice_master as $row){

								echo "<tr>
											<td>".$i."</td>
											<td>".$this->common_model->get_parent_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									
											<td><a href='".base_url('index.php/costsheet/view_product/'.$row->article_no.'/'.$this->input->post('from_date').'/'.$this->input->post('to_date'))."' target='_blank'>".$row->article_no."</a></td>
											<td>".$row->sleeve_dia."</td>
											<td>".$row->print_type."</td>
											<td>".$row->layer_no."</td>
											<td>".$this->common_model->get_article_name($row->sleeve_mb_1,$this->session->userdata['logged_in']['company_id'])."</td>
											<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>

											<td>".money_format('%!.0n',$row->total_qty)."</td>
											<td>".round(($row->amount/$row->total_qty),2)."</td>
											<td>".money_format('%.0n',$row->amount)."</td>
											

									  </tr>";

									  $i++;
							}
						}else{
						}
							?>
					</tbody>	
					</table>
					
				</form>
					</div>
				</div>
				
				
				
				
				
			