<?php 

if($tax_grid==FALSE){
  echo "No Record Found";
}else{

  global $total_tax_amount;
  $a=array();
  $tax_amount=0;
  $ta_amount=0;
  foreach ($tax_grid as $tax_grid_row){
    if($tax_grid_row->accu_flag==0 && $tax_grid_row->other_tax_code==''){  

      $data['tax']=$this->common_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$tax_grid_row->tax_code);
      foreach ($data['tax'] as $tax_value) {
         $tax_value->tax_name."=";
         $ta_amount=($amount/100)*$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id']); 
      }

       
    }else{ 

      $tax_structure_value=explode("|||",$tax_grid_row->other_tax_code);
      count($tax_structure_value);
      $data['tax']=$this->common_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$tax_grid_row->tax_code);

      $i=1;
      foreach ($data['tax'] as $tax_value) {
      $tax_value->tax_name."=";
      foreach ($tax_structure_value as  $value) {
        if($value=='basic'){ }else{}
       } 
        $ta_amount=(($amount+$total_tax_amount)/100)*$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id']);
      $i++;

    }
  }


  array_push($a,$ta_amount);

  $total_tax_amount +=$ta_amount;

  }
  echo "<input type='text' name='total_tax_amount'  class='total_tax_amount' value='".$total_tax_amount."' maxlength='15' size='10'/>";
  implode("|",$a);
 
}

?>