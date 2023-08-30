
					<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($pending_sales_order==FALSE){

					}else{
						echo '<table class="ui selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="7"><a class="ui orange label">CAP FORECAST BY CAP CODE </a>
								    	<a class="ui green label">PENDING ORDER '.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '').'</th>
								  </tr>
					        		<tr>
					        			<th>SR NO</th>

					        			<th width="40%">CAP CODE</th>
					        			
					        			<th colspan="2" class="center aligned">CUSTOMER</th>
					        			<th class="right aligned">PENDING ORDER</th>
					        			<th class="right aligned">PENDING ORDER + TOLERANCE</th>
					        			
					        		</tr>
					        	</thead>';
					
					 $count=1;

					 $total_received_quantity=0;

					 $total_dispached_quantity=0;

					 $total_pending_quantity=0;

					 $total_pending_quantity_with_tolerence=0;

					foreach($pending_sales_order as $coex_order_row){


						?><script>
							$(document).ready(function(){
								//$(".tr_<?php echo $count;?>").css("display","none");

								$("#id_<?php echo $count;?>").on("click", function(){
									$(".tr_<?php echo $count;?>").slideToggle();
								    $("#idd_<?php echo $count;?>").toggleClass('plus circle icon');
								    $("#idd_<?php echo $count;?>").toggleClass('minus circle icon');
								});
							//alert(1);

							});

						</script>
						<?php 
							$customer_wise=$this->sales_order_book_model->pending_sales_order_by_customer_group_with_cap($from_date,$to_date,$coex_order_row->cap_code);
							$d=0;
							$total_d=0;
						        if($customer_wise==TRUE){
								foreach($customer_wise as $customer_wise_row){
									$d=($customer_wise_row->dis_tolerance<>'' ? ($customer_wise_row->order_p+(($customer_wise_row->order_p/100)*$customer_wise_row->dis_tolerance)) : $customer_wise_row->order_p);
									$total_d+=$d;
								}
							}
						
						echo "<tr  class='positive' style='font-size:11px;' id='id_".$count."'>
								<td><b>$count</b></td>

								<td><b>".($coex_order_row->cap_code<>'' ? strtoupper($coex_order_row->cap_code) : "TEAR OFF - NO CAP")."</b></td>
								<td><i id='idd_".$count."' class='minus circle icon'></i></td>
								<td></td>";
								
								//<td class='right aligned'>".money_format('%!.0n',$coex_order_row->order_dispached)."</td>
								//<td class='right aligned'>".money_format('%!.0n',$coex_order_row->order_received)."</td>
						echo    "<td class='right aligned'><b>".money_format('%!.0n',$coex_order_row->order_pending)."</b></td>
								<td class='right aligned'><b>".money_format('%!.0n',$total_d)."</b></td>
					        </tr>";
					       	

							$customer_wise=$this->sales_order_book_model->pending_sales_order_by_customer_group_with_cap($from_date,$to_date,$coex_order_row->cap_code);
					        if($customer_wise==TRUE){
							foreach($customer_wise as $customer_wise_row){
								echo "<tr class='tr_".$count."'>
									<td></td>
									<td>".$this->common_model->get_article_name($coex_order_row->cap_code,$this->session->userdata['logged_in']['company_id'])."</td>
									<td><b>".($customer_wise_row->dis_tolerance<>'' ? $customer_wise_row->dis_tolerance."%" : '')."</b></td>
									<td><b>".$customer_wise_row->customer."</b></td>
									";

									//<td class='right aligned'>".money_format('%!.0n',$customer_wise_row->order_r)."</td>
									//<td class='right aligned'>".money_format('%!.0n',$customer_wise_row->order_d)."</td>
								echo "<td class='right aligned'>".money_format('%!.0n',$customer_wise_row->order_p)."</td>
								<td class='right aligned'>".$a=($customer_wise_row->dis_tolerance<>'' ? money_format('%!.0n',($customer_wise_row->order_p+(($customer_wise_row->order_p/100)*$customer_wise_row->dis_tolerance))) : money_format('%!.0n',$customer_wise_row->order_p))."</td>
								</tr>";
								}
							}else{
							}

					        $total_received_quantity+=$coex_order_row->order_received;

					        $total_dispached_quantity+=$coex_order_row->order_dispached;

					        $total_pending_quantity+=$coex_order_row->order_pending;

					        $total_pending_quantity_with_tolerence+=$total_d;

					        $count++;
					    }




					    echo "<thead>
							    <tr>
							    	<th colspan='4'>GRAND TOTAL</th>";
							    	//<th class='right aligned'>".money_format('%!.0n',$total_received_quantity)."</th>
							    	//<th class='right aligned'>".money_format('%!.0n',$total_dispached_quantity)."</th>
							echo "<th class='right aligned'>".money_format('%!.0n',$total_pending_quantity)."</th>
							<th class='right aligned'>".money_format('%!.0n',$total_pending_quantity_with_tolerence)."</th>
							  	</tr>
							  </thead>";

						echo '</table>';

					}
				?>


			