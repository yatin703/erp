<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
   $(document).ready(function(){
      $("#loading").hide(); $("#cover").hide();

      $("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});


      $("#main_group").change(function(event) {
         var main_group = $('#main_group').val();
         $("#loading").show();
            $("#cover").show();
            $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
          $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/main_group_article",data: {main_group : $('#main_group').val()},cache: false,success: function(html){
               setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
             $("#article_no").html(html);
          } 
          });
         });

      

   });
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_seven_layer');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

									<tr>
										<td class="label" >Main Group <span style="color:red;">*</span> :</td>
										<td><select name="main_group" id="main_group" required><option value=''>--Select Main Group--</option>
                                 <option value="42">FILM</option>
										</select></td>
									</tr>

									<tr>
										<td class="label">Film No <span style="color:red;">*</span> :</td>
										<td><select name="article_no" id="article_no" required>
										<?php if($this->input->post('article_no')){
											echo '<option value="'.$this->input->post('article_no').'">'.$this->input->post('article_no').'</option>';
										}else{
											echo '<option value="">--Select Article Code--</option>';
										}?>
														
										</select></td>
									</tr>


									<tr>
										<td class="label">Dia <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia" required><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													if($sleeve_dia_row->sleeve_id=='5'|| $sleeve_dia_row->sleeve_id=='6'||$sleeve_dia_row->sleeve_id=='7'){
														echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
													}
												}
										}?></select>&nbsp;Length <span style="color:red;">*</span> : <input type="text" name="sleeve_length" id="sleeve_length" size="5" maxlength="6" value="<?php echo set_value('sleeve_length');?>" required></td>
									</tr>

									<tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

									
                           <tr><td class="label"><b>1 Outer Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="number"  name="gauge_one" id="gauge_one" maxlength="5" size="5" value="<?php echo set_value('gauge_one');?>" required></td>
									</tr>

									
									<tr>
										<td class="label">LDPE :</td>
										<td><select name="film_ldpe_one">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											if($ldpe_row->article_no!='RM-LDPE-000-0009'){
											echo "<option value='".$ldpe_row->article_no."' ".set_select('film_ldpe_one',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
											}
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

                           <tr>
                                 <td class="label">HDPE  <span style="color:red;">*</span> :</td>
                                 <td><select name="film_hdpe_one" >
                                 <option value=''>--Select HDPE--</option>
                                 <?php
                                 foreach ($hdpe as $hdpe_row) {
                                 if($hdpe_row->article_no=='RM-HDPE-000-0008'){ 
                                    echo "<option value='".$hdpe_row->article_no."' ".set_select('film_hdpe_one',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
                                 }
                                       
                                 }
                                 ?>
                                 </select></td>
                                 <td>
                                 <input type="number" name="film_hdpe_per_one" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_one');?>" placeholder="%" ></td>
                           </tr>




                           <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>



                           <tr><td class="label"><b>2 Layer</b></td></tr>

                                 <tr>
                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
                                 <td><input type="number" name="gauge_two"  maxlength="5" size="5" value="<?php echo set_value('gauge_two');?>" required></td>
                                 </tr>

                                 <tr>
                                    <td class="label">MB <span style="color:red;">*</span> :</td>
                                    <td><select name="film_masterbatch_two" required><option value=''>--Select MB--</option>
                                    <?php foreach ($masterbatch as $masterbatch_row) {
                                       echo "<option value='".$masterbatch_row->article_no."' ".set_select('film_masterbatch_two',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                                    }?></select></td>

                                    <td><input type="number" name="film_mb_per_two" min="0"  max="25" step="any" maxlength="4" size="4" value="<?php echo set_value('film_mb_per_two');?>" placeholder="%" required></td>
                                 </tr>

                                 <tr>
                                    <td class="label">LDPE :</td>
                                    <td><select name="film_ldpe_two">
                                    <option value=''>--Select LDPE--</option>
                                    <?php
                                    foreach ($ldpe as $ldpe_row) {
										if($ldpe_row->article_no!='RM-LDPE-000-0009'){
											echo "<option value='".$ldpe_row->article_no."' ".set_select('film_ldpe_two',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
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
									if($hdpe_row->article_no=='RM-HDPE-000-0008'){ 
										echo "<option value='".$hdpe_row->article_no."' ".set_select('film_hdpe_two',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
									}
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
											<td><input type="number" name="gauge_three"  id="gauge_three" maxlength="5" size="2" value="<?php echo set_value('gauge_three');?>" required></td>
										</tr>

                              <tr>
                              <td class="label">Admer  <span style="color:red;">*</span> :</td>
                              <td><select name="film_admer_three">
                              <option value=''>--Select Admer--</option>
                              <?php
                              foreach ($admer as $admer_row) {
                                 echo "<option value='".$admer_row->article_no."' ".set_select('film_admer_three',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_admer_per_three" min="100"  max="100" step="any"  maxlength="3" size="3" value="<?php echo set_value('film_admer_per_three');?>" placeholder="%"></td>
                              </tr>

                              <tr>
                                 <td class="label">HDPE :</td>
                                 <td><select name="film_hdpe_three" >
                                 <option value=''>--Select HDPE--</option>
                                 <?php
                                 foreach ($hdpe as $hdpe_row) {
                           if($hdpe_row->article_no=='RM-HDPE-000-0008'){ 
                              echo "<option value='".$hdpe_row->article_no."' ".set_select('film_hdpe_three',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
                           }
                                 }
                                 ?>
                                 </select></td>
                                 <td>
                                 <input type="number" name="film_hdpe_per_three" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_three');?>" placeholder="%" ></td>
                                 </tr>

									
                           <tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>


                              <tr><td class="label"><b>4 Evoh Layer</b></td></tr>
                              <tr>
                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
                                 <td><input type="number" name="gauge_four"  maxlength="5" size="2" value="<?php echo set_value('gauge_four');?>" required></td>
                              </tr>

                              <tr>
                              <td class="label">Evoh <span style="color:red;">*</span> :</td>
                              <td><select name="film_evoh_four">
                              <option value=''>--Select Evoh--</option>
                              <?php
                              foreach ($evoh as $evoh_row) {
                                 echo "<option value='".$evoh_row->article_no."' ".set_select('film_evoh_four',$evoh_row->article_no).">".$evoh_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_evoh_per_four"  min="100" max="100" step="any"  maxlength="3" size="3" value="<?php echo set_value('film_evoh_per_four');?>" placeholder="%"></td>
                              </tr>

                              <tr>
                                 <td class="label">HDPE :</td>
                                 <td><select name="film_hdpe_four" >
                                 <option value=''>--Select HDPE--</option>
                                 <?php
                                 foreach ($hdpe as $hdpe_row) {
                           if($hdpe_row->article_no=='RM-HDPE-000-0008'){ 
                              echo "<option value='".$hdpe_row->article_no."' ".set_select('film_hdpe_four',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
                           }
                                 }
                                 ?>
                                 </select></td>
                                 <td>
                                 <input type="number" name="film_hdpe_per_four" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_four');?>" placeholder="%" ></td>
                              </tr>


                           <tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

                              <tr><td class="label"><b>5 Admer Layer</b></td></tr>
                              <tr>
                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
                                 <td><input type="number" name="gauge_five"  maxlength="2" size="2" value="<?php echo set_value('gauge_five');?>" required></td>
                              </tr>

                              <tr>
                              <td class="label">Admer <span style="color:red;">*</span> :</td>
                              <td><select name="film_admer_five">
                              <option value=''>--Select Admer--</option>
                              <?php
                              foreach ($admer as $admer_row) {
                                 echo "<option value='".$admer_row->article_no."' ".set_select('film_admer_five',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_admer_per_five" min="100" max="100" step="any" maxlength="3" size="3" value="<?php echo set_value('film_admer_per_five');?>" placeholder="%"></td>
                              </tr>

                              <tr>
                                 <td class="label">HDPE :</td>
                                 <td><select name="film_hdpe_five" >
                                 <option value=''>--Select HDPE--</option>
                                 <?php
                                 foreach ($hdpe as $hdpe_row) {
                           if($hdpe_row->article_no=='RM-HDPE-000-0008'){ 
                              echo "<option value='".$hdpe_row->article_no."' ".set_select('film_hdpe_five',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
                           }
                                 }
                                 ?>
                                 </select></td>
                                 <td>
                                 <input type="number" name="film_hdpe_per_five" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_five');?>" placeholder="%" ></td>
                              </tr>


									<tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

								    <tr><td class="label"><b>6 Layer</b></td></tr>

                            <tr>
                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
                                 <td><input type="number" name="gauge_six" id="gauge_six"   maxlength="5" size="5" value="<?php echo set_value('gauge_six');?>" required></td>
                              </tr>

                           <tr>
                              <td class="label">MB <span style="color:red;">*</span> :</td>
                              <td><select name="film_masterbatch_six" required><option value=''>--Select MB--</option>
                              <?php foreach ($masterbatch as $masterbatch_row) {
                                 echo "<option value='".$masterbatch_row->article_no."' ".set_select('film_masterbatch_six',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                              }?></select></td>

                              <td>
                              <input type="number" name="film_mb_per_six" min="0"  max="25" step="any" maxlength="4" size="4" value="<?php echo set_value('film_mb_per_six');?>" placeholder="%" required>
                              
                              </td>
                           </tr>

                              <tr>
                                 <td class="label">LDPE :</td>
                                    <td><select name="film_ldpe_six">
                                    <option value=''>--Select LDPE--</option>
                                    <?php
                                    foreach ($ldpe as $ldpe_row) {
										if($ldpe_row->article_no!='RM-LDPE-000-0009'){
											echo "<option value='".$ldpe_row->article_no."' ".set_select('film_ldpe_six',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
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
								if($hdpe_row->article_no=='RM-HDPE-000-0008'){   
                                 echo "<option value='".$hdpe_row->article_no."' ".set_select('film_hdpe_six',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
								} 
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_hdpe_per_six" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_six');?>" placeholder="%" ></td>
                              </tr>
										
                           <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>   
										

                           <tr><td class="label"><b>7 Layer</b></td></tr>

                           <tr>
                              <td class="label">Gauge <span style="color:red;">*</span> :</td>
                              <td><input type="number"   name="gauge_seven"  maxlength="5" size="5" value="<?php echo set_value('gauge_seven');?>" required></td>
                           </tr>

                              <tr>
                              <td class="label">LDPE <span style="color:red;">*</span> :</td>
                              <td><select name="film_ldpe_seven" required>
                              <option value=''>--Select LDPE--</option>
                              <?php
                              foreach ($ldpe as $ldpe_row) {
								  
								if($ldpe_row->article_no!='RM-LDPE-000-0009'){
									echo "<option value='".$ldpe_row->article_no."' ".set_select('film_ldpe_seven',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
								}
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_ldpe_per_seven" min="0"  max="100" step="1"  maxlength="3" size="3" value="<?php echo set_value('film_ldpe_per_seven');?>" placeholder="%" required></td>
                              </tr>

                              <tr>
                              <td class="label">LLDPE <span style="color:red;">*</span> :</td>
                              <td><select name="film_lldpe_seven" required>
                              <option value=''>--Select LLDPE--</option>
                              <?php
                              foreach ($lldpe as $lldpe_row) {
                                 echo "<option value='".$lldpe_row->article_no."' ".set_select('film_lldpe_seven',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="film_lldpe_per_seven" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_lldpe_per_seven');?>" placeholder="%" required></td>
                              </tr>


                              <tr>
                                 <td class="label">HDPE  <span style="color:red;">*</span> :</td>
                                 <td><select name="film_hdpe_seven" >
                                 <option value=''>--Select HDPE--</option>
                                 <?php
                                 foreach ($hdpe as $hdpe_row) {
                                 if($hdpe_row->article_no=='RM-HDPE-000-0008'){ 
                                    echo "<option value='".$hdpe_row->article_no."' ".set_select('film_hdpe_seven',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
                                 }
                                       
                                 }
                                 ?>
                                 </select></td>
                                 <td>
                                 <input type="number" name="film_hdpe_per_seven" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_seven');?>" placeholder="%" ></td>
                           </tr>




                              
                              <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

                              <tr>
                                 <td class="label"><b>Approval Authority</b> </td>
                                 <td><select name="approval_authority">
                                    <option value=''>--Select Authority--</option>
                                    <?php 
                                    foreach ($approval_authority as $approval_authority_row) {
                                     echo "<option value='".$approval_authority_row->employee_id."' ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
                                     }
                                     ?>
                                    </select></td>
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
	  <button class="ui positive button">Save</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			