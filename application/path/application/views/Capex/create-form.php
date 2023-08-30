<script src="https://cdn.tiny.cloud/1/zefcv4c5th55cjm0i30q7czorh4yrqhi1jsq801s4p14vezy/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>
	<script>
    tinymce.init({
      selector: '.mytextarea',
      min_height: 400,

    });
  </script>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/javascript/semantic.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.address/1.6/jquery.address.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$('.menu .item').tab();
});
</script>
<script type="text/javascript">
	$(document).on("change", ".amount", function() {
        var sum = 0;
        $(".amount").each(function(){
            sum += +$(this).val();
        });
        $(".total").val(sum);
    });
</script>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<div class="ui top attached tabular menu">
		  <a class="active item" data-tab="first">Capex Information</a>
		  <a class="item" data-tab="second">Starting Situation / Problem</a>
		  <a class="item" data-tab="third">Solution Proposal</a>
		  <a class="item" data-tab="four">Advantage & Risk</a>
		  <a class="item" data-tab="five">Saving/Cost</a>
		  <a class="item" data-tab="six">Alternatives</a>
		  <a class="item" data-tab="seven">Impact</a>
		  <a class="item" data-tab="eight">Profitability/Roi</a>
		</div>
		<div class="ui bottom attached active tab segment" data-tab="first">
		  <table class="form_table_inner" style="border:1px solid #ddd;" width="100%">

									<tr>
										<td class="label" width="15%"><b>Capex Date</b>  <span style="color:red;">*</span> :</td>
										<td><input type="date" name="capex_date"  size="60" value="<?php echo set_value('capex_date',date('Y-m-d'));?>" /></td>
									</tr>

									<tr>
										<td class="label" width="15%"><b>Applicant</b>  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="applicant"  size="60" value="<?php echo set_value('applicant');?>" /></td>
									</tr>

									<tr>
											<td class="label"><b>Project Name <span style="color:red;">*</span></b> :</td>
											<td><input type="text" name="project_name" size="60" value="<?php echo set_value('project_name');?>" /></td>
									</tr>

									<tr>
										<td class="label" width="15%"><b>Project Start Date</b>  <span style="color:red;">*</span> :</td>
										<td><input type="date" name="project_begin_date"  size="10" value="<?php echo set_value('project_begin_date');?>" /></td>
									</tr>

									<tr>
										<td class="label" width="15%"><b>Project End Date</b>  <span style="color:red;">*</span> :</td>
										<td><input type="date" name="project_end_date"  size="10" value="<?php echo set_value('project_end_date');?>" /></td>
									</tr>

									<tr>
											<td class="label"><b>Project Organization <span style="color:red;">*</span></b> :</td>
											<td><textarea name="project_organization" rows="3" cols="60"></textarea></td>
									</tr>

									<tr>
											<td class="label"><b>Project Team <span style="color:red;">*</span></b> :</td>
											<td><textarea name="project_team" rows="3" cols="60"></textarea></td>
									</tr>

									<tr>
											<td class="label"><b>Please Select</b></td>
											<td>
												<div class="ui checkbox"><input type="checkbox" name="replacement"  value="1"><label>Replacement</label></div> &nbsp;&nbsp;
												<div class="ui checkbox"><input type="checkbox" name="expansion"  value="1"><label>Expansion</label></div> &nbsp;&nbsp;
												<div class="ui checkbox"><input type="checkbox" name="improvement"  value="1"><label>Improvement</label></div> &nbsp;&nbsp;
												<div class="ui checkbox"><input type="checkbox" name="renewal"  value="1"><label>Renewal</label></div>
											</td>
									</tr>
														
									<tr>
											<td class="label"><b>Cost Center <span style="color:red;">*</span></b> :</td>
											<td><input type="text" name="cost_center" size="60" value="<?php echo set_value('cost_center');?>" /></td>
									</tr>

									<tr>
											<td class="label"><b>Expected Useful Life <span style="color:red;">*</span></b> :</td>
											<td><input type="text" name="expected_useful_life" maxlength="4" size="4" value="<?php echo set_value('expected_useful_life');?>" /> in Years</td>
									</tr>

									<tr>
											<td class="label"><b>Capex Amount <span style="color:red;">*</span></b> :</td>
											<td><input type="text" name="capex_amount"  class="amount" maxlength="10" size="10"  value="<?php echo set_value('capex_amount');?>" />  &nbsp;&nbsp;

												<b>Third Party Service Amount <span style="color:red;">*</span></b> :
												<input type="text" name="third_party_service_amount" class="amount"  maxlength="10" size="10"   value="<?php echo set_value('third_party_service_amount');?>" /> &nbsp;&nbsp;

												<b>Own Work Amount <span style="color:red;">*</span></b> :
												<input type="text" name="own_work_amount" class="amount"  maxlength="10" size="10" value="<?php echo set_value('own_work_amount');?>" /> &nbsp;&nbsp;

												<b>Total Amount <span style="color:red;">*</span></b> :
												<input type="text" name="total_amount" class="total"  maxlength="10" size="10" value="<?php echo set_value('total_amount');?>" />
											</td>
									</tr>
								</table>
		</div>

		<div class="ui bottom attached tab segment" data-tab="second">
		  <table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
		  	<tr>
		  		<td><textarea class="mytextarea" name="problem">STARTING SITUATION/PROBLEM</textarea></td>
			</tr>
			</table>
		</div>

		<div class="ui bottom attached tab segment" data-tab="third">
		  <table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
		  		<tr><td><textarea class="mytextarea" name="solution">SOLUTION/PROPOSAL</textarea></td></tr>
			</table>

		</div>

		<div class="ui bottom attached tab segment" data-tab="four">
			<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
				<tr><td><textarea class="mytextarea" name="advantage">ADVANTAGE</textarea></td></tr>
				<tr><td><textarea class="mytextarea" name="risk">RISK</textarea></td></tr>
			</table>
		</div>
			
		<div class="ui bottom attached tab segment" data-tab="five">
			<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
				<tr><td><textarea class="mytextarea" name="saving">SAVING/COST</textarea></td></tr>
			</table>
		</div>

		<div class="ui bottom attached tab segment" data-tab="six">
			<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
				<tr><td><textarea class="mytextarea" name="alternatives">ALTERNATIVES</textarea></td></tr>
			</table>
		</div>

		<div class="ui bottom attached tab segment" data-tab="seven">
			<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
				<tr><td><textarea class="mytextarea" name="impact">IMPACT</textarea></td></tr>
			</table>
		</div>

		<div class="ui bottom attached tab segment" data-tab="eight">
			<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
				<tr>
											<td class="label"><b>Profitability <span style="color:red;">*</span></b> :</td>
											<td><input type="number" name="profitability" value="<?php echo set_value('profitability');?>" required/> &nbsp;&nbsp;

											<b>ROI %<span style="color:red;">*</span></b> :
											<input type="text" name="roi" value="<?php echo set_value('roi');?>" maxlength="4" size="4" required />
											&nbsp;&nbsp;

											<b>Payback Year <span style="color:red;">*</span></b> :
											<input type="text" name="pay_back_year" maxlength="4" size="4" value="<?php echo set_value('pay_back_year');?>" required/>
											&nbsp;&nbsp;

											<b>IRR %<span style="color:red;">*</span></b> :
											<input type="text" name="irr" maxlength="4" size="4" value="<?php echo set_value('irr');?>" required/>
											</td>
									</tr>

									<tr>
											<td class="label"><b>Please Select</b></td>
											<td>
												<div class="ui checkbox"><label>Inform Clients</label><input type="checkbox" name="inform_clients"  value="1"></div> &nbsp;&nbsp;

												<div class="ui checkbox"><label>Equipment Qualification</label><input type="checkbox" name="equipment_qualification"  value="1"></div> &nbsp;&nbsp;
												
												<div class="ui checkbox"><label>Product Validation</label><input type="checkbox" name="product_validation"  value="1"></div> &nbsp;&nbsp;

											</td>
									</tr>					
			</table>
		</div>
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  <div class="or"></div>
	  <button class="ui positive button" id="btnSubmit">Save</button>
		</div>
	</div>
		
</form>

				
				
				
				
				
			