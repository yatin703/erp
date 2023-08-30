<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajax_springtube extends CI_Controller {
	
	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('currency_model');
      $this->load->model('sub_group_model');
      $this->load->model('second_sub_group_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('springtube_printing_production_model');
      

    }else{
      redirect('login','refresh');
    }
  }
	 
  public function spsm_spsp_no(){
      $edit=$this->input->post('order_no');   
      //$data=array('order_no'=>$edit);  
      $this->load->model('common_model');
      $data['order_details']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$edit);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/spsm-spsp-load-option',$data);
  }

  public function order_article_no(){
      $edit=$this->input->post('order_no');   
      //$data=array('order_no'=>$edit);  
      $this->load->model('common_model');
      $data['result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$edit);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/article-load-option-checkbox',$data);
    
  }
  public function invoice_article_no(){
      $edit=$this->input->post('invoice_no');   
      //$data=array('order_no'=>$edit);  
      $this->load->model('common_model');
      $data['result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$edit);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/article-load-option-checkbox',$data);
    
  }


  public function springtube_article_no(){
      $edit=$this->input->post('order_no');   
      //$data=array('order_no'=>$edit);  
      $this->load->model('common_model');
      $data['order_details']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$edit);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/springtube-article-load-option',$data);
  }


  //All SPSP SPSM for Spring Tube------------------
  public function article_no_springtube(){
      $edit=$this->input->get('q'); 
      $this->load->model('article_model');
      $data['article']=$this->article_model->finish_good_active_record_search_springtube('article',$edit,$this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()).'/article-load-option',$data);
  }

  //Artwork Version no for Spring Tube---------------------
  public function artwork_version_no_springtube(){ 
      if(!empty($this->input->post('article_no'))){
        $arr=explode('//',$this->input->post('article_no'));
        $this->load->model('artwork_springtube_model');
        $data['version']=$this->artwork_springtube_model->select_artwork_version_no('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$arr[1]);
        $this->db->last_query();
        $this->load->view(ucwords($this->router->fetch_class()).'/artwork-version-load-option',$data);
      }
      
  }

  // Sales order Product list on SO autocomplte
  public function spring_so_no(){

      $edit=$this->input->get('q');   
      $data=array('order_no'=>$edit);
      $this->load->model('sales_order_book_model');
      $data['order_master']=$this->sales_order_book_model->select_spring_orders_for_autocomplete('order_master',$data,$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/so-no-load-option',$data);
  }

  // Sales order Product list on SO autocomplte
  public function spring_open_so_no(){

      $edit=$this->input->get('q');   
      $data=array('order_no'=>$edit);
      $this->load->model('sales_order_book_model');
      $data['order_master']=$this->sales_order_book_model->select_open_orders_for_springtube('order_master',$data,$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/so-no-load-option',$data);
  }

  // Sales order Product list on SO autocomplte
  public function spring_so_no_for_production(){

      $edit=$this->input->get('q');   
      //$data=array('order_no'=>$edit,'order_closed<>'=>'1','trans_closed<>'=>'1',         'final_approval_flag'=>'1');
      $this->load->model('sales_order_book_model');
      $data['order_master']=$this->sales_order_book_model->spring_open_orders_for_extrusion('order_master',$edit,$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/so-no-load-option',$data);
  }

  // Extrusion Jobcards for spring
  public function spring_extrusion_jobcards(){

      $article_no=$this->input->post('article_no');   
      $data=array('article_no'=>$article_no,'jobcard_type'=>'1');
      $this->load->model('job_card_model');
      $data['production_master']=$this->job_card_model->active_record_search('production_master',$data,$from='',$to='',$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-extrusion-load-option',$data);
  }
  // Printing Jobcards for spring
  public function spring_printing_jobcards(){

      $article_no=$this->input->post('article_no');
      $order_no=$this->input->post('order_no');  
      $data=array('order_no'=>$order_no,'article_no'=>$article_no,'jobcard_type'=>'2');
      $this->load->model('job_card_model');
      $data['production_master']=$this->job_card_model->active_record_search('production_master',$data,$from='',$to='',$this->session->userdata['logged_in']['company_id']);
      echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-extrusion-load-option',$data);
  }    

  public function get_rm_for_issue(){
    $article_no=$this->input->post('article_no');     
    if($article_no!=''){
      $this->load->model('job_card_model');
      echo $this->job_card_model->get_available_qty($article_no);    
    }
            
  }
  // Spring Extrusion Jobcard autocomplete------
  public function jobcard_extrusion_autocomplete(){
      $edit=$this->input->get('q'); 
      $this->load->model('job_card_model');
      $data['production_master']=$this->job_card_model->jobcard_active_record_search_extrusion('production_master',$edit,$this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-extrusion-autocomplete',$data);
  }

  // Spring Extrusion Jobcard autocomplete------
  public function open_jobcard_extrusion_autocomplete(){
      $edit=$this->input->get('q'); 
      $this->load->model('job_card_model');
      $data['production_master']=$this->job_card_model->open_jobcard_active_record_search_extrusion('production_master',$edit,$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-extrusion-autocomplete',$data);
  }

  // Spring Printing Jobcard autocomplete------
  public function jobcard_printing_autocomplete(){
      $edit=$this->input->get('q'); 
      $this->load->model('job_card_model');
      $data['production_master']=$this->job_card_model->jobcard_active_record_search_printing('production_master',$edit,$this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-printing-autocomplete',$data);
  }

  // Spring Printing Jobcard autocomplete------
  public function jobcard_printing_production_done_autocomplete(){
      $edit=$this->input->get('q'); 
      $this->load->model('job_card_model');
      $data['production_master']=$this->job_card_model->jobcard_active_record_search_printing_for_production('production_master',$edit,$this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-printing-autocomplete',$data);
  }

  // Spring Printing Jobcard autocomplete------
  public function jobcard_printing_inspection_autocomplete(){
      $edit=$this->input->get('q'); 
      $this->load->model('job_card_model');
      $data['production_master']=$this->job_card_model->jobcard_active_record_search_printing_inspection('production_master',$edit,$this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-printing-autocomplete',$data);
  }

  // Spring Printing Jobcard autocomplete------
  public function jobcard_printing_inspection_production_autocomplete(){
      $edit=$this->input->get('q'); 
      $this->load->model('job_card_model');
      $data['production_master']=$this->job_card_model->jobcard_active_record_search_printing_inspection_for_production('production_master',$edit,$this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-printing-autocomplete',$data);
  }

  // Spring Extrusion Jobcard autocomplete------
  public function jobcard_bodymaking_autocomplete(){
      $edit=$this->input->get('q'); 
      $this->load->model('job_card_model');
      $data['production_master']=$this->job_card_model->jobcard_active_record_search_bodymaking('production_master',$edit,$this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-bodymaking-autocomplete',$data);
  }


  public function psm_psp_jobcards(){ 
      if(!empty($this->input->post('article_no'))){ 
        $article_no= $this->input->post('article_no'); 
        $arr=array('article_no'=>$article_no,
                    'sales_ord_no'=>$this->input->post('order_no'),
                    'archive'=>0);
        $data['production_master']=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$arr);
        $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-select-load-option',$data);

      }
      
  }

    
  public function artwork_springtube_autocomplete(){
    $edit=$this->input->get('q'); 
    $data=array('ad_id'=>$edit);  
    $this->load->model('common_model');
    $data['springtube_artwork_devel_master']=$this->common_model->active_record_search('springtube_artwork_devel_master',$data,$this->session->userdata['logged_in']['company_id']);
    $this->load->view(ucwords($this->router->fetch_class()).'/artwork-springtube-load-option',$data);
  }

    public function film_autocomplete(){
      $edit=$this->input->get('q'); 
      $this->load->model('article_model');
      $data['article']=$this->article_model->spring_film_active_record_search('article',$edit,$this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()).'/article-load-option',$data);
    }

    public function ink_lacquer_autocomplete(){

      $edit=$this->input->get('q');
      //$data=array('article_name_info.lang_article_description'=>$edit);       
      $this->load->model('article_model');
      $data['article']=$this->article_model->select_only_printing_ink_lacquer('article',$edit,$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/article-load-option',$data);
    }

    public function springtube_ink_autocomplete(){

      $edit=$this->input->get('q');
      $data=array('ink_desc'=>$edit);       
      $this->load->model('springtube_ink_master_model');
      $data['springtube_ink_master']=$this->springtube_ink_master_model->active_record_search('springtube_ink_master',$data,'','',$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/springtube-ink-load-option',$data);
    }

    public function springtube_ink_for_jobsetup_autocomplete(){

      $edit=$this->input->get('q');
      $data=array('ink_desc'=>$edit);       
      $this->load->model('springtube_ink_master_model');
      $data['springtube_ink_master']=$this->springtube_ink_master_model->active_record_search_for_jobsetup('springtube_ink_master',$data,'','',$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/springtube-ink-load-option',$data);
    }

    public function springtube_direct_ink_autocomplete(){

      $edit=$this->input->get('q');
      $data=array('ink_desc'=>$edit,'ink_composition'=>'1');       
      $this->load->model('springtube_ink_master_model');
      $data['springtube_ink_master']=$this->springtube_ink_master_model->active_record_search('springtube_ink_master',$data,'','',$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/springtube-ink-load-option',$data);
    }
    public function springtube_mixure_ink_autocomplete(){

      $edit=$this->input->get('q');
      $data=array('ink_desc'=>$edit,'ink_composition'=>'2');       
      $this->load->model('springtube_ink_master_model');
      $data['springtube_ink_master']=$this->springtube_ink_master_model->active_record_search('springtube_ink_master',$data,'','',$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/springtube-ink-load-option',$data);
    }

    public function springtube_mixure_ink_pending_autocomplete(){

      $edit=$this->input->get('q');
      $data=array('ink_desc'=>$edit,'ink_composition'=>'2','mixing_status'=>0);       
      $this->load->model('springtube_ink_master_model');
      $data['springtube_ink_master']=$this->springtube_ink_master_model->active_record_search('springtube_ink_master',$data,'','',$this->session->userdata['logged_in']['company_id']);
      //echo $this->db->last_query();
      $this->load->view(ucwords($this->router->fetch_class()).'/springtube-ink-load-option',$data);
    }


    // For Spring extrusion production entry
  public function jobcard_qty_to_reels(){

      //(Sleeve Length For Extrusion * Jobcard Qty/1000/Ups)/reel Length

     //$reel_length=$this->config->item('springtube_reel_length');

      $reel_length='';

      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $final_length_in_mm=0;
      $no_of_reels_planned=0;

      if($this->input->post('jobcard_no')!=''){

        $this->load->model('job_card_model');

        $data['production_master']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$this->input->post('jobcard_no'));
        //echo $this->db->last_query();

        foreach ($data['production_master'] as $production_master_row) {
            
            $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
            $order_no=$production_master_row->sales_ord_no;
            $article_no=$production_master_row->article_no;
            $reel_length=$production_master_row->reel_length;

        }

        $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
              foreach($order_details_result as $order_details_row){
                $total_order_quantity=$order_details_row->total_order_quantity;
                $ad_id=$order_details_row->ad_id;
                $version_no=$order_details_row->version_no;
                $bom_no=$order_details_row->spec_id;
                $bom_version_no=$order_details_row->spec_version_no;
              }
              //Artwork Deatils-------------------------
              $data=array('ad_id'=>$ad_id,
                    'version_no'=>$version_no
                      );
              $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

              foreach ($springtube_artwork_result as $springtube_artwork_row) {
                $body_making_type=$springtube_artwork_row->body_making_type;
              }

              // Bill of Maaterial---------------------
              $ups=0;
              $sleeve_mb_2='';
              $sleeve_mb_6='';
              $sleeve_diameter='';
              $sleeve_length='';
              $sleeve_length_extrusion='';
              $reel_width='';

              

              $film_spec_id='';
              $film_spec_version='';
                        
              $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

              $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

              foreach ($bill_of_material_result as $bill_of_material_row) {
                $bom_id=$bill_of_material_row->bom_id;
                $film_code=$bill_of_material_row->sleeve_code;
                    //$shoulder_code=$bill_of_material_row->shoulder_code;
                    //$cap_code=$bill_of_material_row->cap_code;
                    //$label_code=$bill_of_material_row->label_code;
                $print_type_bom=$bill_of_material_row->print_type;
                    //$specs_comment=strtoupper($bill_of_material_row->comment);
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
              if($specs_result){
                foreach($specs_result as $specs_row){
                  $sleeve_diameter=$specs_row->SLEEVE_DIA;
                  $sleeve_length=$specs_row->SLEEVE_LENGTH;
                  $sleeve_length_extrusion=$sleeve_length+2.5;
                  $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                  $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;       

                }
                $sleeve_dia_id='';

                $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
                //print_r($result_sleeve_diameter_master);
                foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
                  $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;

                
                }
                // $data=array('sleeve_dia_id'=>$sleeve_dia_id,
                //         'seam_type'=>$body_making_type
                //         );
                $data=array('sleeve_dia_id'=>$sleeve_dia_id);

                $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

                $reel_width=0;
                  
                foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
                  $ups=$spring_width_calculation_row->ups;
                  $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
                }

                $final_length_in_mm=($sleeve_length_extrusion*$jobcard_qty/1000)/$ups;
                $no_of_reels_planned=round(($final_length_in_mm/$reel_length),2);
                //$no_of_reels_planned= round($no_of_reels_planned,2);
               echo $jobcard_qty.'//'.$no_of_reels_planned;

            }//SPEC result
      
    }else{
      echo '0//0';
    }  

  }  

  // For Spring Jobcard Qty calculation by reels and reel length
    public function jobcard_reels_to_qty($no_of_reels_planned=0,$reel_length=0){
      
      //(NO Of reels * reel Length * 1000 / Sleeve Length For Extrusion) * Ups

      //$reel_length=$this->config->item('springtube_reel_length');
      $reel_length=0;
      $expected_tubes=0;
      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $final_length_in_mm=0;
      

      if($this->input->post('order_no')!='' && $this->input->post('article_no')){

        $order_no=$this->input->post('order_no');
        $article_no=$this->input->post('article_no');
        $no_of_reels_planned=$this->input->post('no_of_reels');
        $reel_length=$this->input->post('reel_length');

        $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
              foreach($order_details_result as $order_details_row){
                $total_order_quantity=$order_details_row->total_order_quantity;
                $ad_id=$order_details_row->ad_id;
                $version_no=$order_details_row->version_no;
                $bom_no=$order_details_row->spec_id;
                $bom_version_no=$order_details_row->spec_version_no;
              }
              //Artwork Deatils-------------------------
              $data=array('ad_id'=>$ad_id,
                    'version_no'=>$version_no
                      );
              $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

              foreach ($springtube_artwork_result as $springtube_artwork_row) {
                $body_making_type=$springtube_artwork_row->body_making_type;
              }

              // Bill of Maaterial---------------------
              $ups=0;
              $sleeve_mb_2='';
              $sleeve_mb_6='';
              $sleeve_diameter='';
              $sleeve_length='';
              $sleeve_length_extrusion='';
              $reel_width='';              

              $film_spec_id='';
              $film_spec_version='';
                        
              $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

              $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

              foreach ($bill_of_material_result as $bill_of_material_row) {
                $bom_id=$bill_of_material_row->bom_id;
                $film_code=$bill_of_material_row->sleeve_code;
                    //$shoulder_code=$bill_of_material_row->shoulder_code;
                    //$cap_code=$bill_of_material_row->cap_code;
                    //$label_code=$bill_of_material_row->label_code;
                $print_type_bom=$bill_of_material_row->print_type;
                    //$specs_comment=strtoupper($bill_of_material_row->comment);
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
              if($specs_result){
                foreach($specs_result as $specs_row){
                  $sleeve_diameter=$specs_row->SLEEVE_DIA;
                  $sleeve_length=$specs_row->SLEEVE_LENGTH;
                  $sleeve_length_extrusion=$sleeve_length+2.5;
                  $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                  $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;       

                }
                $sleeve_dia_id='';
                $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
                //print_r($result_sleeve_diameter_master);
                foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
                  $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
               
                }
                // $data=array('sleeve_dia_id'=>$sleeve_dia_id,
                //         'seam_type'=>$body_making_type);

                $data=array('sleeve_dia_id'=>$sleeve_dia_id);

                $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

                $reel_width=0;
                  
                foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
                  $ups=$spring_width_calculation_row->ups;
                  $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
                }

                $expected_tubes=($no_of_reels_planned*$reel_length*$ups*1000)/$sleeve_length_extrusion;
                //$final_length_in_mm=($sleeve_length_extrusion*$jobcard_qty/1000)/$ups;
                //$no_of_reels_planned=round(($final_length_in_mm/$reel_length),2);
                //$no_of_reels_planned= round($no_of_reels_planned,2);
                echo round($expected_tubes,0);

            }//SPEC result
      
    }else{
      echo '0';
    }  

  } 

  // New function wrote to find qty through Sales order no and article --------------------------------------
  public function jobcard_meters_to_qty_by_so(){ 

      //(NO Of reels * reel Length * 1000 / Sleeve Length For Extrusion) * Ups

      //$reel_length=$this->config->item('springtube_reel_length');
      //$reel_length=0;
      $expected_tubes=0;
      $jobcard_qty=0;
      //$order_no='';
      //$article_no='';
      $final_length_in_mm=0;
      $body_making_type='';
      
        $order_no=$this->input->post('order_no');
        $article_no=$this->input->post('article_no');
        $total_meters=$this->input->post('total_meters');

      if($order_no!='' && $article_no!='' && $total_meters!=''){
        

        $customer='';
        //$order_no='';
        //$article_no='';
        $bom_no='';
        $bom_version_no='';
        $film_code='';
        $ad_id='';
        $version_no='';
        

        // $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
    
        // foreach($production_master_result as $row) {
        //   $order_no=$row->sales_ord_no;
        //   $article_no=$row->article_no;
        // }

        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
          foreach($order_master_result as $order_master_row){
            $customer=$order_master_row->customer_no;                      
        }


        $data_order_details=array(
        'order_no'=>$order_no,
        'article_no'=>$article_no
        );

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
        foreach($order_details_result as $order_details_row){
          $bom_no=$order_details_row->spec_id;
          $bom_version_no=$order_details_row->spec_version_no;
          $ad_id=$order_details_row->ad_id;
          $version_no=$order_details_row->version_no;
        }

        $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

        $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

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
        
        if($specs_result){                      

          foreach($specs_result as $specs_row){
              $sleeve_diameter=$specs_row->SLEEVE_DIA;
              $sleeve_length=$specs_row->SLEEVE_LENGTH;
              $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
              $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6; 
              $micron_1=$specs_row->FILM_GUAGE_1;
              $micron_2=$specs_row->FILM_GUAGE_2; 
              $micron_3=$specs_row->FILM_GUAGE_3; 
              $micron_4=$specs_row->FILM_GUAGE_4; 
              $micron_5=$specs_row->FILM_GUAGE_5;       
              $micron_6=$specs_row->FILM_GUAGE_6; 
              $micron_7=$specs_row->FILM_GUAGE_7; 

          }

          $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

        }

        //Artwork Deatils-------------------------
        $data=array('ad_id'=>$ad_id,
              'version_no'=>$version_no
                );
        $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

        foreach ($springtube_artwork_result as $springtube_artwork_row) {
          $body_making_type=$springtube_artwork_row->body_making_type;
        }

        
        $sleeve_dia_id='';
        $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
        //print_r($result_sleeve_diameter_master);
        foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
          $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
       
        }
        // $data=array('sleeve_dia_id'=>$sleeve_dia_id,
        //                 'seam_type'=>$body_making_type);
        $data=array('sleeve_dia_id'=>$sleeve_dia_id);

        $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

        $reel_width=0;
        $ups=0;
        $sleeve_length_extrusion=$sleeve_length+2.5;
                  
        foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
          $ups=$spring_width_calculation_row->ups;
          $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
        }

        $expected_tubes=($total_meters*$ups*1000)/$sleeve_length_extrusion;
                //$final_length_in_mm=($sleeve_length_extrusion*$jobcard_qty/1000)/$ups;
                //$no_of_reels_planned=round(($final_length_in_mm/$reel_length),2);
                //$no_of_reels_planned= round($no_of_reels_planned,2);
        echo round($expected_tubes,0);

     
      
    }else{

      echo '0';
    }  

  }



  // New function wrote to find qty through Sales order no and article --------------------------------------
   public function jobcard_qty_to_meters_by_so(){ 

      //(NO Of reels * reel Length * 1000 / Sleeve Length For Extrusion) * Ups

      //$reel_length=$this->config->item('springtube_reel_length');
      //$reel_length=0;
      $expected_meters=0;
      $jobcard_qty=0;
      //$order_no='';
      //$article_no='';
      $final_length_in_mm=0;
      $body_making_type='';
      
        $order_no=$this->input->post('order_no');
        $article_no=$this->input->post('article_no');
        $jobcard_qty=$this->input->post('release_qty');

      if($order_no!='' && $article_no!='' && $jobcard_qty!=0){
        

        $customer='';
        //$order_no='';
        //$article_no='';
        $bom_no='';
        $bom_version_no='';
        $film_code='';
        $ad_id='';
        $version_no='';
        

        // $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
    
        // foreach($production_master_result as $row) {
        //   $order_no=$row->sales_ord_no;
        //   $article_no=$row->article_no;
        // }

        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
          foreach($order_master_result as $order_master_row){
            $customer=$order_master_row->customer_no;                      
        }


        $data_order_details=array(
        'order_no'=>$order_no,
        'article_no'=>$article_no
        );

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
        foreach($order_details_result as $order_details_row){
          $bom_no=$order_details_row->spec_id;
          $bom_version_no=$order_details_row->spec_version_no;
          $ad_id=$order_details_row->ad_id;
          $version_no=$order_details_row->version_no;
        }

        $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

        $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

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
        
        if($specs_result){                      

          foreach($specs_result as $specs_row){
              $sleeve_diameter=$specs_row->SLEEVE_DIA;
              $sleeve_length=$specs_row->SLEEVE_LENGTH;
              $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
              $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6; 
              $micron_1=$specs_row->FILM_GUAGE_1;
              $micron_2=$specs_row->FILM_GUAGE_2; 
              $micron_3=$specs_row->FILM_GUAGE_3; 
              $micron_4=$specs_row->FILM_GUAGE_4; 
              $micron_5=$specs_row->FILM_GUAGE_5;       
              $micron_6=$specs_row->FILM_GUAGE_6; 
              $micron_7=$specs_row->FILM_GUAGE_7; 

          }

          $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

        }

        //Artwork Deatils-------------------------
        $data=array('ad_id'=>$ad_id,
              'version_no'=>$version_no
                );
        $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

        foreach ($springtube_artwork_result as $springtube_artwork_row) {
          $body_making_type=$springtube_artwork_row->body_making_type;
        }

        
        $sleeve_dia_id='';
        $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
        //print_r($result_sleeve_diameter_master);
        foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
          $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
       
        }
        // $data=array('sleeve_dia_id'=>$sleeve_dia_id,
        //                 'seam_type'=>$body_making_type);
        $data=array('sleeve_dia_id'=>$sleeve_dia_id);

        $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

        $reel_width=0;
        $ups=0;
        $sleeve_length_extrusion=$sleeve_length+2.5;
                  
        foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
          $ups=$spring_width_calculation_row->ups;
          $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
        }

        //$expected_tubes=($total_meters*$ups*1000)/$sleeve_length_extrusion;
        $expected_meters=round(($jobcard_qty*$sleeve_length_extrusion)/($ups*1000));
                //$final_length_in_mm=($sleeve_length_extrusion*$jobcard_qty/1000)/$ups;
                //$no_of_reels_planned=round(($final_length_in_mm/$reel_length),2);
                //$no_of_reels_planned= round($no_of_reels_planned,2);
        echo round($expected_meters,0);

     
      
    }else{

      echo '0';
    }  

  }




  public function get_order_details_for_printing(){


    $jobcard_no=$this->input->post('jobcard_no');

    
    if($jobcard_no!=''){

       

      $this->load->model('job_card_model');

      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $ad_id='';
      $version_no='';
      $dia='';
      $length='';
      $print_type='';
      $laminate_color='';
      $total_order_quantity='';

      $printed_counter=0;
      $pending_counter=0;

      $data['production_master']=$this->job_card_model->select_one_active_jobcard_for_printing('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
        //echo $this->db->last_query();
      if($data['production_master']){

        foreach ($data['production_master'] as $production_master_row) {
          
          $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
          $order_no=$production_master_row->sales_ord_no;
          $article_no=$production_master_row->article_no;

        }

        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
        foreach($order_master_result as $order_master_row){
          $customer=$order_master_row->customer_no;                      
        }

        $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
        foreach($order_details_result as $order_details_row){
          $total_order_quantity=$order_details_row->total_order_quantity;
          $ad_id=$order_details_row->ad_id;
          $version_no=$order_details_row->version_no;
          $bom_no=$order_details_row->spec_id;
          $bom_version_no=$order_details_row->spec_version_no;
        }
        //Artwork Deatils-------------------------
        $data=array('ad_id'=>$ad_id,
            'version_no'=>$version_no
              );
        $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

        foreach ($springtube_artwork_result as $springtube_artwork_row) {
          $body_making_type=$springtube_artwork_row->body_making_type;
          $print_type=$springtube_artwork_row->print_type;
          $dia=$springtube_artwork_row->sleeve_dia;
          $length=$springtube_artwork_row->sleeve_length;
          $laminate_color=$springtube_artwork_row->laminate_color;
        }

        $sleeve_dia_id='';
        $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$dia);
        //print_r($result_sleeve_diameter_master);
        foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
          $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
       
        }
        // $data=array('sleeve_dia_id'=>$sleeve_dia_id,
        //                 'seam_type'=>$body_making_type);
        $data=array('sleeve_dia_id'=>$sleeve_dia_id);

        $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

        
        $ups=0;   
        foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
          $ups=$spring_width_calculation_row->ups;
          
        }

        $search_data=array('jobcard_no'=>$jobcard_no);
        $counter_result=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$search_data);
        foreach ($counter_result as $counter_row) {
          $printed_counter=$counter_row->total_counter;
        }

        echo $pending_counter=round($jobcard_qty/$ups)-$printed_counter;




        
                        
        echo'<table class="record_table_design_without_fixed" id="tbl_order_details">
              <tr>
              <th>Customer</th>
                <th>Order No.</th>
                <th>Article No.</th>
                <th>Article Name</th>
                <th>Dia</th>
                <th>Length</th>
                <th>Print Type</th>
                <th>Substrate</th> 
                <th>Artwork</th>
                <th>Order Qty</th>
                <th>Jobcard Qty</th>
                <th>Jobcard Counter</th>
                <th>Pending Counter</th>
                <th>Printed Counter</th>
                <th>Printed Qty</th>
                         
                
              </tr>  
              <tr>
                <td>'.$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id']).'</td>
                <td>'.$order_no.'</td>
                <td>'.$article_no.'</td>
                <td>'.$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']).'</td>
                <td>'.$dia.'</td>
                <td>'.$length.' + 2.5 = '.($length+2.5).' MM</td>
                <td>'.$print_type.'</td>
                <td>'.$laminate_color.'</td>
                <td><a href="'.base_url('index.php/Artwork_springtube/view/'.$ad_id.'/'.$version_no).'" target="_blank">'.$ad_id.'_R'.$version_no.'</a></td>
                <td>'.$this->common_model->read_number($total_order_quantity,$this->session->userdata['logged_in']['company_id']).'</td>
                <td>'.$jobcard_qty.'</td>
                <td>'.round($jobcard_qty/$ups).'</td>
                <td><div id="pending_counter" style="color:blue;"><b>'.$pending_counter.'</b></div</td>
                <td><div id="printed_counter" style="color:blue;"><b>'.$printed_counter.'</b></div</td>
                <td><div id="printed_qty" style="color:blue;"><b>'.round($printed_counter*$ups).'</b></div</td>
                
              </tr>
            </table';


      }else{
        echo'';
      }

    }

  } 

  public function get_printing_quantity(){  


    $jobcard_qty=0;
    $printing_qty=0;
    $total_counter=0;

    $jobcard_no=$this->input->post('jobcard_no');    
    if($jobcard_no!=''){
      $this->load->model('job_card_model');
      $data['production_master']=$this->job_card_model->select_one_active_jobcard_for_printing_inspection('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
        //echo $this->db->last_query();
      if($data['production_master']){

        // foreach ($data['production_master'] as $production_master_row) {
          
        //   $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
        //   $order_no=$production_master_row->sales_ord_no;
        //   $article_no=$production_master_row->article_no;

        // }

        $data_total_counter=array(                  
            'jobcard_no'=>$this->input->post('jobcard_no')                        
        );

        $result_total_counter=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$data_total_counter);
        foreach ($result_total_counter as  $total_counter_row) {
          $total_counter=$total_counter_row->total_counter;
          $printing_qty=round($total_counter*2);
        }


      }

    } 

    echo $printing_qty;

  }

  public function get_orders_for_wip_release(){

    $order_no=$this->input->post('order_no');
    if($order_no!=''){
      
      $data= array('ref_order_no'=>$order_no, 'archive'=>'0','final_approval_flag'=>'1');
      $data['order_master']=$this->common_model->select_active_records_where('order_master',$this->session->userdata['logged_in']['company_id'],$data);     
     if($data['order_master']==FALSE){
        echo'<option value="'.$order_no.'">'.$order_no.'</option>';
     }else{
      $this->load->view(ucwords($this->router->fetch_class()).'/release-order-from-wip-load-option',$data);
     }
      
      
    }else{

      echo'';
    }
    
  }

  public function get_order_details_for_extrusion_wip_issue(){
    
                
    $order_no=$this->input->post('order_no');
    $article_no=$this->input->post('article_no');

    if($order_no!='' && $article_no!=''){    

      $release_to_order_qty='';
      $release_to_ad_id='';
      $release_to_version_no='';
      $release_to_bom_no='';
      $release_to_bom_version_no='';
      $release_to_bom_id='';
      $release_to_film_code='';
      $sleeve_mb_2='';
      $sleeve_mb_6='';
      $micron_1=0;
      $micron_2=0; 
      $micron_3=0; 
      $micron_4=0; 
      $micron_5=0;       
      $micron_6=0; 
      $micron_7=0;

      $order_flag='';
      $dispatch_tolerance='';
      $dispatch_tolerance_1='';
      $adr_company_id='';

      $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);

      foreach ($order_master_result as $order_master_row){

        $order_flag=$order_master_row->order_flag;
        $adr_company_id=$order_master_row->customer_no;

        $address_master_result=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$adr_company_id);

        foreach ($address_master_result as $address_master_row) {
          $dispatch_tolerance=$address_master_row->dispatch_tolerance;
          $dispatch_tolerance_1=$address_master_row->dispatch_tolerance;
        }
      }




      $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

      $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
      foreach($order_details_result as $order_details_row){
        $release_to_order_qty=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
        $release_to_ad_id=$order_details_row->ad_id;
        $release_to_version_no=$order_details_row->version_no;
        $release_to_bom_no=$order_details_row->spec_id;
        $release_to_bom_version_no=$order_details_row->spec_version_no;
      }

      // BOM Details---------
      $data=array('bom_no'=>$release_to_bom_no,'bom_version_no'=>$release_to_bom_version_no);

      $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

      foreach ($bill_of_material_result as $bill_of_material_row) {
        $release_to_bom_id=$bill_of_material_row->bom_id;
        $release_to_film_code=$bill_of_material_row->sleeve_code;
         
      }

      //SLEEVE---------------------------------

      $film_spec_id='';
      $film_spec_version='';

      $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$release_to_film_code);

      foreach($film_code_result as $film_code_row){                   
        $film_spec_id=$film_code_row->spec_id;
        $film_spec_version=$film_code_row->spec_version_no;
      }

      $specs['spec_id']=$film_spec_id;
      $specs['spec_version_no']=$film_spec_version;

      $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
      
      if($specs_result){
        $total_microns=0;
        foreach($specs_result as $specs_row){
            $sleeve_diameter=$specs_row->SLEEVE_DIA;
            $sleeve_length=$specs_row->SLEEVE_LENGTH;
            $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
            $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;
            $micron_1=$specs_row->FILM_GUAGE_1;
            $micron_2=$specs_row->FILM_GUAGE_2; 
            $micron_3=$specs_row->FILM_GUAGE_3; 
            $micron_4=$specs_row->FILM_GUAGE_4; 
            $micron_5=$specs_row->FILM_GUAGE_5;       
            $micron_6=$specs_row->FILM_GUAGE_6; 
            $micron_7=$specs_row->FILM_GUAGE_7; 


        } 
        $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

      }

      $data_search=array('sales_ord_no'=>$order_no,
                  'article_no'=>$article_no,
                  'archive'=>'0',
                  'jobcard_type'=>'2');


      $actual_qty_manufactured=0;

      $production_master_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data_search);
      foreach ($production_master_result as $production_master_row) {
          $actual_qty_manufactured+=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
      }


      $springtube_jobcard_perc_master_result=$this->common_model->select_one_active_record('springtube_jobcard_perc_master',$this->session->userdata['logged_in']['company_id'],'jobcard_type','2');

      $job_card_perc=0;
      foreach ($springtube_jobcard_perc_master_result as $key => $perc_row) {
        $job_card_perc=$perc_row->perc;
      }

      $calc_jobcard_qty=0;

      $calc_jobcard_qty= $release_to_order_qty+($release_to_order_qty*$job_card_perc)/100-$actual_qty_manufactured;


      echo'<tr id="tr_2">
            <td class="label">Order Qty :</td>
            <td><input type="text"  name="release_to_order_qty" id="release_to_order_qty" value="'.$release_to_order_qty.'" readonly>
            </td>
          </tr>
          <tr id="tr_3">
            <td class="label">Spec No :</td>
            <td><input type="text" name="release_to_bom" value="'.($release_to_bom_no!='' ? $release_to_bom_no."_R".$release_to_bom_version_no : '').'" readonly>
                <input type="hidden" name="release_to_spec_id" value="'.$release_to_bom_no.'">
                  <input type="hidden" name="release_to_spec_version_no" value="'.$release_to_bom_version_no.'">
                &nbsp; <a href="'.base_url('/index.php/bill_of_material/view/'.$release_to_bom_id).'" target="_blank">'.($release_to_bom_no!='' ? $release_to_bom_no."_R".$release_to_bom_version_no : '').'</a>
            </td>
          </tr>
          <tr id="tr_4">
            <td class="label">Sleeve Dia :</td>
            <td><input type="text"  name="sleeve_diameter" id="sleeve_diameter" value="'.$sleeve_diameter.'" readonly>
              &nbsp; Length : <input type="text"  name="sleeve_length" id="sleeve_length" value="'.$sleeve_length.' MM" size="10" readonly>
            </td>
          </tr>
          <tr id="tr_5">
            <td class="label">Total Microns :</td>
            <td><input type="text"  name="total_microns" id="total_microns" value="'.$total_microns.'" readonly>
            </td>
          </tr>
          <tr id="tr_6">
            <td class="label">Second Layer MB:</td>
            <td><input type="text" name="sleeve_mb_2" id="sleeve_mb_2" value="'.$this->common_model->get_article_name($sleeve_mb_2,$this->session->userdata['logged_in']['company_id']).'" readonly>
              
            </td>
          </tr>
          <tr id="tr_7">
            <td class="label">Sixth Layer MB:</td>
            <td><input type="text" name="sleeve_mb_6" id="sleeve_mb_6" value="'.$this->common_model->get_article_name($sleeve_mb_6,$this->session->userdata['logged_in']['company_id']).'" readonly>
              
            </td>
          </tr>
          <tr id="tr_8">
            <td class="label">Artwork No * :</td>
            <td><input type="text" name="release_to_artwork" value="'.($release_to_ad_id!='' ? $release_to_ad_id."_R".$release_to_version_no : '').'" readonly>
                  <input type="hidden" name="release_to_ad_id" value="'.$release_to_ad_id.'">
                  <input type="hidden" name="release_to_version_no" value="'.$release_to_version_no.'">
                  &nbsp;<a href="'.base_url('/index.php/artwork_springtube/view/'.$release_to_ad_id.'/'.$release_to_version_no).'" target="_blank">'.($release_to_ad_id!='' ? $release_to_ad_id."_R".$release_to_version_no : '').'</a>
                </td>
          </tr>
          <tr id="tr_9">
            <td class="label">Customer Tolernace :</td>
            <td><input type="text"  name="customer_tolerance" id="customer_tolerance" value="'.set_value('customer_tolerance',$dispatch_tolerance).'" readonly/>
            </td>
          </tr>
          <tr id="tr_10">
            <td class="label">Printing Rejection % :</td>
            <td><input type="text"  name="printing_rejection" id="printing_rejection" value="'.set_value('printing_rejection','25').'" />
            </td>
          </tr>
          <tr id="tr_11">
            <td class="label">Bodymaking Rejection % :</td>
            <td><input type="text"  name="bodymaking_rejection" id="bodymaking_rejection" value="'.set_value('bodymaking_rejection','25').'" />
            </td>
          </tr>

          
          <tr id="tr_12">
            <td class="label">Expected Qty :</td>
            <td><input type="text"  name="expected_qty" id="expected_qty" value="'.set_value('expected_qty',$calc_jobcard_qty).'"/>
            </td>
          </tr>

          <tr id="tr_13">
            <td class="label">Printing Inhouse/Outsource :</td>
            <td><input type="number" min="0" max="1" id="outsource" name="outsource"  value="'.set_value('outsource','0').'"/>&nbsp;<br/><i> 0 = Inhouse printing</i>
            <br/><i> 1 = Outsource printing</i>
            </td>
          </tr>
          <tr id="tr_13">
            <td class="label">New Name for Film :</td>
            <td><input type="text" name="film_new_name" id="film_new_name"  value="'.set_value('film_new_name').'" disabled=true/></td>
          </tr>
          <script>
              $(document).ready(function(){

                var release_to_order_no = $("#release_to_order_no_1").val();      
                var release_article_no=$("#release_article_no").val();

                 $("#outsource").bind("keyup",function(){

                    if($("#outsource").val()==1){
                      alert("You are sending this film for outside printing then please enter the name of film");
                      $("#film_new_name").removeAttr("disabled");
                    }
                    if($("#outsource").val()==0){

                      $("#film_new_name").attr("disabled", "disabled");
                    }

                  }); 
                
                $("#expected_qty").bind("keyup",function(){
                  

                  var ul="'.base_url().'/index.php/ajax_springtube/jobcard_qty_to_meters_by_so";
                                    

                  $.ajax({
                    type: "POST",
                    url:ul,
                    data:{
                      order_no : release_to_order_no, 
                      article_no : release_article_no,
                      release_qty : $("#expected_qty").val()
                    },
                    cache: false, 
                    success: function(html){
                      //alert(html);                        
                      if(html!=""){             
                        $("#release_meters").val(html);
                      }             
                    } 
                  });
                  
                });         

            });
          </script>';


    }else{

      echo'';
    }    

  }

  public function get_order_details_for_printing_jobsetup(){


    $jobcard_no=$this->input->post('jobcard_no');

    
    if($jobcard_no!=''){
      //echo 'in';

      $this->load->model('job_card_model');

      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $ad_id='';
      $version_no='';
      $dia='';
      $length='';
      $print_type='';
      $laminate_color='';
      $total_order_quantity='';

      $printed_counter=0;
      $pending_counter=0;

      $data['production_master']=$this->job_card_model->select_one_active_jobcard_for_printing_inspection('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
        $this->db->last_query();
      if($data['production_master']){

        $printing_done=0;

        foreach ($data['production_master'] as $production_master_row) {
          
          $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
          $order_no=$production_master_row->sales_ord_no;
          $article_no=$production_master_row->article_no;
          $printing_done=$production_master_row->printing_done;

        }

        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
        foreach($order_master_result as $order_master_row){
          $customer=$order_master_row->customer_no;                      
        }

        $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
        foreach($order_details_result as $order_details_row){
          $total_order_quantity=$order_details_row->total_order_quantity;
          $ad_id=$order_details_row->ad_id;
          $version_no=$order_details_row->version_no;
          $bom_no=$order_details_row->spec_id;
          $bom_version_no=$order_details_row->spec_version_no;
        }
        //Artwork Deatils-------------------------
        $data=array('ad_id'=>$ad_id,
            'version_no'=>$version_no
              );
        $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

        foreach ($springtube_artwork_result as $springtube_artwork_row) {
          $body_making_type=$springtube_artwork_row->body_making_type;
          $print_type=$springtube_artwork_row->print_type;
          $dia=$springtube_artwork_row->sleeve_dia;
          $length=$springtube_artwork_row->sleeve_length;
          $laminate_color=$springtube_artwork_row->laminate_color;
        }

        

        $search_data=array('jobcard_no'=>$jobcard_no);
        $counter_result=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$search_data);
        foreach ($counter_result as $counter_row) {
          $printed_counter=$counter_row->total_counter;
        }

        $pending_counter=round($jobcard_qty/2)-$printed_counter;


        $sleeve_dia_id='';
        $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$dia);
        //print_r($result_sleeve_diameter_master);
        foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
          $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
       
        }

        $data=array('sleeve_dia_id'=>$sleeve_dia_id);

        $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

        $reel_width=0;
        $ups=0;
        //$sleeve_length_extrusion=$sleeve_length+2.5;
                  
        foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
          $ups=$spring_width_calculation_row->ups;
          $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
        }

                        
        echo'<table class="record_table_design_without_fixed" id="tbl_order_details">
              <tr>
              <th>Customer</th>
                <th>Order No.</th>
                <th>Article No.</th>
                <th>Article Name</th>
                <th>Dia</th>
                <th>Length</th>
                <th>Print Type</th>
                <th>Substrate</th> 
                <th>Artwork</th>
                <th>Order Qty</th>
                <th>Jobcard Qty</th>
                <th>Jobcard Counter</th>
                <th>Pending Counter</th>
                <th>Printed Counter</th>
                <th>Printed Qty</th>
                <th>Printing Done</th>
                         
                
              </tr>  
              <tr>
                <td>'.$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id']).'</td>
                <td>'.$order_no.'</td>
                <td>'.$article_no.'</td>
                <td>'.$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']).'</td>
                <td>'.$dia.'</td>
                <td>'.$length.' + 2.5 = '.($length+2.5).' MM</td>
                <td>'.$print_type.'</td>
                <td>'.$laminate_color.'</td>
                <td><a href="'.base_url('index.php/Artwork_springtube/view/'.$ad_id.'/'.$version_no).'" target="_blank">'.$ad_id.'_R'.$version_no.'</a></td>
                <td>'.$this->common_model->read_number($total_order_quantity,$this->session->userdata['logged_in']['company_id']).'</td>
                <td>'.$jobcard_qty.'</td>
                <td>'.round($jobcard_qty/2).'</td>
                <td><div id="pending_counter" style="color:blue;"><b>'.$pending_counter.'</b></div</td>
                <td><div id="printed_counter" style="color:blue;"><b>'.$printed_counter.'</b></div</td>
                <td><div id="printed_qty" style="color:blue;"><b>'.round($printed_counter*$ups).'</b></div</td>
                <td>'.($printing_done==1?'YES':'NO').'</td>
                
              </tr>
            </table';


      }

    }else{
        echo'';
    }

  }

  public function get_foils_for_printing_jobsetup(){

    $jobcard_no=$this->input->post('jobcard_no');
    $jobcard_qty=0;
    $total_meters=0;
    $order_no='';
    $article_no='';
    $ad_id='';
    $version_no='';

    $cold_foil_1='';
    $cold_foil_1_width=0;
    $cold_foil_1_area=0;
    $cold_foil_2='';
    $cold_foil_2_width=0;
    $cold_foil_2_area=0;
    
    if($jobcard_no!=''){
      //echo 'in';

      $this->load->model('job_card_model');     

      $data['production_master']=$this->job_card_model->select_one_active_jobcard_for_printing_inspection('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
        //echo $this->db->last_query();
      if($data['production_master']){

        $printing_done=0;

        foreach ($data['production_master'] as $production_master_row) {
          
          $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
          $order_no=$production_master_row->sales_ord_no;
          $article_no=$production_master_row->article_no;
          $printing_done=$production_master_row->printing_done;
          $total_meters=$production_master_row->total_meters;

        }

        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
        foreach($order_master_result as $order_master_row){
          $customer=$order_master_row->customer_no;                      
        }

        $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
        foreach($order_details_result as $order_details_row){
          $total_order_quantity=$order_details_row->total_order_quantity;
          $ad_id=$order_details_row->ad_id;
          $version_no=$order_details_row->version_no;
          $bom_no=$order_details_row->spec_id;
          $bom_version_no=$order_details_row->spec_version_no;
        }
        //Artwork Deatils-------------------------

        if($ad_id!=''){

          $data=array('ad_id'=>$ad_id,
            'version_no'=>$version_no
              );
          $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);


          //echo $this->db->last_query();

          foreach ($springtube_artwork_result as $springtube_artwork_row) {
            $body_making_type=$springtube_artwork_row->body_making_type;
            $print_type=$springtube_artwork_row->print_type;
            $dia=$springtube_artwork_row->sleeve_dia;
            $length=$springtube_artwork_row->sleeve_length;
            $laminate_color=$springtube_artwork_row->laminate_color;
            $cold_foil_1=$springtube_artwork_row->cold_foil_1;
            $cold_foil_1_width=$springtube_artwork_row->cold_foil_1_width;
            $cold_foil_2=$springtube_artwork_row->cold_foil_2;
            $cold_foil_2_width=$springtube_artwork_row->cold_foil_2_width;
          }

          if(!empty($cold_foil_1)){

            $cold_foil_1_area=round(($cold_foil_1_width/1000)*$total_meters,2);
          }
          if(!empty($cold_foil_2)){

            $cold_foil_2_area=round(($cold_foil_2_width/1000)*$total_meters,2);
          }


          $data=array(
            'total_meters'=>$total_meters,
            'cold_foil_1'=>($cold_foil_1!=''?$this->common_model->get_article_name($cold_foil_1,$this->session->userdata['logged_in']['company_id']).'//'.$cold_foil_1:''),
            'cold_foil_1_width'=>$cold_foil_1_width,
            'cold_foil_1_area'=>$cold_foil_1_area,
            'cold_foil_2'=>($cold_foil_2!=''?$this->common_model->get_article_name($cold_foil_2,$this->session->userdata['logged_in']['company_id']).'//'.$cold_foil_2:''),
            'cold_foil_2_width'=>$cold_foil_2_width,
            'cold_foil_2_area'=>$cold_foil_2_area
          );


        }   


      }

      echo json_encode($data);

    }else{
        $data=array(
        'total_meters'=>$total_meters,
        'cold_foil_1'=>$cold_foil_1,
        'cold_foil_1_width'=>$cold_foil_1_width,
        'cold_foil_1_area'=>$cold_foil_1_area,
        'cold_foil_2'=>$cold_foil_2,
        'cold_foil_2_width'=>$cold_foil_2_width,
        'cold_foil_2_area'=>$cold_foil_2_area
        );

        echo json_encode($data);
    }

  }

  // public function get_order_details_for_extrusion(){
    
                
  //   $jobcard_no=$this->input->post('jobcard_no');
    

  //   if($jobcard_no!=''){    

  //     $order_qty='';
  //     $ad_id='';
  //     $version_no='';
  //     $cbom_no='';
  //     $cbom_version_no='';
  //     $cbom_id='';
  //     $cfilm_code='';
  //     $sleeve_mb_2='';
  //     $sleeve_mb_6='';
  //     $micron_1=0;
  //     $micron_2=0; 
  //     $micron_3=0; 
  //     $micron_4=0; 
  //     $micron_5=0;       
  //     $micron_6=0; 
  //     $micron_7=0;

  //     $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

  //     $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
  //     foreach($order_details_result as $order_details_row){
  //       $order_qty=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
  //       $ad_id=$order_details_row->ad_id;
  //       $version_no=$order_details_row->version_no;
  //       $bom_no=$order_details_row->spec_id;
  //       $bom_version_no=$order_details_row->spec_version_no;
  //     }

  //     // BOM Details---------
  //     $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

  //     $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

  //     foreach ($bill_of_material_result as $bill_of_material_row) {
  //       $bom_id=$bill_of_material_row->bom_id;
  //       $film_code=$bill_of_material_row->sleeve_code;
         
  //     }

  //     //SLEEVE---------------------------------

  //     $film_spec_id='';
  //     $film_spec_version='';

  //     $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$release_to_film_code);

  //     foreach($film_code_result as $film_code_row){                   
  //       $film_spec_id=$film_code_row->spec_id;
  //       $film_spec_version=$film_code_row->spec_version_no;
  //     }

  //     $specs['spec_id']=$film_spec_id;
  //     $specs['spec_version_no']=$film_spec_version;

  //     $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
      
  //     if($specs_result){
  //       $total_microns=0;
  //       foreach($specs_result as $specs_row){
  //           $sleeve_diameter=$specs_row->SLEEVE_DIA;
  //           $sleeve_length=$specs_row->SLEEVE_LENGTH;
  //           $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
  //           $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;
  //           $micron_1=$specs_row->FILM_GUAGE_1;
  //           $micron_2=$specs_row->FILM_GUAGE_2; 
  //           $micron_3=$specs_row->FILM_GUAGE_3; 
  //           $micron_4=$specs_row->FILM_GUAGE_4; 
  //           $micron_5=$specs_row->FILM_GUAGE_5;       
  //           $micron_6=$specs_row->FILM_GUAGE_6; 
  //           $micron_7=$specs_row->FILM_GUAGE_7; 


  //       } 
  //       $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

  //     }
 
  //   }else{

  //     echo'';
  //   }    

  // }

  public function get_bodymaking_jobcard_details_autocomplete(){

    $jobcard_no=$this->input->post('jobcard_no');

    
    if($jobcard_no!=''){
      //echo 'in';

      $this->load->model('job_card_model');
      $customer='';
      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $ad_id='';
      $version_no='';
      $dia='';
      $length='';
      $print_type='';
      $laminate_color='';
      $total_order_quantity='';

      $printed_counter=0;
      $pending_counter=0;

      $data['production_master']=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
        //echo $this->db->last_query();
      if($data['production_master']){

        $printing_done=0;
        $inspectioin_done=0;

        foreach ($data['production_master'] as $production_master_row) {
          
          $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
          $order_no=$production_master_row->sales_ord_no;
          $article_no=$production_master_row->article_no;
          $printing_done=$production_master_row->printing_done;
          $inspectioin_done=$production_master_row->printing_done;

        }

        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
        foreach($order_master_result as $order_master_row){
          $customer=$order_master_row->customer_no;                      
        }

        $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
        foreach($order_details_result as $order_details_row){
          $total_order_quantity=$order_details_row->total_order_quantity;
          $ad_id=$order_details_row->ad_id;
          $version_no=$order_details_row->version_no;
          $bom_no=$order_details_row->spec_id;
          $bom_version_no=$order_details_row->spec_version_no;
        }

        $data=array('jobcard_no'=>$jobcard_no,'archive'=>0);

        $this->load->model('springtube_bodymaking_production_model');

        $total_sleeve_produced=0;
        $sleeve_with_cap=0;

        $springtube_bodymaking_production_details_result=$this->springtube_bodymaking_production_model->active_details_records('springtube_bodymaking_production_details',$data);

        foreach ($springtube_bodymaking_production_details_result as $springtube_bodymaking_production_details_row){

          $sleeve_with_cap+=$springtube_bodymaking_production_details_row->sleeve_with_cap;
          $total_sleeve_produced=$springtube_bodymaking_production_details_row->total_sleeve_produced;
        }


        echo'<table>
                <tr>
                    <th>Customer</th>
                    <th>Order No.</th>
                    <th>Article No.</th>
                    <th>Order Qty</th>
                    <th>Jobcard Qty</th>
                    <th>Total Sleeves Produced</th>
                    <th>Total Sleeves with Cap</th>
                </tr>
                <tr style="text-align:center;">               
                  <td>'.$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id']).'</td>
                  <td>'.$order_no.'</td>
                  <td>'.$article_no.'</td>
                  <td>'.$this->common_model->read_number($total_order_quantity,$this->session->userdata['logged_in']['company_id']).'</td>
                  <td>'.$jobcard_qty.'</td>
                  <td>'.$total_sleeve_produced.'</td>
                  <td>'.$sleeve_with_cap.'</td>
                </tr> 
              </table>';

      }
    }
    
  } 

    public function get_extrusion_jobcard_details_autocomplete(){

    $jobcard_no=$this->input->post('jobcard_no');

    
    if($jobcard_no!=''){
      //echo 'in';

      $this->load->model('job_card_model');
      $customer='';
      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $ad_id='';
      $version_no='';
      $dia='';
      $length='';
      $print_type='';
      $laminate_color='';
      $total_order_quantity='';

      $no_of_reels=0;
      $reel_length=0;
      $total_meters=0;


      $data['production_master']=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
        //echo $this->db->last_query();
      if($data['production_master']){

        
        foreach ($data['production_master'] as $production_master_row) {
          
          $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
          $order_no=$production_master_row->sales_ord_no;
          $article_no=$production_master_row->article_no;
          $no_of_reels=$production_master_row->no_of_reels;
          $reel_length=$production_master_row->reel_length;
          $total_meters=$production_master_row->total_meters;

        }

        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
        foreach($order_master_result as $order_master_row){
          $customer=$order_master_row->customer_no;                      
        }

        $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
        foreach($order_details_result as $order_details_row){
          $total_order_quantity=$order_details_row->total_order_quantity;
          $ad_id=$order_details_row->ad_id;
          $version_no=$order_details_row->version_no;
          $bom_no=$order_details_row->spec_id;
          $bom_version_no=$order_details_row->spec_version_no;
        }

        $data=array('jobcard_no'=>$jobcard_no,'archive'=>0);

        $this->load->model('springtube_extrusion_production_model');

        $total_meters_produced=0;

        $springtube_extrusion_production_details_result=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$data);

        foreach ($springtube_extrusion_production_details_result as $springtube_extrusion_production_details_row){

          $total_meters_produced+=$springtube_extrusion_production_details_row->total_meters_produced;
          
        }


        echo'<table>
              <tr>
                  <th>Customer</th>
                  <th>Order No.</th>
                  <th>Article No.</th>
                  <th>Order Qty</th>
                  <th>Jobcard Qty</th>
                  <th>Plan Meters</th>
                  <th>Total Meters Produced</th>
                  
              </tr>
              <tr style="text-align:center;">               
                <td>'.$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id']).'</td>
                <td>'.$order_no.'</td>
                <td>'.$article_no.'</td>
                <td>'.$this->common_model->read_number($total_order_quantity,$this->session->userdata['logged_in']['company_id']).'</td>
                <td>'.$jobcard_qty.'</td>
                <td>('.$reel_length.' X '.$no_of_reels.' = '.$total_meters.')</td>
                <td>'.$total_meters_produced.'</td>
              </tr> 
            </table>';
      }
    }
    
  } 

  public function get_order_details_for_extrusion_control_plan(){
    
                
    $jobcard_no=$this->input->post('jobcard_no');    

    if($jobcard_no!=''){    
      $order_no='';
      $article_no='';
      $order_qty='';
      $ad_id='';
      $version_no='';
      $bom_no='';
      $bom_version_no='';
      $bom_id='';
      $film_code='';
      $sleeve_mb_2='';
      $sleeve_mb_6='';
      $micron_1=0;
      $micron_2=0; 
      $micron_3=0; 
      $micron_4=0; 
      $micron_5=0;       
      $micron_6=0; 
      $micron_7=0;

      $data['production_master']=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
        //echo $this->db->last_query();
             
        foreach ($data['production_master'] as $production_master_row) {
          
          $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
          $order_no=$production_master_row->sales_ord_no;
          $article_no=$production_master_row->article_no;
          // $no_of_reels=$production_master_row->no_of_reels;
          $reel_length=$production_master_row->reel_length;
          // $total_meters=$production_master_row->total_meters;

        }

      $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

      $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
      foreach($order_details_result as $order_details_row){
        $order_qty=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
        $ad_id=$order_details_row->ad_id;
        $version_no=$order_details_row->version_no;
        $bom_no=$order_details_row->spec_id;
        $bom_version_no=$order_details_row->spec_version_no;
      }

      // BOM Details---------
      $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

      $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

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
      
      if($specs_result){
        $total_microns=0;
        foreach($specs_result as $specs_row){
            $sleeve_diameter=$specs_row->SLEEVE_DIA;
            $sleeve_length=$specs_row->SLEEVE_LENGTH;
            $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
            $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;
            $micron_1=$specs_row->FILM_GUAGE_1;
            $micron_2=$specs_row->FILM_GUAGE_2; 
            $micron_3=$specs_row->FILM_GUAGE_3; 
            $micron_4=$specs_row->FILM_GUAGE_4; 
            $micron_5=$specs_row->FILM_GUAGE_5;       
            $micron_6=$specs_row->FILM_GUAGE_6; 
            $micron_7=$specs_row->FILM_GUAGE_7; 


        } 
        $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

      }
      $data=array('order_no'=>$order_no,'article_no'=>$article_no,'micron_1'=>$micron_1,'micron_2'=>$micron_2,'micron_3'=>$micron_3,'micron_4'=>$micron_4,'micron_5'=>$micron_5,'micron_6'=>$micron_6,'micron_7'=>$micron_7,'total_microns'=>$total_microns,'reel_length'=>$reel_length,'bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);
      
      echo json_encode($data);
 
    }else{

      echo '';
    }    

  }
  function spring_bodymaking_wip(){

    //$order_no=$this->input->post('order_no');
    //$article_no=$this->input->post('article_no');
    $order_no='';
    $article_no='';
    $jobcard_no=$this->input->post('jobcard_no');
    $total_bm_wip_qty=0;
    
    //if(!empty($order_no) && !empty($article_no)){

    if(!empty($jobcard_no)){

      //-------------------Jobcard details
      $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);
    
      foreach($production_master_result as $production_master_row) {
        $order_no=$production_master_row->sales_ord_no;
        $article_no=$production_master_row->article_no;
        
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
      
         $sleeve_diameter='';                          
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

      $data_search=array('jobcard_no'=>$jobcard_no,'archive'=>0,'status'=>0);

      $result_springtube_bodymaking_wip_master=$this->common_model->select_active_records_where('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search);
      //echo $this->db->last_query();
      foreach ($result_springtube_bodymaking_wip_master as $key => $springtube_bodymaking_wip_master_row) {
        $total_bm_wip_qty+=$springtube_bodymaking_wip_master_row->bm_wip_qty;

        $data_update=array('consume_flag'=>1);   
        $result=$this->common_model->update_one_active_record('springtube_bodymaking_wip_master',$data_update,'bm_wip_id',$springtube_bodymaking_wip_master_row->bm_wip_id,$this->session->userdata['logged_in']['company_id']);
      }


    }

    $sleeve_dia_id='';
    $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
    //print_r($result_sleeve_diameter_master);
    foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
      $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
   
    }

    $no_of_tubes_per_box=0;
    $boxes=0;

    $packing_box_master_result=$this->common_model->select_one_active_record_noncompany('packing_box_master','sleeve_id',$sleeve_dia_id);

    foreach ($packing_box_master_result as $key => $packing_box_master_row) {
      
      $no_of_tubes_per_box=$this->common_model->read_number($packing_box_master_row->no_of_tubes_per_box,$this->session->userdata['logged_in']['company_id']);

    }

    $boxes=($no_of_tubes_per_box!=0?ceil($total_bm_wip_qty/$no_of_tubes_per_box):0);
    
    $array=array('order_no'=>$order_no,'article_no'=>$article_no,'total_bm_wip_qty'=>$total_bm_wip_qty,'boxes'=>$boxes);

      echo json_encode($array);
    
    

  }

  function spring_aql_input_boxes(){

    $order_no='';
    $article_no='';
    $jobcard_no=$this->input->post('jobcard_no');
    $qty=$this->input->post('qty');
    //echo $jobcard_no;
    //echo $qty;

    if(!empty($jobcard_no) && !empty($qty) ){

      //-------------------Jobcard details
      $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);
    
      foreach($production_master_result as $production_master_row) {
        $order_no=$production_master_row->sales_ord_no;
        $article_no=$production_master_row->article_no;
        
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
      
        $sleeve_diameter='';                          
        foreach($specs_result as $specs_row){
            $sleeve_diameter=$specs_row->SLEEVE_DIA;
            // $sleeve_length=$specs_row->SLEEVE_LENGTH;
            // $micron_1=$specs_row->FILM_GUAGE_1;
            // $micron_2=$specs_row->FILM_GUAGE_2;
            // $film_mb_2=$specs_row->FILM_MASTER_BATCH_2;
            // $micron_3=$specs_row->FILM_GUAGE_3;
            // $micron_4=$specs_row->FILM_GUAGE_4;
            // $micron_5=$specs_row->FILM_GUAGE_5;
            // $micron_6=$specs_row->FILM_GUAGE_6;
            // $film_mb_6=$specs_row->FILM_MASTER_BATCH_6;
            // $micron_7=$specs_row->FILM_GUAGE_7;
             
        }

      $sleeve_dia_id='';
      $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
      //print_r($result_sleeve_diameter_master);
      foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
        $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
     
      }

      $no_of_tubes_per_box=0;
      $boxes=0;

      $packing_box_master_result=$this->common_model->select_one_active_record_noncompany('packing_box_master','sleeve_id',$sleeve_dia_id);

      foreach ($packing_box_master_result as $key => $packing_box_master_row) {
        
        $no_of_tubes_per_box=$this->common_model->read_number($packing_box_master_row->no_of_tubes_per_box,$this->session->userdata['logged_in']['company_id']);

      }

      $boxes=($no_of_tubes_per_box!=0?ceil($qty/$no_of_tubes_per_box):0);     
      $array=array('boxes'=>$boxes,'no_of_tubes_per_box'=>$no_of_tubes_per_box);
      echo json_encode($array);     

    }
    else{
      $array=array('boxes'=>0);
      echo json_encode($array);
    }       
    

  }

  // function spring_aql_boxes_to_qty(){

  //   $order_no='';
  //   $article_no='';
  //   $jobcard_no=$this->input->post('jobcard_no');
  //   $boxes=$this->input->post('boxes');
  //   //echo $jobcard_no;
  //   //echo $qty;

  //   if(!empty($jobcard_no) && !empty($boxes) ){

  //     //-------------------Jobcard details
  //     $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);
    
  //     foreach($production_master_result as $production_master_row) {
  //       $order_no=$production_master_row->sales_ord_no;
  //       $article_no=$production_master_row->article_no;
        
  //     }                

  //     $data_order_details=array(
  //       'order_no'=>$order_no,
  //       'article_no'=>$article_no
  //     );

  //     $bom_no='';
  //     $bom_version_no='';

  //     $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
  //       foreach($order_details_result as $order_details_row){
  //         $bom_no=$order_details_row->spec_id;
  //         $bom_version_no=$order_details_row->spec_version_no;
  //       }

  //     $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

  //     $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

  //     $bom_id='';
  //     $film_code='';

  //     foreach ($bill_of_material_result as $bill_of_material_row) {
  //       $bom_id=$bill_of_material_row->bom_id;
  //       $film_code=$bill_of_material_row->sleeve_code;
         
  //     } 
  //     //SLEEVE---------------------------------

  //       $film_spec_id='';
  //       $film_spec_version='';

  //       $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

  //       foreach($film_code_result as $film_code_row){                   
  //         $film_spec_id=$film_code_row->spec_id;
  //         $film_spec_version=$film_code_row->spec_version_no;
  //       }

  //       $specs['spec_id']=$film_spec_id;
  //       $specs['spec_version_no']=$film_spec_version;

  //       $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
      
  //       $total_microns=0;
      
  //       $sleeve_diameter='';                          
  //       foreach($specs_result as $specs_row){
  //           $sleeve_diameter=$specs_row->SLEEVE_DIA;
  //           // $sleeve_length=$specs_row->SLEEVE_LENGTH;
  //           // $micron_1=$specs_row->FILM_GUAGE_1;
  //           // $micron_2=$specs_row->FILM_GUAGE_2;
  //           // $film_mb_2=$specs_row->FILM_MASTER_BATCH_2;
  //           // $micron_3=$specs_row->FILM_GUAGE_3;
  //           // $micron_4=$specs_row->FILM_GUAGE_4;
  //           // $micron_5=$specs_row->FILM_GUAGE_5;
  //           // $micron_6=$specs_row->FILM_GUAGE_6;
  //           // $film_mb_6=$specs_row->FILM_MASTER_BATCH_6;
  //           // $micron_7=$specs_row->FILM_GUAGE_7;
             
  //       }

  //     $sleeve_dia_id='';
  //     $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
  //     //print_r($result_sleeve_diameter_master);
  //     foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
  //       $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
     
  //     }

  //     $no_of_tubes_per_box=0;
  //     $total_tubes=0;

  //     $packing_box_master_result=$this->common_model->select_one_active_record_noncompany('packing_box_master','sleeve_id',$sleeve_dia_id);

  //     foreach ($packing_box_master_result as $key => $packing_box_master_row) {
        
  //       $no_of_tubes_per_box=$this->common_model->read_number($packing_box_master_row->no_of_tubes_per_box,$this->session->userdata['logged_in']['company_id']);

  //     }

  //     $total_tubes=($no_of_tubes_per_box!=0?$no_of_tubes_per_box*$boxes:0);     
  //     $array=array('total_tubes'=>$total_tubes);
  //     echo json_encode($array);     

  //   }
  //   else{
  //     $array=array('total_tubes'=>0);
  //     echo json_encode($array);
  //   }       
    

  // }




}
