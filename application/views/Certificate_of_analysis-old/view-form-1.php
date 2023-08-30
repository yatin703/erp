<style>
	input{width: 100%;}
	.align-ctr{text-align: center;}
	.align-ctr1{text-align: center;}
	.align-lft{text-align: left !important;}
    td.label.align-ctr{vertical-align: middle;}
    select{width: 100%;}
    .span-h{font-size: 16px;
    border-bottom: 1px solid #000000;}
   .span-required{color: red;}
   .bbtm{border-right:1px solid #D9d9d9;}
   .bbt{border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;}
   .bg-parameter{background: #dffcfc;}
   .invoice-box table tr td:nth-child(2) {
    text-align: center;
}
.bbtr{
	border-right: 1px solid #D9d9d9;
    border-bottom: 0px solid #D9d9d9;
}
</style>
      
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        CERTIFICATE OF ANALYSIS 
      </div>
    </div>
        
        <?php echo $certificate_of_analysis['final_approval_flag']==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/>

        <?php echo $this->common_model->view_date($certificate_of_analysis['inspection_date'],$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($certificate_of_analysis['inspection_date'],$this->session->userdata['logged_in']['company_id']).' '.''.'</span>' : '';
        ?>
        
        <br/>
        <br/>

      <table class="form_table_inner" width="100%" cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
			<tr class="">
				<td width="20%" class="label bbt bg-parameter"><b>Certificate No.</b></td>
				<td width="30%" class="align-lft bbt" colspan="2"><?php echo $certificate_of_analysis['certificate_no'];?></td> 
				<td width="20%" class="label bbt bg-parameter"><b>Date</b></td>
				<td width="30%" class="align-lft bbt" colspan="2"><?php echo $certificate_of_analysis['inspection_date'];?></td>
			</tr> 

			<tr>
                <td width="20%" class="label bbt bg-parameter"><b>Customer Name</b></td>
				<td width="30%" class="align-lft  bbt" colspan="2"><?php echo $certificate_of_analysis['customer_name'];?></td> 
                <td width="20%" class="label bbt bg-parameter"><b>AQL</b></td>
				<td width="30%" class="align-lft bbt" colspan="2"><?php echo $certificate_of_analysis['quality'];?></td> 
			</tr>
                         
			<tr>
	            <td width="20%" class="label bbt bg-parameter"><b>Product</b></td>
				<td width="30%" class="align-lft bbt" colspan="2"><?php echo $certificate_of_analysis['product_name'];?></td> 
                <td width="20%" class="label bbt bg-parameter"><b>Total Qty</b></td>
				<td width="30%" class="align-lft bbt" colspan="2"><?php echo $certificate_of_analysis['total_qty'];?></td> 
			</tr>
                        
	        <tr>
	            <td width="20%" class="label bbtm bg-parameter"><b>SO NO.</b></td>
				<td width="30%" class="align-lft bbtm" colspan="2"><?php echo $certificate_of_analysis['so_no'];?></td> 
				<td width="20%" class="label bbtm bg-parameter"><b>Sample Size</b></td>
				<td width="30%" class="align-lft bbtm" colspan="2"><?php echo $certificate_of_analysis['sample_size'];?></td> 
			</tr>
    </table>

		<table class="form_table_inner" width="100%" cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">	

			<tr>
				<td class="label align-ctr bbt bg-parameter" colspan="6"><b><span class="span-h">Dimensional Compliance</span></b></td>
				<td class="label align-ctr bbt bg-parameter" style="text-align: center !important;" colspan="2"><b><span class="span-h">Multilayer - </span></b></td>
			</tr>
			<tr>
				<td class="label align-ctr1 bbt" rowspan="9" ><b>Process</b> <br><br> <i style="margin-top: 70px;" class="arrow down icon"></i></td>
				<td class="label align-ctr1 bbt" rowspan="9" style="text-align: center !important;" ><b>Parameter</b> <br><br> <i style="margin-top: 70px;" class="arrow down icon"></i></td>
				<td class="label align-ctr1 bbt" rowspan="9"><b>Specification<br>(mm)</b> <br> <i style="margin-top: 70px;" class="arrow down icon"></i></td>
				<td class="label align-ctr1 bbt" rowspan="9"><b>Tolerance<br>(mm)</b><br> <i style="margin-top: 70px;" class="arrow down icon"></i></td>
				<td class="label align-ctr1 bbt" rowspan="9"><b>Actual<br>(mm) </b><br> <i style="margin-top: 70px;" class="arrow down icon"></i></td>
				<td class="label align-ctr1 bbt" rowspan="9"><b>Raw Material<br>(Monolayer/Multilayer)  </b> <br> <i class="arrow right icon"></i></td>
			</tr>
      
      
      <?php
         //$layer = array('1st','2nd','3rd','4th','5th','6th','7th'); 
	       $layer_no     = '7';
	       $bom_no       = $certificate_of_analysis['bom_no'];
	       $version_no   = $certificate_of_analysis['version_no'];
	       for($i=1; $i<=$layer_no;$i++){
	    ?> 

				<tr>
					<td class="label align-ctr bbt"><?php echo $i; ?> Layer</td>
					<td class="label align-ctr bbt">
					 <?php if($i==1){
						  $parameter_data=array('LDPE','LLDPE');	
						  if($parameter_data!=''){
	              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
	            }else{
	            	echo '-';
	            }

	            if (!empty($result[0]->LDPE_PC && $result[0]->LLDPE_PC)) {
              echo ($result[0]->LDPE_PC != null ? $result[0]->LDPE_PC : '-')."% LDPE"." "."+"; echo ($result[0]->LLDPE_PC != null ? $result[0]->LLDPE_PC : '-')."% LLDPE";
							 } else {
								echo '-';
							} 
						} 
					?>
					
					<?php if($i==2){
							$parameter_data=array('LLDPE','HDPE');	
						  if($parameter_data!=''){
	              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
	            }else{
	            	echo '-';
	            }
	             if (!empty($result[0]->LLDPE_PC && $result[0]->HDPE_PC)) {
	            echo ($result[0]->LLDPE_PC != null ? $result[0]->LLDPE_PC : '-')."% LLDPE"." "."+"; echo ($result[0]->HDPE_PC != null ? $result[0]->HDPE_PC : '-')."% HDPE";
							 } else {
								echo '-';
							} 
					  } 
					?>
					<?php if($i==3){
						$parameter_data=array('ADMER');	
						  if($parameter_data!=''){
	              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
	            }else{
	            	echo '-';
	            }

	            if (!empty($result[0]->ADMER_PC)) { 
							  echo ($result[0]->ADMER_PC != null ? $result[0]->ADMER_PC : '-')."% ADMER";
							} else {
								echo '-';
							}
						}
          ?>
          <?php if($i==4){
						$parameter_data=array('EVOH');	
						  if($parameter_data!=''){
	              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
	            }else{
	            	echo '-';
	            }

	            if (!empty($result[0]->EVOH_PC)) { 
							  echo ($result[0]->EVOH_PC != null ? $result[0]->EVOH_PC : '-')."% EVOH";
							  } else {
								echo '-';
							}
						}
          ?>
          <?php if($i==5){
						$parameter_data=array('ADMER');	
						  if($parameter_data!=''){
	              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
	            }else{
	            	echo '-';
	            }

	            if (!empty($result[0]->ADMER_PC)) { 
							  echo ($result[0]->ADMER_PC != null ? $result[0]->ADMER_PC : '-')."% ADMER";
							} else {
								echo '-';
							}
						}
          ?>
          <?php if($i==6){
					  $parameter_data=array('LLDPE','HDPE');	
					  if($parameter_data!=''){
              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
            }else{
            	echo '-';
            }
             if (!empty($result[0]->LLDPE_PC && $result[0]->HDPE_PC)) {
            echo ($result[0]->LLDPE_PC != null ? $result[0]->LLDPE_PC : '-')."% LLDPE"." "."+"; echo ($result[0]->HDPE_PC != null ? $result[0]->HDPE_PC : '-')."% HDPE";
						 } else {
							echo '-';
						} 
					} ?>
					<?php if($i==7){
					  $parameter_data=array('LDPE','LLDPE');	
					  if($parameter_data!=''){
              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
            }else{
            	echo '-';
            }
             if (!empty($result[0]->LDPE_PC && $result[0]->LLDPE_PC)) {
            echo ($result[0]->LDPE_PC != null ? $result[0]->LDPE_PC : '-')."% LDPE"." "."+"; echo ($result[0]->LLDPE_PC != null ? $result[0]->LLDPE_PC : '-')."% LLDPE";
						 } else {
							echo '-';
						} 
					} ?>
          </td>
				</tr>
      <?php } ?>
					
            <tr>
							<td class="label bbt">&nbsp;&nbsp;&nbsp;</td>
							<td class="label bbt">&nbsp;&nbsp;&nbsp;</td>
						</tr>
			 
						<tr>
							<td class="label align-ctr bbt" rowspan="12"><b>SLEEVE</b></td>
							<td class="label align-ctr bbt" rowspan="3"><b>Length</b></td>
							<td class="label align-ctr bbt" rowspan="3"><?php echo $certificate_of_analysis['specification_length'];?></td>
							<td class="label align-ctr bbt" rowspan="3">+/-1.5</td>
							<td class="label align-ctr bbt" rowspan="3"><?php echo $certificate_of_analysis['actual_length'];?></td>
							<td class="label align-ctr bbt" rowspan="3"><b>Master Batch %</b><br>(Monolayer/Multilayer)</td>
						</tr>


						<tr>
							<td class="label align-ctr bbt">Inner Layer</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['sleeve_inner_per'];?>% / <?php echo $certificate_of_analysis['sleeve_inner_layer_color'];?></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">Outer Layer</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['sleeve_outer_per'];?>% / <?php echo $certificate_of_analysis['sleeve_outer_layer_color'];?></td>
						</tr>
						

						<tr>
							<td class="label align-ctr bbt" rowspan="8"><b>Inner Dia</b></td>
							<td class="label align-ctr bbt" rowspan="8"><?php echo $certificate_of_analysis['specification_inner_dia'];?></td>
							<td class="label align-ctr bbt" rowspan="8">+/-0.3</td>
							<td class="label align-ctr bbt" rowspan="8"><?php echo $certificate_of_analysis['actual_inner_dia']; ?></td>
							<td class="label align-ctr bbt" rowspan="9"><b>Sleeve Thickness (Micron)</b><br>(Monolayer/Multilayer)</td>
						</tr>
      <?php 
	       $layer_no     = '7';
	       $bom_no       = $certificate_of_analysis['bom_no'];
	       $version_no   = $certificate_of_analysis['version_no'];
	       for($i=1; $i<=$layer_no;$i++){
	    ?> 

						<tr>
							<td class="label align-ctr bbt"><?php echo $i; ?> Layer</td>
							<td class="label align-ctr bbt">
								<?php if($i==1){
									$parameter_data=array('GUAGE');	
									  if($parameter_data!=''){
				              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
				            }else{
				            	echo '-';
				            }

				            if (!empty($result[0]->GUAGE)) { 
										  echo ($result[0]->GUAGE != null ? $result[0]->GUAGE : '-')." micron";
										} else {
											echo '-';
										}
									}
			          ?>
								<?php if($i==2){
									$parameter_data=array('GUAGE');	
									  if($parameter_data!=''){
				              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
				            }else{
				            	echo '-';
				            }

				            if (!empty($result[0]->GUAGE)) { 
										  echo ($result[0]->GUAGE != null ? $result[0]->GUAGE : '-')." micron";
										} else {
											echo '-';
										}
									}
			          ?>
								<?php if($i==3){
									$parameter_data=array('GUAGE');	
									  if($parameter_data!=''){
				              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
				              $this->db->last_query();
				            }else{
				            	echo '-';
				            }

				            if (!empty($result[0]->GUAGE)) { 
										  echo ($result[0]->GUAGE != null ? $result[0]->GUAGE : '-')." micron";
										} else {
											echo '-';
										}
									}
			          ?>
								<?php if($i==4){
									$parameter_data=array('GUAGE');	
									  if($parameter_data!=''){
				              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
				            }else{
				            	echo '-';
				            }

				            if (!empty($result[0]->GUAGE)) { 
										  echo ($result[0]->GUAGE != null ? $result[0]->GUAGE : '-')." micron";
										} else {
											echo '-';
										}
									}
			          ?>
								<?php if($i==5){
									$parameter_data=array('GUAGE');	
									  if($parameter_data!=''){
				              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
				            }else{
				            	echo '-';
				            }

				            if (!empty($result[0]->GUAGE)) { 
										  echo ($result[0]->GUAGE != null ? $result[0]->GUAGE : '-')." micron";
										} else {
											echo '-';
										}
									}
			          ?>

			          <?php if($i==6){
									$parameter_data=array('GUAGE');	
									  if($parameter_data!=''){
				              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
				            }else{
				            	echo '-';
				            }

				            if (!empty($result[0]->GUAGE)) { 
										  echo ($result[0]->GUAGE != null ? $result[0]->GUAGE : '-')." micron";
										} else {
											echo '-';
										}
									}
			          ?>

			          <?php if($i==7){
									$parameter_data=array('GUAGE');	
									  if($parameter_data!=''){
				              $result=$this->certificate_of_analysis_model->get_layer_details($bom_no,$version_no,$i,$parameter_data);
				            }else{
				            	echo '-';
				            }

				            if (!empty($result[0]->GUAGE)) { 
										  echo ($result[0]->GUAGE != null ? $result[0]->GUAGE : '-')." micron";
										} else {
											echo '-';
										}
									}
			          ?>

							</td>
						</tr>
          <?php } ?>


						<tr>
							<td class="label align-ctr bbt" rowspan=""><b>Outer. Dia</b></td>
							<td class="label align-ctr bbt" rowspan=""><?php echo $certificate_of_analysis['specification_outer_dia']; ?></td>
							<td class="label align-ctr bbt"  rowspan="">+/-0.3</td>
							<td class="label align-ctr bbt" rowspan=""> <?php echo $certificate_of_analysis['actual_outer_dia'];?></td>
													</tr>


						<tr>
							<td class="label align-ctr bbt" rowspan="3"><b>SHOULDER</td>
							<td class="label align-ctr bbt"><b>Parameter</b></td>
							<td class="label align-ctr bbt"><b>Specification<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Tolerance<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Actual<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Raw Material</b></td>
							<td class="label align-ctr bbt" style="border-top: 1px solid #d9d9d9;" colspan="2">HDPE</td>
						</tr>
						
						<tr>
							<td class="label align-ctr bbt"><b>Thread Type</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['shoulder_thread_type'];?></td>
							<td class="label align-ctr bbt"></td>
							<td class="label align-ctr bbt"><b>Master Batch</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['SHOULDER_MASTER_BATCH_COLOR'];?></td>
						</tr>
						
						<tr>
							<td class="label align-ctr bbt"><b>Orifice</b></td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['specification_orifice'];?></td>
							<td class="label align-ctr bbt"> <?php echo $certificate_of_analysis['tolerance_orifice'];?></td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['actual_orifice'];?></td>
							<td class="label align-ctr bbt"><b>% Master Batch</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['master_batch_orifice'];?>%</td>
						</tr>


						<tr>
							<td class="label align-ctr bbt" rowspan="6"><b>CAP</b></td>
							<td class="label align-ctr bbt"><b>Parameter</b></td>
							<td class="label align-ctr bbt"><b>Specification<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Tolerance<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Actual<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Raw Material</b></td>
							<td class="label align-ctr bbt" colspan="2">PP</td>
						</tr>

						
						<tr>
							<td class="label align-ctr bbt"><b>Type</b></td>
							<td class="label align-ctr align-ctr bbt" colspan="3"><?php echo $certificate_of_analysis['cap_type'];?></td>
							<td class="label align-ctr bbt"><b>Master Batch</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['cap_master_batch_colour'];?></td>
						</tr>
						
						<tr>
							<td class="label align-ctr bbt"><b>Diameter</b></td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['specification_diameter'];?></td>
							<td class="label align-ctr bbt">+/-0.2</td>
							<td class="label align-ctr bbt"> <?php echo $certificate_of_analysis['actual_diameter'];?></td>
							<td class="label align-ctr bbtr" rowspan="2"><b>% Master Batch</b></td>
							<td class="label align-ctr bbtr" colspan="2" rowspan="2"><?php echo $certificate_of_analysis['master_batch_diameter'];?>%</td>
						</tr>

						<tr>
							<td class="label align-ctr bbt"><b>Height</b></td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['specification_height'];
						?></td>
							<td class="label align-ctr bbt">+/-0.2</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['actual_height'];?></td>
							
							
						</tr>

						
						<tr>
							<td class="label align-ctr bbt"><b>Cap Orifice</b></td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['specification_cap_orifice'];?></td>
							<td class="label align-ctr bbt">+/-0.2</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['actual_cap_orifice'];?></td>
							<td class="label align-ctr bbtr">&nbsp;&nbsp;&nbsp;</td>
							<td class="label align-ctr bbtr" colspan="2">&nbsp;&nbsp;&nbsp;</td>
						</tr>
						
						<tr>
							<td class="label align-ctr bbt"><b>Shrink Sleeve</b></td>
							<td class="label align-ctr bbt" colspan="3"><?php echo $certificate_of_analysis['specification_shrink_sleeve'];?></td>
							<td class="label align-ctr bbtr" >&nbsp;&nbsp;&nbsp;</td>
							<td class="label align-ctr bbtr" colspan="2">&nbsp;&nbsp;&nbsp;</td>
						</tr>

						<tr>
							<td class="label align-ctr bbt"><b>PRINT</b></td>
							<td class="label align-ctr bbt"><b>Non. Lacq. Area</b></td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['specification_print'];?></td>
							<td class="label align-ctr bbt">+/-1</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['actual_print'];?></td>
							<td class="label align-ctr bbt"><b>Lacquer Type</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['lacquer_type'];?></td>
						</tr>
						
					

						<tr>
							<td class="label align-lft bbt bg-parameter" colspan="8"><b><span class="span-h">TESTNIG PARAMETERS:</span></b></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">1.</td>
							<td  class="label align-lft bbt" colspan="2">Air Leakage</td>
							<td class="label align-ctr bbt"> 
							 <?php if($certificate_of_analysis['air_leakage_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['air_leakage_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?></td>

							<td class="label align-ctr bbt">9.</td>
							<td class="label align-lft bbt" colspan="2">Sleeve colour Opacity</td>
							<td class="label align-ctr bbt">
							<?php if($certificate_of_analysis['sleeve_colour_opacity_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['sleeve_colour_opacity_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>

						</tr>
						<tr>
							 <td class="label align-ctr bbt">2.</td>
							<td class="label align-lft bbt" colspan="2">Water Package</td>
							<td class="label align-ctr bbt">
               <?php if($certificate_of_analysis['water_package_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['water_package_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
                            </td>

							<td class="label align-ctr bbt">10.</td>
							<td  class="label align-lft bbt" colspan="2">Gliding Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['gliding_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['gliding_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
                            </td>
							</td>
							
						</tr>
						<tr>
							<td class="label align-ctr bbt">3.</td>
							<td  class="label align-lft  bbt" colspan="2">Cap Fitment</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['cap_fitment_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['cap_fitment_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?></td>
							<td class="label align-ctr bbt">11.</td>
							<td class="label align-lft bbt" colspan="2">U.V Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['uv_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['uv_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							</td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">4.</td>
							<td  class="label align-lft bbt" colspan="2">Shoulder Welding Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['shoulder_welding_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['shoulder_welding_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							</td>
							<td class="label align-ctr bbt">12.</td>
							<td class="label align-lft bbt" colspan="2">Drop Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['drop_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['drop_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">5.</td>
							<td  class="label align-lft bbt" colspan="2">ESCR Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['escr_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['escr_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							</td>
							<td class="label align-ctr bbt">13.</td>
							<td class="label align-lft bbt" colspan="2">Tape Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['tape_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['tape_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							 </td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">6.</td>
							<td  class="label align-lft bbt" colspan="2">Odour Test</td>
							<td class="label align-ctr bbt">
                             <?php if($certificate_of_analysis['odour_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['odour_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?></td>
							<td class="label align-ctr bbt">14.</td>
							<td class="label align-lft bbt" colspan="2">Rub Test</td>
							<td class="label align-ctr bbt">
							<?php if($certificate_of_analysis['rub_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['rub_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">7.</td>
							<td  class="label align-lft bbt" colspan="2">Vertically Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['vertically_test_status']  =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['vertically_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							 </td>
							<td class="label align-ctr bbt">15.</td>
							<td class="label align-lft bbt" colspan="2">Sealing Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['sealing_test_status']  =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['sealing_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							</td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">8.</td>
							<td  class="label align-lft bbt" colspan="2">Sleeve Colour Difference</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['sleeve_colour_difference_status']  =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['bar_code_test_status']  =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							 </td>
							<td class="label align-ctr bbt">16.</td>
							<td class="label align-lft bbt" colspan="2">Bar Code Test</td>
							<td class="label align-ctr bbt"> 
                             <?php if($certificate_of_analysis['bar_code_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['bar_code_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							</td>
						</tr>
						<tr>
							<td class="label align-lft bg-parameter" colspan="8"><b><span class="span-h">TESTNIG PARAMETERS: SPRING</span></b></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">17.</td>
							<td  class="label align-lft bbt" colspan="2">Welding Test Side Seam</td>
							<td class="label align-ctr bbt">
								 <?php if($certificate_of_analysis['welding_test_side_seam_status'] =='1'){
								 	echo 'PASS';
								 }elseif($certificate_of_analysis['welding_test_side_seam_status'] =='2'){
	                                echo 'FAIL';
								 }else{
								 	echo 'N/A';
								 }?>
						    </td>
							<td class="label align-ctr bbt" colspan="4"></td>

						</tr>
						<tr>
							<td class="label align-lft bbt bg-parameter" colspan="8"><b><span class="span-h">SAMPLING PARAMETERS:</span></b></td>
						</tr>
						<tr>
							<td class="label align-lft bbt" colspan="2"><b>Total Number Of Pallets</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['total_number_of_pallets'];?></td>
							<td class="label align-lft bbt" colspan="2"><b>Sample Per Pallets</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['sample_per_pallets']; ?></td>
						</tr>
						<tr>
							<td  class="label align-lft bbt" colspan="2"><b>Number Of Pallets Rechecked</b></td>
							<td  class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['number_of_pallets_rechecked']; ?></td>
							<td  class="label align-lft bbt" colspan="2"><b>Result</b></td>
							<td class="label align-ctr bbt" colspan="2">
                            <?php if($certificate_of_analysis['coa_result_status'] =='1'){
							 	echo 'PASS';
							 }else{
							 	echo 'FAIL';
							 }?>
							</td>
						</tr>
						<tr>
							<td  class="label align-lft bbt" colspan="2"><b>Prepared</b></td>
							<td  class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['prepared_name']; ?></td>
							<td  class="label align-lft bbt" colspan="2"><b>Approved By</b></td>
							<td  class="label align-ctr bbt" colspan="2"><?php echo (empty($certificate_of_analysis['approval_username']) ? '-' : strtoupper($certificate_of_analysis['approval_username'])); ?>
						</tr>	
					
			    </td>
					</table>

    
</body>
</html>           
