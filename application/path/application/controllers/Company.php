<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Company extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');

      $this->load->model('company_model');

      $this->load->model('country_model');


		}else{

			redirect('login','refresh');

		}

  }



  public function index(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $table='company_master';

    include('pagination.php');

    $data['company']=$this->company_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

  	$this->load->view('Home/header');

  	$this->load->view('Home/nav',$data);

  	$this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

  	$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

  	$this->load->view('Home/footer');

  }







  function modify(){

      $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->uri->segment(3));

      $data['country']=$this->country_model->select_active_drop_down('country_master');

      $data['bank']=$this->common_model->select_active_drop_down_noncompany('bank_master',$this->session->userdata['logged_in']['company_id']);

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

  }



  public function update(){

    $this->form_validation->set_rules('title','Title' ,'required|xss_clean|max_length[64]|strtoupper');

    $this->form_validation->set_rules('short_id','Short Id','required|xss_clean|max_length[2]|strtoupper');

    $this->form_validation->set_rules('street','Street','required|xss_clean|max_length[256]|strtoupper');

    $this->form_validation->set_rules('country','Country','required|xss_clean');

    $this->form_validation->set_rules('postal_code','Postal Code','required|xss_clean|max_length[6]|is_natural');

    $this->form_validation->set_rules('phone_one','Phone No','required|xss_clean|max_length[15]|numeric');

    $this->form_validation->set_rules('phone_two','Secondary Phone No','xss_clean|max_length[15]|numeric');

    $this->form_validation->set_rules('fax_no','Fax No','xss_clean|max_length[20]');

    $this->form_validation->set_rules('email','Email','required|xss_clean|max_length[256]|valid_emails');

    $this->form_validation->set_rules('bank','Bank','required|xss_clean');

    $this->form_validation->set_rules('account_no','Account No','required|xss_clean|max_length[20]|strtoupper');

    $this->form_validation->set_rules('sales_tax_no','Sales Tax No','xss_clean|max_length[20]');

    $this->form_validation->set_rules('incometax_no','Income Tax No','required|xss_clean|max_length[20]');

    $this->form_validation->set_rules('website','Website','required|xss_clean|max_length[64]|strtoupper');



    if($this->form_validation->run()==FALSE){

      $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->input->post('company_id'));

      $data['country']=$this->country_model->select_active_drop_down('country_master');

      $data['bank']=$this->common_model->select_active_drop_down_noncompany('bank_master');

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }else{

      $data=array('title'=>$this->input->post('title'),'short_id'=>$this->input->post('short_id'),'street'=>$this->input->post('street'),'country_code'=>$this->input->post('country'),'post_box_code'=>$this->input->post('postal_code'),'telephone1'=>$this->input->post('phone_one'),'telephone2'=>$this->input->post('phone_two'),'fax'=>$this->input->post('fax_no'),'bank_id'=>$this->input->post('bank'),'account_no'=>$this->input->post('account_no'),'mail_info_contact'=>$this->input->post('email'),'sales_tax_no'=>$this->input->post('sales_tax_no'),'incometax_no'=>$this->input->post('incometax_no'),'home_page'=>$this->input->post('website'),'archive'=>'2');

      $result=$this->common_model->update_one_active_record('company_master',$data,'company_id',$this->input->post('company_id'),$this->session->userdata['logged_in']['company_id']);

        if($result==1){

          $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->input->post('company_id'));

          $data['country']=$this->country_model->select_active_drop_down('country_master');

          $data['bank']=$this->common_model->select_active_drop_down_noncompany('bank_master');

          $data['note']='Update Transaction Completed';

          $data['page_name']='setup';

          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

          $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

          $this->load->view('Home/footer');



        }else{

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


  function parameter(){

      $data['company_parameter']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->uri->segment(3));

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/parameter-form',$data);

      $this->load->view('Home/footer');

  }


  public function parameter_update(){


    $this->form_validation->set_rules('payment_clearance_days','Payment Clearance Day','required|xss_clean|max_length[3]|numeric');

    $this->form_validation->set_rules('discount_clearance_days','Discount Clearance Day','required|xss_clean|max_length[3]|numeric');

    $this->form_validation->set_rules('margin','Margin','required|xss_clean|max_length[3]|numeric');

    $this->form_validation->set_rules('decimal_seperator','Decimal Seperator','required|xss_clean');

    $this->form_validation->set_rules('digit_seperator','Digit Seperator','required|xss_clean');

    $this->form_validation->set_rules('read_format','Read Format','required|xss_clean');

    $this->form_validation->set_rules('decimal_places','Decimal Places','required|xss_clean');

    
    if($this->form_validation->run()==FALSE){

      $data['company_parameter']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->input->post('company_id'));


      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/parameter-form',$data);

      $this->load->view('Home/footer');

    }else{

      $config['upload_path'] ='./uploads/'.$this->input->post('company_id');
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = '2048';
      $config['max_width']  = '200';
      $config['max_height']  = '150';
      $this->load->library('upload',$config);
      $this->upload->initialize($config);

      if($this->upload->do_upload('logo')){
        $data= $this->upload->data();
        $filename=$data['file_name'];
      }else{
        $filename='';
      }

        $data=array('logo'=>$filename,'payment_clearance_days'=>$this->input->post('payment_clearance_days'),'discount_clearance_days'=>$this->input->post('discount_clearance_days'),'margin'=>$this->input->post('margin'),'decimal_seperator'=>$this->input->post('decimal_seperator'),'digit_seperator'=>$this->input->post('digit_seperator'),'read_format'=>$this->input->post('read_format'),'decimal_places'=>$this->input->post('decimal_places'));
      

        $result=$this->common_model->update_one_active_record('company_system_parameters',$data,'company_id',$this->input->post('company_id'),$this->session->userdata['logged_in']['company_id']);
        

        if($result==1){

          $data['company_parameter']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->input->post('company_id'));

          $data['error']=$this->upload->display_errors();

          $data['note']='Update Transaction Completed';

          $data['page_name']='setup';

          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

          $this->load->view(ucwords($this->router->fetch_class()).'/parameter-form',$data);

          $this->load->view('Home/footer');



        }else{

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






}
