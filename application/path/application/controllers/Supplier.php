<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('supplier_model');
      $this->load->model('country_model');
      $this->load->model('state_model');
      $this->load->model('payment_term_model');

		}else{
			redirect('login','refresh');
		}
  }

  function index(){
  	$data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
    	if($module_row->module_name==='Purchase'){
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='address_master';
            include('pagination_supplier.php');
            $data['supplier']=$this->supplier_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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


  function view(){
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$this->uri->segment(3));
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

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['country']=$this->country_model->select_active_drop_down('country_master');

            $data['property']=$this->supplier_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

            $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

            $data['payment_term']=$this->supplier_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);

            $data['bank']=$this->supplier_model->select_active_bank_drop_down('bank_master');

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

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $this->form_validation->set_rules('name1','Company Name' ,'required|trim|xss_clean|is_unique[address_master.name1]|max_length[150]|strtoupper');
            $this->form_validation->set_rules('strno','Gala/Flat/House No' ,'trim|xss_clean|max_length[9]|strtoupper');
            $this->form_validation->set_rules('name2','Society/Building' ,'trim|xss_clean|max_length[100]|strtoupper');
            $this->form_validation->set_rules('street','Street' ,'trim|xss_clean|max_length[150]|strtoupper');
            $this->form_validation->set_rules('name3','Area' ,'required|trim|xss_clean|max_length[500]|strtoupper');
            $this->form_validation->set_rules('city_code','Pincode' ,'trim|xss_clean');

            $this->form_validation->set_rules('country','Country' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('state','State' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('email','Email' ,'required|trim|xss_clean|max_length[200]|valid_emails|strtolower');
            $this->form_validation->set_rules('telephone1','Telephone One' ,'required|trim|xss_clean|max_length[50]');

            $this->form_validation->set_rules('property','Property' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('transit_days','Transit Days' ,'required|trim|xss_clean|max_length[3]|is_natural');

            if($this->input->post('country')==1){

              $this->form_validation->set_rules('post_box_code','Pan No' ,'required|trim|xss_clean|exact_length[10]|alpha_numeric|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]|strtoupper');

              $this->form_validation->set_rules('isdn_local','Gst No' ,'required|trim|xss_clean|alpha_numeric|strtoupper');
            }

            $this->form_validation->set_rules('payment_term','Payment Term' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('bank','Bank' ,'trim|xss_clean|required');

            $this->form_validation->set_rules('account_type','Account Type' ,'trim|xss_clean|max_length[20]');
            $this->form_validation->set_rules('account_no','Account No' ,'trim|xss_clean|max_length[35]|required');


            if($this->form_validation->run()==FALSE){

            $data['country']=$this->country_model->select_active_drop_down('country_master');

            $data['property']=$this->supplier_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

            $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

            $data['payment_term']=$this->supplier_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);

            $data['bank']=$this->supplier_model->select_active_bank_drop_down('bank_master');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

               //$adr_company_id=$this->customer_model->select_max_adr_company_key('address_master',$this->session->userdata['logged_in']['company_id']);

              $adr_company_id='';
              $address_master_result=$this->supplier_model->select_max_adr_company_key('address_master',$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
              foreach ($address_master_result as  $address_master_row) {
                $adr_company_id=$address_master_row->adr_company_id;
              }


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'name1'=>$this->input->post('name1'),
                    'strno'=>$this->input->post('strno'),
                    'name2'=>$this->input->post('name2'),
                    'street'=>$this->input->post('street'),
                    'name3'=>$this->input->post('name3'),
                    'city_code'=>$this->input->post('city_code'),
                    'country_id'=>$this->input->post('country'),
                    'zip_code'=>$this->input->post('state'),
                    'email'=>$this->input->post('email'),
                    'telephone1'=>$this->input->post('telephone1'),
                    'telephone2'=>$this->input->post('telephone2'),
                    'adr_company_id'=>$adr_company_id,
                    'isdn_local'=>$this->input->post('isdn_local'),
                    'post_box_code'=>$this->input->post('post_box_code'),
                    'transit_days'=>$this->input->post('transit_days'),
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'contact_date'=>date('Y-m-d'));

                    $result=$this->common_model->save('address_master',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'payment_condition_id'=>$this->input->post('payment_term'),
                    'property_id'=>$this->input->post('property'),
                    'bank_id'=>$this->input->post('bank'),
                    'account_no'=>$this->input->post('account_no'),
                    'account_type'=>$this->input->post('account_type'),
                    'adr_company_id'=>$adr_company_id,
                    'master_property_id'=>'2',
                    'timestamp'=>date('Y-m-d H:i:s'));

                    $result=$this->common_model->save('address_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'adr_company_id'=>$adr_company_id,
                    'language_id'=>$this->session->userdata['logged_in']['language_id']);

                    $result=$this->common_model->save('address_master_lang',$data);

              //tally Supplier Master to Ledger master SQl Integration---------

                    $name='';
                    $under_group='Sundry Creditors';
                    $default_credit_period='';
                    $maintain_balance_bill_by_bill='Yes';
                    $is_tds_deductable='No';
                    $treat_as_tds_expense='';
                    $deductee_type='';
                    $deduct_tds_on_same_voucher='';
                    $mailing_name='';
                    $address='';
                    $address_1='';
                    $address_2='';
                    $address_3='';
                    $country='';
                    $state='';
                    $pincode='';
                    $contact_person='';
                    $phone_no='';
                    $mobile_no='';
                    $fax_no='';
                    $email='';
                    $cc='account@3d-neopac.com';
                    $website='';
                    $provide_bank_details='';
                    $bank='';
                    $account_no='';
                    $ifsc_code='';                    
                    $pan_no='';
                    $registration_type='Regular';
                    $gstin='';
                    $party_type='Not Applicable';
                    $is_transporter='No';
                    $transaction_date=date('Y-m-d');


                    $name=strtoupper($this->input->post('name1'));                    

                    $payment_term_result=$this->payment_term_model->select_one_active_record('payment_condition_master','id',$this->input->post('payment_term'),$this->session->userdata['logged_in']['language_id']);

                    foreach ($payment_term_result as  $payment_term_row) {
                      $default_credit_period=$payment_term_row->net_days;
                    }

                    $mailing_name=strtoupper($this->input->post('name1'));

                    $address='';
                    if($this->input->post('strno')!=''){
                      $address.=$this->input->post('strno').', ';
                    }
                    if($this->input->post('name2')!=''){        
                      $address.=$this->input->post('name2').', ';
                    }
                    if($this->input->post('street')!=''){
                      $address.=$this->input->post('street').', ';
                    }
                    
                    $address.=$this->input->post('name3');

                    $address_1=substr($address,0,52);
                    $address_2=substr($address,52,52);
                    $address_3=substr($address,104,52);
                    $address_3=($address_3=='0'?'':$address_3);

                    $country_result=$this->country_model->select_one_active_record('country_master','country_master.country_id',$this->input->post('country'));
                    foreach ($country_result as  $country_row) {
                      $country=ucfirst(strtolower($country_row->lang_country_name));
                    }

                    $state_result=$this->state_model->select_one_active_record('zip_code_master','zip_code',$this->input->post('state'),$this->session->userdata['logged_in']['language_id']);

                    foreach ($state_result as $state_row) {
                      $state=ucfirst(strtolower($state_row->lang_city));
                    }

                    $pincode=$this->input->post('city_code');
                    $phone_no=$this->input->post('telephone1');
                    $mobile_no=$this->input->post('telephone2');
                    $email=$this->input->post('email');

                    if($this->input->post('bank')!=''){
                      $provide_bank_details='Yes';
                      $bank_result=$this->common_model->select_one_active_record_noncompany('bank_master','bank_id',$this->input->post('bank'));
                      foreach ($bank_result as $bank_row) {
                        $bank=strtoupper($bank_row->bank_name);
                        $ifsc_code=$bank_row->bank_code;
                      }

                    }else{
                       $provide_bank_details='No';
                    }

                    $account_no=$this->input->post('account_no');
                    $pan_no=$this->input->post('post_box_code');
                    $gstin=$this->input->post('isdn_local');


                    $data=array('name'=>$name,
                                'under_group'=>$under_group,
                                'default_credit_period'=>$default_credit_period,
                                'maintain_balance_bill_by_bill'=>$maintain_balance_bill_by_bill,
                                'is_tds_deductable'=>$is_tds_deductable,
                                'treat_as_tds_expense'=>$treat_as_tds_expense,
                                'deductee_type'=>$deductee_type,
                                'deduct_tds_on_same_voucher'=>$deduct_tds_on_same_voucher,
                                'mailing_name'=>$mailing_name,
                                'address_1'=>$address_1,
                                'address_2'=>$address_2,
                                'address_3'=>$address_3,
                                'country'=>$country,
                                'state'=>$state,
                                'pincode'=>$pincode,
                                'contact_person'=>$contact_person,
                                'phone_no'=>$phone_no,
                                'mobile_no'=>$mobile_no,
                                'fax_no'=>$fax_no,
                                'email'=>$email,
                                'cc'=>$cc,
                                'website'=>$website,
                                'provide_bank_details'=>$provide_bank_details,
                                'bank'=>$bank,
                                'account_no'=>$account_no,
                                'ifsc_code'=>$ifsc_code,
                                'pan_no'=>$pan_no,
                                'registration_type'=>$registration_type,
                                'gstin'=>$gstin,
                                'party_type'=>$party_type,
                                'is_transporter'=>$is_transporter,
                                'transaction_date'=>$transaction_date
                              );

                    $result=$this->common_model->save('tally_ledger_master',$data);
              //----------------------------------------------------------------





                    $data['page_name']='Purchase';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

                    $data['note']='Create Transaction Completed';

                    header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                    $data['country']=$this->country_model->select_active_drop_down('country_master');

                    $data['property']=$this->supplier_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

                    $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

                    $data['payment_term']=$this->supplier_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);

                    $data['bank']=$this->supplier_model->select_active_bank_drop_down('bank_master');

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



  function archive_records(){
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            $table='address_master';
            include('pagination_archive_supplier.php');
            $data['supplier']=$this->supplier_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/archive-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);
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
    }
    else{
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


  function modify(){
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$this->uri->segment(3));

            //echo $this->db->last_query();

            $data['country']=$this->country_model->select_active_drop_down('country_master');

            $data['property']=$this->supplier_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

            $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

            $data['payment_term']=$this->supplier_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);

            $data['bank']=$this->supplier_model->select_active_bank_drop_down('bank_master');
              
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
      $data['page_name']='Purchase';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Purchase'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){
              $this->form_validation->set_rules('name1','Company Name' ,'required|trim|xss_clean|max_length[150]|strtoupper');
              $this->form_validation->set_rules('strno','Gala/Flat/House No' ,'trim|xss_clean|max_length[9]|strtoupper');
              $this->form_validation->set_rules('name2','Society/Building' ,'trim|xss_clean|max_length[100]|strtoupper');
              $this->form_validation->set_rules('street','Street' ,'trim|xss_clean|max_length[150]|strtoupper');
              $this->form_validation->set_rules('name3','Area' ,'required|trim|xss_clean|max_length[500]|strtoupper');

              $this->form_validation->set_rules('city_code','Pincode' ,'trim|xss_clean|max_length[6]|is_natural');

              $this->form_validation->set_rules('country','Country' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('state','State' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('email','Email' ,'required|trim|xss_clean|max_length[200]|valid_emails|strtolower');
              $this->form_validation->set_rules('telephone1','Telephone One' ,'required|trim|xss_clean|max_length[50]');

              $this->form_validation->set_rules('property','Property' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('transit_days','Transit Days' ,'required|trim|xss_clean|max_length[3]|is_natural');

              if($this->input->post('country')==1){


              $this->form_validation->set_rules('post_box_code','Pan No' ,'required|trim|xss_clean|exact_length[10]|alpha_numeric|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]|strtoupper');

              $this->form_validation->set_rules('isdn_local','Gst No' ,'required|trim|xss_clean|alpha_numeric|strtoupper');

              //$this->form_validation->set_rules('isdn_local','Gst No' ,'required|trim|xss_clean|exact_length[15]|alpha_numeric|strtoupper');

              //$this->form_validation->set_rules('isdn_local','Gst No' ,'required|trim|xss_clean|exact_length[15]|alpha_numeric|strtoupper|regex_match[/^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9a-zA-Z]){1}([Z]){1}([0-9]){1}?$/]');
              }
              $this->form_validation->set_rules('payment_term','Payment Term' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bank','Bank' ,'trim|xss_clean');

              $this->form_validation->set_rules('account_type','Account Type' ,'trim|xss_clean|max_length[20]');
              $this->form_validation->set_rules('account_no','Account No' ,'trim|xss_clean|max_length[35]');
              

              if($this->form_validation->run()==FALSE){

                $data['supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$this->input->post('adr_company_id'));

                $data['country']=$this->country_model->select_active_drop_down('country_master');

                $data['property']=$this->supplier_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

                $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

                $data['payment_term']=$this->supplier_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);

                $data['bank']=$this->supplier_model->select_active_bank_drop_down('bank_master');

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                $name='';
                $new_name='';

                $data['supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$this->input->post('adr_company_id'));
                foreach ($data['supplier'] as $supplier_row) {
                  $name= strtoupper($supplier_row->name1);
                }

                $new_name=strtoupper($this->input->post('name1'));
                
                $data=array(
                    'name1'=>$this->input->post('name1'),
                    'strno'=>$this->input->post('strno'),
                    'name2'=>$this->input->post('name2'),
                    'street'=>$this->input->post('street'),
                    'name3'=>$this->input->post('name3'),
                    'city_code'=>$this->input->post('city_code'),
                    'country_id'=>$this->input->post('country'),
                    'zip_code'=>$this->input->post('state'),
                    'email'=>$this->input->post('email'),
                    'telephone1'=>$this->input->post('telephone1'),
                    'telephone2'=>$this->input->post('telephone2'),
                    'isdn_local'=>$this->input->post('isdn_local'),
                    'post_box_code'=>$this->input->post('post_box_code'),
                    'transit_days'=>$this->input->post('transit_days'),
                    'archive'=>'2',
                    'user_id'=>$this->session->userdata['logged_in']['user_id']);

                $result=$this->common_model->update_one_active_record('address_master',$data,'adr_company_id',$this->input->post('adr_company_id'),$this->session->userdata['logged_in']['company_id']);

                $data=array(
                    'payment_condition_id'=>$this->input->post('payment_term'),
                    'property_id'=>$this->input->post('property'),
                    'bank_id'=>$this->input->post('bank'),
                    'account_no'=>$this->input->post('account_no'),
                    'account_type'=>$this->input->post('account_type'),
                    'timestamp'=>date('Y-m-d H:i:s'));

                $result=$this->common_model->update_one_active_record('address_details',$data,'adr_company_id',$this->input->post('adr_company_id'),$this->session->userdata['logged_in']['company_id']);

                

                //tally Supplier Master to Ledger master SQl Integration---------


                    //$name='';
                    $under_group='Sundry Creditors';
                    $default_credit_period='';
                    $maintain_balance_bill_by_bill='Yes';
                    $is_tds_deductable='No';
                    $treat_as_tds_expense='';
                    $deductee_type='';
                    $deduct_tds_on_same_voucher='';
                    $mailing_name='';
                    $address='';
                    $address_1='';
                    $address_2='';
                    $address_3='';
                    $country='';
                    $state='';
                    $pincode='';
                    $contact_person='';
                    $phone_no='';
                    $mobile_no='';
                    $fax_no='';
                    $email='';
                    $cc='';
                    $website='';
                    $provide_bank_details='';
                    $bank='';
                    $account_no='';
                    $ifsc_code='';                    
                    $pan_no='';
                    $registration_type='Regular';
                    $gstin='';
                    $party_type='Not Applicable';
                    $is_transporter='No';
                    $transaction_date=date('Y-m-d');


                    //$name=strtoupper($this->input->post('name1'));

                    $payment_term_result=$this->payment_term_model->select_one_active_record('payment_condition_master','id',$this->input->post('payment_term'),$this->session->userdata['logged_in']['language_id']);

                    foreach ($payment_term_result as  $payment_term_row) {
                      $default_credit_period=$payment_term_row->net_days;
                    }
                    $mailing_name=strtoupper($this->input->post('name1'));

                    $address='';
                    if($this->input->post('strno')!=''){
                      $address.=$this->input->post('strno').', ';
                    }
                    if($this->input->post('name2')!=''){        
                      $address.=$this->input->post('name2').', ';
                    }
                    if($this->input->post('street')!=''){
                      $address.=$this->input->post('street').', ';
                    }
                    
                    $address.=$this->input->post('name3');

                    $address_1=substr($address,0,52);
                    $address_2=substr($address,52,52);
                    $address_3=substr($address,104,52);
                    $address_3=($address_3=='0'?'':$address_3);

                    $country_result=$this->country_model->select_one_active_record('country_master','country_master.country_id',$this->input->post('country'));
                    foreach ($country_result as  $country_row) {
                      $country=ucfirst(strtolower($country_row->lang_country_name));
                    }

                    $state_result=$this->state_model->select_one_active_record('zip_code_master','zip_code',$this->input->post('state'),$this->session->userdata['logged_in']['language_id']);

                    foreach ($state_result as $state_row) {
                      $state=ucfirst(strtolower($state_row->lang_city));
                    }

                    $pincode=$this->input->post('city_code');
                    $phone_no=$this->input->post('telephone1');
                    $mobile_no=$this->input->post('telephone2');
                    $email=$this->input->post('email');

                    if($this->input->post('bank')!=''){
                      $provide_bank_details='Yes';
                      $bank_result=$this->common_model->select_one_active_record_noncompany('bank_master','bank_id',$this->input->post('bank'));
                      foreach ($bank_result as $bank_row) {
                        $bank=strtoupper($bank_row->bank_name);
                        $ifsc_code=$bank_row->bank_code;
                      }

                    }else{
                       $provide_bank_details='No';
                    }

                    $account_no=$this->input->post('account_no');
                    $pan_no=$this->input->post('post_box_code');
                    $gstin=$this->input->post('isdn_local');


                    $data=array('name'=>$name,'under_group'=>$under_group);
                    $tally_ledger_master_result=$this->common_model->select_active_records_nocompany_noarchive_where('tally_ledger_master',$data);

                    $id=0;
                    // if($tally_ledger_master_result){
                    //   foreach ($tally_ledger_master_result as  $tally_ledger_master_row) {
                    //     $id=$tally_ledger_master_row->id;
                    //   }

                      $data=array('name'=>$name,
                                'new_name'=>$new_name,
                                'under_group'=>$under_group,
                                'default_credit_period'=>$default_credit_period,
                                'maintain_balance_bill_by_bill'=>$maintain_balance_bill_by_bill,
                                'is_tds_deductable'=>$is_tds_deductable,
                                'treat_as_tds_expense'=>$treat_as_tds_expense,
                                'deductee_type'=>$deductee_type,
                                'deduct_tds_on_same_voucher'=>$deduct_tds_on_same_voucher,
                                'mailing_name'=>$mailing_name,
                                'address_1'=>$address_1,
                                'address_2'=>$address_2,
                                'address_3'=>$address_3,
                                'country'=>$country,
                                'state'=>$state,
                                'pincode'=>$pincode,
                                'contact_person'=>$contact_person,
                                'phone_no'=>$phone_no,
                                'mobile_no'=>$mobile_no,
                                'fax_no'=>$fax_no,
                                'email'=>$email,
                                'cc'=>$cc,
                                'website'=>$website,
                                'provide_bank_details'=>$provide_bank_details,
                                'bank'=>$bank,
                                'account_no'=>$account_no,
                                'ifsc_code'=>$ifsc_code,
                                'pan_no'=>$pan_no,
                                'registration_type'=>$registration_type,
                                'gstin'=>$gstin,
                                'party_type'=>$party_type,
                                'is_transporter'=>$is_transporter,
                                'transaction_date'=>$transaction_date
                              );

                     // $result=$this->common_model->save('tally_ledger_master',$data); 


                    //}


              //----------------------------------------------------------------
                  $data['supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$this->input->post('adr_company_id'));

                  $data['page_name']='Purchase';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

                  $data['country']=$this->country_model->select_active_drop_down('country_master');

                  $data['property']=$this->supplier_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

                  $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

                  $data['payment_term']=$this->supplier_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);

                  $data['bank']=$this->supplier_model->select_active_bank_drop_down('bank_master');

                  $data['note']='Update Transaction Completed';
                  //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
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

      $data['page_name']='Purchase';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Purchase'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->common_model->archive_one_record('address_master',$data,'adr_company_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['supplier']=$this->supplier_model->select_one_inactive_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$this->uri->segment(3));

                  $data['country']=$this->country_model->select_active_drop_down('country_master');

                  $data['property']=$this->supplier_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

                  $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

                  $data['payment_term']=$this->supplier_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);

                  $data['bank']=$this->supplier_model->select_active_bank_drop_down('bank_master');
                
                  $data['page_name']='Purchase';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

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
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){
                 $data=array('archive'=>'2');
                 $result=$this->common_model->archive_one_record('address_master',$data,'adr_company_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                $data['supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$this->uri->segment(3));


                  $data['page_name']='Purchase';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

                  $data['country']=$this->country_model->select_active_drop_down('country_master');

                  $data['property']=$this->supplier_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

                  $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

                  $data['payment_term']=$this->supplier_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);

                  $data['bank']=$this->supplier_model->select_active_bank_drop_down('bank_master');
                  

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

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['country']=$this->country_model->select_active_drop_down('country_master');

            $data['property']=$this->supplier_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

            $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

            $data['payment_term']=$this->supplier_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);

            $data['bank']=$this->supplier_model->select_active_bank_drop_down('bank_master');

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

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('adr_company_id','Company Id' ,'trim|xss_clean|max_length[10]|is_natural');
            $this->form_validation->set_rules('name1','Company Name' ,'trim|xss_clean|max_length[150]|strtoupper');
            $this->form_validation->set_rules('strno','Gala/Flat/House No' ,'trim|xss_clean|max_length[9]|strtoupper');
            $this->form_validation->set_rules('name2','Society/Building' ,'trim|xss_clean|max_length[100]|strtoupper');
            $this->form_validation->set_rules('street','Street' ,'trim|xss_clean|max_length[150]|strtoupper');
            $this->form_validation->set_rules('name3','Area' ,'trim|xss_clean|max_length[500]|strtoupper');

            $this->form_validation->set_rules('country','Country' ,'trim|xss_clean');
            $this->form_validation->set_rules('state','State' ,'trim|xss_clean');
            $this->form_validation->set_rules('email','Email' ,'trim|xss_clean|max_length[200]|valid_emails|strtolower');
            $this->form_validation->set_rules('telephone1','Telephone One' ,'trim|xss_clean|max_length[50]');

            $this->form_validation->set_rules('property','Property' ,'trim|xss_clean');
            $this->form_validation->set_rules('transit_days','Transit Days' ,'trim|xss_clean|max_length[3]|is_natural');

            $this->form_validation->set_rules('post_box_code','Pan No' ,'trim|xss_clean|exact_length[10]|alpha_numeric|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]|strtoupper');

            $this->form_validation->set_rules('isdn_local','Gst No' ,'trim|xss_clean|exact_length[15]|alpha_numeric|strtoupper');
            $this->form_validation->set_rules('payment_term','Payment Term' ,'trim|xss_clean');
            $this->form_validation->set_rules('bank','Bank' ,'trim|xss_clean');

            $this->form_validation->set_rules('account_type','Account Type' ,'trim|xss_clean|max_length[20]');
            $this->form_validation->set_rules('account_no','Account No' ,'trim|xss_clean|max_length[35]');

            if($this->form_validation->run()==FALSE){

                $data['country']=$this->country_model->select_active_drop_down('country_master');

                $data['property']=$this->supplier_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

                $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

                $data['payment_term']=$this->supplier_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);

                $data['bank']=$this->supplier_model->select_active_bank_drop_down('bank_master');

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

                $data=array(
                    'address_master.adr_company_id'=>$this->input->post('adr_company_id'),
                    'address_master.name1'=>$this->input->post('name1'),
                    'address_master.strno'=>$this->input->post('strno'),
                    'address_master.name2'=>$this->input->post('name2'),
                    'address_master.street'=>$this->input->post('street'),
                    'address_master.name3'=>$this->input->post('name3'),
                    'address_master.country_id'=>$this->input->post('country'),
                    'address_master.zip_code'=>$this->input->post('state'),
                    'address_master.email'=>$this->input->post('email'),
                    'address_master.telephone1'=>$this->input->post('telephone1'),
                    'address_master.telephone2'=>$this->input->post('telephone2'),
                    'address_master.isdn_local'=>$this->input->post('isdn_local'),
                    'address_master.post_box_code'=>$this->input->post('post_box_code'),
                    'address_master.transit_days'=>$this->input->post('transit_days'),
                    'address_details.payment_condition_id'=>$this->input->post('payment_term'),
                    'address_details.property_id'=>$this->input->post('property'),
                    'address_details.bank_id'=>$this->input->post('bank'),
                    'address_details.account_no'=>$this->input->post('account_no'),
                    'address_details.account_type'=>$this->input->post('account_type'));

                $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);
                $data = array_filter($data);
                if(!empty($from)){
                  $data['supplier']=$this->supplier_model->active_record_search_by_date('address_master',$data,$from,$to,$this->session->userdata['logged_in']['company_id']);
                }else{
                $data['supplier']=$this->supplier_model->active_record_search('address_master',$data,$this->session->userdata['logged_in']['company_id']);
              }

                 
                if($data['supplier']!=FALSE){
                    $data['page_name']='Purchase';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-records',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Purchase';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,$this->router->fetch_class());
                      $data['country']=$this->country_model->select_active_drop_down('country_master');
                      $data['property']=$this->supplier_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);
                      $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
                      $data['payment_term']=$this->supplier_model->select_active_payment_term_drop_down('payment_condition_master',$this->session->userdata['logged_in']['language_id']);
                      $data['bank']=$this->supplier_model->select_active_bank_drop_down('bank_master');

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