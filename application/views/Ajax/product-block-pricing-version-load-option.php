<?php 
    if($version==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
      foreach ($version as $version_row){
      					if($version_row->version_no==NULL){
      						echo "<option value='1' ".set_select('version_no','1').">1</option>";
      					}else{
      						 echo "<option value='".$version_row->version_no."' ".set_select('version_no',''.$version_row->version_no.'').">".$version_row->version_no."</option>";
      					}

           
          }     
        }

?>