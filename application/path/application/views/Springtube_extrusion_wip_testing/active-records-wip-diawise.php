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

<div class="middle_form_design">   
<div class="record_form_design" style="width:90%;">	
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
			<table class="ui sortable selectable celled table"  style="font-size:10px;" id="tbl_data" >
				
				<thead>
				<tr><th colspan="9"><a class="ui orange label">WIP MONTHWISE</a> <?php echo ($this->input->post('from_date')!='' && $this->input->post('to_date') ? '<a class="ui olive label"><i class="calendar icon"></i>'.$this->input->post('from_date').'  TO '.$this->input->post('to_date').'</a>':'' )?>

				<?php 
				echo $this->input->get('from_date');
				
				 ?>

			</th></tr>	
					
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
									<td class='positive right aligned'><b> &#x20B9; ".money_format('%!.0n',$master_row->amount)."</b></td>
									<td class='positive right aligned'><b> &#x20B9; ".money_format('%!.0n',$master_row->amount/$master_row->total_ok_meters)."</b></td>";
									 						
									 

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
