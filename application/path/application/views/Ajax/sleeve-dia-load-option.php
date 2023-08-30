<?php 
    if($sleeve_dia==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Sleeve Dia--</option>";
      foreach ($sleeve_dia as $sleeve_dia_row){
            echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."' ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
          }     
        }

?>