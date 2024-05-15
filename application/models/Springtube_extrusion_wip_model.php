<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_extrusion_wip_model extends CI_Model {	

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','0');
		$this->db->where($table.'.status','0');
		
		$this->db->order_by('wip_id','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		$this->db->where($table.'.status','0');
		$this->db->limit($limit, $start);
		$this->db->order_by('wip_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}	

	
	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '0');
		//$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('wip_date>=',$from);
			$this->db->where('wip_date<=',$to);
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

	// public function active_record_search_in($table,$company,$data,$from,$to,$in_arr){
	// 	$this->db->select('*');
	// 	$this->db->from($table);
	// 	$this->db->where($table.'.company_id',$company);
	// 	$this->db->where($table.'.archive', '0');
	// 	//$this->db->where($table.'.status','0');
	// 	if($from!='' && $to!=''){
	// 		$this->db->where('wip_date>=',$from);
	// 		$this->db->where('wip_date<=',$to);
	// 	}
	// 	//print_r($data);
	// 	if(!empty($data)){		
	// 		foreach($data as $key => $value) {
	// 			$this->db->where($table.'.'.$key,$value);
	// 		}
	// 	}

	// 	if(!empty($in_arr)){
	//     	$this->db->where_in($table.'.from_process',$in_arr);
	//     }

	// 	$query = $this->db->get();
	// 	//echo $this->db->last_query();
	// 	return $result=$query->result();
		
	// }
	public function active_record_search_in($table,$company,$data,$from,$to,$release_from,$release_to,$in_arr){

		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive', '0');
		//$this->db->where($table.'.status','0');
		
			if($from!='' && $to!=''){
				$this->db->where('wip_date>=',$from);
				$this->db->where('wip_date<=',$to);
			}
			
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {				
				
				if($key=='status' && $value==0){

					$where='(release_date IS NULL OR release_date>"'.$to.'")';
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

		if(!empty($in_arr)){
	    	$this->db->where_in($table.'.from_process',$in_arr);
	    }

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function active_record_search_groupby($table,$company,$data,$from,$to){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//	$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('wip_date>=',$from);
			$this->db->where('wip_date<=',$to);
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

	public function wip_active_record_search_groupby($table,$company,$data,$from,$to){
		$this->db->select('year(wip_date)year,MONTHNAME(wip_date) month,sleeve_dia,total_microns,second_layer_mb,sixth_layer_mb,sum(total_ok_meters)total_ok_meters,sum(total_ok_meters*wip_cost_per_meter)amount');
		$this->db->from($table);
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//$this->db->where($table.'.status','0');
		if($from!='' && $to!=''){
			$this->db->where('wip_date>=',$from);
			$this->db->where('wip_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		$where='(release_date="0000-00-00" OR release_date>"'.$to.'")';
		$this->db->where($where);
		$this->db->group_by("year(wip_date)");
		$this->db->group_by("MONTH(wip_date)");
		$this->db->group_by("sleeve_dia");
		$this->db->group_by("total_microns");
		$this->db->group_by("second_layer_mb");
		$this->db->group_by("sixth_layer_mb");

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function wip_release_partially($data_wip_before_insert,$data_wip_insert,$data_wip_update,$wip_id){

		$this->db->trans_begin();

		// Inserting meters in wip_before
		$this->db->insert('springtube_printing_wip_master_before',$data_wip_before_insert);
		// Insesrting New record in wip master
		$this->db->insert('springtube_extrusion_wip_master',$data_wip_insert);

		// Updating old wip master record
		$this->db->where('wip_id', $wip_id);		
		$this->db->update('springtube_extrusion_wip_master',$data_wip_update);

		if($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		    return FALSE;

		}
		else
		{
		    $this->db->trans_commit();
		    return TRUE;
		}
		
	}

	public function wip_release_full($data_wip_before_insert,$data_wip_update,$wip_id){

		$this->db->trans_begin();
		
		// Inserting meters in wip_before
		$this->db->insert('springtube_printing_wip_master_before',$data_wip_before_insert);
		
		// Updating old wip master record
		$this->db->where('wip_id', $wip_id);		
		$this->db->update('springtube_extrusion_wip_master',$data_wip_update);

		if($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		    return FALSE;

		}
		else
		{
		    $this->db->trans_commit();
		    return TRUE;
		}
		
	}

	///---------FOR SCRAP--------------

	public function wip_to_scrap_partially($data_scrap_insert,$data_wip_insert,$data_wip_update,$wip_id){

		$this->db->trans_begin();

		// Inserting meters in wip_before
		$this->db->insert('springtube_extrusion_scrap_master',$data_scrap_insert);
		// Insesrting New record in wip master
		$this->db->insert('springtube_extrusion_wip_master',$data_wip_insert);

		// Updating old wip master record
		$this->db->where('wip_id', $wip_id);		
		$this->db->update('springtube_extrusion_wip_master',$data_wip_update);

		if($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		    return FALSE;

		}
		else
		{
		    $this->db->trans_commit();
		    return TRUE;
		}
		
	}

	public function wip_to_scrap_full($data_scrap_insert,$data_wip_update,$wip_id){

		$this->db->trans_begin();
		
		// Inserting meters in wip_before
		$this->db->insert('springtube_extrusion_scrap_master',$data_scrap_insert);
		
		// Updating old wip master record
		$this->db->where('wip_id', $wip_id);		
		$this->db->update('springtube_extrusion_wip_master',$data_wip_update);

		if($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		    return FALSE;

		}
		else
		{
		    $this->db->trans_commit();
		    return TRUE;
		}
		
	}


	/*public function select_active_records_papertube($table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('sofp_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}*/

	public function select_active_records_papertube($table){
		$this->db->select('*');
		
		$this->db->select(''.$table.'.*,springtube_extrusion_wip_master.order_no as STSO_ORDER_NO');
		$this->db->from($table);
		$this->db->join('springtube_extrusion_wip_master',''.$table.'.order_no=springtube_extrusion_wip_master.release_to_order_no','LEFT');
		$this->db->order_by('sofp_id','desc');
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function select_one_active_record_paper_tube($table,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	
		
}

?>