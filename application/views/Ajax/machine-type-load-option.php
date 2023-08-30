<?php 
    if($machine==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Machine--</option>";
      foreach ($machine as $machine_row){
            echo "<option value='".$machine_row->machine_id."' ".set_select('machine_type',''.$machine_row->machine_name.'').">".$machine_row->machine_name."</option>";
          }     
        }

?>