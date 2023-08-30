<?php 
    if($state==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select State--</option>";
      foreach ($state as $state_row){
            echo "<option value='".$state_row->zip_code."' ".set_select('state',''.$state_row->zip_code.'').">".strtoupper($state_row->lang_city)." ".$state_row->state_code."</option>";
          }     
        }

?>