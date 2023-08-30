<?php 
    if($cap_dia==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Cap Type--</option>";
      foreach ($cap_dia as $cap_dia_row){
            echo "<option value='".$cap_dia_row->cap_dia."//".$cap_dia_row->cap_dia_id."' ".set_select('cap_dia',''.$cap_dia_row->cap_dia_id.'').">".$cap_dia_row->cap_dia."</option>";
          }     
        }

?>