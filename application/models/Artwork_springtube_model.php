<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Artwork_springtube_model extends CI_Model {

	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
		$this->db->from($table);
		$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
		$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
		$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
		$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
		$this->db->where($table.'.archive<>', '1');
		$this->db->where($table.'.company_id',$company);
		$this->db->where('article_name_info.company_id',$company);
		$this->db->order_by('ad_date','desc');
		$this->db->order_by('CAST(replace(ad_id,"SAW","") as unsigned) DESC');
		$this->db->order_by('version_no','desc');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}


	public function select_details_record_where($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_artwork_final_version($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$col,$priority,$col2,$priority2,$col3,$priority3){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$this->db->where($pkey3,$edit3);
		$this->db->order_by($col,$priority);
		$this->db->order_by($col2,$priority2);
		$this->db->order_by($col3,$priority3);
		$this->db->limit(1,0);
		$query = $this->db->get();
		return $query->result();
	}


	public function select_artwork_version_no($table,$company,$pkey,$edit){
		$this->db->select('max(version_no)+1 as version_no,ad_id');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}


	public function select_archive_records($limit,$start,$table,$company){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where('article_name_info.company_id',$company);
			$this->db->order_by('ad_date','desc');
			$this->db->limit($limit, $start);
			$query = $this->db->get();
			return $result=$query->result();
		}


		public function select_one_active_record($table,$company,$pkey,$edit,$pkey2,$edit2){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive<>', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where('article_name_info.company_id',$company);
			$this->db->where($pkey,$edit);
			$this->db->where($pkey2,$edit2);
			$query = $this->db->get();
			return $result=$query->result();
		}

		public function select_one_inactive_record($table,$company,$pkey,$edit,$pkey2,$edit2){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where('article_name_info.company_id',$company);
			$this->db->where($pkey,$edit);
			$this->db->where($pkey2,$edit2);
			$query = $this->db->get();
			return $result=$query->result();
		}
		
		public function select_one_active_unapproved_record($table,$company,$pkey,$edit,$pkey2,$edit2){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive<>', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where($table.'.final_approval_flag<>','1');
			$this->db->where($table.'.pending_flag<>','1');
			$this->db->where('article_name_info.company_id',$company);
			$this->db->where($pkey,$edit);
			$this->db->where($pkey2,$edit2);
			$query = $this->db->get();
			return $result=$query->result();
		}

		public function update_one_active_record($table,$data,$pkey,$edit,$pkey2,$edit2,$company){
		$this->db->where($pkey, $edit);
		$this->db->where($pkey2, $edit2);
		$this->db->where('company_id', $company);
		$result=$this->db->update($table,$data);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}

	public function update_details_record_where($table,$data,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$company){
		$this->db->where($pkey, $edit);
		$this->db->where($pkey2, $edit2);
		$this->db->where($pkey3, $edit3);
		$this->db->where('company_id', $company);
		$result=$this->db->update($table,$data);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}


	public function active_record_search_1($table,$data,$from,$to,$company){
			$this->db->select($table.'.*,article_name_info.lang_article_description as article_name,article_name_info.lang_sub_description as article_sub_description,user_master.login_name as username,address_master.name1 as customer_name,a.login_name as approval_username');
			$this->db->from($table);
			$this->db->join('user_master',$table.'.user_id=user_master.user_id','LEFT');
			$this->db->join('user_master as a',$table.'.approved_by=a.user_id','LEFT');
			$this->db->join('article_name_info',$table.'.article_no=article_name_info.article_no','LEFT');
			$this->db->join('address_master',$table.'.adr_company_id=address_master.adr_company_id','LEFT');
			$this->db->where($table.'.archive<>', '1');
			$this->db->where($table.'.company_id',$company);
			$this->db->where('article_name_info.company_id',$company);
			foreach($data as $key => $value) {
			$this->db->like($key,$value);
		}
		if(!empty($from) && !empty($to)){
			$this->db->where(''.$table.'.ad_date >=', $from);
		$this->db->where(''.$table.'.ad_date <=', $to);
		}
		
		$this->db->order_by('ad_date','desc');
		$this->db->order_by('ad_id','desc');
		$this->db->order_by('version_no','desc');
		$query = $this->db->get();
		return $result=$query->result();

	}

	public function active_record_search($table,$data,$search,$from,$to,$company){
		$sql="";
		$sql.= "SELECT * FROM 
					( 	select 
							company_id,
							ad_id,
							version_no,
							ad_date,
							adr_company_id,
							article_no,
							final_approval_flag,
					   		approval_date,
					   		approved_by,
					   		user_id,
					   		archive,
					   		other_info,
					   		artwork_image_nm,
					   		pending_flag,
					   		customer_artwork_pdf 
					   	FROM  springtube_artwork_devel_master 
					 	WHERE archive <> 1 AND company_id='$company'";
					 	if(!empty($from) && !empty($to)){
					 		$sql.= "AND ad_date between '$from' AND '$to'";
					 	}
					 	if(!empty($data)){
							foreach($data as $key => $value) {
								$sql.=" AND ".$key."='".$value."'";
							}
	   					}
		    $sql.= ") A,
					( select 
						ad_id,
						version_no,
					    max(CASE WHEN artwork_para_id=1 THEN parameter_value END) as sleeve_dia,
						max(CASE WHEN artwork_para_id=2 THEN parameter_value END) as sleeve_length,
						max(CASE WHEN artwork_para_id=3 THEN parameter_value END) as laminate_color,	
						max(CASE WHEN artwork_para_id=4 THEN parameter_value END)as cold_foil_1,
						max(CASE WHEN artwork_para_id=5 THEN parameter_value END) as cold_foil_1_area,						
						max(CASE WHEN artwork_para_id=6 THEN parameter_value END)as cold_foil_2,
						max(CASE WHEN artwork_para_id=7 THEN parameter_value END)as cold_foil_2_area,						
						max(CASE WHEN artwork_para_id=8 THEN parameter_value END)as pre_lacquer_1,
						max(CASE WHEN artwork_para_id=9 THEN parameter_value END)as pre_lacquer_1_perc,
						max(CASE WHEN artwork_para_id=10 THEN parameter_value END)as pre_lacquer_2,
						max(CASE WHEN artwork_para_id=11 THEN parameter_value END)as pre_lacquer_2_perc,
						max(CASE WHEN artwork_para_id=12 THEN parameter_value END)as post_lacquer_1,
						max(CASE WHEN artwork_para_id=13 THEN parameter_value END)as post_lacquer_1_perc,
						max(CASE WHEN artwork_para_id=14 THEN parameter_value END)as post_lacquer_2,
						max(CASE WHEN artwork_para_id=15 THEN parameter_value END)as post_lacquer_2_perc,
						max(CASE WHEN artwork_para_id=16 THEN parameter_value END)as non_lacquer_length,
						max(CASE WHEN artwork_para_id=17 THEN parameter_value END)as body_making_type,						
						max(CASE WHEN artwork_para_id=18 THEN parameter_value END)as print_type,
						max(CASE WHEN artwork_para_id=19 THEN parameter_value END)as cold_foil_1_length,
						max(CASE WHEN artwork_para_id=20 THEN parameter_value END)as cold_foil_1_width,
						max(CASE WHEN artwork_para_id=21 THEN parameter_value END)as cold_foil_2_length,
						max(CASE WHEN artwork_para_id=22 THEN parameter_value END)as cold_foil_2_width
					  FROM  springtube_artwork_devel_details
					  GROUP BY ad_id,version_no
					) D
				WHERE A.ad_id=D.ad_id
				AND A.version_no=D.version_no";
				if(!empty($search)){

					foreach($search as $key => $value) {
						
							if($key=='sleeve_dia'){
							 $value=rtrim(str_replace("MM","",$value));
							 $sql.=" AND ".$key." = '".$value."'";
							}
							else{
								$sql.=" AND ".$key." like '".$value."%'";
							}					    
						
						
					}
			    }
       
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		return $result=$query->result();


	}

	public function active_record_search_new($table,$data,$search,$from,$to,$company){
		$sql="";
		$sql.= "SELECT * FROM 
					( 	select 
							company_id,
							ad_id,
							version_no,
							ad_date,
							adr_company_id,
							article_no,
							final_approval_flag,
					   		approval_date,
					   		approved_by,
					   		user_id,
					   		archive,
					   		other_info,
					   		artwork_image_nm,
					   		pending_flag ,
					   		customer_artwork_pdf
					   	FROM  springtube_artwork_devel_master 
					 	WHERE archive <> 1 AND company_id='$company'";
					 	if(!empty($from) && !empty($to)){
					 		$sql.= "AND ad_date between '$from' AND '$to'";
					 	}
					 	if(!empty($data)){
							foreach($data as $key => $value) {
								$sql.=" AND ".$key."='".$value."'";
							}
	   					}
		    $sql.= ") A,
					( select 
						ad_id,
						version_no,
					    max(CASE WHEN artwork_para_id=1 THEN parameter_value END) as sleeve_dia,
						max(CASE WHEN artwork_para_id=2 THEN parameter_value END) as sleeve_length,
						max(CASE WHEN artwork_para_id=3 THEN parameter_value END) as laminate_color,						
						max(CASE WHEN artwork_para_id=4 THEN parameter_value END)as cold_foil_1,
						max(CASE WHEN artwork_para_id=5 THEN parameter_value END) as cold_foil_1_perc,						
						max(CASE WHEN artwork_para_id=6 THEN parameter_value END)as cold_foil_2,
						max(CASE WHEN artwork_para_id=7 THEN parameter_value END)as cold_foil_2_perc,						
						max(CASE WHEN artwork_para_id=8 THEN parameter_value END)as pre_lacquer_1,
						max(CASE WHEN artwork_para_id=9 THEN parameter_value END)as pre_lacquer_1_perc,
						max(CASE WHEN artwork_para_id=10 THEN parameter_value END)as pre_lacquer_2,
						max(CASE WHEN artwork_para_id=11 THEN parameter_value END)as pre_lacquer_2_perc,
						max(CASE WHEN artwork_para_id=12 THEN parameter_value END)as post_lacquer_1,
						max(CASE WHEN artwork_para_id=13 THEN parameter_value END)as post_lacquer_1_perc,
						max(CASE WHEN artwork_para_id=14 THEN parameter_value END)as post_lacquer_2,
						max(CASE WHEN artwork_para_id=15 THEN parameter_value END)as post_lacquer_2_perc,
						max(CASE WHEN artwork_para_id=16 THEN parameter_value END)as non_lacquer_length,
						max(CASE WHEN artwork_para_id=17 THEN parameter_value END)as body_making_type,
						max(CASE WHEN artwork_para_id=18 THEN parameter_value END)as print_type,
						max(CASE WHEN artwork_para_id=19 THEN parameter_value END)as cold_foil_1_length,
						max(CASE WHEN artwork_para_id=20 THEN parameter_value END)as cold_foil_1_width,
						max(CASE WHEN artwork_para_id=21 THEN parameter_value END)as cold_foil_2_length,
						max(CASE WHEN artwork_para_id=22 THEN parameter_value END)as cold_foil_2_width

					  FROM  springtube_artwork_devel_details
					  WHERE company_id='000020'
					  GROUP BY ad_id,version_no
					) D
				WHERE A.ad_id=D.ad_id
				AND A.version_no=D.version_no";
				if(!empty($search)){

					foreach($search as $key => $value) {
						
							if($key=='sleeve_dia'){
							 //$value=rtrim(str_replace("MM","",$value));
							 $sql.=" AND ".$key." = '".$value."'";
							}							
							else{
								$sql.=" AND ".$key." like '".$value."%'";
							}					    
						
						
					}
			    }
       
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		return $result=$query->result();


	}

public function select_details_record_print($ad_id,$version_no){
     $resultdata = array();
     $query = $this->db->query("SELECT am.*, ad.version_no,users.login_name as user_name, 
		MAX(CASE WHEN ad.artwork_para_id='1' THEN ad.parameter_value END) AS 'ARTWORK_PARA_1',
		MAX(CASE WHEN ad.artwork_para_id='2' THEN ad.parameter_value END) AS 'ARTWORK_PARA_2',
		MAX(CASE WHEN ad.artwork_para_id='3' THEN ad.parameter_value END) AS 'ARTWORK_PARA_3',
		MAX(CASE WHEN ad.artwork_para_id='4' THEN ad.parameter_value END) AS 'ARTWORK_PARA_4',
		MAX(CASE WHEN ad.artwork_para_id='5' THEN ad.parameter_value END) AS 'ARTWORK_PARA_5',
		MAX(CASE WHEN ad.artwork_para_id='6' THEN ad.parameter_value END) AS 'ARTWORK_PARA_6',
		MAX(CASE WHEN ad.artwork_para_id='7' THEN ad.parameter_value END) AS 'ARTWORK_PARA_7',
		MAX(CASE WHEN ad.artwork_para_id='8' THEN ad.parameter_value END) AS 'ARTWORK_PARA_8',
		MAX(CASE WHEN ad.artwork_para_id='9' THEN ad.parameter_value END) AS 'ARTWORK_PARA_9',
		MAX(CASE WHEN ad.artwork_para_id='10' THEN ad.parameter_value END) AS 'ARTWORK_PARA_10',
		MAX(CASE WHEN ad.artwork_para_id='11' THEN ad.parameter_value END) AS 'ARTWORK_PARA_11',
		MAX(CASE WHEN ad.artwork_para_id='12' THEN ad.parameter_value END) AS 'ARTWORK_PARA_12',
		MAX(CASE WHEN ad.artwork_para_id='13' THEN ad.parameter_value END) AS 'ARTWORK_PARA_13',
		MAX(CASE WHEN ad.artwork_para_id='14' THEN ad.parameter_value END) AS 'ARTWORK_PARA_14',
		MAX(CASE WHEN ad.artwork_para_id='15' THEN ad.parameter_value END) AS 'ARTWORK_PARA_15',
		MAX(CASE WHEN ad.artwork_para_id='16' THEN ad.parameter_value END) AS 'ARTWORK_PARA_16',
		MAX(CASE WHEN ad.artwork_para_id='17' THEN ad.parameter_value END) AS 'ARTWORK_PARA_17',
		MAX(CASE WHEN ad.artwork_para_id='18' THEN ad.parameter_value END) AS 'ARTWORK_PARA_18',
		MAX(CASE WHEN ad.artwork_para_id='19' THEN ad.parameter_value END) AS 'ARTWORK_PARA_19',
		MAX(CASE WHEN ad.artwork_para_id='20' THEN ad.parameter_value END) AS 'ARTWORK_PARA_20',
		MAX(CASE WHEN ad.artwork_para_id='21' THEN ad.parameter_value END) AS 'ARTWORK_PARA_21',
		MAX(CASE WHEN ad.artwork_para_id='22' THEN ad.parameter_value END) AS 'ARTWORK_PARA_22',
		MAX(CASE WHEN ad.artwork_para_id='23' THEN ad.parameter_value END) AS 'ARTWORK_PARA_23',
		MAX(CASE WHEN ad.artwork_para_id='24' THEN ad.parameter_value END) AS 'ARTWORK_PARA_24',
		MAX(CASE WHEN ad.artwork_para_id='25' THEN ad.parameter_value END) AS 'ARTWORK_PARA_25',
		MAX(CASE WHEN ad.artwork_para_id='26' THEN ad.parameter_value END) AS 'ARTWORK_PARA_26',
		MAX(CASE WHEN ad.artwork_para_id='27' THEN ad.parameter_value END) AS 'ARTWORK_PARA_27',
		MAX(CASE WHEN ad.artwork_para_id='28' THEN ad.parameter_value END) AS 'ARTWORK_PARA_28',
		MAX(CASE WHEN ad.artwork_para_id='29' THEN ad.parameter_value END) AS 'ARTWORK_PARA_29',
		MAX(CASE WHEN ad.artwork_para_id='30' THEN ad.parameter_value END) AS 'ARTWORK_PARA_30'
        FROM springtube_artwork_devel_master as am 
        LEFT JOIN springtube_artwork_devel_details as ad ON am.ad_id =ad.ad_id AND am.version_no = ad.version_no 
        LEFT JOIN user_master as users ON am.user_id = users.user_id
        WHERE am.ad_id='$ad_id' and am.version_no='$version_no';");
 
    if(!empty($query)){   
      $item=$query->row_array();   
      $customer_name=$this->common_model->get_customer_name($item['adr_company_id'],$this->session->userdata['logged_in']['company_id']);
      $article_name=$this->common_model->get_article_name($item['article_no'],$this->session->userdata['logged_in']['company_id']);
      $ARTWORK_PARA_8=$this->common_model->get_article_name($item['ARTWORK_PARA_8'],$this->session->userdata['logged_in']['company_id']);
      $ARTWORK_PARA_10=$this->common_model->get_article_name($item['ARTWORK_PARA_10'],$this->session->userdata['logged_in']['company_id']);
      $ARTWORK_PARA_12=$this->common_model->get_article_name($item['ARTWORK_PARA_12'],$this->session->userdata['logged_in']['company_id']);
      $ARTWORK_PARA_14=$this->common_model->get_article_name($item['ARTWORK_PARA_14'],$this->session->userdata['logged_in']['company_id']);
      
      $img_url = base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork_springtube/'.$item['artwork_image_nm']);
      if($img_url!=''){
      	$artwork_image_nm='<a href="'.$img_url.'" target="_blank">File</a>';
      }else{
      	$artwork_image_nm='-';
      }

      $pdf_url = base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork_springtube/'.$item['customer_artwork_pdf']);
      if($pdf_url!=''){
      	$customer_artwork_pdf='<a href="'.$pdf_url.'" target="_blank">File</a>';
      }else{
      	$customer_artwork_pdf='-';
      }

      if($item['ARTWORK_PARA_16']!='0'){
         $ARTWORK_PARA_16 = 'FULL VARNISH';
      }else{
      	$ARTWORK_PARA_16 = '-';
      }





      $resultdata = array(  
        "ad_id"                => $item['ad_id'] != null ? $item['ad_id'] : '-',
        "version_no"           => $item['version_no'] != null ? $item['version_no'] : '-',
        "sleeve_type"          => $item['ad_date'] != null ? $item['sleeve_type'] : '-',
        "ad_date"              => $item['ad_date'] != null ? $item['ad_date'] : '-',
        "adr_company_id"       => $item['adr_company_id'] != null ? $item['adr_company_id'] : '-',
        "customer_name"        => $customer_name,
        "article_name"         => $article_name,
        "article_no"           => $item['article_no'] != null ? $item['article_no'] : '-',
        "user_name"            => $item['user_name'] != null ? $item['user_name'] : '-',
        "mat_sent_date"        => $item['mat_sent_date'] != null ? $item['mat_sent_date'] : '-',
        "CAD_program"          => $item['CAD_program'] != null ? $item['CAD_program'] : '-',
        "mat_sent_net"         => $item['mat_sent_net'] != null ? $item['mat_sent_net'] : '-',
        "mat_sent_cd"          => $item['mat_sent_cd'] != null ? $item['mat_sent_cd'] : '-',
        "cd_ref"               => $item['cd_ref'] != null ? $item['cd_ref'] : '-',
        "mat_sent_courier"     => $item['mat_sent_courier'] != null ? $item['mat_sent_courier'] : '-',
        "courier_ref"          => $item['courier_ref'] != null ? $item['courier_ref'] : '-',
        "property_id"          => $item['property_id'] != null ? $item['property_id'] : '-',
        "customer_artwork_pdf" => $customer_artwork_pdf ,
        "artwork_image_nm"     => $artwork_image_nm,
        "customer_article_no"  => $item['customer_article_no'] != null ? $item['customer_article_no'] : '-',
        "ARTWORK_PARA_1"       => $item['ARTWORK_PARA_1'] != null ? $item['ARTWORK_PARA_1'] : '-',
	   "ARTWORK_PARA_2"       => $item['ARTWORK_PARA_2'] != null ? $item['ARTWORK_PARA_2'] : '-',
	   "ARTWORK_PARA_3"       => $item['ARTWORK_PARA_3'] != null ? $item['ARTWORK_PARA_3'] : '-',
	   "ARTWORK_PARA_4"       => $item['ARTWORK_PARA_4'] != null ? $item['ARTWORK_PARA_4'] : '-',
	   "ARTWORK_PARA_5"       => $item['ARTWORK_PARA_5'] != null ? $item['ARTWORK_PARA_5'] : '-',
	   "ARTWORK_PARA_6"       => $item['ARTWORK_PARA_6'] != null ? $item['ARTWORK_PARA_6'] : '-',
	   "ARTWORK_PARA_7"       => $item['ARTWORK_PARA_7'] != null ? $item['ARTWORK_PARA_7'] : '-',
	   "ARTWORK_PARA_8"       => $ARTWORK_PARA_8 != null ? $ARTWORK_PARA_8 : '-',
	   "ARTWORK_PARA_9"       => $item['ARTWORK_PARA_9'] != null ? $item['ARTWORK_PARA_9'] : '-',
	   "ARTWORK_PARA_10"      => $ARTWORK_PARA_10 != null ? $ARTWORK_PARA_10 : '-',
	   "ARTWORK_PARA_11"      => $item['ARTWORK_PARA_11'] != null ? $item['ARTWORK_PARA_11'] : '-',
	   "ARTWORK_PARA_12"      => $ARTWORK_PARA_12 != null ? $ARTWORK_PARA_12 : '-',
	   "ARTWORK_PARA_13"      => $item['ARTWORK_PARA_13'] != null ? $item['ARTWORK_PARA_13'] : '-',
	   "ARTWORK_PARA_14"      => $ARTWORK_PARA_14 != null ? $ARTWORK_PARA_14 : '-',
	   "ARTWORK_PARA_15"      => $item['ARTWORK_PARA_15'] != null ? $item['ARTWORK_PARA_15'] : '-',
	   "ARTWORK_PARA_16"      => $item['ARTWORK_PARA_16']!='0'? $item['ARTWORK_PARA_16'].'MM':'FULL VARNISH',
	   "ARTWORK_PARA_17"      => $item['ARTWORK_PARA_17'] != null ? $item['ARTWORK_PARA_17'] : '-',
	   "ARTWORK_PARA_18"      => $item['ARTWORK_PARA_18'] != null ? $item['ARTWORK_PARA_18'] : '-',
	   "ARTWORK_PARA_19"      => $item['ARTWORK_PARA_19'] != null ? $item['ARTWORK_PARA_19'] : '-',
	   "ARTWORK_PARA_20"      => $item['ARTWORK_PARA_20'] != null ? $item['ARTWORK_PARA_20'] : '-',
	   "ARTWORK_PARA_21"      => $item['ARTWORK_PARA_21'] != null ? $item['ARTWORK_PARA_21'] : '-',
	   "ARTWORK_PARA_22"      => $item['ARTWORK_PARA_22'] != null ? $item['ARTWORK_PARA_22'] : '-',
	   "ARTWORK_PARA_23"      => $item['ARTWORK_PARA_23'] != null ? $item['ARTWORK_PARA_23'] : '-',
	   "ARTWORK_PARA_24"      => $item['ARTWORK_PARA_24'] != null ? $item['ARTWORK_PARA_24'] : '-',
	   "ARTWORK_PARA_25"      => $item['ARTWORK_PARA_25'] != null ? $item['ARTWORK_PARA_25'] : '-',
	   "ARTWORK_PARA_26"      => $item['ARTWORK_PARA_26'] != null ? $item['ARTWORK_PARA_26'] : '-',
	   "ARTWORK_PARA_27"      => $item['ARTWORK_PARA_27'] != null ? $item['ARTWORK_PARA_27'] : '-',
	   "ARTWORK_PARA_28"      => $item['ARTWORK_PARA_28'] != null ? $item['ARTWORK_PARA_28'] : '-',
	   "ARTWORK_PARA_29"      => $item['ARTWORK_PARA_29'] != null ? $item['ARTWORK_PARA_29'] : '-',
	   "ARTWORK_PARA_30"      => $item['ARTWORK_PARA_30'] != null ? $item['ARTWORK_PARA_30'] : '-',
	   "foil_one"             =>($item['ARTWORK_PARA_19']!=''? $item['ARTWORK_PARA_19'].' MM':'').($item['ARTWORK_PARA_20']!=''?' X '.$item['ARTWORK_PARA_20'].' MM':''),
	   "foil_two"             =>($item['ARTWORK_PARA_21']!=''? $item['ARTWORK_PARA_21'].' MM':'').($item['ARTWORK_PARA_22']!=''?' X '.$item['ARTWORK_PARA_22'].' MM':'')
      );
    }
    //print_r($resultdata);
    return $resultdata;
}
	


		

}

?>