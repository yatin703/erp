<?php 
    if($sales_quote_customer_contact_details==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select PM--</option>";
      foreach ($sales_quote_customer_contact_details as $row){
            echo "<option value='".$row->address_category_contact_id."' ".set_select('pm_1',''.$row->address_category_contact_id.'').">".$row->contact_name."</option>";
          }     
        }

?>