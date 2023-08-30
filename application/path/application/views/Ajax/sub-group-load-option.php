<?php 
    if($sub_group==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Sub Group--</option>";
      foreach ($sub_group as $sub_group_row){
            echo "<option value='".$sub_group_row->article_group_id."' ".set_select('sub_group',''.$sub_group_row->article_group_id.'').">".strtoupper($sub_group_row->sub_group)."-".$sub_group_row->article_group_id."</option>";
          }     
        }

?>