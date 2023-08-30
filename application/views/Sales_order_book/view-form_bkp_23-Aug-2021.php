
<?php foreach ($order_master as $order_master_row):?>
    
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SALES ORDER
      </div>
    </div>

        <?php echo $order_master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/>

        <?php echo $this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading">
                <td width="10%"><b>SO NO</td>
                <td width="5%"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b><?php echo $order_master_row->order_no;?></b></td>
                <td width="10%">PO NO</td>
                <td width="5%"></td>
                <td width="35%"><?php echo $order_master_row->cust_order_no; ?>&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Product Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($order_master_row->cust_product_no!='' ? $order_master_row->cust_product_no : '-');?></td>
                
            </tr>
        
            <tr class="item last">
                <td>SO DATE</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id']);?></td>
                
                <td>PO DATE</td>
                <td></td>
                <td><?php echo $this->common_model->view_date($order_master_row->cust_order_date,$this->session->userdata['logged_in']['company_id']); ?></td>
            </tr>
        </table>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="10%"><b>BILLING</td>
                <td width="5%"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%"><b>SHIPPING</td>
                <td width="5%"></td>
                <td width="35%"></td>

            </tr>

            <tr class="item">
                <td>BILL TO</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><b><?php echo $order_master_row->customer_name;?></b></td>
                <td>SHIP TO</td>
                <td></td>
                <td><?php 
                if(!empty($order_master_row->consin_adr_company_id)){
                    explode("|",$order_master_row->consin_adr_company_id)[0];
                    $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                    foreach($data['ship_to'] as $ship_to_row){
                        echo $ship_to_row->name1;
                        //echo explode("|",$order_master_row->consin_adr_company_id)[0];
                        $data['property']=$this->property_model->select_one_active_record_noncompany_withlanguage('property_master','property_id',explode("|",$order_master_row->consin_adr_company_id)[1],$this->session->userdata['logged_in']['language_id']);
                        foreach($data['property'] as $property_row){
                            //echo "//".$property_row->lang_property_name;
                        }
                    }
                }else{
                    echo "SAME AS BILLING";
                }


                ?></td>
            </tr>

            <tr class="item">
                <td>ADDRESS</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $order_master_row->strno." ".$order_master_row->name2." ".$order_master_row->street." ".$order_master_row->name3;?></td>
                <td>ADDRESS</td>
                <td></td>
                <td><?php 
                if(!empty($order_master_row->consin_adr_company_id)){
                    explode("|",$order_master_row->consin_adr_company_id)[0];
                    $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                    foreach($data['ship_to'] as $ship_to_row){
                    echo $ship_to_row->strno." ".$ship_to_row->name2." ".$ship_to_row->street." ".$ship_to_row->name3;
                    
                    }
                }else{
                    echo "-";
                }


                ?></td>

            </tr>
            <tr class="item">
                <td>GSTIN</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $order_master_row->isdn_local;?></td>
                <td>GSTIN</td>
                <td></td>
                <td><?php
                         if(!empty($order_master_row->consin_adr_company_id)){
                        explode("|",$order_master_row->consin_adr_company_id)[0];
                        $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                        foreach($data['ship_to'] as $ship_to_row){
                        echo $ship_to_row->isdn_local;
                        
                        }
                    }else{
                        echo "-";
                    }
                 ?></td>
            </tr>
            <tr class="item">
                <td>STATE</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($order_master_row->lang_city);?></td>
                
                <td>STATE</td>
                <td></td>
                <td><?php
                         if(!empty($order_master_row->consin_adr_company_id)){
                        explode("|",$order_master_row->consin_adr_company_id)[0];
                        $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                        foreach($data['ship_to'] as $ship_to_row){
                        echo strtoupper($ship_to_row->lang_city);
                        
                        }
                    }else{
                        echo "-";
                    }
                 ?></td>
            </tr>
            <tr class="item">
                <td>STATE CODE</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $order_master_row->state_code;?></td>
                
                <td>STATE CODE</td>
                <td></td>
                <td><?php
                         if(!empty($order_master_row->consin_adr_company_id)){
                        explode("|",$order_master_row->consin_adr_company_id)[0];
                        $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                        foreach($data['ship_to'] as $ship_to_row){
                        echo $ship_to_row->state_code;
                        
                        }
                    }else{
                        echo "-";
                    }
                 ?></td>
            </tr>

            <tr class="item">
                <td>COUNTRY</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $order_master_row->country_name;?></td>
                
                <td>COUNTRY</td>
                <td></td>
                <td>
                    
                    <?php
                    $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                    if($data['customer']==TRUE){

                        foreach($data['customer'] as $customer_row){


                            $country_result=$this->customer_model->select_one_active_state_country_record('country_master_lang',$this->session->userdata['logged_in']['company_id'],'country_id',$customer_row->country_id);
                           // echo $this->db->last_query();
                            if($country_result==FALSE){
                                //echo '';
                            }else{
                                foreach($country_result as $country){
                                    echo $country->lang_country_name;
                                    
                                }
                            }
                        }

                    }?>

                </td>
            </tr>
            
            

            <tr class="item">
                <td>TYPE</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($order_master_row->for_export==1 ? 'EXPORT' : 'LOCAL');?></td>
                <td>SAMPLE</td>
                <td></td>
                <td><?php echo ($order_master_row->for_sampling==1 ? 'SAMPLE' : 'NO');?></td>
            </tr>

            <?php
                if($order_master_row->for_export==1){
                    echo "<tr class='item last'>
                            <td>CURRENCY</td>
                            <td></td>
                            <td style='border-right:1px solid #D9d9d9;'>".$order_master_row->currency_id."</td>
                            <td>EXCHANGE RATE</td>
                            <td></td>
                            <td>".$this->common_model->read_number($order_master_row->exchange_rate,$this->session->userdata['logged_in']['company_id'])."</td>
                    </tr>";
                }
             ?>
        </table>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td><b>DETAILS</td>
                <td colspan="5"></td>
            </tr>
            
            <?php
            if(!empty($order_master_row->payment_condition_id)){

                $payment_term=$this->payment_term_model->select_one_active_record('payment_condition_master','id',$order_master_row->payment_condition_id,$this->session->userdata['logged_in']['language_id']);
                if($payment_term==FALSE){

                }else{
                    foreach($payment_term as $payment_term_row){

                echo '<tr class="item">
                        <td width="10%">PAYMENT TERM</td>
                        <td width="5%"></td>
                        <td width="35%" style="border-right:1px solid #D9d9d9;">'.$payment_term_row->lang_description.'</td>
                        <td width="10%">CREDIT DAYS</td>
                        <td width="5%"></td>
                        <td width="35%">'.$payment_term_row->net_days.'</td>
                        </tr>';
                    }
                }

            }else{

                $address_details=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$order_master_row->customer_no);
                //echo $this->db->last_query();

                if($address_details==FALSE){

                }else{
                    foreach($address_details as $address_details_row){

                        //echo $address_details_row->payment_condition_id;

                        $payment_term=$this->payment_term_model->select_one_active_record('payment_condition_master','id',$address_details_row->payment_condition_id,$this->session->userdata['logged_in']['language_id']);
                        if($payment_term==FALSE){

                        }else{
                            foreach($payment_term as $payment_term_row){

                        echo '<tr class="item">
                                <td width="10%">PAYMENT TERM</td>
                                <td width="5%"></td>
                                <td width="35%" style="border-right:1px solid #D9d9d9;">'.$payment_term_row->lang_description.'</td>
                                <td width="10%">CREDIT DAYS</td>
                                <td width="5%"></td>
                                <td width="35%">'.$payment_term_row->net_days.'</td>
                                </tr>';
                            }
                        }

                
                    }
                }
            }

            ?>

            <tr class="item">
                <td width="10%">CREATED BY</td>
                <td width="5%"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($order_master_row->username); ?></td>
                <td width="10%">APPROVED BY</td>
                <td width="5%"></td>
                <td width="35%"><?php echo (empty($order_master_row->approval_username) ? '-' : strtoupper($order_master_row->approval_username)); ?></td>
            </tr>

            <?php 
            $data['order_comment']=$this->common_model->select_one_active_record_nonlanguage_without_archive('order_master_lang',$this->session->userdata['logged_in']['company_id'],'order_master_lang.order_no',$order_master_row->order_no);
            if($data['order_comment']==FALSE){

            }else{
                foreach($data['order_comment'] as $order_comment_row){
                    echo '<tr class="item last">
                    <td><b>COMMENT</b></td>
                    <td></td>
                    <td colspan="4">'.strtoupper($order_comment_row->lang_addi_info).'</td>
                    </tr>';
                }
            }
            ?>

        </table>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="2%" style='border-bottom:1px solid #D9d9d9;'>#</td>
                <td width="1%" style='border-bottom:1px solid #D9d9d9;'></td>
                <td width="20%" style='border:1px solid #D9d9d9;'>PRODUCT</td>
                <td width="10%" style='border:1px solid #D9d9d9;'>SPEC</td>
                <td width="10%" style='border:1px solid #D9d9d9;'>QUANTITY</td>
                <td width="10%" style='border:1px solid #D9d9d9;'>UNIT RATE</td>
                <td width="10%" style='border:1px solid #D9d9d9;'>NET AMOUNT  <?php echo (!empty($order_master_row->currency_id) ? "(".$order_master_row->currency_id.")" : '');?></td>
                <?php 
                global $tax_arr;
                $i=0;
                foreach ($tax_master as $tax_value) {
                    $tax_arr[$i]=0;
                    echo "<td colspan='2' width='10%' style='border:1px solid #D9d9d9;'>".strtoupper($tax_value->lang_tax_code_desc)."</td>";
                    $i++;
                }
                ?>
                <td width="10%" style='border:1px solid #D9d9d9;'>TOTAL <?php echo (!empty($order_master_row->currency_id) ? "(".$order_master_row->currency_id.")" : '');?></td>
            </tr>
            <tr class="heading">
                <td colspan="6"></td>
                <td></td>
                <?php foreach ($tax_master as $tax_value) {
                    echo "<td style='border:1px solid #D9d9d9;'>RATE</td>
                    <td style='border:1px solid #D9d9d9;'>AMT</td>";
                }?>
                <td></td>
            </tr>
            <?php 
            $quantity=0;
            $total_quantity=0;
            $amount=0;
            $total_amount=0;
            $total_selling_price=0;
            foreach ($order_details as $order_details_row) {

                $quantity=$order_details_row->total_order_quantity;

                if($order_master_row->for_export==1){
                    $amount=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$order_details_row->calc_sell_price;
                }else{
                    $amount=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($order_details_row->selling_price,$this->session->userdata['logged_in']['company_id']);
                }
                



                echo "<tr class='item' >
                        <td width='2%' style='border-top:1px solid #D9d9d9;'>$order_details_row->ord_pos_no</td>
                        <td style='border-top:1px solid #D9d9d9;'></td>
                        <td width='20%' style='border:1px solid #D9d9d9;'>[$order_details_row->article_no] <br/>".$this->common_model->get_article_name($order_details_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td width='10%' style='border:1px solid #D9d9d9;'>";
                        if(!empty($order_details_row->spec_id)){
                            if(substr($order_details_row->spec_id,0,1)=="S"){
                                echo "<b><a href='".base_url()."/index.php/specification/view/".$order_details_row->spec_id."/".$order_details_row->spec_version_no." ' target='blank'>".$order_details_row->spec_id."_".$order_details_row->spec_version_no."</a></b>";
                            }else{
                                $bom=array('bom_no'=>$order_details_row->spec_id,
                                    'bom_version_no'=>$order_details_row->spec_version_no);
                                $data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
                                    foreach($data['bom'] as $bom_row){                                          
                                        echo "<b><a href='".base_url()."/index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$order_details_row->spec_id."_".$order_details_row->spec_version_no."</a></b>";
                                    }                                   
                                }
                            }

                        echo "<br/>
                        <b><a href='".($order_master_row->order_flag==0?base_url('/index.php/artwork_new/view/'):base_url('/index.php/artwork_springtube/view/'))."".$order_details_row->ad_id."/".$order_details_row->version_no."' target='blank'>".($order_details_row->ad_id!=""? $order_details_row->ad_id."_".$order_details_row->version_no:"")."</a></b>
                        <br/><br/>";
                        if($order_details_row->delivery_date!="0000-00-00"){

                            echo "<i>DELIVERY DATE</i><br/>".$this->common_model->view_date($order_details_row->delivery_date,$this->session->userdata['logged_in']['company_id']);
                        }
                       echo "</td>

                        <td width='10%' style='border:1px solid #D9d9d9;'>".$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])."</td>";

                        if($order_master_row->for_export==1){
                            echo "<td width='10%' style='border:1px solid #D9d9d9;'>".$order_details_row->calc_sell_price."</td>";
                        }else{
                            echo "<td width='10%' style='border:1px solid #D9d9d9;'>".$this->common_model->read_number($order_details_row->selling_price,$this->session->userdata['logged_in']['company_id'])."</td>";
                        }

                        echo "<td width='10%' style='border:1px solid #D9d9d9;'>".$amount."</td>";
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
                    echo "<td style='border:1px solid #D9d9d9;'>".$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id'])."%</td><td style='border:1px solid #D9d9d9;'>";

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
                    echo "<td style='border:1px solid #D9d9d9;'>".$this->common_model->read_number($order_details_row->total_selling_price,$this->session->userdata['logged_in']['company_id'])."</td>";

                echo "</tr>";

                $total_quantity+=$quantity;
                $total_amount+=$amount;
                $total_selling_price+=$order_details_row->total_selling_price;

                }

                $total_gross=$total_amount+$this->common_model->read_number($total_selling_price,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item last' style='background-color:#FAF6A3;'>
                        <td colspan='3' style='border:1px solid #D9d9d9;'><b>TOTAL</b></td>
                        <td style='border:1px solid #D9d9d9;'></td>
                        <td style='border:1px solid #D9d9d9;'><b>".$this->common_model->read_number($total_quantity,$this->session->userdata['logged_in']['company_id'])."/-</td>
                        <td style='border:1px solid #D9d9d9;'></td>
                        <td style='border:1px solid #D9d9d9;'><b>".$total_amount."/-</td>";
                        $l=0;
                        foreach ($tax_master as $tax_value) {
                            echo "<td style='border:1px solid #D9d9d9;'></td>
                                <td style='border:1px solid #D9d9d9;'><b>".$tax_arr[$l]."/-</td>";
                                $l++;
                        }

                echo "<td style='border:1px solid #D9d9d9;'><b>".$this->common_model->read_number($total_selling_price,$this->session->userdata['logged_in']['company_id'])."/-</td>
                    </tr>

                    ";
                ?>
    <?php endforeach;?>
    </table>
    <br/>
    <br/>
    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td colspan='7'>ORDER FOLLOWUPS</td>
            </tr>
            <tr class="heading" style='border:1px solid #D9d9d9;'>
                <td style='border-top:1px solid #D9d9d9;'>SR NO</td>
                <td style='border-top:1px solid #D9d9d9;'></td>
                <td style='border:1px solid #D9d9d9;'>DATE</td>
                <td style='border:1px solid #D9d9d9;'>FROM</td>
                <td style='border:1px solid #D9d9d9;'>TO</td>
                <td style='border:1px solid #D9d9d9;'>STATUS</td>
                <td style='border:1px solid #D9d9d9;'>REMARK</td>
            </tr>
            <?php 
                if($followup==FALSE){
                    echo "<tr>
                            <td colspan='7' style='border:1px solid #D9d9d9;'>NO RECORD FOUND</td>
                        </tr>";

                }else{
                    foreach($followup as $followup_row){

                        echo "<tr class='item'>
                                <td style='border-top:1px solid #D9d9d9;'>$followup_row->transaction_no</td>
                                <td style='border-top:1px solid #D9d9d9;'></td>
                                <td style='border:1px solid #D9d9d9;'>".$this->common_model->view_date($followup_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
                                <td style='border:1px solid #D9d9d9;'>".strtoupper($followup_row->from_user)."</td>
                                <td style='border:1px solid #D9d9d9;'>".strtoupper($followup_row->to_user)."</td>
                                <td style='border:1px solid #D9d9d9;'>".($followup_row->status==99 ? 'SETTLED' : '')."
                                    ".($followup_row->status==999 && $followup_row->approved_flag==1 ? 'APPROVED' : '')."
                                    ".($followup_row->status==999 && $followup_row->approved_flag==2 ? 'REJECTED' : '')."
                                    ".($followup_row->status==1 ? 'PENDING' : '')."</td>
                                    <td style='border:1px solid #D9d9d9;'>".strtoupper($followup_row->remark)."</td>
                            </tr>";
                     }
                }
            ?>
    </table>
    <br/>

    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td colspan='6'>ORDER HOLD/UNHOLD TRANSACTIONS</td>
            </tr>
            <tr class="heading" style='border:1px solid #D9d9d9;'>
                <td style='border-top:1px solid #D9d9d9;'>SR NO</td>
                <td style='border-top:1px solid #D9d9d9;'></td>
                <td style='border:1px solid #D9d9d9;'>DATE</td>
                <td style='border:1px solid #D9d9d9;'>BY</td>
                <td style='border:1px solid #D9d9d9;'>STATUS</td>
                <td style='border:1px solid #D9d9d9;'>REASON</td>
            </tr>
            <?php 
                if($order_transaction==FALSE){
                    echo "<tr>
                            <td colspan='6' style='border:1px solid #D9d9d9;'>NO RECORD FOUND</td>
                        </tr>";

                }else{
                    $j=1;
                    foreach($order_transaction as $order_transaction_row){

                        echo "<tr class='item'>
                                <td style='border-top:1px solid #D9d9d9;'>".$j."</td>
                                <td style='border-top:1px solid #D9d9d9;'></td>
                                <td style='border:1px solid #D9d9d9;'>".$this->common_model->view_date($order_transaction_row->order_hold_date,$this->session->userdata['logged_in']['company_id'])."</td>
                                <td style='border:1px solid #D9d9d9;'>".$this->common_model->get_user_name($order_transaction_row->user_id,$this->session->userdata['logged_in']['company_id'])."</td>
                                <td style='border:1px solid #D9d9d9;'>".($order_transaction_row->hold_flag==1 ? 'HOLD' : 'UNHOLD')."</td>
                                <td style='border:1px solid #D9d9d9;'>".$order_transaction_row->hold_reason."</td>
                            </tr>";
                            $j++;
                     }
                }
            ?>
    </table>
    <br/>
    <br/>

<!--  SPECIFICATION  DETAILS -->


    <?php foreach ($specification as $specification_row):?>

    <?php

        $arr=explode("^^^",$specification_row->dyn_qty_present);
        $arr1=explode("|",$arr[0]);
        $layers=$arr1[1];

    ?>

    <!-- HEADER TABLE START........................-->

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
                <td colspan="6" style="border:1px solid #D9d9d9;">SPECIFICATION DETAILS</td>
                
        </tr>   
        <tr class="heading">
            <td width="10%"><b>SPEC ID</b></td>
            <td width="5%"></td>
            <td width="35%"><?php echo $specification_row->spec_id;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>SPEC VERSION &nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo $specification_row->spec_version_no;?></b></td>
            <td width="10%">ARTWORK</td>
            <td width="5%"></td>
            <td width="35%"><?php echo ($specification_row->ad_id!='' ? "<a href='".base_url('index.php/artwork_new/view/'.$specification_row->ad_id.'/'.$specification_row->version_no)."' target='_blank'>".$specification_row->ad_id."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>ARTWORK VERSION&nbsp;&nbsp;&nbsp;&nbsp;</b>".$specification_row->version_no : "NOT ATTACHED");?></td>
        </tr>
        <tr class="item">
            <td><b>CUSTOMER</b></td>
            <td></td>
            <td><?php echo $specification_row->customer_name;?></td>
            <td><b>ARTICLE</b></td>
            <td></td>
            <td><?php echo $specification_row->article_name; ?>//<?php echo $specification_row->article_no;?></td>
        </tr>
        <tr class="item">
            <td><b>CREATED BY</b></td>
            <td></td>
            <td><?php echo strtoupper($specification_row->username); ?></td>
            <td><b>APPROVED BY</b></td>
            <td></td>
            <td><?php echo (empty($specification_row->approval_username) ? '-' : strtoupper($specification_row->approval_username)); ?></td>
        </tr>
        <tr class="item">
            <td><b>COMMENTS</b></td>
            <td></td>
            <td colspan="4"><?php foreach ($specification_sheet_lang as $specification_sheet_lang_row) {
               echo strtoupper($specification_sheet_lang_row->lang_comments);
            } ?></td>
        </tr>
    </table>

    <!-- HEADER TABLE END........................-->

    <!-- VIEW TABLE START........................-->

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%">PRODUCT</td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr class="heading">
                        <td width="19%">PARAMETER</td>
                        <td width="1%"></td>
                        <td width="15%">VALUE</td>
                        <td width="10%">%</td>
                        <td width="40%">RM</td>
                        <td width="15%">CODE</td>
                    </tr>
                </table>
            </td>

        </tr>
        <?php 
            // LAYER WISE TR GENERATION START-------------------------------------------

            for($i=1;$i<=$layers;$i++):

                $search=array();
                $search['spec_id']=$specification_row->spec_id;
                $search['spec_version_no']=$specification_row->spec_version_no;
                $search['item_group_id']='3'; 
                $search['parameter_name !=']='DRAWING'; 
                $search['layer_no']=$i;
                $order_by='srd_id'; 
                $sequence='asc';

                $specification_sheet_details_sleeve=$this->common_model->select_active_records_where_order_by('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$search,$order_by,$sequence);
                //echo $this->db->last_query();
                $count=count($specification_sheet_details_sleeve);
        ?>
                <tr class="item">
                    <td width="15%"><b>SLEEVE LAYER (<?php echo $i;?>)</b></td>
                    <td width="85%">
                        <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                            <?php
                                foreach($specification_sheet_details_sleeve as $row){

                                    echo'<tr class="details">
                                            <td width="19%">';
                                                if($row->parameter_name!=''){
                                                    if($row->parameter_name=='PRINT TYPE' && $i!=1) continue;
                                                     echo $row->parameter_name;
                                                }else{
                                                    if($row->mat_article_no!=''){
                                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$row->mat_article_no);
                                                        foreach($data['article'] as $article_row){
                                                            echo $article_row->sub_group;
                                                        } 
                                                    }
                                                    
                                                } 

                                            echo'</td>
                                            <td width="1%"></td>
                                            <td width="15%">'.($row->parameter_value!='' ?$row->parameter_value : $row->relating_master_value).'</td>
                                            <td width="10%">'.($row->mat_article_no!='' ? $row->mat_info :'').'</td>
                                            <td width="40%">';

                                                if($row->mat_article_no!=''){

                                                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$row->mat_article_no);
                                                        foreach($data['article'] as $article_row){
                                                            echo $article_row->article_name;
                                                            echo $article_sub_description=( $article_row->article_sub_description!='' ? " [".$article_row->article_sub_description."]" : "");
                                                        } 

                                                        if($row->item_group_id==3 && $row->parameter_name=='MASTER BATCH'){

                                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$row->supplier_no);
                                                            foreach($data['supplier'] as $supplier_row){
                                                                echo ' <b>['.$supplier_row->name1.']</b> ';
                                                            }

                                                        }


                                                }
                                               
                                            echo'</td>
                                            <td width="15%">'; 
                                                if($row->material=='1'){
                                                     echo $row->mat_article_no;
                                             }
                                            echo'</td>
                                    </tr>';

                                }

                            ?>
                            
                        </table>
                    </td>
                </tr>

            <?php 
                endfor; 
                // LAYER WISE TR GENERATION STOP-------------------------------------------
            ?>
        <!-- SHOULDER DETAILS START............................................-->

        <tr class="item">
            <td width="15%"><b>SHOULDER</b></td>
            <td width="85%">
                <table  cellpadding="0" cellspacing="0"  style="border:1px solid #ddd;">
                    <?php foreach($specification_shoulder_details as $specification_shoulder_details_row):?>
                    <tr>
                        <td width="19%">
                            <?php 
                                if($specification_shoulder_details_row->parameter_name=='' && $specification_shoulder_details_row->material=='1'){

                                         $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->sub_group;
                                            }
                                       
                                        
                                }
                                else{
                                     
                                    if($specification_shoulder_details_row->parameter_name=='DRAWING') continue;
                                    if($specification_shoulder_details_row->parameter_name=='PEEL OFF TE') continue;   
                                    echo $specification_shoulder_details_row->parameter_name;

                                }
                            ?>
                                
                        </td>
                        <td width="1%"></td>
                        <td width="15%">
                            <?php echo (empty($specification_shoulder_details_row->parameter_value)  ? $specification_shoulder_details_row->relating_master_value : $specification_shoulder_details_row->parameter_value);
                            ?>
                            
                        </td>
                        <td width="10%">
                            <?php echo $specification_shoulder_details_row->mat_info;?>                            
                        </td>
                        <td width="40%">
                            <?php 
                                

                                if(!empty($specification_shoulder_details_row->mat_article_no)&& $specification_shoulder_details_row->item_group_id==4){
                                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            $article_name=$article_row->article_name;
                                            echo $article_name;
                                            echo $article_sub_description=( $article_row->article_sub_description!='' ? " [".$article_row->article_sub_description."]" : "");
                                        }
                                    if($specification_shoulder_details_row->item_group_id==4 && $specification_shoulder_details_row->parameter_name=='MASTER BATCH'){

                                        $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_shoulder_details_row->supplier_no);
                                        foreach($data['supplier'] as $supplier_row){
                                            echo ' <b>['.$supplier_row->name1.']</b> ';
                                        }

                                    }

                                }
                            ?>                                
                        </td>
                        <td width="15%">
                            <?php echo $specification_shoulder_details_row->mat_article_no;
                               
                            ?>
                            
                        </td>
                    </tr>
                <?php endforeach;?>
                </table>
            </td>
        </tr>

        <!-- SHOULDER DETAILS END............................................-->

        <!-- CAP DETAILS END.................................................-->

        <tr class="item">
            <td width="15%"><b>CAP</b></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                    <?php foreach($specification_cap_details as $specification_cap_details_row):?>
                        <tr>
                            <td width="19%">
                                <?php 
                                    if($specification_cap_details_row->parameter_name=='' && $specification_cap_details_row->material=='1'){

                                         $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_cap_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->sub_group;
                                            }
                                       
                                        
                                    }
                                    else{
                                        if($specification_cap_details_row->parameter_name=='DRAWING') continue;  
                                        echo $specification_cap_details_row->parameter_name;

                                    }
                                ?>      
                            </td>
                            <td width="1%"></td>
                            <td width="15%">
                                <?php 
                                    echo (empty($specification_cap_details_row->parameter_value)  ? $specification_cap_details_row->relating_master_value : $specification_cap_details_row->parameter_value);
                                ?>
                                
                            </td>
                            <td width="10%"><?php echo $specification_cap_details_row->mat_info;?></td>
                            <td width="40%">
                                <?php 
                                    if(!empty($specification_cap_details_row->mat_article_no)){
                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_cap_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            echo $article_row->article_name;
                                            echo $article_sub_description=( $article_row->article_sub_description!='' ? " [".$article_row->article_sub_description."]" : "");
                                        }

                                    }

                                    if($specification_cap_details_row->item_group_id==5 && $specification_cap_details_row->parameter_name=='MASTER BATCH'){
                                        
                                        if(!empty($specification_cap_details_row->supplier_no)){

                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_cap_details_row->supplier_no);
                                            foreach($data['supplier'] as $supplier_row){
                                                echo ' <b>['.$supplier_row->name1.']</b> ';
                                              
                                            }

                                        }
                                    }
                                ?>
                                        
                            </td>
                            <td width="15%">
                                <?php 
                                    echo $specification_cap_details_row->mat_article_no;

                                ?>
                                        
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </td>
        </tr>
    </table>

<!-- VIEW TABLE END........................-->

<?php endforeach;?>

    <!-- APPROVAL/FOLLOWUP TABLE START........................-->

    <!--<table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td colspan='6'>APPROVAL FOLLOWUPS</td>
        </tr>
        <tr class="heading">
            <td width="20%">SR NO</td>
            <td width="1%"></td>
            <td width="20%">DATE</td>
            <td width="20%">FROM</td>
            <td width="20%">TO</td>
            <td width="19%">STATUS</td>
        </tr>
        <?php 
            if($followup==FALSE){
                echo"<tr>
                        <td colspan='6'>NO RECORD FOUND</td>
                    </tr>";

            }else{
                foreach($followup as $followup_row){

                    echo "<tr class='item'>
                            <td>$followup_row->transaction_no</td>
                            <td></td>
                            <td>".$this->common_model->view_date($followup_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
                            <td>".strtoupper($followup_row->from_user)."</td>
                            <td>".strtoupper($followup_row->to_user)."</td>
                            <td>".($followup_row->status==99 ? 'SETTLED' : '')."
                                ".($followup_row->status==999 && $followup_row->approved_flag==1? 'APPROVED' : '')."
                                ".($followup_row->status==999 && $followup_row->approved_flag==2? 'REJECTED' : '')."
                                ".($followup_row->status==1 ? 'PENDING' : '')."</td>
                        </tr>";
                 }
            }
            ?>
    </table> -->
  
   
<!-- BOM  DETAILS ........................................ -->

<?php 
    
if(!empty($bill_of_material)){  // IF BILL OF MATERIAL EXISTS------------------------------------

    foreach ($bill_of_material as $bill_of_material_row):?>

    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        BILL OF MATERIAL
      </div>
    </div>
    <br/>

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        
       
        <tr class="heading">
            <td width="10%"><b>BOM NO</b></td>
            <td width="5%"></td>
            <td width="35%"><?php echo $bill_of_material_row->bom_no."_".$bill_of_material_row->bom_version_no;?></b></td>
            <td width="10%">COMPONETS</td>
            <td width="5%"></td>
            <td width="35%">
                <div class="mini">
                <?php echo "<div  class='ui'>".$bill_of_material_row->sleeve_code."</div>";?>
                <?php echo "<div class='ui'>".$bill_of_material_row->shoulder_code."</div>";?>
                <?php echo "<div class='ui '>".$bill_of_material_row->label_code."</div>";?>
                <?php echo "<div class='ui'>".$bill_of_material_row->cap_code."</div>";?>
                </div>
            </td>
        </tr>

        <tr class="item">
            <td><b>CREATED BY</b></td>
            <td></td>
            <td><?php echo strtoupper($this->common_model->get_user_name($bill_of_material_row->user_id,$this->session->userdata['logged_in']['company_id'])); ?></td>
            <td><b>APPROVED BY</b></td>
            <td></td>
            <td><?php echo (empty($bill_of_material_row->approved_by) ? '-' : strtoupper($this->common_model->get_user_name($bill_of_material_row->approved_by,$this->session->userdata['logged_in']['company_id']))); ?></td>
        </tr>

        <tr class="item">
            <td><b>PRINT TYPE</b></td>
            <td></td>
            <td><?php echo strtoupper($bill_of_material_row->print_type); ?></td>
            <td><b>BOX TYPE</b></td>
            <td></td>
            <td><?php echo ($bill_of_material_row->for_export==1 ? "EXPORT":"DOMESTIC"); ?></td>
        </tr>

        <tr class="item">
            <td><b>COMMENT</b></td>
            <td></td>
            <td colspan="4"><?php echo strtoupper($bill_of_material_row->comment); ?></td>
            </tr>

    

    </table>
<?php endforeach;?>



<?php foreach ($sleeve_specification as $sleeve_specification_row):?>

<?php

    $arr=explode("^^^",$sleeve_specification_row->dyn_qty_present);
    $arr1=explode("|",$arr[0]);
    $layers=$arr1[1];

?>

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%"><?php echo $sleeve_specification_row->article_no;?></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr class="heading">
                        <td width="19%">PARAMETER</td>
                        <td width="1%"></td>
                        <td width="15%">VALUE</td>
                        <td width="10%">%</td>
                        <td width="40%">RM</td>
                        <td width="15%">CODE</td>
                    </tr>
                </table>
            </td>

        </tr>
        <?php 
            // LAYER WISE TR GENERATION START-------------------------------------------

            for($i=1;$i<=$layers;$i++):

                $search=array();
                $search['spec_id']=$sleeve_specification_row->spec_id;
                $search['spec_version_no']=$sleeve_specification_row->spec_version_no;
                $search['item_group_id']='3'; 
                $search['parameter_name !=']='DRAWING'; 
                $search['layer_no']=$i;
                $order_by='srd_id'; 
                $sequence='asc';

                $specification_sheet_details_sleeve=$this->common_model->select_active_records_where_order_by('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$search,$order_by,$sequence);
                //echo $this->db->last_query();
                $count=count($specification_sheet_details_sleeve);
        ?>
        <tr class="item">
                <td width="15%"><b>SLEEVE LAYER (<?php echo $i;?>)</b></td>
                <td width="85%">
                    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                        <?php
                            foreach($specification_sheet_details_sleeve as $row){

                                echo'<tr class="details">
                                        <td width="19%">';
                                            if($row->parameter_name!=''){
                                                if($row->parameter_name=='PRINT TYPE' && $i!=1) continue;
                                                 echo $row->parameter_name;
                                            }else{
                                                if($row->mat_article_no!=''){
                                                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$row->mat_article_no);
                                                    foreach($data['article'] as $article_row){
                                                        echo $article_row->sub_group;
                                                    } 
                                                }
                                                
                                            } 

                                        echo'</td>
                                        <td width="1%"></td>
                                        <td width="15%">'.($row->parameter_value!='' ?$row->parameter_value : $row->relating_master_value).'</td>
                                        <td width="10%">'.($row->mat_article_no!='' ? $row->mat_info."%" :'').'</td>
                                        <td width="40%">';

                                            if($row->mat_article_no!=''){

                                                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$row->mat_article_no);
                                                    foreach($data['article'] as $article_row){
                                                        echo $article_row->article_name;
                                                    } 

                                                    if($row->item_group_id==3 && $row->parameter_name=='MASTER BATCH'){

                                                        $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$row->supplier_no);
                                                        foreach($data['supplier'] as $supplier_row){
                                                            echo ' <b>['.$supplier_row->name1.']</b> ';
                                                        }

                                                    }


                                            }
                                           
                                        echo'</td>
                                        <td width="15%">'; 
                                            if($row->material=='1'){
                                                 echo $row->mat_article_no;
                                         }
                                        echo'</td>
                                </tr>';

                            }

                        ?>
                        
                    </table>
                </td>
        </tr>
        <?php endfor; ?>     
        
    </table>
   

 <!-- SHOULDER DETAILS START............................................-->

    <?php foreach($shoulder_specification as $shoulder_specification_row):?>

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%"><?php echo $shoulder_specification_row->article_no;?></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr class="heading">
                        <td width="19%">PARAMETER</td>
                        <td width="1%"></td>
                        <td width="15%">VALUE</td>
                        <td width="10%">%</td>
                        <td width="40%">RM</td>
                        <td width="15%">CODE</td>
                    </tr>
                </table>
            </td>

        </tr>

        <!-- SHOULDER DETAILS END............................................-->

        <!-- CAP DETAILS END.................................................-->

        <tr class="item">
            <td width="15%"><b>SHOULDER</b></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                    <?php foreach($specification_shoulder_details as $specification_shoulder_details_row):?>
                        <tr>
                            <td width="19%">
                                <?php 
                                    if($specification_shoulder_details_row->parameter_name=='' && $specification_shoulder_details_row->material=='1'){

                                         $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->sub_group;
                                            }
                                       
                                        
                                    }
                                    else{
                                        if($specification_shoulder_details_row->parameter_name=='DRAWING') continue;
                                        if($specification_shoulder_details_row->parameter_name=='PEEL OFF TE') continue;  
                                        echo $specification_shoulder_details_row->parameter_name;

                                    }
                                ?>      
                            </td>
                            <td width="1%"></td>
                            <td width="15%">
                                <?php 
                                    echo (empty($specification_shoulder_details_row->parameter_value)  ? $specification_shoulder_details_row->relating_master_value : $specification_shoulder_details_row->parameter_value);
                                

                                    if($specification_shoulder_details_row->parameter_name=='SHOULDER FOIL TAG' && $specification_shoulder_details_row->parameter_value=="" && $specification_shoulder_details_row->relating_master_value=="" && $specification_shoulder_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                        if($specification_shoulder_details_row->parameter_name=='PEEL OFF TE' && $specification_shoulder_details_row->parameter_value=="" && $specification_shoulder_details_row->relating_master_value=="" && $specification_shoulder_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                ?>
                                
                            </td>
                            <td width="10%"><?php echo ($specification_shoulder_details_row->mat_info!='' ? $specification_shoulder_details_row->mat_info."%" : '');?></td>
                            <td width="40%">
                                <?php 
                                    if(!empty($specification_shoulder_details_row->mat_article_no)){
                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            echo $article_row->article_name;
                                        }

                                    }

                                    if($specification_shoulder_details_row->item_group_id==5 && $specification_shoulder_details_row->parameter_name=='MASTER BATCH'){
                                        
                                        if(!empty($specification_shoulder_details_row->supplier_no)){

                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_shoulder_details_row->supplier_no);
                                            foreach($data['supplier'] as $supplier_row){
                                                echo ' <b>['.$supplier_row->name1.']</b> ';
                                              
                                            }

                                        }
                                    }
                                ?>
                                        
                            </td>
                            <td width="15%">
                                <?php 
                                    echo $specification_shoulder_details_row->mat_article_no;

                                ?>
                                        
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </td>
        </tr>
    </table>

<?php endforeach;?>

<?php 

if(empty($bill_of_material_row->label_code)){

}else{
   if(!empty($bill_of_material_row->label_code)){
    foreach($label_specification as $label_specification_row){ ?>

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%"><?php echo $label_specification_row->article_no;?></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr class="heading">
                        <td width="19%">PARAMETER</td>
                        <td width="1%"></td>
                        <td width="15%">VALUE</td>
                        <td width="10%">%</td>
                        <td width="40%">RM</td>
                        <td width="15%">CODE</td>
                    </tr>
                </table>
            </td>

        </tr>

        <!-- SHOULDER DETAILS END............................................-->

        <!-- CAP DETAILS END.................................................-->

        <tr class="item">
            <td width="15%"><b>LABEL</b></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                    <?php foreach($specification_label_details as $specification_label_details_row):?>
                        <tr>
                            <td width="19%">
                                <?php 
                                    if($specification_label_details_row->parameter_name=='' && $specification_label_details_row->material=='1'){

                                         $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_label_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->sub_group;
                                            }
                                       
                                        
                                    }
                                    else{
                                        if($specification_label_details_row->parameter_name=='DRAWING') continue;  
                                        echo $specification_label_details_row->parameter_name;

                                    }
                                ?>      
                            </td>
                            <td width="1%"></td>
                            <td width="15%">
                                <?php 
                                    echo (empty($specification_label_details_row->parameter_value)  ? $specification_label_details_row->relating_master_value : $specification_label_details_row->parameter_value." MM");
                                ?>
                                
                            </td>
                            <td width="10%"><?php echo ($specification_label_details_row->mat_info!='' ? $specification_label_details_row->mat_info."%":'');?></td>
                            <td width="40%">
                                <?php 
                                    if(!empty($specification_label_details_row->mat_article_no)){
                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_label_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            echo $article_row->article_name;
                                            echo $article_sub_description=( $article_row->article_sub_description!='' ? " [".$article_row->article_sub_description."]" : "");
                                        }

                                    }

                                    if($specification_label_details_row->item_group_id==5 && $specification_label_details_row->parameter_name=='MASTER BATCH'){
                                        
                                        if(!empty($specification_label_details_row->supplier_no)){

                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_label_details_row->supplier_no);
                                            foreach($data['supplier'] as $supplier_row){
                                                echo ' <b>['.$supplier_row->name1.']</b> ';
                                              
                                            }

                                        }
                                    }
                                ?>
                                        
                            </td>
                            <td width="15%">
                                <?php 
                                    echo $specification_label_details_row->mat_article_no;

                                ?>
                                        
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </td>
        </tr>
    </table>
<?php }
}
}
?>

<?php 
    if(!empty($cap_specification)){
    foreach($cap_specification as $cap_specification_row):?>
    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%"><?php echo $cap_specification_row->article_no;?></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr class="heading">
                        <td width="19%">PARAMETER</td>
                        <td width="1%"></td>
                        <td width="15%">VALUE</td>
                        <td width="10%">%</td>
                        <td width="40%">RM</td>
                        <td width="15%">CODE</td>
                    </tr>
                </table>
            </td>

        </tr>

        <!-- SHOULDER DETAILS END............................................-->

        <!-- CAP DETAILS END.................................................-->

        <tr class="item">
            <td width="15%"><b>CAP</b>

                <!-- CAP IMAGE HEIGHT AND DRAWING DETAILS------->
                </br>
                </br>
                </br>

                <?php
                    $cap_height='';
                    $cap_image='';
                    $cap_drawing='';

                    $cap_type='';
                    $cap_type_id='';
                    $cap_finish='';
                    $cap_finish_id='';
                    $cap_dia='';
                    $cap_dia_id='';
                    $cap_orifice='';
                    $cap_orifice_id='';

                    foreach($specification_cap_details as $specification_cap_details_row){

                        if($specification_cap_details_row->parameter_name=='STYLE'){
                           $cap_type=($specification_cap_details_row->parameter_value==''?$specification_cap_details_row->relating_master_value:$specification_cap_details_row->parameter_value);

                           if($cap_type!=''){
                                $cap_types_master_result=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$cap_type);
                                foreach($cap_types_master_result as $cap_types_master_row){
                                    $cap_type_id=$cap_types_master_row->cap_type_id;
                                }
                            } 
                        }
                        if($specification_cap_details_row->parameter_name=='MOLD FINISH'){
                           $cap_finish=($specification_cap_details_row->parameter_value==''?$specification_cap_details_row->relating_master_value:$specification_cap_details_row->parameter_value);

                           if($cap_finish!=''){
                                $cap_finish_master_result=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$cap_finish);
                                foreach($cap_finish_master_result as $cap_finish_master_row){
                                    $cap_finish_id=$cap_finish_master_row->cap_finish_id;
                                }

                           } 


                        }
                        if($specification_cap_details_row->parameter_name=='DIAMETER'){
                           $cap_dia=($specification_cap_details_row->parameter_value==''?$specification_cap_details_row->relating_master_value:$specification_cap_details_row->parameter_value);

                           if($cap_dia!=''){
                                $cap_diameter_master_result=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$cap_dia);
                                foreach($cap_diameter_master_result as $cap_diameter_master_row){
                                    $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
                                }
                            } 


                        }
                        if($specification_cap_details_row->parameter_name=='ORIFICE'){
                           $cap_orifice=($specification_cap_details_row->parameter_value==''?$specification_cap_details_row->relating_master_value:$specification_cap_details_row->parameter_value);

                           if($cap_orifice!=''){
                                $cap_orifice_master_result=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$cap_orifice);
                                foreach($cap_orifice_master_result as $cap_orifice_master_row){
                                    $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
                                }
                            } 


                        }

                    }

                    $data=array('cap_type_id' =>$cap_type_id,
                                'cap_dia_id'=>$cap_dia_id,
                                'cap_finish_id'=>$cap_finish_id,
                                'cap_orifice_id'=>$cap_orifice_id,
                                'archive'=>'0');
                    //echo print_r($data);

                    $shoulder_orifice_dependancy_result=$this->common_model->select_active_records_where('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$data);

                   // echo $this->db->last_query();

                    foreach ($shoulder_orifice_dependancy_result as $shoulder_orifice_dependancy_row) {
                        $cap_height=$shoulder_orifice_dependancy_row->cap_height;
                        $cap_image=$shoulder_orifice_dependancy_row->cap_image;
                        $cap_drawing=$shoulder_orifice_dependancy_row->cap_drawing;
                    }


                ?>

                <?php if($cap_image!=''){?>
                  <img src="<?php echo base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/caps/'.$cap_image.'');?>" style='margin: 10px;' alt="Cap Name"  width="75">
                <?php }?>


                
                </br>
                </br>
                </br>


                <!-- CAP SUPPLIER DETAILS---------------------------------->
                <?php 
                //$cap_article_no=$specification_row->article_no;
                $supplier_no="";
                $data['alternative_supplier']=$this->common_model->select_one_active_record('alternative_supplier',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_specification_row->article_no);
                foreach ($data['alternative_supplier'] as $alternative_supplier_row) {
                    $supplier_no=$alternative_supplier_row->supplier_no;
                }
                if($supplier_no!=""){

                    $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$supplier_no);
                    foreach($data['supplier'] as $supplier_row){
                        echo ' <br>SUPPLIER NAME:- <i>'.$supplier_row->name1.'</i> ';
                      
                    }
                }

                ?>

            </td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                    <?php foreach($specification_cap_details as $specification_cap_details_row):?>
                        <tr>
                            <td width="19%">
                                <?php 
                                    if($specification_cap_details_row->parameter_name=='' && $specification_cap_details_row->material=='1'){

                                         $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_cap_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->sub_group;
                                            }
                                       
                                        
                                    }
                                    else{
                                        if($specification_cap_details_row->parameter_name=='DRAWING') continue;  
                                        echo $specification_cap_details_row->parameter_name;

                                    }
                                ?>      
                            </td>
                            <td width="1%"></td>
                            <td width="15%">
                                <?php 
                                echo ($specification_cap_details_row->parameter_value=='' ? $specification_cap_details_row->relating_master_value : $specification_cap_details_row->parameter_value);
                                
                                if($specification_cap_details_row->parameter_name=='METALIZATION' && $specification_cap_details_row->parameter_value=="" && $specification_cap_details_row->relating_master_value=="" && $specification_cap_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                    if($specification_cap_details_row->parameter_name=='CAP FOIL WIDTH' && $specification_cap_details_row->parameter_value=="" && $specification_cap_details_row->relating_master_value=="" && $specification_cap_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                    if($specification_cap_details_row->parameter_name=='C.FOIL DIST FROM BOT' && $specification_cap_details_row->parameter_value=="" && $specification_cap_details_row->relating_master_value=="" && $specification_cap_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                        if($specification_cap_details_row->parameter_name=='SHRINK SLEEVE' && $specification_cap_details_row->parameter_value=="" && $specification_cap_details_row->relating_master_value=="" && $specification_cap_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                        if($specification_cap_details_row->parameter_name=='CAP FOIL COLOR' && $specification_cap_details_row->parameter_value=="" && $specification_cap_details_row->relating_master_value=="" && $specification_cap_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                ?>
                                
                            </td>
                            <td width="10%"><?php echo ($specification_cap_details_row->mat_info!='' ? $specification_cap_details_row->mat_info."%":'');?></td>
                            <td width="40%">
                                <?php 
                                    if(!empty($specification_cap_details_row->mat_article_no)){
                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_cap_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            echo $article_row->article_name;
                                        }

                                    }

                                    if($specification_cap_details_row->item_group_id==5 && $specification_cap_details_row->parameter_name=='MASTER BATCH'){
                                        
                                        if(!empty($specification_cap_details_row->supplier_no)){

                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_cap_details_row->supplier_no);
                                            foreach($data['supplier'] as $supplier_row){
                                                echo ' <b>['.$supplier_row->name1.']</b> ';
                                              
                                            }

                                        }
                                    }
                                ?>
                                        
                            </td>
                            <td width="15%">
                                <?php 
                                    echo $specification_cap_details_row->mat_article_no;

                                ?>
                                        
                            </td>
                        </tr>
                    <?php endforeach;?>
                    <tr><td>CAP HEIGHT</td><td></td><td colspan="4"><?php echo $this->common_model->read_number($cap_height,$this->session->userdata['logged_in']['company_id']); ?> MM</td></tr>
                    <tr><td>DRAWING</td><td></td><td><?php echo $cap_drawing;?></td></tr>
                    
                </table>
            </td>
        </tr>
    </table>

<?php endforeach;} ?>




<?php endforeach; 


}// IF BILL OF MATERIAL EXISTS---------

?> <!-- BOM SLEEVE SPECIFICATION....................-->


<!-- ................................................ -->


    
<?php foreach ($artwork as $artwork_row):?>

     <?php
     $result_lacquer_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','12');
    
        $result_dia=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','1');

        $result_length=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','2');

        $result_sleeve_color=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','7');

        $result_print_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','17');

        foreach($result_print_type as $print_type_row){ $prin_type=$print_type_row->parameter_value; }

       $result_printing_upto_neck=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','8');

       foreach($result_printing_upto_neck as $result_printing_upto_neck_row){ $printing_upto_neck=$result_printing_upto_neck_row->parameter_value; }

       $result_screen_ink=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','19');

       $result_flexo_ink=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','20');

       $result_offset_ink=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','21');

       $result_special_ink=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','22');

        $result_hot_foil_one=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','23');

        $result_hot_foil_one_per_tube=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','24');

        $result_hot_foil_two=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','25');

        $result_hot_foil_two_per_tube=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','26');

        $result_lacquer_type_one=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','27');

        $result_lacquer_type_one_mixing_pc=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','28');

        $result_lacquer_type_two=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','29');

        $result_lacquer_type_two_mixing_pc=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','30');

        $result_sealing=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','5');

        $result_eye_dimension=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','13');

        $result_eye_position=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','14');
    ?>
    <!-- <?php echo $artwork_row->final_approval_flag==1 ? '<a class="ui green right ribbon label">Approved</a>' : '<a class="ui  red right ribbon label">Unapproved</a>';?>
         <br/>

        <?php echo $this->common_model->view_date($artwork_row->ad_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($artwork_row->ad_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
    
        <br/>
        <br/>
        -->
    <br/>
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        ARTWORK
      </div>
    </div>
    <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading">
                <td width="20%"><b>ARTWORK NO</td>
                <td width="5%"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;"><b><?php echo $artwork_row->ad_id;?></b></td>
                <td width="15%">VERSION NO</td>
                <td width="5%"></td>
                <td width="30%"><?php echo $artwork_row->version_no; ?></td>
                
            </tr>
            
            <tr class="item">
                <td>CUSTOMER</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $artwork_row->customer_name;?>//<?php echo $artwork_row->adr_company_id;?></td>
                
                <td>ARTICLE</td>
                <td></td>
                <td><?php echo $artwork_row->article_name; ?>//<?php echo $artwork_row->article_no;?></td>
            </tr>
            
            <tr class="heading">
                <td colspan="6">
                    OTHER DETAILS
                </td>
               
            </tr>
            <tr class="item">
                <td ><b>ARTWORK FILE</b></td>
                <td ></td>
               
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($artwork_row->artwork_image_nm!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$artwork_row->artwork_image_nm.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');?>
                    
                </td>

                
            </tr>
            <tr class="item" >
                <td width="15%"><b>DIA</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_dia as $dia_row){ echo $dia_row->parameter_value; }?></td>
                <td ><b>LENGTH</b></td>
                <td></td>
                <td><?php foreach($result_length as $length_row){ echo $length_row->parameter_value; }?></td>
            </tr>

            
            <tr class="item">
                <td><b>SLEEVE COLOR</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_sleeve_color as $sleeve_color_row){ echo strtoupper($sleeve_color_row->parameter_value); }?></td>
                <td><b>PRINT TYPE</b></td>
                <td></td>
                <td><?php echo $prin_type; 
                //foreach($result_dia as $dia_row){ echo $dia_row->parameter_value; 
                ?></td>


            </tr>
            
            <tr class="item">
                <td><b>PRINT UP TO NECK</b></td>
                <td></td>
                <td><?php echo $printing_upto_neck;?></td>
                <td></td>
                <td></td>
                <td></td>
                

            </tr>
            
             <tr class="item">
                <td><b>SEALING AND NON LACQUERING AREA</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_sealing as $sealing_row){ echo $sealing_row->parameter_value; }?></td>
                <td></td>
                <td></td>
                <td></td>
                
            </tr>

            <tr class="item">
                <td><b>EYE MARK DIMENSION</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_eye_dimension as $result_eye_dimension_row){ echo $result_eye_dimension_row->parameter_value; }?></td>
                <td><b>EYE MARK POSITION FROM OPEN END</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_eye_position as $result_eye_position_row){ echo $result_eye_position_row->parameter_value; }?></td>
                
            </tr>

            <!--<tr class="item last">
                <td><b>SCREEN INK</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_screen_ink as $result_screen_ink_row){ echo $result_screen_ink_row->parameter_value; }?></td>
                <td><b>FLEXO INK</b></td>
                <td></td>
                <td><?php foreach($result_flexo_ink as $result_flexo_ink_row){ echo $result_flexo_ink_row->parameter_value; }?></td>
            </tr>


            <tr class="item last">
                <td><b>OFFSET INK</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_offset_ink as $result_offset_ink_row){ echo $result_offset_ink_row->parameter_value; }?></td>
                <td><b>SPECIAL INK</b></td>
                <td></td>
                <td><?php foreach($result_special_ink as $result_special_ink_row){ echo $result_special_ink_row->parameter_value; }?></td>
            </tr>-->


            <tr class="item">
                <td><b>HOT FOIL ONE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_hot_foil_one as $result_hot_foil_one_row){ echo $this->common_model->get_article_name($result_hot_foil_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?></td>
                <td><b>HOT FOIL SQM/TUBE</b></td>
                <td></td>
                <td><?php foreach($result_hot_foil_one_per_tube as $result_hot_foil_one_per_tube_row){ echo $result_hot_foil_one_per_tube_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td><b>HOT FOIL TWO</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_hot_foil_two as $result_hot_foil_two_row){ echo $this->common_model->get_article_name($result_hot_foil_two_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?></td>
                <td><b>HOT FOIL SQM/TUBE</b></td>
                <td></td>
                <td><?php foreach($result_hot_foil_two_per_tube as $result_hot_foil_two_per_tube_row){ echo $result_hot_foil_two_per_tube_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td><b>LACQUER ONE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_lacquer_type_one as $result_lacquer_type_one_row){ echo $this->common_model->get_article_name($result_lacquer_type_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?></td>
                <td><b>LACQUER ONE %</b></td>
                <td></td>
                <td><?php foreach($result_lacquer_type_one_mixing_pc as $result_lacquer_type_one_mixing_pc_row){ echo $result_lacquer_type_one_mixing_pc_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td><b>LACQUER TWO</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_lacquer_type_two as $result_lacquer_type_two_row){ echo $this->common_model->get_article_name($result_lacquer_type_two_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?></td>
                <td><b>LACQUER TWO %</b></td>
                <td></td>
                <td><?php foreach($result_lacquer_type_two_mixing_pc as $result_lacquer_type_two_mixing_pc_row){ echo $result_lacquer_type_two_mixing_pc_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td><b>LACQUER COMMENT</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php foreach($result_lacquer_type as $lacquer_row){
                    $lacquer=substr($lacquer_row->parameter_value,strpos($lacquer_row->parameter_value, "||") + 2);
                    echo strtoupper(str_replace("^"," + ",$lacquer));
                    } ?>
                    
                    </td>
                <td><b></b></td>
                <td></td>
                <td></td>
            </tr>
            
             <tr class="heading">
                <td><b>CREATED BY</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($artwork_row->username);?></td>
                
                <td><b>APPROVED BY</b></td>
                <td></td>
                <td><?php echo strtoupper($artwork_row->approval_username);?></td>
            </tr>

      

        </table>
        <?php endforeach;?>
    </table>
<!-- CAP SPECIFICATION VIEW  FOR STELLA---------------------->

<?php  if( empty($specification) && empty($bill_of_material) && !empty($cap_specification)){


    foreach($cap_specification as $cap_specification_row):?>
    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%"><?php echo $cap_specification_row->article_no;?></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr class="heading">
                        <td width="19%">PARAMETER</td>
                        <td width="1%"></td>
                        <td width="15%">VALUE</td>
                        <td width="10%">%</td>
                        <td width="40%">RM</td>
                        <td width="15%">CODE</td>
                    </tr>
                </table>
            </td>

        </tr>

   

        <!-- CAP DETAILS END.................................................-->

        <tr class="item">
            <td width="15%"><b>CAP</b>
                <?php 
                //$cap_article_no=$specification_row->article_no;
                $supplier_no="";
                $data['alternative_supplier']=$this->common_model->select_one_active_record('alternative_supplier',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_specification_row->article_no);
                foreach ($data['alternative_supplier'] as $alternative_supplier_row) {
                    $supplier_no=$alternative_supplier_row->supplier_no;
                }
                if($supplier_no!=""){

                    $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$supplier_no);
                    foreach($data['supplier'] as $supplier_row){
                        echo ' <br>SUPPLIER NAME:- <i>'.$supplier_row->name1.'</i> ';
                      
                    }
                }

                ?>

            </td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                    <?php foreach($specification_cap_details as $specification_cap_details_row):?>
                        <tr>
                            <td width="19%">
                                <?php 
                                    if($specification_cap_details_row->parameter_name=='' && $specification_cap_details_row->material=='1'){

                                         $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_cap_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->sub_group;
                                            }
                                       
                                        
                                    }
                                    else{
                                        if($specification_cap_details_row->parameter_name=='DRAWING') continue;  
                                        echo $specification_cap_details_row->parameter_name;

                                    }
                                ?>      
                            </td>
                            <td width="1%"></td>
                            <td width="15%">
                                <?php 
                                    echo (empty($specification_cap_details_row->parameter_value)  ? $specification_cap_details_row->relating_master_value : $specification_cap_details_row->parameter_value);
                                ?>
                                
                            </td>
                            <td width="10%"><?php echo ($specification_cap_details_row->mat_info!='' ? $specification_cap_details_row->mat_info."%":'');?></td>
                            <td width="40%">
                                <?php 
                                    if(!empty($specification_cap_details_row->mat_article_no)){
                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_cap_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            echo $article_row->article_name;
                                        }

                                    }

                                    if($specification_cap_details_row->item_group_id==5 && $specification_cap_details_row->parameter_name=='MASTER BATCH'){
                                        
                                        if(!empty($specification_cap_details_row->supplier_no)){

                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_cap_details_row->supplier_no);
                                            foreach($data['supplier'] as $supplier_row){
                                                echo ' <b>['.$supplier_row->name1.']</b> ';
                                              
                                            }

                                        }
                                    }
                                ?>
                                        
                            </td>
                            <td width="15%">
                                <?php 
                                    echo $specification_cap_details_row->mat_article_no;

                                ?>
                                        
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </td>
        </tr>
    </table>

<?php endforeach;
    } 

?>
<!--SHOULDER SPECIFICATION FOR STELLA -->
<?php  if( empty($specification) && empty($bill_of_material) && !empty($cap_specification) && !empty($shoulder_specification)){

foreach($shoulder_specification as $shoulder_specification_row):?>

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%"><?php echo $shoulder_specification_row->article_no;?></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr class="heading">
                        <td width="19%">PARAMETER</td>
                        <td width="1%"></td>
                        <td width="15%">VALUE</td>
                        <td width="10%">%</td>
                        <td width="40%">RM</td>
                        <td width="15%">CODE</td>
                    </tr>
                </table>
            </td>

        </tr>

        <!-- SHOULDER DETAILS END............................................-->

        <!-- CAP DETAILS END.................................................-->

        <tr class="item">
            <td width="15%"><b>SHOULDER</b></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                    <?php foreach($specification_shoulder_details as $specification_shoulder_details_row):?>
                        <tr>
                            <td width="19%">
                                <?php 
                                    if($specification_shoulder_details_row->parameter_name=='' && $specification_shoulder_details_row->material=='1'){

                                         $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->sub_group;
                                            }
                                       
                                        
                                    }
                                    else{
                                        if($specification_shoulder_details_row->parameter_name=='DRAWING') continue;
                                        if($specification_shoulder_details_row->parameter_name=='PEEL OFF TE') continue;  
                                        echo $specification_shoulder_details_row->parameter_name;

                                    }
                                ?>      
                            </td>
                            <td width="1%"></td>
                            <td width="15%">
                                <?php 
                                    echo (empty($specification_shoulder_details_row->parameter_value)  ? $specification_shoulder_details_row->relating_master_value : $specification_shoulder_details_row->parameter_value);
                                

                                    if($specification_shoulder_details_row->parameter_name=='SHOULDER FOIL TAG' && $specification_shoulder_details_row->parameter_value=="" && $specification_shoulder_details_row->relating_master_value=="" && $specification_shoulder_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                        if($specification_shoulder_details_row->parameter_name=='PEEL OFF TE' && $specification_shoulder_details_row->parameter_value=="" && $specification_shoulder_details_row->relating_master_value=="" && $specification_shoulder_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                ?>
                                
                            </td>
                            <td width="10%"><?php echo ($specification_shoulder_details_row->mat_info!='' ? $specification_shoulder_details_row->mat_info."%" : '');?></td>
                            <td width="40%">
                                <?php 
                                    if(!empty($specification_shoulder_details_row->mat_article_no)){
                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            echo $article_row->article_name;
                                        }

                                    }

                                    if($specification_shoulder_details_row->item_group_id==5 && $specification_shoulder_details_row->parameter_name=='MASTER BATCH'){
                                        
                                        if(!empty($specification_shoulder_details_row->supplier_no)){

                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_shoulder_details_row->supplier_no);
                                            foreach($data['supplier'] as $supplier_row){
                                                echo ' <b>['.$supplier_row->name1.']</b> ';
                                              
                                            }

                                        }
                                    }
                                ?>
                                        
                            </td>
                            <td width="15%">
                                <?php 
                                    echo $specification_shoulder_details_row->mat_article_no;

                                ?>
                                        
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </td>
        </tr>
    </table>

<?php endforeach;

    }
?>



<?php
/*
    
  $data['followup_received']=$this->sales_order_followup_model->select_followup_received_records_for_so('followup',$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','75','followup.record_no',$this->uri->segment(3));

  //echo $this->db->last_query();


    if($data['followup_received']==FALSE){
    }else{
        foreach($data['followup_received'] as $followup_received_row){
            echo  '<a href="'.base_url('index.php/sales_order_followup/approved/'.$followup_received_row->record_no.'/'.$followup_received_row->transaction_no).'"><button class="ui green button"><i class="thumbs outline up icon"></i> 
  Approve
</button></a>
                                            &nbsp; 

                                            <a href="'.base_url('index.php/sales_order_followup/notapproved/'.$followup_received_row->record_no.'/'.$followup_received_row->transaction_no).'" >

                                            <button class="ui red button">
                                            <i class="thumbs outline down icon"></i>
  Reject
</button></a>';

        }
    }*/
?>






    </div>
</body>
</html>
