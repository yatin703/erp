
<?php foreach ($artwork_springtube as $artwork_springtube_row):?>

<?php

    $result_dia=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','1');
    $result_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','2');
    $result_sleeve_color=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','3');
                    
    $result_cold_foil_one=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','4');
    $result_cold_foil_one_area=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','5');
    
    $result_cold_foil_two=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','6');
    $result_cold_foil_two_area=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','7');

    $result_pre_lacquer_one=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','8');
    
    $result_pre_lacquer_one_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','9');
    
    $result_pre_lacquer_two=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','10');

    $result_pre_lacquer_two_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','11');

    $result_post_lacquer_one=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','12');
    
    $result_post_lacquer_one_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','13');
    
    $result_post_lacquer_two=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','14');

    $result_post_lacquer_two_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','15');

    $result_non_varnish_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','16');

    $result_body_making_type=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','17');

    $result_print_type=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','18');
    
    ?>
        <?php echo $artwork_springtube_row->final_approval_flag==1 ? '<a class="ui green right ribbon label">Approved</a>' : '<a class="ui  red right ribbon label">Unapproved</a>';?>
         <br/>

        <?php echo $this->common_model->view_date($artwork_springtube_row->ad_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($artwork_springtube_row->ad_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading">
                <td width="20%"><b>ARTWORK NO</td>
                <td width="5%"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;"><b><?php echo $artwork_springtube_row->ad_id;?></b></td>
                <td width="15%">VERSION NO</td>
                <td width="5%"></td>
                <td width="30%"><?php echo $artwork_springtube_row->version_no; ?></td>
                
            </tr>
            
            <tr class="item last">
                <td>CUSTOMER</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $artwork_springtube_row->customer_name;?>//<?php echo $artwork_springtube_row->adr_company_id;?></td>
                
                <td>ARTICLE</td>
                <td></td>
                <td><?php echo $artwork_springtube_row->article_name; ?>//<?php echo $artwork_springtube_row->article_no;?></td>
            </tr>
            
            <tr class="heading">
                <td colspan="6">
                    OTHER DETAILS
                </td>
               
            </tr>
            <tr class="item last">
                <td ><b>ARTWORK FILE</b></td>
                <td ></td>
               
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($artwork_springtube_row->artwork_image_nm!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork_springtube/'.$artwork_springtube_row->artwork_image_nm.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');?>

                    
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
                <td><b>LAMINATE COLOR</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_sleeve_color as $sleeve_color_row){ echo strtoupper($sleeve_color_row->parameter_value); }?></td>
                <td><b>PRINT TYPE</b></td>
                <td></td>
                <td><?php foreach($result_print_type as $print_type_row){ echo $print_type_row->parameter_value; }?>
                    
                </td>


            </tr>
            
                       
             <tr class="item last">
                <td><b>NON LACQUER LENGTH</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_non_varnish_length as $non_varnish_length_row){ echo $non_varnish_length_row->parameter_value; }?> MM</td>
                
            </tr>

                <tr class="item last">
                <td><b>FOIL ONE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php   foreach($result_cold_foil_one as $cold_foil_one_row){
                                            //echo $cold_foil_one_row->parameter_value;
                                            echo $this->common_model->get_article_name($cold_foil_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
                            } 
                                        
                    ?>                    
                </td>
                <td><b>FOIL SQM/TUBE</b></td>
                <td></td>
                <td><?php   foreach($result_cold_foil_one_area as $cold_foil_one_area_row){
                                                echo ($cold_foil_one_area_row->parameter_value!=''? ' '.$cold_foil_one_area_row->parameter_value:"");
                                                
                            }?>
                        
                </td>
            </tr>

            <tr class="item last">
                <td><b>FOIL TWO</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php   foreach($result_cold_foil_two as $cold_foil_two_row){
                                            //echo $cold_foil_one_row->parameter_value;
                                echo $this->common_model->get_article_name($cold_foil_two_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
                            } 
                                        
                    ?> </td>
                <td><b>FOIL SQM/TUBE</b></td>
                <td></td>
                <td><?php   foreach($result_cold_foil_two_area as $cold_foil_two_area_row){
                                echo ($cold_foil_two_area_row->parameter_value!=''? ' '.$cold_foil_two_area_row->parameter_value:"");
                                                
                            }?>
                                
                </td>
            </tr>

            <tr class="item last">
                <td><b>PRE LACQUER ONE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php foreach($result_pre_lacquer_one as $result_pre_lacquer_one_row){ echo $this->common_model->get_article_name($result_pre_lacquer_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?>
                        
                </td>
                <td><b>PRE LACQUER ONE %</b></td>
                <td></td>
                <td><?php foreach($result_pre_lacquer_one_perc as $pre_lacquer_one_perc_row){ echo $pre_lacquer_one_perc_row->parameter_value; }?></td>
            </tr>

            <tr class="item last">
                <td><b>PRE LACQUER TWO</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    

                    <?php foreach($result_pre_lacquer_two as $pre_lacquer_two_perc_row){ echo $this->common_model->get_article_name($pre_lacquer_two_perc_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?></td>
                <td><b>PRE LACQUER TWO %</b></td>
                <td></td>
                <td><?php foreach($result_pre_lacquer_two_perc as $pre_lacquer_two_perc_row){ echo $pre_lacquer_two_perc_row->parameter_value; }?></td>
            </tr>


            <tr class="item last">
                <td><b>POST LACQUER ONE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php foreach($result_post_lacquer_one as $result_post_lacquer_one_row){ echo $this->common_model->get_article_name($result_post_lacquer_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?>
                        
                </td>
                <td><b>POST LACQUER ONE %</b></td>
                <td></td>
                <td><?php foreach($result_post_lacquer_one_perc as $post_lacquer_one_perc_row){ echo $post_lacquer_one_perc_row->parameter_value; }?></td>
            </tr>

            <tr class="item last">
                <td><b>POST LACQUER TWO</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    

                    <?php foreach($result_post_lacquer_two as $post_lacquer_two_perc_row){ echo $this->common_model->get_article_name($post_lacquer_two_perc_row->parameter_value,$this->session->userdata['logged_in']['company_id']); }?></td>
                <td><b>POST LACQUER TWO %</b></td>
                <td></td>
                <td><?php foreach($result_post_lacquer_two_perc as $post_lacquer_two_perc_row){ echo $post_lacquer_two_perc_row->parameter_value; }?></td>
            </tr>
                    
             <tr  class="heading">
                <td><b>CREATED BY</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($artwork_springtube_row->username);?></td>
                
                <td><b>APPROVED BY</b></td>
                <td></td>
                <td><?php echo strtoupper($artwork_springtube_row->approval_username);?></td>
            </tr>

      
        </table>
        <?php endforeach;?>
    </br>
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
