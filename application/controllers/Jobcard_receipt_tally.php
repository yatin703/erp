<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jobcard_receipt_tally extends CI_Controller {

	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('jobcard_receipt_tally_model');

      $this->load->model('article_model');

		}else{
			redirect('login','refresh');
		}

  }

  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $table='tally_issued_material_receipt';

    include('pagination_tally.php');

    $data['tally_issued_material_receipt']=$this->common_model->select_active_records_tally($config["per_page"], $this->uri->segment(3),$table);

  	$this->load->view('Home/header');

  	$this->load->view('Home/nav',$data);

  	$this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

  	$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

  	$this->load->view('Home/footer');

  }

  public function search(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

    $this->load->view('Home/footer');


  }


  public function search_result(){
    
    $this->form_validation->set_rules('from_date','From Date' ,'xss_clean');
    $this->form_validation->set_rules('to_date','To Date' ,'xss_clean');
    $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'xss_clean');
    $this->form_validation->set_rules('status','Status' ,'xss_clean');
    $this->form_validation->set_rules('part_no','Article No.' ,'xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $article_no='';
          $data_search=array();
          if($this->input->post('part_no')!=''){

            $arr_article=explode("//",$this->input->post('part_no'));
            $article_no=$arr_article[1];
            $data_search['part_no']=$article_no;
          }
          if($this->input->post('jobcard_no')!=''){
            $data_search['jobcard_no']=$this->input->post('jobcard_no');
          }
          if(!empty($this->input->post('status'))){
            $data_search['status']=$this->input->post('status');
          }

          // if($this->input->post('status')!=''){
          //   if($this->input->post('status')!='--'){
          //     $data_search['status']=$this->input->post('status');
          //   }else{
          //     $data_search['status']='';
              
          //   }
            
          // }
          // }else{
          //   $data_search['status']='';
          // }



          // $data=array('jobcard_no'=>$this->input->post('jobcard_no'),
          //             'status'=>$this->input->post('status'),
          //             'part_no'=>$article_no

          //           );

          //$data=array_filter($data);
          //print_r($data_search);

          $data['tally_issued_material_receipt']=$this->jobcard_receipt_tally_model->active_record_search('tally_issued_material_receipt',$data_search,$this->input->post('from_date'),$this->input->post('to_date'));

          //echo $this->db->last_query();

          $data['page_name']='setup';

          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
          $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
          $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

          $this->load->view('Home/footer');
         

    }

  }

  public function clear_status(){
   
    
        $this->form_validation->set_rules('id[]','Check selection', 'required');
        
        if($this->form_validation->run()==FALSE){          

          $data['page_name']='setup';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);          

          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
          $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
          $this->load->view('Home/footer');
        }
    else{          

          $flag=0;
          $id_arr=$this->input->post('id[]');
          
          for($i=0;$i<count($id_arr);$i++){

           echo $pkey=$id_arr[$i];
            if($pkey!=''){

                $data=array('status'=>'');
                $result=$this->common_model->update_one_active_record_noncompany('tally_issued_material_receipt',$data,'id',$pkey);
              if( $result==1){
                $flag=1;
                $data['note']='Status clear transaction done.';
                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class()."/search");

              }
            }
          }
          
          $data['page_name']='setup';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
          $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
          
          $this->load->view('Home/footer');
         

    }

  }

  public function search_summary(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form-summary',$data);

    $this->load->view('Home/footer');


  }

    public function search_result_summary(){
    
    $this->form_validation->set_rules('from_date','From Date' ,'xss_clean');
    $this->form_validation->set_rules('to_date','To Date' ,'xss_clean');
    //$this->form_validation->set_rules('jobcard_no','Jobcard No' ,'xss_clean');
    //$this->form_validation->set_rules('status','Status' ,'xss_clean');
    $this->form_validation->set_rules('part_no','Article No.' ,'xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form-summary',$data);

      $this->load->view('Home/footer');

    }
    else{

          $article_no='';
          $data_search=array();
          if($this->input->post('part_no')!=''){

            $arr_article=explode("//",$this->input->post('part_no'));
            $article_no=$arr_article[1];
            $data_search['part_no']=$article_no;
          }
          if($this->input->post('jobcard_no')!=''){
            $data_search['jobcard_no']=$this->input->post('jobcard_no');
          }
          if(!empty($this->input->post('status'))){
            $data_search['status']=$this->input->post('status');
          }

          // if($this->input->post('status')!=''){
          //   if($this->input->post('status')!='--'){
          //     $data_search['status']=$this->input->post('status');
          //   }else{
          //     $data_search['status']='';
              
          //   }
            
          // }
          // }else{
          //   $data_search['status']='';
          // }



          // $data=array('jobcard_no'=>$this->input->post('jobcard_no'),
          //             'status'=>$this->input->post('status'),
          //             'part_no'=>$article_no

          //           );

          //$data=array_filter($data);
          //print_r($data_search);

          $data['tally_issued_material_receipt']=$this->jobcard_receipt_tally_model->active_record_search_groupby('tally_issued_material_receipt',$data_search,$this->input->post('from_date'),$this->input->post('to_date'));

          //echo $this->db->last_query();

          $data['page_name']='setup';

          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
          $this->load->view(ucwords($this->router->fetch_class()).'/search-form-summary',$data);
          $this->load->view(ucwords($this->router->fetch_class()).'/search-result',$data);

          $this->load->view('Home/footer');
         

    }

  }


}
