<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Currency extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('country_model');
      $this->load->model('currency_model');
    


		}else{

			redirect('login','refresh');

		}

  }



  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='currency_rates_master';

    include('pagination_noncompany.php');

    $data['currency_rates_master']=$this->currency_model->select_active_records($config["per_page"], $this->uri->segment(3),$table);
    ///echo $this->db->last_query();

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

    $data['country']=$this->country_model->select_active_drop_down('country_master');
    $data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
    $data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }


  public function save(){

    $this->form_validation->set_rules('country_id','Country' ,'required|xss_clean|max_length[50]');
    $this->form_validation->set_rules('for_currency','For Currency','required|xss_clean|strtoupper');
    $this->form_validation->set_rules('to_currency','To Currency','required|xss_clean|strtoupper');
    $this->form_validation->set_rules('exchange_rate','Exchange rate','required|xss_clean|max_length[10]');
    $this->form_validation->set_rules('old_exch_rate','Old Exchange rate','xss_clean|max_length[15]');


    
    if($this->form_validation->run()==FALSE){
        $data['page_name']='setup';

        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $data['country']=$this->country_model->select_active_drop_down('country_master');
        $data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
        $data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

        $this->load->view('Home/header');

        $this->load->view('Home/nav',$data);

        $this->load->view('Home/subnav');

        $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

        $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

        $this->load->view('Home/footer');
    }
    else
    {
       

          $data=array('country_id'=>$this->input->post('country_id'),
                       'for_currency'=>$this->input->post('for_currency'),
                       'to_currency'=>$this->input->post('to_currency')
                      );

          $count=$this->currency_model->active_record_count('currency_rates_master',$data);

          if($count>=1){           


            $data['note']='Duplicate Entry Warning';
           
            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $data['country']=$this->country_model->select_active_drop_down('country_master');
            $data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
            $data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

            $this->load->view('Home/footer');



          }
          else
          {

              $data=array('country_id'=>$this->input->post('country_id'),
                       'for_currency'=>$this->input->post('for_currency'),
                       'to_currency'=>$this->input->post('to_currency'),
                       'exchange_rate'=>($this->input->post('exchange_rate')!=0?($this->input->post('exchange_rate')*100) :0),
                       'old_exch_rate'=>($this->input->post('old_exch_rate')!=0?($this->input->post('old_exch_rate')*100) :0),
                       'date_changed'=>date("Y-m-d H:i:s"),
                       'archive'=>'0'
                        );
              $result=$this->common_model->save('currency_rates_master',$data);

              if($result==1){

                $data['note']='Save Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['page_name']='setup';

                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['country']=$this->country_model->select_active_drop_down('country_master');
                  $data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
                  $data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

                $this->load->view('Home/header');

                $this->load->view('Home/nav',$data);

                $this->load->view('Home/subnav');

                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

                $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

                $this->load->view('Home/footer');

              }
              else{

                $data['note']='Error in Save Transaction';

                $data['page_name']='setup';

                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['country']=$this->country_model->select_active_drop_down('country_master');
                $data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
                $data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

                $this->load->view('Home/header');

                $this->load->view('Home/nav',$data);

                $this->load->view('Home/subnav');

                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

                $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

                $this->load->view('Home/footer');

              }  

          }
    
    } 
  
  }

  public function modify(){
   
    $country_id=$this->uri->segment(3);
    $for_currency=$this->uri->segment(4);
    $to_currency=$this->uri->segment(5);

    $data1=array('country_id'=>$country_id,
                       'for_currency'=>$for_currency,
                       'to_currency'=>$to_currency
                       );
    $table='currency_rates_master';
    $data['currency_rates_master']=$this->currency_model->select_one_active_record($table,$data1);
    //$data['country']=$this->country_model->select_active_drop_down('country_master');
   // $data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
   // $data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

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
   
    
    $this->form_validation->set_rules('exchange_rate','Exchange rate','required|xss_clean|max_length[10]');
    $this->form_validation->set_rules('old_exch_rate','Old Exchange rate','xss_clean|max_length[15]');


    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $country_id=$this->input->post('country_id');
      $for_currency=$this->input->post('for_currency');
      $to_currency=$this->input->post('to_currency');

      $data1=array('country_id'=>$country_id,
                         'for_currency'=>$for_currency,
                         'to_currency'=>$to_currency
                         );
      $table='currency_rates_master';
      $data['currency_rates_master']=$this->currency_model->select_one_active_record($table,$data1);
      // $data['country']=$this->country_model->select_active_drop_down('country_master');
      // $data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
      // $data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');


    }
    else{
        $country_id=$this->input->post('country_id');
        $for_currency=$this->input->post('for_currency');
        $to_currency=$this->input->post('to_currency');
        $exchange_rate=($this->input->post('exchange_rate')!=0?$this->input->post('exchange_rate')*100:$this->input->post('exchange_rate'));
       echo$old_exch_rate=($this->input->post('old_exch_rate')!=0?$this->input->post('old_exch_rate')*100:$this->input->post('old_exch_rate'));

        $pkey=array('country_id'=>$country_id,
                    'for_currency'=>$for_currency,
                    'to_currency'=>$to_currency
                         
                    );

        $data1=array(
                         'exchange_rate'=>$exchange_rate,
                         'old_exch_rate'=>$old_exch_rate,
                         'date_changed'=>date("Y-m-d H:i:s")
                         
                    );
        $table="currency_rates_master";
        $result=$this->currency_model->update_one_active_record($table,$data1,$pkey);
        if( $result==1){

            $data['note']='Update Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            // $country_id=$this->input->post('country_id');
            // $for_currency=$this->input->post('for_currency');
            // $to_currency=$this->input->post('to_currency');

            $pkey=array('country_id'=>$country_id,
                               'for_currency'=>$for_currency,
                               'to_currency'=>$to_currency
                               );

            $table='currency_rates_master';
            $data['currency_rates_master']=$this->currency_model->select_one_active_record($table,$pkey);
            //$data['country']=$this->country_model->select_active_drop_down('country_master');
            //$data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
            //$data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

            $this->load->view('Home/footer');


        }
        else{

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $country_id=$this->uri->segment(3);
            $for_currency=$this->uri->segment(4);
            $to_currency=$this->uri->segment(5);

            $data1=array('country_id'=>$country_id,
                               'for_currency'=>$for_currency,
                               'to_currency'=>$to_currency
                               );
            $table='currency_rates_master';
            $data['currency_rates_master']=$this->currency_model->select_one_active_record($table,$data1);
            // $data['country']=$this->country_model->select_active_drop_down('country_master');
            // $data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
            // $data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

            $this->load->view('Home/footer');



        }              


    }

  }

  public function delete(){

    $country_id=$this->uri->segment(3);
    $for_currency=$this->uri->segment(4);
    $to_currency=$this->uri->segment(5);

    $data=array('archive'=>'1');

    $pkey=array('country_id'=>$country_id,
                       'for_currency'=>$for_currency,
                       'to_currency'=>$to_currency
                       );
    $table='currency_rates_master';
    $result=$this->currency_model->update_one_active_record($table,$data,$pkey);

    if($result==1){

      $data['note']='Archive transaction completed';
     // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $table='currency_rates_master';
      $data['currency_rates_master']=$this->currency_model->select_one_active_record($table,$pkey);
      //$data['country']=$this->country_model->select_active_drop_down('country_master');
      // $data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
     // $data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

     $data['page_name']='setup';

     $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

     $this->load->view('Home/header');

     $this->load->view('Home/nav',$data);

     $this->load->view('Home/subnav');

     $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

     $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

     $this->load->view('Home/footer');


    }else{
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

  public function archive_records(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='currency_rates_master';

    include('pagination_archive_noncompany.php');

    $data['currency_rates_master']=$this->currency_model->select_archive_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);

    $this->load->view('Home/footer');

  }

  public function dearchive(){

    $country_id=$this->uri->segment(3);
    $for_currency=$this->uri->segment(4);
    $to_currency=$this->uri->segment(5);

    $data=array('archive'=>'0');

    $pkey=array('country_id'=>$country_id,
                'for_currency'=>$for_currency,
                'to_currency'=>$to_currency
                );
    $table='currency_rates_master';
    $result=$this->currency_model->update_one_active_record($table,$data,$pkey);

    if($result==1){

      $data['note']='Dearchive transaction completed';
      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $table='currency_rates_master';
      $data['currency_rates_master']=$this->currency_model->select_one_active_record($table,$pkey);
     
      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');


    }else{
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

    $data['country']=$this->country_model->select_active_drop_down('country_master');
    $data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
    $data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

    $this->load->view('Home/footer');
  }

    public function search_result(){

    $this->form_validation->set_rules('country_id','Country' ,'xss_clean|max_length[50]');
    $this->form_validation->set_rules('for_currency','For Currency','xss_clean|strtoupper');
    $this->form_validation->set_rules('to_currency','To Currency','xss_clean|strtoupper');
    $this->form_validation->set_rules('exchange_rate','Exchange rate','xss_clean|max_length[10]');
    $this->form_validation->set_rules('old_exch_rate','Old Exchange rate','xss_clean|max_length[15]');


    
    if($this->form_validation->run()==FALSE){
        $data['page_name']='setup';

        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $data['country']=$this->country_model->select_active_drop_down('country_master');
        $data['for_currency']=$this->currency_model->select_for_currency_drop_down('country_master');
        $data['to_currency']=$this->currency_model->select_for_currency_drop_down('country_master');

        $this->load->view('Home/header');

        $this->load->view('Home/nav',$data);

        $this->load->view('Home/subnav');

        $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

        $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

        $this->load->view('Home/footer');
    }
    else
    {
      
    $country_id=$this->input->post('country_id');
    $for_currency=$this->input->post('for_currency');
    $to_currency=$this->input->post('to_currency');
    $exchange_rate=($this->input->post('exchange_rate')!=0?($this->input->post('exchange_rate')*100) :'');
    $old_exch_rate=($this->input->post('old_exch_rate')!=0?($this->input->post('old_exch_rate')*100) :'');
      $data1=array('country_id'=>$country_id,
                      'for_currency'=> $for_currency,
                      'to_currency'=>$to_currency,
                       'exchange_rate'=>$exchange_rate,
                       'old_exch_rate'=>$old_exch_rate
                    );


      
      $table='currency_rates_master';
      $data['currency_rates_master']=$this->currency_model->active_record_search($table,$data1);
         
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

  public function history(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='currency_history';

    //include('pagination_noncompany.php');

    $data['currency_history']=$this->currency_model->select_active_records($config["per_page"], $this->uri->segment(3),$table);
    ///echo $this->db->last_query();

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/history-records',$data);

    $this->load->view('Home/footer');

  }




 } 