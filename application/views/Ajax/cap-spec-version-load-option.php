<?php 
    if($cap_spec_version_no==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
      foreach ($cap_spec_version_no as $cap_spec_version_no_row){
      					if($cap_spec_version_no_row->spec_version_no==NULL){
      						echo "<option value='1' ".set_select('spec_version_no','1').">1</option>";
      					}else{
                  echo "<option value=''>--Version--</option>";
      						 echo "<option value='".$cap_spec_version_no_row->spec_version_no."' ".set_select('cap_spec_version_no_row',''.$cap_spec_version_no_row->spec_version_no.'').">".$cap_spec_version_no_row->spec_version_no."</option>";
      					}
            }     
        }


    if($specification==FALSE){
        }else{
      foreach ($specification as $specification_row){
                echo $specification_row->article_name;
            }     
        }

?>