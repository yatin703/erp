<?php
	$config['base_url']=base_url().'index.php/'.$this->uri->segment(1).'/'.$this->router->fetch_method();
	$this->db->select('cew.cewip_id,ceq.extrusion_date,cew.diameter,cew.length,cew.sleeve_weight_gm,cew.article_no,cew.order_no,cew.jobcard_no,sum(cew.ok_by_qc) as total_qty, cew.next_process_print,cew.jobcard_issue,cew.created_date,ceq.hold_by_qc,cmm.machine_name,ssm.shift_name ');
	$this->db->from('coex_extrusion_wip as cew');
	$this->db->join('coex_machine_master as cmm','cew'.'.machine_id=cmm.machine_id','LEFT');
	$this->db->join('springtube_shift_master as ssm','cew'.'.shift_id=ssm.shift_id','LEFT');
	$this->db->join('coex_extrusion_qc as ceq','cew'.'.jobcard_no=ceq.jobcard_no','LEFT');
	$this->db->where('ceq'.'.flag=','0');
	$this->db->group_by('ceq'.'.jobcard_no');
	$config['total_rows']=$this->db->get()->num_rows();
	$config['per_page']=10;
	$config['num_links'] = 10;
	$config['next_link'] = 'Next';
	$config['prev_link'] = 'Previous';

	$this->pagination->initialize($config);
?>