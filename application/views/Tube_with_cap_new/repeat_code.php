$dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);


            $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$CAP_DIA);
            //echo $this->db->last_query();
            if($data['cap_diameter_master']==FALSE){
              $cap_dia_id="";
            }else{
             foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
              $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
             }
           }

            $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$CAP_ORIFICE);
            if($data['cap_orifice_master']==FALSE){
              $cap_orifice_id="";
            }else{
              foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
              $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
               }
             }

             $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$CAP_STYLE);
              if($data['cap_types_master']==FALSE){
                $cap_type_id="";
                }else{
                foreach($data['cap_types_master'] as $cap_types_master_row){
                  $cap_type_id=$cap_types_master_row->cap_type_id;
                 }
              }

             $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$CAP_MOLD_FINISH);
             if($data['cap_finish_master']==FALSE){
              $cap_finish_id="";
              }else{
              foreach($data['cap_finish_master'] as $cap_finish_master_row){
                $cap_finish_id=$cap_finish_master_row->cap_finish_id;
              }
              }



             
             $combination_data=array('sleeve_id'=>$sleeve_dia[1],
              'shld_type_id'=>$shoulder[1],
              'shld_orifice_id'=>$shoulder_orifice[1],
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             $this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
             //echo $this->db->last_query();
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){



















              }else{
              $data['error']='Wrong combination';
             }