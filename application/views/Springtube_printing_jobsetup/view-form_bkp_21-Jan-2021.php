<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

    $(document).ready(function(){

        $(".invoice-box").css("max-width", "1300px");
        $(".invoice-box table tr td").css("text-align", "left");

    });
 </script> 
 <style type="text/css">
        table{
            border:1px solid #D9d9d9;
            border-collapse: collapse;
            /*text-align: left;*/
            /*cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;border-collapse: collapse;"*/
        }
        td,th{
             
            text-align: left;
            

        }
</style>        

<?php foreach ($springtube_printing_jobsetup_master as $row):?>
    <?php

        $customer='';
        $jobcard_qty=0;
        $order_no='';
        $article_no='';
        $ad_id='';
        $version_no='';
        $dia='';
        $length='';
        $print_type='';
        $laminate_color='';
        $body_making_type='';
        $total_order_quantity='';
        $printed_counter=0;

        $data['production_master']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$row->jobcard_no);

        foreach ($data['production_master'] as $production_master_row) {
                              
            $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
            $order_no=$production_master_row->sales_ord_no;
            $article_no=$production_master_row->article_no;

        }

        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
        foreach($order_master_result as $order_master_row){
          $customer=$order_master_row->customer_no;                      
        }

        $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
        foreach($order_details_result as $order_details_row){
          $total_order_quantity=$order_details_row->total_order_quantity;
          $ad_id=$order_details_row->ad_id;
          $version_no=$order_details_row->version_no;
          $bom_no=$order_details_row->spec_id;
          $bom_version_no=$order_details_row->spec_version_no;
        }
        //Artwork Deatils-------------------------
        $data=array('ad_id'=>$ad_id,
            'version_no'=>$version_no
              );
        $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

        foreach ($springtube_artwork_result as $springtube_artwork_row) {
          $body_making_type=$springtube_artwork_row->body_making_type;
          $print_type=$springtube_artwork_row->print_type;
          $dia=$springtube_artwork_row->sleeve_dia;
          $length=$springtube_artwork_row->sleeve_length;
          $laminate_color=$springtube_artwork_row->laminate_color;
        }                           

        $search_data=array('jobcard_no'=>$row->jobcard_no);
        $counter_result=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$search_data);
        foreach ($counter_result as $counter_row) {
          $printed_counter=$counter_row->total_counter;
        }
    ?>
    <br/>
    <br/>
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SPRINGTUBE PRINTING JOB SETUP
      </div>
    </div>

    <?php 
        echo($row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"> <b>Approved</b> </i></span>' : '<span class="ui red right ribbon label">Unapproved</span>');
    ?>

    <br/>
        <?php echo $this->common_model->view_date($row->jobsetup_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($row->jobsetup_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
    <br/>
    <br/>


    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading" style="border:1px solid #D9d9d9;">
            <td colspan='11' style="border:1px solid #D9d9d9;">ORDER DETAILS</td>
        </tr>            
        <tr class="heading" style="border-right:1px solid #D9d9d9;">
            <td width="10%" style="border-bottom:1px solid #D9d9d9;">CUSTOMER</td>
            <td width="1%" style="border-bottom:1px solid #D9d9d9;"></td>             
            <td width="5%" style="border:1px solid #D9d9d9;">ORDER NO</td>                
            <td width="5%" style="border:1px solid #D9d9d9;">ARTICLE NO</td>
            <td width="12%" style="border:1px solid #D9d9d9;">ARTICLE NAME</td>
            <td width="3%" style="border:1px solid #D9d9d9;">ARTWORK NO</td>
            <td width="3%" style="border:1px solid #D9d9d9;">ORDER QTY</td>
            <td width="5%" style="border:1px solid #D9d9d9;">JOBCARD NO</td>
            <td width="3%" style="border:1px solid #D9d9d9;">JOBCARD QTY</td>
            <td width="3%" style="border:1px solid #D9d9d9;">PRINTING QTY</td>
            <td width="3%" style="border:1px solid #D9d9d9;">CREATED BY</td>
        </tr>
        <tr >
            <td  ><?php echo $this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id']);?></td>
            <td ></td>
            <td style="border:1px solid #D9d9d9;"><?php echo '<a href="'.base_url('index.php/sales_order_book/view/'.$order_no).'" target="_blank">'.$order_no.'</a>';?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $article_no;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']);?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo '<a href="'.base_url('index.php/artwork_springtube/view/'.$ad_id.'/'.$version_no).'" target="_blank">'.$ad_id.'_R'.$version_no.'</a>';?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $this->common_model->read_number($total_order_quantity,$this->session->userdata['logged_in']['company_id']);?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo '<a href="'.base_url('index.php/sales_order_item_parameterwise/view_new/'.$row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no).'" target="_blank">'.$row->jobcard_no.'</a>';?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $jobcard_qty;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo round(($printed_counter*2),2);?></td>
            <td><?php echo strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']));?></td>
            
        </tr>

    </table>
    <br/>
    <!-- <table>
        <tr class="item">
                <td width="10%">CREATED BY</td>
                <td width="5%"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($row->user_id); ?></td>
                <td width="10%">APPROVED BY</td>
                <td width="5%"></td>
                <td width="35%"><?php echo (empty($row->approved_by) ? '-' : $row->approved_by); ?></td>
            </tr>
    </table> -->

    
    
    

    
    <table >
        <tr>
            <!-- INK 1 -->
            <td width="25%">
                <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                    <tr class="heading">
                        <td colspan="2"><b>ABG 1-FLEXO UNIT-1</b></td>
                        
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;width: 25%;">CARONA</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_carona_1;?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9; height:300px;">COLOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php

                            $ink_1=$row->abg1_ink_id_1;

                            if($ink_1!=''|| $ink_1!='0'){

                                $ink_1_qty_gram=$row->abg1_ink_usage_1;
                               
                                $ink_1_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_1);

                                foreach ($ink_1_result as $ink_1_row) {

                                    if($ink_1_row->ink_composition==1){

                                        echo $ink_1_row->ink_desc;
                                       
                                    }else{
                                         echo $ink_1_row->ink_desc;
                                         echo'<p>';

                                        echo'<table  style="border:1px solid #D9d9d9;">
                                            <tr class="heading">
                                            <td  style="border:1px solid #D9d9d9;">MIXED_INK_DETAILS</td>
                                            <td style="border:1px solid #D9d9d9;">INK%</td>
                                            <td style="border:1px solid #D9d9d9;">GRAMS</td>
                                            <td style="border:1px solid #D9d9d9;">KGS</td>
                                            </tr>';

                                        $ink_1_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_1);
                                        foreach ($ink_1_mixing_master_result as $ink_1_mixing_master_row) {                                   
                                        
                                           $data_mixing_1=array('mixing_id'=>$ink_1_mixing_master_row->mixing_id);

                                            $ink_1_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_1,$this->session->userdata['logged_in']['company_id']);


                                             $sum_perc=0;
                                             $sum_grams=0; 
                                             $sum_kgs=0;
                                            foreach ($ink_1_mixing_details_result as $ink_1_mixing_details_row) {

                                                echo'<tr>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_1_mixing_details_row->ink_desc.'</td>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_1_mixing_details_row->ink_perc.'%</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg1_ink_usage_1*$ink_1_mixing_details_row->ink_perc/100),2).' Grams</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg1_ink_usage_1*$ink_1_mixing_details_row->ink_perc/100),2).' Kgs</td>
                                                </tr>';

                                                $sum_perc+=$ink_1_mixing_details_row->ink_perc;
                                                $sum_grams+=round(($row->abg1_ink_usage_1*$ink_1_mixing_details_row->ink_perc/100),2);
                                                
                                              
                                            }

                                            echo'<tr style="font-weight:bold;"><td style="border:1px solid #D9d9d9;"><b>TOTAL</b></td><td style="border:1px solid #D9d9d9;">'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';

                                                   

                                        }

                                        echo'</table>';
                                    }
                                }
                            }//ink1

                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">INK_USAGE</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_ink_usage_1.($row->abg1_ink_usage_1!=''?' Grams {'.round($row->abg1_ink_usage_1/1000,2).' Kgs}':'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">ANILOX</td>
                        <td style="border:1px solid #D9d9d9;"><?php 

                        $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_1);
                        foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            echo $springtube_anilox_master_row->anilox_lpi;
                            
                        }
                        //echo $row->abg1_anilox_1;
                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">METHOD</td>
                        <td><?php echo ($row->abg1_applying_method_1!=''?($row->abg1_applying_method_1==1?'Plate Through':'Roller Through'):'');?></td style="border:1px solid #D9d9d9;">
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">TEETH</td>
                        <td style="border:1px solid #D9d9d9;"><?php 
                        $cylinder_master_result_1=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_1);
                        foreach ($cylinder_master_result_1 as $cylinder_master_row_1) {
                            echo $cylinder_master_row_1->teeth;
                        }
                        ?>                            
                        </td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">SR/FR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo ($row->abg1_rotary_1!=''?($row->abg1_rotary_1==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">UV POWER</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_power_1.($row->abg1_uv_power_1!=''?' %':'');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV SPEED</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_speed_1.($row->abg1_uv_speed_1!=''?' %':'');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV HOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_hours_1.($row->abg1_uv_hours_1!=''?' Hrs':'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">COMMENT</td>
                        <td style="border:1px solid #D9d9d9; line-height:50px"><?php echo $row->abg1_unit_1_comment;?></td>
                    </tr>
                </table>
           </td>

           <!-- INK 2 -->
           <td width="25%">
                <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                    <tr class="heading">
                        <td colspan="2"><b>ABG 1-FLEXO UNIT-2</b></td>
                        
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;width: 25%;"></td>
                        <td style="border:1px solid #D9d9d9;">&nbsp;</td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9; height:300px;">COLOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php

                            $ink_2=$row->abg1_ink_id_2;

                            if($ink_2!=''|| $ink_2!='0'){

                                $ink_2_qty_gram=$row->abg1_ink_usage_2;
                               
                                $ink_2_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_2);

                                foreach ($ink_2_result as $ink_2_row) {

                                    if($ink_2_row->ink_composition==1){

                                        echo $ink_2_row->ink_desc;
                                       
                                    }else{
                                         echo $ink_2_row->ink_desc;
                                         echo'<p>';

                                        echo'<table style="border:1px solid #D9d9d9;">
                                            <tr class="heading">
                                            <td  style="border:1px solid #D9d9d9;">MIXED_INK_DETAILS</td>
                                            <td style="border:1px solid #D9d9d9;">INK%</td>
                                            <td style="border:1px solid #D9d9d9;">GRAMS</td>
                                            <td style="border:1px solid #D9d9d9;">KGS</td>
                                            </tr>';

                                        $ink_2_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_2);
                                        foreach ($ink_2_mixing_master_result as $ink_2_mixing_master_row) {                                      
                                        
                                           $data_mixing_2=array('mixing_id'=>$ink_2_mixing_master_row->mixing_id);

                                            $ink_2_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_2,$this->session->userdata['logged_in']['company_id']);

                                             $sum_perc=0;
                                             $sum_grams=0; 
                                             $sum_kgs=0;  
                                            foreach ($ink_2_mixing_details_result as $ink_2_mixing_details_row) {

                                                echo'<tr>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_2_mixing_details_row->ink_desc.'</td>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_2_mixing_details_row->ink_perc.'%</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg1_ink_usage_2*$ink_2_mixing_details_row->ink_perc/100),2).'</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg1_ink_usage_2*$ink_2_mixing_details_row->ink_perc/100)/1000,2).'</td>
                                                </tr>';

                                                $sum_perc+=$ink_2_mixing_details_row->ink_perc;
                                                $sum_grams+=round(($row->abg1_ink_usage_2*$ink_2_mixing_details_row->ink_perc/100),2);
                                                
                                              
                                            }
                                            echo'<tr style="font-weight:bold;"><td style="border:1px solid #D9d9d9;">TOTAL</td><td style="border:1px solid #D9d9d9;">'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';
                                                   

                                        }

                                        echo'</table>';
                                    }
                                }
                            }//ink2

                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">INK_USAGE</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_ink_usage_2.($row->abg1_ink_usage_2!=''?' Grams {'.($row->abg1_ink_usage_2/1000).' Kgs}':'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">ANILOX</td>
                        <td style="border:1px solid #D9d9d9;"><?php 
                        $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_2);
                        foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            echo $springtube_anilox_master_row->anilox_lpi;
                            
                        }

                        //echo $row->abg1_anilox_2;
                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">METHOD</td>
                        <td><?php echo ($row->abg1_applying_method_2!=''?($row->abg1_applying_method_2==1?'Plate Through':'Roller Through'):'');?></td style="border:1px solid #D9d9d9;">
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">TEETH</td>
                        <td style="border:1px solid #D9d9d9;"><?php 
                        $cylinder_master_result_2=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_2);
                        foreach ($cylinder_master_result_2 as $cylinder_master_row_2) {
                            echo $cylinder_master_row_2->teeth;
                        }
                        ?>                            
                        </td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">SR/FR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo ($row->abg1_rotary_2!=''?($row->abg1_rotary_2==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">UV POWER</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_power_2.($row->abg1_uv_power_2!=''?' %':'');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV SPEED</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_speed_2.($row->abg1_uv_speed_2!=''?' %':'');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV HOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_hours_2.($row->abg1_uv_hours_2!=''?' Hrs':'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">COMMENT</td>
                        <td style="border:1px solid #D9d9d9;line-height:50px"><?php echo $row->abg1_unit_2_comment;?></td>
                    </tr>
                </table>
           </td>

           <!-- INK 3 -->
           <td width="25%">
                <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                    <tr class="heading">
                        <td colspan="2"><b>ABG 1-FLEXO UNIT-3</b></td>
                        
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;width: 25%;"></td>
                        <td style="border:1px solid #D9d9d9;">&nbsp;</td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9; height:300px;">COLOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php

                            $ink_3=$row->abg1_ink_id_3;

                            if($ink_3!=''|| $ink_3!='0'){

                                $ink_3_qty_gram=$row->abg1_ink_usage_3;
                               
                                $ink_3_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_3);

                                foreach ($ink_3_result as $ink_3_row) {

                                    if($ink_3_row->ink_composition==1){

                                        echo $ink_3_row->ink_desc;
                                       
                                    }else{
                                         echo $ink_3_row->ink_desc;
                                         echo'<p>';

                                        echo'<table style="border:1px solid #D9d9d9;">
                                            <tr class="heading">
                                            <td style="border:1px solid #D9d9d9;">MIXED_INK_DETAILS</td>
                                            <td style="border:1px solid #D9d9d9;">INK%</td>
                                            <td style="border:1px solid #D9d9d9;">GRAMS</td>
                                            <td style="border:1px solid #D9d9d9;">KGS</td>
                                            </tr>';

                                        $ink_3_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_3);
                                        
                                        foreach ($ink_3_mixing_master_result as $ink_3_mixing_master_row) {                                      
                                        
                                           $data_mixing_3=array('mixing_id'=>$ink_3_mixing_master_row->mixing_id);

                                            $ink_3_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_3,$this->session->userdata['logged_in']['company_id']);

                                            $sum_perc=0;
                                            $sum_grams=0;

                                            foreach ($ink_3_mixing_details_result as $ink_3_mixing_details_row) {

                                                echo'<tr>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_3_mixing_details_row->ink_desc.'</td>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_3_mixing_details_row->ink_perc.'%</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg1_ink_usage_3*$ink_3_mixing_details_row->ink_perc/100),2).'</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg1_ink_usage_3*$ink_3_mixing_details_row->ink_perc/100)/1000,2).'</td>
                                                </tr>';

                                                $sum_perc+=$ink_3_mixing_details_row->ink_perc;
                                                $sum_grams+=round(($row->abg1_ink_usage_3*$ink_3_mixing_details_row->ink_perc/100),2);
                                              
                                            }

                                            echo'<tr style="font-weight:bold;"><td style="border:1px solid #D9d9d9;">TOTAL</td><td style="border:1px solid #D9d9d9;">'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';
                                                   

                                        }

                                        echo'</table>';
                                    }
                                }
                            }//ink1

                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">INK_USAGE</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_ink_usage_3.($row->abg1_ink_usage_3!=''?' Grams {'.($row->abg1_ink_usage_3/1000).' Kgs}':'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">ANILOX</td>
                        <td style="border:1px solid #D9d9d9;"><?php 

                        $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_3);
                        foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            echo $springtube_anilox_master_row->anilox_lpi;
                            
                        }

                        //echo $row->abg1_anilox_3;
                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">METHOD</td>
                        <td><?php echo ($row->abg1_applying_method_3!=''?($row->abg1_applying_method_3==1?'Plate Through':'Roller Through'):'');?></td style="border:1px solid #D9d9d9;">
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">TEETH</td>
                        <td style="border:1px solid #D9d9d9;"><?php 
                        $cylinder_master_result_3=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_3);
                        foreach ($cylinder_master_result_3 as $cylinder_master_row_3) {
                            echo $cylinder_master_row_3->teeth;
                        }
                        ?>                            
                        </td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">SR/FR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo ($row->abg1_rotary_3!=''?($row->abg1_rotary_3==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">UV POWER</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_power_3.($row->abg1_uv_power_3!=''?' %':'');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV SPEED</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_speed_3.($row->abg1_uv_speed_3!=''?' %':'');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV HOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_hours_3.($row->abg1_uv_hours_3!=''?' Hrs':'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">COMMENT</td>
                        <td style="border:1px solid #D9d9d9;line-height:50px"><?php echo $row->abg1_unit_3_comment;?></td>
                    </tr>
                </table>
           </td>
             
            <!--INK 4  -->
            <td width="25%">
                <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                    <tr class="heading">
                        <td colspan="2"><b>ABG 1-FLEXO UNIT-4</b></td>
                        
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;width: 25%"></td>
                        <td style="border:1px solid #D9d9d9;">&nbsp;</td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9; height:300px;">COLOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php

                            $ink_4=$row->abg1_ink_id_4;

                            if($ink_4!=''|| $ink_4!='0'){

                                $ink_4_qty_gram=$row->abg1_ink_usage_4;
                               
                                $ink_4_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_4);

                                foreach ($ink_4_result as $ink_4_row) {

                                    if($ink_4_row->ink_composition==1){

                                        echo $ink_4_row->ink_desc;
                                       
                                    }else{
                                         echo $ink_4_row->ink_desc;
                                         echo'<p>';
                                        echo'<table style="border:1px solid #D9d9d9;">
                                            <tr class="heading">
                                            <td style="border:1px solid #D9d9d9;">MIXED_INK_DETAILS</td>
                                            <td style="border:1px solid #D9d9d9;">INK%</td>
                                            <td style="border:1px solid #D9d9d9;">GRAMS</td>
                                            <td style="border:1px solid #D9d9d9;">KGS</td>
                                            </tr>';

                                        $ink_4_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_4);
                                        foreach ($ink_4_mixing_master_result as $ink_4_mixing_master_row) {                                      
                                        
                                           $data_mixing_4=array('mixing_id'=>$ink_4_mixing_master_row->mixing_id);

                                            $ink_4_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_4,$this->session->userdata['logged_in']['company_id']);

                                            $sum_perc=0;
                                            $sum_grams=0;

                                            foreach ($ink_4_mixing_details_result as $ink_4_mixing_details_row) {

                                                echo'<tr>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_4_mixing_details_row->ink_desc.'</td>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_4_mixing_details_row->ink_perc.'%</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg1_ink_usage_4*$ink_4_mixing_details_row->ink_perc/100),2).'</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg1_ink_usage_4*$ink_4_mixing_details_row->ink_perc/100)/1000,2).'</td>
                                                </tr>';

                                                $sum_perc+=$ink_4_mixing_details_row->ink_perc;
                                                $sum_grams+=round(($row->abg1_ink_usage_4*$ink_4_mixing_details_row->ink_perc/100),2);
                                              
                                            }

                                            echo'<tr style="font-weight:bold;"><td style="border:1px solid #D9d9d9;">TOTAL</td><td style="border:1px solid #D9d9d9;">'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';
                                                   

                                        }

                                        echo'</table>';
                                    }
                                }
                            }//ink1

                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">INK_USAGE</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_ink_usage_4.($row->abg1_ink_usage_4!=''?' Grams {'.($row->abg1_ink_usage_4/1000).' Kgs}':'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">ANILOX</td>
                        <td style="border:1px solid #D9d9d9;"><?php 

                        $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_4);
                        foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            echo $springtube_anilox_master_row->anilox_lpi;
                            
                        }

                        //echo $row->abg1_anilox_4;
                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">METHOD</td>
                        <td><?php echo ($row->abg1_applying_method_4!=''?($row->abg1_applying_method_4==1?'Plate Through':'Roller Through'):'');?></td style="border:1px solid #D9d9d9;">
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">TEETH</td>
                        <td style="border:1px solid #D9d9d9;"><?php 

                        $cylinder_master_result_4=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_4);
                        foreach ($cylinder_master_result_4 as $cylinder_master_row_4) {
                            echo $cylinder_master_row_4->teeth;
                        }
                        ?>                            
                        </td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">SR/FR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo ($row->abg1_rotary_4!=''?($row->abg1_rotary_4==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">UV POWER</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_power_4.($row->abg1_uv_power_4!=''?' %':'');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV SPEED</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_speed_4.($row->abg1_uv_speed_4!=''?' %':'');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV HOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg1_uv_hours_4.($row->abg1_uv_hours_4!=''?' Hrs':'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">COMMENT</td>
                        <td style="border:1px solid #D9d9d9;line-height:50px"><?php echo $row->abg1_unit_4_comment;?></td>
                    </tr>

                </table>
           </td>
    </tr>
    </table>
    <br/>

    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading" style="border:1px solid #D9d9d9;"><td colspan="16">DURST</td></tr>            
        <tr class="heading" >
            <td width="5%" style="border-bottom:1px solid #D9d9d9;">CORONA DOSE</td>
            <td width="1%" style="border-bottom:1px solid #D9d9d9;"></td>             
            <td width="3%" style="border:1px solid #D9d9d9;">PRINT CONFIG</td>                
            <td width="3%" style="border:1px solid #D9d9d9;">DEFAULT WHITE</td>
            <td width="10%" style="border:1px solid #D9d9d9;">COLOUR POLICY</td>
            <td width="5%" style="border:1px solid #D9d9d9;">SUBSTARTE DEF</td>
            <td width="5%" style="border:1px solid #D9d9d9;">PRINT SPEED (MTR/MIN)</td>
            <td width="5%" style="border:1px solid #D9d9d9;">UNWIND TENSION</td>
            <td width="5%" style="border:1px solid #D9d9d9;">PINNING W</td>
            <td width="5%" style="border:1px solid #D9d9d9;">PINNING K</td>
            <td width="5%" style="border:1px solid #D9d9d9;">UV1</td>
            <td width="5%" style="border:1px solid #D9d9d9;">UV1 HRS</td>
            <td width="5%" style="border:1px solid #D9d9d9;">UV2</td>
            <td width="5%" style="border:1px solid #D9d9d9;">UV2 HRS</td>
            <td width="5%" style="border:1px solid #D9d9d9;">NITROGEN</td>
             <td width="5%" style="border:1px solid #D9d9d9;">DIGITAL COST (EURO)</td>
        </tr>
        <tr >
            <td><?php echo ($row->durst_corona==''?'-':$row->durst_corona);?></td>
            <td></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->print_confg;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->digital_white;?></td>
            <td style="border:1px solid #D9d9d9;"><?php 
           // echo $row->colour_policy;
            $springtube_printing_color_policy_master_result=$this->common_model->select_one_active_record('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id'],'id',$row->colour_policy);
            foreach ($springtube_printing_color_policy_master_result as $key => $springtube_printing_color_policy_master_row) {
                
                echo $springtube_printing_color_policy_master_row->colour_policy;
            }
            ?>
                
            </td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->substrate_defination;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->printing_speed;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->unwind_tension;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->pinning_w.($row->pinning_w!=''?' %':'');?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->pinning_k.($row->pinning_k!=''?' %':'');?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->durst_uv_curing_1.($row->durst_uv_curing_1!=''?' %':'');?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->durst_uv_lamp_hrs_1;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->durst_uv_curing_2.($row->durst_uv_curing_2!=''?' %':'');?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->durst_uv_lamp_hrs_2;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $row->nitrogen;?></td>
             <td style="border:1px solid #D9d9d9;"><?php echo $row->digital_cost_in_euro;?></td>
            
        </tr>

    </table>


    <br/>
    <br/>
    <table style="width:50%">
        <tr>
            <!-- INK 1 -->
            <td width="50%">
                <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9; ">
                    <tr class="heading">
                        <td colspan="2"><b>ABG 2-FLEXO UNIT-1</b></td>
                        
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;width: 25%;">CARONA</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg2_carona_1;?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9; height:300px;">COLOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php

                            $ink_5=$row->abg2_ink_id_1;

                            if($ink_5!=''|| $ink_5!='0'){

                                $ink_5_qty_gram=$row->abg2_ink_usage_1;
                               
                                $ink_5_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_5);

                                foreach ($ink_5_result as $ink_5_row) {

                                    if($ink_5_row->ink_composition==1){

                                        echo $ink_5_row->ink_desc;
                                       
                                    }else{

                                        echo $ink_5_row->ink_desc;
                                        echo'<p>';

                                        echo'<table style="border:1px solid #D9d9d9;">
                                            <tr class="heading">
                                            <td style="border:1px solid #D9d9d9;">MIXED_INK_DETAILS</td>
                                            <td style="border:1px solid #D9d9d9;">INK%</td>
                                            <td style="border:1px solid #D9d9d9;">GRAMS</td>
                                            <td style="border:1px solid #D9d9d9;">KGS</td>
                                            </tr>';

                                        $ink_5_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_5);
                                        foreach ($ink_5_mixing_master_result as $ink_5_mixing_master_row) {                                      
                                        
                                           $data_mixing_5=array('mixing_id'=>$ink_5_mixing_master_row->mixing_id);

                                            $ink_5_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_5,$this->session->userdata['logged_in']['company_id']);

                                            $sum_perc=0;
                                            $sum_grams=0;

                                            foreach ($ink_5_mixing_details_result as $ink_5_mixing_details_row) {

                                                echo'<tr>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_5_mixing_details_row->ink_desc.'</td>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_5_mixing_details_row->ink_perc.'%</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg2_ink_usage_1*$ink_5_mixing_details_row->ink_perc/100),2).'</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg2_ink_usage_1*$ink_5_mixing_details_row->ink_perc/100)/1000,2).'</td>
                                                </tr>';

                                                $sum_perc+=$ink_5_mixing_details_row->ink_perc;
                                                $sum_grams+=round(($row->abg2_ink_usage_1*$ink_5_mixing_details_row->ink_perc/100),2);
                                              
                                            }

                                            echo'<tr style="font-weight:bold;"><td style="border:1px solid #D9d9d9;">TOTAL</td><td style="border:1px solid #D9d9d9;">'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';
                                                   

                                        }

                                        echo'</table>';
                                    }
                                }
                            }//ink1

                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">INK USAGE</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg2_ink_usage_1.($row->abg2_ink_usage_1!=''?' Grams {'.($row->abg2_ink_usage_1/1000).' Kgs}':'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">ANILOX</td>
                        <td style="border:1px solid #D9d9d9;"><?php 

                        $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg2_anilox_1);
                        foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            echo $springtube_anilox_master_row->anilox_lpi;
                            
                        }                        
                        //echo $row->abg2_anilox_1;
                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">METHOD</td>
                        <td><?php echo ($row->abg2_applying_method_1!=''?($row->abg2_applying_method_1==1?'Plate Through':'Roller Through'):'');?></td style="border:1px solid #D9d9d9;">
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">TEETH</td>
                        <td style="border:1px solid #D9d9d9;"><?php 
                        $cylinder_master_result_5=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg2_cylinder_teeth_1);
                        foreach ($cylinder_master_result_5 as $cylinder_master_row_5) {
                            echo $cylinder_master_row_5->teeth;
                        }
                        ?>                            
                        </td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">SR/FR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo ($row->abg2_rotary_1!=''?($row->abg2_rotary_1==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">UV POWER</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg2_uv_power_1.($row->abg2_uv_power_1!=''?' %':'');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV SPEED</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg2_uv_speed_1.($row->abg2_uv_speed_1!=''?' %':'');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV HOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg2_uv_hours_1.($row->abg2_uv_hours_1!=''?' Hrs':'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">COMMENT</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg2_unit_1_comment;?></td>
                    </tr>
                </table>
           </td>

           <!-- INK 6 -->
           <td width="50%">
                <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9">
                    <tr class="heading">
                        <td colspan="2"><b>ABG 2-FLEXO UNIT-2</b></td>
                        
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;width: 25%;"></td>
                        <td style="border:1px solid #D9d9d9;">&nbsp;</td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9; height:300px;">COLOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php

                            $ink_6=$row->abg2_ink_id_2;

                            if($ink_6!=''|| $ink_6!='0'){

                                $ink_6_qty_gram=$row->abg2_ink_usage_2;
                               
                                $ink_6_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_6);

                                foreach ($ink_6_result as $ink_6_row) {

                                    if($ink_6_row->ink_composition==1){

                                        echo $ink_6_row->ink_desc;
                                       
                                    }else{
                                        echo $ink_6_row->ink_desc;
                                        echo'<p>';
                                        echo'<table style="border:1px solid #D9d9d9;">
                                            <tr class="heading">
                                            <td style="border:1px solid #D9d9d9;">MIXED_INK_DETAILS</td>
                                            <td style="border:1px solid #D9d9d9;">INK%</td>
                                            <td style="border:1px solid #D9d9d9;">GRAMS</td>
                                            <td style="border:1px solid #D9d9d9;">KGS</td>
                                            </tr>';

                                        $ink_6_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_6);
                                        foreach ($ink_6_mixing_master_result as $ink_6_mixing_master_row) {                                      
                                        
                                           $data_mixing_6=array('mixing_id'=>$ink_6_mixing_master_row->mixing_id);

                                            $ink_6_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_6,$this->session->userdata['logged_in']['company_id']);
                                            $sum_perc=0;
                                            $sum_grams=0;

                                            foreach ($ink_6_mixing_details_result as $ink_6_mixing_details_row) {

                                                echo'<tr>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_6_mixing_details_row->ink_desc.'</td>
                                                <td style="border:1px solid #D9d9d9;">'.$ink_6_mixing_details_row->ink_perc.'%</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg2_ink_usage_2*$ink_6_mixing_details_row->ink_perc/100),2).'</td>
                                                <td style="border:1px solid #D9d9d9;">'.round(($row->abg2_ink_usage_2*$ink_6_mixing_details_row->ink_perc/100)/1000,2).'</td>
                                                </tr>';

                                                $sum_perc+=$ink_6_mixing_details_row->ink_perc;
                                                $sum_grams+=round(($row->abg2_ink_usage_2*$ink_6_mixing_details_row->ink_perc/100),2);
                                              
                                            }

                                            echo'<tr style="font-weight:bold;"><td style="border:1px solid #D9d9d9;">TOTAL</td><td style="border:1px solid #D9d9d9;">'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';
                                                   

                                        }

                                        echo'</table>';
                                    }
                                }
                            }//ink2

                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">INK USAGE</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->abg2_ink_usage_2.($row->abg2_ink_usage_2!=''?' Grams {'.($row->abg2_ink_usage_2/1000).' Kgs}':'');?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">ANILOX</td>
                        <td style="border:1px solid #D9d9d9;"><?php 

                        $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg2_anilox_2);
                        foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            echo $springtube_anilox_master_row->anilox_lpi;
                            
                        }

                        //echo $row->abg2_anilox_2;
                        ?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">METHOD</td>
                        <td><?php echo ($row->abg2_applying_method_2!=''?($row->abg2_applying_method_2==1?'Plate Through':'Roller Through'):'');?></td style="border:1px solid #D9d9d9;">
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">TEETH</td>
                        <td style="border:1px solid #D9d9d9;"><?php 
                        $cylinder_master_result_6=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg2_cylinder_teeth_2);
                        foreach ($cylinder_master_result_6 as $cylinder_master_row_6) {
                            echo $cylinder_master_row_6->teeth;
                        }
                        ?>                            
                        </td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">SR/FR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo ($row->abg2_rotary_2!=''?($row->abg2_rotary_2==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'');?></td>
                    </tr>
                    
                    <tr><td style="border:1px solid #D9d9d9;">UV POWER</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo ($row->is_extended_path=="YES"?$row->abg2_extended_uv_power_2.' %' :$row->abg2_uv_power_2.' %');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV SPEED</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo ($row->is_extended_path=="YES"?$row->abg2_extended_uv_speed_2.' %':$row->abg2_uv_speed_2.' %');?></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #D9d9d9;">UV HOUR</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo ($row->is_extended_path=="YES"?$row->abg2_extended_uv_hours_2.' Hrs' :$row->abg2_uv_hours_2.' Hrs');?></td>
                    </tr>

                    <tr><td style="border:1px solid #D9d9d9;">COMMENT</td>
                        <td style="border:1px solid #D9d9d9; line-height:30px"><?php echo $row->abg2_unit_2_comment;?></td>
                    </tr>
                    <tr><td style="border:1px solid #D9d9d9;">EXTENDED WEB PATH</td>
                        <td style="border:1px solid #D9d9d9;"><?php echo $row->is_extended_path;?></td>
                    </tr>
                </table> 
           </td>

        </tr>
    </table> 

    <?php

        //$data=array('order_no'=>$row->order_no,'article_no'=>$row->article_no,'archive'=>0,'job_setup_status'=>'0');
        $data=array('jobcard_no'=>$row->jobcard_no,'archive'=>0,'job_setup_status'=>'1');
        $springtube_daily_plates_master_result=$this->common_model->select_active_records_where('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],$data);

        if($springtube_daily_plates_master_result==TRUE){


    ?>
    <br/>
    <br/>
    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading" style="border:1px solid #D9d9d9;"><td colspan="16">PLATES MAKING DETAILS</td></tr>            
        <tr class="heading" style="border-right:1px solid #D9d9d9;">
            <td width="5%" style="border-bottom:1px solid #D9d9d9;">DATE</td>
            <td width="1%" style="border-bottom:1px solid #D9d9d9;"></td>            
            <td width="5%" style="border:1px solid #D9d9d9;">ORDER NO</td>
            <td width="5%" style="border:1px solid #D9d9d9;">ARTICLE NO</td>
            <td width="15%" style="border:1px solid #D9d9d9;">ARTICLE DESC</td>
            <td width="5%" style="border:1px solid #D9d9d9;">JOBCARD NO</td>             
            <td width="5%" style="border:1px solid #D9d9d9;">UPS</td>                
            <td width="5%" style="border:1px solid #D9d9d9;">REPEAT</td>
            <td width="5%" style="border:1px solid #D9d9d9;">NO. OF PLATES</td>
            
            <td width="5%" style="border:1px solid #D9d9d9;">PLATE SHEET USED</td>
             
            
        </tr>
        <?php foreach ($springtube_daily_plates_master_result as $springtube_daily_plates_master_row):?>
        <tr >
            <td style="border-bottom:1px solid #D9d9d9;"><?php echo $this->common_model->view_date($springtube_daily_plates_master_row->dpr_date,$this->session->userdata['logged_in']['company_id']);?></td>
            <td style="border-bottom:1px solid #D9d9d9;"></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $springtube_daily_plates_master_row->order_no;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $springtube_daily_plates_master_row->article_no;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $this->common_model->get_article_name($springtube_daily_plates_master_row->article_no,$this->session->userdata['logged_in']['company_id']);?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $springtube_daily_plates_master_row->jobcard_no;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $springtube_daily_plates_master_row->ups;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $springtube_daily_plates_master_row->repeat;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $springtube_daily_plates_master_row->total_plates;?></td>
            <td style="border:1px solid #D9d9d9;"><?php echo $springtube_daily_plates_master_row->sheet_used;?></td>

        </tr>
    <?php  endforeach;

        }//IF?>

    </table>
    <br/>
  
                
    <?php endforeach;?>

    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td colspan='6'>FOLLOW UPS</td>
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

    </div>
</body>
</html>   