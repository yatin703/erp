<?php 
    if($shoulder==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Shoulder--</option>";
      foreach ($shoulder as $shoulder_row){
            echo "<option value='".$shoulder_row->shoulder_type."//".$shoulder_row->shld_type_id."' ".set_select('shoulder',''.$shoulder_row->shoulder_type.'//'.$shoulder_row->shld_type_id.'').">".$shoulder_row->shoulder_type."</option>";
          }     
        }

?>