<?php
	$config['base_url']=base_url().'index.php/'.$this->uri->segment(1).'/'.$this->router->fetch_method();
	$this->db->select($table.'.*, coex_machine_master.machine_name,springtube_shift_master.shift_name');
	$this->db->from($table);
	$this->db->join('coex_machine_master',$table.'.machine_id=coex_machine_master.machine_id','LEFT');
	$this->db->join('springtube_shift_master',$table.'.shift_id=springtube_shift_master.shift_id','LEFT');
	$this->db->join('coex_extrusion_qc',$table.'.cewip_id=coex_extrusion_qc.qc_id','LEFT');
	$this->db->where($table.'.archive<>', '1');
	$this->db->where($table.'.ok_by_qc<>','0');
	$this->db->where('coex_extrusion_qc'.'.flag=','0');
	$config['total_rows']=$this->db->get()->num_rows();
	$config['per_page']=10;
	$config['num_links'] = 10;
	$config['next_link'] = 'Next';
	$config['prev_link'] = 'Previous';

	$this->pagination->initialize($config);
?>