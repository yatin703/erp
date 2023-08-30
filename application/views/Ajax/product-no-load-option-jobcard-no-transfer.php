<?php 
    if($springtube_jobcard_master==FALSE){
        echo '<option value="">--Please Select--</option>';
    }
    else{ 
        echo '<option value="">--Please Select--</option>';
        foreach ($springtube_jobcard_master as $row){
            echo '<option value="'.$row->jobcard_no.'" '.set_select('jobcard_no').'>'.$row->jobcard_no.'</option>';
        }     
    }
?>