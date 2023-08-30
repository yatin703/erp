<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Country extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('country_model');


		}else{

			redirect('login','refresh');

		}

  }



  public function index(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='country_master';

    include('pagination_noncompany.php');

    $data['country']=$this->country_model->select_active_records($config["per_page"], $this->uri->segment(3),$table);

  	$this->load->view('Home/header');

  	$this->load->view('Home/nav',$data);

  	$this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

  	$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

  	$this->load->view('Home/footer');

  }

  public function create(){
    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $data['language']=$this->common_model->select_active_drop_down('languages','9999');

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    
    $this->form_validation->set_rules('lang_country_name','Country Name' ,'required|xss_clean|max_length[64]|strtoupper|is_unique[country_master_lang.lang_country_name]');
    $this->form_validation->set_rules('country_short_id','Country Short Id' ,'xss_clean|max_length[5]|strtoupper');
    $this->form_validation->set_rules('currency_name','Currency' ,'required|xss_clean|max_length[64]|strtoupper');
    $this->form_validation->set_rules('currency_symbol','Currency Symbol' ,'xss_clean|max_length[5]|strtoupper');
    $this->form_validation->set_rules('currency_small_deno','Currency Small Deno' ,'xss_clean|max_length[10]|strtoupper');
    $this->form_validation->set_rules('language','Country Language' ,'xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['language']=$this->common_model->select_active_drop_down('languages','9999');

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

        $max_pkey=0;
        $result=$this->common_model->select_max_pkey_noncompany('country_master_lang','country_id'); 
        
        foreach($result as $row){

          $max_pkey=$row->country_id;
        }

        $country_id=$max_pkey+1;

        $data=array('country_id'=>$country_id,'lang_country_name'=>$this->input->post('lang_country_name'),'language_id'=>'1');

        $result=$this->common_model->save('country_master_lang',$data);

        if($result){

           $data=array('country_id'=>$country_id,
                       'country_short_id'=>$this->input->post('country_short_id'),
                       'currency_name'=>$this->input->post('currency_name'), 
                       'currency_symbol'=>$this->input->post('currency_symbol'),
                       'currency_small_deno'=>$this->input->post('currency_small_deno'),
                       'country_language_id'=>$this->input->post('language'),
                       'archive'=>'0');


          $result=$this->common_model->save('country_master',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $data['language']=$this->common_model->select_active_drop_down('languages','9999');

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

            $this->load->view('Home/footer');

          }
          

        }
        else{

          $data['note']='Error in Save Transaction';

          $data['page_name']='setup';

          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view('Error/error-title',$data);

          $this->load->view('Home/footer');

        }

    }


    
  }




  function modify(){


    $data['country_master']=$this->country_model->select_one_active_record('country_master','country_master.country_id',$this->uri->segment(3));

    //$data['country_master_lang']=$this->country_model->select_one_active_record('country_master_lang','country_id',$this->uri->segment(3));

    $data['language']=$this->common_model->select_active_drop_down('languages','9999');

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }



  public function update(){

    $this->form_validation->set_rules('lang_country_name','Country Name' ,'required|xss_clean|max_length[64]|strtoupper');
    $this->form_validation->set_rules('country_short_id','Country Short Id' ,'xss_clean|max_length[5]|strtoupper');
    $this->form_validation->set_rules('currency_name','Currency' ,'required|xss_clean|max_length[64]|strtoupper');
    $this->form_validation->set_rules('currency_symbol','Currency Symbol' ,'xss_clean');
    $this->form_validation->set_rules('currency_small_deno','Currency Small Deno' ,'xss_clean|max_length[10]|strtoupper');
    $this->form_validation->set_rules('language','Country Language' ,'xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['country_master']=$this->country_model->select_one_active_record('country_master','country_master.country_id',$this->input->post('country_id'));

      //$data['country_master_lang']=$this->country_model->select_one_active_record('country_master_lang','country_id',$this->input->post('country_id'));

      $data['language']=$this->common_model->select_active_drop_down('languages','9999');

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

        $data=array('lang_country_name'=>$this->input->post('lang_country_name'));
        $result=$this->common_model->update_one_active_record_noncompany('country_master_lang',$data,'country_id',$this->input->post('country_id'));

        if($result){

           $data=array(
                       'country_short_id'=>$this->input->post('country_short_id'),
                       'currency_name'=>$this->input->post('currency_name'), 
                       'currency_symbol'=>$this->input->post('currency_symbol'),
                       'currency_small_deno'=>$this->input->post('currency_small_deno'),
                       'country_language_id'=>$this->input->post('language')
                       );

          $result=$this->common_model->update_one_active_record_noncompany('country_master',$data,'country_id',$this->input->post('country_id'));



          if($result==1){

            $data['note']='Update Transaction Completed';
            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['country_master']=$this->country_model->select_one_active_record('country_master','country_master.country_id',$this->input->post('country_id'));

            //$data['country_master_lang']=$this->country_model->select_one_active_record('country_master_lang','country_id',$this->input->post('country_id'));

            $data['language']=$this->common_model->select_active_drop_down('languages','9999');

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

            $this->load->view('Home/footer');

          }
          

        }
        else{

          $data['note']='Error in Update Transaction';

          $data['page_name']='setup';

          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view('Error/error-title',$data);

          $this->load->view('Home/footer');

        }

    }
    
  }

  public function delete(){

    $data=array('archive'=>'1');
    $result=$this->common_model->update_one_active_record_noncompany('country_master',$data,'country_id',$this->uri->segment(3));

    if($result){

      $data['note']="Archive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['country_master']=$this->country_model->select_one_inactive_record('country_master','country_master.country_id',$this->uri->segment(3));

      //$data['country_master_lang']=$this->country_model->select_one_active_record('country_master_lang','country_id',$this->uri->segment(3));

      $data['language']=$this->common_model->select_active_drop_down('languages','9999');

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');


    }
    else{
        $data['note']='Error in Archive Transaction';

        $data['page_name']='setup';

        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $this->load->view('Home/header');

        $this->load->view('Home/nav',$data);

        $this->load->view('Home/subnav');

        $this->load->view('Error/error-title',$data);

        $this->load->view('Home/footer');



    }

  }

  function archive_records(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='country_master';

    include('pagination_archive_noncompany.php');

    $data['country']=$this->country_model->select_archive_records($config["per_page"], $this->uri->segment(3),$table);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);

    $this->load->view('Home/footer');


  }


  function dearchive(){

    $data=array('archive'=>'0');
    $result=$this->common_model->update_one_active_record_noncompany('country_master',$data,'country_id',$this->uri->segment(3));

    if($result){

      $data['note']="Dearchive Transaction completed";
      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['country_master']=$this->country_model->select_one_inactive_record('country_master','country_master.country_id',$this->uri->segment(3));

      //$data['country_master_lang']=$this->country_model->select_one_active_record('country_master_lang','country_id',$this->uri->segment(3));

      $data['language']=$this->common_model->select_active_drop_down('languages','9999');

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');


    }
    else{
        $data['note']='Error in Dearchive Transaction';

        $data['page_name']='setup';

        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $this->load->view('Home/header');

        $this->load->view('Home/nav',$data);

        $this->load->view('Home/subnav');

        $this->load->view('Error/error-title',$data);

        $this->load->view('Home/footer');



    }

  }

  public function search(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $data['language']=$this->common_model->select_active_drop_down('languages','9999');

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

    $this->load->view('Home/footer');


  }


  public function search_result(){

    
    $this->form_validation->set_rules('lang_country_name','Country Name' ,'xss_clean|max_length[64]|strtoupper');
    $this->form_validation->set_rules('country_short_id','Country Short Id' ,'xss_clean|max_length[5]|strtoupper');
    $this->form_validation->set_rules('currency_name','Currency' ,'xss_clean|max_length[64]|strtoupper');
    $this->form_validation->set_rules('currency_symbol','Currency Symbol' ,'xss_clean|max_length[5]|strtoupper');
    $this->form_validation->set_rules('currency_small_deno','Currency Small Deno' ,'xss_clean|max_length[10]|strtoupper');
    $this->form_validation->set_rules('language','Country Language' ,'xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['language']=$this->common_model->select_active_drop_down('languages','9999');

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

      $this->load->view('Home/footer');

    }
    else{
          $data=array('lang_country_name'=>$this->input->post('lang_country_name'),
                       'country_short_id'=>$this->input->post('country_short_id'),
                       'currency_name'=>$this->input->post('currency_name'), 
                       'currency_symbol'=>$this->input->post('currency_symbol'),
                       'currency_small_deno'=>$this->input->post('currency_small_deno'),
                       'country_language_id'=>$this->input->post('language'),

                       );

          $data['country']=$this->country_model->active_record_search('country_master',$data);

          $data['page_name']='setup';

          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

          $this->load->view('Home/footer');
         

    }

  }




}
