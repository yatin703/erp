<?php foreach ($sales_quote_master as $sales_quote_master_row):?>

    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SALES QUOTE
      </div>
    </div>

    <?php echo $sales_quote_master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/>

        <?php echo $this->common_model->view_date($sales_quote_master_row->quotation_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($sales_quote_master_row->quotation_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="15%"><b>QUOTE NO</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><b><?php echo $sales_quote_master_row->quotation_no;?></b></td>
                <td width="15%">QUOTE DATE</td>
                <td width="1%"></td>
                <td width="34%"><?php echo $this->common_model->view_date($sales_quote_master_row->quotation_date,$this->session->userdata['logged_in']['company_id']); ?></td>
            </tr>

            <tr class="item last">
                <td>&nbsp;</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td></td>
                <td></td>
                <td><i>QUOTE VALID FOR 15 DAYS</i></td>
            </tr>

        </table>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="15%"><b>TO</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><b>FROM</td>
                <td width="1%"></td>
                <td width="34%"></td>
            </tr>

            <tr class="item">
                <td><b>CUSTOMER</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><b><?php $customer_result=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'adr_category_id',$sales_quote_master_row->customer_no);
                if($customer_result==TRUE){
                    foreach($customer_result as $customer_row){
                        echo $customer_row->category_name;
                    }
                }

                ?></b></td>
                <td></td>
                <td></td>
                <td>3D TECHNOPACK PVT LTD</td>
            </tr>

            <tr class="item">
                <td><b>PURCHASE MANAGER</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($sales_quote_master_row->pm_1);
                ?></td>
                <td><b>SALES MANAGER</b></td>
                <td></td>
                <td><?php echo $this->common_model->get_user_name($sales_quote_master_row->user_id,$this->session->userdata['logged_in']['company_id']);?></td>
            </tr>

            <tr class="item">
                <td><b>NEW PRODUCT</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($sales_quote_master_row->new_product);
                ?>
                </td>
                <td><b>EMAIL</b></td>
                <td></td>
                <td>
                    <?php $user_result=$this->common_model->select_one_active_record('user_master',$this->session->userdata['logged_in']['company_id'],'user_id',$sales_quote_master_row->user_id);
                        $contact_no="";
                        foreach($user_result as $user_row){
                            //echo $user_row->employee_id;

                            $employee_result=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$user_row->employee_id);
                            foreach($employee_result as $emp_row){
                                echo strtoupper($emp_row->mailbox);
                                $contact_no=$emp_row->telephone;
                            }

                        }
                    ?>

                </td>
            </tr>

            <tr class="item">
                <td><b>CREDIT TERMS</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><b>CONTACT NO</b></td>
                <td></td>
                <td><?php echo $contact_no;?></td>
            </tr>

            

        </table>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="100%" colspan="6"><b>WE ARE PLEASED TO QUOTE AS FOLLOWS</td>
            </tr>


            <tr class="heading">
                <td width="100%" colspan="6"><b>PRODUCT SPECIFICATION</td>
            </tr>

            <tr class="item">
                <td width="15%"><b>TUBE DIA X LENGTH</b></td>
                <td width="1%"></td>
                <td width="34%"style="border-right:1px solid #D9d9d9;"><?php 
                $sleeve_dia_result=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_id',$sales_quote_master_row->sleeve_dia);
                if($sleeve_dia_result==TRUE){
                    foreach($sleeve_dia_result as $sleeve_dia_row){
                        $sleeve_dia=$sleeve_dia_row->sleeve_diameter;
                    }
                }
                echo $sleeve_dia." X ".$sales_quote_master_row->sleeve_length." MM";?></td>
                <td width="15%"><b>TUBE LAYER</b></td>
                <td width="1%"></td>
                <td width="34%"><?php echo $sales_quote_master_row->layer." LAYER";?></td>
            </tr>

            <tr class="item">
                <td><b>TUBE MB</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($sales_quote_master_row->tube_mb);?></td>
                <td><b>SHOULDER FOIL</b></td>
                <td></td>
                <td><?php echo strtoupper($sales_quote_master_row->shoulder_foil);?></td>
            </tr>

            <tr class="item">
                <td><b>PRINT TYPE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->print_type;?></td>
                <td><b>SPECIAL INK</b></td>
                <td></td>
                <td><?php echo strtoupper($sales_quote_master_row->special_ink);?></td>
            </tr>

            <tr class="item">
                <td><b>TUBE FOIL</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->tube_foil;?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr class="item">
                <td><b>CAP TYPE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->cap_type;?></td>
                <td><b>CAP FINISH</b></td>
                <td></td>
                <td><?php echo strtoupper($sales_quote_master_row->cap_finish);?></td>
            </tr>

            <tr class="item">
                <td><b>CAP MB</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->cap_mb;?></td>
                <td><b>CAP FOIL</b></td>
                <td></td>
                <td><?php echo strtoupper($sales_quote_master_row->cap_foil);?></td>
            </tr>

            <tr class="item">
                <td><b>CAP SHRINK SLEEVE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->cap_shrink_sleeve;?></td>
                <td><b>CAP METALIZATION</b></td>
                <td></td>
                <td><?php echo strtoupper($sales_quote_master_row->cap_metalization);?></td>
            </tr>

           
        </table>

        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
             <tr class="heading">
                <td colspan="3"><b>QUOTE</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><b>REMARK</b></td>
            </tr>

            <tr class="heading">
                <td width="15%"><b>SR NO</td>
                <td width="1%"></td>
                <td width="25%">QUANTITY</td>
                <td width="9%" style="border-right:1px solid #D9d9d9;">PRICE</td>
                <td width="50%"></td>
            </tr>


            <tr class='item' >
                <td>1</td>
                <td></td>
                <td>< 10K</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->less_than_10k_quoted_price;?>/-</td>
                <td rowspan="6"><?php echo $sales_quote_master_row->remarks;?></td>
            </tr>

            <tr class='item' >
                <td>2</td>
                <td></td>
                <td>10K - 25K</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_10k_to_25k_quoted_price;?>/-</td>
            </tr>

            <tr class='item' >
                <td>3</td>
                <td></td>
                <td>25K - 50K</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_25k_to_50k_quoted_price;?>/-</td>
            </tr>

            <tr class='item' >
                <td>4</td>
                <td></td>
                <td>50K - 100K</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_50k_to_100k_quoted_price;?>/-</td>
            </tr>

            <tr class='item' >
                <td>5</td>
                <td></td>
                <td>100K - 250K</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_100k_to_250k_quoted_price;?>/-</td>
            </tr>

            <tr class='item' >
                <td>6</td>
                <td></td>
                <td>>250K</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->greater_than_250k_quoted_price;?>/-</td>
            </tr>


<?php endforeach; ?>