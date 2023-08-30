<script type="text/javascript">

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
	$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/capa');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#check").html(html);
				} 
			});
		});
	});
</script>
  

	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
									<?php 
									
									if($account_periods_master==FALSE){
										echo "<tr><td>PLEASE SET THE FISCAL YEAR</td>";
									}else{
									foreach ($account_periods_master as $account_periods_master_row ):?>
									<tr>
										<td class="label"  width="25%">From Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="from_date" class="from_date" value="<?php echo set_value('from_date',date('Y-m-01'));?>"/></td>
										<td class="label"  width="25%">To Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="to_date" class="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
									<?php endforeach;
										}?>
									
								
									<tr>
										<td>
											<div class="ui buttons">
										  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
										  		<div class="or"></div>
										  		<button class="ui positive button" id="search">Search</button>
											</div>
										</td>
									</tr>
					</table>
				</td>
				<td>
				</td>
			</tr>
		</table>
					
	</div>

	
	


<div class="record_form_design">
	<div class="record_inner_design" style="overflow: scroll;">
		<div class="row">
			<div class="column">
				<span id="check">
					<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($capa==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:12px;">
					        	<thead>
								   <tr>
								    	<th colspan="16"><a class="ui orange label">CAPA MIS</a>';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			$from_date=$account_periods_master_row->fin_year_start;
								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date(date('Y-m-01'),$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
								    		}
								    	}
								    	echo '</th>
								  </tr>
								  	<tr>
								  		<th colspan="3"></th>
								  		<th class="center aligned" colspan="6">NO OF COMPLAINTS</th>
								  		<th class="center aligned" colspan="4">CAPA COMPLETED YTD</th>
								  	</tr>
								  	

					        		<tr>
					        			<th>SR NO</th>
					        			<th>CATEGORY</th>
					        			<th class="center aligned">COMPLAINTS</th>
					        			<th colspan="2" class="center aligned">'.strtoupper(date("M Y")).'</th>
					        			<th colspan="2" class="center aligned">YTD</th>
					        			<th colspan="2" class="center aligned">PREVIOUS YEAR</th>
					        			<th colspan="2" class="center aligned">YES</th>
					        			<th colspan="2" class="center aligned">NO</th>
					        		</tr>

					        		<tr>
					        			<th></th>
					        			<th></th>
					        			<th class="center aligned"></th>
					        			<th class="center aligned">External</th>
					        			<th class="center aligned">Internal</th>

					        			<th class="center aligned">External</th>
					        			<th class="center aligned">Internal</th>
					        			<th class="center aligned">External</th>
					        			<th class="center aligned">Internal</th>
					        			
					        			<th class="center aligned">External</th>
					        			<th class="center aligned">Internal</th>
					        			<th class="center aligned">External</th>
					        			<th class="center aligned">Internal</th>

					        		</tr>

					        	</thead>';
					        	$i=1;
					        	$month=0;
					        	$month_internal=0;
					        	$ytd=0;

					        	$ytd_internal=0;
					        	$pytd=0;
					        	$pytd_internal=0;
					        	$completed_yes_month=0;
					        	$completed_yes_month_internal=0;
					        	$completed_no_month=0;	
					        	$completed_no_month_internal=0;				        	
					foreach($capa as $capa_row){
						echo "<tr>
								<td>$i</td>
								<td>$capa_row->category</td>
								<td>".strtoupper($capa_row->complaints)."</td>								
								<td class='center aligned'>".$this->complaint_register_model->capa_mis_date(date('Y-m-01'),date('Y-m-d'),$capa_row->complaints)."</td>
								<td class='center aligned'>".$this->complaint_register_model->internal_capa_mis_date(date('Y-m-01'),date('Y-m-d'),$capa_row->complaints)."</td>

								<td class='center aligned'>".$this->complaint_register_model->capa_mis_date($from_date,date('Y-m-d'),$capa_row->complaints)."</td>

								<td class='center aligned'>".$this->complaint_register_model->internal_capa_mis_date($from_date,date('Y-m-d'),$capa_row->complaints)."</td>

								<td class='center aligned'>".$this->complaint_register_model->capa_mis_date('2021-04-01','2022-03-31',$capa_row->complaints)."</td>
								<td class='center aligned'>".$this->complaint_register_model->internal_capa_mis_date('2021-04-01','2022-03-31',$capa_row->complaints)."</td>
								<td class='center aligned'>".($this->complaint_register_model->capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'YES')==0 ? '' : $this->complaint_register_model->capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'YES'))."</td>
								<td class='center aligned'>".($this->complaint_register_model->internal_capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'YES')==0 ? '' : $this->complaint_register_model->internal_capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'YES'))."</td>

								<td class='center aligned'>".($this->complaint_register_model->capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'NO')==0 ? '' : $this->complaint_register_model->capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'NO'))."</td>

								<td class='center aligned'>".($this->complaint_register_model->internal_capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'NO')==0 ? '' : $this->complaint_register_model->internal_capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'NO'))."</td>
					        </tr>";
					        $i++;

					        
					        $month+=$this->complaint_register_model->capa_mis_date(date('Y-m-01'),date('Y-m-d'),$capa_row->complaints);
					        $month_internal+=$this->complaint_register_model->internal_capa_mis_date(date('Y-m-01'),date('Y-m-d'),$capa_row->complaints);
					        $ytd+=$this->complaint_register_model->capa_mis_date($from_date,date('Y-m-d'),$capa_row->complaints);
					        $ytd_internal+=$this->complaint_register_model->internal_capa_mis_date($from_date,date('Y-m-d'),$capa_row->complaints);
					        $pytd+=$this->complaint_register_model->capa_mis_date('2021-04-01','2022-03-31',$capa_row->complaints);
					        $pytd_internal+=$this->complaint_register_model->internal_capa_mis_date('2021-04-01','2022-03-31',$capa_row->complaints);
					       	$completed_yes_month+=$this->complaint_register_model->capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'YES');
					       	$completed_yes_month_internal+=$this->complaint_register_model->internal_capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'YES');
					       	$completed_no_month+=$this->complaint_register_model->capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'NO');

					       	$completed_no_month_internal+=$this->complaint_register_model->internal_capa_mis_complete($from_date,date('Y-m-d'),$capa_row->complaints,'NO');
					       
					       }
					    echo "<thead>
							    <tr>
							    	<th colspan='3'>TOTAL</th>
							    	<th class='center aligned'>".$month."</th>
							    	<th class='center aligned'>".$month_internal."</th>
							    	<th class='center aligned'>".$ytd."</th>

							    	<th class='center aligned'>".$ytd_internal."</th>
							    	<th class='center aligned'>".$pytd."</th>
							    	<th class='center aligned'>".$pytd_internal."</th>
							    	<th class='center aligned'>".$completed_yes_month."</th>
							    	<th class='center aligned'>".$completed_yes_month_internal."</th>
							    	
							    	<th class='center aligned'>".$completed_no_month."</th>
							    	<th class='center aligned'>".$completed_no_month_internal."</th>
							    </tr>
							  </thead>";

						echo '</table>';

					}
				?>
				
				

				</span>

			</div>
  		</div>
		

	

	</div>
</div>