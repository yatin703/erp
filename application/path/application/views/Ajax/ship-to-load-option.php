<?php 
    if($ship_to==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Ship To--</option>";
      foreach ($ship_to as $ship_to_row){
            echo "<option value='".$ship_to_row->related_company_id."' ".set_select('consin_adr_company_id',''.$ship_to_row->related_company_id.'').">".$ship_to_row->relate."//".$ship_to_row->related_company_id."//".$ship_to_row->lang_property_name."</option>";
          }     
        }

?>