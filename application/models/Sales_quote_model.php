<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_quote_model extends CI_Model {	


	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type,cap_finish_master.cap_finish,costsheet_master.order_no,costsheet_master.article_no,sales_quote_revision.version_no as price_version_no,sales_quote_revision._5k_rev_price,sales_quote_revision._10k_rev_price,sales_quote_revision._25k_rev_price,sales_quote_revision._50k_rev_price,sales_quote_revision._100k_rev_price,sales_quote_revision._free_rev_price');

		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
		$this->db->join('costsheet_master',$table.'.invoice_no=costsheet_master.invoice_no','LEFT');
		$this->db->join('sales_quote_revision',$table.'.quotation_no=sales_quote_revision.quotation_no','LEFT');		
		$this->db->where($table.'.version_no=sales_quote_revision.version_no');
		
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->order_by($table.'.quotation_no','desc');
		$this->db->order_by($table.'.quotation_date','desc');
		
		$this->db->order_by('sales_quote_revision.version_no','desc');
		 
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}

public function select_active_user_records($limit,$start,$table,$company,$user_id){
$this->db->select($table.'.*,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type,cap_finish_master.cap_finish,costsheet_master.order_no,costsheet_master.article_no,sales_quote_revision.version_no as price_version_no,sales_quote_revision._5k_rev_price,sales_quote_revision._10k_rev_price,sales_quote_revision._25k_rev_price,sales_quote_revision._50k_rev_price,sales_quote_revision._100k_rev_price,sales_quote_revision._free_rev_price');

$this->db->from($table);
$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
$this->db->join('costsheet_master',$table.'.invoice_no=costsheet_master.invoice_no','LEFT');
$this->db->join('sales_quote_revision',$table.'.quotation_no=sales_quote_revision.quotation_no','LEFT');
$this->db->where($table.'.version_no=sales_quote_revision.version_no');
$this->db->where($table.'.user_id',$user_id);
$this->db->where($table.'.company_id',$company);
$this->db->where($table.'.archive<>','1');
$this->db->order_by($table.'.quotation_no','desc');
$this->db->order_by($table.'.quotation_date','desc');

$this->db->order_by('sales_quote_revision.version_no','desc');

$this->db->limit($limit, $start);
$query = $this->db->get();
return $result=$query->result();
}

	

	public function select_archive_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type,cap_finish_master.cap_finish,costsheet_master.order_no,costsheet_master.article_no');

		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
		$this->db->join('costsheet_master',$table.'.invoice_no=costsheet_master.invoice_no','LEFT');

		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		 
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $result=$query->result();
	}
	
	public function select_one_active_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,address_category_details.address,address_category_details.city,country_master_lang.lang_country_name,address_category_contact_details.company_email,address_category_details.state,address_category_contact_details.company_contact_no,address_category_contact_details.contact_name,address_category_contact_details.adr_category_id,address_category_master.category_name,shoulder_types_master.shoulder_type,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type as cap_types,cap_finish_master.cap_finish as cap_finishes,cap_diameter_master.cap_dia as cap_dias,shoulder_orifice_master.shoulder_orifice as shoulder_ori,cap_orifice_master.cap_orifice as cap_ori,
	coex_machine_master.running_speed,coex_machine_master.job_changeover,coex_machine_master.minimum_contribution,coex_machine_master.machine_capacity_without_changeover,sales_quote_details.lacquer_cost_per_tube,sales_quote_details.screen_flexo_consumable_view,sales_quote_details.total_box_rate,sales_quote_details.stores_spares_local_view,sales_quote_details.shoulder_cost,sales_quote_details.offset_consumable_view,sales_quote_details.liner_gm_per_tube,sales_quote_details.stores_spares_import_view,sales_quote_details.cap_cost_per_tube,sales_quote_details.spring_consumable_view,sales_quote_details.export_packing,sales_quote_details.hygenic_consumable_view,sales_quote_details.packing_shrink_flim,sales_quote_details.tube_foil_cost_per_tube,sales_quote_details.other_consumable_view,sales_quote_details.packing_corrugated_sheet,sales_quote_details.offset_cost_per_tube,sales_quote_details.offset_plate_cost_per_tube,sales_quote_details.packing_bopp_tape,sales_quote_details.screen_flexo_cost_per_tube,sales_quote_details.screen_film_cost_per_tube,sales_quote_details.packing_stickers,sales_quote_details.special_ink_cost_per_tube,sales_quote_details.flexo_plate_cost_per_tube,sales_quote_details.other_packing_material,sales_quote_details.label_cost_per_tube,sales_quote_details.shoulder_foil_cost_per_tube,sales_quote_details.cap_shrink_sleeve_cost_per_tube,sales_quote_details.cap_foil_cost_view,sales_quote_details.cap_metalization_cost_view,sales_quote_details.sleeve_per_cost,sales_quote_details.total_rm_cost_per_tube,sales_quote_details.total_consummable_cost_per_tube,sales_quote_details.total_packing_cost_per_tube,sales_quote_details.total_stores_cost_per_tube,sales_quote_details.total_cost_per_tube,sales_quote_details.waste_total_cost_per_tube,
	sales_quote_details.lacquer1_rate,sales_quote_details.lacquer_1,sales_quote_details.lacquer1_gm_per_tube,sales_quote_details.lacquer1_perc,sales_quote_details.lacquer_2,sales_quote_details.lacquer2_rate,sales_quote_details.lacquer2_gm_per_tube,sales_quote_details.lacquer2_perc,sales_quote_details.lacquer_rejection,sales_quote_details.special_rm_month,sales_quote_details.special_ink_rate,sales_quote_details.special_gm_per_tube,sales_quote_details.special_percentage,sales_quote_details.specialink_rejection,sales_quote_details.sh_hdpe_one,sales_quote_details.sh_hdpe_one_rate,sales_quote_details.hdpe_m,sales_quote_details.sh_hdpe_two,sales_quote_details.sh_hdpe_two_rate,sales_quote_details.hdpe_f,sales_quote_details.shoulder_mb,sales_quote_details.shoulder_mb_rate,sales_quote_details.shoulder_mb_percentage,sales_quote_details.shoulder_mb1,sales_quote_details.shoulder_mb1_rate,sales_quote_details.shoulder_mb_percentage1,sales_quote_details.sh_quantity,sales_quote_details.sh_rejection,sales_quote_details.cap_shrink_sleeve_rate,sales_quote_details.cap_shrink_sleeve_code,sales_quote_details.cap_metalization_rate,sales_quote_details.cap_foil_rate,sales_quote_details.hot_foil_1,sales_quote_details.hot_foil_1_rate,sales_quote_details.hot_foil_1_percentage,sales_quote_details.hot_foil_2,sales_quote_details.hot_foil_2_rate,sales_quote_details.hot_foil_2_percentage,sales_quote_details.tube_foil_rejection,sales_quote_details.shoulder_foil_sqm_per_tube,sales_quote_details.shoulder_foil_rate,sales_quote_details.shoulder_foil_tag,sales_quote_details.mould_type,sales_quote_details.cap_weight_rate,sales_quote_details.runner_waste,sales_quote_details.pp_price,sales_quote_details.mb_price,sales_quote_details.mb_loading,sales_quote_details.moulding_cost,sales_quote_details.cap_rejection,sales_quote_details.bottom_box,sales_quote_details.top_box_rate,sales_quote_details.bottom_box_rate,sales_quote_details.box_liners_rate,sales_quote_details.liner_gm_per_tube,sales_quote_details.total_box_rate,sales_quote_details.box_liners,sales_quote_details.top_box,sales_quote_details.shoulder_foil_tag,sales_quote_details.offset_rm_month,sales_quote_details.offset_rate,sales_quote_details.offset_gm_per_tube,sales_quote_details.offset_rejection,sales_quote_details.offset_percentage,sales_quote_details.offset_plate_cost,sales_quote_details.offset_color,sales_quote_details.offset_impresssion,sales_quote_details.offset_sets,sales_quote_details.label_rate,sales_quote_details.label_rejection,sales_quote_details.screen_rm_month,sales_quote_details.screen_rate,sales_quote_details.screen_gm_per_tube,sales_quote_details.screen_percentage,sales_quote_details.flexo_rm_month,sales_quote_details.flexo_rate,sales_quote_details.flexo_gm_per_tube,sales_quote_details.flexo_percentage,sales_quote_details.screen_flexo_rejection,sales_quote_details.screen_film_rate,sales_quote_details.screen_colors,sales_quote_details.screen_impresssion,sales_quote_details.screen_sets,sales_quote_details.flexo_plate_rate,sales_quote_details.flexo_colors,sales_quote_details.flexo_impresssion,sales_quote_details.flexo_sets,sales_quote_revision._5k_rev_price,sales_quote_revision._10k_rev_price,sales_quote_revision._25k_rev_price,sales_quote_revision._50k_rev_price,sales_quote_revision._100k_rev_price,sales_quote_revision._free_rev_price');

		$this->db->from($table);
		$this->db->join('address_category_details',$table.'.customer_no=address_category_details.adr_category_id','LEFT');
		$this->db->join('country_master_lang','address_category_details.country=country_master_lang.country_id','LEFT');
		$this->db->join('address_category_contact_details',$table.'.pm_1=address_category_contact_details.address_category_contact_id','LEFT');		
		$this->db->join('address_category_master',$table.'.customer_no=address_category_master.adr_category_id','LEFT');	
		$this->db->join('shoulder_types_master',$table.'.shoulder=shoulder_types_master.shld_type_id','LEFT');
		$this->db->join('shoulder_orifice_master',$table.'.shoulder_orifice=shoulder_orifice_master.orifice_id','LEFT');
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
		$this->db->join('cap_diameter_master',$table.'.cap_dia=cap_diameter_master.cap_dia_id','LEFT');
		$this->db->join('cap_orifice_master',$table.'.cap_orifice=cap_orifice_master.cap_orifice_id','LEFT');

		$this->db->join('coex_machine_master',$table.'.machine_print_type_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('sales_quote_details',$table.'.quotation_no=sales_quote_details.quotation_no','LEFT');	
		$this->db->join('sales_quote_revision',$table.'.quotation_no=sales_quote_revision.quotation_no','LEFT');
		//echo $this->db->last_query();
		

		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();

		return $query->result();

	}

	public function select_one_active_record_where($table,$company,$pkey,$edit,$pkey2,$edit2){
		$this->db->select($table.'.*,address_category_details.address,address_category_details.city,country_master_lang.lang_country_name,address_category_contact_details.company_email,address_category_details.state,address_category_contact_details.company_contact_no,address_category_contact_details.contact_name,address_category_master.category_name,shoulder_types_master.shoulder_type,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type as cap_types,cap_finish_master.cap_finish as cap_finishes,cap_diameter_master.cap_dia as cap_dias,shoulder_orifice_master.shoulder_orifice as shoulder_ori,cap_orifice_master.cap_orifice as cap_ori,
	coex_machine_master.running_speed,coex_machine_master.job_changeover,coex_machine_master.minimum_contribution,coex_machine_master.machine_capacity_without_changeover,sales_quote_details.lacquer_cost_per_tube,sales_quote_details.screen_flexo_consumable_view,sales_quote_details.total_box_rate,sales_quote_details.stores_spares_local_view,sales_quote_details.shoulder_cost,sales_quote_details.offset_consumable_view,sales_quote_details.liner_gm_per_tube,sales_quote_details.stores_spares_import_view,sales_quote_details.cap_cost_per_tube,sales_quote_details.spring_consumable_view,sales_quote_details.export_packing,sales_quote_details.hygenic_consumable_view,sales_quote_details.packing_shrink_flim,sales_quote_details.tube_foil_cost_per_tube,sales_quote_details.other_consumable_view,sales_quote_details.packing_corrugated_sheet,sales_quote_details.offset_cost_per_tube,sales_quote_details.offset_plate_cost_per_tube,sales_quote_details.packing_bopp_tape,sales_quote_details.screen_flexo_cost_per_tube,sales_quote_details.screen_film_cost_per_tube,sales_quote_details.packing_stickers,sales_quote_details.special_ink_cost_per_tube,sales_quote_details.flexo_plate_cost_per_tube,sales_quote_details.other_packing_material,sales_quote_details.label_cost_per_tube,sales_quote_details.shoulder_foil_cost_per_tube,sales_quote_details.cap_shrink_sleeve_cost_per_tube,sales_quote_details.cap_foil_cost_view,sales_quote_details.cap_metalization_cost_view,sales_quote_details.sleeve_per_cost,sales_quote_details.total_rm_cost_per_tube,sales_quote_details.total_consummable_cost_per_tube,sales_quote_details.total_packing_cost_per_tube,sales_quote_details.total_stores_cost_per_tube,sales_quote_details.total_cost_per_tube,sales_quote_details.waste_total_cost_per_tube,
	sales_quote_details.lacquer1_rate,sales_quote_details.lacquer_1,sales_quote_details.lacquer1_gm_per_tube,sales_quote_details.lacquer1_perc,sales_quote_details.lacquer_2,sales_quote_details.lacquer2_rate,sales_quote_details.lacquer2_gm_per_tube,sales_quote_details.lacquer2_perc,sales_quote_details.lacquer_rejection,sales_quote_details.special_rm_month,sales_quote_details.special_ink_rate,sales_quote_details.special_gm_per_tube,sales_quote_details.special_percentage,sales_quote_details.specialink_rejection,sales_quote_details.sh_hdpe_one,sales_quote_details.sh_hdpe_one_rate,sales_quote_details.hdpe_m,sales_quote_details.sh_hdpe_two,sales_quote_details.sh_hdpe_two_rate,sales_quote_details.hdpe_f,sales_quote_details.shoulder_mb,sales_quote_details.shoulder_mb_rate,sales_quote_details.shoulder_mb_percentage,sales_quote_details.shoulder_mb1,sales_quote_details.shoulder_mb1_rate,sales_quote_details.shoulder_mb_percentage1,sales_quote_details.sh_quantity,sales_quote_details.sh_rejection,sales_quote_details.cap_shrink_sleeve_rate,sales_quote_details.cap_shrink_sleeve_code,sales_quote_details.cap_metalization_rate,sales_quote_details.cap_foil_rate,sales_quote_details.hot_foil_1,sales_quote_details.hot_foil_1_rate,sales_quote_details.hot_foil_1_percentage,sales_quote_details.hot_foil_2,sales_quote_details.hot_foil_2_rate,sales_quote_details.hot_foil_2_percentage,sales_quote_details.tube_foil_rejection,sales_quote_details.shoulder_foil_sqm_per_tube,sales_quote_details.shoulder_foil_rate,sales_quote_details.shoulder_foil_tag,sales_quote_details.mould_type,sales_quote_details.cap_weight_rate,sales_quote_details.runner_waste,sales_quote_details.pp_price,sales_quote_details.mb_price,sales_quote_details.mb_loading,sales_quote_details.moulding_cost,sales_quote_details.cap_rejection,sales_quote_details.bottom_box,sales_quote_details.top_box_rate,sales_quote_details.bottom_box_rate,sales_quote_details.box_liners_rate,sales_quote_details.liner_gm_per_tube,sales_quote_details.total_box_rate,sales_quote_details.box_liners,sales_quote_details.top_box,sales_quote_details.shoulder_foil_tag,sales_quote_details.offset_rm_month,sales_quote_details.offset_rate,sales_quote_details.offset_gm_per_tube,sales_quote_details.offset_rejection,sales_quote_details.offset_percentage,sales_quote_details.offset_plate_cost,sales_quote_details.offset_color,sales_quote_details.offset_impresssion,sales_quote_details.offset_sets,sales_quote_details.label_rate,sales_quote_details.label_rejection,sales_quote_details.screen_rm_month,sales_quote_details.screen_rate,sales_quote_details.screen_gm_per_tube,sales_quote_details.screen_percentage,sales_quote_details.flexo_rm_month,sales_quote_details.flexo_rate,sales_quote_details.flexo_gm_per_tube,sales_quote_details.flexo_percentage,sales_quote_details.screen_flexo_rejection,sales_quote_details.screen_film_rate,sales_quote_details.screen_colors,sales_quote_details.screen_impresssion,sales_quote_details.screen_sets,sales_quote_details.flexo_plate_rate,sales_quote_details.flexo_colors,sales_quote_details.flexo_impresssion,sales_quote_details.flexo_sets,sales_quote_revision._5k_rev_price,sales_quote_revision._10k_rev_price,sales_quote_revision._25k_rev_price,sales_quote_revision._50k_rev_price,sales_quote_revision._100k_rev_price,sales_quote_revision._free_rev_price,sales_quote_revision.version_no');

		$this->db->from($table);
		$this->db->join('address_category_details',$table.'.customer_no=address_category_details.adr_category_id','LEFT');
		$this->db->join('country_master_lang','address_category_details.country=country_master_lang.country_id','LEFT');
		$this->db->join('address_category_contact_details',$table.'.pm_1=address_category_contact_details.address_category_contact_id','LEFT');		
		$this->db->join('address_category_master',$table.'.customer_no=address_category_master.adr_category_id','LEFT');	
		$this->db->join('shoulder_types_master',$table.'.shoulder=shoulder_types_master.shld_type_id','LEFT');
		$this->db->join('shoulder_orifice_master',$table.'.shoulder_orifice=shoulder_orifice_master.orifice_id','LEFT');
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
		$this->db->join('cap_diameter_master',$table.'.cap_dia=cap_diameter_master.cap_dia_id','LEFT');
		$this->db->join('cap_orifice_master',$table.'.cap_orifice=cap_orifice_master.cap_orifice_id','LEFT');

		$this->db->join('coex_machine_master',$table.'.machine_print_type_id=coex_machine_master.machine_id','LEFT');
		$this->db->join('sales_quote_details',$table.'.quotation_no=sales_quote_details.quotation_no','LEFT');
		$this->db->where($table.'.version_no=sales_quote_details.version_no');		
		$this->db->join('sales_quote_revision',$table.'.quotation_no=sales_quote_revision.quotation_no','LEFT');
		$this->db->where($table.'.version_no=sales_quote_revision.version_no');		//echo $this->db->last_query();

		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>','1');
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$query = $this->db->get();
		return $query->result();
	}

	

	public function select_one_inactive_record($table,$company,$pkey,$edit){
		$this->db->select($table.'.*,address_category_details.address,address_category_details.city,country_master_lang.lang_country_name,address_category_contact_details.personal_email,address_category_details.state,address_category_contact_details.company_contact_no,address_category_contact_details.contact_name,address_category_master.category_name,shoulder_types_master.shoulder_type,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type as cap_types,cap_finish_master.cap_finish as cap_finishes,cap_diameter_master.cap_dia as cap_dias');
		$this->db->from($table);
		$this->db->join('address_category_details',$table.'.customer_no=address_category_details.adr_category_id','LEFT');
		$this->db->join('country_master_lang','address_category_details.country=country_master_lang.country_id','LEFT');
		$this->db->join('address_category_contact_details',$table.'.pm_1=address_category_contact_details.address_category_contact_id','LEFT');		
		$this->db->join('address_category_master',$table.'.customer_no=address_category_master.adr_category_id','LEFT');	
		$this->db->join('shoulder_types_master',$table.'.shoulder=shoulder_types_master.shld_type_id','LEFT');
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
		$this->db->join('cap_diameter_master',$table.'.cap_dia=cap_diameter_master.cap_dia_id','LEFT');
		

		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive','1');
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}


	public function active_record_search($table,$company,$data,$from,$to){
		$this->db->select($table.'.*,sleeve_diameter_master.sleeve_diameter,cap_types_master.cap_type,cap_finish_master.cap_finish,costsheet_master.order_no,costsheet_master.article_no,sales_quote_revision.version_no as price_version_no,sales_quote_revision._5k_rev_price,sales_quote_revision._10k_rev_price,sales_quote_revision._25k_rev_price,sales_quote_revision._50k_rev_price,sales_quote_revision._100k_rev_price,sales_quote_revision._free_rev_price');

		$this->db->from($table);
		$this->db->join('sleeve_diameter_master',$table.'.sleeve_dia=sleeve_diameter_master.sleeve_id','LEFT');
		$this->db->join('cap_types_master',$table.'.cap_type=cap_types_master.cap_type_id','LEFT');
		$this->db->join('cap_finish_master',$table.'.cap_finish=cap_finish_master.cap_finish_id','LEFT');
		$this->db->join('costsheet_master',$table.'.invoice_no=costsheet_master.invoice_no','LEFT');
		$this->db->join('sales_quote_revision',$table.'.quotation_no=sales_quote_revision.quotation_no','LEFT');		
		$this->db->where($table.'.version_no=sales_quote_revision.version_no');

		
		$this->db->where($table.'.company_id',$company);
		$this->db->where($table.'.archive<>', '1');
		//	$this->db->where($table.'.status','0');
		$this->db->order_by($table.'.quotation_date','desc');
		$this->db->order_by($table.'.quotation_no','desc');
		$this->db->order_by('sales_quote_revision.version_no','desc');
		if($from!='' && $to!=''){
			$this->db->where('quotation_date>=',$from);
			$this->db->where('quotation_date<=',$to);
		}
		//print_r($data);
		if(!empty($data)){		
			foreach($data as $key => $value) {
				$this->db->where($table.'.'.$key,$value);
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result=$query->result();
	}

	public function select_quote_verion_no($table,$company,$pkey,$edit){
		$this->db->select('max(version_no)+1 as version_no,quotation_no');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_quote_verion_no_copy_fun($table,$company,$pkey,$edit){
		$this->db->select('ROUND(max(version_no)+1, 0) as version_no,quotation_no');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_quote_verion_no_pts($table,$company,$pkey,$edit,$pkey2,$edit2){
		$this->db->select('ROUND((version_no)+0.1, 1) as version_no,quotation_no');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$this->db->where($pkey2,$edit2);
		$query = $this->db->get();
		return $query->result();
	}

	public function select_quote_max_verion_no($table,$company,$pkey,$edit){
		$this->db->select('max(version_no) as version_no,quotation_no');
		$this->db->from($table);
		$this->db->where('company_id', $company);
		$this->db->where($pkey,$edit);
		$query = $this->db->get();
		return $query->result();
	}
}

?>


