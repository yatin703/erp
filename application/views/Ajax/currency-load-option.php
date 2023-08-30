<?php 
    if($to_currency==FALSE){
      echo "<option value=''>--Currency Setup Required--</option>";
        }else{
          echo "<option value=''>--Please Select--</option>";
      foreach ($to_currency as $row){
            echo "<option value='".$row->currency_name."' ".set_select('to_currency',''.$row->currency_name.'').">".$row->currency_name."</option>";
          }     
        }

?>