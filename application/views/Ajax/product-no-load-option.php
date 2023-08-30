<option value=''>Select Product No</option>
<?php if($order_data){
    foreach($order_data as $row){
        echo "<option value='".$row->article_no."'  ".set_select('product_name',''.$row->article_no.'').">".$row->article_no."</option>";
        }
      }else{
      echo "Contact to Admin";
    }    
?>