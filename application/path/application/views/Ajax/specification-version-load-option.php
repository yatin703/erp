<?php 
    if($spec_version_no==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
      foreach ($spec_version_no as $spec_version_no_row){
      					if($spec_version_no_row->spec_version_no==NULL){
      						echo "<option value='1' ".set_select('spec_version_no','1').">1</option>";
      					}else{
      						 echo "<option value='".$spec_version_no_row->spec_version_no."' ".set_select('spec_version_no',''.$spec_version_no_row->spec_version_no.'').">".$spec_version_no_row->spec_version_no."</option>";
      					}
            }     
        }

?>