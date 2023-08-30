<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
                        <?php foreach($sleeve_diameter_master as $row):?>
						<tr>
							<td>
								<table class="form_table_inner">
									<tr>
										<td class="label">Sleeve Diameter <span style="color:red;">*</span>  :</td>
										<td><input type="text" name="sleeve_diameter" maxlength="10" size="20" value="<?php echo set_value('sleeve_diameter',$row->sleeve_diameter);?>" /></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
				            <td>
								<table class="form_table_inner">
									<tr>
										<td class="label" colspan="10">COEX :</td>
									</tr>
									<tr>
										<td class="label">Innear Diameter <span style="color:red;">*</span>  :</td>
										<td><input type="text" name="inner_diameter" maxlength="10" size="20" value="<?php echo set_value('inner_diameter',$row->inner_diameter);?>" /></td>
										<td class="label">Outer Diameter <span style="color:red;">*</span>  :</td>
										<td><input type="text" name="outer_diameter" maxlength="10" size="20" value="<?php echo set_value('outer_diameter',$row->outer_diameter);?>" /></td>
									</tr>
									<tr>
										<td class="label">Innear Tolerance <span style="color:red;">*</span>  :</td>
										<td><input type="text" name="in_coex_tolerance" maxlength="10" size="20" value="<?php echo set_value('in_coex_tolerance',$row->in_coex_tolerance);?>" /></td>
										<td class="label">Outer Tolerance <span style="color:red;">*</span>  :</td>
										<td><input type="text" name="out_coex_tolerance" maxlength="10" size="20" value="<?php echo set_value('out_coex_tolerance',$row->out_coex_tolerance);?>" /></td>
									</tr>									
								</table>
				            </td>
			            </tr>
						<tr>
				            <td>
								<table class="form_table_inner">
									<tr>
										<td class="label" colspan="10">SPRING :</td>
									</tr>
									<tr>
										<td class="label">Innear Diameter :</td>
										<td><input type="text" name="inner_dia_spring" maxlength="10" size="20" value="<?php echo set_value('inner_dia_spring',$row->inner_dia_spring);?>" /></td>
										<td class="label">Outer Diameter :</td>
										<td><input type="text" name="outer_dia_spring" maxlength="10" size="20" value="<?php echo set_value('outer_dia_spring',$row->outer_dia_spring);?>" /></td>
									</tr>
									<tr>
										<td class="label">Innear Tolerance :</td>
										<td><input type="text" name="in_spring_tolerance" maxlength="10" size="20" value="<?php echo set_value('in_spring_tolerance',$row->in_spring_tolerance);?>" /></td>
										<td class="label">Outer Tolerance :</td>
										<td><input type="text" name="out_spring_tolerance" maxlength="10" size="20" value="<?php echo set_value('out_spring_tolerance',$row->out_spring_tolerance);?>" /></td>
									</tr>									
								</table>
				            </td>
			            </tr>
						<?php endforeach;?>		
					</table>											
				</td>							
			</tr>
		</table>					
	</div>

	<div class="form_design">			
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>		
</form>