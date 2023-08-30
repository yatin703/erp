<?php 
    if($cap_finish==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Cap Finish--</option>";
      foreach ($cap_finish as $cap_finish_row){
            echo "<option value='".$cap_finish_row->cap_finish."//".$cap_finish_row->cap_finish_id."' ".set_select('cap_finish',''.$cap_finish_row->cap_finish.'//'.$cap_finish_row->cap_finish_id.'').">".$cap_finish_row->cap_finish."</option>";
          }     
        }

?>