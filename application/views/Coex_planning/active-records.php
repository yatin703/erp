 <style>
      .tableFixHead {
        overflow-y: auto;
        height: 480px;
      }
      .tableFixHead thead th {
        position: sticky;
        top: 0;
      }
  </style>
  <?php
  $data=array('work_proc_type_id'=>'3');
  $workprocedure_types_master=$this->process_model->active_record_search('workprocedure_types_master',$data,$this->session->userdata['logged_in']['company_id']);
  $rejection="";
	if($workprocedure_types_master==TRUE){
			foreach($workprocedure_types_master as $workprocedure_types_master_row){
				$rejection=$workprocedure_types_master_row->rejection_perc/100;
			}
		}else{
	}?>						
<div class="record_form_design">
<h3>Unplanned Pending Orders</h3>
	<span class='save'></span>
	<div class="record_inner_design">
		
		<div class="tableFixHead">
			<table class="record_table_design_without_fixed">
				<thead>
				<tr>
					<th>Id</th>
					<th>Approval Date</th>
					<th>Customer</th>
					<th>Tolerance</th>
					<th>Order No</th>
					<th>Article No</th>
					<th>Dia</th>
					<th>Print Type</th>
					<th>Order Qty</th>
					<th>Dispatch Allowed Upto</th>					
					<th>Planned Till Date</th>
					<th>Pending To Plan</th>
					<th>To be Planned</th>
					<th>Machine</th>
					<th>Shift Id</th>
					<th>Update</th>
				</tr>
				</thead>
				<?php 
				setlocale(LC_MONETARY, 'en_IN');
				if($pending_order==FALSE){
					echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
				}else{
					$i=1;
					foreach($pending_order as $row){
						?>
						<script>
						$(document).ready(function(){
						$("#loading").hide(); $("#cover").hide();

							$("#machine_id_<?php echo $i;?>").on('change',function(){

								if($('#planned_qty_<?php echo $i;?>').val()==""){
									alert('Enter the planned qty');
								}else if(isNaN($('#planned_qty_<?php echo $i;?>').val())){
									alert('Enter the Numbers in Planned Qty');
									 $("#planned_qty_<?php echo $i;?>").focus();

								}
								else{

								$("#loading").show();
								$("#cover").show();
								//alert($('#order_no_<?php echo $i;?>').val());
								$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
								$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/check_shift",data: {order_no : $('#order_no_<?php echo $i;?>').val(),article_no : $('#article_no_<?php echo $i;?>').val(),machine:$("#machine_id_<?php echo $i;?>").val()},cache: false,success: function(html){
							    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
							       $("#shift_<?php echo $i;?>").html(html);
							       $("#update_<?php echo $i;?>").prop('disabled',false);
							       //$("#update_<?php echo $i;?>").addClass('ui green label');
							       $(".planned_qty").prop('disabled',true);
							       $("#planned_qty_<?php echo $i;?>").prop('disabled',false);
							       $(".machine").prop('disabled',true);
							       $("#machine_id_<?php echo $i;?>").prop('disabled',false);
							       $(".shift").prop('disabled',true);
							       $("#shift_<?php echo $i;?>").prop('disabled',false);

							    } 
							    });
							    }
							});

							$("#update_<?php echo $i;?>").on('click',function(){

								if($('#planned_qty_<?php echo $i;?>').val()==""){
									alert('Enter the planned qty');
								}else if(isNaN($('#planned_qty_<?php echo $i;?>').val())){
									alert('Enter the Numbers in Planned Qty');
									$("#planned_qty_<?php echo $i;?>").focus();
								}else if($('#planned_qty_<?php echo $i;?>').val()>$('#pending_qty_<?php echo $i;?>').val()){
									alert('You can not plan more than Pending Qty');
								}else{
									$("#loading").show();
									$("#cover").show();
									$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
									
									$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/coex_plan",data: {order_no : $('#order_no_<?php echo $i;?>').val(),article_no : $('#article_no_<?php echo $i;?>').val(),planned_qty:$('#planned_qty_<?php echo $i;?>').val(),pending_qty:$('#pending_qty_<?php echo $i;?>').val(),machine:$("#machine_id_<?php echo $i;?>").val(),shift:$("#shift_<?php echo $i;?>").val()},cache: false,success: function(html){
							    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
								       $(".save").html(html);

							    		} 
							    	});
								
								}
								
							});


							//$("#shift_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
						});
						</script>

						<?php

						$dipatch_allowed_upto=($row->dispatch_tolerance<>'' ? ($row->quantity+($row->quantity/$row->dispatch_tolerance)) :$row->quantity);
						$planning_allowed_upto=$dipatch_allowed_upto+(($dipatch_allowed_upto/100)*$rejection);
						$pending=$planning_allowed_upto-$row->planned;
						echo "<tr>
									<td>".$i."</td>
									<td>".$row->approval_date."</td>

									<td>".$this->common_model->get_customer_name($row->customer_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->dispatch_tolerance<>'' ? $row->dispatch_tolerance."%" : '')."</td>
									<td><input type='hidden' id='order_no_".$i."' value='".$row->order_no."'>".$row->order_no."</td>
									<td><input type='hidden' id='article_no_".$i."' value='".$row->article_no."'>".$row->article_no."</td>

									<td>".$row->sleeve_dia."</td>
									<td>".$row->print_type."</td>
									<td>".money_format('%!.0n',$row->quantity)."</td>									
									<td>".money_format('%!.0n',$dipatch_allowed_upto)."</td>
									<td>".money_format('%!.0n',$row->planned)."</td>
									<td><input type='hidden' name='pending_qty_".$i."' id='pending_qty_".$i."' value='".$pending."'>".money_format('%!.0n',$pending)."</td>
									<td><input type='text' class='planned_qty' name='planned_qty_".$i."' id='planned_qty_".$i."' value='".$pending."'></td>
									<td><select name='machine' class='machine' id='machine_id_".$i."'><option value=''>--Machine--</option>";
										$coex_machine_master=$this->coex_planning_model->select_one_active_record('coex_machine_possibility_master',$parameter=array('coex_machine_possibility_master.sleeve_dia'=>$row->sleeve_dia,'coex_machine_possibility_master.print_type'=>$row->print_type,'coex_machine_possibility_master.archive'=>'0'),$this->session->userdata['logged_in']['company_id']);
										echo $this->db->last_query();
										if($coex_machine_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($coex_machine_master as $machine_row){
													echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
												}
										}

										echo "</select></td>
										<td><select id='shift_".$i."' name='shift' class='shift'>
										<option value=''>--Select--</option>
										</select></td>
										<td><input type='submit' class='update' id='update_".$i."' name='update_".$i."' value='Update' disabled></td>
									</tr>";
									$i++;
							}
						}?>
								
				</table>
			</div>
		</div>
</div>