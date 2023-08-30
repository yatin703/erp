<?php 
    if($artwork_final_version_no==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
      foreach ($artwork_final_version_no as $artwork_final_version_no_row){
      						 echo "<option value='".$artwork_final_version_no_row->ad_id."' ".set_select('artwork_final_version_no',''.$artwork_final_version_no_row->version_no.'').">".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."</option>";
          }     
      }

?>