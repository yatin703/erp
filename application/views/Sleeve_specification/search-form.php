<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
   $(document).ready(function(){
      $("#loading").hide(); $("#cover").hide();
      $("#article_no").autocomplete("<?php echo base_url('index.php/ajax/sleeve_autocomplete');?>", {selectFirst: true});

   });
</script>

<script>
	function validate_form(){

		var x=document.getElementById("form1");
		var flag=0;
		for(i=0;i<x.length;i++){
			
			if(x.elements[i].value!='' && x.elements[i].name!='' &&  x.elements[i].name!='from_date' && x.elements[i].name!='to_date'){
				flag=1;								
			}
			if(document.getElementById('from_date').value!='' && document.getElementById('to_date').value!=''){
				flag=1;	
			}
		}

		if(flag==1){
			return true;
		}else{
			alert('From Date And To Date Should not be Blank.');

			if(document.getElementById('from_date').value==''){
				document.getElementById('from_date').focus();
				return false;
			}
			else{
				document.getElementById('to_date').focus();
				return false;
			}
			    
		}		
					
		
	}

</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" id="form1" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="100%">
					<table class="form_table_inner">
								<?php foreach ($account_periods_master as $account_periods_master_row ):?> 
              
            		
									<tr>
										<td class="label" >From Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>"/></td>
										<td class="label" >To Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"/></td>
									</tr>
								<?php endforeach;?>
									<tr>
										<td class="label">Sleeve Com No * :</td>
										<td colspan="3">
											<input type="text" name="article_no" id="article_no" size="67" maxlength="200" value="<?php echo set_value('article_no');?>"/>
										</td>
									</tr>


									<tr>
										<td class="label">Dia  :</td>
										<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select></td>
										<td class="label">Length  :</td>
										<td> <input type="text" name="sleeve_length" id="sleeve_length" size="17" maxlength="6" value="<?php echo set_value('sleeve_length');?>">
										</td>
									</tr>
									<tr>
										<td class="label">Layer  :</td>
										<td><select name="dyn_qty_present" id="dyn_qty_present"><option value=''>--Select Layer--</option>
											<option value="SLEEVE|1">1</option>
											<option value="SLEEVE|2">2</option>
											<option value="SLEEVE|3">3</option>
											<option value="SLEEVE|5">5</option>
										</select>
										<td class="label"> Approval Status :</td>
										<td >
											<select name="final_approval_flag" id="final_approval_flag" >
												<option value="">--Please Select--</option>
												<option value="1" <?php echo set_select('final_approval_flag','1'); ?> >Approved</option>
												<option value="0" <?php echo set_select('final_approval_flag','0'); ?>>Not Approved</option>
											</select>

										</td>
									</tr>
									<tr>
										<td class="label">Created By :</td>
										<td><select name="user_id" id="user_id">
											<option value=''>--Select User--</option>
											<?php 
											foreach ($user_master as $user_master_row) {
							             echo "<option value='".$user_master_row->user_id."' ".set_select('user_id',$user_master_row->user_id).">".strtoupper($user_master_row->login_name)."</option>";
							             }
							             ?>
							            </select></td>
							           
							           

							        </tr>
									<tr><td class="label">&nbsp;</td><td class="label" colspan="3">&nbsp;</td></tr>

									<tr><td class="label"><b>Outer Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="text" name="sleeve_guage" id="sleeve_guage" maxlength="3" size="3" value="<?php echo set_value('sleeve_guage');?>"></td>
									</tr>

									<tr>
										<td class="label">MB <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_master_batch" id="sleeve_master_batch"><option value=''>--Select MB--</option>
										<?php foreach ($masterbatch as $masterbatch_row) {
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('sleeve_master_batch',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}?></select></td>

										<td>
										<input type="text" name="sleeve_mb_perc" id="sleeve_mb_perc" maxlength="3" size="3" value="<?php echo set_value('sleeve_mb_perc');?>" placeholder="%">
										<!--
										<input type="text" name="sl_mb_supplier" class="supplier" size="60"  value="<?php echo set_value('sleeve_mb_supplier');?>" placeholder="MB Supplier">-->
										</td>
									</tr>

									<tr>
										<td class="label">LDPE <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_ldpe" id="sleeve_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sleeve_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sleeve_ldpe_pecr" id="sleeve_ldpe_perc" maxlength="3" size="3" value="<?php echo set_value('sleeve_ldpe_perc');?>" placeholder="%"></td>
									</tr>

									<tr>
										<td class="label">LLDPE <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_lldpe" id="sleeve_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sleeve_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sleeve_lldpe_perc" id="sleeve_lldpe_perc" maxlength="3" size="3" value="<?php echo set_value('sleeve_lldpe_perc');?>" placeholder="%"></td>
									</tr>

									<tr>
										<td class="label">HDPE  :</td>
										<td><select name="sleeve_hdpe" id="sleeve_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sleeve_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sleeve_hdpe_perc"  id="sleeve_hdpe_perc" maxlength="3" size="3" value="<?php echo set_value('sleeve_hdpe_perc');?>" placeholder="%"></td>
									</tr>

									<tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

									<tr><td class="label"><b>Second Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="text" name="sleeve_guage_two" id="sleeve_gauge_two" maxlength="3" size="3" value="<?php echo set_value('sleeve_guage_two');?>"></td>
									</tr>
									<tr>
	                              		<td class="label">Admer  :</td>
	                              		<td><select name="sleeve_admer_two" id="sleeve_admer_two">
	                              		<option value=''>--Select Admer--</option>
	                              		<?php
			                              foreach ($admer as $admer_row) {
			                                 echo "<option value='".$admer_row->article_no."' ".set_select('sleeve_admer_two',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
			                              }
			                              ?>
			                              </select>  
			                            </td>
		                               <td>
		                              	<input type="text" name="sleeve_admer_perc_two" id="sleeve_admer_perc_two" maxlength="3" size="3" value="<?php echo set_value('sleeve_admer_perc_two');?>" placeholder="%"></td>
                                    </tr>
									<tr>
		                                <td class="label">MB <span style="color:red;">*</span> :</td>
			                            <td><select name="sleeve_master_batch_2" id="sleeve_master_batch_2"><option value=''>--Select MB--</option>
			                               <?php foreach ($masterbatch as $masterbatch_row) {
			                                 echo "<option value='".$masterbatch_row->article_no."' ".set_select('sleeve_master_batch_2',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
			                               }?></select>
		                           		</td>

		                                <td>
                             		 	<input type="text" name="sleeve_mb_perc_2" id="sleeve_mb_perc_2" maxlength="3" size="3" value="<?php echo set_value('sleeve_mb_perc_2');?>" placeholder="%">
                              
                              		    </td>
                              		</tr>

                                   <tr>
		                               <td class="label">LDPE <span style="color:red;">*</span> :</td>
		                               <td><select name="sleeve_ldpe_2" id="sleeve_ldpe_2">
		                               <option value=''>--Select LDPE--</option>
		                               <?php
		                                foreach ($ldpe as $ldpe_row) {
		                                 echo "<option value='".$ldpe_row->article_no."' ".set_select('sleeve_ldpe_2',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
		                               }
		                               ?>
		                              </select></td>
		                              <td>
		                              <input type="text" name="sleeve_ldpe_perc_2" id="sleeve_ldpe_perc_2" maxlength="3" size="3" value="<?php echo set_value('sleeve_ldpe_perc_2');?>" placeholder="%"></td>
                                    </tr>

                               		<tr>
	                              		<td class="label">LLDPE <span style="color:red;">*</span> :</td>
	                              		<td><select name="sleeve_lldpe_2" id="sleeve_lldpe_2">
	                              			<option value=''>--Select LLDPE--</option>
	                              			<?php
	                              			foreach ($lldpe as $lldpe_row) {
	                                 		echo "<option value='".$lldpe_row->article_no."' ".set_select('sleeve_lldpe_2',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
	                              			}
	                              			?>
	                             		</select></td>
	                              		<td>
	                              		<input type="text" name="sleeve_lldpe_perc_2" id="sleeve_lldpe_perc_2" maxlength="3" size="3" value="<?php echo set_value('sleeve_lldpe_perc_2');?>" placeholder="%"></td>
                              		</tr>

	                                <tr>
		                               <td class="label">HDPE  :</td>
		                               <td><select name="sleeve_hdpe_2" id="sleeve_hdpe_2">
		                               <option value=''>--Select HDPE--</option>
		                               <?php
			                              foreach ($hdpe as $hdpe_row) {
			                                 echo "<option value='".$hdpe_row->article_no."' ".set_select('sleeve_hdpe_2',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
			                              }
		                                ?>
		                               </select>
	                          	  	    </td>
	                              		<td>
	                              		<input type="text" name="sleeve_hdpe_perc_2" id="sleeve_hdpe_perc_2" maxlength="3" size="3" value="<?php echo set_value('sleeve_hdpe_perc_2');?>" placeholder="%"></td>
	                                </tr>

                                

	                                <tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

	                                <tr><td class="label"><b>Third Layer</b></td></tr>
	                                <tr>
	                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
	                                 <td><input type="text" name="sleeve_guage_3" id="sleeve_guage_3" maxlength="3" size="3" value="<?php echo set_value('sleeve_guage_3');?>"></td>
	                                </tr>

	                                <tr>
		                              <td class="label">Evoh  :</td>
		                              <td><select name="sleeve_evoh" id="sleeve_evoh">
		                              <option value=''>--Select Evoh--</option>
		                              <?php
		                              foreach ($evoh as $evoh_row) {
		                                 echo "<option value='".$evoh_row->article_no."' ".set_select('sleeve_evoh',$evoh_row->article_no).">".$evoh_row->lang_article_description."</option>";
		                              }
		                              ?>
		                              </select></td>
		                              <td>
		                              <input type="text" name="sleeve_evoh_perc" id="sleeve_evoh_perc" maxlength="3" size="3" value="<?php echo set_value('sleeve_evoh_perc');?>" placeholder="%"></td>
	                                </tr>
	                                <tr>
		                              <td class="label">MB <span style="color:red;">*</span> :</td>
		                              <td><select name="sleeve_master_batch_3" id="sleeve_master_batch_3"><option value=''>--Select MB--</option>
		                              <?php foreach ($masterbatch as $masterbatch_row) {
		                                 echo "<option value='".$masterbatch_row->article_no."' ".set_select('sleeve_master_batch_3',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
		                              }?></select></td>

		                              <td>
		                              <input type="text" name="sleeve_mb_perc_3" id="sleeve_mb_perc_3" maxlength="3" size="3" value="<?php echo set_value('sleeve_mb_perc_3');?>" placeholder="%">
		                              
		                              </td>
	                                </tr>

	                                <tr>
		                              <td class="label">LDPE <span style="color:red;">*</span> :</td>
		                              <td><select name="sleeve_ldpe_3" id="sleeve_ldpe_3">
		                              <option value=''>--Select LDPE--</option>
		                              <?php
		                              foreach ($ldpe as $ldpe_row) {
		                                 echo "<option value='".$ldpe_row->article_no."' ".set_select('sleeve_ldpe_3',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
		                              }
		                              ?>
		                              </select></td>
		                              <td>
		                              <input type="text" name="sleeve_ldpe_perc_3" id="sleeve_ldpe_perc_3" maxlength="3" size="3" value="<?php echo set_value('sleeve_ldpe_perc_3');?>" placeholder="%"></td>
	                                </tr>

	                                <tr>
		                              <td class="label">LLDPE <span style="color:red;">*</span> :</td>
		                              <td><select name="sleeve_lldpe_3" id="sleeve_lldpe_3">
		                              <option value=''>--Select LLDPE--</option>
		                              <?php
		                              foreach ($lldpe as $lldpe_row) {
		                                 echo "<option value='".$lldpe_row->article_no."' ".set_select('sleeve_lldpe_3',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
		                              }
		                              ?>
		                              </select></td>
		                              <td>
		                              <input type="text" name="sleeve_lldpe_perc_3" id="sleeve_lldpe_perc_3" maxlength="3" size="3" value="<?php echo set_value('sleeve_lldpe_perc_3');?>" placeholder="%"></td>
	                                </tr>

	                                <tr>
		                              <td class="label">HDPE  :</td>
		                              <td><select name="sleeve_hdpe_3" id="sleeve_hdpe_3">
		                              <option value=''>--Select HDPE--</option>
		                              <?php
		                              foreach ($hdpe as $hdpe_row) {
		                                 echo "<option value='".$hdpe_row->article_no."' ".set_select('sleeve_hdpe_3',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
		                              }
		                              ?>
		                              </select></td>
		                              <td>
		                              <input type="text" name="sleeve_hdpe_perc_3" id="sleeve_hdpe_perc_3" maxlength="3" size="3" value="<?php echo set_value('sleeve_hdpe_perc_3');?>" placeholder="%"></td>
	                               </tr>


                                	<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

		                            
	                                <tr><td class="label"><b>Fourth Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="text" name="sleeve_guage_4" id="sleeve_guage_4" maxlength="3" size="3" value="<?php echo set_value('sleeve_guage_4');?>"></td>
									</tr>
									<tr>
	                              		<td class="label">Admer  :</td>
	                              		<td><select name="sleeve_admer_4" id="sleeve_admer_4">
	                              		<option value=''>--Select Admer--</option>
	                              		<?php
			                              foreach ($admer as $admer_row) {
			                                 echo "<option value='".$admer_row->article_no."' ".set_select('sleeve_admer_4',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
			                              }
			                              ?>
			                              </select>  
			                            </td>
		                               <td>
		                              	<input type="text" name="sleeve_admer_perc_4" id="sleeve_admer_perc_4" maxlength="3" size="3" value="<?php echo set_value('sleeve_admer_perc_4');?>" placeholder="%"></td>
                                    </tr>
									
									<tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

									<tr><td class="label"><b>Inner Layer</b></td></tr>

	                            	<tr>
	                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
	                                 <td><input type="text" name="sleeve_guage_5" id="sleeve_guage_5" maxlength="3" size="3" value="<?php echo set_value('sleeve_guage_5');?>"></td>
	                                </tr>

	                               <tr>
		                              <td class="label">MB <span style="color:red;">*</span> :</td>
		                              <td><select name="sleeve_master_batch_5" id="sleeve_master_batch_5"><option value=''>--Select MB--</option>
		                              <?php foreach ($masterbatch as $masterbatch_row) {
		                                 echo "<option value='".$masterbatch_row->article_no."' ".set_select('sleeve_master_batch_5',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
		                              }?></select></td>

		                              <td>
		                              <input type="text" name="sleeve_mb_perc_5" id="sleeve_mb_perc_5" maxlength="3" size="3" value="<?php echo set_value('sleeve_mb_perc_5');?>" placeholder="%">
		                              
		                              </td>
	                                </tr>

	                                <tr>
		                              <td class="label">LDPE <span style="color:red;">*</span> :</td>
		                              <td><select name="sleeve_ldpe_5" id="sleeve_ldpe_5">
		                              <option value=''>--Select LDPE--</option>
		                              <?php
		                              foreach ($ldpe as $ldpe_row) {
		                                 echo "<option value='".$ldpe_row->article_no."' ".set_select('sleeve_ldpe_5',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
		                              }
		                              ?>
		                              </select></td>
		                              <td>
		                              <input type="text" name="sleeve_ldpe_perc_5" id="sleeve_ldpe_perc_5" maxlength="3" size="3" value="<?php echo set_value('sleeve_ldpe_perc_5');?>" placeholder="%"></td>
	                                </tr>

	                                <tr>
		                              <td class="label">LLDPE <span style="color:red;">*</span> :</td>
		                              <td><select name="sleeve_lldpe_5" id="sleeve_lldpe_5">
		                              <option value=''>--Select LLDPE--</option>
		                              <?php
		                              foreach ($lldpe as $lldpe_row) {
		                                 echo "<option value='".$lldpe_row->article_no."' ".set_select('sleeve_lldpe_5',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
		                              }
		                              ?>
		                              </select></td>
		                              <td>
		                              <input type="text" name="sleeve_lldpe_perc_5" id="sleeve_lldpe_perc_5" maxlength="3" size="3" value="<?php echo set_value('sleeve_lldpe_perc_5');?>" placeholder="%"></td>
	                                </tr>

	                                <tr>
		                              <td class="label">HDPE  :</td>
		                              <td><select name="sleeve_hdpe_5" id="sleeve_hdpe_5">
		                              <option value=''>--Select HDPE--</option>
		                              <?php
		                              foreach ($hdpe as $hdpe_row) {
		                                 echo "<option value='".$hdpe_row->article_no."' ".set_select('sleeve_hdpe_5',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
		                              }
		                              ?>
		                              </select></td>
		                              <td>
		                              <input type="text" name="sleeve_hdpe_perc_5" id="sleeve_hdpe_perc_5" maxlength="3" size="3" value="<?php echo set_value('sleeve_hdpe_perc_5');?>" placeholder="%"></td>
	                               </tr>									

									
								</table>
							</td>
							
						</tr>
			</table>	
				
			

	</div>

	<div class="form_design">
		<div class="ui buttons">
	  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  <div class="or"></div>
	  <button class="ui positive button" onClick="return validate_form();">Search</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			