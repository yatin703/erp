<style>	
   tr:hover {background-color:#e4e4e4;} 
</style>
<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;"> 

<?php          
					
			echo '<table class="ui green sortable celled table"  style="font-size:9px">'; 
			echo'<thead>
				<tr>
					<thead>
					<th class="center aligned">Sr No</th>
					<th class="center aligned">Date</th>	
					<th class="center aligned">Customer</th>
					<th class="center aligned">Print type</th>									
					<th class="center aligned">Order No</th>					
					<th class="center aligned">Article No</th>
					<th class="center aligned">Dia</th>
					<th class="center aligned">Length</th>
					<th class="center aligned">Job Card No</th>	
              
               <th class="center aligned">Job_Order Quantity</th>	
               <th class="center aligned">Extrusion Qty</th>
               <th class="center aligned">Heading Qty</th> 
               <th class="center aligned">Printing Qty</th>
               <th class="center aligned">Capping Qty</th>
               <th class="center aligned">Foiling Qty</th> 
               <th class="center aligned">RFD Qty</th>
               <th class="center aligned">Dispatch Qty </th>
               </tr>
					</thead>';
					$i=1;

					foreach($springtube_printing_production_master as $master_row){  
					        	$heading_qty=0;
					        	$printing_qty=0;
					        	$capping_qty=0;
					         $foiling_qty=0;
					        	$rfd_qty=0;
					        	$dispatch_qty=0;
					        	$dia=0;
					        	$length=0;
					        	$a=$master_row->date;
								$convertDate = date("d-m-Y", strtotime($a));


					        	 $data['springtube_printing_production_heading']=$this->coex_process_wise_track_my_order_model->active_record_search_heading($master_row->so_no); 


                        $data['springtube_printing_production_printing']=$this->coex_process_wise_track_my_order_model->active_record_search_printing($master_row->so_no);  

                        
                         $data['springtube_printing_production_capping']=$this->coex_process_wise_track_my_order_model->active_record_search_capping($master_row->so_no); 


                         $data['springtube_printing_production_foiling']=$this->coex_process_wise_track_my_order_model->active_record_search_foiling($master_row->so_no); 

                         $data['springtube_printing_production_rfd']=$this->coex_process_wise_track_my_order_model->active_record_search_rfd($master_row->so_no);

                         $data['springtube_printing_production_dispatch']=$this->coex_process_wise_track_my_order_model->active_record_search_dispatch($master_row->so_no);  
                            
								echo "
									  <tr>
									  <td class='right aligned'>$i</td>
                             <td class='right aligned'>$convertDate</td>	
				                 <td>$master_row->customer</td>
				                 <td>$master_row->print_type</td>	
                             <td><a href='".base_url('index.php/sales_order_book/view/'.$master_row->so_no)."' target=_blank>".$master_row->so_no."</a></td>

									  <td class='right aligned'>$master_row->psp_psm_no</td> ";

									   foreach($data['springtube_printing_production_dispatch'] as $dispatch){  
					               	$dia=$dispatch->sleeve_dia;
					              		}
					              echo"<td class='right aligned'>$dia</td>";
					              "<br>";

					              foreach($data['springtube_printing_production_dispatch'] as $dispatch){  
					               	$length=$dispatch->sleeve_length;
					              		}
					              echo"<td class='right aligned'>$length</td>"; 
					              "<br>";

					              echo "<td class='right aligned'>$master_row->job_card_no</td>
					             
					              <td class='positive' style='text-align:right;'>".number_format($master_row->job_order_quantity)."</td>								
					              <td class='positive' style='text-align:right;'>".number_format($master_row->ext_qty)."</td>";

					               foreach($data['springtube_printing_production_heading'] as $rows){  
					               	$heading_qty=$rows->heading_qty;
					              		}
					              echo"<td class='negative' style='text-align:right;'>".number_format($heading_qty)."</td>";
					              "<br>";

					               foreach($data['springtube_printing_production_printing'] as $printing){  
					               	$printing_qty=$printing->printing_qty;
					              		}
					              echo"<td class='positive' style='text-align:right;'>".number_format($printing_qty)."</td>";
					              "<br>"; 
					              

					              foreach($data['springtube_printing_production_capping'] as $capping){  
					               	$capping_qty=$capping->capping_qty;
					              		}
					              echo"<td class='negative' style='text-align:right;'>".number_format($capping_qty)."</td>";
					              "<br>";

					             

					               foreach($data['springtube_printing_production_foiling'] as $foiling){  
					               	$foiling_qty=$foiling->foiling_qty;
					              		}
					              echo"<td class='positive' style='text-align:right;'>".number_format($foiling_qty)."</td>";
					              "<br>";


					              foreach($data['springtube_printing_production_rfd'] as $rfd){  
					               	$rfd_qty=$rfd->rfd_qty;
					              		}
					              echo"<td class='negative' style='text-align:right;'>".number_format($rfd_qty)."</td>";
					              "<br>";


					              foreach($data['springtube_printing_production_dispatch'] as $dispatch){  
					               	$dispatch_qty=$dispatch->arid_qty;
					              		}
					              echo"<td class='warning right aligned'>".number_format($dispatch_qty/100)."</td>";
					              "<br>";
                             "</tr>";
					               $i++;
					            }
					            echo"</table>";

									?>


			

				
				

