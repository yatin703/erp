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

			<table class="ui very compact celled table" style="font-size:10px;">
				<thead>
				<tr>
					<th>Sr No</th>
					<th>Id</th>
					<th>Issue Date</th>
					<th>Process</th>
					<th>Jobcard No</th>
					<th>Group</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Qty</th>
					<th>Unit</th>
					<th>Avg Rate</th>
					<th>Amount</th>
					<th>Status</th>
					<th>Remark</th>
					<th>Transaction Date</th>
					<!-- <th><input type="checkbox" name="allchk[]" onClick="chkall(this)"> CHECK ALL</th> -->

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

							foreach($tally_issued_material_receipt as $row){

								$order_type='';
								$process_name='';
								$main_group='';
								$sub_group='';
								$second_sub_group='';


								echo "<tr>
									<td>".++$i;
									// foreach($formrights as $formrights_row){ 												
									// 			echo ($formrights_row->modify==1 ? '<input type="checkbox" name="id[]" value="'.$row->id.'"> ' : '');
												
									// }
									//echo'<input type="checkbox" name="id[]" value="'.$row->id.'">';
								$arr=explode("/", $row->jobcard_no);
								$order_no=$arr[1];
								
								$order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);							
								
								if($order_master_result==TRUE){
									foreach ($order_master_result as $key => $order_master_row) {
										$order_type=$order_master_row->order_flag;
									}

								}
								if(strtolower(substr($row->jobcard_no,0,6))=="manual"){
									$arr_manual=explode("_",$row->jobcard_no);
									if(count($arr_manual)>0){
										$process_name= $arr_manual[3];
									}
								}


								$article_result=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$row->part_no);

								if($article_result==TRUE){
									foreach ($article_result as $key => $article_row) {
										$main_group=$article_row->main_group;
										$sub_group=$article_row->sub_group;
										$second_sub_group=$article_row->second_sub_group;
										$uom=$article_row->uom;
									}
								}					

								$amount=($row->avg_rate!=''?($row->qty*$row->avg_rate):0);


								$sum_qty+=$row->qty;
								$sum_amount+=$amount;

									echo"</td>
									<td>".$row->id."</td>
									<td>".$row->issue_date."</td>
									<td>".($process_name!=''?strtoupper('MANUAL-'.$process_name):($order_type==0?"COEX":"SPRING"))."</td>
									<td>".$row->jobcard_no."</td>
									<td>".($sub_group!=''?$sub_group:$main_group)."</td>
									<td>".$row->part_no."</td>
									<td>".$this->common_model->get_article_name($row->part_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->qty."</td>
									<td>".$uom."</td>
									<td>".$row->avg_rate."</td>
									<td>".($amount!=0?number_format($amount,2,'.',','):0)."</td>
									<td>".$row->status."</td>
									<td>".$row->remarks."</td>
									<td>".$row->transaction_date."</td>";
									//echo'<td><input type="checkbox" name="id[]" value="'.$row->id.'"></td>';							

							echo"</tr>";
							}

							echo'<tr style="font-weight:bold;">
								<td colspan="8">TOTAL</td>
								<td>'.number_format($sum_qty,2,'.',',').'</td>
								<td></td>
								<td></td>
								<td>'.number_format($sum_amount,2,'.',',').'</td>
								<td></td>
								<td></td>
								<td></td>
								</tr>';
						}?>



					</tbody>							
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