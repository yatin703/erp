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


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result_scrap_diawise');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="45%">
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
				

					</table>			
								
				</td>
				<td width="55%">
					<!-- <table>
						 
						<tr>							
							<td class="label">Second Layer MB :</td>
                            <td><select name="film_masterbatch_two" id="film_masterbatch_two" ><option value=''>--Select MB--</option>
                                    <?php foreach ($masterbatch as $masterbatch_row) {
                                       echo "<option value='".$masterbatch_row->article_no."' ".set_select('film_masterbatch_two',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                                    }?></select>
                            </td>
						</tr>

					</table> -->
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

</div>

<div class="record_form_design" style="width:90%;">	
  
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
		<table class="ui sortable selectable celled table"  style="font-size:10px;" id="tbl_data" >
				
				<thead>
				<tr><th colspan="11"><a class="ui orange label">FILM SCRAP MONTHWISE</a> <?php echo ($this->input->post('from_date')!='' && $this->input->post('to_date')!='' ? '<a class="ui olive label"><i class="calendar icon"></i>'.$this->input->post('from_date').'  TO '.$this->input->post('to_date').'</a>':'')?>

			<?php echo $this->input->get('from_date');?>

			</th></tr>	
					
				<tr>				
					<th>Sr no.</th>
					 
					<th>Month</th>
					<th>Dia</th>					
					<th>Microns</th>
					<!--<th>Second layer MB</th>
					<th>Sixth layer MB</th>	
					-->	
					<th>Side Trim Waste</th>			
					<th>Setup Weight</th>
					<th>Purging Weight</th>
					<th>QC Scrap</th>
					<th>QC Scrap Weight</th>
					<th>WIP Scrap</th>
					<th>WIP Scrap Weight</th>

					<!--<th>Reels (Default length 600 MTRS)</th>-->
					
					 
																
					
				</tr>
			</thead>
			<tbody>
				<?php 
					$sum_total_side_trim_waste=0;
					$sum_total_setup_weight=0;
					$sum_total_purging_weight=0;			

					$sum_total_qc_scrap_meters=0;
					$sum_total_qc_scrap_weight=0;
					$sum_total_wip_scrap_meters=0;
					$sum_total_wip_scrap_weight=0;

				if($springtube_extrusion_production_master==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						$reel_length=$this->config->item('springtube_reel_length');

						foreach($springtube_extrusion_production_master as $master_row){

								$total_qc_scrap_meters=0;
								$total_qc_scrap_weight=0;

								$total_wip_scrap_meters=0;
								$total_wip_scrap_weight=0;

								$data_qc_scrap=array(
									'sleeve_dia'=>$master_row->sleeve_dia,
									'total_microns'=>$master_row->total_microns,
									'from_process'=>7,
									'year(scrap_date)'=>$master_row->year,
									'month(scrap_date)'=>$master_row->month_no
								);
								$springtube_extrusion_scrap_master_qc_result=$this->springtube_extrusion_production_model->extrusion_scrap_search_groupby('springtube_extrusion_scrap_master',$this->session->userdata['logged_in']['company_id'],$data_qc_scrap,'','');

								//echo $this->db->last_query();

								foreach ($springtube_extrusion_scrap_master_qc_result as $key => $springtube_extrusion_scrap_master_qc_row) {

								$total_qc_scrap_meters=$springtube_extrusion_scrap_master_qc_row->total_scrap_meters;
								$total_qc_scrap_weight=$springtube_extrusion_scrap_master_qc_row->total_scrap_weight;
									
								}


								$data_wip_scrap=array(
									'sleeve_dia'=>$master_row->sleeve_dia,
									'total_microns'=>$master_row->total_microns,
									'from_process'=>6,
									'year(scrap_date)'=>$master_row->year,
									'month(scrap_date)'=>$master_row->month_no
								);
								$springtube_extrusion_scrap_master_qc_result=$this->springtube_extrusion_production_model->extrusion_scrap_search_groupby('springtube_extrusion_scrap_master',$this->session->userdata['logged_in']['company_id'],$data_wip_scrap,'','');

								//echo $this->db->last_query();

								foreach ($springtube_extrusion_scrap_master_qc_result as $key => $springtube_extrusion_scrap_master_qc_row) {

								$total_wip_scrap_meters=$springtube_extrusion_scrap_master_qc_row->total_scrap_meters;
								$total_wip_scrap_weight=$springtube_extrusion_scrap_master_qc_row->total_scrap_weight;
									
								}

							 
								echo"<tr class='tr_test' >		
									<td >".$i++."</td>										
									<td>".$master_row->year."-".strtoupper(substr($master_row->month_name,0,3))."</td>
									<td>".$master_row->sleeve_dia."</td>
									<td>".$master_row->total_microns."</td>
									<td class='negative' style='text-align:right'><b>".number_format($master_row->total_side_trim_waste,2,'.',',')."</b><i> KGS</i></td>
									<td class='negative' style='text-align:right'><b>".number_format($master_row->total_setup_weight,2,'.',',')."</b><i> KGS</i></td>
									<td class='negative'  style='text-align:right'><b>".number_format($master_row->total_purging_weight,2,'.',',')."</b><i> KGS</i></td>
									<td class='negative' style='text-align:right'><b>".($total_qc_scrap_meters!=0?number_format($total_qc_scrap_meters,2,'.',',')."</b><i>  MTR</i>":"")."</td>
									<td class='negative'  style='text-align:right'><b>".($total_qc_scrap_weight!=0?number_format($total_qc_scrap_weight,2,'.',',')."</b><i> KGS</i>":"")."</td>
									<td class='negative'  style='text-align:right'><b>".($total_wip_scrap_meters!=0?number_format($total_wip_scrap_meters,2,'.',',')."</b><i> MTR</i>":"")."</td>
									<td class='negative'  style='text-align:right'><b>".($total_wip_scrap_weight!=0?number_format($total_wip_scrap_weight,2,'.',',')."</b><i> KGS</i>":"")."</td>

									 ";
									 						
									$sum_total_side_trim_waste+=$master_row->total_side_trim_waste; 	
									$sum_total_setup_weight+=$master_row->total_setup_weight;
									$sum_total_purging_weight+=$master_row->total_purging_weight;			

									$sum_total_qc_scrap_meters+=$total_qc_scrap_meters;
									$sum_total_qc_scrap_weight+=$total_qc_scrap_weight;
									$sum_total_wip_scrap_meters+=$total_wip_scrap_meters;
									$sum_total_wip_scrap_weight+=$total_wip_scrap_weight; 
								// $sum_total_ok_meters+=$master_row->total_ok_meters;
								// $sum_reels+=$master_row->total_ok_meters/$reel_length;
								// $sum_amount+=$master_row->amount;	

						}//master Foreach

					echo"<tr style='font-weight:bold; color:blue;'><td colspan='4' style='text-align:right;'><b>TOTAL</b></td>
					<td   style='text-align:right;'><b>".number_format($sum_total_side_trim_waste,2,'.',',')."</b> <i> KGS</i></td>
					<td   style='text-align:right;'><b>".number_format($sum_total_setup_weight,2,'.',',')."</b> <i> KGS</i></td> 
					<td style='text-align:right;'><b>".number_format($sum_total_purging_weight,2,'.',',')."</b> <i> KGS</i></td>
					<td  style='text-align:right;'><b>".number_format($sum_total_qc_scrap_meters,2,'.',',')."</b> <i> MTR</i></td> 
					<td  style='text-align:right;'><b>".number_format($sum_total_qc_scrap_weight,2,'.',',')."</b> <i> KGS</i></td>

					<td style='text-align:right;'><b>".number_format($sum_total_wip_scrap_meters,2,'.',',')."</b> <i> MTR</i></td> 
					<td style='text-align:right;'><b>".number_format($sum_total_wip_scrap_weight,2,'.',',')."</b> <i> KGS</i></td>
					
					</tr>";	

					}?>
				</tbody>				
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>

		
</form>
				
				
				
				
				
			