
<script>
	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();
		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/production_monthwise');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val()},cache: false,success: function(html){
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
										<td  width="25%"><input type="date" name="from_date" class="from_date"  value="<?php echo set_value('from_date',$account_periods_master_row->fin_year_start);?>"/></td>
										<td class="label"  width="25%">To Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="to_date" class="to_date"  value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
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
							if($extrusion==FALSE){

							}else{
								echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
							        	<thead>
										   <tr>
										    	<th colspan="10"><a class="ui orange label">COEX EXTRUSION</a>';
										    	if($account_periods_master==FALSE){
										    	}else{
										    		foreach ($account_periods_master as $account_periods_master_row ){
										    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
										    		}
										    	}
										    	echo '
										  </tr>

										  	<tr>
							        			<th colspan="2"></th>
							        			<th colspan="4" class="center aligned">EXTRUSION</th>
							        			<th colspan="1" class="center aligned">TOTAL</th>
							        		</tr>

							        		<tr>
							        			<th colspan="2"></th>
							        			<th class="right aligned">GCM 1</th>
							        			<th class="right aligned">GCM 2</th>
							        			<th class="right aligned">BRAYER 2</th>
							        			<th class="right aligned">BRAYER 3</th>
							        			<th class="right aligned">MONTHWISE TOTAL</th>
							        		</tr>


							        		<tr>
							        			<th> SR NO </th>
							        			<th>YEAR- MONTH</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			
							        		</tr>
							        	</thead>';


							 $count=1;
							 $total_gsm_1=0;
							 $total_gsm_2=0;
							 $total_breyer_2=0;
							 $total_breyer_3=0;
							 $total_extrusion=0;
							foreach($extrusion as $row){
								$total_row_extrusion=0;
								$total_row_extrusion=$row->GSM_1_SUM+$row->GSM_2_SUM+$row->BREYER_2_SUM+$row->BREYER_3_SUM;
								echo "<tr title='$row->PRODUCTION_MONTH'>
										<td><b>".$count."</b></td>
										<td><b>".$row->PRODUCTION_YEAR."-".strtoupper($row->PRODUCTION_MONTH)."</b></td>
										<td class='right aligned'>".money_format('%!.0n',$row->GSM_1_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->GSM_2_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->BREYER_2_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->BREYER_3_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$total_row_extrusion)."</td>
									</tr>";

									$count++;

								$total_gsm_1+=$row->GSM_1_SUM;
							    $total_gsm_2+=$row->GSM_2_SUM;
							    $total_breyer_2+=$row->BREYER_2_SUM;
							    $total_breyer_3+=$row->BREYER_3_SUM;
							    $total_extrusion+=$total_row_extrusion;
							    }

							    

							    echo "<thead>
									    <tr>
									    	<th colspan='2'>TOTAL</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_gsm_1)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_gsm_2)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_breyer_2)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_breyer_3)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_extrusion)."</th>
									    </tr>
									  </thead>";

								echo '</table>';
							}
						?>


						<?php
							setlocale(LC_MONETARY, 'en_IN');
							if($heading==FALSE){

							}else{
								echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
							        	<thead>
										   <tr>
										    	<th colspan="10"><a class="ui orange label">COEX HEADING</a>';
										    	if($account_periods_master==FALSE){
										    	}else{
										    		foreach ($account_periods_master as $account_periods_master_row ){
										    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
										    		}
										    	}
										    	echo '
										  </tr>

										  	<tr>
							        			<th colspan="2"></th>
							        			<th colspan="6" class="center aligned">HEADING</th>
							        			<th colspan="1" class="center aligned">TOTAL</th>
							        		</tr>

							        		<tr>
							        			<th colspan="2"></th>
							        			<th class="right aligned">AISA 1</th>
							        			<th class="right aligned">AISA 2</th>
							        			<th class="right aligned">AISA 3</th>
							        			<th class="right aligned">AISA 4</th>
							        			<th class="right aligned">AISA 5</th>
							        			<th class="right aligned">AISA 6</th>
							        			<th class="right aligned">MONTHWISE TOTAL</th>
							        		</tr>


							        		<tr>
							        			<th> SR NO </th>
							        			<th>YEAR- MONTH</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			
							        		</tr>
							        	</thead>';


							 $count=1;
							 $total_aisa_1=0;
							 $total_aisa_2=0;
							 $total_aisa_3=0;
							 $total_aisa_4=0;
							 $total_aisa_5=0;
							 $total_aisa_6=0;
							 $total_heading=0;
							foreach($heading as $row){
								$total_row_heading=0;
								$total_row_heading=$row->AISA_1_SUM+$row->AISA_2_SUM+$row->AISA_3_SUM+$row->AISA_4_SUM+$row->AISA_5_SUM+$row->AISA_6_SUM;
								echo "<tr title='$row->PRODUCTION_MONTH'>
										<td><b>".$count."</b></td>
										<td><b>".$row->PRODUCTION_YEAR."-".strtoupper($row->PRODUCTION_MONTH)."</b></td>
										<td class='right aligned'>".money_format('%!.0n',$row->AISA_1_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->AISA_2_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->AISA_3_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->AISA_4_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->AISA_5_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->AISA_6_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$total_row_heading)."</td>
									</tr>";

									$count++;

								$total_aisa_1+=$row->AISA_1_SUM;
							    $total_aisa_2+=$row->AISA_2_SUM;
							    $total_aisa_3+=$row->AISA_3_SUM;
							    $total_aisa_4+=$row->AISA_4_SUM;
							    $total_aisa_5+=$row->AISA_5_SUM;
							    $total_aisa_6+=$row->AISA_6_SUM;
							    $total_heading+=$total_row_heading;
							    }

							    

							    echo "<thead>
									    <tr>
									    	<th colspan='2'>TOTAL</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_aisa_1)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_aisa_2)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_aisa_3)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_aisa_4)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_aisa_5)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_aisa_6)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_heading)."</th>
									    </tr>
									  </thead>";

								echo '</table>';
							}
						?>

						<?php
							setlocale(LC_MONETARY, 'en_IN');
							if($printing==FALSE){

							}else{
								echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
							        	<thead>
										   <tr>
										    	<th colspan="10"><a class="ui orange label">COEX PRINTING</a>';
										    	if($account_periods_master==FALSE){
										    	}else{
										    		foreach ($account_periods_master as $account_periods_master_row ){
										    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
										    		}
										    	}
										    	echo '
										  </tr>

										  	<tr>
							        			<th colspan="2"></th>
							        			<th colspan="7" class="center aligned">PRINTING</th>
							        			<th colspan="1" class="center aligned">TOTAL</th>
							        		</tr>

							        		<tr>
							        			<th colspan="2"></th>
							        			<th class="right aligned">MOSS (OFFSET)</th>
							        			<th class="right aligned">BONMAC (OFFSET)</th>
							        			<th class="right aligned">POLYTYPE (OFFSET)</th>
							        			<th class="right aligned">POLYTYPE (LACQUER)</th>
							        			<th class="right aligned">ISIMAT (Screen)</th>
							        			<th class="right aligned">ISIMAT (Flexo)</th>
							        			<th class="right aligned">ISIMAT (FLEXO 2)</th>
							        			<th class="right aligned">MONTHWISE TOTAL</th>
							        		</tr>


							        		<tr>
							        			<th> SR NO </th>
							        			<th>YEAR- MONTH</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			
							        		</tr>
							        	</thead>';


							 $count=1;
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
								echo "<tr title='$row->PRODUCTION_MONTH'>
										<td><b>".$count."</b></td>
										<td><b>".$row->PRODUCTION_YEAR."-".strtoupper($row->PRODUCTION_MONTH)."</b></td>
										<td class='right aligned'>".money_format('%!.0n',$row->MOSS_OFFSET_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->BONMAC_OFFSET_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->POLYTYPE_OFFSET_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->POLYTYPE_LAC_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->ISIMAT_SCREEN_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->ISIMAT_FLEXO_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->ISIMAT_FLEXO_2_SUM)."</td>
										<td class='right aligned'>".money_format('%!.0n',$total_row_printing)."</td>
									</tr>";

									$count++;

								$total_moss_offset+=$row->MOSS_OFFSET_SUM;
								$total_bonmac_offset+=$row->BONMAC_OFFSET_SUM;
								$total_polytype_offset+=$row->POLYTYPE_OFFSET_SUM;
								$total_polytype_lac+=$row->POLYTYPE_LAC_SUM;
								$total_isimat_screen+=$row->ISIMAT_SCREEN_SUM;
								$total_isimat_flexo+=$row->ISIMAT_FLEXO_SUM;
								$total_isimat_flexo_2+=$row->ISIMAT_FLEXO_2_SUM;
							    $total_printing+=$total_row_printing;
							    }

							    

							    echo "<thead>
									    <tr>
									    	<th colspan='2'>GRAND TOTAL</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_moss_offset)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_bonmac_offset)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_polytype_offset)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_polytype_lac)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_isimat_screen)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_isimat_flexo)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_isimat_flexo_2)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_printing)."</th>
									    </tr>
									  </thead>";

								echo '</table>';
							}
						?>


						<?php
							setlocale(LC_MONETARY, 'en_IN');
							if($labeling==FALSE){

							}else{
								echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
							        	<thead>
										   <tr>
										    	<th colspan="10"><a class="ui orange label">COEX LABELING</a>';
										    	if($account_periods_master==FALSE){
										    	}else{
										    		foreach ($account_periods_master as $account_periods_master_row ){
										    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
										    		}
										    	}
										    	echo '
										  </tr>

										  	<tr>
							        			<th colspan="2"></th>
							        			<th colspan="3" class="center aligned">LABELING</th>
							        			<th colspan="1" class="center aligned">TOTAL</th>
							        		</tr>

							        		<tr>
							        			<th colspan="2"></th>
							        			<th class="right aligned">LABEL 2</th>
							        			<th class="right aligned">LABEL 3</th>
							        			<th class="right aligned">HALF LABEL</th>
							        			<th class="right aligned">MONTHWISE TOTAL</th>
							        		</tr>


							        		<tr>
							        			<th> SR NO </th>
							        			<th>YEAR- MONTH</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			
							        		</tr>
							        	</thead>';


							 $count=1;
							 $total_label_2=0;
							 $total_label_3=0;
							 $total_half_label=0;
							 $total_labeling=0;
							foreach($labeling as $row){
								$total_row_labeling=0;
								$total_row_labeling=$row->TECHNOSHEEL_LABEL_2+$row->TECHNOSHELL_HALF_LABEL+$row->TECHNOSHELL_LABEL_3;
								echo "<tr title='$row->PRODUCTION_MONTH'>
										<td><b>".$count."</b></td>
										<td><b>".$row->PRODUCTION_YEAR."-".strtoupper($row->PRODUCTION_MONTH)."</b></td>
										<td class='right aligned'>".money_format('%!.0n',$row->TECHNOSHEEL_LABEL_2)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->TECHNOSHELL_LABEL_3)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->TECHNOSHELL_HALF_LABEL)."</td>
										<td class='right aligned'>".money_format('%!.0n',$total_row_labeling)."</td>
									</tr>";

									$count++;

								$total_label_2+=$row->TECHNOSHEEL_LABEL_2;
								$total_label_3+=$row->TECHNOSHELL_LABEL_3;
								$total_half_label+=$row->TECHNOSHELL_HALF_LABEL;
							    $total_labeling+=$total_row_labeling;
							    }

							    

							    echo "<thead>
									    <tr>
									    	<th colspan='2'>GRAND TOTAL</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_label_2)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_label_3)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_half_label)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_labeling)."</th>
									    </tr>
									  </thead>";

								echo '</table>';
							}
						?>
					
						<?php
							setlocale(LC_MONETARY, 'en_IN');
							if($capping==FALSE){

							}else{
								echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
							        	<thead>
										   <tr>
										    	<th colspan="14"><a class="ui orange label">COEX CAPPING</a>';
										    	if($account_periods_master==FALSE){
										    	}else{
										    		foreach ($account_periods_master as $account_periods_master_row ){
										    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
										    		}
										    	}
										    	echo '
										  </tr>

										  	<tr>
							        			<th colspan="2"></th>
							        			<th colspan="7" class="center aligned">CAPPING</th>
							        			<th colspan="1" class="center aligned">TOTAL</th>
							        		</tr>

							        		<tr>
							        			<th colspan="2"></th>
							        			<th class="right aligned">MOSS CAPPING</th>
							        			<th class="right aligned">BONMAC CAPPING</th>
							        			<th class="right aligned">LABEL 2 CAPPING</th>
							        			<th class="right aligned">LABEL 3 CAPPING</th>
							        			<th class="right aligned">ISIMAT SCREEN CAPPING</th>
							        			<th class="right aligned">ISIMAT FLEXO CAPPING</th>
							        			<th class="right aligned">ISIMAT FLEXO 2 CAPPING</th>
							        			<th class="right aligned">MONTHWISE TOTAL</th>
							        		</tr>


							        		<tr>
							        			<th> SR NO </th>
							        			<th>YEAR- MONTH</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			
							        		</tr>
							        	</thead>';


							 $count=1;
							 $total_moss_capping=0;
							 $total_bonmac_capping=0;
							 $total_label_2_capping=0;
							 $total_label_3_capping=0;
							 $total_isimat_screen_capping=0;
							 $total_isimat_flexo_capping=0;
							 $total_isimat_flexo_2_capping=0;
							 $total_capping=0;
							foreach($capping as $row){
								$total_row_capping=0;
								$total_row_capping=$row->MOSS_CAPPING+$row->BONMAC_CAPPING+$row->LABEL_2_CAPPING+$row->LABEL_3_CAPPING+$row->ISIMAT_SCREEN_CAPPING+$row->ISIMAT_FLEXO_CAPPING+$row->ISIMAT_FLEXO_2_CAPPING;
								echo "<tr title='$row->PRODUCTION_MONTH'>
										<td><b>".$count."</b></td>
										<td><b>".$row->PRODUCTION_YEAR."-".strtoupper($row->PRODUCTION_MONTH)."</b></td>
										<td class='right aligned'>".money_format('%!.0n',$row->MOSS_CAPPING)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->BONMAC_CAPPING)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->LABEL_2_CAPPING)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->LABEL_3_CAPPING)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->ISIMAT_SCREEN_CAPPING)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->ISIMAT_FLEXO_CAPPING)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->ISIMAT_FLEXO_2_CAPPING)."</td>
										<td class='right aligned'>".money_format('%!.0n',$total_row_capping)."</td>
									</tr>";

									$count++;

								$total_moss_capping+=$row->MOSS_CAPPING;
								$total_bonmac_capping+=$row->BONMAC_CAPPING;
								$total_label_2_capping+=$row->LABEL_2_CAPPING;
								$total_label_3_capping+=$row->LABEL_3_CAPPING;
								$total_isimat_screen_capping+=$row->ISIMAT_SCREEN_CAPPING;
								$total_isimat_flexo_capping+=$row->ISIMAT_FLEXO_CAPPING;
								$total_isimat_flexo_2_capping+=$row->ISIMAT_FLEXO_2_CAPPING;

							    $total_capping+=$total_row_capping;
							    }

							    

							    echo "<thead>
									    <tr>
									    	<th colspan='2'>GRAND TOTAL</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_moss_capping)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_bonmac_capping)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_label_2_capping)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_label_3_capping)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_isimat_screen_capping)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_isimat_flexo_capping)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_isimat_flexo_2_capping)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_capping)."</th>
									    </tr>
									  </thead>";

								echo '</table>';
							}
						?>


						<?php
							setlocale(LC_MONETARY, 'en_IN');
							if($foiling==FALSE){

							}else{
								echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
							        	<thead>
										   <tr>
										    	<th colspan="6"><a class="ui orange label">COEX FOILING</a>';
										    	if($account_periods_master==FALSE){
										    	}else{
										    		foreach ($account_periods_master as $account_periods_master_row ){
										    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
										    		}
										    	}
										    	echo '
										  </tr>

										  	<tr>
							        			<th colspan="2"></th>
							        			<th colspan="3" class="center aligned">FOILING</th>
							        			<th colspan="1" class="center aligned">TOTAL</th>
							        		</tr>

							        		<tr>
							        			<th colspan="2"></th>
							        			<th class="right aligned">MADAG 2</th>
							        			<th class="right aligned">CER</th>
							        			<th class="right aligned">MADAG 3</th>
							        			<th class="right aligned">MONTHWISE TOTAL</th>
							        		</tr>


							        		<tr>
							        			<th> SR NO </th>
							        			<th>YEAR- MONTH</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			
							        		</tr>
							        	</thead>';


							 $count=1;
							 $total_madag_2=0;
							 $total_cer=0;
							 $total_madag_3=0;
							 $total_foiling=0;
							foreach($foiling as $row){
								$total_row_foiling=0;
								$total_row_foiling=$row->MADAG_2+$row->CER+$row->MADAG_3;
								echo "<tr title='$row->PRODUCTION_MONTH'>
										<td><b>".$count."</b></td>
										<td><b>".$row->PRODUCTION_YEAR."-".strtoupper($row->PRODUCTION_MONTH)."</b></td>
										<td class='right aligned'>".money_format('%!.0n',$row->MADAG_2)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->CER)."</td>
										<td class='right aligned'>".money_format('%!.0n',$row->MADAG_3)."</td>
										<td class='right aligned'>".money_format('%!.0n',$total_row_foiling)."</td>
									</tr>";

									$count++;

								$total_madag_2+=$row->MADAG_2;
								$total_cer+=$row->CER;
								$total_madag_3+=$row->MADAG_3;
								$total_foiling+=$total_row_foiling;
							    }

							    

							    echo "<thead>
									    <tr>
									    	<th colspan='2'>GRAND TOTAL</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_madag_2)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_cer)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_madag_3)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$total_foiling)."</th>
									    </tr>
									  </thead>";

								echo '</table>';
							}
						?>



						<?php
							setlocale(LC_MONETARY, 'en_IN');
							if($spring_printing==FALSE){

							}else{
								echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
							        	<thead>
										   <tr>
										    	<th colspan="6"><a class="ui orange label">SPRING PRINTING</a>';
										    	if($account_periods_master==FALSE){
										    	}else{
										    		foreach ($account_periods_master as $account_periods_master_row ){
										    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
										    		}
										    	}
										    	echo '
										  </tr>

										  	<tr>
							        			<th colspan="2"></th>
							        			<th class="center aligned">SPRING PRINTING</th>
							        			<th colspan="1" class="center aligned">TOTAL</th>
							        		</tr>

							        		<tr>
							        			<th colspan="2"></th>
							        			<th class="right aligned">ABG-DURST</th>
							        			<th class="right aligned">MONTHWISE TOTAL</th>
							        		</tr>


							        		<tr>
							        			<th> SR NO </th>
							        			<th>YEAR- MONTH</th>
							        			<th class="right aligned">QUANTITY</th>
							        			<th class="right aligned">QUANTITY</th>
							        			 
							        			
							        		</tr>
							        	</thead>';


							 $count=1;
							 $grand_total=0;
							
							foreach($spring_printing as $row){
								 
								$grand_total+=$row->SPRING_PRINTING;
								echo "<tr title='$row->PRODUCTION_MONTH'>
										<td><b>".$count."</b></td>
										<td><b>".$row->PRODUCTION_YEAR."-".strtoupper($row->PRODUCTION_MONTH)."</b></td>
										<td class='right aligned'>".money_format('%!.0n',$row->SPRING_PRINTING)."</td>
										
										<td class='right aligned'>".money_format('%!.0n',$row->SPRING_PRINTING)."</td>
									</tr>";

									$count++;

								
							    }

							    

							    echo "<thead>
									    <tr>
									    	<th colspan='2'>GRAND TOTAL</th>
									    	<th class='right aligned'>".money_format('%!.0n',$grand_total)."</th>
									    	<th class='right aligned'>".money_format('%!.0n',$grand_total)."</th>

									    	
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