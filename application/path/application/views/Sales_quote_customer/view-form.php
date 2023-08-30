<?php 

setlocale(LC_MONETARY, 'en_IN');
foreach ($sales_quote_customer_master as $sales_quote_customer_master_row):?>

    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        CUSTOMER DATA
      </div>
    </div>

    <!-- <?php echo $sales_quote_customer_master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>
 -->
        <br/>

        <?php echo $this->common_model->view_date($sales_quote_customer_master_row->creation_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($sales_quote_customer_master_row->creation_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">


           
            <tr class="heading">
                <td width="15%"><b>CUSTOMER</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($sales_quote_customer_master_row->category_name);?>
                <?php 
                $company_type_result=$this->common_model->select_one_active_record('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id'],'id',$sales_quote_customer_master_row->company_type);
                if($company_type_result==TRUE){
                    foreach($company_type_result as $company_type_row){
                        echo "(".strtoupper($company_type_row->company_type).")";
                    }
                }
                ?>

                <?php 
            foreach ($formrights as $formrights_row) {
                echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$sales_quote_customer_master_row->address_category_details_id.'').'" title="Modify" target="_blank"><i class="edit icon"></i></a> ' : '');

            }
            ?>
                </td>
                <td width="15%"><b>OWENERSHIP</b></td>
                <td width="1%"></td>
                <td width="34%"><?php echo $sales_quote_customer_master_row->ownership;?></td>
            </tr>

            <tr class="item">
                <td width="15%"><b>ADDRESS</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" colspan="4" style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($sales_quote_customer_master_row->address.', '.$sales_quote_customer_master_row->city);?>,
                    <b>PIN </b><?php echo $sales_quote_customer_master_row->pincode;?>,
                    <b>STATE </b><?php echo $this->common_model->get_state_name($sales_quote_customer_master_row->state,$this->session->userdata['logged_in']['company_id']);?>,
                    <b>COUNTRY </b><?php echo strtoupper($sales_quote_customer_master_row->lang_country_name); ?>
                </td>
            </tr>
             <tr class="item">
                <td width="15%"><b>PRIMARY CONTACT</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $this->sales_quote_customer_model->get_client_name($data=array('address_category_contact_id'=>$sales_quote_customer_master_row->primary_contact_id)); ?></td>

                <td width="15%"><b>SECONDARY CONTACT</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $this->sales_quote_customer_model->get_client_name($data=array('address_category_contact_id'=>$sales_quote_customer_master_row->secondary_contact_id)); ?></td>
            </tr>

        </table>

       
        <br/>

        

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="15%" colspan="6"><b>PRODUCT INFORMATION</td>
                
            </tr>
             <tr class="item"> 
                <td width="15%"><b>PRODUCT CATEGORY</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo str_replace(",","<br/><br/>",$sales_quote_customer_master_row->product_category);?></td>              
                <td width="15%"><b>PRODUCT TYPE</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%"><?php echo str_replace(",","<br/><br/>",$sales_quote_customer_master_row->product_type);?></td>
                                 
            </tr>
            <tr class="item">                
                <td width="15%"><b>PACKAGING</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo str_replace(",","<br/><br/>",$sales_quote_customer_master_row->packaging_type); ?></td>
                <td width="15%"><b>PRINTING TECHNOLOGY</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%"><?php echo str_replace(",","<br/><br/>",$sales_quote_customer_master_row->printing_technology);?></td>
            </tr>
            <tr class="item">
                 <td width="15%"><b>CURRENT SUPPLIER</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" colspan="4"><?php echo str_replace(",","<br/><br/>",$sales_quote_customer_master_row->current_supplier); ?></td>

                </tr>
            <tr class="item">
                <td width="15%"><b>PRODUCT PRICE M.R.P</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_master_row->product_price_range_min;?>-<?php echo$sales_quote_customer_master_row->product_price_range_max; ?></td>
            
                <td width="15%"><b>PRODUCT TUBE PRICE</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%"><?php echo $sales_quote_customer_master_row->product_price_range_intubes_min;?>-<?php echo $sales_quote_customer_master_row->product_price_range_intubes_max; ?></td>

            </tr>
            <tr class="item">
                <td width="15%"><b>CUSTOMER RATING</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%">
                    <?php if($sales_quote_customer_master_row->images!=''){
                        $img_arr=explode(",",$sales_quote_customer_master_row->images);
                                                            
                        foreach ($img_arr as $key => $image_name) {
                            
                            echo'<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/customer_quotation/'.$image_name.'').'" target="_blank"><i class="file pdf outline icon"></i>
                            </a>';
                        }                              
                    
                    }?>
                                        
                </td>
                
            </tr>
        </table>

         <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="15%" colspan="5" style="border-bottom:1px solid #D9d9d9;"><b>YEARLY BUYING POTENTIAL</td>
            </tr>

            <tr class="heading">
                <td width="15%"><b>TYPE</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;">MIN VOLUME </td>
                <td width="25%" style="border-right:1px solid #D9d9d9;">MAX VOLUME </td>
                <td width="25%" style="border-right:1px solid #D9d9d9;">3D VOLUME </td>
             </tr>
        <?php foreach ($sales_quote_customer_buying_potential as $key => $sales_quote_customer_buying_potential_row):?>
            
                <tr class="item">
                    <td width="15%"><b><?php  
                        $packaging_type_result=$this->common_model->select_one_active_record('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id'],'id',$sales_quote_customer_buying_potential_row->tubes_currently_buying);
                        if($packaging_type_result==TRUE){
                            foreach($packaging_type_result as $packaging_type_row){
                                echo $packaging_type_row->packaging_type;
                            }
                        }
                    ?></td>
                    <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                    <td width="25%" style="border-right:1px solid #D9d9d9;">
                        <?php echo money_format('%!.0n',$sales_quote_customer_buying_potential_row->min_volume);?>
                    <td style="border-right:1px solid #D9d9d9;"><?php echo money_format('%!.0n',$sales_quote_customer_buying_potential_row->max_volume);?>
                        
                    </td>
                    <td><?php echo money_format('%!.0n',$sales_quote_customer_buying_potential_row->three_d_volume);?></td>
                </tr>      

            <?php endforeach; ?>
        </table>


        <br/>
        <?php foreach ($customer_contact_details as $key => $sales_quote_customer_contact_details_row):?>
        <table cellpadding="10" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="55%" colspan="4" style="border-bottom:1px solid #D9d9d9;"><b><?php echo $sales_quote_customer_contact_details_row->seq_no."] ";?>CONTACT DETAILS</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"></td>
                <td width="34%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">STATUS <?php echo ($sales_quote_customer_contact_details_row->active=='1' ? '<i class="check circle icon"></i>' : 'INACTIVE');?>
                
                <span style="text-align:right;"> 
            <?php foreach ($formrights as $formrights_row) {
                echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_contact/'.$sales_quote_customer_contact_details_row->address_category_details_id.'/'.$sales_quote_customer_contact_details_row->address_category_contact_id).'" title="Modify" target="_blank"><i class="edit icon"></i></a>':'');
                }?>
                </span>

                
            </tr>
            </tr>
            <tr class="item">
                <td width="15%"><b>NAME</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_contact_details_row->contact_name ;?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>RANK</b>&nbsp;&nbsp;&nbsp;<?php echo $sales_quote_customer_contact_details_row->rank;?>
                </td>
                <td width="15%"><b>POSITION</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
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
                <td width="15%"><b>REPORT TO</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" colspan="4">
                </td>
            </tr>


            <tr class="item">
                <td><b>COMPANY CONTACT NO</b></td>
                <td style="border-right:1px solid #D9d9d9;" ></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_contact_details_row->company_contact_no;?></td>
                <td><b>PERSONAL</b></td>
                <td style="border-right:1px solid #D9d9d9;" ></td>
                <td><?php echo $sales_quote_customer_contact_details_row->personal_contact_no;?></td>
            </tr>
            <tr class="item">
                <td><b>COMPANY EMAIL</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($sales_quote_customer_contact_details_row->company_email);?></td>
                <td><b>PERSONAL EMAIL</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td ><?php echo strtoupper($sales_quote_customer_contact_details_row->personal_email);?></td>
            </tr>

            <tr class="item">
                <td><b>VIDEO LINK</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_contact_details_row->video_link;?></td>
                <td><b>LINKED IN PROFILE</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td ><?php echo "<a href ='".$sales_quote_customer_contact_details_row->linked_in_link."' target='_blank'>".$sales_quote_customer_contact_details_row->linked_in_link."</a>";?></td>
            </tr>
            
            <tr class="item">
                <td><b>BIRTH DATE</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->view_date($sales_quote_customer_contact_details_row->birth_date,$this->session->userdata['logged_in']['company_id']);?></td>
                <td><b>LOCATED AT</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo strtoupper($sales_quote_customer_contact_details_row->located_at);?></td>
            </tr>

            <tr class="item">
                <td><b>ANNIVERSARY DATE</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->view_date($sales_quote_customer_contact_details_row->anniversary_date,$this->session->userdata['logged_in']['company_id']);?>
                </td>
                <td><b>HOBBIES</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo strtoupper($sales_quote_customer_contact_details_row->hobbies);?></td>
            </tr>


            <tr class="item">
                <td width="15%"><b>PREVIOUS JOB</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_contact_details_row->previous_job;?></td>
                <td width="15%"><b>PREVIOUS POSITION</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%"><?php 
                    $previous_position_result=$this->common_model->select_one_active_record('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id'],'id',$sales_quote_customer_contact_details_row->position);
                if($previous_position_result==TRUE){
                    foreach($previous_position_result as $previous_position_row){
                        echo $previous_position_row->designation;
                    }
                }

                echo "(".$this->common_model->view_date($sales_quote_customer_contact_details_row->previous_from_date,$this->session->userdata['logged_in']['company_id'])."-".$this->common_model->view_date($sales_quote_customer_contact_details_row->previous_to_date,$this->session->userdata['logged_in']['company_id']).")";
                ?></td>
            </tr>
            <tr class="item last">
                <td width="15%"><b>HISTORY</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_customer_contact_details_row->history_if_any ;?></td>
                <td width="15%"><b>3D REPRESENTATIVE</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="34%"><?php echo strtoupper($this->common_model->get_user_name($sales_quote_customer_contact_details_row->repesentative_3d,$this->session->userdata['logged_in']['company_id']));                 
                ?></td>
            </tr>

        </table>
    <?php endforeach;?>
        <br/>
        
        <?php endforeach; ?>