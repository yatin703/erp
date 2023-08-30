<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('process_model');
      $this->load->model('main_group_model');
      $this->load->model('sub_group_model');
      $this->load->model('second_sub_group_model');

		}else{
			redirect('login','refresh');
		}
  }
public function index(){


    $data['page_name']='setup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $table='workprocedure_types_master';

    include('pagination.php');

    $data['workprocedure_types_master']=$this->process_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);


    //echo $this->db->last_query();

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

    $this->load->view('Home/footer');

  }

  public function create(){
    $data['page_name']='setup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


    $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
    $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
    $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    // Eknath--
    $this->form_validation->set_rules('main_group','Main group' ,'xss_clean');
    $this->form_validation->set_rules('sub_group','Sub group' ,'xss_clean');
    $this->form_validation->set_rules('second_sub_group','Second Sub Group' ,'xss_clean');
    $this->form_validation->set_rules('lang_description','Work Procedure Type' ,'required|xss_clean|strtoupper|is_unique[workprocedure_types_master.lang_description]');
    $this->form_validation->set_rules('rejection_perc','Rejection Percentage' ,'xss_clean|numeric');
   


    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
      $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
      $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
      
      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $max_pkey=0;
          $result=$this->common_model->select_max_pkey_numeric('workprocedure_types_master','work_proc_type_id',$this->session->userdata['logged_in']['company_id']); 
          
          foreach($result as $row){

            $max_pkey=$row->work_proc_type_id;
          }

          $work_proc_type_id=$max_pkey+1;
           
          $data=array( 'company_id'=>$this->session->userdata['logged_in']['company_id'],
                       'work_proc_type_id'=>$work_proc_type_id,
                       'main_group_id'=>$this->input->post('main_group'),
                       'article_group_id'=>$this->input->post('sub_group'),
                       'sub_sub_grp_id'=>$this->input->post('second_sub_group'),
                       'lang_description'=>$this->input->post('lang_description'),
                       'rejection_perc'=>$this->common_model->save_number($this->input->post('rejection_perc'),$this->session->userdata['logged_in']['company_id']),
                       'language_id'=>$this->session->userdata['logged_in']['language_id'],
                       'archive'=>'0'
                      );


          $result=$this->common_model->save('workprocedure_types_master',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            
            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

            $this->load->view('Home/footer');

             
          }
          else{

            $data['note']='Error in Save Transaction';

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view('Error/error-title',$data);

            $this->load->view('Home/footer');

        }

    }


    
  }


  function modify(){

    $data['page_name']='setup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
    $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
    $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
     
     $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id', $this->uri->segment(3));

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }



  public function update(){

     $this->form_validation->set_rules('main_group','Main group' ,'xss_clean');
    $this->form_validation->set_rules('sub_group','Sub group' ,'xss_clean');
    $this->form_validation->set_rules('second_sub_group','Second Sub Group' ,'xss_clean');
    $this->form_validation->set_rules('tube_process_id','Tube Process' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('position','Position' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('lang_description','Work Procedure Type' ,'required|xss_clean|strtoupper');
    $this->form_validation->set_rules('rejection_perc','Rejection Percentage' ,'xss_clean|numeric');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

     $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
    $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
    $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
     
     $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id', $this->uri->segment(3));


      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $data=array(
                       'main_group_id'=>$this->input->post('main_group'),
                       'article_group_id'=>$this->input->post('sub_group'),
                       'tube_process_id'=>$this->input->post('tube_process_id'),
                       'position'=>$this->input->post('position'),
                       'sub_sub_grp_id'=>$this->input->post('second_sub_group'),
                       'lang_description'=>$this->input->post('lang_description'),
                       'rejection_perc'=>$this->common_model->save_number($this->input->post('rejection_perc'),$this->session->userdata['logged_in']['company_id'])
                                             
                       );


          $result=$this->common_model->update_one_active_record('workprocedure_types_master',$data,'work_proc_type_id',$this->input->post('work_proc_type_id'),$this->session->userdata['logged_in']['company_id']);
          //echo $this->db->last_query();
          
        
        if( $result==1){

            $data['note']='Update Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
            
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);         
            $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id', $this->input->post('work_proc_type_id'));



            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

            $this->load->view('Home/footer');


        }
        else{

          $data['note']='Error in Update Transaction';

          $data['page_name']='setup';

          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view('Error/error-title',$data);

          $this->load->view('Home/footer');

        }

    }
    
  }

  public function delete(){

    
    $data=array('archive'=>'1');
    $result=$this->common_model->update_one_active_record('workprocedure_types_master',$data,'work_proc_type_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Archive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
     
      $data['workprocedure_types_master']=$this->common_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'] ,'work_proc_type_id',$this->uri->segment(3));

      $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
      $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
      $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']); 

      


      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{
        $data['note']='Error in Archive Transaction';

        $data['page_name']='setup';

        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $this->load->view('Home/header');

        $this->load->view('Home/nav',$data);

        $this->load->view('Home/subnav');

        $this->load->view('Error/error-title',$data);

        $this->load->view('Home/footer');



    }

  }

  function archive_records(){

    $table='workprocedure_types_master';

    include('pagination_archive.php');

    $data['workprocedure_types_master']=$this->process_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
    

    $data['page_name']='setup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);

    $this->load->view('Home/footer');


  }


  function dearchive(){

    $data=array('archive'=>'0');
    $result=$this->common_model->update_one_active_record('workprocedure_types_master',$data,'work_proc_type_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
     
      $data['workprocedure_types_master']=$this->common_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'] ,'work_proc_type_id',$this->uri->segment(3));

      $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
      $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
      $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']); 

      


      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');


    }
    else{
        $data['note']='Error in Dearchive Transaction';

        $data['page_name']='setup';

        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $this->load->view('Home/header');

        $this->load->view('Home/nav',$data);

        $this->load->view('Home/subnav');

        $this->load->view('Error/error-title',$data);

        $this->load->view('Home/footer');



    }

  }

  public function search(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
    $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
    $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']); 


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

    $this->load->view('Home/footer');


  }


  public function search_result(){
    // Eknath--
    $this->form_validation->set_rules('main_group','Main group' ,'xss_clean');
    $this->form_validation->set_rules('sub_group','Sub group' ,'xss_clean');
    $this->form_validation->set_rules('second_sub_group','Second Sub Group' ,'xss_clean');
    $this->form_validation->set_rules('lang_description','Work Procedure Type' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('rejection_perc','Rejection Percentage' ,'xss_clean|numeric');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
      $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
      $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
      


      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

      $this->load->view('Home/footer');

    }
    else{
          $data=array( 'main_group_id'=>$this->input->post('main_group'),
                       'article_group_id'=>$this->input->post('sub_group'),
                       'sub_sub_grp_id'=>$this->input->post('second_sub_group'),
                       'lang_description'=>$this->input->post('lang_description'),
                       'rejection_perc'=>$this->common_model->save_number($this->input->post('rejection_perc'),$this->session->userdata['logged_in']['company_id'])
                      );

          $data=array_filter($data);

    $table='workprocedure_types_master';
    //include('pagination.php');

          $data['workprocedure_types_master']=$this->process_model->active_record_search('workprocedure_types_master',$data,$this->session->userdata['logged_in']['company_id']);

          $data['page_name']='setup';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

          $this->load->view('Home/footer');
         

    }

  }


}
