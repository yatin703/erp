<?php 

  $sleeve_dia='';$sleeve_length=''; $art_dia='';$art_length=''; $art_print_type='';$print_type='';



    if($bom_final_nonapproved_version_no==FALSE){
          $nonapproved_bom_version=0;
        }else{
        foreach ($bom_final_nonapproved_version_no as $bom_final_nonapproved_version_no_row){
          $nonapproved_bom_version=$bom_final_nonapproved_version_no_row->bom_version_no;
          }
      }


      if($bom_final_version_no==FALSE){
        $approved_bom_version=0;
        }else{
      foreach ($bom_final_version_no as $bom_final_version_no_row){
        $approved_bom_version=$bom_final_version_no_row->bom_version_no;
        }     
      }

      if($nonapproved_bom_version>$approved_bom_version){
        echo '<script language="javascript">alert("Final Bill of material is in Process")</script>';
      }else{

        if($bom_final_version_no==FALSE){

        }else{
          foreach ($bom_final_version_no as $bom_final_version_no_row){
            $table='bill_of_material';     

            $data['bill_of_material']=$this->bill_of_material_model->active_records_search($table,$this->session->userdata['logged_in']['company_id'],
              $data=array('bom_no'=>$bom_final_version_no_row->bom_no,
                         'bom_version_no'=>$bom_final_version_no_row->bom_version_no),$from='',$to='',$flag='');
            if($data['bill_of_material']==FALSE){
               
            }else{
              
              foreach($data['bill_of_material'] as $row){

              
                if(substr($row->sleeve_code,0,3)=="SLV"){

                  $sleeve_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$row->sleeve_code);
                if($sleeve_spec_sheet){

                  foreach ($sleeve_spec_sheet as $sleeve_spec_sheet_row) {
                  
                  $sleeve_spec_id=$sleeve_spec_sheet_row->spec_id;
                  $sleeve_spec_version_no=$sleeve_spec_sheet_row->spec_version_no;

                  $data=array('spec_id'=>$sleeve_spec_id,
                        'spec_version_no'=>$sleeve_spec_version_no);

                  $data['sleeve_specs_details']=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);

                  foreach ($data['sleeve_specs_details'] as $sleeve_specs_details_row) {
                    $sleeve_dia=$sleeve_specs_details_row->SLEEVE_DIA;
                    $sleeve_length=$sleeve_specs_details_row->SLEEVE_LENGTH;
                    $sleeve_master_batch=$sleeve_specs_details_row->SLEEVE_MASTER_BATCH;
                    $sleeve_mb_perc=$sleeve_specs_details_row->SLEEVE_MB_PERC;


                    }
                  }
                }else{
                  $sleeve_dia="";
                  $sleeve_length="";
                  $sleeve_spec_id="";
                  $sleeve_master_batch="";
                  $sleeve_spec_version_no="";
                  $sleeve_mb_perc="";
                }
                }else{


                $film_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$row->sleeve_code);

                if($film_spec_sheet){

                  foreach ($film_spec_sheet as $film_spec_sheet_row) {
                  
                  $film_spec_id=$film_spec_sheet_row->spec_id;
                  $film_spec_version_no=$film_spec_sheet_row->spec_version_no;

                  $data=array('spec_id'=>$film_spec_id,
                        'spec_version_no'=>$film_spec_version_no);

                  $data['film_specs_details']=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                  //echo $this->db->last_query();

                  foreach ($data['film_specs_details'] as $film_specs_details_row) {
                    $sleeve_dia=$film_specs_details_row->SLEEVE_DIA;
                    $sleeve_length=$film_specs_details_row->SLEEVE_LENGTH;
                    $sleeve_master_batch=$film_specs_details_row->FILM_MASTER_BATCH_2;
                    $sleeve_mb_perc=$film_specs_details_row->FILM_MB_PERC_2;


                      }
                    }
                  }else{
                    $sleeve_dia="";
                    $sleeve_length="";
                    $sleeve_spec_id="";
                    $sleeve_master_batch="";
                    $sleeve_spec_version_no="";
                    $sleeve_mb_perc="";
                  }

                }

                $print_type = $row->print_type;


/* */





              }

            }
            echo "<a href='".base_url('index.php/bill_of_material/view/'.$bom_final_version_no_row->bom_id.'')."' target='_blank' class='ui green label'>".$bom_final_version_no_row->bom_no."_R".$bom_final_version_no_row->bom_version_no."</a>";
        }     
      }

    }


    /*
     if($bom_no==FALSE){
      echo " NO BOM";
        }else{
      foreach ($bom_no as $bom_no_row){

          echo $a=(!empty($bom_no_row->bom_id) ? "<span class='ui teal label'>".$bom_no_row->bom_no."_".$bom_no_row->bom_version_no."</span>" :"");
          }     
      }

      */

    if($artwork_final_nonapproved_version_no==FALSE){
          $nonapproved_version=0;
        }else{
        foreach ($artwork_final_nonapproved_version_no as $artwork_final_nonapproved_version_no_row){
          $nonapproved_version=$artwork_final_nonapproved_version_no_row->version_no;
          }
      } 

    if($artwork_final_version_no==FALSE){
        $approved_version=0;
        }else{
      foreach ($artwork_final_version_no as $artwork_final_version_no_row){
        $approved_version=$artwork_final_version_no_row->version_no;
        //echo "<a href='".base_url('index.php/Artwork_new/view/'.$artwork_final_version_no_row->ad_id.'/'.$artwork_final_version_no_row->version_no.'')."' target='_blank' class='ui red label'>".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."</a>";
        }     
      }

      if($nonapproved_version>$approved_version){
        echo '<script language="javascript">alert("Final Artwork Version is in Process")</script>';
      }else{
        if($artwork_final_version_no==FALSE){

        }else{
          foreach ($artwork_final_version_no as $artwork_final_version_no_row){
//echo $artwork_final_version_no_row->ad_id;
             if(substr($artwork_final_version_no_row->ad_id, 0,3)=='SAW'){

                $data['artwork_springtube']=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data=array(
                 'ad_id' => $artwork_final_version_no_row->ad_id,
                 'version_no' => $artwork_final_version_no_row->version_no),$search='',$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);

                foreach($data['artwork_springtube'] as $row){
                  $result_dia=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','1');

                  $result_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','2');

                  $result_print_type=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','18');

                  foreach($result_dia as $dia_row){
                    $art_dia = $dia_row->parameter_value;
                  }

                  foreach($result_length as $length_row){
                    $art_length = $length_row->parameter_value;
                  }

                  foreach($result_print_type as $print_type_row){
                    $art_print_type = strtoupper($print_type_row->parameter_value);
                  }
                }


               }else{  

               $data['artwork']=$this->artwork_model->active_record_search_new('artwork_devel_master',$data=array(
                       'ad_id' => $artwork_final_version_no_row->ad_id,
                       'version_no' => $artwork_final_version_no_row->version_no              ),$search='',$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);

                foreach($data['artwork'] as $row){

                  $result_dia=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','1');

                  $result_length=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','2');

                  $result_print_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','17');


                  foreach ($result_dia as $dia_row) {
                    $art_dia = $dia_row->parameter_value;
                  }

                  foreach ($result_length as $length_row) {
                    $art_length = $length_row->parameter_value;
                  }


                   foreach($result_print_type as $print_type_row){
                     $art_print_type = strtoupper($print_type_row->parameter_value);
                    }
                  
                }
                 
               }


            if(substr($artwork_final_version_no_row->ad_id, 0,3)=='SAW'){

                echo "<a href='".base_url('index.php/Artwork_springtube/view/'.$artwork_final_version_no_row->ad_id.'/'.$artwork_final_version_no_row->version_no.'')."' target='_blank' class='ui green label'>".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."</a>";

            }else{
            echo "<a href='".base_url('index.php/Artwork_new/view/'.$artwork_final_version_no_row->ad_id.'/'.$artwork_final_version_no_row->version_no.'')."' target='_blank' class='ui green label'>".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."</a>";
          }

if($art_dia!='' and $sleeve_dia!='' /*|| $art_length!='' || $sleeve_length!='' || $art_print_type!='' || $print_type!=''*/){

  if($art_dia == $sleeve_dia and $art_length == $sleeve_length and $art_print_type == $print_type ){
   echo'';
  }else{
   echo '<script language="javascript">alert("ADR & BOM Data Mismatch Error.")</script>';
  }
}
        
        }     
      }

    }



    

  


     
?>

