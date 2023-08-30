<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($tally_sales_order_master as $row):?>

									<tr>
										<td class="label"> Order Date <span style="color:red;">* </span> :
										</td>
										<td>
											<input type="hidden" name="id" value='<?php echo $row->id;?>'>
											<input type="date" name="order_date" id="order_date" value="<?php echo set_value('order_date',$row->order_date);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Order No <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="order_no" id="order_no" readonly value="<?php echo set_value('order_no',$row->order_no);?>"/> &nbsp;
											&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('index.php/sales_order_book/view/'.$row->order_no.'');?>" target="_balnk"><?php echo $row->order_no;?> </a>

										</td>
									</tr>
									<tr>
										<td class="label"> Sales Ladger <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="sales_ledger" id="sales_ledger" value="<?php echo set_value('sales_ledger',$row->sales_ledger);?>"/>
										</td>
									</tr>
									<tr>

										<td class="label"> Bill To <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="bill_to" id="bill_to" size="40" value="<?php echo set_value('bill_to',$row->bill_to);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Ship To <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="ship_to" id="ship_to" size="40" value="<?php echo set_value('ship_to',$row->ship_to);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Po No/Po Date <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="po_no" id="po_no" size="40" value="<?php echo set_value('po_no',$row->po_no);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Part no. <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="part_no" id="part_no" size="20" value="<?php echo set_value('part_no',$row->part_no);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Order Qty <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="order_quantity" id="order_quantity" size="20" value="<?php echo set_value('order_quantity',$row->order_quantity);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Unit Rate <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="unit_rate" id="unit_rate" size="20" value="<?php echo set_value('unit_rate',$row->unit_rate);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Net Amount <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="net_amount" id="net_amount" size="20" value="<?php echo set_value('net_amount',$row->net_amount);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Status <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="status" id="status" size="20" value="<?php echo set_value('status',$row->status);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Remarks <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="remarks" id="remarks" size="60" value="<?php echo set_value('remarks',$row->remarks);?>"/>
										</td>
									</tr>

									
							<?php endforeach;?>		

					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
