<?php 
    if($packing_box_parameter_result==FALSE){
      echo "<option value=''>--Setup Required--</option>";
        }else{
          echo "<option value=''>--Select Bottom Box--</option>";
      foreach($packing_box_parameter_result as $packing_box_row){
													echo "<option value='".$packing_box_row->article_no."' ".set_select('packing_box',''.$packing_box_row->article_no.'')." >".$this->common_model->get_article_name($packing_box_row->article_no,$this->session->userdata['logged_in']['company_id'])."</option>";
												}     
        }

?>