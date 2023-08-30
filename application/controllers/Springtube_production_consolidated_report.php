<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_production_consolidated_report extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_item_parameterwise_model');
      $this->load->model('springtube_production_consolidated_report_model');
      $this->load->model('job_card_model');
      $this->load->model('country_model');
      $this->load->model('customer_model');
      $this->load->model('tax_grid_model');
      $this->load->model('relate_model');
      $this->load->model('specification_model');
      $this->load->model('property_model');
      $this->load->model('article_model');
      //$this->load->library("cart");
      $this->load->model('process_model');
      $this->load->model('bill_of_material_model');
      $this->load->model('uom_model');
      $this->load->model('artwork_model');
      $this->load->model('fiscal_model');
      $this->load->model('process_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_extrusion_production_model');
      
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
            $table='production_master';
            include('pagination.php');
            $data['job_card']=$this->job_card_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            //$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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


  function search(){
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           

            // $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            // $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            // $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            // $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            // $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
            // $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            // $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            

            //$data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                
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


    
  function search_result(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('adr_company_id','Company Name' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Contract Packer' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('order_no','Sales order' ,'trim|xss_clean');
            // $this->form_validation->set_rules('for_export','Order Type' ,'trim|xss_clean');
            // $this->form_validation->set_rules('order_flag','Order Flag' ,'trim|xss_clean');
            // $this->form_validation->set_rules('sleeve_diameter','Sleeve Diameter' ,'xss_clean|strtoupper');
            // $this->form_validation->set_rules('sleeve_print_type','Sleeve Print Type' ,'xss_clean|strtoupper');
            // $this->form_validation->set_rules('shoulder_type','Shoulder type' ,'xss_clean|strtoupper');
            // $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'xss_clean|strtoupper');
            // $this->form_validation->set_rules('cap_orifice','Cap Orifice' ,'xss_clean|strtoupper');
            // $this->form_validation->set_rules('cap_finish','Cap finish' ,'xss_clean|strtoupper');
            // $this->form_validation->set_rules('for_sampling','For Sample' ,'trim|xss_clean');
            // $this->form_validation->set_rules('final_approval_flag','Approval Status' ,'trim|xss_clean');
            // $this->form_validation->set_rules('order_closed','Order Status' ,'trim|xss_clean');
            // $this->form_validation->set_rules('trans_closed','Transaction Status' ,'trim|xss_clean');
            // $this->form_validation->set_rules('order_by','Sort Order By' ,'trim|xss_clean');
            

            if($this->form_validation->run()==FALSE){

              if(!empty($this->input->post('adr_company_id'))){

                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                if(!empty($customer_arr[1])){
                  $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                }
                
              }

                // $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                // $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                // $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                // $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                // $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
                // $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                // $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

                $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            


                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

                  $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                  $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);

                  $search=array();
                  if(!empty($this->input->post('adr_company_id'))){
                     $arr=explode('//',$this->input->post('adr_company_id'));
                     $search['customer_no']=$arr[1];
                  }

                  // if(!empty($this->input->post('consin_adr_company_id'))){
                  //    $arr=explode('//',$this->input->post('consin_adr_company_id'));
                  //    $consignee=$arr[1].'|';
                  //     $search['consin_adr_company_id']=$consignee;
                  // }
                  if(!empty($this->input->post('order_no'))){
                     $search['order_master.order_no']=$this->input->post('order_no');
                  }
                  // if(!empty($this->input->post('for_export'))){
                  //     $search['order_master.for_export']=$this->input->post('for_export');
                  // }
                  if(!empty($this->input->post('article_no'))){

                    $arr=explode("//",$this->input->post('article_no'));
                    $article_no=$arr[1];

                    $search['order_details.article_no']=$article_no;

                  }
                  // if(!empty($this->input->post('order_flag'))){
                  //     $search['order_master.order_flag']=$this->input->post('order_flag');
                  // }
                  // if(!empty($this->input->post('for_sampling'))){
                  //     $search['order_master.for_sampling']=$this->input->post('for_sampling');
                  // }
                  // if(!empty($this->input->post('final_approval_flag'))){
                  //     $search['order_master.final_approval_flag']=$this->input->post('final_approval_flag');
                  // }
                  // if(!empty($this->input->post('order_closed'))){
                  //     $search['order_master.order_closed']=$this->input->post('order_closed');
                  // }
                  // if(!empty($this->input->post('trans_closed'))){
                  //     $search['order_master.trans_closed']=$this->input->post('trans_closed');
                  // }
                  // $order_by='';                   
                  // if(!empty($this->input->post('order_by'))){
                  //   $order_by=$this->input->post('order_by');
                  // }
                  //  if(!empty($this->input->post('user_id'))){
                  //     $search['order_master.user_id']=$this->input->post('user_id');
                  // }
                                                      

                 $data['order_master']=$this->springtube_production_consolidated_report_model->active_record_search('order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
                  //echo $this->db->last_query();
                 
                if($data['order_master']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                     // $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                     //  $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                     //  $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                     //  $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                     //  $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
                     //  $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                     //  $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

                      $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);           


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
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                      // $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      // $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                      // $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                      // $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                      // $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
                      // $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                      // $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                      $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            
                      
                      $data['error']='No record in search transaction';
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

   public function customer_check($str){
    if(!empty($str)){
    $customer_code=explode('//',$str);
    if(!empty($customer_code[1])){
    $data['customer']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'name1',$customer_code[0]);
    foreach ($data['customer'] as $customer_row) {

      if ($customer_row->adr_company_id == $customer_code[1]){
        return TRUE;
      }else{
        $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
        return FALSE;
        }
      } 
    }else{
        $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
        return FALSE;
        }
    } 
  }

  public function article_check($str){

      if(!empty($str)){
      $item_code=explode('//',$str);
      if(!empty($item_code[1])){
      $data['item']=$this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info',$this->session->userdata['logged_in']['company_id'],'lang_article_description',$item_code[0]);
      //echo $this->db->last_query();

      foreach ($data['item'] as $item_row) {
        if (strtoupper($item_row->article_no) == strtoupper($item_code[1])){
          return TRUE;
        }else{
          $this->form_validation->set_message('article_check', 'The {field} field is incorrect');
          return FALSE;
          }
        } 
      }else{
          $this->form_validation->set_message('article_check', 'The {field} field is incorrect');
          return FALSE;
        }
      } 
    }




}