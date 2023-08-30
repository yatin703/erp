<?php 
    if($currency_rate==FALSE){
      echo "<option value=''>--Form Setup Required--</option>";
        }else{
      foreach ($currency_rate as $currency_rate_row){
            echo "<option value='".$currency_rate_row->to_currency."|".$this->common_model->read_number($currency_rate_row->exchange_rate,$this->session->userdata['logged_in']['company_id'])."|".$currency_rate_row->date_created."' ".set_select('exchange_rate',''.$currency_rate_row->to_currency.'|'.$this->common_model->read_number($currency_rate_row->exchange_rate,$this->session->userdata['logged_in']['company_id']).''.$currency_rate_row->date_created.'').">".$currency_rate_row->to_currency." ".$this->common_model->read_number($currency_rate_row->exchange_rate,$this->session->userdata['logged_in']['company_id'])." - ".date("d-M-Y H:i:s",strtotime($currency_rate_row->date_created))."</option>";
          }     
        }

?>