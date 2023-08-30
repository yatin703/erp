<?php 
    if($springtube_rfd_master==FALSE){
        echo '<option value="">--Please Select--</option>';
    }
    else{ 
        echo '<option value="">--Please Select--</option>';
        foreach ($springtube_rfd_master as $row){
            echo '<option value="'.$row->rfd_qty.'" '.set_select('rfd_qty').'>'.$row->rfd_qty.'</option>';
        }     
    }

?>