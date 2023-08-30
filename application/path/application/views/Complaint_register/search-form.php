<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
 <script type="text/javascript">

	$(document).ready(function() {

		$("#loading").hide(); $("#cover").hide();		 
		// ------------------------------------------
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		$("#invoice_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});
		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_so_no');?>", {selectFirst: true});

		$("#complaint_no").autocomplete("<?php echo base_url('index.php/ajax/complaint_no_autocomplete');?>", {selectFirst: true});
		
		
		$("#tr_invoice").hide();
		$("#tr_order").hide();
		$("#tr_article_no").hide();
		$("#tr_invoice_tubes_checked").hide();
		$("#tr_order_tubes_hold").hide();

		$("#pallets").hide();
		$("#boxes").hide();
		//alert($("#complaint_source").val());
		// AFTER POST-------------------------------
		if($("#complaint_source").val()=="1"){
   			$("#tr_invoice").show();
   			$("#tr_article_no").show();
			$("#tr_order").hide();
			$("#order_no").val('');	   			
   		}else if($("#complaint_source").val()=="0"){
	   		$("#order_no").val('');
	   		$("#tr_article_no").show();
   			$("#tr_invoice").hide();
			$("#tr_order").show();
   		}else{
   			$("#invoice_no").val('');
	   		$("#order_no").val('');
	   		$("#tr_article_no").hide();
   			$("#tr_invoice").hide();
			$("#tr_order").hide();
			$("#tr_invoice_tubes_checked").hide();
			$("#tr_order_tubes_hold").hide();

   		}

   		$("#complaint_source").change(function() {  	    
	   		var complaint_source = $(this).find(':selected').val();
	   		//alert(complaint_source);
	   		if(complaint_source=="1"){
	   			$("#tr_invoice").show();
	   			//$("#tr_article_no").show();
	   			$("#tr_invoice_tubes_checked").show();
	   			$("#order_no").val('');
	   			$("#sp_article_no").html('');
				$("#tr_order").hide();
				$("#tr_order_tubes_hold").hide();	   				   			
	   		}else if(complaint_source=="0"){
	   			$("#invoice_no").val('');
	   			$("#tr_invoice").hide();
	   			$("#tr_invoice_tubes_checked").hide();
				$("#tr_order").show();
				$("#tr_order_tubes_hold").show();
				$("#sp_article_no").html('');	   				   			
	   		}else{
	   			$("#invoice_no").val('');
	   			$("#order_no").val('');
	   			$("#tr_invoice").hide();
				$("#tr_order").hide();
				$("#tr_article_no").hide();
				$("#tr_invoice_tubes_checked").hide();
				$("#tr_order_tubes_hold").hide();
				$("#sp_article_no").html('');

	   		}
	   	});	


	   	 

	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		
		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>Complaint Register Search :</b></legend>
		<table class="form_table_design">
			<tr>
				<td width="50%"> 				 
					<table class="form_table_inner" >
						<?php foreach ($account_periods_master as $account_periods_master_row ):?>
							<tr>
								<td class="label" >From Date <span style="color:red;">*</span>:</td>
								<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',$account_periods_master_row->fin_year_start);?>"/></td>
								<td class="label" >To Date <span style="color:red;">*</span>:</td>
								<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
							</tr>
						<?php endforeach;?>

						<tr>
							<td class="label">Complaint No:</td>
							<td><input type="text" name="complaint_no" id="complaint_no" placeholder="Enter Complaint No." value="<?php echo set_value('complaint_no');?>"/></td>
							<td class="label">Complaint Status:</td>
							<td>
								<select name="complaint_status" id="complaint_status" >
									<option value="" <?php echo set_select('complaint_status','');?>>Select Complaint Status</option>
									<option value="0" <?php echo set_select('complaint_status','0');?>>Rejected</option>
									<option value="1" <?php echo set_select('complaint_status','1');?>>Accepted</option>
									<option value="2" <?php echo set_select('complaint_status','2');?>>Observation</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Complaint Source:</td>
							<td >
								<select name="complaint_source" id="complaint_source">
									<option value="">Select Complaint Source</option>
									<option value="0" <?php echo set_select('complaint_source',0);?> >Internal</option>
									<option value="1" <?php echo set_select('complaint_source',1);?> >External</option>
								</select>
							</td>
							<td class="label">Claim Inspection:</td>
							<td>
								<select name="claim_inspection" id="claim_inspection">
									<option value="">Select Claim Inspection</option>
									<option value="1" <?php echo set_select('claim_inspection',1);?> >Incoming</option>
									<option value="2" <?php echo set_select('claim_inspection',2);?> >Online</option>
								</select>
							</td>
							
						</tr>
						<tr id="tr_invoice">
							<td class="label">Invoice No.:</td>
							<td colspan="2"><input type="text" name="invoice_no" id="invoice_no" value="<?php echo set_value('invoice_no');?>" placeholder="Enter Invoice No." />
							</td>
							<!-- <td>
								<span id="invoice_article_no"></span> 
							</td> -->	
						</tr>
						<tr id="tr_order">
							<td class="label">Order No.:</td>
							<td colspan="2"><input type="text" name="order_no" id="order_no" value="<?php echo set_value('order_no');?>" placeholder="Enter Order No."/>
							</td>
							<!-- <td>	
							<span id="order_article_no"></span>		
							</td> -->
							
						</tr>									 
						
				 		<!-- <tr>
							<td class="label">Claim Inspection:</td>
							<td>
								<select name="claim_inspection" id="claim_inspection">
									<option value="">Select Claim Inspection</option>
									<option value="1" <?php echo set_select('claim_inspection',1);?> >Incoming</option>
									<option value="2" <?php echo set_select('claim_inspection',2);?> >Online</option>
								</select>
							</td>										
						</tr> --> 								 
					
						<!-- <tr>
							<td class="label">Complaint Status <span style="color:red;">*</span> :</td>
							<td>
								<select name="complaint_status" id="complaint_status" >
									<option value="" <?php echo set_select('complaint_status','');?>>Select Complaint Status</option>
									<option value="0" <?php echo set_select('complaint_status','0');?>>Rejected</option>
									<option value="1" <?php echo set_select('complaint_status','1');?>>Accepted</option>
									<option value="2" <?php echo set_select('complaint_status','2');?>>Observation</option>
								</select>
							</td>													
						</tr> --> 
						
					</table>											
						 
				</td>
					
				<td>					
					<table>
						<tr>
							<td class="label">Customer :</td>
							<td colspan="3"><input type="text" name="customer" id="customer"  value="<?php echo set_value('customer');?>" maxlength="200" size="60"/></td>
							
						</tr>						
						<tr>
							<td class="label">Article No. :</td>
							<td colspan="3"><input type="text" name="article_no" id="article_no"  value="<?php echo set_value('article_no');?>" maxlength="200" size="60"/></td>
							
						</tr>
						<tr>
							<td class="label">Nature Of complaint :</td>
							<td colspan="2"><select name="complaint_nature" id="complaint_nature" ><option value=''>--Select Nature Of Complaint--</option>
							<?php if($capa_complaint_nature_master==FALSE){
									echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($capa_complaint_nature_master as $capa_complaint_nature_master_row){
										 
										echo "<option value='".$capa_complaint_nature_master_row->complaints."'".">".$capa_complaint_nature_master_row->complaints."</option>";
									}
							}?>
							</select></td>
						</tr>
						 
 
					</table>
				</td>				
			</tr>						
			<tr>
				<td colspan="2">
					<div class="ui buttons">
					  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
					  <div class="or"></div>
					  <button class="ui positive button" id="btnsubmit" >Search</button>
					<!-- <input type="submit" class="ui positive button" value="Save"/>-->
					</div>
				</td>
			</tr>

		</table>
	</fieldset>
	</div>		
</form>
				
				
				
				
				
			