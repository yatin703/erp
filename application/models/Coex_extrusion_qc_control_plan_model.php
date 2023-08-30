<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion_qc_control_plan_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by('coex_extrusion_qc_control_plan.ceqcp_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by('coex_extrusion_qc_control_plan.ceqcp_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*, coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		//$this->db->join('springtube_extrusion_production_details',$table.'.details_id=springtube_extrusion_production_details.details_id');
		//$this->db->join('springtube_extrusion_production_master','springtube_extrusion_production_details.production_id=springtube_extrusion_production_master.production_id');
		//$this->db->join('springtube_process_master',$table.'.process_id=springtube_process_master.process_id');
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}
  
  public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		
		if(!empty($from) && !empty($to)){
			$this->db->where(''.$table.'.inspection_date >=', $from);
		$this->db->where(''.$table.'.inspection_date <=', $to);
		}
		foreach($data as $key => $value) {
			$this->db->where($key,$value);
		}
		$this->db->order_by('coex_extrusion_qc_control_plan.ceqcp_id desc');
		$query = $this->db->get();
		return $result=$query->result();
	}
	
	public function get_ajax_jobcard_no_id($job_card_id){
    if($job_card_id==''){ 
      header('Content-Type: application/json');
      echo json_encode(array('status' => 400, 'message' => 'Error! Order details not found, try later!')); 
    }
    else{
      $query = $this->db->query("SELECT pm.mp_pos_no as jobcard_no, pm.article_no as product_no, pm.sales_ord_no as sale_order, od.order_no as order_no, od.spec_id as spec_order, bm.bom_no as bom_id, od.spec_version_no, bm.bom_version_no, bm.sleeve_code as sleeve_code, ss.article_no, ss.spec_id, sdle.spec_id, ss.spec_version_no, sdle.spec_version_no,max(sdle.layer_no) as max_sleeve_layer_no,
		
		MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='LDPE'  THEN sdle.mat_info END)  AS 'LDPE_LAYER_1',
		MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_LAYER_1',
		MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='ADMER' THEN sdle.mat_info END) AS 'ADMER_LAYER_2',
		MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='EVOH'  THEN sdle.mat_info END)  AS 'EVOH_LAYER_3',
		MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='ADMER' THEN sdle.mat_info END) AS 'ADMER_LAYER_4',
		MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='LDPE'  THEN sdle.mat_info END)  AS 'LDPE_LAYER_5',
		MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_LAYER_5',
		
		MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_LAYER_1',
		MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_LAYER_2',
		MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_LAYER_3',
		MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_LAYER_4',
		MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_LAYER_5',

		 MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_MASTER_BATCH_1',
		MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_MASTER_BATCH_2',
		MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_MASTER_BATCH_3',
		MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_MASTER_BATCH_4',
		MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_MASTER_BATCH_5',

		MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_MAT_INFO_1',
		MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_MAT_INFO_2',
		MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_MAT_INFO_3',
		MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_MAT_INFO_4',
		MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_MAT_INFO_5'

		FROM production_master as pm 
		LEFT JOIN order_details as od ON pm.sales_ord_no = od.order_no 
		LEFT JOIN bill_of_material as bm ON od.spec_id = bm.bom_no AND od.spec_version_no= bm.bom_version_no 
		LEFT JOIN specification_sheet as ss ON bm.sleeve_code = ss.article_no 
		LEFT JOIN specification_sheet as sle ON bm.sleeve_code = sle.article_no
		LEFT JOIN specification_sheet_details as sdle ON sle.spec_id = sdle.spec_id AND sle.spec_version_no = sdle.spec_version_no
		WHERE pm.mp_pos_no = '$job_card_id'");
 
        if(!empty($query)){   
            $item=$query->row_array();   
            
            $sleeve_inner_per = '';
            $sleeve_outer_per = '';
            $sleeve_inner_layer = '';
            $sleeve_outer_layer = '';

            if($item['max_sleeve_layer_no'] == 1){
	            $sleeve_inner_layer=$this->common_model->get_article_name($item['SLEEVE_MASTER_BATCH_1'],$this->session->userdata['logged_in']['company_id']);
	            $sleeve_outer_layer='-';
	            $sleeve_inner_per=$item['SLEEVE_MAT_INFO_1'];
	          }elseif($item['max_sleeve_layer_no'] == 3){
	            $sleeve_inner_layer=$this->common_model->get_article_name($item['SLEEVE_MASTER_BATCH_1'],$this->session->userdata['logged_in']['company_id']);
	            $sleeve_outer_layer=$this->common_model->get_article_name($item['SLEEVE_MASTER_BATCH_3'],$this->session->userdata['logged_in']['company_id']);
	            $sleeve_inner_per=$item['SLEEVE_MAT_INFO_1'];
	            $sleeve_outer_per=$item['SLEEVE_MAT_INFO_3'];
	          }elseif($item['max_sleeve_layer_no'] == 5){
	            $sleeve_inner_layer=$this->common_model->get_article_name($item['SLEEVE_MASTER_BATCH_1'],$this->session->userdata['logged_in']['company_id']);
	            $sleeve_outer_layer=$this->common_model->get_article_name($item['SLEEVE_MASTER_BATCH_5'],$this->session->userdata['logged_in']['company_id']);
	            $sleeve_inner_per=$item['SLEEVE_MAT_INFO_1'];
	            $sleeve_outer_per=$item['SLEEVE_MAT_INFO_5'];
	          }

              $resultdata = array(  
                "mp_pos_no"              => $item['jobcard_no'],
                "article_no"             => $item['product_no'],
                "sales_ord_no"           => $item['sale_order'],
                "order_no"               => $item['order_no'],
                "spec_order"             => $item['spec_order'],				
                "bom_no"                 => $item['bom_id'],				
                "sleeve_code"            => $item['sleeve_code'],
                "LDPE_LLDPE_LAYER_1"     => ($item['LDPE_LAYER_1']<>'' ? $item['LDPE_LAYER_1']."%LDPE +" : '-').' '                       .($item['LLDPE_LAYER_1']<>'' ? $item['LLDPE_LAYER_1']."%LLDPE" : '-'),
                "ADMER_LAYER_2"          => ($item['ADMER_LAYER_2']<>'' ? $item['ADMER_LAYER_2']."% ADMER" : '-'),
                "EVOH_LAYER_3"           => ($item['EVOH_LAYER_3'] <>'' ? $item['EVOH_LAYER_3']."% EVOH" : '-'),
                "ADMER_LAYER_4"          => ($item['ADMER_LAYER_4'] <>'' ? $item['ADMER_LAYER_4']."% ADMER" : '-'),
                "LDPE_LLDPE_LAYER_5"     => ($item['LDPE_LAYER_5']<>'' ? $item['LDPE_LAYER_5']."%LDPE +" : '-').' '                       .($item['LLDPE_LAYER_5']<>'' ? $item['LLDPE_LAYER_5']."%LLDPE" : '-'),
                "GUAGE_LAYER_1"          => $item['GUAGE_LAYER_1'] != null ? $item['GUAGE_LAYER_1'] : '-',
                "GUAGE_LAYER_2"          => $item['GUAGE_LAYER_2'] != null ? $item['GUAGE_LAYER_2'] : '-',
                "GUAGE_LAYER_3"          => $item['GUAGE_LAYER_3'] != null ? $item['GUAGE_LAYER_3'] : '-',
                "GUAGE_LAYER_4"          => $item['GUAGE_LAYER_4'] != null ? $item['GUAGE_LAYER_4'] : '-',
                "GUAGE_LAYER_5"          => $item['GUAGE_LAYER_5'] != null ? $item['GUAGE_LAYER_5'] : '-',
                "master_batch_inner_layer"      => $sleeve_inner_per.'% '.$sleeve_inner_layer,
                "master_batch_outer_layer"      => $sleeve_outer_per.'% '.$sleeve_outer_layer,
              );
              header('Content-Type: application/json');
              echo json_encode(array('status' => 200,'message' => 'success','data' => $resultdata)); 
           }
	    else{
	      header('Content-Type: application/json');
	      echo json_encode(array('status' => 400, 'message' => 'Error! Vessal details not found, try later!')); 
	    }     
    }
}

}
?>