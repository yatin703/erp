<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_model extends CI_Model {

	public function select_extrusion_monthwise($table,$company,$from_date,$to_date){

		$sql="SELECT YEAR(STR_TO_DATE(es.date,'%d-%m-%Y' )) as PRODUCTION_YEAR, MONTHNAME(STR_TO_DATE(es.date,'%d-%m-%Y' )) as PRODUCTION_MONTH, MONTH(STR_TO_DATE(es.date,'%d-%m-%Y' )) as MONTH_NO, sum(if(es.machine_id='1',sleeve_to_header,0)) as GSM_1_SUM, sum(if(es.machine_id='2',sleeve_to_header,0)) as GSM_2_SUM, sum(if(es.machine_id='4',sleeve_to_header,0)) as BREYER_2_SUM, sum(if(es.machine_id='3',sleeve_to_header,0)) as BREYER_3_SUM FROM `extrusion` as es LEFT JOIN machine_master as mm on es.machine_id=mm.machine_id where STR_TO_DATE(es.date,'%d-%m-%Y' ) BETWEEN '$from_date' AND '$to_date' AND es.job_no!='TOTAL' AND es.so_no!='' group by PRODUCTION_YEAR,MONTH_NO order by PRODUCTION_YEAR, MONTH_NO asc";

			$query=$this->db2->query($sql);
			return $result=$query->result();
	}

	public function select_heading_monthwise($table,$company,$from_date,$to_date){

		$sql="SELECT YEAR(STR_TO_DATE(hs.date,'%d-%m-%Y' )) as PRODUCTION_YEAR, 
				MONTHNAME(STR_TO_DATE(hs.date,'%d-%m-%Y' )) as PRODUCTION_MONTH, 
				MONTH(STR_TO_DATE(hs.date,'%d-%m-%Y' )) as MONTH_NO, 
				sum(if(hs.machine_id='5',hs.heading_sleeves_to_next,0)) as AISA_1_SUM, 
				sum(if(hs.machine_id='7',hs.heading_sleeves_to_next,0)) as AISA_2_SUM, 
				sum(if(hs.machine_id='8',hs.heading_sleeves_to_next,0)) as AISA_3_SUM, 
				sum(if(hs.machine_id='9',hs.heading_sleeves_to_next,0)) as AISA_4_SUM,
				sum(if(hs.machine_id='10',hs.heading_sleeves_to_next,0)) as AISA_5_SUM,
				sum(if(hs.machine_id='11',hs.heading_sleeves_to_next,0)) as AISA_6_SUM  
				FROM `heading` as hs 
				LEFT JOIN machine_master as mm on hs.machine_id=mm.machine_id 
				where STR_TO_DATE(hs.date,'%d-%m-%Y' ) BETWEEN '$from_date' AND '$to_date' 
				AND hs.job_no!='TOTAL' AND hs.so_no!=''  AND hs.forwarded_sleeves<>0
				group by PRODUCTION_YEAR,MONTH_NO 
				order by PRODUCTION_YEAR, MONTH_NO asc";

			$query=$this->db2->query($sql);
			return $result=$query->result();
	}

	public function select_printing_monthwise($table,$company,$from_date,$to_date){

		$sql="SELECT YEAR(STR_TO_DATE(ps.date,'%d-%m-%Y' )) as PRODUCTION_YEAR, 
				MONTHNAME(STR_TO_DATE(ps.date,'%d-%m-%Y' )) as PRODUCTION_MONTH, 
				MONTH(STR_TO_DATE(ps.date,'%d-%m-%Y' )) as MONTH_NO, 
				sum(if(ps.machine_id='12',printing_sleeves_to_next,0)) as MOSS_OFFSET_SUM, 
				sum(if(ps.machine_id='14',printing_sleeves_to_next,0)) as BONMAC_OFFSET_SUM,
				sum(if(ps.machine_id='15',printing_sleeves_to_next,0)) as POLYTYPE_OFFSET_SUM, 
				sum(if(ps.machine_id='33',printing_sleeves_to_next,0)) as POLYTYPE_LAC_SUM,
				sum(if(ps.machine_id='16',printing_sleeves_to_next,0)) as ISIMAT_SCREEN_SUM,
				sum(if(ps.machine_id='17',printing_sleeves_to_next,0)) as ISIMAT_FLEXO_SUM,
				sum(if(ps.machine_id='35',printing_sleeves_to_next,0)) as ISIMAT_FLEXO_2_SUM
				FROM `printing` as ps 
				LEFT JOIN machine_master as mm on ps.machine_id=mm.machine_id 
				where STR_TO_DATE(ps.date,'%d-%m-%Y' ) BETWEEN '$from_date' AND '$to_date' 
				AND ps.job_no!='TOTAL' AND ps.so_no!='' 
				group by PRODUCTION_YEAR,MONTH_NO 
				order by PRODUCTION_YEAR, MONTH_NO asc";

			$query=$this->db2->query($sql);
			return $result=$query->result();
	}

	public function select_labeling_monthwise($table,$company,$from_date,$to_date){

		$sql="SELECT YEAR(STR_TO_DATE(ls.date,'%d-%m-%Y' )) as PRODUCTION_YEAR, 
				MONTHNAME(STR_TO_DATE(ls.date,'%d-%m-%Y' )) as PRODUCTION_MONTH, 
				MONTH(STR_TO_DATE(ls.date,'%d-%m-%Y' )) as MONTH_NO, 
				sum(if(ls.machine_id='18',ls.sleeves_to_next,0)) as TECHNOSHEEL_LABEL_2, 
				sum(if(ls.machine_id='19',ls.sleeves_to_next,0)) as TECHNOSHELL_HALF_LABEL,
				sum(if(ls.machine_id='20',ls.sleeves_to_next,0)) as TECHNOSHELL_LABEL_3
				FROM `labeling` as ls 
				LEFT JOIN machine_master as mm on ls.machine_id=mm.machine_id 
				where STR_TO_DATE(ls.date,'%d-%m-%Y' ) BETWEEN '$from_date' AND '$to_date' 
				AND ls.job_no!='TOTAL' AND ls.so_no!='' 
				group by PRODUCTION_YEAR,MONTH_NO 
				order by PRODUCTION_YEAR, MONTH_NO asc";

			$query=$this->db2->query($sql);
			return $result=$query->result();
	}

	public function select_capping_monthwise($table,$company,$from_date,$to_date){

		$sql="SELECT YEAR(STR_TO_DATE(cs.date,'%d-%m-%Y' )) as PRODUCTION_YEAR, 
				MONTHNAME(STR_TO_DATE(cs.date,'%d-%m-%Y' )) as PRODUCTION_MONTH, 
				MONTH(STR_TO_DATE(cs.date,'%d-%m-%Y' )) as MONTH_NO, 
				sum(if(cs.machine_id='21',cs.sleeves_to_next,0)) as MOSS_CAPPING, 
				sum(if(cs.machine_id='22',cs.sleeves_to_next,0)) as BONMAC_CAPPING,
				sum(if(cs.machine_id='23',cs.sleeves_to_next,0)) as LABEL_2_CAPPING,
				sum(if(cs.machine_id='24',cs.sleeves_to_next,0)) as LABEL_3_CAPPING,
				sum(if(cs.machine_id='25',cs.sleeves_to_next,0)) as ISIMAT_SCREEN_CAPPING,
				sum(if(cs.machine_id='26',cs.sleeves_to_next,0)) as ISIMAT_FLEXO_CAPPING,
				sum(if(cs.machine_id='36',cs.sleeves_to_next,0)) as ISIMAT_FLEXO_2_CAPPING
				FROM `capping` as cs 
				LEFT JOIN machine_master as mm on cs.machine_id=mm.machine_id 
				where STR_TO_DATE(cs.date,'%d-%m-%Y' ) BETWEEN '$from_date' AND '$to_date' 
				AND cs.job_no!='TOTAL' AND cs.so_no!='' 
				group by PRODUCTION_YEAR,MONTH_NO 
				order by PRODUCTION_YEAR, MONTH_NO asc";

			$query=$this->db2->query($sql);
			return $result=$query->result();
	}

	public function select_foiling_monthwise($table,$company,$from_date,$to_date){

		$sql="SELECT YEAR(STR_TO_DATE(fs.date,'%d-%m-%Y' )) as PRODUCTION_YEAR, 
				MONTHNAME(STR_TO_DATE(fs.date,'%d-%m-%Y' )) as PRODUCTION_MONTH, 
				MONTH(STR_TO_DATE(fs.date,'%d-%m-%Y' )) as MONTH_NO, 
				sum(if(fs.machine_id='28',fs.sleeves_to_next,0)) as MADAG_2, 
				sum(if(fs.machine_id='31',fs.sleeves_to_next,0)) as CER,
				sum(if(fs.machine_id='30',fs.sleeves_to_next,0)) as MADAG_3
				FROM `foiling` as fs 
				LEFT JOIN machine_master as mm on fs.machine_id=mm.machine_id 
				where STR_TO_DATE(fs.date,'%d-%m-%Y' ) BETWEEN '$from_date' AND '$to_date' 
				AND fs.job_no!='TOTAL' AND fs.so_no!='' 
				group by PRODUCTION_YEAR,MONTH_NO 
				order by PRODUCTION_YEAR, MONTH_NO asc";

			$query=$this->db2->query($sql);
			return $result=$query->result();
	}

	public function select_spring_printing_monthwise($table,$company,$from_date,$to_date){

		$sql="SELECT YEAR(M.`production_date`) as PRODUCTION_YEAR, 
				MONTHNAME(M.`production_date`) as PRODUCTION_MONTH, 
				MONTH(M.`production_date`) as MONTH_NO, 
				SUM(counter) as counter, SUM(counter)*2 as SPRING_PRINTING
				FROM  `springtube_printing_production_master` M
				INNER JOIN springtube_printing_production_details D
				ON M.production_id=D.production_id
				WHERE M.company_id='$company' AND  M.ARCHIVE <>1
				AND M.`production_date` BETWEEN  '$from_date' AND  '$to_date' 
				group by PRODUCTION_YEAR,MONTH_NO 
				order by PRODUCTION_YEAR, MONTH_NO asc";

			$query=$this->db->query($sql);
			//echo $this->db->last_query();
			return $result=$query->result();
	}

	public function select_spring_extrusion_monthwise($table,$company,$from_date,$to_date){

		$sql="SELECT YEAR(M.`production_date`) as PRODUCTION_YEAR, 
				MONTHNAME(M.`production_date`) as PRODUCTION_MONTH, 
				MONTH(M.`production_date`) as MONTH_NO, 
				SUM(D.`total_meters_produced`) as SPRING_EXTRUSION
				FROM  `springtube_extrusion_production_master` M
				INNER JOIN springtube_extrusion_production_details D
				ON M.production_id=D.production_id
				WHERE M.company_id='$company' AND  M.ARCHIVE=0
				AND M.`production_date` BETWEEN  '$from_date' AND  '$to_date' 
				group by PRODUCTION_YEAR,MONTH_NO 
				order by PRODUCTION_YEAR, MONTH_NO asc";

			$query=$this->db->query($sql);
			//echo $this->db->last_query();
			return $result=$query->result();
	}

	public function select_spring_bodymaking_monthwise($table,$company,$from_date,$to_date){

		$sql="SELECT YEAR(M.`production_date`) as PRODUCTION_YEAR, 
				MONTHNAME(M.`production_date`) as PRODUCTION_MONTH, 
				MONTH(M.`production_date`) as MONTH_NO, 
				SUM(D.`sleeve_with_cap`) as SPRING_BODYMAKING
				FROM  `springtube_bodymaking_production_master` M
				INNER JOIN springtube_bodymaking_production_details D
				ON M.production_id=D.production_id
				WHERE M.company_id='$company' AND  M.ARCHIVE=0
				AND M.`production_date` BETWEEN  '$from_date' AND  '$to_date' 
				group by PRODUCTION_YEAR,MONTH_NO 
				order by PRODUCTION_YEAR, MONTH_NO asc";

			$query=$this->db->query($sql);
			//echo $this->db->last_query();
			return $result=$query->result();
	}

	public function select_active_records_where($limit,$start,$table,$data){
		$this->db2->select('*');
		$this->db2->from($table);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db2->where($key,$value);
			}
		}
		if($limit!== ''){
			$this->db2->limit($limit, $start);

		}		
		
		
		$query = $this->db2->get();
		//echo $this->db2->last_query();
		return $result=$query->result();
	}


}