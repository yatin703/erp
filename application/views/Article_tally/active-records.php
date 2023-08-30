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
			<table class="ui very compact celled table" style="font-size:10px;">
				<thead>
				<tr>
					<th>Sr No</th>
					<th>Id</th>
					<th>Name</th>
					<th>New Name</th>
					<th>Article No</th>
					<th>Description</th>
					<th>Under Group</th>
					<th>Units</th>
					<th>Maintain in Batches</th>
					<th>Date Of Manufacturing</th>
					<th>Expiry Date</th>
					<th>GST Applicable</th>
					<th>HSN/SAC</th>
					<th>HSN Description</th>
					<th>Calculation Type</th>
					<th>Taxability</th>
					<th>IGST</th>
					<th>CGST</th>
					<th>UTGST</th>
					<th>CESS</th>
					<th>Type Of Supply</th>
					<th>Status</th>
					<th>Remark</th>
					<th>Transaction Date</th>
					<th>Tax Apply Date</th>
					<th>Action</th>


				</tr>
				</thead>
				<tbody>
				<?php if($tally_stock_items_master==FALSE){
					echo "<tr><td colspan='25'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));
							foreach($tally_stock_items_master as $row){
								echo "<tr>
									<td>".++$i."</td>
									<td>".$row->id."</td>
									<td>".$row->name."</td>
									<td>".$row->new_name."</td>
									<td>".$row->part_no."</td>
									<td>".$row->description."</td>
									<td>".$row->under_group."</td>
									<td>".$row->units."</td>
									<td>".$row->maintain_in_batches."</td>
									<td>".$row->date_of_manufacturing."</td>
									<td>".$row->expiry_date."</td>
									<td>".$row->gst_applicable."</td>
									<td>".$row->hsn_no."</td>
									<td>".$row->hsn_description."</td>
									<td>".$row->calculation_type."</td>
									<td>".$row->taxability."</td>
									<td>".$row->igst."</td>
									<td>".$row->cgst."</td>
									<td>".$row->utgst."</td>
									<td>".$row->cess."</td>
									<td>".$row->type_of_supply."</td>							
									<td>".$row->status."</td>
									<td>".$row->remarks."</td>
									<td>".$row->transaction_date."</td>
									<td>".$row->appl_date."</td>
									<td><a href='".base_url('index.php/'.$this->router->fetch_class()."/modify/".$row->id.'')."' target='_blank'><i class='edit icon'></i></a></td>							

							</tr>";
							}
						}?>
						</tbody>	
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>