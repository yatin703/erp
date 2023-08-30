<?php
	$config['base_url']=base_url().'index.php/'.$this->uri->segment(1).'/'.$this->router->fetch_method();
	$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name,specification_sheet.dyn_qty_present');
	$this->db->from($table);
	$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
	$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
	$this->db->join('order_details',$table.'.order_no=order_details.order_no','LEFT');
    $this->db->join('bill_of_material','order_details.spec_id=bill_of_material.bom_no AND order_details.spec_version_no = bill_of_material.bom_version_no' ,'LEFT');
    $this->db->join('specification_sheet','bill_of_material.sleeve_code=specification_sheet.article_no','LEFT');
	$this->db->where($table.'.archive<>', '1');
	//$this->db->where($table.'.company_id',$company);
	$this->db->where($table.'.scrap_by_qc<>','0');
	$this->db->order_by($table.'.ce_scrap_id','desc');
	$config['total_rows']=$this->db->get()->num_rows();
	$config['per_page']=10;
	$config['num_links'] = 10;
	$config['next_link'] = 'Next';
	$config['prev_link'] = 'Previous';

	$this->pagination->initialize($config);
?>