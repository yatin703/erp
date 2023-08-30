<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($capa==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:12px;">
					        	<thead>
								   <tr>
								    	<th colspan="16"><a class="ui orange label">CAPA</a>';

								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
								    	
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
					        			<th class="left aligned">COMPLAINTS</th>
					        			<th  colspan="2" class="center aligned">MONTH</th>
					        			<th  colspan="2" class="center aligned">YTD</th>
					        			<th  colspan="2" class="center aligned">PREVIOUS YEAR</th>
					        			<th  colspan="2" class="center aligned">YES</th>
					        			<th  colspan="2" class="center aligned">NO</th>
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

					       if($account_periods_master==FALSE){
							}else{
								foreach ($account_periods_master as $account_periods_master_row ){
								   $ytd_from_date=$account_periods_master_row->fin_year_start;
								   $ytd_end_date=$account_periods_master_row->fin_year_end;
								}
							}


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
								<td class='aligned' >".strtoupper($capa_row->complaints)."</td>								
								<td class='center aligned' >".$this->complaint_register_model->capa_mis_date($from_date,$to_date,$capa_row->complaints)."</td>
								<td class='center aligned' >".$this->complaint_register_model->internal_capa_mis_date($from_date,$to_date,$capa_row->complaints)."</td>

								<td class='center aligned' >".$this->complaint_register_model->capa_mis_date($ytd_from_date,$ytd_end_date,$capa_row->complaints)."</td>
								<td class='center aligned' >".$this->complaint_register_model->internal_capa_mis_date($ytd_from_date,$ytd_end_date,$capa_row->complaints)."</td>

								<td class='center aligned' >".$this->complaint_register_model->capa_mis_date('2021-04-01','2022-03-31',$capa_row->complaints)."</td>
								<td class='center aligned' >".$this->complaint_register_model->internal_capa_mis_date('2021-04-01','2022-03-31',$capa_row->complaints)."</td>

								<td class='center aligned' >".($this->complaint_register_model->capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'YES')==0 ? '' : $this->complaint_register_model->capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'YES'))."</td>

								<td class='center aligned' >".($this->complaint_register_model->internal_capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'YES')==0 ? '' : $this->complaint_register_model->internal_capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'YES'))."</td>

								<td class='center aligned' >".($this->complaint_register_model->capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'NO')==0 ? '' : $this->complaint_register_model->capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'NO'))."</td>
								<td class='center aligned' >".($this->complaint_register_model->internal_capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'NO')==0 ? '' : $this->complaint_register_model->internal_capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'NO'))."</td>
					        </tr>";


					        $i++;
					        $month+=$this->complaint_register_model->capa_mis_date($from_date,$to_date,$capa_row->complaints);
					        $month_internal+=$this->complaint_register_model->internal_capa_mis_date($from_date,$to_date,$capa_row->complaints);
					        $ytd+=$this->complaint_register_model->capa_mis_date($ytd_from_date,$ytd_end_date,$capa_row->complaints);
					        $ytd_internal+=$this->complaint_register_model->internal_capa_mis_date($ytd_from_date,$ytd_end_date,$capa_row->complaints);
					        $pytd+=$this->complaint_register_model->capa_mis_date('2021-04-01','2022-03-31',$capa_row->complaints);
					        $pytd_internal+=$this->complaint_register_model->internal_capa_mis_date('2021-04-01','2022-03-31',$capa_row->complaints);
					       	$completed_yes_month+=$this->complaint_register_model->capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'YES');
					       	$completed_yes_month_internal+=$this->complaint_register_model->internal_capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'YES');
					       	$completed_no_month+=$this->complaint_register_model->capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'NO');
					       	$completed_no_month_internal+=$this->complaint_register_model->internal_capa_mis_complete($ytd_from_date,$ytd_end_date,$capa_row->complaints,'NO');

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
				
				
