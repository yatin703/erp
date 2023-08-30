<?php 
    if($second_sub_group==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Second Sub Group--</option>";
      foreach ($second_sub_group as $second_sub_group_row){
            echo "<option value='".$second_sub_group_row->sub_sub_grp_id."' ".set_select('second_sub_group',''.$second_sub_group_row->sub_sub_grp_id.'').">".strtoupper($second_sub_group_row->second_sub_group)."-".$second_sub_group_row->sub_sub_grp_id."</option>";
          }     
        }

?>