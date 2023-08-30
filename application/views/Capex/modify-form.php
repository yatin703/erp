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
<script>
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
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<?php foreach($capex as $row):?>

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
				<input type="hidden" name="capex_no"  size="60" value="<?php echo $row->capex_no;?>" />
					<tr>
						<td class="label" width="15%"><b>Revision Date</b>  <span style="color:red;">*</span> :</td>
						<td><input type="date" name="capex_date"  size="60" value="<?php echo set_value('revision_date',date('Y-m-d'));?>" /></td>
					</tr>

					<tr>
						<td class="label"><b>Applicant <span style="color:red;">*</span></b> :</td>
						<td><input type="text" name="applicant" size="60" value="<?php echo set_value('applicant',$row->applicant);?>" required/></td>
					</tr>

					<tr>
						<td class="label"><b>Project Name <span style="color:red;">*</span></b> :</td>
						<td><input type="text" name="project_name" size="60" value="<?php echo set_value('project_name',$row->project_name);?>" required/></td>
					</tr>
					<tr>
						<td class="label" width="15%"><b>Project Start Date</b>  <span style="color:red;">*</span> :</td>
						<td><input type="date" name="project_begin_date"  size="10" value="<?php echo set_value('project_begin_date',$row->project_begin_date);?>" /></td>
					</tr>

					<tr>
						<td class="label" width="15%"><b>Project End Date</b>  <span style="color:red;">*</span> :</td>
						<td><input type="date" name="project_end_date"  size="10" value="<?php echo set_value('project_end_date',$row->project_end_date);?>" /></td>
					</tr>

					<tr>
						<td class="label"><b>Project Organization <span style="color:red;">*</span></b> :</td>
						<td><textarea name="project_organization" rows="3" cols="60" value="<?php echo set_value('project_organization',$row->project_organization);?>"><?php echo $row->project_organization;?></textarea></td>
					</tr>

					<tr>
						<td class="label"><b>Project Team <span style="color:red;">*</span></b> :</td>
						<td><textarea name="project_team" rows="3" cols="60" <?php echo set_value('project_team',$row->project_team_members);?>><?php echo $row->project_team_members;?></textarea></td>
					</tr>

									<tr>
											<td class="label"><b>Please Select</b></td>
											<td>
												<div class="ui checkbox"><input type="checkbox" name="replacement" <?php echo (($row->replacement== "1" ) ? 'checked value="1"' : 'value="'.set_checkbox('replacement',1).'"');?>><label>Replacement</label></div> &nbsp;&nbsp;
												<div class="ui checkbox"><input type="checkbox" name="expansion" <?php echo (($row->expansion== "1" ) ? 'checked value="1"' : 'value="'.set_checkbox('expansion',1).'"');?>><label>Expansion</label></div> &nbsp;&nbsp;
												<div class="ui checkbox"><input type="checkbox" name="improvement" <?php echo (($row->improvement== "1" ) ? 'checked value="1"' : 'value="'.set_checkbox('improvement',1).'"');?>><label>Improvement</label></div> &nbsp;&nbsp;
												<div class="ui checkbox"><input type="checkbox" name="renewal" <?php echo (($row->renewal== "1" ) ? 'checked value="1"' : 'value="'.set_checkbox('renewal',1).'"');?>><label>Renewal</label></div>
											</td>
									</tr>
														
									<tr>
											<td class="label"><b>Cost Center <span style="color:red;">*</span></b> :</td>
											<td><input type="text" name="cost_center" size="60" value="<?php echo set_value('cost_center',$row->cost_center);?>" required/></td>
									</tr>

									<tr>
											<td class="label"><b>Expected Useful Life <span style="color:red;">*</span></b> :</td>
											<td><input type="text" name="expected_useful_life" maxlength="4" size="4" value="<?php echo set_value('expected_useful_life',$row->expected_useful_life);?>" required/> in Years</td>
									</tr>

									<tr>
											<td class="label"><b>Capex Amount <span style="color:red;">*</span></b> :</td>
											<td><input type="text" name="capex_amount"  class="amount" maxlength="10" size="10"  value="<?php echo set_value('capex_amount',$row->capex_amount);?>" required/>  &nbsp;&nbsp;

												<b>Third Party Service Amount <span style="color:red;">*</span></b> :
												<input type="text" name="third_party_service_amount" class="amount"  maxlength="10" size="10"   value="<?php echo set_value('third_party_service_amount',$row->third_party_service_amount);?>" required/> &nbsp;&nbsp;

												<b>Own Work Amount <span style="color:red;">*</span></b> :
												<input type="text" name="own_work_amount" class="amount"  maxlength="10" size="10" value="<?php echo set_value('own_work_amount',$row->own_work_amount);?>" required/> &nbsp;&nbsp;

												<b>Total Amount <span style="color:red;">*</span></b> :
												<input type="text" name="total_amount" class="total"  maxlength="10" size="10" value="<?php echo set_value('total_amount',$row->total_amount);?>" required/>
											</td>
									</tr>
				</table>
			</div>
			<div class="ui bottom attached tab segment" data-tab="second">
		  		<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
		  			<tr>
		  				<td><textarea class="mytextarea" name="problem" value="<?php echo set_value('problem',$row->problem);?>"><?php echo $row->problem;?></textarea></td>
					</tr>
				</table>
			</div>
			<div class="ui bottom attached tab segment" data-tab="third">
				<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
					<tr>
						<td><textarea class="mytextarea" name="solution"  rows="10" cols="60" value="<?php echo set_value('solution',$row->solution);?>"><?php echo $row->solution;?></textarea></td>
					</tr>
				</table>
			</div>

			<div class="ui bottom attached tab segment" data-tab="four">
				<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
					<tr><td><textarea class="mytextarea" name="advantage"  rows="10" cols="60" value="<?php echo set_value('advantage',$row->advantage);?>"><?php echo $row->advantage;?></textarea></td>
					</tr>
					<tr><td><textarea class="mytextarea" name="risk"  rows="10" cols="60" value="<?php echo set_value('risk',$row->risk);?>"><?php echo $row->risk;?></textarea></td>
					</tr>
				</table>
			</div>

			<div class="ui bottom attached tab segment" data-tab="five">
				<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
					<tr><td><textarea class="mytextarea" name="saving"  rows="10" cols="60" value="<?php echo set_value('saving',$row->saving);?>"><?php echo $row->saving;?>
    											</textarea></td>
					</tr>
				</table>
			</div>
			<div class="ui bottom attached tab segment" data-tab="six">
				<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
					<tr>
						<td><textarea class="mytextarea" name="alternatives"  rows="10" cols="60" value="<?php echo set_value('alternatives',$row->alternative);?>"><?php echo $row->alternative;?></textarea></td>
					</tr>
				</table>
			</div>
			<div class="ui bottom attached tab segment" data-tab="seven">
				<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
					<tr><td><textarea class="mytextarea" name="impact"  rows="10" cols="60" value="<?php echo set_value('impact',$row->impact);?>"><?php echo $row->impact;?></textarea></td>
					</tr>
				</table>
			</div>
			<div class="ui bottom attached tab segment" data-tab="eight">
				<table class="form_table_inner" style="border:1px solid #ddd;" width="100%">
					<tr>
						<td class="label"><b>Profitability <span style="color:red;">*</span></b> :</td>
						<td><input type="number" name="profitability" value="<?php echo set_value('profitability',$row->profitability);?>" required/> &nbsp;&nbsp;

							<b>ROI %<span style="color:red;">*</span></b> :
							<input type="text" name="roi" value="<?php echo set_value('roi',$row->roi);?>" maxlength="4" size="4" required />
											&nbsp;&nbsp;

											<b>Payback Year <span style="color:red;">*</span></b> :
											<input type="text" name="pay_back_year" maxlength="4" size="4" value="<?php echo set_value('pay_back_year',$row->pay_back_year);?>" required/>
											&nbsp;&nbsp;

											<b>IRR %<span style="color:red;">*</span></b> :
											<input type="text" name="irr" maxlength="4" size="4" value="<?php echo set_value('irr',$row->irr);?>" required/>
											</td>
									</tr>

									<tr>
											<td class="label"><b>Please Select</b></td>
											<td>
												Inform Clients&nbsp;<input type="checkbox" name="inform_clients"  <?php echo (($row->inform_clients== "1" ) ? 'checked value="1"' : ' value="'.set_value('inform_clients',"1").'"');?>> &nbsp;&nbsp;

												Equipment Qualification&nbsp;<input type="checkbox" name="equipment_qualification"  <?php echo (($row->equipment_qualification== "1" ) ? 'checked value="1"' : 'value="'.set_value('equipment_qualification',"1").'"');?>>&nbsp;&nbsp;
												
												Product Validation&nbsp;<input type="checkbox" name="product_validation"  <?php echo (($row->product_validation== "1" ) ? 'checked value="1"' : 'value="'.set_value('product_validation',"1").'"');?>> &nbsp;&nbsp;

											</td>
									</tr>

								</table>
						</div>
	
	<?php endforeach;?>			
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  <div class="or"></div>
	  <button class="ui positive button" id="btnSubmit">Update</button>
		</div>
	</div>
		
</form>

				
				
				
				
				
			