<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_group extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sub_group_model');
      $this->load->model('category_model');
      $this->load->model('tariff_model');
      $this->load->model('account_head_model');

		}else{
			redirect('login','refresh');
		}
  }

  function index(){
  	$data['page_name']='Inventory';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
    	if($module_row->module_name==='Inventory'){
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='article_group';
            include('pagination.php');
            $data['sub_group']=$this->sub_group_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records-tally',$data);
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


  function create(){

    $data['page_name']='Inventory';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Inventory'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['category']=$this->category_model->select_active_drop_down('article_category_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['account_head']=$this->account_head_model->select_active_drop_down('account_head_lang',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id'],'account_head_lang.related_flag<>','1');

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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



  function save(){

    $data['page_name']='Inventory';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Inventory'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sub_group','Sub Group Description' ,'required|trim|xss_clean|is_unique[article_group_desc.lang_article_group_desc]|max_length[50]|strtoupper');
            $this->form_validation->set_rules('short_desc','Short Description' ,'required|trim|xss_clean|is_unique[article_group_desc.lang_short_desc]|max_length[20]|strtoupper');

            $this->form_validation->set_rules('category','Category' ,'trim|xss_clean');
            $this->form_validation->set_rules('tariff','Tariff' ,'trim|xss_clean');

            $this->form_validation->set_rules('account_head','Account Head' ,'trim|xss_clean|required');
            $this->form_validation->set_rules('sales_pur_flag','Sales/Purchase/Other' ,'trim|xss_clean|required');
            $this->form_validation->set_rules('excise_flag','Excisable' ,'trim|xss_clean');
            $this->form_validation->set_rules('spares_flag','Spares' ,'trim|xss_clean');
            $this->form_validation->set_rules('type','Type' ,'trim|xss_clean');

            if($this->form_validation->run()==FALSE){
              $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
              $data['category']=$this->category_model->select_active_drop_down('article_category_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['account_head']=$this->account_head_model->select_active_drop_down('account_head_lang',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id'],'account_head_lang.related_flag<>','1');
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
                $data['result']=$this->common_model->select_max_pkey_numeric('article_group','article_group_id',$this->session->userdata['logged_in']['company_id']);
                foreach ($data['result'] as $row) {
                  $key= $row->article_group_id+1;
                 
                }

              $excise_flag = (!empty($this->input->post('excise_flag'))) ? $this->input->post('excise_flag') : 0;
              $spares_flag = (!empty($this->input->post('spares_flag'))) ? $this->input->post('spares_flag') : 0;
              $data=array(
                    'article_group_id'=>$key,
                    'main_group_id'=>$this->input->post('main_group'),
                    'article_priority'=>'0',
                    'reference_position'=>'0',
                    'archive'=>'0',
                    'company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'increment_value'=>'1',
                    'account_head_id'=>$this->input->post('account_head'),
                    'sales_pur_flag'=>$this->input->post('sales_pur_flag'),
                    'mat_flag'=>$this->input->post('type'),
                    'excise_flag'=>$excise_flag,
                    'spares_flag'=>$spares_flag,
                    'category_id'=>$this->input->post('category'),
                    'excise_rate_id'=>$this->input->post('tariff')
                    );
              $result=$this->common_model->save('article_group',$data);

              $data=array(
                    'article_group_id'=>$key,
                    'lang_article_group_desc'=>$this->input->post('sub_group'),
                    'lang_short_desc'=>$this->input->post('short_desc'),
                    'language_id'=>$this->session->userdata['logged_in']['language_id'],
                    'company_id'=>$this->session->userdata['logged_in']['company_id'],
                    );
                $result=$this->common_model->save('article_group_desc',$data);    

                    $data['page_name']='Inventory';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

                    $data['note']='Create Transaction Completed';

                    header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                    $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                    $data['category']=$this->category_model->select_active_drop_down('article_category_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                    $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                    $data['account_head']=$this->account_head_model->select_active_drop_down('account_head_lang',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id'],'account_head_lang.related_flag<>','1');

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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



  function archive_records(){
    $data['page_name']='Inventory';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Inventory'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            $table='article_group';
            include('pagination_archive.php');
            $data['sub_group']=$this->sub_group_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/archive-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);
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


  function modify(){
    $data['page_name']='Inventory';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Inventory'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$this->uri->segment(3));

            //echo $this->db->last_query();

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

            $data['category']=$this->category_model->select_active_drop_down('article_category_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['account_head']=$this->account_head_model->select_active_drop_down('account_head_lang',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id'],'account_head_lang.related_flag<>','1');
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
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



  function update(){
      $data['page_name']='Inventory';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Inventory'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){
              
              $this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sub_group','Sub Group Description' ,'required|trim|xss_clean|max_length[50]|strtoupper');
              $this->form_validation->set_rules('short_desc','Short Description' ,'required|trim|xss_clean|max_length[15]|strtoupper');

              $this->form_validation->set_rules('category','Category' ,'trim|xss_clean');
              $this->form_validation->set_rules('tariff','Tariff' ,'trim|xss_clean');

              $this->form_validation->set_rules('account_head','Account Head' ,'trim|xss_clean|required');
              $this->form_validation->set_rules('sales_pur_flag','Sales/Purchase/Other' ,'trim|xss_clean|required');
              $this->form_validation->set_rules('excise_flag','Excisable' ,'trim|xss_clean');
              $this->form_validation->set_rules('spares_flag','Spares' ,'trim|xss_clean');
              $this->form_validation->set_rules('type','Type' ,'trim|xss_clean');
              

              if($this->form_validation->run()==FALSE){

                $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$this->input->post('article_group_id'));

                $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                $data['category']=$this->category_model->select_active_drop_down('article_category_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                $data['account_head']=$this->account_head_model->select_active_drop_down('account_head_lang',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id'],'account_head_lang.related_flag<>','1');
                

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{
                $excise_flag = (!empty($this->input->post('excise_flag'))) ? $this->input->post('excise_flag') : 0;
                $spares_flag = (!empty($this->input->post('spares_flag'))) ? $this->input->post('spares_flag') : 0;
              $data=array(
                    'article_group_id'=>$this->input->post('article_group_id'),
                    'main_group_id'=>$this->input->post('main_group'),
                    'article_priority'=>'0',
                    'reference_position'=>'0',
                    'archive'=>'0',
                    'company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'increment_value'=>'1',
                    'account_head_id'=>$this->input->post('account_head'),
                    'sales_pur_flag'=>$this->input->post('sales_pur_flag'),
                    'mat_flag'=>$this->input->post('type'),
                    'excise_flag'=>$excise_flag,
                    'spares_flag'=>$spares_flag,
                    'category_id'=>$this->input->post('category'),
                    'excise_rate_id'=>$this->input->post('tariff')
                    );
              $result=$this->common_model->update_one_active_record('article_group',$data,'article_group_id',$this->input->post('article_group_id'),$this->session->userdata['logged_in']['company_id']);

              $data=array(
                    'article_group_id'=>$this->input->post('article_group_id'),
                    'lang_article_group_desc'=>$this->input->post('sub_group'),
                    'lang_short_desc'=>$this->input->post('short_desc'),
                    'language_id'=>$this->session->userdata['logged_in']['language_id'],
                    'company_id'=>$this->session->userdata['logged_in']['company_id'],
                    );

              $result=$this->common_model->update_one_active_record('article_group_desc',$data,'article_group_id',$this->input->post('article_group_id'),$this->session->userdata['logged_in']['company_id']);
                  

                  $data['page_name']='Inventory';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

                  $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$this->input->post('article_group_id'));

                  $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                  $data['category']=$this->category_model->select_active_drop_down('article_category_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                  $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                  $data['account_head']=$this->account_head_model->select_active_drop_down('account_head_lang',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id'],'account_head_lang.related_flag<>','1');

                  $data['note']='Update Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
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


  function delete(){

      $data['page_name']='Inventory';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Inventory'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->common_model->archive_one_record('article_group',$data,'article_group_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['sub_group']=$this->sub_group_model->select_one_inactive_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$this->uri->segment(3));

                  $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                  $data['category']=$this->category_model->select_active_drop_down('article_category_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                  $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                  $data['account_head']=$this->account_head_model->select_active_drop_down('account_head_lang',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id'],'account_head_lang.related_flag<>','1');
                
                  $data['page_name']='Inventory';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

                  $data['note']='Archive Transaction completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                  $this->load->view('Home/footer');
            }else{
                $data['note']='No Archive rights Thanks';
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
        $data['note']='No Archive rights Thanks';
        $data['page_name']='home';
        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
        $this->load->view('Home/header');
        $this->load->view('Home/nav',$data);
        $this->load->view('Home/subnav');
        $this->load->view('Error/error-title',$data);
        $this->load->view('Home/footer');
      }
    }


    function dearchive(){
    $data['page_name']='Inventory';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Inventory'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){
                 $data=array('archive'=>'2');
                 $result=$this->common_model->archive_one_record('article_group',$data,'article_group_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$this->uri->segment(3));


                  $data['page_name']='Inventory';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

                  $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                  $data['category']=$this->category_model->select_active_drop_down('article_category_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                  $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                  $data['account_head']=$this->account_head_model->select_active_drop_down('account_head_lang',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id'],'account_head_lang.related_flag<>','1');

                  $data['note']='Dearchive Transaction completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
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
    }else{
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


  function search(){

    $data['page_name']='Inventory';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Inventory'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['category']=$this->category_model->select_active_drop_down('article_category_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['account_head']=$this->account_head_model->select_active_drop_down('account_head_lang',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id'],'account_head_lang.related_flag<>','1');

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

    $data['page_name']='Inventory';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Inventory'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
              $this->form_validation->set_rules('main_group','Main Group' ,'trim|xss_clean');
              $this->form_validation->set_rules('sub_group','Sub Group Description' ,'trim|xss_clean|max_length[50]|strtoupper');
              $this->form_validation->set_rules('short_desc','Short Description' ,'trim|xss_clean|max_length[15]|strtoupper');

              $this->form_validation->set_rules('category','Category' ,'trim|xss_clean');
              $this->form_validation->set_rules('tariff','Tariff' ,'trim|xss_clean');

              $this->form_validation->set_rules('account_head','Account Head' ,'trim|xss_clean');
              $this->form_validation->set_rules('sales_pur_flag','Sales/Purchase/Other' ,'trim|xss_clean');
              $this->form_validation->set_rules('excise_flag','Excisable' ,'trim|xss_clean');
              $this->form_validation->set_rules('spares_flag','Spares' ,'trim|xss_clean');
              $this->form_validation->set_rules('type','Type' ,'trim|xss_clean');
              
            
            if($this->form_validation->run()==FALSE){

                $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                $data['category']=$this->category_model->select_active_drop_down('article_category_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                $data['account_head']=$this->account_head_model->select_active_drop_down('account_head_lang',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id'],'account_head_lang.related_flag<>','1');

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{
                

                $data=array(
                    'article_group.main_group_id'=>$this->input->post('main_group'),
                    'article_group_desc.lang_article_group_desc'=>$this->input->post('sub_group'),
                    'article_group_desc.lang_short_desc'=>$this->input->post('short_desc'),
                    'article_group.account_head_id'=>$this->input->post('account_head'),
                    'article_group.sales_pur_flag'=>$this->input->post('sales_pur_flag'),
                    'article_group.mat_flag'=>$this->input->post('type'),
                    'article_group.category_id'=>$this->input->post('category'),
                    'article_group.excise_rate_id'=>$this->input->post('tariff')
                    );
                $data = array_filter($data);

                $data['sub_group']=$this->sub_group_model->active_record_search('article_group',$data,$this->session->userdata['logged_in']['company_id']);

                //echo $this->db->last_query();
                 
                if($data['sub_group']!=FALSE){
                    $data['page_name']='Inventory';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Inventory';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],4,'sub_group');
                      
                      $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                      $data['category']=$this->category_model->select_active_drop_down('article_category_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                      $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                      $data['account_head']=$this->account_head_model->select_active_drop_down('account_head_lang',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id'],'account_head_lang.related_flag<>','1');

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
  

}