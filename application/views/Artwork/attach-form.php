
<?php foreach($artwork as $artwork_row):?>
	<?php
        $result_dia=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','1');

        foreach($result_dia as $dia_row){ $dia=$dia_row->parameter_value; }

        $result_length=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','2');

        foreach($result_length as $length_row){ $length=$length_row->parameter_value; }

        $result_sleeve_color=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','7');

        foreach($result_sleeve_color as $sleeve_color_row){ $sleeve_color=$sleeve_color_row->parameter_value; }

        $result_print_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','17');

        foreach($result_print_type as $print_type_row){ $print_ty=$print_type_row->parameter_value; }

       $result_printing_upto_neck=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','8');

        foreach($result_printing_upto_neck as $printing_upto_neck_row){ $printing_upto_neck=$printing_upto_neck_row->parameter_value; }

        $result_hot_foil=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','11');

        foreach($result_hot_foil as $hot_foil_row){ $hot_foil=$hot_foil_row->parameter_value; }

        $result_lacquer_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','12');

        foreach($result_lacquer_type as $lacquer_row){ $lacquer=$lacquer_row->parameter_value;}

        $result_sealing=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','5');

        foreach($result_sealing as $sealing_row){ $sealing=$sealing_row->parameter_value; }
    ?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/attach_update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

									<tr>
										<td class="label">Artwork No * :</td>
										<td><input type="text" name="artwork_no" size="10" value="<?php echo set_value('artwork_no',$artwork_row->ad_id);?>" readonly/>&nbsp;Version No * : <input type="text" name="version_no" size="4" value="<?php echo set_value('version_no',$artwork_row->version_no);?>" readonly/>
										<input type="hidden" name="record_no" value="<?php echo $artwork_row->ad_id.'@@@'.$artwork_row->version_no;?>">
										</td>
									</tr>

									<tr>
										<td class="label">Created By * :</td>
										<td><select name="user" readonly><option value=''>--Select User--</option>
													<?php if($user==FALSE){
																	echo "<option value=''>--User Setup Required--</option>";}
														else{
															foreach($user as $user_row){
																$selected=($user_row->user_id==$artwork_row->user_id ? 'selected':'');
																echo "<option value='".$user_row->user_id."' $selected>".$user_row->login_name."</option>";
															}
													}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Customer * :</td>
										<td><input type="text" name="customer" id="customer"  size="60" value="<?php echo set_value('customer',$artwork_row->customer_name."//".$artwork_row->adr_company_id);?>" readonly/></td>
									</tr>

									<tr>
										<td class="label">Article  * :</td>
										<td><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no',$artwork_row->article_name."//".$artwork_row->article_no);?>" readonly /></td>
									</tr>
									
									<tr>
										<td class="label">Dia * :</td>
										<td><select name="sleeve_dia" disabled><option value=''>--Select Sleeve Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													$selected=($sleeve_dia_row->sleeve_diameter==$dia ? 'selected' :'');
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."' $selected ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Length * :</td>
										<td><input type="text" name="sleeve_length" size="10" value="<?php echo set_value('sleeve_length',$length);?>" readonly></td>
									</tr>

									<tr>
										<td class="label">Sleeve Color * :</td>
										<td><input type="text" name="sleeve_color" value="<?php echo set_value('sleeve_color',$sleeve_color);?>" readonly></td>
									</tr>

									<tr>
										<td class="label">Print Type * :</td>
										<td><select name="print_type" disabled><option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($print_type as $print_type_row){
													$selected=($print_type_row->lacquer_type==$print_ty ? 'selected' :'');
													echo "<option value='".$print_type_row->lacquer_type."'  $selected ".set_select('print_type',''.$print_type_row->lacquer_type.'').">".$print_type_row->lacquer_type."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Printing upto neck * :</td>
										<td><select name="printing_upto_neck" disabled><option value="">--Select--</option>
											<option value="YES" <?php echo  set_select('printing_upto_neck', 'YES' ,$printing_upto_neck==="YES" ? TRUE : FALSE); ?>>YES</option>
											<option value="NO" <?php echo  set_select('printing_upto_neck', 'NO', $printing_upto_neck==="NO" ? TRUE : FALSE); ?>>NO</option>
										</select></td>
									</tr>

									<tr>
											<td></td>
											<td><input type="button" id="add_1" value="Add"><input type="button" id="remove_1" value="Remove"></td>
									</tr>
									<?php if($this->input->post('hot_foil')){
										for($i=1;$i<=count($this->input->post('hot_foil'));$i++){
											?>
											<tr id="hot_foil_<?php echo $i;?>">
												<td class="label">Hot Foil <?php echo $i;?> * :<input type="hidden" name="hot_foil[]" value="<?php echo $i;?>" /></td>
												<td><input type="text" name="hot_foil_<?php echo $i;?>" value="<?php echo set_value('hot_foil_'.$i.'');?>" readonly></td>
											</tr>
											<?php
										}

										}else{
											$hot_foil_count=substr($hot_foil, 0, strpos($hot_foil, '|'));
											$hot_foils=substr($hot_foil, strpos($hot_foil, "||") + 2);
											for($i=1;$i<=$hot_foil_count;$i++){
												$p=$i-1;
												$hot_foil_arr=explode("^",$hot_foils);
											?>

									<tr id="hot_foil_<?php echo $i;?>">
										<td class="label">Hot Foil <?php echo $i;?> * :<input type="hidden" name="hot_foil[]" value="<?php echo $i;?>" /></td>
										<td><input type="text" name="hot_foil_<?php echo $i;?>" value="<?php echo set_value('hot_foil_'.$i.'',$hot_foil_arr[$p]);?>" readonly></td>
									</tr>

									<?php 
										}
									} ?>

									

									<tr>
										<td class="label">Sealing Non Lacquring Area * :</td>
										<td><input type="text" name="sealing_non_lacquering_area" value="<?php echo set_value('sealing_non_lacquering_area',$sealing);?>" readonly></td>
									</tr>

									<tr>
											<td></td>
											<td><input type="button" id="add_2" value="Add"><input type="button" id="remove_2" value="Remove"></td>
									</tr>

									<?php if($this->input->post('lacquer_type')){
										for($i=1;$i<=count($this->input->post('lacquer_type'));$i++){
											?>
											<tr id="lacquer_type_<?php echo $i;?>">
												<td class="label">Lacquer Type <?php echo $i;?> * :<input type="hidden" name="lacquer_type[]" value="<?php echo $i;?>" /></td>
												<td><input type="text" name="lacquer_type_<?php echo $i;?>" value="<?php echo set_value('lacquer_type_'.$i.'');?>" readonly></td>
											</tr>
											<?php
										}

										}else{
											$lacquer_count=substr($lacquer, 0, strpos($lacquer, '|'));
											$lacquers=substr($lacquer, strpos($lacquer, "||") + 2);
											for($i=1;$i<=$lacquer_count;$i++){
												$p=$i-1;
												$lacquer_arr=explode("^",$lacquers);
											?>

									<tr id="lacquer_type_<?php echo $i;?>">
										<td class="label">Lacquer Type <?php echo $i;?> * :<input type="hidden" name="lacquer_type[]" value="<?php echo $i;?>"/></td>
										<td><input type="text" name="lacquer_type_<?php echo $i;?>" value="<?php echo set_value('lacquer_type_'.$i.'',$lacquer_arr[$p]);?>" readonly></td>
									</tr>
									<?php 
									}
									} ?>
									
				</table>
			</td>
			<td>
					<table class="form_table_inner">
						<?php if(!empty($artwork_row->artwork_image_nm)){
							echo '<tr>
														<td>Previous File</td>
														<td><a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$artwork_row->artwork_image_nm.'').'" ><i class="file pdf outline icon"></i></a></td>
												</tr>';
							}?>
						<tr>
								<td>File * :</td>
								<td><input type="file" name="userfile" /></td>
						</tr>

						<tr>
											<td class="label">Approval Authority :</td>
											<td><select name="approval_authority">
												<option value=''>--Select Authority--</option>
												<?php 
													foreach ($approval_authority as $approval_authority_row) {
													echo "<option value='".$approval_authority_row->employee_id."' ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
													}
												?>
											</select></td>
					</tr>
					<!--
						<tr>
								<td>Sent For Approval * :</td>
								<td><input type="checkbox" name="pending_flag" value="1" <?php echo set_checkbox('pending_flag',1);?>></td>
						</tr>-->

					</table>
				</td>
		</tr>
		</table>
					
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  <div class="or"></div>
	  <button class="ui positive button">Update</button>
		</div>
	</div>
		
</form>

<?php endforeach;?>
				
				
				
				
				
			