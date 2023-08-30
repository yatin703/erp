
<?php foreach ($order_master as $order_master_row):?>
    
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        ORDER CONFIRMATION
      </div>
    </div>

    <br/>
    <br/>

    <div class="ui green labels" style="text-align: center;">
      <div class="ui label">
        DELIVERY BETWEEN <?php 
        $seven_date=strtotime($order_master_row->oc_date);
        $seven= strtotime("+3 day",$seven_date);
        echo $this->common_model->view_date($order_master_row->oc_date,$this->session->userdata['logged_in']['company_id']);?>
      <?php echo " TO ".$this->common_model->view_date(date('Y-m-d',$seven),$this->session->userdata['logged_in']['company_id']);?>
      </div>
    </div>

        
        <?php 
            setlocale(LC_MONETARY, 'en_IN');
        //    echo $this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui green ribbon label"><i class="truck icon">Dispatch between</i>'.$this->common_model->view_date($order_master_row->oc_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading">
                <td width="10%"><b>ORDER NO</td>
                <td width="5%"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b><?php echo $order_master_row->order_no;?></b></td>
                <td width="10%">PO NO</td>
                <td width="5%"></td>
                <td width="35%"><?php echo $order_master_row->cust_order_no; ?>&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRODUCT CODE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($order_master_row->cust_product_no!='' ? $order_master_row->cust_product_no : '-');?></td>
                
            </tr>
        
            <tr class="item last">
                <td>ORDER DATE</td>
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
                <td style="border-right:1px solid #D9d9d9;"><?php echo $order_master_row->strno." ".$order_master_row->name2." ".$order_master_row->street." ".$order_master_row->name3." PIN ".$order_master_row->city_code;?></td>
                <td>ADDRESS</td>
                <td></td>
                <td><?php 
                if(!empty($order_master_row->consin_adr_company_id)){
                    explode("|",$order_master_row->consin_adr_company_id)[0];
                    $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                    foreach($data['ship_to'] as $ship_to_row){
                    echo $ship_to_row->strno." ".$ship_to_row->name2." ".$ship_to_row->street." ".$ship_to_row->name3." PIN ".$ship_to_row->city_code;
                    
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

            <?php 
           /* $data['order_comment']=$this->common_model->select_one_active_record_nonlanguage_without_archive('order_master_lang',$this->session->userdata['logged_in']['company_id'],'order_master_lang.order_no',$order_master_row->order_no);
            if($data['order_comment']==FALSE){

            }else{
                foreach($data['order_comment'] as $order_comment_row){
                    echo '<tr class="item last">
                    <td><b>COMMENT</b></td>
                    <td></td>
                    <td colspan="4">'.strtoupper($order_comment_row->lang_addi_info).'</td>
                    </tr>';
                }
            }*/
            ?>

        </table>


        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="2%" style='border-bottom:1px solid #D9d9d9;'>SR NO</td>
                <td width="1%" style='border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;'></td>
                <td width="30%" style='border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align: center'>PRODUCT</td>
                <td width="10%" style='border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align: center'>SPEC</td>
                <td width="10%" style='border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align: center'>QUANTITY</td>
                <td width="10%" style='border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align: center'>UNIT RATE</td>
                <td width="10%" style='border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align: center'>NET AMOUNT  <?php echo (!empty($order_master_row->currency_id) ? "(".$order_master_row->currency_id.")" : '');?></td>
                <?php 
                global $tax_arr;
                $i=0;
                foreach ($tax_master as $tax_value) {
                    $tax_arr[$i]=0;
                    echo "<td colspan='2' width='15%' style='border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align: center'>".strtoupper($tax_value->lang_tax_code_desc)."</td>";
                    $i++;
                }
                ?>
                <td width="10%" style='border-bottom:1px solid #D9d9d9;text-align: center'>TOTAL AMOUNT<?php echo (!empty($order_master_row->currency_id) ? "(".$order_master_row->currency_id.")" : '');?></td>
            </tr>
            <tr class="heading">
                <td colspan="6"></td>
                <td></td>
                <?php foreach ($tax_master as $tax_value) {
                    echo "<td style='border-right:1px solid #D9d9d9;border-left:1px solid #D9d9d9;text-align: center'>RATE</td>
                    <td style='border-right:1px solid #D9d9d9;text-align: center'>AMT</td>";
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
                        <td style='border-top:1px solid #D9d9d9;border-right:1px solid #D9d9d9;'></td>
                        <td width='20%' style='border-top:1px solid #D9d9d9;border-right:1px solid #D9d9d9;'>[$order_details_row->article_no] <br/>".$this->common_model->get_article_name($order_details_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td width='10%' style='border-top:1px solid #D9d9d9;border-right:1px solid #D9d9d9;'>";
                        if(!empty($order_details_row->spec_id)){
                            if(substr($order_details_row->spec_id,0,1)=="S"){
                                echo "<b>".$order_details_row->spec_id."_".$order_details_row->spec_version_no."</b>";
                            }else{
                                $bom=array('bom_no'=>$order_details_row->spec_id,
                                    'bom_version_no'=>$order_details_row->spec_version_no);
                                $data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
                                    foreach($data['bom'] as $bom_row){                                          
                                        echo "<b>".$order_details_row->spec_id."_".$order_details_row->spec_version_no."</b>";
                                    }                                   
                                }
                            }

                        echo "<br/>
                        <b>".($order_details_row->ad_id!=""? $order_details_row->ad_id."_".$order_details_row->version_no:"")."</b>
                        <br/><br/>";
                       /* if($order_details_row->delivery_date!="0000-00-00"){

                            echo "<i>DELIVERY DATE BY CUSTOMER</i><br/>".$this->common_model->view_date($order_details_row->delivery_date,$this->session->userdata['logged_in']['company_id']);
                        }*/
                       echo "</td>

                        <td width='10%' style='border-top:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align:center;'>".money_format('%!.0n',$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']))."</td>";

                        if($order_master_row->for_export==1){
                            echo "<td width='10%' style='border-top:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align:center'>".$order_details_row->calc_sell_price."</td>";
                        }else{
                            echo "<td width='10%' style='border-top:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align:center'>".$this->common_model->read_number($order_details_row->selling_price,$this->session->userdata['logged_in']['company_id'])."</td>";
                        }

                        echo "<td width='10%' style='border-top:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align:center'>".money_format('%.0n',$amount)."</td>";
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
                    echo "<td style='border-top:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align:center'>".$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id'])."%</td><td style='border-top:1px solid #D9d9d9;border-right:1px solid #D9d9d9;text-align:center'>";

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
                                echo money_format('%.0n',$t_amount[$k]);
                            }
                            $tax_arr[$m]+=$t_amount[$k];
                            $k++;
                        }
                        echo '</td>';
                        $m++;

                        }
                    echo "<td style='border-top:1px solid #D9d9d9;text-align:center'>".money_format('%.0n',$this->common_model->read_number($order_details_row->total_selling_price,$this->session->userdata['logged_in']['company_id']))."</td>";

                echo "</tr>";

                $total_quantity+=$quantity;
                $total_amount+=$amount;
                $total_selling_price+=$order_details_row->total_selling_price;

                }

                $total_gross=$total_amount+$this->common_model->read_number($total_selling_price,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item last' style='background-color:#FAF6A3;'>
                        <td colspan='3' style='border:1px solid #D9d9d9;'><b>TOTAL</b></td>
                        <td style='border:1px solid #D9d9d9;'></td>
                        <td style='border:1px solid #D9d9d9;text-align:center'><b>".money_format('%!.0n',$this->common_model->read_number($total_quantity,$this->session->userdata['logged_in']['company_id']))."</td>
                        <td style='border:1px solid #D9d9d9;'></td>
                        <td style='border:1px solid #D9d9d9;text-align:center;'><b>".money_format('%.0n',$total_amount)."/-</td>";
                        $l=0;
                        foreach ($tax_master as $tax_value) {
                            echo "<td style='border:1px solid #D9d9d9;'></td>
                                <td style='border:1px solid #D9d9d9;text-align:center'><b>".money_format('%.0n',$tax_arr[$l])."/-</td>";
                                $l++;
                        }

                echo "<td style='border:1px solid #D9d9d9;text-align:center'><b>".money_format('%.0n',$this->common_model->read_number($total_selling_price,$this->session->userdata['logged_in']['company_id']))."/-</td>
                    </tr>

                    ";
                ?>
    <?php endforeach;?>
    </table>
    <br/>
    
        <div class="html2pdf_page-break">
            
        </div>
    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td><b>TERMS & CONDITION</td>
        </tr>
        
        <tr>
            <td><b>General Terms</b></td></tr>
        <tr>
            <td>Notwithstanding anything in your Purchase Order (hereinafter PO) as referenced above, this Order Confirmation (hereinafter OC) is subject only to a) a pre-existing and valid contract between our companies, b) agreed written modifications to the terms below or c) the terms below. Where pre-existing contracts and modifications do not cover the items below, or conflict with these, then the terms of this OC take precedence and shall prevail.</td>
        </tr>

        <tr>
            <td>Customer acknowledges that he was provided with all necessary information and advice to ensure that both Products and General Terms and Conditions ( GTCS ) were meeting its requirements and that he issued a purchase order in full acknowledgment of the GTCS. The simple issuance of an Order acceptance of 3D Technopack quotation by a Customer shall be construed as an acceptance. The Seller reserves the right to modify and expand these general terms and conditions of contract.</td></tr>


        <tr>
            <td>Terms of your PO not in conflict with the OC shall stand as accepted.</td>
        </tr>

        <tr>
            <td>No response to this order confirmation within working 5 days will be considered as acceptance of Order Confirmation</td></tr>


        <tr>
            <td><b>Other Condition of Performance</b></td></tr>

        <tr>
            <td>The Customer shall verify such studies and recommendations under its own control and responsibility, and shall ensure, prior to the design and manufacture of the Product or performance of the service, that the Product is compatible with its contemplated use, if need be by appropriate testing.</td>
        </tr>

        <tr>
            <td>To check the suitability of the tube with respect to the product, 3D technopack recomends customers to carry out compatibility / stability tests .  3D technopack does not take any responsibility for the effect of the bulk on the tube in case of missing compatibility / stability tests.</td>
        </tr>

        <tr>
            <td>The customer accepts full responsibility for ensuring that the artworks approved by him does not infringe the rights of a third party, especially copyright and proprietary rights. The customer shall indemnify us fully against any damage which may be sustained by us in connection with any infringement of the rights of third parties resulting from the fulfilment of his order.</td>
        </tr>

        <tr>
            <td>All terms herein, and in your Purchase order, shall be invalid if the manufacturing or delivery period is affected by Force Majeure or Strikes, Riots and Civil Commotion, including transportation strikes; any terms in your PO referencing ‘time is of the essence’ or the equivalent are specifically stricken by this OC.</td>
        </tr>


        <tr>
            <td>The referenced PO is non-cancellable and non-deferrable, unless confirmed by us in writing, except within the earlier of 7 days from this OC/ the commencement of manufacture by 3DT its suppliers or affiliates (hereinafter 3DT) of parts or components required to fulfil your PO/ the order by 3DT of parts /components required to fulfil your PO.</td>
        </tr>



        <tr>
            <td>3D takes no responsibility for label lift off unless the label stock that is used meets our standard for adhesion and rolls are properly wound with even tension. Furthermore, 3D takes no responsibility for printing defects on labels and any delay caused by this or other label issues that are properly the responsibility of the label vendor, whether such vendor was selected by you or by us.           
            </td>
        </tr>

        <tr>
            <td>Labels must be cut to the shape specified in 3D Standard KLD and must end 15mm below the cut length of the tube unless the glue has the tack value to hold against the bend of the tube at the sealing area.
            </td>
        </tr>

        <tr>
            <td>Any warranty for defects shall remain valid only from the date of manufacture and not from the date of shipment</td>
        </tr>

        <tr>
            <td>All warranties are expressly tied to our AQL agreement.</td>
        </tr>


        <tr>
            <td><b>Delivery</b></td></tr>

        <tr>
            <td>The Products shall be transported at the Customer’s risks, even in the case where shipping is undertaken at 3D Technopack expenses.Delays in delivery, specifically those as a result of acts of God or as a result of unforeseeable circumstances not attributable to us, like disruption in the work of the factory, strikes, closing of the factory, a lack of transport, administrative decrees, do not count as delays in fulfillment of contract by us.</td>
        </tr>

        <tr>
            <td>3D Technopack Pvt Ltd (hereinafter 3DT) shall inform you within one week of the incidence if there is a long-term breakdown of a machine, that could result in a delay of your material, and shall seek to reschedule delivery to the satisfaction of both parties.</td>
        </tr>
        <tr>
            <td>The tubes referenced in this OC will be despatched from our factory within the dates referenced herein unless otherwise agreed in writing (including by email) between us.</td>
        </tr>

        <tr>
            <td>If the actual date of delivery is delayed by more than two weeks (from the 1st date) after the date of delivery on this OC you may cancel or defer without penalty, which shall not invite monetary or other penalties, and 3D shall bear the costs of materials manufactured specifically for such PO (Stocking Orders will continue to be payable in full for up to the agreed maximum quantity).
            </td>
        </tr>
        <tr>
            <td>In the event of an agreed cancellation without a delay of more than two weeks (from the 1st date), or deferral 3DT shall promptly bill you for materials made, procured, or ordered by it, and you shall make payments for such invoices on your normal terms for the supply of goods. Caps made by 3D shall be charged at the prices prevailing for third party caps of the same or similar specification.
            </td>
        </tr>
        <tr>
            <td>Any changes (Eg- Quantity, artwork, product, Specification etc.) in your Purchase Order made by you will result in a new OC with a new date.</td>
        </tr>
        <tr>
            <td>If customer does not have stocking agreements with 3DT then 3DT shall also provide you with warehousing facility for tubes completed including capping (but not for tube components Viz. Shoulders, caps, sleeves etc) for maximum of 3 months at cost of Rs.125/Pallet towards rental with additional fixed handling charges of Rs. 125/pallet</td>
        </tr>
        <tr>
            <td>All component purchases for your PO’s are expressly tied to our Stocking Agreement if applicable.</td>
        </tr>
        <tr>
            <td>3D shall take no responsibility for delays in outsourced material and its impact on the committed date of delivery on your order.</td></tr>

        <tr>
            <td><b>Payments</b></td></tr>

        <tr><td>Payment should be release as per the PO agreed term. Delay in Payment will likely to attract interest rate of 2% per month.Without prior intimation.</td></tr>
        <tr>
            <td>You are requested to release payment as per agreed PO terms. Delays in payment beyond agreed payment terms are likely to attract interest at 2% per month without prior intimation.</td>
        </tr>

        <tr>
            <td><b>Intellectual and Industrial property</b></td></tr>

        <tr><td>Artwork provided by the customer will be processed by us to suit particular printing operations. 3D Technopack is liable to return customer provided artworks and not our processed artworks.</td></tr>
        


        <tr><td>&nbsp;</td></tr>
        <tr>
            <td style="text-align: center;"><b>If any query contact to sales@3d-neopac.com</b></td>
        </tr>

        
        <tr><td>&nbsp;</td></tr>
        <tr class="heading">
            <td style="text-align: center;"><b>This is an electronically generated document, no signature required.</b></td>
        </tr>
        
    </table>
   
    </div>
    <div class="printbtn">
        <br/>
        <br/>
        <button class="ui mini red button" id="download"><i class="file pdf outline icon"></i>Download</button>
</div>
<script type="text/javascript">
    window.onload = function () {
    document.getElementById("download")
        .addEventListener("click", () => {
            const invoice = this.document.getElementById("invoice");
            console.log(invoice);
            console.log(window);
            var file=window.location.pathname.split('/').pop();
            var opt = {
                margin: 0.75,
                filename: file+'.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(invoice).set(opt).save();
        })
}
</script>
</body>
</html>
