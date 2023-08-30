<?php
	$config['base_url']=base_url().'index.php/'.$this->uri->segment(1).'/'.$this->router->fetch_method();
	$this->db->select($table.'.*');
	$this->db->from($table);
	$this->db->where($table.'.archive<>', '1');
	$this->db->where($table.'.company_id', $this->session->userdata['logged_in']['company_id']);
	//$this->db->where($table.'.release_qty<>','0');
	$this->db->order_by('coex_r_f_d.rfd_id desc');
	$config['total_rows']=$this->db->get()->num_rows();
	$config['per_page']=10;
	$config['num_links'] = 10;
	$config['next_link'] = 'Next';
	$config['prev_link'] = 'Previous';

	$this->pagination->initialize($config);
?>
