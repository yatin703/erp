<?php 
    if($order_details==FALSE){
      	echo '<option value="">--Please Select--</option>';
    }
    else{ 
        echo '<option value="">--Please Select--</option>';
      	foreach ($order_details as $row){
            echo '<option value="'.$row->article_no.'" '.set_select('article_no').'>'.$row->article_no.'</option>';
        }     
    }

?>