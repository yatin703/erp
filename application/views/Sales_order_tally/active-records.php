<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		
	    $("table tr").click(function(e){
	    	$("table tr").removeClass('on-hower');	
	        $(this).addClass('on-hower');
	    }); 
	});
</script>

<style>
	.on-hower{
        background-color:#e4e4e4;
    }
	tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Sr No</th>
					<th>Id</th>
					<th>Order Date</th>
					<th>Order No</th>
					<th>Sales Ledger</th>
					<th>Bill to</th>
					<th>Ship to</th>
					<th>PO No</th>
					<th>Article No</th>
					<th>Order Qty</th>
					<th>Unit Rate</th>
					<th>Net Amount</th>
					<th>Currency</th>
					<th>Currency Rate</th>
					<th>Status</th>
					<th>Remark</th>
					<th>Transaction Date</th>
					<th>Action</th>



				</tr>
				<?php if($tally_sales_order_master==FALSE){
					echo "<tr><td colspan='25'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));
							foreach($tally_sales_order_master as $row){
								echo "<tr>
									<td>".++$i."</td>
									<td>".$row->id."</td>
									<td>".$row->order_date."</td>
									<td>".$row->order_no."</td>
									<td>".$row->sales_ledger."</td>
									<td>".$row->bill_to."</td>
									<td>".$row->ship_to."</td>
									<td>".$row->po_no."</td>
									<td>".$row->part_no."</td>
									<td>".$row->order_quantity."</td>
									<td>".$row->unit_rate."</td>
									<td>".$row->net_amount."</td>							 
									<td>".$row->currency."</td>
									<td>".$row->rate_of_exchange."</td>
									<td>".$row->status."</td>
									<td>".$row->remarks."</td>
									<td>".$row->transaction_date."</td>	
									<td><a href='".base_url('index.php/'.$this->router->fetch_class()."/modify/".$row->id.'')."' target='_blank'><i class='edit icon'></i></a></td>


								</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>