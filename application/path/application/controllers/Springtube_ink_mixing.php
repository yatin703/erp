<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_ink_mixing extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');       
      $this->load->model('springtube_ink_mixing_model');
    }else{
      redirect('login','refresh');
    }
  }

  function index(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='springtube_ink_mixing_master';
            include('pagination.php');
            $data['springtube_ink_mixing_master']=$this->springtube_ink_mixing_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            // $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
            // $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

            // $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
            // $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);

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
  //Eknath
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('master_ink','Ink Name' ,'required|trim|xss_clean|callback_ink_check');
             
            $arr=$this->input->post('inks');
            //print_r($this->input->post('pantone'));
            if(is_array($arr)){
              for($i=0;$i<count($arr);$i++){

                $this->form_validation->set_rules('inks[]','Inks '.$i ,'required|trim|xss_clean|callback_ink_check');
                $this->form_validation->set_rules('quantity[]','Quantity (Grams) '.$i ,'required|trim|xss_clean');
                  
              }
            }
            

            if($this->form_validation->run()==FALSE){
              
              // $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
              // $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

              // $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
              // $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

              $master_ink_id='';
              if($this->input->post('master_ink')!=''){
                $master_ink_arr=explode("//", $this->input->post('master_ink'));
                $master_ink_id=$master_ink_arr[1];
              }

              
              $data=array(                    
                    'ink_mixing_date'=>date('Y-m-d'),
                    'ink_id'=>$master_ink_id,
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'company_id'=>$this->session->userdata['logged_in']['company_id']                 
                    );

              $mixing_id=$this->common_model->save_return_pkey('springtube_ink_mixing_master',$data);
              //$mixing_id=0;  
              $arr1=$this->input->post('inks');
              //print_r($arr1); 
              if($mixing_id!='' || $mixing_id!=0){               

                $arr1=$this->input->post('inks');
                 
                    //print_r($arr1);
                if(is_array($arr1)){
                  $j=1;
                  $total_quantity=0;
                  for($i=0;$i<count($arr1);$i++){
                    $total_quantity+=$this->input->post('quantity['.$i.']');
                  }

                  for($i=0;$i<count($arr1);$i++){

                      $ink_id='';
                      $ink_arr=explode("//", $this->input->post('inks['.$i.']'));
                      $ink_id= $ink_arr[1]; 
                      $data=array(                    
                        'mixing_id'=>$mixing_id,
                        'ink_seq_no'=>$j,
                        'ink_id'=>$ink_id,
                        'quantity'=>$this->input->post('quantity['.$i.']'),
                        'ink_perc'=>round(($this->input->post('quantity['.$i.']')*100)/$total_quantity)
                                   
                      );
                      
                      $result=$this->common_model->save('springtube_ink_mixing_details',$data);
                    $j++;  
                  }
                }

              }

              if($result){
                $data_master=array('mixing_status'=>1);                
                $result=$this->common_model->update_one_active_record('springtube_ink_master',$data_master,'ink_id',$master_ink_id,$this->session->userdata['logged_in']['company_id']);

                 $data['note']='Create Transaction Completed';
               }else{
                $data['note']='Create Transaction failed';
               }

               header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
              $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

              $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
              $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);

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

  function modify(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['springtube_ink_mixing_master']=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.mixing_id',$this->uri->segment(3));

              // $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
              // $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

              // $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
              // $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);

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
      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

              $this->form_validation->set_rules('master_ink','Ink Name' ,'required|trim|xss_clean|callback_ink_check');
             
              $arr=$this->input->post('inks');
              //print_r($this->input->post('pantone'));
              if(is_array($arr)){
                for($i=0;$i<count($arr);$i++){

                  $this->form_validation->set_rules('inks[]','Inks '.$i ,'required|trim|xss_clean|callback_ink_check');
                  $this->form_validation->set_rules('quantity[]','Quantity (Grams) '.$i ,'required|trim|xss_clean');
                    
                }
              }             

              if($this->form_validation->run()==FALSE){

                
                // $data['springtube_ink_mixing_master']=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.mixing_id',$this->input->post('mixing_id'));

                // $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
                // $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

                $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
                $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                $master_ink_id='';
                if($this->input->post('master_ink')!=''){
                  $master_ink_arr=explode("//", $this->input->post('master_ink'));
                  $master_ink_id=$master_ink_arr[1];
                }

                $data=array(        
                     
                  'ink_id'=>$master_ink_id,
                                     
                );

                $result=$this->common_model->update_one_active_record('springtube_ink_mixing_master',$data,'mixing_id',$this->input->post('mixing_id'),$this->session->userdata['logged_in']['company_id']);

                // Removing Ink details and inserting new
                $result=$this->common_model->delete_one_active_record_noncompany('springtube_ink_mixing_details','mixing_id',$this->input->post('mixing_id'));

                $arr1=$this->input->post('inks');
                //print_r($arr1); 
                if($this->input->post('mixing_id')!='' || $this->input->post('mixing_id')!=0){

                      $arr1=$this->input->post('inks');
                      //print_r($arr1);
                      if(is_array($arr1)){
                          $j=1;
                          $total_quantity=0;
                          for($i=0;$i<count($arr1);$i++){
                            $total_quantity+=$this->input->post('quantity['.$i.']');
                          }


                          for($i=0;$i<count($arr1);$i++){

                            $ink_id='';
                            $ink_arr=explode("//", $this->input->post('inks['.$i.']'));
                            $ink_id= $ink_arr[1];

                            $ink_perc= $this->input->post('quantity['.$i.']')*100/$total_quantity;

                            $data=array(                    
                              'mixing_id'=>$this->input->post('mixing_id'),
                              'ink_seq_no'=>$j,
                              'ink_id'=>$ink_id,
                              'quantity'=>$this->input->post('quantity['.$i.']'),
                              'ink_perc'=>round($ink_perc,2)
                              //'ink_perc'=>round((($this->input->post('quantity['.$i.']')*100)/($total_quantity),2); 
                                         
                            );
                              
                            $result=$this->common_model->save('springtube_ink_mixing_details',$data);
                            $j++;  
                          }
                      }

                }
                if($result){

                $data_master=array('mixing_status'=>1);                
                $result=$this->common_model->update_one_active_record('springtube_ink_master',$data_master,'ink_id',$master_ink_id,$this->session->userdata['logged_in']['company_id']);

                  $data['note']='Update Transaction Completed';
                }else{
                  $data['error']='Update Transaction failed';
                }

                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  $data['page_name']='Production';

                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                  $data['springtube_ink_mixing_master']=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.mixing_id',$this->input->post('mixing_id'));

                  // $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
                  // $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

                  // $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
                  // $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);

                 
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

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->common_model->update_one_active_record('springtube_ink_mixing_master',$data,'mixing_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['springtube_ink_mixing_master']=$this->springtube_ink_mixing_model->select_one_inactive_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.mixing_id',$this->uri->segment(3));

                  // $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
                  // $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

                  // $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
                  // $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);

                
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


    function dearchive(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){
              

              $data=array('archive'=>'0');              

              $result=$this->common_model->update_one_active_record('springtube_ink_mixing_master',$data,'mixing_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

              $data['springtube_ink_mixing_master']=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.mixing_id',$this->uri->segment(3));

              // $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
              // $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

              // $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
              // $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);

              $data['page_name']='Production';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());              
                  

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
  function archive_records(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){

             $table='springtube_ink_mixing_master';
            include('pagination.php');
            $data['springtube_ink_mixing_master']=$this->springtube_ink_mixing_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);


            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);


            $data['springtube_ink_mixing_master']=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.mixing_id',$this->uri->segment(3));

            
            $dataa=array('mixing_id'=>$this->uri->segment(3));

            $data['springtube_ink_mixing_details']=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$dataa,$this->session->userdata['logged_in']['company_id']);
            
            $data['page_name']='Production';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

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


  function search(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){             

            // $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
            // $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

            // $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
            // $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);

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
              $this->form_validation->set_rules('ink_name','Ink Name' ,'trim|xss_clean');
              


            if($this->form_validation->run()==FALSE){               

                // $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
                // $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

                // $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
                // $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{



               $ink_code='';   
               if(!empty($this->input->post('ink_name'))){
                  $arr=explode("//",$this->input->post('ink_name'));
                  if(count($arr)>=2){
                      $ink_code=$arr[1];
                  }
               }
                // $data=array(                 
                
                // 'ink_name'=>$this->input->post('ink_name')                 
                                
                // );

               $data=array(                 
                
                'ink_id'=>$ink_code                 
                                
                );



                $data['springtube_ink_mixing_master']=$this->springtube_ink_mixing_model->active_record_search('springtube_ink_mixing_master',$data,$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);
               // echo $this->db->last_query();
                 
                if($data['springtube_ink_mixing_master']!=FALSE){

                  
                  // $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
                  // $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

                  // $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
                  // $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);

                    $data['page_name']='Production';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    //$this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                    $this->load->view('Home/footer');
                }else{

                    $data['page_name']='Production';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                       

                    // $data_direct_ink = array('archive' =>'0','ink_composition'=>'1');
                    // $data['springtube_ink_master_direct']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_direct_ink);

                    // $data_mixing_ink = array('archive' =>'0','ink_composition'=>'2');
                    // $data['springtube_ink_master_mixing']=$this->common_model->select_active_records_where('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],$data_mixing_ink);
                        

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

  public function ink_check($str){

      if(!empty($str)){

        $ink_arr=explode('//',$str);

        if(!empty($ink_arr[1])){

          $data['springtube_ink_master']=$this->common_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_arr[1]);
          //echo $this->db->last_query();

          foreach ($data['springtube_ink_master'] as $row) {
            
            if ($row->ink_desc == $ink_arr[0]){
              return TRUE;
            }else{
              $this->form_validation->set_message('ink_check', 'The {field} field is incorrect');
              return FALSE;
            }
          } 
        }else{
            $this->form_validation->set_message('ink_check', 'The {field} field is incorrect');
            return FALSE;
        }

      }

    }
  

  
}