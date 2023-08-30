<?php 
    if($cap_type==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Cap Type--</option>";
      foreach ($cap_type as $cap_type_row){
            echo "<option value='".$cap_type_row->cap_type."//".$cap_type_row->cap_type_id."' ".set_select('cap_type',''.$cap_type_row->cap_type_id.'').">".$cap_type_row->cap_type."</option>";
          }     
        }

?>