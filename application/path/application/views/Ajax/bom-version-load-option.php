<?php 
    if($bom_version_no_result==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
      foreach ($bom_version_no_result as $bom_version_no_row){
      					if($bom_version_no_row->bom_version_no==NULL){
      						echo "<option value='1' ".set_select('bom_version_no','1').">1</option>";
      					}else{
      						 echo "<option value='".$bom_version_no_row->bom_version_no."' ".set_select('bom_version_no',''.$bom_version_no_row->bom_version_no.'').">".$bom_version_no_row->bom_version_no."</option>";
      					}
            }     
        }

?>