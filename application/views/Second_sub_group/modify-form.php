<script type="text/javascript">
$(document).ready(function() {
		$("#loading").hide();
		$("#cover").hide();

		$("#main_group").change(function(event) {
   var main_group = $('#main_group').val();
   $("#loading").show();
		$("#cover").show();
		$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/sub_group",data: {main_group : $('#main_group').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#sub_group").html(html);
    } 
    });
   });

});
</script>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
<?php foreach ($second_sub_group as $row):?>
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

									<tr>
										<td class="label">Main Group <span style="color:red;">*</span> :</td>
										<td><select name="main_group" id="main_group"><option value=''>--Select Main Group--</option>
										<?php if($main_group==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($main_group as $main_group_row){
													$selected=($main_group_row->main_group_id==$row->main_group_id ? 'selected' : '');
													echo "<option value='".$main_group_row->main_group_id."' $selected ".set_select('main_group',''.$main_group_row->main_group_id.'').">".strtoupper($main_group_row->lang_main_group_desc)."</option>";
												}
										}?>
										</select></td>
									</tr>
									
									<tr>
										<td class="label">Sub Group <span style="color:red;">*</span> :</td>
										<td><select name="sub_group" id="sub_group"><option value=''>--Select Sub Group--</option>
										<?php if($sub_group==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sub_group as $sub_group_row){
													$selected=($sub_group_row->article_group_id==$row->article_group_id ? 'selected' : '');
													echo "<option value='".$sub_group_row->article_group_id."' $selected ".set_select('sub_group',''.$sub_group_row->article_group_id.'').">".strtoupper($sub_group_row->sub_group)."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr> 
										<td class="label">Second Sub Group Desc <span style="color:red;">*</span> :</td>
										<td><input type="text" name="second_sub_group" maxlength="50" size="50" value="<?php echo set_value('second_sub_group',$row->second_sub_group);?>" />
										<input type="hidden" name="sub_sub_grp_id" value="<?php echo $row->sub_sub_grp_id;?>" /></td>
									</tr>

									<tr>
										<td class="label">Short Desc <span style="color:red;">*</span> :</td>
										<td><input type="text" name="short_desc" maxlength="20" size="20" value="<?php echo set_value('short_desc',$row->second_sub_group_short_id);?>" /></td>
									</tr>

									<tr>
										<td class="label">Category :</td>
										<td><select name="category"><option value=''>--Select Category--</option>
										<?php if($category==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($category as $category_row){
													$selected=($category_row->category_id==$row->category_id ? 'selected' : '');
													echo "<option value='".$category_row->category_id."' $selected  ".set_select('category',''.$category_row->category_id.'').">".$category_row->lang_category_name."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Tariff :</td>
										<td><select name="tariff"><option value=''>--Select Tariff--</option>
										<?php if($tariff==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($tariff as $tariff_row){
													$selected=($tariff_row->erm_id==$row->excise_rate_id ? 'selected' : '');
													echo "<option value='".$tariff_row->erm_id."' $selected ".set_select('tariff',''.$tariff_row->erm_id.'').">".strtoupper($tariff_row->tariff_heading)."-".$tariff_row->cetsh_no."</option>";
												}
										}?>
										</select></td>
									</tr>
									
									<tr>
										<td class="label">Account Head <span style="color:red;">*</span> :</td>
										<td><select name="account_head"><option value=''>--Select Account Head--</option>
										<?php if($account_head==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($account_head as $account_head_row){
													$selected=($account_head_row->account_head_id==$row->account_head_id ? 'selected' : '');
													echo "<option value='".$account_head_row->account_head_id."' $selected ".set_select('account_head',''.$account_head_row->account_head_id.'').">".strtoupper($account_head_row->lang_description)."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Sale/Purchase/Other <span style="color:red;">*</span> :</td>
										<td><select name="sales_pur_flag"><option value=''>--Select Type--</option>
														<option value="1" <?php echo  set_select('type', '1', $row->sales_pur_flag==1 ? TRUE : FALSE); ?>>Sales</option>
														<option value="0" <?php echo  set_select('type', '0', $row->sales_pur_flag==0 ? TRUE : FALSE); ?>>Purchase</option>
														<option value="2" <?php echo  set_select('type', '2', $row->sales_pur_flag==2 ? TRUE : FALSE); ?>>Other</option>
										</select></td>
									</tr>

									<tr>
										<td class="label">Excisable :</td>
										<td><input type="checkbox" name="excise_flag" value="1" <?php echo set_checkbox('excise_flag',1);?> <?php echo ($row->excise_flag==1 ? 'value="1" checked' : 'value="0"');?>/></td>
									</tr>

									<tr>
										<td class="label">Spars  :</td>
										<td><input type="checkbox" name="spares_flag" value="1" <?php echo set_checkbox('spares_flag',1);?> <?php echo ($row->spares_flag==1 ? 'value="1" checked' : 'value="0"');?>/></td>
									</tr>

									<tr>
										<td class="label">Type <span style="color:red;">*</span> :</td>
										<td><select name="type"><option value=''>--Select Type--</option>
														<option value="1" <?php echo  set_select('type', '1', $row->mat_flag==1 ? TRUE : FALSE); ?>>RAW MATERIAL</option>
														<option value="2" <?php echo  set_select('type', '2', $row->mat_flag==2 ? TRUE : FALSE); ?>>TRADE MATERIAL</option>
														<option value="3" <?php echo  set_select('type', '3', $row->mat_flag==3 ? TRUE : FALSE); ?>>SERVICE</option>
														<option value="4" <?php echo  set_select('type', '4', $row->mat_flag==4 ? TRUE : FALSE); ?>>ASSETS</option>
										</select></td>
									</tr>

				</table>
				</td>
			</tr>
		</table>

	</div>

	<div class="form_design">
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
			<?php endforeach;?>
</form>
				
				
				
				
				
			