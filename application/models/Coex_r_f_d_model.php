<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_r_f_d_model extends CI_Model {

	public function select_active_records_pending($table,$company){
		$this->db->select($table.'.*,om.oc_date,od.print_type,am.name1,ani.lang_sub_description,ani.lang_article_description');
		$this->db->from($table);
		$this->db->join('order_master as om',$table.'.order_no=om.order_no','LEFT');
		$this->db->join('order_details as od',$table.'.order_no=od.order_no','INNER');
		$this->db->join('address_master as am','om'.'.customer_no=am.adr_company_id','INNER');
		$this->db->join('article_name_info as ani','od'.'.article_no=ani.article_no','INNER');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id','000020');
		$this->db->where(''.'ani'.'.company_id', '000020');
		$this->db->where($table.'.rfd<>','0');
		$this->db->where($table.'.rfd_flag<>','1');
		//$this->db->order_by('coex_r_f_d.rfd_id desc ');
		$this->db->order_by('coex_r_f_d.aql_date desc ');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_records_released($limit,$start,$table,$company){
		$this->db->select($table.'.*,om.oc_date,od.print_type,am.name1,ani.lang_sub_description,ani.lang_article_description');
		$this->db->from($table);
		$this->db->join('order_master as om',$table.'.order_no=om.order_no','LEFT');
		$this->db->join('order_details as od',$table.'.order_no=od.order_no','INNER');
		$this->db->join('address_master as am','om'.'.customer_no=am.adr_company_id','INNER');
		$this->db->join('article_name_info as ani','od'.'.article_no=ani.article_no','INNER');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where(''.'ani'.'.company_id', '000020');
		$this->db->order_by('coex_r_f_d.aql_date desc ');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,om.oc_date,od.print_type,am.name1,ani.lang_sub_description,ani.lang_article_description');
		$this->db->from($table);
		$this->db->join('order_master as om',$table.'.order_no=om.order_no','LEFT');
		$this->db->join('order_details as od',$table.'.order_no=od.order_no','INNER');
		$this->db->join('address_master as am','om'.'.customer_no=am.adr_company_id','INNER');
		$this->db->join('article_name_info as ani','od'.'.article_no=ani.article_no','INNER');

		$this->db->where($table.'.company_id',$company);
		$this->db->where(''.'ani'.'.company_id', '000020');
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	 public function active_record_rfd_search($table,$company,$data,$from,$to){
		$this->db->select($table.'.*,om.oc_date,od.print_type,am.name1,ani.lang_sub_description,ani.lang_article_description');
	    $this->db->from($table);
	    $this->db->join('order_master as om',$table.'.order_no=om.order_no','LEFT');
	    $this->db->join('order_details as od',$table.'.order_no=od.order_no','INNER');
	    $this->db->join('address_master as am','om'.'.customer_no=am.adr_company_id','INNER');
	    $this->db->join('article_name_info as ani','od'.'.article_no=ani.article_no','INNER');
		
	
		$this->db->where($table.'.rfd<>','0');
        $this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id','000020');
		$this->db->where(''.'ani'.'.company_id', '000020');
		$this->db->order_by('coex_r_f_d.aql_date desc ');
		if($from!='' && $to!=''){
			$this->db->where('aql_date>=',$from);
			$this->db->where('aql_date<=',$to);
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


	public function select_active_records_report($table,$company){
		$this->db->select($table.'.*,om.oc_date,od.print_type,(od.total_order_quantity/100) as order_quantity,od.total_order_quantity,am.name1,ani.lang_sub_description,ani.lang_article_description');
		$this->db->from($table);
		$this->db->join('order_master as om',$table.'.order_no=om.order_no','LEFT');
		$this->db->join('order_details as od',$table.'.order_no=od.order_no','INNER');
		$this->db->join('address_master as am','om'.'.customer_no=am.adr_company_id','INNER');
		$this->db->join('article_name_info as ani','od'.'.article_no=ani.article_no','INNER');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id','000020');
		$this->db->where(''.'ani'.'.company_id', '000020');
		$this->db->where($table.'.rfd<>','0');
		$this->db->where($table.'.rfd_flag<>','1');
		//$this->db->order_by('coex_r_f_d.rfd_id desc ');
		$this->db->order_by('coex_r_f_d.aql_date desc ');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_records_rfd()
    {
        $db2 = $this->load->database("another_db", true);

        $sql = "select twerp.aql.order_no,neo.ar_invoice_details.ref_ord_no, neo.ar_invoice_details.arid_qty,neo.ar_invoice_details.ar_invoice_no,neo.ar_invoice_master.invoice_date 
		from twerp.aql 
		LEFT JOIN neo.ar_invoice_details on twerp.aql.order_no = neo.ar_invoice_details.ref_ord_no 
		LEFT JOIN neo.ar_invoice_master on neo.ar_invoice_details.ar_invoice_no = neo.ar_invoice_master.ar_invoice_no 
		WHERE neo.ar_invoice_master.invoice_date='2023-04-24' group by neo.ar_invoice_details.ref_ord_no";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function update_two_active_record($order_no){
	 $sql="UPDATE ar_invoice_details as t 
           LEFT JOIN ar_invoice_master as ap ON t.ar_invoice_no = ap.ar_invoice_no 
           SET t.rfd_flag = '1' 
           WHERE t.ref_ord_no ='$order_no' and ap.invoice_date='2023-04-24' and ap.company_id='000020'";

     $query=$this->db->query($sql);

	}

    public function select_active_records_sum_rfd($order_no)
    {

        $sql = "SELECT sum(rfd) as sum_rfd,order_no,aql_date,article_no,jobcard_no FROM `coex_r_f_d` WHERE `order_no`='$order_no' and `rfd_flag`='0'";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }



    

}

