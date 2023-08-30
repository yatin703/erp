<?php foreach ($sales_quote_customer_master as $sales_quote_customer_master_row):?>

    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SALES CUSTOMER
      </div>
    </div>

    <?php echo $sales_quote_customer_master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/>

        <?php echo $this->common_model->view_date($sales_quote_customer_master_row->creation_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($sales_quote_customer_master_row->creation_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="15%"><b>CUSTOMER DETAILS</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"> </td>
                <td width="15%"> </td>
                <td width="1%"></td>
                <td width="34%"></td>
            </tr>
            <tr class="item last">
                <td width="15%"><b>CUSTOMER NAME</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($sales_quote_customer_master_row->customer_name);?></td>
                <td width="15%">COMPANY TYPE</td>
                <td width="1%"></td>
                <td width="34%"><?php 
                $company_type_result=$this->common_model->select_one_active_record('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id'],'id',$sales_quote_customer_master_row->company_type);
                if($company_type_result==TRUE){
                    foreach($company_type_result as $company_type_row){
                        echo strtoupper($company_type_row->company_type);
                    }
                }
                ?></td>
            </tr>

            <tr class="item last">
                <td width="15%"><b>ADDRESS</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($sales_quote_customer_master_row->address.', '.$sales_quote_customer_master_row->city);?></td>
                <td width="15%"><b>PIN</td>
                <td width="1%"></td>
                <td width="34%"><?php echo $sales_quote_customer_master_row->pincode; ?></td>
            </tr>
            <tr class="item last">
                <td width="15%"><b>STATE</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($sales_quote_customer_master_row->lang_city.' ('.$sales_quote_customer_master_row->state_code.')');?></td>
                <td width="15%"><b>COUNTRY</td>
                <td width="1%"></td>
                <td width="34%"><?php echo strtoupper($sales_quote_customer_master_row->lang_country_name); ?></td>
            </tr>

        </table>
        <br/>

        <?php foreach ($sales_quote_customer_contact_details as $key => $sales_quote_customer_contact_details_row):?>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="15%"><b>CONTACT DETAILS</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><b></td>
                <td width="1%"></td>
                <td width="34%"></td>
            </tr>
            <tr class="item last">
                <td width="15%"><b>NAME</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_contact_details_row->contact_name ;?></td>
                <td width="15%"><b>POSITION</td>
                <td width="1%"></td>
                <td width="34%"><?php 
                    $position_result=$this->common_model->select_one_active_record('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id'],'id',$sales_quote_customer_contact_details_row->position);
                if($position_result==TRUE){
                    foreach($position_result as $position_row){
                        echo $position_row->designation;
                    }
                }
                ?></td>
            </tr>
            <tr class="item">
                <td><b>COMPANY CONTACT NO</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_contact_details_row->company_contact_no;?></td>
                <td><b>PERSONAL CONTACT NO</b></td>
                <td></td>
                <td><?php echo $sales_quote_customer_contact_details_row->personal_contact_no;?></td>
            </tr>
            <tr class="item">
                <td><b>COMPANY EMAIL</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_contact_details_row->company_email;?></td>
                <td><b>PERSONAL EMAIL</b></td>
                <td></td>
                <td><?php echo $sales_quote_customer_contact_details_row->personal_email;?></td>
            </tr>
            <tr class="item">
                <td><b>BIRTH DATE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_contact_details_row->birth_date;?></td>
                <td><b>LOCATED AT</b></td>
                <td></td>
                <td><?php echo $sales_quote_customer_contact_details_row->located_at;?></td>
            </tr>
            <tr class="item last">
                <td width="15%"><b>PREVIOUS JOB</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_contact_details_row->previous_job ;?></td>
                <td width="15%"><b>PREFIOUS POSITION</td>
                <td width="1%"></td>
                <td width="34%"><?php 
                    $previous_position_result=$this->common_model->select_one_active_record('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id'],'id',$sales_quote_customer_contact_details_row->position);
                if($previous_position_result==TRUE){
                    foreach($previous_position_result as $previous_position_row){
                        echo $previous_position_row->designation;
                    }
                }
                ?></td>
            </tr>
            <tr class="item last">
                <td width="15%"><b>HISTORY</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_contact_details_row->history_if_any ;?></td>
                <td width="15%"><b>3D REPRESENTATIVE</td>
                <td width="1%"></td>
                <td width="34%"><?php echo $this->common_model->get_user_name($sales_quote_customer_contact_details_row->repesentative_3d,$this->session->userdata['logged_in']['company_id']);                 
                ?></td>
            </tr>

        </table>
    <?php endforeach;?>
        <br/> 

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="15%"><b>PRODUCT CATAGORY</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"> </td>
                <td width="15%"> </td>
                <td width="1%"></td>
                <td width="34%"></td>
            </tr>
            <tr class="item last">
                <td width="15%"><b>OWENERSHIP</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_master_row->ownership;?></td>
                <td width="15%"><b>PRODUCT TYPE</b></td>
                <td width="1%"></td>
                <td width="34%"><?php echo $sales_quote_customer_master_row->product_type;?></td>
            </tr>

            <tr class="item last">
                <td width="15%"><b>PRODUCT CATEGORY</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_master_row->product_category;?></td>
                <td width="15%"><b>PACKAGING</td>
                <td width="1%"></td>
                <td width="34%"><?php echo$sales_quote_customer_master_row->packaging_type; ?></td>
            </tr>
            <tr class="item last">
                <td width="15%"><b>PRINTING TECHNOLOGY</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_master_row->printing_technology;?></td>
                <td width="15%"><b>CURRENT SUPPLIER</td>
                <td width="1%"></td>
                <td width="34%"><?php echo$sales_quote_customer_master_row->current_supplier; ?></td>
            </tr>
            <tr class="item last">
                <td width="15%"><b>PRODUCT PRICE MIN</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_master_row->product_price_range_min;?></td>
                <td width="15%"><b>PRODUCT PRICE MAX</td>
                <td width="1%"></td>
                <td width="34%"><?php echo$sales_quote_customer_master_row->product_price_range_max; ?></td>
            </tr>
            <tr class="item last">
                <td width="15%"><b>PRICE IN TUBE MIN</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_master_row->product_price_range_intubes_min;?></td>
                <td width="15%"><b>PRICE IN TUBE MAX</td>
                <td width="1%"></td>
                <td width="34%"><?php echo$sales_quote_customer_master_row->product_price_range_intubes_max; ?></td>
            </tr>

            <tr class="item last">
                <td width="15%"><b>CUSTOMER RATING</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;">
                    <?php if($sales_quote_customer_master_row->images!=''){
                        $img_arr=explode(",",$sales_quote_customer_master_row->images);
                                                            
                        foreach ($img_arr as $key => $image_name) {
                            
                            echo'<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/customer_quotation/'.$image_name.'').'" target="_blank"><i class="file pdf outline icon"></i>
                            </a>';
                        }                              
                    
                    }?>
                                        
                </td>
                <td width="15%"></td>
                <td width="1%"></td>
                <td width="34%"></td>
            </tr>

        </table>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="15%"><b>BUYING POTENTIAL</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><b></td>
                <td width="1%"></td>
                <td width="34%"></td>
            </tr>
        <?php foreach ($sales_quote_customer_buying_potential as $key => $sales_quote_customer_buying_potential_row):?>
            
                <tr class="item last">
                    <td width="15%"><b><?php  
                        $packaging_type_result=$this->common_model->select_one_active_record('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id'],'id',$sales_quote_customer_buying_potential_row->tubes_curretly_buying);
                        if($packaging_type_result==TRUE){
                            foreach($packaging_type_result as $packaging_type_row){
                                echo $packaging_type_row->packaging_type;
                            }
                        }
                    ?></td>
                    <td width="1%"></td>
                    <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo 'MIN-'.$sales_quote_customer_buying_potential_row->min_volume.', MAX- '.$sales_quote_customer_buying_potential_row->max_volume; ?></td>
                    <td width="15%"><b>3D VOLUME</b></td>
                    <td width="1%"></td>
                    <td width="34%"><?php echo $sales_quote_customer_buying_potential_row->three_d_volume; ?></td>
                </tr>      

            <?php endforeach; ?>
        </table>
        <?php endforeach; ?>