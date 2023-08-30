<?php 
    if($specification_final_version_no==FALSE){
      echo "NO SPECIFICATION";
        }else{
      foreach ($specification_final_version_no as $specification_final_version_no_row){
      	
      						 echo "<a href='".base_url('index.php/Tube_with_cap_new/view/'.$specification_final_version_no_row->spec_id.'/'.$specification_final_version_no_row->spec_version_no.'')."' target='_blank' class='ui teal label'>".$specification_final_version_no_row->spec_id."_R".$specification_final_version_no_row->spec_version_no."</a> <a href='".base_url('index.php/Artwork_new/view/'.$specification_final_version_no_row->ad_id.'/'.$specification_final_version_no_row->version_no.'')."' target='_blank' class='ui red label'>".$specification_final_version_no_row->ad_id."_R".$specification_final_version_no_row->version_no."</a>";
          }     
      }

?>