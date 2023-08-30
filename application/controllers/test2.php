 $data=array('sleeve_id'=>$sleeve_dia[1],
                'shld_type_id'=>$shoulder[1],
                'shld_orifice_id'=>$shoulder_orifice[1],
                'cap_dia_id'=>$cap_dia[1],
                'cap_orifice_id'=>$cap_orifice[1],
                'cap_type_id'=>$cap_type[1],
                'cap_finish_id'=>$cap_finish[1]);
              $data['combination']=$this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$data);
              if($data['combination']==FALSE){
                $this->form_validation->set_message('article_check', 'The {field} field is incorrect');
              }else{
              foreach($data['combination'] as $combination_row){

              }
            }