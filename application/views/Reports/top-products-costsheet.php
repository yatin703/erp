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
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/ajax_top_products_costsheet');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),sleeve_dia : $('.sleeve_dia:checked').serialize(),print_type :$('.print_type').val(),customer_category:$("#customer_category").val() },
				cache: false,
				success: function(html){
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
									<?php /*
									if($account_periods_master==FALSE){
										echo "<tr><td>PLEASE SET THE FISCAL YEAR</td></tr>";
									}else{
									foreach ($account_periods_master as $account_periods_master_row ): */?>
									<tr>
										<td class="label"  width="25%">From Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="from_date" class="from_date" value="<?php echo set_value('from_date',date('Y-m-01'));?>"/></td>
										<td class="label"  width="25%">To Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="to_date" class="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
									<?php /*endforeach;
										}*/?>
									 
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
										<td class="label">Customer :</td>
										<td colspan="3" ><input type="text" name="customer_category" id="customer_category" size="40" value="<?php echo set_value('customer_category');?>"/></td>
						</tr>
						
						<tr>
							<td class="label">Print Type :</td>
							<td colspan="3"><select name="print_type" class="print_type"><option value=''>--Select Print Type--</option>
							<?php if($print_type==FALSE){
								echo "<option value=''>--Setup Required--</option>";}
							else{
								foreach($print_type as $print_type_row){
									echo "<option value='".$print_type_row->printing_group."'  ".set_select('print_type',''.$print_type_row->printing_group.'').">".$print_type_row->printing_group."</option>";
												}
								}?>
							</select>
							</td>
						</tr>
						<!--<tr>
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
									 													
										?>
								</td>
						</tr>
						<tr>
							<td class="label" width="25%">Convert</td>
							<td colspan="3"><select name="convert" class="convert">
								<option value="0">INR</option>
								<option value="1">Millions</option
							</select></td>
						</tr>-->
					</table>
				
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
					if($top_products_costsheet==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:9px;">
					        	<thead>
								   <tr>
								    	<th colspan="27"><a class="ui orange label">TOP PRODUCTS OF COSTSHEET</a>';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date(date('Y-m-01'),$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a>';
								    		}
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
								  	<th colspan="4">'.'<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date(date('Y-m-01'),$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a>'.'</th>
								  	<th colspan="4">
								  	'.'<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date(date('Y-m-01',strtotime('-6 month')),$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d',strtotime('last day of previous month')),$this->session->userdata['logged_in']['company_id']).'</a>'.'</th>
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

							//echo $this->db->last_query();
						
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
				</span>
			</div>
  		</div>		

	

	</div>
</div>