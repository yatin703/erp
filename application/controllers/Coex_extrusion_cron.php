
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion_cron extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('coex_extrusion_model');
    }
  }

  function index(){

    $this->db2 = $this->load->database('another_db2', TRUE); // Load TWERP http://192.168.0.9/ Database
    
    $this->load->model('coex_extrusion_model'); // Load coex_extrusion_model
    
    $exidrow=$this->coex_extrusion_model->get_extrusion_();  
    $lastexid=$exidrow['maxexid'];
    $newexid=$lastexid+1;
    
    $this->load->model('common_model'); // Load common_model
    
    $data['dbdata']=$this->common_model->select_db1_record();

/****************************** Global Variable Start ****************************/

    
    $count = 1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id1=0;
    $transform_flag='';
    $machine='';
    $shift='';
    $g='';
    $f='';
    $y='';


/**************************** Global Variable End ****************************/


/******************* shift_id='1' and machine_id='1' Start *******************/
   
    $i = 0;
    foreach($data['dbdata'] as $dbdata1){

      $a=$dbdata1->ce_id;
      $b=$dbdata1->extrusion_date;
      $machine=$dbdata1->machine_id;
      $shift=$dbdata1->shift_id;
      $e=$dbdata1->user_id;
      $f=$dbdata1->jobcard_no;
      $g=$dbdata1->order_no;
      $h=$dbdata1->article_no;
      $i=$dbdata1->diameter;
      $j=$dbdata1->length;
      $k=$dbdata1->layer_no;
      $l=$dbdata1->sleeve_weight_kg;
      $m=$dbdata1->rm_mixed_qty_kg;
      $n=$dbdata1->ok_qty_no;
      $o=$dbdata1->scrap_weight_kg;
      $p=$dbdata1->scrap_tube_no;
      $q=$dbdata1->cutting_speed_minutes;
      $r=$dbdata1->job_runtime_minutes;
      $s=$dbdata1->qc_date;
      $rp=$dbdata1->rejection_percentage;
      $operator=$dbdata1->operator;
      $transform_flag=$dbdata1->transform_flag;
      $bb = date("d-m-Y", strtotime($b));
      $extd1 = date("Y-m-d", strtotime($b));


        $query = $this->db->query("SELECT * FROM coex_extrusion where shift_id='1' and machine_id='1' and `extrusion_date`='$extd1'" );
        $query->num_rows();

        if($query->num_rows()>0){

            if($shift==1 and $machine==1){

                $sleeve_weight_kg=$sleeve_weight_kg+$l;
                $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
                $ok_qty_no=$ok_qty_no+$n;
                $scrap_weight_kg=$scrap_weight_kg+$o;
                $scrap_tube_no=$scrap_tube_no+$p;
                $expected_sleeve_prod=$n+$p;
                $sp_minutes = $n+$p/$q;
                $job_runtime_minutes=$job_runtime_minutes+$r;

                $this->db2 = $this->load->database('another_db2', TRUE);
             
                $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
                    foreach($jobcard_qty['jqty'] as $j){
                      $joq=$j->actual_qty_manufactured/100;
                    }

                $data2[] = array( 'ex_id'=>$newexid[$i],

                                        'psp_psm_no'=>$h[$i],
                                        'job_card_no'=>$f[$i],
                                        'so_no'=>$g[$i],
                                        'total_rm_kg'=>$m[$i],
                                        //'ttotal_rm_kg'=>$m,
                    
                                        'sleeve_weight_kg'=>$sleeve_weight_kg[$i],
                                        'sleeve_to_header'=>$n[$i],
                                        'sleeve_waste_kg'=>$o[$i],
                                        'sleeve_waste_no'=>$p[$i],
                                        'minutes'=>$r[$i],
                                    );
                $i++;
            }  
        }
        

    }
    print_r($data2);die();
    $data['db2data']=$this->common_model->save_db2('extrusion',$data2);

    $dates=$extd1;
    $data_update=array(
        'transform_flag'=> '1'
    );
              
    $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'shift_id','1', 'machine_id', '1', '000020');



    echo "completed !!";
       
}

}


