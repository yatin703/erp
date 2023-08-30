<?php 
    if($springtube_rfd_master==FALSE){
        echo '<option value="">--Please Select--</option>';
    }
    else{ 
        echo '<option value="">--Please Select--</option>';
        foreach ($springtube_rfd_master as $row){
            echo '<option value="'.$row->article_no.'" '.set_select('article_no').'>'.$row->article_no.'</option>';
        }     
    }

?>