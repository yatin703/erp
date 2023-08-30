<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});

		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_so_no');?>", {selectFirst: true});

		$("#release_to_order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_so_no');?>", {selectFirst: true});

		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/article_no_springtube');?>", {selectFirst: true});

		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});

		$("#film_code").autocomplete("<?php echo base_url('index.php/ajax_springtube/film_autocomplete');?>", {selectFirst: true});
	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<!-- <h4>WIP search</h4> -->
		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>WIP Search</b></legend>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<?php foreach ($account_periods_master as $account_periods_master_row ):?>
							<tr>
								<td class="label" >From Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',$account_periods_master_row->fin_year_start);?>"/></td>
								<td class="label" >To Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
							</tr>
							<?php endforeach;?>
						 
						<tr>
						<tr>
							<td class="label">SO No :</td>
							<td><input type="text" name="order_no" id="order_no"  value="<?php echo set_value('order_no');?>" maxlength="20" size="20"/></td>
							<td class="label">Jobcard No. :</td>
							<td><input type="text" name="jobcard_no" id="jobcard_no"  value="<?php echo set_value('jobcard_no');?>" maxlength="20" size="20"/></td>
						</tr>
						<tr>
							<td class="label">Sleeve Dia :</td>
							<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Dia--</option>
							<?php   if($sleeve_dia==FALSE){
											echo "<option value=''>--Setup Required--</option>";
									}
								else{
									foreach($sleeve_dia as $sleeve_dia_row){
										echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
									}
							}?></select>
							<!-- <td class="label">Sleeve Length :</td>
							 <td>
							 	<input type="number" name="sleeve_length" min="10"  max="500" step="0.1"  id="sleeve_length" size="5" maxlength="5" value="<?php echo set_value('sleeve_length');?>">
							 </td> -->
							<td class="label">Total Microns :</td>
							<td ><input type="number" name="total_microns" min="10"  max="500" step="0.5"  id="total_microns" size="5" maxlength="5" value="<?php echo set_value('total_microns');?>">
							</td> 
						</tr>
						<tr>
							<td class="label">Status:</td>
							<td><select name="status">
									<option value=''>--Select Status--</option>
									<option value='1' <?php echo set_select('status',1); ?>>Released</option>
									<option value='0' <?php echo set_select('status',0); ?>>In WIP</option>
								</select>
							</td>
							<td class="label">WIP Cost :</td>
							<td colspan="3">
								<input type="number" name="wip_cost_per_meter" value="<?php echo set_value('wip_cost_per_meter');?>" min="0" max="1000" steps="any">
							</td>
								
							
						</tr>					
							
						<tr>
							<td class="label">From Process</td>
							<td colspan="3">
								
								<?php if($springtube_process_master==TRUE){
											
									foreach($springtube_process_master as $springtube_process_master_row){
										if(!empty($this->input->post('springtube_process[]'))){

											echo'<input type="checkbox" name="springtube_process[]" value="'.$springtube_process_master_row->process_id.'" '.(in_array($springtube_process_master_row->process_id,$this->input->post('springtube_process[]'))?"checked":"").' >&nbsp;'.$springtube_process_master_row->process_name.'</br>';
										}else{
										echo'<input type="checkbox" name="springtube_process[]" value="'.$springtube_process_master_row->process_id.'" >&nbsp;'.$springtube_process_master_row->process_name.'</br>';
										}
									}
							}?>
							
							</td>
								
							
						</tr>
											
					

					</table>			
								
				</td>
				<td width="50%">
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
							<td class="label">Film Code :</td>
							<td colspan="3"><input type="text" name="film_code" id="film_code"  value="<?php echo set_value('film_code');?>" maxlength="500" size="60"/></td>
							
						</tr>
						<tr>
							
							<td class="label">Second Layer MB :</td>
                            <td colspan="3"><select name="film_masterbatch_two" id="film_masterbatch_two" ><option value=''>--Select MB--</option>
                                    <?php foreach ($masterbatch as $masterbatch_row) {
                                       echo "<option value='".$masterbatch_row->article_no."' ".set_select('film_masterbatch_two',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                                    }?></select>
                            </td>
						</tr>
						<tr>
							
							<td class="label">Sixth Layer MB :</td>
                            <td colspan="3"><select name="film_masterbatch_six" id="film_masterbatch_six" ><option value=''>--Select MB--</option>
                                    <?php foreach ($masterbatch as $masterbatch_row) {
                                       echo "<option value='".$masterbatch_row->article_no."' ".set_select('film_masterbatch_six',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                                    }?></select>
                            </td>
						</tr>
						<tr>
							<td class="label" >Release From Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="release_from_date" id="release_from_date" value="<?php echo set_value('release_from_date');?>"/></td>
							<td class="label" >Release To Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="release_to_date" id="release_to_date" value="<?php echo set_value('release_to_date');?>"/></td>
						</tr>

						<tr>
							<td class="label">Released Order No.:</td>
							<td><input type="text" name="release_to_order_no" value="<?php echo set_value('release_to_order_no');?>" maxlength="20" size="20" >
							</td>
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
						 
					</div>
				</td>
			</tr>
		</table>
	</fieldset>	
	

</div>
		
</form>
				
				
				
				
				
			