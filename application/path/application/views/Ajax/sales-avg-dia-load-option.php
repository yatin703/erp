

	
	

					<?php

					//echo $from_date;
					setlocale(LC_MONETARY, 'en_IN');
				
					if($sales_avg_dia==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								    <tr>
								    	<th colspan="10"><a class="ui orange label">SALES AVG DIA</a>'.($customer_name!=''?'<a class="ui blue label">'.$customer_name.'</a>':'');						    	

								    	echo '<a class="ui olive label"><i class="calendar icon"></i>'.date('d-M',strtotime($this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']))).' TO '.date('d-M',strtotime($this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']))).'</a> <a class="ui green label">LAST 3 YEAR</a>';
								    	
								    	echo '</th>
								    </tr>
								    <tr>
								    	<th style="text-align:center;">';

								    		echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a>';
								    	
								    	echo'</th>
					        			
					        			<th style="text-align:center;">';

					        				echo'<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date( date("Y-m-d", strtotime("-1 year", strtotime($from_date))),$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date("Y-m-d", strtotime("-1 year", strtotime($to_date))),$this->session->userdata['logged_in']['company_id']).'</a>';
					        			

					        			echo'</th>
					        			<th style="text-align:center;">';	        			

					        					echo'<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date( date("Y-m-d", strtotime("-2 year", strtotime($from_date))),$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date("Y-m-d", strtotime("-2 year", strtotime($to_date))),$this->session->userdata['logged_in']['company_id']).'</a>';
					        			
					        			echo'</th>

					        	    </tr>					        	    
					        	</thead>
					        <tbody>
					        	<tr>

					        		<!---------------Currrent Year--------------------->
					        		<td> 
					        			<table class="ui sortable selectable celled table">
									 		<thead>
									 		<tr>        			
							        			<th>DIA</th>					        			
							        			<th class="right aligned">SALES QTY</th>
							        			<th class="right aligned">DIA X VOLUME</th>

									        </tr>
									        </thead>
									        <tbody>';

									        	$total_qty=0;
									        	$total_volume=0;
											foreach ($sales_avg_dia as $key => $row) {			
											
												echo'<tr>																	
													<td><b>'.$row->sleeve_diameter.'</b></td>
													<td class="right aligned">'.money_format('%!.0n',$row->qty).'</td>
													<td class="right aligned">'.money_format('%!.0n',$row->dia_volume).'</td>
													</tr>';
												$total_qty+=$row->qty;
												$total_volume+=$row->dia_volume;
												
											}


										echo'<tr>
												<td><b>TOTAL</b></td>
												<td class="right aligned">'.money_format('%!.0n',$total_qty).'</td>
												<td class="right aligned">'.money_format('%!.0n',$total_volume).'</td>
												</tr>

												<tr>
												<td><b>AVG DIA</b></td>
												<td class="right aligned"><a class="ui black label">'.($total_volume!='' ? money_format('%!.0n',$total_volume/$total_qty) : '-').'</a></td>
												<td class="right aligned"></td>
												</tr>
											</tbody>
										</table> 
									</td>
									<!---------------LAST Year--------------------->
									<td>
					        			<table class="ui sortable selectable celled table">
									 		<thead>
									 		<tr>        			
							        			<!--<th>DIA</th>-->					        			
							        			<th class="right aligned">SALES QTY</th>
							        			<th class="right aligned">DIA X VOLUME</th>

									        </tr>
									        </thead>
									        <tbody>';

									        	$total_qty=0;
									        	$total_volume=0;
											foreach ($sales_avg_dia_last_year as $key => $row) {
											
												echo'<tr>																	
													<!--<td>'.$row->sleeve_diameter.'</td>-->
													<td class="right aligned">'.money_format('%!.0n',$row->qty).'</td>
													<td class="right aligned">'.money_format('%!.0n',$row->dia_volume).'</td>';

												echo'</tr>';

												$total_qty+=$row->qty;
												$total_volume+=$row->dia_volume;
											}


										echo'<tr>
												<td class="right aligned">'.money_format('%!.0n',$total_qty).'</td>
												<td class="right aligned">'.money_format('%!.0n',$total_volume).'</td>
												</tr>

												<tr>
												<td class="right aligned"><a class="ui black label">'.($total_volume!='' ? money_format('%!.0n',$total_volume/$total_qty) : '-').'</a></td>
												<td class="right aligned"></td>
												</tr></tbody>
										</table> 
									</td>

									<!---------------LAST 2 Years--------------------->
									<td>
					        			<table class="ui sortable selectable celled table">
									 		<thead>
									 		<tr>        			
							        			<!--<th>DIA</th>-->					        			
							        			<th class="right aligned">SALES QTY</th>
							        			<th class="right aligned">DIA X VOLUME</th>

									        </tr>
									        </thead>
									        <tbody>';
									        	$total_qty=0;
									        	$total_volume=0;
											foreach ($sales_avg_dia_prev_year as $key => $row) {	
											
												echo'<tr>																	
													<!--<td>'.$row->sleeve_diameter.'</td>-->
													<td class="right aligned">'.money_format('%!.0n',$row->qty).'</td>
													<td class="right aligned">'.money_format('%!.0n',$row->dia_volume).'</td>';

												echo'</tr>';

												$total_qty+=$row->qty;
												$total_volume+=$row->dia_volume;
											}


										echo'<tr>
												<td class="right aligned">'.money_format('%!.0n',$total_qty).'</td>
												<td class="right aligned">'.money_format('%!.0n',$total_volume).'</td>
												</tr>

												<tr>
												<td class="right aligned"><a class="ui black label">'.($total_volume!='' ? money_format('%!.0n',$total_volume/$total_qty) : '-').'</a></td>
												<td class="right aligned"></td>
												</tr>
												</tbody>
										</table> 
									</td>
								</tr>
							</tbody>
							</table>';
						

					}
				?>
				

