
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_planning_model extends CI_Model {

//Used in Main Group Create form for dropdown
	public function select_active_records($from_date,$to_date){

		$sql="SELECT om.order_no,om.customer_no,am.dispatch_tolerance,om.approval_date,od.article_no,if(om.for_export<>1 , (od.selling_price/100),(od.calc_sell_price)*(om.exchange_rate/100))as unit_price, od.sleeve_dia, od.print_type,od.total_order_quantity /100 AS quantity,lm.printing_group, IFNULL(sum( ar.arid_qty /100 ),0) AS dispatch, IFNULL(sum(cp.quantity),0) as planned,if((IFNULL(sum( ar.arid_qty /100 ),0)+IFNULL(sum(cp.quantity),0)) < ( od.total_order_quantity /100 ) , (od.total_order_quantity /100) -(IFNULL(sum(cp.quantity),0) + IFNULL(sum( ar.arid_qty /100),0)), 0 ) AS pending

					FROM `order_master` AS om
					INNER JOIN order_details AS od ON om.order_no = od.order_no
					LEFT JOIN ar_invoice_details AS ar ON om.order_no = ar.ref_ord_no
					AND od.article_no = ar.article_no

					LEFT JOIN coex_planning AS cp ON cp.order_no = om.order_no
					AND cp.article_no=od.article_no
					/*LEFT JOIN ar_invoice_master AS am ON ar.ar_invoice_no = am.ar_invoice_no*/
					LEFT JOIN lacquer_types_master AS lm ON od.print_type = lm.lacquer_type
					LEFT JOIN address_master AS am ON om.customer_no=am.adr_company_id
					WHERE om.approval_date
					BETWEEN '$from_date'
					AND '$to_date'
					AND om.final_approval_flag = '1'

					AND om.trans_closed<>'1'
					AND om.for_stock<>1
					AND om.order_flag=0
					/*AND od.sleeve_dia<>''*/
					AND od.print_type<>''

					AND om.planning_flag IN('0','2')
					/*AND am.cancel_invoice <>1*/
					GROUP BY  om.order_no,od.article_no

					Order by om.approval_date asc";
					$query=$this->db->query($sql);
					return $result=$query->result();
	}

	public function select_one_active_record($table,$data,$company){
		$this->db->select($table.'.*,coex_machine_master.machine_name');
		$this->db->from($table);
		$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($key,$value);
			}
		}
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function check_shift_record($machine_id,$company){
		$sql="select shift_master.*,coex_machine_master.machine_capacity_per_minute,coex_machine_master.job_changeover,coex_machine_master.tool_changeover from shift_master 
		LEFT JOIN coex_machine_master on shift_master.machine_id=coex_machine_master.machine_id
		where shift_master.company_id='$company' AND shift_master.archive<>1 AND shift_master.machine_id='$machine_id' order by shift_id limit 0,1";
		$query=$this->db->query($sql);
		return $result=$query->result();
		/*
		$this->db->select('*');
		$this->db->from('shift_master');
		$this->db->where('company_id', $company);
		$this->db->where('archive<>', '1');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();*/
	}

	public function select_planned_records($table,$data,$company){
		$this->db->select(''.$table.'.*,order_master.customer_no,address_master.name1,od.sleeve_dia,od.sleeve_length,od.print_type,shift_master.shift_start_time');
		$this->db->from($table);
		$this->db->join('order_master',''.$table.'.order_no=order_master.order_no','LEFT');
		$this->db->join('address_master','order_master.customer_no=address_master.adr_company_id','LEFT');
		$this->db->join('order_details as od',''.$table.'.order_no=od.order_no','LEFT');
		$this->db->join('shift_master',''.$table.'.shift_id=shift_master.shift_no','LEFT');
		//$this->db->join('order_details as od',''.$table.'.article_no=od.article_no','LEFT');
		$this->db->where(''.$table.'.company_id', $company);
		$this->db->where(''.$table.'.archive!=', '1');
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		$this->db->order_by(' '.$table.'.c_plan_id');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();

	}	
	



}

?>