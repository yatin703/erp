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
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/clear_status');?>" method="POST" target="_blank" >
<div class="record_form_design">
	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
<h3>Active Records</h3>
	<div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">

			<table class="record_table_design_without_fixed">
				<tr>
					<th>Sr No</th>
					<th>Id</th>
					<th>Issue Date</th>
					<th>Jobcard No</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Qty</th>
					<th>Avg Rate</th>
					<th>Status</th>
					<th>Remark</th>
					<th>Transaction Date</th>
					<th><input type="checkbox" name="allchk[]" onClick="chkall(this)"> CHECK ALL</th>



				</tr>
				<?php if($tally_issued_material_receipt==FALSE){
					echo "<tr><td colspan='10'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));
							foreach($tally_issued_material_receipt as $row){
								echo "<tr>
									<td>".++$i;
									// foreach($formrights as $formrights_row){ 												
									// 			echo ($formrights_row->modify==1 ? '<input type="checkbox" name="id[]" value="'.$row->id.'"> ' : '');
												
									// }
									//echo'<input type="checkbox" name="id[]" value="'.$row->id.'">';
									echo"</td>
									<td>".$row->id."</td>
									<td>".$row->issue_date."</td>
									<td>".$row->jobcard_no."</td>
									<td>".$row->part_no."</td>
									<td>".$this->common_model->get_article_name($row->part_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->qty."</td>
									<td>".$row->avg_rate."</td>
									<td>".$row->status."</td>
									<td>".$row->remarks."</td>
									<td>".$row->transaction_date."</td>";
									echo'<td><input type="checkbox" name="id[]" value="'.$row->id.'"></td>';							

							echo"</tr>";
							}
						}?>
							
						</table>
						<div class="form_design">
										<div class="ui buttons">
									  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
									  		<div class="or"></div>
									  		<button id="btn_close" class="ui positive button">Clear Status</button>
										</div>
							  	</div>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>
			</form>