<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();


		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});

		$("#check-all").hide();
		$('#check-all').click(function(){
			$(".inv_type").prop('checked', true);
			$("#uncheck-all").show();
			$("#check-all").hide();
			
		});
		$('#uncheck-all').click(function(){
			$("#check-all").show();
			$(".inv_type").attr('checked', false);
			$("#uncheck-all").hide();
		});
		
		
		$(".toggler").click(function(e){
        e.preventDefault();
        $('.cat'+$(this).attr('data-prod-cat')).toggle();
		});

		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/ajax_top_products_costsheet');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),sleeve_dia : $('.sleeve_dia:checked').serialize(),print_type :$('.print_type').val(),customer_category:$("#customer_category").val()},
				cache: false,
				success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#check").html(html);
				} 
			});
		});


});

</script>
  
 
	<?php
		setlocale(LC_MONETARY, 'en_IN');
		if($top_products_costsheet==FALSE){

		}else{
			echo '<table class="ui sortable selectable celled table" style="font-size:9px;">
		        	<thead>
					   <tr>
					    	<th colspan="27"><a class="ui orange label">TOP PRODUCTS OF COSTSHEET</a>'.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '');

					    	if(!empty($sleeve_dia_data)){

								    		$arr=explode(",",$sleeve_dia_data);
								    		foreach($arr as $sld){
								    			$sld=str_replace("'","",$sld);
								    			echo '<a class="ui label">'.$sld.'</a>';
								    		}
								    		echo "<br/><br/>";
								    	}
 
					    	echo '</th>
					  </tr>
					  <tr>
					        <th colspan="6"></th>
					        <th colspan="4">CURRENT MONTH</th>
					        <th colspan="3">LAST 6 MONTH</th>

					  </tr>
					  <tr>
								  	<th colspan="6"></th>
								  	<th colspan="4">'.'<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a>'.'</th>
								  	<th colspan="4">
								  	'.'<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date(date('Y-m-01',strtotime('-6 month',strtotime($from_date))),$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d',strtotime('last day of previous month',strtotime($from_date))),$this->session->userdata['logged_in']['company_id']).'</a>'.'</th>
								  </tr>

								  <tr>
					        			<th colspan="6"></th>
					        			<th>SALES QTY</th>
					        			<th colspan="3">AVG</th>
					        			<th>SALES QTY</th>
					        			<th colspan="3">AVG</th>

					        		</tr>
					  <tr>
					        			<th>SR NO</th>
					        			<th>CUSTOMER</th>
					        			<th>PRODUCT</th>
					        			<th>PRODUCT NAME</th>
					        			<th>DIA</th>
					        			<th>PRINT TYPE</th>
					        			<th class="right aligned">SALES QTY</th>
					        			<th class="right aligned">SALES PRICE</th>
					        			<th class="right aligned">COST/TUBE</th>
					        			<th class="right aligned">CONTR/TUBE</th>
					        			<th class="right aligned">SALES QTY</th>
					        			<th class="right aligned">SALES  PRICE</th>
					        			<th class="right aligned">COST/TUBE</th>
					        			<th class="right aligned">CONTR/TUBE</th>

					  </tr>
		        	</thead>
		        <tbody>';
		 $i=1;
		 $last_count=0;
		 $total_dispatch_quantity=0;
		 $total_dispatch_quantity_last_three_month=0;
		 $grand_total_dispatch_quantity=0;

		 $total_fifteen_dispatch_quantity=0;
		 $total_fifteen_dispatch_quantity_last_three_month=0;
		 $grand_total_fifteen_dispatch_quantity_last_three_month=0;

			foreach ($top_products_costsheet as $key => $row) {

				
				$data=array('article_no'=>$row->article_no);

				$data['top_products_costsheet']=$this->sales_invoice_book_model->select_top_product_by_costsheet('costsheet_master',$this->session->userdata['logged_in']['company_id'],date('Y-m-01',strtotime('-6 month')),date('Y-m-d',strtotime('last day of previous month')),'','','',$data);
			
				echo '<tr  '.$a=($i>15 ? 'class="cat1" style="display:none"' : "NO").'>
						<td>'.$i.'</td>
						<td>'.$this->common_model->get_parent_name($row->article_no,$this->session->userdata['logged_in']['company_id']).'</td>
						<td>'.$row->article_no.'</td>
						<td>'.$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id']).'</td>
						<td>'.$row->dia.'</td>
						<td>'.$row->print_type.'</td>
						<td class="right aligned">'.money_format('%!.0n',$row->dispatch_quantity).'</td>
						<td class="positive right aligned">&#8377;'.round($row->avg_price,2).'</td>
						<td class="negative right aligned">&#8377;'.round($row->avg_cost,2).'</td>			
						<td class="active right aligned">&#8377;'.round($row->avg_contribution,2).'</td>';

						if($data['top_products_costsheet']==FALSE){

							echo '<td colspan="4">---</td>';

						}else{

							foreach($data['top_products_costsheet'] as $top_products_costsheet_row){

									echo '<td class="right aligned">'.money_format('%!.0n',$top_products_costsheet_row->dispatch_quantity).'</td>
									  <td class="positive right aligned">&#8377;'.round($top_products_costsheet_row->avg_price,2).'</td>
									  <td class="negative right aligned">&#8377;'.round($top_products_costsheet_row->avg_cost,2).'</td>			
									  <td class="active right aligned">&#8377;'.round($top_products_costsheet_row->avg_contribution,2).'</td>';
									  $total_fifteen_dispatch_quantity_last_three_month+=$top_products_costsheet_row->dispatch_quantity;
									}
						}

						echo '</tr>';

						$total_fifteen_dispatch_quantity+=$row->dispatch_quantity;

						if($i==15){
								echo '<thead>
										<tr>
											<th>TOP 15 TOTAL</th>
											<th colspan="5"></th>
											<th class="right aligned">'.money_format('%!.0n',$total_fifteen_dispatch_quantity).'</th>
											<th colspan="3"></th>
											<th class="right aligned">'.money_format('%!.0n',$total_fifteen_dispatch_quantity_last_three_month).'</th>
										</tr>
									</thead>';
							}

						if($i>15){

								$total_dispatch_quantity+=$row->dispatch_quantity;
								$total_dispatch_quantity_last_three_month+=$top_products_costsheet_row->dispatch_quantity;
							}

							$grand_total_dispatch_quantity+=$row->dispatch_quantity;

					$i++;

			}

			 echo "</tbody>
						 <thead>
						 <tr>
							<th colspan='6'><a href='#'' class='toggler' data-prod-cat='1'>OTHER TOTAL</a></th>
							<th class='right aligned'>".money_format('%!.0n',$total_dispatch_quantity)."</th>
							<th colspan='3'></th>
							<th class='right aligned'>".money_format('%!.0n',$total_dispatch_quantity_last_three_month)."</th>
						</tr>
						</thead>
						<thead>
						 <tr>
							<th colspan='6'>GRAND TOTAL</th>
							<th class='right aligned'>".money_format('%!.0n',$grand_total_dispatch_quantity)."</th>
							<th colspan='3'></th>
							<th class='right aligned'>".money_format('%!.0n',$total_fifteen_dispatch_quantity_last_three_month+$total_dispatch_quantity_last_three_month)."</th>
						</tr>
						</thead>
						</table>";
		}
	?>
		 