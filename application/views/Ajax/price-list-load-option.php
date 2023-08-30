<?php 
    if($price_list==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
        	echo "<option value=''>--Select Price List--</option>";
      foreach ($price_list as $price_list_row){
            echo "<option value='".$price_list_row->pg_no."' ".set_select('pg_no',''.$price_list_row->pg_no.'').">".$price_list_row->price_list_name."</option>";
          }     
        }

?>