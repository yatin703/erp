<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($tally_sales_invoice_details as $row):?>

									<tr>
										<td class="label"> Invoice Date <span style="color:red;">* </span> :
										</td>
										<td>
											<input type="hidden" name="id" value='<?php echo $row->id;?>'>
											<input type="date" name="invoice_date" id="invoice_date" value="<?php echo set_value('invoice_date',$row->invoice_date);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Invoice No <span style="color:red;">* </span> :
										</td>
										<td>											
											<input type="text" name="ar_invoice_no" id="ar_invoice_no" readonly value="<?php echo set_value('ar_invoice_no',$row->ar_invoice_no);?>"/> 
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
										<td class="label"> Order No <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="order_no" id="order_no" size="40" value="<?php echo set_value('order_no',$row->order_no);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Article No. <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="article_no" id="article_no" size="20" value="<?php echo set_value('article_no',$row->article_no);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Invoice Qty <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="arid_qty" id="arid_qty" size="20" value="<?php echo set_value('arid_qty',$row->arid_qty);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Unit Rate <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="selling_price" id="selling_price" size="20" value="<?php echo set_value('selling_price',$row->selling_price);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Net Amount <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="total_price" id="total_price" size="20" value="<?php echo set_value('total_price',$row->total_price);?>"/>
										</td>
									</tr>

									<tr>
										<td class="label"> Tax Amount <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="total_tax" id="total_tax" size="20" value="<?php echo set_value('total_tax',$row->total_tax);?>"/>
										</td>
									</tr>

									<tr>
										<td class="label"> CGST <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="cgst" id="cgst" size="20" value="<?php echo set_value('cgst',$row->cgst);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> UTGST <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="utgst" id="utgst" size="20" value="<?php echo set_value('utgst',$row->utgst);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> SGST <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="sgst" id="sgst" size="20" value="<?php echo set_value('sgst',$row->sgst);?>"/>
										</td>
									</tr>

									<tr>
										<td class="label"> IGST <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="igst" id="igst" size="20" value="<?php echo set_value('igst',$row->igst);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Freight <span style="color:red;">* </span> :
										</td>
										<td>											
											<input type="text" name="freight" id="freight" size="20" value="<?php echo set_value('freight',$row->freight);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Packing <span style="color:red;">* </span> :
										</td>
										<td>											
											<input type="text" name="packing" id="packing" size="20" value="<?php echo set_value('packing',$row->packing);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Insurance <span style="color:red;">* </span> :
										</td>
										<td>											
											<input type="text" name="insurance" id="insurance" size="20" value="<?php echo set_value('insurance',$row->insurance);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Gross Amount <span style="color:red;">* </span> :
										</td>
										<td>											
											<input type="text" name="gross_amount" id="gross_amount" size="20" value="<?php echo set_value('gross_amount',$row->gross_amount);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Currency <span style="color:red;">* </span> :
										</td>
										<td>											
											<input type="text" name="currency" id="currency" size="20" value="<?php echo set_value('currency',$row->currency);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Currency Rate <span style="color:red;">* </span> :
										</td>
										<td>											
											<input type="text" name="currency_rate" id="currency_rate" size="20" value="<?php echo set_value('currency_rate',$row->currency_rate);?>"/>
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
				
