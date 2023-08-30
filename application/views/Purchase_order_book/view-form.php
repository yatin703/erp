
<?php foreach ($purchase_order_master as $order_master_row):?>

    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        PURCHASE ORDER
      </div>
    </div>

        <?php //echo $order_master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span><br/>' : '<span class="ui red right ribbon label">Unapproved</span><br/>';?>

        

        <?php //echo $this->common_model->view_date($order_master_row->po_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($order_master_row->po_date,$this->session->userdata['logged_in']['company_id']).'</span><br/>' : '';?>
        
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading">
                <td width="10%"><b>PO</td>
                <td width="5%"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b><?php echo $order_master_row->po_no;?><?php echo $order_master_row->final_approval_flag==1 ? '&nbsp;<i class="check circle icon"></i>' : '';?></b></td>
                <td width="10%">PO DATE</td>
                <td width="5%"></td>
                <td width="35%"><?php echo $this->common_model->view_date($order_master_row->po_date,$this->session->userdata['logged_in']['company_id']);?></td>
            </tr>

            <tr class="item">
                <td>SO NO</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $order_master_row->so_no; ?></td>
                <td>TYPE</td>
                <td></td>
                <td><?php echo ($order_master_row->for_import==1 ? 'IMPORT' : 'LOCAL');?></td>
            </tr>

            <?php
                if($order_master_row->for_import==1){
                    echo "<tr class='item'>
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
        <?php foreach ($company_details as $company_details_row):?>
        <?php foreach ($company as $company_row):
            $company_name=strtoupper($company_row->title);
            $company_address=strtoupper($company_row->street);
            $company_gsttin=strtoupper($company_row->gst_no);
            $company_zip=$company_row->zip_code;
            $state_details=$this->state_model->select_one_active_record('zip_code_master','zip_code',$company_zip,$this->session->userdata['logged_in']['language_id']);
            if($state_details==FALSE){
                $company_state="";
                $company_state_code="";
            }else{
                foreach($state_details as $state_details_row){
                    $company_state=$state_details_row->lang_city;
                    $company_state_code=$state_details_row->state_code;
                }
            }

         endforeach;?>
    <?php endforeach;?>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            <tr class="heading">
                <td width="10%"><b>VENDOR</td>
                <td width="5%"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%">SHIP TO</td>
                <td width="5%"></td>
                <td width="35%"></td>
            </tr>

            <tr class="item">
                <td>VENDOR</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><b><?php echo $order_master_row->supplier_name;?></b></td>
                <td>COMPANY NAME</td>
                <td></td>
                <td><?php echo $company_name;?></td>
            </tr>

            <tr class="item">
                <td>ADDRESS</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $order_master_row->strno." ".$order_master_row->name2." ".$order_master_row->street." ".$order_master_row->name3;?></td>
                <td>ADDRESS</td>
                <td></td>
                <td><?php echo $company_address;?></td>
            </tr>

            <tr class="item">
                <td>EMAIL</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($order_master_row->email);?></td>
                <td>EMAIL</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php;?></td>
            </tr>

            <tr class="item">
                <td>GSTIN</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $order_master_row->isdn_local;?></td>
                <td>GSTIN</td>
                <td></td>
                <td><?php echo $company_gsttin;?></td>
            </tr>

            <tr class="item">
                <td>STATE</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($order_master_row->lang_city);?>&nbsp;<?php echo $order_master_row->state_code;?></td>
                <td>STATE</td>
                <td></td>
                <td><?php echo strtoupper($company_state);?>&nbsp;<?php echo $company_state_code;?></td>
            </tr>

            
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

                $address_details=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$order_master_row->supplier_no);
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
                <td>CREATED BY</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($order_master_row->username); ?></td>

                <td>APPROVED BY</td>
                 <td></td>
                <td><?php echo (empty($order_master_row->approval_username) ? '-' : strtoupper($order_master_row->approval_username)); ?></td>
            </tr>

            <?php 
            $data['order_comment']=$this->common_model->select_one_active_record_nonlanguage_without_archive('purchase_order_master_lang',$this->session->userdata['logged_in']['company_id'],'purchase_order_master_lang.po_no',$order_master_row->po_no);
            if($data['order_comment']==FALSE){

            }else{
                foreach($data['order_comment'] as $order_comment_row){
                    echo '<tr class="item last">
                    <td><b>REMARK</b></td>
                    <td></td>
                    <td colspan="4">'.strtoupper($order_comment_row->lang_internal_remarks).'</td>
                    </tr>';
                }
            }
            ?>

        </table>
        <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="2%" style='border-bottom:1px solid #D9d9d9;'>#</td>
                <td width="1%" style='border-bottom:1px solid #D9d9d9;'></td>
                <td width="15%" style='border:1px solid #D9d9d9;'>GOODS DESCRIPTION</td>
                <td width="10%" style='border:1px solid #D9d9d9;'>CODE</td>
                
                <td width="7%" style='border:1px solid #D9d9d9;'>QUANTITY</td>
                <td width="5%" style='border:1px solid #D9d9d9;'>UNIT</td>
                <td width="5%" style='border:1px solid #D9d9d9;'>UNIT RATE</td>
                <td width="10%" style='border:1px solid #D9d9d9;'>NET AMOUNT <?php echo (!empty($order_master_row->currency_id) ? "(".$order_master_row->currency_id.")" : '');?></td>
                <?php 
                global $tax_arr;
                $i=0;
                foreach ($tax_master as $tax_value) {
                    $tax_arr[$i]=0;
                    echo "<td colspan='2' width='10%' style='border:1px solid #D9d9d9;'>$tax_value->lang_tax_code_desc</td>";
                    $i++;
                }
                ?>
                <td width="10%" style='border:1px solid #D9d9d9;'>TOTAL <?php echo (!empty($order_master_row->currency_id) ? "(".$order_master_row->currency_id.")" : '');?></td>
            </tr>
            <tr class="heading">
                <td colspan="7"></td>
                <td></td>
                <?php foreach ($tax_master as $tax_value) {
                    echo "<td style='border:1px solid #D9d9d9;'>RATE</td>
                        <td style='border:1px solid #D9d9d9;'>AMOUNT</td>";
                }?>
                <td></td>
            </tr>
            <?php 
            $quantity=0;
            $total_quantity=0;
            $amount=0;
            $total_amount=0;
            $gross_price=0;
            foreach ($purchase_order_details as $order_details_row) {

                $quantity=$order_details_row->po_qty;

                if($order_master_row->for_import==1){
                    $amount=$this->common_model->read_number($order_details_row->po_qty,$this->session->userdata['logged_in']['company_id'])*$order_details_row->calc_sell_price;
                }else{
                    $amount=$this->common_model->read_number($order_details_row->po_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($order_details_row->price_per_unit,$this->session->userdata['logged_in']['company_id']);
                }
                



                echo "<tr class='item'>
                        <td width='2%' style='border-top:1px solid #D9d9d9;'>$order_details_row->pur_pos_no</td>
                        <td style='border-top:1px solid #D9d9d9;'></td>
                        <td width='10%' style='border:1px solid #D9d9d9;'>"; 
                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$order_details_row->article_no);
                        $uom="";
                        foreach($data['article'] as $article_row){
                            echo $article_row->article_name;
                            $uom=$article_row->uom;
                            if(!empty($article_row->article_sub_description)){
                                echo "<br/><i style='font-size:8px;'>".$article_row->article_sub_description."</i>";
                            }
                        }
                        echo "</td>
                        <td width='10%' style='border:1px solid #D9d9d9;'>$order_details_row->article_no</td>
                        
                        
                        <td width='7%' style='border:1px solid #D9d9d9;'>".$this->common_model->read_number($order_details_row->po_qty,$this->session->userdata['logged_in']['company_id'])."</td>

                        <td width='5%' style='border:1px solid #D9d9d9;'>".$uom."</td>";

                        if($order_master_row->for_import==1){
                            echo "<td width='5%' style='border:1px solid #D9d9d9;'>".$order_details_row->calc_sell_price."</td>";
                        }else{
                            echo "<td width='5%' style='border:1px solid #D9d9d9;'>".$this->common_model->read_number($order_details_row->price_per_unit,$this->session->userdata['logged_in']['company_id'])."</td>";
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
                    echo "<td style='border:1px solid #D9d9d9;'>".$this->common_model->read_number($order_details_row->gross_price,$this->session->userdata['logged_in']['company_id'])."</td>";

                echo "</tr>";

                $total_quantity+=$quantity;
                $total_amount+=$amount;
                $gross_price+=$order_details_row->gross_price;

                }

                $total_gross=$total_amount+$this->common_model->read_number($gross_price,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'>
                        <td colspan='3' style='border:1px solid #D9d9d9;'><b>TOTAL </b></td>
                        <td style='border:1px solid #D9d9d9;'></td>
                        <td style='border:1px solid #D9d9d9;'><b>".$this->common_model->read_number($total_quantity,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td style='border:1px solid #D9d9d9;'></td>
                        <td style='border:1px solid #D9d9d9;'></td>
                        <td style='border:1px solid #D9d9d9;'><b>".$total_amount."/-</td>";
                        $l=0;
                        foreach ($tax_master as $tax_value) {
                            echo "<td style='border:1px solid #D9d9d9;'></td>
                                <td style='border:1px solid #D9d9d9;'><b>".$tax_arr[$l]."/-</td>";
                                $l++;
                        }

                echo "<td style='border:1px solid #D9d9d9;'><b>".$this->common_model->read_number($gross_price,$this->session->userdata['logged_in']['company_id'])."/-</td>
                    </tr>

                    <tr class='item'>
                        <td  colspan='7' style='text-align:left'><b>IN WORDS : <b> ".strtoupper($this->numbertowords->convert_number($this->common_model->read_number($gross_price,$this->session->userdata['logged_in']['company_id'])))."</td>
                    </tr>

                    </table>";
                ?>
    <?php endforeach;?>
    <table cellpadding="0" cellspacing="0" style='border:1px solid #D9d9d9;'>
        <tr class="heading">
            <td>TERMS & CONDITION</td>
        </tr>
        <?php
        if($form==FALSE){

        }else{
            foreach($form as $form_row){
                echo "<tr>
                        <td><i style='font-size:8px'>".$form_row->toc."<i></td>
                    </tr>";
            }
        }
        ?>
    </table>
    <!--
    <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td colspan='6'>APPROVAL FOLLOWUPS</td>
            </tr>
            <tr class="heading">
                <td>SR NO</td>
                <td></td>
                <td>DATE</td>
                <td>FROM</td>
                <td>TO</td>
                <td>STATUS</td>
            </tr>
            <?php 
                if($followup==FALSE){
                    echo "<tr>
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
                                    ".($followup_row->status==999 && $followup_row->approved_flag==1 ? 'APPROVED' : '')."
                                    ".($followup_row->status==999 && $followup_row->approved_flag==2 ? 'REJECTED' : '')."
                                    ".($followup_row->status==1 ? 'PENDING' : '')."</td>
                            </tr>";
                     }
                }
            ?>
    </table>-->
    </div>
</body>
</html>
