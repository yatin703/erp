<?php
	$config['base_url']=base_url().'index.php/'.$this->uri->segment(1).'/'.$this->router->fetch_method();
	$this->db->select('*');
	$this->db->from($table);
	$this->db->where('company_id', $this->session->userdata['logged_in']['company_id']);
	$this->db->where('archive<>', '1');
	$this->db->where('trans_closed', '0');
	if($user_id!=''){
		$this->db->where('user_id', $user_id);
	}
	$this->db->where('order_date >=', $from);
	$this->db->where('order_date <=', $to);
	$config['total_rows']=$this->db->get()->num_rows();
	$config['per_page']=10;
	$config['num_links'] = 10;
	$config['next_link'] = 'Next';
	$config['prev_link'] = 'Previous';

	$this->pagination->initialize($config);
?>