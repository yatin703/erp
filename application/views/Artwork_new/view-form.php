
<?php foreach ($artwork as $artwork_row):?>

    <?php

    $result_lacquer_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','12');
    
        $result_hot_foil=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','11');

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
        <?php echo $artwork_row->final_approval_flag==1 ? '<a class="ui green right ribbon label">Approved</a>' : '<a class="ui  red right ribbon label">Unapproved</a>';?>
         <br/>

        <?php echo $this->common_model->view_date($artwork_row->ad_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($artwork_row->ad_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
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
            
            <tr class="item last">
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
            <tr class="item last">
                <td ><b>ARTWORK FILE</b></td>
                <td ></td>
               
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($artwork_row->artwork_image_nm!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$artwork_row->artwork_image_nm.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');?>

                    
                </td>

                <td><b>CUSTOMER APPR FILE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($artwork_row->customer_artwork_pdf!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$artwork_row->customer_artwork_pdf.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');?>

                    
                </td>


                
            </tr>
            <tr class="item last">
                <td width="15%"><b>DIA</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_dia as $dia_row){ echo $dia_row->parameter_value; }?></td>
                <td ><b>LENGTH</b></td>
                <td></td>
                <td><?php foreach($result_length as $length_row){ echo $length_row->parameter_value; }?></td>
            </tr>

            
            <tr class="item last">
                <td><b>SLEEVE COLOR</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_sleeve_color as $sleeve_color_row){ echo strtoupper($sleeve_color_row->parameter_value); }?></td>
                <td><b>PRINT TYPE</b></td>
                <td></td>
                <td><?php echo $prin_type; 
                //foreach($result_dia as $dia_row){ echo $dia_row->parameter_value; 
                ?></td>


            </tr>
            
            <tr class="item last">
                <td><b>PRINT UP TO NECK</b></td>
                <td></td>
                <td><?php echo $printing_upto_neck;?></td>
                 
                

            </tr>
            
             <tr class="item last">
                <td><b>SEALING AND NON LACQUERING AREA</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_sealing as $sealing_row){ echo $sealing_row->parameter_value; }?></td>
                
            </tr>

            <!-- <tr class="item last">
                <td><b>EYE MARK DIMENSION</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_eye_dimension as $result_eye_dimension_row){ echo $result_eye_dimension_row->parameter_value; }?></td>
                <td><b>EYE MARK POSITION FROM OPEN END</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_eye_position as $result_eye_position_row){ echo $result_eye_position_row->parameter_value; }?></td>
                
            </tr> -->

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


            <tr class="item last">
                <td><b>FOIL ONE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php foreach($result_hot_foil as $hot_foil_row){
                    $hot_foil=substr($hot_foil_row->parameter_value,strpos($hot_foil_row->parameter_value, "||") + 2);
                    echo strtoupper(str_replace("^"," + ",$hot_foil));
                    }?>
                    
                    <?php foreach($result_hot_foil_one as $result_hot_foil_one_row){ echo $this->common_model->get_article_name($result_hot_foil_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?></td>
                <td><b>FOIL SQM/TUBE</b></td>
                <td></td>
                <td><?php foreach($result_hot_foil_one_per_tube as $result_hot_foil_one_per_tube_row){ echo $result_hot_foil_one_per_tube_row->parameter_value; }?></td>
            </tr>

            <tr class="item last">
                <td><b>FOIL TWO</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_hot_foil_two as $result_hot_foil_two_row){ echo $this->common_model->get_article_name($result_hot_foil_two_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?></td>
                <td><b>FOIL SQM/TUBE</b></td>
                <td></td>
                <td><?php foreach($result_hot_foil_two_per_tube as $result_hot_foil_two_per_tube_row){ echo $result_hot_foil_two_per_tube_row->parameter_value; }?></td>
            </tr>



            <tr class="item last">
                <td><b>LACQUER ONE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php foreach($result_lacquer_type_one as $result_lacquer_type_one_row){ echo $this->common_model->get_article_name($result_lacquer_type_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?></td>
                <td><b>LACQUER ONE %</b></td>
                <td></td>
                <td><?php foreach($result_lacquer_type_one_mixing_pc as $result_lacquer_type_one_mixing_pc_row){ echo $result_lacquer_type_one_mixing_pc_row->parameter_value; }?></td>
            </tr>

            <tr class="item last">
                <td><b>LACQUER TWO</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">

                    

                    <?php foreach($result_lacquer_type_two as $result_lacquer_type_two_row){ echo $this->common_model->get_article_name($result_lacquer_type_two_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?></td>
                <td><b>LACQUER TWO %</b></td>
                <td></td>
                <td><?php foreach($result_lacquer_type_two_mixing_pc as $result_lacquer_type_two_mixing_pc_row){ echo $result_lacquer_type_two_mixing_pc_row->parameter_value; }?></td>
            </tr>

            <tr class="item last">
                <td><b>LACQUER COMMENT</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php foreach($result_lacquer_type as $lacquer_row){
                    $lacquer=substr($lacquer_row->parameter_value,strpos($lacquer_row->parameter_value, "||") + 2);
                    echo strtoupper(str_replace("^"," + ",$lacquer));
                    } ?>
                    
                    </td>
                <td><b>MACHINE</b></td>
                <td></td>
                <td><?php 
                    $dataa=array('artwork_no'=>$artwork_row->ad_id,'version_no'=>$artwork_row->version_no,'archive'=>'0');
                    $machine_result=$this->common_model->select_one_active_record_nonlanguage_without_archives('artwork_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                    if($machine_result==TRUE){
                        foreach($machine_result as $machine_row){
                            $machine=$this->common_model->select_one_active_record('coex_machine_master',$this->session->userdata['logged_in']['company_id'],'machine_id',$machine_row->machine_id);
                            if($machine==TRUE){
                                foreach($machine as $machine_name) {
                                    echo $machine_name->machine_name."<br/>";
                                }
                            }

                        }
                    }
                ?></td>
            </tr>

            
             <tr  class="heading">
                <td><b>CREATED BY</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($artwork_row->username);?></td>
                
                <td><b>APPROVED BY</b></td>
                <td></td>
                <td><?php echo strtoupper($artwork_row->approval_username);?></td>
            </tr>

      

        </table>
        <?php endforeach;?>
        </br>

        <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
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
                                    ".($followup_row->status==999 && $followup_row->approved_flag==1? 'APPROVED' : '')."
                                    ".($followup_row->status==999 && $followup_row->approved_flag==2? 'REJECTED' : '')."
                                    ".($followup_row->status==1 ? 'PENDING' : '')."</td>
                            </tr>";
                     }
                }
                ?>
        </table>   
    </div>
</body>
        
  
</html>
