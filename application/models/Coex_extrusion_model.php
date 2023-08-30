<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion_model extends CI_Model {
   
    public function count_pending(){
        $resultdata     = array();
        $query_pending    = $this->db->query("SELECT ce_id FROM coex_extrusion 
        WHERE qc_flag='0'");
        return $query_pending->num_rows();
    }

    public function count_hold(){
        $resultdata     = array();
        $query_hold    = $this->db->query("SELECT qc_id FROM coex_extrusion_qc 
        WHERE hold_by_qc!='0' and flag!='1'");
        return $query_hold->num_rows();
    }

    public function count_realesed(){
        $resultdata     = array();
        $query_realesed    = $this->db->query("SELECT qc_id FROM coex_extrusion_qc 
        WHERE flag='1' and release_qty!='0'");
        return $query_realesed->num_rows();
    }

    public function count_hold_scrap(){
        $resultdata     = array();
        $query_qc_scrap    = $this->db->query("SELECT ce_scrap_id FROM coex_extrusion_scrap WHERE scrap_by_qc!='0'");
        return $query_qc_scrap->num_rows();
    }

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by('coex_extrusion.ce_id desc');
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

	public function select_machine_start($table,$company,$data,$group_by,$order_by,$limit,$start){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }

	    if(!empty($group_by)){
				$this->db->group_by($group_by);
			
	    }

	    if(!empty($order_by)){
				$this->db->order_by('CAST('.$table.'.'.$order_by.' as unsigned)','desc');
			
	    }	    
	    $this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
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


	public function select_runtime_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,coex_machine_start_stop_reasons.coex_machine_start_stop_reasons');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('coex_machine_start_stop_reasons',$table.'.cemssr_id=coex_machine_start_stop_reasons.cemssr_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('coex_machine_master.process_id','1');
		$this->db->order_by($table.'.cmr_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_downtime_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,coex_machine_start_stop_reasons.coex_machine_start_stop_reasons');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('coex_machine_start_stop_reasons',$table.'.cemssr_id=coex_machine_start_stop_reasons.cemssr_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('coex_machine_master.process_id','1');
		$this->db->order_by($table.'.cmd_id desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		if(!empty($data)){
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		}
		$this->db->where(''.$table.'.extrusion_date >=', $from);
		$this->db->where(''.$table.'.extrusion_date <=', $to);
		//$this->db->order_by('address_details.timestamp','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}
  
  public function active_record_search_($table,$company,$data,$from,$to){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('extrusion_date>=',$from);
			$this->db->where('extrusion_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function machine_vice_record_search($table,$from,$to,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where(''.$table.'.extrusion_date >=', $from);
		$this->db->where(''.$table.'.extrusion_date <=', $to);
		//$this->db->order_by('address_details.timestamp','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


	 public function check_jobcard_no_duplication($action = "", $field = "", $jobcard_no = "") {
      $duplicate_jobcard_no_check = $this->db->get_where('coex_extrusion_wip', array(
          $field => $jobcard_no
      ));
      
      if ($action == 'on_create') {
          if ($duplicate_jobcard_no_check->num_rows() > 0) {
              return false;
          } else {
              return true;
          }
      }
  }

public function select_active_records_wip($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.cewip_id','desc');
		$this->db->where($table.'.ok_by_qc<>','0');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}



public function select_active_records_wip_($limit,$start,$table,$company){
		$this->db->select($table.'.*, coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->join('coex_extrusion_qc',$table.'.cewip_id=coex_extrusion_qc.qc_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.ok_by_qc<>','0');
		$this->db->where($table.'.status<>','1');
		//$this->db->where('coex_extrusion_qc'.'.flag=','0');
		$this->db->order_by($table.'.cewip_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

public function select_active_records_wip_released($limit,$start,$table,$company){
		$this->db->select($table.'.*, coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->join('coex_extrusion_qc',$table.'.cewip_id=coex_extrusion_qc.qc_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.release_qty<>','0');
		$this->db->where($table.'.status','1');
		//$this->db->where('coex_extrusion_qc'.'.flag=','0');
		$this->db->order_by($table.'.cewip_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

public function select_active_records_wip_group_by($a,$b){
		$query = $this->db->query("SELECT cew.cewip_id,cew.extrusion_date,cew.diameter,cew.length,cew.layer_no,cew.sleeve_weight_gm,cew.article_no,cew.order_no,cew.jobcard_no,sum(cew.ok_by_qc) as total_qty, cew.cost,cew.next_process_print,cew.jobcard_issue,cew.created_date,cew.issue_created_date,ceq.hold_by_qc,cmm.machine_name,ssm.shift_name,ss.dyn_qty_present 
			FROM coex_extrusion_wip as cew
	    LEFT JOIN coex_machine_master as cmm ON cew.machine_id = cmm.machine_id    
	    LEFT JOIN springtube_shift_master as ssm ON cew.shift_id = ssm.shift_id    
	    LEFT JOIN coex_extrusion_qc as ceq ON cew.jobcard_no = ceq.jobcard_no	
	    LEFT JOIN order_details as od ON cew.order_no = od.order_no	
      LEFT JOIN bill_of_material as bom ON od.spec_id = bom.bom_no AND od.spec_version_no = bom.bom_version_no
      LEFT JOIN specification_sheet as ss ON bom.sleeve_code = ss.article_no	
	    WHERE ceq.flag=0
      group by ceq.jobcard_no ORDER BY cew.cewip_id desc LIMIT $b,$a");
		  return $result=$query->result();
  }


  public function select_active_records_wip_group_by_check($jobcard_no){
		$query = $this->db->query("SELECT cew.cewip_id,cew.extrusion_date,cew.diameter,cew.length,cew.sleeve_weight_gm,cew.article_no,cew.order_no,cew.jobcard_no,sum(cew.ok_by_qc) as total_qty, cew.next_process_print,cew.jobcard_issue,cew.created_date,cew.issue_created_date,ceq.hold_by_qc,cmm.machine_name,ssm.shift_name,ss.dyn_qty_present 
			FROM coex_extrusion_wip as cew
	    LEFT JOIN coex_machine_master as cmm ON cew.machine_id = cmm.machine_id    
	    LEFT JOIN springtube_shift_master as ssm ON cew.shift_id = ssm.shift_id    
	    LEFT JOIN coex_extrusion_qc as ceq ON cew.jobcard_no = ceq.jobcard_no	
	    LEFT JOIN order_details as od ON cew.order_no = od.order_no	
      LEFT JOIN bill_of_material as bom ON od.spec_id = bom.bom_no AND od.spec_version_no = bom.bom_version_no
      LEFT JOIN specification_sheet as ss ON bom.sleeve_code = ss.article_no	
	    WHERE ceq.flag=0 and cew.jobcard_no='$jobcard_no'
      group by ceq.jobcard_no ORDER BY cew.cewip_id desc LIMIT 50");
		  return $result=$query->result();
  }

public function active_record_jobcard_purchase_price($jobcard_no){ 
    $sql = "SELECT mm_jobcard_no, sum(cost) as material_price 
            FROM (SELECT mm_jobcard_no, (qty*purchase_price) as cost 
            FROM (SELECT mm.manu_order_no as mm_jobcard_no,rqm.manu_order_no as rqm_jobcard_no,mm.work_proc_no,(rqm.total_qty/100) as qty, (rqm.calculated_purchase_price/100) as purchase_price
						FROM material_manufacturing as mm
						RIGHT JOIN reserved_quantity_manu as rqm ON mm.mm_id = rqm.ref_mm_id
						WHERE mm.manu_order_no ='$jobcard_no' and mm.work_proc_no ='1') as multi_cost) as price";
    $query=$this->db->query($sql);
    return $result=$query->result(); 
}


public function active_record_jobcard_qty_released_total($jobcard_no){ 
    $sql = "SELECT sum(`ok_by_qc`) as ok_qty FROM `coex_extrusion_wip` WHERE `jobcard_no` ='$jobcard_no' and `status`='1' and `to_process` ='4' || `to_process` ='7'";
    $query=$this->db->query($sql);
    return $result=$query->result(); 
}


public function active_record_jobcard_qty_released_to_total($jobcard_no){ 
    $sql = "SELECT sum(`ok_by_qc`) as ok_qty FROM `coex_extrusion_wip` WHERE `jobcard_no` ='$jobcard_no' and `status`='1' and `to_process` ='2' || `to_process` ='3'";
    $query=$this->db->query($sql);
    return $result=$query->result(); 
}






public function get_total_wip_qty($jobcard_no){ 
    $sql = "SELECT jobcard_no as wip_jobcard_no, sum(ok_by_qc) as wip_quantity FROM `coex_extrusion_wip` WHERE `jobcard_no`='$jobcard_no' GROUP BY jobcard_no ";
    $query=$this->db->query($sql);
    return $result=$query->result(); 
}

public function get_jobcard_close_check($jobcard_no){ 
    $sql = "SELECT jobcard_no,jobcard_close,jobcard_close_date FROM `coex_extrusion` WHERE `jobcard_no`='$jobcard_no' ";
    $query=$this->db->query($sql);
    return $result=$query->result(); 
}

public function get_to_process($wip_id){ 
	$sql = "SELECT * FROM coex_extrusion_wip WHERE cewip_id='$wip_id'";
	$query=$this->db->query($sql);
	return $result=$query->result(); 
}

public function get_to_process_($jobcard_no){ 
	$sql = "SELECT * FROM coex_extrusion_qc WHERE jobcard_no='$jobcard_no' and flag='0'";
	$query=$this->db->query($sql);
	return $result=$query->result(); 
}

public function get_return_extrusion_check($jobcard_no){ 
	$sql = "SELECT * FROM coex_extrusion_wip WHERE jobcard_no='$jobcard_no' and jobcard_issue='0'";
	$query=$this->db->query($sql);
	return $result=$query->result(); 
}


public function get_to_process_zero($jobcard_no){ 
	$sql = "SELECT * FROM coex_extrusion_qc WHERE jobcard_no='$jobcard_no' AND flag='0' ";
	$query=$this->db->query($sql);
	return $result=$query->result(); 
}

public function get_hold_qc_zero($wip_id){
	$query = $this->db->query("select *, w_cewip_id,w_jobcard_no,q_jobcard_no,q_hold_by_qc as hold_qty from (SELECT cew.cewip_id as w_cewip_id, cew.ce_id as w_ce_id, cew.qc_id as w_qc_id, cew.wip_id as w_wip_id,cew.wip_scrap_id as w_wip_scrap_id, cew.company_id as w_company_id,cew.jobcard_no as w_jobcard_no,ceq.ceqc_id as q_ceqc_id,ceq.ce_id as q_ce_id, ceq.qc_id as q_qc_id, ceq.wip_id as q_wip_id,ceq.company_id as q_company_id,ceq.jobcard_no as q_jobcard_no,ceq.hold_by_qc as q_hold_by_qc FROM coex_extrusion_wip as cew LEFT JOIN coex_extrusion_qc as ceq ON cew.jobcard_no = ceq.jobcard_no WHERE cew.jobcard_no='$wip_id' and ceq.hold_by_qc='0' )as hold_by");
	  return $result=$query->result();
  }

public function select_active_records_qc($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','RIGHT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','RIGHT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.hold_by_qc<>','0');
		$this->db->where($table.'.flag<>','1');
		$this->db->order_by($table.'.qc_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

public function select_active_records_scrap($limit,$start,$table,$company){
	$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
	$this->db->from($table);
	$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
	$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
	$this->db->where($table.'.archive<>', '1');
	$this->db->where($table.'.company_id',$company);
	$this->db->where($table.'.scrap_by_qc<>','0');
	$this->db->order_by($table.'.ce_scrap_id','desc');
	$this->db->limit($limit, $start);
	$query = $this->db->get();
	return $result=$query->result();
}

public function select_active_records_wip_scrap($limit,$start,$table,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.scrap_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}
	
public function select_one_active_record_hold($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

public function select_archive_records_ce($table,$data,$from,$to,$company){
    $this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
    $this->db->from($table);
    $this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
    $this->db->where($table.'.archive<>', '1');
    $this->db->where($table.'.company_id',$company);
    
    if(!empty($from) && !empty($to)){
      $this->db->where(''.$table.'.extrusion_date >=', $from);
    $this->db->where(''.$table.'.extrusion_date <=', $to);
    }
    foreach($data as $key => $value) {
      $this->db->where($key,$value);
    }
    $this->db->order_by('coex_extrusion.ce_id desc');
    $query = $this->db->get();
    return $result=$query->result();
  }

public function select_archive_records_wip($table,$data,$from,$to,$company){
    $this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
    $this->db->from($table);
    $this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
    $this->db->where($table.'.archive<>', '1');
    $this->db->where($table.'.company_id',$company);
    
    if(!empty($from) && !empty($to)){
      $this->db->where(''.$table.'.extrusion_date >=', $from);
    $this->db->where(''.$table.'.extrusion_date <=', $to);
    }
    foreach($data as $key => $value) {
      $this->db->where($key,$value);
    }
    $this->db->order_by('coex_extrusion_wip.cewip_id desc');
    $query = $this->db->get();
    return $result=$query->result();
  }

public function select_archive_records_qc($table,$data,$from,$to,$company){
    $this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
    $this->db->from($table);
    $this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
    $this->db->where($table.'.archive<>', '1');
    $this->db->where($table.'.company_id',$company);
    
    if(!empty($from) && !empty($to)){
      $this->db->where(''.$table.'.extrusion_date >=', $from);
    $this->db->where(''.$table.'.extrusion_date <=', $to);
    }
    foreach($data as $key => $value) {
      $this->db->where($key,$value);
    }
    $this->db->order_by('coex_extrusion_qc.ceqc_id desc');
    $query = $this->db->get();
    return $result=$query->result();
  }

public function select_archive_records_scrap($table,$company,$data,$from,$to){
    $this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
    $this->db->from($table);
    $this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
	$this->db->where($table.'.scrap_by_qc<>', '0');	
    $this->db->where($table.'.archive<>', '1');
    $this->db->where($table.'.company_id',$company);
    
    if(!empty($from) && !empty($to)){
      $this->db->where(''.$table.'.created_date >=', $from);
    $this->db->where(''.$table.'.created_date <=', $to);
    }
    foreach($data as $key => $value) {
      $this->db->where($key,$value);
    }
    $this->db->order_by('coex_extrusion_scrap.ce_scrap_id desc');
    $query = $this->db->get();
    return $result=$query->result();
  }

public function select_one_active_record_wip($table,$company,$pkey,$edit){
	$this->db->select('*');
	$this->db->from($table);
	$this->db->where($table.'.company_id',$company);
	$this->db->where($table.'.archive<>','1');
	$this->db->where($pkey,$edit);
	$query = $this->db->get();
	return $query->result();
}

/*public function select_one_active_record_scrap($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}*/

/*public function active_record_search_in($table,$company,$data,$from,$to,$release_from,$release_to){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name,specification_sheet.dyn_qty_present');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');

        $this->db->join('order_details',$table.'.order_no=order_details.order_no','LEFT');
    	$this->db->join('bill_of_material','order_details.spec_id=bill_of_material.bom_no AND order_details.spec_version_no = bill_of_material.bom_version_no' ,'LEFT');
        $this->db->join('specification_sheet','bill_of_material.sleeve_code=specification_sheet.article_no','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '0');
		$this->db->where($table.'.ok_by_qc<>','0');
		$this->db->order_by($table.'.cewip_id desc');
		//$this->db->where($table.'.status','0');
		
			if($from!='' && $to!=''){
				$this->db->where('created_date >=',$from);
				$this->db->where('created_date <=',$to);
			}
			
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {				
				
				if($key=='status' && $value==0){

					$where='(release_date="0000-00-00" OR release_date>"'.$to.'")';
					$this->db->where($where);

				}else{
					$this->db->where($table.'.'.$key,$value);
				}
			}
		}
		if($release_from!='' && $release_to!=''){
			$this->db->where('release_date>=',$release_from);
			$this->db->where('release_date<=',$release_to);
		}

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}*/


	public function active_record_search_in($table,$company,$data,$from,$to,$release_from,$release_to){

		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '0');
		$this->db->where($table.'.ok_by_qc<>','0');
		
		$this->db->order_by($table.'.cewip_id desc');
		
			if($from!='' && $to!=''){
				$this->db->where('created_date>=',$from);
				$this->db->where('created_date<=',$to);
				//$this->db->where($table.'.ok_by_qc<>','0');
			}
			
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {				
				
				if($key=='status' && $value==0){

					$where='(release_date="0000-00-00" OR release_date>"'.$to.'")';
					$this->db->where($where);

				}else{
					$this->db->where($table.'.'.$key,$value);
				}
			}
		}
		if($release_from!='' && $release_to!=''){
			$this->db->where('release_date>=',$release_from);
			$this->db->where('release_date<=',$release_to);
		}

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}



	public function wip_active_record_search_groupby($table,$company,$data,$from,$to){
		$this->db->select('year(extrusion_date)year,MONTHNAME(extrusion_date) month,diameter,length,order_no,article_no,jobcard_no,sum(ok_by_qc)ok_by_qc');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('extrusion_date>=',$from);
			$this->db->where('extrusion_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		$where='(release_date="0000-00-00" OR release_date>"'.$to.'")';
		$this->db->where($where);
		$this->db->group_by("year(extrusion_date)");
		$this->db->group_by("MONTH(extrusion_date)");
		$this->db->group_by("diameter");
		//$this->db->group_by("length");
		//$this->db->group_by("order_no");
		//$this->db->group_by("article_no");
		//$this->db->group_by("jobcard_no");

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}


public function select_extrusion_monthwise_mis_gcm2($from_date,$to_date){ 

        $sql="select year(ce.extrusion_date) as year, monthname(ce.extrusion_date) as month, month(ce.extrusion_date) as month_no, 
	SUM(if(ce.machine_id=1, ce.ok_qty_no,0)) as prod_Gcm_1, 
	SUM(if(ce.machine_id=1 , ce.scrap_tube_no,0)) as scrap_Gcm_1, 
	SUM(if(ce.machine_id=1 , (ce.scrap_tube_no)/(ce.ok_qty_no)*100,0)) as rejection_Gcm_1, 
	SUM(if(ce.machine_id=2 ,ce.ok_qty_no,0)) as prod_Gcm_2 , 
	SUM(if(ce.machine_id=2 , ce.scrap_tube_no,0)) as scrap_Gcm_2, 
	SUM(if(ce.machine_id=2 , (ce.scrap_tube_no)/(ce.ok_qty_no)*100,0)) as rejection_Gcm_2, 
	SUM(if(ce.machine_id=3 ,ce.ok_qty_no,0)) as prod_Breyer_3,
	SUM(if(ce.machine_id=3 ,ce.scrap_tube_no,0)) as scrap_Breyer_3, 
	SUM(if(ce.machine_id=3 , (ce.scrap_tube_no)/(ce.ok_qty_no)*100,0)) as rejection_breyer_2,  
	SUM(if(ce.machine_id=4 ,ce.ok_qty_no,0)) as prod_Breyer_4, 
	SUM(if(ce.machine_id=4 ,ce.scrap_tube_no,0)) as scrap_Breyer_4, 
	SUM(if(ce.machine_id=4 , (ce.scrap_tube_no)/(ce.ok_qty_no)*100,0)) as rejection_breyer_3 
	from coex_extrusion as ce LEFT JOIN coex_machine_master as cm ON ce.machine_id=cm.machine_id WHERE ce.extrusion_date between '$from_date' and '$to_date' group by year,month order by year desc,month_no desc";

            $query=$this->db->query($sql);
            return $result=$query->result();
    }

public function check_ce_qc(){
  $query = $this->db->query("
  	SELECT cew.*, ceq.hold_by_qc as hold_qty
    FROM coex_extrusion_qc as ceq
    LEFT JOIN coex_extrusion_wip as cew ON ceq.jobcard_no = cew.jobcard_no ");
  return $result=$query->result();
}

public function select_defect_model($table){
	$this->db->select('*');
	$this->db->from($table);
	$query = $this->db->get();
	return $query->result();
}


public function select_active_records_qc_released($limit,$start,$table,$company){
	$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
	$this->db->from($table);
    $this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','RIGHT');
	$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','RIGHT');
	$this->db->where($table.'.archive<>', '1');
	$this->db->where($table.'.company_id',$company);
	$this->db->where($table.'.flag','1');
	$this->db->where($table.'.release_qty<>', '0');
	$this->db->order_by($table.'.qc_id','desc');
	$this->db->limit($limit, $start);
	$query = $this->db->get();
	return $result=$query->result();
}


	public function get_defect_details_by_id($id)
  {
    $query = $this->db->query("SELECT id, defect FROM coex_extrusion_defect 
    	WHERE id='$id'");
        if (!empty($query)) {
           $item=$query->row_array();    
            $resultdata = array(
              "id"          => $item['id'],
					    "defect"      => $item['defect'],
				    );            
        }
    return $resultdata;
  }

	public function get_defect_details($table,$id){
		$this->db->select('id, process_id, defect');
		$this->db->from($table);
		$this->db->where($table.'.id',$id);
		$query = $this->db->get();
		return $result=$query->result();
	}
  

  public function active_record_search_coex($table,$company,$data,$from,$to,$release_from,$release_to){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name,specification_sheet.dyn_qty_present,sleeve_diameter_master.sleeve_id,packing_box_master.no_of_tubes_per_box');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->join('order_details',$table.'.order_no=order_details.order_no','LEFT');
        $this->db->join('bill_of_material','order_details.spec_id=bill_of_material.bom_no AND order_details.spec_version_no = bill_of_material.bom_version_no' ,'LEFT');
        $this->db->join('specification_sheet','bill_of_material.sleeve_code=specification_sheet.article_no','LEFT');
		$this->db->join('sleeve_diameter_master',$table.'.diameter=sleeve_diameter_master.sleeve_diameter','LEFT');
		$this->db->join('packing_box_master','sleeve_diameter_master'.'.sleeve_id=packing_box_master.sleeve_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '0');
		//$this->db->where($table.'.status','0');
		
			if($from!='' && $to!=''){
				$this->db->where('extrusion_date>=',$from);
				$this->db->where('extrusion_date<=',$to);
			}
			
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {				
				
				if($key=='status' && $value==0){

					$where='(release_date="0000-00-00" OR release_date>"'.$to.'")';
					$this->db->where($where);

				}else{
					$this->db->where($table.'.'.$key,$value);
				}
			}
		}
		if($release_from!='' && $release_to!=''){
			$this->db->where('release_date>=',$release_from);
			$this->db->where('release_date<=',$release_to);
		}

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}


public function active_record_qc_search($table,$company,$data,$from,$to){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.hold_by_qc<>','0');
		$this->db->where($table.'.flag','0');
		$this->db->order_by($table.'.qc_id','desc');
		if($from!='' && $to!=''){
			$this->db->where('created_date>=',$from);
			$this->db->where('created_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}


public function active_record_qc_released_search($table,$company,$data,$from,$to){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.release_qty<>','0');
		$this->db->where($table.'.flag','1');
		$this->db->order_by($table.'.qc_id','desc');
		if($from!='' && $to!=''){
			$this->db->where('created_date>=',$from);
			$this->db->where('created_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

public function active_record_search_pending_coex($table,$company,$data,$from,$to){
		$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name,specification_sheet.dyn_qty_present');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
		$this->db->join('order_details',$table.'.order_no=order_details.order_no','LEFT');
        $this->db->join('bill_of_material','order_details.spec_id=bill_of_material.bom_no AND order_details.spec_version_no = bill_of_material.bom_version_no' ,'LEFT');
        $this->db->join('specification_sheet','bill_of_material.sleeve_code=specification_sheet.article_no','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '0');
		$this->db->where($table.'.qc_flag','0');
		if($from!='' && $to!=''){
			$this->db->where('extrusion_date>=',$from);
			$this->db->where('extrusion_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}
  
  public function active_record_wip_group_by_search($company,$data,$from,$to){
		$this->db->select('cew.cewip_id,ceq.extrusion_date,cew.diameter,cew.length,cew.sleeve_weight_gm,cew.article_no,cew.order_no,cew.jobcard_no,sum(cew.ok_by_qc) as total_qty, cew.next_process_print,cew.jobcard_issue,cew.created_date,ceq.hold_by_qc,cmm.machine_name,ssm.shift_name,ss.dyn_qty_present');
		$this->db->from('coex_extrusion_wip as cew');
		$this->db->join('coex_machine_master as cmm','cew'.'.machine_id=cmm.machine_id','LEFT');
		$this->db->join('springtube_shift_master as ssm','cew'.'.shift_id=ssm.shift_id','LEFT');
		$this->db->join('coex_extrusion_qc as ceq','cew'.'.jobcard_no=ceq.jobcard_no','LEFT');
		//$this->db->join('coex_extrusion as ce','cew'.'.jobcard_no=ce.jobcard_no','LEFT');
		$this->db->join('order_details as od','cew'.'.order_no=od.order_no','LEFT');
        $this->db->join('bill_of_material as bom','od.spec_id=bom.bom_no AND od.spec_version_no = bom.bom_version_no' ,'LEFT');
        $this->db->join('specification_sheet as ss','bom.sleeve_code=ss.article_no','LEFT');
		$this->db->where('cew'.'.company_id',$company);
		$this->db->where('cew'.'.archive<>', '1');
		$this->db->where('ceq'.'.flag','0');
		$this->db->group_by('ceq'.'.jobcard_no');
		//$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('ceq.extrusion_date>=',$from);
			$this->db->where('ceq.extrusion_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where('cew'.'.'.$key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}


public function select_active_records_pending_qc($limit,$start,$table,$company){
	$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name,specification_sheet.dyn_qty_present');
	$this->db->from($table);
	$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
	$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
	$this->db->join('order_details',$table.'.order_no=order_details.order_no','LEFT');
    $this->db->join('bill_of_material','order_details.spec_id=bill_of_material.bom_no AND order_details.spec_version_no = bill_of_material.bom_version_no' ,'LEFT');
    $this->db->join('specification_sheet','bill_of_material.sleeve_code=specification_sheet.article_no','LEFT');
	$this->db->where($table.'.archive<>', '1');
	$this->db->where($table.'.company_id',$company);
	$this->db->where($table.'.qc_flag','0');
	$this->db->order_by('coex_extrusion.ce_id desc');
	$this->db->limit($limit, $start);
	$query = $this->db->get();
	return $result=$query->result();
}


public function get_extrusion_(){
	$this->db2 = $this->load->database('another_db2', TRUE);
    $this->db2->select('MAX(ex_id) as maxexid');
    $this->db2->from('extrusion');
    $query = $this->db2->get();
    return $result=$query->row_array();
  }

  public function get_jobcard_qty($so_no, $jobcard){

  	$sql = "SELECT * FROM `production_master` WHERE `mp_pos_no`='$jobcard' and `sales_ord_no`='$so_no'";
  	$query = $this->db->query($sql);
    return $result=$query->result();

  }





}
?>