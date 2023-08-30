<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/any_article_no');?>", {selectFirst: true});		
		$("#mp_pos_no").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});

		

		
	});

</script>

</script>
	<script>
	function validate_form(){

		var x=document.getElementById("form1");
		var flag=0;
		for(i=0;i<x.length;i++){
			
			if(x.elements[i].value!='' && x.elements[i].name!='' &&  x.elements[i].name!='from_date' && x.elements[i].name!='to_date'){
				flag=1;								
			}
			if(document.getElementById('from_date').value!='' && document.getElementById('to_date').value!=''){
				flag=1;	
			}
		}

		if(flag==1){
			return true;
		}else{
			alert('From Date And To Date Should not be Blank.');

			if(document.getElementById('from_date').value==''){
				document.getElementById('from_date').focus();
				return false;
			}
			else{
				document.getElementById('to_date').focus();
				return false;
			}
			    
		}		
					
		
	}

</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result_manual');?>" id="form1" method="POST" >

	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<fieldset style="border: 1px solid #8cacbb;">
			<legend><b>Manual Issue Search</b></legend>

		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
									
						<!-- <?php foreach ($account_periods_master as $account_periods_master_row ):?>
							<tr>
								<td class="label" >From Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',$account_periods_master_row->fin_year_start);?>"/></td>
								<td class="label" >To Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
							</tr>
						<?php endforeach;?> -->

							<tr>
								<td class="label" >From Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',date('Y-m-d'));?>"/></td>
								<td class="label" >To Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
							</tr>

							<tr>
								<td class="label">Article   :</td>
								<td colspan="3"><input type="text" name="article_no" id="article_no"  size="65" value="<?php echo set_value('article_no');?>" /></td>
							</tr> 	 
					</table>		
								
				</td>
				<td width="50%">
					<table class="form_table_inner">									
						<tr>
							<td class="label">Process :</td>
							<td >
								<select name="process" id="process" >

									<option value="">--Please Select--</option>
									<option value="0" <?php echo set_select('process','0');?>>Coex</option>
									<option value="1" <?php echo set_select('process','1');?> >Spring Tube</option>
									
								</select>

							</td>
							<td class="label">Created By :</td>
							<td><select name="employee_id" id="employee_id">
								<option value=''>--Select User--</option>
								<?php 
								foreach ($user_master as $user_master_row) {
				             echo "<option value='".$user_master_row->user_id."' ".set_select('employee_id',$user_master_row->user_id).">".strtoupper($user_master_row->login_name)."</option>";
				             }
				             ?>
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
	  		<button class="ui positive button" onClick="return validate_form(); ">Search</button>
		</div>
				</td>
			</tr>
		</table>
		</fieldset>					
	</div>	
		
</form>
				
				
				
				
				
			