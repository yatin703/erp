
		<article class="sub_container">
			<div class="form_container">
				<div class="form_design">
					<form name="" action="<?php echo base_url('index.php/login/company');?>" method="POST">
						<?php echo validation_errors();?>
						<?php if(isset($note)){ echo $note;}?>
						<table class="form_table_design">
							<tr>
								<td>
								<table class="form_table_inner">
									<tr><td class="label">Company Name * :</td><td><input type="text" name="company_name" maxlength="100" size="50" value="<?php echo set_value('company_name');?>"/></td></tr>
									<tr><td class="label">Company Id * :</td><td><input type="text" name="company_id" maxlength="6" size="6" value="<?php echo set_value('company_id');?>"/></td></tr>
									<tr><td class="label">Short Id * :</td><td><input type="text" name="short_id" maxlength="2"  size="2" value="<?php echo set_value('short_id');?>"/></td></tr>
									<tr><td class="label">Address * :</td><td><textarea name="address" maxlength="256" rows="3" cols="40" value="<?php echo set_value('address');?>"><?php echo set_value('address');?></textarea></td></tr>
									<tr><td class="label">Phone No * :</td><td><input type="text" name="phone_no" maxlength="15" size="15" value="<?php echo set_value('phone_no');?>"/></td></tr>
									<tr><td class="label">Fax No :</td><td><input type="text" name="fax_no" maxlength="15" size="15" value="<?php echo set_value('fax_no');?>"/></td></tr>
									<tr><td class="label">Web Address :</td><td><input type="text" name="web_address" maxlength="255" size="50" value="<?php echo set_value('web_address');?>"/></td></tr>
									<tr><td class="label">Email * :</td><td><input type="email" name="email" maxlength="254" size="50" value="<?php echo set_value('email');?>"/></td></tr>
									
								</table>
							</td>
							<td>
								<table class="form_table_inner">
									<tr><td class="label">BCC Email :</td><td><input type="email" name="bcc_email" maxlength="254" size="50" value="<?php echo set_value('bcc_email');?>"/></td></tr>
									<tr><td class="label">Vat Tin No :</td><td><input type="text" name="vat_no" maxlength="30" size="30" value="<?php echo set_value('vat_no');?>"/></td></tr>
									<tr><td class="label">Cst No :</td><td><input type="text" name="cst_no" maxlength="30" size="30" value="<?php echo set_value('cst_no');?>"/></td></tr>
									<tr><td class="label">Pan No * :</td><td><input type="text" name="pan_no" maxlength="30" size="30" value="<?php echo set_value('pan_no');?>"/></td></tr>

									<tr><td class="label">Service Tax No :</td><td><input type="text" name="service_tax_no" maxlength="30" size="30" value="<?php echo set_value('service_tax_no');?>"/></td></tr>
									<tr><td class="label">Excise No :</td><td><input type="text" name="excise_no" maxlength="30" size="30" value="<?php echo set_value('excise_no');?>"/></td></tr>
									<tr><td class="label">Excise Range :</td><td><input type="text" name="excise_range" maxlength="64" size="50" value="<?php echo set_value('excise_range');?>"/></td></tr>
									<tr><td class="label">Excise Division :</td><td><input type="text" name="excise_division" maxlength="64" size="50" value="<?php echo set_value('excise_division');?>"/></td></tr>

									<tr><td class="label">Commissionarate :</td><td><input type="text" name="commissionarate" maxlength="64" size="50" value="<?php echo set_value('commissionarate');?>"/></td></tr>
								</table>
							</td>
							
							
						</tr>
					</table>
					<button class="submit" name="submit">Next</button>
					</form>
				</div>
			</div>
		</article>
		