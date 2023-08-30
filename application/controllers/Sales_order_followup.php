<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales_order_followup extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_in')) {
      $this->load->model('common_model');
      $this->load->model('sales_order_followup_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('customer_model');
      $this->load->model('relate_model');
      $this->load->model('country_model');
      $this->load->model('customer_model');
      $this->load->model('tax_grid_model');
    } else {
      redirect('login', 'refresh');
    }
  }

  function index()
  {
    $data['page_name'] = 'Followup';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Followup') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->view == 1) {
              $table = 'followup';
              $data['followup_received'] = $this->sales_order_followup_model->select_followup_received_records($table, $this->session->userdata['logged_in']['company_id'], 'followup.user_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');

              $data['followup_sent'] = $this->sales_order_followup_model->select_followup_received_records($table, $this->session->userdata['logged_in']['company_id'], 'followup.contact_person_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
              $this->db->last_query();

              $data['page_name'] = 'Followup';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/received-records', $data);
              $data = array('followup.status' => '999', 'followup.approved_flag' => '2', 'followup.form_id' => '75', 'followup.user_id' => $this->session->userdata['logged_in']['user_id']);
              $order_by = array('followup.transaction_no' => 'desc');

              $data['followup_rejected'] = $this->sales_order_followup_model->select_followup_rejected_records($table, $this->session->userdata['logged_in']['company_id'], $data, $order_by);
              $this->load->view(ucwords($this->router->fetch_class()) . '/rejected-records', $data);
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


  function approved()
  {
    $data['page_name'] = 'Followup';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Followup') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {

              $for_stock = '';

              $tally_sales_order_master_result = $this->common_model->select_one_details_record_noncompany('tally_sales_order_master', 'order_no', $this->uri->segment(3));

              //$order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$this->uri->segment(3));

              // foreach ($order_master_result as $key => $order_master_row) {
              //   $for_stock=$order_master_row->for_stock;
              // }

              // CHECKING RECORDS IN TALLY TABLE  AND IF NO STOCK SO THEN ALLOWED---13-May-2021

              if (count($tally_sales_order_master_result) == 0) {

                $data = array('status' => '99');
                $result = $this->common_model->update_one_active_record_where('followup', $data, 'record_no', $this->uri->segment(3), 'transaction_no', $this->uri->segment(4), $this->session->userdata['logged_in']['company_id']);

                $data = array('final_approval_flag' => '1', 'approval_date' => date('Y-m-d'), 'approved_by' => $this->session->userdata['logged_in']['user_id']);

                $result = $this->common_model->update_one_active_record('order_master', $data, 'order_no', $this->uri->segment(3), $this->session->userdata['logged_in']['company_id']);

                //Sql Integration For tally 05-Apr-2019---------------------------



                $order_no = $this->uri->segment(3);
                $order_date = '';
                $sales_ledger = '';
                $bill_to = '';
                $ship_to = '';
                $po_no = '';
                $part_no = '';
                $order_quantity = '';
                $currency = '';
                $rate_of_exchange = '';
                $unit_rate = '';
                $net_amount = '';


                $data['order_master_details'] = $this->sales_order_book_model->select_one_active_record_for_tally_sql('order_master', $this->session->userdata['logged_in']['company_id'], 'order_master.order_no', $order_no);

                //print_r($data['order_master']);
                foreach ($data['order_master_details'] as $row) {

                  //Sales Ledger Types-------------


                  if ($row->for_export == '1') {

                    if ($row->customer_no == '1255' || $row->customer_no == '1231') {
                      $sales_ledger = 'Sales - Exports Inter company';
                    } else {
                      $sales_ledger = 'Sales - Exports';
                    }
                  } else {

                    if ($row->zip_code == 'DN') {
                      $sales_ledger = 'Sales - Local';
                    } else if ($row->party_type == 'SEZ') {
                      $sales_ledger = 'Sales - Deemed Exports';
                    } else {
                      $sales_ledger = 'Sales - Interstate';
                    }
                  }

                  //Consignee Details--------
                  if ($row->consin_adr_company_id != '') {
                    $arr_consignee = explode("|", $row->consin_adr_company_id);

                    $data['ship_to'] = $this->customer_model->select_one_active_record("address_master", $this->session->userdata['logged_in']['company_id'], 'address_master.adr_company_id', $arr_consignee[0]);
                    foreach ($data['ship_to'] as $ship_to_row) {
                      $ship_to = $ship_to_row->name1;
                    }
                  } else {
                    $ship_to = $row->name1;
                  }
                  $order_date = $row->order_date;
                  $bill_to = $row->name1;
                  $po_no = $row->cust_order_no . ',' . $row->cust_order_date;
                  $part_no = $row->article_no;

                  if ($row->for_export == '1') {
                    $unit_rate = $row->calc_sell_price;
                    $net_amount = $this->common_model->read_number($row->total_order_quantity, $this->session->userdata['logged_in']['company_id']) * $row->calc_sell_price;
                  } else {

                    $unit_rate = $this->common_model->read_number($row->selling_price, $this->session->userdata['logged_in']['company_id']);
                    $net_amount = $this->common_model->read_number($row->total_order_quantity, $this->session->userdata['logged_in']['company_id']) * $this->common_model->read_number($row->selling_price, $this->session->userdata['logged_in']['company_id']);
                  }

                  $order_quantity = $this->common_model->read_number($row->total_order_quantity, $this->session->userdata['logged_in']['company_id']);
                  $currency = $row->currency_id;
                  $rate_of_exchange = $this->common_model->read_number($row->exchange_rate, $this->session->userdata['logged_in']['company_id']);

                  // Stock So is not sending to Tally ---------------13-May-2021
                  if ($row->for_stock == 0) {

                    $data_tally = array(
                      'order_date' => $order_date,
                      'order_no' => $order_no,
                      'sales_ledger' => $sales_ledger,
                      'bill_to' => $bill_to,
                      'ship_to' => $ship_to,
                      'po_no' => $po_no,
                      'part_no' => $part_no,
                      'order_quantity' => $order_quantity,
                      'currency' => $currency,
                      'rate_of_exchange' => $rate_of_exchange,
                      'unit_rate' => $unit_rate,
                      'net_amount' => $net_amount,
                      'transaction_date' => date('Y-m-d')
                    );

                    $result = $this->common_model->save('tally_sales_order_master', $data_tally);
                  }
                }


                //-----------------------------------------------------------------------------------------

                $data['followup'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('followup', $this->session->userdata['logged_in']['company_id'], 'record_no', $this->uri->segment(3));

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
                  'form_id' => '75',
                  'transaction_no' => $transaction_no,
                  'status' => '999',
                  'followup_date' => date('Y-m-d'),
                  'approved_flag' => '1',
                  'approval_date' => date('Y-m-d'),
                  'contact_person_id' => $this->session->userdata['logged_in']['user_id'],
                  'record_no' => $this->uri->segment(3),
                );
                $result = $this->common_model->save('followup', $data);
                $data['note'] = 'Approval Transaction Completed';
                // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                $data['followup_received'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.user_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
                $data['followup_sent'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.contact_person_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
                $data['page_name'] = 'Followup';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());
                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/received-records', $data);
                $this->load->view('Home/footer');
              } else {

                $data['note'] = 'transaction already approved';
                // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                $data['followup_received'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.user_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
                $data['followup_sent'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.contact_person_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
                $data['page_name'] = 'Followup';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());
                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/received-records', $data);
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



  function approved_a()
  {
    $data['page_name'] = 'Followup';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Followup') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {


              $tally_sales_order_master_result = $this->common_model->select_one_details_record_noncompany('tally_sales_order_master', 'order_no', $this->input->post('order_no'));

              // CHECKING RECORDS IN TALLY TABLE
              if (count($tally_sales_order_master_result) == 0) {


                $data = array('status' => '99');
                $result = $this->common_model->update_one_active_record_where('followup', $data, 'record_no', $this->input->post('order_no'), 'transaction_no', $this->input->post('transaction_no'), $this->session->userdata['logged_in']['company_id']);

                $data = array('final_approval_flag' => '1', 'approval_date' => date('Y-m-d'), 'approved_by' => $this->session->userdata['logged_in']['user_id']);

                $result = $this->common_model->update_one_active_record('order_master', $data, 'order_no', $this->input->post('order_no'), $this->session->userdata['logged_in']['company_id']);

                //Sql Integration For tally 05-Apr-2019---------------------------



                $order_no = $this->input->post('order_no');
                $order_date = '';
                $sales_ledger = '';
                $bill_to = '';
                $ship_to = '';
                $po_no = '';
                $part_no = '';
                $order_quantity = '';
                $currency = '';
                $rate_of_exchange = '';
                $unit_rate = '';
                $net_amount = '';


                $data['order_master_details'] = $this->sales_order_book_model->select_one_active_record_for_tally_sql('order_master', $this->session->userdata['logged_in']['company_id'], 'order_master.order_no', $order_no);

                //print_r($data['order_master']);
                foreach ($data['order_master_details'] as $row) {

                  //Sales Ledger Types-------------


                  if ($row->for_export == '1') {

                    if ($row->customer_no == '1255' || $row->customer_no == '1231') {
                      $sales_ledger = 'Sales - Exports Inter company';
                    } else {
                      $sales_ledger = 'Sales - Exports';
                    }
                  } else {

                    if ($row->zip_code == 'DN') {
                      $sales_ledger = 'Sales - Local';
                    } else if ($row->party_type == 'SEZ') {
                      $sales_ledger = 'Sales - Deemed Exports';
                    } else {
                      $sales_ledger = 'Sales - Interstate';
                    }
                  }

                  //Consignee Details--------
                  if ($row->consin_adr_company_id != '') {
                    $arr_consignee = explode("|", $row->consin_adr_company_id);

                    $data['ship_to'] = $this->customer_model->select_one_active_record("address_master", $this->session->userdata['logged_in']['company_id'], 'address_master.adr_company_id', $arr_consignee[0]);
                    foreach ($data['ship_to'] as $ship_to_row) {
                      $ship_to = $ship_to_row->name1;
                    }
                  } else {
                    $ship_to = $row->name1;
                  }
                  $order_date = $row->order_date;
                  $bill_to = $row->name1;

                  if ($row->cust_product_no != '') {
                    $po_no = $row->cust_order_no . ',' . $row->cust_order_date . ' (' . $row->cust_product_no . ')';
                  } else {
                    $po_no = $row->cust_order_no . ',' . $row->cust_order_date;
                  }

                  $part_no = $row->article_no;

                  if ($row->for_export == '1') {
                    $unit_rate = $row->calc_sell_price;
                    $net_amount = $this->common_model->read_number($row->total_order_quantity, $this->session->userdata['logged_in']['company_id']) * $row->calc_sell_price;
                  } else {

                    $unit_rate = $this->common_model->read_number($row->selling_price, $this->session->userdata['logged_in']['company_id']);
                    $net_amount = $this->common_model->read_number($row->total_order_quantity, $this->session->userdata['logged_in']['company_id']) * $this->common_model->read_number($row->selling_price, $this->session->userdata['logged_in']['company_id']);
                  }

                  $order_quantity = $this->common_model->read_number($row->total_order_quantity, $this->session->userdata['logged_in']['company_id']);
                  $currency = $row->currency_id;
                  $rate_of_exchange = $this->common_model->read_number($row->exchange_rate, $this->session->userdata['logged_in']['company_id']);

                  $data_tally = array(
                    'order_date' => $order_date,
                    'order_no' => $order_no,
                    'sales_ledger' => $sales_ledger,
                    'bill_to' => $bill_to,
                    'ship_to' => $ship_to,
                    'po_no' => $po_no,
                    'part_no' => $part_no,
                    'order_quantity' => $order_quantity,
                    'currency' => $currency,
                    'rate_of_exchange' => $rate_of_exchange,
                    'unit_rate' => $unit_rate,
                    'net_amount' => $net_amount,
                    'transaction_date' => date('Y-m-d')
                  );

                  $result = $this->common_model->save('tally_sales_order_master', $data_tally);
                }


                //-----------------------------------------------------------------------------------------

                $data['followup'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('followup', $this->session->userdata['logged_in']['company_id'], 'record_no', $this->input->post('order_no'));

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
                  'form_id' => '75',
                  'transaction_no' => $transaction_no,
                  'status' => '999',
                  'followup_date' => date('Y-m-d'),
                  'approved_flag' => '1',
                  'approval_date' => date('Y-m-d'),
                  'contact_person_id' => $this->session->userdata['logged_in']['user_id'],
                  'record_no' => $this->input->post('order_no'),
                  'remark' => $this->input->post('remark')
                );
                $result = $this->common_model->save('followup', $data);


                $data['approval_employee'] = $this->common_model->select_one_active_record('employee_master', $this->session->userdata['logged_in']['company_id'], 'employee_id', $this->session->userdata['logged_in']['user_id']);
                $approval_email = "";
                if ($data['approval_employee'] == FALSE) {
                  $approval_email = "";
                } else {
                  foreach ($data['approval_employee'] as $employee_approval_row) {
                    $approval_email = $employee_approval_row->mailbox;
                  }
                }


                $data['employee'] = $this->common_model->select_one_active_record('employee_master', $this->session->userdata['logged_in']['company_id'], 'employee_id', $contact_person_id);
                if ($data['employee'] == FALSE) {
                } else {

                  foreach ($data['employee'] as $employee_row) {
                    $config['protocol'] = 'smtp';
                    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                    $config['smtp_port'] = 465;
                    $this->load->library('email', $config);
                    $this->email->from("auto.mailer@3d-neopac.com");
                    $this->email->to($employee_row->mailbox);

                    $this->email->cc($approval_email);

                    $this->email->subject("" . $this->input->post('order_no') . " is Approved");

                    $this->email->message("" . $this->input->post('remark') . "");

                    if ($this->email->send()) {
                      $data['note'] = 'Mail Sent';
                    }
                  }
                }



                $data['note'] = 'Approval Transaction Completed';
                // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                $data['followup_received'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.user_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
                $data['followup_sent'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.contact_person_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
                $data['page_name'] = 'Followup';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());
                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/received-records', $data);
                $this->load->view('Home/footer');
              } else {

                $data['note'] = 'transaction already approved';
                // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                $data['followup_received'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.user_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
                $data['followup_sent'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.contact_person_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
                $data['page_name'] = 'Followup';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());
                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/received-records', $data);
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


  function approval()
  {
    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {

        if ($module_row->module_name === 'Followup') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {
              $data = array('order_no' => $this->uri->segment(3));
              $data['order'] = $this->sales_order_book_model->active_details_records('order_master', $data, $this->session->userdata['logged_in']['company_id']);

              $customer_no = '';
              foreach ($data['order'] as $order_row) {
                $customer_no = $order_row->customer_no;
              }

              $data['ship_to'] = $this->relate_model->select_one_active_record('adr_relate_companies', $this->session->userdata['logged_in']['company_id'], 'adr_relate_companies.adr_company_id', $customer_no, $this->session->userdata['logged_in']['language_id']);

              //$this->db->last_query();

              $data['order_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('order_details', $this->session->userdata['logged_in']['company_id'], 'order_no', $this->uri->segment(3));

              $data['customer'] = $this->customer_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'address_details.master_property_id', '1');

              $data['country'] = $this->country_model->select_active_drop_down('country_master');
              $data['tax_grid'] = $this->tax_grid_model->select_sales_tax_active_drop_down('tax_grid_master', $this->session->userdata['logged_in']['company_id']);
              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '75');
              $data['payment_term'] = $this->customer_model->select_active_payment_term_drop_down('payment_condition_master', $this->session->userdata['logged_in']['language_id']);
              $data['freight_type'] = $this->common_model->select_active_drop_down_noncompany_withlanguage('freight_type_master_lang', $this->session->userdata['logged_in']['language_id']);

              $data['followup'] = $this->common_model->select_followup_records('followup', $this->session->userdata['logged_in']['company_id'], 'record_no', $this->uri->segment(3));


              $data['page_name'] = 'Sales';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());
              //$data['note']='No Modify rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
              $this->load->view(ucwords($this->router->fetch_class()) . '/modify-approval-form', $data);
              $this->load->view('Home/footer');
            } else {
              $data['note'] = 'No Approval rights Thanks';
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
      $data['note'] = 'No Approval rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }


  function reject()
  {
    $data['page_name'] = 'Sales';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {

        if ($module_row->module_name === 'Followup') {

          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {
              $data = array('order_no' => $this->uri->segment(3));
              $data['order'] = $this->sales_order_book_model->select_one_active_record('order_master', $this->session->userdata['logged_in']['company_id'], 'order_master.order_no', $this->uri->segment(3));
              $customer_no = '';
              foreach ($data['order'] as $order_row) {
                $customer_no = $order_row->customer_no;
              }

              $data['ship_to'] = $this->relate_model->select_one_active_record('adr_relate_companies', $this->session->userdata['logged_in']['company_id'], 'adr_relate_companies.adr_company_id', $customer_no, $this->session->userdata['logged_in']['language_id']);

              //$this->db->last_query();

              $data['order_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('order_details', $this->session->userdata['logged_in']['company_id'], 'order_no', $this->uri->segment(3));
              $this->load->model('tax_grid_model');
              $data['tax_master'] = $this->tax_grid_model->select_sales_order_tax_grid($this->uri->segment(3));

              $data['customer'] = $this->customer_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'address_details.master_property_id', '1');
              $data['country'] = $this->country_model->select_active_drop_down('country_master');
              $data['tax_grid'] = $this->tax_grid_model->select_sales_tax_active_drop_down('tax_grid_master', $this->session->userdata['logged_in']['company_id']);
              $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '75');
              $data['payment_term'] = $this->customer_model->select_active_payment_term_drop_down('payment_condition_master', $this->session->userdata['logged_in']['language_id']);
              $data['freight_type'] = $this->common_model->select_active_drop_down_noncompany_withlanguage('freight_type_master_lang', $this->session->userdata['logged_in']['language_id']);

              $data['followup'] = $this->common_model->select_followup_records('followup', $this->session->userdata['logged_in']['company_id'], 'record_no', $this->uri->segment(3));


              $data['page_name'] = 'Followup';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());
              //$data['note']='No Modify rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
              $this->load->view(ucwords($this->router->fetch_class()) . '/modify-reject-form', $data);
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
      $data['note'] = 'No Approval rights Thanks';
      $data['page_name'] = 'home';
      $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav', $data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title', $data);
      $this->load->view('Home/footer');
    }
  }



  function notapproved()
  {
    $data['page_name'] = 'Followup';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Followup') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {

              $data = array('status' => '99');
              $result = $this->common_model->update_one_active_record_where('followup', $data, 'record_no', $this->uri->segment(3), 'transaction_no', $this->uri->segment(4), $this->session->userdata['logged_in']['company_id']);

              $data = array('pending_flag' => '0');

              $result = $this->common_model->update_one_active_record('order_master', $data, 'order_no', $this->uri->segment(3), $this->session->userdata['logged_in']['company_id']);

              $data['followup'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('followup', $this->session->userdata['logged_in']['company_id'], 'record_no', $this->uri->segment(3));

              if ($data['followup'] == FALSE) {
                $transaction_no = 1;
                $status = 1;
              } else {
                $i = 1;
                foreach ($data['followup'] as $followup_row) {
                  $transaction_no = $followup_row->transaction_no;
                  $status = 1;
                  $i++;
                  $contact_person_id = $followup_row->contact_person_id;
                }
                $transaction_no = $i;
              }
              $data = array(
                'company_id' => $this->session->userdata['logged_in']['company_id'],
                'user_id' => $contact_person_id,
                'form_id' => '75',
                'transaction_no' => $transaction_no,
                'status' => '999',
                'followup_date' => date('Y-m-d'),
                'approved_flag' => '2',
                'approval_date' => date('Y-m-d'),
                'contact_person_id' => $this->session->userdata['logged_in']['user_id'],
                'record_no' => $this->uri->segment(3)
              );
              $result = $this->common_model->save('followup', $data);

              $data['note'] = 'Rejected Transaction Completed';
              header("refresh:1;url=" . base_url() . "index.php/" . $this->router->fetch_class());
              $data['followup_received'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.user_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
              $data['page_name'] = 'Followup';
              $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
              $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());
              $this->load->view('Home/header');
              $this->load->view('Home/nav', $data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
              $this->load->view(ucwords($this->router->fetch_class()) . '/received-records', $data);
              $this->load->view('Home/footer');
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


  function notapproved_a()
  {
    $data['page_name'] = 'Followup';
    $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
    if ($data['module'] != FALSE) {
      foreach ($data['module'] as $module_row) {
        if ($module_row->module_name === 'Followup') {
          $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if ($formrights_row->new == 1) {

              $this->form_validation->set_rules('remark', 'Disapprove Remark', 'required|trim|xss_clean');
              if ($this->form_validation->run() == FALSE) {


                $data = array('order_no' => $this->input->post('order_no'));
                $data['order'] = $this->sales_order_book_model->select_one_active_record('order_master', $this->session->userdata['logged_in']['company_id'], 'order_master.order_no', $this->input->post('order_no'));

                $customer_no = '';
                foreach ($data['order'] as $order_row) {
                  $customer_no = $order_row->customer_no;
                }

                $data['ship_to'] = $this->relate_model->select_one_active_record('adr_relate_companies', $this->session->userdata['logged_in']['company_id'], 'adr_relate_companies.adr_company_id', $customer_no, $this->session->userdata['logged_in']['language_id']);

                //$this->db->last_query();
                $this->load->model('tax_grid_model');
                $data['tax_master'] = $this->tax_grid_model->select_sales_order_tax_grid($this->input->post('order_no'));
                $data['order_details'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('order_details', $this->session->userdata['logged_in']['company_id'], 'order_no', $this->input->post('order_no'));

                $data['customer'] = $this->customer_model->select_one_active_record('address_master', $this->session->userdata['logged_in']['company_id'], 'address_details.master_property_id', '1');
                $data['country'] = $this->country_model->select_active_drop_down('country_master');
                $data['tax_grid'] = $this->tax_grid_model->select_sales_tax_active_drop_down('tax_grid_master', $this->session->userdata['logged_in']['company_id']);
                $data['approval_authority'] = $this->common_model->select_one_active_approval_authority_record('authority_master', $this->session->userdata['logged_in']['company_id'], 'authority_master.form_id', '75');
                $data['payment_term'] = $this->customer_model->select_active_payment_term_drop_down('payment_condition_master', $this->session->userdata['logged_in']['language_id']);
                $data['freight_type'] = $this->common_model->select_active_drop_down_noncompany_withlanguage('freight_type_master_lang', $this->session->userdata['logged_in']['language_id']);

                $data['followup'] = $this->common_model->select_followup_records('followup', $this->session->userdata['logged_in']['company_id'], 'record_no', $this->input->post('order_no'));

                $data['followup_sent'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.contact_person_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');


                $data['page_name'] = 'Followup';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());
                //$data['note']='No Modify rights Thanks';
                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title');
                $this->load->view(ucwords($this->router->fetch_class()) . '/modify-reject-form', $data);
                $this->load->view('Home/footer');
              } else {

                $data = array('status' => '99');
                $result = $this->common_model->update_one_active_record_where('followup', $data, 'record_no', $this->input->post('order_no'), 'transaction_no', $this->input->post('transaction_no'), $this->session->userdata['logged_in']['company_id']);

                $data = array('pending_flag' => '0');

                $result = $this->common_model->update_one_active_record('order_master', $data, 'order_no', $this->input->post('order_no'), $this->session->userdata['logged_in']['company_id']);

                $data['followup'] = $this->common_model->select_one_active_record_nonlanguage_without_archive('followup', $this->session->userdata['logged_in']['company_id'], 'record_no', $this->input->post('order_no'));

                if ($data['followup'] == FALSE) {
                  $transaction_no = 1;
                  $status = 1;
                } else {
                  $i = 1;
                  foreach ($data['followup'] as $followup_row) {
                    $transaction_no = $followup_row->transaction_no;
                    $status = 1;
                    $i++;
                    $contact_person_id = $followup_row->contact_person_id;
                  }
                  $transaction_no = $i;
                }

                $data = array(
                  'company_id' => $this->session->userdata['logged_in']['company_id'],
                  'user_id' => $contact_person_id,
                  'form_id' => '75',
                  'transaction_no' => $transaction_no,
                  'status' => '999',
                  'followup_date' => date('Y-m-d'),
                  'approved_flag' => '2',
                  'approval_date' => date('Y-m-d'),
                  'contact_person_id' => $this->session->userdata['logged_in']['user_id'],
                  'record_no' => $this->input->post('order_no'),
                  'remark' => $this->input->post('remark')
                );
                $result = $this->common_model->save('followup', $data);



                $data['approval_employee'] = $this->common_model->select_one_active_record('employee_master', $this->session->userdata['logged_in']['company_id'], 'employee_id', $this->session->userdata['logged_in']['user_id']);
                $approval_email = "";
                if ($data['approval_employee'] == FALSE) {
                  $approval_email = "";
                } else {
                  foreach ($data['approval_employee'] as $employee_approval_row) {
                    $approval_email = $employee_approval_row->mailbox;
                  }
                }


                $data['employee'] = $this->common_model->select_one_active_record('employee_master', $this->session->userdata['logged_in']['company_id'], 'employee_id', $contact_person_id);
                if ($data['employee'] == FALSE) {
                } else {

                  foreach ($data['employee'] as $employee_row) {
                    $config['protocol'] = 'smtp';
                    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                    $config['smtp_port'] = 465;
                    $this->load->library('email', $config);
                    $this->email->from('auto.mailer@3d-neopac.com');
                    $this->email->to($employee_row->mailbox);
                    $this->email->cc($approval_email);
                    $this->email->cc('erp@3d-neopac.com');
                    $this->email->subject("" . $this->input->post('order_no') . " is Rejected");
                    $this->email->message("Dear Team, SO is Rejected due to " . $this->input->post('remark') . "

Regards,
" . $this->common_model->get_user_name($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']) . "
" . $this->common_model->get_user_contact_no($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']) . "


                          ");

                    if ($this->email->send()) {
                      $data['note'] = 'Mail Sent';
                    }
                  }
                }

                $data['note'] = 'Rejected Transaction Completed';
                header("refresh:1;url=" . base_url() . "index.php/" . $this->router->fetch_class());
                $data['followup_received'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.user_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
                $data['followup_sent'] = $this->sales_order_followup_model->select_followup_received_records('followup', $this->session->userdata['logged_in']['company_id'], 'followup.contact_person_id', $this->session->userdata['logged_in']['user_id'], 'status', '1', 'followup.form_id', '75');
                $data['page_name'] = 'Followup';
                $data['module'] = $this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id']);
                $data['formrights'] = $this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'], $this->session->userdata['logged_in']['company_id'], 7, $this->router->fetch_class());
                $this->load->view('Home/header');
                $this->load->view('Home/nav', $data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()) . '/active-title', $data);
                $this->load->view(ucwords($this->router->fetch_class()) . '/received-records', $data);
                $this->load->view('Home/footer');
              }
            } else {
              $data['note'] = 'No Newww rights Thanks';
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
}
