
<?php foreach ($order_master as $order_master_row):?>
    
    <br/>
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        TRACK MY ORDER
      </div>
    </div>

    <?php echo $order_master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

    <br/>

    <?php echo $this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';
    ?>

    <br/>
    <br/>

    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
        <tr class="heading">
            <td width="10%"><b>SO NO</td>
            <td width="5%"></td>
            <td width="35%" style="border-right:1px solid #D9d9d9;"><b><?php echo $order_master_row->order_no;?></b></td>
            <td width="10%">PO NO</td>
            <td width="5%"></td>
            <td width="35%"><?php echo $order_master_row->cust_order_no; ?></td>
            
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

        <!-- ORDER DETAILS -->

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

                    </table>";
                ?>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td colspan='6'>ORDER FOLLOWUPS</td>
            </tr>
            <tr class="heading" style='border:1px solid #D9d9d9;'>
                <td style='border-top:1px solid #D9d9d9;'>SR NO</td>
                <td style='border-top:1px solid #D9d9d9;'></td>
                <td style='border:1px solid #D9d9d9;'>DATE</td>
                <td style='border:1px solid #D9d9d9;'>FROM</td>
                <td style='border:1px solid #D9d9d9;'>TO</td>
                <td style='border:1px solid #D9d9d9;'>STATUS</td>
            </tr>
            <?php 
                if($followup==FALSE){
                    echo "<tr>
                            <td colspan='6' style='border:1px solid #D9d9d9;'>NO RECORD FOUND</td>
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

    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        JOBCARD DETAILS
      </div>
    </div>
    <br/>

<?php

    $details_data=array('order_no'=>$order_master_row->order_no);

    $order_details_result=$this->sales_order_book_model->active_details_records_new('order_details',$details_data,$this->session->userdata['logged_in']['company_id'],'','');

    foreach ($order_details_result as $key => $order_details_row) {

        $data_production_master=array(
            'sales_ord_no'=>$order_master_row->order_no,
            'article_no'=>$order_details_row->article_no,
            'archive'=>0
        );


        echo'<table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="2%" >SR NO</td>
            <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
            <td width="10%" style="border-right:1px solid #D9d9d9;">FOR PROCESS</td>
            <td width="10%" style="border-right:1px solid #D9d9d9;">JOB DATE</td>
            <td width="10%" style="border-right:1px solid #D9d9d9;">JOBCARD NO</td>
            <td width="10%" style="border-right:1px solid #D9d9d9;">ORDER NO</td>
            <td width="10%" style="border-right:1px solid #D9d9d9;">ARTICLE NO</td>
            <td width="10%" style="border-right:1px solid #D9d9d9;">ORDER QTY</td>            
            
            <td width="10%" style="border-right:1px solid #D9d9d9;">JOBCARD QTY</td>            
            <td width="10%" style="border-right:1px solid #D9d9d9;">JOBCARD METERS</td>
            
            
            
            <!--<td width="10%" style="border:1px solid #D9d9d9;">COST</td>-->
        </tr>    ';


        $production_master_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data_production_master);
        $i=1;
        foreach($production_master_result as $production_master_row){
          echo'<tr>
          <td width="2%" style="border-bottom:1px solid #D9d9d9;">'.$i++.'</td>
          <td width="1%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
          <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">';         

          $springtube_jobcard_type_master_result=$this->common_model->select_one_active_record('springtube_jobcard_type_master',$this->session->userdata['logged_in']['company_id'],'jobcard_type',$production_master_row->jobcard_type);
          foreach ($springtube_jobcard_type_master_result as $key => $springtube_jobcard_type_master_row) {
              echo $springtube_jobcard_type_master_row->process_name;
          }

          echo'</td>
          <td width="10%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.$this->common_model->view_date($production_master_row->manu_plan_date,$this->session->userdata['logged_in']['company_id']).'</td>

          <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$production_master_row->mp_pos_no.'</td>
          <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$production_master_row->sales_ord_no.'</td>
          <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$production_master_row->article_no.'</td>
          <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$this->common_model->read_number($production_master_row->mp_qty,$this->session->userdata['logged_in']['company_id']).'</td>
          
          <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']).'</td>
          <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$production_master_row->total_meters.'</td>

          </tr>';
        }
        echo'</table><br/><br/>';

        echo'<div class="ui teal labels" style="text-align: center;">
        <div class="ui label">
       FILM EXTRUSION
        </div>
        </div>
        <br/>';
        $data_production_master=array(
            'sales_ord_no'=>$order_master_row->order_no,
            'article_no'=>$order_details_row->article_no,
            'archive'=>0,
            'jobcard_type'=>1
        );

        $production_master_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data_production_master);

        

        foreach ($production_master_result as $key => $production_master_row) {

            echo'<table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading"><td colspan="13">'.$production_master_row->mp_pos_no.'</td></tr>
            <tr class="heading">
                <td width="2%" style="border-bottom:1px solid #D9d9d9;">SR NO</td>
                <td width="1%" style="border-bottom:1px solid #D9d9d9;"></td>
                <td width="10%" style="border:1px solid #D9d9d9;">DATE</td>
                <td width="10%" style="border:1px solid #D9d9d9;">SHIFT</td> 
                <td width="10%" style="border:1px solid #D9d9d9;">ORDER NO</td>
                <td width="10%" style="border:1px solid #D9d9d9;">ARTICLE NO</td>
                <td width="10%" style="border:1px solid #D9d9d9;">DIA</td>
                <td width="10%" style="border:1px solid #D9d9d9;">COLOR</td>                         
                <td width="10%" style="border:1px solid #D9d9d9;">JOBCARD NO</td>
                <td width="10%" style="border:1px solid #D9d9d9;">OK PROD</td>
                <td width="10%" style="border:1px solid #D9d9d9;">QC HOLD</td>
                <td width="10%" style="border:1px solid #D9d9d9;">QC SCRAP</td>
                <td width="10%" style="border:1px solid #D9d9d9;">TOTAL PROD</td>                   
            </tr>';

            $data_search=array('springtube_extrusion_production_details.jobcard_no'=>$production_master_row->mp_pos_no);
            
            $springtube_extrusion_production_result=$this->springtube_extrusion_production_model->select_active_records_by_order('springtube_extrusion_production_master', $this->session->userdata['logged_in']['company_id'],$data_search);

            //print_r($springtube_extrusion_production_result);

            if($springtube_extrusion_production_result){


                $sum_ok_production=0;
                $sum_qc_hold=0;
                $sum_qc_scrap=0;
                $sum_total_produced=0;

                $i=1;
                foreach ($springtube_extrusion_production_result as $key => $springtube_extrusion_production_row) {


                    $total_ok_meters=0;
                    $ok_from_production=0;
                    $ok_from_qc=0;
                    $data_ok_meters=array('details_id'=>$springtube_extrusion_production_row->details_id,'from_process'=>1,'archive'=>0);
                    $springtube_extrusion_wip_master_result=$this->common_model->select_active_records_where('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data_ok_meters);

                    foreach ($springtube_extrusion_wip_master_result as $springtube_extrusion_wip_master_row) {
                        $ok_from_production+=$springtube_extrusion_wip_master_row->total_ok_meters;
                    }

                    $data_qc_ok_meters=array('details_id'=>$springtube_extrusion_production_row->details_id,'from_process'=>7,'archive'=>0);
                    $springtube_extrusion_wip_master_result_1=$this->common_model->select_active_records_where('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data_qc_ok_meters);

                    foreach ($springtube_extrusion_wip_master_result_1 as $springtube_extrusion_wip_master_row_1) {
                        $ok_from_qc+=$springtube_extrusion_wip_master_row_1->total_ok_meters;
                    }


                    $total_ok_meters=$ok_from_production+$ok_from_qc;

                    $qc_hold_meters=0;
                    $data_qc_hold=array('details_id'=>$springtube_extrusion_production_row->details_id,'status'=>0,'archive'=>0);
                    $springtube_extrusion_qc_master_hold=$this->common_model->select_active_records_where('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],$data_qc_hold);

                    foreach ($springtube_extrusion_qc_master_hold as $springtube_extrusion_qc_master_hold_row) {
                        $qc_hold_meters+=$springtube_extrusion_qc_master_hold_row->total_qc_hold_meters;
                    }

                    $qc_scraped_meters=0;
                    $data_qc_scraped=array('details_id'=>$springtube_extrusion_production_row->details_id,'status'=>1,'next_process'=>11,'archive'=>0);
                    $springtube_extrusion_qc_master_result_1=$this->common_model->select_active_records_where('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],$data_qc_scraped);

                    foreach ($springtube_extrusion_qc_master_result_1 as $springtube_extrusion_qc_master_row_1) {
                        $qc_scraped_meters+=$springtube_extrusion_qc_master_row_1->release_meters;
                    }

                    echo'<tr>
                        <td style="border-bottom:1px solid #D9d9d9;">'.$i++.'</td>
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"></td>
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$springtube_extrusion_production_row->production_date.'</td>
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$springtube_extrusion_production_row->shift.'</td>
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$springtube_extrusion_production_row->order_no.'</td>
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$springtube_extrusion_production_row->article_no.'</td>
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$springtube_extrusion_production_row->sleeve_dia.'</td>
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$this->common_model->get_article_name($springtube_extrusion_production_row->second_layer_mb,$this->session->userdata['logged_in']['company_id']).'</td>
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$springtube_extrusion_production_row->jobcard_no.'</td>
                        
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$total_ok_meters.'</td>
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$qc_hold_meters.'</td>
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$qc_scraped_meters.'</td>
                        <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$springtube_extrusion_production_row->total_meters_produced.'</td>
                    </tr>';

                    $sum_ok_production+=$total_ok_meters;
                    $sum_qc_hold+=$qc_hold_meters;
                    $sum_qc_scrap+=$qc_scraped_meters;
                    $sum_total_produced+=$springtube_extrusion_production_row->total_meters_produced;

                    echo '<tr style="font-weight:bold;"><td colspan="9" style="text-align:right;">TOTAL</td>
                            <td style="text-align:left; border-left:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$sum_ok_production.'</td>
                            <td>'.$sum_qc_hold.'</td>
                            <td>'.$sum_qc_scrap.'</td>
                            <td>'.$sum_total_produced.'</td>
                    </tr>';
                    
                }

            }else{
                echo'<tr><td colspan="11">No Records Found</td></tr>';
            }      



           echo'</table></br>'; 
            
        }//FORACH JOBCARD WISE


        
    }


    ?>  
        

    <?php endforeach;?>

    </div>
</body>
</html>
