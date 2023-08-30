<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($tally_stock_items_master as $row):?>

									<tr>
										<td class="label"> Article Name <span style="color:red;">* </span> :
										</td>
										<td>
											<input type="hidden" name="id" value='<?php echo $row->id;?>'>
											<input type="text" name="name" id="name" value="<?php echo set_value('name',$row->name);?>" size="60"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Part No. <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="part_no" id="part_no" readonly value="<?php echo set_value('part_no',$row->part_no);?>"/> 

										</td>
									</tr>
									<tr>
										<td class="label"> Description</span> :
										</td>
										<td>
											
											<input type="text" name="description" id="description" value="<?php echo set_value('description',$row->description);?>" size="60"/>
										</td>
									</tr>
									<tr>

										<td class="label"> Group Name <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="under_group" id="under_group" size="60" value="<?php echo set_value('under_group',$row->under_group);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Unit <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="units" id="units" size="20" value="<?php echo set_value('units',$row->units);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Maintain In Batches :
										</td>
										<td>											
											<input type="text" name="maintain_in_batches" id="maintain_in_batches" value="<?php echo set_value('maintain_in_batches',$row->maintain_in_batches);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Date Of Manufacturing :
										</td>
										<td>
											
											<input type="text" name="date_of_manufacturing" id="date_of_manufacturing" size="20" value="<?php echo set_value('date_of_manufacturing',$row->date_of_manufacturing);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Expiry Date :
										</td>
										<td>
											
											<input type="text" name="expiry_date" id="expiry_date" size="20" value="<?php echo set_value('expiry_date',$row->expiry_date);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> GST Applicable <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="gst_applicable" id="gst_applicable" size="20" value="<?php echo set_value('gst_applicable',$row->gst_applicable);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> HSN/SAC No. <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="hsn_no" id="hsn_no" size="20" value="<?php echo set_value('hsn_no',$row->hsn_no);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> HSN Description <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="hsn_description" id="hsn_description" size="40" value="<?php echo set_value('hsn_description',$row->hsn_description);?>"/>
										</td>
									</tr>

									<tr>
										<td class="label"> Calculation Type :
										</td>
										<td>
											
											<input type="text" name="calculation_type" id="calculation_type" size="20" value="<?php echo set_value('calculation_type',$row->calculation_type);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Taxability <span style="color:red;">* </span> :
										</td>
										<td>											
											<input type="text" name="taxability" id="taxability" size="20" value="<?php echo set_value('taxability',$row->taxability);?>"/>
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
										<td class="label"> CESS <span style="color:red;">* </span> :
										</td>
										<td>											
											<input type="text" name="cess" id="cess" size="20" value="<?php echo set_value('cess',$row->cess);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Type Of Supply <span style="color:red;">* </span> :
										</td>
										<td>											
											<input type="text" name="type_of_supply" id="type_of_supply" size="20" value="<?php echo set_value('type_of_supply',$row->type_of_supply);?>"/>
										</td>
									</tr>

									<tr>
										<td class="label"> Status</span> :
										</td>
										<td>											
											<input type="text" name="status" id="status" size="20" value="<?php echo set_value('status',$row->status);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Remarks</span> :
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
				
