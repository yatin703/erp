<?php 
    if($form==FALSE){
      echo "<option value=''>--Form Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Form--</option>";
      foreach ($form as $row){
            echo "<option value='".$row->form_id."' ".set_select('form',''.$row->form_id.'').">".$row->form_name."</option>";
          }     
        }

?>