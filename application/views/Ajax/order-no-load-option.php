<option value=''>Select Order No</option>
<?php if($order_data){
        foreach ($order_data as $row){
            echo "<option value='".$row->ref_ord_no."' ".set_select('so_no',''.$row->ref_ord_no.'').">".$row->ref_ord_no."</option>";
          }
      }else{
      echo "Contact to Admin";
    }    
?>