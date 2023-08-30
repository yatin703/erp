<?php
	$config['base_url']=base_url().'index.php/'.$this->uri->segment(1).'/'.$this->router->fetch_method();
	$this->db->select($table.'.*,coex_machine_master.machine_name,springtube_shift_master.shift_name');
	$this->db->from($table);
	$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','RIGHT');
	$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','RIGHT');
	$this->db->where($table.'.archive<>', '1');
	$this->db->where($table.'.company_id',$this->session->userdata['logged_in']['company_id']);
    $this->db->where($table.'.scrap_by_qc<>','0');
	$this->db->order_by($table.'.ce_scrap_id','desc');
	$config['total_rows']=$this->db->get()->num_rows();
	$config['per_page']=10;
	$config['num_links'] = 10;
	$config['next_link'] = 'Next';
	$config['prev_link'] = 'Previous';

	$this->pagination->initialize($config);
?>