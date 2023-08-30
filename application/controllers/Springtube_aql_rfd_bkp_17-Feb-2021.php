<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_aql_rfd extends CI_Controller {

  function __construct(){    
    parent::__construct();
    if($this->session->userdata('logged_in')){
      
      $this->load->model('common_model');
      $this->load->model('article_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_bodymaking_wip_model');
      $this->load->model('springtube_aql_rfd_model');
      
    }else{
      redirect('login','refresh');
    }
  }

  function index(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $table='springtube_aql_rfd_master';
              include('pagination.php');
              $data['springtube_aql_rfd_master']=$this->springtube_aql_rfd_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
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
  
  function create(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){
              
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
               
             
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

  function save(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){
              
              $this->form_validation->set_rules('aql_date','AQL Date' ,'required|trim|xss_clean|exact_length[10]');              
              $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'required|trim|xss_clean'); 
              
              $this->form_validation->set_rules('bm_wip_qty','Bodymaking WIP Qty.' ,'required|trim|xss_clean|max_length[10]|greater_than[0]');

              $this->form_validation->set_rules('inspection_qty','Inspection Qty' ,'trim|xss_clean|greater_than[0]|callback_check_inspection_qty');

              $this->form_validation->set_rules('remaining_wip','Remaining WIP Qty' ,'trim|xss_clean|greater_than_equal_to[0]');
              
              // Bodymaking Inspection-------------------------
              $this->form_validation->set_rules('seam_welding_stratup_box','Seam welding (in startup box) Decoseam one side' ,'trim|xss_clean');
              $this->form_validation->set_rules('seam_welding_ok_box','Seam welding (in ok box)' ,'trim|xss_clean');
              $this->form_validation->set_rules('shoulder_welding_ok_box','Shoulder welding (in ok box) one side decoseam' ,'trim|xss_clean');
              $this->form_validation->set_rules('ink_flaking','Ink flaking (ink wrinkles in seam)' ,'trim|xss_clean');             
              $this->form_validation->set_rules('cap_oriantation_alignment','Cap oriantation alignment' ,'trim|xss_clean');
              $this->form_validation->set_rules('wrong_position_tube_cutting','Wrong position tube cutting' ,'trim|xss_clean');
              $this->form_validation->set_rules('scratch_line','Scratch Lines' ,'trim|xss_clean');
              $this->form_validation->set_rules('total_rejected_bodymaking_issue','Total Rejected Tubes due to Bodymakig issue' ,'trim|xss_clean');
              
              // Printing Inspection------------------------- 

              $this->form_validation->set_rules('smudge_printing','Smudge Printing' ,'trim|xss_clean');
              $this->form_validation->set_rules('print_miss_registration','Print / Foil miss registation' ,'trim|xss_clean');
              $this->form_validation->set_rules('foil_cut','Foil cut / Unsharp foil' ,'trim|xss_clean');             
              $this->form_validation->set_rules('without_varnish','without_varnish' ,'trim|xss_clean');
              $this->form_validation->set_rules('wet_varnish','Wet varnish / motlling' ,'trim|xss_clean');
              $this->form_validation->set_rules('streaks_nozzle_lines','Streaks / Nozzle lines' ,'trim|xss_clean');
              $this->form_validation->set_rules('ghost_printing','Ghost Printing' ,'trim|xss_clean');
              $this->form_validation->set_rules('nozzle_ink_dots','Nozzle ink dots' ,'trim|xss_clean');             
              $this->form_validation->set_rules('reel_trimming_issue','Reel trimming issue' ,'trim|xss_clean');
              
              $this->form_validation->set_rules('other_print_defects','Other printing defects' ,'trim|xss_clean');

              $this->form_validation->set_rules('total_rejected_printing_issue','Total Rejected Tubes due to Printing issue' ,'trim|xss_clean');              
              
              $this->form_validation->set_rules('rfd_qty','Total RFD Qty' ,'required|trim|xss_clean|max_length[10]|greater_than_equal_to[0]|less_than_equal_to['.$this->input->post('inspection_qty').']');
              


              if($this->form_validation->run()==FALSE){

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
                $this->load->view('Home/footer');
              }else{



                $jobcard_no=$this->input->post('jobcard_no');

                $customer='';               
                $order_no='';
                $article_no='';
                $sleeve_diameter='';
                $sleeve_length='';
                $total_microns='';
                $film_mb_2='';
                $film_mb_6='';
                $film_code='';
                

                $bm_wip_qty=0;
                $inspection_qty=0;
                $remaining_wip=0;


                $seam_welding_stratup_box=0;
                $seam_welding_ok_box=0;
                $shoulder_welding_ok_box=0;
                $ink_flaking=0;
                $cap_oriantation_alignment=0;
                $wrong_position_tube_cutting=0;
                $scratch_line=0;

                $total_rejected_bodymaking_issue=0;               
                

                $smudge_printing=0;
                $print_miss_registration=0;
                $foil_cut=0;
                $stopage_marks=0;
                $without_varnish=0;
                $wet_varnish=0;
                $streaks_nozzle_lines=0;
                $ghost_printing=0;
                $nozzle_ink_dots=0;
                $reel_trimming_issue=0;
                $other_print_defects=0;

                $total_rejected_printing_issue=0;

                $total_rejected_qty=0;
                $rfd_qty=0;

                if(!empty($this->input->post('bm_wip_qty'))){

                  $bm_wip_qty=$this->input->post('bm_wip_qty');

                }
                if(!empty($this->input->post('inspection_qty'))){

                  $inspection_qty=$this->input->post('inspection_qty');

                }
                if(!empty($this->input->post('remaining_wip'))){

                  $remaining_wip=$this->input->post('remaining_wip');

                }

                if(!empty($this->input->post('seam_welding_stratup_box'))){

                  $seam_welding_stratup_box=$this->input->post('seam_welding_stratup_box');
                }
                if(!empty($this->input->post('seam_welding_ok_box'))){

                  $seam_welding_ok_box=$this->input->post('seam_welding_ok_box');
                }
                if(!empty($this->input->post('shoulder_welding_ok_box'))){

                  $shoulder_welding_ok_box=$this->input->post('shoulder_welding_ok_box');
                }
                if(!empty($this->input->post('ink_flaking'))){

                  $ink_flaking=$this->input->post('ink_flaking');

                }
                if(!empty($this->input->post('cap_oriantation_alignment'))){

                  $cap_oriantation_alignment=$this->input->post('cap_oriantation_alignment');

                }
                if(!empty($this->input->post('wrong_position_tube_cutting'))){
                  $wrong_position_tube_cutting=$this->input->post('wrong_position_tube_cutting');
                }
                if(!empty($this->input->post('scratch_line'))){
                  $scratch_line=$this->input->post('scratch_line');

                }

                if(!empty($this->input->post('total_rejected_bodymaking_issue'))){
                  $total_rejected_bodymaking_issue=$this->input->post('total_rejected_bodymaking_issue');

                }

                  //$total_rejected_bodymaking_issue= $seam_welding_stratup_box+$seam_welding_ok_box+$shoulder_welding_ok_box+$ink_flaking+$cap_oriantation_alignment+$wrong_position_tube_cutting+$scratch_line;


                


                if(!empty($this->input->post('smudge_printing'))){
                    $smudge_printing=$this->input->post('smudge_printing');

                }
                if(!empty($this->input->post('print_miss_registration'))){
                    $print_miss_registration=$this->input->post('print_miss_registration');

                }
                if(!empty($this->input->post('foil_cut'))){
                    $foil_cut=$this->input->post('foil_cut');

                }
                if(!empty($this->input->post('stopage_marks'))){
                    $stopage_marks=$this->input->post('stopage_marks');

                }
                if(!empty($this->input->post('without_varnish'))){
                    $without_varnish=$this->input->post('without_varnish');

                }
                if(!empty($this->input->post('wet_varnish'))){
                    $wet_varnish=$this->input->post('wet_varnish');

                }
                if(!empty($this->input->post('streaks_nozzle_lines'))){
                    $streaks_nozzle_lines=$this->input->post('streaks_nozzle_lines');

                }
                if(!empty($this->input->post('ghost_printing'))){
                    $ghost_printing=$this->input->post('ghost_printing');

                }
                if(!empty($this->input->post('nozzle_ink_dots'))){
                    $nozzle_ink_dots=$this->input->post('nozzle_ink_dots');

                }
                if(!empty($this->input->post('reel_trimming_issue'))){
                    $reel_trimming_issue=$this->input->post('reel_trimming_issue');

                }
                if(!empty($this->input->post('other_print_defects'))){
                    $other_print_defects=$this->input->post('other_print_defects');

                }

                if(!empty($this->input->post('total_rejected_printing_issue'))){
                    $total_rejected_printing_issue=$this->input->post('total_rejected_printing_issue');

                }                
                //$total_rejected_printing_issue=$smudge_printing+$print_miss_registration+$foil_cut+$stopage_marks+$without_varnish+$wet_varnish+$streaks_nozzle_lines+$ghost_printing+$nozzle_ink_dots+$reel_trimming_issue+$other_print_defects;

                if(!empty($this->input->post('total_rejected_qty'))){

                    $total_rejected_qty=$this->input->post('total_rejected_qty');
                }
                if(!empty($this->input->post('rfd_qty'))){
                    echo $rfd_qty=$this->input->post('rfd_qty');

                }                
                //$total_rejected=$total_rejected_bodymaking_issue+$total_rejected_printing_issue;

                  
                //$remaining_wip=$bm_wip_qty-($total_rejected+$rfd_qty);              


                //-------------------Jobcard details
                $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);
              
                  foreach($production_master_result as $production_master_row) {
                    $order_no=$production_master_row->sales_ord_no;
                    $article_no=$production_master_row->article_no;
                    
                  }

                $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
                  foreach($order_master_result as $order_master_row){
                    $customer=$order_master_row->customer_no;                      
                  }

                $data_order_details=array(
                  'order_no'=>$order_no,
                  'article_no'=>$article_no
                );

                $bom_no='';
                $bom_version_no='';

                $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
                  foreach($order_details_result as $order_details_row){
                    $bom_no=$order_details_row->spec_id;
                    $bom_version_no=$order_details_row->spec_version_no;
                  }

                $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

                $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

                $bom_id='';
                $film_code='';

                foreach ($bill_of_material_result as $bill_of_material_row) {
                  $bom_id=$bill_of_material_row->bom_id;
                  $film_code=$bill_of_material_row->sleeve_code;
                   
                } 
                //SLEEVE---------------------------------

                  $film_spec_id='';
                  $film_spec_version='';

                  $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

                  foreach($film_code_result as $film_code_row){                   
                    $film_spec_id=$film_code_row->spec_id;
                    $film_spec_version=$film_code_row->spec_version_no;
                  }

                  $specs['spec_id']=$film_spec_id;
                  $specs['spec_version_no']=$film_spec_version;

                  $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
                
                  $total_microns=0;
                
                                             
                  foreach($specs_result as $specs_row){
                      $sleeve_diameter=$specs_row->SLEEVE_DIA;
                      $sleeve_length=$specs_row->SLEEVE_LENGTH;
                      $micron_1=$specs_row->FILM_GUAGE_1;
                      $micron_2=$specs_row->FILM_GUAGE_2;
                      $film_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                      $micron_3=$specs_row->FILM_GUAGE_3;
                      $micron_4=$specs_row->FILM_GUAGE_4;
                      $micron_5=$specs_row->FILM_GUAGE_5;
                      $micron_6=$specs_row->FILM_GUAGE_6;
                      $film_mb_6=$specs_row->FILM_MASTER_BATCH_6;
                      $micron_7=$specs_row->FILM_GUAGE_7;
                       
                  }


                $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7; 
 

                 $data=array(
                  'aql_date'=>$this->input->post('aql_date'),
                  'jobcard_no'=>$jobcard_no,                  
                  'customer'=>$customer,
                  'order_no'=>$order_no,
                  'article_no'=>$article_no,
                  'sleeve_dia'=>$sleeve_diameter,
                  'sleeve_length'=>$sleeve_length,
                  'total_microns'=>$total_microns,
                  'second_layer_mb'=>$film_mb_2,
                  'sixth_layer_mb'=>$film_mb_6,
                  'film_code'=>$film_code,             

                  'bm_wip_qty'=>$bm_wip_qty,
                  'inspection_qty'=>$inspection_qty,
                  'remaining_wip'=>$remaining_wip, 

                  'seam_welding_stratup_box'=>$seam_welding_stratup_box,
                  'seam_welding_ok_box'=>$seam_welding_ok_box,
                  'shoulder_welding_ok_box'=>$shoulder_welding_ok_box,
                  'ink_flaking'=>$ink_flaking,
                  'cap_oriantation_alignment'=>$cap_oriantation_alignment,
                  'wrong_position_tube_cutting'=>$wrong_position_tube_cutting,
                  'scratch_line'=>$scratch_line,

                  'total_rejected_bodymaking_issue'=>$total_rejected_bodymaking_issue,

                  'smudge_printing'=>$smudge_printing,
                  'print_miss_registration'=>$print_miss_registration,
                  'foil_cut'=>$foil_cut,
                  'stopage_marks'=>$stopage_marks,
                  'without_varnish'=>$without_varnish,
                  'wet_varnish'=>$wet_varnish,
                  'streaks_nozzle_lines'=>$streaks_nozzle_lines,
                  'ghost_printing'=>$ghost_printing,
                  'nozzle_ink_dots'=>$nozzle_ink_dots,
                  'reel_trimming_issue'=>$reel_trimming_issue,
                  'other_print_defects'=>$other_print_defects,

                  'total_rejected_printing_issue'=>$total_rejected_printing_issue,

                  'total_rejected_qty'=>$total_rejected_qty,                  
                  'rfd_qty'=>$rfd_qty,  

                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'created_date'=>date('Y-m-d H:i:s'),                 
                  'from_process'=>'13'
                 );

                $aql_id=$this->common_model->save_return_pkey('springtube_aql_rfd_master',$data);

                if($aql_id){

                    $data_search=array('jobcard_no'=>$jobcard_no,'archive'=>0,'status'=>0,'consume_flag'=>1);

                    $result_springtube_bodymaking_wip_master=$this->common_model->select_active_records_where('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search);
                    //echo $this->db->last_query();
                    foreach ($result_springtube_bodymaking_wip_master as $key => $springtube_bodymaking_wip_master_row) {

                      $data_wip_update=array(
                      'status'=>'1',                         
                      'release_qty'=>$inspection_qty,
                      'release_date'=>date('Y-m-d'),
                      'release_by'=>$this->session->userdata['logged_in']['user_id'],
                      'next_process'=>'17',
                      'ref_aql_id'=>$aql_id
                      
                        );
                      $result=$this->common_model->update_one_active_record('springtube_bodymaking_wip_master',$data_wip_update,'bm_wip_id',$springtube_bodymaking_wip_master_row->bm_wip_id,$this->session->userdata['logged_in']['company_id']);
                    }  

                    if($remaining_wip>0){
                        $data_insert=array(
                          'wip_date'=>$this->input->post('aql_date'),
                          'jobcard_no'=>$jobcard_no,                  
                          'customer'=>$customer,
                          'order_no'=>$order_no,
                          'article_no'=>$article_no,
                          'sleeve_dia'=>$sleeve_diameter,
                          'sleeve_length'=>$sleeve_length,
                          'total_microns'=>$total_microns,
                          'second_layer_mb'=>$film_mb_2,
                          'sixth_layer_mb'=>$film_mb_6,
                          'film_code'=>$film_code,
                          'bm_wip_qty'=>$remaining_wip,
                          'user_id'=>$this->session->userdata['logged_in']['user_id'],
                          'company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'created_date'=>date('Y-m-d H:i:s'),                 
                          'from_process'=>'17',
                          'ref_aql_id'=>$aql_id

                        );

                        $result_final=$this->common_model->save('springtube_bodymaking_wip_master',$data_insert);

                    }


                 }


                 if($aql_id){
                     $data['note']='Data saved Successfully';
                  }else{
                    $data['error']='Error while saving data';
                  }

                //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                 
               
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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
   function modify($aql_id){
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){ 
              
              $data['springtube_aql_rfd_master']=$this->springtube_aql_rfd_model->select_one_active_record('springtube_aql_rfd_master',$this->session->userdata['logged_in']['company_id'],'aql_id',$aql_id);

              
             // echo $this->db->last_query();

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

  function update(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){
              
              $this->form_validation->set_rules('aql_date','AQL Date' ,'required|trim|xss_clean|exact_length[10]');              
              $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'required|trim|xss_clean'); 
              
              $this->form_validation->set_rules('bm_wip_qty','Bodymaking WIP Qty.' ,'required|trim|xss_clean|max_length[10]|greater_than[0]');
              
              // Bodymaking Inspection-------------------------
              $this->form_validation->set_rules('seam_welding_stratup_box','Seam welding (in startup box) Decoseam one side' ,'trim|xss_clean');
              $this->form_validation->set_rules('seam_welding_ok_box','Seam welding (in ok box)' ,'trim|xss_clean');
              $this->form_validation->set_rules('shoulder_welding_ok_box','Shoulder welding (in ok box) one side decoseam' ,'trim|xss_clean');
              $this->form_validation->set_rules('ink_flaking','Ink flaking (ink wrinkles in seam)' ,'trim|xss_clean');             
              $this->form_validation->set_rules('cap_oriantation_alignment','Cap oriantation alignment' ,'trim|xss_clean');
              $this->form_validation->set_rules('wrong_position_tube_cutting','Wrong position tube cutting' ,'trim|xss_clean');
              $this->form_validation->set_rules('scratch_line','Scratch Lines' ,'trim|xss_clean');
              $this->form_validation->set_rules('total_rejected_bodymaking_issue','Total Rejected Tubes due to Bodymakig issue' ,'trim|xss_clean');
              
              // Printing Inspection------------------------- 

              $this->form_validation->set_rules('smudge_printing','Smudge Printing' ,'trim|xss_clean');
              $this->form_validation->set_rules('print_miss_registration','Print / Foil miss registation' ,'trim|xss_clean');
              $this->form_validation->set_rules('foil_cut','Foil cut / Unsharp foil' ,'trim|xss_clean');             
              $this->form_validation->set_rules('without_varnish','without_varnish' ,'trim|xss_clean');
              $this->form_validation->set_rules('wet_varnish','Wet varnish / motlling' ,'trim|xss_clean');
              $this->form_validation->set_rules('streaks_nozzle_lines','Streaks / Nozzle lines' ,'trim|xss_clean');
              $this->form_validation->set_rules('ghost_printing','Ghost Printing' ,'trim|xss_clean');
              $this->form_validation->set_rules('nozzle_ink_dots','Nozzle ink dots' ,'trim|xss_clean');             
              $this->form_validation->set_rules('reel_trimming_issue','Reel trimming issue' ,'trim|xss_clean');
              
              $this->form_validation->set_rules('other_print_defects','Other print defects / Head touch / Printing dust / Nipple dust' ,'trim|xss_clean');
              $this->form_validation->set_rules('total_rejected_printing_issue','Total Rejected Tubes due to Printing issue' ,'trim|xss_clean');
              
              $this->form_validation->set_rules('total_rejected_qty','Total Rejected Qty' ,'trim|xss_clean');
              $this->form_validation->set_rules('rfd_qty','Total RFD Qty' ,'required|trim|xss_clean|max_length[10]|greater_than[0]');
              $this->form_validation->set_rules('remaining_wip','Remaining WIP Qty' ,'trim|xss_clean');


              if($this->form_validation->run()==FALSE){

                $data['springtube_aql_rfd_master']=$this->springtube_aql_rfd_model->select_one_active_record('springtube_aql_rfd_master',$this->session->userdata['logged_in']['company_id'],'aql_id',$this->input->post('aql_id'));

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');
              }else{



                $jobcard_no=$this->input->post('jobcard_no');

                $customer='';               
                $order_no='';
                $article_no='';
                $sleeve_diameter='';
                $sleeve_length='';
                $total_microns='';
                $film_mb_2='';
                $film_mb_6='';
                $film_code='';
                

                $bm_wip_qty=0;
                $seam_welding_stratup_box=0;
                $seam_welding_ok_box=0;
                $shoulder_welding_ok_box=0;
                $ink_flaking=0;
                $cap_oriantation_alignment=0;
                $wrong_position_tube_cutting=0;
                $scratch_line=0;

                $total_rejected_bodymaking_issue=0;

                $total_rejected_qty=0;
                $rfd_qty=0;
                $remaining_wip=0;

                $smudge_printing=0;
                $print_miss_registration=0;
                $foil_cut=0;
                $stopage_marks=0;
                $without_varnish=0;
                $wet_varnish=0;
                $streaks_nozzle_lines=0;
                $ghost_printing=0;
                $nozzle_ink_dots=0;
                $reel_trimming_issue=0;
                $other_print_defects=0;

                $total_rejected_printing_issue=0;

                if(!empty($this->input->post('bm_wip_qty'))){

                  $bm_wip_qty=$this->input->post('bm_wip_qty');

                }

                if(!empty($this->input->post('seam_welding_stratup_box'))){

                  $seam_welding_stratup_box=$this->input->post('seam_welding_stratup_box');
                }
                if(!empty($this->input->post('seam_welding_ok_box'))){

                  $seam_welding_ok_box=$this->input->post('seam_welding_ok_box');
                }
                if(!empty($this->input->post('shoulder_welding_ok_box'))){

                  $shoulder_welding_ok_box=$this->input->post('shoulder_welding_ok_box');
                }

                if(!empty($this->input->post('ink_flaking'))){

                  $ink_flaking=$this->input->post('ink_flaking');

                }
                if(!empty($this->input->post('cap_oriantation_alignment'))){

                  $cap_oriantation_alignment=$this->input->post('cap_oriantation_alignment');

                }
                if(!empty($this->input->post('wrong_position_tube_cutting'))){
                  $wrong_position_tube_cutting=$this->input->post('wrong_position_tube_cutting');
                }
                if(!empty($this->input->post('scratch_line'))){
                  $scratch_line=$this->input->post('scratch_line');

                }

                  $total_rejected_bodymaking_issue= $seam_welding_stratup_box+$seam_welding_ok_box+$shoulder_welding_ok_box+$ink_flaking+$cap_oriantation_alignment+$wrong_position_tube_cutting+$scratch_line;


                if(!empty($this->input->post('total_rejected_qty'))){

                    $total_rejected_qty=$this->input->post('total_rejected_qty');
                }
                if(!empty($this->input->post('rfd_qty'))){
                    $rfd_qty=$this->input->post('rfd_qty');

                }
                if(!empty($this->input->post('smudge_printing'))){
                    $smudge_printing=$this->input->post('smudge_printing');

                }
                if(!empty($this->input->post('print_miss_registration'))){
                    $print_miss_registration=$this->input->post('print_miss_registration');

                }
                if(!empty($this->input->post('foil_cut'))){
                    $foil_cut=$this->input->post('foil_cut');

                }
                if(!empty($this->input->post('stopage_marks'))){
                    $stopage_marks=$this->input->post('stopage_marks');

                }
                if(!empty($this->input->post('without_varnish'))){
                    $without_varnish=$this->input->post('without_varnish');

                }
                if(!empty($this->input->post('wet_varnish'))){
                    $wet_varnish=$this->input->post('wet_varnish');

                }
                if(!empty($this->input->post('streaks_nozzle_lines'))){
                    $streaks_nozzle_lines=$this->input->post('streaks_nozzle_lines');

                }
                if(!empty($this->input->post('ghost_printing'))){
                    $ghost_printing=$this->input->post('ghost_printing');

                }
                if(!empty($this->input->post('nozzle_ink_dots'))){
                    $nozzle_ink_dots=$this->input->post('nozzle_ink_dots');

                }
                if(!empty($this->input->post('reel_trimming_issue'))){
                    $reel_trimming_issue=$this->input->post('reel_trimming_issue');

                }
                if(!empty($this->input->post('other_print_defects'))){
                    $other_print_defects=$this->input->post('other_print_defects');

                }
                
                $total_rejected_printing_issue=$smudge_printing+$print_miss_registration+$foil_cut+$stopage_marks+$without_varnish+$wet_varnish+$streaks_nozzle_lines+$ghost_printing+$nozzle_ink_dots+$reel_trimming_issue+$other_print_defects;

                
                $total_rejected=$total_rejected_bodymaking_issue+$total_rejected_printing_issue;

                  
                $remaining_wip=$bm_wip_qty-($total_rejected+$rfd_qty);
                


                //-------------------Jobcard details
                $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);
              
                  foreach($production_master_result as $production_master_row) {
                    $order_no=$production_master_row->sales_ord_no;
                    $article_no=$production_master_row->article_no;
                    
                  }

                $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
                  foreach($order_master_result as $order_master_row){
                    $customer=$order_master_row->customer_no;                      
                  }

                $data_order_details=array(
                  'order_no'=>$order_no,
                  'article_no'=>$article_no
                );

                $bom_no='';
                $bom_version_no='';

                $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
                  foreach($order_details_result as $order_details_row){
                    $bom_no=$order_details_row->spec_id;
                    $bom_version_no=$order_details_row->spec_version_no;
                  }

                $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

                $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

                $bom_id='';
                $film_code='';

                foreach ($bill_of_material_result as $bill_of_material_row) {
                  $bom_id=$bill_of_material_row->bom_id;
                  $film_code=$bill_of_material_row->sleeve_code;
                   
                } 
                //SLEEVE---------------------------------

                  $film_spec_id='';
                  $film_spec_version='';

                  $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

                  foreach($film_code_result as $film_code_row){                   
                    $film_spec_id=$film_code_row->spec_id;
                    $film_spec_version=$film_code_row->spec_version_no;
                  }

                  $specs['spec_id']=$film_spec_id;
                  $specs['spec_version_no']=$film_spec_version;

                  $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
                
                  $total_microns=0;
                
                                             
                  foreach($specs_result as $specs_row){
                      $sleeve_diameter=$specs_row->SLEEVE_DIA;
                      $sleeve_length=$specs_row->SLEEVE_LENGTH;
                      $micron_1=$specs_row->FILM_GUAGE_1;
                      $micron_2=$specs_row->FILM_GUAGE_2;
                      $film_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                      $micron_3=$specs_row->FILM_GUAGE_3;
                      $micron_4=$specs_row->FILM_GUAGE_4;
                      $micron_5=$specs_row->FILM_GUAGE_5;
                      $micron_6=$specs_row->FILM_GUAGE_6;
                      $film_mb_6=$specs_row->FILM_MASTER_BATCH_6;
                      $micron_7=$specs_row->FILM_GUAGE_7;
                       
                  }


                $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7; 


                // Archive remaining wip records w r t aql id--------------

                $data_array=array('status'=>0,'archive'=>0,'ref_aql_id'=>$this->input->post('aql_id'));              

                
                $data['springtube_bodymaking_wip_master_remain']=$this->common_model->select_active_records_where('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_array);
                foreach ($data['springtube_bodymaking_wip_master_remain'] as $key => $wip_row) {
                  
                  $data_archive=array('archive'=>1);
                  $result=$this->common_model->update_one_active_record('springtube_bodymaking_wip_master',$data_archive,'bm_wip_id',$wip_row->bm_wip_id,$this->session->userdata['logged_in']['company_id']);

                }

                $data_array=array('status'=>1,'archive'=>0,'ref_aql_id'=>$this->input->post('aql_id'));
                $data['springtube_bodymaking_wip_master_1']=$this->common_model->select_active_records_where('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_array);
                
                foreach ($data['springtube_bodymaking_wip_master_1'] as $key => $wip_row) {
                  
                  $data_update=array(
                    'status'=>0,
                    'release_qty'=>'',
                    'release_date'=>'0000-00-00',
                    'release_by'=>'',
                    'next_process'=>0);

                  $result=$this->common_model->update_one_active_record('springtube_bodymaking_wip_master',$data_update,'bm_wip_id',$wip_row->bm_wip_id,$this->session->userdata['logged_in']['company_id']);
                

                }
                
 

                //updating new Aql record--------------
                 $data=array(
                  'aql_date'=>$this->input->post('aql_date'),
                  'jobcard_no'=>$jobcard_no,                  
                  'customer'=>$customer,
                  'order_no'=>$order_no,
                  'article_no'=>$article_no,
                  'sleeve_dia'=>$sleeve_diameter,
                  'sleeve_length'=>$sleeve_length,
                  'total_microns'=>$total_microns,
                  'second_layer_mb'=>$film_mb_2,
                  'sixth_layer_mb'=>$film_mb_6,
                  'film_code'=>$film_code,             

                  'bm_wip_qty'=>$bm_wip_qty,                  
                  'seam_welding_stratup_box'=>$seam_welding_stratup_box,
                  'seam_welding_ok_box'=>$seam_welding_ok_box,
                  'shoulder_welding_ok_box'=>$shoulder_welding_ok_box,
                  'ink_flaking'=>$ink_flaking,
                  'cap_oriantation_alignment'=>$cap_oriantation_alignment,
                  'wrong_position_tube_cutting'=>$wrong_position_tube_cutting,
                  'scratch_line'=>$scratch_line,
                  'total_rejected_bodymaking_issue'=>$total_rejected_bodymaking_issue,
                  'smudge_printing'=>$smudge_printing,
                  'print_miss_registration'=>$print_miss_registration,
                  'foil_cut'=>$foil_cut,
                  'stopage_marks'=>$stopage_marks,
                  'without_varnish'=>$without_varnish,
                  'wet_varnish'=>$wet_varnish,
                  'streaks_nozzle_lines'=>$streaks_nozzle_lines,
                  'ghost_printing'=>$ghost_printing,
                  'nozzle_ink_dots'=>$nozzle_ink_dots,
                  'reel_trimming_issue'=>$reel_trimming_issue,
                  'other_print_defects'=>$other_print_defects,
                  'total_rejected_printing_issue'=>$total_rejected_printing_issue,
                  'total_rejected_qty'=>$total_rejected_qty,
                  'rfd_qty'=>$rfd_qty,
                  'remaining_wip'=>$remaining_wip,
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'created_date'=>date('Y-m-d H:i:s'),                 
                  'from_process'=>'13'
                 );

                 $result_update=$this->common_model->update_one_active_record('springtube_aql_rfd_master',$data,'aql_id',$this->input->post('aql_id'),$this->session->userdata['logged_in']['company_id']);

                 if($result_update){

                    $data_search=array('jobcard_no'=>$jobcard_no,'archive'=>0,'status'=>0,'consume_flag'=>1);

                    $result_springtube_bodymaking_wip_master=$this->common_model->select_active_records_where('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search);
                    //echo $this->db->last_query();
                    foreach ($result_springtube_bodymaking_wip_master as $key => $springtube_bodymaking_wip_master_row) {

                      $data_wip_update=array(
                      'status'=>'1',                         
                      'release_qty'=>($bm_wip_qty-$remaining_wip),
                      'release_date'=>date('Y-m-d'),
                      'release_by'=>$this->session->userdata['logged_in']['user_id'],
                      'next_process'=>'17',
                      'ref_aql_id'=>$this->input->post('aql_id')
                      
                        );
                      $result=$this->common_model->update_one_active_record('springtube_bodymaking_wip_master',$data_wip_update,'bm_wip_id',$springtube_bodymaking_wip_master_row->bm_wip_id,$this->session->userdata['logged_in']['company_id']);
                    }  

                    if($remaining_wip>0){
                        $data_insert=array(
                          'wip_date'=>$this->input->post('aql_date'),
                          'jobcard_no'=>$jobcard_no,                  
                          'customer'=>$customer,
                          'order_no'=>$order_no,
                          'article_no'=>$article_no,
                          'sleeve_dia'=>$sleeve_diameter,
                          'sleeve_length'=>$sleeve_length,
                          'total_microns'=>$total_microns,
                          'second_layer_mb'=>$film_mb_2,
                          'sixth_layer_mb'=>$film_mb_6,
                          'film_code'=>$film_code,
                          'bm_wip_qty'=>$remaining_wip,
                          'user_id'=>$this->session->userdata['logged_in']['user_id'],
                          'company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'created_date'=>date('Y-m-d H:i:s'),                 
                          'from_process'=>'17',
                          'ref_aql_id'=>$this->input->post('aql_id')

                        );

                        $result_final=$this->common_model->save('springtube_bodymaking_wip_master',$data_insert);

                    }


                 }


                 if($result_final){
                     $data['note']='Data Updated Successfully';
                  }else{
                    $data['error']='Error while Updating data';
                  }

                //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['springtube_aql_rfd_master']=$this->springtube_aql_rfd_model->select_one_active_record('springtube_aql_rfd_master',$this->session->userdata['logged_in']['company_id'],'aql_id',$this->input->post('aql_id'));

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                 
               
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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

  function delete($aql_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){


              // Archive Aql record--------------
              $data=array('archive'=>'1');
              $result=$this->common_model->update_one_active_record('springtube_aql_rfd_master',$data,'aql_id',$aql_id,$this->session->userdata['logged_in']['company_id']);  

              $data['springtube_aql_rfd_master']=$this->common_model->select_one_inactive_record('springtube_aql_rfd_master',$this->session->userdata['logged_in']['company_id'],'aql_id',$aql_id); 


              // Archive remaining wip records w r t aql id--------------

                $data_array=array('status'=>0,'archive'=>0,'ref_aql_id'=>$aql_id);
                
                $data['springtube_bodymaking_wip_master_remain']=$this->common_model->select_active_records_where('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_array);
                foreach ($data['springtube_bodymaking_wip_master_remain'] as $key => $wip_row) {
                  
                  $data_archive=array('archive'=>1);
                  $result=$this->common_model->update_one_active_record('springtube_bodymaking_wip_master',$data_archive,'bm_wip_id',$wip_row->bm_wip_id,$this->session->userdata['logged_in']['company_id']);

                }

                //  Making status 0 for Consumed WIP---------

                $data_array=array('status'=>1,'archive'=>0,'ref_aql_id'=>$aql_id);
                $data['springtube_bodymaking_wip_master_1']=$this->common_model->select_active_records_where('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_array);
                
                foreach ($data['springtube_bodymaking_wip_master_1'] as $key => $wip_row) {
                  
                  $data_update=array(
                    'status'=>0,
                    'release_qty'=>'',
                    'release_date'=>'0000-00-00',
                    'release_by'=>'',
                    'next_process'=>0);

                  $result=$this->common_model->update_one_active_record('springtube_bodymaking_wip_master',$data_update,'bm_wip_id',$wip_row->bm_wip_id,$this->session->userdata['logged_in']['company_id']);                

                }              
                   

                
                
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());                  

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




  function archive_records(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
          //print_r( $data['formrights']);

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $table='springtube_aql_rfd_master';
              include('pagination_archive.php');
              $data['springtube_aql_rfd_master']=$this->springtube_aql_rfd_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              
              
             
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
  function search_result(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('order_no','Order No.' ,'trim|xss_clean');        
            $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'trim|xss_clean');
            $this->form_validation->set_rules('article_no','article_no' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_code','Film Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_masterbatch_two','Second Layer MB' ,'trim|xss_clean');
            $this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('status','Status' ,'trim|xss_clean');
                       
            if($this->form_validation->run()==FALSE){

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view('Home/footer');
            }else{              
              
              
              $data_search=array();
              if($this->input->post('jobcard_no')!=''){
                $data_search['jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('customer')!=''){
                $customer_arr=explode("//",$this->input->post('article_no'));
                $data_search['customer']=$customer_arr[1];
              }
              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['sleeve_dia']=$sleeve_dia_arr[0];
              }
              if($this->input->post('sleeve_length')!=''){
                $data_search['sleeve_length']=$this->input->post('sleeve_length');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
              // if($this->input->post('film_code')!=''){
              //   $film_code_arr=explode("//",$this->input->post('film_code'));
              //   $data_search['film_code']=$film_code_arr[1];
              // }
              // if($this->input->post('total_microns')!=''){
              //   $data_search['total_microns']=$this->input->post('total_microns');
              // }
              // if($this->input->post('film_masterbatch_two')!=''){
              //   $data_search['second_layer_mb']=$this->input->post('film_masterbatch_two');
              // }

              // if($this->input->post('status')!=''){
              //   $data_search['status']=$this->input->post('status');
              // }
             

              $data['springtube_aql_rfd_master']=$this->springtube_aql_rfd_model->active_record_search('springtube_aql_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
             //echo $this->db->last_query();            

              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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

  public function article_check($str){
    
      if(!empty($str)){
      $item_code=explode('//',$str);
      if(!empty($item_code[1])){
      $data['item']=$this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1]);
      //echo $this->db->last_query();

      foreach ($data['item'] as $item_row) {
        
        if ($item_row->article_no == $item_code[1]){
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

    function customer_check($str){

    if(!empty($str)){
    $customer_code=explode('//',$str);
    if(!empty($customer_code[1])){
      $data=array('address_master.adr_company_id'=>$customer_code[1],
        'address_master.name1'=>$customer_code[0]);
    $data['customer']=$this->customer_model->active_record_search('address_master',$data,$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
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

  function check_inspection_qty(){

    if(!empty($this->input->post('inspection_qty'))){

      if($this->input->post('inspection_qty')<=$this->input->post('bm_wip_qty')){
        return TRUE;
      }else{
        $this->form_validation->set_message('check_inspectionn_qty', 'The {field} value must be less than or equal to Bodymaking WIP Qty');
        return FALSE;
      }
       
    }

  }

      

}

