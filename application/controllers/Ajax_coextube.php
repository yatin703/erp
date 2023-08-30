<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajax_coextube extends CI_Controller {
	
	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('currency_model');
      $this->load->model('sub_group_model');
      $this->load->model('second_sub_group_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('sales_order_book_model');    
    }else{
      redirect('login','refresh');
    }
  }


  // Sales order Product list on SO autocomplte
  public function coex_so_no(){
      $edit=$this->input->get('q');   
      $data=array('order_no'=>$edit);
      $this->load->model('sales_order_book_model');
      $data['order_master']=$this->sales_order_book_model->select_spring_orders_for_autocomplete('order_master',$data,$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/so-no-load-option',$data);
  }



  public function article_no(){
      $edit=$this->input->get('q'); 
      $this->load->model('article_model');
      $data['article']=$this->article_model->finish_good_active_record_search('article',$edit,$this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()).'/article-load-option',$data);
  }

  public function jobcard_no(){
      $edit=$this->input->get('q'); 
      $this->load->model('job_card_model');
      $data['production_master']=$this->job_card_model->jobcard_active_record_search_coex('production_master',$edit,$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-extrusion-autocomplete',$data);
  }

  public function coextube_direct_ink_autocomplete(){

      $edit=$this->input->get('q');
      $arr=array('lang_article_description'=>$edit);       
      $this->load->model('coextube_ink_mixing_model');
      $data['coextube_ink_master']=$this->coextube_ink_mixing_model->active_record_search('article',$arr,$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/coextube-ink-load-option',$data);
  }

  public function coextube_ink_for_jobsetup_autocomplete(){

      $edit=$this->input->get('q');
      $data=array('pantone_code'=>$edit);       
      $this->load->model('coextube_ink_mixing_model');
      $data['coextube_ink_mixing_master']=$this->coextube_ink_mixing_model->active_record_search_for_jobsetup('coextube_ink_mixing_master',$data,$this->session->userdata['logged_in']['company_id']);
     // echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/pantone-code-load-option',$data);
    }


}