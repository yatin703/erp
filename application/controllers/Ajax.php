<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Ajax extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_in')) {
      $this->load->model('common_model');
      $this->load->model('currency_model');
      $this->load->model('sub_group_model');
      $this->load->model('second_sub_group_model');
    } else {
      redirect('login', 'refresh');
    }
  }

  public function mis_report_ajax()
  {
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');

      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;

      $this->load->model('coex_extrusion_model');

      $data['gcm2'] = $this->coex_extrusion_model->select_extrusion_monthwise_mis_gcm2($from_date, date('Y-m-d'));

      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/mis-report-ajax', $data);
      } else {

        $this->load->view(ucwords($this->router->fetch_class()) . '/mis-report-ajax-million', $data);
      }
    }
  }

  public function get_so_no()
  {
    if (!empty($this->input->post('certificate_no'))) {
      $certificate_no = $this->input->post('certificate_no');
      $arr = array('ar_invoice_no' => $certificate_no);
      $data['order_data'] = $this->common_model->select_active_records_where('ar_invoice_details', $this->session->userdata['logged_in']['company_id'], $arr);
      $this->load->view('Ajax/order-no-load-option', $data);
    }
  }

  public function get_product_no()
  {
    if (!empty($this->input->post('certificate_no') && $this->input->post('order_no'))) {
      $certificate_no = $this->input->post('certificate_no');
      $order_no = $this->input->post('order_no');
      $arr = array('ar_invoice_no' => $certificate_no, 'ref_ord_no' => $order_no);
      echo $this->db->last_query();
      $data['order_data'] = $this->common_model->select_active_records_where('ar_invoice_details', $this->session->userdata['logged_in']['company_id'], $arr);
      $this->load->view('Ajax/product-no-load-option', $data);
    }
  }

  public function get_cap_height_coa()
  {
    if (!empty($this->input->post('cap_type') && $this->input->post('specification_diameter') && $this->input->post('shoulder_thread_type'))) {
      $cap_type        = $this->input->post('cap_type');
      $cap_diameter    = $this->input->post('specification_diameter');
      $shoulder_type   = $this->input->post('shoulder_thread_type');
      $data['cap_height'] = $this->common_model->get_cap_height('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], 'cap_type', $cap_type, 'cap_dia', $cap_diameter, 'shoulder_type', $shoulder_type);
      //echo $this->db->last_query();
      $this->load->view('Ajax/cap-height-load-option', $data);
    }
  }

  public function get_customer_flag()
  {
    $arr = explode('//', $this->input->post('customer'));

    $data = array('adr_category_id' => $arr[1]);
    if (!empty($arr[1])) {

      $this->load->model('packing_material_consumption_model');
      $result = $this->common_model->select_one_active_record_with_limit('address_category_master', $this->session->userdata['logged_in']['company_id'], $data, '', '1', '0');

      //echo $this->db->last_query();
      if ($result) {
        foreach ($result as $row) {
          if ($row->export_flag == 1) {
            $total_export_packing_cost = 0;
            $data = array(
              'apply_from_date' => date('Y-m-01', strtotime('-1 month', strtotime(date("Y-m-d")))),
              'apply_to_date' => date('Y-m-t', strtotime('-1 month', strtotime(date("Y-m-d")))),
              'packing_category_id' => '1'
            );
            $result_edge_angle_board = $this->packing_material_consumption_model->active_record_search('packing_material_consumption_master', $data, $this->session->userdata['logged_in']['company_id']);
            $edge_angle_board = 0;
            if ($result_edge_angle_board) {
              foreach ($result_edge_angle_board as $row) {
                $edge_angle_board = $row->cost_per_tube;
              }
            } else {
              echo "Contact to Admin";
            }
            $data = array(
              'apply_from_date' => date('Y-m-01', strtotime('-1 month', strtotime(date("Y-m-d")))),
              'apply_to_date' => date('Y-m-t', strtotime('-1 month', strtotime(date("Y-m-d")))),
              'packing_category_id' => '3'
            );
            $result_wooden_pallets = $this->packing_material_consumption_model->active_record_search('packing_material_consumption_master', $data, $this->session->userdata['logged_in']['company_id']);
            $wodden_pallets = 0;
            if ($result_wooden_pallets) {
              foreach ($result_wooden_pallets as $row) {
                $wodden_pallets = $row->cost_per_tube;
              }
            } else {
              echo "Contact to Admin";
            }
            $data = array(
              'apply_from_date' => date('Y-m-01', strtotime('-1 month', strtotime(date("Y-m-d")))),
              'apply_to_date' => date('Y-m-t', strtotime('-1 month', strtotime(date("Y-m-d")))),
              'packing_category_id' => '2'
            );
            $result_desiccant_bags = $this->packing_material_consumption_model->active_record_search('packing_material_consumption_master', $data, $this->session->userdata['logged_in']['company_id']);
            $desiccant_bags = 0;
            if ($result_desiccant_bags) {
              foreach ($result_desiccant_bags as $row) {
                $desiccant_bags =  $row->cost_per_tube;
              }
            } else {
              echo "Contact to Admin";
            }
            $total_export_packing_cost = $edge_angle_board + $wodden_pallets + $desiccant_bags;
            echo $total_export_packing_cost;
          } else {
            echo '0.00';
          }
        }
      } else {
        echo "Contact to Admin";
      }
    }
  }

  public function get_consumable()
  {

    $this->load->model('other_consumable_consumption_model');

    $data = array(
      'apply_from_date' => date('Y-m-01', strtotime('-1 month', strtotime(date("Y-m-d")))),
      'apply_to_date' => date('Y-m-t', strtotime('-1 month', strtotime(date("Y-m-d")))),
      'consumable_category_id' => $this->input->post('consumable_category_id')
    );

    $result_screen_consumable = $this->other_consumable_consumption_model->active_record_search('other_consumable_consumption_master', $data);

    //echo $this->db->last_query();
    if ($result_screen_consumable) {
      foreach ($result_screen_consumable as $row) {
        echo $row->cost_per_tube;
      }
    } else {
      echo "Contact to Admin";
    }
  }

  public function get_screen_flexo_consumable()
  {

    $this->load->model('other_consumable_consumption_model');
    $total_screen_flexo_cost = 0;

    $data = array(
      'apply_from_date' => date('Y-m-01', strtotime('-1 month', strtotime(date("Y-m-d")))),
      'apply_to_date' => date('Y-m-t', strtotime('-1 month', strtotime(date("Y-m-d")))),
      'consumable_category_id' => $this->input->post('screen')
    );

    $result_screen_consumable = $this->other_consumable_consumption_model->active_record_search('other_consumable_consumption_master', $data);
    $screen_consumable = 0;
    //echo $this->db->last_query();
    if ($result_screen_consumable) {
      foreach ($result_screen_consumable as $row) {
        $screen_consumable = $row->cost_per_tube;
      }
    } else {
      echo "Contact to Admin";
    }

    $data = array(
      'apply_from_date' => date('Y-m-01', strtotime('-1 month', strtotime(date("Y-m-d")))),
      'apply_to_date' => date('Y-m-t', strtotime('-1 month', strtotime(date("Y-m-d")))),
      'consumable_category_id' => $this->input->post('flexo')
    );

    $result_flexo_consumable = $this->other_consumable_consumption_model->active_record_search('other_consumable_consumption_master', $data);
    $flexo_consumable = 0;
    //echo $this->db->last_query();
    if ($result_flexo_consumable) {
      foreach ($result_flexo_consumable as $row) {
        $flexo_consumable = $row->cost_per_tube;
      }
    } else {
      echo "Contact to Admin";
    }

    $total_screen_flexo_cost = $screen_consumable + $flexo_consumable;
    echo $total_screen_flexo_cost;
  }


  public function get_packing_box_tubes()
  {
    $arr = explode('//', $this->input->post('sleeve_id'));
    $sleeve_id = $arr[1];
    $data['sleeve_id'] = $sleeve_id;

    $data = array('sleeve_id' => $sleeve_id);

    $result = $this->common_model->active_record_search_noncompany('packing_box_master', $data);

    //echo $this->db->last_query();
    if ($result) {
      foreach ($result as $row) {
        echo $row->no_of_tubes_per_box;
      }
    } else {
      echo "Contact to Admin";
    }
  }

  public function get_shoulder_per_tube()
  {
    $arr = explode('//', $this->input->post('sleeve_id'));
    $sleeve_id = $arr[1];
    $data['sleeve_id'] = $sleeve_id;

    $data = array(
      'sleeve_id' => $sleeve_id,
      'article_no' => $this->input->post('rm')
    );

    $result = $this->common_model->select_one_active_record_with_limit('shoulder_foil_master', $this->session->userdata['logged_in']['company_id'], $data, '', '1', '0');

    //echo $this->db->last_query();
    if ($result) {
      foreach ($result as $row) {
        echo $row->sqm_per_tube;
      }
    } else {
      echo "Contact to Admin";
    }
  }

  public function get_cap_height()
  {
    $this->load->model('sales_order_item_parameterwise_model');
    $arr = explode('//', $this->input->post('sleeve_id'));
    $sleeve_id = $arr[1];
    $data['sleeve_id'] = $sleeve_id;

    $arr1 = explode('//', $this->input->post('shld_type_id'));
    $shld_type_id = $arr1[1];
    $data['shld_type_id'] = $shld_type_id;

    $arr2 = explode('//', $this->input->post('shld_orifice_id'));
    $shld_orifice_id = $arr2[1];
    $data['shld_orifice_id'] = $shld_orifice_id;

    $arr3 = explode('//', $this->input->post('cap_type_id'));
    $cap_type_id = $arr3[1];
    $data['cap_type_id'] = $cap_type_id;

    $arr4 = explode('//', $this->input->post('cap_dia_id'));
    $cap_dia_id = $arr4[1];
    $data['cap_dia_id'] = $cap_dia_id;

    $arr5 = explode('//', $this->input->post('cap_finish_id'));
    $cap_finish_id = $arr5[1];
    $data['cap_finish_id'] = $cap_finish_id;


    $data = array(
      'sleeve_id' => $sleeve_id,
      'shld_type_id' => $shld_type_id,
      'shld_orifice_id' => $shld_orifice_id,
      'cap_type_id' => $cap_type_id,
      'cap_finish_id' => $cap_finish_id,
      'cap_dia_id' => $cap_dia_id
    );

    $result = $this->common_model->select_one_active_record_with_limit('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], $data, '', '1', '0');

    //echo $this->db->last_query();
    if ($result) {
      foreach ($result as $row) {
        $cap_height = $row->cap_height;
        $box_min_height = ($this->input->post('sleeve_length') * 100) + $cap_height + 500;
        $box_max_height = $box_min_height + 2000;

        $data['packing_box_parameter_result'] = $this->sales_order_item_parameterwise_model->select_packing_box_record('packing_box_parameter_master', $this->session->userdata['logged_in']['company_id'], $box_min_height, $box_max_height, $packing_box_parameter_data = "");
        //echo $this->db->last_query();
        $this->load->view(ucwords($this->router->fetch_class()) . '/packing-box-load-option', $data);
      }
    } else {
      echo "Contact to Admin";
    }
  }

  public function get_mould_type()
  {

    $arr3 = explode('//', $this->input->post('cap_type_id'));
    $cap_type_id = $arr3[1];
    $data['cap_type_id'] = $cap_type_id;

    $data = array('cap_type_id' => $cap_type_id);

    $result = $this->common_model->select_one_active_record_with_limit('cap_types_master', $this->session->userdata['logged_in']['company_id'], $data, '', '1', '0');

    //echo $this->db->last_query();
    if ($result) {
      foreach ($result as $row) {
        echo $row->type;
      }
    } else {
      echo "Contact to Admin";
    }
  }

  public function get_moulding_cost()
  {

    $arr3 = explode('//', $this->input->post('cap_type'));
    $cap_type = $arr3[0];
    $data['cap_type'] = $cap_type;

    $arr4 = explode('//', $this->input->post('sleeve_dia'));
    $sleeve_dia = $arr4[0];
    $data['sleeve_dia'] = $sleeve_dia;

    $arr5 = explode('//', $this->input->post('cap_finish'));
    $cap_finish = $arr5[0];
    $data['cap_finish'] = $cap_finish;


    if ($cap_type == 'STD SCREW ON' || $cap_type == 'ROUND' || $cap_type == 'BEVEL' || $cap_type == 'LONG HEIGHT NOZZLE' || $cap_type == 'SHORT HEIGHT NOZZLE') {
      $cap_finish = "";
    }

    $data = array(
      'cap_type' => $cap_type,
      'cap_finish' => $cap_finish,
      'sleeve_dia' => $sleeve_dia
    );

    $result = $this->common_model->select_one_active_record_with_limit('other_cost_master', $this->session->userdata['logged_in']['company_id'], $data, '', '1', '0');

    //echo $this->db->last_query();


    if ($result) {
      foreach ($result as $row) {
        echo $row->cost_per_tube;
      }
    } else {
      echo "0";
    }
  }

  public function get_runner_waste()
  {

    $arr3 = explode('//', $this->input->post('cap_type_id'));
    $cap_type_id = $arr3[1];
    $data['cap_type_id'] = $cap_type_id;

    $data = array('cap_type_id' => $cap_type_id);

    $result = $this->common_model->select_one_active_record_with_limit('cap_types_master', $this->session->userdata['logged_in']['company_id'], $data, '', '1', '0');

    //echo $this->db->last_query();
    if ($result) {
      foreach ($result as $row) {
        echo $row->runner_waste;
      }
    } else {
      echo "Contact to Admin";
    }
  }

  public function get_cap_weight()
  {
    $arr = explode('//', $this->input->post('sleeve_id'));
    $sleeve_id = $arr[1];
    $data['sleeve_id'] = $sleeve_id;

    $arr1 = explode('//', $this->input->post('shld_type_id'));
    $shld_type_id = $arr1[1];
    $data['shld_type_id'] = $shld_type_id;

    if (!empty($this->input->post('shld_orifice_id'))) {
      $arr2 = explode('//', $this->input->post('shld_orifice_id'));
      $shld_orifice_id = $arr2[1];
      $data['shld_orifice_id'] = $shld_orifice_id;
    } else {
      $shld_orifice_id = '';
      $shld_orifice_id = $this->input->post('shld_orifice_id');

      $data['shld_orifice_id'] = $shld_orifice_id;
    }


    $arr3 = explode('//', $this->input->post('cap_type_id'));
    $cap_type_id = $arr3[1];
    $data['cap_type_id'] = $cap_type_id;

    $arr4 = explode('//', $this->input->post('cap_dia_id'));
    $cap_dia_id = $arr4[1];
    $data['cap_dia_id'] = $cap_dia_id;

    $arr5 = explode('//', $this->input->post('cap_finish_id'));
    $cap_finish_id = $arr5[1];
    $data['cap_finish_id'] = $cap_finish_id;


    $data = array(
      'sleeve_id' => $sleeve_id,
      'shld_type_id' => $shld_type_id,
      'shld_orifice_id' => $shld_orifice_id,
      'cap_type_id' => $cap_type_id,
      'cap_finish_id' => $cap_finish_id,
      'cap_dia_id' => $cap_dia_id
    );

    $data_array = array_filter($data);

    $result = $this->common_model->select_one_active_record_with_limit('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], $data_array, '', '1', '0');

    //echo $this->db->last_query();
    if ($result) {
      foreach ($result as $row) {
        echo $this->common_model->read_number($row->cap_weight, $this->session->userdata['logged_in']['company_id']);
      }
    } else {
      echo "Contact to Admin";
    }
  }

  public function get_shoulder_weight()
  {

    $arr = explode('//', $this->input->post('sleeve_id'));
    $sleeve_id = $arr[1];
    $data['sleeve_id'] = $sleeve_id;

    $arr1 = explode('//', $this->input->post('shld_type_id'));
    $shld_type_id = $arr1[1];
    $data['shld_type_id'] = $shld_type_id;

    $arr2 = explode('//', $this->input->post('shld_orifice_id'));
    $shld_orifice_id = $arr2[1];
    $data['shld_orifice_id'] = $shld_orifice_id;

    $data = array(
      'sleeve_id' => $sleeve_id,
      'shld_type_id' => $shld_type_id,
      'shld_orifice_id' => $shld_orifice_id
    );

    $result = $this->common_model->select_one_active_record_with_limit('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], $data, '', '1', '0');

    //echo $this->db->last_query();
    if ($result) {
      foreach ($result as $row) {
        echo $this->common_model->read_number($row->shld_weight, $this->session->userdata['logged_in']['company_id']) + ($this->common_model->read_number($row->shld_weight, $this->session->userdata['logged_in']['company_id']) * ($this->input->post('sh_rejection')) / 100);
      }
    } else {
      echo "0";
    }
  }


  public function get_rm_rate()
  {
    $result = $this->common_model->get_material_rate($this->input->post('rm'));
    if ($result) {
      foreach ($result as $row) {
        echo round($row->Avg_rate, 2);
      }
    } else {
      echo "0";
    }
  }

  public function get_ink_rate()
  {
    $ink_data = array(
      'ink_id' => $this->input->post('ink_id'),
      'archive' => '0'
    );
    $result_offset = $this->common_model->select_one_active_record_with_limit('ink_price_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
    //echo $this->db->last_query();
    if ($result_offset) {
      foreach ($result_offset as $row_result_offset) {
        echo $offset_rate = $row_result_offset->cost_per_kg;
      }
    }
  }

  public function get_offset_plate_rate()
  {
    $plate_data = array(
      'lacquer_type_id' => '2',
      'archive' => '0'
    );
    $result_plates = $this->common_model->select_one_active_record_with_limit('screen_consumption_master', $this->session->userdata['logged_in']['company_id'], $plate_data, 'apply_from_date desc', '1', '0');
    //echo $this->db->last_query();
    if ($result_plates) {
      foreach ($result_plates as $row_result_plates) {
        echo $plate_rate = $row_result_plates->consumption_unit_rate;
      }
    }
  }

  public function get_screen_plate_rate()
  {
    $plate_data = array(
      'lacquer_type_id' => '3',
      'archive' => '0'
    );
    $result_plates = $this->common_model->select_one_active_record_with_limit('screen_consumption_master', $this->session->userdata['logged_in']['company_id'], $plate_data, 'apply_from_date desc', '1', '0');
    //echo $this->db->last_query();
    if ($result_plates) {
      foreach ($result_plates as $row_result_plates) {
        echo $plate_rate = $row_result_plates->consumption_unit_rate;
      }
    }
  }

  public function get_flexo_plate_rate()
  {
    $plate_data = array(
      'lacquer_type_id' => '6',
      'archive' => '0'
    );
    $result_plates = $this->common_model->select_one_active_record_with_limit('screen_consumption_master', $this->session->userdata['logged_in']['company_id'], $plate_data, 'apply_from_date desc', '1', '0');
    //echo $this->db->last_query();
    if ($result_plates) {
      foreach ($result_plates as $row_result_plates) {
        echo $plate_rate = $row_result_plates->consumption_unit_rate;
      }
    }
  }

  public function get_consumption_rate()
  {
    $ink_data = array(
      'lacquer_type_id' => $this->input->post('lacquer_type_id'),
      'archive' => '0'
    );
    $result_offset = $this->common_model->select_one_active_record_with_limit('screen_consumption_master', $this->session->userdata['logged_in']['company_id'], $ink_data, 'apply_from_date desc', '1', '0');
    //echo $this->db->last_query();
    if ($result_offset) {
      foreach ($result_offset as $row_result_offset) {
        echo $offset_rate = $row_result_offset->consumption_unit_rate;
      }
    }
  }

  public function get_lacquer_consumption()
  {
    $arr = explode('//', $this->input->post('sleeve_dia'));
    $sleeve_dia = $arr[1];
    if (!empty($sleeve_dia)) {
      //$result_lacquer_gm_tube=$this->common_model->article_no_generationn('lacquer_consumption_master',$this->session->userdata['logged_in']['company_id'],'length_from>=',$this->input->post('sleeve_length')-10,'length_to<=',$this->input->post('sleeve_length')+10,'sleeve_id',$sleeve_dia,'article_no',$this->input->post('rm'));

      $data = array(
        'length_from>=' => $this->input->post('sleeve_length') - 10,
        'length_to<=' => $this->input->post('sleeve_length') + 10,
        'sleeve_id' => $sleeve_dia,
        'article_no' => $this->input->post('rm')
      );
      $result_lacquer_gm_tube = $this->common_model->select_one_active_record_with_limit('lacquer_consumption_master', $this->session->userdata['logged_in']['company_id'], $data, 'lcm_id', '1', '0');
      //echo $this->db->last_query();
      if ($result_lacquer_gm_tube) {
        foreach ($result_lacquer_gm_tube as $row_lacquer_gm_tube) {
          echo $lacquer_one_gm_tube = $row_lacquer_gm_tube->consumption_per_tube;
        }
      }
    }
  }

  public function oc_date_confirmation()
  {
    $update_data = array('oc_date' => $this->input->post('oc_date'), 'oc_date_updated_on' => date('Y-m-d H:i:s'));
    $update_result = $this->common_model->update_one_active_record('order_master', $update_data, 'order_no', $this->input->post('order_no'), $this->session->userdata['logged_in']['company_id']);
    if ($update_result) {
      $from = "2022-02-01";
      $to = date('Y-m-d');
      $search = "";
      $this->load->model('artwork_model');
      $this->load->model('sales_order_book_model');
      $data['order_no'] = $this->input->post('order_no');
      $data['oc_date'] = $this->input->post('oc_date');
      $data['article_no'] = $this->input->post('article_no');
      $data['order_master'] = $this->sales_order_book_model->active_record_oc('order_master', $search, $from, $to, $this->session->userdata['logged_in']['company_id'], $order_closed_arr = "", '', '', $cancelled_from_date = "", $cancelled_to_date = "");
      $this->load->view(ucwords($this->router->fetch_class()) . '/order-oc-load-option', $data);
      $username = "";
      $data['employee_to'] = $this->common_model->select_one_active_record('employee_master', $this->session->userdata['logged_in']['company_id'], 'employee_id', $this->input->post('order_created_by'));
      foreach ($data['employee_to'] as $employee_to_row) {
        $to = $employee_to_row->mailbox;
        $data['username'] = $employee_to_row->name1;
      }
      $data['employee_cc'] = $this->common_model->select_one_active_record('employee_master', $this->session->userdata['logged_in']['company_id'], 'employee_id', $this->input->post('order_arropved_by'));
      foreach ($data['employee_cc'] as $employee_cc_row) {
        $cc = $employee_cc_row->mailbox;
        //$data['username']=$employee_to_row->name1;
      }

      $data['employee'] = $this->common_model->select_one_active_record('employee_master', $this->session->userdata['logged_in']['company_id'], 'employee_id', $this->session->userdata['logged_in']['user_id']);

      foreach ($data['employee'] as $employee_row) {


        $this->load->library('email');
        $config = array(
          'charset' => 'utf-8',
          'wordwrap' => TRUE,
          'mailtype' => 'html'
        );
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        //$this->email->set_header('Content-Type', 'text/html');
        $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
        $this->email->set_header('Content-type', 'text/html');
        $this->email->from('auto.mailer@3d-neopac.com');
        $this->email->to($to);
        $this->email->cc($cc);
        $this->email->subject("Notification : " . $this->input->post('order_no') . " OC Date " . $this->common_model->view_date($this->input->post('oc_date'), $this->session->userdata['logged_in']['company_id']));
        $this->email->message("Dear Sales Team, OC date updated");
        //$body = $this->load->view('Email/order-confirmation',$data,TRUE);
        // $this->email->message($body);

        if ($this->email->send()) {
          $data['note'] = 'mail Sent';
        }
      }
    }
  }

  public function coex_plan()
  {
    $half_plan = $this->input->post('pending_qty') - $this->input->post('planned_qty');
    $planning_flag = ($half_plan == 0 ? '1' : '2');
    $update_data = array('planning_flag' => $planning_flag);
    $update_result = $this->common_model->update_one_active_record('order_master', $update_data, 'order_no', $this->input->post('order_no'), $this->session->userdata['logged_in']['company_id']);
    if ($update_result) {
      $data = array(
        'company_id' => $this->session->userdata['logged_in']['company_id'],
        'c_planned_on_date' => date('Y-m-d'),
        'order_no' => $this->input->post('order_no'),
        'article_no' => $this->input->post('article_no'),
        'coex_machine_id' => $this->input->post('machine'),
        'shift_id' => $this->input->post('shift'),
        'quantity' => $this->input->post('planned_qty')
      );
      $result = $this->common_model->save('coex_planning', $data);
      if ($result) {
        echo "<p class='alert alert-success'>" . $this->input->post('order_no') . " is planned</p>";
      }
    }
  }

  public function check_shift()
  {
    $this->load->model('coex_planning_model');
    $data['mac'] = array('machine_id' => $this->input->post('machine'));
    $search = array('order_no' => $this->input->post('order_no'), 'article_no' => $this->input->post('article_no'));
    $data['shift_planned'] = $this->common_model->active_record_search('coex_planning', $search, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/shift-load-option', $data);
  }

  public function sleeve_length()
  {
    if (!empty($this->input->post('sleeve_dia'))) {
      $arr = explode('//', $this->input->post('sleeve_dia'));
      $sleeve_length = $this->input->post('sleeve_length');
      $this->load->model('sleeve_length_model');
      $result = $this->sleeve_length_model->select_length_active_record('length_master', $this->session->userdata['logged_in']['company_id'], $arr[0], $sleeve_length);
      if ($result) {
        foreach ($result as $row) {
          if ($row->no == 0) {
            echo '<script language="javascript">alert("Manufacturing of the mentioned length is not possible")</script>';
          }
        }
      }
      //echo $this->db->last_query();
      //$this->load->view(ucwords($this->router->fetch_class()).'/shoulder-load-option',$data);
    }
  }

  public function quotation_no()
  {
    $edit = $this->input->get('q');
    $data = array('quotation_no' => $edit);
    $this->load->model('common_model');
    $data['sales_quote_master'] = $this->common_model->active_record_search('sales_quote_master', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/quotation-no-load-option', $data);
  }

  public function tube_color()
  {
    $edit = $this->input->get('q');
    $data = array('color' => $edit);
    $this->load->model('common_model');
    $data['color_master'] = $this->common_model->active_record_search('color_master', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/tube-color-load-option', $data);
  }


  public function costsheet_data()
  {

    //echo $this->input->post('cap_metalization'); 

    $data['layer'] = $this->input->post('layer');
    $data['print_type'] = $this->input->post('print_type');
    $data['shoulder_foil'] = $this->input->post('shoulder_foil');
    $data['cap_foil'] = $this->input->post('cap_foil');
    $data['cap_metalization'] = $this->input->post('cap_metalization');
    $data['cap_shrink_sleeve'] = $this->input->post('cap_shrink_sleeve');
    $data['tube_foil'] = $this->input->post('tube_foil');


    $arr = explode('//', $this->input->post('sleeve_dia'));
    $sleeve_dia = $arr[0];
    $data['sleeve_dia'] = $sleeve_dia;

    $arr1 = explode('//', $this->input->post('shoulder'));
    $shoulder = $arr1[0];
    $data['shoulder'] = $shoulder;

    $arr2 = explode('//', $this->input->post('cap_type'));
    $cap_type = $arr2[0];
    $data['cap_type'] = $cap_type;

    $arr3 = explode('//', $this->input->post('cap_finish'));
    $cap_finish = $arr3[0];
    $data['cap_finish'] = $cap_finish;

    $arr4 = explode('//', $this->input->post('cap_dia'));
    $cap_dia = $arr4[0];
    $data['cap_dia'] = $cap_dia;


    $search = array(
      'layer' => $this->input->post('layer'),
      'print_type' => $this->input->post('print_type'),

      'dia' => $sleeve_dia,
      'shoulder_type' => $shoulder,
      'cap_type' => $cap_type,
      'cap_finish' => $cap_finish,
      'cap_dia' => $cap_dia,
      'shoulder_foil' => $this->input->post('shoulder_foil'),
      'cap_foil' => $this->input->post('cap_foil'),
      'cap_metalization' => $this->input->post('cap_metalization'),
      'cap_shrink_sleeve' => $this->input->post('cap_shrink_sleeve'),
      'tube_foil_1' => $this->input->post('tube_foil'),


    );
    $search_filer = array_filter($search);

    $data['costsheet_data'] = $this->common_model->select_active_records_where_order_by('costsheet_master', $this->session->userdata['logged_in']['company_id'], $search_filer, 'costheet_id', 'desc');
    //echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/costsheet-table-load-option', $data);
  }

  public function po_check()
  {

    if (!empty($this->input->post('article_no')) && !empty($this->input->post('po_no'))) {
      //$data=array('po_no'=>$this->input->post('po_no'));

      $arr = explode('//', $this->input->post('article_no'));
      if (!empty($arr[1])) {
        $this->load->model('sales_order_book_model');
        $result = $this->sales_order_book_model->po_check($this->input->post('po_no'), $arr[1]);
        if ($result) {
          foreach ($result as $row) {
            //echo $row->count;
            if ($row->no > 0) {
              echo '<script language="javascript">alert("' . $row->order_no . ' with same PO & Product Code already exist, Check Once again")</script>';
            }
          }
        }
      }
    }
  }

  public function module()
  {
    $table = 'form_master';
    $pkey = 'module_id';
    $edit = $this->input->post('module');
    $data['form'] = $this->common_model->select_one_active_record($table, $this->session->userdata['logged_in']['company_id'], $pkey, $edit);
    $this->load->view(ucwords($this->router->fetch_class()) . '/form-load-option', $data);
  }

  public function form()
  {
    $table = 'form_master';
    $pkey = 'form_id';
    $edit = $this->input->post('form');
    $data['formrights'] = $this->common_model->select_one_active_record($table, $this->session->userdata['logged_in']['company_id'], $pkey, $edit);
    $this->load->view(ucwords($this->router->fetch_class()) . '/formrights-load-option', $data);
  }

  public function machine_start()
  {
    $data = array('machine_id' => $this->input->post('machine'));
    $this->load->model('coex_extrusion_model');
    $data['machine_start'] = $this->coex_extrusion_model->select_machine_start('coex_extrusion_machine_start_stop', $this->session->userdata['logged_in']['company_id'], $data, $group_by = "", 'cemss_id', '1', '0');

    $dataa = array('process_id' => '1', 'start_stop_flag' => '0');
    $data['coex_extrusion_machine_stop_reasons'] = $this->common_model->select_active_records_where('coex_machine_start_stop_reasons', $this->session->userdata['logged_in']['company_id'], $dataa);

    $dataa = array('process_id' => '1', 'start_stop_flag' => '1');
    $data['coex_extrusion_machine_start_reasons'] = $this->common_model->select_active_records_where('coex_machine_start_stop_reasons', $this->session->userdata['logged_in']['company_id'], $dataa);

    $this->load->view(ucwords($this->router->fetch_class()) . '/extrusion-machine-start-load-option', $data);
  }


  public function printing_machine_start()
  {
    $data = array('machine_id' => $this->input->post('machine'));
    $this->load->model('coex_printing_model');
    $data['machine_start'] = $this->coex_printing_model->select_machine_start('coex_printing_machine_start_stop', $this->session->userdata['logged_in']['company_id'], $data, $group_by = "", 'cpmss_id', '1', '0');

    $dataa = array('process_id' => '3', 'start_stop_flag' => '0', 'archive' => '0');
    $data['coex_printing_machine_stop_reasons'] = $this->common_model->select_active_records_where_order_by('coex_machine_start_stop_reasons', $this->session->userdata['logged_in']['company_id'], $dataa, 'pos_no', 'asc');

    $dataa = array('process_id' => '3', 'start_stop_flag' => '1', 'archive' => '0');
    $data['coex_printing_machine_start_reasons'] = $this->common_model->select_active_records_where('coex_machine_start_stop_reasons', $this->session->userdata['logged_in']['company_id'], $dataa);

    $this->load->view(ucwords($this->router->fetch_class()) . '/printing-machine-start-load-option', $data);
  }

  public function machine_start_entry()
  {
    $data = array(
      'machine_start_stop_date' => date('Y-m-d'), 'machine_id' => $this->input->post('machine'),
      'company_id' => $this->session->userdata['logged_in']['company_id'], 'machine_start_stop_time' => date('Y-m-d H:i:s'), 'machine_start_stop_timestamp' => time(), 'machine_start_stop_flag' => '1', 'user_id' => $this->session->userdata['logged_in']['user_id'], 'cemssr_id' => $this->input->post('coex_extrusion_machine_start_reasons'), 'process_id' => '1'
    );
    $this->common_model->save('coex_extrusion_machine_start_stop', $data);

    $data = array(
      'machine_id' => $this->input->post('machine'),
      'company_id' => $this->session->userdata['logged_in']['company_id'], 'machine_start_time' => date('Y-m-d H:i:s'), 'cemssr_id' => $this->input->post('coex_extrusion_machine_start_reasons'), 'user_id' => $this->session->userdata['logged_in']['user_id'], 'process_id' => '1'
    );
    $this->common_model->save('coex_machine_runtime', $data);


    $update_data = array('machine_start_time' => date('Y-m-d H:i:s'));
    $this->common_model->update_one_active_record_where('coex_machine_downtime', $update_data, 'machine_id', $this->input->post('machine'), 'machine_start_time', '0000-00-00 00:00:00', $this->session->userdata['logged_in']['company_id']);

    $dat = array('machine_id' => $this->input->post('machine'));
    $this->load->model('coex_extrusion_model');
    $data['machine_start'] = $this->coex_extrusion_model->select_machine_start('coex_extrusion_machine_start_stop', $this->session->userdata['logged_in']['company_id'], $dat, $group_by = "", 'cemss_id', '1', '0');


    $dataa = array('process_id' => '1', 'start_stop_flag' => '0');
    $data['coex_extrusion_machine_stop_reasons'] = $this->common_model->select_active_records_where('coex_machine_start_stop_reasons', $this->session->userdata['logged_in']['company_id'], $dataa);

    $this->load->view(ucwords($this->router->fetch_class()) . '/extrusion-machine-start-load-option', $data);
  }

  public function printing_machine_start_entry()
  {
    $data = array(
      'machine_start_stop_date' => date('Y-m-d'), 'machine_id' => $this->input->post('machine'),
      'company_id' => $this->session->userdata['logged_in']['company_id'], 'machine_start_stop_time' => date('Y-m-d H:i:s'), 'machine_start_stop_timestamp' => time(), 'machine_start_stop_flag' => '1', 'user_id' => $this->session->userdata['logged_in']['user_id'], 'cemssr_id' => $this->input->post('coex_printing_machine_start_reasons'), 'process_id' => '3', 'mp_pos_no' => $this->input->post('mp_pos_no')
    );
    $this->common_model->save('coex_printing_machine_start_stop', $data);

    $data = array(
      'machine_id' => $this->input->post('machine'),
      'company_id' => $this->session->userdata['logged_in']['company_id'], 'machine_start_time' => date('Y-m-d H:i:s'), 'cemssr_id' => $this->input->post('coex_printing_machine_start_reasons'), 'user_id' => $this->session->userdata['logged_in']['user_id'], 'process_id' => '3', 'mp_pos_no' => $this->input->post('mp_pos_no')
    );
    $this->common_model->save('coex_machine_runtime', $data);


    $update_data = array('machine_start_time' => date('Y-m-d H:i:s'));
    $this->common_model->update_one_active_record_where('coex_machine_downtime', $update_data, 'machine_id', $this->input->post('machine'), 'machine_start_time', '0000-00-00 00:00:00', $this->session->userdata['logged_in']['company_id']);

    $dat = array('machine_id' => $this->input->post('machine'));
    $this->load->model('coex_printing_model');
    $data['machine_start'] = $this->coex_printing_model->select_machine_start('coex_printing_machine_start_stop', $this->session->userdata['logged_in']['company_id'], $dat, $group_by = "", 'cpmss_id', '1', '0');


    $dataa = array('process_id' => '3', 'start_stop_flag' => '0', 'archive' => '0');
    $data['coex_printing_machine_stop_reasons'] = $this->common_model->select_active_records_where_order_by('coex_machine_start_stop_reasons', $this->session->userdata['logged_in']['company_id'], $dataa, 'coex_machine_start_stop_reasons', 'asc');



    $this->load->view(ucwords($this->router->fetch_class()) . '/printing-machine-start-load-option', $data);
  }

  public function machine_stop_entry()
  {
    $dataaa = array(
      'machine_start_stop_date' => date('Y-m-d'), 'machine_id' => $this->input->post('machine'),
      'company_id' => $this->session->userdata['logged_in']['company_id'], 'machine_start_stop_time' => date('Y-m-d H:i:s'), 'machine_start_stop_timestamp' => time(), 'machine_start_stop_flag' => '0', 'user_id' => $this->session->userdata['logged_in']['user_id'], 'cemssr_id' => $this->input->post('coex_extrusion_machine_stop_reasons'), 'process_id' => '1'
    );
    $this->common_model->save('coex_extrusion_machine_start_stop', $dataaa);

    $update_data = array('machine_stop_time' => date('Y-m-d H:i:s'));
    $this->common_model->update_one_active_record_where('coex_machine_runtime', $update_data, 'machine_id', $this->input->post('machine'), 'machine_stop_time', '0000-00-00 00:00:00', $this->session->userdata['logged_in']['company_id']);

    $data_downtime = array(
      'machine_id' => $this->input->post('machine'),
      'company_id' => $this->session->userdata['logged_in']['company_id'], 'machine_stop_time' => date('Y-m-d H:i:s'), 'cemssr_id' => $this->input->post('coex_extrusion_machine_stop_reasons'), 'user_id' => $this->session->userdata['logged_in']['user_id'], 'process_id' => '1'
    );
    $this->common_model->save('coex_machine_downtime', $data_downtime);

    $dat = array('machine_id' => $this->input->post('machine'));
    $this->load->model('coex_extrusion_model');
    $data['machine_start'] = $this->coex_extrusion_model->select_machine_start('coex_extrusion_machine_start_stop', $this->session->userdata['logged_in']['company_id'], $dat, $group_by = "", 'cemss_id', '1', '0');

    $dataa = array('process_id' => '1', 'start_stop_flag' => '1');
    $data['coex_extrusion_machine_start_reasons'] = $this->common_model->select_active_records_where('coex_machine_start_stop_reasons', $this->session->userdata['logged_in']['company_id'], $dataa);

    $this->load->view(ucwords($this->router->fetch_class()) . '/extrusion-machine-start-load-option', $data);
  }

  public function printing_machine_stop_entry()
  {
    $dataaa = array(
      'machine_start_stop_date' => date('Y-m-d'), 'machine_id' => $this->input->post('machine'),
      'company_id' => $this->session->userdata['logged_in']['company_id'], 'machine_start_stop_time' => date('Y-m-d H:i:s'), 'machine_start_stop_timestamp' => time(), 'machine_start_stop_flag' => '0', 'user_id' => $this->session->userdata['logged_in']['user_id'], 'cemssr_id' => $this->input->post('coex_printing_machine_stop_reasons'), 'process_id' => '3'
    );
    $this->common_model->save('coex_printing_machine_start_stop', $dataaa);

    $update_data = array('machine_stop_time' => date('Y-m-d H:i:s'));
    $this->common_model->update_one_active_record_where('coex_machine_runtime', $update_data, 'machine_id', $this->input->post('machine'), 'machine_stop_time', '0000-00-00 00:00:00', $this->session->userdata['logged_in']['company_id']);

    $data_downtime = array(
      'machine_id' => $this->input->post('machine'),
      'company_id' => $this->session->userdata['logged_in']['company_id'], 'machine_stop_time' => date('Y-m-d H:i:s'), 'cemssr_id' => $this->input->post('coex_printing_machine_stop_reasons'), 'user_id' => $this->session->userdata['logged_in']['user_id'], 'process_id' => '3'
    );
    $this->common_model->save('coex_machine_downtime', $data_downtime);

    $dat = array('machine_id' => $this->input->post('machine'));
    $this->load->model('coex_printing_model');
    $data['machine_start'] = $this->coex_printing_model->select_machine_start('coex_printing_machine_start_stop', $this->session->userdata['logged_in']['company_id'], $dat, $group_by = "", 'cpmss_id', '1', '0');

    $dataa = array('process_id' => '3', 'start_stop_flag' => '1', 'archive' => '0');
    $data['coex_printing_machine_start_reasons'] = $this->common_model->select_active_records_where('coex_machine_start_stop_reasons', $this->session->userdata['logged_in']['company_id'], $dataa);

    $this->load->view(ucwords($this->router->fetch_class()) . '/printing-machine-start-load-option', $data);
  }

  public function currency()
  {
    $table = 'country_master';
    //$pkey='country_id';
    if ($this->input->post('for_currency')) {
      $ignore = $this->input->post('for_currency');
    } else {
      $ignore = '';
    }

    $data['to_currency'] = $this->currency_model->select_to_currency_drop_down($table, $ignore);
    $this->load->view(ucwords($this->router->fetch_class()) . '/currency-load-option', $data);
  }

  //Used in Create form Article Create form
  public function sub_group()
  {
    $data['sub_group'] = $this->sub_group_model->select_one_active_record('article_group', $this->session->userdata['logged_in']['company_id'], 'article_group.main_group_id', $this->input->post('main_group'));

    $this->load->view(ucwords($this->router->fetch_class()) . '/sub-group-load-option', $data);
  }

  public function second_sub_group()
  {
    $data['second_sub_group'] = $this->second_sub_group_model->select_one_active_record('article_second_subgroup_master', $this->session->userdata['logged_in']['company_id'], 'article_second_subgroup_master.article_group_id', $this->input->post('sub_group'));
    $this->load->view(ucwords($this->router->fetch_class()) . '/second-sub-group-load-option', $data);
  }

  public function main_group_article()
  {
    $data['autogeneration'] = $this->common_model->article_no_generation('article_number_circles', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $this->input->post('main_group'), 'sub_group_id', '', 'sub_sub_grp_id', '');
    echo $this->db->last_query();
    if ($data['autogeneration'] == FALSE) {
      $data['default'] = $this->common_model->article_no_generation('article_number_circles', $this->session->userdata['logged_in']['company_id'], 'main_group_id', '', 'sub_group_id', '', 'sub_sub_grp_id', '');
      foreach ($data['default'] as $default_row) {

        $count = str_pad($default_row->curr_val, $default_row->number_of_digits, 0, STR_PAD_LEFT);

        $data['main_group'] = $this->common_model->select_one_active_record('article_main_group', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $this->input->post('main_group'));
        foreach ($data['main_group'] as $main_group_row) {
          $main_group_row->lang_short_desc;
          $data['number'] = $main_group_row->lang_short_desc . "-000-000-" . $count;
        }
      }
    } else {
      foreach ($data['autogeneration'] as $row) {
        $main_group_initial = '';
        if ($row->main_grp_value == 'MAIN') {
          $data['main_group'] = $this->common_model->select_one_active_record('article_main_group', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $row->main_group_id);
          foreach ($data['main_group'] as $main_group_row) {
            $main_group_initial = $main_group_row->lang_short_desc . $row->seperator;
          }
        } else if ($row->main_grp_value == '') {
          $main_group_initial = "";
        } else {
          $main_group_initial = $row->main_grp_value . $row->seperator;
        }

        if ($row->sub_grp_value == 'SUB') {
          $sub_group_initial = "000" . $row->seperator;
        } else if ($row->sub_grp_value == '') {
          $sub_group_initial = "";
        } else {
          $sub_group_initial = $row->sub_grp_value . $row->seperator;
        }

        if ($row->sub_sub_grp_value == 'SECSUB') {
          $second_sub_group_initial = "000" . $row->seperator;
        } else if ($row->sub_sub_grp_value == '') {
          $second_sub_group_initial = "";
        } else {
          $second_sub_group_initial = $row->sub_sub_grp_value . $row->seperator;
        }

        $count = $this->common_model->active_record_count_where('article', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $row->main_group_id, 'article_group_id', '999999999999999', 'sub_sub_grp_id', '999999999999999');
        echo $this->db->last_query();
        echo $count = $row->step_by + $count + $row->start_value;
        $count = str_pad($count, $row->number_of_digits, 0, STR_PAD_LEFT);

        $data['number'] = $main_group_initial . $sub_group_initial . $second_sub_group_initial . $count;
      }
    }
    $this->load->view(ucwords($this->router->fetch_class()) . '/main-group-article-load-option', $data);
  }

  public function jobcard_material_details()
  {
    $jobcard_no = $this->input->post('jobcard_no');
    $dat = array('manu_order_no' => $jobcard_no, 'work_proc_no' => 1);
    $this->load->model('job_card_model');
    $this->load->model('coex_extrusion_rm_mixing_model');
    $data['jobcard_material_details'] = $this->job_card_model->jobcard_material_summary('material_manufacturing', $dat, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/jobcard-material-load-option', $data);
  }

  public function pricing_list_details()
  {
    $pg_no = $this->input->post('pg_no');
    $data = array('pg_no' => $pg_no);
    $this->load->model('product_block_pricing_model');
    $data['product_block_pricing'] = $this->product_block_pricing_model->active_record_search('product_block_pricing', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/price-list-table-load-option', $data);
  }

  public function sub_group_article()
  {

    $data['autogeneration'] = $this->common_model->article_no_generation('article_number_circles', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $this->input->post('main_group'), 'sub_group_id', $this->input->post('sub_group'), 'sub_sub_grp_id', '');
    //echo $this->db->last_query();
    if ($data['autogeneration'] == FALSE) {


      //$data['default']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id','','sub_group_id','','sub_sub_grp_id','');
      $data_sub_group['main_group_id'] = $this->input->post('main_group');
      $data_sub_group['article_group_id'] = $this->input->post('sub_group');

      $data['default'] = $this->common_model->select_active_records_where('article_group', $this->session->userdata['logged_in']['company_id'], $data_sub_group);
      $this->db->last_query();
      foreach ($data['default'] as $default_row) {

        //$count=str_pad($default_row->curr_val,$default_row->number_of_digits,0,STR_PAD_LEFT);
        $count = str_pad($default_row->increment_value, 4, 0, STR_PAD_LEFT);
        $data['main_group'] = $this->common_model->select_one_active_record('article_main_group', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $this->input->post('main_group'));

        foreach ($data['main_group'] as $main_group_row) {
          $main_group_initial = $main_group_row->lang_short_desc;
          $data['sub_group'] = $this->sub_group_model->select_one_active_record('article_group', $this->session->userdata['logged_in']['company_id'], 'article_group.article_group_id', $this->input->post('sub_group'));
          foreach ($data['sub_group'] as $sub_group_row) {
            if ($main_group_row->main_group_id != 1 && $main_group_row->main_group_id != 3) {
              $data['number'] = $main_group_row->lang_short_desc . "-" . $sub_group_row->sub_group_short_id . "-000-" . $count;
            } else {
              $data['number'] = $sub_group_row->sub_group_short_id . "-000-" . $count;
            }
          }
        }
      }
    } else {

      foreach ($data['autogeneration'] as $row) {

        if ($row->main_grp_value == 'MAIN') {
          $data['main_group'] = $this->common_model->select_one_active_record('article_main_group', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $row->main_group_id);
          foreach ($data['main_group'] as $main_group_row) {
            $main_group_initial = $main_group_row->lang_short_desc . $row->seperator;
          }
        } else if ($row->main_grp_value == '') {
          $main_group_initial = "";
        } else {
          $main_group_initial = $row->main_grp_value . $row->seperator;
        }

        if ($row->sub_grp_value == 'SUB') {
          $data['sub_group'] = $this->sub_group_model->select_one_active_record('article_group', $this->session->userdata['logged_in']['company_id'], 'article_group.article_group_id', $row->sub_group_id);
          foreach ($data['sub_group'] as $sub_group_row) {
            $sub_group_initial = $sub_group_row->sub_group_short_id . $row->seperator;
          }
        } else if ($row->sub_grp_value == '') {
          $sub_group_initial = "";
        } else {
          $sub_group_initial = $row->sub_grp_value . $row->seperator;
        }

        if ($row->sub_sub_grp_value == 'SECSUB') {
          $second_sub_group_initial = "000" . $row->seperator;
        } else if ($row->sub_sub_grp_value == '') {
          $second_sub_group_initial = "";
        } else {
          $second_sub_group_initial = $row->sub_sub_grp_value . $row->seperator;
        }

        $count = $this->common_model->active_record_count_where('article', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $this->input->post('main_group'), 'article_group_id', $this->input->post('sub_group'), 'sub_sub_grp_id', '999999999999999');
        //echo $this->db->last_query();
        //$count=$row->step_by+$count+$row->start_value;
        /* if($count<$row->curr_val){
          $count=$row->step_by+$row->curr_val;
          $next_curr_value=$row->curr_val+1;
          $udata=array('curr_val'=>$next_curr_value);
          //$this->common_model->update_one_active_record('article_number_circles',$udata,'sub_group_id',$this->input->post('sub_group'),$this->session->userdata['logged_in']['company_id']);

        }else{
          }*/

        $count = $row->step_by + $count + $row->start_value;

        $count = str_pad($count, $row->number_of_digits, 0, STR_PAD_LEFT);

        $data['number'] = $main_group_initial . $sub_group_initial . $second_sub_group_initial . $count;
      }
    }

    //echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/main-group-article-load-option', $data);
  }


  public function second_sub_group_article()
  {
    $data['autogeneration'] = $this->common_model->article_no_generation('article_number_circles', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $this->input->post('main_group'), 'sub_group_id', $this->input->post('sub_group'), 'sub_sub_grp_id', $this->input->post('second_sub_group'));
    if ($data['autogeneration'] == FALSE) {



      //$data['default']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id','','sub_group_id','','sub_sub_grp_id','');

      // $data_second_sub_group['main_group_id']=$this->input->post('main_group');
      // $data_second_sub_group['article_group_id']=$this->input->post('sub_group');
      // $data_second_sub_group['sub_sub_grp_id']=$this->input->post('second_sub_group');

      if ($this->input->post('main_group') == '8' && $this->input->post('sub_group') == '34') {

        $data_second_sub_group['main_group_id'] = $this->input->post('main_group');
        $data_second_sub_group['article_group_id'] = $this->input->post('sub_group');

        $data['default'] = $this->common_model->select_active_records_where('article_group', $this->session->userdata['logged_in']['company_id'], $data_second_sub_group);
      } else {
        $data_second_sub_group['main_group_id'] = $this->input->post('main_group');
        $data_second_sub_group['article_group_id'] = $this->input->post('sub_group');
        $data_second_sub_group['sub_sub_grp_id'] = $this->input->post('second_sub_group');
        $data['default'] = $this->common_model->select_active_records_where('article_second_subgroup_master', $this->session->userdata['logged_in']['company_id'], $data_second_sub_group);
      }


      foreach ($data['default'] as $default_row) {



        //$count=str_pad($default_row->curr_val,$default_row->number_of_digits,0,STR_PAD_LEFT);
        $count = str_pad($default_row->increment_value, 4, 0, STR_PAD_LEFT);

        $data['main_group'] = $this->common_model->select_one_active_record('article_main_group', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $this->input->post('main_group'));
        foreach ($data['main_group'] as $main_group_row) {

          $data['sub_group'] = $this->sub_group_model->select_one_active_record('article_group', $this->session->userdata['logged_in']['company_id'], 'article_group.article_group_id', $this->input->post('sub_group'));
          foreach ($data['sub_group'] as $sub_group_row) {

            $data['second_sub_group'] = $this->second_sub_group_model->select_one_active_record('article_second_subgroup_master', $this->session->userdata['logged_in']['company_id'], 'article_second_subgroup_master.sub_sub_grp_id', $this->input->post('second_sub_group'));
            foreach ($data['second_sub_group'] as $second_sub_group_row) {
              $data['number'] = $main_group_row->lang_short_desc . "-" . $sub_group_row->sub_group_short_id . "-" . $second_sub_group_row->second_sub_group_short_id . "-" . $count;
            }
          }
        }
      }
    } else {

      foreach ($data['autogeneration'] as $row) {

        if ($row->main_grp_value == 'MAIN') {
          $data['main_group'] = $this->common_model->select_one_active_record('article_main_group', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $row->main_group_id);
          foreach ($data['main_group'] as $main_group_row) {
            $main_group_initial = $main_group_row->lang_short_desc . $row->seperator;
          }
        } else if ($row->main_grp_value == '') {
          $main_group_initial = "";
        } else {
          $main_group_initial = $row->main_grp_value . $row->seperator;
        }

        if ($row->sub_grp_value == 'SUB') {
          $data['sub_group'] = $this->sub_group_model->select_one_active_record('article_group', $this->session->userdata['logged_in']['company_id'], 'article_group.article_group_id', $row->sub_group_id);
          foreach ($data['sub_group'] as $sub_group_row) {
            $sub_group_initial = $sub_group_row->sub_group_short_id . $row->seperator;
          }
        } else if ($row->sub_grp_value == '') {
          $sub_group_initial = "";
        } else {
          $sub_group_initial = $row->sub_grp_value . $row->seperator;
        }

        if ($row->sub_sub_grp_value == 'SECSUB') {
          $data['second_sub_group'] = $this->second_sub_group_model->select_one_active_record('article_second_subgroup_master', $this->session->userdata['logged_in']['company_id'], 'article_second_subgroup_master.sub_sub_grp_id', $row->sub_sub_grp_id);
          foreach ($data['second_sub_group'] as $second_sub_group_row) {
            $second_sub_group_initial = $second_sub_group_row->second_sub_group_short_id . $row->seperator;
          }
        } else if ($row->sub_sub_grp_value == '') {
          $second_sub_group_initial = "";
        } else {
          $second_sub_group_initial = $row->sub_sub_grp_value . $row->seperator;
        }

        $count = $this->common_model->active_record_count_where('article', $this->session->userdata['logged_in']['company_id'], 'main_group_id', $this->input->post('main_group'), 'article_group_id', $this->input->post('sub_group'), 'sub_sub_grp_id', $this->input->post('second_sub_group'));
        $count = $row->step_by + $count + $row->start_value;
        $count = str_pad($count, $row->number_of_digits, 0, STR_PAD_LEFT);

        $data['number'] = $main_group_initial . $sub_group_initial . $second_sub_group_initial . $count;
      }
    }
    $this->load->view(ucwords($this->router->fetch_class()) . '/main-group-article-load-option', $data);
  }

  public function customer()
  {
    $edit = $this->input->get('q');
    $data = array('address_master.name1' => $edit);
    $this->load->model('customer_model');
    $data['customer'] = $this->customer_model->active_record_customer_search('address_master', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/customer-load-option', $data);
  }

  public function customer_address()
  {

    if (!empty($this->input->post('adr_company_id'))) {
      $arr = explode('//', $this->input->post('adr_company_id'));
      if (!empty($arr[1])) {
        $data = array('address_master.adr_company_id' => $arr[1]);
        $this->load->model('customer_model');
        $data['customer'] = $this->customer_model->active_record_customer_bill_to_address('address_master', $data, $this->session->userdata['logged_in']['company_id']);
        $this->load->view(ucwords($this->router->fetch_class()) . '/customer-address-load-option', $data);
      }
    }
  }

  public function customer_max_lead_time()
  {

    if (!empty($this->input->post('adr_company_id'))) {
      $arr = explode('//', $this->input->post('adr_company_id'));
      if (!empty($arr[1])) {
        $data = array('address_master.adr_company_id' => $arr[1]);
        $this->load->model('customer_model');
        $data['customer'] = $this->customer_model->active_record_customer_bill_to_address('address_master', $data, $this->session->userdata['logged_in']['company_id']);
        $this->load->view(ucwords($this->router->fetch_class()) . '/customer-max-lead-time-load-option', $data);
      }
    }
  }
  public function shipping_address()
  {
    //echo $this->input->post('consin_adr_company_id');

    if (!empty($this->input->post('consin_adr_company_id'))) {
      $data = array('address_master.adr_company_id' => $this->input->post('consin_adr_company_id'));
      $this->load->model('customer_model');
      $data['customer'] = $this->customer_model->active_record_customer_bill_to_address('address_master', $data, $this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()) . '/customer-address-load-option', $data);
    }
  }

  public function bill_to()
  {

    if (!empty($this->input->post('customer'))) {

      $data = array('address_master.name1' => $this->input->post('customer'));
      $this->load->model('customer_model');
      $data['customer'] = $this->customer_model->active_record_customer_search('address_master', $data, $this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()) . '/customer-checkbox-load-option', $data);
    }
  }


  public function supplier()
  {
    $edit = $this->input->get('q');
    $data = array('address_master.name1' => $edit);
    $this->load->model('supplier_model');
    $data['supplier'] = $this->supplier_model->active_record_search('address_master', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/supplier-load-option', $data);
  }

  public function so_no_only_open()
  {
    $edit = $this->input->get('q');
    $data = array('order_no' => $edit);
    $this->load->model('sales_order_book_model');
    $data['order_master'] = $this->sales_order_book_model->select_open_orders('order_master', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/so-no-load-option', $data);
  }

  public function so_no_transaction_open()
  {
    $edit = $this->input->get('q');
    $data = array('order_no' => $edit);
    $this->load->model('sales_order_book_model');
    $data['order_master'] = $this->sales_order_book_model->select_transaction_open_orders('order_master', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/so-no-load-option', $data);
  }

  public function spring_so_no_for_production()
  {
    $edit = $this->input->get('q');
    //$data=array('order_no'=>$edit,'order_closed<>'=>'1','trans_closed<>'=>'1',         'final_approval_flag'=>'1');
    $this->load->model('sales_order_book_model');
    $data['order_master'] = $this->sales_order_book_model->spring_open_orders_for_extrusion('order_master', $edit, $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/so-no-load-option', $data);
  }

  public function so_no()
  {
    $edit = $this->input->get('q');
    $data = array('order_no' => $edit);
    //$this->load->model('common_model');
    //$data['order_master']=$this->common_model->active_record_search('order_master',$data,$this->session->userdata['logged_in']['company_id']);
    $this->load->model('sales_order_book_model');
    $data['order_master'] = $this->sales_order_book_model->select_orders_for_autocomplete('order_master', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/so-no-load-option', $data);
  }
  // Sales order Product list on SO autocomplte
  public function psm_psp_no()
  {
    $edit = $this->input->post('order_no');
    //$data=array('order_no'=>$edit);  
    $this->load->model('common_model');
    $data['order_details'] = $this->common_model->select_one_details_record('order_details', $this->session->userdata['logged_in']['company_id'], 'order_no', $edit);
    echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/psm-psp-load-option', $data);
  }
  public function spsm_spsp_no()
  {
    $edit = $this->input->post('order_no');
    //$data=array('order_no'=>$edit);  
    $this->load->model('common_model');
    $data['order_details'] = $this->common_model->select_one_details_record('order_details', $this->session->userdata['logged_in']['company_id'], 'order_no', $edit);
    //echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/psm-psp-load-option', $data);
  }

  public function ar_invoice_no()
  {
    $edit = $this->input->get('q');
    $data = array('ar_invoice_no' => $edit);
    $this->load->model('common_model');
    $data['ar_invoice_master'] = $this->common_model->active_record_search('ar_invoice_master', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/invoice-no-load-option', $data);
  }


  public function bom_no_autocomplete()
  {
    $edit = $this->input->get('q');
    $data = array('bom_no' => $edit);
    $this->load->model('common_model');
    $data['bill_of_material'] = $this->common_model->active_record_search('bill_of_material', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/bom-no-load-option', $data);
  }



  public function cap_article_no()
  {
    $edit = $this->input->get('q');
    $this->load->model('specification_model');
    $data['article'] = $this->specification_model->select_cap_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_name_info.lang_article_description', $edit, 'specification_sheet.final_approval_flag', '1');
    //echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/cap-article-load-option', $data);
  }

  public function label()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $query = $this->db->query("SELECT ANI.article_no,ANI.lang_article_description,A.main_group_id FROM article A, article_name_info ANI WHERE A.article_no = ANI.article_no AND A.archive <>1 AND A.company_id =  '" . $this->session->userdata['logged_in']['company_id'] . "' AND A.main_group_id IN('5') AND ANI.company_id = '" . $this->session->userdata['logged_in']['company_id'] . "' AND ( ANI.lang_article_description LIKE '%" . $edit . "%' OR ANI.article_no like  '%" . $edit . "%') ORDER BY ANI.lang_article_description");

    $data['article'] = $query->result();
    $this->load->view(ucwords($this->router->fetch_class()) . '/label-article-load-option', $data);
  }

  public function cap_spec_no()
  {
    $edit = $this->input->get('q');
    $this->load->model('specification_model');
    $data['cap_spec_no'] = $this->specification_model->select_one_active_record_cap('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'specification_sheet.spec_id', $edit, 'specification_sheet.final_approval_flag', '1');
    //echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/cap-spec-load-option', $data);
  }

  public function cap_spec_version_no()
  {
    if (!empty($this->input->post('cap_spec_no'))) {
      $this->load->model('specification_model');
      $data['cap_spec_version_no'] = $this->specification_model->select_cap_specification_final_verion_no('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'specification_sheet.spec_id', $this->input->post('cap_spec_no'), 'specification_sheet.final_approval_flag', '1');
      echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()) . '/cap-spec-version-load-option', $data);
    }
  }

  public function cap_spec_details()
  {
    $this->load->model('sales_order_book_model');
    $data = array('spec_id' => $this->input->post('cap_spec_no'), 'spec_version_no' => $this->input->post('cap_spec_version_no'));
    $data['cap_spec_details'] = $this->sales_order_book_model->select_cap_specs_record('specification_sheet_details', $this->session->userdata['logged_in']['company_id'], $data);
    $this->load->model('specification_model');
    $data['specification'] = $this->specification_model->select_one_active_record('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'specification_sheet.spec_id', $this->input->post('cap_spec_no'), 'specification_sheet.spec_version_no', $this->input->post('cap_spec_version_no'));
    //echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/cap-spec-details-load-option', $data);
  }


  public function article_no()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->finish_good_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function any_article_no()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->select_any_article('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function pricing_grid()
  {
    $edit = $this->input->get('q');
    $this->load->model('product_block_pricing_model');
    $data['pg'] = $this->product_block_pricing_model->select_distinct_price_grid('product_block_pricing', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/pg-load-option', $data);
  }

  //All SPSP SPSM for Spring Tube------------------

  public function article_no_springtube()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->finish_good_active_record_search_springtube('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }



  public function raw_material_article_no()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->raw_material_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }
  public function raw_material_autocomplet_tally()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->raw_material_search_for_tally('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function purchase_article_no()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->purchase_good_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function mannual_issue_article_no()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->mannual_issue_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }
  public function mannual_issue_article_no_open()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->mannual_issue_active_record_search_open('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function packing_article_no()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->packing_good_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function version_no()
  {
    if (!empty($this->input->post('article_no'))) {
      $arr = explode('//', $this->input->post('article_no'));
      $this->load->model('artwork_model');
      $data['version'] = $this->artwork_model->select_artwork_verion_no('artwork_devel_master', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1]);
      $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()) . '/artwork-version-load-option', $data);
    }
  }

  public function product_block_pricing_version_no()
  {
    if (!empty($this->input->post('article_no'))) {
      $arr = explode('//', $this->input->post('article_no'));
      $this->load->model('product_block_pricing_model');
      $data['version'] = $this->product_block_pricing_model->select_product_block_pricing_verion_no('product_block_pricing', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1]);
      $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()) . '/product-block-pricing-version-load-option', $data);
    }
  }

  //Artwork Version no for Spring Tube---------------------
  public function artwork_version_no_springtube()
  {
    if (!empty($this->input->post('article_no'))) {
      $arr = explode('//', $this->input->post('article_no'));
      $this->load->model('artwork_springtube_model');
      $data['version'] = $this->artwork_springtube_model->select_artwork_version_no('springtube_artwork_devel_master', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1]);
      $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()) . '/artwork-version-load-option', $data);
    }
  }

  public function spec_version_no()
  {
    if (!empty($this->input->post('article_no'))) {
      $arr = explode('//', $this->input->post('article_no'));
      $this->load->model('specification_model');
      $data['spec_version_no'] = $this->specification_model->select_specification_verion_no('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1]);
      echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()) . '/specification-version-load-option', $data);
    }
  }

  public function bom_version_no()
  {
    if (!empty($this->input->post('article_no'))) {
      $arr = explode('//', $this->input->post('article_no'));
      if ($arr[1] != '') {

        $this->load->model('bill_of_material_model');
        $data['bom_version_no_result'] = $this->bill_of_material_model->select_bom_verion_no('bill_of_material', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1]);
        //echo $this->db->last_query();
        $this->load->view(ucwords($this->router->fetch_class()) . '/bom-version-load-option', $data);
      }
    }
  }

  public function artwork_final_version_no()
  {
    if (!empty($this->input->post('article_no'))) {
      $arr = explode('//', $this->input->post('article_no'));
      $this->load->model('artwork_model');

      $data['artwork_final_nonapproved_version_no'] = $this->artwork_model->select_artwork_final_version('artwork_devel_master', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1], 'final_approval_flag', '0', 'archive<>', '1', 'ad_date', 'desc', 'ad_id', 'desc', 'version_no', 'desc');

      $data['artwork_final_version_no'] = $this->artwork_model->select_artwork_final_version('artwork_devel_master', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1], 'final_approval_flag', '1', 'archive<>', '1', 'ad_date', 'desc', 'ad_id', 'desc', 'version_no', 'desc');
      echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()) . '/artwork-final-version-load-option', $data);
    }
  }

  public function machine_type()
  {
    if (!empty($this->input->post('print_type'))) {
      $print_type = $this->input->post('print_type');
      $this->load->model('common_model');
      $data['machine'] = $this->common_model->select_one_active_record('coex_machine_master', $this->session->userdata['logged_in']['company_id'], 'coex_machine_master.machine_print_type', $print_type);
      echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()) . '/machine-type-load-option', $data);
    }
  }

  public function machine_type_details()
  {
    if (!empty($this->input->post('machine_type'))) {
      $machine_type = $this->input->post('machine_type');

      $this->load->model('common_model');
      $data['machine_name'] = $this->common_model->select_one_active_record('coex_machine_master', $this->session->userdata['logged_in']['company_id'], 'coex_machine_master.machine_id', $machine_type);
      //echo $this->db->last_query();
      if ($data['machine_name']) {
        foreach ($data['machine_name'] as $row) {
          echo $row->running_speed;
        }
      } else {
        echo "Contact to Admin";
      }
      //$this->load->view(ucwords($this->router->fetch_class()).'/machine-type-load-option',$data);
    }
  }

  public function machine_type_min_contribution()
  {
    if (!empty($this->input->post('machine_type'))) {
      $machine_type = $this->input->post('machine_type');

      $this->load->model('common_model');
      $data['machine_name'] = $this->common_model->select_one_active_record('coex_machine_master', $this->session->userdata['logged_in']['company_id'], 'coex_machine_master.machine_id', $machine_type);
      //echo $this->db->last_query();
      if ($data['machine_name']) {
        foreach ($data['machine_name'] as $row) {
          echo $row->minimum_contribution;
        }
      } else {
        echo "Contact to Admin";
      }
      //$this->load->view(ucwords($this->router->fetch_class()).'/machine-type-load-option',$data);
    }
  }

  public function machine_type_jobchangeover_details()
  {
    if (!empty($this->input->post('machine_type'))) {
      $machine_type = $this->input->post('machine_type');

      $this->load->model('common_model');
      $data['machine_name'] = $this->common_model->select_one_active_record('coex_machine_master', $this->session->userdata['logged_in']['company_id'], 'coex_machine_master.machine_id', $machine_type);
      //echo $this->db->last_query();
      if ($data['machine_name']) {
        foreach ($data['machine_name'] as $row) {
          echo $row->job_changeover;
        }
      } else {
        echo "0";
      }
      //$this->load->view(ucwords($this->router->fetch_class()).'/machine-type-load-option',$data);
    }
  }

  public function machine_type_capacity_details()
  {
    if (!empty($this->input->post('machine_type'))) {
      $machine_type = $this->input->post('machine_type');
      $this->load->model('common_model');
      $data['machine_name'] = $this->common_model->select_one_active_record('coex_machine_master', $this->session->userdata['logged_in']['company_id'], 'coex_machine_master.machine_id', $machine_type);
      //echo $this->db->last_query();
      if ($data['machine_name']) {
        foreach ($data['machine_name'] as $row) {
          echo $row->machine_capacity_without_changeover;
        }
      } else {
        echo "0";
      }
      //$this->load->view(ucwords($this->router->fetch_class()).'/machine-type-load-option',$data);
    }
  }


  public function shoulder()
  {
    if (!empty($this->input->post('sleeve_dia'))) {
      $arr = explode('//', $this->input->post('sleeve_dia'));
      $this->load->model('combination_model');
      $data['shoulder'] = $this->combination_model->select_shoulder_active_record('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], 'shoulder_orifice_dependancy.sleeve_id', $arr[1]);
      echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()) . '/shoulder-load-option', $data);
    }
  }

  public function shoulder_orifice()
  {
    $sleeve_dia = explode('//', $this->input->post('sleeve_dia'));
    $shoulder = explode('//', $this->input->post('shoulder'));
    $this->load->model('combination_model');
    $data['shoulder_orifice'] = $this->combination_model->select_shoulder_orifice_active_record('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], 'shoulder_orifice_dependancy.sleeve_id', $sleeve_dia[1], 'shoulder_orifice_dependancy.shld_type_id', $shoulder[1]);
    echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/shoulder-orifice-load-option', $data);
  }

  public function cap_type()
  {
    $sleeve_dia = explode('//', $this->input->post('sleeve_dia'));
    $shoulder = explode('//', $this->input->post('shoulder'));
    $shoulder_orifice = explode('//', $this->input->post('shoulder_orifice'));
    $this->load->model('combination_model');
    $data['cap_type'] = $this->combination_model->select_cap_type_active_record('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], 'shoulder_orifice_dependancy.sleeve_id', $sleeve_dia[1], 'shoulder_orifice_dependancy.shld_type_id', $shoulder[1]);
    echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/cap-type-load-option', $data);
  }

  public function spec_cap_finish()
  {
    $cap_type = explode('//', $this->input->post('cap_type'));
    $this->load->model('combination_model');
    $data['cap_finish'] = $this->combination_model->select_spec_cap_finish_active_record('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], 'shoulder_orifice_dependancy.cap_type_id', $cap_type[1]);

    $this->load->view(ucwords($this->router->fetch_class()) . '/cap-finish-load-option', $data);
  }

  public function cap_finish()
  {
    $sleeve_dia = explode('//', $this->input->post('sleeve_dia'));
    $shoulder = explode('//', $this->input->post('shoulder'));
    $cap_type = explode('//', $this->input->post('cap_type'));
    $this->load->model('combination_model');
    $data['cap_finish'] = $this->combination_model->select_cap_finish_active_record('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], 'shoulder_orifice_dependancy.sleeve_id', $sleeve_dia[1], 'shoulder_orifice_dependancy.shld_type_id', $shoulder[1], 'shoulder_orifice_dependancy.cap_type_id', $cap_type[1]);
    $this->load->view(ucwords($this->router->fetch_class()) . '/cap-finish-load-option', $data);
  }

  public function spec_cap_dia()
  {
    $cap_type = explode('//', $this->input->post('cap_type'));
    $cap_finish = explode('//', $this->input->post('cap_finish'));
    $this->load->model('combination_model');
    $data['cap_dia'] = $this->combination_model->select_spec_cap_dia_active_record('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], 'shoulder_orifice_dependancy.cap_type_id', $cap_type[1], 'shoulder_orifice_dependancy.cap_finish_id', $cap_finish[1]);
    $this->load->view(ucwords($this->router->fetch_class()) . '/cap-dia-load-option', $data);
  }


  public function cap_dia()
  {
    $sleeve_dia = explode('//', $this->input->post('sleeve_dia'));
    $shoulder = explode('//', $this->input->post('shoulder'));
    $cap_type = explode('//', $this->input->post('cap_type'));
    $cap_finish = explode('//', $this->input->post('cap_finish'));
    $this->load->model('combination_model');
    $data['cap_dia'] = $this->combination_model->select_cap_dia_active_record('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], 'shoulder_orifice_dependancy.sleeve_id', $sleeve_dia[1], 'shoulder_orifice_dependancy.shld_type_id', $shoulder[1], 'shoulder_orifice_dependancy.cap_type_id', $cap_type[1], 'shoulder_orifice_dependancy.cap_finish_id', $cap_finish[1]);
    $this->load->view(ucwords($this->router->fetch_class()) . '/cap-dia-load-option', $data);
  }

  public function spec_cap_orifice()
  {
    $cap_type = explode('//', $this->input->post('cap_type'));
    $cap_finish = explode('//', $this->input->post('cap_finish'));
    $cap_dia = explode('//', $this->input->post('cap_dia'));
    $this->load->model('combination_model');
    $data['cap_orifice'] = $this->combination_model->select_spec_cap_orifice_active_record('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], 'shoulder_orifice_dependancy.cap_type_id', $cap_type[1], 'shoulder_orifice_dependancy.cap_finish_id', $cap_finish[1], 'shoulder_orifice_dependancy.cap_dia_id', $cap_dia[1]);

    $this->load->view(ucwords($this->router->fetch_class()) . '/cap-orifice-load-option', $data);
  }

  public function cap_orifice()
  {
    $sleeve_dia = explode('//', $this->input->post('sleeve_dia'));
    $shoulder = explode('//', $this->input->post('shoulder'));
    $cap_type = explode('//', $this->input->post('cap_type'));
    $cap_finish = explode('//', $this->input->post('cap_finish'));
    $cap_dia = explode('//', $this->input->post('cap_dia'));
    $this->load->model('combination_model');
    $data['cap_orifice'] = $this->combination_model->select_cap_orifice_active_record('shoulder_orifice_dependancy', $this->session->userdata['logged_in']['company_id'], 'shoulder_orifice_dependancy.sleeve_id', $sleeve_dia[1], 'shoulder_orifice_dependancy.shld_type_id', $shoulder[1], 'shoulder_orifice_dependancy.cap_type_id', $cap_type[1], 'shoulder_orifice_dependancy.cap_finish_id', $cap_finish[1], 'shoulder_orifice_dependancy.cap_dia_id', $cap_dia[1]);
    $this->load->view(ucwords($this->router->fetch_class()) . '/cap-orifice-load-option', $data);
  }


  public function top_customer_order()
  {
    $month = $this->input->post('month');
    $year = $this->input->post('year');
    $this->load->model('sales_order_book_model');
    $table = 'order_master';
    include('pagination.php');
    $data['top_orders'] = $this->sales_order_book_model->select_top_customers_orders($config["per_page"], $this->uri->segment(3), 'order_master', $this->session->userdata['logged_in']['company_id'], $year, $month);
    $this->load->view(ucwords($this->router->fetch_class()) . '/top-customer-order-load-option', $data);
  }

  public function currency_rate()
  {
    $currency = $this->input->post('currency');
    $data['currency_rate'] = $this->common_model->select_updated_currency_rate('currency_history', 'to_currency', $currency, 'date_created', 'desc');
    $this->load->view(ucwords($this->router->fetch_class()) . '/currency-rate-load-option', $data);
  }

  public function price_list_drop()
  {
    $customer_category = $this->input->post('customer_category');
    $this->load->model('product_block_pricing_model');
    $data['price_list'] = $this->product_block_pricing_model->select_distinct_price_grid_by_customer('product_block_pricing', $customer_category, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/price-list-load-option', $data);
  }

  public function tax_grid()
  {
    $edit = $this->input->post('tax_grid');
    $data['amount'] = $this->input->post('amount');
    $data['tax_grid'] = $this->common_model->select_tax_record('tax_grid_details', $this->session->userdata['logged_in']['company_id'], 'tax_id', $edit);
    $this->load->view(ucwords($this->router->fetch_class()) . '/tax-grid-load-option', $data);
  }


  public function ship_to()
  {

    if (!empty($this->input->post('adr_company_id'))) {
      $customer_arr = explode('//', $this->input->post('adr_company_id'));
      $this->load->model('relate_model');
      $data['ship_to'] = $this->relate_model->select_one_active_record('adr_relate_companies', $this->session->userdata['logged_in']['company_id'], 'adr_relate_companies.adr_company_id', $customer_arr[1], $this->session->userdata['logged_in']['language_id']);
      $this->load->view(ucwords($this->router->fetch_class()) . '/ship-to-load-option', $data);
    } else {
      echo "Select the Customer";
    }
  }


  public function spec_final_version_no()
  {
    if (!empty($this->input->post('article_no'))) {
      $arr = explode('//', $this->input->post('article_no'));
      if (!empty($arr[1])) {
        $this->load->model('artwork_model');

        $data['specification_final_version_no'] = $this->artwork_model->select_artwork_final_version('specification_sheet', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1], 'final_approval_flag', '1', 'archive<>', '1', 'spec_created_date', 'desc', 'spec_id', 'desc', 'spec_version_no', 'desc');

        $this->load->view(ucwords($this->router->fetch_class()) . '/specification-final-version-load-option', $data);
      } else {
        echo "Select Product";
      }
    } else {
    }
  }

  public function bom_no()
  {
    if (!empty($this->input->post('article_no'))) {
      $arr = explode('//', $this->input->post('article_no'));
      if (!empty($arr[1])) {
        $this->load->model('artwork_model');

        if (substr($arr[1], 0, 2) == "PS" || substr($arr[1], 0, 2) == "SR") {
          $data['artwork_final_nonapproved_version_no'] = $this->artwork_model->select_artwork_final_version('artwork_devel_master', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1], 'final_approval_flag', '0', 'archive<>', '1', '', '', 'ad_id', 'desc', 'version_no', 'desc');

          $data['artwork_final_version_no'] = $this->artwork_model->select_artwork_final_version('artwork_devel_master', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1], 'final_approval_flag', '1', 'archive<>', '1', '', '', 'ad_id', 'desc', 'version_no', 'desc');
        } else {

          $data['artwork_final_nonapproved_version_no'] = $this->artwork_model->select_artwork_final_version('springtube_artwork_devel_master', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1], 'final_approval_flag', '0', 'archive<>', '1', '', '', 'ad_id', 'desc', 'version_no', 'desc');

          $data['artwork_final_version_no'] = $this->artwork_model->select_artwork_final_version('springtube_artwork_devel_master', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1], 'final_approval_flag', '1', 'archive<>', '1', '', '', 'ad_id', 'desc', 'version_no', 'desc');
        }



        $this->load->model('bill_of_material_model');
        $this->load->model('sales_order_book_model');
        $this->load->model('artwork_springtube_model');


        //print_r($data['artwork_final_version_no');
        $dataa = array(
          'article_no' => $arr[1],
          'final_approval_flag' => '1'
        );

        $data['bom_final_version_no'] = $this->artwork_model->select_artwork_final_version('bill_of_material', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1], 'final_approval_flag', '1', 'archive<>', '1', 'bom_creation_date', 'desc', 'bom_no', 'desc', 'bom_version_no', 'desc');

        $data['bom_final_nonapproved_version_no'] = $this->artwork_model->select_artwork_final_version('bill_of_material', $this->session->userdata['logged_in']['company_id'], 'article_no', $arr[1], 'final_approval_flag', '0', 'archive<>', '1', 'bom_creation_date', 'desc', 'bom_no', 'desc', 'bom_version_no', 'desc');

        //$data['bom_no']=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$dataa);

        $this->load->view(ucwords($this->router->fetch_class()) . '/bom-load-option', $data);
      } else {
        echo "Select Product";
      }
    } else {
    }
  }


  public function state()
  {
    $country = $this->input->post('country');
    $data['state'] = $this->common_model->select_one_active_record_noncompany('zip_code_master', 'country_id', $country);
    $this->load->view(ucwords($this->router->fetch_class()) . '/state-load-option', $data);
  }

  public function sleeve_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->sleeve_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function shoulder_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->shoulder_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function cap_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->cap_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function label_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->label_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function paper_film_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->paper_film_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function approved_sleeve_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('sleeve_specification_model');
    $data['article'] = $this->sleeve_specification_model->approved_record_search_for_bom('specification_sheet', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function approved_paper_film_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('paper_film_specification_model');
    $data['article'] = $this->paper_film_specification_model->approved_record_search_for_bom_paper_film('specification_sheet', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function approved_shoulder_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('shoulder_specification_model');
    $data['article'] = $this->shoulder_specification_model->approved_record_search_for_bom('specification_sheet', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function approved_cap_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('cap_specification_model');
    $data['article'] = $this->cap_specification_model->approved_record_search_for_bom('specification_sheet', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }

  public function approved_label_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('label_specification_model');
    $data['article'] = $this->label_specification_model->approved_record_search_for_bom('specification_sheet', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }


  public function get_rm_for_issue()
  {
    $article_no = $this->input->post('article_no');
    if ($article_no != '') {
      $this->load->model('job_card_model');
      echo $this->job_card_model->get_available_qty($article_no);
    }
  }

  public function jobcard_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('job_card_model');
    $data['jobcard'] = $this->job_card_model->jobcard_active_record_search('production_master', $edit, $this->session->userdata['logged_in']['company_id']);

    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->waste_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/jobcard-load-option', $data);
  }

  public function coex_jobcard_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('job_card_model');
    $data['jobcard'] = $this->job_card_model->jobcard_active_record_search_coex('production_master', $edit, $this->session->userdata['logged_in']['company_id']);

    $this->load->view(ucwords($this->router->fetch_class()) . '/coex-jobcard-load-option', $data);
  }

  public function customer_category_autocomplete()
  {


    $dataa = array('category_name' => $this->input->get('q'));
    $this->load->model('common_model');
    $data['customer_category'] = $this->common_model->active_record_search('address_category_master', $dataa, $this->session->userdata['logged_in']['company_id']);

    $this->load->view(ucwords($this->router->fetch_class()) . '/customer-category-load-option', $data);
  }

  public function primary_contact_autocomplete()
  {


    $dataa = array('contact_name' => $this->input->get('q'));
    $this->load->model('common_model');
    $data['contact_details'] = $this->common_model->active_record_search('address_category_contact_details', $dataa, $this->session->userdata['logged_in']['company_id']);

    $this->load->view(ucwords($this->router->fetch_class()) . '/contact-details-load-option', $data);
  }
  public function sales_quote_customer_autocomplete()
  {

    $dataa = array('customer_name' => $this->input->get('q'));
    $this->load->model('common_model');
    $data['sales_quote_customer_master'] = $this->common_model->active_record_search('sales_quote_customer_master', $dataa, $this->session->userdata['logged_in']['company_id']);

    $this->load->view(ucwords($this->router->fetch_class()) . '/sales-quote-customer-load-option', $data);
  }
  public function purchase_manager()
  {

    if (!empty($this->input->post('customer'))) {
      $customer_id = '';
      $customer_arr = explode('//', $this->input->post('customer'));
      if (count($customer_arr) > 1) {
        $customer_id = $customer_arr[1];
      }
      $this->load->model('common_model');
      $search = array(
        'adr_category_id' => $customer_id,
        'archive' => '0',
        'active' => '1'
      );

      $data['sales_quote_customer_contact_details'] = $this->common_model->select_active_records_where('address_category_contact_details', $this->session->userdata['logged_in']['company_id'], $search);
      echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()) . '/purchase-manager-load-option', $data);
    } else {
      echo "Select the Customer";
    }
  }

  public function psm_psp_jobcards()
  {
    if (!empty($this->input->post('article_no'))) {
      $article_no = $this->input->post('article_no');
      $arr = array(
        'article_no' => $article_no,
        'sales_ord_no' => $this->input->post('order_no'),
        'archive' => 0
      );
      $data['production_master'] = $this->common_model->select_active_records_where('production_master', $this->session->userdata['logged_in']['company_id'], $arr);
      $this->load->view(ucwords($this->router->fetch_class()) . '/jobcard-select-load-option', $data);
    }
  }

  public function jobcard_no()
  {
    if (!empty($this->input->post('jobcard_no'))) {
      $jobcard_no = $this->input->post('jobcard_no');
      $arr = array('mp_pos_no' => $jobcard_no);
      $data['production_master'] = $this->common_model->select_active_records_where('production_master', $this->session->userdata['logged_in']['company_id'], $arr);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()) . '/jobcard-order-details-select-load-option', $data);
      //$this->load->view(ucwords($this->router->fetch_class()).'/jobcard-product-details-select-load-option',$data);

    }
  }

  public function get_order_no()
  {
    if (!empty($this->input->post('jobcard_no'))) {
      $jobcard_no = $this->input->post('jobcard_no');
      $arr = array('mp_pos_no' => $jobcard_no);
      $result = $this->common_model->select_active_records_where('production_master', $this->session->userdata['logged_in']['company_id'], $arr);
      //echo $this->db->last_query();
      if ($result) {
        foreach ($result as $row) {
          echo $row->sales_ord_no;
        }
      } else {
        echo "Contact to Admin";
      }
    }
  }

  public function get_article_no()
  {
    if (!empty($this->input->post('jobcard_no'))) {
      $jobcard_no = $this->input->post('jobcard_no');
      $arr = array('mp_pos_no' => $jobcard_no);
      $result = $this->common_model->select_active_records_where('production_master', $this->session->userdata['logged_in']['company_id'], $arr);
      //echo $this->db->last_query();
      if ($result) {
        foreach ($result as $row) {
          echo $row->article_no;
        }
      } else {
        echo "Contact to Admin";
      }
    }
  }

  public function jobcard_details_dia()
  {

    $order_no = $this->input->post('order_no');

    $data = array('order_no' => $order_no);

    $result = $this->common_model->select_one_active_record_with_limit('order_details', $this->session->userdata['logged_in']['company_id'], $data, '', '1', '0');

    //echo $this->db->last_query();
    if ($result) {
      foreach ($result as $row) {
        echo $row->sleeve_dia;
      }
    } else {
      echo "Contact to Admin";
    }
  }

  public function jobcard_details_length()
  {

    $order_no = $this->input->post('order_no');

    $data = array('order_no' => $order_no);

    $result = $this->common_model->select_one_active_record_with_limit('order_details', $this->session->userdata['logged_in']['company_id'], $data, '', '1', '0');

    //echo $this->db->last_query();
    if ($result) {
      foreach ($result as $row) {
        echo $row->sleeve_length;
      }
    } else {
      echo "Contact to Admin";
    }
  }

  public function jobcard_details_dia_length()
  {

    $order_no = $this->input->post('order_no');

    $data = array('order_no' => $order_no);

    $result = $this->common_model->select_one_active_record_with_limit('order_details', $this->session->userdata['logged_in']['company_id'], $data, '', '1', '0');

    //echo $this->db->last_query();
    if ($result) {
      foreach ($result as $row) {
        echo $row->sleeve_dia . " X " . $row->sleeve_length;
      }
    } else {
      echo "Contact to Admin";
    }
  }

  public function get_artwork_details()
  {
    if (!empty($this->input->post('article_no'))) {
      $article_no = $this->input->post('article_no');
      $order_no = $this->input->post('order_no');
      $arr = array(
        'order_no' => $this->input->post('order_no'),
        'article_no' => $article_no
      );
      $data['order_details'] = $this->common_model->select_active_records_where('order_details', $this->session->userdata['logged_in']['company_id'], $arr);

      foreach ($data['order_details'] as  $row) {
        echo $row->ad_id . "//" . $row->version_no;
      }
    }
  }

  public function capa()
  {
    if (!empty($this->input->post('from_date'))) {
      $data['from_date'] = $this->input->post('from_date');
      $data['to_date'] = $this->input->post('to_date');
      $this->load->model('complaint_register_model');
      $this->load->model('fiscal_model');

      $data['capa'] = $this->complaint_register_model->capa_mis();
      $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);
      $this->load->model('complaint_register_model');
      $this->load->view(ucwords($this->router->fetch_class()) . '/capa-report-load-option', $data);
    }
  }

  public function domestic_export_sales()
  {
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');
      $this->input->post('sleeve_dia');

      $sleeve_dia = str_replace("&", "", $this->input->post('sleeve_dia'));
      $sleeve_diaaa = str_replace("+", " ", $sleeve_dia);
      $sleeve_diaa = str_replace("sleeve_dia=", "','", $sleeve_diaaa);
      $AddToEnd = "'";
      $sleeve_diaaaaa = substr($sleeve_diaa . $AddToEnd, 2);
      $data['sleeve_dia_data'] = $sleeve_diaaaaa;

      $inv_type = str_replace("&", "", $this->input->post('inv_type'));
      $inv_typee = ltrim(str_replace("inv_type=", ",", $inv_type), ',');
      $data['inv_type_data'] = $inv_typee;

      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;

      $this->load->model('sales_invoice_book_model');
      $table = "ar_invoice_master";

      $data['domestic_export_sales'] = $this->sales_invoice_book_model->select_domestic_export_wise_sales($table, $from_date, $to_date, $sleeve_diaaaaa, $inv_typee);
      //echo  $this->db->last_query();
      //$data['dia_wise_sales_coex']=$this->sales_invoice_book_model->select_dia_wise_coex_sales_record($table,$from_date,$to_date,$sleeve_diaaaaa,$inv_typee);
      //$data['dia_wise_sales_spring']=$this->sales_invoice_book_model->select_dia_wise_spring_sales_record($table,$from_date,$to_date,$sleeve_diaaaaa,$inv_typee);
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/domestic-export-sales-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/domestic-export-sales-million-load-option', $data);
      }
    }
  }


  public function dia_wise_sales()
  {
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');
      $this->input->post('sleeve_dia');

      $sleeve_dia = str_replace("&", "", $this->input->post('sleeve_dia'));
      $sleeve_diaaa = str_replace("+", " ", $sleeve_dia);
      $sleeve_diaa = str_replace("sleeve_dia=", "','", $sleeve_diaaa);
      $AddToEnd = "'";
      $sleeve_diaaaaa = substr($sleeve_diaa . $AddToEnd, 2);
      $data['sleeve_dia_data'] = $sleeve_diaaaaa;

      $inv_type = str_replace("&", "", $this->input->post('inv_type'));
      $inv_typee = ltrim(str_replace("inv_type=", ",", $inv_type), ',');
      $data['inv_type_data'] = $inv_typee;

      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;

      $this->load->model('sales_invoice_book_model');
      $table = "ar_invoice_master";

      $data['dia_wise_sales'] = $this->sales_invoice_book_model->select_dia_wise_sales($table, $from_date, $to_date, $sleeve_diaaaaa, $inv_typee);
      //echo  $this->db->last_query();
      //$data['dia_wise_sales_coex']=$this->sales_invoice_book_model->select_dia_wise_coex_sales_record($table,$from_date,$to_date,$sleeve_diaaaaa,$inv_typee);
      //$data['dia_wise_sales_spring']=$this->sales_invoice_book_model->select_dia_wise_spring_sales_record($table,$from_date,$to_date,$sleeve_diaaaaa,$inv_typee);
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/dia-wise-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/dia-wise-million-load-option', $data);
      }
    }
  }


  public function pending_sales_order()
  {
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_invoice_book_model');
      $data['sales_order_summary'] = $this->sales_order_book_model->pending_sales_order('order_master', $from_date, $to_date);
      $data['sales_invoice_summary'] = $this->sales_invoice_book_model->sales_summary('ar_invoice_master', $from_date, $to_date, '', '', '', '');
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/pending-sales-order-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/pending-sales-order-millions-load-option', $data);
      }
    }
  }


  public function pending_sales_order_monthwise()
  {
    if (!empty($this->input->post('from_date'))) {
      $customer_category_id = '';
      $customer_category_name = '';
      $arr = explode("//", $this->input->post('customer_category'));
      if (count($arr) > 1) {
        $customer_category_id = $arr[1];
        $customer_category_name = $arr[0];
      }

      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');


      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $data['customer_name'] = $customer_category_name;
      $this->load->model('sales_order_book_model');
      $data['pending_sales_order'] = $this->sales_order_book_model->pending_sales_order_monthwise('order_master', $from_date, $to_date, $customer_category_id);
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/pending-sales-order-monthwise-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/pending-sales-order-monthwise-million-load-option', $data);
      }
    }
  }

  public function pending_sales_order_on_delivery_date()
  {
    if (!empty($this->input->post('from_date'))) {
      $customer_category_id = '';
      $customer_category_name = '';
      $arr = explode("//", $this->input->post('customer_category'));
      if (count($arr) > 1) {
        $customer_category_id = $arr[1];
        $customer_category_name = $arr[0];
      }

      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');


      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $data['customer_name'] = $customer_category_name;
      $this->load->model('sales_order_book_model');
      $data['pending_sales_order'] = $this->sales_order_book_model->pending_sales_order_on_delivery_date('order_master', $from_date, $to_date, $customer_category_id);
      //echo $this->db->last_query();
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/pending-sales-order-delivery-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/pending-sales-order-delivery-million-load-option', $data);
      }
    }
  }


  public function pending_sales_order_on_oc_date()
  {
    if (!empty($this->input->post('from_date'))) {
      $customer_category_id = '';
      $customer_category_name = '';
      $arr = explode("//", $this->input->post('customer_category'));
      if (count($arr) > 1) {
        $customer_category_id = $arr[1];
        $customer_category_name = $arr[0];
      }

      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $data['customer_name'] = $customer_category_name;
      $this->load->model('sales_order_book_model');
      $data['pending_sales_order'] = $this->sales_order_book_model->pending_sales_order_on_oc_date('order_master', $from_date, $to_date, $customer_category_id);

      $data['pending_sales_order_without_oc'] = $this->sales_order_book_model->pending_sales_order_monthwise_without_oc('order_master', $from_date, $to_date, '');
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/pending-sales-order-on-oc-date', $data);
      } else {
        //$this->load->view(ucwords($this->router->fetch_class()).'/pending-sales-order-on-oc-date-million-load-option',$data);
      }
    }
  }

  public function approved_unapproved_pending_sales_order_on_delivery_date()
  {
    if (!empty($this->input->post('from_date'))) {
      $customer_category_id = '';
      $customer_category_name = '';
      $arr = explode("//", $this->input->post('customer_category'));
      if (count($arr) > 1) {
        $customer_category_id = $arr[1];
        $customer_category_name = $arr[0];
      }

      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');

      $order_type = str_replace("&", "", $this->input->post('order_type'));
      $order_typee = ltrim(str_replace("order_type=", ",", $order_type), ',');
      $data['order_type_data'] = $order_typee;
      //echo $this->db->last_query();
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $data['customer_name'] = $customer_category_name;
      $this->load->model('sales_order_book_model');
      $data['pending_sales_order'] = $this->sales_order_book_model->approved_unapproved_pending_sales_order_delivery_date('order_master', $from_date, $to_date, $customer_category_id, $order_typee);

      //echo $this->db->last_query();
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/approved-unapproved-pending-sales-order-delivery-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/approved-unapproved-pending-sales-order-delivery-million-load-option', $data);
      }
    }
  }

  public function pending_sales_order_by_customer()
  {
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $this->load->model('sales_order_book_model');
      $data['pending_sales_order'] = $this->sales_order_book_model->pending_sales_order_by_customer('order_master', $from_date, $to_date);
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/pending-sales-order-customer-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/pending-sales-order-customer-millions-load-option', $data);
      }
    }
  }


  public function pending_sales_order_by_cap()
  {
    if (!empty($this->input->post('from_date'))) {
      $cap_code = $this->input->post('cap_code');
      if (!empty($this->input->post('cap_code'))) {
        $cap_code_arr = explode('//', $this->input->post('cap_code'));
        $cap_code = $cap_code_arr[1];
      } else {
        $cap_code = "";
      }
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $this->load->model('sales_order_book_model');
      $data['pending_sales_order'] = $this->sales_order_book_model->pending_sales_order_by_customer_with_cap('order_master', $from_date, $to_date, $cap_code);
      $this->load->view(ucwords($this->router->fetch_class()) . '/pending-sales-order-cap-load-option', $data);
    }
  }

  public function pending_sales_order_cap_by_customer()
  {
    if (!empty($this->input->post('from_date'))) {
      $customer_category = $this->input->post('customer_category');
      if (!empty($this->input->post('customer_category'))) {
        $customer_category_arr = explode('//', $this->input->post('customer_category'));
        $customer = $customer_category_arr[1];
      } else {
        $customer = "";
      }
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $this->load->model('sales_order_book_model');
      $data['pending_sales_order'] = $this->sales_order_book_model->pending_sales_order_cap_by_customer('order_master', $from_date, $to_date, $customer);
      $this->load->view(ucwords($this->router->fetch_class()) . '/pending-sales-order-cap-by-customer-load-option', $data);
    }
  }

  public function production_monthwise()
  {
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $CI = &get_instance();
      $this->db2 = $CI->load->database('another_db', TRUE);
      $this->load->model('production_model');
      $data['extrusion'] = $this->production_model->select_extrusion_monthwise('extrusion', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date);
      $data['heading'] = $this->production_model->select_heading_monthwise('heading', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date);
      $data['printing'] = $this->production_model->select_printing_monthwise('printing', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date);

      $data['labeling'] = $this->production_model->select_labeling_monthwise('labeling', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date);

      $data['capping'] = $this->production_model->select_capping_monthwise('capping', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date);

      $data['foiling'] = $this->production_model->select_foiling_monthwise('foiling', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date);
      //echo $this->db2->last_query();
      $this->load->view(ucwords($this->router->fetch_class()) . '/production-monthwise-load-option', $data);
    }
  }


  public function top_customer_sales()
  {
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');
      $sleeve_dia = str_replace("&", "", $this->input->post('sleeve_dia'));
      $sleeve_diaaa = str_replace("+", " ", $sleeve_dia);
      //$sleeve_diaaaaa=str_replace("sleeve_dia=",",",$sleeve_diaaa);
      $sleeve_diaa = str_replace("sleeve_dia=", "','", $sleeve_diaaa);
      $AddToEnd = "'";
      $sleeve_diaaaaa = substr($sleeve_diaa . $AddToEnd, 2);
      $data['sleeve_dia_data'] = $sleeve_diaaaaa;

      $inv_type = str_replace("&", "", $this->input->post('inv_type'));
      $inv_typee = ltrim(str_replace("inv_type=", ",", $inv_type), ',');
      $data['inv_type_data'] = $inv_typee;

      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $this->load->model('sales_invoice_book_model');
      $data['top_customer_coex'] = $this->sales_invoice_book_model->select_top_customer('ar_invoice_master', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date, $sleeve_diaaaaa, $inv_typee);
      //echo $this->db->last_query();
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/top-customer-sales-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/top-customer-sales-million-load-option', $data);
      }
    }
  }



  public function top_customer_sales_diawise()
  {
    $this->load->model('fiscal_model');
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');
      $sleeve_dia = str_replace("&", "", $this->input->post('sleeve_dia'));
      $sleeve_diaaa = str_replace("+", " ", $sleeve_dia);
      //$sleeve_diaaaaa=str_replace("sleeve_dia=",",",$sleeve_diaaa);
      $sleeve_diaa = str_replace("sleeve_dia=", "','", $sleeve_diaaa);
      $AddToEnd = "'";
      $sleeve_diaaaaa = substr($sleeve_diaa . $AddToEnd, 2);
      $data['sleeve_dia_data'] = $sleeve_diaaaaa;

      $inv_type = str_replace("&", "", $this->input->post('inv_type'));
      $inv_typee = ltrim(str_replace("inv_type=", ",", $inv_type), ',');
      $data['inv_type_data'] = $inv_typee;

      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $this->load->model('sales_invoice_book_model');
      $data['top_customer_coex'] = $this->sales_invoice_book_model->select_top_customer('ar_invoice_master', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date, $sleeve_diaaaaa, $inv_typee);
      //echo $this->db->last_query();
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/top-customer-sales-diawise-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/top-customer-sales-diawise-million-load-option', $data);
      }
    }
  }

  public function ajax_top_products_costsheet()
  {
    $this->load->model('fiscal_model');
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $print_type = $this->input->post('print_type');
      $customer_category = $this->input->post('customer_category');
      if (!empty($this->input->post('customer_category'))) {
        $customer_category_arr = explode('//', $this->input->post('customer_category'));
        $customer_category = $customer_category_arr[1];
      } else {
        $customer_category = "";
      }
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $sleeve_dia = str_replace("&", "", $this->input->post('sleeve_dia'));
      $sleeve_diaaa = str_replace("+", " ", $sleeve_dia);
      //$sleeve_diaaaaa=str_replace("sleeve_dia=",",",$sleeve_diaaa);
      $sleeve_diaa = str_replace("sleeve_dia=", "','", $sleeve_diaaa);
      $AddToEnd = "'";
      $sleeve_diaaaaa = substr($sleeve_diaa . $AddToEnd, 2);
      $data['sleeve_dia_data'] = $sleeve_diaaaaa;

      $this->load->model('sales_invoice_book_model');
      $data['top_products_costsheet'] = $this->sales_invoice_book_model->select_top_product_by_costsheet('costsheet_master', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date, $sleeve_diaaaaa, $print_type, $customer_category, '');
      //echo $this->db->last_query();

      $this->load->view(ucwords($this->router->fetch_class()) . '/top-products-costsheet-load-option', $data);
    }
  }

  public function ajax_sales_pcb()
  {
    $this->load->model('fiscal_model');
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      /*$ar_invoice_no=$this->input->post('ar_invoice_no');
          $customer_category=$this->input->post('customer_category');
          if(!empty($this->input->post('customer_category'))){
          $customer_category_arr=explode('//',$this->input->post('customer_category'));
          $customer_category=$customer_category_arr[1];
          }else{
            $customer_category="";
          }*/

      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      //$data['ar_invoice_no']=$ar_invoice_no;

      $this->load->model('sales_invoice_book_model');
      $this->load->model('common_model');

      $data['ar_invoice_master'] = $this->sales_invoice_book_model->sales_report_pcb('ar_invoice_master', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date, '');
      //echo $this->db->last_query();

      $this->load->view(ucwords($this->router->fetch_class()) . '/sales-pcb-load-option', $data);
    }
  }

  public function ajax_sales_avg_dia()
  {
    $this->load->model('fiscal_model');
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');

      $convert = $this->input->post('convert');

      $customer_category = $this->input->post('customer_category');
      $customer_name = '';
      if (!empty($this->input->post('customer_category'))) {
        $customer_category_arr = explode('//', $this->input->post('customer_category'));
        $customer_category = $customer_category_arr[1];
        $customer_name = $customer_category_arr[0];
      } else {
        $customer_category = "";
      }
      $data['customer_name'] = $customer_name;
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;


      $this->load->model('sales_invoice_book_model');
      // Current year---------------
      $data['sales_avg_dia'] = $this->sales_invoice_book_model->sales_avg_dia($from_date, $to_date, $customer_category);

      // Last Year-----------------
      $from_date_last = date("Y-m-d", strtotime("-1 year", strtotime($from_date)));
      $to_date_last = date("Y-m-d", strtotime("-1 year", strtotime($to_date)));
      $data['sales_avg_dia_last_year'] = $this->sales_invoice_book_model->sales_avg_dia($from_date_last, $to_date_last, $customer_category);

      // Prevoius Year--------------
      $from_date_prev = date("Y-m-d", strtotime("-2 year", strtotime($from_date)));
      $to_date_prev = date("Y-m-d", strtotime("-2 year", strtotime($to_date)));
      $data['sales_avg_dia_prev_year'] = $this->sales_invoice_book_model->sales_avg_dia($from_date_prev, $to_date_prev, $customer_category);

      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/sales-avg-dia-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/sales-avg-dia-million-load-option', $data);
      }
    }
  }


  /* public function print_type_wise_sales_old(){ 
      if(!empty($this->input->post('from_date'))){
       $customer_category=$this->input->post('customer_category');
        $from_date= $this->input->post('from_date'); 
        $to_date=$this->input->post('to_date');
        $convert=$this->input->post('convert');
        $customer=str_replace("&","",$this->input->post('customer_no'));
        $customer_no=str_replace("customer_no=",",",$customer);
        $customer_in=substr($customer_no,1);
        $data['customer_data']=$customer_in;

        $sleeve_dia=str_replace("&","",$this->input->post('sleeve_dia'));
        $sleeve_diaaa=str_replace("+"," ",$sleeve_dia);
        $sleeve_diaa=str_replace("sleeve_dia=","','",$sleeve_diaaa);
        $AddToEnd = "'";
        $sleeve_diaaaaa=substr($sleeve_diaa.$AddToEnd,2);
        $data['sleeve_dia_data']=$sleeve_diaaaaa;

        $inv_type=str_replace("&","",$this->input->post('inv_type'));
        $inv_typee=ltrim(str_replace("inv_type=",",",$inv_type),',');
        $data['inv_type_data']=$inv_typee;

        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $for_export=$this->input->post('for_export');

        $this->load->model('sales_invoice_book_model');
        $table="ar_invoice_master";
        $data['print_type_wise_sales_coex']=$this->sales_invoice_book_model->select_print_type_wise_sales($table,$from_date,$to_date,$customer_in,$sleeve_diaaaaa,$for_export,$customer_category,$inv_typee);
        
        //$data['print_type_wise_sales_coex']=$this->sales_invoice_book_model->select_print_type_wise_coex_sales_record($table,$from_date,$to_date,$customer_in,$sleeve_diaaaaa,$for_export,$customer_category,$inv_typee);
        //$data['print_type_wise_sales_spring']=$this->sales_invoice_book_model->select_print_type_wise_spring_sales_record($table,$from_date,$to_date,$customer_in,$sleeve_diaaaaa,$for_export,$customer_category,$inv_typee);
        if($convert==0){
        $this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise-load-option',$data);
      }else{
        $this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise-million-load-option',$data);
      }
        
        }
      }
    */

  public function print_type_wise_sales()
  {

    if (!empty($this->input->post('from_date'))) {

      $customer_category_id = '';
      $customer_category_name = '';
      $customer_category = $this->input->post('customer_category');
      $arr = explode("//", $this->input->post('customer_category'));
      if (count($arr) > 1) {
        $customer_category_id = $arr[1];
        $customer_category_name = $arr[0];
      }
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');
      $customer = str_replace("&", "", $this->input->post('customer_no'));
      $customer_no = str_replace("customer_no=", ",", $customer);
      $customer_in = substr($customer_no, 1);
      $data['customer_data'] = $customer_in;

      $sleeve_dia = str_replace("&", "", $this->input->post('sleeve_dia'));
      $sleeve_diaaa = str_replace("+", " ", $sleeve_dia);
      $sleeve_diaa = str_replace("sleeve_dia=", "','", $sleeve_diaaa);
      $AddToEnd = "'";
      $sleeve_diaaaaa = substr($sleeve_diaa . $AddToEnd, 2);
      $data['sleeve_dia_data'] = $sleeve_diaaaaa;

      $inv_type = str_replace("&", "", $this->input->post('inv_type'));
      $inv_typee = ltrim(str_replace("inv_type=", ",", $inv_type), ',');
      $data['inv_type_data'] = $inv_typee;

      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $data['customer_name'] = $customer_category_name;
      $for_export = $this->input->post('for_export');

      $this->load->model('sales_invoice_book_model');
      $table = "ar_invoice_master";
      $data['print_type_wise_sales_coex'] = $this->sales_invoice_book_model->select_print_type_wise_sales($table, $from_date, $to_date, $customer_in, $sleeve_diaaaaa, $for_export, $customer_category_id, $inv_typee);

      //$data['print_type_wise_sales_coex']=$this->sales_invoice_book_model->select_print_type_wise_coex_sales_record($table,$from_date,$to_date,$customer_in,$sleeve_diaaaaa,$for_export,$customer_category,$inv_typee);
      //$data['print_type_wise_sales_spring']=$this->sales_invoice_book_model->select_print_type_wise_spring_sales_record($table,$from_date,$to_date,$customer_in,$sleeve_diaaaaa,$for_export,$customer_category,$inv_typee);
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/print-type-wise-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/print-type-wise-million-load-option', $data);
      }
    }
  }


  public function print_type_wise_contribution()
  {

    if (!empty($this->input->post('from_date'))) {

      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');

      $this->load->model('costsheet_model');
      $data['print_type_wise'] = $this->costsheet_model->contribution_print_type_wise('2022-04-01', $to_date);
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;

      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/print-type-wise-contribution-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/print-type-wise-contribution-million-load-option', $data);
      }
    }
  }

  public function contribution_by_big_dia_small_dia_with_print_type()
  {

    if (!empty($this->input->post('from_date'))) {

      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');

      $this->load->model('costsheet_model');
      $data['print_type_wise'] = $this->costsheet_model->contribution_print_type_wise($from_date, $to_date);
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;

      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/big-dia-small-dia-with-print-type-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/big-dia-small-dia-with-print-type-million-load-option', $data);
      }
    }
  }


  public function contribution_by_customer()
  {

    if (!empty($this->input->post('from_date'))) {

      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');

      $this->load->model('costsheet_model');
      $data['print_type_wise'] = $this->costsheet_model->contribution_by_customer($from_date, $to_date);
      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;

      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/contribution-by-customer-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/contribution-by-customer-million-load-option', $data);
      }
    }
  }


  public function dia_wise_saless()
  {

    if (!empty($this->input->post('from_date'))) {

      $customer_category_id = '';
      $customer_category_name = '';
      $customer_category = $this->input->post('customer_category');
      $arr = explode("//", $this->input->post('customer_category'));
      if (count($arr) > 1) {
        $customer_category_id = $arr[1];
        $customer_category_name = $arr[0];
      }
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');
      $customer = str_replace("&", "", $this->input->post('customer_no'));
      $customer_no = str_replace("customer_no=", ",", $customer);
      $customer_in = substr($customer_no, 1);
      $data['customer_data'] = $customer_in;

      $sleeve_dia = str_replace("&", "", $this->input->post('sleeve_dia'));
      $sleeve_diaaa = str_replace("+", " ", $sleeve_dia);
      $sleeve_diaa = str_replace("sleeve_dia=", "','", $sleeve_diaaa);
      $AddToEnd = "'";
      $sleeve_diaaaaa = substr($sleeve_diaa . $AddToEnd, 2);
      $data['sleeve_dia_data'] = $sleeve_diaaaaa;

      $inv_type = str_replace("&", "", $this->input->post('inv_type'));
      $inv_typee = ltrim(str_replace("inv_type=", ",", $inv_type), ',');
      $data['inv_type_data'] = $inv_typee;

      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;
      $data['customer_name'] = $customer_category_name;
      $for_export = $this->input->post('for_export');

      $this->load->model('sales_invoice_book_model');
      $table = "ar_invoice_master";
      $data['print_type_wise_sales_coex'] = $this->sales_invoice_book_model->select_dia_wise_saless($table, $from_date, $to_date, $customer_in, $sleeve_diaaaaa, $for_export, $customer_category_id, $inv_typee);

      //$data['print_type_wise_sales_coex']=$this->sales_invoice_book_model->select_print_type_wise_coex_sales_record($table,$from_date,$to_date,$customer_in,$sleeve_diaaaaa,$for_export,$customer_category,$inv_typee);
      //$data['print_type_wise_sales_spring']=$this->sales_invoice_book_model->select_print_type_wise_spring_sales_record($table,$from_date,$to_date,$customer_in,$sleeve_diaaaaa,$for_export,$customer_category,$inv_typee);
      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/dia-wise-sales-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/dia-wise-sales-million-load-option', $data);
      }
    }
  }





  public function print_type_wise_sales_order()
  {
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');

      $sleeve_dia = str_replace("&", "", $this->input->post('sleeve_dia'));
      $sleeve_diaaa = str_replace("+", " ", $sleeve_dia);
      $sleeve_diaa = str_replace("sleeve_dia=", "','", $sleeve_diaaa);
      $AddToEnd = "'";
      $sleeve_diaaaaa = substr($sleeve_diaa . $AddToEnd, 2);
      $data['sleeve_dia_data'] = $sleeve_diaaaaa;



      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;

      $this->load->model('sales_order_book_model');
      $table = "ar_invoice_master";
      $data['print_type_wise_sales_order'] = $this->sales_order_book_model->print_type_wise_sales_order($table, $from_date, $to_date);

      //$data['print_type_wise_sales_coex']=$this->sales_invoice_book_model->select_print_type_wise_coex_sales_record($table,$from_date,$to_date,$customer_in,$sleeve_diaaaaa,$for_export,$customer_category,$inv_typee);
      //$data['print_type_wise_sales_spring']=$this->sales_invoice_book_model->select_print_type_wise_spring_sales_record($table,$from_date,$to_date,$customer_in,$sleeve_diaaaaa,$for_export,$customer_category,$inv_typee);

      $this->load->view(ucwords($this->router->fetch_class()) . '/print-type-wise-sales-order-load-option', $data);
    }
  }

  public function total_order_received_by_customer()
  {
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');

      $sleeve_dia = str_replace("&", "", $this->input->post('sleeve_dia'));
      $sleeve_diaaa = str_replace("+", " ", $sleeve_dia);
      $sleeve_diaa = str_replace("sleeve_dia=", "','", $sleeve_diaaa);
      $AddToEnd = "'";
      $sleeve_diaaaaa = substr($sleeve_diaa . $AddToEnd, 2);
      $data['sleeve_dia_data'] = $sleeve_diaaaaa;



      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;

      $this->load->model('sales_order_book_model');
      $data['total_order_received_by_customer'] = $this->sales_order_book_model->total_order_received_by_customer('order_master', $from_date, $to_date, $sleeve_diaaaaa);
      //echo $this->db->last_query();

      $this->load->view(ucwords($this->router->fetch_class()) . '/total-order-received-by-customer-load-option', $data);
    }
  }

  public function total_order_received_by_customer_on_order_date()
  {
    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');

      $sleeve_dia = str_replace("&", "", $this->input->post('sleeve_dia'));
      $sleeve_diaaa = str_replace("+", " ", $sleeve_dia);
      $sleeve_diaa = str_replace("sleeve_dia=", "','", $sleeve_diaaa);
      $AddToEnd = "'";
      $sleeve_diaaaaa = substr($sleeve_diaa . $AddToEnd, 2);
      $data['sleeve_dia_data'] = $sleeve_diaaaaa;



      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;

      $this->load->model('sales_order_book_model');
      $data['total_order_received_by_customer'] = $this->sales_order_book_model->total_order_received_by_customer_on_order_date('order_master', $from_date, $to_date, $sleeve_diaaaaa = "");
      //echo $this->db->last_query();

      $this->load->view(ucwords($this->router->fetch_class()) . '/total-order-received-by-customer-on-order-date-load-option', $data);
    }
  }


  public function dashboard_sales()
  {

    if (!empty($this->input->post('from_date'))) {
      $from_date = $this->input->post('from_date');
      $to_date = $this->input->post('to_date');
      $convert = $this->input->post('convert');

      $data['from_date'] = $from_date;
      $data['to_date'] = $to_date;

      $this->load->model('sales_invoice_book_model');
      $table = "ar_invoice_master";

      $this->load->model('fiscal_model');
      $data['account_periods_master'] = $this->fiscal_model->select_current_financial_year('account_periods_master', $this->session->userdata['logged_in']['company_id']);
      if ($data['account_periods_master'] == FALSE) {
      } else {
        foreach ($data['account_periods_master'] as $account_periods_master_row) {
          $from_date_fin = $account_periods_master_row->fin_year_start;
        }
      }

      $data['print_type_wise_sales_coex'] = $this->sales_invoice_book_model->select_print_type_wise_diawise_sales($table, $from_date, $to_date, '', '', '', '', '');

      $this->db->last_query();

      $data['print_type_wise_sales_coex_last_month'] = $this->sales_invoice_book_model->select_print_type_wise_diawise_sales($table, date("Y-m-d", strtotime("-1 month", strtotime($from_date))), date("Y-m-d", strtotime("-1 month", strtotime($to_date))), '', '', '', '', '');

      $data['print_type_wise_sales_coex_2ndlast_month'] = $this->sales_invoice_book_model->select_print_type_wise_diawise_sales($table, date("Y-m-d", strtotime("-2 month", strtotime($from_date))), date('Y-m-d', strtotime("-2 month", strtotime($to_date))), '', '', '', '', '');

      $data['print_type_wise_sales_coex_3rdlast_month'] = $this->sales_invoice_book_model->select_print_type_wise_diawise_sales($table, date("Y-m-01", strtotime("-3 month", strtotime($from_date))), date('Y-m-d', strtotime("-3 month", strtotime($to_date))), '', '', '', '', '');

      $data['print_type_wise_sales_coex_total_year'] = $this->sales_invoice_book_model->select_print_type_wise_diawise_sales($table, $from_date_fin, date('Y-m-d'), '', '', '', '', '');
      $this->load->model('costsheet_model');

      $cdata = array('status_flag' => '1');
      $data['contribution'] = $this->costsheet_model->select_contriubution('costsheet_master', $from_date, $to_date, $cdata);

      $data['contribution_last_month'] = $this->costsheet_model->select_contriubution('costsheet_master', date("Y-m-d", strtotime("-1 month", strtotime($from_date))), date("Y-m-d", strtotime("-1 month", strtotime($to_date))), $cdata);


      $CI = &get_instance();

      $this->db2 = $CI->load->database('another_db', TRUE);
      $this->load->model('production_model');
      $data['printing'] = $this->production_model->select_printing_monthwise('printing', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date);

      $data['labeling'] = $this->production_model->select_labeling_monthwise('labeling', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date);

      $data['spring_printing'] = $this->production_model->select_spring_printing_monthwise('springtube_printing_production_details', $this->session->userdata['logged_in']['company_id'], $from_date, $to_date);

      $data['printing_last_month'] = $this->production_model->select_printing_monthwise('printing', $this->session->userdata['logged_in']['company_id'], date("Y-m-d", strtotime("-1 month", strtotime($from_date))), date("Y-m-d", strtotime("-1 month", strtotime($to_date))));

      $data['spring_printing_last_month'] = $this->production_model->select_spring_printing_monthwise('springtube_printing_production_details', $this->session->userdata['logged_in']['company_id'], date("Y-m-01", strtotime("-1 month")), date('Y-m-d', strtotime("-1 month")));

      $data['labeling_last_month'] = $this->production_model->select_labeling_monthwise('labeling', $this->session->userdata['logged_in']['company_id'], date("Y-m-01", strtotime("-1 month")), date('Y-m-d', strtotime("-1 month")));

      $data['printing_2ndlast_month'] = $this->production_model->select_printing_monthwise('printing', $this->session->userdata['logged_in']['company_id'], date("Y-m-d", strtotime("-2 month", strtotime($from_date))), date('Y-m-d', strtotime("-2 month", strtotime($to_date))));

      $data['spring_printing_2ndlast_month'] = $this->production_model->select_spring_printing_monthwise('springtube_printing_production_details', $this->session->userdata['logged_in']['company_id'], date("Y-m-01", strtotime("-2 month")), date('Y-m-d', strtotime("-2 month")));

      $data['labeling_2ndlast_month'] = $this->production_model->select_labeling_monthwise('labeling', $this->session->userdata['logged_in']['company_id'], date("Y-m-01", strtotime("-2 month")), date('Y-m-d', strtotime("-2 month")));

      $data['printing_3rdlast_month'] = $this->production_model->select_printing_monthwise('printing', $this->session->userdata['logged_in']['company_id'], date("Y-m-d", strtotime("-3 month", strtotime($from_date))), date('Y-m-d', strtotime("-3 month", strtotime($to_date))));

      $data['spring_printing_3rdlast_month'] = $this->production_model->select_spring_printing_monthwise('springtube_printing_production_details', $this->session->userdata['logged_in']['company_id'], date("Y-m-01", strtotime("-3 month")), date('Y-m-d', strtotime("-3 month")));

      $data['labeling_3rdlast_month'] = $this->production_model->select_labeling_monthwise('labeling', $this->session->userdata['logged_in']['company_id'], date("Y-m-01", strtotime("-3 month")), date('Y-m-d', strtotime("-3 month")));

      $data['printing_total_year'] = $this->production_model->select_printing_monthwise('printing', $this->session->userdata['logged_in']['company_id'], $from_date_fin, date('Y-m-d'));

      $data['spring_printing_total_year'] = $this->production_model->select_spring_printing_monthwise('springtube_printing_production_details', $this->session->userdata['logged_in']['company_id'], $from_date_fin, date('Y-m-d'));

      $data['labeling_total_year'] = $this->production_model->select_labeling_monthwise('labeling', $this->session->userdata['logged_in']['company_id'], $from_date_fin, date('Y-m-d'));

      $data['top_customer_coex'] = $this->sales_invoice_book_model->select_top_customer($table, $this->session->userdata['logged_in']['company_id'], $from_date, $to_date, '', '');

      // echo $this->db->last_query();

      $data['print_type_wise_sales_domestic'] = $this->sales_invoice_book_model->select_print_type_wise_sales($table, $from_date, $to_date, '', '', '', '', '1,2,8');
      $data['print_type_wise_sales_export_local'] = $this->sales_invoice_book_model->select_print_type_wise_sales($table, $from_date, $to_date, '', '', '', '', '3');

      $data['print_type_wise_sales_export_fze'] = $this->sales_invoice_book_model->select_print_type_wise_sales($table, $from_date, $to_date, '', '', '', '', '11');

      $this->load->model('sales_order_book_model');

      $data['pending_sales_order_opening'] = $this->sales_order_book_model->pending_sales_order_monthwise('order_master', $from_date_fin, date('Y-m-d', strtotime('-1 day', strtotime($from_date))), '');

      $data['pending_sales_order'] = $this->sales_order_book_model->pending_sales_order_monthwise('order_master', $from_date, date('Y-m-d'), '');

      $data['print_type_wise_sales_coex_m'] = $this->sales_invoice_book_model->select_print_type_wise_sales($table, $from_date, date('Y-m-d'), '', '', '', '', '');
      $data['order_dispatched_count'] = $this->sales_invoice_book_model->sales_total_order_dispathed_count($from_date, $to_date);

      $data['order_completed_dispatched_count'] = $this->sales_invoice_book_model->sales_total_order_completed_count($from_date, $to_date);
      $data['order_short_completed_dispatched_count'] = $this->sales_invoice_book_model->sales_total_order_short_completed_count($from_date, $to_date);

      $data['open_order_count'] = $this->sales_invoice_book_model->sales_open_order_count($from_date, $to_date);
      //echo $this->db->last_query();
      $data['order_completed_dispatched_count'] = $this->sales_invoice_book_model->sales_total_order_completed_count($from_date, $to_date);
      $data['order_completed_dispatched_volume'] = $this->sales_invoice_book_model->sales_total_order_completed_volume($from_date, $to_date);
      $data['order_open_dispatched_volume'] = $this->sales_invoice_book_model->sales_total_open_order_dispatch_volume($from_date, $to_date);
      $data['order_short_completed_dispatched_volume'] = $this->sales_invoice_book_model->sales_total_short_completed_volume($from_date, $to_date);

      $data['sales_total_order_completed_net'] = $this->sales_invoice_book_model->sales_total_order_completed_net($from_date, $to_date);

      $data['sales_total_order_short_completed_net'] = $this->sales_invoice_book_model->sales_total_order_short_completed_net($from_date, $to_date);

      if ($convert == 0) {
        $this->load->view(ucwords($this->router->fetch_class()) . '/dashboard-sales-load-option', $data);
      } else {
        $this->load->view(ucwords($this->router->fetch_class()) . '/dashboard-sales-million-load-option', $data);
      }
    }
  }




  public function artwork_autocomplete()
  {
    $edit = $this->input->get('q');
    $data = array('ad_id' => $edit);
    $this->load->model('common_model');
    $data['artwork_devel_master'] = $this->common_model->active_record_search('artwork_devel_master', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/artwork-load-option', $data);
  }
  public function artwork_springtube_autocomplete()
  {
    $edit = $this->input->get('q');
    $data = array('ad_id' => $edit);
    $this->load->model('common_model');
    $data['springtube_artwork_devel_master'] = $this->common_model->active_record_search('springtube_artwork_devel_master', $data, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/artwork-springtube-load-option', $data);
  }

  public function film_autocomplete()
  {
    $edit = $this->input->get('q');
    $this->load->model('article_model');
    $data['article'] = $this->article_model->spring_film_active_record_search('article', $edit, $this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()) . '/article-load-option', $data);
  }
  // Sales order Product list on SO autocomplte
  public function complaint_no_autocomplete()
  {

    $edit = $this->input->get('q');
    $data = array('complaint_no' => $edit);
    $this->load->model('complaint_register_model');
    $data['result'] = $this->complaint_register_model->active_record_search_autocomplete('capa_complaint_register_master', $data, '', '', $this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    $this->load->view(ucwords($this->router->fetch_class()) . '/complaint-no-load-option', $data);
  }

  public function get_so_no_transfer()
  {
    $so_no = $this->input->get('q');
    $data = array('order_no' => $so_no);
    $this->load->model('common_model');
    $data['springtube_rfd_master'] = $this->common_model->active_record_search_rfd_trns('springtube_rfd_master', $data, $this->session->userdata['logged_in']['company_id']);

    $this->load->view(ucwords($this->router->fetch_class()) . '/order-no-load-option-transfer', $data);
  }

  public function get_product_no_transfer()
  {
    $this->load->model('common_model');
    if (!empty($this->input->post('so_no'))) {
      $so_no = $this->input->post('so_no');
      $arr = array('order_no' => $so_no);

      $data['springtube_rfd_master'] = $this->common_model->select_active_records_where('springtube_rfd_master', $this->session->userdata['logged_in']['company_id'], $arr);
      $this->load->view('Ajax/product-no-load-option-transfer', $data);
    }
  }


  public function get_rfd_qty_transfer()
  {
    $this->load->model('common_model');
    if (!empty($this->input->post('so_no'))) {
      $so_no = $this->input->post('so_no');
      $arr = array('order_no' => $so_no);

      $data['springtube_rfd_master'] = $this->common_model->select_active_records_rfd_transfer('springtube_rfd_master', $this->session->userdata['logged_in']['company_id'], $arr);
      //echo $this->db->last_query();
      $this->load->view('Ajax/product-no-load-option-rfd-qty-transfer', $data);
    }
  }

  public function get_rfd_jobcard_transfer()
  {
    $this->load->model('common_model');
    if (!empty($this->input->post('so_no'))) {
      $so_no = $this->input->post('so_no');
      $arr = array('order_no' => $so_no);

      $data['springtube_jobcard_master'] = $this->common_model->select_active_records_rfd_transfer('springtube_rfd_master', $this->session->userdata['logged_in']['company_id'], $arr);
      //echo $this->db->last_query();
      $this->load->view('Ajax/product-no-load-option-jobcard-no-transfer', $data);
    }
  }





  public function springtube_extrusion_planning()
  {

    $this->load->model('common_model');
    $this->load->model('sales_order_book_model');
    $this->load->model('sales_order_status_model');
    $this->load->model('artwork_springtube_model');
    $this->load->model('springtube_extrusion_planning_model');

    echo $id = $this->input->post('id');

    $data['spring_extrusion_planning_master'] = $this->common_model->select_one_active_record('spring_extrusion_planning_master', $this->session->userdata['logged_in']['company_id'], 'id', $id);

    $reel_length = $this->config->item('springtube_reel_length');


    foreach ($data['spring_extrusion_planning_master'] as $row) {

      $customer = '';
      $order_date = '';
      $ad_id = '';
      $version_no = '';
      $body_making_type = '';
      $print_type_artwork = '';
      $bom_no = '';
      $bom_version_no = '';
      $total_order_quantity = 0;

      //Order Details----------------
      $order_master_result = $this->sales_order_book_model->select_one_active_record('order_master', $this->session->userdata['logged_in']['company_id'], 'order_master.order_no', $row->order_no);
      foreach ($order_master_result as $order_master_row) {
        $customer = $order_master_row->customer_name;
        $order_date = $order_master_row->order_date;
      }

      $data_order_details = array('order_no' => $row->order_no, 'article_no' => $row->article_no);

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
      $reel_width = '';

      if ($bom_no != '' && $bom_version_no != '') {

        $film_spec_id = '';
        $film_spec_version = '';

        $data = array(
          'bom_no' => $bom_no,
          'bom_version_no' => $bom_version_no
        );

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
            'seam_type' => $body_making_type,
            'ups' => '2'
          );

          $result_spring_width_calculation = $this->common_model->select_active_records_where('spring_width_calculation', $this->session->userdata['logged_in']['company_id'], $data);

          $reel_width = 0;

          foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
            $ups = $spring_width_calculation_row->ups;
            $reel_width = ($spring_width_calculation_row->slit_width) + ($spring_width_calculation_row->ups * $spring_width_calculation_row->distance_each_side);
          }
        }
      } //Bom--

      // Invoice Qty-----------------

      $supply_qty = 0;
      $pending_qty = 0;

      $invoice_data = array();
      $invoice_data['ref_ord_no'] = $row->order_no;
      $invoice_data['article_no'] = $row->article_no;

      $supply_qty_result = $this->sales_order_status_model->sum_supply_qty('ar_invoice_master', $invoice_data, $this->session->userdata['logged_in']['company_id']);

      foreach ($supply_qty_result as $supply_qty_row) {
        $supply_qty = $supply_qty_row->supply_qty;
      }

      if ($supply_qty == 0) {

        $pending_qty = $this->common_model->read_number($total_order_quantity, $this->session->userdata['logged_in']['company_id']);
      } else {
        $pending_qty = $this->common_model->read_number($total_order_quantity - $supply_qty, $this->session->userdata['logged_in']['company_id']);
      }

      $planned_qty = 0;
      $planned_length = 0;

      if ($row->jobcard_perc != '') {

        $planned_qty = $pending_qty + ($row->jobcard_perc / 100 * $pending_qty);


        if ($ups != 0) {

          $planned_length = (($sleeve_length + 2.5) * $planned_qty / 1000) / $ups;
        }
      }
    }
  }
  public function order_sleeve_mb()
  {


    if (!empty($this->input->post('order_no'))) {
      $this->input->post('order_no');

      $update_data = array('ordered_shoulder_mb' => $this->input->post('value'));
      $update_result = $this->common_model->update_one_active_record('order_details', $update_data, 'order_no', $this->input->post('order_no'), $this->session->userdata['logged_in']['company_id']);
      if ($update_result == TRUE) {
        echo '<script>alert("PO is sent for ' . $this->input->post('order_no') . ' ' . $this->input->post('value') . '")</script>';
      }
    }
  }
  public function order_shoulder_mb()
  {


    if (!empty($this->input->post('order_no'))) {
      $this->input->post('order_no');

      $update_data = array('ordered_shoulder_mb' => $this->input->post('value'));
      $update_result = $this->common_model->update_one_active_record('order_details', $update_data, 'order_no', $this->input->post('order_no'), $this->session->userdata['logged_in']['company_id']);
      if ($update_result == TRUE) {
        echo '<script>alert("PO is sent for ' . $this->input->post('order_no') . ' ' . $this->input->post('value') . '")</script>';
      }
    }
  }
  public function order_cap_code()
  {


    if (!empty($this->input->post('order_no'))) {
      $this->input->post('order_no');

      $update_data = array('ordered_cap_mb' => $this->input->post('value'));
      $update_result = $this->common_model->update_one_active_record('order_details', $update_data, 'order_no', $this->input->post('order_no'), $this->session->userdata['logged_in']['company_id']);
      if ($update_result == TRUE) {
        echo '<script>alert("PO is sent for ' . $this->input->post('order_no') . ' ' . $this->input->post('value') . '")</script>';
      }
    }
  }
}
