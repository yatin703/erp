
										<tr><td class="label"><b>Purging Information</b></td></tr>

										<tr>
										<td class="label">LDPE <span style="color:red;">*</span> :</td>
										<td><select name="purg_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('purg_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="purg_ldpe_per" maxlength="3" size="3" value="<?php echo set_value('purg_ldpe_per');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">Purging Agent <span style="color:red;">*</span> :</td>
										<td><select name="purg_rm">
										<option value=''>--Select Purging--</option>
										<?php
										foreach ($purg_rm as $purg_rm_row) {
											echo "<option value='".$purg_rm_row->article_no."' ".set_select('purg_rm',$purg_rm_row->article_no).">".$purg_rm_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="purg_rm_per" maxlength="3" size="3" value="<?php echo set_value('purg_rm_per');?>" placeholder="%"></td>
										</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>