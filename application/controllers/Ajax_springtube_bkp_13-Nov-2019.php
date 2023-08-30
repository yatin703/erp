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

  public function get_rm_for_issue(){
    $article_no=$this->input->post('article_no');     
    if($article_no!=''){
      $this->load->model('job_card_model');
      echo $this->job_card_model->get_available_qty($article_no);    
    }
            
  }

  public function jobcard_autocomplete(){
      $edit=$this->input->get('q'); 
      $this->load->model('job_card_model');
      $data['jobcard']=$this->job_card_model->jobcard_active_record_search('production_master',$edit,$this->session->userdata['logged_in']['company_id']);
      $this->load->view(ucwords($this->router->fetch_class()).'/jobcard-load-option',$data);
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


    // For Spring extrusion production entry
    public function jobcard_qty_to_reels(){

      //(Sleeve Length For Extrusion * Jobcard Qty/1000/Ups)/reel Length

     $reel_length=$this->config->item('springtube_reel_length');

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
                $data=array('sleeve_dia_id'=>$sleeve_dia_id,
                        'seam_type'=>$body_making_type
                        );

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

  // For Spring extrusion production entry
    public function jobcard_reels_to_qty(){

      //(NO Of reels * reel Length * 1000 / Sleeve Length For Extrusion) * Ups

      $reel_length=$this->config->item('springtube_reel_length');
      $reels_produced=$this->input->post('reels_produced');
      $expected_tubes=0;
      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $final_length_in_mm=0;
      $no_of_reels_planned=0;

      if($this->input->post('jobcard_no')!='' && $this->input->post('reels_produced')){

        $this->load->model('job_card_model');

        $data['production_master']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$this->input->post('jobcard_no'));
        //echo $this->db->last_query();

        foreach ($data['production_master'] as $production_master_row) {
            
            $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
            $order_no=$production_master_row->sales_ord_no;
            $article_no=$production_master_row->article_no;

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
                $data=array('sleeve_dia_id'=>$sleeve_dia_id,
                        'seam_type'=>$body_making_type);

                $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

                $reel_width=0;
                  
                foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
                  $ups=$spring_width_calculation_row->ups;
                  $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
                }

                $expected_tubes=($reels_produced*$reel_length*$ups*1000)/$sleeve_length_extrusion;
                //$final_length_in_mm=($sleeve_length_extrusion*$jobcard_qty/1000)/$ups;
                //$no_of_reels_planned=round(($final_length_in_mm/$reel_length),2);
                //$no_of_reels_planned= round($no_of_reels_planned,2);
                echo round($expected_tubes,0);

            }//SPEC result
      
    }else{
      echo '0';
    }  

  }  

}

?>