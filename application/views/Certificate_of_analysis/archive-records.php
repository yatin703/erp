
<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Invoice No.</th>
					<th>Customer Name</th>
					<th>Product Name</th>
					<th>S.O.No.</th>
					<th>AQL</th>
					<th>Total QTY</th>
					<th>Sample Size</th>
					<th>Action</th>
				</tr>
				<?php if($certificate_of_analysis==FALSE){
					echo "<tr><td colspan='11'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($certificate_of_analysis as $row){
								echo "<tr>
									<td>".$i."</td>
									<td>".$row->inspection_date."</td>
									<td>".$row->certificate_no."</td>
									<td>".$row->customer_name."</td>
									<td>".$row->so_no."</td>
									<td>".$row->quality."</td>
									<td>".$row->total_qty."</td>
									<td>".$row->sample_size."</td>
									<td>".$row->sample_size."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

									echo ($formrights_row->dearchive=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->coa_id).'" title="Dearchive"><i class="edit icon"></i></a> ' : '');
								    }

									echo"</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>