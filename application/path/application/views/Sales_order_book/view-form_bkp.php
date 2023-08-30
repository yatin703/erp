
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
                        <td width='20%' style='border:1px solid #D9d9d9;'>[$order_details_row->article_no] <br/>$order_details_row->description</td>
                        <td width='10%' style='border:1px solid #D9d9d9;'><b><a href='".base_url()."/index.php/specification/view/".$order_details_row->spec_id."/".$order_details_row->spec_version_no." ' target='blank'>".($order_details_row->spec_id!=""? $order_details_row->spec_id."_R".$order_details_row->spec_version_no:"")."</a></b>
                        <br/>
                        <b><a href='".base_url()."/index.php/artwork/view/".$order_details_row->ad_id."/".$order_details_row->version_no." ' target='blank'>".($order_details_row->ad_id!=""? $order_details_row->ad_id."_R".$order_details_row->version_no:"")."</b></a></td>

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
    <?php endforeach;?>
    <br/>
    <br/>
    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td colspan='6'>APPROVAL FOLLOWUPS</td>
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
            <td width="35%"><?php echo ($specification_row->ad_id!='' ? "<a href='".base_url('index.php/artwork/view/'.$specification_row->ad_id.'/'.$specification_row->version_no)."' target='_blank'>".$specification_row->ad_id."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>ARTWORK VERSION&nbsp;&nbsp;&nbsp;&nbsp;</b>".$specification_row->version_no : "NOT ATTACHED");?></td>
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
    <br/>
    <br/>

    <!-- APPROVAL/FOLLOWUP TABLE END........................-->   

    
<?php foreach ($artwork as $artwork_row):?>

    <?php
        $result_dia=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','1');

        $result_length=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','2');

        $result_sleeve_color=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','7');

        $result_print_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','17');

        foreach($result_print_type as $print_type_row){ $prin_type=$print_type_row->parameter_value; }

       $result_printing_upto_neck=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','8');

        $result_hot_foil=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','11');

        $result_lacquer_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','12');

        $result_sealing=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','5');
    ?>
        
        


        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading">
                <td colspan="2" style="border:1px solid #D9d9d9;">
                    ARTWORK DETAILS
                </td>
                
                
            </tr>
            <tr class="heading">
                <td>
                    ARTWORK NO
                </td>
                
                <td>
                    VERSION NO
                </td>
            </tr>

            
            <tr class="details">
                <td >
                    <?php echo $artwork_row->ad_id;?>
                </td>
                
                <td >
                    <?php echo $artwork_row->version_no;?>
                </td>
            </tr>
            
            <tr class="heading">
                <td colspan="2" style="border:1px solid #D9d9d9;">
                    OTHER DETAILS
                </td>
                
            </tr>


            <tr class="item">
                <td>ARTWORK FILE</td>
                <td><?php echo ($artwork_row->artwork_image_nm!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$artwork_row->artwork_image_nm.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');?></td>
            </tr>
            <tr class="item">
                <td>CUSTOMER</td>
                <td><?php echo $artwork_row->customer_name;?>//<?php echo $artwork_row->adr_company_id;?></td>
            </tr>

            <tr class="item">
                <td>ARTICLE</td>
                <td><?php echo $artwork_row->article_name; ?>//<?php echo $artwork_row->article_no;?></td>
            </tr>

            <tr class="item">
                <td>DIA</td>
                <td><?php foreach($result_dia as $dia_row){ echo $dia_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td>LENGTH</td>
                <td><?php foreach($result_length as $length_row){ echo $length_row->parameter_value; }?></td>
            </tr>
            
            <tr class="item">
                <td>SLEEVE COLOR</td>
                <td><?php foreach($result_sleeve_color as $sleeve_color_row){ echo $sleeve_color_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td>PRINT TYPE</td>
                <td><?php foreach($result_print_type as $print_type_row){ echo $print_type_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td>PRINT UPTO NECK</td>
                <td><?php foreach($result_printing_upto_neck as $printing_upto_neck_row){ echo $printing_upto_neck_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td>HOT FOIL</td>
                <td><?php foreach($result_hot_foil as $hot_foil_row){
                    $hot_foil=substr($hot_foil_row->parameter_value,strpos($hot_foil_row->parameter_value, "||") + 2);
                    echo strtoupper(str_replace("^"," + ",$hot_foil));
                    }?></td>
            </tr>

            <tr class="item">
                <td>SEALING AND NON LACQUERING AREA</td>
                <td><?php foreach($result_sealing as $sealing_row){ echo $sealing_row->parameter_value; }?></td>
            </tr>

            <tr class="item last">
                <td>LACQUER TYPE</td>
                <td><?php foreach($result_lacquer_type as $lacquer_row){
                    $lacquer=substr($lacquer_row->parameter_value,strpos($lacquer_row->parameter_value, "||") + 2);
                    echo strtoupper(str_replace("^"," + ",$lacquer));
                    } ?></td>
            </tr>

            <tr class="item">
                <td>CREATED BY</td>
                <td><?php echo strtoupper($artwork_row->username);?></td>
            </tr>

            <tr class="item">
                <td>APPROVED BY</td>
                <td><?php echo strtoupper($artwork_row->approval_username);?></td>
            </tr>

        </table>
        <?php endforeach;?>






    </div>
</body>
</html>
