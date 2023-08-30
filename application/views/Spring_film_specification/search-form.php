<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
   $(document).ready(function(){
      	$("#loading").hide(); $("#cover").hide();

      	$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/film_autocomplete');?>", {selectFirst: true});
   

   });
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

									<tr>
										<td class="label" >From Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>"/></td>
										<td class="label" >To Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"/></td>
									</tr>

									<tr>
										<td class="label">Film No. :</td>
										<td colspan="3">
											<input type="text" name="article_no" id="article_no" size="67" maxlength="200" value="<?php echo set_value('article_no');?>"/>
										</td>
									</tr>


									<tr>
										<td class="label">Dia :</td>
										<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select>
										 <td class="label"> Length :</td>
										 <td>
										 	<input type="text" name="sleeve_length" min="10"  max="500" id="sleeve_length" size="5" maxlength="5" value="<?php echo set_value('sleeve_length');?>">
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
							            <td class="label"> Approval Status :</td>
							            <td >
											<select name="final_approval_flag" id="final_approval_flag" >
												<option value="">--Please Select--</option>
												<option value="1" <?php echo set_select('final_approval_flag','1'); ?> >Approved</option>
												<option value="0" <?php echo set_select('final_approval_flag','0'); ?>>Not Approved</option>
											</select>

										</td>
							        </tr>

									<tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

									
                           <tr><td class="label"><b>1 Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="number" min="10" max="20" step="10" name="gauge_one" id="gauge_one" maxlength="5" size="5" value="<?php echo set_value('gauge_one');?>" ></td>
									</tr>

									
									<tr>
										<td class="label">LDPE :</td>
										<td><select name="film_ldpe_one">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('film_ldpe_one',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="film_ldpe_per_one" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_ldpe_per_one');?>" placeholder="%"></td>
									</tr>

									<tr>
										<td class="label">LLDPE :</td>
										<td><select name="film_lldpe_one">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('film_lldpe_one',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="film_lldpe_per_one" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_lldpe_per_one');?>" placeholder="%"></td>
									</tr>



                           <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>



                           <tr><td class="label"><b>2 Layer</b></td></tr>

                                 <tr>
                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
                                 <td><input type="number" name="gauge_two" min="155" max="155" step="1" maxlength="5" size="5" value="<?php echo set_value('gauge_two');?>" ></td>
                                 </tr>

                                 <tr>
                                    <td class="label">MB <span style="color:red;">*</span> :</td>
                                    <td><select name="film_masterbatch_two" ><option value=''>--Select MB--</option>
                                    <?php foreach ($masterbatch as $masterbatch_row) {
                                       echo "<option value='".$masterbatch_row->article_no."' ".set_select('film_masterbatch_two',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                                    }?></select></td>

                                    <td><input type="number" name="film_mb_per_two" min="0"  max="25" step="0.5" maxlength="4" size="4" value="<?php echo set_value('film_mb_per_two');?>" placeholder="%" ></td>
                                 </tr>

                                 <tr>
                                    <td class="label">LDPE :</td>
                                    <td><select name="film_ldpe_two">
                                    <option value=''>--Select LDPE--</option>
                                    <?php
                                    foreach ($ldpe as $ldpe_row) {
                                       echo "<option value='".$ldpe_row->article_no."' ".set_select('film_ldpe_two',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
                                    }
                                    ?>
                                    </select></td>
                                    <td>
                                    <input type="number" name="film_ldpe_per_two" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_ldpe_per_two');?>" placeholder="%"></td>
                                 </tr>

                                 <tr>
                                 <td class="label">LLDPE <span style="color:red;">*</span> :</td>
                                 <td><select name="film_lldpe_two" >
                                 <option value=''>--Select LLDPE--</option>
                                 <?php
                                 foreach ($lldpe as $lldpe_row) {
                                    echo "<option value='".$lldpe_row->article_no."' ".set_select('film_lldpe_two',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
                                 }
                                 ?>
                                 </select></td>
                                 <td>
                                 <input type="number" name="film_lldpe_per_two" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_lldpe_per_two');?>" placeholder="%" ></td>
                                 </tr>

                                 <tr>
                                 <td class="label">HDPE  <span style="color:red;">*</span> :</td>
                                 <td><select name="film_hdpe_two" >
                                 <option value=''>--Select HDPE--</option>
                                 <?php
                                 foreach ($hdpe as $hdpe_row) {
                                    echo "<option value='".$hdpe_row->article_no."' ".set_select('film_hdpe_two',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
                                 }
                                 ?>
                                 </select></td>
                                 <td>
                                 <input type="number" name="film_hdpe_per_two" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_two');?>" placeholder="%" ></td>
                                 </tr>


                              <tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

									
                           <tr><td class="label"><b>3 Admer Layer</b></td></tr>

                              <tr>
											<td class="label">Gauge <span style="color:red;">*</span> :</td>
											<td><input type="number" name="gauge_three" min="10"  max="20" step="1" id="gauge_three" maxlength="2" size="2" value="<?php echo set_value('gauge_three');?>" ></td>
										</tr>

                              <tr>
                              <td class="label">Admer  <span style="color:red;">*</span> :</td>
                              <td><select name="film_admer_three" >
                              <option value=''>--Select Admer--</option>
                              <?php
                              foreach ($admer as $admer_row) {
                                 echo "<option value='".$admer_row->article_no."' ".set_select('film_admer_three',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_admer_per_three" min="100"  max="100" step="0.5"  maxlength="3" size="4" value="<?php echo set_value('film_admer_per_three');?>" placeholder="%" ></td>
                              </tr>

									
                           <tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>


                              <tr><td class="label"><b>4 Evoh Layer</b></td></tr>
                              <tr>
                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
                                 <td><input type="number" name="gauge_four" min="25"  max="25" step="1" maxlength="2" size="2" value="<?php echo set_value('gauge_four');?>" ></td>
                              </tr>

                              <tr>
                              <td class="label">Evoh <span style="color:red;">*</span> :</td>
                              <td><select name="film_evoh_four" >
                              <option value=''>--Select Evoh--</option>
                              <?php
                              foreach ($evoh as $evoh_row) {
                                 echo "<option value='".$evoh_row->article_no."' ".set_select('film_evoh_four',$evoh_row->article_no).">".$evoh_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_evoh_per_four"  min="100" max="100" step="0.5"  maxlength="3" size="3" value="<?php echo set_value('film_evoh_per_four');?>" placeholder="%" ></td>
                              </tr>


                           <tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

                              <tr><td class="label"><b>5 Admer Layer</b></td></tr>
                              <tr>
                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
                                 <td><input type="number" name="gauge_five" min="10"  max="20" step="10" maxlength="2" size="2" value="<?php echo set_value('gauge_five');?>" ></td>
                              </tr>

                              <tr>
                              <td class="label">Admer <span style="color:red;">*</span> :</td>
                              <td><select name="film_admer_five" >
                              <option value=''>--Select Admer--</option>
                              <?php
                              foreach ($admer as $admer_row) {
                                 echo "<option value='".$admer_row->article_no."' ".set_select('film_admer_five',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_admer_per_five" min="100" max="100" step="0.5" maxlength="3" size="3" value="<?php echo set_value('film_admer_per_five');?>" placeholder="%" ></td>
                              </tr>


									<tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

								    <tr><td class="label"><b>6 Layer</b></td></tr>

                            <tr>
                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
                                 <td><input type="number" name="gauge_six" id="gauge_six" min="210" max="210" step="1" maxlength="5" size="5" value="<?php echo set_value('gauge_six');?>"  ></td>
                              </tr>

                           <tr>
                              <td class="label">MB <span style="color:red;">*</span> :</td>
                              <td><select name="film_masterbatch_six"  ><option value=''>--Select MB--</option>
                              <?php foreach ($masterbatch as $masterbatch_row) {
                                 echo "<option value='".$masterbatch_row->article_no."' ".set_select('film_masterbatch_six',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                              }?></select></td>

                              <td>
                              <input type="number" name="film_mb_per_six" min="0"  max="25" step="0.5" maxlength="4" size="4" value="<?php echo set_value('film_mb_per_six');?>" placeholder="%"  >
                              
                              </td>
                           </tr>

                              <tr>
                                 <td class="label">LDPE :</td>
                                    <td><select name="film_ldpe_six">
                                    <option value=''>--Select LDPE--</option>
                                    <?php
                                    foreach ($ldpe as $ldpe_row) {
                                       echo "<option value='".$ldpe_row->article_no."' ".set_select('film_ldpe_six',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
                                    }
                                    ?>
                                    </select></td>
                                    <td>
                                    <input type="number" name="film_ldpe_per_six" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_ldpe_per_six');?>" placeholder="%"></td>
                              </tr>

                              <tr>
                              <td class="label">LLDPE <span style="color:red;">*</span> :</td>
                              <td><select name="film_lldpe_six" >
                              <option value=''>--Select LLDPE--</option>
                              <?php
                              foreach ($lldpe as $lldpe_row) {
                                 echo "<option value='".$lldpe_row->article_no."' ".set_select('film_lldpe_six',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_lldpe_per_six" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_lldpe_per_six');?>" placeholder="%" ></td>
                              </tr>

                              <tr>
                              <td class="label">HDPE  <span style="color:red;">*</span> :</td>
                              <td><select name="film_hdpe_six" id="sl_hdpe_six" >
                              <option value=''>--Select HDPE--</option>
                              <?php
                              foreach ($hdpe as $hdpe_row) {
                                 echo "<option value='".$hdpe_row->article_no."' ".set_select('film_hdpe_six',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_hdpe_per_six" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_six');?>" placeholder="%" ></td>
                              </tr>
										
                           <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>   
										

                           <tr><td class="label"><b>7 Outer Layer</b></td></tr>

                           <tr>
                              <td class="label">Gauge <span style="color:red;">*</span> :</td>
                              <td><input type="number" min="10" max="20" step="10" name="gauge_seven"  maxlength="5" size="5" value="<?php echo set_value('gauge_seven');?>"  ></td>
                           </tr>

                              <tr>
                              <td class="label">LDPE <span style="color:red;">*</span> :</td>
                              <td><select name="film_ldpe_seven"  >
                              <option value=''>--Select LDPE--</option>
                              <?php
                              foreach ($ldpe as $ldpe_row) {
                                 echo "<option value='".$ldpe_row->article_no."' ".set_select('film_ldpe_seven',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_ldpe_per_seven" min="0"  max="100" step="1"  maxlength="3" size="3" value="<?php echo set_value('film_ldpe_per_seven');?>" placeholder="%"  ></td>
                              </tr>

                              <tr>
                              <td class="label">LLDPE <span style="color:red;">*</span> :</td>
                              <td><select name="film_lldpe_seven"  >
                              <option value=''>--Select LLDPE--</option>
                              <?php
                              foreach ($lldpe as $lldpe_row) {
                                 echo "<option value='".$lldpe_row->article_no."' ".set_select('film_lldpe_seven',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_lldpe_per_seven" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_lldpe_per_seven');?>" placeholder="%"  ></td>
                              </tr>

                              
                              <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

                              
									
								</table>
							</td>
							
						</tr>
			</table>
				
			

	</div>

	<div class="form_design">
		<div class="ui buttons">
	  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  <div class="or"></div>
	  <button class="ui positive button">Search</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			