<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('article_model');
      $this->load->model('main_group_model');
      $this->load->model('sub_group_model');
      $this->load->model('second_sub_group_model');
      $this->load->model('tariff_model');
      $this->load->model('uom_model');

      $this->load->model('customer_model');
      $this->load->model('country_model');
      $this->load->model('state_model');

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='article_main_group';
            $search_data=array();
            $data['article_main_group']=$this->main_group_model->active_record_search($table,$search_data,$this->session->userdata['logged_in']['company_id']);
           // echo $this->db->last_query();

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/configuration',$data);
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

  // function index(){
  // 	$data['page_name']='Sales';
  //   $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  //   if($data['module']!=FALSE){
  //   foreach ($data['module'] as $module_row) {
  //   	if($module_row->module_name==='Sales'){
  //   		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

		//   	foreach ($data['formrights'] as $formrights_row) {
  //         if($formrights_row->view==1){
  //           $table='article';
  //           include('pagination.php');
  //           $data['article']=$this->article_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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
		  	
  //   		}
  //   	}
  // 	}
  //   else{
  //   	$data['note']='No rights Thanks';
  //   	$data['page_name']='home';
  //   	$data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  // 		$this->load->view('Home/header');
  // 		$this->load->view('Home/nav',$data);
  // 		$this->load->view('Home/subnav');
  //     $this->load->view('Error/error-title',$data);
  // 		$this->load->view('Home/footer');
  //   }
  // }


  function view(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$this->uri->segment(3));
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


  function create(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $this->common_model->save_number($this->input->post('opening_stock'),$this->session->userdata['logged_in']['company_id']);
            $this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sub_group','Sub Group' ,'required|trim|xss_clean|callback_check_group');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|is_unique[article.article_no]|max_length[45]');

            $this->form_validation->set_rules('article_name','Article Name' ,'required|trim|xss_clean|is_unique[article_name_info.lang_article_description]|strtoupper|max_length[500]');

            $this->form_validation->set_rules('article_desc','Article Description' ,'trim|xss_clean|strtoupper|max_length[1055]');

            $this->form_validation->set_rules('tariff','HSN/SAC' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('uom','UOM' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('opening_stock','Opening Stock' ,'trim|xss_clean|numeric|greater_than[0]');
            $this->form_validation->set_rules('opening_stock_valuation','Opening Stock Valuation' ,'trim|xss_clean|numeric');
            $this->form_validation->set_rules('lot_wise','Lot Wise' ,'trim|xss_clean');
            $this->form_validation->set_rules('std_lot_size','Standard Lot Size' ,'trim|xss_clean|numeric');
            $this->form_validation->set_rules('expiary_period','Expiary' ,'trim|xss_clean|numeric');
            $this->form_validation->set_rules('qc_flag','Qc Check' ,'trim|xss_clean');
            $this->form_validation->set_rules('imported_flag','Imported' ,'trim|xss_clean');
            $this->form_validation->set_rules('spec_item_flag','For Specification' ,'trim|xss_clean');

            if($this->form_validation->run()==FALSE){

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
              $sub_group=(!empty($this->input->post('sub_group'))) ? $this->input->post('sub_group') : '999999999999999';
              $second_sub_group=(!empty($this->input->post('second_sub_group'))) ? $this->input->post('second_sub_group') : '999999999999999';
              $spec_item_flag = (!empty($this->input->post('spec_item_flag'))) ? $this->input->post('spec_item_flag') : 0;
              $qc_flag = (!empty($this->input->post('qc_flag'))) ? $this->input->post('qc_flag') : 0;
              $imported_flag = (!empty($this->input->post('imported_flag'))) ? $this->input->post('imported_flag') : 0;

              if(!empty($this->input->post('second_sub_group'))){
                $data['second_sub_group']=$this->second_sub_group_model->select_one_active_record('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],'article_second_subgroup_master.sub_sub_grp_id',$second_sub_group);
                foreach($data['second_sub_group'] as $second_sub_group_row){
                  $sales_pur_flag=$second_sub_group_row->sales_pur_flag;
                }
              }else if(!empty($this->input->post('sub_group'))){
                $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$sub_group);

                foreach($data['sub_group'] as $sub_group_row){
                  $sales_pur_flag=$sub_group_row->sales_pur_flag;
                }
              }else{
                $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$this->input->post('main_group'));
                foreach($data['main_group'] as $main_group_row){
                  $sales_pur_flag=$main_group_row->sales_pur_flag;
                }
              }


              if(!empty($this->input->post('second_sub_group'))){

                $data['second_sub_group']=$this->second_sub_group_model->select_one_active_record('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],'article_second_subgroup_master.sub_sub_grp_id',$second_sub_group);
                foreach($data['second_sub_group'] as $second_sub_group_row){
                  $sales_pur_flag=$second_sub_group_row->sales_pur_flag;
                  $increment_value=$second_sub_group_row->increment_value;
                }

                $table='article_second_subgroup_master';
                $increment_value_new=$increment_value+1;
                $data_incr= array('increment_value' =>$increment_value_new);
                $pkeys=array('main_group_id' =>$this->input->post('main_group'),
                              'article_group_id'=>$this->input->post('sub_group'),
                              'sub_sub_grp_id'=>$this->input->post('second_sub_group')
                            );

              }else if(!empty($this->input->post('sub_group'))){
                $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$sub_group);

                foreach($data['sub_group'] as $sub_group_row){
                  $sales_pur_flag=$sub_group_row->sales_pur_flag;
                   $increment_value=$sub_group_row->increment_value;
                }

                $table='article_group';
                $increment_value_new=$increment_value+1;
                $data_incr= array('increment_value' =>$increment_value_new);
                $pkeys=array('main_group_id' =>$this->input->post('main_group'),
                              'article_group_id'=>$this->input->post('sub_group')                              
                            );

              }else{
                $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$this->input->post('main_group'));
                foreach($data['main_group'] as $main_group_row){
                  $sales_pur_flag=$main_group_row->sales_pur_flag;
                   $increment_value=$main_group_row->increment_value;
                }

                $table='main_group';
                $increment_value_new=$increment_value+1;
                $data_incr= array('increment_value' =>$increment_value_new);
                $pkeys=array('main_group_id' =>$this->input->post('main_group'));

              }
              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'main_group_id'=>$this->input->post('main_group'),
                    'article_group_id'=>$sub_group,
                    'sub_sub_grp_id'=>$second_sub_group,
                    'article_no'=>$this->input->post('article_no'),
                    'uom'=>$this->input->post('uom'),
                    'excise_rate_id'=>$this->input->post('tariff'),
                    'op_stock'=>$this->common_model->save_number($this->input->post('opening_stock'),$this->session->userdata['logged_in']['company_id']),
                    'op_stock_value'=>$this->common_model->save_number($this->input->post('opening_stock_valuation'),$this->session->userdata['logged_in']['company_id']),
                    'std_lot_size'=>$this->common_model->save_number($this->input->post('std_lot_size'),$this->session->userdata['logged_in']['company_id']),
                    'expiry_period'=>$this->common_model->save_number($this->input->post('expiary_period'),$this->session->userdata['logged_in']['company_id']),
                    'sales_purchase_flag'=>$sales_pur_flag,
                    'spec_item_flag'=>$spec_item_flag,
                    'qc'=>$qc_flag,
                    'imported_flag'=>$imported_flag,'archive'=>'0','article_date'=>date('Y-m-d'), 
                    'article_modified_date'=>date('Y-m-d')
                  );

              $result=$this->common_model->save('article',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'language_id'=>$this->session->userdata['logged_in']['language_id'],
                    'article_no'=>$this->input->post('article_no'),
                    'lang_article_description'=>$this->input->post('article_name'),
                    'lang_sub_description'=>$this->input->post('article_desc'),
                    'main_group_id'=>$this->input->post('main_group'),
                    'article_group_id'=>$sub_group,
                    'sub_sub_grp_id'=>$second_sub_group);

              $result=$this->common_model->save('article_name_info',$data);

              $result=$this->article_model->update_one_active_record_where($table,$data_incr,$pkeys,$this->session->userdata['logged_in']['company_id']);

          
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

                    $data['note']='Create Transaction Completed';

                    header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                    $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                    $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                    $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                    $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                    $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);

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


  function check_group(){
    $main_group=$this->input->post('main_group');
    $sub_group=$this->input->post('sub_group');
    $count=$this->common_model->active_record_count_where('article_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group,'article_group_id',$sub_group,'archive<>','1');
    $this->db->last_query();
    if($count==0){
      $this->form_validation->set_message('check_group', 'Invalid Group Selection');
         return false;
    }else{
      return TRUE;
    }

  }



  function archive_records(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            $table='article';
            include('pagination_archive.php');
            $data['article']=$this->article_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->uri->segment(3));
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);
            $data['alternative_supplier']=$this->article_model->select_article_supplier('alternative_supplier','alternative_supplier.article_no',$this->uri->segment(3));

             $data['article_customer']=$this->article_model->select_article_customer('article_customer','article_customer.article_no',$this->uri->segment(3));

             
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
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){
              /*
              $this->form_validation->set_rules('main_group','Main Group' ,'trim|xss_clean');
              $this->form_validation->set_rules('sub_group','Sub Group' ,'trim|xss_clean|callback_check_group');
              $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[45]');
              */

              $this->form_validation->set_rules('article_name','Article Name' ,'required|trim|xss_clean|strtoupper|max_length[500]');

              $this->form_validation->set_rules('article_desc','Article Description' ,'trim|xss_clean|strtoupper|max_length[1055]');

              $this->form_validation->set_rules('tariff','HSN/SAC' ,'trim|xss_clean');
              $this->form_validation->set_rules('uom','UOM' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('opening_stock','Opening Stock' ,'trim|xss_clean|numeric');
              $this->form_validation->set_rules('opening_stock_valuation','Opening Stock Valuation' ,'trim|xss_clean|numeric');
              $this->form_validation->set_rules('lot_wise','Lot Wise' ,'trim|xss_clean');
              $this->form_validation->set_rules('std_lot_size','Standard Lot Size' ,'trim|xss_clean|numeric');
              $this->form_validation->set_rules('expiary_period','Expiary' ,'trim|xss_clean|numeric');
              $this->form_validation->set_rules('qc_flag','Qc Check' ,'trim|xss_clean');
              $this->form_validation->set_rules('imported_flag','Imported' ,'trim|xss_clean');
              $this->form_validation->set_rules('spec_item_flag','For Specification' ,'trim|xss_clean');
              

              if($this->form_validation->run()==FALSE){
                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('article_no'));
                //echo $this->db->last_query();
                $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);
                

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{
                $spec_item_flag = (!empty($this->input->post('spec_item_flag'))) ? $this->input->post('spec_item_flag') : 0;
                $qc_flag = (!empty($this->input->post('qc_flag'))) ? $this->input->post('qc_flag') : 0;
                $imported_flag = (!empty($this->input->post('imported_flag'))) ? $this->input->post('imported_flag') : 0;

                if(!empty($this->input->post('second_sub_group'))){
                $data['second_sub_group']=$this->second_sub_group_model->select_one_active_record('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],'article_second_subgroup_master.sub_sub_grp_id',$this->input->post('second_sub_group'));
                foreach($data['second_sub_group'] as $second_sub_group_row){
                  $sales_pur_flag=$second_sub_group_row->sales_pur_flag;
                }
              }else if(!empty($this->input->post('sub_group'))){
                $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$this->input->post('sub_group'));

                foreach($data['sub_group'] as $sub_group_row){
                  $sales_pur_flag=$sub_group_row->sales_pur_flag;
                }
              }else{
                $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$this->input->post('main_group'));
                foreach($data['main_group'] as $main_group_row){
                  $sales_pur_flag=$main_group_row->sales_pur_flag;
                }
              }

                $data=array(
                    'uom'=>$this->input->post('uom'),
                    'excise_rate_id'=>$this->input->post('tariff'),
                    'op_stock'=>$this->common_model->save_number($this->input->post('opening_stock'),$this->session->userdata['logged_in']['company_id']),
                    'op_stock_value'=>$this->common_model->save_number($this->input->post('opening_stock_valuation'),$this->session->userdata['logged_in']['company_id']),
                    'std_lot_size'=>$this->common_model->save_number($this->input->post('std_lot_size'),$this->session->userdata['logged_in']['company_id']),
                    'expiry_period'=>$this->common_model->save_number($this->input->post('expiary_period'),$this->session->userdata['logged_in']['company_id']),
                    'sales_purchase_flag'=>$sales_pur_flag,
                    'spec_item_flag'=>$spec_item_flag,
                    'qc'=>$qc_flag,
                    'imported_flag'=>$imported_flag,
                    'article_modified_date'=>date('Y-m-d'));

              $result=$this->common_model->update_one_active_record('article',$data,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);

              $data=array('lang_article_description'=>$this->input->post('article_name'),'lang_sub_description'=>$this->input->post('article_desc'));

              $result=$this->common_model->update_one_active_record('article_name_info',$data,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('article_no'));
              $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
              $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);

              $data['page_name']='Sales';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

              $data['note']='Update Transaction Completed';
               // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
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

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->common_model->archive_one_record('article',$data,'article_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['article']=$this->article_model->select_one_inactive_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->uri->segment(3));

                  $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                  $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                  $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                  $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                  $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);
                
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

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
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){
              $data=array('archive'=>'2');

              $result=$this->common_model->archive_one_record('article',$data,'article_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->uri->segment(3));

              $data['page_name']='Sales';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

              $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
              $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
               $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);   
                  

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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']); 

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

              $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean');
              $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean');            
              $this->form_validation->set_rules('main_group','Main Group' ,'trim|xss_clean');
              $this->form_validation->set_rules('sub_group','Sub Group' ,'trim|xss_clean');
              $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|max_length[45]');
              $this->form_validation->set_rules('article_name','Article Name' ,'trim|xss_clean|strtoupper|max_length[500]');

              $this->form_validation->set_rules('article_desc','Article Descroption' ,'trim|xss_clean|strtoupper|max_length[1055]');

              $this->form_validation->set_rules('tariff','HSN/SAC' ,'trim|xss_clean');
              $this->form_validation->set_rules('uom','UOM' ,'trim|xss_clean');
              $this->form_validation->set_rules('opening_stock','Opening Stock' ,'trim|xss_clean|numeric');
              $this->form_validation->set_rules('opening_stock_valuation','Opening Stock Valuation' ,'trim|xss_clean|numeric');
              $this->form_validation->set_rules('lot_wise','Lot Wise' ,'trim|xss_clean');
              $this->form_validation->set_rules('std_lot_size','Standard Lot Size' ,'trim|xss_clean|numeric');
              $this->form_validation->set_rules('expiary_period','Expiary' ,'trim|xss_clean|numeric');
              $this->form_validation->set_rules('qc_flag','Qc Check' ,'trim|xss_clean');
              $this->form_validation->set_rules('imported_flag','Imported' ,'trim|xss_clean');
              $this->form_validation->set_rules('spec_item_flag','For Specification' ,'trim|xss_clean');
            

            if($this->form_validation->run()==FALSE){

              $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
              $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);
                

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

               $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
              $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);

                $data=array(
                    'article.main_group_id'=>$this->input->post('main_group'),
                    'article.article_group_id'=>$this->input->post('sub_group'),
                    'article.sub_sub_grp_id'=>$this->input->post('second_sub_group'),
                    'article.article_no'=>$this->input->post('article_no'),
                    'article_name_info.lang_article_description'=>$this->input->post('article_name'),
                    'article_name_info.lang_sub_description'=>$this->input->post('article_desc'),
                    'article.excise_rate_id'=>$this->input->post('tariff'),
                    'article.uom'=>$this->input->post('uom'),
                    'article.op_stock'=>$this->common_model->save_number($this->input->post('opening_stock'),$this->session->userdata['logged_in']['company_id']),
                    'article.op_stock_value'=>$this->common_model->save_number($this->input->post('opening_stock_valuation'),$this->session->userdata['logged_in']['company_id']),
                    'article.std_lot_size'=>$this->common_model->save_number($this->input->post('std_lot_size'),$this->session->userdata['logged_in']['company_id']),
                    'article.expiry_period'=>$this->common_model->save_number($this->input->post('expiary_period'),$this->session->userdata['logged_in']['company_id']));

                $data = array_filter($data);

                $data['article']=$this->article_model->active_record_search('article',$data,$this->session->userdata['logged_in']['company_id'],$from,$to);
               //echo $this->db->last_query();
                 
                if($data['article']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-result',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');
                      
                      $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                      $data['sub_group']=$this->sub_group_model->select_active_drop_down('article_group',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                      $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                      $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                      $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);

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
  function create_article(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $main_group_id=$this->uri->segment(3);
           // $article_group_id=$this->uri->segment(4);
            //------------ Main group Dropdown -----------------------
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            //------------SUb Group Dropdown--------------------------
            $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.main_group_id',$main_group_id);           
            //------------Second Sub group dropdown on Sub group------
            // $data_second_sub_group=array();
            // $data_second_sub_group['article_second_subgroup_master.main_group_id']=$main_group_id;
            // $data_second_sub_group['article_second_subgroup_master.article_group_id']=$article_group_id;
            // $data['second_sub_group']=$this->second_sub_group_model->select_active_records_where('article_second_subgroup_master',$data_second_sub_group,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();
            //$data['number']=$this->autogeneration_article_sub_group($main_group_id,$article_group_id);
            $data['number']=$this->autogeneration_article_main_group($main_group_id);

            $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);            
            $data['article_short_code']=$this->common_model->select_active_drop_down('article_short_code',$this->session->userdata['logged_in']['company_id']);
            $data['machines_master']=$this->common_model->select_active_drop_down('machines_master',$this->session->userdata['logged_in']['company_id']);
            $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);


            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data); 
            if($main_group_id==1){
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form-rm-mb',$data);
            }else{
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form-stores-spares',$data);
            }           
            

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
  function save_article(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sub_group','Sub Group' ,'required|trim|xss_clean|callback_check_group');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|is_unique[article.article_no]|max_length[45]');
            $this->form_validation->set_rules('lang_article_description','Article Name' ,'required|trim|xss_clean|is_unique[article_name_info.lang_article_description]|strtoupper|max_length[64]');
            $this->form_validation->set_rules('tariff','HSN/SAC' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('uom','UOM' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('opening_stock','Opening Stock' ,'trim|xss_clean|numeric|greater_than[0]');
            $this->form_validation->set_rules('opening_stock_valuation','Opening Stock Valuation' ,'trim|xss_clean|numeric');
            $this->form_validation->set_rules('lot_wise','Lot Wise' ,'trim|xss_clean');
            $this->form_validation->set_rules('std_lot_size','Standard Lot Size' ,'trim|xss_clean|numeric');
            $this->form_validation->set_rules('expiary_period','Expiary' ,'trim|xss_clean|numeric');
            $this->form_validation->set_rules('qc_flag','Qc Check' ,'trim|xss_clean');
            $this->form_validation->set_rules('imported_flag','Imported' ,'trim|xss_clean');
            $this->form_validation->set_rules('spec_item_flag','For Specification' ,'trim|xss_clean');
            if($this->form_validation->run()==FALSE) {                

              $main_group_id=$this->input->post('main_group');
              $article_group_id=$this->input->post('sub_group');
              $sub_sub_grp_id=$this->input->post('second_sub_group');
                //------------ Main group Dropdown -----------------------
              $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
              //------------SUb Group Dropdown--------------------------
              $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.main_group_id',$main_group_id);           
              //------------Second Sub group dropdown on Sub group------
              $data_second_sub_group=array();
              $data_second_sub_group['article_second_subgroup_master.main_group_id']=$main_group_id;
              $data_second_sub_group['article_second_subgroup_master.article_group_id']=$article_group_id;
              $data['second_sub_group']=$this->second_sub_group_model->select_active_records_where('article_second_subgroup_master',$data_second_sub_group,$this->session->userdata['logged_in']['company_id']);

              //echo $this->db->last_query();
              if(!empty($this->input->post('second_sub_group'))){

               $data['number']=$this->autogenration_article_second_subgroup($main_group_id,$article_group_id,$sub_sub_grp_id);
              }
              else{
                $data['number']=$this->autogeneration_article_sub_group($main_group_id,$article_group_id);
              }
              

              $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);            
              $data['article_short_code']=$this->common_model->select_active_drop_down('article_short_code',$this->session->userdata['logged_in']['company_id']);
              $data['machines_master']=$this->common_model->select_active_drop_down('machines_master',$this->session->userdata['logged_in']['company_id']);
              $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);              
              if($main_group_id==1){
                $this->load->view(ucwords($this->router->fetch_class()).'/create-form-rm-mb',$data);
              }else{
                $this->load->view(ucwords($this->router->fetch_class()).'/create-form-stores-spares',$data);
              }
              $this->load->view('Home/footer');
             
            }else {
             
              $main_group_id=$this->input->post('main_group');
              $article_group_id=$this->input->post('sub_group');
              

              $sub_group=(!empty($this->input->post('sub_group'))) ? $this->input->post('sub_group') : '999999999999999';
              $second_sub_group=(!empty($this->input->post('second_sub_group'))) ? $this->input->post('second_sub_group') : '999999999999999';
              $spec_item_flag = (!empty($this->input->post('spec_item_flag'))) ? $this->input->post('spec_item_flag') : 0;
              $qc_flag = (!empty($this->input->post('qc_flag'))) ? $this->input->post('qc_flag') : 0;
              $imported_flag = (!empty($this->input->post('imported_flag'))) ? $this->input->post('imported_flag') : 0;

              if(!empty($this->input->post('second_sub_group'))){

                $data['second_sub_group']=$this->second_sub_group_model->select_one_active_record('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],'article_second_subgroup_master.sub_sub_grp_id',$second_sub_group);
                foreach($data['second_sub_group'] as $second_sub_group_row){
                  $sales_pur_flag=$second_sub_group_row->sales_pur_flag;
                  $increment_value=$second_sub_group_row->increment_value;
                }

                $table='article_second_subgroup_master';
                $increment_value_new=$increment_value+1;
                $data_incr= array('increment_value' =>$increment_value_new);
                $pkeys=array('main_group_id' =>$this->input->post('main_group'),
                              'article_group_id'=>$this->input->post('sub_group'),
                              'sub_sub_grp_id'=>$this->input->post('second_sub_group')
                            );

              }else if(!empty($this->input->post('sub_group'))){
                $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$sub_group);

                foreach($data['sub_group'] as $sub_group_row){
                  $sales_pur_flag=$sub_group_row->sales_pur_flag;
                   $increment_value=$sub_group_row->increment_value;
                }

                $table='article_group';
                $increment_value_new=$increment_value+1;
                $data_incr= array('increment_value' =>$increment_value_new);
                $pkeys=array('main_group_id' =>$this->input->post('main_group'),
                              'article_group_id'=>$this->input->post('sub_group')                              
                            );

              }else{
                $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$this->input->post('main_group'));
                foreach($data['main_group'] as $main_group_row){
                  $sales_pur_flag=$main_group_row->sales_pur_flag;
                   $increment_value=$main_group_row->increment_value;
                }

                $table='main_group';
                $increment_value_new=$increment_value+1;
                $data_incr= array('increment_value' =>$increment_value_new);
                $pkeys=array('main_group_id' =>$this->input->post('main_group'));

              }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'main_group_id'=>$this->input->post('main_group'),
                          'article_group_id'=>$sub_group,
                          'sub_sub_grp_id'=>$second_sub_group,
                          'article_no'=>$this->input->post('article_no'),
                          'uom'=>$this->input->post('uom'),
                          'excise_rate_id'=>$this->input->post('tariff'),
                          'op_stock'=>$this->common_model->save_number($this->input->post('opening_stock'),$this->session->userdata['logged_in']['company_id']),
                          'op_stock_value'=>$this->common_model->save_number($this->input->post('opening_stock_valuation'),$this->session->userdata['logged_in']['company_id']),
                          'std_lot_size'=>$this->common_model->save_number($this->input->post('std_lot_size'),$this->session->userdata['logged_in']['company_id']),
                          'expiry_period'=>$this->common_model->save_number($this->input->post('expiary_period'),$this->session->userdata['logged_in']['company_id']),
                          'sales_purchase_flag'=>$sales_pur_flag,
                          'spec_item_flag'=>$spec_item_flag,
                          'qc'=>$qc_flag,
                          'imported_flag'=>$imported_flag,'archive'=>'0'
                        );

              $result=$this->common_model->save('article',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'language_id'=>$this->session->userdata['logged_in']['language_id'],
                    'article_no'=>$this->input->post('article_no'),
                    'lang_article_description'=>$this->input->post('lang_article_description'),
                    'main_group_id'=>$this->input->post('main_group'),
                    'article_group_id'=>$sub_group,
                    'sub_sub_grp_id'=>$second_sub_group);

              $result=$this->common_model->save('article_name_info',$data);

              $result=$this->article_model->update_one_active_record_where($table,$data_incr,$pkeys,$this->session->userdata['logged_in']['company_id']);

                //------------ Main group Dropdown -----------------------
              $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
               //------------Sub Group Dropdown--------------------------
              $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.main_group_id',$main_group_id);

               //------------Second Sub group dropdown on Sub group
              $data_second_sub_group=array();
              $data_second_sub_group['article_second_subgroup_master.main_group_id']=$main_group_id;
              $data_second_sub_group['article_second_subgroup_master.article_group_id']=$article_group_id;
              $data['second_sub_group']=$this->second_sub_group_model->select_active_records_where('article_second_subgroup_master',$data_second_sub_group,$this->session->userdata['logged_in']['company_id']);

              if(!empty($this->input->post('second_sub_group'))){

              $data['number']=$this->autogenration_article_second_subgroup($main_group_id,$article_group_id,$this->input->post('second_sub_group'));
              }
              else{
                $data['number']=$this->autogeneration_article_sub_group($main_group_id,$article_group_id);
              }
                                         
              $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);            
              $data['article_short_code']=$this->common_model->select_active_drop_down('article_short_code',$this->session->userdata['logged_in']['company_id']);
              $data['machines_master']=$this->common_model->select_active_drop_down('machines_master',$this->session->userdata['logged_in']['company_id']);
              $data['tariff']=$this->tariff_model->select_active_drop_down('excise_rates_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              $data['uom']=$this->uom_model->select_active_drop_down('uom_master',$this->session->userdata['logged_in']['language_id']);


              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'article');

              $data['note']='Create Transaction Completed';

             // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);              
              if($main_group_id==1){
                $this->load->view(ucwords($this->router->fetch_class()).'/create-form-rm-mb',$data);
              }else{
               $this->load->view(ucwords($this->router->fetch_class()).'/create-form-stores-spares',$data);
              }
              $this->load->view('Home/footer');



            }



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

   public function autogeneration_article_main_group($main_group_id){

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
     $this->load->view(ucwords($this->router->fetch_class()).'/main-group-article-load-option',$data);
  }

  function autogeneration_article_sub_group($main_group_id,$article_group_id){

    $data['autogeneration']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id,'sub_group_id',$article_group_id,'sub_sub_grp_id','');
            if($data['autogeneration']==FALSE){
              
              //$data['default']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id','','sub_group_id','','sub_sub_grp_id','');
              $data_sub_group['main_group_id']=$main_group_id;
              $data_sub_group['article_group_id']=$article_group_id;    

              $data['default']=$this->common_model->select_active_records_where('article_group',$this->session->userdata['logged_in']['company_id'],$data_sub_group);
              //echo $this->db->last_query();
              foreach ($data['default'] as $default_row) {
               
                //$count=str_pad($default_row->curr_val,$default_row->number_of_digits,0,STR_PAD_LEFT);
                $count=str_pad($default_row->increment_value,4,0,STR_PAD_LEFT);
                $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id);
                foreach ($data['main_group'] as $main_group_row) {

                  $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$article_group_id);
                  foreach ($data['sub_group'] as $sub_group_row) {
                    //$data['number']=$main_group_row->lang_short_desc."-".$sub_group_row->sub_group_short_id."-000-".$count;

                    return $main_group_row->lang_short_desc."-".$sub_group_row->sub_group_short_id."-000-".$count;

                  }
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
                  $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$row->sub_group_id);
                foreach ($data['sub_group'] as $sub_group_row) {
                  $sub_group_initial=$sub_group_row->sub_group_short_id.$row->seperator;
                }
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

                $count=$this->common_model->active_record_count_where('article',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id,'article_group_id',$article_group_id,'sub_sub_grp_id','999999999999999');
                $count=$row->step_by+$count+$row->start_value;
                $count=str_pad($count,$row->number_of_digits,0,STR_PAD_LEFT);

                //$data['number']=$main_group_initial.$sub_group_initial.$second_sub_group_initial.$count;
                return $main_group_initial.$sub_group_initial.$second_sub_group_initial.$count;

              }
             
             } 
      
  }
  function autogenration_article_second_subgroup($main_group_id,$article_group_id,$sub_sub_grp_id){

    $data['autogeneration']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id,'sub_group_id',$article_group_id,'sub_sub_grp_id',$sub_sub_grp_id);
    if($data['autogeneration']==FALSE){
      
      //$data['default']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id','','sub_group_id','','sub_sub_grp_id','');

      $data_second_sub_group['main_group_id']=$main_group_id;
      $data_second_sub_group['article_group_id']=$article_group_id;
      $data_second_sub_group['sub_sub_grp_id']=$sub_sub_grp_id;

      $data['default']=$this->common_model->select_active_records_where('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$data_second_sub_group);

      foreach ($data['default'] as $default_row) {
       
        //$count=str_pad($default_row->curr_val,$default_row->number_of_digits,0,STR_PAD_LEFT);
        $count=str_pad($default_row->increment_value,4,0,STR_PAD_LEFT);

        $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id);
        foreach ($data['main_group'] as $main_group_row) {

          $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$article_group_id);
          foreach ($data['sub_group'] as $sub_group_row) {

            $data['second_sub_group']=$this->second_sub_group_model->select_one_active_record('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],'article_second_subgroup_master.sub_sub_grp_id',$sub_sub_grp_id);
            foreach ($data['second_sub_group'] as $second_sub_group_row) {
              return $main_group_row->lang_short_desc."-".$sub_group_row->sub_group_short_id."-".$second_sub_group_row->second_sub_group_short_id."-".$count;
            }
          }
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
          $data['sub_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$row->sub_group_id);
        foreach ($data['sub_group'] as $sub_group_row) {
          $sub_group_initial=$sub_group_row->sub_group_short_id.$row->seperator;
        }
      }else if($row->sub_grp_value==''){
        $sub_group_initial="";
      }else{
        $sub_group_initial=$row->sub_grp_value.$row->seperator;
      }

      if($row->sub_sub_grp_value=='SECSUB'){
            $data['second_sub_group']=$this->second_sub_group_model->select_one_active_record('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],'article_second_subgroup_master.sub_sub_grp_id',$row->sub_sub_grp_id);
            foreach ($data['second_sub_group'] as $second_sub_group_row) {
              $second_sub_group_initial=$second_sub_group_row->second_sub_group_short_id.$row->seperator;
            }
          }else if($row->sub_sub_grp_value==''){
          $second_sub_group_initial="";
        }else{
            $second_sub_group_initial=$row->sub_sub_grp_value.$row->seperator;
        }

        $count=$this->common_model->active_record_count_where('article',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id,'article_group_id',$article_group_id,'sub_sub_grp_id',$sub_sub_grp_id);
        $count=$row->step_by+$count+$row->start_value;
        $count=str_pad($count,$row->number_of_digits,0,STR_PAD_LEFT);

        return $main_group_initial.$sub_group_initial.$second_sub_group_initial.$count;
      }
     
     }
     
  
  }

  public function export_to_excel_tally(){

    require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php');
    require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

    if(empty($this->input->get('from_date')) && empty($this->input->get('to_date'))){
      echo 'From Date and To date Should not Blank';
    }
    else{

          $from=$this->common_model->change_date_format($this->input->get('from_date'),$this->session->userdata['logged_in']['company_id']);
          $to=$this->common_model->change_date_format($this->input->get('to_date'),$this->session->userdata['logged_in']['company_id']);

         
                     
          // $data=array(          
          // 'article_no'=>$this->input->get('article_no');
          // );

         // $data_array = array_filter($data); 

          $data['article']=$this->article_model->active_record_search_tally('article',$data='',$this->session->userdata['logged_in']['company_id'],$from,$to);  

          //echo $this->db->last_query();



          $header_row_styleArray = array(
          'font'  => array(
          'bold'  => true,
          'color' => array('rgb' => 'FFFFFF'),
          'size'  => 14,
          'name'  => 'Calibri',
        ),
        
        'borders' => array(
          'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
          )
        ),

        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
      );

       $merge_cell_alignment = array(
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
      );

      // Hyperlink formating
      $link_style_array = [
        'font'  => [
          'color' => ['rgb' => '0000FF'],
          'underline' => 'single'
        ]

      ];



      $ObjPHPExcel=new PHPExcel();
      $ObjPHPExcel->SetActiveSheetIndex(0);
      $ObjPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20); // Row height
      $ObjPHPExcel->getActiveSheet()->freezePane('A2'); // Freeze Pane
      //Write row in excel START------
      
      // Header Row Generation------------
      $header_row=1;
      $header_columns=array('PARENT GROUP NAME','STOCK ITEM NAME','PART NO','ADDITIONAL DESCRIPTION','UOM','ALT UOM','MAINTAIN IN BATCH.','BATCH NAME','IS GST APPLICABLE','GOODS/SERVICE','HSN DESC','HSN/SAC NO','TAXABILITY','REVERSE CHARGE APPL?','IGST RATE','CGST RATE','SGST RATE','CESS RATE','CLOSING QTY','RATE','VALUE');

      for($header_column_index=0;$header_column_index<count($header_columns);$header_column_index++){

         $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($header_column_index,$header_row,$header_columns[$header_column_index]);
      }
      
     

      $sr_no=1;      
      $excel_sheet_row = 2;
      
      foreach ($data['article'] as $article_row) {        
        $row_column_index=0;  

        $hsn_no='';
        $hsn_desc='';
        $tariff_result=$this->tariff_model->select_one_active_record('excise_rates_master','excise_rates_master.erm_id',$article_row->excise_rate_id,$this->session->userdata['logged_in']['company_id']);
        foreach ($tariff_result as  $tariff_row){
          
          $hsn_no=$tariff_row->cetsh_no;
          $hsn_desc=strtoupper($tariff_row->lang_tariff_descr);
        }       
       
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row, strtoupper(($article_row->sub_group!=''?$article_row->sub_group:$article_row->main_group)));
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,strtoupper($article_row->article_name));
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,$article_row->article_no);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,$article_row->article_sub_description);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,$article_row->uom);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'GOODS');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,$hsn_desc);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,$hsn_no);
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'18');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'9');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'9');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'0');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'0');
        $ObjPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row_column_index++ ,$excel_sheet_row,'0');
                    

        $sr_no++;   
        $excel_sheet_row++;

      }//Foreach


      $directoryName="/var/www/html/erp/tallyserver";
      //$file_name='stock-item-'.date('Y-m-d').'.xls';
      $file_name='stock-item-'.$from.'.xls';
      //$ObjPHPExcel->getActiveSheet()->setTitle('stock-item-'.date('Y-m-d').'');
      $ObjPHPExcel->getActiveSheet()->setTitle('stock-item-'.$from.'');

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="'.$file_name.'"');
      header('Cache-Control: max-age=0');

      //$writer=PHPExcel_IOFactory::createWriter($ObjPHPExcel,'Excel2007');
      $writer=PHPExcel_IOFactory::createWriter($ObjPHPExcel,'Excel5');
      $writer->save('php://output');      
      //$writer->save($directoryName.'/'.$file_name);
      //exit;

    }// Else

  }



  

}