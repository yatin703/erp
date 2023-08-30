<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_grid_model extends CI_Model {

	public function select_sales_tax_active_drop_down($table,$company){
		$this->db->select($table.'.*,tax_grid_master_lang.lang_tax_grid_desc as tax_grid_name');
		$this->db->from($table);
		$this->db->join('tax_grid_master_lang',$table.'.tax_id=tax_grid_master_lang.tax_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.sales_purchase_flag<>', '1');
		$this->db->where($table.'.company_id',$company);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_sales_order_tax_grid($order_no){
		$query=$this->db->query("SELECT O.order_no, O.order_date, OD.tax_pos_no,C.tax_code,D.tax_name,D.tax_rate,C.tax_code,E.lang_tax_grid_desc,F.lang_tax_code_desc FROM order_master O INNER JOIN order_details OD ON O.order_no = OD.order_no INNER JOIN tax_grid_details C ON OD.tax_pos_no=C.tax_id
		INNER JOIN tax_master D ON D.tax_code=C.tax_code
		INNER JOIN tax_master_lang F ON F.tax_code=C.tax_code
		INNER JOIN tax_grid_master_lang E ON OD.tax_pos_no=E.tax_id
		WHERE O.order_no='$order_no' group by C.tax_code order by C.priority");
		return $result=$query->result();
	}
	public function select_sales_invoice_tax_grid($ar_invoice_no){
		$query=$this->db->query("SELECT O.ar_invoice_no, O.invoice_date, OD.tax_pos_no,C.tax_code,D.tax_name,D.tax_rate,C.tax_code,E.lang_tax_grid_desc,F.lang_tax_code_desc FROM ar_invoice_master O INNER JOIN ar_invoice_details OD ON O.ar_invoice_no = OD.ar_invoice_no INNER JOIN tax_grid_details C ON OD.tax_pos_no=C.tax_id
		INNER JOIN tax_master D ON D.tax_code=C.tax_code
		INNER JOIN tax_master_lang F ON F.tax_code=C.tax_code
		INNER JOIN tax_grid_master_lang E ON OD.tax_pos_no=E.tax_id
		WHERE O.ar_invoice_no='$ar_invoice_no' group by C.tax_code order by C.priority");
		return $result=$query->result();
	}

	public function select_purchase_tax_active_drop_down($table,$company){
		$this->db->select($table.'.*,tax_grid_master_lang.lang_tax_grid_desc as tax_grid_name');
		$this->db->from($table);
		$this->db->join('tax_grid_master_lang',$table.'.tax_id=tax_grid_master_lang.tax_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.sales_purchase_flag<>', '2');
		$this->db->where($table.'.company_id',$company);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_purchase_order_tax_grid($po_no){
		$query=$this->db->query("SELECT O.po_no, O.po_date, OD.tax_pos_no,C.tax_code,D.tax_name,D.tax_rate,C.tax_code,E.lang_tax_grid_desc,F.lang_tax_code_desc FROM purchase_order_master O INNER JOIN purchase_order_details OD ON O.po_no = OD.po_no INNER JOIN tax_grid_details C ON OD.tax_pos_no=C.tax_id
		INNER JOIN tax_master D ON D.tax_code=C.tax_code
		INNER JOIN tax_master_lang F ON F.tax_code=C.tax_code
		INNER JOIN tax_grid_master_lang E ON OD.tax_pos_no=E.tax_id
		WHERE O.po_no='$po_no' group by C.tax_code order by C.priority");
		return $result=$query->result();
	}



}