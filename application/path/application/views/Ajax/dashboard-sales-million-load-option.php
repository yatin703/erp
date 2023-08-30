<script>
	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();

		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/dashboard_sales');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),convert:$('.convert').val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);

				$("#check").html(html);
				} 
			});
		});

		$(".toggler").click(function(e){
        e.preventDefault();
        $('.cat'+$(this).attr('data-prod-cat')).toggle();
		});

		
});

</script>

<div class="record_form_design">
	<div class="record_inner_design">

		<div class="ui equal width grid">
		  <div class="equal width row">
		    <div class="column">

		    	<div class="ui red segments">
		    		<div class="ui red segment">
					    <p><a  class="ui orange label">OVERVIEW</a><a class="ui olive label"><i class="calendar icon"></i><?php echo date('d M y',strtotime($from_date));?> TO <?php echo date('d M y',strtotime($to_date));?></a></p>
					</div>
					<div class="ui segment">
						<table class="ui very basic collapsing celled table"  style="font-size:10px;">
						  <thead>
						    <tr>
						    	<th>MONTH</th>
						    	<th>SALES VOLUME</th>
						    	<th>PRINTING VOLUME</th>
						    	<th>NET SALES</th>
						    	<th>AVG PRICE</th>
						    	<th>CONTR</th>
						    	<th>AVG CONTR</th>
						  </tr></thead>
						  <tbody>
						    <tr>
						      <td><b><?php echo strtoupper(date('M y',strtotime($from_date)));?></b></td>
						      <td><?php 
						      setlocale(LC_MONETARY, 'en_IN');
						      	$march=0;
						      	$total_total_print_type_sales_quantity=0;
							    $total_total_print_type_sales_value=0;
							    $total_total_print_type_sales_avg=0;
						      	if($print_type_wise_sales_coex==FALSE){}else{
						      	$total_screen_flexo_quantity=0;
						      	$total_screen_flexo_value=0;
							    $total_offset_quantity=0;
							    $total_offset_value=0;
							    $total_label_quantity=0;
							    $total_label_value=0;
							    $total_digital_quantity=0;
							    $total_digital_value=0;
							    
						      	foreach($print_type_wise_sales_coex as $row_coex){
						      		$total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO;
							       	$total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_VALUE;
							       	$total_offset_quantity+=$row_coex->OFFSET;
							       	$total_offset_value+=$row_coex->OFFSET_VALUE;
							       	$total_label_quantity+=$row_coex->LABEL;
							       	$total_label_value+=$row_coex->LABEL_VALUE;
							       	$total_digital_quantity+=$row_coex->DIGITAL;
							       	$total_digital_value+=$row_coex->DIGITAL_VALUE;
						      	}
						      	$total_total_print_type_sales_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity+$total_digital_quantity;
							    $total_total_print_type_sales_value=$total_screen_flexo_value+$total_offset_value+$total_label_value+$total_digital_value;
							    $total_total_print_type_sales_avg=($total_total_print_type_sales_value<>0 ? ($total_total_print_type_sales_value/$total_total_print_type_sales_quantity) : 0);

							    echo $this->common_model->read_number_million($total_total_print_type_sales_quantity);

						      } 
						      $total_total_print_type_sales_quantity=$march;
						      ?>

						     </td>
						     <td><?php if($printing==FALSE){ }else{
						      	 $total_moss_offset=0;
								 $total_bonmac_offset=0;
								 $total_polytype_offset=0;
								 $total_polytype_lac=0;
								 $total_isimat_screen=0;
								 $total_isimat_flexo=0;
								 $total_isimat_flexo_2=0;
								 $total_printing=0;
						      	foreach($printing as $row){
									$total_row_printing=0;
									$total_row_printing=$row->MOSS_OFFSET_SUM+$row->BONMAC_OFFSET_SUM+$row->POLYTYPE_OFFSET_SUM+$row->POLYTYPE_LAC_SUM+$row->ISIMAT_SCREEN_SUM+$row->ISIMAT_FLEXO_SUM+$row->ISIMAT_FLEXO_2_SUM;
									
								    $total_printing+=$total_row_printing;
						      	}
						      	echo $this->common_model->read_number_million($total_printing);

						      } ?></td>
						    <td><?php echo $this->common_model->read_number_million($total_total_print_type_sales_value);?></td>
						    <td><?php echo "&#8377;".number_format($total_total_print_type_sales_avg,2,'.','');?></td>
						    <td></td>
						    <td></td>
						    </tr>

						    <tr>
						      <td><b><?php echo strtoupper(date('M y',strtotime("-1 month",strtotime($from_date))));?></b></td>
						      <td><?php $feb=0;
						      	$total_total_print_type_sales_quantity=0;
							    $total_total_print_type_sales_value=0;
							    $total_total_print_type_sales_avg=0;
						      if($print_type_wise_sales_coex_last_month==FALSE){}else{
						      	$total_screen_flexo_quantity=0;
						      	$total_screen_flexo_value=0;
							    $total_offset_quantity=0;
							    $total_offset_value=0;
							    $total_label_quantity=0;
							    $total_label_value=0;
							    $total_digital_quantity=0;
							    $total_digital_value=0;
							    
						      	foreach($print_type_wise_sales_coex_last_month as $row_coex){
						      		$total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO;
							       	$total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_VALUE;
							       	$total_offset_quantity+=$row_coex->OFFSET;
							       	$total_offset_value+=$row_coex->OFFSET_VALUE;
							       	$total_label_quantity+=$row_coex->LABEL;
							       	$total_label_value+=$row_coex->LABEL_VALUE;
							       	$total_digital_quantity+=$row_coex->DIGITAL;
							       	$total_digital_value+=$row_coex->DIGITAL_VALUE;
						      	}
						      	$total_total_print_type_sales_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity+$total_digital_quantity;
							    $total_total_print_type_sales_value=$total_screen_flexo_value+$total_offset_value+$total_label_value+$total_digital_value;
							    $total_total_print_type_sales_avg=($total_total_print_type_sales_value<>0 ? ($total_total_print_type_sales_value/$total_total_print_type_sales_quantity) : 0);

							    echo $this->common_model->read_number_million($total_total_print_type_sales_quantity);
								} 
								$feb=$total_total_print_type_sales_quantity;
								?>

						     </td>
						     <td><?php if($printing_last_month==FALSE){

						      }else{
						      	 $total_moss_offset=0;
								 $total_bonmac_offset=0;
								 $total_polytype_offset=0;
								 $total_polytype_lac=0;
								 $total_isimat_screen=0;
								 $total_isimat_flexo=0;
								 $total_isimat_flexo_2=0;
								 $total_printing=0;
						      	foreach($printing_last_month as $row){
									$total_row_printing=0;
									$total_row_printing=$row->MOSS_OFFSET_SUM+$row->BONMAC_OFFSET_SUM+$row->POLYTYPE_OFFSET_SUM+$row->POLYTYPE_LAC_SUM+$row->ISIMAT_SCREEN_SUM+$row->ISIMAT_FLEXO_SUM+$row->ISIMAT_FLEXO_2_SUM;
									
								    $total_printing+=$total_row_printing;
						      	}
						      	echo $this->common_model->read_number_million($total_printing);

						      } ?></td>
						    <td><?php echo $this->common_model->read_number_million($total_total_print_type_sales_value);?></td>

							<td><?php echo "&#8377;".number_format($total_total_print_type_sales_avg,2,'.','');?></td>
							<td></td>
							<td></td>
							</tr>


							<tr>
						      <td><b><?php echo strtoupper(date('M y',strtotime("-2 month",strtotime($from_date))));?></b></td>
						      <td><?php $jan=0;
						      	$total_total_print_type_sales_quantity=0;
							    $total_total_print_type_sales_value=0;
							    $total_total_print_type_sales_avg=0;
						      if($print_type_wise_sales_coex_2ndlast_month==FALSE){}else{
						      	$total_screen_flexo_quantity=0;
						      	$total_screen_flexo_value=0;
							    $total_offset_quantity=0;
							    $total_offset_value=0;
							    $total_label_quantity=0;
							    $total_label_value=0;
							    $total_digital_quantity=0;
							    $total_digital_value=0;
							    
						      	foreach($print_type_wise_sales_coex_2ndlast_month as $row_coex){
						      		$total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO;
							       	$total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_VALUE;
							       	$total_offset_quantity+=$row_coex->OFFSET;
							       	$total_offset_value+=$row_coex->OFFSET_VALUE;
							       	$total_label_quantity+=$row_coex->LABEL;
							       	$total_label_value+=$row_coex->LABEL_VALUE;
							       	$total_digital_quantity+=$row_coex->DIGITAL;
							       	$total_digital_value+=$row_coex->DIGITAL_VALUE;
						      	}
						      	$total_total_print_type_sales_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity+$total_digital_quantity;
							    $total_total_print_type_sales_value=$total_screen_flexo_value+$total_offset_value+$total_label_value+$total_digital_value;
							    $total_total_print_type_sales_avg=($total_total_print_type_sales_value<>0 ? ($total_total_print_type_sales_value/$total_total_print_type_sales_quantity) : 0);

							    echo $this->common_model->read_number_million($total_total_print_type_sales_quantity);
								} 
								$jan=$total_total_print_type_sales_quantity;
								?>

						     </td>
						     <td><?php if($printing_2ndlast_month==FALSE){

						      }else{
						      	 $total_moss_offset=0;
								 $total_bonmac_offset=0;
								 $total_polytype_offset=0;
								 $total_polytype_lac=0;
								 $total_isimat_screen=0;
								 $total_isimat_flexo=0;
								 $total_isimat_flexo_2=0;
								 $total_printing=0;
						      	foreach($printing_2ndlast_month as $row){
									$total_row_printing=0;
									$total_row_printing=$row->MOSS_OFFSET_SUM+$row->BONMAC_OFFSET_SUM+$row->POLYTYPE_OFFSET_SUM+$row->POLYTYPE_LAC_SUM+$row->ISIMAT_SCREEN_SUM+$row->ISIMAT_FLEXO_SUM+$row->ISIMAT_FLEXO_2_SUM;
									
								    $total_printing+=$total_row_printing;
						      	}
						      	echo $this->common_model->read_number_million($total_printing);

						      } ?></td>
						    <td><?php echo $this->common_model->read_number_million($total_total_print_type_sales_value);?></td>

							<td><?php echo "&#8377;".round($total_total_print_type_sales_avg,2);?></td>
							<td></td>
							<td></td>
							</tr>

							<tr>
						      <td><b><?php echo strtoupper(date('M y',strtotime("-3 month",strtotime($from_date))));?></b></td>
						      <td><?php $jan=0;
						      	$total_total_print_type_sales_quantity=0;
							    $total_total_print_type_sales_value=0;
							    $total_total_print_type_sales_avg=0;
						      if($print_type_wise_sales_coex_3rdlast_month==FALSE){}else{
						      	$total_screen_flexo_quantity=0;
						      	$total_screen_flexo_value=0;
							    $total_offset_quantity=0;
							    $total_offset_value=0;
							    $total_label_quantity=0;
							    $total_label_value=0;
							    $total_digital_quantity=0;
							    $total_digital_value=0;
							    
						      	foreach($print_type_wise_sales_coex_3rdlast_month as $row_coex){
						      		$total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO;
							       	$total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_VALUE;
							       	$total_offset_quantity+=$row_coex->OFFSET;
							       	$total_offset_value+=$row_coex->OFFSET_VALUE;
							       	$total_label_quantity+=$row_coex->LABEL;
							       	$total_label_value+=$row_coex->LABEL_VALUE;
							       	$total_digital_quantity+=$row_coex->DIGITAL;
							       	$total_digital_value+=$row_coex->DIGITAL_VALUE;
						      	}
						      	$total_total_print_type_sales_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity+$total_digital_quantity;
							    $total_total_print_type_sales_value=$total_screen_flexo_value+$total_offset_value+$total_label_value+$total_digital_value;
							    $total_total_print_type_sales_avg=($total_total_print_type_sales_value<>0 ? ($total_total_print_type_sales_value/$total_total_print_type_sales_quantity) : 0);

							    echo $this->common_model->read_number_million($total_total_print_type_sales_quantity);
								} 
								$jan=$total_total_print_type_sales_quantity;
								?>

						     </td>
						     <td><?php if($printing_3rdlast_month==FALSE){

						      }else{
						      	 $total_moss_offset=0;
								 $total_bonmac_offset=0;
								 $total_polytype_offset=0;
								 $total_polytype_lac=0;
								 $total_isimat_screen=0;
								 $total_isimat_flexo=0;
								 $total_isimat_flexo_2=0;
								 $total_printing=0;
						      	foreach($printing_3rdlast_month as $row){
									$total_row_printing=0;
									$total_row_printing=$row->MOSS_OFFSET_SUM+$row->BONMAC_OFFSET_SUM+$row->POLYTYPE_OFFSET_SUM+$row->POLYTYPE_LAC_SUM+$row->ISIMAT_SCREEN_SUM+$row->ISIMAT_FLEXO_SUM+$row->ISIMAT_FLEXO_2_SUM;
									
								    $total_printing+=$total_row_printing;
						      	}
						      	echo $this->common_model->read_number_million($total_printing);

						      } ?></td>
						    <td><?php echo $this->common_model->read_number_million($total_total_print_type_sales_value);?></td>

							<td><?php echo "&#8377;".number_format($total_total_print_type_sales_avg,2,'.','');?></td>
							<td></td>
							<td></td>
							</tr>


							<tr>
						      <td><b>TOTAL YEAR</b></td>
						      <td><?php $nov=0;
						      	$total_total_print_type_sales_quantity=0;
							    $total_total_print_type_sales_value=0;
							    $total_total_print_type_sales_avg=0;
						      if($print_type_wise_sales_coex_total_year==FALSE){}else{
						      	$total_screen_flexo_quantity=0;
						      	$total_screen_flexo_value=0;
							    $total_offset_quantity=0;
							    $total_offset_value=0;
							    $total_label_quantity=0;
							    $total_label_value=0;
							    $total_digital_quantity=0;
							    $total_digital_value=0;
							    
						      	foreach($print_type_wise_sales_coex_total_year as $row_coex){
						      		$total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO;
							       	$total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_VALUE;
							       	$total_offset_quantity+=$row_coex->OFFSET;
							       	$total_offset_value+=$row_coex->OFFSET_VALUE;
							       	$total_label_quantity+=$row_coex->LABEL;
							       	$total_label_value+=$row_coex->LABEL_VALUE;
							       	$total_digital_quantity+=$row_coex->DIGITAL;
							       	$total_digital_value+=$row_coex->DIGITAL_VALUE;
						      	}
						      	$total_total_print_type_sales_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity+$total_digital_quantity;
							    $total_total_print_type_sales_value=$total_screen_flexo_value+$total_offset_value+$total_label_value+$total_digital_value;
							    $total_total_print_type_sales_avg=($total_total_print_type_sales_value<>0 ? ($total_total_print_type_sales_value/$total_total_print_type_sales_quantity) : 0);

							    echo $this->common_model->read_number_million($total_total_print_type_sales_quantity);
								} 
								$nov=$total_total_print_type_sales_quantity;
								?>

						     </td>
						     <td><?php if($printing_total_year==FALSE){

						      }else{
						      	 $total_moss_offset=0;
								 $total_bonmac_offset=0;
								 $total_polytype_offset=0;
								 $total_polytype_lac=0;
								 $total_isimat_screen=0;
								 $total_isimat_flexo=0;
								 $total_isimat_flexo_2=0;
								 $total_printing=0;
						      	foreach($printing_total_year as $row){
									$total_row_printing=0;
									$total_row_printing=$row->MOSS_OFFSET_SUM+$row->BONMAC_OFFSET_SUM+$row->POLYTYPE_OFFSET_SUM+$row->POLYTYPE_LAC_SUM+$row->ISIMAT_SCREEN_SUM+$row->ISIMAT_FLEXO_SUM+$row->ISIMAT_FLEXO_2_SUM;
									
								    $total_printing+=$total_row_printing;
						      	}
						      	echo $this->common_model->read_number_million($total_printing);

						      } ?></td>
						    <td><?php echo $this->common_model->read_number_million($total_total_print_type_sales_value);?></td>

							<td><?php echo "&#8377;".number_format($total_total_print_type_sales_avg,2,'.','');?></td>
							<td></td>
							<td></td>
							</tr>
						</thead>
						</tbody>
						</table>
					</div>
				</div>

		    </div>

		    <div class="column">

		    	<div class="ui segments">
		    		<div class="ui blue segment">
					    <p><a  class="ui orange label">PENDING ORDER</a><a class="ui olive label"><i class="calendar icon"></i><?php echo date('d M y',strtotime($from_date));?> TO <?php echo date('d M y',strtotime($to_date));?></a></p>
					</div>
					<div class="ui segment">
						<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($pending_sales_order_opening==FALSE){

					}else{
						echo '<table class="ui very basic collapsing celled table" style="font-size:9px;">
					        	<thead>
								   
								  <tr>
					        			<th colspan="3" class="center aligned">COEX</th>
					        			<th colspan="3" class="center aligned">SPRING</th>
					        			<th colspan="3"  class="center aligned">TOTAL</th>
					        		</tr>
					        		<tr>
					        			<th>YEAR-MONTH</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			
					        		</tr>
					        	</thead>';
					 $total_balace_coex_pending_quantity=0;	
					 $total_balance_spring_pending_order_quantity=0;
					 $total_balance_spring_pending_order_value=0;
					 $total_screen_flexo_pending_quantity=0;
					 $total_offset_pending_quantity=0;
					 $total_label_pending_quantity=0;
					 $total_digital_pending_order_quantity=0;

					 $total_total_pending_order_quantity=0;
					 $total_total_coex_pending_order_quantity=0;
					 $total_balace_coex_pending_value=0;

					 $total_screen_flexo_pending_value=0;
					 $total_offset_pending_value=0;
					 $total_label_pending_value=0;
					 $total_digital_pending_order_value=0;
					 $total_total_pending_order_value=0;
					 $total_total_coex_pending_order_value=0;
					 if($pending_sales_order_opening==FALSE){
					 	echo "<tr><td colspan='9'>NO PENDING ORDERS</td></tr>";
					 }else{
					foreach($pending_sales_order_opening as $coex_order_row){
						
						$total_screen_flexo_pending_quantity+=$coex_order_row->SCREEN_FLEXO_PENDING_QTY;
					    $total_offset_pending_quantity+=$coex_order_row->OFFSET_PENDING_QTY;
					    $total_label_pending_quantity+=$coex_order_row->LABEL_PENDING_QTY;
					    $total_digital_pending_order_quantity+=$coex_order_row->DIGITAL_PENDING_QTY;

					    $total_screen_flexo_pending_value+=$coex_order_row->SCREEN_FLEXO_PENDING_VALUE;
					 	$total_offset_pending_value+=$coex_order_row->OFFSET_PENDING_VALUE;
					 	$total_label_pending_value+=$coex_order_row->LABEL_PENDING_VALUE;
					 	$total_digital_pending_order_value+=$coex_order_row->DIGITAL_PENDING_VALUE;

						$total_total_coex_pending_order_quantity=$total_screen_flexo_pending_quantity+$total_offset_pending_quantity+$total_label_pending_quantity;
						$total_total_pending_order_quantity=$total_screen_flexo_pending_quantity+$total_offset_pending_quantity+$total_label_pending_quantity+$total_digital_pending_order_quantity;

						$total_total_coex_pending_order_value=$total_screen_flexo_pending_value+$total_offset_pending_value+$total_label_pending_value;
					    $total_total_pending_order_value=$total_screen_flexo_pending_value+$total_offset_pending_value+$total_label_pending_value+$total_digital_pending_order_value;

					    $total_total_coex_pending_avg_price=0;
					    $total_total_coex_pending_avg_price=($total_total_coex_pending_order_value!=0 ? ($total_total_coex_pending_order_value/$total_total_coex_pending_order_quantity) : 0);
					    $total_digital_pending_order_avg_price=0;
					    $total_digital_pending_order_avg_price=($total_digital_pending_order_value!=0 ? ($total_digital_pending_order_value/$total_digital_pending_order_quantity) : 0);

					    $total_total_pending_avg_price=0;
					    $total_total_pending_avg_price=($total_total_pending_order_value!=0 ? ($total_total_pending_order_value/$total_total_pending_order_quantity) : 0);

					    }
					}
					    echo "<tr>
							    	<td><b>OPENING ORDER</b></td>
							    	<td class='negative right aligned'>".$this->common_model->read_number_million($total_total_coex_pending_order_quantity)."</td>
							    	<td class='negative right aligned'>".$this->common_model->read_number_million($total_total_coex_pending_order_value)."</td>
							    	<td class='negative right aligned'>&#8377;".round($total_total_coex_pending_avg_price,2)."</td>
							    	<td class='positive right aligned'>".$this->common_model->read_number_million($total_digital_pending_order_quantity)."</td>
							    	<td class='positiveright aligned'>".$this->common_model->read_number_million($total_digital_pending_order_value)."</td>
							    	<td class='positive right aligned'>&#8377;".round($total_digital_pending_order_avg_price,2)."</td>
							    	<td class='active right aligned'>".$this->common_model->read_number_million($total_total_pending_order_quantity)."</td>
							    	<td class='active right aligned'>".$this->common_model->read_number_million($total_total_pending_order_value)."</td>
							    	<td class='active right aligned'>&#8377;".round($total_total_pending_avg_price,2)."</t>

							  	</tr>";


					 $total_screen_flexo_pending_quantity=0;
					 $total_offset_pending_quantity=0;
					 $total_label_pending_quantity=0;
					 $total_digital_pending_quantity=0;
					 $total_total_pending_quantity=0;
					 $total_total_coex_pending_quantity=0;

					 $total_screen_flexo_pending_value=0;
					 $total_offset_pending_value=0;
					 $total_label_pending_value=0;
					 $total_digital_pending_value=0;
					 $total_total_pending_value=0;
					 $total_total_coex_pending_value=0;
					 if($pending_sales_order==FALSE){
					 	echo "<tr><td colspan='9'>NO NEW ORDERS IN THE MONTH</td></tr>";
					 }else{
					foreach($pending_sales_order as $coex_order_row){
						
						$total_screen_flexo_pending_quantity+=$coex_order_row->SCREEN_FLEXO_PENDING_QTY;
					    $total_offset_pending_quantity+=$coex_order_row->OFFSET_PENDING_QTY;
					    $total_label_pending_quantity+=$coex_order_row->LABEL_PENDING_QTY;
					    $total_digital_pending_quantity+=$coex_order_row->DIGITAL_PENDING_QTY;

					    $total_screen_flexo_pending_value+=$coex_order_row->SCREEN_FLEXO_PENDING_VALUE;
					 	$total_offset_pending_value+=$coex_order_row->OFFSET_PENDING_VALUE;
					 	$total_label_pending_value+=$coex_order_row->LABEL_PENDING_VALUE;
					 	$total_digital_pending_value+=$coex_order_row->DIGITAL_PENDING_VALUE;

					 	$total_screen_flexo_pending_avg_price=0;
						$total_screen_flexo_pending_avg_price=($total_screen_flexo_pending_value!=0 ? ($total_screen_flexo_pending_value/$total_screen_flexo_pending_quantity) : 0);

						$total_offset_pending_avg_price=0;
						$total_offset_pending_avg_price=($total_offset_pending_value!=0 ? ($total_offset_pending_value/$total_offset_pending_quantity) : 0);

						$total_label_pending_avg_price=0;
						$total_label_pending_avg_price=($total_label_pending_value!=0 ? ($total_label_pending_value/$total_label_pending_quantity) : 0);

						$total_digital_pending_avg_price=0;
						$total_digital_pending_avg_price=($total_digital_pending_value!=0 ? ($total_digital_pending_value/$total_digital_pending_quantity) : 0);

						$total_total_coex_pending_quantity=$total_screen_flexo_pending_quantity+$total_offset_pending_quantity+$total_label_pending_quantity;
						$total_total_pending_quantity=$total_screen_flexo_pending_quantity+$total_offset_pending_quantity+$total_label_pending_quantity+$total_digital_pending_quantity;

						$total_total_coex_pending_value=$total_screen_flexo_pending_value+$total_offset_pending_value+$total_label_pending_value;
					    $total_total_pending_value=$total_screen_flexo_pending_value+$total_offset_pending_value+$total_label_pending_value+$total_digital_pending_value;

					    $total_total_coex_pending_avg_price=0;
					    $total_total_coex_pending_avg_price=($total_total_coex_pending_value!=0 ? ($total_total_coex_pending_value/$total_total_coex_pending_quantity) : 0);
					    $total_total_pending_avg_price=0;
					    $total_total_pending_avg_price=($total_total_pending_value!=0 ? ($total_total_pending_value/$total_total_pending_quantity) : 0);

					    }
					}

					    echo "<tbody>
							    <tr>
							    	<td><b>NEW ORDER</b></td>
							    	<td class='negative right aligned'>".$this->common_model->read_number_million($total_total_coex_pending_quantity)."</td>
							    	<td class='negative right aligned'>".$this->common_model->read_number_million($total_total_coex_pending_value)."</td>
							    	<td class='negative right aligned'>&#8377;".round($total_total_coex_pending_avg_price,2)."</td>
							    	<td class='positive right aligned'>".$this->common_model->read_number_million($total_digital_pending_quantity)."</td>
							    	<td class='positive right aligned'>".$this->common_model->read_number_million($total_digital_pending_value)."</td>
							    	<td class='positive right aligned'>&#8377;".round($total_digital_pending_avg_price,2)."</td>
							    	<td class='active right aligned'>".$this->common_model->read_number_million($total_total_pending_quantity)."</td>
							    	<td class='active right aligned'>".$this->common_model->read_number_million($total_total_pending_value)."</td>
							    	<td class='active right aligned'>&#8377;".round($total_total_pending_avg_price,2)."</t>

							  	</tr>
							  </tbody>";/*
							  if($print_type_wise_sales_coex_m==FALSE){
							  	echo "<tr><td colspan='9'>NO DISPATCH IN THE MONTH</td></tr>";
							  	 }else{
							  foreach($print_type_wise_sales_coex_m as $row_coex){
							  	$total_prin_type_coex_quantity=0;
								$total_prin_type_coex_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL;
								$total_print_type_coex_value=0;
								$total_print_type_coex_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE;
								$total_print_type_coex_avg_price=0;
								$total_print_type_coex_avg_price=($total_print_type_coex_value!=0 ? $total_print_type_coex_value/$total_prin_type_coex_quantity : 0);

								$total_spring_pending_order_dispatch_quantity=0;
								$total_spring_pending_order_dispatch_value=0;

								$total_spring_pending_order_dispatch_quantity=$row_coex->DIGITAL;
								$total_spring_pending_order_dispatch_value=$row_coex->DIGITAL_VALUE;

								$total_prin_type_quantity=0;
								$total_prin_type_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL+$row_coex->DIGITAL;
								$total_print_type_value=0;
								$total_print_type_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE+$row_coex->DIGITAL_VALUE;
								$total_print_type_avg_price=0;
								$total_print_type_avg_price=($total_print_type_value<>0 ? ($total_print_type_value/$total_prin_type_quantity) : 0);

								$digital_avg_price=0;
								$digital_avg_price=($row_coex->DIGITAL_VALUE!=0 ? ($row_coex->DIGITAL_VALUE/$row_coex->DIGITAL) : 0);
					    	echo "<tr>
							    	<td>3</td>
							    	<td><b>DISPATCH IN MONTH</b></td>
							    	<td class='negative right aligned'>".$this->common_model->read_number_million($total_prin_type_coex_quantity)."</td>
							    	<td class='negative right aligned'>".$this->common_model->read_number_million($total_print_type_coex_value)."</td>
							    	<td class='negative right aligned'>&#8377;".round($total_print_type_coex_avg_price,2)."</td>
							    	<td class='positive right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL)."</td>
									<td class='positive right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL_VALUE)."</td>
									<td class='positive right aligned'>&#8377;".round($digital_avg_price,2)."</td>
							    	<td class='active right aligned'>".$this->common_model->read_number_million($total_prin_type_quantity)."</td>
									<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_value)."</td>
									<td class='active right aligned'>&#8377;".round($total_print_type_avg_price,2)."</td>

							  		</tr>";
								}
							}*/
							$total_balace_coex_pending_quantity=$total_total_coex_pending_order_quantity+$total_total_coex_pending_quantity/*-$total_prin_type_coex_quantity*/;
							$total_balace_coex_pending_value=$total_total_coex_pending_order_value+$total_total_coex_pending_value/*-$total_print_type_coex_value*/;
							$total_balace_coex_pending_avg=0;
							$total_balace_coex_pending_avg=($total_balace_coex_pending_value!=0 ? ($total_balace_coex_pending_value/$total_balace_coex_pending_quantity) : 0);

							$total_balance_spring_pending_order_quantity=$total_digital_pending_order_quantity+$total_digital_pending_quantity/*-$total_spring_pending_order_dispatch_quantity*/;
							$total_balance_spring_pending_order_value=$total_digital_pending_order_value+$total_digital_pending_value/*-$total_spring_pending_order_dispatch_value*/;
							$total_balance_spring_pending_order_avg=0;
							$total_balance_spring_pending_order_avg=($total_balance_spring_pending_order_value!=0 ? ($total_balance_spring_pending_order_value/$total_balance_spring_pending_order_quantity) : 0);

							$total_balace_pending_order_quantity=0;
							$total_balace_pending_order_quantity=$total_balace_coex_pending_quantity+$total_balance_spring_pending_order_quantity;

							$total_balace_pending_order_value=0;
							$total_balace_pending_order_value=$total_balace_coex_pending_value+$total_balance_spring_pending_order_value;

							$total_balace_pending_order_avg=0;
							$total_balace_pending_order_avg=($total_balace_pending_order_value!=0 ? ($total_balace_pending_order_value/$total_balace_pending_order_quantity) :0);


							echo "<tr>
							    	<td><b>BALANCE PENDING</b></td>
							    	<td>".$this->common_model->read_number_million($total_balace_coex_pending_quantity)."</td>
							    	<td>".$this->common_model->read_number_million($total_balace_coex_pending_value)."</td>
							    	<td>&#8377;".round($total_balace_coex_pending_avg,2)."</td>
							    	<td>".$this->common_model->read_number_million($total_balance_spring_pending_order_quantity)."</td>
							    	<td>".$this->common_model->read_number_million($total_balance_spring_pending_order_value)."</td>
							    	<td>&#8377;".round($total_balance_spring_pending_order_avg,2)."</td>
							    	<td>".$this->common_model->read_number_million($total_balace_pending_order_quantity)."</td>
							    	<td>".$this->common_model->read_number_million($total_balace_pending_order_value)."</td>
							    	<td>&#8377;".round($total_balace_pending_order_avg,2)."</td>
							  		</tr>";
							   

						echo '</table>';

					}
				?>
					</div>
				</div>

		    </div>

		  </div>
		</div>

		<div class="ui equal width grid">
		  <div class="two column computer only row">
		  	<div class="twelve wide column">
		    	
		    	<div class="ui red segments">
		    		<div class="ui red segment">
					    <p><a  class="ui orange label">SALES</a>

					    	<a  class="ui blue label">DOMESTIC</a>
					    	<a  class="ui blue label">EXPORT FROM INDIA</a>
					    	<a  class="ui blue label">EXPORT TO 3D SARL</a>
					    	<a class="ui olive label"><i class="calendar icon"></i><?php echo date('d M y',strtotime($from_date));?> TO <?php echo date('d M y',strtotime($to_date));?></a></p>
					</div>
		    		<div class="ui segment">
		    			<?php
						setlocale(LC_MONETARY, 'en_IN');
						if($print_type_wise_sales_domestic==FALSE){
							$total_total_print_type_coex_spring_domestic_quantity=0;
					        	$total_total_print_type_coex_spring_export_to_india_quantity=0;
					        	$total_total_print_type_coex_spring_export_to_sarl_quantity=0;
						}else{
						echo '<table class="ui very basic collapsing celled table" style="font-size:9px;">
					        	<thead>
								  <tr>
					        			<th></th>
					        			<th></th>
					        			<th colspan="4" class="center aligned">COEX</th>
					        			<th colspan="4" class="center aligned">SPRING</th>
					        			<th colspan="3" class="center aligned">TOTAL</th>
					        		</tr>
					        		<tr>
					        			<th></th>
					        			<th></th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">%</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">%</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        		</tr>
					        	</thead><tbody>';

					        	$total_total_print_type_coex_domestic_quantity=0;
					        	$total_total_print_type_coex_domestic_value=0;
					        	$total_total_print_type_spring_domestic_quantity=0;
					        	$total_total_print_type_spring_domestic_value=0;
					        	$total_total_print_type_coex_spring_domestic_quantity=0;
					        	$total_total_print_type_coex_spring_domestic_value=0;

					        	if($print_type_wise_sales_domestic==FALSE){

					    	echo "<tr>
					    			<td><b>DOMESTIC</b></td>
					    			<th></th>
					    			<td class='active right aligned'>-</td>
									<td class='active right aligned'>-</td>
									<td class='active right aligned'>-</td>

									<td class='negative right aligned'>-</td>
									<td class='negative right aligned'>-</td>
									<td class='negative right aligned'>-</td>

									<td class='active warning right aligned'>-</td>
									<td class='active warning right aligned'>-</td>
									<td class='active warning right aligned'>-</td>
								</tr>";
					    }
					    	else{
					 $total_screen_flexo_quantity=0;
					 $total_screen_flexo_value=0;
					 $total_screen_flexo_avg=0;
					 $total_offset_quantity=0;
					 $total_offset_value=0;
					 $total_offset_avg=0;
					 $total_label_quantity=0;
					 $total_label_value=0;
					 $total_label_avg=0;

					 $total_digital_quantity=0;
					 $total_digital_value=0;
					 $total_digital_avg=0;

					 $total_total_print_type_coex_quantity=0;
					 $total_total_print_type_coex_value=0;
					 $total_total_print_type_coex_avg=0;
					 $i=1;
					 $count=0;
					 $last_count=0;
					foreach($print_type_wise_sales_domestic as $row_coex){
						$screen_flexo_avg_price=0;
						$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_VALUE!=0 ? $row_coex->SCREEN_FLEXO_VALUE/$row_coex->SCREEN_FLEXO : 0);
						$offset_avg_price=0;
						$offset_avg_price=($row_coex->OFFSET_VALUE!=0 ? $row_coex->OFFSET_VALUE/$row_coex->OFFSET : 0);
						$label_avg_price=0;
						$label_avg_price=($row_coex->LABEL_VALUE!=0 ? $row_coex->LABEL_VALUE/$row_coex->LABEL : 0);
						$digital_avg_price=0;
						$digital_avg_price=($row_coex->DIGITAL_VALUE!=0 ? $row_coex->DIGITAL_VALUE/$row_coex->DIGITAL : 0);
						$total_prin_type_coex_quantity=0;
						$total_prin_type_coex_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL;

						$total_print_type_coex_value=0;
						$total_print_type_coex_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE;
						$total_print_type_coex_avg_price=0;
						$total_print_type_coex_avg_price=($total_print_type_coex_value!=0 ? $total_print_type_coex_value/$total_prin_type_coex_quantity : 0);

						$total_prin_type_quantity=0;
						$total_prin_type_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL+$row_coex->DIGITAL;
						$total_print_type_value=0;
						$total_print_type_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE+$row_coex->DIGITAL_VALUE;
						$total_print_type_avg_price=0;
						$total_print_type_avg_price=($total_print_type_value<>0 ? ($total_print_type_value/$total_prin_type_quantity) : 0);
						$domestic_coex_pc=0;
						$domestic_coex_pc=($total_prin_type_coex_quantity<>0 ? ($total_prin_type_coex_quantity/$total_prin_type_quantity)*100 :'0');
						$domestic_spring_pc=0;
						$domestic_spring_pc=($row_coex->DIGITAL<>0 ? ($row_coex->DIGITAL/$total_prin_type_quantity)*100 :'0');
						
						echo "<tr>
								<td><b>".strtoupper($row_coex->sales_month)." ".$row_coex->sales_year."</b></td>
								<td><b>DOMESTIC</b></td>
								<td class='active right aligned'>".$this->common_model->read_number_million($total_prin_type_coex_quantity)."</td>
								<td class='active right aligned'>".number_format($domestic_coex_pc)."%</td>
								<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_coex_value)."</td>
								<td class='active right aligned'>&#8377;".number_format($total_print_type_coex_avg_price,2,'.','')."</td>

								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL)."</td>
								<td class='negative right aligned'>".number_format($domestic_spring_pc)."%</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".number_format($digital_avg_price,2,'.','')."</td>

								<td class='active warning right aligned'>".$this->common_model->read_number_million($total_prin_type_quantity)."</td>
								<td class='active warning right aligned'>".$this->common_model->read_number_million($total_print_type_value)."</td>
								<td class='active warning right aligned'>&#8377;".number_format($total_print_type_avg_price,2,'.','')."</td>
					        </tr>";

					       $total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO;
					       $total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_VALUE;
					       $total_offset_quantity+=$row_coex->OFFSET;
					       $total_offset_value+=$row_coex->OFFSET_VALUE;
					       $total_label_quantity+=$row_coex->LABEL;
					       $total_label_value+=$row_coex->LABEL_VALUE;
					       $total_digital_quantity+=$row_coex->DIGITAL;
					       $total_digital_value+=$row_coex->DIGITAL_VALUE;
					       $count++;
							$i++;
					    }
					    $total_total_print_type_coex_domestic_quantity+=$total_prin_type_coex_quantity;
					    $total_total_print_type_coex_domestic_value+=$total_print_type_coex_value;
					    $total_total_print_type_spring_domestic_quantity=$total_digital_quantity;
					    $total_total_print_type_spring_domestic_value=$total_digital_value;
					    $total_total_print_type_coex_spring_domestic_quantity=$total_prin_type_quantity;
					    $total_total_print_type_coex_spring_domestic_value=$total_print_type_value;
					}
					    $total_screen_flexo_avg=($total_screen_flexo_value!=0 ? $total_screen_flexo_value/$total_screen_flexo_quantity : '0');
					    $total_offset_avg=($total_offset_value!=0 ? $total_offset_value/$total_offset_quantity : '0');
					    $total_label_avg=($total_label_value!=0 ? $total_label_value/$total_label_quantity : '0');
					    $total_digital_avg=($total_digital_value!=0 ? $total_digital_value/$total_digital_quantity : '0');

					    $total_total_print_type_coex_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity;
					    $total_total_print_type_coex_value=$total_screen_flexo_value+$total_offset_value+$total_label_value;
					    $total_total_print_type_coex_avg=($total_total_print_type_coex_value<>0 ? ($total_total_print_type_coex_value/$total_total_print_type_coex_quantity) : 0);

					    $total_total_print_type_sales_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity+$total_digital_quantity;
					    $total_total_print_type_sales_value=$total_screen_flexo_value+$total_offset_value+$total_label_value+$total_digital_value;
					    $total_total_print_type_sales_avg=($total_total_print_type_sales_value<>0 ? ($total_total_print_type_sales_value/$total_total_print_type_sales_quantity) : 0);


					    $total_total_print_type_coex_export_to_india_quantity=0;
					    $total_total_print_type_coex_export_to_india_value=0;
					    $total_total_print_type_spring_export_to_india_quantity=0;
					    $total_total_print_type_spring_export_to_india_value=0;
					    $total_total_print_type_coex_spring_export_to_india_quantity=0;
					    $total_total_print_type_coex_spring_export_to_india_value=0;

					    if($print_type_wise_sales_export_local==FALSE){

					    	echo "<tr>
					    			<td><b>EXPORT FROM INDIA</b></td>
					    			<td></td>
					    			<td class='active right aligned'>-</td>
									<td class='active right aligned'>-</td>
									<td class='active right aligned'>-</td>

									<td class='negative right aligned'>-</td>
									<td class='negative right aligned'>-</td>
									<td class='negative right aligned'>-</td>

									<td class='active warning right aligned'>-</td>
									<td class='active warning right aligned'>-</td>
									<td class='active warning right aligned'>-</td>
								</tr>";
					    }
					    	else{

					    	 $total_screen_flexo_quantity=0;
							 $total_screen_flexo_value=0;
							 $total_screen_flexo_avg=0;
							 $total_offset_quantity=0;
							 $total_offset_value=0;
							 $total_offset_avg=0;
							 $total_label_quantity=0;
							 $total_label_value=0;
							 $total_label_avg=0;

							 $total_digital_quantity=0;
							 $total_digital_value=0;
							 $total_digital_avg=0;

							 $total_total_print_type_coex_quantity=0;
							 $total_total_print_type_coex_value=0;
							 $total_total_print_type_coex_avg=0;

					    	foreach($print_type_wise_sales_export_local as $row_coex){

					    		$screen_flexo_avg_price=0;
								$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_VALUE!=0 ? $row_coex->SCREEN_FLEXO_VALUE/$row_coex->SCREEN_FLEXO : 0);
								$offset_avg_price=0;
								$offset_avg_price=($row_coex->OFFSET_VALUE!=0 ? $row_coex->OFFSET_VALUE/$row_coex->OFFSET : 0);
								$label_avg_price=0;
								$label_avg_price=($row_coex->LABEL_VALUE!=0 ? $row_coex->LABEL_VALUE/$row_coex->LABEL : 0);
								$digital_avg_price=0;
								$digital_avg_price=($row_coex->DIGITAL_VALUE!=0 ? $row_coex->DIGITAL_VALUE/$row_coex->DIGITAL : 0);
								$total_prin_type_coex_quantity=0;
								$total_prin_type_coex_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL;

								$total_print_type_coex_value=0;
								$total_print_type_coex_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE;
								$total_print_type_coex_avg_price=0;
								$total_print_type_coex_avg_price=($total_print_type_coex_value!=0 ? $total_print_type_coex_value/$total_prin_type_coex_quantity : 0);

								$total_prin_type_quantity=0;
								$total_prin_type_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL+$row_coex->DIGITAL;
								$total_print_type_value=0;
								$total_print_type_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE+$row_coex->DIGITAL_VALUE;
								$total_print_type_avg_price=0;
								$total_print_type_avg_price=($total_print_type_value<>0 ? ($total_print_type_value/$total_prin_type_quantity) : 0);
								$export_from_india_coex_pc=0;
								$export_from_india_coex_pc=($total_prin_type_coex_quantity<>0 ? ($total_prin_type_coex_quantity/$total_prin_type_quantity)*100 :'0');
								$export_from_india_spring_pc=0;
								$export_from_india_spring_pc=($row_coex->DIGITAL<>0 ? ($row_coex->DIGITAL/$total_prin_type_quantity)*100 :'0');

					    		echo "<tr>
								<td><b> ".strtoupper($row_coex->sales_month)." ".$row_coex->sales_year."</b></td>
								<td><b>EXPORT FROM INDIA</b></td>
								<td class='active right aligned'>".$this->common_model->read_number_million($total_prin_type_coex_quantity)."</td>
								<td class='active right aligned'>".number_format($export_from_india_coex_pc)."%</td>
								<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_coex_value)."</td>
								<td class='active right aligned'>&#8377;".number_format($total_print_type_coex_avg_price,2,'.','')."</td>

								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL)."</td>
								<td class='negative right aligned'>".number_format($export_from_india_spring_pc)."%</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".number_format($digital_avg_price,2,'.','')."</td>

								<td class='active warning right aligned'>".$this->common_model->read_number_million($total_prin_type_quantity)."</td>
								<td class='active warning right aligned'>".$this->common_model->read_number_million($total_print_type_value)."</td>
								<td class='active warning right aligned'>&#8377;".number_format($total_print_type_avg_price,2,'.','')."</td>
					        </tr>";
					        $total_digital_quantity+=$row_coex->DIGITAL;
					        $total_digital_value+=$row_coex->DIGITAL_VALUE;
					    	}

					    	$total_total_print_type_coex_export_to_india_quantity+=$total_prin_type_coex_quantity;
					    	$total_total_print_type_coex_export_to_india_value=$total_print_type_coex_value;
					    	$total_total_print_type_spring_export_to_india_quantity=$total_digital_quantity;
					    	$total_total_print_type_spring_export_to_india_value=$total_digital_value;
					    	$total_total_print_type_coex_spring_export_to_india_quantity=$total_prin_type_quantity;
					    	$total_total_print_type_coex_spring_export_to_india_value=$total_print_type_value;

					    }

					    $total_total_print_type_coex_export_to_sarl_quantity=0;
					    $total_total_print_type_coex_export_to_sarl_value=0;
					    $total_total_print_type_coex_spring_to_sarl_quantity=0;
					    $total_total_print_type_spring_export_to_sarl_value=0;
					    $total_total_print_type_coex_spring_export_to_sarl_quantity=0;
					    $total_total_print_type_coex_spring_export_to_sarl_value=0;
					    if($print_type_wise_sales_export_fze==FALSE){
					    	echo "<tr>
					    			<td><b>EXPORT TO SARL</b></td>
					    			<td></td>
					    			<td class='active right aligned'>-</td>
									<td class='active right aligned'>-</td>
									<td class='active right aligned'>-</td>

									<td class='negative right aligned'>-</td>
									<td class='negative right aligned'>-</td>
									<td class='negative right aligned'>-</td>

									<td class='active warning right aligned'>-</td>
									<td class='active warning right aligned'>-</td>
									<td class='active warning right aligned'>-</td>
								</tr>";
					    }
					    	else{

					    	 $total_screen_flexo_quantity=0;
							 $total_screen_flexo_value=0;
							 $total_screen_flexo_avg=0;
							 $total_offset_quantity=0;
							 $total_offset_value=0;
							 $total_offset_avg=0;
							 $total_label_quantity=0;
							 $total_label_value=0;
							 $total_label_avg=0;

							 $total_digital_quantity=0;
							 $total_digital_value=0;
							 $total_digital_avg=0;

							 $total_total_print_type_coex_quantity=0;
							 $total_total_print_type_coex_value=0;
							 $total_total_print_type_coex_avg=0;

					    	foreach($print_type_wise_sales_export_fze as $row_coex){

					    		$screen_flexo_avg_price=0;
								$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_VALUE!=0 ? $row_coex->SCREEN_FLEXO_VALUE/$row_coex->SCREEN_FLEXO : 0);
								$offset_avg_price=0;
								$offset_avg_price=($row_coex->OFFSET_VALUE!=0 ? $row_coex->OFFSET_VALUE/$row_coex->OFFSET : 0);
								$label_avg_price=0;
								$label_avg_price=($row_coex->LABEL_VALUE!=0 ? $row_coex->LABEL_VALUE/$row_coex->LABEL : 0);
								$digital_avg_price=0;
								$digital_avg_price=($row_coex->DIGITAL_VALUE!=0 ? $row_coex->DIGITAL_VALUE/$row_coex->DIGITAL : 0);
								$total_prin_type_coex_quantity=0;
								$total_prin_type_coex_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL;

								$total_print_type_coex_value=0;
								$total_print_type_coex_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE;
								$total_print_type_coex_avg_price=0;
								$total_print_type_coex_avg_price=($total_print_type_coex_value!=0 ? $total_print_type_coex_value/$total_prin_type_coex_quantity : 0);

								$total_prin_type_quantity=0;
								$total_prin_type_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL+$row_coex->DIGITAL;
								$total_print_type_value=0;
								$total_print_type_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE+$row_coex->DIGITAL_VALUE;
								$total_print_type_avg_price=0;
								$total_print_type_avg_price=($total_print_type_value<>0 ? ($total_print_type_value/$total_prin_type_quantity) : 0);

								$export_to_sarl_coex_pc=0;
								$export_to_sarl_coex_pc=($total_prin_type_coex_quantity<>0 ? ($total_prin_type_coex_quantity/$total_prin_type_quantity)*100 : '0');
								$export_to_sarl_spring_pc=0;
								$export_to_sarl_spring_pc=($row_coex->DIGITAL<>0 ? ($row_coex->DIGITAL/$total_prin_type_quantity)*100 : '0');

					    		echo "<tr>
								<td><b> ".strtoupper($row_coex->sales_month)." ".$row_coex->sales_year."</b></td>
								<td><b>EXPORT TO SARL</b></td>
								<td class='active right aligned'>".$this->common_model->read_number_million($total_prin_type_coex_quantity)."</td>
								<td class='active right aligned'>".number_format($export_to_sarl_coex_pc)."%</td>
								<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_coex_value)."</td>
								<td class='active right aligned'>&#8377;".number_format($total_print_type_coex_avg_price,2,'.','')."</td>

								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL)."</td>
								<td class='negative right aligned'>".number_format($export_to_sarl_spring_pc)."%</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".number_format($digital_avg_price,2,'.','')."</td>

								<td class='active warning right aligned'>".$this->common_model->read_number_million($total_prin_type_quantity)."</td>
								<td class='active warning right aligned'>".$this->common_model->read_number_million($total_print_type_value)."</td>
								<td class='active warning right aligned'>&#8377;".number_format($total_print_type_avg_price,2,'.','')."</td>
					        </tr>";

					        $total_digital_quantity+=$row_coex->DIGITAL;
					        $total_digital_value+=$row_coex->DIGITAL_VALUE;

					    	}
					    	$total_total_print_type_coex_export_to_sarl_quantity=$total_prin_type_coex_quantity;
					    	$total_total_print_type_coex_export_to_sarl_value=$total_print_type_coex_value;
					    	$total_total_print_type_spring_to_sarl_quantity=$total_digital_quantity;
					    	$total_total_print_type_spring_export_to_sarl_value=$total_digital_value;
					    	$total_total_print_type_coex_spring_export_to_sarl_quantity=$total_prin_type_quantity;
					    	$total_total_print_type_coex_spring_export_to_sarl_value=$total_print_type_value;

					    }

					    $total_dom_export_coex_quantity=$total_total_print_type_coex_export_to_sarl_quantity+$total_total_print_type_coex_export_to_india_quantity+$total_total_print_type_coex_domestic_quantity;
					    $total_dom_export_coex_value=$total_total_print_type_coex_export_to_sarl_value+$total_total_print_type_coex_export_to_india_value+$total_total_print_type_coex_domestic_value;
					    $total_dom_export_coex_avg=0;
					    $total_dom_export_coex_avg=($total_dom_export_coex_value/$total_dom_export_coex_quantity);
					    $total_dom_export_spring_quantity=$total_total_print_type_spring_to_sarl_quantity+$total_total_print_type_spring_domestic_quantity+$total_total_print_type_spring_export_to_india_quantity;
					    $total_dom_export_spring_value=$total_total_print_type_spring_export_to_sarl_value+$total_total_print_type_spring_export_to_india_value+$total_total_print_type_spring_domestic_value;
					    $total_dom_export_spring_avg=0;
					    $total_dom_export_spring_avg=($total_dom_export_spring_value/$total_dom_export_spring_quantity);

					    $total_dom_export_coex_spring_quantity=$total_total_print_type_coex_spring_export_to_sarl_quantity+$total_total_print_type_coex_spring_domestic_quantity+$total_total_print_type_coex_spring_export_to_india_quantity;
					    $total_dom_export_coex_spring_value=$total_total_print_type_coex_spring_export_to_sarl_value+$total_total_print_type_coex_spring_domestic_value+$total_total_print_type_coex_spring_export_to_india_value;
					    $total_dom_export_coex_spring_avg=0;
					    $total_dom_export_coex_spring_avg=($total_dom_export_coex_spring_value/$total_dom_export_coex_spring_quantity);

					    $total_all_coex_pc=0;
					    $total_all_coex_pc=($total_dom_export_coex_quantity<>0 ? ($total_dom_export_coex_quantity/$total_dom_export_coex_spring_quantity)*100 : '0');


					    $total_all_spring_pc=0;
					    $total_all_spring_pc=($total_dom_export_spring_quantity<>0 ? ($total_dom_export_spring_quantity/$total_dom_export_coex_spring_quantity)*100 : '0');

					    echo "<tr>
					    		<td colspan='2'><b>TOTAL</b></td>
					    			<td class='active right aligned'>".$this->common_model->read_number_million($total_dom_export_coex_quantity)."</td>
					    			<td class='active right aligned'>".number_format($total_all_coex_pc)."%</td>
									<td class='active right aligned'>".$this->common_model->read_number_million($total_dom_export_coex_value)."</td>
									<td class='active right aligned'>&#8377;".number_format($total_dom_export_coex_avg,2,'.','')."</td>

									<td class='negative right aligned'>".$this->common_model->read_number_million($total_dom_export_spring_quantity)."</td>
									<td class='negative right aligned'>".number_format($total_all_spring_pc)."%</td>
									<td class='negative right aligned'>".$this->common_model->read_number_million($total_dom_export_spring_value)."</td>
									<td class='negative right aligned'>&#8377;".number_format($total_dom_export_spring_avg,2,'.','')."</td>

									<td class='active warning right aligned'>".$this->common_model->read_number_million($total_dom_export_coex_spring_quantity)."</td>
									<td class='active warning right aligned'>".$this->common_model->read_number_million($total_dom_export_coex_spring_value)."</td>
									<td class='active warning right aligned'>&#8377;".number_format($total_dom_export_coex_spring_avg,2,'.','')."</td>

					    	</tr>";


					    echo "</tbody>
							</table>";
						}

						



						?>
					</div>
				</div>
			</div>
			<div class="four wide column">

				<div class="ui red segments">
		    		<div class="ui red segment">
					    <p><a  class="ui orange label">SALES</a>
					    	<a class="ui olive label"><i class="calendar icon"></i><?php echo date('d M y',strtotime($from_date));?> TO <?php echo date('d M y',strtotime($to_date));?></a></p>
					</div>
		    		<div class="ui segment">
		    			<div class="ui tiny horizontal statistics">
						  <div class="red statistic">
						    <div class="value">
						      <?php echo ($total_total_print_type_coex_spring_domestic_quantity<>0 ? number_format((($total_total_print_type_coex_spring_domestic_quantity/$total_dom_export_coex_spring_quantity)*100),1,".","")."%" : "0%")?>
						    </div>
						    <div class="label">
						      Domestic
						    </div>
						  </div>
						  <div class="yellow statistic">
						    <div class="value">
						      <?php echo ($total_total_print_type_coex_spring_export_to_india_quantity<>0 ? number_format((($total_total_print_type_coex_spring_export_to_india_quantity/$total_dom_export_coex_spring_quantity)*100),'1',".","")."%" : "0%")?>
						    </div>
						    <div class="label">
						      Export from India
						    </div>
						  </div>
						  <div class="green statistic">
						    <div class="value">
						      <?php echo ($total_total_print_type_coex_spring_export_to_sarl_quantity<>0 ? number_format((($total_total_print_type_coex_spring_export_to_sarl_quantity/$total_dom_export_coex_spring_quantity)*100),'1',".","")."%" : "0%")?>
						    </div>
						    <div class="label">
						      Export To Sarl
						    </div>
						  </div>
						</div>
					</div>
				</div>
			
		    </div>
		  </div>
		</div>

		<div class="ui equal width grid">
		  <div class="equal width row">
		    <div class="column">

		    	<div class="ui segments">
		    		<div class="ui blue segment">
					    <p><a  class="ui orange label">SALES</a><a  class="ui blue label"> PRINT TYPE WISE</a> 
					    	<a class="ui olive label"><i class="calendar icon"></i><?php echo date('d M y',strtotime($from_date));?> TO <?php echo date('d M y',strtotime($to_date));?></a></p>
					</div>
					<div class="ui segment">
						<?php
						setlocale(LC_MONETARY, 'en_IN');
						if($print_type_wise_sales_coex==FALSE){}else{
						echo '<table class="ui very basic collapsing celled table" style="font-size:9px;">
					        	<thead>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="3" class="center aligned">COEX TOTAL</th>
					        			<th colspan="3" class="center aligned">SPRING</th>
					        			<th colspan="3" class="center aligned">DIA WISE TOTAL</th>
					        		</tr>
					        		<tr>
					        			<th>SR NO</th>
					        			<th>DIA</th>
					        			<th class="active right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        		</tr>
					        	</thead><tbody>';
					 $total_screen_flexo_quantity=0;
					 $total_screen_flexo_value=0;
					 $total_screen_flexo_avg=0;
					 $total_offset_quantity=0;
					 $total_offset_value=0;
					 $total_offset_avg=0;
					 $total_label_quantity=0;
					 $total_label_value=0;
					 $total_label_avg=0;

					 $total_digital_quantity=0;
					 $total_digital_value=0;
					 $total_digital_avg=0;

					 $total_total_print_type_coex_quantity=0;
					 $total_total_print_type_coex_value=0;
					 $total_total_print_type_coex_avg=0;
					 $i=1;
					 $count=0;
					 $last_count=0;
					foreach($print_type_wise_sales_coex as $row_coex){
						$screen_flexo_avg_price=0;
						$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_VALUE!=0 ? $row_coex->SCREEN_FLEXO_VALUE/$row_coex->SCREEN_FLEXO : 0);
						$offset_avg_price=0;
						$offset_avg_price=($row_coex->OFFSET_VALUE!=0 ? $row_coex->OFFSET_VALUE/$row_coex->OFFSET : 0);
						$label_avg_price=0;
						$label_avg_price=($row_coex->LABEL_VALUE!=0 ? $row_coex->LABEL_VALUE/$row_coex->LABEL : 0);
						$digital_avg_price=0;
						$digital_avg_price=($row_coex->DIGITAL_VALUE!=0 ? $row_coex->DIGITAL_VALUE/$row_coex->DIGITAL : 0);



						$total_prin_type_coex_quantity=0;
						$total_prin_type_coex_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL;

						$total_print_type_coex_value=0;
						$total_print_type_coex_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE;

						$total_print_type_coex_avg_price=0;
						$total_print_type_coex_avg_price=($total_print_type_coex_value!=0 ? $total_print_type_coex_value/$total_prin_type_coex_quantity : 0);

						$total_prin_type_quantity=0;
						$total_prin_type_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL+$row_coex->DIGITAL;
						$total_print_type_value=0;
						$total_print_type_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE+$row_coex->DIGITAL_VALUE;
						$total_print_type_avg_price=0;
						$total_print_type_avg_price=($total_print_type_value<>0 ? ($total_print_type_value/$total_prin_type_quantity) : 0);
						if($count==0){
							$from_date=strtoupper($row_coex->sales_month)." ".$row_coex->sales_year;
						}
						echo "<tr>
								<td>$i</td>
								<td><b>".strtoupper($row_coex->sleeve_dia)."</b></td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO)."</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($screen_flexo_avg_price,2)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row_coex->OFFSET)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row_coex->OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($offset_avg_price,2)."</td>
								<td class='warning right aligned'>".$this->common_model->read_number_million($row_coex->LABEL)."</td>
								<td class='warning right aligned'>".$this->common_model->read_number_million($row_coex->LABEL_VALUE)."</td>
								<td class='warning right aligned'>&#8377;".round($label_avg_price,2)."</td>

								<td class='active right aligned'>".$this->common_model->read_number_million($total_prin_type_coex_quantity)."</td>
								<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_coex_value)."</td>
								<td class='active right aligned'>&#8377;".round($total_print_type_coex_avg_price,2)."</td>

								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL)."</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($digital_avg_price,2)."</td>

								<td class='active warning right aligned'>".$this->common_model->read_number_million($total_prin_type_quantity)."</td>
								<td class='active warning right aligned'>".$this->common_model->read_number_million($total_print_type_value)."</td>
								<td class='active warning right aligned'>&#8377;".round($total_print_type_avg_price,2)."</td>
					        </tr>";

					       $total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO;
					       $total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_VALUE;
					       $total_offset_quantity+=$row_coex->OFFSET;
					       $total_offset_value+=$row_coex->OFFSET_VALUE;
					       $total_label_quantity+=$row_coex->LABEL;
					       $total_label_value+=$row_coex->LABEL_VALUE;
					       $total_digital_quantity+=$row_coex->DIGITAL;
					       $total_digital_value+=$row_coex->DIGITAL_VALUE;
					       $count++;
					       
							$i++;
					    }
					    $total_screen_flexo_avg=($total_screen_flexo_value!=0 ? $total_screen_flexo_value/$total_screen_flexo_quantity : '0');
					    $total_offset_avg=($total_offset_value!=0 ? $total_offset_value/$total_offset_quantity : '0');
					    $total_label_avg=($total_label_value!=0 ? $total_label_value/$total_label_quantity : '0');
					    $total_digital_avg=($total_digital_value!=0 ? $total_digital_value/$total_digital_quantity : '0');

					    $total_total_print_type_coex_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity;
					    $total_total_print_type_coex_value=$total_screen_flexo_value+$total_offset_value+$total_label_value;
					    $total_total_print_type_coex_avg=($total_total_print_type_coex_value<>0 ? ($total_total_print_type_coex_value/$total_total_print_type_coex_quantity) : 0);

					    $total_total_print_type_sales_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity+$total_digital_quantity;
					    $total_total_print_type_sales_value=$total_screen_flexo_value+$total_offset_value+$total_label_value+$total_digital_value;
					    $total_total_print_type_sales_avg=($total_total_print_type_sales_value<>0 ? ($total_total_print_type_sales_value/$total_total_print_type_sales_quantity) : 0);

					    echo "</tbody><tfoot>
							    <tr>
							    	<th colspan='2'>GRAND TOTAL</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_screen_flexo_quantity)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_screen_flexo_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_screen_flexo_avg,2)."</th>
							    	<th class='positive right aligned'>".$this->common_model->read_number_million($total_offset_quantity)."</th>
							    	<th class='positive right aligned'>".$this->common_model->read_number_million($total_offset_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_offset_avg,2)."</th>
							    	<th class='positive right aligned'>".$this->common_model->read_number_million($total_label_quantity)."</th>
							    	<th class='positive right aligned'>".$this->common_model->read_number_million($total_label_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_label_avg,2)."</th>

							    	<th class='positive right aligned'>".$this->common_model->read_number_million($total_total_print_type_coex_quantity)."</th>
							    	<th class='positive right aligned'>".$this->common_model->read_number_million($total_total_print_type_coex_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_total_print_type_coex_avg,2)."</th>

							    	<th class='positive right aligned'>".$this->common_model->read_number_million($total_digital_quantity)."</th>
							    	<th class='positive right aligned'>".$this->common_model->read_number_million($total_digital_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_digital_avg,2)."</th>

							    	<th class='warning right aligned'>".$this->common_model->read_number_million($total_total_print_type_sales_quantity)."</th>
							    	<th class='warning right aligned'>".$this->common_model->read_number_million($total_total_print_type_sales_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_total_print_type_sales_avg,2)."</th>
							  	</tr>
							  </tfoot>
							</table>";
						}
						?>
					</div>
				</div>

		    </div>

		  </div>
		</div>



		<div class="ui equal width grid">
		  <div class="equal width row">
		    <div class="column">

		    	<div class="ui segments">
		    		<div class="ui blue segment">
					    <p><a  class="ui orange label">SALES</a><a  class="ui blue label"> TOP CUSTOMER</a><a class="ui olive label"><i class="calendar icon"></i><?php echo date('d M y',strtotime($from_date));?> TO <?php echo date('d M y',strtotime($to_date));?></a></p>
					</div>
					<div class="ui segment">
						<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($top_customer_coex==FALSE){

					}else{
						echo '<table class="ui very basic collapsing celled table" style="font-size:9px;">
					        	<thead>
								  	<tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="4" class="center aligned">COEX TOTAL</th>
					        			<th colspan="4" class="center aligned">SPRING</th>
					        			<th colspan="4" class="center aligned">TOTAL</th>
					        		</tr>
								  <tr>
					        			<th>SR NO</th>
					        			<th>CUSTOMER</th>
					        			<th class="active right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">Q %</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">Q %</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">Q %</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG</th>
					        		</tr>
					        	</thead><tbody>';
					 $count=1;
					 $last_count=0;
					 
					 $total_screen_flexo_coex_quantity=0;
					 $total_screen_flexo_coex_value=0;
					 $total_screen_flexo_coex_avg_price=0;

					 $total_offset_coex_quantity=0;
					 $total_offset_coex_value=0;
					 $total_offset_coex_avg_price=0;

					 $total_label_coex_quantity=0;
					 $total_label_coex_value=0;
					 $total_label_coex_avg_price=0;

					 $total_coex_quantity=0;
					 $total_coex_value=0;
					 $total_coex_avg_price=0;

					 $total_digital_spring_quantity=0;
					 $total_digital_spring_value=0;
					 $total_digital_spring_avg_price=0;

					 $total_sales_coex_spring_quantity=0;
					 $total_sales_coex_spring_value=0;
					 $total_sales_coex_spring_avg_price=0;

					 $total_sales_coex_spring_quantity_for_per=0;
					 $total_sales_coex_spring_value_for_per=0;


					 $total_ten_screen_flexo_coex_quantity=0;
					 $total_ten_screen_flexo_coex_value=0;

					 $total_ten_offset_coex_quantity=0;
					 $total_ten_offset_coex_value=0;

					 $total_ten_label_coex_quantity=0;
					 $total_ten_label_coex_value=0;

					 $total_ten_coex_quantity=0;
					 $total_ten_coex_value=0;

					 $total_ten_digital_spring_quantity=0;
					 $total_ten_digital_spring_value=0;

					 $total_ten_sales_coex_spring_quantity=0;
					 $total_ten_sales_coex_spring_value=0;



					 $total_other_screen_flexo_coex_quantity=0;
					 $total_other_screen_flexo_coex_value=0;

					 $total_other_offset_coex_quantity=0;
					 $total_other_offset_coex_value=0;

					 $total_other_label_coex_quantity=0;
					 $total_other_label_coex_value=0;

					 $total_other_coex_quantity=0;
					 $total_other_coex_value=0;

					 $total_other_digital_spring_quantity=0;
					 $total_other_digital_spring_value=0;

					 $total_other_sales_coex_quantity=0;
					 $total_other_sales_coex_value=0;

					 $i=0;
					foreach($top_customer_coex as $row_coex){
						$total_sales_coex_spring_quantity_for_per+=$row_coex->sale_quantity;
						$total_sales_coex_spring_value_for_per+=$row_coex->value;
						$i++;
					}
						
					foreach($top_customer_coex as $row_coex){

						$avg_coex_rate=($row_coex->value/$row_coex->sale_quantity);
						$screen_flexo_avg_price=0;
						$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_VALUE!=0 ? $row_coex->SCREEN_FLEXO_VALUE/$row_coex->SCREEN_FLEXO : 0);
						$offset_avg_price=0;
						$offset_avg_price=($row_coex->OFFSET_VALUE!=0 ? $row_coex->OFFSET_VALUE/$row_coex->OFFSET : 0);
						$label_avg_price=0;
						$label_avg_price=($row_coex->LABEL_VALUE!=0 ? $row_coex->LABEL_VALUE/$row_coex->LABEL : 0);
						$digital_avg_price=0;
						$digital_avg_price=($row_coex->DIGITAL_VALUE!=0 ? $row_coex->DIGITAL_VALUE/$row_coex->DIGITAL : 0);

						$total_row_sales_coex_quantity=0;
						$total_row_sales_coex_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL;

						$total_row_sales_coex_value=0;
						$total_row_sales_coex_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE;

						$total_row_coex_avg_price=0;
						$total_row_coex_avg_price=($total_row_sales_coex_value!=0 ? ($total_row_sales_coex_value/$total_row_sales_coex_quantity) : 0);

						echo "<tr title ='$row_coex->customer' "; echo $a=($count>10 ? "class='cat1' style='display:none'" : "NO");  echo ">
								<td>$count</td>
								<td><b>$row_coex->customer</b></td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO)."</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($screen_flexo_avg_price,2)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row_coex->OFFSET)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row_coex->OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($offset_avg_price,2)."</td>

								<td class='right aligned'>".$this->common_model->read_number_million($row_coex->LABEL)."</td>
								<td class='right aligned'>".$this->common_model->read_number_million($row_coex->LABEL_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($label_avg_price,2)."</td>

								<td class='active right aligned'>".$this->common_model->read_number_million($total_row_sales_coex_quantity)."</td>
								<td class='active right aligned'>".round((($total_row_sales_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</td>
								<td class='active right aligned'>".$this->common_model->read_number_million($total_row_sales_coex_value)."</td>
								
								<td class='active right aligned'>&#8377;".round($total_row_coex_avg_price,2)."</td>

								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL)."</td>
								<td class='negative right aligned'>".round((($row_coex->DIGITAL/$total_sales_coex_spring_quantity_for_per)*100))."%</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL_VALUE)."</td>
								
								<td class='negative right aligned'>&#8377;".round($digital_avg_price,2)."</td>

								<td class='active right aligned'>".$this->common_model->read_number_million($row_coex->sale_quantity)."</td>
								<td class='active right aligned'>".round((($row_coex->sale_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</td>
								<td class='active right aligned'>".$this->common_model->read_number_million($row_coex->value)."</td>
								
								<td class='active right aligned'>&#8377;".round($avg_coex_rate,2)."</td>
							</tr>";

					        

					        $total_ten_screen_flexo_coex_quantity+=$row_coex->SCREEN_FLEXO;
							$total_ten_screen_flexo_coex_value+=$row_coex->SCREEN_FLEXO_VALUE;

							$total_ten_offset_coex_quantity+=$row_coex->OFFSET;
							$total_ten_offset_coex_value+=$row_coex->OFFSET_VALUE;

							$total_ten_label_coex_quantity+=$row_coex->LABEL;
							$total_ten_label_coex_value+=$row_coex->LABEL_VALUE;

							$total_ten_coex_quantity+=$total_row_sales_coex_quantity;
							$total_ten_coex_value+=$total_row_sales_coex_value;

							$total_ten_digital_spring_quantity+=$row_coex->DIGITAL;
							$total_ten_digital_spring_value+=$row_coex->DIGITAL_VALUE;

							$total_ten_sales_coex_spring_quantity+=$row_coex->sale_quantity;
							$total_ten_sales_coex_spring_value+=$row_coex->value;

					        if($count==10){

					        	$total_ten_screen_flexo_coex_avg_price=0;
							    $total_ten_screen_flexo_coex_avg_price=($total_ten_screen_flexo_coex_value!=0 ? ($total_ten_screen_flexo_coex_value/$total_ten_screen_flexo_coex_quantity) : 0);

							    $total_ten_offset_coex_avg_price=0;
							    $total_ten_offset_coex_avg_price=($total_ten_offset_coex_value!=0 ? ($total_ten_offset_coex_value/$total_ten_offset_coex_quantity) : 0);

							    $total_ten_label_coex_avg_price=0;
							    $total_ten_label_coex_avg_price=($total_ten_label_coex_value!=0 ? ($total_ten_label_coex_value/$total_ten_label_coex_quantity) : 0);

							    $total_ten_coex_avg_price=0;
							    $total_ten_coex_avg_price=($total_ten_coex_value!=0 ? ($total_ten_coex_value/$total_ten_coex_quantity) : 0);

							    $total_ten_digital_spring_avg_price=0;
							    $total_ten_digital_spring_avg_price=($total_ten_digital_spring_value!=0 ? ($total_ten_digital_spring_value/$total_ten_digital_spring_quantity) : 0);



							    $total_ten_sales_coex_spring_avg_price=0;
							    $total_ten_sales_coex_spring_avg_price=($total_ten_sales_coex_spring_value!=0 ? ($total_ten_sales_coex_spring_value/$total_ten_sales_coex_spring_quantity) : 0);

					        	echo "</tbody><tfoot><tr>
										<th colspan='2'>TOP 10 TOTAL</th>
										<th class='negative right aligned'>".$this->common_model->read_number_million($total_ten_screen_flexo_coex_quantity)."</th>
										<th class='negative right aligned'>".$this->common_model->read_number_million($total_ten_screen_flexo_coex_value)."</th>
										
										<th class='negative right aligned'>&#8377;".round($total_ten_screen_flexo_coex_avg_price,2)."</th>
										<th class='positive right aligned'>".$this->common_model->read_number_million($total_ten_offset_coex_quantity)."</th>
										<th class='positive right aligned'>".$this->common_model->read_number_million($total_ten_offset_coex_value)."</th>
										<th class='positive right aligned'>&#8377;".round($total_ten_offset_coex_avg_price,2)."</th>
										
										<th class='right aligned'>".$this->common_model->read_number_million($total_ten_label_coex_quantity)."</th>
										<th class='right aligned'>".$this->common_model->read_number_million($total_ten_label_coex_value)."</th>
										<th class='right aligned'>&#8377;".round($total_ten_label_coex_avg_price,2)."</th>

										<th class='right aligned'>".$this->common_model->read_number_million($total_ten_coex_quantity)."</th>
										<th class='right aligned'>".round((($total_ten_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
										<th class='right aligned'>".$this->common_model->read_number_million($total_ten_coex_value)."</th>
										
										<th class='right aligned'>&#8377;".round($total_ten_coex_avg_price,2)."</th>

										<th class='negative right aligned'>".$this->common_model->read_number_million($total_ten_digital_spring_quantity)."</th>
										<th class='right aligned'>".round((($total_ten_digital_spring_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
										<th class='negative right aligned'>".$this->common_model->read_number_million($total_ten_digital_spring_value)."</th>
										
										<th class='negative right aligned'>&#8377;".round($total_ten_digital_spring_avg_price,2)."</th>

										<th class='warning right aligned'>".$this->common_model->read_number_million($total_ten_sales_coex_spring_quantity)."</th>
										<th class='warning right aligned'>".round((($total_ten_sales_coex_spring_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>

										<th class='warning right aligned'>".$this->common_model->read_number_million($total_ten_sales_coex_spring_value)."</th>
										
										<th class='warning right aligned'>&#8377;".round($total_ten_sales_coex_spring_avg_price,2)."</th>
							        </tr>";

					        }
					       $total_screen_flexo_coex_quantity+=$row_coex->SCREEN_FLEXO;
					       $total_screen_flexo_coex_value+=$row_coex->SCREEN_FLEXO_VALUE;

					       $total_offset_coex_quantity+=$row_coex->OFFSET;
					       $total_offset_coex_value+=$row_coex->OFFSET_VALUE;


					       $total_label_coex_quantity+=$row_coex->LABEL;
					       $total_label_coex_value+=$row_coex->LABEL_VALUE;

					       $total_coex_quantity+=$total_row_sales_coex_quantity;
						   $total_coex_value+=$total_row_sales_coex_value;

					       $total_digital_spring_quantity+=$row_coex->DIGITAL;
					       $total_digital_spring_value+=$row_coex->DIGITAL_VALUE;

					       $total_sales_coex_spring_quantity+=$row_coex->sale_quantity;
					       $total_sales_coex_spring_value+=$row_coex->value;

					       if($count>10){
					       	 $total_other_screen_flexo_coex_quantity+=$row_coex->SCREEN_FLEXO;
					       	 $total_other_screen_flexo_coex_value+=$row_coex->SCREEN_FLEXO_VALUE;

							 $total_other_offset_coex_quantity+=$row_coex->OFFSET;
							 $total_other_offset_coex_value+=$row_coex->OFFSET_VALUE;

							 $total_other_label_coex_quantity+=$row_coex->LABEL;
							 $total_other_label_coex_value+=$row_coex->LABEL_VALUE;

							 $total_other_coex_quantity+=$total_row_sales_coex_quantity;
							 $total_other_coex_value+=$total_row_sales_coex_value;

							 $total_other_digital_spring_quantity+=$row_coex->DIGITAL;
							 $total_other_digital_spring_value+=$row_coex->DIGITAL_VALUE;

							 $total_other_sales_coex_quantity+=$row_coex->sale_quantity;
							 $total_other_sales_coex_value+=$row_coex->value;
					       }

					       	$count++;
						       
					    }

					    	$total_other_screen_flexo_coex_avg_price=0;
					       	$total_other_screen_flexo_coex_avg_price=($total_other_screen_flexo_coex_value!=0 ? ($total_other_screen_flexo_coex_value/$total_other_screen_flexo_coex_quantity) : 0);

					       	$total_other_offset_coex_avg_price=0;
					       	$total_other_offset_coex_avg_price=($total_other_offset_coex_value!=0 ? ($total_other_offset_coex_value/$total_other_offset_coex_quantity) : 0);

					       	$total_other_label_coex_avg_price=0;
					       	$total_other_label_coex_avg_price=($total_other_label_coex_value!=0 ? ($total_other_label_coex_value/$total_other_label_coex_quantity) : 0);

					       	$total_other_coex_avg_price=0;
					       	$total_other_coex_avg_price=($total_other_coex_value!=0 ? ($total_other_coex_value/$total_other_coex_quantity) : 0);

					       	$total_other_digital_spring_avg_price=0;
					       	$total_other_digital_spring_avg_price=($total_other_digital_spring_value!=0 ? ($total_other_digital_spring_value/$total_other_digital_spring_quantity) : 0);

					       	$total_other_sales_coex_avg_price=0;
					       	$total_other_sales_coex_avg_price=($total_other_sales_coex_value!=0 ? ($total_other_sales_coex_value/$total_other_sales_coex_quantity) : 0);
					    
					    	

					    echo "
							    <tr>
							    	<th colspan='2'><a href='#'' class='toggler' data-prod-cat='1'>OTHER TOTAL</a></th>
							    	<th class='right aligned'>".$this->common_model->read_number_million($total_other_screen_flexo_coex_quantity)."</th>
							    	<th class='right aligned'>".$this->common_model->read_number_million($total_other_screen_flexo_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_screen_flexo_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".$this->common_model->read_number_million($total_other_offset_coex_quantity)."</th>
							    	<th class='right aligned'>".$this->common_model->read_number_million($total_other_offset_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_offset_coex_avg_price,2)."</th>


							    	<th class='right aligned'>".$this->common_model->read_number_million($total_other_label_coex_quantity)."</th>
							    	<th class='right aligned'>".$this->common_model->read_number_million($total_other_label_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_label_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".$this->common_model->read_number_million($total_other_coex_quantity)."</th>
							    	<th class='right aligned'>".round((($total_other_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
									<th class='right aligned'>".$this->common_model->read_number_million($total_other_coex_value)."</th>
									
									<th class='right aligned'>&#8377;".round($total_other_coex_avg_price,2)."</th>

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_other_digital_spring_quantity)."</th>
							    	<th class='right aligned'>".round((($total_other_digital_spring_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
									<th class='negative right aligned'>".$this->common_model->read_number_million($total_other_digital_spring_value)."</th>
									
									<th class='negative right aligned'>&#8377;".round($total_other_digital_spring_avg_price,2)."</th>

							    	<th class='right aligned'>".$this->common_model->read_number_million($total_other_sales_coex_quantity)."</th>
							    	<th class='right aligned'>".round((($total_other_sales_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
							    	<th class='right aligned'>".$this->common_model->read_number_million($total_other_sales_coex_value)."</th>
							    	
							    	<th class='right aligned'>&#8377;".round($total_other_sales_coex_avg_price,2)."</th>

							  	</tr>";


							$total_screen_flexo_coex_avg_price=0;
					       	$total_screen_flexo_coex_avg_price=($total_screen_flexo_coex_value!=0 ? ($total_screen_flexo_coex_value/$total_screen_flexo_coex_quantity) : 0);

					       	$total_offset_coex_avg_price=0;
					       	$total_offset_coex_avg_price=($total_offset_coex_value!=0 ? ($total_offset_coex_value/$total_offset_coex_quantity) : 0);

					       	$total_label_coex_avg_price=0;
					       	$total_label_coex_avg_price=($total_label_coex_value!=0 ? ($total_label_coex_value/$total_label_coex_quantity) : 0);

					       	$total_coex_avg_price=0;
					       	$total_coex_avg_price=($total_coex_value!=0 ? ($total_coex_value/$total_coex_quantity) : 0);

					       	$total_digital_spring_avg_price=0;
					       	$total_digital_spring_avg_price=($total_digital_spring_value!=0 ? ($total_digital_spring_value/$total_digital_spring_quantity) : 0);

					       	$total_sales_coex_spring_avg_price=0;
					       	$total_sales_coex_spring_avg_price=($total_sales_coex_spring_value!=0 ? ($total_sales_coex_spring_value/$total_sales_coex_spring_quantity) : 0);

						 echo "
							    <tr>
							    	<th colspan='2'>GRAND TOTAL</th>
							    	<th class='right aligned'>".$this->common_model->read_number_million($total_screen_flexo_coex_quantity)."</th>
							    	<th class='right aligned'>".$this->common_model->read_number_million($total_screen_flexo_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_screen_flexo_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".$this->common_model->read_number_million($total_offset_coex_quantity)."</th>
							    	<th class='right aligned'>".$this->common_model->read_number_million($total_offset_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_offset_coex_avg_price,2)."</th>


							    	<th class='right aligned'>".$this->common_model->read_number_million($total_label_coex_quantity)."</th>
							    	<th class='right aligned'>".$this->common_model->read_number_million($total_label_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_label_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".$this->common_model->read_number_million($total_coex_quantity)."</th>
							    	<th class='right aligned'>".round((($total_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
									<th class='right aligned'>".$this->common_model->read_number_million($total_coex_value)."</th>
									<th class='right aligned'>&#8377;".round($total_coex_avg_price,2)."</th>

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_digital_spring_quantity)."</th>
							    	<th class='right aligned'>".round((($total_digital_spring_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
									<th class='negative right aligned'>".$this->common_model->read_number_million($total_digital_spring_value)."</th>
									<th class='negative right aligned'>&#8377;".round($total_digital_spring_avg_price,2)."</th>

							    	<th class='right aligned'>".$this->common_model->read_number_million($total_sales_coex_spring_quantity)."</th>
							    	<th class='right aligned'>".round((($total_sales_coex_spring_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
							    	<th class='right aligned'>".$this->common_model->read_number_million($total_sales_coex_spring_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_sales_coex_spring_avg_price,2)."</th>

							  	</tr>
							  </tfoot></table>";

					}
				?>
					</div>
				</div>

		    </div>
		  </div>
		</div>
		<!--
		<div class="ui equal width grid">
		  <div class="equal width row">
		    

		    <div class="column">
		    	
		    	<div class="ui red segments">
		    		<div class="ui red segment">
					    <p><a  class="ui orange label">OTIF STATISTICS</a><a class="ui olive label"><i class="calendar icon"></i><?php echo date('d M y',strtotime($from_date));?> TO <?php echo date('d M y',strtotime($to_date));?></a></p>
					</div>
		    		<div class="ui segment">
		    			<table class="ui very basic collapsing celled table" style="font-size:9px;">
					      <thead>
					      <tr><td><b>STATISTICS</td><td><b>COUNT</td><td><b>%</td></tr>
		    			<?php
						setlocale(LC_MONETARY, 'en_IN');
						$total_order_dispatched_count=0;
						if($order_dispatched_count==FALSE){}else{
							foreach($order_dispatched_count as $order_dispatched_count_row){
								$total_order_dispatched_count=$order_dispatched_count_row->Orders_dispatched;
								echo "<tr><td>Number of Orders Dispatched</td><td>".$order_dispatched_count_row->Orders_dispatched."</td>
								<td>".(($total_order_dispatched_count/$total_order_dispatched_count)*100)."%</td></tr>";
								

					    	}
						}
						$total_order_completed_dispatched_count=0;
						if($order_completed_dispatched_count==FALSE){}else{
							foreach($order_completed_dispatched_count as $order_completed_dispatched_count_row){
								$total_order_completed_dispatched_count=$order_completed_dispatched_count_row->order_completed;
								echo "<tr><td>Number of Orders Completed</td><td>".$order_completed_dispatched_count_row->order_completed."</td><td>".round((($total_order_completed_dispatched_count/$total_order_dispatched_count)*100),0)."%</td></tr>";
								
					    	}
						}

						$total_order_short_completed_dispatched_count=0;
						if($order_short_completed_dispatched_count==FALSE){}else{
							foreach($order_short_completed_dispatched_count as $order_short_completed_dispatched_count_row){
								$total_order_short_completed_dispatched_count=$order_short_completed_dispatched_count_row->order_short_completed;
								echo "<tr><td>Number of Orders Short Closed</td><td>".$order_short_completed_dispatched_count_row->order_short_completed."</td>

								<td>".round((($total_order_short_completed_dispatched_count/$total_order_dispatched_count)*100),0)."%</td>

								</tr>";
								
					    	}
						}


						$total_open_order_count=0;
						if($open_order_count==FALSE){}else{
							foreach($open_order_count as $open_order_count_row){
								$total_open_order_count=$open_order_count_row->open_order;
								echo "<tr><td>Number of Orders Open</td><td>".$open_order_count_row->open_order."</td>

								<td>".round((($total_open_order_count/$total_order_dispatched_count)*100),0)."%</td></tr>";
								
					    	}
						}


					      	echo "<tr><td>--------------------</td><td>--------------------</td><td>---------------</td></tr>
					      	<tr><td><b>STATISTICS</td><td><b>VOLUME</td><td><b>%</td></tr>";

						$total_total_print_type_sales_quantity=0;
						$total_total_print_type_sales_value=0;
						if($print_type_wise_sales_coex==FALSE){}else{
							$total_screen_flexo_quantity=0;
						    $total_screen_flexo_value=0;
							$total_offset_quantity=0;
							$total_offset_value=0;
							$total_label_quantity=0;
							$total_label_value=0;
							$total_digital_quantity=0;
							$total_digital_value=0;
							foreach($print_type_wise_sales_coex as $row_coex){
							$total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO;
							$total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_VALUE;
							$total_offset_quantity+=$row_coex->OFFSET;
							$total_offset_value+=$row_coex->OFFSET_VALUE;
							$total_label_quantity+=$row_coex->LABEL;
							$total_label_value+=$row_coex->LABEL_VALUE;
							$total_digital_quantity+=$row_coex->DIGITAL;
							$total_digital_value+=$row_coex->DIGITAL_VALUE;
							}
							$total_total_print_type_sales_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity+$total_digital_quantity;
							$total_total_print_type_sales_value=$total_screen_flexo_value+$total_offset_value+$total_label_value+$total_digital_value;

							echo "<tr><td>Total Sales Volume</td><td>".$this->common_model->read_number_million($total_total_print_type_sales_quantity)."</td><td>".round((($total_total_print_type_sales_quantity/$total_total_print_type_sales_quantity)*100),0)."%</td></tr>";
							}

						$total_order_completed_dispatched_volume=0;
						if($order_completed_dispatched_volume==FALSE){}else{
							foreach($order_completed_dispatched_volume as $order_completed_dispatched_volume_row){
								$total_order_completed_dispatched_volume=$order_completed_dispatched_volume_row->full_dispatch_volume;
								echo "<tr><td>Completed Orders Volume</td><td>".$this->common_model->read_number_million($order_completed_dispatched_volume_row->full_dispatch_volume)."</td><td>".round((($total_order_completed_dispatched_volume/$total_total_print_type_sales_quantity)*100),0)."%</td></tr>";
								
					    	}
						}

						$total_order_short_completed_dispatched_volume=0;
						if($order_short_completed_dispatched_volume==FALSE){}else{
							foreach($order_short_completed_dispatched_volume as $order_short_completed_dispatched_volume_row){
								$total_order_short_completed_dispatched_volume=$order_short_completed_dispatched_volume_row->short_tubes;
								echo "<tr><td>Short Close Orders Volume</td><td>".$this->common_model->read_number_million($order_short_completed_dispatched_volume_row->short_tubes)."</td><td>".round((($total_order_short_completed_dispatched_volume/$total_total_print_type_sales_quantity)*100),0)."%</td></tr>";
								
					    	}
						}

						
						$total_order_open_dispatched_volume=0;
						if($order_open_dispatched_volume==FALSE){}else{
							foreach($order_open_dispatched_volume as $order_open_dispatched_volume_row){
								$total_order_open_dispatched_volume=$order_open_dispatched_volume_row->open_order_dispatch_volume;
								echo "<tr><td>Open Orders Volume</td><td>".$this->common_model->read_number_million($order_open_dispatched_volume_row->open_order_dispatch_volume)."</td><td>".($total_order_open_dispatched_volume<>0 ? round((($total_order_open_dispatched_volume/$total_total_print_type_sales_quantity)*100),0) : 0)."%</td></tr>";
								
					    	}
						}
						


						echo "<tr><td>--------------------</td><td>--------------------</td><td>---------------</td></tr>
					      	<tr><td><b>STATISTICS</td><td><b>VALUE</td></tr>";

						if($total_total_print_type_sales_value<>0){
							echo "<tr><td>Total Net Sales</td><td>".$this->common_model->read_number_million($total_total_print_type_sales_value)."</td></tr>";
						}

						$total_sales_total_order_completed_net=0;
						if($sales_total_order_completed_net==FALSE){}else{
							foreach($sales_total_order_completed_net as $sales_total_order_completed_net_row){
								echo "<tr><td>Completed Orders Net Sales</td><td>".$this->common_model->read_number_million($sales_total_order_completed_net_row->sales_values)."</td></tr>";
								$total_sales_total_order_completed_net=$sales_total_order_completed_net_row->sales_values;
					    	}
						}
						/*
						$total_sales_total_order_short_completed_net=0;
						if($sales_total_order_short_completed_net==FALSE){}else{
							foreach($sales_total_order_short_completed_net as $sales_total_order_short_completed_net_row){
								echo "<tr><td>Sales in Short</td><td>".$this->common_model->read_number_million($sales_total_order_short_completed_net_row->short_tubes_sales)."</td></tr>";
								$total_sales_total_order_short_completed_net=$sales_total_order_short_completed_net_row->short_tubes_sales;
					    	}
						}*/
						$sales_total_order_short_completed_net_value=0;
						if($sales_total_order_short_completed_net==FALSE){}else{
							foreach($sales_total_order_short_completed_net as $sales_total_order_short_completed_net_row){
								echo "<tr><td>Loss Due to Short Sales</td><td>".$this->common_model->read_number_million($sales_total_order_short_completed_net_row->short_tubes_sales)."</td></tr>";
								//$total_order_short_completed_dispatched_volume=$order_short_completed_dispatched_volume_row->short_tubes;
					    	}
						}

						?>
							</tbody>
						</table>
					</div>
				</div>
			
		    </div>

		  </div>
		</div>-->

  	</div>
</div>