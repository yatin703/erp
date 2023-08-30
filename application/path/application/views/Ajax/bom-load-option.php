<?php 
    
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
            if(substr($artwork_final_version_no_row->ad_id, 0,3)=='SAW'){

                echo "<a href='".base_url('index.php/Artwork_springtube/view/'.$artwork_final_version_no_row->ad_id.'/'.$artwork_final_version_no_row->version_no.'')."' target='_blank' class='ui green label'>".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."</a>";

            }else{
            echo "<a href='".base_url('index.php/Artwork_new/view/'.$artwork_final_version_no_row->ad_id.'/'.$artwork_final_version_no_row->version_no.'')."' target='_blank' class='ui green label'>".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."</a>";
          }
        }     
      }

    }



     
?>