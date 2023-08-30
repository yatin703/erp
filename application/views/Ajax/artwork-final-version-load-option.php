<?php 

				if($artwork_final_nonapproved_version_no==FALSE){
          $nonapproved_version=0;
					//echo "<option value=''>--N Required--</option>";
				}else{
        foreach ($artwork_final_nonapproved_version_no as $artwork_final_nonapproved_version_no_row){

      					$nonapproved_version=$artwork_final_nonapproved_version_no_row->version_no;
     	    }
      } 

        if($artwork_final_version_no==FALSE){
          $approved_version=0;
          //echo "<option value=''>--Setup Required--</option>";
            }else{
          foreach ($artwork_final_version_no as $artwork_final_version_no_row){

          					$approved_version=$artwork_final_version_no_row->version_no;

          						 //echo "<option value='".$artwork_final_version_no_row->ad_id."' ".set_select('artwork_final_version_no',''.$artwork_final_version_no_row->version_no.'').">".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."</option>";
              }     
          }

      if($nonapproved_version>$approved_version){
      	echo "<option value=''>--Final Version is in Process</option>";
      }else{

      	if($artwork_final_version_no==FALSE){
      	//echo "<option value=''>--Setup Required--</option>";
        }else{
      		foreach ($artwork_final_version_no as $artwork_final_version_no_row){
      			echo "<option value='".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."' ".set_select('artwork_final_version_no',''.$artwork_final_version_no_row->ad_id.'_R'.$artwork_final_version_no_row->version_no.'').">".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."</option>";
          }     
      		}

      }

?>