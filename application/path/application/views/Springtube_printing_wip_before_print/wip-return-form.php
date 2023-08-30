<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		



	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/wip_return_save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

						<?php foreach($springtube_printing_wip_master_before as $row){ ?>

						<tr>
							<td class="label"> Date <span style="color:red;">*</span> :</td>
							<td><input type="hidden" name="bprint_wip_id" value="<?php echo set_value('bprint_wip_id',$row->bprint_wip_id);?>">
								<input type="date" name="bprint_wip_date"   value="<?php echo set_value('bprint_wip_date',date('Y-m-d'));?>" readonly /></td>
							
						</tr>
						<tr>
							<td class="label">Customer  :</td>
							<td ><input type="text" name="customer" id="customer"  size="60" value="<?php echo set_value('customer',$this->common_model->get_customer_name($row->customer,$this->session->userdata['logged_in']['company_id']).'//'.$row->customer);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Order No.  :</td>
							<td ><input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$row->order_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Article No.  :</td>
							<td ><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no',$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id']).'//'.$row->article_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Printing Jobcard No.  :</td>
							<td ><input type="text" name="print_jobcard_no" id="print_jobcard_no"  size="20" value="<?php echo set_value('print_jobcard_no',$row->print_jobcard_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Job Meters<span style="color:red;">*</span>  :</td>
							<td ><input type="text" name="bprint_wip_meters" id="bprint_wip_meters"  size="20" value="<?php echo set_value('bprint_wip_meters',$row->bprint_wip_meters);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Job Qty<span style="color:red;">*</span>  :</td>
							<td ><input type="text" name="bprint_wip_qty" id="bprint_wip_qty"  size="20" value="<?php echo set_value('bprint_wip_qty',$row->bprint_wip_qty);?>" readonly/></td>
						</tr>

						<tr>
							<td class="label">Cost/Meter<span style="color:red;">*</span>  :</td>
							<td ><input type="text" name="bwip_cost_per_meter" id="bwip_cost_per_meter"  size="20" value="<?php echo set_value('bwip_cost_per_meter',$row->bwip_cost_per_meter);?>" readonly/></td>
						</tr>

						<?php }?>

						<?php foreach($springtube_extrusion_wip_master as $row){ ?>

						<tr>
							<td class="label">From Order No.  :</td>
							<td ><input type="text" name="from_order_no" id="from_order_no"  size="20" value="<?php echo set_value('from_order_no',$row->order_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Article No.  :</td>
							<td ><input type="text" name="from_article_no" id="from_article_no"  size="60" value="<?php echo set_value('from_article_no',$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id']).'//'.$row->article_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Extrusion Jobcard No.  :</td>
							<td ><input type="text" name="extrusion_jobcard_no" id="extrusion_jobcard_no"  size="20" value="<?php echo set_value('extrusion_jobcard_no',$row->jobcard_no);?>" readonly/></td>
						</tr>

						<?php }?>

												 
					</table>			
				</td>
			</tr>
			<tr>
				<td>
					<div class="ui buttons">
				  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
				  		<div class="or"></div>
				  		<button class="ui positive button">Return</button>
					</div>
				</td>
		</tr>
		</table>							
	</div>	
</form>
			
				
				
			