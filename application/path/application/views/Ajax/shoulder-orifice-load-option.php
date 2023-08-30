<?php 
    if($shoulder_orifice==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Shoulder Orifice--</option>";
      foreach ($shoulder_orifice as $shoulder_orifice_row){
            echo "<option value='".$shoulder_orifice_row->shoulder_orifice."//".$shoulder_orifice_row->shld_orifice_id."' ".set_select('shoulder_orifice',''.$shoulder_orifice_row->shld_orifice_id.'').">".$shoulder_orifice_row->shoulder_orifice."</option>";
          }     
        }

?>