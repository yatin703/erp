<?php foreach ($order as $order_row):?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/notapproved_a');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="ui green very compact sortable celled table">
			<thead>
				<tr>
					<th colspan='4'>Order Details</th>
				</tr>
			</thead>
			<tr>
				<td>
					<table class="">
									<tr>
										<td class="">Order No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="order_no" value="<?php echo $order_row->order_no;?>" disabled>
										<input type="hidden" name="order_no" value="<?php echo $order_row->order_no;?>">
										<input type="hidden" name="transaction_no" value="<?php echo $this->uri->segment(4);?>"></td>
									</tr>


									<tr>
										<td class="">Bill To <span style="color:red;">*</span> :</td>
										<td><select name="adr_company_id" id="adr_company_id" disabled>
											<?php 
												foreach($customer as $customer_row){
													$selected=($customer_row->adr_company_id==$order_row->customer_no ? 'selected' :'');
            echo "<option value='".$customer_row->name1."//".$customer_row->adr_company_id."//".$customer_row->lang_property_name."' $selected ".set_select('adr_company_id',''.$customer_row->adr_company_id.'').">".$customer_row->name1."//".$customer_row->adr_company_id."//".$customer_row->lang_property_name."</option>";
												}
											?>
										</select></td>
									</tr>
									<tr>
										<td>Billing Address <span style="color:red;">*</span> :</td>
										<td><?php 
											$data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$order_row->customer_no);
			      							if($data['customer']==FALSE){
			      								$bill_to_gst="";
      											$bill_to_state=""; 
			          							echo "Contact to Admin";
			       							}else{
													foreach($data['customer'] as $customer_row){
														$bill_to_gst=$customer_row->isdn_local;
														$bill_to_state=$customer_row->zip_code;
													echo "<textarea disabled rows='4' cols='50'>".$customer_row->strno." ".$customer_row->name2." ".$customer_row->street." ".$customer_row->name3." PIN ".$customer_row->city_code."</textarea>";
														}
													}
											?>
												
										</td>
									</tr>
									<tr>
										<td>Bill To Gst Tin <span style="color:red;">*</span> :</td>
										<td><?php echo (!empty($bill_to_gst) ? $bill_to_gst : "");?>&nbsp;&nbsp;State <span style="color:red;">*</span> : <?php echo (!empty($bill_to_state) ? $this->common_model->get_state_name($bill_to_state,$this->session->userdata['logged_in']['company_id']) : "");?></td>
									</tr>
									<tr>
										<td class="">Ship To   :</td>
										<td><select name="consin_adr_company_id" id="consin_adr_company_id" disabled>
											<option value=''>--Same As Bill To--</option>
											<?php
											foreach ($ship_to as $ship_to_row){
												$selected=($ship_to_row->related_company_id==explode("|",$order_row->consin_adr_company_id)[0] ? 'selected' :'');
            									echo "<option ".$selected." value='".$ship_to_row->related_company_id."' ".set_select('consin_adr_company_id',''.$ship_to_row->related_company_id.'').">".$ship_to_row->relate."//".$ship_to_row->related_company_id."//".$ship_to_row->lang_property_name."</option>";
          									} ?> 
										</select></td>
									</tr>
									<tr>

										<td>Shipping  Address <span style="color:red;">*</span> :</td>
										<td><?php 
										$data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_row->consin_adr_company_id)[0]);
				      						if($data['customer']==FALSE){
				      							$ship_to_gst="";
		      									$ship_to_state=""; 
		      									echo "Same as Bill To";
				       							}else{
													foreach($data['customer'] as $customer_row){
														$ship_to_gst=$customer_row->isdn_local;
														$ship_to_state=$customer_row->zip_code;
													echo "<textarea disabled rows='4' cols='50'>".$customer_row->strno." ".$customer_row->name2." ".$customer_row->street." ".$customer_row->name3." PIN ".$customer_row->city_code."</textarea>";
													}
												}
											?>
										</td>
										
									</tr>

									<tr>
									<td>Ship To Gst Tin <span style="color:red;">*</span> :</td>
									<td><?php echo (!empty($ship_to_gst) ? $ship_to_gst : "-");?>&nbsp;&nbsp;State <span style="color:red;">*</span> : <?php echo (!empty($ship_to_state) ? $this->common_model->get_state_name($ship_to_state,$this->session->userdata['logged_in']['company_id']) : "-");?></td>
									</tr>

									<tr>
										<td class="">Po No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="po_no" value="<?php echo set_value('po_no',$order_row->cust_order_no);?>" disabled/>&nbsp;&nbsp;&nbsp;Po Date <span style="color:red;">*</span> :<input type="date" name="po_date" value="<?php echo set_value('po_date',$order_row->cust_order_date);?>" disabled/></td>
									</tr>

									<tr>
										<td class="">Export  :</td>
										<td><input type="checkbox" name="export"  value="1" <?php echo set_checkbox('export',1);?> <?php echo ($order_row->for_export==1 ? 'value="1" checked' : 'value="0"');?> disabled/></td>
									</tr>

									<tr>
										<td class="">For Sample  :</td>
										<td><input type="checkbox" name="for_sampling"  value="1" <?php echo set_checkbox('for_sampling',1);?> <?php echo ($order_row->for_sampling==1 ? 'value="1" checked' : 'value="0"');?> disabled/></td>
									</tr>

									<tr>
										<td class="">Currency :</td>
										<td>
											<select name="currency" id="currency" disabled><option value=''>--Select Currency--</option>
											<?php if($country==FALSE){
															echo "<option value=''>--Currency Setup Required--</option>";}
												else{
													foreach($country as $country_row){
														$selected=($country_row->country_id===$order_row->country_id ? 'selected' : '');
														echo '<option value="'.$country_row->currency_name.'|'.$country_row->country_id.'" '.$selected.' '.set_select('currency',''.$country_row->currency_name.'|'.$country_row->country_id.'').'>'.$country_row->currency_name.' ('.$country_row->country_short_id.')</option>';
													}
											}?>
											</select>&nbsp;&nbsp;&nbsp;Exchange Rate : <select name="exchange_rate" id="exchange_rate" disabled>
											<option value='<?php echo  $order_row->currency_id."|".$this->common_model->read_number($order_row->exchange_rate,$this->session->userdata['logged_in']['company_id'])."|".$order_row->exchange_rate_date;?>'>
											<?php echo $order_row->currency_id." ".$this->common_model->read_number($order_row->exchange_rate,$this->session->userdata['logged_in']['company_id'])." - ".$order_row->exchange_rate_date;?></option>
											</select>
										</td>
									</tr>

									<tr>
										<td class="">Created By :</td>
										<td>
											<input type="text" name="username" value="<?php echo set_value('username',$order_row->username);?>" disabled/>
											
										</td>
									</tr>

									

						</table>
			</td>
			<td>
				<table>
					<tr>
						<td class="">For Springtube  :</td>
						<td><input type="checkbox" name="order_flag"  value="1" <?php echo set_checkbox('order_flag',1);?> <?php echo ($order_row->order_flag==1 ? 'value="1" checked' : 'value="0"');?> disabled/></td>
					</tr>

					<tr>
						<td class="">For Stock  :</td>
						<td><input type="checkbox" name="for_stock"  value="1" <?php echo set_checkbox('for_stock',1);?> <?php echo ($order_row->for_stock==1 ? 'value="1" checked' : 'value="0"');?> disabled/></td>
					</tr>
					<tr>
						<td class="">Referense SO. :</td>
						<td><input type="text" name="ref_order_no" id="ref_order_no" value="<?php echo set_value('ref_order_no',$order_row->ref_order_no);?>" maxlength="30" disabled></td>
					</tr>	
					<tr>
						<td class="">Payment Term  :</td>
						<td><select name="payment_term" disabled><option value=''>--Select Payment Term--</option>
						<?php if($payment_term==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
							else{
								foreach($payment_term as $payment_term_row){
									$selected=($payment_term_row->id==$order_row->payment_condition_id ? 'selected' : '' );
									echo "<option value='".$payment_term_row->id."'  ".set_select('payment_term',''.$payment_term_row->id.'')." $selected>".$payment_term_row->lang_description." (".$payment_term_row->net_days." days) </option>";
								}
						}?>
						</select></td>
					</tr>

						<tr>
						<td class="">Shipping Details  :</td>
						<td><select name="freight_type" disabled><option value=''>--Select Shipping Details-</option>
						<?php if($freight_type==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
							else{
								foreach($freight_type as $freight_type_row){
									$selected=($freight_type_row->freight_type_id==$order_row->freight_type_id ? 'selected' : '' );
									echo "<option value='".$freight_type_row->freight_type_id."'  ".set_select('freight_type',''.$freight_type_row->freight_type_id.'')." $selected>".$freight_type_row->lang_freight_type."</option>";
								}
						}?>
						</select></td>
					</tr>
					<?php 
					$data['order_comment']=$this->common_model->select_one_active_record_nonlanguage_without_archive('order_master_lang',$this->session->userdata['logged_in']['company_id'],'order_master_lang.order_no',$order_row->order_no);
					if($data['order_comment']==FALSE){
					}else{
							foreach($data['order_comment'] as $order_comment_row){
									echo '<tr>
								<td class="">Comment :</td>
								<td><textarea  rows="4" cols="50" name="comment" value="'.set_value('comment',$order_comment_row->lang_addi_info).'" disabled>'.set_value('comment',$order_comment_row->lang_addi_info).'</textarea></td>
								</tr>';
							}
					}
					?>
					<tr>
						<td class="">Hold/Unhold  :</td>
						<td><select name="hold_flag" disabled>					
								<option value="1" <?php echo ($order_row->hold_flag=='1' ? "selected" : ""); ?> <?php echo set_select('hold_flag','1');?>>HOLD</option>
								<option value="0" <?php echo ($order_row->hold_flag=='0' ? "selected" : ""); ?> <?php echo set_select('hold_flag','0');?>>UNHOLD</option>								
							</select></td>
					</tr>

					<tr>
						<td class="">Hold/Unhold Reason  :</td>
						<td><textarea rows="4" cols="50" name="hold_reason" value="<?php echo set_value('hold_reason',$order_row->hold_reason);?>" disabled><?php echo set_value('hold_reason',$order_row->hold_reason);?></textarea></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</div>

<div class="middle_form_design">
					<div class="middle_form_inner_design">
						

        <table class="ui blue sortable celled table" style="overflow:scroll;">
        	<thead>
            	<tr>
                <th>Sr No</th>
                <th>Product</th>
                <th>Delivery Date</th>
                <th>Quantity</th>
                <th>Unit Rate</th>
                <th>Net Amount  <?php echo (!empty($order_master_row->currency_id) ? "(".$order_master_row->currency_id.")" : '');?></th>
                <?php 
                global $tax_arr;
                $i=0;
                foreach ($tax_master as $tax_value) {
                    $tax_arr[$i]=0;
                    echo "<th colspan='2'>".strtoupper($tax_value->lang_tax_code_desc)."</th>";
                    $i++;
                }
                ?>
                <th>Total <?php echo (!empty($order_row->currency_id) ? "(".$order_row->currency_id.")" : '');?></th>
            </tr>
            <tr>
                <th colspan="6"></th>
                <?php foreach ($tax_master as $tax_value) {
                    echo "<th>Rate</th>
                    <th>Amt</th>";
                }?>
                <th></th>
            </tr>
           </thead>
           <tbody>
            <?php 
            $quantity=0;
            $total_quantity=0;
            $amount=0;
            $total_amount=0;
            $total_selling_price=0;
            foreach ($order_details as $order_details_row) {

                $quantity=$order_details_row->total_order_quantity;

                if($order_row->for_export==1){
                    $amount=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$order_details_row->calc_sell_price;
                }else{
                    $amount=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($order_details_row->selling_price,$this->session->userdata['logged_in']['company_id']);
                }
                



                echo "<tr>
                        <td>$order_details_row->ord_pos_no</td>
                        
                        <td>[$order_details_row->article_no] <br/>".$this->common_model->get_article_name($order_details_row->article_no,$this->session->userdata['logged_in']['company_id'])."<br/>";


                        if(!empty($order_details_row->spec_id)){
                            if(substr($order_details_row->spec_id,0,1)=="S"){
                                echo "<b><a class='ui teal label' href='".base_url()."/index.php/specification/view/".$order_details_row->spec_id."/".$order_details_row->spec_version_no." ' target='blank'>".$order_details_row->spec_id."_".$order_details_row->spec_version_no."</a></b>";
                            }else{
                                $bom=array('bom_no'=>$order_details_row->spec_id,
                                    'bom_version_no'=>$order_details_row->spec_version_no);
                                $data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
                                    foreach($data['bom'] as $bom_row){                                          
                                        echo "<b><a class='ui teal label' href='".base_url()."/index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$order_details_row->spec_id."_".$order_details_row->spec_version_no."</a></b>";
                                    }                                   
                                }
                            }

                        echo "&nbsp;<a  class='ui red label' href='".($order_row->order_flag==0 ? base_url('/index.php/artwork_new/view/'):base_url('/index.php/artwork_springtube/view/'))."".$order_details_row->ad_id."/".$order_details_row->version_no."' target='blank'>".($order_details_row->ad_id!=""? $order_details_row->ad_id."_".$order_details_row->version_no:"")."</a></b>
                        <br/>";

                        echo "</td>
                        <td>";
                        if($order_details_row->delivery_date!="0000-00-00"){

                            echo $this->common_model->view_date($order_details_row->delivery_date,$this->session->userdata['logged_in']['company_id']);
                        }
                       echo "</td>

                        <td>".$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])."</td>";

                        if($order_row->for_export==1){
                            echo "<td>".$order_details_row->calc_sell_price."</td>";
                        }else{
                            echo "<td>".$this->common_model->read_number($order_details_row->selling_price,$this->session->userdata['logged_in']['company_id'])."</td>";
                        }

                        echo "<td>".$amount."</td>";
                        $m=0;
                        $k=0;
                        foreach ($tax_master as $tax_value) {
                            $output = array ();
                            $data['tax_pos']=$this->common_model->select_one_active_record_nonlanguage_without_archive('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$order_details_row->tax_pos_no);
                            foreach ($data['tax_pos'] as $tax_pos_row) {
                                $output[]=$tax_pos_row->tax_code;
                            }
                            $flag=0;
                            $out = array ();
                    echo "<td>".$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id'])."%</td><td>";

                        foreach($output as $value){
                            if($value!=''){
                                if($tax_value->tax_code==$value){
                                    $t_amount=explode ('|',$order_details_row->tax_grid_amount);
                                    $flag++;
                                }
                            }
                            if($flag>0){
                                $out[]=$flag;
                            }
                        }

                        if(!empty($out)){
                            $t_amount=explode ('|',$order_details_row->tax_grid_amount);
                            if($t_amount[$k]==''){
                                echo "0";
                            }else{
                                echo $t_amount[$k];
                            }
                            $tax_arr[$m]+=$t_amount[$k];
                            $k++;
                        }
                        echo '</td>';
                        $m++;

                        }
                    echo "<td>".$this->common_model->read_number($order_details_row->total_selling_price,$this->session->userdata['logged_in']['company_id'])."</td>
                    </tr>";

                $total_quantity+=$quantity;
                $total_amount+=$amount;
                $total_selling_price+=$order_details_row->total_selling_price;

                }

                $total_gross=$total_amount+$this->common_model->read_number($total_selling_price,$this->session->userdata['logged_in']['company_id']);

                echo "<tr>
                        <td colspan='3'><b>TOTAL</b></td>
                        <td><b>".$this->common_model->read_number($total_quantity,$this->session->userdata['logged_in']['company_id'])."/-</td>
                        <td></td>
                        <td><b>".$total_amount."/-</td>";
                        $l=0;
                        foreach ($tax_master as $tax_value) {
                            echo "<td></td>
                                <td><b>".$tax_arr[$l]."/-</td>";
                                $l++;
                        }

                echo "<td><b>".$this->common_model->read_number($total_selling_price,$this->session->userdata['logged_in']['company_id'])."/-</td>
                    </tr>";?>
                </tbody>
    		</table>

    		
						<table class="ui red very compact sortable celled table">
						<thead>
						<tr>
							<th colspan='6'>Order Followup</th>
						</tr>
						<tr class="item">
			                <th>Sr No</th>
			                <th>Date</th>
			                <th>From</th>
			                <th>To</th>
			                <th>Status</th>
			                <th>Remark</th>
			            </tr>
            			</thead>
            			<tbody>
            			<?php 
			                if($followup==FALSE){
			                    echo "<tr>
			                            <td colspan='6' style='border:1px solid #D9d9d9;'>NO RECORD FOUND</td>
			                        </tr>";

			                }else{
			                    foreach($followup as $followup_row){

			                        echo "<tr class='item'>
			                                <td>$followup_row->transaction_no</td>
			                                
			                                <td>".$this->common_model->view_date($followup_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
			                                <td>".strtoupper($followup_row->from_user)."</td>
			                                <td>".strtoupper($followup_row->to_user)."</td>
			                                <td>".($followup_row->status==99 ? 'SETTLED' : '')."
			                                    ".($followup_row->status==999 && $followup_row->approved_flag==1 ? 'APPROVED' : '')."
			                                    ".($followup_row->status==999 && $followup_row->approved_flag==2 ? 'REJECTED' : '')."
			                                    ".($followup_row->status==1 ? 'PENDING' : '')."</td>
			                                 <td>".strtoupper($followup_row->remark)."</td>
			                            </tr>";
			                     }
			                }
			            ?>
			            </tbody>
						</table>

						<table class="ui red sortable celled table">
							<thead>
								<tr>
									<th>Remark (Only 256 Characters)</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><textarea name="remark" cols='100' rows='3' value="<?php echo set_value('remark');?>"><?php echo set_value('remark');?></textarea></td>
								</tr>
							</tbody>
						</table>


						
						
					</div>
					
				</div>

					
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui red button">Reject</button>
		</div>
	</div>
		
</form>
<?php endforeach;?>
				
				
				
				
				
			