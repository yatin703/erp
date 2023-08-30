
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		
		$(".toggler").click(function(e){
        e.preventDefault();
        $('.cat'+$(this).attr('data-prod-cat')).toggle();
		});

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
		
		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/top_customer_sales_diawise');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),convert:$('.convert').val(),sleeve_dia : $('.sleeve_dia:checked').serialize(),inv_type : $('.inv_type:checked').serialize()},cache: false,success: function(html){
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
										echo "<tr><td>PLEASE SET THE FISCAL YEAR</td></tr>";
									}else{
									foreach ($account_periods_master as $account_periods_master_row ):?>
									<tr>
										<td class="label"  width="25%">From Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="from_date" class="from_date" value="<?php echo set_value('from_date',$account_periods_master_row->fin_year_start);?>"/></td>
										<td class="label"  width="25%">To Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="to_date" class="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
									<?php endforeach;
										}?>
									<!--
									<tr>
										<td class="label">Customer Group :</td>
										<td colspan="3" ><select name="customer_category" id="customer_category" ><option value=''>--Select Category--</option>
										<?php if($customer_category==FALSE){

													echo "<option value=''>--Setup Required--</option>";

												}else{
													foreach($customer_category as $customer_category_row){
														echo "<option value='".$customer_category_row->adr_category_id."'  ".set_select('customer_category',''.$customer_category_row->adr_category_id.'').">".$customer_category_row->category_name."</option>";
												
													}
												}
												?></select></td>
									</tr>-->
									<!--
									<tr>
										<td class="label">Customer   :</td>
										<td colspan="3" ><input type="text" name="customer" id="customer"  size="60" value="<?php echo set_value('customer');?>" /></td>
									</tr>
									-->
									
									<tr>
										<td class="label" width="25%">Diameter :</td>
										<td width="25%">
												<?php if($sleeve_dia==FALSE){
												}else{
													foreach($sleeve_dia as $sleeve_dia_row){
													echo '<div class="ui checkbox">
													<input type="checkbox" name="sleeve_dia" class="sleeve_dia" value="'.$sleeve_dia_row->sleeve_diameter.'" checked><label>'.$sleeve_dia_row->sleeve_diameter.'</label>
													</div>';
													}
												}
												?>
										</td>
										<!--
										<td class="label" width="25%">Domestic/Export  :</td>
										<td width="25%"><select name="for_export" id="for_export" >

												<option value="">--Please Select--</option>
												<option value="2" <?php echo set_select('for_export','2');?>>Domestic</option>
												<option value="1" <?php echo set_select('for_export','1');?> >Export</option>
												
											</select>
										</td>-->
									</tr>
								
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
				<table>
						<tr>
							<td class="label" width="25%"> Invoice Types  :</td>
								<td colspan="3">
									<a id="check-all" class="submit-green" href="javascript:void(0);">Check all</a>
									<a id="uncheck-all" class="submit-green" href="javascript:void(0);">Uncheck all</a>
									<br/>
										<?php
										

											echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="1" checked><label>Inter State Sales (1)</label>
													</div><br/>';

											echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="2" checked><label>Local Sales (2)</label>
													</div><br/>';

											echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="3" checked><label>Local Export Sales(ANN-45) (3)</label>
													</div><br/>';

											echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="8" checked><label>SEZ Export Sales (8)</label>
													</div><br/>';

											echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="11" checked><label>Export Sales (11)</label>
													</div><br/>';
													/*
										if($invoice_types_master_lang==FALSE){


										}else{
											foreach($invoice_types_master_lang as $row){
													echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="'.$row->inv_type_id.'" checked><label>'.$row->lang_inv_type.'</label>
													</div><br/>';
											}
										}*/
																						
										?>
								</td>
						</tr>
						<tr>
							<td class="label" width="25%">Convert</td>
							<td colspan="3"><select name="convert" class="convert">
								<option value="0">INR</option>
								<option value="1">Millions</option
							</select></td>
						</tr>
					</table>
					<!--
					<table class="form_table_inner">
						<tr>
							<td class="label" width="25%"></td>
							<td width="75%"><span id="hello"></span></td>
						</tr>
					</table>-->
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
					if($top_customer_coex==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:9px;">
					        	<thead>
								   <tr>
								    	<th colspan="27"><a class="ui orange label">SALES TOP CUSTOMER</a>';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a>';
								    		}
								    	}
								    	echo '</th>
								  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th></th>
					        			<th colspan="14" class="center aligned">COEX TUBE</th>
					        			<th colspan="5" class="center aligned">SPRING TUBE</th>
					        			<th colspan="5" class="center aligned">GRAND TOTAL</th>
					        		</tr>
								  	<tr>
					        			<th colspan="2"></th>
					        			<th></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="5" class="center aligned">COEX TOTAL</th>
					        			<th colspan="5" class="center aligned">DIGITAL</th>
					        			<th colspan="5" class="center aligned">TOTAL</th>
					        		</tr>
								  <tr>
					        			<th>SR NO</th>
					        			<th>CUSTOMER</th>
					        			<th>DIA</th>
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
					        			<th class="right aligned">V %</th>
					        			<th class="right aligned">AVG</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">Q %</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">V %</th>
					        			<th class="right aligned">AVG</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">Q %</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">V %</th>
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


						?>


						<script>
							$(document).ready(function(){
								$(".tr_<?php echo $count;?>").hide();
								$("#id_<?php echo $count;?>").on("click", function(){
								    $(".tr_<?php echo $count;?>").slideToggle(1000);
								    $("#idd_<?php echo $count;?>").toggleClass('plus icon');
								    $("#idd_<?php echo $count;?>").toggleClass('minus icon');
								  });

							});

						</script>

						<?php

						echo "<tr id='id_".$count."' title ='$row_coex->customer' "; echo $a=($count>10 ? "class='cat1' style='display:none'" : "NO");  echo ">
								<td>$count</td>
								<td><b>$row_coex->customer</b></td>
								<td><i id='idd_".$count."' class='plus icon'></i></td>
								<td class='negative right aligned'>".($row_coex->SCREEN_FLEXO<>0 ? money_format('%!.0n',$row_coex->SCREEN_FLEXO) : '-')."</td>
								<td class='negative right aligned'>".($row_coex->SCREEN_FLEXO_VALUE<>0 ? money_format('%.0n',$row_coex->SCREEN_FLEXO_VALUE) : "-")."</td>
								<td class='negative right aligned'>".($screen_flexo_avg_price<>0 ? "&#8377;".round($screen_flexo_avg_price,2) : "-")."</td>
								<td class='positive right aligned'>".($row_coex->OFFSET<>0 ? money_format('%!.0n',$row_coex->OFFSET) : "-")."</td>
								<td class='positive right aligned'>".($row_coex->OFFSET_VALUE<>0 ? money_format('%.0n',$row_coex->OFFSET_VALUE) : "-")."</td>
								<td class='positive right aligned'>".($offset_avg_price<>0 ? "&#8377;".round($offset_avg_price,2) : "")."</td>

								<td class='right aligned'>".($row_coex->LABEL<>0 ? money_format('%!.0n',$row_coex->LABEL) : "-")."</td>
								<td class='right aligned'>".($row_coex->LABEL_VALUE<>0 ? money_format('%.0n',$row_coex->LABEL_VALUE) : "-")."</td>
								<td class='right aligned'>".($label_avg_price<>0 ? "&#8377;".round($label_avg_price,2) : "-")."</td>

								<td class='active right aligned'>".($total_row_sales_coex_quantity<>0 ? money_format('%!.0n',$total_row_sales_coex_quantity) : "-")."</td>
								<td class='active right aligned'>".($total_row_sales_coex_quantity<>0 ? round((($total_row_sales_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%" : "-")."</td>
								<td class='active right aligned'>".($total_row_sales_coex_value<>0 ? money_format('%.0n',$total_row_sales_coex_value) : "-")."</td>
								<td class='active right aligned'>".($total_row_sales_coex_value<>0 ? round((($total_row_sales_coex_value/$total_sales_coex_spring_value_for_per)*100))."%" : "-")."</td>
								<td class='active right aligned'>".($total_row_coex_avg_price<>0 ? "&#8377;".round($total_row_coex_avg_price,2) : "")."</td>

								<td class='negative right aligned'>".($row_coex->DIGITAL<>0 ? money_format('%!.0n',$row_coex->DIGITAL) : "-")."</td>
								<td class='negative right aligned'>".($row_coex->DIGITAL<>0 ? round((($row_coex->DIGITAL/$total_sales_coex_spring_quantity_for_per)*100))."%" : "-")."</td>
								<td class='negative right aligned'>".($row_coex->DIGITAL_VALUE<>0 ? money_format('%.0n',$row_coex->DIGITAL_VALUE) : "-")."</td>
								<td class='negative right aligned'>".($row_coex->DIGITAL_VALUE<>0 ? round((($row_coex->DIGITAL_VALUE/$total_sales_coex_spring_value_for_per)*100))."%" : "-")."</td>
								<td class='negative right aligned'>".($digital_avg_price<>0 ? "&#8377;".round($digital_avg_price,2) : "-")."</td>

								<td class='active right aligned'>".($row_coex->sale_quantity<>0 ? money_format('%!.0n',$row_coex->sale_quantity) : "-")."</td>
								<td class='active right aligned'>".($row_coex->sale_quantity<>0 ? round((($row_coex->sale_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%" : "-")."</td>
								<td class='active right aligned'>".($row_coex->value<>0 ? money_format('%.0n',$row_coex->value) : "-")."</td>
								<td class='active right aligned'>".($row_coex->value<>0 ? round((($row_coex->value/$total_sales_coex_spring_value_for_per)*100))."%" : "-")."</td>
								<td class='active right aligned'>".($avg_coex_rate<>0 ? "&#8377;".round($avg_coex_rate,2) : "-")."</td>
							</tr>";

							$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

							if($data['account_periods_master']==FALSE){
					          $from_date="";
					        }else{
					          foreach($data['account_periods_master'] as $account_periods_master_row){
					            $from_date=$account_periods_master_row->fin_year_start;
					          }
					        }


							$top_customer_diawise=$this->sales_invoice_book_model->select_top_customer_diawise('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'),$row_coex->customer_no,'','');

							if($top_customer_diawise==TRUE){
							foreach($top_customer_diawise as $top_row){

								$top_avg_coex_rate=($top_row->value/$top_row->sale_quantity);
								$top_screen_flexo_avg_price=0;
								$top_screen_flexo_avg_price=($top_row->SCREEN_FLEXO_VALUE!=0 ? $top_row->SCREEN_FLEXO_VALUE/$top_row->SCREEN_FLEXO : 0);
								$top_offset_avg_price=0;
								$top_offset_avg_price=($top_row->OFFSET_VALUE!=0 ? $top_row->OFFSET_VALUE/$top_row->OFFSET : 0);
								$top_label_avg_price=0;
								$top_label_avg_price=($top_row->LABEL_VALUE!=0 ? $top_row->LABEL_VALUE/$top_row->LABEL : 0);
								$top_digital_avg_price=0;
								$top_digital_avg_price=($top_row->DIGITAL_VALUE!=0 ? $top_row->DIGITAL_VALUE/$top_row->DIGITAL : 0);

								$top_total_row_sales_coex_quantity=0;
								$top_total_row_sales_coex_quantity=$top_row->SCREEN_FLEXO+$top_row->OFFSET+$top_row->LABEL;

								$top_total_row_sales_coex_value=0;
								$top_total_row_sales_coex_value=$top_row->SCREEN_FLEXO_VALUE+$top_row->OFFSET_VALUE+$top_row->LABEL_VALUE;

								$top_total_row_coex_avg_price=0;
								$top_total_row_coex_avg_price=($top_total_row_sales_coex_value!=0 ? ($top_total_row_sales_coex_value/$top_total_row_sales_coex_quantity) : 0);


								echo "<tr class='tr_".$count."' title ='$row_coex->customer' "; echo $a=($count>10 ? "class='cat1' style='display:none'" : "NO");  echo ">

											<td></td>
											<td></td>
											<td><b>$top_row->sleeve_dia</b></td>
											<td class='negative right aligned'>".($top_row->SCREEN_FLEXO<>0 ? money_format('%!.0n',$top_row->SCREEN_FLEXO) : '-')."</td>
											<td class='negative right aligned'>".($top_row->SCREEN_FLEXO_VALUE<>0 ? money_format('%.0n',$top_row->SCREEN_FLEXO_VALUE) : '-')."</td>
											<td class='negative right aligned'>".($top_screen_flexo_avg_price<>0 ? "&#8377;".round($top_screen_flexo_avg_price,2) : '-')."</td>
											<td class='positive right aligned'>".($top_row->OFFSET<>0 ? money_format('%!.0n',$top_row->OFFSET) : '-')."</td>
											<td class='positive right aligned'>".($top_row->OFFSET_VALUE<>0 ? money_format('%.0n',$top_row->OFFSET_VALUE) : '-')."</td>
											<td class='positive right aligned'>".($top_offset_avg_price<>0 ? "&#8377;".round($top_offset_avg_price,2) : '-')."</td>

											<td class='right aligned'>".($top_row->LABEL<>0 ? money_format('%!.0n',$top_row->LABEL) : '')."</td>
											<td class='right aligned'>".($top_row->LABEL_VALUE<>0 ? money_format('%.0n',$top_row->LABEL_VALUE) : '-')."</td>
											<td class='right aligned'>".($top_label_avg_price<>0 ? "&#8377;".round($top_label_avg_price,2) : '-')."</td>

											<td class='active right aligned'>".($top_total_row_sales_coex_quantity<>0 ? money_format('%!.0n',$top_total_row_sales_coex_quantity) : '-')."</td>
											<td class='active right aligned'>".($top_total_row_sales_coex_quantity<>0 ? round((($top_total_row_sales_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%" : "-")."</td>

											<td class='active right aligned'>".($top_total_row_sales_coex_value<>0 ? money_format('%.0n',$top_total_row_sales_coex_value) : '-')."</td>
											<td class='active right aligned'>".($top_total_row_sales_coex_value<>0 ? round((($top_total_row_sales_coex_value/$total_sales_coex_spring_value_for_per)*100))."%" : '-')."</td>

											<td class='active right aligned'>".($top_total_row_coex_avg_price<>0 ? "&#8377;".round($top_total_row_coex_avg_price,2) : '-')."</td>

											<td class='negative right aligned'>".($top_row->DIGITAL<>0 ? money_format('%!.0n',$top_row->DIGITAL) : '-')."</td>
											<td class='negative right aligned'>".($top_row->DIGITAL<>0 ? round((($top_row->DIGITAL/$total_sales_coex_spring_quantity_for_per)*100))."%" : "-")."</td>

											<td class='negative right aligned'>".($top_row->DIGITAL_VALUE<>0 ? money_format('%.0n',$top_row->DIGITAL_VALUE) : '-')."</td>
											<td class='negative right aligned'>".($top_row->DIGITAL_VALUE<>0 ? round((($top_row->DIGITAL_VALUE/$total_sales_coex_spring_value_for_per)*100))."%" : "-")."</td>
											<td class='negative right aligned'>".($top_digital_avg_price<>0 ? "&#8377;".round($top_digital_avg_price,2) : "-")."</td>

											<td class='active right aligned'>".($top_row->sale_quantity<>0 ? money_format('%!.0n',$top_row->sale_quantity) : '')."</td>
											<td class='active right aligned'>".($top_row->sale_quantity<>0 ? round((($top_row->sale_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%" : "-")."</td>
											<td class='active right aligned'>".($top_row->value<>0 ? money_format('%.0n',$top_row->value) : "-")."</td>
											<td class='active right aligned'>".($top_row->value<>0 ? round((($top_row->value/$total_sales_coex_spring_value_for_per)*100))."%" : "-")."</td>
											<td class='active right aligned'>".($top_avg_coex_rate<>0 ? "&#8377;".round($top_avg_coex_rate,2) : "-")."</td>
										

										</tr>";

							}
						}else{

						}


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

					        	echo "<thead><tr>
										<th colspan='2'>TOP 10 TOTAL</th>
										<th></th>
										<th class='negative right aligned'>".money_format('%!.0n',$total_ten_screen_flexo_coex_quantity)."</th>
										<th class='negative right aligned'>".money_format('%.0n',$total_ten_screen_flexo_coex_value)."</th>
										
										<th class='negative right aligned'>&#8377;".round($total_ten_screen_flexo_coex_avg_price,2)."</th>
										<th class='positive right aligned'>".money_format('%!.0n',$total_ten_offset_coex_quantity)."</th>
										<th class='positive right aligned'>".money_format('%.0n',$total_ten_offset_coex_value)."</th>
										<th class='positive right aligned'>&#8377;".round($total_ten_offset_coex_avg_price,2)."</th>
										
										<th class='right aligned'>".money_format('%!.0n',$total_ten_label_coex_quantity)."</th>
										<th class='right aligned'>".money_format('%.0n',$total_ten_label_coex_value)."</th>
										<th class='right aligned'>&#8377;".round($total_ten_label_coex_avg_price,2)."</th>

										<th class='right aligned'>".money_format('%!.0n',$total_ten_coex_quantity)."</th>
										<th class='right aligned'>".round((($total_ten_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
										<th class='right aligned'>".money_format('%.0n',$total_ten_coex_value)."</th>
										<th class='right aligned'>".round((($total_ten_coex_value/$total_sales_coex_spring_value_for_per)*100))."%</th>
										<th class='right aligned'>&#8377;".round($total_ten_coex_avg_price,2)."</th>

										<th class='negative right aligned'>".money_format('%!.0n',$total_ten_digital_spring_quantity)."</th>
										<th class='right aligned'>".round((($total_ten_digital_spring_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
										<th class='negative right aligned'>".money_format('%.0n',$total_ten_digital_spring_value)."</th>
										<th class='right aligned'>".round((($total_ten_digital_spring_value/$total_sales_coex_spring_value_for_per)*100))."%</th>
										<th class='negative right aligned'>&#8377;".round($total_ten_digital_spring_avg_price,2)."</th>

										<th class='warning right aligned'>".money_format('%!.0n',$total_ten_sales_coex_spring_quantity)."</th>
										<th class='warning right aligned'>".round((($total_ten_sales_coex_spring_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>

										<th class='warning right aligned'>".money_format('%.0n',$total_ten_sales_coex_spring_value)."</th>
										<th class='warning right aligned'>".round((($total_ten_sales_coex_spring_value/$total_sales_coex_spring_value_for_per)*100))."%</th>
										<th class='warning right aligned'>&#8377;".round($total_ten_sales_coex_spring_avg_price,2)."</th>
							        </tr></thead>";

					        }

					        

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


					       	echo "</tbody><thead>
							    <tr>
							    	<th colspan='2'><a href='#'' class='toggler' data-prod-cat='1'>OTHER TOTAL</a></th>
							    	<th></th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_other_screen_flexo_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_screen_flexo_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_screen_flexo_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_other_offset_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_offset_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_offset_coex_avg_price,2)."</th>


							    	<th class='right aligned'>".money_format('%!.0n',$total_other_label_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_label_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_label_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_other_coex_quantity)."</th>
							    	<th class='right aligned'>".round((($total_other_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_coex_value)."</th>
									<th class='right aligned'>".round((($total_other_coex_value/$total_sales_coex_spring_value_for_per)*100))."%</th>
									<th class='right aligned'>&#8377;".round($total_other_coex_avg_price,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_other_digital_spring_quantity)."</th>
							    	<th class='right aligned'>".round((($total_other_digital_spring_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
									<th class='negative right aligned'>".money_format('%.0n',$total_other_digital_spring_value)."</th>
									<th class='right aligned'>".round((($total_other_digital_spring_value/$total_sales_coex_spring_value_for_per)*100))."%</th>
									<th class='negative right aligned'>&#8377;".round($total_other_digital_spring_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_other_sales_coex_quantity)."</th>
							    	<th class='right aligned'>".round((($total_other_sales_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_sales_coex_value)."</th>
							    	<th class='right aligned'>".round((($total_other_sales_coex_value/$total_sales_coex_spring_value_for_per)*100))."%</th>
							    	<th class='right aligned'>&#8377;".round($total_other_sales_coex_avg_price,2)."</th>

							  	</tr>
							  </thead>";


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

						 echo "<thead>
							    <tr>
							    	<th colspan='3'>GRAND TOTAL</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_screen_flexo_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_screen_flexo_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_screen_flexo_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_offset_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_offset_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_offset_coex_avg_price,2)."</th>


							    	<th class='right aligned'>".money_format('%!.0n',$total_label_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_label_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_label_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_coex_quantity)."</th>
							    	<th class='right aligned'>".round((($total_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
									<th class='right aligned'>".money_format('%.0n',$total_coex_value)."</th>
									<th class='right aligned'>".round((($total_coex_value/$total_sales_coex_spring_value_for_per)*100))."%</th>
									<th class='right aligned'>&#8377;".round($total_coex_avg_price,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_digital_spring_quantity)."</th>
							    	<th class='right aligned'>".round((($total_digital_spring_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
									<th class='negative right aligned'>".money_format('%.0n',$total_digital_spring_value)."</th>
									<th class='right aligned'>".round((($total_digital_spring_value/$total_sales_coex_spring_value_for_per)*100))."%</th>
									<th class='negative right aligned'>&#8377;".round($total_digital_spring_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_sales_coex_spring_quantity)."</th>
							    	<th class='right aligned'>".round((($total_sales_coex_spring_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_sales_coex_spring_value)."</th>
							    	<th class='right aligned'>".round((($total_sales_coex_spring_value/$total_sales_coex_spring_value_for_per)*100))."%</th>
							    	<th class='right aligned'>&#8377;".round($total_sales_coex_spring_avg_price,2)."</th>

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