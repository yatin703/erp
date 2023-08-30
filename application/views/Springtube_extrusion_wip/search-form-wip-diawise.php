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


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result_wip_diawise');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>FIlm WIP Report Search</b></legend>

		<table class="form_table_design">
			<tr>
				<td width="45%">
					<table class="form_table_inner">
						<?php foreach ($account_periods_master as $account_periods_master_row ):?>
							<tr>
								<td class="label" >From Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date','2020-04-01');?>"/></td>
								<td class="label" >To Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
							</tr>
							<?php endforeach;?>
						 
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
						<!-- <tr>
							<td class="label">Status:</td>
							<td><select name="status">
									<option value=''>--Select Status--</option>
									<option value='1' <?php echo set_select('status',1); ?>>Released</option>
									<option value='0' <?php echo set_select('status',0); ?>>In WIP</option>
								</select>
							</td>
							 	
							
						</tr> -->
											
					

					</table>			
								
				</td>
				<td width="55%">
					<table>
						 
						<tr>							
							<td class="label">Second Layer MB :</td>
                            <td><select name="film_masterbatch_two" id="film_masterbatch_two" ><option value=''>--Select MB--</option>
                                    <?php foreach ($masterbatch as $masterbatch_row) {
                                       echo "<option value='".$masterbatch_row->article_no."' ".set_select('film_masterbatch_two',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                                    }?></select>
                            </td>
						</tr>
						<tr>
							
							<td class="label">Sixth Layer MB :</td>
                            <td><select name="film_masterbatch_six" id="film_masterbatch_six" ><option value=''>--Select MB--</option>
                                    <?php foreach ($masterbatch as $masterbatch_row) {
                                       echo "<option value='".$masterbatch_row->article_no."' ".set_select('film_masterbatch_six',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                                    }?></select>
                            </td>
						</tr>

					</table>
				</td>
											
			</tr>

			<tr><td colspan="2"><div class="ui buttons">
				  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
				  <div class="or"></div>
				  <button class="ui positive button" id="btnsubmit" >Search</button>
	 
				</div>
				</td>
			</tr>
		</table>		 

		</field>		

 	</div>



 	<div class="record_form_design" style="width:90%;">	
	<div class="record_inner_design" >


		<div class="ui equal width grid">
		  <div class="equal width row">
		    <div class="column">

			
		<div class="ui segments">
			<div class="ui blue segment">
			    <p><a  class="ui orange label">FILM WIP</a><a  class="ui blue label"> MONTH WISE</a> 
			    	<a class="ui olive label"><i class="calendar icon"></i><?php echo($this->input->post('from_date')!='' && $this->input->post('to_date')!=''?$this->input->post('from_date').' TO '.$this->input->post('to_date') : $from_date.' TO '.$to_date);?></a></p>

			</div>	

			<div class="ui segment">
				<table class="ui very basic collapsing celled table"  style="font-size:10px;" id="tbl_data" >
					
					<thead>
					<!-- <tr><th colspan="9"><a class="ui orange label">WIP MONTHWISE</a> <?php echo ($this->input->post('from_date')!='' && $this->input->post('to_date') ? '<a class="ui olive label"><i class="calendar icon"></i>'.$this->input->post('from_date').'  TO '.$this->input->post('to_date').'</a>':'' )?>

					<?php 
					echo $this->input->get('from_date');
					
					 ?>

				</th></tr>
				 -->	
						
					<tr>				
						<th>Sr no.</th>
						 
						<th>Month</th>
						<th>Dia</th>					
						<th>Microns</th>
						<th>Second layer MB</th>
						<th>Sixth layer MB</th>					
						<th style="text-align: center;">WIP</th>
						<!--<th>Reels (Default length 600 MTRS)</th>-->
						<th style="text-align: center;">Amount</th>
						<th style="text-align: center;">Cost/Meter</th>
						 
																	
						
					</tr>
				</thead>
				<tbody>
					<?php 

						$sum_total_ok_meters=0;
						 

						$sum_reels=0;
						$sum_reels_release=0;
						$sum_amount=0;

					if($springtube_extrusion_wip_master==FALSE){
						echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
					}else{
							$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
							
							$reel_length=$this->config->item('springtube_reel_length');

							foreach($springtube_extrusion_wip_master as $master_row){

								 
									echo"<tr class='tr_test'>		
										<td >".$i++."</td>										
										<td>".$master_row->year."-".strtoupper(substr($master_row->month,0,3))."</td>
										<td>".$master_row->sleeve_dia."</td>
										<td>".$master_row->total_microns."</td>
										<td>".$this->common_model->get_article_name($master_row->second_layer_mb,$this->session->userdata['logged_in']['company_id'])."</td>
										<td>".$this->common_model->get_article_name($master_row->sixth_layer_mb,$this->session->userdata['logged_in']['company_id'])."</td>
										<td class='positive right aligned'><b>".money_format('%!.0n',$master_row->total_ok_meters)."</b><i> MTRS</i></td>
										<!--<td class='negative right aligned'><b>".money_format('%!.0n',$master_row->total_ok_meters/$reel_length)."</b><i> NOS</i></td>
										-->
										<td class='positive right aligned'><b>".($master_row->amount!=0?"  &#x20B9; ".money_format('%!.0n',$master_row->amount):"<i style='color:red'>Running</i>")."</b></td>
										<td class='positive right aligned'><b> ".($master_row->amount/$master_row->total_ok_meters!=0?"&#x20B9; ".money_format('%!.0n',$master_row->amount/$master_row->total_ok_meters):"<i style='color:red'>Running<i>")."</b></td>";
										 						
										 

									$sum_total_ok_meters+=$master_row->total_ok_meters;
									$sum_reels+=$master_row->total_ok_meters/$reel_length;
									$sum_amount+=$master_row->amount;	

							}//master Foreach

						echo"<tr style='font-weight:bold;'><td colspan='6' style='text-align:right;'><b>TOTAL</b></td><td   style='text-align:right;'><b>".money_format('%!.0n',$sum_total_ok_meters)."</b> <i> MTRS</i></td> 
						<!--<td class='positive' style='text-align:right;'><b>".money_format('%!.0n',$sum_reels)."</b> <i> NOS</i></td>
						-->
						<td  style='text-align:right;'><b> &#x20B9; ".money_format('%!.0n',$sum_amount)."</b></td><td class='positive right aligned'> &#x20B9; ".money_format('%!.0n',$sum_amount/$sum_total_ok_meters)."</td></tr>";	

						}?>
					</tbody>				
				</table>
			</div>	

	</div>

	</div>
	</div>
	</div>










			</div>
		</div>
	
</form>
				
				
				
				
				
			