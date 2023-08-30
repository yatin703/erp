<?php 
    if($result!=FALSE){  

    // if(!empty($this->input->post('article_no[]'))){
    // 	print_r($this->input->post('article_no[]'));
    // }  
    	
     //echo count($this->input->get('article_no[]'));
      // foreach ($result as $row){ 

      //   echo ' <input type="checkbox" name="article_no[]" id="article_no[]" value="'.$row->article_no.'" '.(count($this->input->post('article_no[]'))>0?(in_array($row->article_no,$this->input->post('article_no[]'),TRUE)? "checked":""):"").'/> &nbsp;'.$row->article_no.'</br>';
      // }

      echo "<table class='ui very basic collapsing celled table' style='font-size:10px;'>
            <thead>
               <tr>
               <th>Select</th>
               <th>Product Name</th>
               </tr>
            </thead>
            <tbody>";
      foreach ($result as $row){ 
              
        echo '<tr>
                <td>
                    <input type="checkbox" name="article_no[]" id="article_no[]" value="'.$row->article_no.'" '.set_checkbox('article_no',$row->article_no).'/>
                  
                </td>
                <td>'.$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id']).'//'.$row->article_no.'</td>
              </tr>';
            }
        echo "</tbody></table>";          
    }else{
    }

?>