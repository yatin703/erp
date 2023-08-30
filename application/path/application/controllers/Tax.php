<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Tax extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('tax_model');


		}else{

			redirect('login','refresh');

		}

  }



  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='tax_master';

    include('pagination.php');

    $data['tax_master']=$this->tax_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

    //echo $this->db->last_query();

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


    $data['sales_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
    $data['purchase_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
    $data['tr6_account_heads_master']=$this->common_model->select_active_drop_down_noncompany('tr6_account_heads_master');
    $data['tax_group']=array('EXCISE','EXCISE_ECESS','EXCISE_HECESS','ST','ST_ECESS','ST_HECESS','CUSTOMS','CVD','CVD_ECESS','CVD_HECESS','CUSTOMS_ECESS','CUSTOMS_HECESS','ADDICVD','VAT','CST','TCS');


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){

      
    $this->form_validation->set_rules('creation_date','Creation Date' ,'trim|required|xss_clean');
    $this->form_validation->set_rules('tax_rate','Tax rate' ,'trim|required|decimal|xss_clean');
    $this->form_validation->set_rules('lang_tax_code_desc','Tax Code Description' ,'trim|required|xss_clean|strtoupper');
    $this->form_validation->set_rules('account_head_id','Sales Account Head' ,'trim|required|xss_clean');
    $this->form_validation->set_rules('account_head_id_p','Purchase Account Head' ,'trim|required|xss_clean');
    $this->form_validation->set_rules('govt_acct_head_no','Govt. Account Head' ,'trim|xss_clean|strtoupper');
    $this->form_validation->set_rules('tax_name','Tax Name' ,'trim|xss_clean|strtoupper');
    $this->form_validation->set_rules('form_id','Form No.' ,'trim|xss_clean|is_natural');
    $this->form_validation->set_rules('for_tds','TDS' ,'trim|xss_clean');
    $this->form_validation->set_rules('not_in_incl_price','Not In Inclusive' ,'trim|xss_clean');
    $this->form_validation->set_rules('not_passed_on','Not Passed On' ,'trim|xss_clean');
    $this->form_validation->set_rules('mrp_diff_av','MRP Applicable' ,'trim|xss_clean');
    $this->form_validation->set_rules('exp_flg','Expense' ,'trim|xss_clean');



    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['sales_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
      $data['purchase_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
      $data['tr6_account_heads_master']=$this->common_model->select_active_drop_down_noncompany('tr6_account_heads_master');
      $data['tax_group']=array('EXCISE','EXCISE_ECESS','EXCISE_HECESS','ST','ST_ECESS','ST_HECESS','CUSTOMS','CVD','CVD_ECESS','CVD_HECESS','CUSTOMS_ECESS','CUSTOMS_HECESS','ADDICVD','VAT','CST','TCS');


      
      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $max_pkey=0;

          $result=$this->common_model->select_max_pkey_numeric('tax_master','tax_code',$this->session->userdata['logged_in']['company_id']); 
          echo $this->db->last_query();
          
          foreach($result as $row){

              $max_pkey=$row->tax_code;
          }

          $tax_code=$max_pkey+1;

          $creation_date=$this->common_model->change_date_format($this->input->post('creation_date'),$this->session->userdata['logged_in']['company_id']);
          $tax_rate=$this->common_model->save_number($this->input->post('tax_rate'),$this->session->userdata['logged_in']['company_id']);
          $form_id=$this->common_model->save_number($this->input->post('form_id'),$this->session->userdata['logged_in']['company_id']);
           
          $tax_master=array( 
                      'tax_code'=>$tax_code,
                      'tax_pos_no'=>$tax_code,
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'creation_date'=>$creation_date,
                      'tax_rate'=>$tax_rate,
                      'account_head_id'=>$this->input->post('account_head_id'),
                      'account_head_id_p'=>$this->input->post('account_head_id_p'),
                      'govt_acct_head_no'=>$this->input->post('govt_acct_head_no'),
                      'tax_name'=>$this->input->post('tax_name'),
                      'form_id'=>$form_id,
                      // 'for_tds'=>$this->input->post('for_tds'),
                      // 'not_in_incl_price'=>$this->input->post('not_in_incl_price'),
                      // 'not_passed_on'=>$this->input->post('not_passed_on'),
                      // 'mrp_diff_av'=>$this->input->post('mrp_diff_av'),
                      // 'exp_flg'=>$this->input->post('exp_flg'),
                      'archive'=>'0'
                      );

            if(!empty($this->input->post('for_tds'))){
                $tax_master['for_tds']=$this->input->post('for_tds');
            }  
            if(!empty($this->input->post('not_in_incl_price'))){
                $tax_master['not_in_incl_price']=$this->input->post('not_in_incl_price');
            }
            if(!empty($this->input->post('not_passed_on'))){
                $tax_master['not_passed_on']=$this->input->post('not_passed_on');
            }
            if(!empty($this->input->post('mrp_diff_av'))){
                $tax_master['mrp_diff_av']=$this->input->post('mrp_diff_av');
            }
            if(!empty($this->input->post('exp_flg'))){
                $tax_master['exp_flg']=$this->input->post('exp_flg');
            }

            $result=$this->common_model->save('tax_master',$tax_master);
           

            $tax_master_lang=array( 'company_id'=>$this->session->userdata['logged_in']['company_id'],
                                    'language_id'=>1,
                                    'tax_code'=>$tax_code,
                                    'tax_pos_no'=>$tax_code,
                                    'lang_tax_code_desc'=>$this->input->post('lang_tax_code_desc')
                       
                                  );

            $result=$this->common_model->save('tax_master_lang',$tax_master_lang);

          $tax_hist_id=0;

          $result=$this->common_model->select_max_pkey_noncompany('tax_master_history','tax_hist_id'); 
          echo $this->db->last_query();
          
          foreach($result as $row){

              $tax_hist_id=$row->tax_hist_id;
          }

          $tax_hist_id=$tax_hist_id+1;

          $tax_master_history=array('tax_code'=>$tax_code,
                                    'tax_hist_id'=>$tax_hist_id,
                                    'old_rate'=>$tax_rate,
                                    'new_rate'=>$tax_rate,
                                    'date_created'=>$creation_date,
                                    'date_changed'=>$creation_date
                                  );

          $result=$this->common_model->save('tax_master_history',$tax_master_history);  
          
            if($result==1){

              $data['note']='Save Transaction Completed';

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='setup';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              
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

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view('Error/error-title',$data);

            $this->load->view('Home/footer');

          }

    }


    
  }




  function modify(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $data['tax_master']=$this->tax_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$this->uri->segment(3));

    $data['sales_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
    $data['purchase_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
    $data['tr6_account_heads_master']=$this->common_model->select_active_drop_down_noncompany('tr6_account_heads_master');
    $data['tax_group']=array('EXCISE','EXCISE_ECESS','EXCISE_HECESS','ST','ST_ECESS','ST_HECESS','CUSTOMS','CVD','CVD_ECESS','CVD_HECESS','CUSTOMS_ECESS','CUSTOMS_HECESS','ADDICVD','VAT','CST','TCS');

  
    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }



  public function update(){

    $this->form_validation->set_rules('creation_date','Creation Date' ,'trim|required|xss_clean');
    $this->form_validation->set_rules('tax_rate','Tax rate' ,'trim|required|decimal|xss_clean');
    $this->form_validation->set_rules('lang_tax_code_desc','Tax Code Description' ,'trim|required|xss_clean|strtoupper');
    $this->form_validation->set_rules('account_head_id','Sales Account Head' ,'trim|required|xss_clean');
    $this->form_validation->set_rules('account_head_id_p','Purchase Account Head' ,'trim|required|xss_clean');
    $this->form_validation->set_rules('govt_acct_head_no','Govt. Account Head' ,'trim|xss_clean|strtoupper');
    $this->form_validation->set_rules('tax_name','Tax Name' ,'trim|xss_clean|strtoupper');
    $this->form_validation->set_rules('form_id','Form No.' ,'trim|xss_clean|is_natural');
    $this->form_validation->set_rules('for_tds','TDS' ,'trim|xss_clean');
    $this->form_validation->set_rules('not_in_incl_price','Not In Inclusive' ,'trim|xss_clean');
    $this->form_validation->set_rules('not_passed_on','Not Passed On' ,'trim|xss_clean');
    $this->form_validation->set_rules('mrp_diff_av','MRP Applicable' ,'trim|xss_clean');
    $this->form_validation->set_rules('exp_flg','Expense' ,'trim|xss_clean');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['tax_master']=$this->tax_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$this->input->post('tax_code'));

      $data['sales_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
      $data['purchase_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
      $data['tr6_account_heads_master']=$this->common_model->select_active_drop_down_noncompany('tr6_account_heads_master');
      $data['tax_group']=array('EXCISE','EXCISE_ECESS','EXCISE_HECESS','ST','ST_ECESS','ST_HECESS','CUSTOMS','CVD','CVD_ECESS','CVD_HECESS','CUSTOMS_ECESS','CUSTOMS_HECESS','ADDICVD','VAT','CST','TCS');



      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $tax_code=$this->input->post('tax_code');

          $creation_date=$this->common_model->change_date_format($this->input->post('creation_date'),$this->session->userdata['logged_in']['company_id']);
          $tax_rate=$this->common_model->save_number($this->input->post('tax_rate'),$this->session->userdata['logged_in']['company_id']);
          $form_id=$this->common_model->save_number($this->input->post('form_id'),$this->session->userdata['logged_in']['company_id']);
           
          $tax_master=array( 
                      
                      'creation_date'=>$creation_date,
                      'tax_rate'=>$tax_rate,
                      'account_head_id'=>$this->input->post('account_head_id'),
                      'account_head_id_p'=>$this->input->post('account_head_id_p'),
                      'govt_acct_head_no'=>$this->input->post('govt_acct_head_no'),
                      'tax_name'=>$this->input->post('tax_name'),
                      'form_id'=>$form_id,
                                            
                      );

            if(!empty($this->input->post('for_tds'))){
                $tax_master['for_tds']=$this->input->post('for_tds');
            }  
            if(!empty($this->input->post('not_in_incl_price'))){
                $tax_master['not_in_incl_price']=$this->input->post('not_in_incl_price');
            }
            if(!empty($this->input->post('not_passed_on'))){
                $tax_master['not_passed_on']=$this->input->post('not_passed_on');
            }
            if(!empty($this->input->post('mrp_diff_av'))){
                $tax_master['mrp_diff_av']=$this->input->post('mrp_diff_av');
            }
            if(!empty($this->input->post('exp_flg'))){
                $tax_master['exp_flg']=$this->input->post('exp_flg');
            }

            $result=$this->common_model->update_one_active_record('tax_master',$tax_master,'tax_code',$this->input->post('tax_code'),$this->session->userdata['logged_in']['company_id']);
           

            $tax_master_lang=array( 
                                    'lang_tax_code_desc'=>$this->input->post('lang_tax_code_desc')
                       
                                  );


          $result=$this->common_model->update_one_active_record('tax_master_lang',$tax_master_lang,'tax_code',$this->input->post('tax_code'),$this->session->userdata['logged_in']['company_id']);

          $tax_master_history=array( 
                                    'new_rate'=>$tax_rate,
                                    'date_changed'=>date('Y-m-d')
                                  );
 
          $result=$this->tax_model->update_tax_history_table('tax_master_history',$tax_master_history,'tax_code',$this->input->post('tax_code'));
         // echo $this->db->last_query();

        
        if( $result==1){

            $data['note']='Update Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
            
            $data['tax_master']=$this->tax_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$this->input->post('tax_code'));

            $data['sales_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
            $data['purchase_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
           $data['tr6_account_heads_master']=$this->common_model->select_active_drop_down_noncompany('tr6_account_heads_master');
            $data['tax_group']=array('EXCISE','EXCISE_ECESS','EXCISE_HECESS','ST','ST_ECESS','ST_HECESS','CUSTOMS','CVD','CVD_ECESS','CVD_HECESS','CUSTOMS_ECESS','CUSTOMS_HECESS','ADDICVD','VAT','CST','TCS');

               
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
    $result=$this->common_model->update_one_active_record('tax_master',$data,'tax_code',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
        

    if($result){

      $data['note']="Archive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
      $data['tax_master']=$this->tax_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$this->input->post('tax_code'));

      $data['sales_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
      $data['purchase_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
      $data['tr6_account_heads_master']=$this->common_model->select_active_drop_down_noncompany('tr6_account_heads_master');
      $data['tax_group']=array('EXCISE','EXCISE_ECESS','EXCISE_HECESS','ST','ST_ECESS','ST_HECESS','CUSTOMS','CVD','CVD_ECESS','CVD_HECESS','CUSTOMS_ECESS','CUSTOMS_HECESS','ADDICVD','VAT','CST','TCS');




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

    $table='tax_master';

    include('pagination_archive.php');

    $data['tax_master']=$this->tax_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
    

    $data['page_name']='setup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);

    $this->load->view('Home/footer');


  }


  function dearchive(){

    $data=array('archive'=>'0');
    $result=$this->common_model->update_one_active_record('tax_master',$data,'tax_code',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
     
      $data['tax_master']=$this->tax_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'] ,'tax_code',$this->uri->segment(3));

      $data['sales_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
      $data['purchase_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
      $data['tr6_account_heads_master']=$this->common_model->select_active_drop_down_noncompany('tr6_account_heads_master');
      $data['tax_group']=array('EXCISE','EXCISE_ECESS','EXCISE_HECESS','ST','ST_ECESS','ST_HECESS','CUSTOMS','CVD','CVD_ECESS','CVD_HECESS','CUSTOMS_ECESS','CUSTOMS_HECESS','ADDICVD','VAT','CST','TCS');

 


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

    $data['sales_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
    $data['purchase_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
    $data['tr6_account_heads_master']=$this->common_model->select_active_drop_down_noncompany('tr6_account_heads_master');
    $data['tax_group']=array('EXCISE','EXCISE_ECESS','EXCISE_HECESS','ST','ST_ECESS','ST_HECESS','CUSTOMS','CVD','CVD_ECESS','CVD_HECESS','CUSTOMS_ECESS','CUSTOMS_HECESS','ADDICVD','VAT','CST','TCS');




    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

    $this->load->view('Home/footer');


  }


  public function search_result(){

       
    $this->form_validation->set_rules('creation_date','Creation Date' ,'trim|xss_clean');
    $this->form_validation->set_rules('tax_rate','Tax rate' ,'trim|decimal|xss_clean');
    $this->form_validation->set_rules('lang_tax_code_desc','Tax Code Description' ,'trim|xss_clean|strtoupper');
    $this->form_validation->set_rules('account_head_id','Sales Account Head' ,'trim|xss_clean');
    $this->form_validation->set_rules('account_head_id_p','Purchase Account Head' ,'trim|xss_clean');
    $this->form_validation->set_rules('govt_acct_head_no','Govt. Account Head' ,'trim|xss_clean|strtoupper');
    $this->form_validation->set_rules('tax_name','Tax Name' ,'trim|xss_clean|strtoupper');
    $this->form_validation->set_rules('form_id','Form No.' ,'trim|xss_clean|is_natural');
    $this->form_validation->set_rules('for_tds','TDS' ,'trim|xss_clean');
    $this->form_validation->set_rules('not_in_incl_price','Not In Inclusive' ,'trim|xss_clean');
    $this->form_validation->set_rules('not_passed_on','Not Passed On' ,'trim|xss_clean');
    $this->form_validation->set_rules('mrp_diff_av','MRP Applicable' ,'trim|xss_clean');
    $this->form_validation->set_rules('exp_flg','Expense' ,'trim|xss_clean');
    

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      
      $data['sales_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
      $data['purchase_account_head']=$this->tax_model->select_active_drop_down_account_head('account_head_lang',$this->session->userdata['logged_in']['company_id']);
      $data['tr6_account_heads_master']=$this->common_model->select_active_drop_down_noncompany('tr6_account_heads_master');
      $data['tax_group']=array('EXCISE','EXCISE_ECESS','EXCISE_HECESS','ST','ST_ECESS','ST_HECESS','CUSTOMS','CVD','CVD_ECESS','CVD_HECESS','CUSTOMS_ECESS','CUSTOMS_HECESS','ADDICVD','VAT','CST','TCS');



      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

      $this->load->view('Home/footer');

    }
    else{
          $tax_master=array();
          if(!empty($this->input->post('creation_date'))){
            $tax_master['tax_master.creation_date']=$this->common_model->change_date_format($this->input->post('creation_date'),$this->session->userdata['logged_in']['company_id']);
          }
          if(!empty($this->input->post('tax_rate')) && $this->input->post('tax_rate')!='0'){

            $tax_master['tax_master.tax_rate']=$this->common_model->save_number($this->input->post('tax_rate'),$this->session->userdata['logged_in']['company_id']);
          }
          if(!empty($this->input->post('lang_tax_code_desc'))){
            $tax_master['tax_master_lang.lang_tax_code_desc']=$this->input->post('lang_tax_code_desc');            
          }
          if(!empty($this->input->post('account_head_id'))){
            $tax_master['tax_master.account_head_id']=$this->input->post('account_head_id');            
          }
          if(!empty($this->input->post('account_head_id_p'))){
            $tax_master['tax_master.account_head_id_p']=$this->input->post('account_head_id_p');            
          }
          if(!empty($this->input->post('govt_acct_head_no'))){
            $tax_master['tax_master.govt_acct_head_no']=$this->input->post('govt_acct_head_no');            
          }
          if(!empty($this->input->post('tax_name'))){
            $tax_master['tax_master.tax_name']=$this->input->post('tax_name');            
          }
          if(!empty($this->input->post('form_id'))){
            $tax_master['tax_master.form_id']=$this->common_model->save_number($this->input->post('form_id'),$this->session->userdata['logged_in']['company_id']);
          }
          if(!empty($this->input->post('for_tds'))){
              $tax_master['tax_master.for_tds']=$this->input->post('for_tds');
          }  
          if(!empty($this->input->post('not_in_incl_price'))){
              $tax_master['tax_master.not_in_incl_price']=$this->input->post('not_in_incl_price');
          }
          if(!empty($this->input->post('not_passed_on'))){
              $tax_master['tax_master.not_passed_on']=$this->input->post('not_passed_on');
          }
          if(!empty($this->input->post('mrp_diff_av'))){
              $tax_master['tax_master.mrp_diff_av']=$this->input->post('mrp_diff_av');
          }
          if(!empty($this->input->post('exp_flg'))){
              $tax_master['tax_master.exp_flg']=$this->input->post('exp_flg');
          }

          $table='tax_master';
          
          $data['tax_master']=$this->tax_model->active_record_search('tax_master',$tax_master,$this->session->userdata['logged_in']['company_id']);
          //echo $this->db->last_query();

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
