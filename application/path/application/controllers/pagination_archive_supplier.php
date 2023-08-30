<?php
	$config['base_url']=base_url().'index.php/'.$this->uri->segment(1).'/'.$this->router->fetch_method();
	$this->db->select('*');
	$this->db->from($table);
	$this->db->join('address_details',$table.'.adr_company_id=address_details.adr_company_id','LEFT');
	$this->db->where($table.'.company_id', $this->session->userdata['logged_in']['company_id']);
	$this->db->where($table.'.archive', '1');
	$this->db->where('address_details.master_property_id','2');
	$config['total_rows']=$this->db->get()->num_rows();
	$config['per_page']=15;
	$config['num_links'] = 10;
	$config['next_link'] = 'Next';
	$config['prev_link'] = 'Previous';

	$this->pagination->initialize($config);
?>