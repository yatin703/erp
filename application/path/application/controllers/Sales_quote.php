<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_quote extends CI_Controller {

  function __construct(){    
    parent::__construct();
    if($this->session->userdata('logged_in')){
      
      $this->load->model('common_model');
      $this->load->model('fiscal_model');
      $this->load->model('article_model');
      $this->load->model('sales_quote_model');
      $this->load->model('customer_model');

 
      
    }else{
      redirect('login','refresh');
    }
  }

  function index(){
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $table='sales_quote_master';
              include('pagination.php');
              $data['sales_quote_master']=$this->sales_quote_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
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
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){
              
              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);

              //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $data['tube_color']=$this->common_model->select_active_drop_down('color_master',$this->session->userdata['logged_in']['company_id']);
            
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

               $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
               $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
               $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);


              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');
           
            

               
             
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
              $this->form_validation->set_rules('layer','Layer' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_dia','Tube dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Tube length' ,'required|trim|xss_clean');
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
              $this->form_validation->set_rules('shoulder_foil','Shoulder Foil' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_foil','Cap foil' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_metalization','Cap Metalization' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_shrink_sleeve','Cap shrink sleeve' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('label_price','Label Price' ,'trim|xss_clean');

              // Quote-----------------------------------

          $this->form_validation->set_rules('less_than_10k_target_contr','<10k Target contr.' ,'required|trim|xss_clean');
          $this->form_validation->set_rules('less_than_10k_quoted_contr','<10k Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_cost','<10k Cost' ,'required|trim|xss_clean');
             
              $this->form_validation->set_rules('less_than_10k_quoted_price','<10k Quoted Price' ,'required|trim|xss_clean');


      $this->form_validation->set_rules('_10k_to_25k_target_contr','10k - 25K Target contr.' ,'required|trim|xss_clean');
      $this->form_validation->set_rules('_10k_to_25k_quoted_contr','10k - 25K Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_cost','10k - 25K Cost' ,'required|trim|xss_clean');
             
        $this->form_validation->set_rules('_10k_to_25k_quoted_price','10k - 25K Quoted Price' ,'required|trim|xss_clean');

      $this->form_validation->set_rules('_25k_to_50k_target_contr','25k - 50K Target contr.' ,'required|trim|xss_clean');
      $this->form_validation->set_rules('_25k_to_50k_quoted_contr','25k - 50K Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_cost','25k - 50K Cost' ,'required|trim|xss_clean');
             
              $this->form_validation->set_rules('_25k_to_50k_quoted_price','25K - 50K Quoted Price' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('_50k_to_100k_target_contr','50k - 100K Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_quoted_contr','50k - 100K Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_cost','50k - 100K Cost' ,'required|trim|xss_clean');
              
              $this->form_validation->set_rules('_50k_to_100k_quoted_price','50K - 100K Quoted Price' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('_100k_to_250k_target_contr','100k - 250K Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_quoted_contr','100k - 250K Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_cost','100k - 250K Cost' ,'required|trim|xss_clean');
             
              $this->form_validation->set_rules('_100k_to_250k_quoted_price','100k - 250K Quoted Price' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('greater_than_250k_target_contr','>250k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_quoted_contr','>250k Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_cost','>250k Cost' ,'required|trim|xss_clean');
              
              $this->form_validation->set_rules('greater_than_250k_quoted_price','>250k Quoted Price' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('freight','Freight' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('packing','Packaging' ,'required|trim|xss_clean');
              
                            
              // Cost sheet details------------------------------
              if(!empty($this->input->post('article_no'))){
                $this->form_validation->set_rules('article_no','Article no' ,'trim|xss_clean|callback_article_check');
              }else{
                $this->form_validation->set_rules('article_no','Article no' ,'trim|xss_clean');
              }
              
              //$this->form_validation->set_rules('invoice_date','Costsheet date' ,'trim|xss_clean');
              $this->form_validation->set_rules('invoice_no','Invoice no' ,'required|trim|xss_clean');
              //$this->form_validation->set_rules('cost','Cost' ,'trim|xss_clean');  

              $this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean');             
              
             
              

              //echo $this->input->post('cap_metalization');  

              if($this->form_validation->run()==FALSE){

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
              
                $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['tube_color']=$this->common_model->select_active_drop_down('color_master',$this->session->userdata['logged_in']['company_id']);
            
                $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');
            

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
                $this->load->view('Home/footer');
              }else{

               // echo $this->input->post('cap_metalization');
              //echo "<br/>";
              // echo "hi";

                $sales_quotation_no='';
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
                }

                //$data=array('curr_val'=>$next_sales_order_no);
                //$this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','91',$this->session->userdata['logged_in']['company_id']);
               

                $customer_no=''; 

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

                $less_than_10k_flag=($this->input->post('less_than_10k_flag') == '1' ? '1' :'0');
                $_10k_to_25k_flag=($this->input->post('_10k_to_25k_flag') == '1' ? '1' :'0');
                $_25k_to_50k_flag=($this->input->post('_25k_to_50k_flag') == '1' ? '1' :'0');
                $_50k_to_100k_flag=($this->input->post('_50k_to_100k_flag') == '1' ? '1' :'0');  
                $_100k_to_250k_flag=($this->input->post('_100k_to_250k_flag') == '1' ? '1' :'0');
                $greater_than_250k_flag=($this->input->post('greater_than_250k_flag') == '1' ? '1' :'0');


                 $data=array(
                  'quotation_date'=>date('Y-m-d'),
                  'quotation_no'=>$sales_quotation_no,                  
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
                  'label_price'=>$this->input->post('label_price'),

                  //Quote

                  'less_than_10k_flag'=>$less_than_10k_flag,
                  'less_than_10k_target_contr'=>$this->input->post('less_than_10k_target_contr'),
                  'less_than_10k_quoted_contr'=>$this->input->post('less_than_10k_quoted_contr'),
                  'less_than_10k_cost'=>$this->input->post('less_than_10k_cost'),
                  'less_than_10k_quoted_price'=>$this->input->post('less_than_10k_quoted_price'),

                  '_10k_to_25k_flag'=>$_10k_to_25k_flag,
                  '_10k_to_25k_target_contr'=>$this->input->post('_10k_to_25k_target_contr'),
                  '_10k_to_25k_quoted_contr'=>$this->input->post('_10k_to_25k_quoted_contr'),
                  '_10k_to_25k_cost'=>$this->input->post('_10k_to_25k_cost'),               
                  '_10k_to_25k_quoted_price'=>$this->input->post('_10k_to_25k_quoted_price'),

                  '_25k_to_50k_flag'=>$_25k_to_50k_flag,
                  '_25k_to_50k_target_contr'=>$this->input->post('_25k_to_50k_target_contr'),
                  '_25k_to_50k_quoted_contr'=>$this->input->post('_25k_to_50k_quoted_contr'),
                  '_25k_to_50k_cost'=>$this->input->post('_25k_to_50k_cost'),                                  
                  '_25k_to_50k_quoted_price'=>$this->input->post('_25k_to_50k_quoted_price'),

                  '_50k_to_100k_flag'=>$_50k_to_100k_flag,
                  '_50k_to_100k_target_contr'=>$this->input->post('_50k_to_100k_target_contr'),
                  '_50k_to_100k_quoted_contr'=>$this->input->post('_50k_to_100k_quoted_contr'),
                  '_50k_to_100k_cost'=>$this->input->post('_50k_to_100k_cost'),             
                  '_50k_to_100k_quoted_price'=>$this->input->post('_50k_to_100k_quoted_price'),

                  '_100k_to_250k_flag'=>$_100k_to_250k_flag,
                  '_100k_to_250k_target_contr'=>$this->input->post('_100k_to_250k_target_contr'),
                  '_100k_to_250k_quoted_contr'=>$this->input->post('_100k_to_250k_quoted_contr'),
                  '_100k_to_250k_cost'=>$this->input->post('_100k_to_250k_cost'),
                  '_100k_to_250k_quoted_price'=>$this->input->post('_100k_to_250k_quoted_price'),
                  
                  'greater_than_250k_flag'=>$greater_than_250k_flag,
                  'greater_than_250k_target_contr'=>$this->input->post('greater_than_250k_target_contr'),
                  'greater_than_250k_quoted_contr'=>$this->input->post('greater_than_250k_quoted_contr'),
                  'greater_than_250k_cost'=>$this->input->post('greater_than_250k_cost'),
                  'greater_than_250k_quoted_price'=>$this->input->post('greater_than_250k_quoted_price'),

                  'freight'=>$this->input->post('freight'),
                  'packing'=>$this->input->post('packing'),

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
                //echo $this->db->last_query();
                if($result_sales_quote_master){

                  $data_1=array('curr_val'=>$next_quotation_no);
                  $result_autogeneration_format_master=$this->common_model->update_one_active_record('autogeneration_format_master',$data_1,'form_id','91',$this->session->userdata['logged_in']['company_id']);              

                }

                if(!empty($this->input->post('approval_authority'))){

                  $data=array('pending_flag'=>'1');
                  $result=$this->common_model->update_one_active_record('sales_quote_master',$data,'quotation_no',$sales_quotation_no,$this->session->userdata['logged_in']['company_id']);

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

                if($result_autogeneration_format_master){
                  $data['note']='Data saved Successfully';
                }else{
                  $data['error']='Error while saving data';
                }

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            
                $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');
             
               
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
  function modify($id){
       
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){ 

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']); 

              $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

              //$data['purchase_manager']=$this->common_model->select_active_drop_down('address_category_contact_details',$this->session->userdata['logged_in']['company_id']);

              //echo $this->db->last_query();

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');            
              
              $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'id',$id);

              //echo $this->db->last_query();



              $customer_no='';
              foreach ($data['sales_quote_master'] as $key => $row) {
                $customer_no=$row->customer_no;
              }

             $data_search=array('adr_category_id'=>$customer_no,'archive'=>0);
              $data['purchase_manager']=$this->common_model->select_active_records_where('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],$data_search);



              
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
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

              $this->form_validation->set_rules('id','ID','required|trim|xss_clean');  

              $this->form_validation->set_rules('customer','Custommer ' ,'required|trim|xss_clean');              
              $this->form_validation->set_rules('pm_1','Purchase Manager ' ,'required|trim|xss_clean'); 
              $this->form_validation->set_rules('product_name','Product Name' ,'required|trim|xss_clean'); 
              $this->form_validation->set_rules('credit_days','Credit Days','required|trim|xss_clean');
              $this->form_validation->set_rules('enquiry_date','Enquiry Date','required|trim|xss_clean');

              // Tube Specification-----------------------------              
              $this->form_validation->set_rules('layer','Layer' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_dia','Sleeve dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve length' ,'required|trim|xss_clean');
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
              $this->form_validation->set_rules('shoulder_foil','Shoulder Foil' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_foil','Cap foil' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_metalization','Cap Metalization' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_shrink_sleeve','Cap shrink sleeve' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('label_price','Label Price' ,'trim|xss_clean');

              // Quote-----------------------------------

          $this->form_validation->set_rules('less_than_10k_target_contr','<10k Target contr.' ,'required|trim|xss_clean');
          $this->form_validation->set_rules('less_than_10k_quoted_contr','<10k Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_cost','<10k Cost' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_freight','<10k Freight' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_packing','<10k Packing' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_quoted_price','<10k Quoted Price' ,'required|trim|xss_clean');


      $this->form_validation->set_rules('_10k_to_25k_target_contr','10k - 25K Target contr.' ,'required|trim|xss_clean');
      $this->form_validation->set_rules('_10k_to_25k_quoted_contr','10k - 25K Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_cost','10k - 25K Cost' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_freight','10k - 25K Freight' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_packing','10k - 25K Packing' ,'required|trim|xss_clean');
        $this->form_validation->set_rules('_10k_to_25k_quoted_price','10k - 25K Quoted Price' ,'required|trim|xss_clean');

      $this->form_validation->set_rules('_25k_to_50k_target_contr','25k - 50K Target contr.' ,'required|trim|xss_clean');
      $this->form_validation->set_rules('_25k_to_50k_quoted_contr','25k - 50K Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_cost','25k - 50K Cost' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_freight','25k - 50K Freight' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_packing','25k - 50K Packing' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_quoted_price','25K - 50K Quoted Price' ,'required|trim|xss_clean');

    $this->form_validation->set_rules('_50k_to_100k_target_contr','50k - 100K Target contr.' ,'required|trim|xss_clean');
    $this->form_validation->set_rules('_50k_to_100k_quoted_contr','50k - 100K Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_cost','50k - 100K Cost' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_freight','50k - 100K Freight' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_packing','50k - 100K Packing' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_quoted_price','50K - 100K Quoted Price' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('_100k_to_250k_target_contr','100k - 250K Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_quoted_contr','100k - 250K Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_cost','100k - 250K Cost' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_freight','100k - 250K Freight' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_packing','100k - 250K Packing' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_quoted_price','100k - 250K Quoted Price' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('greater_than_250k_target_contr','>250k Target contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_quoted_contr','>250k Quoted contr.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_cost','>250k Cost' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_freight','>250k Freight' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_packing','>250k Packing' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_quoted_price','>250k Quoted Price' ,'required|trim|xss_clean');

                      
              // Cost sheet details------------------------------

              $this->form_validation->set_rules('article_no','Article no' ,'trim|xss_clean');
              $this->form_validation->set_rules('invoice_date','Costsheet date' ,'trim|xss_clean');
              $this->form_validation->set_rules('invoice_no','Invoice no' ,'trim|xss_clean');
              $this->form_validation->set_rules('cost','Cost' ,'trim|xss_clean'); 
              $this->form_validation->set_rules('remarks','Reamrks' ,'trim|xss_clean');              
              

              if($this->form_validation->run()==FALSE){

                $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));
                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
              
                $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              
                $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);

                $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);

                $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');

                $customer_no='';
              foreach ($data['sales_quote_master'] as $key => $row) {
                $customer_no=$row->customer_no;
              }

              $data_search=array('customer_no'=>$customer_no,'archive'=>0);
              $data['purchase_manager']=$this->common_model->select_active_records_where('sales_quote_master',$this->session->userdata['logged_in']['company_id'],$data_search);


                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');
              }else{

                $customer_no=''; 

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

                 $data=array(
                                    
                  'customer_no'=>$customer_no,
                  'pm_1'=>$this->input->post('pm_1'),
                  'product_name'=>$this->input->post('product_name'),
                  'enquiry_date'=>$this->input->post('enquiry_date'),
                                   
                  // specification
                  
                  'sleeve_dia'=>$sleeve_dia,
                  'shoulder'=>$shoulder,
                  'shoulder_orifice'=>$shoulder_orifice,

                  'cap_type'=>$cap_type,
                  'cap_finish'=>$cap_finish,
                  'cap_dia'=>$cap_dia,
                  'cap_orifice'=>$cap_orifice,
                  'credit_days'=>$this->input->post('credit_days'),

                  'tube_color'=>$tube_color,
                  'tube_lacquer'=>$this->input->post('tube_lacquer'),
                  'sleeve_length'=>$this->input->post('sleeve_length'),
                  'shoulder_color'=>$shoulder_color,
                  'cap_color'=>$cap_color,

                  'layer'=>$this->input->post('layer'),
                  //'tube_mb'=>$this->input->post('tube_mb'),
                  'print_type'=>$this->input->post('print_type'),
                  'special_ink'=>$this->input->post('special_ink'),
                  'tube_foil'=>$this->input->post('tube_foil'),
                  
                  //'cap_mb'=>$this->input->post('cap_mb'),
                  
                  'cap_foil'=>$cap_foil,
                  'cap_foil_width'=>$this->input->post('cap_foil_width'),
                  'cap_foil_dist_frm_bottom'=>$this->input->post('cap_foil_dist_frm_bottom'),

                  'cap_metalization'=>$cap_metalization,
                  'cap_metalization_color'=>$this->input->post('cap_metalization_color'),
                  'cap_metalization_finish'=>$this->input->post('cap_metalization_finish'),

                  'cap_shrink_sleeve'=>$this->input->post('cap_shrink_sleeve'),    
                  'shoulder_foil'=>$this->input->post('shoulder_foil'),
                  'label_price'=>$this->input->post('label_price'),

                  //Quote
                  'less_than_10k_target_contr'=>$this->input->post('less_than_10k_target_contr'),
                  'less_than_10k_quoted_contr'=>$this->input->post('less_than_10k_quoted_contr'),
                  'less_than_10k_cost'=>$this->input->post('less_than_10k_cost'),
                  'less_than_10k_freight'=>$this->input->post('less_than_10k_freight'),
                  'less_than_10k_packing'=>$this->input->post('less_than_10k_packing'),
                  'less_than_10k_quoted_price'=>$this->input->post('less_than_10k_quoted_price'),

                  '_10k_to_25k_target_contr'=>$this->input->post('_10k_to_25k_target_contr'),
                  '_10k_to_25k_quoted_contr'=>$this->input->post('_10k_to_25k_quoted_contr'),
                  '_10k_to_25k_cost'=>$this->input->post('_10k_to_25k_cost'),
                  '_10k_to_25k_freight'=>$this->input->post('_10k_to_25k_freight'),
                  '_10k_to_25k_packing'=>$this->input->post('_10k_to_25k_packing'),
                  '_10k_to_25k_quoted_price'=>$this->input->post('_10k_to_25k_quoted_price'),

                  '_25k_to_50k_target_contr'=>$this->input->post('_25k_to_50k_target_contr'),
                  '_25k_to_50k_quoted_contr'=>$this->input->post('_25k_to_50k_quoted_contr'),
                  '_25k_to_50k_cost'=>$this->input->post('_25k_to_50k_cost'), 
                  '_25k_to_50k_freight'=>$this->input->post('_25k_to_50k_freight'), 
                  '_25k_to_50k_packing'=>$this->input->post('_25k_to_50k_packing'),                  
                  '_25k_to_50k_quoted_price'=>$this->input->post('_25k_to_50k_quoted_price'),

                  '_50k_to_100k_target_contr'=>$this->input->post('_50k_to_100k_target_contr'),
                  '_50k_to_100k_quoted_contr'=>$this->input->post('_50k_to_100k_quoted_contr'),
                  '_50k_to_100k_cost'=>$this->input->post('_50k_to_100k_cost'),
                  '_50k_to_100k_freight'=>$this->input->post('_50k_to_100k_freight'),
                  '_50k_to_100k_packing'=>$this->input->post('_50k_to_100k_packing'), 
                  '_50k_to_100k_quoted_price'=>$this->input->post('_50k_to_100k_quoted_price'),

                  '_100k_to_250k_target_contr'=>$this->input->post('_100k_to_250k_target_contr'),
                  '_100k_to_250k_quoted_contr'=>$this->input->post('_100k_to_250k_quoted_contr'),
                  '_100k_to_250k_cost'=>$this->input->post('_100k_to_250k_cost'),
                  '_100k_to_250k_freight'=>$this->input->post('_100k_to_250k_freight'),
                  '_100k_to_250k_packing'=>$this->input->post('_100k_to_250k_packing'),
                  '_100k_to_250k_quoted_price'=>$this->input->post('_100k_to_250k_quoted_price'),
                  
                  'greater_than_250k_target_contr'=>$this->input->post('greater_than_250k_target_contr'),
                  'greater_than_250k_quoted_contr'=>$this->input->post('greater_than_250k_quoted_contr'),
                  'greater_than_250k_cost'=>$this->input->post('greater_than_250k_cost'),
                  'greater_than_250k_freight'=>$this->input->post('greater_than_250k_freight'),
                  'greater_than_250k_packing'=>$this->input->post('greater_than_250k_packing'),
                  'greater_than_250k_quoted_price'=>$this->input->post('greater_than_250k_quoted_price'),

                  //Customer Price Range
                  

                  //Cost sheet details
                  'article_no'=>$article_no,
                  'invoice_date'=>$this->input->post('invoice_date'),
                  'invoice_no'=>$this->input->post('invoice_no'),
                  'cost'=>$this->input->post('cost'),
                  'remarks'=>$this->input->post('remarks'),
                  'user_id'=>$this->session->userdata['logged_in']['user_id']
                               
                  );

                  $result_update=$this->common_model->update_one_active_record('sales_quote_master',$data,'id',$this->input->post('id'),$this->session->userdata['logged_in']['company_id']); 

                  //echo $this->db->last_query();

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->common_model->update_one_active_record('sales_quote_master',$data,'id',$this->input->post('id'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('quotation_no'));
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
                        'record_no'=>$this->input->post('quotation_no'));

                      $result=$this->common_model->save('followup',$data);

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

                   
                 if($result_update){
                     $data['note']='Data Updated Successfully';
                  }else{
                    $data['error']='Error while Updating data';
                  }

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              
                $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');

                $customer_no='';
                foreach ($data['sales_quote_master'] as $key => $row) {
                  $customer_no=$row->customer_no;
                }

                $data_search=array('customer_no'=>$customer_no,'archive'=>0);
                $data['purchase_manager']=$this->common_model->select_active_records_where('sales_quote_master',$this->session->userdata['logged_in']['company_id'],$data_search);

 
               
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
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

  function delete($id){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              
              

              

             // echo $this->db->last_query();

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');

              

               $update_data=array('archive'=>'1');
               $result=$this->common_model->update_one_active_record('sales_quote_master',$update_data,'id',$id,$this->session->userdata['logged_in']['company_id']); 

               $data['sales_quote_master']=$this->sales_quote_model->select_one_inactive_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'id',$id);

               $customer_no='';
              foreach ($data['sales_quote_master'] as $key => $row) {
                $customer_no=$row->customer_no;
              }

              $data_search=array('customer_no'=>$customer_no,'archive'=>0);
              $data['purchase_manager']=$this->common_model->select_active_records_where('sales_quote_master',$this->session->userdata['logged_in']['company_id'],$data_search);

               
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
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
          //print_r( $data['formrights']);

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $table='sales_quote_master';
              include('pagination_archive.php');
              $data['sales_quote_master']=$this->sales_quote_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

  function dearchive($id){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');


              $update_data=array('archive'=>'0');
              $result=$this->common_model->update_one_active_record('sales_quote_master',$update_data,'id',$id,$this->session->userdata['logged_in']['company_id']); 



              $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'id',$id); 

              $customer_no='';
              foreach ($data['sales_quote_master'] as $key => $row) {
                $customer_no=$row->customer_no;
              } 

              $data_search=array('customer_no'=>$customer_no,'archive'=>0);
              $data['purchase_manager']=$this->common_model->select_active_records_where('sales_quote_master',$this->session->userdata['logged_in']['company_id'],$data_search);
               
              $data['note']='Dearchive Transaction completed';
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


  

  function search(){    
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){


              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
            
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');
            
              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              
             
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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('customer_category','Custommer ' ,'trim|xss_clean');              
              $this->form_validation->set_rules('pm_1','Purchase Manager 1' ,'trim|xss_clean'); 
              $this->form_validation->set_rules('quotation_no','Quotation no' ,'trim|xss_clean');
              $this->form_validation->set_rules('product_name','Product Name' ,'trim|xss_clean'); 
              $this->form_validation->set_rules('credit_days','Credit Days','trim|xss_clean');

              // Tube Specification-----------------------------              
              $this->form_validation->set_rules('layer','Layer' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_dia','Sleeve dia' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve length' ,'trim|xss_clean');
              $this->form_validation->set_rules('tube_color','Tube Color' ,'xss_clean');
              $this->form_validation->set_rules('tube_lacquer','Tube lacquer' ,'xss_clean');
              $this->form_validation->set_rules('print_type','Print Type' ,'trim|xss_clean');
              $this->form_validation->set_rules('special_ink','Special ink' ,'trim|xss_clean');

              // Shoulder Specification-----------------------------
              $this->form_validation->set_rules('shoulder','Shoulder' ,'xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Oriface' ,'xss_clean');
              $this->form_validation->set_rules('shoulder_color','Shoulder Color' ,'xss_clean');

              // Cap Specification-----------------------------
              $this->form_validation->set_rules('cap_type','Cap type' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_finish','Cap Finish' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_dia','Cap Dia' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_orifice','Cap Orifice' ,'xss_clean');              
              $this->form_validation->set_rules('cap_color','Cap Color' ,'xss_clean');

              // Decorative Elements -----------------------------
              $this->form_validation->set_rules('tube_foil','Tube foil' ,'trim|xss_clean');
              $this->form_validation->set_rules('shoulder_foil','Shoulder Foil' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_foil','Cap foil' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_metalization','Cap Metalization' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_shrink_sleeve','Cap shrink sleeve' ,'trim|xss_clean');
              $this->form_validation->set_rules('label_price','Label Price' ,'trim|xss_clean');

              // Quote-----------------------------------

              $this->form_validation->set_rules('less_than_10k_target_contr','<10k Target contr.' ,'trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_quoted_contr','<10k Quoted contr.' ,'trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_cost','<10k Cost' ,'trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_freight','<10k Freight' ,'trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_packing','<10k Packing' ,'trim|xss_clean');
              $this->form_validation->set_rules('less_than_10k_quoted_price','<10k Quoted Price' ,'trim|xss_clean');

              $this->form_validation->set_rules('_10k_to_25k_target_contr','10k - 25K Target contr.' ,'trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_quoted_contr','10k - 25K Quoted contr.' ,'trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_cost','10k - 25K Cost' ,'trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_freight','10k - 25K Freight' ,'trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_packing','10k - 25K Packing' ,'trim|xss_clean');
              $this->form_validation->set_rules('_10k_to_25k_quoted_price','10k - 25K Quoted Price' ,'trim|xss_clean');

              $this->form_validation->set_rules('_25k_to_50k_target_contr','25k - 50K Target contr.' ,'trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_quoted_contr','25k - 50K Quoted contr.' ,'trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_cost','25k - 50K Cost' ,'trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_freight','25k - 50K Freight' ,'trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_packing','25k - 50K Packing' ,'trim|xss_clean');
              $this->form_validation->set_rules('_25k_to_50k_quoted_price','25K - 50K Quoted Price' ,'trim|xss_clean');

              $this->form_validation->set_rules('_50k_to_100k_target_contr','50k - 100K Target contr.' ,'trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_quoted_contr','50k - 100K Quoted contr.' ,'trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_cost','50k - 100K Cost' ,'trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_freight','50k - 100K Freight' ,'trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_packing','50k - 100K Packing' ,'trim|xss_clean');
              $this->form_validation->set_rules('_50k_to_100k_quoted_price','50K - 100K Quoted Price' ,'trim|xss_clean');

            $this->form_validation->set_rules('_100k_to_250k_target_contr','100k - 250K Target contr.' ,'trim|xss_clean');
            $this->form_validation->set_rules('_100k_to_250k_quoted_contr','100k - 250K Quoted contr.' ,'trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_cost','100k - 250K Cost' ,'trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_freight','100k - 250K Freight' ,'trim|xss_clean');
              $this->form_validation->set_rules('_100k_to_250k_packing','100k - 250K Packing' ,'trim|xss_clean');
            $this->form_validation->set_rules('_100k_to_250k_quoted_price','100k - 250K Quoted Price' ,'trim|xss_clean');

              $this->form_validation->set_rules('greater_than_250k_target_contr','>250k Target contr.' ,'trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_quoted_contr','>250k Quoted contr.' ,'trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_cost','>250k Cost' ,'trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_freight','>250k Freight' ,'trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_packing','>250k Packing' ,'trim|xss_clean');
              $this->form_validation->set_rules('greater_than_250k_quoted_price','>250k Quoted Price' ,'trim|xss_clean');


                           
              // Cost sheet details------------------------------

              $this->form_validation->set_rules('article_no','Article no' ,'trim|xss_clean');
              $this->form_validation->set_rules('invoice_date','Costsheet date' ,'trim|xss_clean');
              $this->form_validation->set_rules('invoice_no','Invoice no' ,'trim|xss_clean');
              $this->form_validation->set_rules('cost','Cost' ,'trim|xss_clean');               
                         
            if($this->form_validation->run()==FALSE){

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
            
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view('Home/footer');
            }else{              
              
                $customer_no=''; 

                if(!empty($this->input->post('customer_category'))){

                  $arr=explode("//",$this->input->post('customer_category'));
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

                 $data=array(                   
                  'quotation_no'=>$this->input->post('quotation_no'),                 
                  'customer_no'=>$customer_no,
                  'pm_1'=>$this->input->post('pm_1'),
                  'product_name'=>$this->input->post('product_name'),
                  'credit_days'=>$this->input->post('credit_days'),
                                    
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
                  'cap_foil'=>$this->input->post('cap_foil'),
                  'cap_metalization'=>$this->input->post('cap_metalization'),
                  'cap_shrink_sleeve'=>$this->input->post('cap_shrink_sleeve'),
                  'label_price'=>$this->input->post('label_price'),

                  //Quote
                  'less_than_10k_target_contr'=>$this->input->post('less_than_10k_target_contr'),
                  'less_than_10k_quoted_contr'=>$this->input->post('less_than_10k_quoted_contr'),
                  'less_than_10k_cost'=>$this->input->post('less_than_10k_cost'),
                  'less_than_10k_freight'=>$this->input->post('less_than_10k_freight'),
                  'less_than_10k_packing'=>$this->input->post('less_than_10k_packing'),
                  'less_than_10k_quoted_price'=>$this->input->post('less_than_10k_quoted_price'),

                  '_10k_to_25k_target_contr'=>$this->input->post('_10k_to_25k_target_contr'),
                  '_10k_to_25k_quoted_contr'=>$this->input->post('_10k_to_25k_quoted_contr'),
                  '_10k_to_25k_cost'=>$this->input->post('_10k_to_25k_cost'),
                  '_10k_to_25k_freight'=>$this->input->post('_10k_to_25k_freight'),
                  '_10k_to_25k_packing'=>$this->input->post('_10k_to_25k_packing'),
                  '_10k_to_25k_quoted_price'=>$this->input->post('_10k_to_25k_quoted_price'),

                  '_25k_to_50k_target_contr'=>$this->input->post('_25k_to_50k_target_contr'),
                  '_25k_to_50k_quoted_contr'=>$this->input->post('_25k_to_50k_quoted_contr'),
                  '_25k_to_50k_cost'=>$this->input->post('_25k_to_50k_cost'), 
                  '_25k_to_50k_freight'=>$this->input->post('_25k_to_50k_freight'), 
                  '_25k_to_50k_packing'=>$this->input->post('_25k_to_50k_packing'),                  
                  '_25k_to_50k_quoted_price'=>$this->input->post('_25k_to_50k_quoted_price'),

                  '_50k_to_100k_target_contr'=>$this->input->post('_50k_to_100k_target_contr'),
                  '_50k_to_100k_quoted_contr'=>$this->input->post('_50k_to_100k_quoted_contr'),
                  '_50k_to_100k_cost'=>$this->input->post('_50k_to_100k_cost'),
                  '_50k_to_100k_freight'=>$this->input->post('_50k_to_100k_freight'),
                  '_50k_to_100k_packing'=>$this->input->post('_50k_to_100k_packing'), 
                  '_50k_to_100k_quoted_price'=>$this->input->post('_50k_to_100k_quoted_price'),

                  '_100k_to_250k_target_contr'=>$this->input->post('_100k_to_250k_target_contr'),
                  '_100k_to_250k_quoted_contr'=>$this->input->post('_100k_to_250k_quoted_contr'),
                  '_100k_to_250k_cost'=>$this->input->post('_100k_to_250k_cost'),
                  '_100k_to_250k_freight'=>$this->input->post('_100k_to_250k_freight'),
                  '_100k_to_250k_packing'=>$this->input->post('_100k_to_250k_packing'),
                  '_100k_to_250k_quoted_price'=>$this->input->post('_100k_to_250k_quoted_price'),
                  
                  'greater_than_250k_target_contr'=>$this->input->post('greater_than_250k_target_contr'),
                  'greater_than_250k_quoted_contr'=>$this->input->post('greater_than_250k_quoted_contr'),
                  'greater_than_250k_cost'=>$this->input->post('greater_than_250k_cost'),
                  'greater_than_250k_freight'=>$this->input->post('greater_than_250k_freight'),
                  'greater_than_250k_packing'=>$this->input->post('greater_than_250k_packing'),
                  'greater_than_250k_quoted_price'=>$this->input->post('greater_than_250k_quoted_price'),

                  //Customer Price Range
                  
                  '_50g_min'=>$this->input->post('_50g_min'),
                  '_50g_max'=>$this->input->post('_50g_max'),
                  '_100g_min'=>$this->input->post('_100g_min'),
                  '_100g_max'=>$this->input->post('_100g_max'),
                  '_150g_min'=>$this->input->post('_150g_min'),
                  '_150g_max'=>$this->input->post('_150g_max'),
                  '_200g_min'=>$this->input->post('_200g_min'),                  
                  '_200g_max'=>$this->input->post('_200g_max'),

                  //Cost sheet details
                  'article_no'=>$article_no,
                  'invoice_date'=>$this->input->post('invoice_date'),
                  'invoice_no'=>$this->input->post('invoice_no'),
                  'cost'=>$this->input->post('cost'),
                  'remarks'=>$this->input->post('remarks'),
                                 
                  );
  
              $data_search=array_filter($data);

              $data['sales_quote_master']=$this->sales_quote_model->active_record_search('sales_quote_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
             //echo $this->db->last_query();            

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
            
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','91');

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
             

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
      $data=array('adr_category_id'=>$customer_code[1],
        'category_name'=>$customer_code[0]);
      $data['customer']=$this->common_model->select_active_records_where('address_category_master',$this->session->userdata['logged_in']['company_id'],$data);
      //echo $this->db->last_query();
      foreach ($data['customer'] as $customer_row) {

        if ($customer_row->adr_category_id == $customer_code[1]){
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

  function download(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
                header("Content-Type: application/octet-stream");
  
        $file = "http://192.168.0.9/erp/index.php/sales_quote/view/".$this->uri->segment(3). ".pdf";
          
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

  function view($quotation_no){
       
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){


              $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
            
              $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
 
              
              $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'sales_quote_master.quotation_no',$quotation_no);

              
             // echo $this->db->last_query();

              //$this->load->view('Home/header');
              //$this->load->view('Home/nav',$data);
              //$this->load->view('Home/subnav');
              $this->load->view('Print/header',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
              //$this->load->view('Home/footer');
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



}

