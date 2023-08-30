<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		
	    $("table tr").click(function(e){
	    	$("table tr").removeClass('on-hower');	
	        $(this).addClass('on-hower');
	    }); 

	    $("#tbl_data .td_wip_cost").each(function(){
			//alert($(this).html());
			//if($(this).html()==0){
				//$(this).parent("tr").css("background-color","pink");
				$(this).parent("tr").addClass("negative");
			//}

		})
	});
</script>

<style>
	.on-hower{
        background-color:#e4e4e4;
    }
	tr:hover {background-color:#e4e4e4;}
	th{text-align:center;border-top: 1px solid rgba(34,36,38,.1)}
</style>

<div class="record_form_design" style="width:90%;">	
<div class="middle_form_design">   
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
			<table class="ui sortable selectable celled table"  style="font-size:10px;" id="tbl_data" >
				
				<thead>
				<tr><th colspan="10"><a class="ui orange label">FILM SCRAP MONTHWISE</a> <?php echo ($this->input->post('from_date')!='' && $this->input->post('to_date') ? '<a class="ui olive label"><i class="calendar icon"></i>'.$this->input->post('from_date').'  TO '.$this->input->post('to_date').'</a>':'' )?>

				<?php 
				echo $this->input->get('from_date');
				
				 ?>

			</th></tr>	
					
				<tr>				
					<th>Sr no.</th>
					 
					<th>Month</th>
					<th>Dia</th>					
					<th>Microns</th>
					<!--<th>Second layer MB</th>
					<th>Sixth layer MB</th>	
					-->				
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

							 
								echo"<tr class='tr_test'>		
									<td >".$i++."</td>										
									<td>".$master_row->year."-".strtoupper(substr($master_row->month_name,0,3))."</td>
									<td>".$master_row->sleeve_dia."</td>
									<td>".$master_row->total_microns."</td>

									<td style='text-align:right'><b>".number_format($master_row->total_setup_weight,2,'.',',')."</b><i> KGS</i></td>
									<td style='text-align:right'><b>".number_format($master_row->total_purging_weight,2,'.',',')."</b><i> KGS</i></td>
									<td style='text-align:right'><b>".number_format($total_qc_scrap_meters,2,'.',',')."</b><i>MTR</i></td>
									<td style='text-align:right'><b>".number_format($total_qc_scrap_weight,2,'.',',')."</b><i>KGS</i></td>
									<td style='text-align:right'><b>".number_format($total_wip_scrap_meters,2,'.',',')."</b><i>MTR</i></td>
									<td style='text-align:right'><b>".number_format($total_wip_scrap_weight,2,'.',',')."</b><i>KGS</i></td>

									 ";
									 						
									 
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

					echo"<tr style='font-weight:bold;'><td colspan='4' style='text-align:right;'><b>TOTAL</b></td>
					<td   style='text-align:right;'><b>".number_format($sum_total_setup_weight,2,'.',',')."</b> <i> KGS</i></td> 
					<td class='positive' style='text-align:right;'><b>".number_format($sum_total_purging_weight,2,'.',',')."</b> <i> KGS</i></td>
					<td   style='text-align:right;'><b>".number_format($sum_total_qc_scrap_meters,2,'.',',')."</b> <i> MTR</i></td> 
					<td class='positive' style='text-align:right;'><b>".number_format($sum_total_qc_scrap_weight,2,'.',',')."</b> <i> KGS</i></td>

					<td   style='text-align:right;'><b>".number_format($sum_total_wip_scrap_meters,2,'.',',')."</b> <i> MTR</i></td> 
					<td class='positive' style='text-align:right;'><b>".number_format($sum_total_wip_scrap_weight,2,'.',',')."</b> <i> KGS</i></td>
					
					</tr>";	

					}?>
				</tbody>				
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>
</div>
