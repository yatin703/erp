<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_runtime_downtime_model extends CI_Model {

	public function active_record_search($table,$data,$company){
		$this->db->select($table.'.*,coex_machine_start_stop_reasons.coex_machine_start_stop_reasons,coex_machine_master.machine_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('coex_machine_start_stop_reasons',$table.'.cemssr_id=coex_machine_start_stop_reasons.cemssr_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		//$this->db->order_by('address_details.timestamp','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search_by_date($table,$data,$from,$to,$company){
		$this->db->select($table.'.*,coex_machine_start_stop_reasons.coex_machine_start_stop_reasons,coex_machine_master.machine_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('coex_machine_start_stop_reasons',$table.'.cemssr_id=coex_machine_start_stop_reasons.cemssr_id','LEFT');
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->where(''.$table.'.machine_start_time >=', $from." 00:00:01");
		$this->db->where(''.$table.'.machine_start_time <=', $to." 24:59:59");
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function active_record_search_by_date_downtime($table,$data,$from,$to,$company){
		$this->db->select($table.'.*,coex_machine_start_stop_reasons.coex_machine_start_stop_reasons,coex_machine_master.machine_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('coex_machine_start_stop_reasons',$table.'.cemssr_id=coex_machine_start_stop_reasons.cemssr_id','LEFT');
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->where(''.$table.'.machine_stop_time >=', $from." 00:00:01");
		$this->db->where(''.$table.'.machine_stop_time <=', $to." 24:59:59");
		$this->db->where($table.'.archive<>','1');
		$this->db->where($table.'.company_id',$company);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function coex_machine_current_status($table,$company,$machine){
		$query=$this->db->query("SELECT coex_extrusion_machine_start_stop . * , coex_machine_start_stop_reasons.coex_machine_start_stop_reasons
			FROM  `coex_extrusion_machine_start_stop` 
			LEFT JOIN coex_machine_start_stop_reasons ON coex_extrusion_machine_start_stop.`cemssr_id` = coex_machine_start_stop_reasons.cemssr_id
			WHERE  `machine_id` =  '$machine'
			ORDER BY  `cemss_id` DESC 
			LIMIT 0 , 1");
		return $result=$query->result();
	}

	public function coex_printing_machine_current_status($table,$company,$machine){
		$query=$this->db->query("SELECT coex_printing_machine_start_stop . * , coex_machine_start_stop_reasons.coex_machine_start_stop_reasons
			FROM  `coex_printing_machine_start_stop` 
			LEFT JOIN coex_machine_start_stop_reasons ON coex_printing_machine_start_stop.`cemssr_id` = coex_machine_start_stop_reasons.cemssr_id
			WHERE  `machine_id` =  '$machine'
			ORDER BY  `cpmss_id` DESC 
			LIMIT 0 , 1");
		return $result=$query->result();
	}

	public function coex_downtime_summary($from_date,$to_date,$company){
		$sql="SELECT coex_machine_downtime.machine_stop_time as sort,
				MONTH(coex_machine_downtime.machine_stop_time) as month_no,
				YEAR( coex_machine_downtime.machine_stop_time) as downtime_year, 
				LEFT(MONTHNAME(coex_machine_downtime.machine_stop_time),3) as downtime_month,

				coex_machine_start_stop_reasons.coex_machine_start_stop_reasons as downtime_reason , 


				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '5' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '5' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS FLEXO1_DONWTIME ,


				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '6' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '6' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS FLEXO2_DONWTIME , 


				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '7' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '7' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS MOSS_DONWTIME , 

				
				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '8' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '8' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS ISIMATSCREEN_DONWTIME, 

				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '9' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '9' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS BONMAC_DONWTIME, 

				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '10' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '10' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS POLYTYPE_DONWTIME,

				CONCAT(FLOOR(SUM( TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) )/60),'h ',MOD(SUM( TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) ),60),'m') AS TOTAL_DOWNTIME  

				FROM `coex_machine_downtime` LEFT JOIN coex_machine_start_stop_reasons ON coex_machine_downtime.cemssr_id = coex_machine_start_stop_reasons.cemssr_id WHERE coex_machine_downtime.machine_stop_time >= '$from_date 00:00:01' AND coex_machine_downtime.machine_stop_time <= '$to_date 24:59:59' 

				GROUP BY coex_machine_downtime.cemssr_id
				ORDER BY 
				SUM( TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) ) desc

				";
		$query=$this->db->query($sql);
		return $result=$query->result();
	}

	public function coex_downtime_summary_total($from_date,$to_date,$company){
		$sql="SELECT 
				coex_machine_start_stop_reasons.coex_machine_start_stop_reasons as downtime_reason , 


				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '5' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '5' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS FLEXO1_DONWTIME ,


				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '6' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '6' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS FLEXO2_DONWTIME , 


				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '7' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '7' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS MOSS_DONWTIME , 

				
				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '8' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '8' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS ISIMATSCREEN_DONWTIME, 

				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '9' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '9' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS BONMAC_DONWTIME, 

				CONCAT(FLOOR(SUM( IF( coex_machine_downtime.machine_id = '10' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) )/60),'h ',MOD(SUM( IF( coex_machine_downtime.machine_id = '10' , TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) , 0 ) ),60),'m')  AS POLYTYPE_DONWTIME,

				CONCAT(FLOOR(SUM( TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) )/60),'h ',MOD(SUM( TIMESTAMPDIFF( MINUTE , machine_stop_time , machine_start_time ) ),60),'m') AS TOTAL_DOWNTIME  

				FROM `coex_machine_downtime` LEFT JOIN coex_machine_start_stop_reasons ON coex_machine_downtime.cemssr_id = coex_machine_start_stop_reasons.cemssr_id WHERE coex_machine_downtime.machine_stop_time >= '$from_date 00:00:01' AND coex_machine_downtime.machine_stop_time <= '$to_date 24:59:59' 

				";
		$query=$this->db->query($sql);
		return $result=$query->result();
	}

}

?>