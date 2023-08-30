<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"  />
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
<script type="text/javascript">
		document.getElementsByClassName("ui mini fluid").style.fontSize = "9px";
</script>
<?php foreach ($order as $order_row):?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_oc_mail');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

									<tr>
										<td class="label">Order <span style="color:red;">* </span>:</td>
										<td><input type="text" name="order_no" size="20" value="<?php echo set_value('order_no',$order_row->order_no);?>"/>
										</td>
									</tr>

									<tr>
										<td class="label">From <span style="color:red;">*</span>:</td>
										<td><input type="text" name="from_mail" size="60"  value="auto.mailer@3d-neopac.com" /></td>
									</tr>
									<?php
										$this->load->model('customer_model');
		            					$customer_result=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$order_row->customer_no);
		            					if($customer_result==FALSE){

		            					}else{
		            						foreach($customer_result as $customer_row){
		            							$to_mail=$customer_row->email;
		            						}
		            					}
									?>
									
									<tr>
										<td class="label">To <span style="color:red;">*</span>:</td>
										<td><select name="to_mails[]" multiple="" class="ui mini fluid dropdown">
												<option value=''>--</option>
												<?php
												$to_mail_arr=explode(',',$to_mail);
												foreach($to_mail_arr as $to_mail_arr_row){
													echo "<option value='".$to_mail_arr_row."'>".$to_mail_arr_row."</option>";
												} 

												?>
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">CC <span style="color:red;">*</span>:</td>
										<td><input type="text" name="cc" size="60" value="<?php echo set_value('cc',$this->common_model->get_user_email($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']));?>"/>
										</td>
									</tr>

								<!--	<tr>
										<td class="label">Cc <span style="color:red;">*</span> :</td>
										<td><input type="text" name="cc" size="60" value="<?php echo set_value('cc');?>"/></td>
									</tr>-->

									<tr>
										<td class="label">Subject  :</td>
										<td><input type="text" name="subject" size="60" value="<?php echo set_value('subject',"Dispatch Schedule/Order confirmation for ".$order_row->cust_order_no."");?>"/></td>
									</tr>

									<tr>
										<td class="label">Message  :</td>
										<td><textarea name="message" rows='15' cols='100'>Dear Sir,

As a part of our efforts to improve the experience of customers in dealing with 3D Technopack, we are rolling out an 'ORDER CONFIRMATION' document as attached which mentions the confirmed dispatch schedule for tubes from our factory. There also are related terms and conditions to have abundant understanding between yourself as a customer and 3D as supplier. Trust you will find it fair and just.We will be glad to hear from you if you have any comments.

Regards

<?php echo $this->common_model->get_user_name($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);?>

<?php echo $this->common_model->get_user_contact_no($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);?>
											
										</textarea></td>
									</tr>

					</table>			
								
				</td>
			</tr>
		</table>
					
	</div>

	<div class="form_design">
	<button class="submit" name="submit">Send</button><a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
</form>
<?php endforeach;?>
	
<script>
            $('.ui.dropdown').dropdown();
        </script>	
				
				
				
				
			