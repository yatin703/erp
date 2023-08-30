<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint_register_model extends CI_Model {

		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->order_by($table.'.id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive=', '1');
		$this->db->where($table.'.company_id',$company);
		//$this->db->order_by($table.'.jobsetup_date','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);		
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}
	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);		 
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.archive', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function active_record_search($table,$data,$from,$to,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		if($from!=''&& $to!=''){
		$this->db->where($table.'.email_date>=',$from);
		$this->db->where($table.'.email_date<=',$to);
		}
		foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}	
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search_autocomplete($table,$data,$from,$to,$company){
		$this->db->select('complaint_no');
		$this->db->from($table);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		if($from!=''&& $to!=''){
		$this->db->where($table.'.complaint_date>=',$from);
		$this->db->where($table.'.complaint_date<=',$to);
		}
		foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}	
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function capa_mis(){
		$sql="SELECT cnm.id,cnm.category,
							cnm.complaints
							FROM capa_complaint_nature_master as cnm 							
							group by cnm.complaints
							order by cnm.index";

		
					$query=$this->db->query($sql);
					return $result=$query->result();

	}

	public function capa_mis_date($from_date,$to_date,$complaint){
		$sql="SELECT cnm.id,cnm.category,
							cnm.complaints,
							count(crm.complaint_nature) as no_of_complaints
							FROM `capa_complaint_register_master` as crm RIGHT JOIN capa_complaint_nature_master as cnm 
							ON cnm.complaints=crm.complaint_nature 
							where crm.email_date between '$from_date' AND '$to_date'
							AND cnm.complaints='$complaint'
							AND crm.complaint_status IN('1','2','')
							AND crm.complaint_source=1
							group by cnm.complaints
							order by cnm.index";

		
					$query=$this->db->query($sql);
					$result=$query->result();
					foreach($result as $row){
						return $row->no_of_complaints;
					}

	}

	public function internal_capa_mis_date($from_date,$to_date,$complaint){
		$sql="SELECT cnm.id,cnm.category,
							cnm.complaints,
							count(crm.complaint_nature) as no_of_complaints
							FROM `capa_complaint_register_master` as crm RIGHT JOIN capa_complaint_nature_master as cnm 
							ON cnm.complaints=crm.complaint_nature 
							where crm.email_date between '$from_date' AND '$to_date'
							AND cnm.complaints='$complaint'
							AND crm.complaint_status IN('1','2','')
							AND crm.complaint_source=0
							group by cnm.complaints
							order by cnm.index";

		
					$query=$this->db->query($sql);
					$result=$query->result();
					foreach($result as $row){
						return $row->no_of_complaints;
					}

	}

	public function capa_mis_complete($from_date,$to_date,$complaint,$yn){
		$sql="select count(A.complete) as capa_compelte from (SELECT cnm.id,cnm.category,
							cnm.complaints,
                            if(crm.corrective_action_date='0000-00-00','NO','YES') as complete,
							crm.corrective_action_date
							FROM `capa_complaint_register_master` as crm RIGHT JOIN capa_complaint_nature_master as cnm 
							ON cnm.complaints=crm.complaint_nature 
							where crm.email_date between '$from_date' AND '$to_date'
							AND crm.complaint_status IN('1','2','')
							AND cnm.complaints='$complaint'	
							AND crm.complaint_source=1						
							order by cnm.index) as A where complete='$yn'";

		
					$query=$this->db->query($sql);
					$result=$query->result();
					foreach($result as $row){
						return $row->capa_compelte;
					}
					

	}

	public function internal_capa_mis_complete($from_date,$to_date,$complaint,$yn){
		$sql="select count(A.complete) as capa_compelte from (SELECT cnm.id,cnm.category,
							cnm.complaints,
                            if(crm.corrective_action_date='0000-00-00','NO','YES') as complete,
							crm.corrective_action_date
							FROM `capa_complaint_register_master` as crm RIGHT JOIN capa_complaint_nature_master as cnm 
							ON cnm.complaints=crm.complaint_nature 
							where crm.email_date between '$from_date' AND '$to_date'
							AND crm.complaint_status IN('1','2','')
							AND cnm.complaints='$complaint'
							AND crm.complaint_source=0							
							order by cnm.index) as A where complete='$yn'";

		
					$query=$this->db->query($sql);
					$result=$query->result();
					foreach($result as $row){
						return $row->capa_compelte;
					}
					

	}
	 

}

?>