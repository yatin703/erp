<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer_supplier_tally extends CI_Controller
{

  function __construct()
  {

    parent::__construct();

    if ($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin'] == 1) {

      $this->load->model('common_model');
      $this->load->model('customer_supplier_tally_model');
    } else {
      redirect('login', 'refresh');
    }
  }

  public function index()
  {


    $data['page_name'] = 'setup';

    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

    $table = 'tally_ledger_master';

    include('pagination_tally.php');

    $data['tally_ledger_master'] = $this->common_model->select_active_records_tally($config["per_page"], $this->uri->segment(3), $table);

    $this->load->view('Home/header');

    $this->load->view('Home/nav', $data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');

    $this->load->view(ucwords($this->router->fetch_class()) . '/active-records', $data);

    $this->load->view('Home/footer');
  }

  public function search()
  {

    $data['page_name'] = 'setup';

    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav', $data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');

    $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);

    $this->load->view('Home/footer');
  }


  public function search_result()
  {

    $this->form_validation->set_rules('from_date', 'From Date', 'xss_clean');
    $this->form_validation->set_rules('to_date', 'To Date', 'xss_clean');
    $this->form_validation->set_rules('name', 'Party Name', 'xss_clean');
    $this->form_validation->set_rules('status', 'Status', 'xss_clean');

    if ($this->form_validation->run() == FALSE) {

      $data['page_name'] = 'setup';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav', $data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');

      $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);

      $this->load->view('Home/footer');
    } else {
      // $data=array('name'=>$this->input->post('name'),
      //             'status'=>$this->input->post('status')
      //           );

      // $data=array_filter($data);

      $search = array();

      if ($this->input->post('name') != '') {
        $search['name'] = $this->input->post('name');
      }
      if ($this->input->post('status') != '--') {
        $search['status'] = $this->input->post('status');
      }

      //print_r($search);

      $data['tally_ledger_master'] = $this->customer_supplier_tally_model->active_record_search('tally_ledger_master', $search, $this->input->post('from_date'), $this->input->post('to_date'));

      //echo $this->db->last_query();

      $data['page_name'] = 'setup';

      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);


      $this->load->view('Home/header');

      $this->load->view('Home/nav', $data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
      $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);
      $this->load->view(ucwords($this->router->fetch_class()) . '/active-records', $data);

      $this->load->view('Home/footer');
    }
  }

  function modify()
  {

    $data['page_name'] = 'setup';

    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

    $data['tally_ledger_master'] = $this->common_model->select_one_details_record_noncompany('tally_ledger_master', 'id', $this->uri->segment(3));


    $this->load->view('Home/header');

    $this->load->view('Home/nav', $data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');

    $this->load->view(ucwords($this->router->fetch_class()) . '/modify-form', $data);

    $this->load->view('Home/footer');
  }

  public function update()
  {

    $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
    $this->form_validation->set_rules('country', 'Country', 'xss_clean');
    $this->form_validation->set_rules('state', 'State', 'xss_clean');
    $this->form_validation->set_rules('pincode', 'Pincode', 'xss_clean');
    $this->form_validation->set_rules('phone_no', 'Phone Number', 'xss_clean');
    $this->form_validation->set_rules('email', 'Email', 'xss_clean');
    $this->form_validation->set_rules('status', 'Status', 'xss_clean');




    if ($this->form_validation->run() == FALSE) {


      $data['page_name'] = 'setup';

      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

      $data['tally_ledger_master'] = $this->common_model->select_one_details_record_noncompany('tally_ledger_master', 'id', $this->input->post('id'));


      $this->load->view('Home/header');

      $this->load->view('Home/nav', $data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');

      $this->load->view(ucwords($this->router->fetch_class()) . '/modify-form', $data);

      $this->load->view('Home/footer');
    } else {

      $data = array(
        'name' => $this->input->post('name'),
        'new_name' => $this->input->post('new_name'),
        'under_group' => $this->input->post('under_group'),
        'is_tds_deductable' => $this->input->post('is_tds_deductable'),
        'treat_as_tds_expense' => $this->input->post('treat_as_tds_expense'),
        'deductee_type' => $this->input->post('deductee_type'),
        'deduct_tds_on_same_voucher' => $this->input->post('deduct_tds_on_same_voucher'),
        'mailing_name' => $this->input->post('mailing_name'),
        'address_1' => $this->input->post('address_1'),
        'address_2' => $this->input->post('address_2'),
        'address_3' => $this->input->post('address_3'),
        'country' => $this->input->post('country'),
        'state' => $this->input->post('state'),
        'pincode' => $this->input->post('pincode'),
        'contact_person' => $this->input->post('contact_person'),
        'phone_no' => $this->input->post('phone_no'),
        'mobile_no' => $this->input->post('mobile_no'),
        'fax_no' => $this->input->post('fax_no'),
        'email' => $this->input->post('email'),
        'cc' => $this->input->post('cc'),
        'website' => $this->input->post('website'),
        'provide_bank_details' => $this->input->post('provide_bank_details'),
        'bank' => $this->input->post('bank'),
        'account_no' => $this->input->post('account_no'),
        'ifsc_code' => $this->input->post('ifsc_code'),
        'pan_no' => $this->input->post('pan_no'),
        'party_type' => $this->input->post('party_type'),
        'gstin' => $this->input->post('gstin'),
        'registration_type' => $this->input->post('registration_type'),
        'is_transporter' => $this->input->post('is_transporter'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'transaction_date' => $this->input->post('transaction_date'),
      );




      $result = $this->common_model->update_one_active_record_noncompany('tally_ledger_master', $data, 'id', $this->input->post('id'));

      if ($result == 1) {

        $data['note'] = 'Update Transaction Completed';

        // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

        $data['tally_ledger_master'] = $this->common_model->select_one_details_record_noncompany('tally_ledger_master', 'id', $this->input->post('id'));



        $data['page_name'] = 'setup';

        $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

        $this->load->view('Home/header');

        $this->load->view('Home/nav', $data);

        $this->load->view('Home/subnav');

        $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');

        $this->load->view(ucwords($this->router->fetch_class()) . '/modify-form', $data);

        $this->load->view('Home/footer');
      } else {

        $data['note'] = 'Error in Update Transaction';

        $data['page_name'] = 'setup';

        $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

        $this->load->view('Home/header');

        $this->load->view('Home/nav', $data);

        $this->load->view('Home/subnav');

        $this->load->view('Error/error-title', $data);

        $this->load->view('Home/footer');
      }
    }
  }
}
