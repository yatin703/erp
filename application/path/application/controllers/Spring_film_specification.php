<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spring_film_specification extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('tube_specification_model');
      $this->load->model('sleeve_specification_model');
      $this->load->model('article_model');
      $this->load->model('customer_model');
      $this->load->model('supplier_model');
      $this->load->model('artwork_model');
      $this->load->model('sub_group_model');
      $this->load->model('second_sub_group_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('fiscal_model');
    }else{
      redirect('login','refresh');
    }
  }

  function index(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='specification_sheet';
            include('pagination-tube.php');
            $data['specification']=$this->sleeve_specification_model->select_film_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

            //echo $this->db->last_query();
           
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No rights Thanks';
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }
        }
        
        }
      }
    }
    else{
      $data['note']='No rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }


  function create_seven_layer(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-seven-form',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No rights Thanks';
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }
        }
        
        }
      }
    }
    else{
      $data['note']='No New rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }


  


  function save_seven_layer(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|max_length[5]');

            //Layer ONe

            $this->form_validation->set_rules('gauge_one','Gauge One' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('film_ldpe_per_one','Film Ldpe Layer One %' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_one_check');
            $this->form_validation->set_rules('film_lldpe_per_one','Film Lldpe Layer One %' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_one_check');
            $this->form_validation->set_rules('film_hdpe_per_one','Film Hdpe % Layer One' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_one_check');
            if(!empty($this->input->post('film_ldpe_per_one'))){
              $this->form_validation->set_rules('film_ldpe_one','Film Ldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('film_lldpe_per_one'))){
              $this->form_validation->set_rules('film_lldpe_one','Film Lldpe' ,'trim|xss_clean|required');
            }
            if(!empty($this->input->post('film_hdpe_per_one'))){
              $this->form_validation->set_rules('film_hdpe_one','Film Hdpe' ,'trim|xss_clean|required');
            }

            //Layer Two

            $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|exact_length[3]');
            $this->form_validation->set_rules('film_masterbatch_two','Film Masterbatch Layer Two' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('film_mb_per_two','Film Masterbatch % Layer Two' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');

            if($this->input->post('film_masterbatch_two')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('film_mb_per_two','Film Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]');
            }
            
            $this->form_validation->set_rules('film_ldpe_per_two','Film Ldpe % Layer Two' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_two_check');
            $this->form_validation->set_rules('film_lldpe_per_two','Film Lldpe % Layer Two' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_two_check');
            $this->form_validation->set_rules('film_hdpe_per_two','Film Hdpe % Layer Two' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_two_check');

             if(!empty($this->input->post('film_ldpe_per_two'))){
                $this->form_validation->set_rules('film_ldpe_two','Film Ldpe Layer Two' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('film_lldpe_per_two'))){
                $this->form_validation->set_rules('film_lldpe_two','Film Lldpe Layer Two' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('film_hdpe_per_two'))){
                $this->form_validation->set_rules('film_hdpe_two','Film Hdpe Layer Two' ,'trim|xss_clean|required');
              }

            //Layer Three
            $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean|exact_length[2]');
            $this->form_validation->set_rules('film_admer_three','Film Admer Layer Three' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_admer_per_three','Film Admer % Layer Three' ,'trim|xss_clean|is_natural|exact_length[3]');
            $this->form_validation->set_rules('film_hdpe_three','Film Hdpe Three' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_hdpe_per_three','HDPE % Layer Three' ,'trim|xss_clean|is_natural|exact_length[3]');

            //Layer Four

            $this->form_validation->set_rules('gauge_four','Gauge Layer Four' ,'required|trim|xss_clean|exact_length[2]');
            $this->form_validation->set_rules('film_evoh_four','Film Evoh Layer Four' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_evoh_per_four','Film Evoh % Layer Four' ,'trim|xss_clean|is_natural|exact_length[3]');
            $this->form_validation->set_rules('film_hdpe_four','Film Hdpe Four' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_hdpe_per_four','HDPE % Layer Four' ,'trim|xss_clean|is_natural|exact_length[3]');


            //Layer Five

            $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|exact_length[2]');
            $this->form_validation->set_rules('film_admer_five','Film Admer Layer Five' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_admer_per_five','Film Admer % Layer Five' ,'trim|xss_clean|is_natural|exact_length[3]');
            $this->form_validation->set_rules('film_hdpe_five','Film Hdpe Five' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_hdpe_per_five','HDPE % Layer Five' ,'trim|xss_clean|is_natural|exact_length[3]');

            //Layer Six

            $this->form_validation->set_rules('gauge_six','Gauge Layer Six' ,'required|trim|xss_clean|exact_length[3]');
            $this->form_validation->set_rules('film_masterbatch_six','Film Masterbatch Layer Six' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('film_mb_per_six','Film Masterbatch % Layer Six' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');

            if($this->input->post('film_masterbatch_six')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('film_mb_per_six','Film Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]');
            }
            
            $this->form_validation->set_rules('film_ldpe_per_six','Film Ldpe % Layer Six' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_six_check');
            $this->form_validation->set_rules('film_lldpe_per_six','Film Lldpe % Layer Six' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_six_check');
            $this->form_validation->set_rules('film_hdpe_per_six','Film Hdpe % Layer Six' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_six_check');

             if(!empty($this->input->post('film_ldpe_per_six'))){
                $this->form_validation->set_rules('film_ldpe_six','Film Ldpe Layer Six' ,'trim|xss_clean|required');
              }
             if(!empty($this->input->post('film_lldpe_per_six'))){
                $this->form_validation->set_rules('film_lldpe_six','Film Lldpe Layer Six' ,'trim|xss_clean|required');
              }
              if(!empty($this->input->post('film_hdpe_per_six'))){
                $this->form_validation->set_rules('film_hdpe_six','Film Hdpe Layer Six' ,'trim|xss_clean|required');
              }

            //Layer Seven

            $this->form_validation->set_rules('gauge_seven','Gauge Seven' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('film_ldpe_per_seven','Film Ldpe Layer Seven %' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_seven_check');
            $this->form_validation->set_rules('film_lldpe_per_seven','Film Lldpe Layer Seven %' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_seven_check');
            $this->form_validation->set_rules('film_hdpe_per_seven','Film Hdpe Layer Seven %' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_seven_check');
            if(!empty($this->input->post('film_ldpe_per_seven'))){
              $this->form_validation->set_rules('film_ldpe_seven','Film Ldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('film_lldpe_per_seven'))){
              $this->form_validation->set_rules('film_lldpe_seven','Film Lldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('film_hdpe_per_seven'))){
              $this->form_validation->set_rules('film_hdpe_seven','Film hdpe' ,'trim|xss_clean|required');
            }

            
            

            if($this->form_validation->run()==FALSE){
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-seven-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
                $sleeve_dia[1]='';
              }

              if(!empty($this->input->post('sleeve_length'))){
                $sleeve_length="X".$this->input->post('sleeve_length')." 7 LAYER";
              }else{
                $sleeve_length='';
              }

              if(!empty($this->input->post('gauge_one'))){
                $gauge_one=$this->input->post('gauge_one')."MIC";
              }else{
                $gauge_one='';
              }


              if(!empty($this->input->post('film_ldpe_one')) && !empty($this->input->post('film_ldpe_per_one'))){

                $data['film_ldpe_one']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_ldpe_one'));
                if($data['film_ldpe_one']==FALSE){
                $film_ldpe_one="";
                }else{
                foreach($data['film_ldpe_one'] as $film_lldpe_row){
                  $film_ldpe_one=$film_lldpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_ldpe_per_one')) && $this->input->post('film_ldpe_per_one')!=0){
                  $film_ldpe_per_one=$this->input->post('film_ldpe_per_one')."%";
                }else{
                  $film_ldpe_per_one="";
                }

              }else{
                $film_ldpe_one='';
                $film_ldpe_per_one='';
              }

              if(!empty($this->input->post('film_lldpe_one')) && !empty($this->input->post('film_lldpe_per_one'))){

                $data['film_lldpe_one']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_lldpe_one'));
                if($data['film_lldpe_one']==FALSE){
                
                }else{
                foreach($data['film_lldpe_one'] as $film_lldpe_one_row){
                  $film_lldpe_one=$film_lldpe_one_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_lldpe_per_one')) && $this->input->post('film_lldpe_per_one')!=0){
                  $film_lldpe_per_one=$this->input->post('film_lldpe_per_one')."%";
                }else{
                  $film_lldpe_per_one="";
                }

              }else{
                $film_lldpe_one='';
                $film_lldpe_per_one='';
              }

              if(!empty($this->input->post('film_hdpe_one')) && !empty($this->input->post('film_hdpe_per_one'))){

                $data['film_hdpe_one']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_one'));
                if($data['film_hdpe_one']==FALSE){
                
                }else{
                foreach($data['film_hdpe_one'] as $film_hdpe_one_row){
                  $film_hdpe_one=$film_hdpe_one_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_one')) && $this->input->post('film_hdpe_per_one')!=0){
                  $film_hdpe_per_one=$this->input->post('film_hdpe_per_one')."%";
                }else{
                  $film_hdpe_per_one="";
                }

              }else{
                $film_hdpe_one='';
                $film_hdpe_per_one='';
              }



              if(!empty($this->input->post('gauge_two'))){
                $gauge_two=$this->input->post('gauge_two')."MIC";
              }else{
                $gauge_two='';
              }

              if(!empty($this->input->post('film_masterbatch_two'))){
              $data['film_masterbatch_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_masterbatch_two'));

                foreach($data['film_masterbatch_two'] as $film_masterbatch_two_row){
                  $film_masterbatch_two=$film_masterbatch_two_row->article_name;
                }
              }else{
                $film_masterbatch_two="";
              }

              if($this->input->post('film_mb_per_two')!=''){
                  $film_mb_per_two=$this->input->post('film_mb_per_two')."%";
              }else{
                $film_mb_per_two="";
              }


              if(!empty($this->input->post('film_ldpe_two')) && !empty($this->input->post('film_ldpe_per_two'))){

                $data['film_ldpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_ldpe_two'));
                if($data['film_ldpe_two']==FALSE){
                
                }else{
                foreach($data['film_ldpe_two'] as $film_ldpe_two_row){
                  $film_ldpe_two=$film_ldpe_two_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_ldpe_per_two')) && $this->input->post('film_ldpe_per_two')!=0){
                  $film_ldpe_per_two=$this->input->post('film_ldpe_per_two')."%";
                }else{
                  $film_ldpe_per_two="";
                }

              }else{
                $film_ldpe_two='';
                $film_ldpe_per_two='';
              }


              if(!empty($this->input->post('film_lldpe_two')) && !empty($this->input->post('film_lldpe_per_two'))){

                $data['film_lldpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_lldpe_two'));
                if($data['film_lldpe_two']==FALSE){
                
                }else{
                foreach($data['film_lldpe_two'] as $film_lldpe_two_row){
                  $film_lldpe_two=$film_lldpe_two_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_lldpe_per_two')) && $this->input->post('film_lldpe_per_two')!=0){
                  $film_lldpe_per_two=$this->input->post('film_lldpe_per_two')."%";
                }else{
                  $film_lldpe_per_two="";
                }

              }else{
                $film_lldpe_two='';
                $film_lldpe_per_two='';
              }

              if(!empty($this->input->post('film_hdpe_two')) && !empty($this->input->post('film_hdpe_per_two'))){

                $data['film_hdpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_two'));
                if($data['film_hdpe_two']==FALSE){
                $film_hdpe_two="";
                }else{
                foreach($data['film_hdpe_two'] as $film_hdpe_two_row){
                  $film_hdpe_two=$film_hdpe_two_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_two')) && $this->input->post('film_hdpe_per_two')!=0){
                  $film_hdpe_per_two=$this->input->post('film_hdpe_per_two')."%";
                }else{
                  $film_hdpe_per_two="";
                }

              }else{
                $film_hdpe_two='';
                $film_hdpe_per_two='';
              }

              if(!empty($this->input->post('gauge_three'))){
                $gauge_three=$this->input->post('gauge_three')."MIC";
              }else{
                $gauge_three='';
              }

              if(!empty($this->input->post('film_admer_three')) && !empty($this->input->post('film_admer_per_three'))){

                $data['film_admer_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_admer_three'));
                if($data['film_admer_three']==FALSE){
                
                }else{
                foreach($data['film_admer_three'] as $film_admer_three_row){
                  $film_admer_three=$film_admer_three_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_admer_per_three')) && $this->input->post('film_admer_per_three')!=0){
                  $film_admer_per_three=$this->input->post('film_admer_per_three')."%";
                }else{
                  $film_admer_per_three="";
                }

              }else{
                $film_admer_three='';
                $film_admer_per_three='';
              }

              if(!empty($this->input->post('film_hdpe_three')) && !empty($this->input->post('film_hdpe_per_three'))){

                $data['film_hdpe_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_three'));
                if($data['film_hdpe_three']==FALSE){
                
                }else{
                foreach($data['film_hdpe_three'] as $film_hdpe_three_row){
                  $film_hdpe_three=$film_admer_three_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_three')) && $this->input->post('film_hdpe_per_three')!=0){
                  $film_hdpe_per_three=$this->input->post('film_hdpe_per_three')."%";
                }else{
                  $film_hdpe_per_three="";
                }

              }else{
                $film_hdpe_three='';
                $film_hdpe_per_three='';
              }

              if(!empty($this->input->post('gauge_four'))){
                $gauge_four=$this->input->post('gauge_four')."MIC";
              }else{
                $gauge_four='';
              }

              if(!empty($this->input->post('film_evoh_four')) && !empty($this->input->post('film_evoh_per_four'))){

                $data['film_evoh_four']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_evoh_four'));
                if($data['film_evoh_four']==FALSE){
                $film_evoh_four="";
                }else{
                foreach($data['film_evoh_four'] as $film_evoh_four_row){
                  $film_evoh_four=$film_evoh_four_row->article_name;
                  }
                }
                if(!empty($this->input->post('film_evoh_per_four')) && $this->input->post('film_evoh_per_four')!=0){
                  $film_evoh_per_four=$this->input->post('film_evoh_per_four')."%";
                }else{
                  $film_evoh_per_four="";
                }
                
              }else{
                $film_evoh_four='';
                $film_evoh_per_four='';
              }


              if(!empty($this->input->post('film_hdpe_four')) && !empty($this->input->post('film_hdpe_per_four'))){

                $data['film_hdpe_four']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_four'));
                if($data['film_hdpe_four']==FALSE){
                
                }else{
                foreach($data['film_hdpe_four'] as $film_hdpe_four_row){
                  $film_hdpe_four=$film_admer_four_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_four')) && $this->input->post('film_hdpe_per_four')!=0){
                  $film_hdpe_per_four=$this->input->post('film_hdpe_per_four')."%";
                }else{
                  $film_hdpe_per_four="";
                }

              }else{
                $film_hdpe_four='';
                $film_hdpe_per_four='';
              }



             if(!empty($this->input->post('sl_admer_four')) && !empty($this->input->post('sl_admer_per_four'))){

                $data['sl_admer_four']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_admer_four'));
                if($data['sl_admer_four']==FALSE){
                
                }else{
                foreach($data['sl_admer_four'] as $sl_admer_four_row){
                  $sl_admer_four=$sl_admer_four_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_admer_per_four')) && $this->input->post('sl_admer_per_four')!=0){
                  $sl_admer_per_four=$this->input->post('sl_admer_per_four')."%";
                }else{
                  $sl_admer_per_four="";
                }

              }else{
                $sl_admer_four='';
                $sl_admer_per_four='';
              }


              if(!empty($this->input->post('film_hdpe_five')) && !empty($this->input->post('film_hdpe_per_five'))){

                $data['film_hdpe_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_five'));
                if($data['film_hdpe_five']==FALSE){
                
                }else{
                foreach($data['film_hdpe_five'] as $film_hdpe_five_row){
                  $film_hdpe_five=$film_admer_five_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_five')) && $this->input->post('film_hdpe_per_five')!=0){
                  $film_hdpe_per_five=$this->input->post('film_hdpe_per_five')."%";
                }else{
                  $film_hdpe_per_five="";
                }

              }else{
                $film_hdpe_five='';
                $film_hdpe_per_five='';
              }


              if(!empty($this->input->post('gauge_five'))){
                $gauge_five=$this->input->post('gauge_five')."MIC";
              }else{
                $gauge_five='';
              }

              if(!empty($this->input->post('film_admer_five')) && !empty($this->input->post('film_admer_per_five'))){

                $data['film_admer_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_admer_five'));
                if($data['film_admer_five']==FALSE){
                
                }else{
                foreach($data['film_admer_five'] as $film_admer_five_row){
                  $film_admer_five=$film_admer_five_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_admer_per_five')) && $this->input->post('film_admer_per_five')!=0){
                  $film_admer_per_five=$this->input->post('film_admer_per_five')."%";
                }else{
                  $film_admer_per_five="";
                }

              }else{
                $film_admer_five='';
                $film_admer_per_five='';
              }

              if(!empty($this->input->post('gauge_six'))){
                $gauge_six=$this->input->post('gauge_six')."MIC";
              }else{
                $gauge_six='';
              }

              if(!empty($this->input->post('film_masterbatch_six'))){
              $data['film_masterbatch_six']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_masterbatch_six'));

                foreach($data['film_masterbatch_six'] as $film_masterbatch_six_row){
                  $film_masterbatch_six=$film_masterbatch_six_row->article_name;
                }
              }else{
                $film_masterbatch_six="";
              }

              if($this->input->post('film_mb_per_six')!=''){
                  $film_mb_per_six=$this->input->post('film_mb_per_six')."%";
              }else{
                $film_mb_per_six="";
              }


              if(!empty($this->input->post('film_ldpe_six')) && !empty($this->input->post('film_ldpe_per_six'))){

                $data['film_ldpe_six']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_ldpe_six'));
                if($data['film_ldpe_six']==FALSE){
                
                }else{
                foreach($data['film_ldpe_six'] as $film_ldpe_six_row){
                  $film_ldpe_six=$film_ldpe_six_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_ldpe_per_six')) && $this->input->post('film_ldpe_per_six')!=0){
                  $film_ldpe_per_six=$this->input->post('film_ldpe_per_six')."%";
                }else{
                  $film_ldpe_per_six="";
                }

              }else{
                $film_ldpe_six='';
                $film_ldpe_per_six='';
              }


              if(!empty($this->input->post('film_lldpe_six')) && !empty($this->input->post('film_lldpe_per_six'))){

                $data['film_lldpe_six']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_lldpe_six'));
                if($data['film_lldpe_six']==FALSE){
                
                }else{
                foreach($data['film_lldpe_six'] as $film_lldpe_six_row){
                  $film_lldpe_six=$film_lldpe_six_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_lldpe_per_six')) && $this->input->post('film_lldpe_per_six')!=0){
                  $film_lldpe_per_six=$this->input->post('film_lldpe_per_six')."%";
                }else{
                  $film_lldpe_per_six="";
                }

              }else{
                $film_lldpe_six='';
                $film_lldpe_per_six='';
              }

              if(!empty($this->input->post('film_hdpe_six')) && !empty($this->input->post('film_hdpe_per_two'))){

                $data['film_hdpe_six']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_six'));
                if($data['film_hdpe_six']==FALSE){
                $film_hdpe_six="";
                }else{
                foreach($data['film_hdpe_six'] as $film_hdpe_six_row){
                  $film_hdpe_six=$film_hdpe_six_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_six')) && $this->input->post('film_hdpe_per_six')!=0){
                  $film_hdpe_per_six=$this->input->post('film_hdpe_per_six')."%";
                }else{
                  $film_hdpe_per_six="";
                }

              }else{
                $film_hdpe_six='';
                $film_hdpe_per_six='';
              }
              
              if(!empty($this->input->post('gauge_seven'))){
                $gauge_seven=$this->input->post('gauge_seven')."MIC";
              }else{
                $gauge_seven='';
              }


              if(!empty($this->input->post('film_ldpe_seven')) && !empty($this->input->post('film_ldpe_per_seven'))){

                $data['film_ldpe_seven']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_ldpe_seven'));
                if($data['film_ldpe_seven']==FALSE){
                $film_ldpe_seven="";
                }else{
                foreach($data['film_ldpe_seven'] as $film_ldpe_seven_row){
                  $film_ldpe_seven=$film_ldpe_seven_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_ldpe_per_seven')) && $this->input->post('film_ldpe_per_seven')!=0){
                  $film_ldpe_per_seven=$this->input->post('film_ldpe_per_seven')."%";
                }else{
                  $film_ldpe_per_seven="";
                }

              }else{
                $film_ldpe_seven='';
                $film_ldpe_per_seven='';
              }

              if(!empty($this->input->post('film_lldpe_seven')) && !empty($this->input->post('film_lldpe_per_seven'))){

                $data['film_lldpe_seven']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_lldpe_seven'));
                if($data['film_lldpe_seven']==FALSE){
                
                }else{
                foreach($data['film_lldpe_seven'] as $film_lldpe_seven_row){
                  $film_lldpe_seven=$film_lldpe_seven_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_lldpe_per_seven')) && $this->input->post('film_lldpe_per_seven')!=0){
                  $film_lldpe_per_seven=$this->input->post('film_lldpe_per_seven')."%";
                }else{
                  $film_lldpe_per_seven="";
                }

              }else{
                $film_lldpe_seven='';
                $film_lldpe_per_seven='';
              }


              if(!empty($this->input->post('film_hdpe_seven')) && !empty($this->input->post('film_hdpe_per_seven'))){

                $data['film_hdpe_seven']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_seven'));
                if($data['film_hdpe_seven']==FALSE){
                
                }else{
                foreach($data['film_hdpe_seven'] as $film_hdpe_seven_row){
                  $film_hdpe_seven=$film_hdpe_seven_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_seven')) && $this->input->post('film_hdpe_per_seven')!=0){
                  $film_hdpe_per_seven=$this->input->post('film_hdpe_per_seven')."%";
                }else{
                  $film_hdpe_per_seven="";
                }

              }else{
                $film_hdpe_seven='';
                $film_hdpe_per_seven='';
              }
              

              $article_description=$sleeve_dia[0]."".$sleeve_length." ".$gauge_one." ".$film_ldpe_one." ".$film_ldpe_per_one."  ".$film_lldpe_one." ".$film_lldpe_per_one." ".$film_hdpe_one." ".$film_hdpe_per_one." ".$gauge_two." ".$film_masterbatch_two." ".$film_mb_per_two." ".$film_ldpe_two." ".$film_ldpe_per_two." ".$film_lldpe_two." ".$film_lldpe_per_two." ".$film_hdpe_two." ".$film_hdpe_per_two." ".$gauge_three." ".$film_admer_three." ".$film_admer_per_three." ".$film_hdpe_three." ".$film_hdpe_per_three." ".$gauge_four." ".$film_evoh_four." ".$film_evoh_per_four." ".$film_hdpe_four." ".$film_hdpe_per_four." ".$gauge_five." ".$film_admer_five." ".$film_admer_per_five." ".$film_hdpe_five." ".$film_hdpe_per_five." ".$gauge_six." ".$film_masterbatch_six." ".$film_mb_per_six." ".$film_ldpe_six." ".$film_ldpe_per_six." ".$film_lldpe_six." ".$film_lldpe_per_six." ".$film_hdpe_six." ".$film_hdpe_per_six." ".$gauge_seven." ".$film_ldpe_seven." ".$film_ldpe_per_seven." ".$film_lldpe_seven." ".$film_lldpe_per_seven." ".$film_hdpe_seven." ".$film_hdpe_per_seven;

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                      if($data['article']==FALSE){

                        $article_no=$this->main_group_article($this->input->post('main_group'));

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999',
                              'article_no'=>$article_no,
                              'uom'=>'UOM004',
                              'sales_purchase_flag'=>'2',
                              'spec_item_flag'=>'1',
                              'archive'=>'0',
                              'article_date'=>date('Y-m-d'), 
                              'article_modified_date'=>date('Y-m-d')
                            );

                        $result=$this->common_model->save('article',$data);

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'language_id'=>$this->session->userdata['logged_in']['language_id'],
                              'article_no'=>$article_no,
                              'lang_article_description'=>$article_description,
                              'lang_sub_description'=>'',
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999');

                        $result=$this->common_model->save('article_name_info',$data);

                        $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','1244');
                        $no="";
                        foreach ($data['auto'] as $auto_row) {

                          $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                          foreach($data['account_periods'] as $account_periods_row){
                            $start=date('y', strtotime($account_periods_row->fin_year_start));
                            $end=date('y', strtotime($account_periods_row->fin_year_end));
                          }
                          $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                          $spec_no=$auto_row->textcode.$no;
                          $next_spec_no=$auto_row->curr_val+1;
                        }
                        $data=array('curr_val'=>$next_spec_no);
                        $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','1244',$this->session->userdata['logged_in']['company_id']);
                        $spec_version_no='1';

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'spec_id'=>$spec_no,
                              'spec_created_date'=>date('Y-m-d'),
                              'spec_version_no'=>$spec_version_no,
                              'adr_company_id'=>'',
                              'article_no'=>$article_no,
                              'pending_flag'=>'0',
                              'final_approval_flag'=>'0',
                              'user_id'=>$this->session->userdata['logged_in']['user_id'],
                              'dyn_qty_present'=>'FILM|7',
                              );

                        $result=$this->common_model->save('specification_sheet',$data);


                        

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_one'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LDPE',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_ldpe_per_one'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('film_ldpe_one'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'170',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LLDPE',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_lldpe_per_one'),
                'mat_article_no'=>$this->input->post('film_lldpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              //HDPE
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'171',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_hdpe_per_one'),
                'mat_article_no'=>$this->input->post('film_hdpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_two'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $film_mb_per_two=$this->input->post('film_mb_per_two');
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$film_mb_per_two,
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('film_masterbatch_two'),
                'srd_id'=>'2_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LDPE',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_ldpe_per_two'),
                'mat_article_no'=>$this->input->post('film_ldpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'170',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LLDPE',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_lldpe_per_two'),
                'mat_article_no'=>$this->input->post('film_lldpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'171',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_hdpe_per_two'),
                'mat_article_no'=>$this->input->post('film_hdpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'172',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_three'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'173',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'ADMER',
                'material'=>'1',
                'item_group_material'=>'15',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_admer_per_three'),
                'mat_article_no'=>$this->input->post('film_admer_three'),
                'property_id'=>'',
                'srd_id'=>'3_6_4',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'200',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_hdpe_per_three'),
                'mat_article_no'=>$this->input->post('film_hdpe_three'),
                'property_id'=>'',
                'srd_id'=>'3_6_5',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);
            


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'174',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_four'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'4',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'175',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'EVOH',
                'material'=>'1',
                'item_group_material'=>'16',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_evoh_per_four'),
                'mat_article_no'=>$this->input->post('film_evoh_four'),
                'property_id'=>'',
                'srd_id'=>'4_6_3',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'4',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'201',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_hdpe_per_four'),
                'mat_article_no'=>$this->input->post('film_hdpe_four'),
                'property_id'=>'',
                'srd_id'=>'4_6_4',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'4',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_five'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'177',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'ADMER',
                'material'=>'1',
                'item_group_material'=>'15',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_admer_per_five'),
                'mat_article_no'=>$this->input->post('film_admer_five'),
                'property_id'=>'',
                'srd_id'=>'5_6_4',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'202',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_hdpe_per_five'),
                'mat_article_no'=>$this->input->post('film_hdpe_five'),
                'property_id'=>'',
                'srd_id'=>'5_6_5',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'178',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_six'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'6_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'6',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'6');
              $result=$this->common_model->save('specification_sheet_details',$data);

               $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'179',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_mb_per_six'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('film_masterbatch_six'),
                'srd_id'=>'6_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'6',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'6');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'180',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LDPE',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_ldpe_per_six'),
                'mat_article_no'=>$this->input->post('film_ldpe_six'),
                'property_id'=>'',
                'srd_id'=>'6_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'6',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'6');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'181',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LLDPE',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_lldpe_per_six'),
                'mat_article_no'=>$this->input->post('film_lldpe_six'),
                'property_id'=>'',
                'srd_id'=>'6_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'6',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'6');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'182',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_hdpe_per_six'),
                'mat_article_no'=>$this->input->post('film_hdpe_six'),
                'property_id'=>'',
                'srd_id'=>'6_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'6',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'6');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'183',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_seven'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'7_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'7',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'7');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'184',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LDPE',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_ldpe_per_seven'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('film_ldpe_seven'),
                'srd_id'=>'7_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'7');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LLDPE',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_lldpe_per_seven'),
                'mat_article_no'=>$this->input->post('film_lldpe_seven'),
                'property_id'=>'',
                'srd_id'=>'7_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'7',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'7');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'186',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('film_hdpe_per_seven'),
                'mat_article_no'=>$this->input->post('film_hdpe_seven'),
                'property_id'=>'',
                'srd_id'=>'7_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'7',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'7');
              $result=$this->common_model->save('specification_sheet_details',$data);


              /*$data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'spec_id'=>$spec_no,
                        'lang_comments'=>$this->input->post('comment'),
                        'language_id'=>$this->session->userdata['logged_in']['language_id'],
                        'spec_version_no'=>$spec_version_no);
              $result=$this->common_model->save('specification_sheet_lang',$data);*/

              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

               if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$spec_no,'spec_version_no',$spec_version_no,$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$spec_no.'@@@'.$spec_version_no);
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$spec_no.'@@@'.$spec_version_no);

                      $result=$this->common_model->save('followup',$data);
                      $data['note']='Create Transaction Completed';
                      $data['error']='Sent For Approval';
                      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }

            }else{
             $data['error']='Same Flim alerdy Exist';
          }

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              
                  $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
                  $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-seven-form',$data);
                  $this->load->view('Home/footer');
              
            }
          }else{
            $data['note']='No New rights Thanks';
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }
        }
      }
    }
  }
  else{
      $data['note']='No rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }



  function modify_seven_layer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['specification']=$this->sleeve_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
            $this->load->view(ucwords($this->router->fetch_class()).'/modify-seven-form',$data);
            $this->load->view('Home/footer');

          }else{
              $data['note']='No Modify rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
          }
        }
      }
    }
  }else{
      $data['note']='No Modify rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }



  function update_seven_layer(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

            //$this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|max_length[5]');
            
            //Layer ONe

            $this->form_validation->set_rules('gauge_one','Gauge One' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('film_ldpe_per_one','Film Ldpe Layer One %' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_one_check');
            $this->form_validation->set_rules('film_lldpe_per_one','Film Lldpe Layer One %' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_one_check');
            $this->form_validation->set_rules('film_hdpe_per_one','Film Hdpe Layer One %' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_one_check');
            if(!empty($this->input->post('film_ldpe_per_one'))){
              $this->form_validation->set_rules('film_ldpe_one','Film Ldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('film_lldpe_per_one'))){
              $this->form_validation->set_rules('film_lldpe_one','Film Lldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('film_hdpe_per_one'))){
              $this->form_validation->set_rules('film_hdpe_one','Film Hdpe' ,'trim|xss_clean|required');
            }

            //Layer Two

            $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|exact_length[3]|is_natural');
            $this->form_validation->set_rules('film_masterbatch_two','Film Masterbatch Layer Two' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('film_mb_per_two','Film Masterbatch % Layer Two' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');

            if($this->input->post('film_masterbatch_two')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('film_mb_per_two','Film Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]');
            }
            
            $this->form_validation->set_rules('film_ldpe_per_two','Film Ldpe % Layer Two' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_two_check');

            $this->form_validation->set_rules('film_lldpe_per_two','Film Lldpe % Layer Two' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_two_check');
            $this->form_validation->set_rules('film_hdpe_per_two','Film Hdpe % Layer Two' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_two_check');

            if(!empty($this->input->post('film_ldpe_per_two'))){
                $this->form_validation->set_rules('film_ldpe_two','Film Ldpe Layer Two' ,'trim|xss_clean|required');
              }
             if(!empty($this->input->post('film_lldpe_per_two'))){
                $this->form_validation->set_rules('film_lldpe_two','Film Lldpe Layer Two' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('film_hdpe_per_two'))){
                $this->form_validation->set_rules('film_hdpe_two','Film Hdpe Layer Two' ,'trim|xss_clean|required');
              }

            //Layer Three
            $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean|exact_length[2]|is_natural');
            $this->form_validation->set_rules('film_admer_three','Film Admer Layer Three' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_admer_per_three','Film Admer % Layer Three' ,'trim|xss_clean|is_natural|exact_length[3]');
            $this->form_validation->set_rules('film_hdpe_three','Film Hdpe Layer Three' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_hdpe_per_three','Film Hdpe % Layer Three' ,'trim|xss_clean|is_natural|exact_length[3]');

            //Layer Four

            $this->form_validation->set_rules('film_evoh_four','Film Evoh Layer Four' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_evoh_per_four','Film Evoh % Layer Four' ,'trim|xss_clean|is_natural|exact_length[3]');
            $this->form_validation->set_rules('film_hdpe_four','Film Hdpe Layer Four' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_hdpe_per_four','Film Hdpe % Layer Four' ,'trim|xss_clean|is_natural|exact_length[3]');



            //Layer Five

            $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|exact_length[2]|is_natural');
            $this->form_validation->set_rules('film_admer_five','Film Admer Layer Five' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_admer_per_five','Film Admer % Layer Five' ,'trim|xss_clean|is_natural|exact_length[3]');
            $this->form_validation->set_rules('film_hdpe_five','Film Hdpe Layer Five' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_hdpe_per_five','Film Hdpe % Layer Five' ,'trim|xss_clean|is_natural|exact_length[3]');


            //Layer Six

            $this->form_validation->set_rules('gauge_six','Gauge Layer Six' ,'required|trim|xss_clean|exact_length[3]|is_natural');
            $this->form_validation->set_rules('film_masterbatch_six','Film Masterbatch Layer Six' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('film_mb_per_six','Film Masterbatch % Layer Six' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');

            if($this->input->post('film_masterbatch_six')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('film_mb_per_six','Film Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]');
            }

            $this->form_validation->set_rules('film_ldpe_per_six','Film Ldpe % Layer Six' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_six_check');
            $this->form_validation->set_rules('film_lldpe_per_six','Film Lldpe % Layer Six' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_six_check');
            $this->form_validation->set_rules('film_hdpe_per_six','Film Hdpe % Layer Six' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_six_check');

            if(!empty($this->input->post('film_ldpe_per_six'))){
                $this->form_validation->set_rules('film_ldpe_six','Film Ldpe Layer Six' ,'trim|xss_clean|required');
              }
             if(!empty($this->input->post('film_lldpe_per_six'))){
                $this->form_validation->set_rules('film_lldpe_six','Film Lldpe Layer Six' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('film_hdpe_per_six'))){
                $this->form_validation->set_rules('film_hdpe_six','Film Hdpe Layer Six' ,'trim|xss_clean|required');
              }

            //Layer Seven

            $this->form_validation->set_rules('gauge_seven','Gauge Seven' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('film_ldpe_per_seven','Film Ldpe Layer Seven %' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_seven_check');
            $this->form_validation->set_rules('film_lldpe_per_seven','Film Lldpe Layer Seven %' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_seven_check');
            $this->form_validation->set_rules('film_hdpe_per_seven','Film hdpe Layer Seven %' ,'trim|xss_clean|is_natural|max_length[3]|callback_film_per_seven_check');
            
            if(!empty($this->input->post('film_ldpe_per_seven'))){
              $this->form_validation->set_rules('film_ldpe_seven','Film Ldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('film_lldpe_per_seven'))){
              $this->form_validation->set_rules('film_lldpe_seven','Film Lldpe' ,'trim|xss_clean|required');
            }
            if(!empty($this->input->post('film_hdpe_per_seven'))){
              $this->form_validation->set_rules('film_hdpe_seven','Film Hdpe' ,'trim|xss_clean|required');
            }

              

              if($this->form_validation->run()==FALSE){

                $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
                $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['specification']=$this->tube_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-seven-form',$data);
                $this->load->view('Home/footer');

              }else{

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
                $sleeve_dia[1]='';
              }

              if(!empty($this->input->post('sleeve_length'))){
                $sleeve_length="X".$this->input->post('sleeve_length')." 7 LAYER";
              }else{
                $sleeve_length='';
              }

              if(!empty($this->input->post('gauge_one'))){
                $gauge_one=$this->input->post('gauge_one')."MIC";
              }else{
                $gauge_one='';
              }


              if(!empty($this->input->post('film_ldpe_one')) && !empty($this->input->post('film_ldpe_per_one'))){

                $data['film_ldpe_one']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_ldpe_one'));
                if($data['film_ldpe_one']==FALSE){
                $film_ldpe_one="";
                }else{
                foreach($data['film_ldpe_one'] as $film_ldpe_row){
                  $film_ldpe_one=$film_ldpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_ldpe_per_one')) && $this->input->post('film_ldpe_per_one')!=0){
                  $film_ldpe_per_one=$this->input->post('film_ldpe_per_one')."%";
                }else{
                  $film_ldpe_per_one="";
                }

              }else{
                $film_ldpe_one='';
                $film_ldpe_per_one='';
              }

              if(!empty($this->input->post('film_lldpe_one')) && !empty($this->input->post('film_lldpe_per_one'))){

                $data['film_lldpe_one']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_lldpe_one'));
                if($data['film_lldpe_one']==FALSE){
                
                }else{
                foreach($data['film_lldpe_one'] as $film_lldpe_one_row){
                  $film_lldpe_one=$film_lldpe_one_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_lldpe_per_one')) && $this->input->post('film_lldpe_per_one')!=0){
                  $film_lldpe_per_one=$this->input->post('film_lldpe_per_one')."%";
                }else{
                  $film_lldpe_per_one="";
                }

              }else{
                $film_lldpe_one='';
                $film_lldpe_per_one='';
              }


              if(!empty($this->input->post('film_hdpe_one')) && !empty($this->input->post('film_hdpe_per_one'))){

                $data['film_hdpe_one']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_one'));
                if($data['film_hdpe_one']==FALSE){
                
                }else{
                foreach($data['film_hdpe_one'] as $film_hdpe_one_row){
                  $film_hdpe_one=$film_hdpe_one_row->article_name;
                  }
                }

              if(!empty($this->input->post('film_hdpe_per_one')) && $this->input->post('film_hdpe_per_one')!=0){
                  $film_hdpe_per_one=$this->input->post('film_hdpe_per_one')."%";
              }else{
                  $film_hdpe_per_one="";
              }

              }else{
                $film_hdpe_one='';
                $film_hdpe_per_one='';
              }



              if(!empty($this->input->post('gauge_two'))){
                $gauge_two=$this->input->post('gauge_two')."MIC";
              }else{
                $gauge_two='';
              }

              if(!empty($this->input->post('film_masterbatch_two'))){
              $data['film_masterbatch_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_masterbatch_two'));

                foreach($data['film_masterbatch_two'] as $film_masterbatch_two_row){
                  $film_masterbatch_two=$film_masterbatch_two_row->article_name;
                }
              }else{
                $film_masterbatch_two="";
              }

              if($this->input->post('film_mb_per_two')!=''){
                  $film_mb_per_two=$this->input->post('film_mb_per_two')."%";
              }else{
                $film_mb_per_two="";
              }


              if(!empty($this->input->post('film_ldpe_two')) && !empty($this->input->post('film_ldpe_per_two'))){

                $data['film_ldpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_ldpe_two'));
                if($data['film_ldpe_two']==FALSE){
                  $film_ldpe_two="";
                }else{
                foreach($data['film_ldpe_two'] as $film_ldpe_row){
                  $film_ldpe_two=$film_ldpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_ldpe_per_two')) && $this->input->post('film_ldpe_per_two')!=0){
                  $film_ldpe_per_two=$this->input->post('film_ldpe_per_two')."%";
                }else{
                  $film_ldpe_per_two="";
                }

              }else{
                $film_ldpe_two='';
                $film_ldpe_per_two='';
              }


              if(!empty($this->input->post('film_lldpe_two')) && !empty($this->input->post('film_lldpe_per_two'))){

                $data['film_lldpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_lldpe_two'));
                if($data['film_lldpe_two']==FALSE){
                
                }else{
                foreach($data['film_lldpe_two'] as $film_lldpe_two_row){
                  $film_lldpe_two=$film_lldpe_two_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_lldpe_per_two')) && $this->input->post('film_lldpe_per_two')!=0){
                  $film_lldpe_per_two=$this->input->post('film_lldpe_per_two')."%";
                }else{
                  $film_lldpe_per_two="";
                }

              }else{
                $film_lldpe_two='';
                $film_lldpe_per_two='';
              }

              if(!empty($this->input->post('film_hdpe_two')) && !empty($this->input->post('film_hdpe_per_two'))){

                $data['film_hdpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_two'));
                if($data['film_hdpe_two']==FALSE){
                $film_hdpe_two="";
                }else{
                foreach($data['film_hdpe_two'] as $film_hdpe_two_row){
                  $film_hdpe_two=$film_hdpe_two_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_two')) && $this->input->post('film_hdpe_per_two')!=0){
                  $film_hdpe_per_two=$this->input->post('film_hdpe_per_two')."%";
                }else{
                  $film_hdpe_per_two="";
                }

              }else{
                $film_hdpe_two='';
                $film_hdpe_per_two='';
              }

              if(!empty($this->input->post('gauge_three'))){
                $gauge_three=$this->input->post('gauge_three')."MIC";
              }else{
                $gauge_three='';
              }

              if(!empty($this->input->post('film_admer_three')) && !empty($this->input->post('film_admer_per_three'))){

                $data['film_admer_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_admer_three'));
                if($data['film_admer_three']==FALSE){
                
                }else{
                foreach($data['film_admer_three'] as $film_admer_three_row){
                  $film_admer_three=$film_admer_three_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_admer_per_three')) && $this->input->post('film_admer_per_three')!=0){
                  $film_admer_per_three=$this->input->post('film_admer_per_three')."%";
                }else{
                  $film_admer_per_three="";
                }

              }else{
                $film_admer_three='';
                $film_admer_per_three='';
              }

              if(!empty($this->input->post('film_hdpe_three')) && !empty($this->input->post('film_hdpe_per_three'))){

                $data['film_hdpe_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_three'));
                if($data['film_hdpe_three']==FALSE){
                $film_hdpe_three="";
                }else{
                foreach($data['film_hdpe_three'] as $film_hdpe_three_row){
                  $film_hdpe_three=$film_hdpe_three_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_three')) && $this->input->post('film_hdpe_per_three')!=0){
                  $film_hdpe_per_three=$this->input->post('film_hdpe_per_three')."%";
                }else{
                  $film_hdpe_per_three="";
                }

              }else{
                $film_hdpe_three='';
                $film_hdpe_per_three='';
              }



              if(!empty($this->input->post('gauge_four'))){
                $gauge_four=$this->input->post('gauge_four')."MIC";
              }else{
                $gauge_four='';
              }

              if(!empty($this->input->post('film_evoh_four')) && !empty($this->input->post('film_evoh_per_four'))){

                $data['film_evoh_four']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_evoh_four'));
                if($data['film_evoh_four']==FALSE){
                $film_evoh_four="";
                }else{
                foreach($data['film_evoh_four'] as $film_evoh_four_row){
                  $film_evoh_four=$film_evoh_four_row->article_name;
                  }
                }
                if(!empty($this->input->post('film_evoh_per_four')) && $this->input->post('film_evoh_per_four')!=0){
                  $film_evoh_per_four=$this->input->post('film_evoh_per_four')."%";
                }else{
                  $film_evoh_per_four="";
                }
                
              }else{
                $film_evoh_four='';
                $film_evoh_per_four='';
              }

              if(!empty($this->input->post('film_hdpe_four')) && !empty($this->input->post('film_hdpe_per_four'))){

                $data['film_hdpe_four']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_four'));
                if($data['film_hdpe_four']==FALSE){
                $film_hdpe_four="";
                }else{
                foreach($data['film_hdpe_four'] as $film_hdpe_four_row){
                  $film_hdpe_four=$film_hdpe_four_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_four')) && $this->input->post('film_hdpe_per_four')!=0){
                  $film_hdpe_per_four=$this->input->post('film_hdpe_per_four')."%";
                }else{
                  $film_hdpe_per_four="";
                }

              }else{
                $film_hdpe_four='';
                $film_hdpe_per_four='';
              }



             if(!empty($this->input->post('sl_admer_four')) && !empty($this->input->post('sl_admer_per_four'))){

                $data['sl_admer_four']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_admer_four'));
                if($data['sl_admer_four']==FALSE){
                
                }else{
                foreach($data['sl_admer_four'] as $sl_admer_four_row){
                  $sl_admer_four=$sl_admer_four_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_admer_per_four')) && $this->input->post('sl_admer_per_four')!=0){
                  $sl_admer_per_four=$this->input->post('sl_admer_per_four')."%";
                }else{
                  $sl_admer_per_four="";
                }

              }else{
                $sl_admer_four='';
                $sl_admer_per_four='';
              }


              if(!empty($this->input->post('gauge_five'))){
                $gauge_five=$this->input->post('gauge_five')."MIC";
              }else{
                $gauge_five='';
              }

              if(!empty($this->input->post('film_admer_five')) && !empty($this->input->post('film_admer_per_five'))){

                $data['film_admer_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_admer_five'));
                if($data['film_admer_five']==FALSE){
                
                }else{
                foreach($data['film_admer_five'] as $film_admer_five_row){
                  $film_admer_five=$film_admer_five_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_admer_per_five')) && $this->input->post('film_admer_per_five')!=0){
                  $film_admer_per_five=$this->input->post('film_admer_per_five')."%";
                }else{
                  $film_admer_per_five="";
                }

              }else{
                $film_admer_five='';
                $film_admer_per_five='';
              }


              if(!empty($this->input->post('film_hdpe_five')) && !empty($this->input->post('film_hdpe_per_five'))){

                $data['film_hdpe_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_five'));
                if($data['film_hdpe_five']==FALSE){
                $film_hdpe_five="";
                }else{
                foreach($data['film_hdpe_five'] as $film_hdpe_five_row){
                  $film_hdpe_five=$film_hdpe_five_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_five')) && $this->input->post('film_hdpe_per_five')!=0){
                  $film_hdpe_per_five=$this->input->post('film_hdpe_per_five')."%";
                }else{
                  $film_hdpe_per_five="";
                }

              }else{
                $film_hdpe_five='';
                $film_hdpe_per_five='';
              }

              if(!empty($this->input->post('gauge_six'))){
                $gauge_six=$this->input->post('gauge_six')."MIC";
              }else{
                $gauge_six='';
              }

              if(!empty($this->input->post('film_masterbatch_six'))){
              $data['film_masterbatch_six']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_masterbatch_six'));

                foreach($data['film_masterbatch_six'] as $film_masterbatch_six_row){
                  $film_masterbatch_six=$film_masterbatch_six_row->article_name;
                }
              }else{
                $film_masterbatch_six="";
              }

              if($this->input->post('film_mb_per_six')!=''){
                  $film_mb_per_six=$this->input->post('film_mb_per_six')."%";
              }else{
                $film_mb_per_six="";
              }


              if(!empty($this->input->post('film_ldpe_six')) && !empty($this->input->post('film_ldpe_per_six'))){

                $data['film_ldpe_six']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_ldpe_six'));
                if($data['film_ldpe_six']==FALSE){
                
                }else{
                foreach($data['film_ldpe_six'] as $film_ldpe_six_row){
                  $film_ldpe_six=$film_ldpe_six_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_ldpe_per_six')) && $this->input->post('film_ldpe_per_six')!=0){
                  $film_ldpe_per_six=$this->input->post('film_ldpe_per_six')."%";
                }else{
                  $film_ldpe_per_six="";
                }

                }else{
                  $film_ldpe_six='';
                  $film_ldpe_per_six='';
                }


              if(!empty($this->input->post('film_lldpe_six')) && !empty($this->input->post('film_lldpe_per_six'))){

                $data['film_lldpe_six']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_lldpe_six'));
                if($data['film_lldpe_six']==FALSE){
                
                }else{
                foreach($data['film_lldpe_six'] as $film_lldpe_six_row){
                  $film_lldpe_six=$film_lldpe_six_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_lldpe_per_six')) && $this->input->post('film_lldpe_per_six')!=0){
                  $film_lldpe_per_six=$this->input->post('film_lldpe_per_six')."%";
                }else{
                  $film_lldpe_per_six="";
                }

              }else{
                $film_lldpe_six='';
                $film_lldpe_per_six='';
              }

              if(!empty($this->input->post('film_hdpe_six')) && !empty($this->input->post('film_hdpe_per_two'))){

                $data['film_hdpe_six']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_six'));
                if($data['film_hdpe_six']==FALSE){
                $film_hdpe_six="";
                }else{
                foreach($data['film_hdpe_six'] as $film_hdpe_six_row){
                  $film_hdpe_six=$film_hdpe_six_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_hdpe_per_six')) && $this->input->post('film_hdpe_per_six')!=0){
                  $film_hdpe_per_six=$this->input->post('film_hdpe_per_six')."%";
                }else{
                  $film_hdpe_per_six="";
                }

              }else{
                $film_hdpe_six='';
                $film_hdpe_per_six='';
              }
              
              if(!empty($this->input->post('gauge_seven'))){
                $gauge_seven=$this->input->post('gauge_seven')."MIC";
              }else{
                $gauge_seven='';
              }


              if(!empty($this->input->post('film_ldpe_seven')) && !empty($this->input->post('film_ldpe_per_seven'))){

                $data['film_ldpe_seven']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_ldpe_seven'));
                if($data['film_ldpe_seven']==FALSE){
                $film_ldpe_seven="";
                }else{
                foreach($data['film_ldpe_seven'] as $film_ldpe_seven_row){
                  $film_ldpe_seven=$film_ldpe_seven_row->article_name;
                  }
                }

                if(!empty($this->input->post('film_ldpe_per_seven')) && $this->input->post('film_ldpe_per_seven')!=0){
                  $film_ldpe_per_seven=$this->input->post('film_ldpe_per_seven')."%";
                }else{
                  $film_ldpe_per_seven="";
                }

              }else{
                $film_ldpe_seven='';
                $film_ldpe_per_seven='';
              }

              if(!empty($this->input->post('film_lldpe_seven')) && !empty($this->input->post('film_lldpe_per_seven'))){

                $data['film_lldpe_seven']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_lldpe_seven'));
                if($data['film_lldpe_seven']==FALSE){
                
                }else{
                foreach($data['film_lldpe_seven'] as $film_lldpe_seven_row){
                  $film_lldpe_seven=$film_lldpe_seven_row->article_name;
                  }
                }

              if(!empty($this->input->post('film_lldpe_per_seven')) && $this->input->post('film_lldpe_per_seven')!=0){
                  $film_lldpe_per_seven=$this->input->post('film_lldpe_per_seven')."%";
                }else{
                  $film_lldpe_per_seven="";
                }

              }else{
                $film_lldpe_seven='';
                $film_lldpe_per_seven='';
              }


              if(!empty($this->input->post('film_hdpe_seven')) && !empty($this->input->post('film_hdpe_per_seven'))){

                $data['film_hdpe_seven']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('film_hdpe_seven'));
                if($data['film_hdpe_seven']==FALSE){
                
                }else{
                foreach($data['film_hdpe_seven'] as $film_hdpe_seven_row){
                  $film_hdpe_seven=$film_hdpe_seven_row->article_name;
                  }
                }

              if(!empty($this->input->post('film_hdpe_per_seven')) && $this->input->post('film_hdpe_per_seven')!=0){
                  $film_hdpe_per_seven=$this->input->post('film_hdpe_per_seven')."%";
                }else{
                  $film_hdpe_per_seven="";
                }

              }else{
                $film_hdpe_seven='';
                $film_hdpe_per_seven='';
              }
              

              $article_description=$sleeve_dia[0]."".$sleeve_length." ".$gauge_one." ".$film_ldpe_one." ".$film_ldpe_per_one." ".$film_lldpe_one." ".$film_lldpe_per_one." ".$film_hdpe_one." ".$film_hdpe_per_one." ".$gauge_two." ".$film_masterbatch_two." ".$film_mb_per_two." ".$film_ldpe_two." ".$film_ldpe_per_two." ".$film_lldpe_two." ".$film_lldpe_per_two." ".$film_hdpe_two." ".$film_hdpe_per_two." ".$gauge_three." ".$film_admer_three." ".$film_admer_per_three." ".$film_hdpe_three." ".$film_hdpe_per_three." ".$gauge_four." ".$film_evoh_four." ".$film_evoh_per_four."".$film_hdpe_four." ".$film_hdpe_per_four." ".$gauge_five." ".$film_admer_five." ".$film_admer_per_five." ".$film_hdpe_five." ".$film_hdpe_per_five." ".$gauge_six." ".$film_masterbatch_six." ".$film_mb_per_six." ".$film_ldpe_six." ".$film_ldpe_per_six." ".$film_lldpe_six." ".$film_lldpe_per_six." ".$film_hdpe_six." ".$film_hdpe_per_six." ".$gauge_seven." ".$film_ldpe_seven." ".$film_ldpe_per_seven." ".$film_lldpe_seven." ".$film_lldpe_per_seven." ".$film_hdpe_one." ".$film_hdpe_per_one;

              

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                if($data['article']==FALSE){

                  $data=array('lang_article_description'=>$article_description);

                  $result=$this->common_model->update_one_active_record('article_name_info',$data,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);

                  $data_article=array('article_modified_date'=>date('Y-m-d'));
                  $result=$this->common_model->update_one_active_record('article',$data_article,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);
                  
                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_one'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_ldpe_one'),'mat_info'=>$this->input->post('film_ldpe_per_one'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_lldpe_one'),'mat_info'=>$this->input->post('film_lldpe_per_one'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_hdpe_one'),'mat_info'=>$this->input->post('film_hdpe_per_one'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_2',$this->session->userdata['logged_in']['company_id']);

                  

                  $data=array('parameter_value'=>$this->input->post('gauge_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_masterbatch_two'),'mat_info'=>$this->input->post('film_mb_per_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_ldpe_two'),'mat_info'=>$this->input->post('film_ldpe_per_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_lldpe_two'),'mat_info'=>$this->input->post('film_lldpe_per_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_hdpe_two'),'mat_info'=>$this->input->post('film_hdpe_per_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_2',$this->session->userdata['logged_in']['company_id']);


                  $data=array('parameter_value'=>$this->input->post('gauge_three'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_4',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$this->input->post('film_admer_three'),'mat_info'=>$this->input->post('film_admer_per_three'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_hdpe_three'),'mat_info'=>$this->input->post('film_hdpe_per_three'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6_5',$this->session->userdata['logged_in']['company_id']);


                  $data=array('parameter_value'=>$this->input->post('gauge_four'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_evoh_four'),'mat_info'=>$this->input->post('film_evoh_per_four'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_6_3',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_hdpe_four'),'mat_info'=>$this->input->post('film_hdpe_per_four'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_6_4',$this->session->userdata['logged_in']['company_id']);


                  $data=array('parameter_value'=>$this->input->post('gauge_five'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_4',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$this->input->post('film_admer_five'),'mat_info'=>$this->input->post('film_admer_per_five'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_6_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_hdpe_five'),'mat_info'=>$this->input->post('film_hdpe_per_five'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_6_5',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_six'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_4',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$this->input->post('film_masterbatch_six'),'mat_info'=>$this->input->post('film_mb_per_six'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_ldpe_six'),'mat_info'=>$this->input->post('film_ldpe_per_six'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_lldpe_six'),'mat_info'=>$this->input->post('film_lldpe_per_six'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_hdpe_six'),'mat_info'=>$this->input->post('film_hdpe_per_six'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_6_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_seven'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_ldpe_seven'),'mat_info'=>$this->input->post('film_ldpe_per_seven'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('film_lldpe_seven'),'mat_info'=>$this->input->post('film_lldpe_per_seven'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_6_1',$this->session->userdata['logged_in']['company_id']);
                  
                  $data=array('mat_article_no'=>$this->input->post('film_hdpe_seven'),'mat_info'=>$this->input->post('film_hdpe_per_seven'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_6_2',$this->session->userdata['logged_in']['company_id']);
                  


                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);
                  }

                  $data['note']='Update Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  }else{
                  $data['error']='No change in Film component, It is exist';

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);

                      $data['note']='Sent for approval';
                      //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }
                }


                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
                  $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-seven-form',$data);
                  $this->load->view('Home/footer');
              }
            }else{
              $data['note']='No Modify rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    }else{
      $data['note']='No Modify rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }



  public function film_per_one_check($str){
    $film_ldpe_per_one=$this->input->post('film_ldpe_per_one');
    $film_lldpe_per_one=$this->input->post('film_lldpe_per_one');
    $film_hdpe_per_one=$this->input->post('film_hdpe_per_one');
    $total_per=$film_ldpe_per_one+$film_lldpe_per_one+$film_hdpe_per_one;

    if($total_per!=100){
      $this->form_validation->set_message('film_per_one_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function film_per_two_check($str){
    $film_ldpe_per_two=$this->input->post('film_ldpe_per_two');
    $film_lldpe_per_two=$this->input->post('film_lldpe_per_two');
    $film_hdpe_per_two=$this->input->post('film_hdpe_per_two');
    $total_per_two=$film_lldpe_per_two+$film_hdpe_per_two+$film_ldpe_per_two;

    if($total_per_two!=100){
      $this->form_validation->set_message('film_per_two_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function film_per_six_check($str){
    $film_ldpe_per_six=$this->input->post('film_ldpe_per_six');
    $film_lldpe_per_six=$this->input->post('film_lldpe_per_six');
    $film_hdpe_per_six=$this->input->post('film_hdpe_per_six');
    $total_per_six=$film_lldpe_per_six+$film_hdpe_per_six+$film_ldpe_per_six;

    if($total_per_six!=100){
      $this->form_validation->set_message('film_per_six_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function film_per_seven_check($str){
    $film_ldpe_per_seven=$this->input->post('film_ldpe_per_seven');
    $film_lldpe_per_seven=$this->input->post('film_lldpe_per_seven');

    $film_hdpe_per_seven=$this->input->post('film_hdpe_per_seven');

    $total_per_seven=$film_ldpe_per_seven+$film_lldpe_per_seven+$film_hdpe_per_seven;

    if($total_per_seven!=100){
      $this->form_validation->set_message('film_per_seven_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }


  public function main_group_article($main_group_id){
    $data['autogeneration']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id,'sub_group_id','','sub_sub_grp_id','');
    //echo $this->db->last_query();
    if($data['autogeneration']==FALSE){
      $data['default']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id','','sub_group_id','','sub_sub_grp_id','');
      foreach ($data['default'] as $default_row) {
       
        $count=str_pad($default_row->curr_val,$default_row->number_of_digits,0,STR_PAD_LEFT);

        $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id);
        foreach ($data['main_group'] as $main_group_row) {
          $main_group_row->lang_short_desc;
          return $main_group_row->lang_short_desc."-000-000-".$count;
        }

        
        }
      
    }else{
      foreach($data['autogeneration'] as $row){

        if($row->main_grp_value=='MAIN'){
          $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$row->main_group_id);
          foreach ($data['main_group'] as $main_group_row) {
            $main_group_initial=$main_group_row->lang_short_desc.$row->seperator;
          }
        }else if($row->main_grp_value==''){
          $main_group_initial="";
        }else{
          $main_group_initial=$row->main_grp_value.$row->seperator;
        }

        if($row->sub_grp_value=='SUB'){
          $sub_group_initial="000".$row->seperator;
        }else if($row->sub_grp_value==''){
          $sub_group_initial="";
        }else{
          $sub_group_initial=$row->sub_grp_value.$row->seperator;
        }

        if($row->sub_sub_grp_value=='SECSUB'){
            $second_sub_group_initial="000".$row->seperator;
          }else if($row->sub_sub_grp_value==''){
          $second_sub_group_initial="";
        }else{
            $second_sub_group_initial=$row->sub_sub_grp_value.$row->seperator;
        }

        $count=$this->common_model->active_record_count_where('article',$this->session->userdata['logged_in']['company_id'],'main_group_id',$row->main_group_id,'article_group_id','999999999999999','sub_sub_grp_id','999999999999999');
        //echo $this->db->last_query();
        $count=$row->step_by+$count+$row->start_value;
        $count=str_pad($count,$row->number_of_digits,0,STR_PAD_LEFT);

        return $main_group_initial.$sub_group_initial.$second_sub_group_initial.$count;
      }
     
     }
     
  }


  function view(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['specification']=$this->tube_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4));

            $spec_lang=array();
            $spec_lang['spec_id']=$this->uri->segment(3);
            $spec_lang['spec_version_no']=$this->uri->segment(4);
           
            $data['specification_film_details']=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','3','srd_id','asc');

            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->uri->segment(3).'@@@'.$this->uri->segment(4));

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
            
            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
          }else{
              $data['note']='No Modify rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
          }
        }
      }
    }
  }else{
      $data['note']='No View rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }


  function copy_seven_layer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

            $data['specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

            //echo $this->db->last_query();
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-seven-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Copy rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
          }
        }
      }
    }
  }else{
      $data['note']='No Copy rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

  function search(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

            $data['page_name']='home';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No rights Thanks';
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }
        }
        
        }
      }
    }
    else{
      $data['note']='No New rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }


  function search_result(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
              
            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean');
            $this->form_validation->set_rules('user_id','Created By' ,'trim|xss_clean');
            $this->form_validation->set_rules('final_approval_flag','Approval Status' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'trim|xss_clean|max_length[5]');
            // Layer 1-----
            $this->form_validation->set_rules('gauge_one',' Layer-1 Gauge' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');              
            $this->form_validation->set_rules('film_ldpe_one','Layer-1 Ldpe' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_ldpe_per_one','Layer-1 Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
            $this->form_validation->set_rules('film_lldpe_one','Layer-1 Lldpe' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_lldpe_per_one','Layer-1 Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
            //Layer 2----             
            $this->form_validation->set_rules('gauge_two','Layer-2 Gauge' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');
            $this->form_validation->set_rules('film_masterbatch_two','Layer-2 Masterbatch' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_mb_per_two','Layer-2 Masterbatch %' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_ldpe_two','Layer-2 Ldpe' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_ldpe_per_two','Layer-2 Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
            $this->form_validation->set_rules('film_lldpe_two','Layer-2 Lldpe' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_lldpe_per_two','Layer-2 Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
            $this->form_validation->set_rules('film_hdpe_two','Layer-2 Hdpe' ,'trim|xss_clean');
            $this->form_validation->set_rules('file_hdpe_perc_two','Layer-2 Ldpe' ,'trim|xss_clean|is_natural|max_length[3]');
           // Layer 3 Admer----
            $this->form_validation->set_rules('gauge_three','Layer-3 Admer Gauge' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');
            $this->form_validation->set_rules('film_admer_three','Layer-3 Admer' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_admer_per_three','Layer-3 Admer %' ,'trim|xss_clean');

            // Layer 4 Evoh--------
            $this->form_validation->set_rules('gauge_four','Layer-4 Evoh Gauge' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');
            $this->form_validation->set_rules('film_evoh_four','Layer-4 Evoh' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_evoh_per_four','Layer-4 Evoh %' ,'trim|xss_clean');
            //Layer 5 Admer-------
            $this->form_validation->set_rules('gauge_five','Layer-5 Admer Gauge' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');
            $this->form_validation->set_rules('film_admer_five','Layer-5 Admer' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_admer_per_five','Layer-5 Admer %' ,'trim|xss_clean');
              //Layer 6----
            $this->form_validation->set_rules('gauge_six','Layer-6 Gauge' ,'trim|xss_clean|exact_length[3]|is_natural');
            $this->form_validation->set_rules('film_masterbatch_six','Layer-6 Masterbatch' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_mb_per_six',' Layer-6 Masterbatch %' ,'trim|xss_clean|max_length[4]');
            $this->form_validation->set_rules('film_ldpe_six','Layer-6 Ldpe' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_ldpe_per_six','Layer-6 Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
            $this->form_validation->set_rules('film_lldpe_six','Layer-6 Lldpe' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_lldpe_per_six','Layer-6 Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
            $this->form_validation->set_rules('film_hdpe_six','Layer-6 Hdpe' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_hdpe_per_six','Layer-6 Hdpe % ' ,'trim|xss_clean|is_natural|max_length[3]');
            //Layer 7---------
            $this->form_validation->set_rules('gauge_seven',' Layer-7 Gauge' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');              
            $this->form_validation->set_rules('film_ldpe_seven','Layer-7 Ldpe' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_ldpe_per_seven','Layer-7 Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
            $this->form_validation->set_rules('film_lldpe_seven','Layer-7 Lldpe' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_lldpe_per_seven','Layer-7 Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]');



            $arr_input=array_filter($this->input->post(),'strlen');
            
            if(empty($arr_input)){

              $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|exact_length[10]');
              $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|exact_length[10]');

            }
            

            if($this->form_validation->run()==FALSE){

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
              $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
              $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
              $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
              $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{
                $from='';
                $to='';
                if(!empty($this->input->post('from_date'))){
                  $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                }
                if(!empty($this->input->post('to_date'))){
                  $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);
                }            

                if(!empty($this->input->post('article_no'))){
                  $article_no_arr=explode('//',$this->input->post('article_no'));
                }else{
                  $article_no_arr[1]='';
                }

                if(!empty($this->input->post('sleeve_dia'))){

                  $sleeve_dia=explode("//", $this->input->post('sleeve_dia'));
                }
                else{
                  $sleeve_dia[0]='';
                  $sleeve_dia[1]='';
                }
                
                $data=array('user_id'=>$this->input->post('user_id'),                    
                            'article_no'=>$article_no_arr[1],
                            'final_approval_flag'=>$this->input->post('final_approval_flag')                            
                           );

                $data=array_filter($data,'strlen');

                $search_arr = array(
                                'sleeve_dia' =>$sleeve_dia[0],
                                'sleeve_length' =>$this->input->post('sleeve_length'),
                                'layer_1_guage' =>$this->input->post('guage_one'),
                                'layer_1_ldpe' =>$this->input->post('film_ldpe_one'),
                                'layer_1_ldpe_perc' =>$this->input->post('film_ldpe_per_one'),
                                'layer_1_lldpe' =>$this->input->post('film_lldpe_one'),
                                'layer_1_lldpe_perc' =>$this->input->post('film_lldpe_per_one'),

                                'layer_2_guage' =>$this->input->post('gauge_two'),
                                'layer_2_master_batch' =>$this->input->post('film_masterbatch_two'),
                                'layer_2_mb_perc' =>$this->input->post('film_mb_per_two'),
                                'layer_2_ldpe' =>$this->input->post('film_ldpe_two'),
                                'layer_2_ldpe_perc' =>$this->input->post('film_ldpe_per_two'),
                                'layer_2_lldpe' =>$this->input->post('film_lldpe_two'),
                                'layer_2_lldpe_perc' =>$this->input->post('film_lldpe_per_two'),
                                'layer_2_hdpe' =>$this->input->post('film_hdpe'),
                                'layer_2_hdpe_perc' =>$this->input->post('film_hdpe_per_two'),
                                      
                                'Layer_3_guage' =>$this->input->post('guage_three'),                             
                                'Layer_3_admer' =>$this->input->post('film_admer_three'),
                                'Layer_3_admer_perc' =>$this->input->post('film_admer_per_three'),
                                
                                'Layer_4_guage' =>$this->input->post('guage_four'),                              
                                'Layer_4_evoh' =>$this->input->post('film_evoh_four'),
                                'Layer_4_evoh_perc' =>$this->input->post('film_evoh_per_four'),

                                'Layer_5_guage' =>$this->input->post('guage_five'),                              
                                'Layer_5_admer' =>$this->input->post('film_admer_five'),
                                'Layer_5_admer_perc' =>$this->input->post('film_admer_per_five'),
                                   
                                'layer_6_guage' =>$this->input->post('gauge_six'),
                                'layer_6_master_batch' =>$this->input->post('film_masterbatch_six'),
                                'layer_6_mb_perc' =>$this->input->post('film_mb_per_six'),
                                'layer_6_ldpe' =>$this->input->post('film_ldpe_six'),
                                'layer_6_ldpe_perc' =>$this->input->post('film_ldpe_per_six'),
                                'layer_6_lldpe' =>$this->input->post('film_lldpe_six'),
                                'layer_6_lldpe_perc' =>$this->input->post('film_lldpe_per_six'),
                                'layer_6_hdpe' =>$this->input->post('film_hdpe'),
                                'layer_6_hdpe_perc' =>$this->input->post('film_hdpe_per_six'),

                                'layer_7_guage' =>$this->input->post('guage_seven'),
                                'layer_7_ldpe' =>$this->input->post('film_ldpe_seven'),
                                'layer_7_ldpe_perc' =>$this->input->post('film_ldpe_per_seven'),
                                'layer_7_lldpe' =>$this->input->post('film_lldpe_seven'),
                                'layer_7_lldpe_perc' =>$this->input->post('film_lldpe_per_seven')

                                    
                                ); 

                $search=array_filter($search_arr);

                $data['specification']=$this->sleeve_specification_model->active_record_search_for_spring_film('specification_sheet',$data,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                 
                if($data['specification']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                      
                      $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

                      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                      $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                      $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                      $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                      $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
                      $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
                      $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                      

                      $data['note']='No record in search transaction';
                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                      $this->load->view('Home/footer');
                  }
                
            }

          }else{
                  $data['page_name']='home';
                  $data['note']='No rights Thanks';
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view('Error/error-title',$data);
                  $this->load->view('Home/footer');
                }
              }
              
              }
            }
          }
          else{
            $data['note']='No New rights Thanks';
            $data['page_name']='home';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }


  }
  
  //   function approved_by_factory(){
  //   $data['page_name']='Sales';
  //   $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  //   if($data['module']!=FALSE){
  //   foreach ($data['module'] as $module_row) {
  //     if($module_row->module_name==='Sales'){
  //       $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

  //       foreach ($data['formrights'] as $formrights_row) {
  //         if($formrights_row->approval==1){
			  
			
		// 	$dataa=array('pending_flag'=>'1','final_approval_flag'=>'1');

		// 	$result=$this->common_model->update_one_active_record_where('specification_sheet',$dataa,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);
		// 	echo"<script>alert('Approval done ');</script>";
			
  //           $table='specification_sheet';
  //           include('pagination-tube.php');
  //           $data['specification']=$this->sleeve_specification_model->select_film_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

  //           //echo $this->db->last_query();
           
  //           $this->load->view('Home/header');
  //           $this->load->view('Home/nav',$data);
  //           $this->load->view('Home/subnav');
  //           $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
  //           $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
  //           $this->load->view('Home/footer');
  //         }else{
  //           $data['note']='No rights Thanks';
  //           $this->load->view('Home/header');
  //           $this->load->view('Home/nav',$data);
  //           $this->load->view('Home/subnav');
  //           $this->load->view('Error/error-title',$data);
  //           $this->load->view('Home/footer');
  //         }
  //       }
        
  //       }
  //     }
  //   }
  //   else{
  //     $data['note']='No rights Thanks';
  //     $data['page_name']='home';
  //     $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  //     $this->load->view('Home/header');
  //     $this->load->view('Home/nav',$data);
  //     $this->load->view('Home/subnav');
  //     $this->load->view('Error/error-title',$data);
  //     $this->load->view('Home/footer');
  //   }
  // }





}

?>