<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales_quote extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_in')) {

      $this->load->model('common_model');
      $this->load->model('process_model');
      $this->load->model('fiscal_model');
      $this->load->model('article_model');
      $this->load->model('sales_quote_model');
      $this->load->model('stores_and_spares_consumption_model');
      $this->load->model('other_consumable_consumption_model');
      $this->load->model('packing_material_consumption_model');
      $this->load->model('customer_model');
      $this->load->model('sales_order_item_parameterwise_model');
      $this->load->model('sales_quote_followup_model');
    } else {
      redirect('login', 'refresh');
    }
  }

  function my_quotes()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {

              $table = 'sales_quote_master';
              include('pagination-user.php');

              $data['sales_quote_master'] = $this->sales_quote_model->select_active_user_records($config["per_page"], $this->uri->segment(3), $table, $this->session->userdata['logged_in']['company_id'], $this->session->userdata['logged_in']['user_id']);

              //echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
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

  function index()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {

              $table = 'sales_quote_master';
              include('pagination.php');

              $data['sales_quote_master'] = $this->sales_quote_model->select_active_records($config["per_page"], $this->uri->segment(3), $table, $this->session->userdata['logged_in']['company_id']);

              //echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
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


  function abc()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              //$this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/angular', $data);
              $this->load->view('Home/footer');
            }
          }
        }
      }
    }
  }

  function create()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

              $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

              //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


              $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
              $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
              $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
              $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
              $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
              $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
              $special_ink_data = array('ink_id' => '4', 'archive' => '0');
              $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

              $ink_data = array('ink_id' => '2', 'archive' => '0');
              $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
              $screen_data = array('ink_id' => '3', 'archive' => '0');
              $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
              $flexo_data = array('ink_id' => '1', 'archive' => '0');
              $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
              //echo $this->db->last_query();

              $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

              //----Shoulder
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

              $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

              $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

              $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' => '3');
              $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);

              $data_search = array('archive' => 0);
              $data['purchase_manager'] = $this->common_model->select_active_records_where('address_category_contact_details', $this->session->userdata['logged_in']['company_id'], $data_search);

              //echo $this->db->last_query();

              //$data['machine_type']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);       

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/create-form', $data);
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

  function save()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {

              //Information----------------------------

              $this->form_validation->set_rules('customer', 'Custommer ', 'required|trim|xss_clean|callback_customer_check');
              $this->form_validation->set_rules('pm_1', 'Purchase Manager 1', 'required|trim|xss_clean');
              $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim|xss_clean');
              $this->form_validation->set_rules('credit_days', 'Payment Terms', 'required|trim|xss_clean');
              $this->form_validation->set_rules('enquiry_date', 'Enquiry Date', 'required|trim|xss_clean');

              // Tube Specification-----------------------------              
              $this->form_validation->set_rules('sleeve_dia', 'Tube dia', 'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length', 'Tube length', 'required|trim|xss_clean');
              $this->form_validation->set_rules('layer', 'Layer', 'required|trim|xss_clean');


              $this->form_validation->set_rules('tube_color', 'Tube Color', 'required|xss_clean');
              $this->form_validation->set_rules('tube_lacquer', 'Tube lacquer', 'required|xss_clean');
              $this->form_validation->set_rules('print_type', 'Print Type', 'required|trim|xss_clean');
              $this->form_validation->set_rules('special_ink', 'Special ink', 'required|trim|xss_clean');

              // Shoulder Specification-----------------------------
              $this->form_validation->set_rules('shoulder', 'Shoulder', 'required|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice', 'Shoulder Oriface', 'xss_clean');
              $this->form_validation->set_rules('shoulder_color', 'Shoulder Color', 'required|xss_clean');

              // Cap Specification-----------------------------
              $this->form_validation->set_rules('cap_type', 'Cap type', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_finish', 'Cap Finish', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_dia', 'Cap Dia', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_orifice', 'Cap Orifice', 'xss_clean');
              $this->form_validation->set_rules('cap_color', 'Cap Color', 'xss_clean');

              // Decorative Elements -----------------------------
              $this->form_validation->set_rules('tube_foil', 'Tube foil', 'required|trim|xss_clean');
              //$this->form_validation->set_rules('shoulder_foil','Shoulder Foil' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_foil', 'Cap foil', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_metalization', 'Cap Metalization', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_shrink_sleeve', 'Cap shrink sleeve', 'required|trim|xss_clean');
              $this->form_validation->set_rules('label_price', 'Label Price', 'trim|xss_clean');

              // Quote-----------------------------------

              //$this->form_validation->set_rules('_5k_target_contr','5k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_quoted_contr', '5K Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_cost', '5K Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_quoted_price', '5k Quoted Price', 'required|trim|xss_clean');


              ///$this->form_validation->set_rules('_10k_target_contr','10k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_quoted_contr', '10k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_cost', '10k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_quoted_price', '10k Quoted Price', 'required|trim|xss_clean');

              // $this->form_validation->set_rules('_25k_target_contr','25k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_quoted_contr', '25k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_cost', '25k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_quoted_price', '25K Quoted Price', 'required|trim|xss_clean');

              //$this->form_validation->set_rules('_50k_target_contr','50k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_quoted_contr', '50k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_cost', '50k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_quoted_price', '50K Quoted Price', 'required|trim|xss_clean');

              // $this->form_validation->set_rules('_100k_target_contr','100k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_quoted_contr', '100k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_cost', '100k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_quoted_price', '100k Quoted Price', 'required|trim|xss_clean');

              $this->form_validation->set_rules('freight', 'Freight', 'required|trim|xss_clean');



              // Cost sheet details------------------------------
              if (!empty($this->input->post('article_no'))) {
                $this->form_validation->set_rules('article_no', 'Article no', 'trim|xss_clean|callback_article_check');
              } else {
                $this->form_validation->set_rules('article_no', 'Article no', 'trim|xss_clean');
              }

              //$this->form_validation->set_rules('invoice_date','Costsheet date' ,'trim|xss_clean');
              $this->form_validation->set_rules('invoice_no', 'Invoice no', 'trim|xss_clean');
              //$this->form_validation->set_rules('cost','Cost' ,'trim|xss_clean');  

              $this->form_validation->set_rules('remarks', 'Remarks', 'trim|xss_clean');




              //echo $this->input->post('cap_metalization');  

              if ($this->form_validation->run() == FALSE) {

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

                $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

                //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();

                $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


                $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
                $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
                $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
                $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
                $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
                $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
                $special_ink_data = array('ink_id' => '4', 'archive' => '0');
                $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

                $ink_data = array('ink_id' => '2', 'archive' => '0');
                $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
                $screen_data = array('ink_id' => '3', 'archive' => '0');
                $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
                $flexo_data = array('ink_id' => '1', 'archive' => '0');
                $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
                //echo $this->db->last_query();

                $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

                //----Shoulder
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

                $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

                $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

                $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

                $dataa = array('process_id' => '3');
                $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);

                $data_search = array('archive' => 0);
                $data['purchase_manager'] = $this->common_model->select_active_records_where('address_category_contact_details', $this->session->userdata['logged_in']['company_id'], $data_search);




                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/create-form', $data);
                $this->load->view('Home/footer');
              } else {

                // echo $this->input->post('cap_metalization');
                //echo "<br/>";
                // echo "hi";

                $sales_quotation_no = '';
                if (!empty($this->input->post('quotation_no'))) {
                  $sales_quotation_no = $this->input->post('quotation_no');
                } else {
                  $data['auto'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master', $this->session->userdata['logged_in']['company_id'], 'form_id', '91');
                  $no = "";
                  foreach ($data['auto'] as $auto_row) {

                    $data['account_periods'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master', $this->session->userdata['logged_in']['company_id'], 'finyear_close_opt', '0');
                    foreach ($data['account_periods'] as $account_periods_row) {
                      $start = date('y', strtotime($account_periods_row->fin_year_start));
                      $end = date('y', strtotime($account_periods_row->fin_year_end));
                    }
                    $no = str_pad($auto_row->curr_val, 4, "0", STR_PAD_LEFT);
                    $sales_quotation_no = $auto_row->textcode . $auto_row->seperator . $start . $auto_row->seperator . $end . $auto_row->seperator . $no;
                    $next_quotation_no = $auto_row->curr_val + 1;
                  }
                }

                //$data=array('curr_val'=>$next_sales_order_no);
                //$this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','91',$this->session->userdata['logged_in']['company_id']);


                $customer_no = '';

                if (!empty($this->input->post('customer'))) {

                  $arr = explode("//", $this->input->post('customer'));
                  if (count($arr) >= 2) {
                    $customer_no = $arr[1];
                  }
                }
                $article_no = '';
                if (!empty($this->input->post('article_no'))) {

                  $arr1 = explode("//", $this->input->post('article_no'));
                  if (count($arr1) >= 2) {
                    $article_no = $arr1[1];
                  }
                }

                if (!empty($this->input->post('sleeve_dia'))) {
                  $sleeve_dia_array = explode("//", $this->input->post('sleeve_dia'));
                  $sleeve_dia = $sleeve_dia_array[1];
                } else {
                  $sleeve_dia = "";
                }

                if (!empty($this->input->post('shoulder'))) {
                  $shoulder_array = explode("//", $this->input->post('shoulder'));
                  $shoulder = $shoulder_array[1];
                } else {
                  $shoulder = "";
                }

                if (!empty($this->input->post('shoulder_orifice'))) {
                  $shoulder_orifice_array = explode("//", $this->input->post('shoulder_orifice'));
                  $shoulder_orifice = $shoulder_orifice_array[1];
                } else {
                  $shoulder_orifice = "";
                }

                //-------CAP explode//
                if (!empty($this->input->post('cap_type'))) {
                  $cap_type_array = explode("//", $this->input->post('cap_type'));
                  $cap_type = $cap_type_array[1];
                } else {
                  $cap_type = "";
                }

                if (!empty($this->input->post('cap_finish'))) {
                  $cap_finish_array = explode("//", $this->input->post('cap_finish'));
                  $cap_finish = $cap_finish_array[1];
                } else {
                  $cap_finish = "";
                }

                if (!empty($this->input->post('cap_dia'))) {
                  $cap_dia_array = explode("//", $this->input->post('cap_dia'));
                  $cap_dia = $cap_dia_array[1];
                } else {
                  $cap_dia = "";
                }

                if (!empty($this->input->post('cap_orifice'))) {
                  $cap_orifice_array = explode("//", $this->input->post('cap_orifice'));
                  $cap_orifice = $cap_orifice_array[1];
                } else {
                  $cap_orifice = "";
                }

                if (!empty($this->input->post('tube_color'))) {
                  $tube_color_aray = explode("//", $this->input->post('tube_color'));
                  $tube_color = $tube_color_aray[0];
                } else {
                  $tube_color = "";
                }

                if (!empty($this->input->post('shoulder_color'))) {
                  $shoulder_color_array = explode("//", $this->input->post('shoulder_color'));
                  $shoulder_color = $shoulder_color_array[0];
                } else {
                  $shoulder_color = "";
                }

                if (!empty($this->input->post('cap_color'))) {
                  $cap_color_array = explode("//", $this->input->post('cap_color'));
                  $cap_color = $cap_color_array[0];
                } else {
                  $cap_color = "";
                }

                if ($this->input->post('cap_metalization') == 'YES') {
                  $cap_metalization = "YES";
                } else {
                  $cap_metalization = "NO";
                }

                if ($this->input->post('cap_foil') == 'YES') {
                  $cap_foil = "YES";
                } else {
                  $cap_foil = "NO";
                }

                $version_no = '';
                if (!empty($this->input->post('version_no'))) {
                  $version_no = $this->input->post('version_no');
                }

                $_5k_flag = ($this->input->post('_5k_flag') == '1' ? '1' : '0');
                $_10k_flag = ($this->input->post('_10k_flag') == '1' ? '1' : '0');
                $_25k_flag = ($this->input->post('_25k_flag') == '1' ? '1' : '0');
                $_50k_flag = ($this->input->post('_50k_flag') == '1' ? '1' : '0');
                $_100k_flag = ($this->input->post('_100k_flag') == '1' ? '1' : '0');
                $free_flag = ($this->input->post('free_flag') == '1' ? '1' : '0');

                // $data['version']=$this->sales_quote_model->select_quote_verion_no_copy_fun('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'quotation_no',$sales_quotation_no,'version_no',$version_no);
                //                   //echo $this->db->last_query();

                // foreach ($data['version'] as $version_row) {

                //             if($version_row->version_no==NULL){

                //               $this->input->post('version_no')=='';
                //               $version_no = 1;

                //             }else{
                //               $version_no=$version_row->version_no;

                //              }
                //          }

                // File Upload----------------------------------  

                $filename = $sales_quotation_no . "_" . time() . "_" . preg_replace('/[^A-Za-z0-9.-]/ ', '', $_FILES['userfile']['name']);
                $config['upload_path'] = './assets/' . $this->session->userdata['logged_in']['company_id'] . '/sales_quote_ref/';
                $config['encrypt_name '] = TRUE;
                $config['allowed_types'] = 'pdf|PDF';
                $config['max_size'] = '0';
                $config['remove_spaces'] = TRUE;
                $config['file_name'] = $filename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('userfile')) {
                  $data = $this->upload->data();
                  //$filename=time()."_".$data['file_name'];
                } else {
                  //$filename=$this->input->post('po_file');
                  $filename = '';
                  $data['error'] = $this->upload->display_errors();
                }


                $data = array(
                  'quotation_date' => date('Y-m-d'),
                  'quotation_no' => $sales_quotation_no,
                  'version_no' => $version_no,
                  'customer_no' => $customer_no,
                  'images' => $filename,
                  'pm_1' => $this->input->post('pm_1'),
                  'product_name' => $this->input->post('product_name'),
                  'credit_days' => $this->input->post('credit_days'),
                  'enquiry_date' => $this->input->post('enquiry_date'),

                  // specification
                  'layer' => $this->input->post('layer'),
                  'sleeve_dia' => $sleeve_dia,
                  'sleeve_length' => $this->input->post('sleeve_length'),
                  'tube_color' => $tube_color,
                  'tube_lacquer' => $this->input->post('tube_lacquer'),
                  'print_type' => $this->input->post('print_type'),
                  'special_ink' => $this->input->post('special_ink'),

                  'shoulder' => $shoulder,
                  'shoulder_orifice' => $shoulder_orifice,
                  'shoulder_color' => $shoulder_color,

                  'cap_type' => $cap_type,
                  'cap_finish' => $cap_finish,
                  'cap_dia' => $cap_dia,
                  'cap_orifice' => $cap_orifice,
                  'cap_color' => $cap_color,

                  'tube_foil' => $this->input->post('tube_foil'),
                  'shoulder_foil' => $this->input->post('shoulder_foil'),
                  'cap_foil' => $cap_foil,
                  'cap_foil_width' => $this->input->post('cap_foil_width'),
                  'cap_foil_dist_frm_bottom' => $this->input->post('cap_foil_dist_frm_bottom'),

                  'cap_metalization' => $cap_metalization,
                  'cap_metalization_color' => $this->input->post('cap_metalization_color'),
                  'cap_metalization_finish' => $this->input->post('cap_metalization_finish'),
                  'cap_shrink_sleeve' => $this->input->post('cap_shrink_sleeve'),


                  //Quote
                  'machine_print_type_id' => $this->input->post('machine_type'),
                  'job_changeover_time' => $this->input->post('job_changeover'),

                  '_5k_flag' => $_5k_flag,
                  '_5k_waste' => $this->input->post('_5k_waste'),
                  //'_5k_target_contr'=>$this->input->post('_5k_target_contr'),
                  '_5k_quoted_contr' => $this->input->post('_5k_quoted_contr'),
                  '_5k_cost' => $this->input->post('_5k_cost'),
                  '_5k_quoted_price' => $this->input->post('_5k_quoted_price'),

                  '_10k_flag' => $_10k_flag,
                  '_10k_waste' => $this->input->post('_10k_waste'),
                  //'_10k_target_contr'=>$this->input->post('_10k_target_contr'),
                  '_10k_quoted_contr' => $this->input->post('_10k_quoted_contr'),
                  '_10k_cost' => $this->input->post('_10k_cost'),
                  '_10k_quoted_price' => $this->input->post('_10k_quoted_price'),

                  '_25k_flag' => $_25k_flag,
                  '_25k_waste' => $this->input->post('_25k_waste'),
                  //'_25k_target_contr'=>$this->input->post('_25k_target_contr'),
                  '_25k_quoted_contr' => $this->input->post('_25k_quoted_contr'),
                  '_25k_cost' => $this->input->post('_25k_cost'),
                  '_25k_quoted_price' => $this->input->post('_25k_quoted_price'),

                  '_50k_flag' => $_50k_flag,
                  '_50k_waste' => $this->input->post('_50k_waste'),
                  //'_50k_target_contr'=>$this->input->post('_50k_target_contr'),
                  '_50k_quoted_contr' => $this->input->post('_50k_quoted_contr'),
                  '_50k_cost' => $this->input->post('_50k_cost'),
                  '_50k_quoted_price' => $this->input->post('_50k_quoted_price'),

                  '_100k_flag' => $_100k_flag,
                  '_100k_waste' => $this->input->post('_100k_waste'),
                  //'_100k_target_contr'=>$this->input->post('_100k_target_contr'),
                  '_100k_quoted_contr' => $this->input->post('_100k_quoted_contr'),
                  '_100k_cost' => $this->input->post('_100k_cost'),
                  '_100k_quoted_price' => $this->input->post('_100k_quoted_price'),

                  'free_flag' => $free_flag,
                  'free_quantity' => $this->input->post('free_quantity'),
                  '_free_quantity_waste' => $this->input->post('_free_quantity_waste'),
                  //'free_target_contr'=>$this->input->post('free_target_contr'),
                  'free_quoted_contr' => $this->input->post('free_quoted_contr'),
                  'free_cost' => $this->input->post('free_cost'),
                  'free_quoted_price' => $this->input->post('free_quoted_price'),

                  'freight' => $this->input->post('freight'),
                  //'packing'=>$this->input->post('packing'),

                  //Cost sheet details
                  //'article_no'=>$article_no,
                  //'invoice_date'=>$this->input->post('invoice_date'),
                  'invoice_no' => $this->input->post('invoice_no'),
                  //'cost'=>$this->input->post('cost'),
                  'remarks' => $this->input->post('remarks'),
                  'user_id' => $this->session->userdata['logged_in']['user_id'],
                  'company_id' => $this->session->userdata['logged_in']['company_id']
                );

                $result_sales_quote_master = $this->common_model->save('sales_quote_master', $data);
                //echo $this->db->last_query();
                if ($result_sales_quote_master) {

                  if (!empty($this->input->post('quotation_no'))) {
                    $sales_quotation_no = $this->input->post('quotation_no');
                  } else {
                    $data_1 = array('curr_val' => $next_quotation_no);
                    $result_autogeneration_format_master = $this->common_model->update_one_active_record('autogeneration_format_master', $data_1, 'form_id', '91', $this->session->userdata['logged_in']['company_id']);
                  }


                  $data_details = array(
                    'quotation_no' => $sales_quotation_no,
                    'sleeve_per_cost' => $this->input->post('sleeve_cost_view'),
                    'version_no' => $version_no,
                    'lacquer_1' => $this->input->post('lacquer_type_1'),
                    'lacquer1_rate' => $this->input->post('lacquer_type_1_rate'),
                    'lacquer1_gm_per_tube' => $this->input->post('lacquer_type_1_gm_per_tube'),
                    'lacquer1_perc' => $this->input->post('lacquer_type_1_percentage'),
                    'lacquer_2' => $this->input->post('lacquer_type_2'),
                    'lacquer2_rate' => $this->input->post('lacquer_type_2_rate'),
                    'lacquer2_gm_per_tube' => $this->input->post('lacquer_type_2_gm_per_tube'),
                    'lacquer2_perc' => $this->input->post('lacquer_type_2_percentage'),
                    'lacquer_rejection' => $this->input->post('lacquer_rejection'),
                    'lacquer_cost_per_tube' => $this->input->post('lacquer_cost_view'),
                    //----------print type------
                    'label_rejection' => $this->input->post('label_rejection'),
                    'label_rate' => $this->input->post('label_rate'),
                    'label_cost_per_tube' => $this->input->post('label_cost_view'),
                    'screen_rm_month' => $this->input->post('screen_rm_month'),
                    'screen_rate' => $this->input->post('screen_rate'),
                    'screen_gm_per_tube' => $this->input->post('screen_gm_per_tube'),
                    'screen_flexo_rejection' => $this->input->post('screen_flexo_rejection'),
                    'screen_percentage' => $this->input->post('screen_percentage'),
                    'flexo_rm_month' => $this->input->post('flexo_rm_month'),
                    'flexo_rate' => $this->input->post('flexo_rate'),
                    'flexo_gm_per_tube' => $this->input->post('flexo_gm_per_tube'),
                    'flexo_percentage' => $this->input->post('flexo_percentage'),
                    'screen_flexo_cost_per_tube' => $this->input->post('screen_flexo_cost_view'),

                    'spring_consumable_view' => $this->input->post('spring_consumable_view'),
                    'screen_flexo_consumable_view' => $this->input->post('screen_flexo_consumable_view'),
                    //----------screen flexo plate------
                    'screen_film_rate' => $this->input->post('screen_film_rate'),
                    'screen_colors' => $this->input->post('screen_colors'),
                    'screen_impresssion' => $this->input->post('screen_impresssion'),
                    'screen_sets' => $this->input->post('screen_sets'),
                    'screen_film_cost_per_tube' => $this->input->post('screen_plate_cost_view'),
                    'flexo_plate_rate' => $this->input->post('flexo_plate_rate'),
                    'flexo_colors' => $this->input->post('flexo_colors'),
                    'flexo_impresssion' => $this->input->post('flexo_impresssion'),
                    'flexo_sets' => $this->input->post('flexo_sets'),
                    'flexo_plate_cost_per_tube' => $this->input->post('flexo_plate_cost_view'),
                    //----------offset plate------
                    'offset_rm_month' => $this->input->post('offset_rm_month'),
                    'offset_rate' => $this->input->post('offset_rate'),
                    'offset_gm_per_tube' => $this->input->post('offset_gm_per_tube'),
                    'offset_rejection' => $this->input->post('offset_rejection'),
                    'offset_percentage' => $this->input->post('offset_percentage'),
                    'offset_cost_per_tube' => $this->input->post('offset_cost_view'),
                    'offset_consumable_view' => $this->input->post('offset_consumable_view'),

                    'offset_plate_cost' => $this->input->post('offset_plate_cost'),
                    'offset_color' => $this->input->post('offset_color'),
                    'offset_impresssion' => $this->input->post('offset_impresssion'),
                    'offset_sets' => $this->input->post('offset_sets'),
                    'offset_plate_cost_per_tube ' => $this->input->post('offset_plate_cost_view'),

                    //----------special ink------
                    'special_rm_month' => $this->input->post('special_rm_month'),
                    'special_ink_rate' => $this->input->post('special_ink_rate'),
                    'special_gm_per_tube' => $this->input->post('special_gm_per_tube'),
                    'special_percentage' => $this->input->post('special_percentage'),
                    'specialink_rejection' => $this->input->post('specialink_rejection'),
                    'special_ink_cost_per_tube' => $this->input->post('special_ink_cost_view'),
                    //----------shoulder------
                    'sh_hdpe_one' => $this->input->post('sh_hdpe_one'),
                    'sh_hdpe_one_rate' => $this->input->post('sh_hdpe_one_rate'),
                    'hdpe_m' => $this->input->post('hdpe_m'),
                    'sh_hdpe_two' => $this->input->post('sh_hdpe_two'),
                    'sh_hdpe_two_rate' => $this->input->post('sh_hdpe_two_rate'),
                    'hdpe_f' => $this->input->post('hdpe_f'),
                    'shoulder_mb' => $this->input->post('shoulder_mb'),
                    'shoulder_mb_rate' => $this->input->post('shoulder_mb_rate'),
                    'shoulder_mb_percentage' => $this->input->post('shoulder_mb_percentage'),
                    'shoulder_mb1' => $this->input->post('shoulder_mb1'),
                    'shoulder_mb1_rate' => $this->input->post('shoulder_mb1_rate'),
                    'shoulder_mb_percentage1' => $this->input->post('shoulder_mb_percentage1'),
                    'sh_rejection' => $this->input->post('sh_rejection'),
                    'sh_quantity' => $this->input->post('sh_quantity'),
                    'shoulder_cost' => $this->input->post('shoulder_cost_view'),
                    //----------cap------
                    'mould_type' => $this->input->post('mould_type'),
                    'cap_weight_rate' => $this->input->post('cap_weight_rate'),
                    'runner_waste' => $this->input->post('runner_waste'),
                    'pp_price' => $this->input->post('pp_price'),
                    'mb_price' => $this->input->post('mb_price'),
                    'mb_loading' => $this->input->post('mb_loading'),
                    'moulding_cost' => $this->input->post('moulding_cost'),
                    'cap_rejection' => $this->input->post('cap_rejection'),
                    'cap_cost_per_tube' => $this->input->post('cap_cost_view'),
                    //----------packing box--- 
                    'top_box' => $this->input->post('top_box'),
                    'bottom_box' => $this->input->post('bottom_box'),
                    'box_liners' => $this->input->post('box_liners'),
                    'liner_gm' => $this->input->post('liner_gm'),
                    'top_box_rate' => $this->input->post('top_box_rate'),
                    'bottom_box_rate' => $this->input->post('bottom_box_rate'),
                    'box_liners_rate' => $this->input->post('box_liners_rate'),
                    'total_box_rate' => $this->input->post('packing_box_view'),
                    'liner_gm_per_tube' => $this->input->post('liners_view'),
                    //-------------Tube foil--------
                    'hot_foil_1' => $this->input->post('hot_foil_1'),
                    'hot_foil_1_rate' => $this->input->post('hot_foil_1_rate'),
                    'hot_foil_1_percentage' => $this->input->post('hot_foil_1_percentage'),
                    'hot_foil_2' => $this->input->post('hot_foil_2'),
                    'hot_foil_2_rate' => $this->input->post('hot_foil_2_rate'),
                    'hot_foil_2_percentage' => $this->input->post('hot_foil_2_percentage'),
                    'tube_foil_rejection' => $this->input->post('tube_foil_rejection'),
                    'tube_foil_cost_per_tube' => $this->input->post('tube_foil_cost_view'),
                    //-------------Shoulder foil---------
                    'shoulder_foil_tag' => $this->input->post('shoulder_foil_tag'),
                    'shoulder_foil_rate' => $this->input->post('shoulder_foil_rate'),
                    'shoulder_foil_sqm_per_tube' => $this->input->post('shoulder_foil_sqm_per_tube'),
                    'shoulder_foil_cost_per_tube' => $this->input->post('shoulder_foil_cost_view'),
                    //-------------shrink Sleeve---------
                    'cap_shrink_sleeve_code' => $this->input->post('cap_shrink_sleeve_code'),
                    'cap_shrink_sleeve_rate' => $this->input->post('cap_shrink_sleeve_rate'),
                    'cap_shrink_sleeve_cost_per_tube' => $this->input->post('cap_shrink_sleeve_cost_view'),
                    'cap_metalization_rate' => $this->input->post('cap_metalization_rate'),
                    'cap_metalization_cost_view' => $this->input->post('cap_metalization_cost_view'),
                    'cap_foil_rate' => $this->input->post('cap_foil_rate'),
                    'cap_foil_cost_view' => $this->input->post('cap_foil_cost_view'),
                    //-----------Stores and Spares
                    'stores_spares_local_view' => $this->input->post('stores_spares_local_view'),
                    'stores_spares_import_view' => $this->input->post('stores_spares_import_view'),
                    'export_packing' => $this->input->post('customer_flag'),
                    'hygenic_consumable_view' => $this->input->post('hygenic_consumable_view'),
                    'packing_shrink_flim' => $this->input->post('packing_shrink_flim'),
                    'other_consumable_view' => $this->input->post('other_consumable_view'),
                    'packing_corrugated_sheet' => $this->input->post('packing_corrugated_sheet'),
                    'packing_bopp_tape' => $this->input->post('packing_bopp_tape'),
                    'packing_stickers' => $this->input->post('packing_stickers'),
                    'other_packing_material' => $this->input->post('other_packing_material'),
                    'total_rm_cost_per_tube' => $this->input->post('total_rm_cost_per_tube'),
                    'total_consummable_cost_per_tube' => $this->input->post('total_consummable_cost_per_tube'),
                    'total_packing_cost_per_tube' => $this->input->post('total_packing_cost_per_tube'),
                    'total_stores_cost_per_tube' => $this->input->post('total_stores_cost_per_tube'),
                    'total_cost_per_tube' => $this->input->post('total_cost_per_tube'),
                    'waste_total_cost_per_tube' => $this->input->post('waste_total_cost_per_tube'),
                    'company_id' => $this->session->userdata['logged_in']['company_id']

                  );

                  $result_sales_quote_details = $this->common_model->save('sales_quote_details', $data_details);


                  $version_details = array(
                    'quotation_no' => $sales_quotation_no,
                    'version_no' => $version_no,
                    'company_id' => $this->session->userdata['logged_in']['company_id']
                  );

                  $result_version_details = $this->common_model->save('sales_quote_revision', $version_details);
                }

                if ($this->input->post('layer') == 1) {

                  for ($i = 1; $i <= $this->input->post('layer_1_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $sales_quotation_no,
                      'version_no' => $version_no,
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('micron'),
                      'rm' => $this->input->post('layer_1_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_1_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_1_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_1_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer1_rejection'),
                      'quantity' => $this->input->post('quantity'),
                      'sleeve_per_cost' => $this->input->post('sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    $result_sales_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 2) {

                  for ($i = 1; $i <= $this->input->post('layer_2_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $sales_quotation_no,
                      'version_no' => $version_no,
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_2_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_2_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_2_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_2_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_2_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer2_rejection'),
                      'quantity' => $this->input->post('layer2_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer2_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    $result_sales_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 3) {

                  for ($i = 1; $i <= $this->input->post('layer_3_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $sales_quotation_no,
                      'version_no' => $version_no,
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_3_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_3_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_3_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_3_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_3_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer3_rejection'),
                      'quantity' => $this->input->post('layer3_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer3_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    $result_sales_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 5) {

                  for ($i = 1; $i <= $this->input->post('layer_5_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $sales_quotation_no,
                      'version_no' => $version_no,
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_5_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_5_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_5_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_5_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_5_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer5_rejection'),
                      'quantity' => $this->input->post('layer5_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer5_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    $result_sales_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 7) {

                  for ($i = 1; $i <= $this->input->post('layer_7_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $sales_quotation_no,
                      'version_no' => $version_no,
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_7_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_7_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_7_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_7_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_7_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer7_rejection'),
                      'quantity' => $this->input->post('layer7_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer7_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    $result_sales_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if (!empty($this->input->post('approval_authority'))) {

                  $data = array('pending_flag' => '1');
                  $result = $this->common_model->update_one_active_record_where('sales_quote_master', $data, 'quotation_no', $sales_quotation_no, 'version_no', $version_no, $this->session->userdata['logged_in']['company_id']);

                  $data['followup'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('followup', $this->session->userdata['logged_in']['company_id'], 'record_no', $sales_quotation_no . '@@@' . $version_no);
                  if ($data['followup'] == FALSE) {
                    $transaction_no = 1;
                    $status = 1;
                  } else {
                    $i = 1;
                    foreach ($data['followup'] as $followup_row) {
                      $transaction_no = $followup_row->transaction_no;
                      $status = 1;
                      $i++;
                    }
                    $transaction_no = $i;
                  }

                  $data = array(
                    'company_id' => $this->session->userdata['logged_in']['company_id'],
                    'user_id' => $this->input->post('approval_authority'),
                    'form_id' => '91',
                    'transaction_no' => $transaction_no,
                    'status' => $status,
                    'followup_date' => date('Y-m-d'),
                    'contact_person_id' => $this->session->userdata['logged_in']['user_id'],
                    'record_no' => $sales_quotation_no . '@@@' . $version_no,
                  );

                  $result = $this->common_model->save('followup', $data);
                }


                if ($result_sales_quote_master != '') {

                  $version_noo = $version_no;
                  if ($version_noo == '') {
                    $version_nooo = '';
                  } else {
                    $version_nooo = 'REV' . $version_noo;
                  }

                  $sales_quote_date         = date('Y-m-d');
                  $user_id = $this->session->userdata['logged_in']['user_id'];
                  $prepared_by              = $this->common_model->get_user_name($user_id, $this->session->userdata['logged_in']['company_id']);
                  $user_email = $this->common_model->get_user_email($user_id, $this->session->userdata['logged_in']['company_id']);

                  $apr_name = $this->input->post('approval_authority');
                  $apr_email = $this->common_model->get_user_email($apr_name, $this->session->userdata['logged_in']['company_id']);


                  $customer_result = $this->common_model->select_one_active_record('address_category_master', $this->session->userdata['logged_in']['company_id'], 'adr_category_id', $customer_no);
                  if ($customer_result == TRUE) {
                    foreach ($customer_result as $customer_row) {
                      $bill_to = $customer_row->category_name;
                    }
                  }

                  $customer_result = $this->common_model->select_one_active_record('address_category_details', $this->session->userdata['logged_in']['company_id'], 'adr_category_id', $customer_no);
                  if ($customer_result == TRUE) {
                    foreach ($customer_result as $customer_row) {
                      $address  = $customer_row->address;
                      $city     = $customer_row->city;
                      $statee   = $customer_row->state;
                      $countryy = $customer_row->country;
                    }
                  }
                  $state = $this->common_model->get_state_name($statee, $this->session->userdata['logged_in']['company_id']);

                  $country = $this->common_model->get_country_name($countryy, $this->session->userdata['logged_in']['company_id']);
                  //echo $this->db->last_query();

                  $sales_quote_customer_contact_details = $this->common_model->select_one_record_with_company('address_category_contact_details', $this->session->userdata['logged_in']['company_id'], 'address_category_contact_id', $this->input->post('pm_1'));
                  foreach ($sales_quote_customer_contact_details as $key => $sales_quote_customer_contact_details_row) {
                    $contact_name = $sales_quote_customer_contact_details_row->contact_name;
                    $company_email = $sales_quote_customer_contact_details_row->company_email;
                    $company_contact_no = $sales_quote_customer_contact_details_row->company_contact_no;
                  }

                  $credit_days = $this->input->post('credit_days');

                  $sleeve_dia_result = $this->common_model->select_one_active_record('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id'], 'sleeve_id', $sleeve_dia);
                  if ($sleeve_dia_result == TRUE) {
                    foreach ($sleeve_dia_result as $sleeve_dia_row) {
                      $sleeve_diaa = $sleeve_dia_row->sleeve_diameter;
                    }
                  }

                  $machine_id = $this->input->post('machine_type');
                  $machine_name = '';

                  if (!empty($machine_id)) {
                    $company_id = $this->session->userdata['logged_in']['company_id'];


                    $machine_type = $this->common_model->select_one_active_record('coex_machine_master', 'machine_id', $machine_id, 'null');

                    if ($machine_type != null) {

                      $selected_machine_type = $this->input->post('machine_print_type_id');


                      if ($selected_machine_type == $machine_id) {
                        $machine_name = $machine_type->machine_name;
                      }
                    }
                  }


                  $cap_type_          = $cap_type;
                  $special_ink_       = ($this->input->post('special_ink') == 'YES' ? 'YES' : '-');
                  $tube_layer_        = ($this->input->post('layer') == '1' ? 'MONO LAYER' : ($this->input->post('layer') == '7' ? 'SPRING' : ($this->input->post('layer') == '5' ? 'MULTI LAYER' : ($this->input->post('layer') == '2' ? '2 LAYER' : ($this->input->post('layer') == '3' ? '3 LAYER' : '-')))));
                  $cap_color_         = strtoupper($cap_color);
                  $shoulder_foil_     = ($this->input->post('shoulder_foil') == 'YES' ? 'YES' : '-');
                  $tube_color_        = strtoupper($tube_color);
                  $cap_finishes_      = $cap_finish;
                  $cap_foil_          = ($cap_foil == 'YES' ? 'YES' : '-');
                  $print_type_        = $this->input->post('print_type');
                  $cap_dia_           = strtoupper($cap_dia);
                  $cap_shrink_sleeve_ = ($this->input->post('cap_shrink_sleeve') == 'YES' ? 'YES' : '-');
                  $tube_lacquer_      = strtoupper($this->input->post('tube_lacquer'));
                  $cap_orifice_       = $cap_orifice;
                  $cap_metalization_  = ($cap_metalization == 'YES' ? 'YES' : '-');
                  $shoulder_          = $shoulder;
                  $tube_foil_         = ($this->input->post('tube_foil') == 'YES' ? 'YES' : '-');
                  $shoulder_orifice_  = $shoulder_orifice;
                  $shoulder_color_    = $shoulder_color;
                  $product= $this->input->post('product_name');




                  $filename = base_url('assets/img/logo.png');
                  $smtp_user = $this->config->item('smtp_user');
                  $smtp_pass = $this->config->item('smtp_pass');
                  $config['protocol'] = 'smtp';
                  $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                  $config['smtp_port'] = 465;
                  $config['smtp_timeout'] = 60;
                  $config['charset'] = 'utf-8';
                  $config['mailtype'] = 'html';
                  $config['validation'] = 'TRUE';
                  $config['smtp_user'] = 'auto.mailer@3d-neopac.com';
                  $config['smtp_pass'] = 'auto@2223';
                  $config['newline'] = "\r\n";
                  $this->load->library('email', $config);
                 // $this->email->from("auto.mailer@3d-neopac.com");
                 //$this->email->to("yatin.patel@3d-neopac.com");
                  // $this->email->cc($user_email);
                  //$this->email->bcc('ankit.shukla@3d-neopac.com');
                  $this->email->subject("Sales Quote  " . $sales_quotation_no . " Version " . $this->input->post('version_no') . " ");
                  $this->email->attach($filename);
                  $cid = $this->email->attachment_cid($filename);


                  $html = '<!DOCTYPE>
              <html>
               <head><title>Sales Order</title>
                <style>table {border:1px solid #ddd;border-collapse:collapse;font-size:10px;width:100%;color:black;font-family:verdana;}th {border:1px solid #ddd;text-align: left;background-color:#DFFCFC;font-weight:bold;font-size:10px;}td {border:1px solid #ddd;text-align: left;font-size:10px;}        .ui.teal.labels .label {background-color: #00b5ad!important;border-color: #00b5ad!important;color: #fff!important;}.invoice-box table {width: 100%;line-height: 12px;text-align: left;}.invoice-box table td {padding: 3px !important;}.invoice-box table tr td:nth-child(2) {text-align: center;}
                </style>
               </head>         
               <body>
               <div style="margin-top:5px;width:875px;margin:0px auto;background-color:#ddd;border:1px solid #ddd;font-family:verdana;">
               <div style="padding:3px;background-color: #ffffff">  
               <div style="margin-top:20px;>
               <table cellpadding="0" cellspacing="0" border="0">          
                <tbody>
                 <tr>
                <td class="title" width="5%">
                 <div style="text-align:center;"">
                  <img src="cid:' . $cid . '" style="max-width:130px;height:30px;"><br/>
                  <span style="font-size:10px;"><b>3D TECHNOPACK PVT LTD</b><br/>
                  SURVEY NO 8/1, VILLAGE ATHAL, SILVASSA, DADRA NAGAR HAVELI, PIN : 396230, INDIA</span>
                 </div>
                </td>
                 </tr>                      
                </tbody>
                </table>

                <div class="ui teal labels" style="text-align: center;">
                  <div class="ui label">SALES QUOTE</div>
                </div>

                 <table width="100%" cellpadding="3" cellspacing="0" style="margin-top: 10px;">
                  <tr class="heading">
                    <td width="15%" style="background-color:#dffcfc;"><b>QUOTE NO</td>
                    <td width="35%" style="background-color:#dffcfc;"><b>' . $sales_quotation_no . ' ' . $version_nooo . ' </b></td>
                    <td width="15%" style="background-color:#dffcfc;"><b>QUOTE DATE</b></td>
                    <td width="35%" style="background-color:#dffcfc;">' . $sales_quote_date . '</td>                        
                  </tr>
                  <tr class="item last">
                    <td width="15%"><b>PREPARED BY</b></td>
                    <td width="35%">' . $prepared_by . '</td>                        
                    <td width="15%"><b>QUOTE VALIDITY</b></td>
                    <td width="35%"><i>FOR 30 DAYS</i></td>
                  </tr>  
                  <tr class="heading">
                    <td colspan="4" width="100%" style="background-color:#dffcfc;">
                      <b>CUSTOMER DETAILS</b>
                    </td>             
                  </tr>
                  <tr class="item last">
                    <td width="15%"><b>Customer Name</b></td>
                    <td width="35%">' . $bill_to . '
                    </td>
                    <td width="15%"><b>Purchase Manager</b></td>
                    <td width="35%">' . $contact_name . '</td>
                  </tr>                
                <tr class="item last">
                <td width="15%"><b>CONTACT NO</b></td>
                <td width="35%">' . $company_contact_no . '</td>
                <td width="15%"><b>ADDRESS</b></td>
                <td width="35%">' . $company_email . '</td>
                </tr>
                
                <tr class="item last">
                <td width="15%"><b>PAYMENT TERM</b></td>
                <td width="35%">' . $credit_days . ' Days</td>
                <td width="15%"><b>Date of Enquiry</b></td>
                <td width="35%">' . $this->input->post('enquiry_date') . '</td>
                </tr>
               </table>
                  
               <table width="100%" cellpadding="3" cellspacing="0" style="margin-top: 10px;">
                <tr class="heading">
                  <td width="100%" colspan="7" style="background-color:#dffcfc !important;"><b>PRODUCT SPECIFICATION</td>
                </tr>

                <tr class="heading">
                  <td width="33%" colspan="2" style="background-color:#dffcfc;"><b>TUBE</td>
                   <td width="33%" colspan="2" style="background-color:#dffcfc;"><b>CAP</td>
                   <td width="34%" colspan="2" style="background-color:#dffcfc;"><b>DECORATIVE ELEMENTS</td>   
                </tr>

                <tr class="item">
                  <td width="15%"><b>TUBE DIA X LENGTH</b></td>
                  <td width="18%"style="border-right:1px solid #D9d9d9;">' . $sleeve_diaa . ' X ' . $this->input->post('sleeve_length') . 'MM</td>
                  <td width="15%"><b>CAP TYPE</b></td>
                  <td width="18%" style="border-right:1px solid #D9d9d9;">' . $cap_type_ . '</td>
                  <td width="15%" ><b>SPECIAL INK</b></td>
                  <td width="19%" >' . $special_ink_ . '</td>
                </tr>

                <tr class="item">
                  <td width="15%"><b>TUBE LAYER</b></td>
                  <td width="18%"style="border-right:1px solid #D9d9d9;">' . $tube_layer_ . '</td>
                  <td width="15%"><b>CAP COLOR</b></td>
                  <td width="18%"style="border-right:1px solid #D9d9d9;">' . $cap_color_ . '</td>
                  <td width="15%"><b>SHOULDER FOIL</b></td>
                  <td width="19%">' . $shoulder_foil_ . '</td>
                </tr>

                <tr class="item">
                  <td width="15%"><b>TUBE COLOR</b></td>
                  <td width="18%"style="border-right:1px solid #D9d9d9;">' . $tube_color_ . '</td>
                  <td width="15%"><b>CAP FINISH</b></td>
                  <td width="18%"style="border-right:1px solid #D9d9d9;">' . $cap_finishes_ . '</td>
                  <td width="15%"><b>CAP FOIL</b></td>
                  <td width="19%">' . $cap_foil_ . '</td>
                </tr>

                <tr class="item">
                  <td width="15%"><b>TUBE PRINT TYPE</b></td>
                  <td width="18%" style="border-right:1px solid #D9d9d9;">' . $this->input->post('print_type') . '</td>
                  <td width="15%"><b>CAP DIA</b></td>
                  <td width="18%"style="border-right:1px solid #D9d9d9;">' . $cap_dia_ . '</td>
                  <td width="15%"><b>CAP SHRINK SLEEVE</b></td>
                  <td width="19%">' . $cap_shrink_sleeve_ . '</td>
                </tr>

                <tr class="item">
                  <td width="15%"><b>TUBE LACQUER </b></td>
                  <td width="18%" style="border-right:1px solid #D9d9d9;">' . $tube_lacquer_ . '</td>
                  <td width="15%"><b>CAP ORIFICE</b></td>
                  <td width="18%" style="border-right:1px solid #D9d9d9;">' . $cap_orifice_ . '</td>
                  <td width="15%"><b>CAP METALIZATION</b></td>
                  <td width="19%">' . $cap_metalization_ . '</td>
                  
                </tr>

                <tr class="item">
                  <td width="15%"><b>SHOULDER </b></td>
                  <td width="18%" style="border-right:1px solid #D9d9d9;">' . $shoulder_ . '</td>
                  <td width="15%"><b></b></td>
                  <td width="18%" style="border-right:1px solid #D9d9d9;"></td>
                  <td width="15%"><b>TUBE FOIL</b></td>
                  <td width="19%">' . $tube_foil_ . '</td>
                </tr>

                <tr class="item">
                  <td width="15%"><b>SHOULDER ORIFACE </b></td>
                  <td width="18%" style="border-right:1px solid #D9d9d9;">' . $shoulder_orifice_ . '</td>
                  <td width="15%"><b></b></td>
                  <td width="18%" style="border-right:1px solid #D9d9d9;"> </td>
                  <td width="15%"><b></b></td>
                  <td width="19%"></td>
                </tr>

                <tr class="item last">
                  <td width="15%"><b>SHOULDER COLOR </b></td>
                  <td width="18%" style="border-right:1px solid #D9d9d9;">' . $shoulder_color_ . '</td>
                  <td width="15%"><b></b></td>
                  <td width="18%">  </td>
                  <td width="15%"></td>
                  <td width="19%"><?php  ?></td>
                </tr>
                </table>
          
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
            <td width="5%"><b>SR NO</td>
            <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
            <td width="45%" style="border-right:1px solid #D9d9d9;">PRODUCT NAME</td>
            <td width="12%" style="border-right:1px solid #D9d9d9; text-align: right;">QUANTITY</td>
            <td width="12%" style="border-right:1px solid #D9d9d9; text-align: right;">UNIT PRICE</td>
            <td width="20%" style="text-align: right;">NET AMOUNT</td>

        </tr>';
        // $data['company'] = $this->common_model->select_one_active_record('company_master', $this->session->userdata['logged_in']['company_id'], 'company_id', $this->session->userdata['logged_in']['company_id']);

        //       $data['company_details'] = $this->common_model->select_one_active_record('company_system_parameters', $this->session->userdata['logged_in']['company_id'], 'company_id', $this->session->userdata['logged_in']['company_id']);


        //       // $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'sales_quote_master.quotation_no',$quotation_no);
         $data['sales_quote_master ']= $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->uri->segment(3), 'sales_quote_revision.version_no', $this->uri->segment(4));
            echo "<pre>";print_r($data['sales_quote_master ']);die;
// foreach ( $data['sales_quote_master '] as $sales_quote_master_row): {
      
        $i = 1;
        $total_quantity = 0;
        $total_net_value = 0;
        $total_amount = 0;
        if ($data['sales_quote_master ']->_5k_flag == 1) {
            $html.= '<tr class="item">
                <td>' . $i . '</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">' . strtoupper($product) . '</td>
                <td style="border-right:1px solid #D9d9d9; text-align: right;">5,000</td>                               
                <td style="border-right:1px solid #D9d9d9; text-align: right;">&#8377;' . ($sales_quote_master_row->_5k_rev_price <> 0 ? number_format($sales_quote_master_row->_5k_rev_price, 2, '.', '') : '') . '</td>
                <td style="text-align: right;">' . money_format('%.0n', (5000 * $sales_quote_master_row->_5k_rev_price)) . '/-</td>    
            </tr>';
            $total_quantity += 5000;
            $total_net_value += (5000 * $sales_quote_master_row->_5k_rev_price);
            $i++;
        }
        if ($result_sales_quote_master->_10k_flag == 1) {
            $html.= '<tr class="item">
                <td>' . $i . '</td>
                <td style="border-right:1px solid #D9d9d9;"></td>               
                <td style="border-right:1px solid #D9d9d9;">' . strtoupperstrtoupper($product) . '</td>
                <td style="border-right:1px solid #D9d9d9;text-align: right;">10,000</td>              
                <td style="border-right:1px solid #D9d9d9;text-align: right;">&#8377;' . ($sales_quote_master_row->_10k_rev_price <> 0 ? number_format($sales_quote_master_row->_10k_rev_price, 2, '.', '') : '') . '</td>
                <td style="text-align: right;">' . money_format('%.0n', (10000 * $sales_quote_master_row->_10k_rev_price)) . '/-</td>
            </tr>';
            $total_quantity += 10000;
            $total_net_value += (10000 * $sales_quote_master_row->_10k_rev_price);

            $i++;
        }

        if ($sales_quotation_no->_25k_flag == 1) {

            $html.= '<tr class="item">
                <td>' . $i . '</td>
                <td style="border-right:1px solid #D9d9d9;"></td>  
                <td style="border-right:1px solid #D9d9d9;">' . strtoupper($sales_quote_master_row->product_name) . '</td>             
                <td style="border-right:1px solid #D9d9d9;text-align: right;">25,000</td>
                <td style="border-right:1px solid #D9d9d9;text-align: right;">&#8377;' . ($sales_quote_master_row->_25k_rev_price <> 0 ? number_format($sales_quote_master_row->_25k_rev_price, 2, '.', '') : '') . '</td>                
                <td style="text-align: right;">' . money_format('%.0n', (25000 * $sales_quote_master_row->_25k_rev_price)) . '/-</td>
            </tr>';
            $total_quantity += 25000;
            $total_net_value += (25000 * $sales_quote_master_row->_25k_rev_price);
            $i++;
        }

         if ($sales_quotation_no->_50k_flag == 1) {
          $html.= '<tr class="item">
                <td>' . $i . '</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">' . strtoupper($sales_quote_master_row->product_name) . '</td>
                <td style="border-right:1px solid #D9d9d9;text-align: right;">50,000</td>
                <td style="border-right:1px solid #D9d9d9;text-align: right;">&#8377;' . ($sales_quote_master_row->_50k_rev_price <> 0 ? number_format($sales_quote_master_row->_50k_rev_price, 2, '.', '') : '') . '</td>                
                <td style="text-align: right;">' . money_format('%.0n', (50000 * $sales_quote_master_row->_50k_rev_price)) . '/-</td>
            </tr>';
            $total_quantity += 50000;
            $total_net_value += (50000 * $sales_quote_master_row->_50k_rev_price);
            $i++;
        }

         if ($sales_quotation_no->_100k_flag == 1) {
            $html.= '<tr class="item">
                <td>' . $i . '</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">' . strtoupper($sales_quote_master_row->product_name) . '</td>                
                <td style="border-right:1px solid #D9d9d9;text-align: right;">1,00,000</td>
                <td style="border-right:1px solid #D9d9d9;text-align: right;">&#8377;' . ($sales_quote_master_row->_100k_rev_price <> 0 ? number_format($sales_quote_master_row->_100k_rev_price, 2, '.', '') : '') . '</td>                
                <td style="border-right:1px solid #D9d9d9;text-align: right;">' . money_format('%.0n', (100000 * $sales_quote_master_row->_100k_rev_price)) . '/-</td>
            </tr>';
            $total_quantity += 100000;
            $total_net_value += (100000 * $sales_quote_master_row->_100k_rev_price);
            $i++;
        }

         if ($sales_quotation_no->free_flag == 1) {
            $html.= '<tr class="item">
                <td>' . $i . '</td>
                <td style="border-right:1px solid #D9d9d9;"></td> 
                <td style="border-right:1px solid #D9d9d9;">' . strtoupper($sales_quote_master_row->product_name) . '</td>               
                <td style="border-right:1px solid #D9d9d9;text-align: right;">' . money_format('%!.0n', $sales_quote_master_row->free_quantity) . '</td>
               <td style="border-right:1px solid #D9d9d9;text-align: right;">&#8377;' . ($sales_quote_master_row->_free_rev_price <> 0 ? number_format($sales_quote_master_row->_free_rev_price, 2, '.', '') : '') . '</td> 
                <td style="text-align: right;">' . money_format('%.0n', ($sales_quote_master_row->free_quantity * $sales_quote_master_row->_free_rev_price)) . '/-</td>
            </tr>';
            $total_quantity += $sales_quote_master_row->free_quantity;
            $total_net_value += ($sales_quote_master_row->free_quantity * $sales_quote_master_row->_free_rev_price);
            $i++;
        }

        $freight_1= ($sales_quotation_no->freight == 0) ? 'NA' : 'ADDED IN UNIT RATE';

        $html.='<tr class="item">
            <td></td>
            <td style="border-right:1px solid #D9d9d9;"></td>
            <td><b>FREIGHT - '.$freight_1.'</b></td>

            <td> </td>
            <td></td>
            <td></td>
        </tr>';
        $total_quantity_1= money_format('%!.0n', $total_quantity);
        $total_net_value_1=money_format('%.0n', $total_net_value);
        $total_net_value_2=money_format('%.0n', ($total_net_value / 100) * 18);
        $gross_amount=money_format('%.0n', ($total_net_value + (($total_net_value / 100) * 18)));

        $html.='<tr class="item">
            <td colspan="3" style="border-right:1px solid #D9d9d9;text-align: right;"><b>TOTAL</b></td>
            <td style="border-right:1px solid #D9d9d9;"><b>'.$total_quantity_1.'</b></td>
            <td style="border-right:1px solid #D9d9d9;text-align: right;"><b>NET AMOUNT</b></td>
            <td style="text-align: right;"><b>'.$total_net_value_1.'/-</b></td>
        </tr>
        <tr class="item">
            <td colspan="5" style="border-right:1px solid #D9d9d9;text-align: right;"><b>GST 18%</b></td>
            <td style="text-align: right;"><b>'.$total_net_value_2.'/-</b></td>
        </tr>
        <tr class="item last">
            <td colspan="5" style="border-right:1px solid #D9d9d9;text-align: right;"><b>GROSS AMOUNT</b></td>
            <td style="text-align: right;"><b>'.$gross_amount.'/-</b></td>
        </tr>
    </table>';
    //    }
    //  endforeach;   
            $html.='<table width="100%" cellpadding="5" cellspacing="0">
              <tr class="heading">
                  <div class="printbtn">
                    <br/>
                    <br/>
                    <button style="background-color: green border: none;
                    color: white;
                    padding: 15px 32px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px; ; color: white;" class="ui mini green button" id="approval">Procced</button>
                  </div>
                </td>
              </tr>
            </table>
               </div>
              </div>
            </div>
            </body>
          </html>';


                  $this->email->message($html);


                  $this->email->set_mailtype("html");



                  if ($this->email->send()) {
                    $data['note'] = 'File Uploaded Succesfully!';
                  } else {
                    $data['error'] = 'Email send failed!';
                  }
                }




                if ($result_sales_quote_master) {
                  $data['note'] = 'Data saved Successfully';
                } else {
                  $data['error'] = 'Error while saving data';
                }


                //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

                $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

                //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();

                $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


                $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
                $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
                $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
                $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
                $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
                $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
                $special_ink_data = array('ink_id' => '4', 'archive' => '0');
                $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

                $ink_data = array('ink_id' => '2', 'archive' => '0');
                $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
                $screen_data = array('ink_id' => '3', 'archive' => '0');
                $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
                $flexo_data = array('ink_id' => '1', 'archive' => '0');
                $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
                //echo $this->db->last_query();

                $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

                //----Shoulder
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

                $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

                $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

                $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

                $dataa = array('process_id' => '3');
                $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);


                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/create-form', $data);
                $this->load->view('Home/footer');
              }
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

  function price_revision_save()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {

              //Information----------------------------

              $this->form_validation->set_rules('customer', 'Custommer ', 'required|trim|xss_clean|callback_customer_check');
              $this->form_validation->set_rules('pm_1', 'Purchase Manager 1', 'required|trim|xss_clean');
              $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim|xss_clean');
              $this->form_validation->set_rules('credit_days', 'Payment Terms', 'required|trim|xss_clean');
              $this->form_validation->set_rules('enquiry_date', 'Enquiry Date', 'required|trim|xss_clean');

              // Tube Specification-----------------------------              
              $this->form_validation->set_rules('sleeve_dia', 'Tube dia', 'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length', 'Tube length', 'required|trim|xss_clean');
              $this->form_validation->set_rules('layer', 'Layer', 'required|trim|xss_clean');


              $this->form_validation->set_rules('tube_color', 'Tube Color', 'required|xss_clean');
              $this->form_validation->set_rules('tube_lacquer', 'Tube lacquer', 'required|xss_clean');
              $this->form_validation->set_rules('print_type', 'Print Type', 'required|trim|xss_clean');
              $this->form_validation->set_rules('special_ink', 'Special ink', 'required|trim|xss_clean');

              // Shoulder Specification-----------------------------
              $this->form_validation->set_rules('shoulder', 'Shoulder', 'required|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice', 'Shoulder Oriface', 'xss_clean');
              $this->form_validation->set_rules('shoulder_color', 'Shoulder Color', 'required|xss_clean');

              // Cap Specification-----------------------------
              $this->form_validation->set_rules('cap_type', 'Cap type', 'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_finish', 'Cap Finish', 'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_dia', 'Cap Dia', 'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_orifice', 'Cap Orifice', 'xss_clean');
              $this->form_validation->set_rules('cap_color', 'Cap Color', 'required|xss_clean');

              // Decorative Elements -----------------------------
              $this->form_validation->set_rules('tube_foil', 'Tube foil', 'required|trim|xss_clean');
              //$this->form_validation->set_rules('shoulder_foil','Shoulder Foil' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_foil', 'Cap foil', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_metalization', 'Cap Metalization', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_shrink_sleeve', 'Cap shrink sleeve', 'required|trim|xss_clean');
              $this->form_validation->set_rules('label_price', 'Label Price', 'trim|xss_clean');

              // Quote-----------------------------------

              //$this->form_validation->set_rules('_5k_target_contr','5k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_quoted_contr', '5K Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_cost', '5K Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_quoted_price', '5k Quoted Price', 'required|trim|xss_clean');


              ///$this->form_validation->set_rules('_10k_target_contr','10k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_quoted_contr', '10k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_cost', '10k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_quoted_price', '10k Quoted Price', 'required|trim|xss_clean');

              // $this->form_validation->set_rules('_25k_target_contr','25k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_quoted_contr', '25k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_cost', '25k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_quoted_price', '25K Quoted Price', 'required|trim|xss_clean');

              //$this->form_validation->set_rules('_50k_target_contr','50k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_quoted_contr', '50k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_cost', '50k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_quoted_price', '50K Quoted Price', 'required|trim|xss_clean');

              // $this->form_validation->set_rules('_100k_target_contr','100k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_quoted_contr', '100k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_cost', '100k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_quoted_price', '100k Quoted Price', 'required|trim|xss_clean');

              $this->form_validation->set_rules('freight', 'Freight', 'required|trim|xss_clean');

              $_5k_approved_contr = $this->input->post('_5k_approved_contr');
              $_10k_approved_contr = $this->input->post('_10k_approved_contr');
              $_25k_approved_contr = $this->input->post('_25k_approved_contr');
              $_50k_approved_contr = $this->input->post('_50k_approved_contr');
              $_100k_approved_contr = $this->input->post('_100k_approved_contr');
              $_free_approved_contr = $this->input->post('_free_approved_contr');

              $this->form_validation->set_rules('_5k_r1_price', '5k rev price', 'trim|xss_clean|greater_than_equal_to[' . $_5k_approved_contr . ']');

              $this->form_validation->set_rules('_10k_r1_price', '10K rev price', 'trim|xss_clean|greater_than_equal_to[' . $_10k_approved_contr . ']');
              $this->form_validation->set_rules('_25k_r1_price', '25K rev price', 'trim|xss_clean|greater_than_equal_to[' . $_25k_approved_contr . ']');
              $this->form_validation->set_rules('_50k_r1_price', '50k rev Price', 'trim|xss_clean|greater_than_equal_to[' . $_50k_approved_contr . ']');
              $this->form_validation->set_rules('_100k_r1_price', '100k rev Price', 'trim|xss_clean|greater_than_equal_to[' . $_100k_approved_contr . ']');
              $this->form_validation->set_rules('_free_r1_price', 'free rev Price', 'trim|xss_clean|greater_than_equal_to[' . $_free_approved_contr . ']');


              // Cost sheet details------------------------------
              if (!empty($this->input->post('article_no'))) {
                $this->form_validation->set_rules('article_no', 'Article no', 'trim|xss_clean|callback_article_check');
              } else {
                $this->form_validation->set_rules('article_no', 'Article no', 'trim|xss_clean');
              }

              //$this->form_validation->set_rules('invoice_date','Costsheet date' ,'trim|xss_clean');
              $this->form_validation->set_rules('invoice_no', 'Invoice no', 'trim|xss_clean');
              //$this->form_validation->set_rules('cost','Cost' ,'trim|xss_clean');  

              $this->form_validation->set_rules('remarks', 'Remarks', 'trim|xss_clean');




              //echo $this->input->post('cap_metalization');  

              if ($this->form_validation->run() == FALSE) {

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

                $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

                //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();

                $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


                $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
                $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
                $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
                $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
                $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
                $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
                $special_ink_data = array('ink_id' => '4', 'archive' => '0');
                $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

                $ink_data = array('ink_id' => '2', 'archive' => '0');
                $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
                $screen_data = array('ink_id' => '3', 'archive' => '0');
                $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
                $flexo_data = array('ink_id' => '1', 'archive' => '0');
                $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
                //echo $this->db->last_query();

                $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

                //----Shoulder
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

                $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

                $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

                $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

                $dataa = array('process_id' => '3');
                $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);

                $data_search = array('archive' => 0);
                $data['purchase_manager'] = $this->common_model->select_active_records_where('address_category_contact_details', $this->session->userdata['logged_in']['company_id'], $data_search);

                $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->input->post('quotation_no'), 'sales_quote_revision.version_no', $this->input->post('transaction_no'));

                //echo $this->db->last_query();



                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/price-rev-save-form', $data);
                $this->load->view('Home/footer');
              } else {

                // echo $this->input->post('cap_metalization');
                //echo "<br/>";
                // echo "hi";

                $sales_quotation_no = '';
                if (!empty($this->input->post('quotation_no'))) {
                  $sales_quotation_no = $this->input->post('quotation_no');
                } else {
                  $data['auto'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master', $this->session->userdata['logged_in']['company_id'], 'form_id', '91');
                  $no = "";
                  foreach ($data['auto'] as $auto_row) {

                    $data['account_periods'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master', $this->session->userdata['logged_in']['company_id'], 'finyear_close_opt', '0');
                    foreach ($data['account_periods'] as $account_periods_row) {
                      $start = date('y', strtotime($account_periods_row->fin_year_start));
                      $end = date('y', strtotime($account_periods_row->fin_year_end));
                    }
                    $no = str_pad($auto_row->curr_val, 4, "0", STR_PAD_LEFT);
                    $sales_quotation_no = $auto_row->textcode . $auto_row->seperator . $start . $auto_row->seperator . $end . $auto_row->seperator . $no;
                    $next_quotation_no = $auto_row->curr_val + 1;
                  }
                }

                //$data=array('curr_val'=>$next_sales_order_no);
                //$this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','91',$this->session->userdata['logged_in']['company_id']);


                $customer_no = '';

                if (!empty($this->input->post('customer'))) {

                  $arr = explode("//", $this->input->post('customer'));
                  if (count($arr) >= 2) {
                    $customer_no = $arr[1];
                  }
                }
                $article_no = '';
                if (!empty($this->input->post('article_no'))) {

                  $arr1 = explode("//", $this->input->post('article_no'));
                  if (count($arr1) >= 2) {
                    $article_no = $arr1[1];
                  }
                }

                if (!empty($this->input->post('sleeve_dia'))) {
                  $sleeve_dia_array = explode("//", $this->input->post('sleeve_dia'));
                  $sleeve_dia = $sleeve_dia_array[1];
                } else {
                  $sleeve_dia = "";
                }

                if (!empty($this->input->post('shoulder'))) {
                  $shoulder_array = explode("//", $this->input->post('shoulder'));
                  $shoulder = $shoulder_array[1];
                } else {
                  $shoulder = "";
                }

                if (!empty($this->input->post('shoulder_orifice'))) {
                  $shoulder_orifice_array = explode("//", $this->input->post('shoulder_orifice'));
                  $shoulder_orifice = $shoulder_orifice_array[1];
                } else {
                  $shoulder_orifice = "";
                }

                //-------CAP explode//
                if (!empty($this->input->post('cap_type'))) {
                  $cap_type_array = explode("//", $this->input->post('cap_type'));
                  $cap_type = $cap_type_array[1];
                } else {
                  $cap_type = "";
                }

                if (!empty($this->input->post('cap_finish'))) {
                  $cap_finish_array = explode("//", $this->input->post('cap_finish'));
                  $cap_finish = $cap_finish_array[1];
                } else {
                  $cap_finish = "";
                }

                if (!empty($this->input->post('cap_dia'))) {
                  $cap_dia_array = explode("//", $this->input->post('cap_dia'));
                  $cap_dia = $cap_dia_array[1];
                } else {
                  $cap_dia = "";
                }

                if (!empty($this->input->post('cap_orifice'))) {
                  $cap_orifice_array = explode("//", $this->input->post('cap_orifice'));
                  $cap_orifice = $cap_orifice_array[1];
                } else {
                  $cap_orifice = "";
                }

                if (!empty($this->input->post('tube_color'))) {
                  $tube_color_aray = explode("//", $this->input->post('tube_color'));
                  $tube_color = $tube_color_aray[0];
                } else {
                  $tube_color = "";
                }

                if (!empty($this->input->post('shoulder_color'))) {
                  $shoulder_color_array = explode("//", $this->input->post('shoulder_color'));
                  $shoulder_color = $shoulder_color_array[0];
                } else {
                  $shoulder_color = "";
                }

                if (!empty($this->input->post('cap_color'))) {
                  $cap_color_array = explode("//", $this->input->post('cap_color'));
                  $cap_color = $cap_color_array[0];
                } else {
                  $cap_color = "";
                }

                if ($this->input->post('cap_metalization') == 'YES') {
                  $cap_metalization = "YES";
                } else {
                  $cap_metalization = "NO";
                }

                if ($this->input->post('cap_foil') == 'YES') {
                  $cap_foil = "YES";
                } else {
                  $cap_foil = "NO";
                }

                // $version_no='';
                // if(!empty($this->input->post('version_no'))){
                //   $version_no=$this->input->post('version_no');
                // }

                $_5k_flag = ($this->input->post('_5k_flag') == '1' ? '1' : '0');
                $_10k_flag = ($this->input->post('_10k_flag') == '1' ? '1' : '0');
                $_25k_flag = ($this->input->post('_25k_flag') == '1' ? '1' : '0');
                $_50k_flag = ($this->input->post('_50k_flag') == '1' ? '1' : '0');
                $_100k_flag = ($this->input->post('_100k_flag') == '1' ? '1' : '0');
                $free_flag = ($this->input->post('free_flag') == '1' ? '1' : '0');

                // $data['version']=$this->sales_quote_model->select_quote_verion_no_pts('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'quotation_no',$sales_quotation_no,'version_no',$version_no);
                // //echo $this->db->last_query();

                // foreach ($data['version'] as $version_row) {

                //             if($version_row->version_no==NULL){

                //               $this->input->post('quotation_no')=='';
                //               $version_no = 1;

                //             }else{
                //               $version_no=$version_row->version_no;

                //              }
                //          }



                $data = array(
                  'quotation_date' => date('Y-m-d'),
                  'quotation_no' => $sales_quotation_no,
                  'version_no' => $this->input->post('version_no'),
                  'customer_no' => $customer_no,

                  'pm_1' => $this->input->post('pm_1'),
                  'product_name' => $this->input->post('product_name'),
                  'credit_days' => $this->input->post('credit_days'),
                  'enquiry_date' => $this->input->post('enquiry_date'),

                  // specification
                  'layer' => $this->input->post('layer'),
                  'sleeve_dia' => $sleeve_dia,
                  'sleeve_length' => $this->input->post('sleeve_length'),
                  'tube_color' => $tube_color,
                  'tube_lacquer' => $this->input->post('tube_lacquer'),
                  'print_type' => $this->input->post('print_type'),
                  'special_ink' => $this->input->post('special_ink'),

                  'shoulder' => $shoulder,
                  'shoulder_orifice' => $shoulder_orifice,
                  'shoulder_color' => $shoulder_color,

                  'cap_type' => $cap_type,
                  'cap_finish' => $cap_finish,
                  'cap_dia' => $cap_dia,
                  'cap_orifice' => $cap_orifice,
                  'cap_color' => $cap_color,

                  'tube_foil' => $this->input->post('tube_foil'),
                  'shoulder_foil' => $this->input->post('shoulder_foil'),
                  'cap_foil' => $cap_foil,
                  'cap_foil_width' => $this->input->post('cap_foil_width'),
                  'cap_foil_dist_frm_bottom' => $this->input->post('cap_foil_dist_frm_bottom'),

                  'cap_metalization' => $cap_metalization,
                  'cap_metalization_color' => $this->input->post('cap_metalization_color'),
                  'cap_metalization_finish' => $this->input->post('cap_metalization_finish'),
                  'cap_shrink_sleeve' => $this->input->post('cap_shrink_sleeve'),

                  //HOD price
                  '_5k_approval_authority_contr' => $this->input->post('_5k_approved_contr'),
                  '_10k_approval_authority_contr' => $this->input->post('_10k_approved_contr'),
                  '_25k_approval_authority_contr' => $this->input->post('_25k_approved_contr'),
                  '_50k_approval_authority_contr' => $this->input->post('_50k_approved_contr'),
                  '_100k_approval_authority_contr' => $this->input->post('_100k_approved_contr'),
                  '_free_approval_authority_contr' => $this->input->post('_free_approved_contr'),


                  //Quote
                  'machine_print_type_id' => $this->input->post('machine_type'),
                  'job_changeover_time' => $this->input->post('job_changeover'),


                  '_5k_flag' => $_5k_flag,
                  '_5k_waste' => $this->input->post('_5k_waste'),
                  //'_5k_target_contr'=>$this->input->post('_5k_target_contr'),
                  '_5k_quoted_contr' => $this->input->post('_5k_quoted_contr'),
                  '_5k_cost' => $this->input->post('_5k_cost'),
                  '_5k_quoted_price' => $this->input->post('_5k_quoted_price'),

                  '_10k_flag' => $_10k_flag,
                  '_10k_waste' => $this->input->post('_10k_waste'),
                  //'_10k_target_contr'=>$this->input->post('_10k_target_contr'),
                  '_10k_quoted_contr' => $this->input->post('_10k_quoted_contr'),
                  '_10k_cost' => $this->input->post('_10k_cost'),
                  '_10k_quoted_price' => $this->input->post('_10k_quoted_price'),

                  '_25k_flag' => $_25k_flag,
                  '_25k_waste' => $this->input->post('_25k_waste'),
                  //'_25k_target_contr'=>$this->input->post('_25k_target_contr'),
                  '_25k_quoted_contr' => $this->input->post('_25k_quoted_contr'),
                  '_25k_cost' => $this->input->post('_25k_cost'),
                  '_25k_quoted_price' => $this->input->post('_25k_quoted_price'),

                  '_50k_flag' => $_50k_flag,
                  '_50k_waste' => $this->input->post('_50k_waste'),
                  //'_50k_target_contr'=>$this->input->post('_50k_target_contr'),
                  '_50k_quoted_contr' => $this->input->post('_50k_quoted_contr'),
                  '_50k_cost' => $this->input->post('_50k_cost'),
                  '_50k_quoted_price' => $this->input->post('_50k_quoted_price'),

                  '_100k_flag' => $_100k_flag,
                  '_100k_waste' => $this->input->post('_100k_waste'),
                  //'_100k_target_contr'=>$this->input->post('_100k_target_contr'),
                  '_100k_quoted_contr' => $this->input->post('_100k_quoted_contr'),
                  '_100k_cost' => $this->input->post('_100k_cost'),
                  '_100k_quoted_price' => $this->input->post('_100k_quoted_price'),

                  'free_flag' => $free_flag,
                  'free_quantity' => $this->input->post('free_quantity'),
                  '_free_quantity_waste' => $this->input->post('_free_quantity_waste'),
                  //'free_target_contr'=>$this->input->post('free_target_contr'),
                  'free_quoted_contr' => $this->input->post('free_quoted_contr'),
                  'free_cost' => $this->input->post('free_cost'),
                  'free_quoted_price' => $this->input->post('free_quoted_price'),

                  'freight' => $this->input->post('freight'),
                  //'packing'=>$this->input->post('packing'),

                  //Cost sheet details
                  //'article_no'=>$article_no,
                  //'invoice_date'=>$this->input->post('invoice_date'),
                  'invoice_no' => $this->input->post('invoice_no'),
                  //'cost'=>$this->input->post('cost'),
                  'remarks' => $this->input->post('remarks'),
                  'pending_flag' => 1,
                  'final_approval_flag' => 1,
                  'user_id' => $this->session->userdata['logged_in']['user_id'],
                  'company_id' => $this->session->userdata['logged_in']['company_id']
                );

                $result_sales_quote_master = $this->common_model->save('sales_quote_master', $data);

                //echo $this->db->last_query();
                if ($result_sales_quote_master) {

                  if (!empty($this->input->post('quotation_no'))) {
                    $sales_quotation_no = $this->input->post('quotation_no');
                  } else {
                    $data_1 = array('curr_val' => $next_quotation_no);
                    $result_autogeneration_format_master = $this->common_model->update_one_active_record('autogeneration_format_master', $data_1, 'form_id', '91', $this->session->userdata['logged_in']['company_id']);
                  }


                  $data_details = array(
                    'quotation_no' => $sales_quotation_no,
                    'sleeve_per_cost' => $this->input->post('sleeve_cost_view'),
                    'version_no' => $this->input->post('version_no'),
                    'lacquer_1' => $this->input->post('lacquer_type_1'),
                    'lacquer1_rate' => $this->input->post('lacquer_type_1_rate'),
                    'lacquer1_gm_per_tube' => $this->input->post('lacquer_type_1_gm_per_tube'),
                    'lacquer1_perc' => $this->input->post('lacquer_type_1_percentage'),
                    'lacquer_2' => $this->input->post('lacquer_type_2'),
                    'lacquer2_rate' => $this->input->post('lacquer_type_2_rate'),
                    'lacquer2_gm_per_tube' => $this->input->post('lacquer_type_2_gm_per_tube'),
                    'lacquer2_perc' => $this->input->post('lacquer_type_2_percentage'),
                    'lacquer_rejection' => $this->input->post('lacquer_rejection'),
                    'lacquer_cost_per_tube' => $this->input->post('lacquer_cost_view'),
                    //----------print type------
                    'label_rejection' => $this->input->post('label_rejection'),
                    'label_rate' => $this->input->post('label_rate'),
                    'label_cost_per_tube' => $this->input->post('label_cost_view'),
                    'screen_rm_month' => $this->input->post('screen_rm_month'),
                    'screen_rate' => $this->input->post('screen_rate'),
                    'screen_gm_per_tube' => $this->input->post('screen_gm_per_tube'),
                    'screen_flexo_rejection' => $this->input->post('screen_flexo_rejection'),
                    'screen_percentage' => $this->input->post('screen_percentage'),
                    'flexo_rm_month' => $this->input->post('flexo_rm_month'),
                    'flexo_rate' => $this->input->post('flexo_rate'),
                    'flexo_gm_per_tube' => $this->input->post('flexo_gm_per_tube'),
                    'flexo_percentage' => $this->input->post('flexo_percentage'),
                    'screen_flexo_cost_per_tube' => $this->input->post('screen_flexo_cost_view'),

                    'spring_consumable_view' => $this->input->post('spring_consumable_view'),
                    'screen_flexo_consumable_view' => $this->input->post('screen_flexo_consumable_view'),
                    //----------screen flexo plate------
                    'screen_film_rate' => $this->input->post('screen_film_rate'),
                    'screen_colors' => $this->input->post('screen_colors'),
                    'screen_impresssion' => $this->input->post('screen_impresssion'),
                    'screen_sets' => $this->input->post('screen_sets'),
                    'screen_film_cost_per_tube' => $this->input->post('screen_plate_cost_view'),
                    'flexo_plate_rate' => $this->input->post('flexo_plate_rate'),
                    'flexo_colors' => $this->input->post('flexo_colors'),
                    'flexo_impresssion' => $this->input->post('flexo_impresssion'),
                    'flexo_sets' => $this->input->post('flexo_sets'),
                    'flexo_plate_cost_per_tube' => $this->input->post('flexo_plate_cost_view'),
                    //----------offset plate------
                    'offset_rm_month' => $this->input->post('offset_rm_month'),
                    'offset_rate' => $this->input->post('offset_rate'),
                    'offset_gm_per_tube' => $this->input->post('offset_gm_per_tube'),
                    'offset_rejection' => $this->input->post('offset_rejection'),
                    'offset_percentage' => $this->input->post('offset_percentage'),
                    'offset_cost_per_tube' => $this->input->post('offset_cost_view'),
                    'offset_consumable_view' => $this->input->post('offset_consumable_view'),

                    'offset_plate_cost' => $this->input->post('offset_plate_cost'),
                    'offset_color' => $this->input->post('offset_color'),
                    'offset_impresssion' => $this->input->post('offset_impresssion'),
                    'offset_sets' => $this->input->post('offset_sets'),
                    'offset_plate_cost_per_tube ' => $this->input->post('offset_plate_cost_view'),

                    //----------special ink------
                    'special_rm_month' => $this->input->post('special_rm_month'),
                    'special_ink_rate' => $this->input->post('special_ink_rate'),
                    'special_gm_per_tube' => $this->input->post('special_gm_per_tube'),
                    'special_percentage' => $this->input->post('special_percentage'),
                    'specialink_rejection' => $this->input->post('specialink_rejection'),
                    'special_ink_cost_per_tube' => $this->input->post('special_ink_cost_view'),
                    //----------shoulder------
                    'sh_hdpe_one' => $this->input->post('sh_hdpe_one'),
                    'sh_hdpe_one_rate' => $this->input->post('sh_hdpe_one_rate'),
                    'hdpe_m' => $this->input->post('hdpe_m'),
                    'sh_hdpe_two' => $this->input->post('sh_hdpe_two'),
                    'sh_hdpe_two_rate' => $this->input->post('sh_hdpe_two_rate'),
                    'hdpe_f' => $this->input->post('hdpe_f'),
                    'shoulder_mb' => $this->input->post('shoulder_mb'),
                    'shoulder_mb_rate' => $this->input->post('shoulder_mb_rate'),
                    'shoulder_mb_percentage' => $this->input->post('shoulder_mb_percentage'),
                    'shoulder_mb1' => $this->input->post('shoulder_mb1'),
                    'shoulder_mb1_rate' => $this->input->post('shoulder_mb1_rate'),
                    'shoulder_mb_percentage1' => $this->input->post('shoulder_mb_percentage1'),
                    'sh_rejection' => $this->input->post('sh_rejection'),
                    'sh_quantity' => $this->input->post('sh_quantity'),
                    'shoulder_cost' => $this->input->post('shoulder_cost_view'),
                    //----------cap------
                    'mould_type' => $this->input->post('mould_type'),
                    'cap_weight_rate' => $this->input->post('cap_weight_rate'),
                    'runner_waste' => $this->input->post('runner_waste'),
                    'pp_price' => $this->input->post('pp_price'),
                    'mb_price' => $this->input->post('mb_price'),
                    'mb_loading' => $this->input->post('mb_loading'),
                    'moulding_cost' => $this->input->post('moulding_cost'),
                    'cap_rejection' => $this->input->post('cap_rejection'),
                    'cap_cost_per_tube' => $this->input->post('cap_cost_view'),
                    //----------packing box--- 
                    'top_box' => $this->input->post('top_box'),
                    'bottom_box' => $this->input->post('bottom_box'),
                    'box_liners' => $this->input->post('box_liners'),
                    'liner_gm' => $this->input->post('liner_gm'),
                    'top_box_rate' => $this->input->post('top_box_rate'),
                    'bottom_box_rate' => $this->input->post('bottom_box_rate'),
                    'box_liners_rate' => $this->input->post('box_liners_rate'),
                    'total_box_rate' => $this->input->post('packing_box_view'),
                    'liner_gm_per_tube' => $this->input->post('liners_view'),
                    //-------------Tube foil--------
                    'hot_foil_1' => $this->input->post('hot_foil_1'),
                    'hot_foil_1_rate' => $this->input->post('hot_foil_1_rate'),
                    'hot_foil_1_percentage' => $this->input->post('hot_foil_1_percentage'),
                    'hot_foil_2' => $this->input->post('hot_foil_2'),
                    'hot_foil_2_rate' => $this->input->post('hot_foil_2_rate'),
                    'hot_foil_2_percentage' => $this->input->post('hot_foil_2_percentage'),
                    'tube_foil_rejection' => $this->input->post('tube_foil_rejection'),
                    'tube_foil_cost_per_tube' => $this->input->post('tube_foil_cost_view'),
                    //-------------Shoulder foil---------
                    'shoulder_foil_tag' => $this->input->post('shoulder_foil_tag'),
                    'shoulder_foil_rate' => $this->input->post('shoulder_foil_rate'),
                    'shoulder_foil_sqm_per_tube' => $this->input->post('shoulder_foil_sqm_per_tube'),
                    'shoulder_foil_cost_per_tube' => $this->input->post('shoulder_foil_cost_view'),
                    //-------------shrink Sleeve---------
                    'cap_shrink_sleeve_code' => $this->input->post('cap_shrink_sleeve_code'),
                    'cap_shrink_sleeve_rate' => $this->input->post('cap_shrink_sleeve_rate'),
                    'cap_shrink_sleeve_cost_per_tube' => $this->input->post('cap_shrink_sleeve_cost_view'),
                    'cap_metalization_rate' => $this->input->post('cap_metalization_rate'),
                    'cap_metalization_cost_view' => $this->input->post('cap_metalization_cost_view'),
                    'cap_foil_rate' => $this->input->post('cap_foil_rate'),
                    'cap_foil_cost_view' => $this->input->post('cap_foil_cost_view'),
                    //-----------Stores and Spares
                    'stores_spares_local_view' => $this->input->post('stores_spares_local_view'),
                    'stores_spares_import_view' => $this->input->post('stores_spares_import_view'),
                    'export_packing' => $this->input->post('customer_flag'),
                    'hygenic_consumable_view' => $this->input->post('hygenic_consumable_view'),
                    'packing_shrink_flim' => $this->input->post('packing_shrink_flim'),
                    'other_consumable_view' => $this->input->post('other_consumable_view'),
                    'packing_corrugated_sheet' => $this->input->post('packing_corrugated_sheet'),
                    'packing_bopp_tape' => $this->input->post('packing_bopp_tape'),
                    'packing_stickers' => $this->input->post('packing_stickers'),
                    'other_packing_material' => $this->input->post('other_packing_material'),
                    'total_rm_cost_per_tube' => $this->input->post('total_rm_cost_per_tube'),
                    'total_consummable_cost_per_tube' => $this->input->post('total_consummable_cost_per_tube'),
                    'total_packing_cost_per_tube' => $this->input->post('total_packing_cost_per_tube'),
                    'total_stores_cost_per_tube' => $this->input->post('total_stores_cost_per_tube'),
                    'total_cost_per_tube' => $this->input->post('total_cost_per_tube'),
                    'waste_total_cost_per_tube' => $this->input->post('waste_total_cost_per_tube'),
                    'company_id' => $this->session->userdata['logged_in']['company_id']

                  );

                  $result_sales_quote_details = $this->common_model->save('sales_quote_details', $data_details);


                  $version_details = array(
                    'quotation_no' => $sales_quotation_no,
                    'version_no' => $this->input->post('version_no'),
                    '_5k_rev_price' => $this->input->post('_5k_r1_price'),
                    '_10k_rev_price' => $this->input->post('_10k_r1_price'),
                    '_25k_rev_price' => $this->input->post('_25k_r1_price'),
                    '_50k_rev_price' => $this->input->post('_50k_r1_price'),
                    '_100k_rev_price' => $this->input->post('_100k_r1_price'),
                    '_free_rev_price' => $this->input->post('_free_r1_price'),
                    'company_id' => $this->session->userdata['logged_in']['company_id']
                  );

                  $result_version_details = $this->common_model->save('sales_quote_revision', $version_details);
                }

                if ($this->input->post('layer') == 1) {

                  for ($i = 1; $i <= $this->input->post('layer_1_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $sales_quotation_no,
                      'version_no' => $this->input->post('version_no'),
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('micron'),
                      'rm' => $this->input->post('layer_1_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_1_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_1_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_1_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer1_rejection'),
                      'quantity' => $this->input->post('quantity'),
                      'sleeve_per_cost' => $this->input->post('sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    $result_sales_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 2) {

                  for ($i = 1; $i <= $this->input->post('layer_2_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $sales_quotation_no,
                      'version_no' => $this->input->post('version_no'),
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_2_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_2_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_2_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_2_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_2_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer2_rejection'),
                      'quantity' => $this->input->post('layer2_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer2_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    $result_sales_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 3) {

                  for ($i = 1; $i <= $this->input->post('layer_3_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $sales_quotation_no,
                      'version_no' => $this->input->post('version_no'),
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_3_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_3_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_3_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_3_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_3_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer3_rejection'),
                      'quantity' => $this->input->post('layer3_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer3_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    $result_sales_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 5) {

                  for ($i = 1; $i <= $this->input->post('layer_5_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $sales_quotation_no,
                      'version_no' => $this->input->post('version_no'),
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_5_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_5_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_5_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_5_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_5_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer5_rejection'),
                      'quantity' => $this->input->post('layer5_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer5_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    $result_sales_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 7) {

                  for ($i = 1; $i <= $this->input->post('layer_7_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $sales_quotation_no,
                      'version_no' => $this->input->post('version_no'),
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_7_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_7_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_7_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_7_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_7_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer7_rejection'),
                      'quantity' => $this->input->post('layer7_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer7_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    $result_sales_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                /* if(!empty($this->input->post('approval_authority'))){

                  $data=array('pending_flag'=>'1');
                  $result=$this->common_model->update_one_active_record_where('sales_quote_master',$data,'quotation_no',$sales_quotation_no,'version_no',$version_no,$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$sales_quotation_no.'@@@'.$version_no);
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
                      'form_id'=>'91',
                      'transaction_no'=>$transaction_no,
                      'status'=>$status,
                      'followup_date'=>date('Y-m-d'),
                      'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                      'record_no'=>$sales_quotation_no.'@@@'.$version_no,
                      );

                    $result=$this->common_model->save('followup',$data);
                  } */

                if ($result_sales_quote_master) {
                  $data['note'] = 'Data saved Successfully';
                } else {
                  $data['error'] = 'Error while saving data';
                }

                //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

                $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

                //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();

                $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


                $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
                $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
                $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
                $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
                $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
                $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
                $special_ink_data = array('ink_id' => '4', 'archive' => '0');
                $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

                $ink_data = array('ink_id' => '2', 'archive' => '0');
                $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
                $screen_data = array('ink_id' => '3', 'archive' => '0');
                $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
                $flexo_data = array('ink_id' => '1', 'archive' => '0');
                $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
                //echo $this->db->last_query();

                $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

                //----Shoulder
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

                $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

                $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

                $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

                $dataa = array('process_id' => '3');
                $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);


                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/create-form', $data);
                $this->load->view('Home/footer');
              }
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



  function copy()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->modify == 1) {

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

              $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

              //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


              $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
              $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
              $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
              $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
              $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
              $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
              $special_ink_data = array('ink_id' => '4', 'archive' => '0');
              $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

              $ink_data = array('ink_id' => '2', 'archive' => '0');
              $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
              $screen_data = array('ink_id' => '3', 'archive' => '0');
              $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
              $flexo_data = array('ink_id' => '1', 'archive' => '0');
              $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
              //echo $this->db->last_query();

              $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

              //----Shoulder
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

              $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

              $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

              $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' => '3');
              $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);


              // -----------------
              $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->uri->segment(3), 'sales_quote_revision.version_no', $this->uri->segment(4));

              // $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'sales_quote_master.quotation_no',$this->uri->segment(3));


              //echo $this->db->last_query();



              $customer_no = '';
              foreach ($data['sales_quote_master'] as $key => $row) {
                $customer_no = $row->customer_no;
              }

              $data_search = array('adr_category_id' => $customer_no, 'archive' => 0);
              $data['purchase_manager'] = $this->common_model->select_active_records_where('address_category_contact_details', $this->session->userdata['logged_in']['company_id'], $data_search);




              // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/copy-form', $data);
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

  /*
  function copy_save(){    
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              //Information----------------------------
             
              $this->form_validation->set_rules('customer','Custommer ' ,'required|trim|xss_clean|callback_customer_check');              
             $this->form_validation->set_rules('pm_1','Purchase Manager 1' ,'required|trim|xss_clean'); 
              $this->form_validation->set_rules('product_name','Product Name' ,'required|trim|xss_clean'); 
              $this->form_validation->set_rules('credit_days','Payment Terms','required|trim|xss_clean');
              $this->form_validation->set_rules('enquiry_date','Enquiry Date','required|trim|xss_clean');

               // Tube Specification-----------------------------              
              $this->form_validation->set_rules('sleeve_dia','Tube dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Tube length' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('layer','Layer' ,'required|trim|xss_clean');
              
              
              $this->form_validation->set_rules('tube_color','Tube Color' ,'required|xss_clean');
              $this->form_validation->set_rules('tube_lacquer','Tube lacquer' ,'required|xss_clean');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('special_ink','Special ink' ,'required|trim|xss_clean');

              // Shoulder Specification-----------------------------
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Oriface' ,'xss_clean');
              $this->form_validation->set_rules('shoulder_color','Shoulder Color' ,'required|xss_clean');

              // Cap Specification-----------------------------
              $this->form_validation->set_rules('cap_type','Cap type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_finish','Cap Finish' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_dia','Cap Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_orifice','Cap Orifice' ,'xss_clean');              
              $this->form_validation->set_rules('cap_color','Cap Color' ,'required|xss_clean');

              // Decorative Elements -----------------------------
              $this->form_validation->set_rules('tube_foil','Tube foil' ,'required|trim|xss_clean');
              //$this->form_validation->set_rules('shoulder_foil','Shoulder Foil' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_foil','Cap foil' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_metalization','Cap Metalization' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_shrink_sleeve','Cap shrink sleeve' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('label_price','Label Price' ,'trim|xss_clean');

              // Quote-----------------------------------

              //$this->form_validation->set_rules('_5k_target_contr','5k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_quoted_contr','5K Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_cost','5K Cost' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_quoted_price','5k Quoted Price' ,'required|trim|xss_clean');


             ///$this->form_validation->set_rules('_10k_target_contr','10k Target contr.' ,'required|trim|xss_clean');
             $this->form_validation->set_rules('_10k_quoted_contr','10k Quoted contr.' ,'required|trim|xss_clean');
             $this->form_validation->set_rules('_10k_cost','10k Cost' ,'required|trim|xss_clean');
             $this->form_validation->set_rules('_10k_quoted_price','10k Quoted Price' ,'required|trim|xss_clean');

             // $this->form_validation->set_rules('_25k_target_contr','25k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_quoted_contr','25k Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_cost','25k Cost' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_quoted_price','25K Quoted Price' ,'required|trim|xss_clean');

             //$this->form_validation->set_rules('_50k_target_contr','50k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_quoted_contr','50k Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_cost','50k Cost' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_quoted_price','50K Quoted Price' ,'required|trim|xss_clean');

             // $this->form_validation->set_rules('_100k_target_contr','100k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_quoted_contr','100k Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_cost','100k Cost' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_quoted_price','100k Quoted Price' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('freight','Freight' ,'required|trim|xss_clean');
              
              
                            
              // Cost sheet details------------------------------
              if(!empty($this->input->post('article_no'))){
                $this->form_validation->set_rules('article_no','Article no' ,'trim|xss_clean|callback_article_check');
              }else{
                $this->form_validation->set_rules('article_no','Article no' ,'trim|xss_clean');
              }
              
              //$this->form_validation->set_rules('invoice_date','Costsheet date' ,'trim|xss_clean');
              $this->form_validation->set_rules('invoice_no','Invoice no' ,'trim|xss_clean');
              //$this->form_validation->set_rules('cost','Cost' ,'trim|xss_clean');  

              $this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean');           
              
             
              

              //echo $this->input->post('cap_metalization');  

              if($this->form_validation->run()==FALSE){

               // echo 'if';

                //$data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));
                $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record_where('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'sales_quote_master.quotation_no',$this->uri->segment(3),'sales_quote_revision.version_no',$this->uri->segment(4));
                //echo $this->db->last_query();

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                 $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);

              //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
             // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','print_type',$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $data['tube_color']=$this->common_model->select_active_drop_down('color_master',$this->session->userdata['logged_in']['company_id']);
            
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
              $data['packing_box']=$this->article_model->spec_all_active_record_search('article','41',$this->session->userdata['logged_in']['company_id']);


               $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
               $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
               $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
               $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
               $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
               $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
               $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
               $special_ink_data=array('ink_id'=>'4','archive'=>'0');
               $data['special_ink']=$this->common_model->select_one_active_record_with_limit('ink_price_master',$this->session->userdata['logged_in']['company_id'],$special_ink_data,'apply_from_date desc','1','0');

               $ink_data=array('ink_id'=>'2','archive'=>'0');
               $data['offset']=$this->common_model->select_one_active_record_with_limit('ink_price_master',$this->session->userdata['logged_in']['company_id'],$ink_data,'apply_from_date desc','1','0');
              $screen_data=array('ink_id'=>'3','archive'=>'0');
               $data['screen']=$this->common_model->select_one_active_record_with_limit('ink_price_master',$this->session->userdata['logged_in']['company_id'],$screen_data,'apply_from_date desc','1','0');
               $flexo_data=array('ink_id'=>'1','archive'=>'0');
               $data['flexo']=$this->common_model->select_one_active_record_with_limit('ink_price_master',$this->session->userdata['logged_in']['company_id'],$flexo_data,'apply_from_date desc','1','0');
               //echo $this->db->last_query();

               $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','1');

               //----Shoulder
               $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);

               $data['workprocedure']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','7');
               
               $data['workprocedure_label']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','5');
               
               $data['workprocedure_printing']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','3');

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');
              $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);

              $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['cap_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['cap_shrink_sleeve']=$this->article_model->spec_all_active_record_search('article','213',$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'3');
              $data['machine_type']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_search=array('archive'=>0);
              $data['purchase_manager']=$this->common_model->select_active_records_where('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],$data_search);

              


                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/copy-form',$data);
                $this->load->view('Home/footer');
              }else{

               // echo $this->input->post('cap_metalization');
              //echo "<br/>";
               echo "else";

                $sales_quotation_no='';
                if(!empty($this->input->post('quotation_no'))){
                  $sales_quotation_no = $this->input->post('quotation_no');
                }

                /*
                $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','91');
                $no="";
                foreach ($data['auto'] as $auto_row) {

                  $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                  foreach($data['account_periods'] as $account_periods_row){
                    $start=date('y', strtotime($account_periods_row->fin_year_start));
                    $end=date('y', strtotime($account_periods_row->fin_year_end));
                  }
                  $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                  $sales_quotation_no=$auto_row->textcode.$auto_row->seperator.$start.$auto_row->seperator.$end.$auto_row->seperator.$no;
                  $next_quotation_no=$auto_row->curr_val+1;
                }  */

  //$data=array('curr_val'=>$next_sales_order_no);
  //$this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','91',$this->session->userdata['logged_in']['company_id']);


  /*    $customer_no=''; 

                if(!empty($this->input->post('customer'))){

                  $arr=explode("//",$this->input->post('customer'));
                  if(count($arr)>=2){
                    $customer_no=$arr[1];
                  }

                }
                $article_no='';
                if(!empty($this->input->post('article_no'))){

                  $arr1=explode("//",$this->input->post('article_no'));
                  if(count($arr1)>=2){
                    $article_no=$arr1[1];
                  }

                }

                if(!empty($this->input->post('sleeve_dia'))){
                  $sleeve_dia_array=explode("//",$this->input->post('sleeve_dia'));
                  $sleeve_dia=$sleeve_dia_array[1];
                  }else{
                  $sleeve_dia="";
                }  

                if(!empty($this->input->post('shoulder'))){
                  $shoulder_array=explode("//",$this->input->post('shoulder'));
                  $shoulder=$shoulder_array[1];
                  }else{
                  $shoulder="";
                }

                if(!empty($this->input->post('shoulder_orifice'))){
                  $shoulder_orifice_array=explode("//",$this->input->post('shoulder_orifice'));
                  $shoulder_orifice=$shoulder_orifice_array[1];
                  }else{
                  $shoulder_orifice="";
                }

                //-------CAP explode//
                if(!empty($this->input->post('cap_type'))){
                  $cap_type_array=explode("//",$this->input->post('cap_type'));
                  $cap_type=$cap_type_array[1];
                  }else{
                  $cap_type="";
                }

                if(!empty($this->input->post('cap_finish'))){
                  $cap_finish_array=explode("//",$this->input->post('cap_finish'));
                  $cap_finish=$cap_finish_array[1];
                  }else{
                  $cap_finish="";
                }

                if(!empty($this->input->post('cap_dia'))){
                  $cap_dia_array=explode("//",$this->input->post('cap_dia'));
                  $cap_dia=$cap_dia_array[1];
                  }else{
                  $cap_dia="";
                }

                if(!empty($this->input->post('cap_orifice'))){
                  $cap_orifice_array=explode("//",$this->input->post('cap_orifice'));
                  $cap_orifice=$cap_orifice_array[1];
                  }else{
                  $cap_orifice="";
                }

                if(!empty($this->input->post('tube_color'))){
                  $tube_color_aray=explode("//",$this->input->post('tube_color'));
                  $tube_color=$tube_color_aray[0];
                  }else{
                  $tube_color="";
                }

                if(!empty($this->input->post('shoulder_color'))){
                  $shoulder_color_array=explode("//",$this->input->post('shoulder_color'));
                  $shoulder_color=$shoulder_color_array[0];
                  }else{
                  $shoulder_color="";
                }

                if(!empty($this->input->post('cap_color'))){
                  $cap_color_array=explode("//",$this->input->post('cap_color'));
                  $cap_color=$cap_color_array[0];
                  }else{
                  $cap_color="";
                }

                if($this->input->post('cap_metalization') == 'YES') {
                   $cap_metalization = "YES";
                } else {
                   $cap_metalization = "NO";
                }
                
                if($this->input->post('cap_foil') == 'YES') {
                   $cap_foil = "YES";
                } else {
                   $cap_foil = "NO";
                }

                $_5k_flag=($this->input->post('_5k_flag') == '1' ? '1' :'0');
                $_10k_flag=($this->input->post('_10k_flag') == '1' ? '1' :'0');
                $_25k_flag=($this->input->post('_25k_flag') == '1' ? '1' :'0');
                $_50k_flag=($this->input->post('_50k_flag') == '1' ? '1' :'0');  
                $_100k_flag=($this->input->post('_100k_flag') == '1' ? '1' :'0');
                $free_flag=($this->input->post('free_flag') == '1' ? '1' :'0');


                 $data=array(
                  'quotation_date'=>date('Y-m-d'),
                  'quotation_no'=>$sales_quotation_no,  
                  'version_no'=>$this->input->post('version_no');                
                  'customer_no'=>$customer_no,
                  'pm_1'=>$this->input->post('pm_1'),
                  'product_name'=>$this->input->post('product_name'),
                  'credit_days'=>$this->input->post('credit_days'),
                  'enquiry_date'=>$this->input->post('enquiry_date'),
                  
                  // specification
                  'layer'=>$this->input->post('layer'),
                  'sleeve_dia'=>$sleeve_dia,
                  'sleeve_length'=>$this->input->post('sleeve_length'),
                  'tube_color'=>$tube_color,
                  'tube_lacquer'=>$this->input->post('tube_lacquer'),
                  'print_type'=>$this->input->post('print_type'),
                  'special_ink'=>$this->input->post('special_ink'),

                  'shoulder'=>$shoulder,
                  'shoulder_orifice'=>$shoulder_orifice,
                  'shoulder_color'=>$shoulder_color,

                  'cap_type'=>$cap_type,
                  'cap_finish'=>$cap_finish,
                  'cap_dia'=>$cap_dia,
                  'cap_orifice'=>$cap_orifice,
                  'cap_color'=>$cap_color,

                  'tube_foil'=>$this->input->post('tube_foil'),
                  'shoulder_foil'=>$this->input->post('shoulder_foil'),
                  'cap_foil'=>$cap_foil,
                  'cap_foil_width'=>$this->input->post('cap_foil_width'),
                  'cap_foil_dist_frm_bottom'=>$this->input->post('cap_foil_dist_frm_bottom'),

                  'cap_metalization'=>$cap_metalization,
                  'cap_metalization_color'=>$this->input->post('cap_metalization_color'),
                  'cap_metalization_finish'=>$this->input->post('cap_metalization_finish'),
                  'cap_shrink_sleeve'=>$this->input->post('cap_shrink_sleeve'),
                  

                  //Quote
                  'machine_print_type_id'=>$this->input->post('machine_type'),

                  '_5k_flag'=>$_5k_flag,
                  '_5k_waste'=>$this->input->post('_5k_waste'),
                  //'_5k_target_contr'=>$this->input->post('_5k_target_contr'),
                  '_5k_quoted_contr'=>$this->input->post('_5k_quoted_contr'),
                  '_5k_cost'=>$this->input->post('_5k_cost'),
                  '_5k_quoted_price'=>$this->input->post('_5k_quoted_price'),

                  '_10k_flag'=>$_10k_flag,
                  '_10k_waste'=>$this->input->post('_10k_waste'),
                  //'_10k_target_contr'=>$this->input->post('_10k_target_contr'),
                  '_10k_quoted_contr'=>$this->input->post('_10k_quoted_contr'),
                  '_10k_cost'=>$this->input->post('_10k_cost'),               
                  '_10k_quoted_price'=>$this->input->post('_10k_quoted_price'),

                  '_25k_flag'=>$_25k_flag,
                  '_25k_waste'=>$this->input->post('_25k_waste'),
                  //'_25k_target_contr'=>$this->input->post('_25k_target_contr'),
                  '_25k_quoted_contr'=>$this->input->post('_25k_quoted_contr'),
                  '_25k_cost'=>$this->input->post('_25k_cost'),                                  
                  '_25k_quoted_price'=>$this->input->post('_25k_quoted_price'),

                  '_50k_flag'=>$_50k_flag,
                  '_50k_waste'=>$this->input->post('_50k_waste'),
                  //'_50k_target_contr'=>$this->input->post('_50k_target_contr'),
                  '_50k_quoted_contr'=>$this->input->post('_50k_quoted_contr'),
                  '_50k_cost'=>$this->input->post('_50k_cost'),             
                  '_50k_quoted_price'=>$this->input->post('_50k_quoted_price'),

                  '_100k_flag'=>$_100k_flag,
                  '_100k_waste'=>$this->input->post('_100k_waste'),
                  //'_100k_target_contr'=>$this->input->post('_100k_target_contr'),
                  '_100k_quoted_contr'=>$this->input->post('_100k_quoted_contr'),
                  '_100k_cost'=>$this->input->post('_100k_cost'),
                  '_100k_quoted_price'=>$this->input->post('_100k_quoted_price'),
                  
                  'free_flag'=>$free_flag,
                  'free_quantity'=>$this->input->post('free_quantity'),
                  '_free_quantity_waste'=>$this->input->post('_free_quantity_waste'),
                  //'free_target_contr'=>$this->input->post('free_target_contr'),
                  'free_quoted_contr'=>$this->input->post('free_quoted_contr'),
                  'free_cost'=>$this->input->post('free_cost'),
                  'free_quoted_price'=>$this->input->post('free_quoted_price'),

                  'freight'=>$this->input->post('freight'),
                 //'packing'=>$this->input->post('packing'),

                  //Cost sheet details
                  //'article_no'=>$article_no,
                  //'invoice_date'=>$this->input->post('invoice_date'),
                  'invoice_no'=>$this->input->post('invoice_no'),
                  //'cost'=>$this->input->post('cost'),
                  'remarks'=>$this->input->post('remarks'),
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'company_id'=>$this->session->userdata['logged_in']['company_id']               
                  );

                $result_sales_quote_master=$this->common_model->save('sales_quote_master',$data); 
               // echo $this->db->last_query();
                if($result_sales_quote_master){

                /*  $data_1=array('curr_val'=>$next_quotation_no);
                  $result_autogeneration_format_master=$this->common_model->update_one_active_record('autogeneration_format_master',$data_1,'form_id','91',$this->session->userdata['logged_in']['company_id']); */


  /*     $data_details = array('quotation_no'=>$sales_quotation_no,
                                      //'version_no'=>$this->input->post('version_no');   
                                      'sleeve_per_cost'=>$this->input->post('sleeve_cost_view'),
                                      'lacquer_1'=>$this->input->post('lacquer_type_1'),
                                      'lacquer1_rate'=>$this->input->post('lacquer_type_1_rate'),
                                      'lacquer1_gm_per_tube'=>$this->input->post('lacquer_type_1_gm_per_tube'),
                                      'lacquer1_perc'=>$this->input->post('lacquer_type_1_percentage'),
                                      'lacquer_2'=>$this->input->post('lacquer_type_2'),
                                      'lacquer2_rate'=>$this->input->post('lacquer_type_2_rate'),
                                      'lacquer2_gm_per_tube'=>$this->input->post('lacquer_type_2_gm_per_tube'),
                                      'lacquer2_perc'=>$this->input->post('lacquer_type_2_percentage'),
                                      'lacquer_rejection'=>$this->input->post('lacquer_rejection'),
                                      'lacquer_cost_per_tube'=>$this->input->post('lacquer_cost_view'), 
                                      //----------print type------
                                      'label_rejection'=>$this->input->post('label_rejection'), 
                                      'label_rate'=>$this->input->post('label_rate'), 
                                      'label_cost_per_tube'=>$this->input->post('label_cost_view'), 
                                      'screen_rm_month'=>$this->input->post('screen_rm_month'), 
                                      'screen_rate'=>$this->input->post('screen_rate'), 
                                      'screen_gm_per_tube'=>$this->input->post('screen_gm_per_tube'),
                                      'screen_flexo_rejection'=>$this->input->post('screen_flexo_rejection'),   
                                      'screen_percentage'=>$this->input->post('screen_percentage'), 
                                      'flexo_rm_month'=>$this->input->post('flexo_rm_month'), 
                                      'flexo_rate'=>$this->input->post('flexo_rate'), 
                                      'flexo_gm_per_tube'=>$this->input->post('flexo_gm_per_tube'), 
                                      'flexo_percentage'=>$this->input->post('flexo_percentage'), 
                                      'screen_flexo_cost_per_tube'=>$this->input->post('screen_flexo_cost_view'),

                                      'spring_consumable_view'=>$this->input->post('spring_consumable_view'), 
                                      'screen_flexo_consumable_view'=>$this->input->post('screen_flexo_consumable_view'), 
                                      //----------screen flexo plate------
                                      'screen_film_rate'=>$this->input->post('screen_film_rate'), 
                                      'screen_colors'=>$this->input->post('screen_colors'), 
                                      'screen_impresssion'=>$this->input->post('screen_impresssion'), 
                                      'screen_sets'=>$this->input->post('screen_sets'), 
                                      'screen_film_cost_per_tube'=>$this->input->post('screen_plate_cost_view'), 
                                      'flexo_plate_rate'=>$this->input->post('flexo_plate_rate'), 
                                      'flexo_colors'=>$this->input->post('flexo_colors'), 
                                      'flexo_impresssion'=>$this->input->post('flexo_impresssion'), 
                                      'flexo_sets'=>$this->input->post('flexo_sets'), 
                                      'flexo_plate_cost_per_tube'=>$this->input->post('flexo_plate_cost_view'),
                                      //----------offset plate------
                                      'offset_rm_month'=>$this->input->post('offset_rm_month'),
                                      'offset_rate'=>$this->input->post('offset_rate'),
                                      'offset_gm_per_tube'=>$this->input->post('offset_gm_per_tube'),
                                      'offset_rejection'=>$this->input->post('offset_rejection'),
                                      'offset_percentage'=>$this->input->post('offset_percentage'),
                                      'offset_cost_per_tube'=>$this->input->post('offset_cost_view'),
                                      'offset_consumable_view'=>$this->input->post('offset_consumable_view'), 

                                      'offset_plate_cost'=>$this->input->post('offset_plate_cost'),
                                      'offset_color'=>$this->input->post('offset_color'),
                                      'offset_impresssion'=>$this->input->post('offset_impresssion'),
                                      'offset_sets'=>$this->input->post('offset_sets'),
                                      'offset_plate_cost_per_tube '=>$this->input->post('offset_plate_cost_view'),

                                      //----------special ink------
                                      'special_rm_month'=>$this->input->post('special_rm_month'),
                                      'special_ink_rate'=>$this->input->post('special_ink_rate'),
                                      'special_gm_per_tube'=>$this->input->post('special_gm_per_tube'),
                                      'special_percentage'=>$this->input->post('special_percentage'),
                                      'specialink_rejection'=>$this->input->post('specialink_rejection'),
                                      'special_ink_cost_per_tube'=>$this->input->post('special_ink_cost_view'),
                                      //----------shoulder------
                                      'sh_hdpe_one'=>$this->input->post('sh_hdpe_one'),
                                      'sh_hdpe_one_rate'=>$this->input->post('sh_hdpe_one_rate'),
                                      'hdpe_m'=>$this->input->post('hdpe_m'),
                                      'sh_hdpe_two'=>$this->input->post('sh_hdpe_two'),
                                      'sh_hdpe_two_rate'=>$this->input->post('sh_hdpe_two_rate'),
                                      'hdpe_f'=>$this->input->post('hdpe_f'),
                                      'shoulder_mb'=>$this->input->post('shoulder_mb'),
                                      'shoulder_mb_rate'=>$this->input->post('shoulder_mb_rate'),
                                      'shoulder_mb_percentage'=>$this->input->post('shoulder_mb_percentage'),
                                      'shoulder_mb1'=>$this->input->post('shoulder_mb1'),
                                      'shoulder_mb1_rate'=>$this->input->post('shoulder_mb1_rate'),
                                      'shoulder_mb_percentage1'=>$this->input->post('shoulder_mb_percentage1'),
                                      'sh_rejection'=>$this->input->post('sh_rejection'),
                                      'sh_quantity'=>$this->input->post('sh_quantity'),
                                      'shoulder_cost'=>$this->input->post('shoulder_cost_view'),
                                      //----------cap------
                                      'mould_type'=>$this->input->post('mould_type'),
                                      'cap_weight_rate'=>$this->input->post('cap_weight_rate'),
                                      'runner_waste'=>$this->input->post('runner_waste'),
                                      'pp_price'=>$this->input->post('pp_price'),
                                      'mb_price'=>$this->input->post('mb_price'),
                                      'mb_loading'=>$this->input->post('mb_loading'),
                                      'moulding_cost'=>$this->input->post('moulding_cost'),
                                      'cap_rejection'=>$this->input->post('cap_rejection'),
                                      'cap_cost_per_tube'=>$this->input->post('cap_cost_view'),
                                      //----------packing box--- 
                                      'top_box'=>$this->input->post('top_box'), 
                                      'bottom_box'=>$this->input->post('bottom_box'), 
                                      'box_liners'=>$this->input->post('box_liners'), 
                                      'liner_gm'=>$this->input->post('liner_gm'), 
                                      'top_box_rate'=>$this->input->post('top_box_rate'), 
                                      'bottom_box_rate'=>$this->input->post('bottom_box_rate'), 
                                      'box_liners_rate'=>$this->input->post('box_liners_rate'), 
                                      'total_box_rate'=>$this->input->post('packing_box_view'), 
                                      'liner_gm_per_tube'=>$this->input->post('liners_view'), 
                                      //-------------Tube foil--------
                                      'hot_foil_1'=>$this->input->post('hot_foil_1'), 
                                      'hot_foil_1_rate'=>$this->input->post('hot_foil_1_rate'), 
                                      'hot_foil_1_percentage'=>$this->input->post('hot_foil_1_percentage'), 
                                      'hot_foil_2'=>$this->input->post('hot_foil_2'), 
                                      'hot_foil_2_rate'=>$this->input->post('hot_foil_2_rate'), 
                                      'hot_foil_2_percentage'=>$this->input->post('hot_foil_2_percentage'), 
                                      'tube_foil_rejection'=>$this->input->post('tube_foil_rejection'),
                                      'tube_foil_cost_per_tube'=>$this->input->post('tube_foil_cost_view'), 
                                      //-------------Shoulder foil---------
                                      'shoulder_foil_tag'=>$this->input->post('shoulder_foil_tag'), 
                                      'shoulder_foil_rate'=>$this->input->post('shoulder_foil_rate'),
                                      'shoulder_foil_sqm_per_tube'=>$this->input->post('shoulder_foil_sqm_per_tube'),
                                      'shoulder_foil_cost_per_tube'=>$this->input->post('shoulder_foil_cost_view'),
                                      //-------------shrink Sleeve---------
                                      'cap_shrink_sleeve_code'=>$this->input->post('cap_shrink_sleeve_code'), 
                                      'cap_shrink_sleeve_rate'=>$this->input->post('cap_shrink_sleeve_rate'),
                                      'cap_shrink_sleeve_cost_per_tube'=>$this->input->post('cap_shrink_sleeve_cost_view'),
                                      'cap_metalization_rate'=>$this->input->post('cap_metalization_rate'),
                                      'cap_metalization_cost_view'=>$this->input->post('cap_metalization_cost_view'),
                                      'cap_foil_rate'=>$this->input->post('cap_foil_rate'),
                                      'cap_foil_cost_view'=>$this->input->post('cap_foil_cost_view'),
                                      //-----------Stores and Spares
                                      'stores_spares_local_view'=>$this->input->post('stores_spares_local_view'),
                                      'stores_spares_import_view'=>$this->input->post('stores_spares_import_view'),
                                      'export_packing'=>$this->input->post('customer_flag'),
                                      'hygenic_consumable_view'=>$this->input->post('hygenic_consumable_view'),
                                      'packing_shrink_flim'=>$this->input->post('packing_shrink_flim'),
                                      'other_consumable_view'=>$this->input->post('other_consumable_view'),
                                      'packing_corrugated_sheet'=>$this->input->post('packing_corrugated_sheet'),
                                      'packing_bopp_tape'=>$this->input->post('packing_bopp_tape'),
                                      'packing_stickers'=>$this->input->post('packing_stickers'),
                                      'other_packing_material'=>$this->input->post('other_packing_material'),
                                      'total_rm_cost_per_tube'=>$this->input->post('total_rm_cost_per_tube'),
                                      'total_consummable_cost_per_tube'=>$this->input->post('total_consummable_cost_per_tube'),
                                      'total_packing_cost_per_tube'=>$this->input->post('total_packing_cost_per_tube'),
                                      'total_stores_cost_per_tube'=>$this->input->post('total_stores_cost_per_tube'),
                                      'total_cost_per_tube'=>$this->input->post('total_cost_per_tube'),
                                      'waste_total_cost_per_tube'=>$this->input->post('waste_total_cost_per_tube'),
                                      'company_id'=>$this->session->userdata['logged_in']['company_id']  

                                    );

                  $result_sales_quote_details=$this->common_model->save('sales_quote_details',$data_details);

                  $version_details = array( 'quotation_no'=>$sales_quotation_no,
                                            'version_no'=>$this->input->post('version_no'),
                                            'company_id'=>$this->session->userdata['logged_in']['company_id'] 
                                        );

                  $result_version_details=$this->common_model->save('sales_quote_revision',$version_details);
                  
                }

                if($this->input->post('layer')==1){

                for($i=1;$i<=$this->input->post('layer_1_rows');$i++) {


                    $sleeve_details = array('quotation_no'=>$sales_quotation_no,
                                          //'version_no'=>$this->input->post('version_no');   
                                            'layer'=>$this->input->post('layer'),
                                            'micron'=>$this->input->post('micron'),
                                            'rm'=>$this->input->post('layer_1_rm_'.$i.''),
                                            'rm_code'=>$this->input->post('layer_1_rm_'.$i.'_code'),
                                            'rm_rate'=>$this->input->post('layer_1_rm_'.$i.'_rate'),
                                            'rm_percentage'=>$this->input->post('layer_1_rm_'.$i.'_percentage'),
                                            'rejection'=>$this->input->post('layer1_rejection'),
                                            'quantity'=>$this->input->post('quantity'),                                            
                                            'sleeve_per_cost'=>$this->input->post('sleeve_cost'),
                                            'company_id'=>$this->session->userdata['logged_in']['company_id']  
                                            
                                          );
                    $result_sales_quote_sleeve_details=$this->common_model->save('sales_quote_sleeve_details',$sleeve_details); 
                    //echo $this->db->last_query();
                  }
               }

               if($this->input->post('layer')==2){

                for($i=1;$i<=$this->input->post('layer_2_rows');$i++) {


                    $sleeve_details = array('quotation_no'=>$sales_quotation_no,
                                            //'version_no'=>$this->input->post('version_no');   
                                            'layer'=>$this->input->post('layer'),
                                            'micron'=>$this->input->post('layer_2_layer_'.$i.'_micron'), 
                                            'rm'=>$this->input->post('layer_2_rm_'.$i.''),
                                            'rm_code'=>$this->input->post('layer_2_rm_'.$i.'_code'),
                                            'rm_rate'=>$this->input->post('layer_2_rm_'.$i.'_rate'),
                                            'rm_percentage'=>$this->input->post('layer_2_rm_'.$i.'_percentage'),
                                            'rejection'=>$this->input->post('layer2_rejection'),
                                            'quantity'=>$this->input->post('layer2_quantity'),     
                                            'sleeve_per_cost'=>$this->input->post('layer2_sleeve_cost'),
                                            'company_id'=>$this->session->userdata['logged_in']['company_id']  
                                            
                                          );
                    $result_sales_quote_sleeve_details=$this->common_model->save('sales_quote_sleeve_details',$sleeve_details); 
                    //echo $this->db->last_query();
                  }
               }

               if($this->input->post('layer')==3){

                for($i=1;$i<=$this->input->post('layer_3_rows');$i++) {


                    $sleeve_details = array('quotation_no'=>$sales_quotation_no,
                                            //'version_no'=>$this->input->post('version_no');       
                                            'layer'=>$this->input->post('layer'),
                                            'micron'=>$this->input->post('layer_3_layer_'.$i.'_micron'), 
                                            'rm'=>$this->input->post('layer_3_rm_'.$i.''),
                                            'rm_code'=>$this->input->post('layer_3_rm_'.$i.'_code'),
                                            'rm_rate'=>$this->input->post('layer_3_rm_'.$i.'_rate'),
                                            'rm_percentage'=>$this->input->post('layer_3_rm_'.$i.'_percentage'),
                                            'rejection'=>$this->input->post('layer3_rejection'),
                                            'quantity'=>$this->input->post('layer3_quantity'),     
                                            'sleeve_per_cost'=>$this->input->post('layer3_sleeve_cost'),
                                            'company_id'=>$this->session->userdata['logged_in']['company_id']  
                                            
                                          );
                    $result_sales_quote_sleeve_details=$this->common_model->save('sales_quote_sleeve_details',$sleeve_details); 
                    //echo $this->db->last_query();
                  }
               }

               if($this->input->post('layer')==5){

                for($i=1;$i<=$this->input->post('layer_5_rows');$i++) {


                    $sleeve_details = array('quotation_no'=>$sales_quotation_no,
                                            //'version_no'=>$this->input->post('version_no');         
                                            'layer'=>$this->input->post('layer'),
                                            'micron'=>$this->input->post('layer_5_layer_'.$i.'_micron'), 
                                            'rm'=>$this->input->post('layer_5_rm_'.$i.''),
                                            'rm_code'=>$this->input->post('layer_5_rm_'.$i.'_code'),
                                            'rm_rate'=>$this->input->post('layer_5_rm_'.$i.'_rate'),
                                            'rm_percentage'=>$this->input->post('layer_5_rm_'.$i.'_percentage'),
                                            'rejection'=>$this->input->post('layer5_rejection'),
                                            'quantity'=>$this->input->post('layer5_quantity'),     
                                            'sleeve_per_cost'=>$this->input->post('layer5_sleeve_cost'),
                                            'company_id'=>$this->session->userdata['logged_in']['company_id']  
                                            
                                          );
                    $result_sales_quote_sleeve_details=$this->common_model->save('sales_quote_sleeve_details',$sleeve_details); 
                    //echo $this->db->last_query();
                  }
               }

               if($this->input->post('layer')==7){

                for($i=1;$i<=$this->input->post('layer_7_rows');$i++) {


                    $sleeve_details = array('quotation_no'=>$sales_quotation_no,
                                           //'version_no'=>$this->input->post('version_no');      
                                            'layer'=>$this->input->post('layer'),
                                            'micron'=>$this->input->post('layer_7_layer_'.$i.'_micron'), 
                                            'rm'=>$this->input->post('layer_7_rm_'.$i.''),
                                            'rm_code'=>$this->input->post('layer_7_rm_'.$i.'_code'),
                                            'rm_rate'=>$this->input->post('layer_7_rm_'.$i.'_rate'),
                                            'rm_percentage'=>$this->input->post('layer_7_rm_'.$i.'_percentage'),
                                            'rejection'=>$this->input->post('layer7_rejection'),
                                            'quantity'=>$this->input->post('layer7_quantity'),     
                                            'sleeve_per_cost'=>$this->input->post('layer7_sleeve_cost'),
                                            'company_id'=>$this->session->userdata['logged_in']['company_id']  
                                            
                                          );
                    $result_sales_quote_sleeve_details=$this->common_model->save('sales_quote_sleeve_details',$sleeve_details); 
                    //echo $this->db->last_query();
                  }
               }

                if(!empty($this->input->post('approval_authority'))){

                  $data=array('pending_flag'=>'1');
                  $result=$this->common_model->update_one_active_record_where('sales_quote_master',$data,'quotation_no',$sales_quotation_no,'sales_quote_revision.version_no',$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$sales_quotation_no);
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
                      'form_id'=>'91',
                      'transaction_no'=>$transaction_no,
                      'status'=>$status,
                      'followup_date'=>date('Y-m-d'),
                      'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                      'record_no'=>$sales_quotation_no,
                      );

                    $result=$this->common_model->save('followup',$data);
                  } 

                if($result_sales_quote_master){
                  $data['note']='Data saved Successfully';
                }else{
                  $data['error']='Error while saving data';
                }

                //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                //$data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));
                $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record_where('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'sales_quote_master.quotation_no',$this->uri->segment(3),'sales_quote_revision.version_no',$this->uri->segment(4));

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);

              //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
             // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','print_type',$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $data['tube_color']=$this->common_model->select_active_drop_down('color_master',$this->session->userdata['logged_in']['company_id']);
            
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
              $data['packing_box']=$this->article_model->spec_all_active_record_search('article','41',$this->session->userdata['logged_in']['company_id']);


               $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
               $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
               $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
               $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
               $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
               $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
               $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
               $special_ink_data=array('ink_id'=>'4','archive'=>'0');
               $data['special_ink']=$this->common_model->select_one_active_record_with_limit('ink_price_master',$this->session->userdata['logged_in']['company_id'],$special_ink_data,'apply_from_date desc','1','0');

               $ink_data=array('ink_id'=>'2','archive'=>'0');
               $data['offset']=$this->common_model->select_one_active_record_with_limit('ink_price_master',$this->session->userdata['logged_in']['company_id'],$ink_data,'apply_from_date desc','1','0');
              $screen_data=array('ink_id'=>'3','archive'=>'0');
               $data['screen']=$this->common_model->select_one_active_record_with_limit('ink_price_master',$this->session->userdata['logged_in']['company_id'],$screen_data,'apply_from_date desc','1','0');
               $flexo_data=array('ink_id'=>'1','archive'=>'0');
               $data['flexo']=$this->common_model->select_one_active_record_with_limit('ink_price_master',$this->session->userdata['logged_in']['company_id'],$flexo_data,'apply_from_date desc','1','0');
               //echo $this->db->last_query();

               $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','1');

               //----Shoulder
               $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);

               $data['workprocedure']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','7');
               
               $data['workprocedure_label']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','5');
               
               $data['workprocedure_printing']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','3');

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');
              $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);

              $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['cap_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['cap_shrink_sleeve']=$this->article_model->spec_all_active_record_search('article','213',$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'3');
              $data['machine_type']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
             
               
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/copy-form',$data);
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
  */


  function price_revision_modify()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->modify == 1) {

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

              $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

              //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


              $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
              $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
              $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
              $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
              $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
              $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
              $special_ink_data = array('ink_id' => '4', 'archive' => '0');
              $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

              $ink_data = array('ink_id' => '2', 'archive' => '0');
              $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
              $screen_data = array('ink_id' => '3', 'archive' => '0');
              $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
              $flexo_data = array('ink_id' => '1', 'archive' => '0');
              $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
              //echo $this->db->last_query();

              $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

              //----Shoulder
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

              $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

              $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

              $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' => '3');
              $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);


              // -----------------
              $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->uri->segment(3), 'sales_quote_revision.version_no', $this->uri->segment(4));

              // $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'sales_quote_master.quotation_no',$this->uri->segment(3));


              //echo $this->db->last_query();



              $customer_no = '';
              foreach ($data['sales_quote_master'] as $key => $row) {
                $customer_no = $row->customer_no;
              }

              $data_search = array('adr_category_id' => $customer_no, 'archive' => 0);
              $data['purchase_manager'] = $this->common_model->select_active_records_where('address_category_contact_details', $this->session->userdata['logged_in']['company_id'], $data_search);




              // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/price-rev-form', $data);
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

  function price_revision_update()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->modify == 1) {

              // Quote-----------------------------------

              $_5k_approved_contr = $this->input->post('_5k_approved_contr');
              $_10k_approved_contr = $this->input->post('_10k_approved_contr');
              $_25k_approved_contr = $this->input->post('_25k_approved_contr');
              $_50k_approved_contr = $this->input->post('_50k_approved_contr');
              $_100k_approved_contr = $this->input->post('_100k_approved_contr');
              $_free_approved_contr = $this->input->post('_free_approved_contr');

              $this->form_validation->set_rules('_5k_r1_price', '5k rev price', 'trim|xss_clean|greater_than_equal_to[' . $_5k_approved_contr . ']');

              $this->form_validation->set_rules('_10k_r1_price', '10K rev price', 'trim|xss_clean|greater_than_equal_to[' . $_10k_approved_contr . ']');
              $this->form_validation->set_rules('_25k_r1_price', '25K rev price', 'trim|xss_clean|greater_than_equal_to[' . $_25k_approved_contr . ']');
              $this->form_validation->set_rules('_50k_r1_price', '50k rev Price', 'trim|xss_clean|greater_than_equal_to[' . $_50k_approved_contr . ']');
              $this->form_validation->set_rules('_100k_r1_price', '100k rev Price', 'trim|xss_clean|greater_than_equal_to[' . $_100k_approved_contr . ']');
              $this->form_validation->set_rules('_free_r1_price', 'free rev Price', 'trim|xss_clean|greater_than_equal_to[' . $_free_approved_contr . ']');

              $result_sales_quote_revision = '';

              if ($this->form_validation->run() == FALSE) {


                //echo('if');  

                //$data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));

                $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->input->post('quotation_no'), 'sales_quote_revision.version_no', $this->input->post('version_no'));


                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

                $dataa = array('process_id' => '3');
                $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);





                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/price-rev-form', $data);
                $this->load->view('Home/footer');
              } else {
                //echo('else');  

                $data['version'] = $this->sales_quote_model->select_quote_verion_no('sales_quote_revision', $this->session->userdata['logged_in']['company_id'], 'quotation_no', $this->input->post('quotation_no'));
                //echo $this->db->last_query();

                foreach ($data['version'] as $version_row) {

                  if ($version_row->version_no == NULL) {

                    $this->input->post('quotation_no') == '';
                    $version_no = 1;
                  } else {
                    $version_no = $version_row->version_no;
                  }
                }

                $_5k_flag = ($this->input->post('_5k_flag') == '1' ? '1' : '0');
                $_10k_flag = ($this->input->post('_10k_flag') == '1' ? '1' : '0');
                $_25k_flag = ($this->input->post('_25k_flag') == '1' ? '1' : '0');
                $_50k_flag = ($this->input->post('_50k_flag') == '1' ? '1' : '0');
                $_100k_flag = ($this->input->post('_100k_flag') == '1' ? '1' : '0');
                $free_flag = ($this->input->post('free_flag') == '1' ? '1' : '0');

                $flag_data = array(
                  '_5k_flag' => $_5k_flag,
                  '_10k_flag' => $_10k_flag,
                  '_25k_flag' => $_25k_flag,
                  '_50k_flag' => $_50k_flag,
                  '_100k_flag' => $_100k_flag,
                  'free_flag' => $free_flag
                );

                $result_update = $this->common_model->update_one_active_record_where('sales_quote_master', $flag_data, 'quotation_no', $this->input->post('quotation_no'), 'version_no', $this->input->post('version_no'), $this->session->userdata['logged_in']['company_id']);

                //echo $this->db->last_query();                  

                $data = array(

                  'quotation_no' => $this->input->post('quotation_no'),
                  'version_no' => $this->input->post('version_no'),
                  '_5k_rev_price' => $this->input->post('_5k_r1_price'),
                  '_10k_rev_price' => $this->input->post('_10k_r1_price'),
                  '_25k_rev_price' => $this->input->post('_25k_r1_price'),
                  '_50k_rev_price' => $this->input->post('_50k_r1_price'),
                  '_100k_rev_price' => $this->input->post('_100k_r1_price'),
                  '_free_rev_price' => $this->input->post('_free_r1_price'),
                  //'company_id'=>$this->session->userdata['logged_in']['company_id']

                );

                $result_sales_quote_revision = $this->common_model->update_one_active_record_where('sales_quote_revision', $data, 'sales_quote_revision.quotation_no', $this->input->post('quotation_no'), 'sales_quote_revision.version_no', $this->input->post('version_no'), $this->session->userdata['logged_in']['company_id']);

                //$result_sales_quote_revision=$this->common_model->save('sales_quote_revision',$data); 

                //echo $this->db->last_query();                  

              }


              if ($result_sales_quote_revision) {
                $data['note'] = 'Data Updated Successfully';


                header("refresh:1;url=" . base_url() . "index.php/" . $this->router->fetch_class());

                //$data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));
                $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->uri->segment(3), 'sales_quote_revision.version_no', $this->uri->segment(4));

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());
                $dataa = array('process_id' => '3');
                $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);


                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');

                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/price-rev-form', $data);
                $this->load->view('Home/footer');
              } else {
                $data['error'] = 'Error while Updating data';
              }
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

  function price_revision()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->modify == 1) {

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

              $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

              //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


              $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
              $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
              $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
              $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
              $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
              $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
              $special_ink_data = array('ink_id' => '4', 'archive' => '0');
              $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

              $ink_data = array('ink_id' => '2', 'archive' => '0');
              $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
              $screen_data = array('ink_id' => '3', 'archive' => '0');
              $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
              $flexo_data = array('ink_id' => '1', 'archive' => '0');
              $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
              //echo $this->db->last_query();

              $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

              //----Shoulder
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

              $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

              $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

              $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' => '3');
              $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);


              // -----------------
              $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->uri->segment(3), 'sales_quote_revision.version_no', $this->uri->segment(4));

              // $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'sales_quote_master.quotation_no',$this->uri->segment(3));


              //echo $this->db->last_query();



              $customer_no = '';
              foreach ($data['sales_quote_master'] as $key => $row) {
                $customer_no = $row->customer_no;
              }

              $data_search = array('adr_category_id' => $customer_no, 'archive' => 0);
              $data['purchase_manager'] = $this->common_model->select_active_records_where('address_category_contact_details', $this->session->userdata['logged_in']['company_id'], $data_search);




              // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/price-rev-save-form', $data);
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


  public function approval()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->modify == 1) {

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

              $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

              //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


              $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
              $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
              $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
              $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
              $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
              $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
              $special_ink_data = array('ink_id' => '4', 'archive' => '0');
              $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

              $ink_data = array('ink_id' => '2', 'archive' => '0');
              $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
              $screen_data = array('ink_id' => '3', 'archive' => '0');
              $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
              $flexo_data = array('ink_id' => '1', 'archive' => '0');
              $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
              //echo $this->db->last_query();

              $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

              //----Shoulder
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

              $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

              $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

              $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' => '3');
              $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);


              // -----------------
              $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->uri->segment(3), 'sales_quote_master.version_no', $this->uri->segment(4));

              //echo $this->db->last_query();



              $customer_no = '';
              foreach ($data['sales_quote_master'] as $key => $row) {
                $customer_no = $row->customer_no;
              }

              $data_search = array('adr_category_id' => $customer_no, 'archive' => 0);
              $data['purchase_manager'] = $this->common_model->select_active_records_where('address_category_contact_details', $this->session->userdata['logged_in']['company_id'], $data_search);




              // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/approval-form', $data);
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

  function approval_update()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->modify == 1) {

              // Quote-----------------------------------

              $this->form_validation->set_rules('_5k_approved_contr', '5k HOD price', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_approved_contr', '10K HOD price', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_approved_contr', '25K HOD price', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_approved_contr', '50k HOD price', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_approved_contr', '100k HOD price', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_free_approved_contr', 'Free quantity HOD price', 'required|trim|xss_clean');

              if ($this->form_validation->run() == FALSE) {
                //echo('if');  

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

                $dataa = array('process_id' => '3');
                $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);

                $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->input->post('quotation_no'), 'sales_quote_master.version_no', $this->input->post('version_no'));
                //echo $this->db->last_query();  


                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/approval-form', $data);
                $this->load->view('Home/footer');
              } else {
                //echo('else');  

                $_5k_flag = ($this->input->post('_5k_flag') == '1' ? '1' : '0');
                $_10k_flag = ($this->input->post('_10k_flag') == '1' ? '1' : '0');
                $_25k_flag = ($this->input->post('_25k_flag') == '1' ? '1' : '0');
                $_50k_flag = ($this->input->post('_50k_flag') == '1' ? '1' : '0');
                $_100k_flag = ($this->input->post('_100k_flag') == '1' ? '1' : '0');
                $free_flag = ($this->input->post('free_flag') == '1' ? '1' : '0');

                $approval_data = array(

                  'job_changeover_time' => $this->input->post('job_changeover'),
                  '_5k_flag' => $_5k_flag,
                  '_5k_waste' => $this->input->post('_5k_waste'),
                  //'_5k_target_contr'=>$this->input->post('_5k_target_contr'),
                  '_5k_quoted_contr' => $this->input->post('_5k_quoted_contr'),
                  '_5k_cost' => $this->input->post('_5k_cost'),
                  '_5k_quoted_price' => $this->input->post('_5k_quoted_price'),

                  '_10k_flag' => $_10k_flag,
                  '_10k_waste' => $this->input->post('_10k_waste'),
                  //'_10k_target_contr'=>$this->input->post('_10k_target_contr'),
                  '_10k_quoted_contr' => $this->input->post('_10k_quoted_contr'),
                  '_10k_cost' => $this->input->post('_10k_cost'),
                  '_10k_quoted_price' => $this->input->post('_10k_quoted_price'),

                  '_25k_flag' => $_25k_flag,
                  '_25k_waste' => $this->input->post('_25k_waste'),
                  //'_25k_target_contr'=>$this->input->post('_25k_target_contr'),
                  '_25k_quoted_contr' => $this->input->post('_25k_quoted_contr'),
                  '_25k_cost' => $this->input->post('_25k_cost'),
                  '_25k_quoted_price' => $this->input->post('_25k_quoted_price'),

                  '_50k_flag' => $_50k_flag,
                  '_50k_waste' => $this->input->post('_50k_waste'),
                  //'_50k_target_contr'=>$this->input->post('_50k_target_contr'),
                  '_50k_quoted_contr' => $this->input->post('_50k_quoted_contr'),
                  '_50k_cost' => $this->input->post('_50k_cost'),
                  '_50k_quoted_price' => $this->input->post('_50k_quoted_price'),

                  '_100k_flag' => $_100k_flag,
                  '_100k_waste' => $this->input->post('_100k_waste'),
                  //'_100k_target_contr'=>$this->input->post('_100k_target_contr'),
                  '_100k_quoted_contr' => $this->input->post('_100k_quoted_contr'),
                  '_100k_cost' => $this->input->post('_100k_cost'),
                  '_100k_quoted_price' => $this->input->post('_100k_quoted_price'),

                  'free_flag' => $free_flag,
                  'free_quantity' => $this->input->post('free_quantity'),
                  '_free_quantity_waste' => $this->input->post('_free_quantity_waste'),
                  //'free_target_contr'=>$this->input->post('free_target_contr'),
                  'free_quoted_contr' => $this->input->post('free_quoted_contr'),
                  'free_cost' => $this->input->post('free_cost'),
                  'free_quoted_price' => $this->input->post('free_quoted_price'),

                  '_5k_approval_authority_contr' => $this->input->post('_5k_approved_contr'),
                  '_10k_approval_authority_contr' => $this->input->post('_10k_approved_contr'),
                  '_25k_approval_authority_contr' => $this->input->post('_25k_approved_contr'),
                  '_50k_approval_authority_contr' => $this->input->post('_50k_approved_contr'),
                  '_100k_approval_authority_contr' => $this->input->post('_100k_approved_contr'),
                  '_free_approval_authority_contr' => $this->input->post('_free_approved_contr'),

                );

                $result_update = $this->common_model->update_one_active_record_where('sales_quote_master', $approval_data, 'sales_quote_master.quotation_no', $this->input->post('quotation_no'), 'sales_quote_master.version_no', $this->input->post('version_no'), $this->session->userdata['logged_in']['company_id']);

                //echo $this->db->last_query();

                $data = array('status' => '99');
                $result = $this->common_model->update_one_active_record_where('followup', $data, 'record_no', $this->input->post('record_no'), 'transaction_no', $this->input->post('transaction_no'), $this->session->userdata['logged_in']['company_id']);
                // echo $this->db->last_query();

                $data = array('pending_flag' => '1', 'final_approval_flag' => '1', 'approval_date' => date('Y-m-d'), 'approved_by' => $this->session->userdata['logged_in']['user_id']);

                $result = $this->common_model->update_one_active_record_where('sales_quote_master', $data, 'sales_quote_master.quotation_no', $this->input->post('quotation_no'), 'sales_quote_master.version_no', $this->input->post('version_no'), $this->session->userdata['logged_in']['company_id']);

                // echo $this->input->post('quotation_no'); 
                // echo $this->db->last_query();


                $data['followup'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('followup', $this->session->userdata['logged_in']['company_id'], 'record_no', $this->input->post('record_no'));

                if ($data['followup'] == FALSE) {
                  $transaction_no = 1;
                  $status = 1;
                } else {
                  $i = 1;
                  foreach ($data['followup'] as $followup_row) {
                    $transaction_no = $followup_row->transaction_no;
                    $status = 1;
                    $contact_person_id = $followup_row->contact_person_id;
                    $i++;
                  }
                  $transaction_no = $i;
                }
                $data = array(
                  'company_id' => $this->session->userdata['logged_in']['company_id'],
                  'user_id' => $contact_person_id,
                  'form_id' => '91',
                  'transaction_no' => $transaction_no,
                  'status' => '999',
                  'followup_date' => date('Y-m-d'),
                  'approved_flag' => '1',
                  'approval_date' => date('Y-m-d'),
                  'contact_person_id' => $this->session->userdata['logged_in']['user_id'],
                  'record_no' => $this->input->post('record_no')
                );
                $result = $this->common_model->save('followup', $data);




                if ($result_update) {
                  $data['note'] = 'Data Updated Successfully';
                } else {
                  $data['error'] = 'Error while Updating data';
                }

                header("refresh:1;url=" . base_url() . "index.php/" . $this->router->fetch_class());

                $data['employee'] = $this->common_model->select_one_active_record('employee_master', $this->session->userdata['logged_in']['company_id'], 'employee_id', $this->session->userdata['logged_in']['user_id']);

                foreach ($data['employee'] as $employee_row) {
                  $config['protocol'] = 'smtp';
                  $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                  $config['smtp_port'] = 465;
                  $this->load->library('email', $config);
                  $this->email->from("auto.mailer@3d-neopac.com");
                  $this->email->to("vaibhav.singh@3d-neopac.com,soumen.nandan@3d-neopac.com,vishal.gupta@3d-neopac.com ,shailendra.singh@3d-neopac.com ,erp@3d-neopac.com");
                  $this->email->cc($employee_row->mailbox);
                  $this->email->subject("" . $this->input->post('quotation_no') . ' REV' . $this->input->post('version_no') . " is Approved");
                  $this->email->message("Dear Sales Team, The subjected Quote has been Approved");

                  if ($this->email->send()) {
                    $data['note'] = 'Approved Transaction Completed';
                  }
                }


                $data['followup_received'] = $this->sales_quote_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.user_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '91');
                $data['page_name'] = 'Followup';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());

                $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->input->post('quotation_no'), 'sales_quote_master.version_no', $this->input->post('version_no'));

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());
                $dataa = array('process_id' => '3');
                $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);


                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/approval-form', $data);
                $this->load->view('Home/footer');
              }
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

  function modify()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->modify == 1) {

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

              $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

              //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
              $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


              $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
              $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
              $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
              $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
              $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
              $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
              $special_ink_data = array('ink_id' => '4', 'archive' => '0');
              $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

              $ink_data = array('ink_id' => '2', 'archive' => '0');
              $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
              $screen_data = array('ink_id' => '3', 'archive' => '0');
              $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
              $flexo_data = array('ink_id' => '1', 'archive' => '0');
              $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
              //echo $this->db->last_query();

              $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

              //----Shoulder
              $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

              $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

              $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

              $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

              $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
              $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' => '3');
              $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);


              // -----------------
              $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->uri->segment(3), 'sales_quote_master.version_no', $this->uri->segment(4));

              //echo $this->db->last_query();

              $customer_no = '';
              foreach ($data['sales_quote_master'] as $key => $row) {
                $customer_no = $row->customer_no;
              }

              $data_search = array('adr_category_id' => $customer_no, 'archive' => 0);
              $data['purchase_manager'] = $this->common_model->select_active_records_where('address_category_contact_details', $this->session->userdata['logged_in']['company_id'], $data_search);

              // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/modify-form', $data);
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

  function update()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->modify == 1) {

              $this->form_validation->set_rules('id', 'ID', 'required|trim|xss_clean');

              //Information----------------------------

              $this->form_validation->set_rules('customer', 'Custommer ', 'required|trim|xss_clean|callback_customer_check');
              $this->form_validation->set_rules('pm_1', 'Purchase Manager 1', 'required|trim|xss_clean');
              $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim|xss_clean');
              $this->form_validation->set_rules('credit_days', 'Payment Terms', 'required|trim|xss_clean');
              $this->form_validation->set_rules('enquiry_date', 'Enquiry Date', 'required|trim|xss_clean');

              // Tube Specification-----------------------------              
              $this->form_validation->set_rules('sleeve_dia', 'Tube dia', 'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length', 'Tube length', 'required|trim|xss_clean');
              $this->form_validation->set_rules('layer', 'Layer', 'required|trim|xss_clean');


              $this->form_validation->set_rules('tube_color', 'Tube Color', 'required|xss_clean');
              $this->form_validation->set_rules('tube_lacquer', 'Tube lacquer', 'required|xss_clean');
              $this->form_validation->set_rules('print_type', 'Print Type', 'required|trim|xss_clean');
              $this->form_validation->set_rules('special_ink', 'Special ink', 'required|trim|xss_clean');

              // Shoulder Specification-----------------------------
              $this->form_validation->set_rules('shoulder', 'Shoulder', 'required|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice', 'Shoulder Oriface', 'xss_clean');
              $this->form_validation->set_rules('shoulder_color', 'Shoulder Color', 'required|xss_clean');

              // Cap Specification-----------------------------
              $this->form_validation->set_rules('cap_type', 'Cap type', 'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_finish', 'Cap Finish', 'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_dia', 'Cap Dia', 'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_orifice', 'Cap Orifice', 'xss_clean');
              $this->form_validation->set_rules('cap_color', 'Cap Color', 'required|xss_clean');

              // Decorative Elements -----------------------------
              $this->form_validation->set_rules('tube_foil', 'Tube foil', 'required|trim|xss_clean');
              //$this->form_validation->set_rules('shoulder_foil','Shoulder Foil' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_foil', 'Cap foil', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_metalization', 'Cap Metalization', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_shrink_sleeve', 'Cap shrink sleeve', 'required|trim|xss_clean');
              $this->form_validation->set_rules('label_price', 'Label Price', 'trim|xss_clean');

              // Quote-----------------------------------

              //$this->form_validation->set_rules('_5k_target_contr','5k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_quoted_contr', '5K Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_cost', '5K Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_5k_quoted_price', '5k Quoted Price', 'required|trim|xss_clean');


              ///$this->form_validation->set_rules('_10k_target_contr','10k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_quoted_contr', '10k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_cost', '10k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_quoted_price', '10k Quoted Price', 'required|trim|xss_clean');

              // $this->form_validation->set_rules('_25k_target_contr','25k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_quoted_contr', '25k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_cost', '25k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_quoted_price', '25K Quoted Price', 'required|trim|xss_clean');

              //$this->form_validation->set_rules('_50k_target_contr','50k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_quoted_contr', '50k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_cost', '50k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_quoted_price', '50K Quoted Price', 'required|trim|xss_clean');

              // $this->form_validation->set_rules('_100k_target_contr','100k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_quoted_contr', '100k Quoted contr.', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_cost', '100k Cost', 'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_quoted_price', '100k Quoted Price', 'required|trim|xss_clean');

              $this->form_validation->set_rules('freight', 'Freight', 'required|trim|xss_clean');



              // Cost sheet details------------------------------
              if (!empty($this->input->post('article_no'))) {
                $this->form_validation->set_rules('article_no', 'Article no', 'trim|xss_clean|callback_article_check');
              } else {
                $this->form_validation->set_rules('article_no', 'Article no', 'trim|xss_clean');
              }

              //$this->form_validation->set_rules('invoice_date','Costsheet date' ,'trim|xss_clean');
              $this->form_validation->set_rules('invoice_no', 'Invoice no', 'trim|xss_clean');
              //$this->form_validation->set_rules('cost','Cost' ,'trim|xss_clean');  

              $this->form_validation->set_rules('remarks', 'Remarks', 'trim|xss_clean');


              if ($this->form_validation->run() == FALSE) {

                $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->input->post('quotation_no'), 'sales_quote_master.version_no', $this->input->post('version_no'));

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

                $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

                //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();

                $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


                $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
                $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
                $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
                $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
                $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
                $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
                $special_ink_data = array('ink_id' => '4', 'archive' => '0');
                $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

                $ink_data = array('ink_id' => '2', 'archive' => '0');
                $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
                $screen_data = array('ink_id' => '3', 'archive' => '0');
                $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
                $flexo_data = array('ink_id' => '1', 'archive' => '0');
                $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
                //echo $this->db->last_query();

                $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

                //----Shoulder
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

                $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

                $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

                $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

                $dataa = array('process_id' => '3');
                $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);

                $customer_no = '';
                foreach ($data['sales_quote_master'] as $key => $row) {
                  $customer_no = $row->customer_no;
                }

                $data_search = array('customer_no' => $customer_no, 'archive' => 0);
                $data['purchase_manager'] = $this->common_model->select_active_records_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], $data_search);


                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/modify-form', $data);
                $this->load->view('Home/footer');
              } else {

                $customer_no = '';

                if (!empty($this->input->post('customer'))) {

                  $arr = explode("//", $this->input->post('customer'));
                  if (count($arr) >= 2) {
                    $customer_no = $arr[1];
                  }
                }
                $article_no = '';
                if (!empty($this->input->post('article_no'))) {

                  $arr1 = explode("//", $this->input->post('article_no'));
                  if (count($arr1) >= 2) {
                    $article_no = $arr1[1];
                  }
                }

                if (!empty($this->input->post('sleeve_dia'))) {
                  $sleeve_dia_array = explode("//", $this->input->post('sleeve_dia'));
                  $sleeve_dia = $sleeve_dia_array[1];
                } else {
                  $sleeve_dia = "";
                }

                if (!empty($this->input->post('shoulder'))) {
                  $shoulder_array = explode("//", $this->input->post('shoulder'));
                  $shoulder = $shoulder_array[1];
                } else {
                  $shoulder = "";
                }

                if (!empty($this->input->post('shoulder_orifice'))) {
                  $shoulder_orifice_array = explode("//", $this->input->post('shoulder_orifice'));
                  $shoulder_orifice = $shoulder_orifice_array[1];
                } else {
                  $shoulder_orifice = "";
                }

                //-------CAP explode//
                if (!empty($this->input->post('cap_type'))) {
                  $cap_type_array = explode("//", $this->input->post('cap_type'));
                  $cap_type = $cap_type_array[1];
                } else {
                  $cap_type = "";
                }

                if (!empty($this->input->post('cap_finish'))) {
                  $cap_finish_array = explode("//", $this->input->post('cap_finish'));
                  $cap_finish = $cap_finish_array[1];
                } else {
                  $cap_finish = "";
                }

                if (!empty($this->input->post('cap_dia'))) {
                  $cap_dia_array = explode("//", $this->input->post('cap_dia'));
                  $cap_dia = $cap_dia_array[1];
                } else {
                  $cap_dia = "";
                }

                if (!empty($this->input->post('cap_orifice'))) {
                  $cap_orifice_array = explode("//", $this->input->post('cap_orifice'));
                  $cap_orifice = $cap_orifice_array[1];
                } else {
                  $cap_orifice = "";
                }

                if (!empty($this->input->post('tube_color'))) {
                  $tube_color_aray = explode("//", $this->input->post('tube_color'));
                  $tube_color = $tube_color_aray[0];
                } else {
                  $tube_color = "";
                }

                if (!empty($this->input->post('shoulder_color'))) {
                  $shoulder_color_array = explode("//", $this->input->post('shoulder_color'));
                  $shoulder_color = $shoulder_color_array[0];
                } else {
                  $shoulder_color = "";
                }

                if (!empty($this->input->post('cap_color'))) {
                  $cap_color_array = explode("//", $this->input->post('cap_color'));
                  $cap_color = $cap_color_array[0];
                } else {
                  $cap_color = "";
                }

                if ($this->input->post('cap_metalization') == 'YES') {
                  $cap_metalization = "YES";
                } else {
                  $cap_metalization = "NO";
                }

                if ($this->input->post('cap_foil') == 'YES') {
                  $cap_foil = "YES";
                } else {
                  $cap_foil = "NO";
                }

                $_5k_flag = ($this->input->post('_5k_flag') == '1' ? '1' : '0');
                $_10k_flag = ($this->input->post('_10k_flag') == '1' ? '1' : '0');
                $_25k_flag = ($this->input->post('_25k_flag') == '1' ? '1' : '0');
                $_50k_flag = ($this->input->post('_50k_flag') == '1' ? '1' : '0');
                $_100k_flag = ($this->input->post('_100k_flag') == '1' ? '1' : '0');
                $free_flag = ($this->input->post('free_flag') == '1' ? '1' : '0');

                // File Upload----------------------------------  

                $filename = $this->input->post('quotation_no') . "_" . time() . "_" . preg_replace('/[^A-Za-z0-9.-]/ ', '', $_FILES['userfile']['name']);
                //echo $_FILES['userfile']['name']; 

                $config['upload_path'] = './assets/' . $this->session->userdata['logged_in']['company_id'] . '/sales_quote_ref/';
                $config['encrypt_name '] = TRUE;
                $config['allowed_types'] = 'pdf|PDF';
                $config['max_size'] = '0';
                $config['remove_spaces'] = TRUE;
                $config['file_name'] = $filename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('userfile')) {
                  //echo '1';
                  $data = $this->upload->data();
                  //$filename=time()."_".$data['file_name'];
                } else {
                  // echo '2';
                  $filename = $this->input->post('sales_files');

                  $data['error'] = $this->upload->display_errors();
                }


                $data = array(

                  'customer_no' => $customer_no,
                  'pm_1' => $this->input->post('pm_1'),
                  'product_name' => $this->input->post('product_name'),
                  'images' => $filename,
                  'credit_days' => $this->input->post('credit_days'),
                  'enquiry_date' => $this->input->post('enquiry_date'),

                  // specification
                  'layer' => $this->input->post('layer'),
                  'sleeve_dia' => $sleeve_dia,
                  'sleeve_length' => $this->input->post('sleeve_length'),
                  'tube_color' => $tube_color,
                  'tube_lacquer' => $this->input->post('tube_lacquer'),
                  'print_type' => $this->input->post('print_type'),
                  'special_ink' => $this->input->post('special_ink'),

                  'shoulder' => $shoulder,
                  'shoulder_orifice' => $shoulder_orifice,
                  'shoulder_color' => $shoulder_color,

                  'cap_type' => $cap_type,
                  'cap_finish' => $cap_finish,
                  'cap_dia' => $cap_dia,
                  'cap_orifice' => $cap_orifice,
                  'cap_color' => $cap_color,

                  'tube_foil' => $this->input->post('tube_foil'),
                  'shoulder_foil' => $this->input->post('shoulder_foil'),
                  'cap_foil' => $cap_foil,
                  'cap_foil_width' => $this->input->post('cap_foil_width'),
                  'cap_foil_dist_frm_bottom' => $this->input->post('cap_foil_dist_frm_bottom'),

                  'cap_metalization' => $cap_metalization,
                  'cap_metalization_color' => $this->input->post('cap_metalization_color'),
                  'cap_metalization_finish' => $this->input->post('cap_metalization_finish'),
                  'cap_shrink_sleeve' => $this->input->post('cap_shrink_sleeve'),


                  //Quote
                  'machine_print_type_id' => $this->input->post('machine_type'),
                  'job_changeover_time' => $this->input->post('job_changeover'),

                  '_5k_flag' => $_5k_flag,
                  '_5k_waste' => $this->input->post('_5k_waste'),
                  //'_5k_target_contr'=>$this->input->post('_5k_target_contr'),
                  '_5k_quoted_contr' => $this->input->post('_5k_quoted_contr'),
                  '_5k_cost' => $this->input->post('_5k_cost'),
                  '_5k_quoted_price' => $this->input->post('_5k_quoted_price'),

                  '_10k_flag' => $_10k_flag,
                  '_10k_waste' => $this->input->post('_10k_waste'),
                  // '_10k_target_contr'=>$this->input->post('_10k_target_contr'),
                  '_10k_quoted_contr' => $this->input->post('_10k_quoted_contr'),
                  '_10k_cost' => $this->input->post('_10k_cost'),
                  '_10k_quoted_price' => $this->input->post('_10k_quoted_price'),

                  '_25k_flag' => $_25k_flag,
                  '_25k_waste' => $this->input->post('_25k_waste'),
                  //'_25k_target_contr'=>$this->input->post('_25k_target_contr'),
                  '_25k_quoted_contr' => $this->input->post('_25k_quoted_contr'),
                  '_25k_cost' => $this->input->post('_25k_cost'),
                  '_25k_quoted_price' => $this->input->post('_25k_quoted_price'),

                  '_50k_flag' => $_50k_flag,
                  '_50k_waste' => $this->input->post('_50k_waste'),
                  //'_50k_target_contr'=>$this->input->post('_50k_target_contr'),
                  '_50k_quoted_contr' => $this->input->post('_50k_quoted_contr'),
                  '_50k_cost' => $this->input->post('_50k_cost'),
                  '_50k_quoted_price' => $this->input->post('_50k_quoted_price'),

                  '_100k_flag' => $_100k_flag,
                  '_100k_waste' => $this->input->post('_100k_waste'),
                  //'_100k_target_contr'=>$this->input->post('_100k_target_contr'),
                  '_100k_quoted_contr' => $this->input->post('_100k_quoted_contr'),
                  '_100k_cost' => $this->input->post('_100k_cost'),
                  '_100k_quoted_price' => $this->input->post('_100k_quoted_price'),

                  'free_flag' => $free_flag,
                  'free_quantity' => $this->input->post('free_quantity'),
                  '_free_quantity_waste' => $this->input->post('_free_quantity_waste'),
                  //'free_target_contr'=>$this->input->post('free_target_contr'),
                  'free_quoted_contr' => $this->input->post('free_quoted_contr'),
                  'free_cost' => $this->input->post('free_cost'),
                  'free_quoted_price' => $this->input->post('free_quoted_price'),

                  'freight' => $this->input->post('freight'),

                  //Customer Price Range
                  //Cost sheet details
                  //'article_no'=>$article_no,
                  //'invoice_date'=>$this->input->post('invoice_date'),
                  //'cost'=>$this->input->post('cost'),
                  'invoice_no' => $this->input->post('invoice_no'),
                  'remarks' => $this->input->post('remarks'),
                  'user_id' => $this->session->userdata['logged_in']['user_id']
                );

                $result_update = $this->common_model->update_one_active_record_where('sales_quote_master', $data, 'quotation_no', $this->input->post('quotation_no'), 'version_no', $this->input->post('version_no'), $this->session->userdata['logged_in']['company_id']);

                //echo $this->db->last_query();

                if ($result_update) {

                  $data = array(
                    'sleeve_per_cost' => $this->input->post('sleeve_cost_view'),
                    'lacquer_1' => $this->input->post('lacquer_type_1'),
                    'lacquer1_rate' => $this->input->post('lacquer_type_1_rate'),
                    'lacquer1_gm_per_tube' => $this->input->post('lacquer_type_1_gm_per_tube'),
                    'lacquer1_perc' => $this->input->post('lacquer_type_1_percentage'),
                    'lacquer_2' => $this->input->post('lacquer_type_2'),
                    'lacquer2_rate' => $this->input->post('lacquer_type_2_rate'),
                    'lacquer2_gm_per_tube' => $this->input->post('lacquer_type_2_gm_per_tube'),
                    'lacquer2_perc' => $this->input->post('lacquer_type_2_percentage'),
                    'lacquer_rejection' => $this->input->post('lacquer_rejection'),
                    'lacquer_cost_per_tube' => $this->input->post('lacquer_cost_view'),
                    //----------print type------
                    'label_rejection' => $this->input->post('label_rejection'),
                    'label_rate' => $this->input->post('label_rate'),
                    'label_cost_per_tube' => $this->input->post('label_cost_view'),
                    'screen_rm_month' => $this->input->post('screen_rm_month'),
                    'screen_rate' => $this->input->post('screen_rate'),
                    'screen_gm_per_tube' => $this->input->post('screen_gm_per_tube'),
                    'screen_flexo_rejection' => $this->input->post('screen_flexo_rejection'),
                    'screen_percentage' => $this->input->post('screen_percentage'),
                    'flexo_rm_month' => $this->input->post('flexo_rm_month'),
                    'flexo_rate' => $this->input->post('flexo_rate'),
                    'flexo_gm_per_tube' => $this->input->post('flexo_gm_per_tube'),
                    'flexo_percentage' => $this->input->post('flexo_percentage'),
                    'screen_flexo_cost_per_tube' => $this->input->post('screen_flexo_cost_view'),

                    'spring_consumable_view' => $this->input->post('spring_consumable_view'),
                    'screen_flexo_consumable_view' => $this->input->post('screen_flexo_consumable_view'),
                    //----------screen flexo plate------
                    'screen_film_rate' => $this->input->post('screen_film_rate'),
                    'screen_colors' => $this->input->post('screen_colors'),
                    'screen_impresssion' => $this->input->post('screen_impresssion'),
                    'screen_sets' => $this->input->post('screen_sets'),
                    'screen_film_cost_per_tube' => $this->input->post('screen_plate_cost_view'),
                    'flexo_plate_rate' => $this->input->post('flexo_plate_rate'),
                    'flexo_colors' => $this->input->post('flexo_colors'),
                    'flexo_impresssion' => $this->input->post('flexo_impresssion'),
                    'flexo_sets' => $this->input->post('flexo_sets'),
                    'flexo_plate_cost_per_tube' => $this->input->post('flexo_plate_cost_view'),
                    //----------offset plate------
                    'offset_rm_month' => $this->input->post('offset_rm_month'),
                    'offset_rate' => $this->input->post('offset_rate'),
                    'offset_gm_per_tube' => $this->input->post('offset_gm_per_tube'),
                    'offset_rejection' => $this->input->post('offset_rejection'),
                    'offset_percentage' => $this->input->post('offset_percentage'),
                    'offset_cost_per_tube' => $this->input->post('offset_cost_view'),
                    'offset_consumable_view' => $this->input->post('offset_consumable_view'),

                    'offset_plate_cost' => $this->input->post('offset_plate_cost'),
                    'offset_color' => $this->input->post('offset_color'),
                    'offset_impresssion' => $this->input->post('offset_impresssion'),
                    'offset_sets' => $this->input->post('offset_sets'),
                    'offset_plate_cost_per_tube ' => $this->input->post('offset_plate_cost_view'),

                    //----------special ink------
                    'special_rm_month' => $this->input->post('special_rm_month'),
                    'special_ink_rate' => $this->input->post('special_ink_rate'),
                    'special_gm_per_tube' => $this->input->post('special_gm_per_tube'),
                    'special_percentage' => $this->input->post('special_percentage'),
                    'specialink_rejection' => $this->input->post('specialink_rejection'),
                    'special_ink_cost_per_tube' => $this->input->post('special_ink_cost_view'),
                    //----------shoulder------
                    'sh_hdpe_one' => $this->input->post('sh_hdpe_one'),
                    'sh_hdpe_one_rate' => $this->input->post('sh_hdpe_one_rate'),
                    'hdpe_m' => $this->input->post('hdpe_m'),
                    'sh_hdpe_two' => $this->input->post('sh_hdpe_two'),
                    'sh_hdpe_two_rate' => $this->input->post('sh_hdpe_two_rate'),
                    'hdpe_f' => $this->input->post('hdpe_f'),
                    'shoulder_mb' => $this->input->post('shoulder_mb'),
                    'shoulder_mb_rate' => $this->input->post('shoulder_mb_rate'),
                    'shoulder_mb_percentage' => $this->input->post('shoulder_mb_percentage'),
                    'shoulder_mb1' => $this->input->post('shoulder_mb1'),
                    'shoulder_mb1_rate' => $this->input->post('shoulder_mb1_rate'),
                    'shoulder_mb_percentage1' => $this->input->post('shoulder_mb_percentage1'),
                    'sh_rejection' => $this->input->post('sh_rejection'),
                    'sh_quantity' => $this->input->post('sh_quantity'),
                    'shoulder_cost' => $this->input->post('shoulder_cost_view'),
                    //----------cap------
                    'mould_type' => $this->input->post('mould_type'),
                    'cap_weight_rate' => $this->input->post('cap_weight_rate'),
                    'runner_waste' => $this->input->post('runner_waste'),
                    'pp_price' => $this->input->post('pp_price'),
                    'mb_price' => $this->input->post('mb_price'),
                    'mb_loading' => $this->input->post('mb_loading'),
                    'moulding_cost' => $this->input->post('moulding_cost'),
                    'cap_rejection' => $this->input->post('cap_rejection'),
                    'cap_cost_per_tube' => $this->input->post('cap_cost_view'),
                    //----------packing box--- 
                    'top_box' => $this->input->post('top_box'),
                    'bottom_box' => $this->input->post('bottom_box'),
                    'box_liners' => $this->input->post('box_liners'),
                    'liner_gm' => $this->input->post('liner_gm'),
                    'top_box_rate' => $this->input->post('top_box_rate'),
                    'bottom_box_rate' => $this->input->post('bottom_box_rate'),
                    'box_liners_rate' => $this->input->post('box_liners_rate'),
                    'total_box_rate' => $this->input->post('packing_box_view'),
                    'liner_gm_per_tube' => $this->input->post('liners_view'),
                    //-------------Tube foil--------
                    'hot_foil_1' => $this->input->post('hot_foil_1'),
                    'hot_foil_1_rate' => $this->input->post('hot_foil_1_rate'),
                    'hot_foil_1_percentage' => $this->input->post('hot_foil_1_percentage'),
                    'hot_foil_2' => $this->input->post('hot_foil_2'),
                    'hot_foil_2_rate' => $this->input->post('hot_foil_2_rate'),
                    'hot_foil_2_percentage' => $this->input->post('hot_foil_2_percentage'),
                    'tube_foil_rejection' => $this->input->post('tube_foil_rejection'),
                    'tube_foil_cost_per_tube' => $this->input->post('tube_foil_cost_view'),
                    //-------------Shoulder foil---------
                    'shoulder_foil_tag' => $this->input->post('shoulder_foil_tag'),
                    'shoulder_foil_rate' => $this->input->post('shoulder_foil_rate'),
                    'shoulder_foil_sqm_per_tube' => $this->input->post('shoulder_foil_sqm_per_tube'),
                    'shoulder_foil_cost_per_tube' => $this->input->post('shoulder_foil_cost_view'),
                    //-------------shrink Sleeve---------
                    'cap_shrink_sleeve_code' => $this->input->post('cap_shrink_sleeve_code'),
                    'cap_shrink_sleeve_rate' => $this->input->post('cap_shrink_sleeve_rate'),
                    'cap_shrink_sleeve_cost_per_tube' => $this->input->post('cap_shrink_sleeve_cost_view'),
                    'cap_metalization_rate' => $this->input->post('cap_metalization_rate'),
                    'cap_metalization_cost_view' => $this->input->post('cap_metalization_cost_view'),
                    'cap_foil_rate' => $this->input->post('cap_foil_rate'),
                    'cap_foil_cost_view' => $this->input->post('cap_foil_cost_view'),
                    //-----------Stores and Spares
                    'stores_spares_local_view' => $this->input->post('stores_spares_local_view'),
                    'stores_spares_import_view' => $this->input->post('stores_spares_import_view'),
                    'export_packing' => $this->input->post('customer_flag'),
                    'hygenic_consumable_view' => $this->input->post('hygenic_consumable_view'),
                    'packing_shrink_flim' => $this->input->post('packing_shrink_flim'),
                    'other_consumable_view' => $this->input->post('other_consumable_view'),
                    'packing_corrugated_sheet' => $this->input->post('packing_corrugated_sheet'),
                    'packing_bopp_tape' => $this->input->post('packing_bopp_tape'),
                    'packing_stickers' => $this->input->post('packing_stickers'),
                    'other_packing_material' => $this->input->post('other_packing_material'),
                    'total_rm_cost_per_tube' => $this->input->post('total_rm_cost_per_tube'),
                    'total_consummable_cost_per_tube' => $this->input->post('total_consummable_cost_per_tube'),
                    'total_packing_cost_per_tube' => $this->input->post('total_packing_cost_per_tube'),
                    'total_stores_cost_per_tube' => $this->input->post('total_stores_cost_per_tube'),
                    'total_cost_per_tube' => $this->input->post('total_cost_per_tube'),
                    'waste_total_cost_per_tube' => $this->input->post('waste_total_cost_per_tube'),

                  );

                  $result_update_quote_details = $this->common_model->update_one_active_record_where('sales_quote_details', $data, 'quotation_no', $this->input->post('quotation_no'), 'version_no', $this->input->post('version_no'), $this->session->userdata['logged_in']['company_id']);

                  //echo $this->db->last_query();

                }

                $data = array('archive' => 1);

                $result_details = $this->common_model->update_one_active_record_where('sales_quote_sleeve_details', $data, 'quotation_no', $this->input->post('quotation_no'), 'version_no', $this->input->post('version_no'), $this->session->userdata['logged_in']['company_id']);

                if ($this->input->post('layer') == 1) {

                  for ($i = 1; $i <= $this->input->post('layer_1_rows'); $i++) {
                    //echo $i;
                    //echo"</br>";

                    $sleeve_details = array(

                      'quotation_no' => $this->input->post('quotation_no'),
                      'version_no' => $this->input->post('version_no'),
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('micron'),
                      //'rm'=>$this->input->post('layer_1_rm_'.$i.''),
                      'rm_code' => $this->input->post('layer_1_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_1_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_1_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer1_rejection'),
                      'quantity' => $this->input->post('quantity'),
                      'sleeve_per_cost' => $this->input->post('sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    //$result_update_quote_sleeve_details=$this->common_model->update_one_active_record_where('sales_quote_sleeve_details',$sleeve_details,'quotation_no',$this->input->post('quotation_no'),'sqsd_id',$this->input->post('layer_1_sqsd_'.$i.''),$this->session->userdata['logged_in']['company_id']);

                    $result_update_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);

                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 2) {

                  for ($i = 1; $i <= $this->input->post('layer_2_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $this->input->post('quotation_no'),
                      'version_no' => $this->input->post('version_no'),
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_2_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_2_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_2_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_2_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_2_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer2_rejection'),
                      'quantity' => $this->input->post('layer2_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer2_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    //$result_update_quote_sleeve_details=$this->common_model->update_one_active_record_where('sales_quote_sleeve_details',$sleeve_details,'quotation_no',$this->input->post('quotation_no'),'sqsd_id',$this->input->post('layer_2_sqsd_'.$i.''),$this->session->userdata['logged_in']['company_id']);

                    $result_update_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 3) {

                  for ($i = 1; $i <= $this->input->post('layer_3_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $this->input->post('quotation_no'),
                      'version_no' => $this->input->post('version_no'),
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_3_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_3_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_3_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_3_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_3_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer3_rejection'),
                      'quantity' => $this->input->post('layer3_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer3_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    // $result_update_quote_sleeve_details=$this->common_model->update_one_active_record_where('sales_quote_sleeve_details',$sleeve_details,'quotation_no',$this->input->post('quotation_no'),'sqsd_id',$this->input->post('layer_3_sqsd_'.$i.''),$this->session->userdata['logged_in']['company_id']);

                    $result_update_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 5) {

                  for ($i = 1; $i <= $this->input->post('layer_5_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $this->input->post('quotation_no'),
                      'version_no' => $this->input->post('version_no'),
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_5_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_5_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_5_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_5_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_5_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer5_rejection'),
                      'quantity' => $this->input->post('layer5_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer5_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    //$result_update_quote_sleeve_details=$this->common_model->update_one_active_record_where('sales_quote_sleeve_details',$sleeve_details,'quotation_no',$this->input->post('quotation_no'),'sqsd_id',$this->input->post('layer_5_sqsd_'.$i.''),$this->session->userdata['logged_in']['company_id']);

                    $result_update_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }

                if ($this->input->post('layer') == 7) {

                  for ($i = 1; $i <= $this->input->post('layer_7_rows'); $i++) {


                    $sleeve_details = array(
                      'quotation_no' => $this->input->post('quotation_no'),
                      'version_no' => $this->input->post('version_no'),
                      'layer' => $this->input->post('layer'),
                      'micron' => $this->input->post('layer_7_layer_' . $i . '_micron'),
                      'rm' => $this->input->post('layer_7_rm_' . $i . ''),
                      'rm_code' => $this->input->post('layer_7_rm_' . $i . '_code'),
                      'rm_rate' => $this->input->post('layer_7_rm_' . $i . '_rate'),
                      'rm_percentage' => $this->input->post('layer_7_rm_' . $i . '_percentage'),
                      'rejection' => $this->input->post('layer7_rejection'),
                      'quantity' => $this->input->post('layer7_quantity'),
                      'sleeve_per_cost' => $this->input->post('layer7_sleeve_cost'),
                      'company_id' => $this->session->userdata['logged_in']['company_id']

                    );
                    // $result_update_quote_sleeve_details=$this->common_model->update_one_active_record_where('sales_quote_sleeve_details',$sleeve_details,'quotation_no',$this->input->post('quotation_no'),'sqsd_id',$this->input->post('layer_7_sqsd_'.$i.''),$this->session->userdata['logged_in']['company_id']); 

                    $result_update_quote_sleeve_details = $this->common_model->save('sales_quote_sleeve_details', $sleeve_details);
                    //echo $this->db->last_query();
                  }
                }




                if (!empty($this->input->post('approval_authority'))) {

                  $data = array('pending_flag' => '1');

                  $result = $this->common_model->update_one_active_record_where('sales_quote_master', $data, 'quotation_no', $this->input->post('quotation_no'), 'version_no', $this->input->post('version_no'), $this->session->userdata['logged_in']['company_id']);

                  $data['followup'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('followup', $this->session->userdata['logged_in']['company_id'], 'record_no', $this->input->post('record_no'));
                  if ($data['followup'] == FALSE) {
                    $transaction_no = 1;
                    $status = 1;
                  } else {
                    $i = 1;
                    foreach ($data['followup'] as $followup_row) {

                      $transaction_no = $followup_row->transaction_no;
                      $status = 1;
                      $i++;
                    }
                    $transaction_no = $i;
                  }

                  $data = array(
                    'company_id' => $this->session->userdata['logged_in']['company_id'],
                    'user_id' => $this->input->post('approval_authority'),
                    'form_id' => '91',
                    'transaction_no' => $transaction_no,
                    'status' => $status,
                    'followup_date' => date('Y-m-d'),
                    'contact_person_id' => $this->session->userdata['logged_in']['user_id'],
                    'record_no' => $this->input->post('record_no')
                  );

                  $result = $this->common_model->save('followup', $data);

                  /*

                      $data['approval_employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->input->post('approval_authority'));
                      $approval_email="";
                      if($data['approval_employee']==FALSE){
                        $approval_email="";
                      }else{
                        foreach($data['approval_employee'] as $employee_approval_row) {
                          $approval_email=$employee_approval_row->mailbox;
                        }
                      }


                      $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->session->userdata['logged_in']['user_id']);
                        if($data['employee']==FALSE){

                        }else{

                          foreach($data['employee'] as $employee_row) {
                                  $config['protocol'] = 'smtp';
                                  $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                                  $config['smtp_port'] = 465;
                                  $this->load->library('email', $config);
                                  $this->email->from("auto.mailer@3d-neopac.com");
                                  $this->email->to($approval_email);
                                  $this->email->cc("".$employee_row->mailbox.",erp@3d-neopac.com");
                                  $this->email->subject("".$this->input->post('order_no')." is Sent For Approval");
                                  $this->email->message("
                                    Followup Link
                                    http://localhost:19282/erp/index.php/Sales_order_followup/");

                                  if ($this->email->send()) {
                                    $data['note']='Mail Sent';
                                  } 
                                }

                        }*/
                }


                if ($result_update) {
                  $data['note'] = 'Data Updated Successfully';
                } else {
                  $data['error'] = 'Error while Updating data';
                }

                header("refresh:1;url=" . base_url() . "index.php/" . $this->router->fetch_class());

                $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'id', $this->input->post('id'));

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

                $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

                //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();

                $data['tube_color'] = $this->common_model->select_active_drop_down('color_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);
                $data['packing_box'] = $this->article_model->spec_all_active_record_search('article', '41', $this->session->userdata['logged_in']['company_id']);


                $data['ldpe'] = $this->article_model->spec_active_record_search('article', '7', $this->session->userdata['logged_in']['company_id']);
                $data['lldpe'] = $this->article_model->spec_active_record_search('article', '8', $this->session->userdata['logged_in']['company_id']);
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);
                $data['admer'] = $this->article_model->spec_active_record_search('article', '15', $this->session->userdata['logged_in']['company_id']);
                $data['evoh'] = $this->article_model->spec_active_record_search('article', '16', $this->session->userdata['logged_in']['company_id']);
                $data['masterbatch'] = $this->article_model->spec_all_active_record_search('article', '12', $this->session->userdata['logged_in']['company_id']);
                $data['lacquer'] = $this->article_model->spec_all_active_record_search('article', '14', $this->session->userdata['logged_in']['company_id']);
                $special_ink_data = array('ink_id' => '4', 'archive' => '0');
                $data['special_ink'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $special_ink_data, 'apply_from_date desc', '1', '0');

                $ink_data = array('ink_id' => '2', 'archive' => '0');
                $data['offset'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
                $screen_data = array('ink_id' => '3', 'archive' => '0');
                $data['screen'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $screen_data, 'apply_from_date desc', '1', '0');
                $flexo_data = array('ink_id' => '1', 'archive' => '0');
                $data['flexo'] = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $flexo_data, 'apply_from_date desc', '1', '0');
                //echo $this->db->last_query();

                $data['workprocedure_types_master'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '1');

                //----Shoulder
                $data['hdpe'] = $this->article_model->spec_active_record_search('article', '6', $this->session->userdata['logged_in']['company_id']);

                $data['workprocedure'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '7');

                $data['workprocedure_label'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '5');

                $data['workprocedure_printing'] = $this->process_model->select_one_active_record('workprocedure_types_master', $this->session->userdata['logged_in']['company_id'], 'workprocedure_types_master.work_proc_type_id', '3');

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');
                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cold_foil'] = $this->article_model->spec_all_active_record_search('article', '304', $this->session->userdata['logged_in']['company_id']);

                $data['hot_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_foil'] = $this->article_model->spec_all_active_record_search('article', '71', $this->session->userdata['logged_in']['company_id']);
                $data['cap_shrink_sleeve'] = $this->article_model->spec_all_active_record_search('article', '213', $this->session->userdata['logged_in']['company_id']);

                $dataa = array('process_id' => '3');
                $data['machine_type'] = $this->common_model->select_active_records_where('coex_machine_master', $this->session->userdata['logged_in']['company_id'], $dataa);

                $customer_no = '';
                foreach ($data['sales_quote_master'] as $key => $row) {
                  $customer_no = $row->customer_no;
                }

                $data_search = array('customer_no' => $customer_no, 'archive' => 0);
                $data['purchase_manager'] = $this->common_model->select_active_records_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], $data_search);



                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/modify-form', $data);
                $this->load->view('Home/footer');
              }
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

  function delete($id)
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->delete == 1) {

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

              $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);

              $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');

              $update_data = array('archive' => '1');
              $result = $this->common_model->update_one_active_record('sales_quote_master', $update_data, 'id', $id, $this->session->userdata['logged_in']['company_id']);

              $data['sales_quote_master'] = $this->sales_quote_model->select_one_inactive_record('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'id', $id);

              $customer_no = '';
              foreach ($data['sales_quote_master'] as $key => $row) {
                $customer_no = $row->customer_no;
              }

              $data_search = array('customer_no' => $customer_no, 'archive' => 0);
              $data['purchase_manager'] = $this->common_model->select_active_records_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], $data_search);


              $data['note'] = 'Archive Transaction completed';
              header("refresh:1;url=" . base_url() . "index.php/" . $this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
              $this->load->view(ucwords($this->router->fetch_class()) . '/modify-form', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No Archive rights Thanks';
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
      $data['note'] = 'No Archive rights Thanks';
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

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());
          //print_r( $data['formrights']);

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->delete == 1) {

              $table = 'sales_quote_master';
              include('pagination_archive.php');
              $data['sales_quote_master'] = $this->sales_quote_model->select_archive_records($config["per_page"], $this->uri->segment(3), $table, $this->session->userdata['logged_in']['company_id']);
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
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

  function dearchive($id)
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->delete == 1) {

              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

              $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);

              $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');


              $update_data = array('archive' => '0');
              $result = $this->common_model->update_one_active_record('sales_quote_master', $update_data, 'id', $id, $this->session->userdata['logged_in']['company_id']);



              $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'id', $id);

              $customer_no = '';
              foreach ($data['sales_quote_master'] as $key => $row) {
                $customer_no = $row->customer_no;
              }

              $data_search = array('customer_no' => $customer_no, 'archive' => 0);
              $data['purchase_manager'] = $this->common_model->select_active_records_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], $data_search);

              $data['note'] = 'Dearchive Transaction completed';
              header("refresh:1;url=" . base_url() . "index.php/" . $this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
              $this->load->view(ucwords($this->router->fetch_class()) . '/modify-form', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No Archive rights Thanks';
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
      $data['note'] = 'No Archive rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }


  function search()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {


              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

              $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

              $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);

              $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);

              $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);

              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');

              $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);


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

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {

              $this->form_validation->set_rules('from_date', 'From Date', 'trim|xss_clean|exact_length[10]');
              $this->form_validation->set_rules('to_date', 'To Date', 'trim|xss_clean|exact_length[10]');
              $this->form_validation->set_rules('customer_category', 'Custommer ', 'trim|xss_clean');
              $this->form_validation->set_rules('pm_1', 'Purchase Manager 1', 'trim|xss_clean');
              $this->form_validation->set_rules('quotation_no', 'Quotation no', 'trim|xss_clean');
              $this->form_validation->set_rules('product_name', 'Product Name', 'trim|xss_clean');
              $this->form_validation->set_rules('credit_days', 'Credit Days', 'trim|xss_clean');

              // Tube Specification-----------------------------              
              $this->form_validation->set_rules('layer', 'Layer', 'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_dia', 'Sleeve dia', 'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length', 'Sleeve length', 'trim|xss_clean');
              $this->form_validation->set_rules('tube_color', 'Tube Color', 'xss_clean');
              $this->form_validation->set_rules('tube_lacquer', 'Tube lacquer', 'xss_clean');
              $this->form_validation->set_rules('print_type', 'Print Type', 'trim|xss_clean');
              $this->form_validation->set_rules('special_ink', 'Special ink', 'trim|xss_clean');

              // Shoulder Specification-----------------------------
              $this->form_validation->set_rules('shoulder', 'Shoulder', 'xss_clean');
              $this->form_validation->set_rules('shoulder_orifice', 'Shoulder Oriface', 'xss_clean');
              $this->form_validation->set_rules('shoulder_color', 'Shoulder Color', 'xss_clean');

              // Cap Specification-----------------------------
              $this->form_validation->set_rules('cap_type', 'Cap type', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_finish', 'Cap Finish', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_dia', 'Cap Dia', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_orifice', 'Cap Orifice', 'xss_clean');
              $this->form_validation->set_rules('cap_color', 'Cap Color', 'xss_clean');

              // Decorative Elements -----------------------------
              $this->form_validation->set_rules('tube_foil', 'Tube foil', 'trim|xss_clean');
              $this->form_validation->set_rules('shoulder_foil', 'Shoulder Foil', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_foil', 'Cap foil', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_metalization', 'Cap Metalization', 'trim|xss_clean');
              $this->form_validation->set_rules('cap_shrink_sleeve', 'Cap shrink sleeve', 'trim|xss_clean');
              $this->form_validation->set_rules('label_price', 'Label Price', 'trim|xss_clean');

              // Quote-----------------------------------

              $this->form_validation->set_rules('less_than_10k_target_contr', '<10k Target contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_quoted_contr', '<10k Quoted contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_cost', '<10k Cost', 'trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_freight', '<10k Freight', 'trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_packing', '<10k Packing', 'trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_quoted_price', '<10k Quoted Price', 'trim|xss_clean');

              $this->form_validation->set_rules('_10k_to_25k_target_contr', '10k - 25K Target contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_quoted_contr', '10k - 25K Quoted contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_cost', '10k - 25K Cost', 'trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_freight', '10k - 25K Freight', 'trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_packing', '10k - 25K Packing', 'trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_quoted_price', '10k - 25K Quoted Price', 'trim|xss_clean');

              $this->form_validation->set_rules('_25k_to_50k_target_contr', '25k - 50K Target contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_quoted_contr', '25k - 50K Quoted contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_cost', '25k - 50K Cost', 'trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_freight', '25k - 50K Freight', 'trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_packing', '25k - 50K Packing', 'trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_quoted_price', '25K - 50K Quoted Price', 'trim|xss_clean');

              $this->form_validation->set_rules('_50k_to_100k_target_contr', '50k - 100K Target contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_quoted_contr', '50k - 100K Quoted contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_cost', '50k - 100K Cost', 'trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_freight', '50k - 100K Freight', 'trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_packing', '50k - 100K Packing', 'trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_quoted_price', '50K - 100K Quoted Price', 'trim|xss_clean');

              $this->form_validation->set_rules('_100k_to_250k_target_contr', '100k - 250K Target contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_quoted_contr', '100k - 250K Quoted contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_cost', '100k - 250K Cost', 'trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_freight', '100k - 250K Freight', 'trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_packing', '100k - 250K Packing', 'trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_quoted_price', '100k - 250K Quoted Price', 'trim|xss_clean');

              $this->form_validation->set_rules('greater_than_250k_target_contr', '>250k Target contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_quoted_contr', '>250k Quoted contr.', 'trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_cost', '>250k Cost', 'trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_freight', '>250k Freight', 'trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_packing', '>250k Packing', 'trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_quoted_price', '>250k Quoted Price', 'trim|xss_clean');



              // Cost sheet details------------------------------

              $this->form_validation->set_rules('article_no', 'Article no', 'trim|xss_clean');
              $this->form_validation->set_rules('invoice_date', 'Costsheet date', 'trim|xss_clean');
              $this->form_validation->set_rules('invoice_no', 'Invoice no', 'trim|xss_clean');
              $this->form_validation->set_rules('cost', 'Cost', 'trim|xss_clean');

              if ($this->form_validation->run() == FALSE) {

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

                $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

                $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);

                $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');

                $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);
                $this->load->view('Home/footer');
              } else {

                $customer_no = '';

                if (!empty($this->input->post('customer_category'))) {

                  $arr = explode("//", $this->input->post('customer_category'));
                  if (count($arr) >= 2) {
                    $customer_no = $arr[1];
                  }
                }
                $article_no = '';
                if (!empty($this->input->post('article_no'))) {

                  $arr1 = explode("//", $this->input->post('article_no'));
                  if (count($arr1) >= 2) {
                    $article_no = $arr1[1];
                  }
                }

                if (!empty($this->input->post('sleeve_dia'))) {
                  $sleeve_dia_array = explode("//", $this->input->post('sleeve_dia'));
                  $sleeve_dia = $sleeve_dia_array[1];
                } else {
                  $sleeve_dia = "";
                }

                if (!empty($this->input->post('shoulder'))) {
                  $shoulder_array = explode("//", $this->input->post('shoulder'));
                  $shoulder = $shoulder_array[1];
                } else {
                  $shoulder = "";
                }

                if (!empty($this->input->post('shoulder_orifice'))) {
                  $shoulder_orifice_array = explode("//", $this->input->post('shoulder_orifice'));
                  $shoulder_orifice = $shoulder_orifice_array[1];
                } else {
                  $shoulder_orifice = "";
                }

                //-------CAP explode//
                if (!empty($this->input->post('cap_type'))) {
                  $cap_type_array = explode("//", $this->input->post('cap_type'));
                  $cap_type = $cap_type_array[1];
                } else {
                  $cap_type = "";
                }

                if (!empty($this->input->post('cap_finish'))) {
                  $cap_finish_array = explode("//", $this->input->post('cap_finish'));
                  $cap_finish = $cap_finish_array[1];
                } else {
                  $cap_finish = "";
                }

                if (!empty($this->input->post('cap_dia'))) {
                  $cap_dia_array = explode("//", $this->input->post('cap_dia'));
                  $cap_dia = $cap_dia_array[1];
                } else {
                  $cap_dia = "";
                }

                if (!empty($this->input->post('cap_orifice'))) {
                  $cap_orifice_array = explode("//", $this->input->post('cap_orifice'));
                  $cap_orifice = $cap_orifice_array[1];
                } else {
                  $cap_orifice = "";
                }

                if (!empty($this->input->post('tube_color'))) {
                  $tube_color_aray = explode("//", $this->input->post('tube_color'));
                  $tube_color = $tube_color_aray[0];
                } else {
                  $tube_color = "";
                }

                if (!empty($this->input->post('shoulder_color'))) {
                  $shoulder_color_array = explode("//", $this->input->post('shoulder_color'));
                  $shoulder_color = $shoulder_color_array[0];
                } else {
                  $shoulder_color = "";
                }

                if (!empty($this->input->post('cap_color'))) {
                  $cap_color_array = explode("//", $this->input->post('cap_color'));
                  $cap_color = $cap_color_array[0];
                } else {
                  $cap_color = "";
                }

                $data = array(
                  'quotation_no' => $this->input->post('quotation_no'),
                  'customer_no' => $customer_no,
                  'pm_1' => $this->input->post('pm_1'),
                  'product_name' => $this->input->post('product_name'),
                  'credit_days' => $this->input->post('credit_days'),

                  // specification
                  'layer' => $this->input->post('layer'),
                  'sleeve_dia' => $sleeve_dia,
                  'sleeve_length' => $this->input->post('sleeve_length'),
                  'tube_color' => $tube_color,
                  'tube_lacquer' => $this->input->post('tube_lacquer'),
                  'print_type' => $this->input->post('print_type'),
                  'special_ink' => $this->input->post('special_ink'),

                  'shoulder' => $shoulder,
                  'shoulder_orifice' => $shoulder_orifice,
                  'shoulder_color' => $shoulder_color,

                  'cap_type' => $cap_type,
                  'cap_finish' => $cap_finish,
                  'cap_dia' => $cap_dia,
                  'cap_orifice' => $cap_orifice,
                  'cap_color' => $cap_color,

                  'tube_foil' => $this->input->post('tube_foil'),
                  'shoulder_foil' => $this->input->post('shoulder_foil'),
                  'cap_foil' => $this->input->post('cap_foil'),
                  'cap_metalization' => $this->input->post('cap_metalization'),
                  'cap_shrink_sleeve' => $this->input->post('cap_shrink_sleeve'),
                  'label_price' => $this->input->post('label_price'),

                  //Quote
                  'less_than_10k_target_contr' => $this->input->post('less_than_10k_target_contr'),
                  'less_than_10k_quoted_contr' => $this->input->post('less_than_10k_quoted_contr'),
                  'less_than_10k_cost' => $this->input->post('less_than_10k_cost'),
                  'less_than_10k_freight' => $this->input->post('less_than_10k_freight'),
                  'less_than_10k_packing' => $this->input->post('less_than_10k_packing'),
                  'less_than_10k_quoted_price' => $this->input->post('less_than_10k_quoted_price'),

                  '_10k_to_25k_target_contr' => $this->input->post('_10k_to_25k_target_contr'),
                  '_10k_to_25k_quoted_contr' => $this->input->post('_10k_to_25k_quoted_contr'),
                  '_10k_to_25k_cost' => $this->input->post('_10k_to_25k_cost'),
                  '_10k_to_25k_freight' => $this->input->post('_10k_to_25k_freight'),
                  '_10k_to_25k_packing' => $this->input->post('_10k_to_25k_packing'),
                  '_10k_to_25k_quoted_price' => $this->input->post('_10k_to_25k_quoted_price'),

                  '_25k_to_50k_target_contr' => $this->input->post('_25k_to_50k_target_contr'),
                  '_25k_to_50k_quoted_contr' => $this->input->post('_25k_to_50k_quoted_contr'),
                  '_25k_to_50k_cost' => $this->input->post('_25k_to_50k_cost'),
                  '_25k_to_50k_freight' => $this->input->post('_25k_to_50k_freight'),
                  '_25k_to_50k_packing' => $this->input->post('_25k_to_50k_packing'),
                  '_25k_to_50k_quoted_price' => $this->input->post('_25k_to_50k_quoted_price'),

                  '_50k_to_100k_target_contr' => $this->input->post('_50k_to_100k_target_contr'),
                  '_50k_to_100k_quoted_contr' => $this->input->post('_50k_to_100k_quoted_contr'),
                  '_50k_to_100k_cost' => $this->input->post('_50k_to_100k_cost'),
                  '_50k_to_100k_freight' => $this->input->post('_50k_to_100k_freight'),
                  '_50k_to_100k_packing' => $this->input->post('_50k_to_100k_packing'),
                  '_50k_to_100k_quoted_price' => $this->input->post('_50k_to_100k_quoted_price'),

                  '_100k_to_250k_target_contr' => $this->input->post('_100k_to_250k_target_contr'),
                  '_100k_to_250k_quoted_contr' => $this->input->post('_100k_to_250k_quoted_contr'),
                  '_100k_to_250k_cost' => $this->input->post('_100k_to_250k_cost'),
                  '_100k_to_250k_freight' => $this->input->post('_100k_to_250k_freight'),
                  '_100k_to_250k_packing' => $this->input->post('_100k_to_250k_packing'),
                  '_100k_to_250k_quoted_price' => $this->input->post('_100k_to_250k_quoted_price'),

                  'greater_than_250k_target_contr' => $this->input->post('greater_than_250k_target_contr'),
                  'greater_than_250k_quoted_contr' => $this->input->post('greater_than_250k_quoted_contr'),
                  'greater_than_250k_cost' => $this->input->post('greater_than_250k_cost'),
                  'greater_than_250k_freight' => $this->input->post('greater_than_250k_freight'),
                  'greater_than_250k_packing' => $this->input->post('greater_than_250k_packing'),
                  'greater_than_250k_quoted_price' => $this->input->post('greater_than_250k_quoted_price'),


                  //Cost sheet details
                  'article_no' => $article_no,
                  'invoice_date' => $this->input->post('invoice_date'),
                  'invoice_no' => $this->input->post('invoice_no'),
                  'cost' => $this->input->post('cost'),
                  'remarks' => $this->input->post('remarks'),

                );

                $data_search = array_filter($data);

                $data['sales_quote_master'] = $this->sales_quote_model->active_record_search('sales_quote_master', $this->session->userdata['logged_in']['company_id'], $data_search, $this->input->post('from_date'), $this->input->post('to_date'));
                //echo $this->db->last_query();            

                $data['page_name'] = 'Sales';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

                $data['sleeve_dia'] = $this->common_model->select_active_drop_down('sleeve_diameter_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types'] = $this->common_model->select_active_drop_down('shoulder_types_master', $this->session->userdata['logged_in']['company_id']);

                $data['shoulder_orifice'] = $this->common_model->select_active_drop_down('shoulder_orifice_master', $this->session->userdata['logged_in']['company_id']);

                $data['print_type'] = $this->common_model->select_active_distinct_drop_down('lacquer_types_master', 'print_type', $this->session->userdata['logged_in']['company_id']);

                $data['cap_type'] = $this->common_model->select_active_drop_down('cap_types_master', $this->session->userdata['logged_in']['company_id']);
                $data['cap_finish'] = $this->common_model->select_active_drop_down('cap_finish_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_dia'] = $this->common_model->select_active_drop_down('cap_diameter_master', $this->session->userdata['logged_in']['company_id']);

                $data['cap_orifice'] = $this->common_model->select_active_drop_down('cap_orifice_master', $this->session->userdata['logged_in']['company_id']);

                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '91');

                $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);


                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/search-form', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-records', $data);
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

  public function article_check($str)
  {

    if (!empty($str)) {
      $item_code = explode('//', $str);
      if (!empty($item_code[1])) {
        $data['item'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info', $this->session->userdata['logged_in']['company_id'], 'article_no', $item_code[1]);
        //echo $this->db->last_query();

        foreach ($data['item'] as $item_row) {

          if ($item_row->article_no == $item_code[1]) {
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

  function customer_check($str)
  {

    if (!empty($str)) {
      $customer_code = explode('//', $str);
      if (!empty($customer_code[1])) {
        $data = array(
          'adr_category_id' => $customer_code[1],
          'category_name' => $customer_code[0]
        );
        $data['customer'] = $this->common_model->select_active_records_where('address_category_master', $this->session->userdata['logged_in']['company_id'], $data);
        //echo $this->db->last_query();
        foreach ($data['customer'] as $customer_row) {

          if ($customer_row->adr_category_id == $customer_code[1]) {
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

  function download()
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {
              header("Content-Type: application/octet-stream");

              $file = "http://192.168.0.33/erp/index.php/sales_quote/view/" . $this->uri->segment(3) . ".pdf";

              header("Content-Disposition: attachment; filename=" . urlencode($file));
              header("Content-Type: application/download");
              header("Content-Description: File Transfer");
              header("Content-Length: " . filesize($file));

              flush(); // This doesn't really matter.

              $fp = fopen($file, "r");
              while (!feof($fp)) {
                echo fread($fp, 65536);
                flush(); // This is essential for large downloads
              }

              fclose($fp);
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

  function view($quotation_no)
  {

    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Sales') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 1, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {


              $data['company'] = $this->common_model->select_one_active_record('company_master', $this->session->userdata['logged_in']['company_id'], 'company_id', $this->session->userdata['logged_in']['company_id']);

              $data['company_details'] = $this->common_model->select_one_active_record('company_system_parameters', $this->session->userdata['logged_in']['company_id'], 'company_id', $this->session->userdata['logged_in']['company_id']);


              // $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'sales_quote_master.quotation_no',$quotation_no);
              $data['sales_quote_master'] = $this->sales_quote_model->select_one_active_record_where('sales_quote_master', $this->session->userdata['logged_in']['company_id'], 'sales_quote_master.quotation_no', $this->uri->segment(3), 'sales_quote_revision.version_no', $this->uri->segment(4));

              // echo $this->uri->segment(3);
              // echo $this->db->last_query();

              //$this->load->view('Home/header');
              //$this->load->view('Home/nav',$data);
              //$this->load->view('Home/subnav');
              $this->load->view('Print/header', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/view-form', $data);
              //$this->load->view('Home/footer');
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
}
