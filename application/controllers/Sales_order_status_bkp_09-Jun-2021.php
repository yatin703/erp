<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_status extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('fiscal_model'); 
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('relate_model');
      $this->load->library('excel');
           
     

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
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_status');

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='order_master';
            include('pagination.php');
            
            //$data['order_master']=$this->customer_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_status');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
           

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_status');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('adr_company_id','Company Name' ,'trim|xss_clean|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Contract Packer' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('order_no','Sales order' ,'trim|xss_clean');
            $this->form_validation->set_rules('for_export','Domestic/Export' ,'trim|xss_clean');
            $this->form_validation->set_rules('order_flag','Order Type' ,'trim|xss_clean');
            $this->form_validation->set_rules('for_sampling','For Sample' ,'trim|xss_clean');
            $this->form_validation->set_rules('final_approval_flag','Approval Status' ,'trim|xss_clean');
            $this->form_validation->set_rules('order_closed','Order Status' ,'trim|xss_clean');
            $this->form_validation->set_rules('trans_closed','Transaction Status' ,'trim|xss_clean');


            if($this->form_validation->run()==FALSE){

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                if(!empty($this->input->post('adr_company_id'))){

                  $customer_arr=explode('//',$this->input->post('adr_company_id'));
                  $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                  $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                  $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                }

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

                  $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                  $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);

                  $for_export=$this->input->post('for_export');
                  $for_sampling=$this->input->post('for_sampling');
                  $final_approval_flag=$this->input->post('final_approval_flag');
                  $order_closed=$this->input->post('order_closed');
                  $trans_closed=$this->input->post('trans_closed');
                  
                  $search=array();
                  
                  if(!empty($this->input->post('adr_company_id'))){
                     $arr=explode('//',$this->input->post('adr_company_id'));
                     $search['customer_no']=$arr[1];
                  }

                  if(!empty($this->input->post('consin_adr_company_id'))){
                     $arr=explode('//',$this->input->post('consin_adr_company_id'));
                     $consignee=$arr[1].'|';
                      $search['consin_adr_company_id']=$consignee;
                  }

                  if(!empty($this->input->post('order_no'))){                    
                     $search['order_no']=$this->input->post('order_no');
                  }
                  if($for_export!=''){
                      $search['for_export']=$for_export;
                  }
                   if($for_sampling!=''){
                      $search['for_sampling']=$for_sampling;
                  }
                   if($final_approval_flag!=''){
                      $search['final_approval_flag']=$final_approval_flag;
                  }

                  if($order_closed!=''){
                      $search['order_closed']=$order_closed;
                  }
                  
                  if($trans_closed!=''){
                      $search['trans_closed']=$trans_closed;
                  }
                  
                  if($this->input->post('order_flag')!=''){
                      $search['order_flag']=$this->input->post('order_flag');
                  }
                               

                 $data['order_master']=$this->sales_order_status_model->active_record_search('order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
                                 
                 
                if($data['order_master']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_status');
                    $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                   $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

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
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_status');
                      
                      $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                      $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                      
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
      $data['customer']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id ',$customer_code[1]);
      
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
      if($str!=''){
        $article=explode('//',$str);
        if(!empty($article[1])){
          $data['article']=$this->common_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_no',$article[1]);
          foreach ($data['article'] as $article_row) {

            if ($article_row->article_no == $article[1]){
            return TRUE;
            }else{
            $this->form_validation->set_message('article_no', 'The {field} field is incorrect');
            return FALSE;
            }
          } 

        }else{
          $this->form_validation->set_message('article_no', 'The {field} field is incorrect');
          return FALSE;
        } 

      }
     
  }

  public function download_to_excel(){

    //$this->load->model('common_model'); 
    //$this->load->helper(array('form', 'url'));
    //$this->load->helper('download');
    $this->load->library('PHPReport');

    // get data from databse
    //$table='rss_customer';
    //$data = $this->common_model->GetDataForExcel($table);

    $search_data=array();

    if(!empty($this->input->get('from_date'))){
      $from=$this->common_model->change_date_format($this->input->get('from_date'),$this->session->userdata['logged_in']['company_id']);

    }
    if(!empty($this->input->get('to_date'))){

      $to=$this->common_model->change_date_format($this->input->get('to_date'),$this->session->userdata['logged_in']['company_id']);

    }
    if(!empty($this->input->get('adr_company_id'))){
      $arr=explode("//",$this->input->get('adr_company_id'));
      $search_data['customer_no']=$arr[1];

    }
    if(!empty($this->input->get('consin_adr_company_id'))){
      $arr=explode("//",$this->input->get('consin_adr_company_id'));
      $search_data['consin_adr_company_id']=$arr[1];

    }
    if(!empty($this->input->get('article_no'))){
      $search_data['article_no']=$this->input->get('article_no');

    }
    if(!empty($this->input->get('order_no'))){
      $search_data['order_no']=$this->input->get('order_no');

    }
    if(!empty($this->input->get('for_export'))){
      $search_data['for_export']=$this->input->get('for_export');

    }
    if(!empty($this->input->get('for_sampling'))){
      $search_data['for_sampling']=$this->input->get('for_sampling');

    }
    if(!empty($this->input->get('final_approval_flag'))){
      $search_data['final_approval_flag']=$this->input->get('final_approval_flag');

    }
    if(!empty($this->input->get('order_closed'))){
      $search_data['order_closed']=$this->input->get('order_closed');

    }
     if(!empty($this->input->get('trans_closed'))){
      $search_data['trans_closed']=$this->input->get('trans_closed');

    }


    if($from!='' && $to!=''){
    
      $data= $this->sales_order_status_model->active_record_for_excel('order_master',$search_data,$from,$to,$this->session->userdata['logged_in']['company_id']);
      echo $this->db->last_query();

      $template = 'sales_order_book.xlsx';
      //set absolute path to directory with template files
      $templateDir = __DIR__ . "/excel_templates/";

        //set config for report
      $config = array(
        'template' => $template,
        'templateDir' => $templateDir
      );

        //load template
      $R = new PHPReport($config);

      $R->load(array(
          'id' => 'sales_order_book',
          'repeat' => TRUE,
          'data' => $data
          )
      );

        // define output directoy 
      $output_file_dir = $templateDir;
      //$output_file_dir = "";

        //Tp Save a copy to root folder of project directory un-comment below code:
      $filename = $output_file_dir."sales_order_book"."__halt_compiler()".date('d_m_y_h_i_s_a').".xlsx";
      $a = "sales_order_book_"."_".date('d_m_y_h_i_s_a').".xlsx";
        
        //unlink(__DIR__ . "/excel_templates/".$filename);

        //download excel sheet with data in /tmp folder
        $result = $R->render('excel', $filename);
        
        //To download Excel in local Machine un-comment below code:
        $file_content = file_get_contents($filename); // Read the file's contents
        if(file_exists($filename)){
          unlink($filename);
        }
        force_download($a, $file_content);

        //force_download($filename, NULL);

      }
      

    
  }

 
  

}