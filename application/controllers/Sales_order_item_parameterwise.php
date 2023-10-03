<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales_order_item_parameterwise extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_in')) {
      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_item_parameterwise_model');
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
      $this->load->model('springtube_extrusion_wip_model');
      $this->load->model('springtube_printing_wip_before_print_model');
      $this->load->model('jobcard_issue_tally_model');
    } else {
      redirect('login', 'refresh');
    }
  }




  function against_jobcard()
  {
    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {

        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {
              $data = array('manu_order_no' => $this->uri->segment(3));

              $data['job_card'] = $this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data, '', 'work_proc_no');

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');
              $data['process_master'] = $this->common_model->select_active_drop_down('workprocedure_types_master', $this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
              $this->load->view(ucwords($this->router->fetch_class()) . '/against-job-form', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No Create rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }

  function index()
  {
    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {
              $table = 'production_master';
              include('pagination.php');
              $data['job_card'] = $this->job_card_model->select_active_records($config["per_page"], $this->uri->segment(3), $table, $this->session->userdata['logged_in']['company_id']);
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              //$this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-records', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No View rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }


  function archive_records()
  {
    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {
              $table = 'production_master';
              include('pagination_archive.php');
              $data['job_card'] = $this->job_card_model->select_archive_records($config["per_page"], $this->uri->segment(3), $table, $this->session->userdata['logged_in']['company_id']);
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              //$this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()) . '/archive-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/archive-records', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No View rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }



  public function customer_check($str)
  {
    if (!empty($str)) {
      $customer_code = explode('//', $str);
      if (!empty($customer_code[1])) {
        $data['customer'] = $this->common_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'name1', $customer_code[0]);
        foreach ($data['customer'] as $customer_row) {

          if ($customer_row->adr_company_id == $customer_code[1]) {
            return TRUE;
          } else {
            $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
            return FALSE;
          }
        }
      } else {
        $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
        return FALSE;
      }
    }
  }


  function search()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {


              $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
              $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
              $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
              $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
              $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);

              $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);


              //$data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No View rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }






  function search_result_bkp()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {

              $this->form_validation->set_rules('adr_company_id', 'Company Name', 'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
              $this->form_validation->set_rules('consin_adr_company_id', 'Contract Packer', 'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
              $this->form_validation->set_rules('article_no', 'Article No', 'trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('from_date', 'From Date', 'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('to_date', 'To Date', 'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('order_no', 'Sales order', 'trim|xss_clean');
              $this->form_validation->set_rules('for_export', 'Order Type', 'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_diameter', 'Sleeve Diameter', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('sleeve_print_type', 'Sleeve Print Type', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('shoulder_type', 'Shoulder type', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('shoulder_orifice', 'Shoulder Orifice', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_orifice', 'Cap Orifice', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_finish', 'Cap finish', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('for_sampling', 'For Sample', 'trim|xss_clean');
              $this->form_validation->set_rules('final_approval_flag', 'Approval Status', 'trim|xss_clean');
              $this->form_validation->set_rules('order_closed', 'Order Status', 'trim|xss_clean');
              $this->form_validation->set_rules('trans_closed', 'Transaction Status', 'trim|xss_clean');
              $this->form_validation->set_rules('order_by', 'Sort Order By', 'trim|xss_clean');
              $this->form_validation->set_rules('user_id', 'Created By', 'trim|xss_clean');


              if ($this->form_validation->run() == FALSE) {

                if (!empty($this->input->post('adr_company_id'))) {

                  $customer_arr = explode('//', $this->input->post('adr_company_id'));
                  if (!empty($customer_arr[1])) {
                    $data['ship_to'] = $this->relate_model->select_one_active_record('adr_relate_companies', $this->session->userdata['logged_in']['company_id'], 'adr_relate_companies.adr_company_id', $customer_arr[1], $this->session->userdata['logged_in']['language_id']);
                  }
                }

                $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);
                $this->load->view('Home/footer');
              } else {

                $from = $this->common_model->change_date_format($this->input->post('from_date'), $this->session->userdata['logged_in']['company_id']);
                $to = $this->common_model->change_date_format($this->input->post('to_date'), $this->session->userdata['logged_in']['company_id']);

                $search = array();
                if (!empty($this->input->post('adr_company_id'))) {
                  $arr = explode('//', $this->input->post('adr_company_id'));
                  $search['customer_no'] = $arr[1];
                }

                if (!empty($this->input->post('consin_adr_company_id'))) {
                  $arr = explode('//', $this->input->post('consin_adr_company_id'));
                  $consignee = $arr[1] . '|';
                  $search['consin_adr_company_id'] = $consignee;
                }
                if (!empty($this->input->post('order_no'))) {
                  $search['order_master.order_no'] = $this->input->post('order_no');
                }
                if (!empty($this->input->post('for_export'))) {
                  $search['order_master.for_export'] = $this->input->post('for_export');
                }
                if (!empty($this->input->post('article_no'))) {

                  $arr = explode("//", $this->input->post('article_no'));
                  $article_no = $arr[1];

                  $search['order_details.article_no'] = $article_no;
                }
                if (!empty($this->input->post('for_sampling'))) {
                  $search['order_master.for_sampling'] = $this->input->post('for_sampling');
                }
                if (!empty($this->input->post('final_approval_flag'))) {
                  $search['order_master.final_approval_flag'] = $this->input->post('final_approval_flag');
                }
                if (!empty($this->input->post('order_closed'))) {
                  $search['order_master.order_closed'] = $this->input->post('order_closed');
                }
                if (!empty($this->input->post('trans_closed'))) {
                  $search['order_master.trans_closed'] = $this->input->post('trans_closed');
                }
                if (!empty($this->input->post('user_id'))) {
                  $search['order_master.user_id'] = $this->input->post('user_id');
                }
                $order_by = '';
                if (!empty($this->input->post('order_by'))) {
                  $order_by = $this->input->post('order_by');
                }


                $data['order_master'] = $this->sales_order_item_parameterwise_model->active_record_search('order_master', $search, $from, $to, $this->session->userdata['logged_in']['company_id'], $order_by);
                //echo $this->db->last_query();

                if ($data['order_master'] != FALSE) {
                  $data['page_name'] = 'Sales';
                  $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

                  $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                  $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                  $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                  $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);



                  $this->load->view('Home/header');
                  $this->load->view('Home/nav', $data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-result', $data);
                  $this->load->view('Home/footer');
                } else {
                  $data['page_name'] = 'Sales';
                  $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                  $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                  $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                  $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                  $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);


                  $data['error'] = 'No record in search transaction';
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav', $data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);
                  $this->load->view('Home/footer');
                }
              }
            } else {
              $data['page_name'] = 'home';
              $data['note'] = 'No rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No New rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }


  public function customer_supplier_check($str)
  {

    if ($str != '') {

      $customer_supplier_code = explode('//', $str);
      if (!empty($customer_supplier_code[1])) {
        $data['customer_supplier'] = $this->common_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'name1', $customer_supplier_code[0]);
        foreach ($data['customer_supplier'] as $customer_supplier_row) {

          if ($customer_supplier_row->adr_company_id == $customer_supplier_code[1]) {
            return TRUE;
          } else {
            $this->form_validation->set_message('adr_company_id', 'The {field} field is incorrect');
            return FALSE;
          }
        }
      } else {
        $this->form_validation->set_message('adr_company_id', 'The {field} field is incorrect');
        return FALSE;
      }
    }
  }


  public function article_check($str)
  {

    if (!empty($str)) {
      $item_code = explode('//', $str);
      if (!empty($item_code[1])) {
        $data['item'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info', $this->session->userdata['logged_in']['company_id'], 'lang_article_description', $item_code[0]);
        //echo $this->db->last_query();

        foreach ($data['item'] as $item_row) {
          if (strtoupper($item_row->article_no) == strtoupper($item_code[1])) {
            return TRUE;
          } else {
            $this->form_validation->set_message('article_check', 'The {field} field is incorrect');
            return FALSE;
          }
        }
      } else {
        $this->form_validation->set_message('article_check', 'The {field} field is incorrect');
        return FALSE;
      }
    }
  }

  // public function article_check($str){
  //     if($str!=''){
  //       $article=explode('//',$str);
  //       if(!empty($article[1])){
  //         $data['article']=$this->common_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_no',$article[1]);
  //         foreach ($data['article'] as $article_row) {

  //           if ($article_row->article_no == $article[1]){
  //           return TRUE;
  //           }else{
  //           $this->form_validation->set_message('article_no', 'The {field} field is incorrect');
  //           return FALSE;
  //           }
  //         }

  //       }else{
  //         $this->form_validation->set_message('article_no', 'The {field} field is incorrect');
  //         return FALSE;
  //       }

  //     }

  // }

  /*

  public function get_sales_data(){


      //$this->load->model('common_model');
      //$this->load->helper(array('form', 'url'));
      //$this->load->helper('download');
      //$this->load->library('PHPReport');

      // get data from databse
      $table='order_master';
      $from=$this->input->get('from_date');
      $to=$this->input->get('to_date');
      $company=$this->session->userdata['logged_in']['company_id'];

      $data = $this->common_model->select_active_records_excel($table,$from,$to,$company);
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

      //Tp Save a copy to root folder of project directory un-comment below code:
      $filename = $output_file_dir  . "sales_order_book".date('d_m_y_h_i_s_a').".xlsx";

      //download excel sheet with data in /tmp folder
      $result = $R->render('excel', $filename);

      //To download Excel in local Machine un-comment below code:
      force_download($filename, NULL);


  }*/
  public function jobcard_quantity_check($str)
  {

    // Jobcard Creation Lock---------------------
    $print_type = '';
    $order_flag = 0;
    $bom_no = $this->input->post('spec_no');
    $bom_version_no = $this->input->post('spec_version_no');
    $data = array(
      'bom_no' => $this->input->post('spec_no'),
      'bom_version_no' => $this->input->post('spec_version_no')
    );

    $result_bill_of_material = $this->common_model->select_active_records_where('bill_of_material', $this->session->userdata['logged_in']['company_id'], $data);
    foreach ($result_bill_of_material as $bill_of_material_row) {
      $print_type = strtoupper($bill_of_material_row->print_type);
    }


    $result_order_master = $this->common_model->select_one_active_record('order_master', $this->session->userdata['logged_in']['company_id'], 'order_no', $this->input->post('order_no'));
    foreach ($result_order_master as $order_master_row) {
      $order_flag = $order_master_row->order_flag;
    }

    $job_card_perc = 0;
    $order_qty = "";
    $order_qty = $this->input->post('order_qty');
    if ($this->input->post('dispatch_tolerance_1') != '') {
      $order_qty = $order_qty + ($order_qty / $this->input->post('dispatch_tolerance_1'));
    }
    $job_card_quantity = $this->input->post('job_card_quantity');
    $order_no = $this->input->post('order_no');
    $article_no = $this->input->post('article_no');
    $actual_qty_manufactured = 0;
    $calc_jobcard_qty = 0;

    // JObcard Matrix is changes on 9th May 2020---with mail ref

    if ($order_flag == 0) {

      if ($order_qty <= 5000) {
        $job_card_perc = 50;
      }
      if ($order_qty > 5000 && $order_qty <= 10000) {
        $job_card_perc = 50;
        //$job_card_perc=300;
      }
      if ($order_qty >= 10001 && $order_qty <= 20000) {
        $job_card_perc = 400;
      }
      if ($order_qty >= 20001 && $order_qty <= 50000) {
        $job_card_perc = 30;
        //$job_card_perc=200;
      }
      // Jobcard perc incresed by 10% matrix changed on 18-Feb-2020,
      if ($order_qty >= 50001 && $order_qty <= 100000) {
        $job_card_perc = 25;
        //$job_card_perc=100;
      }
      if ($order_qty > 100000) {
        $job_card_perc = 20;
      }
      if ($print_type == 'LABELING') {
        $job_card_perc = 15;
      }

      $data = array(
        'sales_ord_no' => $order_no,
        'article_no' => $article_no,
        'archive' => '0',
        'jobcard_type' => 0
      );

      $production_master_result = $this->common_model->select_active_records_where('production_master', $this->session->userdata['logged_in']['company_id'], $data);
      foreach ($production_master_result as $production_master_row) {
        $actual_qty_manufactured += $this->common_model->read_number($production_master_row->actual_qty_manufactured, $this->session->userdata['logged_in']['company_id']);
      }

      if ($actual_qty_manufactured == 0) {
        $calc_jobcard_qty = $order_qty + ($order_qty * $job_card_perc) / 100;
      } else {
        $calc_jobcard_qty = $order_qty + ($order_qty * $job_card_perc) / 100 - $actual_qty_manufactured;
      }
    } else { // Springtube JObcard creation Matrix

      $customer_tolerance = $this->input->post('dispatch_tolerance_1');
      $printing_rejection = $this->input->post('printing_rejection');
      $bodymaking_rejection = $this->input->post('bodymaking_rejection');

      $job_card_perc = ($customer_tolerance + $printing_rejection + $bodymaking_rejection);

      $data = array(
        'sales_ord_no' => $order_no,
        'article_no' => $article_no,
        'archive' => '0',
        'jobcard_type' => 1
      );

      $production_master_result = $this->common_model->select_active_records_where('production_master', $this->session->userdata['logged_in']['company_id'], $data);
      foreach ($production_master_result as $production_master_row) {
        $actual_qty_manufactured += $this->common_model->read_number($production_master_row->actual_qty_manufactured, $this->session->userdata['logged_in']['company_id']);
      }

      if ($actual_qty_manufactured == 0) {
        $calc_jobcard_qty = $order_qty + (($order_qty * $job_card_perc) / 100);
      } else {
        $calc_jobcard_qty = $order_qty + (($order_qty * $job_card_perc) / 100) - $actual_qty_manufactured;
      }
    }


    // $data=array('sales_ord_no'=>$order_no,
    //             'article_no'=>$article_no,
    //             'archive'=>'0');

    // $production_master_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data);
    // foreach ($production_master_result as $production_master_row) {
    //     $actual_qty_manufactured+=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
    // }

    // if($actual_qty_manufactured==0){
    //    $calc_jobcard_qty=$order_qty+($order_qty*$job_card_perc)/100;

    // }else{
    //   $calc_jobcard_qty= $order_qty+($order_qty*$job_card_perc)/100-$actual_qty_manufactured;

    // }

    if ($calc_jobcard_qty < $job_card_quantity) {
      $this->form_validation->set_message('jobcard_quantity_check', 'The {field} can not be more than specified %');
      return FALSE;
    } else {
      return TRUE;
    }
  }

  function job_card()
  {
    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {

        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {

              $data = array(
                'final_approval_flag' => '1',
                'order_no' => $this->uri->segment(3),
                'trans_closed' => '0',
                'order_closed <>' => '1',
                'hold_flag' => '0'
              );

              $data['order'] = $this->sales_order_book_model->active_details_records('order_master', $data, $this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $dataa = array(
                'order_no' => $this->uri->segment(3),
                'article_no' => $this->uri->segment(4)
              );



              $data['order_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('order_details', $this->session->userdata['logged_in']['company_id'], $dataa);

              $data['customer'] = $this->customer_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'address_details.property_id', '1');

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '75');

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
              $this->load->view(ucwords($this->router->fetch_class()) . '/create-form', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No Create rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }

  function add_to_plan()
  {
    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {

        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {

              $data = array(
                'final_approval_flag' => '1',
                'order_no' => $this->uri->segment(3),
                'trans_closed' => '0',
                'order_closed <>' => '1',
                'hold_flag' => '0'
              );

              $data['order'] = $this->sales_order_book_model->active_details_records('order_master', $data, $this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $dataa = array(
                'order_no' => $this->uri->segment(3),
                'article_no' => $this->uri->segment(4)
              );



              $data['order_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('order_details', $this->session->userdata['logged_in']['company_id'], $dataa);

              $data['customer'] = $this->customer_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'address_details.property_id', '1');

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '75');

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
              $this->load->view(ucwords($this->router->fetch_class()) . '/create-form', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No Create rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }


  function view()
  {

    $order_no = $this->uri->segment(3);
    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {

        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {

              $data['production'] = $this->common_model->select_one_active_record('production_master', $this->session->userdata['logged_in']['company_id'], 'mp_pos_no', $this->uri->segment(3));


              $data['company'] = $this->common_model->select_one_active_record('company_master', $this->session->userdata['logged_in']['company_id'], 'company_id', $this->session->userdata['logged_in']['company_id']);

              $data['company_details'] = $this->common_model->select_one_active_record('company_system_parameters', $this->session->userdata['logged_in']['company_id'], 'company_id', $this->session->userdata['logged_in']['company_id']);

              $dataa = array(
                'manu_order_no' => $this->uri->segment(3),
                'work_proc_no' => '1',
                'from_job_card' => '0'
              );

              $data['extrusion_additional'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $dataa);

              $data_purging = array(
                'manu_order_no' => $this->uri->segment(3),
                'work_proc_no' => '9'
              );
              //Purging Material-------
              $data['purging'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data_purging);

              //echo $this->db->last_query();



              $this->load->view('Print/header', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/view-form', $data);
            } else {
              $data['note'] = 'No Modify rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No Modify rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }



  function view_new()
  {

    $order_no = $this->uri->segment(3);
    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {

        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {

              $order_flag = 0;

              $data['production'] = $this->common_model->select_one_active_record('production_master', $this->session->userdata['logged_in']['company_id'], 'mp_pos_no', $this->uri->segment(3));
              //echo $this->db->last_query();
              foreach ($data['production'] as $production_row) {
                $production_row->sales_ord_no;
                //$data['order_master']=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$production_row->sales_ord_no);

                $data['order_master'] = $this->sales_order_item_parameterwise_model->select_one_active_record('order_master', $this->session->userdata['logged_in']['company_id'], 'order_no', $production_row->sales_ord_no);
                //echo $this->db->last_query();


                foreach ($data['order_master'] as $order_master_row) {
                  $order_flag = $order_master_row->order_flag;
                  $data['tolerance'] = $order_master_row->dispatch_tolerance;
                }
              }


              $data['company'] = $this->common_model->select_one_active_record('company_master', $this->session->userdata['logged_in']['company_id'], 'company_id', $this->session->userdata['logged_in']['company_id']);

              $data['company_details'] = $this->common_model->select_one_active_record('company_system_parameters', $this->session->userdata['logged_in']['company_id'], 'company_id', $this->session->userdata['logged_in']['company_id']);

              $data_extrusion = array('manu_order_no' => $this->uri->segment(3), 'work_proc_no' => '1', 'from_job_card' => '1', 'archive' => '0');
              $data['extrusion'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data_extrusion);

              $dataa = array('manu_order_no' => $this->uri->segment(3), 'type_flag' => '4');
              $data['extrusion_additional'] = $this->common_model->select_one_active_record_nonlanguage_without_archives_jobcard_view('reserved_quantity_manu', $this->session->userdata['logged_in']['company_id'], $dataa);

              $data_purging = array(
                'manu_order_no' => $this->uri->segment(3),
                'work_proc_no' => '9',
                'from_job_card' => '1',
                'archive' => '0'
              );
              $data['purging'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data_purging);


              $data_printing_input = array('manu_order_no' => $this->uri->segment(3), 'work_proc_no' => '1', 'from_job_card' => '1', 'sfg_flag' => '1', 'archive' => '0');


              $data['printing_input'] = $this->common_model->select_active_records_where_order_by('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data_printing_input, 'part_pos_no', 'asc');

              //echo $this->db->last_query();

              $data_printing = array('manu_order_no' => $this->uri->segment(3), 'work_proc_no' => '3', 'from_job_card' => '1', 'archive' => '0');

              //$data_printing=array('manu_order_no'=>$this->uri->segment(3),'work_proc_no'=>'3','from_job_card'=>'1');

              //$data['printing']=$this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data_printing);

              $data['printing'] = $this->common_model->select_active_records_where_order_by('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data_printing, 'part_pos_no', 'asc');


              $data_box = array('manu_order_no' => $this->uri->segment(3), 'work_proc_no' => '10', 'from_job_card' => '1', 'archive' => '0');
              $data['box'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data_box);

              $data_foiling = array('manu_order_no' => $this->uri->segment(3), 'work_proc_no' => '6', 'from_job_card' => '1', 'archive' => '0');
              $data['foiling'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data_foiling);

              $data_capping = array('manu_order_no' => $this->uri->segment(3), 'work_proc_no' => '11', 'from_job_card' => '1', 'archive' => '0');
              $data['capping'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data_capping);

              $data_labeling = array('manu_order_no' => $this->uri->segment(3), 'work_proc_no' => '5', 'from_job_card' => '1', 'archive' => '0');
              $data['labeling'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data_labeling);

              $data_shoulder_foiling = array('manu_order_no' => $this->uri->segment(3), 'work_proc_no' => '7', 'from_job_card' => '1', 'archive' => '0');
              $data['shoulder_foiling'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data_shoulder_foiling);

              $data_heading = array('manu_order_no' => $this->uri->segment(3), 'work_proc_no' => '2', 'from_job_card' => '1', 'archive' => '0');
              $data['heading'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data_heading);


              $this->load->view('Print/header', $data);
              if ($order_flag == 1) {
                $this->load->view(ucwords($this->router->fetch_class()) . '/view-spring', $data);
              } else {
                $this->load->view(ucwords($this->router->fetch_class()) . '/view-new-form', $data);
              }
            } else {
              $data['note'] = 'No Modify rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No Modify rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }



  function save_job_card()
  {

    $this->input->post('order_flag');

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {

            if ($formrights_row->new == 1) {

              if ($this->input->post('order_flag') == '0') {

                $this->form_validation->set_rules('job_card_quantity', 'Job Card Quantity', 'required|trim|xss_clean|max_length[15]|numeric|callback_jobcard_quantity_check');
                $this->form_validation->set_rules('spec_id', 'Specification No', 'required|trim|xss_clean');
                $this->form_validation->set_rules('comment', 'Comment', 'required|trim|xss_clean');
              } else {

                $this->form_validation->set_rules('spec_id', 'Specification No', 'required|trim|xss_clean');
                $this->form_validation->set_rules('job_card_quantity', 'Job Card Quantity', 'required|trim|xss_clean|max_length[15]|numeric|callback_jobcard_quantity_check');

                $this->form_validation->set_rules('no_of_reels', 'No. Of reels', 'required|trim|xss_clean|numeric');
                $this->form_validation->set_rules('reel_length', 'Default Reel Length', 'required|trim|xss_clean|numeric');

                $this->form_validation->set_rules('job_card_length_in_meters', 'Jobcard Length in meters', 'required|trim|xss_clean|numeric');
                $this->form_validation->set_rules('comment', 'Comment', 'required|trim|xss_clean');
              }


              if ($this->form_validation->run() == FALSE) {

                $data = array(
                  'final_approval_flag' => '1',
                  'order_no' => $this->input->post('order_no'),
                  'trans_closed' => '0',
                  'order_closed' => '0'
                );

                $data['order'] = $this->sales_order_book_model->active_details_records('order_master', $data, $this->session->userdata['logged_in']['company_id']);


                $dataa = array(
                  'order_no' => $this->input->post('order_no'),
                  'article_no' => $this->input->post('article_no')
                );

                $data['order_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('order_details', $this->session->userdata['logged_in']['company_id'], $dataa);

                $data['customer'] = $this->customer_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'address_details.property_id', '1');

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '75');

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_book');
                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/create-form', $data);
                $this->load->view('Home/footer');
              } else {

                $order_flag = $this->input->post('order_flag');
                $form_id = '';
                $jobcard_type = '0';
                $no_of_reels = '';
                $reel_length = '';
                $job_card_length_in_meters = '';
                $jobcard_qty = '0';


                $sleeve_code = '';
                $shoulder_code = '';
                $label_code = '';
                $cap_code = '';
                $for_export = '';


                $data = array(
                  'final_approval_flag' => '1',
                  'order_no' => $this->input->post('order_no'),
                  'trans_closed' => '0',
                  'order_closed' => '0'
                );

                $data['order'] = $this->sales_order_book_model->active_details_records('order_master', $data, $this->session->userdata['logged_in']['company_id']);

                foreach ($data['order'] as $order_row) {
                  $order_flag = $order_row->order_flag;
                }

                if ($order_flag == '0') {
                  $form_id = '1032';
                  $jobcard_qty = $this->common_model->save_number($this->input->post('job_card_quantity'), $this->session->userdata['logged_in']['company_id']);
                } else if ($order_flag == '1') {
                  $form_id = '103222';
                  $jobcard_type = '1';
                  $no_of_reels = $this->input->post('no_of_reels');
                  $reel_length = $this->input->post('reel_length');
                  $job_card_length_in_meters = $this->input->post('job_card_length_in_meters');

                  //$jobcard_qty=$this->jobcard_reels_to_qty($no_of_reels,$reel_length);
                  $jobcard_qty = $this->input->post('job_card_quantity');
                  $jobcard_qty = $this->common_model->save_number($jobcard_qty, $this->session->userdata['logged_in']['company_id']);
                }

                //$data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','1032');
                $data['auto'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master', $this->session->userdata['logged_in']['company_id'], 'form_id', $form_id);
                $no = "";
                foreach ($data['auto'] as $auto_row) {

                  $data['account_periods'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master', $this->session->userdata['logged_in']['company_id'], 'finyear_close_opt', '0');
                  foreach ($data['account_periods'] as $account_periods_row) {
                    $start = date('y', strtotime($account_periods_row->fin_year_start));
                    $end = date('y', strtotime($account_periods_row->fin_year_end));
                  }
                  $no = str_pad($auto_row->curr_val, 4, "0", STR_PAD_LEFT);
                  $jobcard_no = $auto_row->textcode . $auto_row->seperator . $start . $auto_row->seperator . $end . $auto_row->seperator . $no;
                  $next_jobcard_no = $auto_row->curr_val + 1;
                }
                $data = array('curr_val' => $next_jobcard_no);

                //$this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','1032',$this->session->userdata['logged_in']['company_id']);

                $this->common_model->update_one_active_record('autogeneration_format_master', $data, 'form_id', $form_id, $this->session->userdata['logged_in']['company_id']);



                $data['max'] = $this->common_model->select_max_pkey_numeric('production_master', 'manu_order_no', $this->session->userdata['logged_in']['company_id']);
                foreach ($data['max'] as $max_value) {
                  $manu_order_no = $max_value->manu_order_no + 1;
                }

                $data = array(
                  'manu_order_no' => $manu_order_no,
                  'company_id' => $this->session->userdata['logged_in']['company_id'],
                  'mp_pos_no' => $jobcard_no,
                  'article_no' => $this->input->post('article_no'),
                  'mp_qty' => $this->common_model->save_number($this->input->post('order_qty'), $this->session->userdata['logged_in']['company_id']),
                  'actual_qty_manufactured' => $jobcard_qty,
                  'manu_plan_date' => date('Y-m-d'),
                  'employee_id' => $this->session->userdata['logged_in']['user_id'],
                  'sales_ord_no' => $this->input->post('order_no'),
                  'ord_pos_no' => $this->input->post('ord_pos_no'),
                  'jobcard_type' => $jobcard_type,
                  'no_of_reels' => $no_of_reels,
                  'reel_length' => $reel_length,
                  'total_meters' => $job_card_length_in_meters,
                  'comment' => strtoupper($this->input->post('comment'))
                );

                $result = $this->common_model->save('production_master', $data);


                if (strtoupper(substr($this->input->post('spec_no'), 0, 3)) == 'BOM') {

                  $data = array(
                    'bom_no' => $this->input->post('spec_no'),
                    'bom_version_no' => $this->input->post('spec_version_no')
                  );
                  $data['bom_details'] = $this->common_model->select_active_records_where('bill_of_material', $this->session->userdata['logged_in']['company_id'], $data);

                  foreach ($data['bom_details'] as $bom_details_row) {
                    $sleeve_code = $bom_details_row->sleeve_code;
                    $shoulder_code = $bom_details_row->shoulder_code;
                    $label_code = $bom_details_row->label_code;
                    $cap_code = $bom_details_row->cap_code;
                    $for_export = $bom_details_row->for_export;

                    if (substr($sleeve_code, 0, 4) == "LMNF") {

                      //Lami

                      $data['film_specs'] = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $sleeve_code);
                      foreach ($data['film_specs'] as $film_specs) {

                        $film_specss['spec_id'] = $film_specs->spec_id;
                        $film_specss['spec_version_no'] = $film_specs->spec_version_no;

                        $film_specs_master_result = $this->common_model->select_active_records_where('specification_sheet', $this->session->userdata['logged_in']['company_id'], $film_specss);
                        if ($film_specs_master_result) {
                          foreach ($film_specs_master_result as $film_specs_master_result_row) {
                            $layer_arr = explode("|", $film_specs_master_result_row->dyn_qty_present);
                            $layer_no = substr($layer_arr[1], 0, 1);
                          }
                        }

                        $film_specs_result = $this->sales_order_book_model->select_film_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $film_specss);
                        if ($film_specs_result) {
                          foreach ($film_specs_result as $specs_row) {
                            $dia = $specs_row->SLEEVE_DIA;
                            $length = $specs_row->SLEEVE_LENGTH;
                            $total_film_guage = $specs_row->FILM_GUAGE_1 + $specs_row->FILM_GUAGE_2 + $specs_row->FILM_GUAGE_3 + $specs_row->FILM_GUAGE_4 + $specs_row->FILM_GUAGE_5 + $specs_row->FILM_GUAGE_6 + $specs_row->FILM_GUAGE_7;

                            $data['sleeve_diameter_master'] = $this->common_model->select_one_active_record('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id'], 'sleeve_diameter', $dia);
                            foreach ($data['sleeve_diameter_master'] as $sleeve_dia_row) {
                              $sleeve_dia_id = $sleeve_dia_row->sleeve_id;
                            }

                            $result_body_making_type = $this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '17');
                            foreach ($result_body_making_type as $body_making_type_row) {
                              $body_making_type = $body_making_type_row->parameter_value;
                            }

                            //$data=array('sleeve_dia_id'=>$sleeve_dia_id,'seam_type'=>$body_making_type);

                            $data = array('sleeve_dia_id' => $sleeve_dia_id);

                            $result_spring_width_calculation = $this->common_model->active_record_search('spring_width_calculation', $data, $this->session->userdata['logged_in']['company_id']);
                            if ($result_spring_width_calculation) {
                              foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
                                //echo $spring_width_calculation_row->slit_width;
                                //echo $spring_width_calculation_row->ups;
                                // echo $spring_width_calculation_row->distance_each_side;
                                $film_width = $spring_width_calculation_row->slit_width + ($spring_width_calculation_row->distance_each_side * $spring_width_calculation_row->ups);
                                //echo "<br/>";
                                $qty_to_be_printed = $this->input->post('job_card_quantity') / $spring_width_calculation_row->ups;
                                $film_length = $qty_to_be_printed * ($length + 2.5);
                                //echo "<br/>";
                                $total_film_guagee = $total_film_guage / 1000;
                                //echo "<br/>";
                                $total_film_volume = $total_film_guagee * $film_length * $film_width;
                                $density = 0.00098;
                                //echo "<br/>";
                                $total_film_material = ($total_film_volume * $density) / 1000;
                              }
                            }
                          }
                        }

                        $t = 1;
                        for ($a = 1; $a <= $layer_no; $a++) {

                          $data['specification_film_details'] = $this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $film_specs->spec_id, 'specification_sheet_details.spec_version_no', $film_specs->spec_version_no, 'item_group_id', '3', 'layer_no', $a, 'parameter_name', 'GUAGE', 'srd_id', 'asc', 'layer_no', 'asc');

                          foreach ($data['specification_film_details'] as $specification_film_details_row) {
                            $gauge = rtrim($specification_film_details_row->parameter_value, " MIC");

                            $data['specification_film_details'] = $this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $film_specs->spec_id, 'specification_sheet_details.spec_version_no', $film_specs->spec_version_no, 'item_group_id', '3', 'mat_article_no<>', '', 'layer_no', $a, 'srd_id', 'asc', 'layer_no', 'asc');
                            foreach ($data['specification_film_details'] as $specification_film_details_row) {

                              if (!empty($specification_film_details_row->mat_info) && !empty($specification_film_details_row->mat_article_no)) {

                                //$rm_qty=(($total_film_material/$total_film_guage*$gauge)/100)*$specification_film_details_row->mat_info;
                                //echo "<br/>";

                                $density = '';

                                if ($a == '1' || $a == '3' || $a == '5' || $a == '7') {
                                  $density = 0.92;
                                } elseif ($a == '2' || $a == '6') {
                                  $density = 0.94;
                                } elseif ($a == '4') {
                                  $density = 1.19;
                                }

                                /*echo 'Layer='.$a;
                          echo "<br/>";
                          echo  'Length='.($length+2.5);
                          echo "<br/>";
                          echo 'FIlm Width='.$film_width;
                          echo "<br/>";
                          echo 'Gauge='.$gauge;
                          echo "<br/>";
                          echo 'Dencity='.$density;
                          echo "<br/>";
                          echo 'RM per sleeve= ';
                          */
                                $rm_per_sleeve = (($length + 2.5) * $film_width * $gauge * $density) / 1000000;
                                //echo "<br/>";
                                //echo 'RM per sleeve in kg= ';
                                $rm_per_sleeve_in_kg = $rm_per_sleeve / 1000;
                                //echo "<br/>";
                                //echo "Total Rm=";

                                $rm_total = ($rm_per_sleeve_in_kg * $qty_to_be_printed);
                                //echo "<br/>";
                                //echo "Total Rm perc%";

                                $rm_qty = $rm_total * ($specification_film_details_row->mat_info / 100);
                                //echo "<br/>";

                                $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                                foreach ($data['max_mm'] as $max_mm_row) {
                                  $mm_id = $max_mm_row->mm_id + 1;
                                }


                                $data = array(
                                  'manu_order_no' => $jobcard_no,
                                  'article_no' => $specification_film_details_row->mat_article_no,
                                  'demand_qty' => $this->common_model->save_number($rm_qty, $this->session->userdata['logged_in']['company_id']),
                                  'company_id' => $this->session->userdata['logged_in']['company_id'],
                                  'work_proc_no' => '1',
                                  'from_job_card' => '1',
                                  'rel_demand_qty' => $this->common_model->save_number($rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                                  'flag_uom_type' => '1',
                                  'mm_id' => $mm_id,
                                  'rel_uom_id' => 'UOM013',
                                  'part_pos_no' => $t,
                                  'layer_no' => $a
                                );
                                $this->common_model->save('material_manufacturing', $data);

                                $t++;
                              }
                            }
                          }
                        }
                      }

                      if ($order_flag == '0') {

                        if (!empty($cap_code)) {

                          $data['cap_specs'] = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $cap_code);
                          foreach ($data['cap_specs'] as $cap_specs) {
                            $cap_specss['spec_id'] = $cap_specs->spec_id;
                            $cap_specss['spec_version_no'] = $cap_specs->spec_version_no;
                          }

                          $data['specs_details'] = $this->sales_order_book_model->select_cap_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $cap_specss);
                          foreach ($data['specs_details'] as $specs_details_row) {
                            $CAP_STYLE = $specs_details_row->CAP_STYLE;
                            $CAP_MOLD_FINISH = $specs_details_row->CAP_MOLD_FINISH;
                            $CAP_ORIFICE = $specs_details_row->CAP_ORIFICE;
                            $CAP_DIA = $specs_details_row->CAP_DIA;
                            $CAP_FOIL_COLOR = $specs_details_row->CAP_FOIL_COLOR;
                            $CAP_FOIL_CODE = $specs_details_row->CAP_FOIL_CODE;
                            $CAP_SHRINK_SLEEVE = $specs_details_row->CAP_SHRINK_SLEEVE;
                            $CAP_MASTER_BATCH = $specs_details_row->CAP_MASTER_BATCH;
                            $CAP_METALIZATION = $specs_details_row->CAP_METALIZATION;
                            $CAP_MB_PERC = $specs_details_row->CAP_MB_PERC;
                            $CAP_SHRINK_SLEEVE_CODE = $specs_details_row->CAP_SHRINK_SLEEVE_CODE;
                          }

                          $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                          foreach ($data['max_mm'] as $max_mm_row) {
                            $mm_id = $max_mm_row->mm_id + 1;
                          }

                          $data = array(
                            'manu_order_no' => $jobcard_no,
                            'article_no' => $cap_code,
                            'demand_qty' => $jobcard_qty,
                            'company_id' => $this->session->userdata['logged_in']['company_id'],
                            'work_proc_no' => '11',
                            'from_job_card' => '1',
                            'rel_demand_qty' => $jobcard_qty * 1000,
                            'flag_uom_type' => '1',
                            'mm_id' => $mm_id,
                            'rel_uom_id' => '9',
                            'part_pos_no' => $t
                          );
                          $this->common_model->save('material_manufacturing', $data);
                          $t++;



                          if (!empty($CAP_SHRINK_SLEEVE_CODE)) {

                            $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                            foreach ($data['max_mm'] as $max_mm_row) {
                              $mm_id = $max_mm_row->mm_id + 1;
                            }

                            $data = array(
                              'manu_order_no' => $jobcard_no,
                              'article_no' => $CAP_SHRINK_SLEEVE_CODE,
                              'demand_qty' => $jobcard_qty,
                              'company_id' => $this->session->userdata['logged_in']['company_id'],
                              'work_proc_no' => '11',
                              'from_job_card' => '1',
                              'rel_demand_qty' => $jobcard_qty * 1000,
                              'flag_uom_type' => '1',
                              'mm_id' => $mm_id,
                              'rel_uom_id' => '9',
                              'part_pos_no' => $t
                            );
                            $this->common_model->save('material_manufacturing', $data);
                            $t++;
                          }
                        } //IF CAP CODE

                      }
                    } // IF FILM LAMINATE------

                    if (substr($sleeve_code, 0, 3) == "SLV") {

                      if (!empty($sleeve_code)) {
                        $data['sleeve_specs'] = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $sleeve_code);
                        foreach ($data['sleeve_specs'] as $sleeve_specs) {

                          $sleeve_specss['spec_id'] = $sleeve_specs->spec_id;
                          $sleeve_specss['spec_version_no'] = $sleeve_specs->spec_version_no;

                          $sleeve_specs_master_result = $this->common_model->select_active_records_where('specification_sheet', $this->session->userdata['logged_in']['company_id'], $sleeve_specss);
                          if ($sleeve_specs_master_result) {
                            foreach ($sleeve_specs_master_result as $sleeve_specs_master_result_row) {
                              $layer_arr = explode("|", $sleeve_specs_master_result_row->dyn_qty_present);
                              $layer_no = substr($layer_arr[1], 0, 1);
                            }
                          }

                          $sleeve_specs_result = $this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $sleeve_specss);
                          if ($sleeve_specs_result) {
                            foreach ($sleeve_specs_result as $specs_row) {
                              $dia = $specs_row->SLEEVE_DIA;
                              $length = $specs_row->SLEEVE_LENGTH + 3;
                              $sleeve_length = $specs_row->SLEEVE_LENGTH;
                            }
                          }

                          $pi = 3.14;

                          $this->load->model('process_model');
                          $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');
                          foreach ($data['workprocedure_types_master'] as $workprocedure_types_master) {
                            $rejection = $this->common_model->read_number($workprocedure_types_master->rejection_perc, $this->session->userdata['logged_in']['company_id']);
                          }



                          $t = 1;
                          for ($i = 1; $i <= $layer_no; $i++) {
                            $gauge = "";
                            $data['specification_sleeve_details'] = $this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $sleeve_specs->spec_id, 'specification_sheet_details.spec_version_no', $sleeve_specs->spec_version_no, 'item_group_id', '3', 'layer_no', $i, 'parameter_name', 'GUAGE', 'srd_id', 'asc', 'layer_no', 'asc');

                            foreach ($data['specification_sleeve_details'] as $specification_sleeve_details_row) {
                              $gauge = rtrim($specification_sleeve_details_row->parameter_value, " MIC");

                              $sleeve_weight = "";
                              $density = "";

                              if ($layer_no == 5 && $i == 3) {
                                $density = 1.18;
                              } else {
                                $density = 0.92;
                              }



                              $sleeve_weight = ((((($dia * $length * $gauge * $pi * $density) / 1000000) * $rejection / 100) + (($dia * $length * $gauge * $pi * $density) / 1000000)) / 1000) * $this->input->post('job_card_quantity');

                              $sleeve_weight = $sleeve_weight / 100;


                              $data['specification_sleeve_details'] = $this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $sleeve_specs->spec_id, 'specification_sheet_details.spec_version_no', $sleeve_specs->spec_version_no, 'item_group_id', '3', 'mat_article_no<>', '', 'layer_no', $i, 'srd_id', 'asc', 'layer_no', 'asc');


                              foreach ($data['specification_sleeve_details'] as $specification_sleeve_details_row) {
                                if (!empty($specification_sleeve_details_row->mat_info) && !empty($specification_sleeve_details_row->mat_article_no)) {

                                  $specification_sleeve_details_row->mat_article_no . " " . $specification_sleeve_details_row->mat_info;


                                  $rm_qty = round($sleeve_weight * $specification_sleeve_details_row->mat_info, 2);



                                  // echo "<table><tr><td>$rm_qty</td><td>$density</td><td>$sleeve_weight</td></tr></table>";


                                  //echo "<br>";

                                  $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                                  foreach ($data['max_mm'] as $max_mm_row) {
                                    $mm_id = $max_mm_row->mm_id + 1;
                                  }

                                  $data = array(
                                    'manu_order_no' => $jobcard_no,
                                    'article_no' => $specification_sleeve_details_row->mat_article_no,
                                    'demand_qty' => $this->common_model->save_number($rm_qty, $this->session->userdata['logged_in']['company_id']),
                                    'company_id' => $this->session->userdata['logged_in']['company_id'],
                                    'work_proc_no' => '1',
                                    'from_job_card' => '1',
                                    'rel_demand_qty' => $this->common_model->save_number($rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                                    'flag_uom_type' => '1',
                                    'mm_id' => $mm_id,
                                    'rel_uom_id' => 'UOM013',
                                    'part_pos_no' => $t
                                  );
                                  $this->common_model->save('material_manufacturing', $data);

                                  $t++;
                                }
                              }
                            }
                          }


                          $data['specification_sleeve_details'] = $this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $sleeve_specs->spec_id, 'specification_sheet_details.spec_version_no', $sleeve_specs->spec_version_no, 'item_group_id', '3', 'mat_article_no<>', '', 'layer_no', '1', 'srd_id', 'asc', 'layer_no', 'asc');


                          foreach ($data['specification_sleeve_details'] as $specification_sleeve_details_row) {

                            if ($specification_sleeve_details_row->parameter_name == 'MASTER BATCH') {
                              $data['article'] = $this->article_model->select_one_active_record('article', $this->session->userdata['logged_in']['company_id'], 'article.article_no', $specification_sleeve_details_row->mat_article_no);
                              foreach ($data['article'] as $article_row) {
                                /*
                                  if (strpos($article_row->article_name, 'TRANSPARENT') == FALSE || strpos($article_row->article_name, 'WHITE') == FALSE) {
                                    */
                                if ($article_row->article_no != 'RM-MB-TRA-0007' && $article_row->article_no != 'RM-MB-STD-0008' && $article_row->article_no != 'RM-MB-STD-0808') {
                                  $avg_purging_kg = 15;
                                  $data['purging'] = $this->common_model->select_one_active_record('purging_perc_master', $this->session->userdata['logged_in']['company_id'], 'archive<>', '1');
                                  //echo $this->db->last_query();
                                  foreach ($data['purging'] as $purging_row) {

                                    $rm_qty = $this->common_model->read_number($purging_row->purging_perc, $this->session->userdata['logged_in']['company_id']) * $avg_purging_kg;

                                    $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);

                                    foreach ($data['max_mm'] as $max_mm_row) {
                                      $mm_id = $max_mm_row->mm_id + 1;
                                    }

                                    $data = array(
                                      'manu_order_no' => $jobcard_no,
                                      'article_no' => $purging_row->article_no,
                                      'demand_qty' => $rm_qty,
                                      'company_id' => $this->session->userdata['logged_in']['company_id'],
                                      'work_proc_no' => '9',
                                      'from_job_card' => '1',
                                      'rel_demand_qty' => $this->common_model->save_number($rm_qty, $this->session->userdata['logged_in']['company_id']),
                                      'flag_uom_type' => '1',
                                      'mm_id' => $mm_id,
                                      'rel_uom_id' => 'UOM013',
                                      'part_pos_no' => $t
                                    );

                                    $this->common_model->save('material_manufacturing', $data);

                                    $t++;
                                  }
                                }
                              }
                            }
                          }
                        }
                      }

                      $foil = "";
                      $printing_output_quantity = "";

                      if (!empty($shoulder_code)) {
                        $data['shoulder_specs'] = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $shoulder_code);
                        foreach ($data['shoulder_specs'] as $shoulder_specs) {
                          $shoulder_specss['spec_id'] = $shoulder_specs->spec_id;
                          $shoulder_specss['spec_version_no'] = $shoulder_specs->spec_version_no;

                          $data = array('sleeve_diameter' => $dia);
                          $data['sleeve_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id'], $data);
                          foreach ($data['sleeve_details'] as $sleeve_details_row) {
                            $sleeve_id = $sleeve_details_row->sleeve_id;
                          }

                          $shoulder_specs_result = $this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $shoulder_specss);
                          if ($shoulder_specs_result) {
                            foreach ($shoulder_specs_result as $shoulder_specs_row) {
                              $shoulder_type = $shoulder_specs_row->SHOULDER_STYLE;
                              $shoulder_orifice = $shoulder_specs_row->SHOULDER_ORIFICE;
                              $shoulder_foil_tag = $shoulder_specs_row->SHOULDER_FOIL_TAG;
                            }
                          }


                          $data = array('shoulder_type' => $shoulder_type);
                          $data['shoulder_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_types_master', $this->session->userdata['logged_in']['company_id'], $data);

                          foreach ($data['shoulder_details'] as $shoulder_details_row) {
                            $shoulder_id = $shoulder_details_row->shld_type_id;
                          }


                          $data = array('shoulder_orifice' => $shoulder_orifice);
                          $data['shoulder_orifice_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id'], $data);
                          if ($data['shoulder_orifice_details'] == FALSE) {
                            $orifice_id = '';
                          } else {
                            foreach ($data['shoulder_orifice_details'] as $shoulder_orifice_details_row) {
                              $orifice_id = $shoulder_orifice_details_row->orifice_id;
                            }
                          }




                          $data = array(
                            'sleeve_id' => $sleeve_id,
                            'shld_type_id' => $shoulder_id,
                            'shld_orifice_id' => $orifice_id
                          );

                          $data['shoulder_weight_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], $data);


                          foreach ($data['shoulder_weight_details'] as $shoulder_weight_details_row) {
                            $shoulder_weight = $this->common_model->read_number($shoulder_weight_details_row->shld_weight, $this->session->userdata['logged_in']['company_id']);
                          }

                          $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '2');

                          foreach ($data['workprocedure_types_master'] as $workprocedure_types_master) {
                            $shoulder_rejection = $this->common_model->read_number($workprocedure_types_master->rejection_perc, $this->session->userdata['logged_in']['company_id']);
                          }
                          $shoulder_weight = (($shoulder_weight + (($shoulder_weight / 100) * $shoulder_rejection)) / 1000) * $this->input->post('job_card_quantity');


                          $shoulder_weight = $shoulder_weight / 100;



                          $data['specification_shoulder_details'] = $this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $shoulder_specs->spec_id, 'specification_sheet_details.spec_version_no', $shoulder_specs->spec_version_no, 'item_group_id', '4', 'material', '1', 'layer_no', '1', 'srd_id', 'asc', 'layer_no', 'asc');



                          foreach ($data['specification_shoulder_details'] as $specification_shoulder_details_row) {

                            if (!empty($specification_shoulder_details_row->mat_info) && !empty($specification_shoulder_details_row->mat_article_no)) {
                              $specification_shoulder_details_row->mat_article_no . " " . rtrim($specification_shoulder_details_row->mat_info, "%");
                              $rm_qty = round($shoulder_weight * $specification_shoulder_details_row->mat_info, 2);


                              $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                              foreach ($data['max_mm'] as $max_mm_row) {
                                $mm_id = $max_mm_row->mm_id + 1;
                              }

                              $data = array(
                                'manu_order_no' => $jobcard_no,
                                'article_no' => $specification_shoulder_details_row->mat_article_no,
                                'demand_qty' => $this->common_model->save_number($rm_qty, $this->session->userdata['logged_in']['company_id']),
                                'company_id' => $this->session->userdata['logged_in']['company_id'],
                                'work_proc_no' => '2',
                                'from_job_card' => '1',
                                'rel_demand_qty' => $this->common_model->save_number($rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                                'flag_uom_type' => '1',
                                'mm_id' => $mm_id,
                                'rel_uom_id' => 'UOM013',
                                'part_pos_no' => $t
                              );
                              $this->common_model->save('material_manufacturing', $data);
                            }
                            $t++;
                          }
                        }
                      }

                      if (!empty($label_code)) {
                        $foil = "";
                        $data['label_specs'] = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $label_code);
                        foreach ($data['label_specs'] as $label_specs) {

                          $label_specss['spec_id'] = $label_specs->spec_id;
                          $label_specss['spec_version_no'] = $label_specs->spec_version_no;


                          $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');
                          foreach ($data['workprocedure_types_master'] as $workprocedure_types_master) {
                            $printing_rejection = $this->common_model->read_number($workprocedure_types_master->rejection_perc, $this->session->userdata['logged_in']['company_id']);
                          }



                          $data['label_specification_details'] = $this->sales_order_book_model->select_label_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $label_specss);

                          if ($data['label_specification_details'] == FALSE) {
                            $LABEL_NAME = "";
                            $LABEL_LACQUER_ONE = "";
                            $LABEL_LACQUER_ONE_PERC = "";
                            $LABEL_LACQUER_TWO = "";
                            $LABEL_LACQUER_TWO_PERC = "";
                            $LABEL_OE = "";
                            $LABEL_SE = "";
                          } else {
                            foreach ($data['label_specification_details'] as $specs_details_row) {
                              $LABEL_NAME = $specs_details_row->LABEL_NAME;
                              $LABEL_LACQUER_ONE = $specs_details_row->LABEL_LACQUER_ONE;
                              $LABEL_LACQUER_ONE_PERC = $specs_details_row->LABEL_LACQUER_ONE_PERC;
                              $LABEL_LACQUER_TWO = $specs_details_row->LABEL_LACQUER_TWO;
                              $LABEL_LACQUER_TWO_PERC = $specs_details_row->LABEL_LACQUER_TWO_PERC;
                              $LABEL_OE = $specs_details_row->OE;
                              $LABEL_SE = $specs_details_row->SE;
                            }
                          }
                          $printing_job_card_quantity = "";
                          $printing_output_quantity = "";
                          $printing_job_card_quantity = ($this->input->post('job_card_quantity') - ($this->input->post('job_card_quantity') / 100) * $shoulder_rejection);
                          $printing_output_quantity = $printing_job_card_quantity - (($printing_job_card_quantity / 100) * $printing_rejection);
                          $printing_job_card_quantity = $printing_job_card_quantity + (($printing_job_card_quantity / 100) * $printing_rejection);




                          if (!empty($LABEL_LACQUER_ONE)) {
                            $length = $length - $LABEL_OE;
                            $length_from = $length - 10;
                            $length_to = $length + 10;
                            $result_lacquer_gm_tube = $this->common_model->article_no_generationn('lacquer_consumption_master', $this->session->userdata['logged_in']['company_id'], 'length_from>=', $length_from, 'length_to<=', $length_to, 'sleeve_id', $sleeve_id, 'article_no', $LABEL_LACQUER_ONE);
                            if ($result_lacquer_gm_tube) {
                              foreach ($result_lacquer_gm_tube as $row_lacquer_gm_tube) {
                                $lacquer_one_gm_tube = $row_lacquer_gm_tube->consumption_per_tube;
                              }
                            }
                            $lacquer_one_rm_qty = ((($lacquer_one_gm_tube / 1000) * $printing_job_card_quantity) / 100) * $LABEL_LACQUER_ONE_PERC;
                          }

                          if (!empty($LABEL_LACQUER_TWO)) {
                            $length = $length - $LABEL_OE;
                            $length_from = $length - 10;
                            $length_to = $length + 10;
                            $result_lacquer_gm_tube = $this->common_model->article_no_generationn('lacquer_consumption_master', $this->session->userdata['logged_in']['company_id'], 'length_from>=', $length_from, 'length_to<=', $length_to, 'sleeve_id', $sleeve_id, 'article_no', $LABEL_LACQUER_TWO);
                            if ($result_lacquer_gm_tube) {
                              foreach ($result_lacquer_gm_tube as $row_lacquer_gm_tube) {
                                $lacquer_two_gm_tube = $row_lacquer_gm_tube->consumption_per_tube;
                              }
                            }
                            $lacquer_two_rm_qty = ((($lacquer_two_gm_tube / 1000) * $printing_job_card_quantity) / 100) * $LABEL_LACQUER_TWO_PERC;
                          }
                          //$printing_job_card_quantity=($this->input->post('job_card_quantity')-($this->input->post('job_card_quantity')/100)*$shoulder_rejection);




                          if (!empty($lacquer_one_rm_qty)) {

                            $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);

                            foreach ($data['max_mm'] as $max_mm_row) {
                              $mm_id = $max_mm_row->mm_id + 1;
                            }

                            $data = array(
                              'manu_order_no' => $jobcard_no,
                              'article_no' => $LABEL_LACQUER_ONE,
                              'demand_qty' => $this->common_model->save_number($lacquer_one_rm_qty, $this->session->userdata['logged_in']['company_id']),
                              'company_id' => $this->session->userdata['logged_in']['company_id'],
                              'work_proc_no' => '3',
                              'from_job_card' => '1',
                              'rel_demand_qty' => $this->common_model->save_number($lacquer_one_rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                              'flag_uom_type' => '1',
                              'mm_id' => $mm_id,
                              'rel_uom_id' => '9',
                              'part_pos_no' => $t
                            );

                            $this->common_model->save('material_manufacturing', $data);
                            $t++;
                          }



                          if (!empty($lacquer_two_rm_qty)) {

                            $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);

                            foreach ($data['max_mm'] as $max_mm_row) {
                              $mm_id = $max_mm_row->mm_id + 1;
                            }

                            $data = array(
                              'manu_order_no' => $jobcard_no,
                              'article_no' => $LABEL_LACQUER_TWO,
                              'demand_qty' => $this->common_model->save_number($lacquer_two_rm_qty, $this->session->userdata['logged_in']['company_id']),
                              'company_id' => $this->session->userdata['logged_in']['company_id'],
                              'work_proc_no' => '3',
                              'from_job_card' => '1',
                              'rel_demand_qty' => $this->common_model->save_number($lacquer_two_rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                              'flag_uom_type' => '1',
                              'mm_id' => $mm_id,
                              'rel_uom_id' => '9',
                              'part_pos_no' => $t
                            );

                            $this->common_model->save('material_manufacturing', $data);
                            $t++;
                          }


                          if (!empty($LABEL_NAME)) {

                            $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);

                            foreach ($data['max_mm'] as $max_mm_row) {
                              $mm_id = $max_mm_row->mm_id + 1;
                            }

                            $data = array(
                              'manu_order_no' => $jobcard_no,
                              'article_no' => $LABEL_NAME,
                              'demand_qty' => '',
                              'company_id' => $this->session->userdata['logged_in']['company_id'],
                              'work_proc_no' => '5',
                              'from_job_card' => '1',
                              'rel_demand_qty' => '',
                              'flag_uom_type' => '1',
                              'mm_id' => $mm_id,
                              'rel_uom_id' => '9',
                              'part_pos_no' => $t
                            );

                            $this->common_model->save('material_manufacturing', $data);
                            $t++;
                          }
                        }
                      }




                      if (!empty($this->input->post('artwork_no')) && !empty($this->input->post('artwork_version_no'))) {
                        $foil = "";

                        $artwork_data = array('ad_id' => $this->input->post('artwork_no'), 'version_no' => $this->input->post('artwork_version_no'));
                        $this->load->model('artwork_model');

                        $result_print_type = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '17');
                        if ($result_print_type) {
                          foreach ($result_print_type as $print_type_row) {
                            strtoupper($print_type_row->parameter_value);
                          }
                        }



                        $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');
                        foreach ($data['workprocedure_types_master'] as $workprocedure_types_master) {
                          $printing_rejection = $this->common_model->read_number($workprocedure_types_master->rejection_perc, $this->session->userdata['logged_in']['company_id']);
                        }
                        $printing_job_card_quantity = "";
                        $printing_job_card_quantity = ($this->input->post('job_card_quantity') - ($this->input->post('job_card_quantity') / 100) * $shoulder_rejection);
                        $printing_output_quantity = $printing_job_card_quantity - (($printing_job_card_quantity / 100) * $printing_rejection);

                        $printing_job_card_quantity = $printing_job_card_quantity + (($printing_job_card_quantity / 100) * $printing_rejection);

                        $result_hot_foil = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '11');

                        $result_hot_foil_one = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '23');

                        $result_hot_foil_one_per_tube = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '24');

                        $result_hot_foil_two = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '25');

                        $result_hot_foil_two_per_tube = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '26');

                        $result_lacquer_type = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '12');

                        $result_lacquer_one = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '27');

                        $result_lacquer_one_pc = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '28');

                        $result_lacquer_two = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '29');

                        $result_lacquer_two_pc = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '30');

                        $result_sealing_non_lacquring = $this->artwork_model->select_details_record_where('artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '5');
                        if ($result_sealing_non_lacquring) {
                          foreach ($result_sealing_non_lacquring as $sealing_non_lacquring_row) {
                            $lacquer_length = $length - $sealing_non_lacquring_row->parameter_value;
                            $lacquer_length_from = $lacquer_length - 15;
                            $lacquer_length_to = $lacquer_length + 15;
                          }
                        } else {
                          $lacquer_length = "";
                        }

                        if ($result_lacquer_one) {

                          foreach ($result_lacquer_one as $result_lacquer_one_row) {
                            $LACQUER_ONE = $result_lacquer_one_row->parameter_value;
                          }
                        }

                        if ($result_lacquer_one) {
                          $result_lacquer_gm_tube = $this->common_model->article_no_generationn('lacquer_consumption_master', $this->session->userdata['logged_in']['company_id'], 'length_from>=', $lacquer_length_from, 'length_to<=', $lacquer_length_to, 'sleeve_id', $sleeve_id, 'article_no', $LACQUER_ONE);

                          $this->db->last_query();
                          if ($result_lacquer_gm_tube) {
                            foreach ($result_lacquer_gm_tube as $row_lacquer_gm_tube) {
                              $lacquer_one_gm_tube = $row_lacquer_gm_tube->consumption_per_tube;
                            }
                          }
                        }
                        if ($result_lacquer_one_pc) {
                          foreach ($result_lacquer_one_pc as $result_lacquer_one_pc_row) {
                            $LACQUER_ONE_PERC = $result_lacquer_one_pc_row->parameter_value;
                          }
                          $lacquer_one_rm_qty = ((($lacquer_one_gm_tube / 1000) * $printing_job_card_quantity) / 100) * $LACQUER_ONE_PERC;
                        }

                        if ($result_lacquer_one) {

                          foreach ($result_lacquer_one as $result_lacquer_one_row) {
                            $LACQUER_TWO = $result_lacquer_one_row->parameter_value;
                          }
                        }

                        if ($result_lacquer_two) {
                          $result_lacquer_gm_tube = $this->common_model->article_no_generationn('lacquer_consumption_master', $this->session->userdata['logged_in']['company_id'], 'length_from>=', $lacquer_length_from, 'length_to<=', $lacquer_length_to, 'sleeve_id', $sleeve_id, 'article_no', $LACQUER_TWO);
                          if ($result_lacquer_gm_tube) {
                            foreach ($result_lacquer_gm_tube as $row_lacquer_gm_tube) {
                              $lacquer_two_gm_tube = $row_lacquer_gm_tube->consumption_per_tube;
                            }
                          }
                        }

                        if ($result_lacquer_two_pc) {
                          foreach ($result_lacquer_two_pc as $result_lacquer_two_pc_row) {
                            $LACQUER_TWO_PERC = $result_lacquer_two_pc_row->parameter_value;
                          }
                          $lacquer_two_rm_qty = ((($lacquer_two_gm_tube / 1000) * $printing_job_card_quantity) / 100) * $LACQUER_TWO_PERC;
                        }


                        if ($result_lacquer_one) {

                          foreach ($result_lacquer_one as $result_lacquer_one_row) {
                            $LACQUER_ONE = $result_lacquer_one_row->parameter_value;
                          }

                          if (!empty($LACQUER_ONE)) {
                            $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                            foreach ($data['max_mm'] as $max_mm_row) {
                              $mm_id = $max_mm_row->mm_id + 1;
                            }

                            $data = array(
                              'manu_order_no' => $jobcard_no,
                              'article_no' => $LACQUER_ONE,
                              'demand_qty' => $this->common_model->save_number($lacquer_one_rm_qty, $this->session->userdata['logged_in']['company_id']),
                              'company_id' => $this->session->userdata['logged_in']['company_id'],
                              'work_proc_no' => '3',
                              'from_job_card' => '1',
                              'rel_demand_qty' => $this->common_model->save_number($lacquer_one_rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                              'flag_uom_type' => '1',
                              'mm_id' => $mm_id,
                              'rel_uom_id' => '9',
                              'part_pos_no' => $t
                            );

                            $this->common_model->save('material_manufacturing', $data);
                            $t++;
                          }
                        }


                        if ($result_lacquer_two) {

                          foreach ($result_lacquer_two as $result_lacquer_two_row) {
                            $LACQUER_TWO = $result_lacquer_two_row->parameter_value;
                          }

                          if (!empty($LACQUER_TWO)) {

                            $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                            foreach ($data['max_mm'] as $max_mm_row) {
                              $mm_id = $max_mm_row->mm_id + 1;
                            }

                            $data = array(
                              'manu_order_no' => $jobcard_no,
                              'article_no' => $LACQUER_TWO,
                              'demand_qty' => $this->common_model->save_number($lacquer_two_rm_qty, $this->session->userdata['logged_in']['company_id']),
                              'company_id' => $this->session->userdata['logged_in']['company_id'],
                              'work_proc_no' => '3',
                              'from_job_card' => '1',
                              'rel_demand_qty' => $this->common_model->save_number($lacquer_two_rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                              'flag_uom_type' => '1',
                              'mm_id' => $mm_id,
                              'rel_uom_id' => '9',
                              'part_pos_no' => $t
                            );
                            $this->common_model->save('material_manufacturing', $data);
                            $t++;
                          }
                        }




                        if ($result_hot_foil_one == TRUE) {

                          $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '6');
                          foreach ($data['workprocedure_types_master'] as $workprocedure_types_master) {
                            $foiling_rejection = $this->common_model->read_number($workprocedure_types_master->rejection_perc, $this->session->userdata['logged_in']['company_id']);
                          }

                          $foiling_job_card_quantity = "";
                          $foiling_job_card_quantity = $printing_output_quantity + (($printing_output_quantity / 100) * $foiling_rejection);



                          foreach ($result_hot_foil_one as $hot_foil_row) {
                            $hot_foil_one = $hot_foil_row->parameter_value;
                          }

                          if (!empty($hot_foil_one)) {
                            $foil = 1;

                            foreach ($result_hot_foil_one_per_tube as $hot_foil_row) {
                              $hot_foil_one_per_tube = $hot_foil_row->parameter_value;
                              $hot_foil_one_per_tube_thirty_extra = (($hot_foil_row->parameter_value / 100) * 30);
                              $hot_foil_one_rm_qty = ($hot_foil_one_per_tube + $hot_foil_one_per_tube_thirty_extra) * $foiling_job_card_quantity;

                              $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                              foreach ($data['max_mm'] as $max_mm_row) {
                                $mm_id = $max_mm_row->mm_id + 1;
                              }

                              $data = array(
                                'manu_order_no' => $jobcard_no,
                                'article_no' => $hot_foil_one,
                                'demand_qty' => $this->common_model->save_number($hot_foil_one_rm_qty, $this->session->userdata['logged_in']['company_id']),
                                'company_id' => $this->session->userdata['logged_in']['company_id'],
                                'work_proc_no' => '6',
                                'from_job_card' => '1',
                                'rel_demand_qty' => $this->common_model->save_number($hot_foil_one_rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                                'flag_uom_type' => '1',
                                'mm_id' => $mm_id,
                                'rel_uom_id' => '9',
                                'part_pos_no' => $t
                              );
                              $this->common_model->save('material_manufacturing', $data);
                              $t++;
                            }
                          } else {
                            $foil = "";
                          }
                        }


                        if ($result_hot_foil_two == TRUE) {

                          foreach ($result_hot_foil_two as $hot_foil_row) {
                            $hot_foil_two = $hot_foil_row->parameter_value;
                          }
                          if (!empty($hot_foil_two)) {
                            $foil = 1;
                            foreach ($result_hot_foil_two_per_tube as $hot_foil_row) {
                              $hot_foil_two_per_tube = $hot_foil_row->parameter_value;
                              $hot_foil_two_per_tube_thirty_extra = (($hot_foil_row->parameter_value / 100) * 30);
                              $hot_foil_two_rm_qty = ($hot_foil_two_per_tube + $hot_foil_two_per_tube_thirty_extra) * $foiling_job_card_quantity;

                              $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                              foreach ($data['max_mm'] as $max_mm_row) {
                                $mm_id = $max_mm_row->mm_id + 1;
                              }

                              $data = array(
                                'manu_order_no' => $jobcard_no,
                                'article_no' => $hot_foil_two,
                                'demand_qty' => $this->common_model->save_number($hot_foil_two_rm_qty, $this->session->userdata['logged_in']['company_id']),
                                'company_id' => $this->session->userdata['logged_in']['company_id'],
                                'work_proc_no' => '6',
                                'from_job_card' => '1',
                                'rel_demand_qty' => $this->common_model->save_number($hot_foil_two_rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                                'flag_uom_type' => '1',
                                'mm_id' => $mm_id,
                                'rel_uom_id' => '9',
                                'part_pos_no' => $t
                              );
                              $this->common_model->save('material_manufacturing', $data);
                              $t++;
                            }
                          }
                        }
                      }


                      if (!empty($shoulder_code)) {
                        $data['shoulder_specs'] = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $shoulder_code);
                        foreach ($data['shoulder_specs'] as $shoulder_specs) {
                          $shoulder_specss['spec_id'] = $shoulder_specs->spec_id;
                          $shoulder_specss['spec_version_no'] = $shoulder_specs->spec_version_no;

                          $data = array('sleeve_diameter' => $dia);
                          $data['sleeve_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id'], $data);
                          foreach ($data['sleeve_details'] as $sleeve_details_row) {
                            $sleeve_id = $sleeve_details_row->sleeve_id;
                          }

                          $shoulder_specs_result = $this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $shoulder_specss);
                          if ($shoulder_specs_result) {
                            foreach ($shoulder_specs_result as $shoulder_specs_row) {
                              $shoulder_type = $shoulder_specs_row->SHOULDER_STYLE;
                              $shoulder_orifice = $shoulder_specs_row->SHOULDER_ORIFICE;
                              $shoulder_foil_tag = $shoulder_specs_row->SHOULDER_FOIL_TAG;


                              if (!empty($shoulder_foil_tag)) {
                                $shoulder_foil_data = array(
                                  'article_no' => $shoulder_foil_tag,
                                  'sleeve_id' => $sleeve_id
                                );
                                $shoulder_foil_details_result = $this->common_model->select_active_records_where('shoulder_foil_master', $this->session->userdata['logged_in']['company_id'], $shoulder_foil_data);
                                if ($shoulder_foil_details_result) {

                                  $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

                                  foreach ($data['workprocedure_types_master'] as $workprocedure_types_master) {
                                    $shoulder_foil_rejection = $this->common_model->read_number($workprocedure_types_master->rejection_perc, $this->session->userdata['logged_in']['company_id']);
                                  }
                                  $shoulder_foil = 1;
                                  $shoulder_foil_job_card_quantity = "";
                                  if ($foil == 1) {
                                    $shoulder_foil_job_card_quantity = $foiling_job_card_quantity + (($foiling_job_card_quantity / 100) * $shoulder_foil_rejection);
                                  } else {
                                    $shoulder_foil_job_card_quantity = $printing_output_quantity + (($printing_output_quantity / 100) * $shoulder_foil_rejection);
                                  }

                                  foreach ($shoulder_foil_details_result as $shoulder_foil_details_row) {
                                    $total_shoulder_foil_material = $shoulder_foil_details_row->sqm_per_tube;
                                    $shoulder_foil_material_qty = $total_shoulder_foil_material * $shoulder_foil_job_card_quantity;
                                    $shoulder_foil_material_qty = round($shoulder_foil_material_qty, 2);
                                  }

                                  $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                                  foreach ($data['max_mm'] as $max_mm_row) {
                                    $mm_id = $max_mm_row->mm_id + 1;
                                  }

                                  $data = array(
                                    'manu_order_no' => $jobcard_no,
                                    'article_no' => $shoulder_foil_tag,
                                    'demand_qty' => $this->common_model->save_number($shoulder_foil_material_qty, $this->session->userdata['logged_in']['company_id']),
                                    'company_id' => $this->session->userdata['logged_in']['company_id'],
                                    'work_proc_no' => '7',
                                    'from_job_card' => '1',
                                    'rel_demand_qty' => $this->common_model->save_number($shoulder_foil_material_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                                    'flag_uom_type' => '1',
                                    'mm_id' => $mm_id,
                                    'rel_uom_id' => '9',
                                    'part_pos_no' => $t
                                  );

                                  $this->common_model->save('material_manufacturing', $data);
                                  $t++;
                                }
                              } else {
                                $shoulder_foil = "";
                              }
                            }
                          }
                        }
                      }


                      if (!empty($cap_code)) {
                        $data['cap_specs'] = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $cap_code);
                        foreach ($data['cap_specs'] as $cap_specs) {
                          $cap_specss['spec_id'] = $cap_specs->spec_id;
                          $cap_specss['spec_version_no'] = $cap_specs->spec_version_no;
                        }

                        $data['specs_details'] = $this->sales_order_book_model->select_cap_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $cap_specss);
                        foreach ($data['specs_details'] as $specs_details_row) {
                          $CAP_STYLE = $specs_details_row->CAP_STYLE;
                          $CAP_MOLD_FINISH = $specs_details_row->CAP_MOLD_FINISH;
                          $CAP_ORIFICE = $specs_details_row->CAP_ORIFICE;
                          $CAP_DIA = $specs_details_row->CAP_DIA;
                          $CAP_FOIL_COLOR = $specs_details_row->CAP_FOIL_COLOR;
                          $CAP_FOIL_CODE = $specs_details_row->CAP_FOIL_CODE;
                          $CAP_SHRINK_SLEEVE = $specs_details_row->CAP_SHRINK_SLEEVE;
                          $CAP_MASTER_BATCH = $specs_details_row->CAP_MASTER_BATCH;
                          $CAP_METALIZATION = $specs_details_row->CAP_METALIZATION;
                          $CAP_MB_PERC = $specs_details_row->CAP_MB_PERC;
                          $CAP_SHRINK_SLEEVE_CODE = $specs_details_row->CAP_SHRINK_SLEEVE_CODE;
                        }

                        $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '11');
                        foreach ($data['workprocedure_types_master'] as $workprocedure_types_master) {
                          $capping_rejection = $this->common_model->read_number($workprocedure_types_master->rejection_perc, $this->session->userdata['logged_in']['company_id']);
                        }



                        $cap_job_card_quantity = "";

                        if ($foil == 1) {

                          $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '6');
                          foreach ($data['workprocedure_types_master'] as $workprocedure_types_master) {
                            $foiling_rejection = $this->common_model->read_number($workprocedure_types_master->rejection_perc, $this->session->userdata['logged_in']['company_id']);
                          }

                          $foiling_job_card_quantity = "";
                          $foiling_job_card_quantity = $printing_output_quantity + (($printing_output_quantity / 100) * $foiling_rejection);
                          $foiling_output_quantity = ($printing_output_quantity - (($printing_output_quantity / 100) * $foiling_rejection));
                          $cap_job_card_quantity = round($foiling_output_quantity + (($foiling_output_quantity / 100) * $capping_rejection));
                        } else if ($shoulder_foil == 1) {

                          $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

                          foreach ($data['workprocedure_types_master'] as $workprocedure_types_master) {
                            $shoulder_foil_rejection = $this->common_model->read_number($workprocedure_types_master->rejection_perc, $this->session->userdata['logged_in']['company_id']);
                          }

                          if ($foil == 1) {
                            $shoulder_foil_job_card_quantity = $foiling_job_card_quantity + (($foiling_job_card_quantity / 100) * $shoulder_foil_rejection);
                            $shoulder_foil_output_quantity = ($foiling_output_quantity - (($foiling_output_quantity / 100) * $shoulder_foil_rejection));
                            $cap_job_card_quantity = round($shoulder_foil_output_quantity + (($shoulder_foil_output_quantity / 100) * $capping_rejection));
                          } else {
                            $shoulder_foil_job_card_quantity = $printing_output_quantity + (($printing_output_quantity / 100) * $shoulder_foil_rejection);
                            $shoulder_foil_output_quantity = ($printing_output_quantity - (($printing_output_quantity / 100) * $shoulder_foil_rejection));
                            $cap_job_card_quantity = round($shoulder_foil_output_quantity + (($shoulder_foil_output_quantity / 100) * $capping_rejection));
                          }
                        } else {
                          $cap_job_card_quantity = round($printing_output_quantity + (($printing_output_quantity / 100) * $capping_rejection));
                        }

                        if (!empty($cap_code)) {

                          $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                          foreach ($data['max_mm'] as $max_mm_row) {
                            $mm_id = $max_mm_row->mm_id + 1;
                          }

                          $data = array(
                            'manu_order_no' => $jobcard_no,
                            'article_no' => $cap_code,
                            'demand_qty' => $this->common_model->save_number($cap_job_card_quantity, $this->session->userdata['logged_in']['company_id']),
                            'company_id' => $this->session->userdata['logged_in']['company_id'],
                            'work_proc_no' => '11',
                            'from_job_card' => '1',
                            'rel_demand_qty' => $this->common_model->save_number($cap_job_card_quantity * 1000, $this->session->userdata['logged_in']['company_id']),
                            'flag_uom_type' => '1',
                            'mm_id' => $mm_id,
                            'rel_uom_id' => '9',
                            'part_pos_no' => $t
                          );
                          $this->common_model->save('material_manufacturing', $data);
                          $t++;
                        }


                        if (!empty($CAP_SHRINK_SLEEVE_CODE)) {

                          $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                          foreach ($data['max_mm'] as $max_mm_row) {
                            $mm_id = $max_mm_row->mm_id + 1;
                          }

                          $data = array(
                            'manu_order_no' => $jobcard_no,
                            'article_no' => $CAP_SHRINK_SLEEVE_CODE,
                            'demand_qty' => $this->common_model->save_number($cap_job_card_quantity, $this->session->userdata['logged_in']['company_id']),
                            'company_id' => $this->session->userdata['logged_in']['company_id'],
                            'work_proc_no' => '11',
                            'from_job_card' => '1',
                            'rel_demand_qty' => $this->common_model->save_number($cap_job_card_quantity * 1000, $this->session->userdata['logged_in']['company_id']),
                            'flag_uom_type' => '1',
                            'mm_id' => $mm_id,
                            'rel_uom_id' => '9',
                            'part_pos_no' => $t
                          );
                          $this->common_model->save('material_manufacturing', $data);
                          $t++;
                        }





                        $cap_specs_result = $this->sales_order_book_model->select_cap_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $cap_specss);
                        if ($cap_specs_result) {
                          foreach ($cap_specs_result as $cap_specs_row) {
                            $cap_dia = $cap_specs_row->CAP_DIA;
                            $cap_style = $cap_specs_row->CAP_STYLE;


                            $cap_dia_data = array('cap_dia' => $cap_dia);
                            $cap_dia_result = $this->common_model->select_one_active_record_nonlanguage_without_archives('cap_diameter_master', $this->session->userdata['logged_in']['company_id'], $cap_dia_data);
                            if ($cap_dia_result) {
                              foreach ($cap_dia_result as $cap_dia_result_row) {
                                $cap_dia_id = $cap_dia_result_row->cap_dia_id;
                              }
                            }

                            $cap_style_data = array(
                              'cap_type' => $cap_style,
                              'archive<>' => 1
                            );
                            $cap_type_result = $this->common_model->select_one_active_record_nonlanguage_without_archives('cap_types_master', $this->session->userdata['logged_in']['company_id'], $cap_style_data);
                            if ($cap_type_result) {
                              foreach ($cap_type_result as $cap_type_result_row) {
                                $cap_type_id = $cap_type_result_row->cap_type_id;
                              }
                            }

                            $cap_height_data = array(
                              'cap_dia_id' => $cap_dia_id,
                              'cap_type_id' => $cap_type_id
                            );
                            $cap_height_result = $this->common_model->select_active_records_where('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], $cap_height_data);
                            //echo $this->db->last_query();
                            if ($cap_height_result) {
                              foreach ($cap_height_result as $cap_height_result_row) {
                                $cap_height = $cap_height_result_row->cap_height / 100;
                              }
                            }

                            $packing_box_result = $this->common_model->select_one_active_record_noncompany('packing_box_master', 'sleeve_id', $sleeve_id);
                            if ($packing_box_result) {
                              foreach ($packing_box_result as $packing_box_result_row) {
                                $no_of_tubes_per_box = $packing_box_result_row->no_of_tubes_per_box / 100;
                              }
                            }


                            //Eknath For Box length Calculation 13 Feb 2019------

                            $sleeve_length = 0;
                            $dia = '';
                            if (!empty($sleeve_code)) {
                              $data['sleeve_specs'] = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $sleeve_code);
                              foreach ($data['sleeve_specs'] as $sleeve_specs) {

                                $sleeve_specss['spec_id'] = $sleeve_specs->spec_id;
                                $sleeve_specss['spec_version_no'] = $sleeve_specs->spec_version_no;

                                $sleeve_specs_result = $this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $sleeve_specss);
                                if ($sleeve_specs_result) {
                                  foreach ($sleeve_specs_result as $specs_row) {
                                    $dia = $specs_row->SLEEVE_DIA;
                                    $length = $specs_row->SLEEVE_LENGTH + 3;
                                    $sleeve_length = $specs_row->SLEEVE_LENGTH;
                                  }
                                }
                              }
                            }

                            //---------------------------------
                            //echo $sleeve_length=$sleeve_length-3;
                            echo  $sleeve_length;
                            echo "<br/>";
                            echo $cap_height;
                            echo "<br/>";
                            echo $box_min_height = $sleeve_length + $cap_height + 5;
                            echo "<br/>";
                            echo $box_max_height = $box_min_height + 20;
                            echo "<br/>";
                            $box_min_height = $box_min_height * 100;

                            //echo "<br/>BOX MIN HEIGHT ";
                            // echo $box_min_height;

                            $box_max_height = $box_max_height * 100;
                            //echo "<br/>BOX MAX HEIGHT ";
                            //echo $box_max_height;

                            $cap_foil_data = array(
                              'cap_dia_id' => $cap_dia_id,
                              'cap_type_id' => $cap_type_id,
                              'article_no' => $CAP_FOIL_CODE
                            );
                            $cap_foil_result = $this->common_model->select_active_records_where('cap_foil_master', $this->session->userdata['logged_in']['company_id'], $cap_foil_data);
                            if ($cap_foil_result) {
                              foreach ($cap_foil_result as $cap_foil_row) {
                                $cap_foil_sqm_tube = $cap_foil_row->sqm_per_tube;
                                $cap_foil_sqm_tube = $cap_foil_sqm_tube * $cap_job_card_quantity;
                              }
                            }
                          }
                        }


                        if (!empty($CAP_FOIL_CODE)) {

                          $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                          foreach ($data['max_mm'] as $max_mm_row) {
                            $mm_id = $max_mm_row->mm_id + 1;
                          }

                          $data = array(
                            'manu_order_no' => $jobcard_no,
                            'article_no' => $CAP_FOIL_CODE,
                            'demand_qty' => $this->common_model->save_number($cap_foil_sqm_tube, $this->session->userdata['logged_in']['company_id']),
                            'company_id' => $this->session->userdata['logged_in']['company_id'],
                            'work_proc_no' => '11',
                            'from_job_card' => '1',
                            'rel_demand_qty' => $this->common_model->save_number($cap_foil_sqm_tube * 1000, $this->session->userdata['logged_in']['company_id']),
                            'flag_uom_type' => '1',
                            'mm_id' => $mm_id,
                            'rel_uom_id' => '9',
                            'part_pos_no' => $t
                          );
                          $this->common_model->save('material_manufacturing', $data);
                          $t++;
                        }
                      } else {
                        //echo "Hi, I am tear off shoulder";

                        $packing_box_result = $this->common_model->select_one_active_record_noncompany('packing_box_master', 'sleeve_id', $sleeve_id);
                        if ($packing_box_result) {
                          foreach ($packing_box_result as $packing_box_result_row) {
                            $no_of_tubes_per_box = $packing_box_result_row->no_of_tubes_per_box / 100;
                          }
                        }


                        //Eknath For Box length Calculation 13 Feb 2019------

                        $sleeve_length = 0;
                        $dia = '';
                        if (!empty($sleeve_code)) {
                          $data['sleeve_specs'] = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $sleeve_code);
                          foreach ($data['sleeve_specs'] as $sleeve_specs) {

                            $sleeve_specss['spec_id'] = $sleeve_specs->spec_id;
                            $sleeve_specss['spec_version_no'] = $sleeve_specs->spec_version_no;

                            $sleeve_specs_result = $this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $sleeve_specss);
                            if ($sleeve_specs_result) {
                              foreach ($sleeve_specs_result as $specs_row) {
                                $dia = $specs_row->SLEEVE_DIA;
                                $length = $specs_row->SLEEVE_LENGTH + 3;
                                $sleeve_length = $specs_row->SLEEVE_LENGTH;
                              }
                            }
                          }
                        }

                        $cap_height_data = array(
                          'sleeve_id' => $sleeve_id,
                          'shld_type_id' => $shoulder_id
                        );
                        $cap_height_result = $this->common_model->select_active_records_where('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], $cap_height_data);

                        //echo $this->db->last_query();
                        if ($cap_height_result) {
                          foreach ($cap_height_result as $cap_height_result_row) {
                            $cap_height = $cap_height_result_row->shld_height / 100;
                          }
                        }
                        //---------------------------------
                        //echo $sleeve_length=$sleeve_length-3;
                        echo $sleeve_length;
                        echo "<br/>";
                        echo $cap_height;
                        echo "<br/>";
                        echo $box_min_height = $sleeve_length + $cap_height + 5;
                        echo "<br/>";
                        echo $box_max_height = $box_min_height + 20;
                        echo "<br/>";
                        $box_min_height = $box_min_height * 100;

                        //echo "<br/>BOX MIN HEIGHT ";
                        // echo $box_min_height;

                        $box_max_height = $box_max_height * 100;
                      }


                      if ($for_export == 1) {

                        $packing_box_parameter_data = array('type' => 'EX');

                        // For Royal Talent 40 Dia PSP 5 Ply Required---------
                        //$dia_numeric=$this->common_model->select_number_from_string($dia);

                        //Changes done on 29-Dec-2020---Due to 5 Ply on mobille

                        $royal_talent_psps = array("PSP-000-1645", "PSP-000-0670", "PSP-000-0625", "PSP-000-0039", "PSP-000-0176");

                        $psp = $this->input->post('article_no');
                        //if(in_array($psp, $royal_talent_psps) && $dia_numeric=='40'){
                        if (in_array($psp, $royal_talent_psps)) {

                          $packing_box_parameter_data = array('type' => 'EX', 'ply' => '5');
                        }

                        //-----------------------------------------------------


                      } else {

                        if ($this->input->post('customer') == 1948 || $this->input->post('customer') == 1974) {
                          if ($dia == '35 MM' || $dia == '50 MM') {
                            $packing_box_parameter_data = array('type' => 'RE', 'ply' => '5');
                          } else {
                            $packing_box_parameter_data = array('type' => 'RE');
                          }
                        } else if ($this->input->post('customer') == 517 || $this->input->post('customer') == 538 || $this->input->post('customer') == 2900) {
                          $packing_box_parameter_data = array('type' => 'RE'/*,'ply'=>'3'*/);
                        } else {
                          $packing_box_parameter_data = array('type' => 'RE');
                        }
                      }
                      $packing_box_parameter_result = $this->sales_order_item_parameterwise_model->select_packing_box_record('packing_box_parameter_master', $this->session->userdata['logged_in']['company_id'], $box_min_height, $box_max_height, $packing_box_parameter_data);
                      //echo $this->db->last_query();

                      if ($packing_box_parameter_result) {

                        foreach ($packing_box_parameter_result as $packing_box_parameter_result_row) {
                          //echo "<br/>BOTTOMBOX ";
                          $packing_box_parameter_result_row->article_no;
                          $box_quantity = $this->input->post('job_card_quantity') / $no_of_tubes_per_box;
                          $box_quantity = round($box_quantity);
                          $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                          foreach ($data['max_mm'] as $max_mm_row) {
                            $mm_id = $max_mm_row->mm_id + 1;
                          }

                          $data = array(
                            'manu_order_no' => $jobcard_no,
                            'article_no' => $packing_box_parameter_result_row->article_no,
                            'demand_qty' => $this->common_model->save_number($box_quantity, $this->session->userdata['logged_in']['company_id']),
                            'company_id' => $this->session->userdata['logged_in']['company_id'],
                            'work_proc_no' => '10',
                            'from_job_card' => '1',
                            'rel_demand_qty' => $this->common_model->save_number($box_quantity * 1000, $this->session->userdata['logged_in']['company_id']),
                            'flag_uom_type' => '1',
                            'mm_id' => $mm_id,
                            'rel_uom_id' => 'UOM001',
                            'part_pos_no' => $t
                          );

                          $this->common_model->save('material_manufacturing', $data);

                          $t++;
                        }
                      }

                      $packing_box_parameter_data = array('type' => 'BOTH');
                      $packing_box_parameter_result = $this->common_model->select_active_records_where('packing_box_parameter_master', $this->session->userdata['logged_in']['company_id'], $packing_box_parameter_data);


                      if ($packing_box_parameter_result) {

                        foreach ($packing_box_parameter_result as $packing_box_parameter_result_row) {

                          if ($for_export == 1) {
                            $article_no = 'PM-CB-000-0043';
                          } else {
                            $article_no = 'PM-CB-000-0076';
                          }


                          $packing_box_parameter_result_row->article_no;
                          $box_quantity = $this->input->post('job_card_quantity') / $no_of_tubes_per_box;
                          $box_quantity = round($box_quantity);
                          $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                          foreach ($data['max_mm'] as $max_mm_row) {
                            $mm_id = $max_mm_row->mm_id + 1;
                          }

                          $data = array(
                            'manu_order_no' => $jobcard_no,
                            'article_no' => $article_no,
                            'demand_qty' => $this->common_model->save_number($box_quantity, $this->session->userdata['logged_in']['company_id']),
                            'company_id' => $this->session->userdata['logged_in']['company_id'],
                            'work_proc_no' => '10',
                            'from_job_card' => '1',
                            'rel_demand_qty' => $this->common_model->save_number($box_quantity * 1000, $this->session->userdata['logged_in']['company_id']),
                            'flag_uom_type' => '1',
                            'mm_id' => $mm_id,
                            'rel_uom_id' => 'UOM001',
                            'part_pos_no' => $t
                          );

                          $this->common_model->save('material_manufacturing', $data);

                          $t++;
                        }

                        $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                        foreach ($data['max_mm'] as $max_mm_row) {
                          $mm_id = $max_mm_row->mm_id + 1;
                        }
                        // Liner weights added on 14Th-August 2019-------
                        $liner_weight = '';
                        $liner_height = $length + $cap_height;
                        if ($liner_height > 120) {
                          $liner_article_no = 'PM-PL-000-0009';
                          $liner_weight = 0.077;
                        } else {
                          //$liner_article_no='PM-PL-000-0008';
                          $liner_article_no = 'PM-PL-000-0009';
                          //$liner_weight=0.0275;
                          $liner_weight = 0.077;
                        }
                        $liner_qty = "";
                        $liner_qty = $liner_weight * $box_quantity;
                        $data = array(
                          'manu_order_no' => $jobcard_no,
                          'article_no' => $liner_article_no,
                          'demand_qty' => $this->common_model->save_number($liner_qty, $this->session->userdata['logged_in']['company_id']),
                          'company_id' => $this->session->userdata['logged_in']['company_id'],
                          'work_proc_no' => '10',
                          'from_job_card' => '1',
                          'rel_demand_qty' => $this->common_model->save_number($liner_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                          'flag_uom_type' => '1',
                          'mm_id' => $mm_id,
                          'rel_uom_id' => 'UOM001',
                          'part_pos_no' => $t
                        );

                        $this->common_model->save('material_manufacturing', $data);

                        $t++;
                      }


                      header("refresh:1;url=" . base_url() . "index.php/" . $this->router->fetch_class());
                      $data['note'] = 'Create Transaction Completed';
                    }

                    //END
                  }
                } else {






                  $data['specification'] = $this->specification_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'specification_sheet.spec_id', $this->input->post('spec_no'), 'specification_sheet.spec_version_no', $this->input->post('spec_version_no'));
                  foreach ($data['specification'] as $specification_row) {
                    $no_of_layer = substr($specification_row->dyn_qty_present, strpos($specification_row->dyn_qty_present, "|") + 1, 1);
                  }
                  $data['specification_sleeve_details'] = $this->specification_model->select_details_record_for_jobcard_where('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $this->input->post('spec_no'), 'specification_sheet_details.spec_version_no', $this->input->post('spec_version_no'), 'item_group_id', '3', 'parameter_name', 'DIA', 'srd_id', 'asc', 'layer_no', 'asc');
                  foreach ($data['specification_sleeve_details'] as $specification_sleeve_details_row) {
                    $sleeve_diameter = $specification_sleeve_details_row->relating_master_value;
                    $dia = rtrim($specification_sleeve_details_row->relating_master_value, " MM");
                  }

                  $data['specification_sleeve_details'] = $this->specification_model->select_details_record_for_jobcard_where('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $this->input->post('spec_no'), 'specification_sheet_details.spec_version_no', $this->input->post('spec_version_no'), 'item_group_id', '3', 'parameter_name', 'LENGTH', 'srd_id', 'asc', 'layer_no', 'asc');

                  foreach ($data['specification_sleeve_details'] as $specification_sleeve_details_row) {

                    $length = rtrim($specification_sleeve_details_row->parameter_value, "MM");
                    $length = $length + 3;
                  }

                  $pi = 3.14159;
                  $density = 0.92;
                  $this->load->model('process_model');
                  $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');
                  foreach ($data['workprocedure_types_master'] as $workprocedure_types_master) {
                    $rejection = $this->common_model->read_number($workprocedure_types_master->rejection_perc, $this->session->userdata['logged_in']['company_id']);
                  }




                  $t = 1;
                  for ($i = 1; $i <= $no_of_layer; $i++) {
                    $gauge = "";

                    $data['specification_sleeve_details'] = $this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $this->input->post('spec_no'), 'specification_sheet_details.spec_version_no', $this->input->post('spec_version_no'), 'item_group_id', '3', 'layer_no', $i, 'parameter_name', 'GUAGE', 'srd_id', 'asc', 'layer_no', 'asc');
                    foreach ($data['specification_sleeve_details'] as $specification_sleeve_details_row) {
                      $gauge = rtrim($specification_sleeve_details_row->parameter_value, " MIC");
                    }
                    $sleeve_weight = "";
                    $sleeve_weight = ((((($dia * $length * $gauge * $pi * $density) / 1000000) * $rejection / 100) + (($dia * $length * $gauge * $pi * $density) / 1000000)) / 1000) * $this->input->post('job_card_quantity');
                    $sleeve_weight = $sleeve_weight / 100;

                    if ($no_of_layer == 5) {
                      if ($i == 3) {
                        $sleeve_weight = "";
                        $density = 1.18;
                        $sleeve_weight = ((((($dia * $length * $gauge * $pi * $density) / 1000000) * $rejection / 100) + (($dia * $length * $gauge * $pi * $density) / 1000000)) / 1000) * $this->input->post('job_card_quantity');
                        $sleeve_weight = $sleeve_weight / 100;
                        $density = 0.92;
                      } else {
                        $density = 0.92;
                      }
                    }







                    $data['specification_sleeve_details'] = $this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $this->input->post('spec_no'), 'specification_sheet_details.spec_version_no', $this->input->post('spec_version_no'), 'item_group_id', '3', 'material', '1', 'layer_no', $i, 'srd_id', 'asc', 'layer_no', 'asc');


                    foreach ($data['specification_sleeve_details'] as $specification_sleeve_details_row) {
                      if (!empty($specification_sleeve_details_row->mat_info) && !empty($specification_sleeve_details_row->mat_article_no)) {

                        $specification_sleeve_details_row->mat_article_no . " " . rtrim($specification_sleeve_details_row->mat_info, "%");


                        $rm_qty = round($sleeve_weight * rtrim($specification_sleeve_details_row->mat_info, "%"), 2);



                        // echo "<table><tr><td>$rm_qty</td><td>$density</td><td>$sleeve_weight</td></tr></table>";


                        //echo "<br>";

                        $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                        foreach ($data['max_mm'] as $max_mm_row) {
                          $mm_id = $max_mm_row->mm_id + 1;
                        }

                        $data = array(
                          'manu_order_no' => $jobcard_no,
                          'article_no' => $specification_sleeve_details_row->mat_article_no,
                          'demand_qty' => $this->common_model->save_number($rm_qty, $this->session->userdata['logged_in']['company_id']),
                          'company_id' => $this->session->userdata['logged_in']['company_id'],
                          'work_proc_no' => '1',
                          'from_job_card' => '1',
                          'rel_demand_qty' => $this->common_model->save_number($rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                          'flag_uom_type' => '1',
                          'mm_id' => $mm_id,
                          'rel_uom_id' => 'UOM013',
                          'part_pos_no' => $t
                        );
                        $this->common_model->save('material_manufacturing', $data);

                        $t++;
                      }
                    }

                    /*
              $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->input->post('spec_no'),'specification_sheet_details.spec_version_no',$this->input->post('spec_version_no'),'item_group_id','3','material','1','layer_no',$i,'srd_id','asc','layer_no','asc');


              foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){

              if($specification_sleeve_details_row->parameter_name=='MASTER BATCH'){
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_sleeve_details_row->mat_article_no);
                    foreach($data['article'] as $article_row){

                        if (strpos($article_row->article_name, 'TRANSPARENT') == FALSE || strpos($article_row->article_name, 'WHITE') == FALSE) {
                            $avg_purging_kg=50;
                            $data['purging']=$this->common_model->select_one_active_record('purging_perc_master',$this->session->userdata['logged_in']['company_id'],'archive<>','1');

                            foreach($data['purging'] as $purging_row){

                              $rm_qty=$this->common_model->read_number($purging_row->purging_perc,$this->session->userdata['logged_in']['company_id'])*$avg_purging_kg;

                              $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);

                              foreach($data['max_mm'] as $max_mm_row){
                                $mm_id=$max_mm_row->mm_id+1;
                              }

                              $data=array('manu_order_no'=>$jobcard_no,
                              'article_no'=>$specification_sleeve_details_row->mat_article_no,
                              'demand_qty'=>$this->common_model->save_number($rm_qty,$this->session->userdata['logged_in']['company_id']),
                              'company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'work_proc_no'=>'9',
                              'from_job_card'=>'1',
                              'rel_demand_qty'=>$this->common_model->save_number($rm_qty*1000,$this->session->userdata['logged_in']['company_id']),
                              'flag_uom_type'=>'1',
                              'mm_id'=>$mm_id,
                              'rel_uom_id'=>'UOM013',
                              'part_pos_no'=>$t);

                            $this->common_model->save('material_manufacturing',$data);

                            $t++;
                            }

                        }
                    }

                 }
               }
               */
                  }

                  $data = array('sleeve_diameter' => $sleeve_diameter);
                  $data['sleeve_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id'], $data);
                  foreach ($data['sleeve_details'] as $sleeve_details_row) {
                    $sleeve_id = $sleeve_details_row->sleeve_id;
                  }

                  $data['specification_shoulder_details'] = $this->specification_model->select_details_record_for_jobcard_where('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $this->input->post('spec_no'), 'specification_sheet_details.spec_version_no', $this->input->post('spec_version_no'), 'item_group_id', '4', 'parameter_name', 'NECK TYPE', 'srd_id', 'asc', 'layer_no', 'asc');
                  foreach ($data['specification_shoulder_details'] as $specification_shoulder_details_row) {
                    $shoulder = $specification_shoulder_details_row->relating_master_value;
                  }


                  $data = array('shoulder_type' => $shoulder);
                  $data['shoulder_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_types_master', $this->session->userdata['logged_in']['company_id'], $data);

                  foreach ($data['shoulder_details'] as $shoulder_details_row) {
                    $shoulder_id = $shoulder_details_row->shld_type_id;
                  }


                  $data['specification_shoulder_details'] = $this->specification_model->select_details_record_for_jobcard_where('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $this->input->post('spec_no'), 'specification_sheet_details.spec_version_no', $this->input->post('spec_version_no'), 'item_group_id', '4', 'parameter_name', 'ORIFICE', 'srd_id', 'asc', 'layer_no', 'asc');
                  foreach ($data['specification_shoulder_details'] as $specification_shoulder_details_row) {
                    $shoulder_orifice = $specification_shoulder_details_row->relating_master_value;
                  }

                  $data = array('shoulder_orifice' => $shoulder_orifice);
                  $data['shoulder_orifice_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id'], $data);
                  if ($data['shoulder_orifice_details'] == FALSE) {
                    $orifice_id = '';
                  } else {
                    foreach ($data['shoulder_orifice_details'] as $shoulder_orifice_details_row) {
                      $orifice_id = $shoulder_orifice_details_row->orifice_id;
                    }
                  }




                  $data = array(
                    'sleeve_id' => $sleeve_id,
                    'shld_type_id' => $shoulder_id,
                    'shld_orifice_id' => $orifice_id
                  );

                  $data['shoulder_weight_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], $data);


                  foreach ($data['shoulder_weight_details'] as $shoulder_weight_details_row) {
                    $shoulder_weight = $this->common_model->read_number($shoulder_weight_details_row->shld_weight, $this->session->userdata['logged_in']['company_id']);
                  }

                  $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '2');

                  foreach ($data['workprocedure_types_master'] as $workprocedure_types_master) {
                    $shoulder_rejection = $this->common_model->read_number($workprocedure_types_master->rejection_perc, $this->session->userdata['logged_in']['company_id']);
                  }
                  $shoulder_weight = (($shoulder_weight + (($shoulder_weight / 100) * $shoulder_rejection)) / 1000) * $this->input->post('job_card_quantity');
                  $shoulder_weight = $shoulder_weight / 100;


                  $data['specification_shoulder_details'] = $this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $this->input->post('spec_no'), 'specification_sheet_details.spec_version_no', $this->input->post('spec_version_no'), 'item_group_id', '4', 'material', '1', 'layer_no', '1', 'srd_id', 'asc', 'layer_no', 'asc');


                  $t = 1;
                  foreach ($data['specification_shoulder_details'] as $specification_shoulder_details_row) {

                    if (!empty($specification_shoulder_details_row->mat_info) && !empty($specification_shoulder_details_row->mat_article_no)) {
                      $specification_shoulder_details_row->mat_article_no . " " . rtrim($specification_shoulder_details_row->mat_info, "%");
                      $rm_qty = round($shoulder_weight * rtrim($specification_shoulder_details_row->mat_info, "%"), 2);


                      $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                      foreach ($data['max_mm'] as $max_mm_row) {
                        $mm_id = $max_mm_row->mm_id + 1;
                      }

                      $data = array(
                        'manu_order_no' => $jobcard_no,
                        'article_no' => $specification_shoulder_details_row->mat_article_no,
                        'demand_qty' => $this->common_model->save_number($rm_qty, $this->session->userdata['logged_in']['company_id']),
                        'company_id' => $this->session->userdata['logged_in']['company_id'],
                        'work_proc_no' => '2',
                        'from_job_card' => '1',
                        'rel_demand_qty' => $this->common_model->save_number($rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                        'flag_uom_type' => '1',
                        'mm_id' => $mm_id,
                        'rel_uom_id' => 'UOM013',
                        'part_pos_no' => $t
                      );
                      $this->common_model->save('material_manufacturing', $data);
                    }
                    $t++;
                  }
                }


                $dataaa = array('flag_planned' => '1');
                //$dataaa['order_details']=$this->common_model->update_one_active_record_where('order_details',$dataaa,'order_no',$this->input->post('order_no'),'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);





                $data = array(
                  'final_approval_flag' => '1',
                  'order_no' => $this->input->post('order_no'),
                  'trans_closed' => '0',
                  'order_closed' => '0'
                );

                $data['order'] = $this->sales_order_book_model->active_details_records('order_master', $data, $this->session->userdata['logged_in']['company_id']);

                $dataa = array(
                  'order_no' => $this->input->post('order_no'),
                  'article_no' => $this->input->post('article_no')
                );

                $data['note'] = 'Create Transaction Completed';
                header("refresh:1;url=" . base_url() . "index.php/" . $this->router->fetch_class());

                $data['order_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('order_details', $this->session->userdata['logged_in']['company_id'], $dataa);

                $data['customer'] = $this->customer_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'address_details.property_id', '1');

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '75');

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_book');

                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/create-form', $data);
                $this->load->view('Home/footer');
              }
            } else {
              $data['note'] = 'No New rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }



  function save_against_job_card_additional()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {
              $k = 0;
              for ($i = 1; $i <= count($this->input->post('sr_no')); $i++) {
                $k = $i - 1;
                $this->form_validation->set_rules('process[]', 'Process ' . $k . '', 'required|trim|xss_clean');
                $this->form_validation->set_rules('product_name_' . $i . '', 'Product Name ' . $i . '', 'required|trim|xss_clean|strtoupper|callback_article_check');
                $this->form_validation->set_rules('quantity_' . $i . '', 'Quantity ' . $i . '', 'required|trim|xss_clean|max_length[15]|decimal');
              }


              if ($this->form_validation->run() == FALSE) {

                $data = array('manu_order_no' => $this->input->post('job_card'));

                $data['job_card'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data);

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
                $this->load->view(ucwords($this->router->fetch_class()) . '/against-job-form', $data);
                $this->load->view('Home/footer');
              } else {
                $j = 0;
                for ($i = 1; $i <= count($this->input->post('sr_no[]')); $i++) {
                  $j = $i - 1;
                  $quantity = $this->input->post('quantity_' . $i . '');
                  $item_code = explode('//', $this->input->post('product_name_' . $i . ''));

                  $data['article'] = $this->article_model->select_one_active_record('article', $this->session->userdata['logged_in']['company_id'], 'article.article_no', $item_code[1]);
                  foreach ($data['article'] as $article_row) {
                    $uom_id = $article_row->uom_id;
                  }



                  $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                  foreach ($data['max_mm'] as $max_mm_row) {
                    $mm_id = $max_mm_row->mm_id + 1;
                  }

                  $data = array(
                    'manu_order_no' => $this->input->post('job_card'),
                    'article_no' => $item_code[1],
                    'demand_qty' => $this->common_model->save_number($quantity, $this->session->userdata['logged_in']['company_id']),
                    'company_id' => $this->session->userdata['logged_in']['company_id'],
                    'work_proc_no' => $this->input->post('process[' . $j . ']'),
                    'from_job_card' => '0',
                    'rel_demand_qty' => $this->common_model->save_number($quantity * 1000, $this->session->userdata['logged_in']['company_id']),
                    'flag_uom_type' => '1',
                    'mm_id' => $mm_id,
                    'rel_uom_id' => $uom_id,
                    'part_pos_no' => $i
                  );
                  $this->common_model->save('material_manufacturing', $data);
                }

                header("refresh:1;url=" . base_url() . "index.php/" . $this->router->fetch_class());
                $data = array('manu_order_no' => $this->input->post('job_card'));

                $data['job_card'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data);
                $data['note'] = 'Create Transaction Completed';

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
                $this->load->view(ucwords($this->router->fetch_class()) . '/against-job-form', $data);
                $this->load->view('Home/footer');
              }
            } else {
              $data['note'] = 'No New rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }


  function save_against_job_card()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {

              for ($i = 1; $i <= count($this->input->post('sr_noo')); $i++) {

                $this->form_validation->set_rules('product_namee_' . $i . '', 'Product Name ' . $i . '', 'required|trim|xss_clean|strtoupper|callback_article_check');
                $this->form_validation->set_rules('quantityy_' . $i . '', 'Quantity ' . $i . '', 'required|trim|xss_clean|max_length[15]|decimal');
              }


              if ($this->form_validation->run() == FALSE) {

                $data = array('manu_order_no' => $this->input->post('job_card'));

                $data['job_card'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data);

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
                $this->load->view(ucwords($this->router->fetch_class()) . '/against-job-form', $data);
                $this->load->view('Home/footer');
              } else {

                for ($i = 1; $i <= count($this->input->post('sr_noo[]')); $i++) {
                  $mm_id = $this->input->post('mm_id_' . $i . '');
                  $quantity = $this->input->post('quantityy_' . $i . '');
                  $item_code = explode('//', $this->input->post('product_namee_' . $i . ''));

                  $data['article'] = $this->article_model->select_one_active_record('article', $this->session->userdata['logged_in']['company_id'], 'article.article_no', $item_code[1]);
                  foreach ($data['article'] as $article_row) {
                    $uom_id = $article_row->uom_id;
                  }

                  $data = array(
                    'demand_qty' => $this->common_model->save_number($quantity, $this->session->userdata['logged_in']['company_id']),
                    'rel_demand_qty' => $this->common_model->save_number($quantity * 1000, $this->session->userdata['logged_in']['company_id'])
                  );

                  $result = $this->common_model->update_one_active_record('material_manufacturing', $data, 'mm_id', $mm_id, $this->session->userdata['logged_in']['company_id']);
                }

                header("refresh:1;url=" . base_url() . "index.php/" . $this->router->fetch_class());
                $data = array('manu_order_no' => $this->input->post('job_card'));

                $data['job_card'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('material_manufacturing', $this->session->userdata['logged_in']['company_id'], $data);
                $data['note'] = 'Create Transaction Completed';

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
                $this->load->view(ucwords($this->router->fetch_class()) . '/against-job-form', $data);
                $this->load->view('Home/footer');
              }
            } else {
              $data['note'] = 'No New rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }




  function search_result()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {

              $this->form_validation->set_rules('adr_company_id', 'Company Name', 'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
              $this->form_validation->set_rules('consin_adr_company_id', 'Contract Packer', 'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
              $this->form_validation->set_rules('article_no', 'Article No', 'trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('from_date', 'From Date', 'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('to_date', 'To Date', 'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('order_no', 'Sales order', 'trim|xss_clean');
              $this->form_validation->set_rules('for_export', 'Order Type', 'trim|xss_clean');
              $this->form_validation->set_rules('order_flag', 'Order Flag', 'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_diameter', 'Sleeve Diameter', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('sleeve_print_type', 'Sleeve Print Type', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('shoulder_type', 'Shoulder type', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('shoulder_orifice', 'Shoulder Orifice', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_orifice', 'Cap Orifice', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_finish', 'Cap finish', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('for_sampling', 'For Sample', 'trim|xss_clean');
              $this->form_validation->set_rules('final_approval_flag', 'Approval Status', 'trim|xss_clean');
              $this->form_validation->set_rules('order_closed', 'Order Status', 'trim|xss_clean');
              $this->form_validation->set_rules('trans_closed', 'Transaction Status', 'trim|xss_clean');
              $this->form_validation->set_rules('order_by', 'Sort Order By', 'trim|xss_clean');
              $this->form_validation->set_rules('approval_from_date', 'Approval From Date', 'trim|xss_clean');
              $this->form_validation->set_rules('approval_to_date', 'Approval To Date', 'trim|xss_clean');
              $this->form_validation->set_rules('delivery_from_date', 'Delivery From Date', 'trim|xss_clean');
              $this->form_validation->set_rules('delivery_to_date', 'Delivery To Date', 'trim|xss_clean');
              $this->form_validation->set_rules('customer_category', 'Customer', 'trim|xss_clean');


              if ($this->form_validation->run() == FALSE) {

                if (!empty($this->input->post('adr_company_id'))) {

                  $customer_arr = explode('//', $this->input->post('adr_company_id'));
                  if (!empty($customer_arr[1])) {
                    $data['ship_to'] = $this->relate_model->select_one_active_record('adr_relate_companies', $this->session->userdata['logged_in']['company_id'], 'adr_relate_companies.adr_company_id', $customer_arr[1], $this->session->userdata['logged_in']['language_id']);
                  }
                }

                $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);

                $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);



                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);
                $this->load->view('Home/footer');
              } else {

                $from = $this->common_model->change_date_format($this->input->post('from_date'), $this->session->userdata['logged_in']['company_id']);
                $to = $this->common_model->change_date_format($this->input->post('to_date'), $this->session->userdata['logged_in']['company_id']);

                $search = array();
                if (!empty($this->input->post('adr_company_id'))) {
                  $arr = explode('//', $this->input->post('adr_company_id'));
                  $search['customer_no'] = $arr[1];
                }

                if (!empty($this->input->post('consin_adr_company_id'))) {
                  $arr = explode('//', $this->input->post('consin_adr_company_id'));
                  $consignee = $arr[1] . '|';
                  $search['consin_adr_company_id'] = $consignee;
                }
                if (!empty($this->input->post('order_no'))) {
                  $search['order_master.order_no'] = $this->input->post('order_no');
                }
                if (!empty($this->input->post('for_export'))) {
                  $search['order_master.for_export'] = $this->input->post('for_export');
                }
                if (!empty($this->input->post('article_no'))) {

                  $arr = explode("//", $this->input->post('article_no'));
                  $article_no = $arr[1];

                  $search['order_details.article_no'] = $article_no;
                }
                if ($this->input->post('order_flag') != '') {
                  $search['order_master.order_flag'] = $this->input->post('order_flag');
                }
                if (!empty($this->input->post('for_sampling'))) {
                  $search['order_master.for_sampling'] = $this->input->post('for_sampling');
                }
                if (!empty($this->input->post('final_approval_flag'))) {
                  $search['order_master.final_approval_flag'] = $this->input->post('final_approval_flag');
                }
                if (!empty($this->input->post('order_closed'))) {
                  $search['order_master.order_closed'] = $this->input->post('order_closed');
                }
                if (!empty($this->input->post('trans_closed'))) {
                  $search['order_master.trans_closed'] = $this->input->post('trans_closed');
                }
                $order_by = '';
                if (!empty($this->input->post('order_by'))) {
                  $order_by = $this->input->post('order_by');
                }
                if (!empty($this->input->post('user_id'))) {
                  $search['order_master.user_id'] = $this->input->post('user_id');
                }
                // if(!empty($this->input->post('approval_date'))){
                //     $search['order_master.approval_date']=$this->input->post('approval_date');
                // }

                // if(!empty($this->input->post('approval_date'))){
                //     $search['order_master.approval_date']=$this->input->post('approval_date');
                // }
                // if(!empty($this->input->post('delivery_date'))){
                //     $search['order_details.delivery_date']=$this->input->post('delivery_date');
                // }

                $approval_from_date = '';
                if (!empty($this->input->post('approval_from_date'))) {
                  $approval_from_date = $this->common_model->change_date_format($this->input->post('approval_from_date'), $this->session->userdata['logged_in']['company_id']);
                }

                $approval_to_date = '';
                if (!empty($this->input->post('approval_to_date'))) {
                  $approval_to_date = $this->common_model->change_date_format($this->input->post('approval_to_date'), $this->session->userdata['logged_in']['company_id']);
                }

                $delivery_from_date = '';
                if (!empty($this->input->post('delivery_from_date'))) {
                  $delivery_from_date = $this->common_model->change_date_format($this->input->post('delivery_from_date'), $this->session->userdata['logged_in']['company_id']);
                }
                $delivery_to_date = '';
                if (!empty($this->input->post('delivery_to_date'))) {
                  $delivery_to_date = $this->common_model->change_date_format($this->input->post('delivery_to_date'), $this->session->userdata['logged_in']['company_id']);
                }

                $customer_category = '';

                if (!empty($this->input->post('customer_category'))) {
                  $arr_category = explode('//', $this->input->post('customer_category'));
                  $customer_category = $arr_category[1];
                }


                //$data['order_master']=$this->sales_order_item_parameterwise_model->active_record_search('order_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id'],$order_by);
                // echo $this->db->last_query();

                $data['order_master'] = $this->sales_order_item_parameterwise_model->active_record_search_new('order_master', $search, $from, $to, $approval_from_date, $approval_to_date, $delivery_from_date, $delivery_to_date, $this->session->userdata['logged_in']['company_id'], $order_by, $customer_category);


                if ($data['order_master'] != FALSE) {
                  $data['page_name'] = 'Sales';
                  $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

                  $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                  $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                  $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                  $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);

                  $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);



                  $this->load->view('Home/header');
                  $this->load->view('Home/nav', $data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-result', $data);
                  $this->load->view('Home/footer');
                } else {
                  $data['page_name'] = 'Sales';
                  $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                  $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                  $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                  $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                  $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);
                  $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);


                  $data['error'] = 'No record in search transaction';
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav', $data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);
                  $this->load->view('Home/footer');
                }
              }
            } else {
              $data['page_name'] = 'home';
              $data['note'] = 'No rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No New rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }

  function search_planning()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {


              $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
              $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
              $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
              $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
              $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);
              $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);


              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/search-form-planning', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No View rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }

  function search_result_planning()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->copy == 1) {

              $this->form_validation->set_rules('adr_company_id', 'Company Name', 'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
              $this->form_validation->set_rules('consin_adr_company_id', 'Contract Packer', 'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
              $this->form_validation->set_rules('article_no', 'Article No', 'trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('from_date', 'From Date', 'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('to_date', 'To Date', 'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('order_no', 'Sales order', 'trim|xss_clean');
              $this->form_validation->set_rules('for_export', 'Order Type', 'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_diameter', 'Sleeve Diameter', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('sleeve_print_type', 'Sleeve Print Type', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('shoulder_type', 'Shoulder type', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('shoulder_orifice', 'Shoulder Orifice', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_orifice', 'Cap Orifice', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_finish', 'Cap finish', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('for_sampling', 'For Sample', 'trim|xss_clean');
              $this->form_validation->set_rules('final_approval_flag', 'Approval Status', 'trim|xss_clean');
              $this->form_validation->set_rules('order_closed', 'Order Status', 'trim|xss_clean');
              $this->form_validation->set_rules('trans_closed', 'Transaction Status', 'trim|xss_clean');
              $this->form_validation->set_rules('order_by', 'Sort Order By', 'trim|xss_clean');

              $this->form_validation->set_rules('approval_from_date', 'From Date', 'trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('approval_to_date', 'To Date', 'trim|xss_clean|max_length[10]');

              $this->form_validation->set_rules('delivery_date', 'Delivery Date', 'trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('delivery_date', 'Delivery Date', 'trim|xss_clean|max_length[10]');


              if ($this->form_validation->run() == FALSE) {

                if (!empty($this->input->post('adr_company_id'))) {

                  $customer_arr = explode('//', $this->input->post('adr_company_id'));
                  if (!empty($customer_arr[1])) {
                    $data['ship_to'] = $this->relate_model->select_one_active_record('adr_relate_companies', $this->session->userdata['logged_in']['company_id'], 'adr_relate_companies.adr_company_id', $customer_arr[1], $this->session->userdata['logged_in']['language_id']);
                  }
                }

                $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);
                $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);



                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/search-form-planning', $data);
                $this->load->view('Home/footer');
              } else {

                $from = $this->common_model->change_date_format($this->input->post('from_date'), $this->session->userdata['logged_in']['company_id']);
                $to = $this->common_model->change_date_format($this->input->post('to_date'), $this->session->userdata['logged_in']['company_id']);

                $search = array();
                if (!empty($this->input->post('adr_company_id'))) {
                  $arr = explode('//', $this->input->post('adr_company_id'));
                  $search['customer_no'] = $arr[1];
                }

                if (!empty($this->input->post('consin_adr_company_id'))) {
                  $arr = explode('//', $this->input->post('consin_adr_company_id'));
                  $consignee = $arr[1] . '|';
                  $search['consin_adr_company_id'] = $consignee;
                }
                if (!empty($this->input->post('order_no'))) {
                  $search['order_master.order_no'] = $this->input->post('order_no');
                }
                if (!empty($this->input->post('for_export'))) {
                  $search['order_master.for_export'] = $this->input->post('for_export');
                }
                if (!empty($this->input->post('article_no'))) {

                  $arr = explode("//", $this->input->post('article_no'));
                  $article_no = $arr[1];

                  $search['order_details.article_no'] = $article_no;
                }
                if (!empty($this->input->post('for_sampling'))) {
                  $search['order_master.for_sampling'] = $this->input->post('for_sampling');
                }
                if (!empty($this->input->post('final_approval_flag'))) {
                  $search['order_master.final_approval_flag'] = $this->input->post('final_approval_flag');
                }
                if (!empty($this->input->post('order_closed'))) {
                  $search['order_master.order_closed'] = $this->input->post('order_closed');
                }
                if (!empty($this->input->post('trans_closed'))) {
                  $search['order_master.trans_closed'] = $this->input->post('trans_closed');
                }
                $order_by = '';
                if (!empty($this->input->post('order_by'))) {
                  $order_by = $this->input->post('order_by');
                }
                if (!empty($this->input->post('user_id'))) {
                  $search['order_master.user_id'] = $this->input->post('user_id');
                }

                $approval_from_date = '';
                if (!empty($this->input->post('approval_from_date'))) {
                  $approval_from_date = $this->common_model->change_date_format($this->input->post('approval_from_date'), $this->session->userdata['logged_in']['company_id']);
                }

                $approval_to_date = '';
                if (!empty($this->input->post('approval_to_date'))) {
                  $approval_to_date = $this->common_model->change_date_format($this->input->post('approval_to_date'), $this->session->userdata['logged_in']['company_id']);
                }

                $delivery_from_date = '';
                if (!empty($this->input->post('delivery_from_date'))) {
                  $delivery_from_date = $this->common_model->change_date_format($this->input->post('delivery_from_date'), $this->session->userdata['logged_in']['company_id']);
                }
                $delivery_to_date = '';
                if (!empty($this->input->post('delivery_to_date'))) {
                  $delivery_to_date = $this->common_model->change_date_format($this->input->post('delivery_to_date'), $this->session->userdata['logged_in']['company_id']);
                }

                $customer_category = '';

                if (!empty($this->input->post('customer_category'))) {
                  $arr_category = explode('//', $this->input->post('customer_category'));
                  $customer_category = $arr_category[1];
                }




                $data['order_master'] = $this->sales_order_item_parameterwise_model->active_record_search_planning('order_master', $search, $from, $to, $approval_from_date, $approval_to_date, $delivery_from_date, $delivery_to_date, $this->session->userdata['logged_in']['company_id'], $order_by, $customer_category);
                // echo $this->db->last_query();

                if ($data['order_master'] != FALSE) {
                  $data['page_name'] = 'Sales';
                  $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

                  $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                  $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                  $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                  $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);

                  $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);



                  $this->load->view('Home/header');
                  $this->load->view('Home/nav', $data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-form-planning', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-result-planning', $data);
                  $this->load->view('Home/footer');
                } else {
                  $data['page_name'] = 'Sales';
                  $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                  $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                  $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                  $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                  $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);

                  $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);


                  $data['error'] = 'No record in search transaction';
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav', $data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-form-planning', $data);
                  $this->load->view('Home/footer');
                }
              }
            } else {
              $data['page_name'] = 'home';
              $data['note'] = 'No rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No New rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }
  function search_planning_springtube()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {


              $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
              $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
              $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
              $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
              $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);
              $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);


              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/search-form-planning-springtube', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No View rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }

  function search_result_planning_springtube()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->copy == 1) {

              $this->form_validation->set_rules('adr_company_id', 'Company Name', 'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
              $this->form_validation->set_rules('consin_adr_company_id', 'Contract Packer', 'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
              $this->form_validation->set_rules('article_no', 'Article No', 'trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('from_date', 'From Date', 'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('to_date', 'To Date', 'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('order_no', 'Sales order', 'trim|xss_clean');
              $this->form_validation->set_rules('for_export', 'Domestic/Export', 'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_diameter', 'Sleeve Diameter', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('sleeve_print_type', 'Sleeve Print Type', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('shoulder_type', 'Shoulder type', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('shoulder_orifice', 'Shoulder Orifice', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_orifice', 'Cap Orifice', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_finish', 'Cap finish', 'xss_clean|strtoupper');
              $this->form_validation->set_rules('for_sampling', 'For Sample', 'trim|xss_clean');
              $this->form_validation->set_rules('final_approval_flag', 'Approval Status', 'trim|xss_clean');
              $this->form_validation->set_rules('order_closed', 'Order Status', 'trim|xss_clean');
              $this->form_validation->set_rules('trans_closed', 'Transaction Status', 'trim|xss_clean');
              $this->form_validation->set_rules('order_by', 'Sort Order By', 'trim|xss_clean');
              $this->form_validation->set_rules('order_flag', 'Order type', 'trim|xss_clean');

              $this->form_validation->set_rules('approval_from_date', 'Approval From Date', 'trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('approval_to_date', ' Approval To Date', 'trim|xss_clean|max_length[10]');

              $this->form_validation->set_rules('delivery_from_date', 'Delivery From Date', 'trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('delivery_to_date', 'Delivery To Date', 'trim|xss_clean|max_length[10]');



              if ($this->form_validation->run() == FALSE) {

                if (!empty($this->input->post('adr_company_id'))) {

                  $customer_arr = explode('//', $this->input->post('adr_company_id'));
                  if (!empty($customer_arr[1])) {
                    $data['ship_to'] = $this->relate_model->select_one_active_record('adr_relate_companies', $this->session->userdata['logged_in']['company_id'], 'adr_relate_companies.adr_company_id', $customer_arr[1], $this->session->userdata['logged_in']['language_id']);
                  }
                }

                $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);
                $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);



                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/search-form-planning-springtube', $data);
                $this->load->view('Home/footer');
              } else {

                $from = $this->common_model->change_date_format($this->input->post('from_date'), $this->session->userdata['logged_in']['company_id']);
                $to = $this->common_model->change_date_format($this->input->post('to_date'), $this->session->userdata['logged_in']['company_id']);

                $search = array();
                if (!empty($this->input->post('adr_company_id'))) {
                  $arr = explode('//', $this->input->post('adr_company_id'));
                  $search['customer_no'] = $arr[1];
                }

                if (!empty($this->input->post('consin_adr_company_id'))) {
                  $arr = explode('//', $this->input->post('consin_adr_company_id'));
                  $consignee = $arr[1] . '|';
                  $search['consin_adr_company_id'] = $consignee;
                }
                if (!empty($this->input->post('order_no'))) {
                  $search['order_master.order_no'] = $this->input->post('order_no');
                }
                if (!empty($this->input->post('for_export'))) {
                  $search['order_master.for_export'] = $this->input->post('for_export');
                }
                if (!empty($this->input->post('article_no'))) {

                  $arr = explode("//", $this->input->post('article_no'));
                  $article_no = $arr[1];

                  $search['order_details.article_no'] = $article_no;
                }
                if (!empty($this->input->post('for_sampling'))) {
                  $search['order_master.for_sampling'] = $this->input->post('for_sampling');
                }
                if (!empty($this->input->post('final_approval_flag'))) {
                  $search['order_master.final_approval_flag'] = $this->input->post('final_approval_flag');
                }
                if (!empty($this->input->post('order_closed'))) {
                  $search['order_master.order_closed'] = $this->input->post('order_closed');
                }
                if (!empty($this->input->post('trans_closed'))) {
                  $search['order_master.trans_closed'] = $this->input->post('trans_closed');
                }
                $order_by = '';
                if (!empty($this->input->post('order_by'))) {
                  $order_by = $this->input->post('order_by');
                }
                if (!empty($this->input->post('user_id'))) {
                  $search['order_master.user_id'] = $this->input->post('user_id');
                }

                $approval_from_date = '';
                if (!empty($this->input->post('approval_from_date'))) {
                  $approval_from_date = $this->common_model->change_date_format($this->input->post('approval_from_date'), $this->session->userdata['logged_in']['company_id']);
                }

                $approval_to_date = '';
                if (!empty($this->input->post('approval_to_date'))) {
                  $approval_to_date = $this->common_model->change_date_format($this->input->post('approval_to_date'), $this->session->userdata['logged_in']['company_id']);
                }

                $delivery_from_date = '';
                if (!empty($this->input->post('delivery_from_date'))) {
                  $delivery_from_date = $this->common_model->change_date_format($this->input->post('delivery_from_date'), $this->session->userdata['logged_in']['company_id']);
                }
                $delivery_to_date = '';
                if (!empty($this->input->post('delivery_to_date'))) {
                  $delivery_to_date = $this->common_model->change_date_format($this->input->post('delivery_to_date'), $this->session->userdata['logged_in']['company_id']);
                }

                $customer_category = '';

                if (!empty($this->input->post('customer_category'))) {
                  $arr_category = explode('//', $this->input->post('customer_category'));
                  $customer_category = $arr_category[1];
                }


                $data['order_master'] = $this->sales_order_item_parameterwise_model->active_record_search_planning_springtube('order_master', $search, $from, $to, $approval_from_date, $approval_to_date, $delivery_from_date, $delivery_to_date, $this->session->userdata['logged_in']['company_id'], $order_by, $customer_category);
                // echo $this->db->last_query();

                if ($data['order_master'] != FALSE) {
                  $data['page_name'] = 'Sales';
                  $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

                  $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                  $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                  $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                  $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);

                  $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);



                  $this->load->view('Home/header');
                  $this->load->view('Home/nav', $data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-form-planning-springtube', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-result-planning-springtube', $data);
                  $this->load->view('Home/footer');
                } else {
                  $data['page_name'] = 'Sales';
                  $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                  $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

                  $data['sleeve_diameter_master'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);
                  $data['lacquer_types_master'] = $this->common_model->select_active_drop_down('lacquer_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types_master'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice_master'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice_master'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish_master'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                  $data['user_master'] = $this->common_model->select_active_drop_down('user_master', $this->session->userdata['logged_in']['company_id']);

                  $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);


                  $data['error'] = 'No record in search transaction';
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav', $data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                  $this->load->view(ucwords($this->router->fetch_class()) . '/search-form-planning-springtube', $data);
                  $this->load->view('Home/footer');
                }
              }
            } else {
              $data['page_name'] = 'home';
              $data['note'] = 'No rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No New rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }


  // For Spring Jobcard Qty calculation by reels and reel length
  function jobcard_reels_to_qty($no_of_reels_planned = 0, $reel_length = 0)
  {

    //(NO Of reels * reel Length * 1000 / Sleeve Length For Extrusion) * Ups

    //$reel_length=$this->config->item('springtube_reel_length');
    $reel_length = 0;
    $expected_tubes = 0;
    $jobcard_qty = 0;
    $order_no = '';
    $article_no = '';
    $final_length_in_mm = 0;
    $body_making_type = '';


    if ($this->input->post('order_no') != '' && $this->input->post('article_no')) {

      $order_no = $this->input->post('order_no');
      $article_no = $this->input->post('article_no');
      $no_of_reels_planned = $this->input->post('no_of_reels');
      $reel_length = $this->input->post('reel_length');

      $data_order_details = array('order_no' => $order_no, 'article_no' => $article_no);

      $order_details_result = $this->common_model->select_active_records_where('order_details', $this->session->userdata['logged_in']['company_id'], $data_order_details);
      foreach ($order_details_result as $order_details_row) {
        $total_order_quantity = $order_details_row->total_order_quantity;
        $ad_id = $order_details_row->ad_id;
        $version_no = $order_details_row->version_no;
        $bom_no = $order_details_row->spec_id;
        $bom_version_no = $order_details_row->spec_version_no;
      }
      //Artwork Deatils-------------------------
      $data = array(
        'ad_id' => $ad_id,
        'version_no' => $version_no
      );
      $springtube_artwork_result = $this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master', $data, '', '', '', $this->session->userdata['logged_in']['company_id']);

      foreach ($springtube_artwork_result as $springtube_artwork_row) {
        $body_making_type = $springtube_artwork_row->body_making_type;
      }

      // Bill of Maaterial---------------------
      $ups = 0;
      $sleeve_mb_2 = '';
      $sleeve_mb_6 = '';
      $sleeve_diameter = '';
      $sleeve_length = '';
      $sleeve_length_extrusion = '';
      $reel_width = '';

      $film_spec_id = '';
      $film_spec_version = '';

      $data = array('bom_no' => $bom_no, 'bom_version_no' => $bom_version_no);

      $bill_of_material_result = $this->common_model->select_active_records_where('bill_of_material', $this->session->userdata['logged_in']['company_id'], $data);

      foreach ($bill_of_material_result as $bill_of_material_row) {
        $bom_id = $bill_of_material_row->bom_id;
        $film_code = $bill_of_material_row->sleeve_code;
        //$shoulder_code=$bill_of_material_row->shoulder_code;
        //$cap_code=$bill_of_material_row->cap_code;
        //$label_code=$bill_of_material_row->label_code;
        $print_type_bom = $bill_of_material_row->print_type;
        //$specs_comment=strtoupper($bill_of_material_row->comment);
      }

      //SLEEVE---------------------------------

      $film_spec_id = '';
      $film_spec_version = '';

      $film_code_result = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $film_code);

      foreach ($film_code_result as $film_code_row) {
        $film_spec_id = $film_code_row->spec_id;
        $film_spec_version = $film_code_row->spec_version_no;
      }

      $specs['spec_id'] = $film_spec_id;
      $specs['spec_version_no'] = $film_spec_version;

      $specs_result = $this->sales_order_book_model->select_film_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $specs);
      if ($specs_result) {
        foreach ($specs_result as $specs_row) {
          $sleeve_diameter = $specs_row->SLEEVE_DIA;
          $sleeve_length = $specs_row->SLEEVE_LENGTH;
          $sleeve_length_extrusion = $sleeve_length + 2.5;
          $sleeve_mb_2 = $specs_row->FILM_MASTER_BATCH_2;
          $sleeve_mb_6 = $specs_row->FILM_MASTER_BATCH_6;
        }
        $sleeve_dia_id = '';
        $result_sleeve_diameter_master = $this->common_model->select_one_active_record('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id'], 'sleeve_diameter', $sleeve_diameter);
        //print_r($result_sleeve_diameter_master);
        foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row) {
          $sleeve_dia_id = $sleeve_diameter_master_row->sleeve_id;
        }
        $data = array(
          'sleeve_dia_id' => $sleeve_dia_id,
          'seam_type' => $body_making_type
        );

        $result_spring_width_calculation = $this->common_model->select_active_records_where('spring_width_calculation', $this->session->userdata['logged_in']['company_id'], $data);

        $reel_width = 0;

        foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
          $ups = $spring_width_calculation_row->ups;
          $reel_width = ($spring_width_calculation_row->slit_width) + ($spring_width_calculation_row->ups * $spring_width_calculation_row->distance_each_side);
        }

        $expected_tubes = ($no_of_reels_planned * $reel_length * $ups * 1000) / $sleeve_length_extrusion;
        //$final_length_in_mm=($sleeve_length_extrusion*$jobcard_qty/1000)/$ups;
        //$no_of_reels_planned=round(($final_length_in_mm/$reel_length),2);
        //$no_of_reels_planned= round($no_of_reels_planned,2);
        return round($expected_tubes, 0);
      } //SPEC result

    } else {
      return '0';
    }
  }

  // Spring tube setup job card-----------------------------

  function setup_job_card()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {

        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {

              $data = array(
                'final_approval_flag' => '1',
                'order_no' => $this->uri->segment(3),
                'trans_closed' => '0',
                'order_closed <>' => '1'
              );

              $data['order'] = $this->sales_order_book_model->active_details_records('order_master', $data, $this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $dataa = array(
                'order_no' => $this->uri->segment(3),
                'article_no' => $this->uri->segment(4)
              );



              $data['order_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('order_details', $this->session->userdata['logged_in']['company_id'], $dataa);

              $data['customer'] = $this->customer_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'address_details.property_id', '1');

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '75');

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
              $this->load->view(ucwords($this->router->fetch_class()) . '/create-form-setup-jobcard', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    } else {
      $data['note'] = 'No Create rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }

  function save_setup_job_card()
  {


    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

    if ($data['module'] != FALSE) {

      foreach ($data['module'] as $module_row) {

        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_item_parameterwise');

          foreach ($data['formrights'] as $formrights_row) {

            if ($formrights_row->new == 1) {

              $this->form_validation->set_rules('spec_id', 'Specification No', 'required|trim|xss_clean');
              $this->form_validation->set_rules('job_card_quantity', 'Job Card Quantity', 'required|trim|xss_clean|max_length[15]|numeric|callback_jobcard_quantity_check');
              $this->form_validation->set_rules('no_of_reels', 'No. Of reels', 'required|trim|xss_clean|numeric');
              $this->form_validation->set_rules('reel_length', 'Default Reel Length', 'required|trim|xss_clean|numeric');
              $this->form_validation->set_rules('job_card_length_in_meters', 'Jobcard Length in meters', 'required|trim|xss_clean|numeric');

              if ($this->form_validation->run() == FALSE) {



                $data = array(
                  'final_approval_flag' => '1',
                  'order_no' => $this->input->post('order_no'),
                  'trans_closed' => '0',
                  'order_closed' => '0'
                );

                $data['order'] = $this->sales_order_book_model->active_details_records('order_master', $data, $this->session->userdata['logged_in']['company_id']);


                $dataa = array(
                  'order_no' => $this->input->post('order_no'),
                  'article_no' => $this->input->post('article_no')
                );

                $data['order_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('order_details', $this->session->userdata['logged_in']['company_id'], $dataa);

                $data['customer'] = $this->customer_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'address_details.property_id', '1');

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '75');

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);

                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_book');

                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/create-form-setup-jobcard', $data);
                $this->load->view('Home/footer');
              } else {

                $order_flag = $this->input->post('order_flag');
                $form_id = '';
                $jobcard_type = ''; // FOR SETUP
                $no_of_reels = '';
                $reel_length = '';
                $job_card_length_in_meters = '';
                $jobcard_qty = '0';


                $data = array(
                  'final_approval_flag' => '1',
                  'order_no' => $this->input->post('order_no'),
                  'trans_closed' => '0',
                  'order_closed' => '0'
                );

                $data['order'] = $this->sales_order_book_model->active_details_records('order_master', $data, $this->session->userdata['logged_in']['company_id']);

                $form_id = '103244'; //SETUP SJOB----
                $jobcard_type = '4'; // FOR SETUP
                $no_of_reels = $this->input->post('no_of_reels');
                $reel_length = $this->input->post('reel_length');
                $job_card_length_in_meters = $this->input->post('job_card_length_in_meters');
                $jobcard_qty = $this->jobcard_reels_to_qty($no_of_reels, $reel_length);
                $jobcard_qty = $this->common_model->save_number($jobcard_qty, $this->session->userdata['logged_in']['company_id']);

                $data['auto'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master', $this->session->userdata['logged_in']['company_id'], 'form_id', $form_id);
                $no = "";
                foreach ($data['auto'] as $auto_row) {

                  $data['account_periods'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master', $this->session->userdata['logged_in']['company_id'], 'finyear_close_opt', '0');
                  foreach ($data['account_periods'] as $account_periods_row) {
                    $start = date('y', strtotime($account_periods_row->fin_year_start));
                    $end = date('y', strtotime($account_periods_row->fin_year_end));
                  }
                  $no = str_pad($auto_row->curr_val, 4, "0", STR_PAD_LEFT);
                  $jobcard_no = $auto_row->textcode . $auto_row->seperator . $start . $auto_row->seperator . $end . $auto_row->seperator . $no;
                  $next_jobcard_no = $auto_row->curr_val + 1;
                }

                $data = array('curr_val' => $next_jobcard_no);

                $this->common_model->update_one_active_record('autogeneration_format_master', $data, 'form_id', $form_id, $this->session->userdata['logged_in']['company_id']);

                $data['max'] = $this->common_model->select_max_pkey_numeric('production_master', 'manu_order_no', $this->session->userdata['logged_in']['company_id']);
                foreach ($data['max'] as $max_value) {
                  $manu_order_no = $max_value->manu_order_no + 1;
                }

                $data = array(
                  'manu_order_no' => $manu_order_no,
                  'company_id' => $this->session->userdata['logged_in']['company_id'],
                  'mp_pos_no' => $jobcard_no,
                  'article_no' => $this->input->post('article_no'),
                  'mp_qty' => $this->common_model->save_number($this->input->post('order_qty'), $this->session->userdata['logged_in']['company_id']),
                  'actual_qty_manufactured' => $jobcard_qty,
                  'manu_plan_date' => date('Y-m-d'),
                  'employee_id' => $this->session->userdata['logged_in']['user_id'],
                  'sales_ord_no' => $this->input->post('order_no'),
                  'ord_pos_no' => $this->input->post('ord_pos_no'),
                  'jobcard_type' => $jobcard_type,
                  'no_of_reels' => $no_of_reels,
                  'reel_length' => $reel_length,
                  'total_meters' => $job_card_length_in_meters
                );

                $result = $this->common_model->save('production_master', $data);

                if (strtoupper(substr($this->input->post('spec_no'), 0, 3)) == 'BOM') {

                  $data = array(
                    'bom_no' => $this->input->post('spec_no'),
                    'bom_version_no' => $this->input->post('spec_version_no')
                  );
                  $data['bom_details'] = $this->common_model->select_active_records_where('bill_of_material', $this->session->userdata['logged_in']['company_id'], $data);

                  foreach ($data['bom_details'] as $bom_details_row) {
                    $sleeve_code = $bom_details_row->sleeve_code;
                    $shoulder_code = $bom_details_row->shoulder_code;
                    $label_code = $bom_details_row->label_code;
                    $cap_code = $bom_details_row->cap_code;
                    $for_export = $bom_details_row->for_export;

                    if (substr($sleeve_code, 0, 4) == "LMNF") {

                      $data['film_specs'] = $this->common_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $sleeve_code);
                      foreach ($data['film_specs'] as $film_specs) {

                        $film_specss['spec_id'] = $film_specs->spec_id;
                        $film_specss['spec_version_no'] = $film_specs->spec_version_no;

                        $film_specs_master_result = $this->common_model->select_active_records_where('specification_sheet', $this->session->userdata['logged_in']['company_id'], $film_specss);
                        if ($film_specs_master_result) {
                          foreach ($film_specs_master_result as $film_specs_master_result_row) {
                            $layer_arr = explode("|", $film_specs_master_result_row->dyn_qty_present);
                            $layer_no = substr($layer_arr[1], 0, 1);
                          }
                        }

                        $film_specs_result = $this->sales_order_book_model->select_film_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $film_specss);

                        if ($film_specs_result) {

                          foreach ($film_specs_result as $specs_row) {

                            $dia = $specs_row->SLEEVE_DIA;
                            $length = $specs_row->SLEEVE_LENGTH;
                            $total_film_guage = $specs_row->FILM_GUAGE_1 + $specs_row->FILM_GUAGE_2 + $specs_row->FILM_GUAGE_3 + $specs_row->FILM_GUAGE_4 + $specs_row->FILM_GUAGE_5 + $specs_row->FILM_GUAGE_6 + $specs_row->FILM_GUAGE_7;

                            $data['sleeve_diameter_master'] = $this->common_model->select_one_active_record('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id'], 'sleeve_diameter', $dia);
                            foreach ($data['sleeve_diameter_master'] as $sleeve_dia_row) {
                              $sleeve_dia_id = $sleeve_dia_row->sleeve_id;
                            }

                            $result_body_making_type = $this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details', $this->session->userdata['logged_in']['company_id'], 'ad_id', $this->input->post('artwork_no'), 'version_no', $this->input->post('artwork_version_no'), 'artwork_para_id', '17');

                            foreach ($result_body_making_type as $body_making_type_row) {
                              $body_making_type = $body_making_type_row->parameter_value;
                            }

                            $data = array('sleeve_dia_id' => $sleeve_dia_id, 'seam_type' => $body_making_type);
                            $result_spring_width_calculation = $this->common_model->active_record_search('spring_width_calculation', $data, $this->session->userdata['logged_in']['company_id']);
                            if ($result_spring_width_calculation) {

                              foreach ($result_spring_width_calculation as $spring_width_calculation_row) {

                                $film_width = $spring_width_calculation_row->slit_width + ($spring_width_calculation_row->distance_each_side * $spring_width_calculation_row->ups);

                                $qty_to_be_printed = $this->input->post('job_card_quantity') / $spring_width_calculation_row->ups;
                                $film_length = $qty_to_be_printed * ($length + 2.5);
                                //echo "<br/>";
                                $total_film_guagee = $total_film_guage / 1000;
                                //echo "<br/>";
                                $total_film_volume = $total_film_guagee * $film_length * $film_width;
                                $density = 0.00098;
                                //echo "<br/>";
                                $total_film_material = ($total_film_volume * $density) / 1000;
                              }
                            }
                          }
                        }

                        $t = 1;
                        for ($a = 1; $a <= $layer_no; $a++) {

                          $data['specification_film_details'] = $this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $film_specs->spec_id, 'specification_sheet_details.spec_version_no', $film_specs->spec_version_no, 'item_group_id', '3', 'layer_no', $a, 'parameter_name', 'GUAGE', 'srd_id', 'asc', 'layer_no', 'asc');

                          foreach ($data['specification_film_details'] as $specification_film_details_row) {
                            $gauge = rtrim($specification_film_details_row->parameter_value, " MIC");

                            $data['specification_film_details'] = $this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], 'specification_sheet_details.spec_id', $film_specs->spec_id, 'specification_sheet_details.spec_version_no', $film_specs->spec_version_no, 'item_group_id', '3', 'mat_article_no<>', '', 'layer_no', $a, 'srd_id', 'asc', 'layer_no', 'asc');

                            foreach ($data['specification_film_details'] as $specification_film_details_row) {

                              if (!empty($specification_film_details_row->mat_info) && !empty($specification_film_details_row->mat_article_no)) {

                                $density = '';

                                if ($a == '1' || $a == '3' || $a == '5' || $a == '7') {
                                  $density = 0.92;
                                } elseif ($a == '2' || $a == '6') {
                                  $density = 0.94;
                                } elseif ($a == '4') {
                                  $density = 1.19;
                                }

                                /*echo 'Layer='.$a;
                                echo "<br/>";
                                echo  'Length='.($length+2.5);
                                echo "<br/>";
                                echo 'FIlm Width='.$film_width;
                                echo "<br/>";
                                echo 'Gauge='.$gauge;
                                echo "<br/>";
                                echo 'Dencity='.$density;
                                echo "<br/>";
                                echo 'RM per sleeve= ';
                                */
                                $rm_per_sleeve = (($length + 2.5) * $film_width * $gauge * $density) / 1000000;
                                //echo "<br/>";
                                //echo 'RM per sleeve in kg= ';
                                $rm_per_sleeve_in_kg = $rm_per_sleeve / 1000;
                                //echo "<br/>";
                                //echo "Total Rm=";

                                $rm_total = ($rm_per_sleeve_in_kg * $qty_to_be_printed);
                                //echo "<br/>";
                                //echo "Total Rm perc%";

                                $rm_qty = $rm_total * ($specification_film_details_row->mat_info / 100);
                                //echo "<br/>";

                                $data['max_mm'] = $this->common_model->select_max_pkey_numeric('material_manufacturing', 'mm_id', $this->session->userdata['logged_in']['company_id']);
                                foreach ($data['max_mm'] as $max_mm_row) {
                                  $mm_id = $max_mm_row->mm_id + 1;
                                }


                                $data = array(
                                  'manu_order_no' => $jobcard_no,
                                  'article_no' => $specification_film_details_row->mat_article_no,
                                  'demand_qty' => $this->common_model->save_number($rm_qty, $this->session->userdata['logged_in']['company_id']),
                                  'company_id' => $this->session->userdata['logged_in']['company_id'],
                                  //'work_proc_no'=>'15',
                                  'work_proc_no' => '1',
                                  'from_job_card' => '1',
                                  'rel_demand_qty' => $this->common_model->save_number($rm_qty * 1000, $this->session->userdata['logged_in']['company_id']),
                                  'flag_uom_type' => '1',
                                  'mm_id' => $mm_id,
                                  'rel_uom_id' => 'UOM013',
                                  'part_pos_no' => $t,
                                  'layer_no' => $a
                                );
                                $this->common_model->save('material_manufacturing', $data);

                                $t++;
                              }
                            }
                          }
                        } //LAYER FOR

                      } //FOREACH FILMSPEC

                    } //LMNF

                  }
                } //BOM

                $data = array(
                  'final_approval_flag' => '1',
                  'order_no' => $this->input->post('order_no'),
                  'trans_closed' => '0',
                  'order_closed' => '0'
                );

                $data['order'] = $this->sales_order_book_model->active_details_records('order_master', $data, $this->session->userdata['logged_in']['company_id']);

                $dataa = array(
                  'order_no' => $this->input->post('order_no'),
                  'article_no' => $this->input->post('article_no')
                );

                $data['note'] = 'Create Transaction Completed';

                //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['order_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archives('order_details', $this->session->userdata['logged_in']['company_id'], $dataa);

                $data['customer'] = $this->customer_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'address_details.property_id', '1');

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '75');

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, 'sales_order_book');

                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/create-form', $data);
                $this->load->view('Home/footer');
              } // VALIDATION

            } else {
              $data['note'] = 'No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title', $data);
              $this->load->view('Home/footer');
            }
          } //FOREACH FORM RIGHTS
        }
      } //FOREACH MODULE

    } else {
      $data['note'] = 'No Create rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }
}
