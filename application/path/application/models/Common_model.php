<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_Model {

	
	public function save($table,$data){
		$result=$this->db->insert($table,$data);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}

	public function save_return_pkey($table,$data){
		$this->db->insert($table,$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}


//Drop Down function ---Company & Non Company

//Start


	public function select_active_drop_down_noncompany_nonarchive($table){
		$this->db->select('*');
		$this->db->from($table);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_active_drop_down_noncompany($table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('archive<>','1');
		$query = $this->db->get();
		return $query->result();
	}

	public function select_active_drop_down($table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('archive<>','1');
		$query = $this->db->get();
		return $query->result();
	}

	public function select_active_distinct_drop_down($table,$column,$company){
		$this->db->select('distinct('.$table.'.'.$column.')');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('archive<>','1');
		$query = $this->db->get();
		return $query->result();
	}

	public function select_active_drop_down_noncompany_withlanguage($table,$language){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('archive<>','1');
		$this->db->where('language_id',$language);
		$query = $this->db->get();
		return $query->result();
	}



//End


	public function select_active_module($user,$company){
	  $this->db->select('distinct(formrights_master.module_id),mm.module_name');
	  $this->db->from('formrights_master');
	  $this->db->join('module_master as mm','mm.module_id=formrights_master.module_id');
	  $this->db->where('formrights_master.company_id', $company);
	  $this->db->where('formrights_master.archive<>', '1');
	  $this->db->where('formrights_master.user_id', $user);
	  $query = $this->db->get();
	  return $result=$query->result();
 	}

public function select_assign_forms($user,$company,$module){
		$this->db->select('formrights_master.*,fm.form_name,fm.file_name,fm.icon');
		$this->db->from('formrights_master');
		$this->db->join('form_master as fm','fm.form_id=formrights_master.form_id');
		$this->db->where('formrights_master.company_id', $company);
		$this->db->where('formrights_master.archive<>', '1');
		$this->db->where('formrights_master.user_id', $user);
		$this->db->where('formrights_master.module_id', $module);
		$this->db->order_by('fm.form_name asc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	//Select form_rights of that form
	public function select_active_formrights_of_form($user,$company,$module,$file){
		$this->db->select('formrights_master.*,fm.form_name,fm.file_name');
		$this->db->from('formrights_master');
		$this->db->join('form_master as fm','fm.form_id=formrights_master.form_id');
		$this->db->where('formrights_master.company_id', $company);
		$this->db->where('formrights_master.archive<>', '1');
		$this->db->where('formrights_master.user_id', $user);
		$this->db->where('formrights_master.module_id', $module);
		$this->db->where('fm.file_name', $file);
		$query = $this->db->get();
		return $result=$query->result();
	}

//SELECT ACTIVE RECORDS function ---Company & Non Company

//Start

 	public function select_active_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('archive<>', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_records_noncompany($limit,$start,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('archive<>', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_records_tally($limit,$start,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('transaction_date','DESC');		
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

//End	


//SELECT ARCHIVE RECORDS function ---Company & Non Company

//Start

 	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('archive', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_archive_records_noncompany($limit,$start,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('archive', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

//End	



//ACTIVE Record Count Function---Company & Non Company

//Start

	public function active_record_count($table,$company){
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		$this->db->from($table);
		$count = $this->db->count_all_results();
		return $count;
		
	}

	public function active_record_count_where_pkey($table,$company,$pkey,$edit){
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		$this->db->where($pkey,$edit);
		$this->db->from($table);
		$count = $this->db->count_all_results();
		return $count;
		
	}

	public function table_record_count_where_pkey($table,$company,$pkey,$edit){
		//$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		$this->db->where($pkey,$edit);
		$this->db->from($table);
		$count = $this->db->count_all_results();
		return $count;
		
	}

	

	public function active_record_count_where($table,$company,$pkey,$key,$pkey2,$key2,$pkey3,$key3){
		$this->db->where('company_id',$company);
		$this->db->where($pkey,$key);
		$this->db->where($pkey2,$key2);
		$this->db->where($pkey3,$key3);
		$this->db->from($table);
		$count = $this->db->count_all_results();
		return $count;
	}

	public function active_record_count_noncompany($table){
		$this->db->where('archive<>','1');
		$this->db->from($table);
		$count = $this->db->count_all_results();
		return $count;
	}


//for Article code creation
public function article_no_generation($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey, $edit);
		$this->db->where($pkey2, $edit2);
		$this->db->where($pkey3, $edit3);
		//$this->db->where($pkey4, $edit4);
		$query = $this->db->get();
		return $query->result();
	}

	public function article_no_generationn($table,$company,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$pkey4,$edit4){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey, $edit);
		$this->db->where($pkey2, $edit2);
		$this->db->where($pkey3, $edit3);
		$this->db->where($pkey4, $edit4);
		$query = $this->db->get();
		return $query->result();
	}



	public function select_one_active_approval_authority_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,user_master.login_name as username');
		$this->db->from($table);
		$this->db->join('user_master',$table.'.employee_id=user_master.user_id','LEFT');
		$this->db->where($table.'.company_id',$company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	
//End

//SELECT  One Active Record Function---Company & Non Company

//Start

	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('archive<>', '1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_record_with_company($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);		
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	//Followup Records


	public function select_followup_records($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,t.login_name as to_user,f.login_name as from_user');
		$this->db->from($table);
		$this->db->join('user_master as t',$table.'.user_id=t.user_id','LEFT');
		$this->db->join('user_master as f',$table.'.contact_person_id=f.user_id','LEFT');
		$this->db->where($table.'.company_id', $company);
		$this->db->where($table.'.'.$pkey, $edit);
		$this->db->order_by('followup.followup_date asc,followup.transaction_no asc');
		$query = $this->db->get();
		return $query->result();
	}

//Artwork Records
	

	public function select_one_active_record_noncompany($table,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('archive<>', '1');
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_active_record_nonlanguage_without_archive($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_active_record_nonlanguage_without_archives($table,$company,$data){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }

		$query = $this->db->get();
		return $query->result();
	}
	
	public function select_one_active_record_nonlanguage_without_archives_jobcard_view($table,$company,$data){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('article',$table.'.article_no=article.article_no','LEFT');
		$this->db->where($table.'.company_id', $company);
		$this->db->where('article.company_id', $company);
		$this->db->where('article.archive','0');
		$this->db->where_not_in ('article.main_group_id','5');

		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }

		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_active_record_nonlanguage_without_archives_order_by($table,$company,$data,$group_by,$order_by){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where(''.$table.'.'.$key.'', $value);
			}
	    }

	    if(!empty($group_by)){
				$this->db->group_by($group_by);
			
	    }

	    if(!empty($order_by)){
				$this->db->order_by('CAST('.$table.'.'.$order_by.' as unsigned)','asc');
			
	    }	    

		$query = $this->db->get();
		return $query->result();
	}

	public function select_one_details_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}
	public function select_one_details_record_noncompany($table,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_updated_currency_rate($table,$pkey,$edit,$order_by,$priority){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($pkey, $edit);
		$this->db->order_by($order_by,$priority);
		$query = $this->db->get();
		return $query->result();
	}

//END


public function delete_one_active_record($table,$pkey,$edit,$company){
		$this->db->where($pkey, $edit);
		$this->db->where('company_id', $company);
		$result=$this->db->delete($table);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
}

public function delete_one_active_record_noncompany($table,$pkey,$edit){
		$this->db->where($pkey, $edit);
		//$this->db->where('company_id', $company);
		$result=$this->db->delete($table);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
}


//Update One Active Record Function---Company & Non Company

//Start

	public function update_one_active_record($table,$data,$pkey,$edit,$company){
		$this->db->where($pkey, $edit);
		$this->db->where('company_id', $company);
		$result=$this->db->update($table,$data);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}


	public function update_one_active_record_where($table,$data,$pkey,$edit,$pkey2,$edit2,$company){
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

	public function update_one_active_record_where_where($table,$data,$pkey,$edit,$pkey2,$edit2,$pkey3,$edit3,$company){
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

	public function update_one_active_record_noncompany($table,$data,$pkey,$edit){
		$this->db->where($pkey, $edit);
		$result=$this->db->update($table,$data);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}


//End




//Update One Inactive Record Function---Company & Non Company

	//Start

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('archive', '1');
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function select_one_inactive_record_noncompany($table,$pkey,$edit){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('archive', '1');
		$this->db->where($pkey, $edit);
		$query = $this->db->get();
		return $query->result();
	}


//END


//ACTIVE Record SEARCH Function---Company & Non Company

//Start
	public function active_record_search($table,$data,$company){
		$this->db->select('*');
		$this->db->from($table);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->like($key,$value);
			}
		}	
		$this->db->where('archive<>','1');
		$this->db->where('company_id',$company);
		$query = $this->db->get();
		return $result=$query->result();
	}


	public function active_record_search_noncompany($table,$data){
		$this->db->select('*');
		$this->db->from($table);
		foreach($data as $key => $value) {
			$this->db->like($key,$value,'after');
		}
		$this->db->where('archive<>','1');
		$query = $this->db->get();
		return $result=$query->result();
	}


//END



//Archive Record Count Function---Company & Non Company

//Start

	public function archive_record_count($table,$company){
		$this->db->where('archive','1');
		$this->db->where('company_id',$company);
		$this->db->from($table);
		$count = $this->db->count_all_results();
		return $count;
	}


	public function archive_record_count_noncompany($table){
		$this->db->where('archive','1');
		$this->db->from($table);
		$count = $this->db->count_all_results();
		return $count;
	}

//End



//Max Increment value of table

	//Start

	public function select_max_pkey_noncompany($table,$pkey){
		$this->db->select('MAX(CAST('.$pkey.' as unsigned)) as '.$pkey);
		$this->db->from($table);
		$query = $this->db->get();
		return $query->result();
		
	}

//Used in Main_group Save
	
	public function select_max_pkey($table,$pkey,$company){
		$this->db->select('MAX('.$pkey.')  as '.$pkey);
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$query = $this->db->get();
		return $query->result();
		
	}

	public function select_max_pkey_numeric($table,$pkey,$company){
		$this->db->select('MAX(cast('.$pkey.' as unsigned))  as '.$pkey);
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$query = $this->db->get();
		echo $this->db->last_query();
		return $query->result();
		
	}

	public function select_max_pkey_springtube($table,$pkey,$company){
		$this->db->select('MAX(CAST(REPLACE(ad_id,"SAW","") AS UNSIGNED)) as ad_id');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$query = $this->db->get();
		return $query->result();
		
	}

	public function select_max_pkey_where($table,$pkey,$key,$edit,$company){
		$this->db->select('MAX('.$pkey.')  as '.$pkey);
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($key,$edit);
		$query = $this->db->get();
		return $query->result();
		
	}

	//End


	//archive

	public function archive_one_record($table,$data,$pkey,$edit,$company){
		$this->db->where($pkey, $edit);
		$this->db->where('company_id', $company);
		$result=$this->db->update($table,$data);
		if($result){
			return $falg=1;
		}else{
			return $falg=0;
		}
	}


// Company number formation

		public function save_number($number,$company){
			$this->db->select("decimal_for_all,decimal_places,read_format,decimal_seperator,digit_seperator");
			$this->db->from('company_system_parameters');
			$this->db->where('company_id',$company);
			$query = $this->db->get();
			foreach($query->result() as $row){
				if($number>=0){
					$new_number=round($number,2);
					return $new_number*100;
				}
			}
		}

		public function read_number($number,$company){
			$this->db->select("decimal_for_all,decimal_places,read_format,decimal_seperator,digit_seperator");
			$this->db->from('company_system_parameters');
			$this->db->where('company_id',$company);
			$query = $this->db->get();
			foreach($query->result() as $row){
				if($number>0){
					return $number/100;
				}else if($number==0){
					return $number=0;
				}else{
					return $number/100;
				}
			}
		}

		public function read_number_million($n){

			$n = (0+str_replace(",", "", $n));
				if (!is_numeric($n)) return false;
		        if ($n > 1000000000000) return round(($n/1000000000000), 2).' T';
		        elseif ($n > 1000000000) return round(($n/1000000000), 2).' B';
		        elseif ($n > 1000000) return round(($n/1000000), 2).'';
		        elseif ($n > 1000) return round(($n/1000000), 2).'';

		        return number_format($n);
		}

		public function get_user_name($user_id,$company){
			$this->db->select("*");
			$this->db->from('user_master');
			$this->db->where('company_id',$company);
			$this->db->where('user_id',$user_id);
			$query = $this->db->get();
			$result=$query->result();
			if($result){

				foreach($result as $row){

					return $row->login_name;
				
				}
			}
			else{
				return '';
			}
			
		}

		public function get_state_name($zip_code,$company){
			$this->db->select("*");
			$this->db->from('zip_code_master');
			//$this->db->where('company_id',$company);
			$this->db->where('zip_code',$zip_code);
			$query = $this->db->get();
			$result=$query->result();
			if($result){

				foreach($result as $row){

					return $row->lang_city;
				
				}
			}
			else{
				return '';
			}
			
		}

		public function view_date($date,$company){
			if($date!='' && $date!='0000-00-00'){
				return date_format(date_create($date),'d-M-Y');
			}else{
				return '';
			}
		}

		public function change_date_format($date,$company){
			if($date!='' && $date!='0000-00-00'){
				return date('Y-m-d',strtotime($date));
			}else{
				return '';
			}
		}

		public function select_active_records_excel($table,$from,$to,$company){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where('archive<>', '1');
		$this->db->where('order_date>=', $from);
		$this->db->where('order_date<=', $to);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function select_number_from_string($string){
		return $number=intval(preg_replace('/[^0-9]+/', '', $string),10);
	}


	public function select_percentage_from_string($string){
		return $number=str_replace('%','',$string);
	}


	public function select_tax_record($table,$company,$pkey,$edit){
		$this->db->select('tax_grid_details.*,tax_master.tax_name,tax_master.tax_rate');
		$this->db->from($table);
		$this->db->join('tax_master','tax_grid_details.tax_code=tax_master.tax_code','LEFT');
		$this->db->where('tax_grid_details.'.$pkey.'', $edit);
		$this->db->where('tax_grid_details.company_id', $company);
		$this->db->order_by('tax_grid_details.priority', 'asc');
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_records_where($table,$company,$data){
		$this->db->select('*');
		$this->db->from($table);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}		
		$this->db->where('company_id',$company);
		$query = $this->db->get();
		return $result=$query->result();
	}
	public function select_active_records_where_in($table,$data,$search_key,$in_array){
		$this->db->select('*');
		$this->db->from($table);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}
		if($in_array!=''){
			$this->db->where_in($search_key,$in_array);
		}		
		//$this->db->where('company_id',$company);

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}
	public function select_active_records_nocompany_noarchive_where($table,$data){
		$this->db->select('*');
		$this->db->from($table);
		if(!empty($data)){
			foreach($data as $key => $value) {
				$this->db->where($key,$value);
			}
		}
				
		$query = $this->db->get();
		return $result=$query->result();
	}

	public function select_active_records_where_order_by($table,$company,$data,$orderby,$sequence){
		$this->db->select('*');
		$this->db->from($table);
		foreach($data as $key => $value) {
			$this->db->where($key,$value);
		}
		$this->db->where('company_id',$company);
		if($orderby!=''){
			$this->db->order_by($orderby,$sequence);
		}
		$query = $this->db->get();
		return $result=$query->result();
	}
	public function get_article_name($article_no,$company){
			$this->db->select("*");
			$this->db->from('article_name_info');
			$this->db->where('company_id',$company);
			$this->db->where('article_no',$article_no);
			$query = $this->db->get();
			$result=$query->result();
			if($result){

				foreach($result as $row){

					return $row->lang_article_description.($row->lang_sub_description!='' ? ' ('.$row->lang_sub_description.')' :'');
				
				}
			}
			else{
				return '';
			}
			
	}


	public function get_parent_name($article_no,$company){
			$this->db->select("address_category_master.category_name as parent");
			$this->db->from('article_name_info');
			$this->db->join('address_category_master','article_name_info.adr_category_id=address_category_master.adr_category_id','LEFT');
			$this->db->where('article_name_info.company_id',$company);
			$this->db->where('article_name_info.article_no',$article_no);
			$query = $this->db->get();
			$result=$query->result();
			if($result){

				foreach($result as $row){

					return $row->parent;
				
				}
			}
			else{
				return '';
			}
			
	}

	public function get_uom($uom_id,$company){
			$this->db->select("*");
			$this->db->from('uom_master');
			$this->db->where('uom_id',$uom_id);
			$this->db->where('language_id','1');
			$this->db->where('archive<>','1');
			$query = $this->db->get();
			$result=$query->result();
			if($result){
				foreach($result as $row){
					return strtoupper($row->lang_uom_desc);				
				}
			}
			else{
				return '';
			}
			
	}
	public function get_customer_name($adr_company_id,$company){
			$this->db->select("*");
			$this->db->from('address_master');
			$this->db->where('company_id',$company);
			$this->db->where('archive<>','1');
			$this->db->where('adr_company_id',$adr_company_id);
			$query = $this->db->get();
			$result=$query->result();
			if($result){
				foreach($result as $row){
					return $row->name1;
				
				}
			}
			else{
				return '';
			}
			
	}

	public function jobcard_meters_to_qty($jobcard_no,$total_meters){     
      //(NO Of reels * reel Length * 1000 / Sleeve Length For Extrusion) * Ups

      //$reel_length=$this->config->item('springtube_reel_length');
      //$reel_length=0;
      $expected_tubes=0;
      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $final_length_in_mm=0;
      $body_making_type='';
      

      if($jobcard_no!='' && $total_meters!=''){

        $customer='';
        $order_no='';
        $article_no='';
        $bom_no='';
        $bom_version_no='';
        $film_code='';
        $ad_id='';
        $version_no='';
        

        $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
    
        foreach($production_master_result as $row) {
          $order_no=$row->sales_ord_no;
          $article_no=$row->article_no;
        }

        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
          foreach($order_master_result as $order_master_row){
            $customer=$order_master_row->customer_no;                      
          }


        $data_order_details=array(
        'order_no'=>$order_no,
        'article_no'=>$article_no
        );

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
        foreach($order_details_result as $order_details_row){
          $bom_no=$order_details_row->spec_id;
          $bom_version_no=$order_details_row->spec_version_no;
          $ad_id=$order_details_row->ad_id;
          $version_no=$order_details_row->version_no;
        }

        $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

        $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

        foreach ($bill_of_material_result as $bill_of_material_row) {
          $bom_id=$bill_of_material_row->bom_id;
          $film_code=$bill_of_material_row->sleeve_code;
           
        } 
        //SLEEVE---------------------------------

        $film_spec_id='';
        $film_spec_version='';

        $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

        foreach($film_code_result as $film_code_row){                   
            $film_spec_id=$film_code_row->spec_id;
            $film_spec_version=$film_code_row->spec_version_no;
        }

        $specs['spec_id']=$film_spec_id;
        $specs['spec_version_no']=$film_spec_version;

        $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
          
        $total_microns=0;
        
        if($specs_result){                      

          foreach($specs_result as $specs_row){
              $sleeve_diameter=$specs_row->SLEEVE_DIA;
              $sleeve_length=$specs_row->SLEEVE_LENGTH;
              $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
              $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6; 
              $micron_1=$specs_row->FILM_GUAGE_1;
              $micron_2=$specs_row->FILM_GUAGE_2; 
              $micron_3=$specs_row->FILM_GUAGE_3; 
              $micron_4=$specs_row->FILM_GUAGE_4; 
              $micron_5=$specs_row->FILM_GUAGE_5;       
              $micron_6=$specs_row->FILM_GUAGE_6; 
              $micron_7=$specs_row->FILM_GUAGE_7; 

          }

          $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

        }

        //Artwork Deatils-------------------------
        $data=array('ad_id'=>$ad_id,
              'version_no'=>$version_no
                );
        $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

        foreach ($springtube_artwork_result as $springtube_artwork_row) {
          $body_making_type=$springtube_artwork_row->body_making_type;
        }

        
        $sleeve_dia_id='';
        $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
        //print_r($result_sleeve_diameter_master);
        foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
          $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
       
        }
	        // $data=array('sleeve_dia_id'=>$sleeve_dia_id,
	        //                 'seam_type'=>$body_making_type);

        $data=array('sleeve_dia_id'=>$sleeve_dia_id);

        $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

        $reel_width=0;
        $ups=0;
        $sleeve_length_extrusion=$sleeve_length+2.5;
                  
        foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
          $ups=$spring_width_calculation_row->ups;
          $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
        }

        $expected_tubes=($total_meters*$ups*1000)/$sleeve_length_extrusion;
                //$final_length_in_mm=($sleeve_length_extrusion*$jobcard_qty/1000)/$ups;
                //$no_of_reels_planned=round(($final_length_in_mm/$reel_length),2);
                //$no_of_reels_planned= round($no_of_reels_planned,2);
        return round($expected_tubes,0);

     
      
    }else{
      return '0';
    }  

  }
  

	public function time_diffrence($datee1,$datee2){

	$date1 = strtotime($datee1); 
	$date2 = strtotime($datee2 ); 

	$diff = abs($date2 - $date1); 

	$years = floor($diff / (365*60*60*24)); 


	$months = floor(($diff - $years * 365*60*60*24) 
								/ (30*60*60*24)); 

	$days = floor(($diff - $years * 365*60*60*24 - 
				$months*30*60*60*24)/ (60*60*24)); 
	 
	$hours = floor(($diff - $years * 365*60*60*24 
		- $months*30*60*60*24 - $days*60*60*24) 
									/ (60*60)); 


	$minutes = floor(($diff - $years * 365*60*60*24 
			- $months*30*60*60*24 - $days*60*60*24 
							- $hours*60*60)/ 60); 

	$seconds = floor(($diff - $years * 365*60*60*24 
			- $months*30*60*60*24 - $days*60*60*24 
					- $hours*60*60 - $minutes*60)); 

	return /*printf("%d years, %d months, %d days, %d hours, "
		. "%d minutes, %d seconds",*/ $days." Days ".$hours." Hours ".$minutes." Min ".$seconds." Sec";/*); */

	}

	
 
	public function get_material_rate($part_no){
		$sql="SELECT YEAR(issue_date) as Year,MONTH(issue_date) as Month, CASE WHEN MONTH(issue_date) BETWEEN 4 AND 6 THEN 'Q1' WHEN MONTH(issue_date) BETWEEN 7 AND 9 THEN 'Q2' WHEN MONTH(issue_date) BETWEEN 10 AND 12 THEN 'Q3' WHEN MONTH(issue_date) BETWEEN 1 AND 3 THEN 'Q4' END AS quarter, sum(qty) as Quantity, sum(qty*avg_rate) as Value, sum(qty*avg_rate)/sum(qty) as Avg_rate FROM tally_issued_material_receipt WHERE part_no = '$part_no' GROUP BY YEAR(issue_date),QUARTER(issue_date) order by YEAR(issue_date) desc,QUARTER(issue_date) desc limit 1,1";
		$query=$this->db->query($sql);
		return $result=$query->result();
	}
	


}
?>