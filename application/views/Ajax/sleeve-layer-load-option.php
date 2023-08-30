<?php

if($sleeve_layer==FALSE){
	echo "Sleeve Layer Set Up Required";
}else{
	foreach ($sleeve_layer as $sleeve_layer_row){

		for($i=1;$i<=$sleeve_layer_row;$i++){?>
			<script>
				$(document).ready(function(){

					$("#rm_<?php echo $i;?>1").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

					$("#rm_supplier_<?php echo $i;?>1").autocomplete("<?php echo base_url('index.php/ajax/supplier');?>", {selectFirst: true});

					});
			</script>

<?php
	echo '<p><b>Layer No '.$i.' Information</b></p>
					<table class="form_table_design">
						<tr>
							<td>
								<table class="form_table_inner">
									<tr>
										<td class="label">Gauge * :</td>
										<td><input type="text" name="gauge_'.$i.'" maxlength="3" size="3" value="'.set_value('gauge_'.$i.'').'"></td>
										<td></td>
										<td>&nbsp;</td>
									</tr>

									<tr>
										<td class="label">LDPE * :</td>
										<td><select name="'.$i.'_6_0"><option value="">--Select LDPE--</option>';
										foreach ($ldpe as $ldpe_row) {
											echo "<option value ='$ldpe_row->article_no' ".set_select(''.$i.'_6_0',$ldpe_row->article_no)." >$ldpe_row->lang_article_description</option>";
										}
										echo '
										</select></td>
										<td><input type="text" name="rm_supplier_'.$i.'[]"  maxlength="76" size="50" id="rm_supplier_'.$i.'1" value="'.set_value('rm_supplier_'.$i.'[size]').'" placeholder="Supplier"></td>
										<td><input type="text" name="rm_per_'.$i.'[]" maxlength="3" size="3" id="rm_per_'.$i.'1" value="'.set_value('rm_per_'.$i.'[size]').'" placeholder="%"></td>
									</tr>

									<tr>
										<td class="label">LLDPE * :</td>
										<td><select name="'.$i.'_6_1"><option value="">--Select LLDPE--</option>';
										foreach ($lldpe as $lldpe_row) {
											echo "<option value ='$lldpe_row->article_no'>$lldpe_row->lang_article_description</option>";
										}
										echo '
										</select></td>
										<td><input type="text" name="rm_supplier_'.$i.'[]"  maxlength="76" size="50" id="rm_supplier_'.$i.'1" value="'.set_value('rm_supplier_'.$i.'[size]').'" placeholder="Supplier"></td>
										<td><input type="text" name="rm_per_'.$i.'[]" maxlength="3" size="3" id="rm_per_'.$i.'1" value="'.set_value('rm_per_'.$i.'[size]').'" placeholder="%"></td>
									</tr>

									<tr>
										<td class="label">MB * :</td>
										<td><select name="'.$i.'_5_0"><option value="">--Select MB--</option>';
										foreach ($masterbatch as $masterbatch_row) {
											echo "<option value ='$masterbatch_row->article_no'>$masterbatch_row->lang_article_description</option>";
									}
										echo '
										</select></td>
										<td><input type="text" name="rm_supplier_'.$i.'[]"  maxlength="76" size="50" id="rm_supplier_'.$i.'1" value="'.set_value('rm_supplier_'.$i.'[size]').'" placeholder="Supplier"></td>
										<td><input type="text" name="rm_per_'.$i.'[]" maxlength="3" size="3" id="rm_per_'.$i.'1" value="'.set_value('rm_per_'.$i.'[size]').'" placeholder="%"></td>
									</tr>


								</table>
							</td>
						</tr>
					</table>';
	echo '<br/>';
		}
	}    	
}
?>