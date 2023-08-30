
<?php foreach ($ar_invoice_master as $ar_invoice_master_row):?>

    
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        COST SHEET
      </div>
    </div>

        <?php echo $ar_invoice_master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/>

        <?php echo $this->common_model->view_date($ar_invoice_master_row->invoice_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($ar_invoice_master_row->invoice_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading">
                <td width="10%"><b>INVOICE NO</td>
                <td width="5%"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b><?php echo $ar_invoice_master_row->ar_invoice_no;?></b></td>
                <td width="10%">INVOICE DATE</td>
                <td width="5%"></td>
                <td width="35%"><?php echo $this->common_model->view_date($ar_invoice_master_row->invoice_date,$this->session->userdata['logged_in']['company_id']);?></td>
                
            </tr>
        </table>
        <br/>
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
                <td style="border-right:1px solid #D9d9d9;"><b><?php echo $ar_invoice_master_row->customer_name;?></b></td>
                <td>SHIP TO</td>
                <td></td>
                <td><?php 
                if(!empty($ar_invoice_master_row->consin_adr_company_id)){
                    explode("|",$ar_invoice_master_row->consin_adr_company_id)[0];
                    $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$ar_invoice_master_row->consin_adr_company_id)[0]);
                    foreach($data['ship_to'] as $ship_to_row){
                        echo $ship_to_row->name1;
                        //echo explode("|",$order_master_row->consin_adr_company_id)[0];
                        $data['property']=$this->property_model->select_one_active_record_noncompany_withlanguage('property_master','property_id',explode("|",$ar_invoice_master_row->consin_adr_company_id)[1],$this->session->userdata['logged_in']['language_id']);
                        foreach($data['property'] as $property_row){
                            echo "//".$property_row->lang_property_name;
                        }
                    }
                }else{
                    echo "SAME AS BILLING";
                }


                ?></td>
            </tr>

            <tr class="item">
                <td>BILL TO ADDRESS</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $ar_invoice_master_row->strno." ".$ar_invoice_master_row->name2." ".$ar_invoice_master_row->street." ".$ar_invoice_master_row->name3;?></td>
                <td>SHIP TO ADDRESS</td>
                <td></td>
                <td><?php 
                if(!empty($ar_invoice_master_row->consin_adr_company_id)){
                    explode("|",$ar_invoice_master_row->consin_adr_company_id)[0];
                    $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$ar_invoice_master_row->consin_adr_company_id)[0]);
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
                <td style="border-right:1px solid #D9d9d9;"><?php echo $ar_invoice_master_row->isdn_local;?></td>
                <td>GSTIN</td>
                <td></td>
                <td><?php
                         if(!empty($ar_invoice_master_row->consin_adr_company_id)){
                        explode("|",$ar_invoice_master_row->consin_adr_company_id)[0];
                        $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$ar_invoice_master_row->consin_adr_company_id)[0]);
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
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($ar_invoice_master_row->lang_city);?></td>
                
                <td>STATE</td>
                <td></td>
                <td><?php
                         if(!empty($ar_invoice_master_row->consin_adr_company_id)){
                        explode("|",$ar_invoice_master_row->consin_adr_company_id)[0];
                        $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$ar_invoice_master_row->consin_adr_company_id)[0]);
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
                <td style="border-right:1px solid #D9d9d9;"><?php echo $ar_invoice_master_row->state_code;?></td>
                
                <td>STATE CODE</td>
                <td></td>
                <td><?php
                         if(!empty($ar_invoice_master_row->consin_adr_company_id)){
                        explode("|",$ar_invoice_master_row->consin_adr_company_id)[0];
                        $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$ar_invoice_master_row->consin_adr_company_id)[0]);
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
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($ar_invoice_master_row->for_export==1 ? 'EXPORT' : 'LOCAL');?></td>
                <td>SAMPLE</td>
                <td></td>
                <td><?php echo ($ar_invoice_master_row->for_sampling==1 ? 'SAMPLE' : 'NO');?></td>
            </tr>

            <?php
                if($ar_invoice_master_row->for_export==1){
                    echo "<tr class='item last'>
                            <td>CURRENCY</td>
                            <td></td>
                            <td>".$ar_invoice_master_row->currency_id."</td>
                            <td>EXCHANGE RATE</td>
                            <td></td>
                            <td>".$this->common_model->read_number($ar_invoice_master_row->exchange_rate,$this->session->userdata['logged_in']['company_id'])."</td>
                    </tr>";
                }
             ?>
        </table>
             </br>
        
        <br/>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="5%">#</td>
                <td width="1%"></td>
                <td width="10%">PRODUCT</td>
                <td width="10%">SPECS</td>
                <td width="10%">ARTWORK</td>
                <td width="10%">QUANTITY</td>
                <td width="10%">UNIT RATE</td>
                <td width="10%">NET AMOUNT  <?php echo (!empty($ar_invoice_master_row->currency_id) ? "(".$ar_invoice_master_row->currency_id.")" : '');?></td>
                <?php 
                global $tax_arr;
                $i=0;
                foreach ($tax_master as $tax_value) {
                    $tax_arr[$i]=0;
                    echo "<td colspan='2' width='10%'>".strtoupper($tax_value->lang_tax_code_desc)."</td>";
                    $i++;
                }
                ?>
                <td width="10%">TOTAL AMOUNT <?php echo (!empty($ar_invoice_master_row->currency_id) ? "(".$ar_invoice_master_row->currency_id.")" : '');?></td>
            </tr>
            <tr class="heading">
                <td colspan="7"></td>
                <td></td>
                <?php foreach ($tax_master as $tax_value) {
                    echo "<td>RATE</td><td>AMT</td>";
                }?>
                <td></td>
            </tr>
            <?php 
            $quantity=0;
            $total_quantity=0;
            $amount=0;
            $total_amount=0;
            $total_selling_price=0;
            foreach ($ar_invoice_details as $ar_invoice_details_row) {

                $quantity=$ar_invoice_details_row->arid_qty;

                if($ar_invoice_master_row->for_export==1){
                    $amount=$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$ar_invoice_details_row->calc_sell_price;
                }else{
                    $amount=$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($ar_invoice_details_row->selling_price,$this->session->userdata['logged_in']['company_id']);
                }
                



                echo "<tr class='item'>
                        <td width='5%'>$ar_invoice_details_row->ar_pos_no</td>
                        <td></td>
                        <td width='10%'>[$ar_invoice_details_row->article_no] <br/>$ar_invoice_details_row->article_no</td>
                        <td width='10%'><b><a href='".base_url()."/index.php/specification/view/".$ar_invoice_details_row->spec_id."/".$ar_invoice_details_row->spec_version_no." ' target='blank'>".($ar_invoice_details_row->spec_id!=""? $ar_invoice_details_row->spec_id."_R".$ar_invoice_details_row->spec_version_no:"")."</a></b></td>
                        <td width='10%'><b><a href='".base_url()."/index.php/artwork/view/".$ar_invoice_details_row->ad_id."/".$ar_invoice_details_row->version_no." ' target='blank'>".($ar_invoice_details_row->ad_id!=""? $ar_invoice_details_row->ad_id."_R".$ar_invoice_details_row->version_no:"")."</b></a></td>

                        <td width='10%'>".$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])."</td>";

                        if($ar_invoice_master_row->for_export==1){
                            echo "<td width='10%'>".$ar_invoice_details_row->calc_sell_price."</td>";
                        }else{
                            echo "<td width='10%'>".$this->common_model->read_number($ar_invoice_details_row->selling_price,$this->session->userdata['logged_in']['company_id'])."</td>";
                        }

                        echo "<td width='10%'>".$amount."</td>";
                        $m=0;
                        $k=0;
                        foreach ($tax_master as $tax_value) {
                            $output = array ();
                            $data['tax_pos']=$this->common_model->select_one_active_record_nonlanguage_without_archive('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$ar_invoice_details_row->tax_pos_no);
                            foreach ($data['tax_pos'] as $tax_pos_row) {
                                $output[]=$tax_pos_row->tax_code;
                            }
                            $flag=0;
                            $out = array ();
                    echo "<td>".$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id'])."%</td><td>";

                        foreach($output as $value){
                            if($value!=''){
                                if($tax_value->tax_code==$value){
                                    $t_amount=explode ('|',$ar_invoice_details_row->tax_grid_amount);
                                    $flag++;
                                }
                            }
                            if($flag>0){
                                $out[]=$flag;
                            }
                        }

                        if(!empty($out)){
                            $t_amount=explode ('|',$ar_invoice_details_row->tax_grid_amount);
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
                    echo "<td>".$this->common_model->read_number($ar_invoice_details_row->total_selling_price,$this->session->userdata['logged_in']['company_id'])."</td>";

                echo "</tr>";

                $total_quantity+=$quantity;
                $total_amount+=$amount;
                $total_selling_price+=$ar_invoice_details_row->total_selling_price;

                }

                $total_gross=$total_amount+$this->common_model->read_number($total_selling_price,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item last' style='background-color:#FAF6A3;'>
                        <td colspan='4'><b>TOTAL</b></td>
                        <td></td>
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
    </table>
    </div>
</body>
</html>
