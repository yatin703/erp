<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	function chkall(source) {
			checkboxes = document.getElementsByName('id[]');
			for(var i=0, n=checkboxes.length;i<n;i++) {
				checkboxes[i].checked = source.checked;
			}
	}
	

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/clear_status');?>" method="POST" target="_blank" >
<div class="record_form_design">
	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
<h3>Active Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h3>
	<div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">

			<table class="ui very compact celled table" style="font-size:10px;">
				<thead>
				<tr>
					<th>Sr No</th>
					<th>DATE</th>
					<!-- <th>Month</th> -->
					<th>Max Rate</th>
					
					

				</tr>
			</thead>
			<tbody>
				<?php if($tally_issued_material_receipt==FALSE){
					echo "<tr><td colspan='10'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));

							$order_type='';
							$process_name='';
							$main_group='';
							$sub_group='';
							$second_sub_group='';
							$sum_qty=0;
							$sum_amount=0;
							$uom='';
							// echo'<pre>';
							// print_r($tally_issued_material_receipt);
							// echo'</pre>';
							//echo $tally_issued_material_receipt[0]['year'];
							//echo$tally_issued_material_receipt['year'];
							 
							foreach($tally_issued_material_receipt as $row){

								echo "<tr>
									<td>".++$i." 
									<td>".$row['year']."-".$row['month']."</td>
									<!--<td>".$row['month']."</td>-->
									<td>".$row['avg_rate']."</td>
									";
									 							

							echo"</tr>";
							}

							//print_r($year_array);

							 
						}?>



					</tbody>							
						</table>

						<canvas id="myChart" style="width:100%;max-width:600px"></canvas>					 
						 
					</div>
				</div>
			</form>
			 
