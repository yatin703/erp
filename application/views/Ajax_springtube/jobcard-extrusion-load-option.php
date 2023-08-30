<?php 
    if($production_master==FALSE){
      	echo '<option value="">--Please Select--</option>';
    }
    else{ 
        echo '<option value="">--Select Jobcard--</option>';
      	foreach ($production_master as $row){
          echo '<option value="'.$row->mp_pos_no.'" '.set_select('jobcard_no').'>'.$row->mp_pos_no.'</option>';
        }     
    }

?>