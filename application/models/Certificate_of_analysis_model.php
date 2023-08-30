<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_of_analysis_model extends CI_Model {
		
	public function select_active_records($limit,$start,$table,$company){
		$this->db->select($table.'.*,od.spec_id as od_spec_id, bom.sleeve_code as bom_sleeve_code,ss.article_no as ss_article_no,ssd.spec_id as ssd_spec_id');

		$this->db->from($table);
		$this->db->join('order_details as od',$table.'.so_no=od.order_no','LEFT');
   	$this->db->join('bill_of_material as bom','od'.'.spec_id=bom.bom_no','LEFT');
  	$this->db->join('specification_sheet as ss','bom'.'.sleeve_code=ss.article_no','LEFT');
   	$this->db->join('specification_sheet_details as ssd','ss'.'.spec_id=ssd.spec_id','LEFT');
		
		$this->db->where($table.'.company_id',$company);		
		$this->db->where($table.'.archive<>', '1');
		$this->db->group_by('coa_id');
		$this->db->order_by(' '.$table.'.coa_id','DESC');
		$this->db->limit($limit, $start);

		$query = $this->db->get();
		return $result=$query->result();
	}

	public function count_active_records(){
        $query_staff    = $this->db->query("SELECT coa_id FROM certificate_of_analysis");
        return $query_staff->num_rows();
  }

 public function select_one_layer_active_records($table,$company,$pkey1,$edit1,$pkey2,$edit2,$limit,$start){

    $this->db->select($table.'.*, od.order_no,bom.sleeve_code,aid.layer_no,bom.bom_no,bom.bom_version_no');
    $this->db->from($table);
    $this->db->join('order_details as od',$table.'.so_no= od.order_no','LEFT');
    $this->db->join('ar_invoice_details as aid','od'.'.order_no=aid.ref_ord_no','LEFT');
    $this->db->join('bill_of_material as bom','od'.'.spec_id=bom.bom_no','LEFT');
    $this->db->join('specification_sheet as ss','bom'.'.sleeve_code=ss.article_no','LEFT');
    $this->db->join('specification_sheet_details as ssd','ss'.'.spec_id=ssd.spec_id','LEFT');

    $this->db->where($table.'.archive<>', '1');
    $this->db->where($table.'.company_id',$company);
    $this->db->where($pkey1,$edit1);
    $this->db->where($pkey2,$edit2);
    $this->db->limit($limit, $start);

    $query = $this->db->get();
    return $result=$query->result();
  }

/*public function get_coa_details_id($company,$certificate_no){
  $resultdata = array();

  $query = $this->db->query("SELECT coa.*, user.user_id,user.login_name as prepared_name_,users.user_id,users.login_name as approved_by_,aim.ar_invoice_no as aim_id, aim.invoice_date as in_date, aid.ar_invoice_no as aid_id, aid.ref_ord_no as ref_ord_id, aid.article_no as aid_article_no, om.order_no as om_ord_id, om.customer_no as om_customer_id, om.order_flag as order_type, od.order_no as ord_id, bm.bom_no as bom_id,bm.bom_version_no as version_no, bm.shoulder_code as shoulder_id, bm.sleeve_code as sleeve_id, bm.cap_code as cap_code_id , sd.layer_no as sd_layer_no,max(sdle.layer_no) as max_sleeve_layer_no,min(sdle.layer_no) as min_sleeve_layer_no,
    MAX(CASE WHEN sd.parameter_name='MASTER BATCH' THEN sd.mat_article_no END) AS 'SHOULDER_MASTER_BATCH_COLOR',

    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_1',
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_2',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_3',
    MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_4',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_5',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_6',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_7',

    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_1',
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_2',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_3',
    MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_4',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_5',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_6',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_7',

    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END)  AS 'LDPE_Layer_1',
    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_1',
    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END)  AS 'HDPE_Layer_1',    
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='ADMER' THEN sdle.mat_info END) AS 'ADMER_Layer_2',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='EVOH' THEN sdle.mat_info END)  AS 'EVOH_Layer_3',
    MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='ADMER' THEN sdle.mat_info END) AS 'ADMER_Layer_4',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END)  AS 'LDPE_Layer_5',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_5',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END) AS  'HDPE_Layer_5',
    
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END) AS  'LDPE_Layer_2', 
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_2',
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END)  AS 'HDPE_Layer_2',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='ADMER' THEN sdle.mat_info END) AS 'ADMER_Layer_3',
    MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='EVOH' THEN sdle.mat_info END)  AS 'EVOH_Layer_4',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='ADMER' THEN sdle.mat_info END) AS 'ADMER_Layer_5',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_6',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END)  AS 'HDPE_Layer_6',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END)  AS 'LDPE_Layer_6',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END)  AS 'LDPE_Layer_7',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_7',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END)  AS 'HDPE_Layer_7',
    
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END)  AS 'HDPE_Layer_3',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END)  AS 'LDPE_Layer_3',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_3',
    
    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_1',
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_2',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_3',
    MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_4',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_5',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_6',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_7'

    FROM certificate_of_analysis as coa
        LEFT JOIN user_master as user ON coa.user_id = user.user_id 
        LEFT JOIN user_master as users ON coa.approved_by = users.user_id 
        LEFT JOIN ar_invoice_master as aim ON coa.certificate_no = aim.ar_invoice_no 
        LEFT JOIN ar_invoice_details as aid ON aim.ar_invoice_no = aid.ar_invoice_no 
        LEFT JOIN order_master as om ON aid.ref_ord_no = om.order_no
        LEFT JOIN order_details as od ON om.order_no = od.order_no
        LEFT JOIN bill_of_material as bm ON od.spec_id = bm.bom_no AND od.spec_version_no= bm.bom_version_no
        LEFT JOIN specification_sheet as ss ON bm.shoulder_code = ss.article_no
        LEFT JOIN specification_sheet as sl ON bm.sleeve_code = sl.article_no
        LEFT JOIN specification_sheet as sle ON bm.sleeve_code = sle.article_no
        LEFT JOIN specification_sheet as sc ON bm.cap_code = sc.article_no 
        LEFT JOIN specification_sheet_details as sd ON ss.spec_id = sd.spec_id AND ss.spec_version_no = sd.spec_version_no
        LEFT JOIN specification_sheet_details as sdl ON sl.spec_id = sdl.spec_id AND sl.spec_version_no = sdl.spec_version_no AND sdl.mat_article_no
        LEFT JOIN specification_sheet_details as sdle ON sle.spec_id = sdle.spec_id AND sle.spec_version_no = sdle.spec_version_no
        LEFT JOIN specification_sheet_details as sdc ON sc.spec_id = sdc.spec_id AND sc.spec_version_no = sdc.spec_version_no AND sdl.relating_master_value
        LEFT JOIN cap_diameter_size as cds ON sdl.relating_master_value = cds.diameter
        WHERE coa.certificate_no = '$certificate_no' and coa.company_id = '$company' and (coa.archive<>'1') ORDER BY coa.coa_id desc LIMIT 1 ");
        if (!empty($query)) {
        $item=$query->row_array();
        
        $shoulder_master_batch_color=$this->common_model->get_article_name($item['SHOULDER_MASTER_BATCH_COLOR'],$this->session->userdata['logged_in']['company_id']);
         
          if($item['max_sleeve_layer_no'] == 1){
            $sleeve_inner_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_1'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_outer_layer='-';
            $sleeve_inner_per=$item['SLEEVE_LAYER_PER_1'];
            $sleeve_outer_per='-';
            $sleeve_tolerance='0.2';
          }elseif($item['max_sleeve_layer_no'] == 3){
            $sleeve_inner_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_1'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_outer_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_3'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_inner_per=$item['SLEEVE_LAYER_PER_1'];
            $sleeve_outer_per=$item['SLEEVE_LAYER_PER_3'];
            $sleeve_tolerance='0.2';
          }elseif($item['max_sleeve_layer_no'] == 5){
            $sleeve_inner_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_1'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_outer_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_5'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_inner_per=$item['SLEEVE_LAYER_PER_1'];
            $sleeve_outer_per=$item['SLEEVE_LAYER_PER_5'];
            $sleeve_tolerance='0.2';
          }elseif($item['max_sleeve_layer_no'] == 7){
            $sleeve_inner_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_2'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_outer_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_6'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_inner_per=$item['SLEEVE_LAYER_PER_2'];
            $sleeve_outer_per=$item['SLEEVE_LAYER_PER_6'];
            $sleeve_tolerance='0.3';
          }

        $resultdata = array(  
                "coa_id"                        => $item['coa_id'],
                "certificate_no"                => $item['certificate_no'],
                "inspection_date"               => $item['inspection_date'],
                "customer_name"                 => $item['customer_name'],
                "quality"                       => $item['quality'],
                "product_name"                  => $item['product_name'],
                "total_qty"                     => $item['total_qty'],
                "so_no"                         => $item['so_no'],
                "sample_size"                   => $item['sample_size'],
                "version_no"                    => $item['version_no'],
                "bom_no"                        => $item['bom_id'],
                "layer_no"                      => $item['sd_layer_no'],
                "specification_length"          => $item['specification_length'],
                "actual_length"                 => $item['actual_length'],
                "specification_inner_dia"       => $item['specification_inner_dia'],
                "actual_inner_dia"              => $item['actual_inner_dia'],
                "specification_outer_dia"       => $item['specification_outer_dia'],
                "actual_outer_dia"              => $item['actual_outer_dia'],
                "inner_tolerance"               => $item['inner_tolerance'],
                "outer_tolerance"               => $item['outer_tolerance'],                
                "shoulder_thread_type"          => $item['shoulder_thread_type'],
                "shoulder_master_batch"         => $item['shoulder_master_batch'],
                "specification_orifice"         => $item['specification_orifice'],
                "tolerance_orifice"             => $item['tolerance_orifice'],
                "actual_orifice"                => $item['actual_orifice'],
                "master_batch_orifice"          => $item['master_batch_orifice'],
                "cap_type"                      => $item['cap_type'],
                "cap_master_batch_colour"       => $item['cap_master_batch_colour'],
                "specification_diameter"        => $item['specification_diameter'],
                "actual_diameter"               => $item['actual_diameter'],
                "master_batch_diameter"         => $item['master_batch_diameter'],
                "specification_height"          => $item['specification_height'],
                "actual_height"                 => $item['actual_height'],
                "specification_cap_orifice"     => $item['specification_cap_orifice'],
                "actual_cap_orifice"            => $item['actual_cap_orifice'],
                "specification_shrink_sleeve"   => $item['specification_shrink_sleeve'],
                "actual_shrink_sleeve"          => $item['actual_shrink_sleeve'],
                "specification_print"           => $item['specification_print'],
                "actual_print"                  => $item['actual_print'],
                "lacquer_type"                  => $item['lacquer_type'],
                "air_leakage_status"            => $item['air_leakage_status'],
                "sleeve_colour_opacity_status"  => $item['sleeve_colour_opacity_status'],
                "sleeve_colour_opacity_status"  => $item['sleeve_colour_opacity_status'],
                "water_package_status"          => $item['water_package_status'],
                "gliding_test_status"           => $item['gliding_test_status'],
                "cap_fitment_status"            => $item['cap_fitment_status'],
                "uv_test_status"                => $item['uv_test_status'],
                "shoulder_welding_test_status"  => $item['shoulder_welding_test_status'],
                "drop_test_status"              => $item['drop_test_status'],
                "tape_test_status"              => $item['tape_test_status'],
                "odour_test_status"             => $item['odour_test_status'],
                "rub_test_status"               => $item['rub_test_status'],
                "vertically_test_status"        => $item['vertically_test_status'],
                "sealing_test_status"           => $item['sealing_test_status'],
                "sleeve_colour_difference_status" => $item['sleeve_colour_difference_status'],
                "bar_code_test_status"          => $item['bar_code_test_status'],
                "welding_test_side_seam_status" => $item['welding_test_side_seam_status'],
                "coa_result_status"             => $item['coa_result_status'],
                "escr_test_status"              => $item['escr_test_status'],
                "total_number_of_pallets"       => $item['total_number_of_pallets'],
                "sample_per_pallets"            => $item['sample_per_pallets'],
                "number_of_pallets_rechecked"   => $item['number_of_pallets_rechecked'],
                "SHOULDER_MASTER_BATCH_COLOR"   => $shoulder_master_batch_color,
                "final_approval_flag"           => $item['final_approval_flag'],
                "prepared_name"                 => $item['prepared_name_'],
                "approval_username"             => $item['approved_by_'] != null ? $item['approved_by_'] : '-',
                "max_sleeve_layer_no"           => $item['max_sleeve_layer_no'],
                "SLEEVE_LAYER_1"                => $item['SLEEVE_LAYER_1'],
                "SLEEVE_LAYER_2"                => $item['SLEEVE_LAYER_2'],
                "SLEEVE_LAYER_3"                => $item['SLEEVE_LAYER_3'],
                "SLEEVE_LAYER_4"                => $item['SLEEVE_LAYER_4'],
                "SLEEVE_LAYER_5"                => $item['SLEEVE_LAYER_5'],
                "SLEEVE_LAYER_6"                => $item['SLEEVE_LAYER_6'],
                "SLEEVE_LAYER_7"                => $item['SLEEVE_LAYER_7'],
                "sleeve_inner_layer_color"      => $sleeve_inner_layer,
                "sleeve_outer_layer_color"      => $sleeve_outer_layer,
                "sleeve_inner_per"              => $sleeve_inner_per,
                "sleeve_outer_per"              => $sleeve_outer_per,
                "sleeve_tolerance"              => $sleeve_tolerance,
                "LAYER_1"                       => ($item['LDPE_Layer_1']<>'' ? $item['LDPE_Layer_1']."%LDPE" : '').' '.
                                                   ($item['LLDPE_Layer_1']<>''  && $item['LLDPE_Layer_1']<>0 ? $item['LLDPE_Layer_1']."%LLDPE" : '').' '
                                                   ($item['HDPE_Layer_1']<>'' && $item['HDPE_Layer_1']<>0 ? $item['HDPE_Layer_1']."%HDPE" : '').''.
                                                   ($item['LDPE_Layer_1']=='' && $item['LLDPE_Layer_1']=='' && $item['HDPE_Layer_1']=='' ? '-' : ''),
                "LAYER_2"                       => ($item['LDPE_Layer_2']<>''   && $item['LDPE_Layer_2']<>0 ? 
                                                   $item['LDPE_Layer_2']."%LDPE" : '').' '.
                                                   ($item['LLDPE_Layer_2']<>'' && $item['LLDPE_Layer_2']<>0 ? $item['LLDPE_Layer_2']."%LLDPE" : '').' '
                                                   ($item['HDPE_Layer_2']<>'' && $item['HDPE_Layer_2']<>0 ? $item['HDPE_Layer_2']."%HDPE" : '').' '.
                                                   ($item['ADMER_Layer_2']<>''  ? $item['ADMER_Layer_2']."%ADMER" : '').''.
                                                   ($item['LDPE_Layer_2']=='' && $item['LLDPE_Layer_2']=='' && $item['HDPE_Layer_2']=='' && $item['ADMER_Layer_2']==''? '-' : ''),
                "LAYER_3"                       => ($item['ADMER_Layer_3']<>''  ? $item['ADMER_Layer_3']."%ADMER" : '').' '.
                                                   ($item['EVOH_Layer_3']<>''   ? $item['EVOH_Layer_3']."%EVOH" : '').' '.
                                                   ($item['LDPE_Layer_3']<>''   ? $item['LDPE_Layer_3']."%LDPE" : '').' '.
                                                   ($item['LLDPE_Layer_3']<>''  ? $item['LLDPE_Layer_3']."%LLDPE" : '').' '.
                                                   ($item['HDPE_Layer_3']<>'' && $item['HDPE_Layer_3']<>0  ? $item['HDPE_Layer_3']."%HDPE" : '').''.($item['ADMER_Layer_3']=='' && $item['EVOH_Layer_3']=='' && $item['LDPE_Layer_3']=='' && $item['LLDPE_Layer_3']=='' && $item['HDPE_Layer_3']==''? '-' : ''),
                "LAYER_4"                       => ($item['ADMER_Layer_4']<>''? $item['ADMER_Layer_4']."%ADMER" : '').' '.
                                                   ($item['EVOH_Layer_4']<>'' ? $item['EVOH_Layer_4']."%EVOH" : '').''.
                                                   ($item['ADMER_Layer_4']=='' && $item['EVOH_Layer_4']=='' ? '-' : ''),
                "LAYER_5"                       => ($item['LDPE_Layer_5']<>''   ? $item['LDPE_Layer_5']."%LDPE" : '').' '                                .($item['LLDPE_Layer_5']<>''  ? $item['LLDPE_Layer_5']."%LLDPE" : '').' '                                .($item['HDPE_Layer_5']<>'' && $item['HDPE_Layer_5']<>0 ? 
                                                   $item['HDPE_Layer_5']."%HDPE" : '').' '.($item['ADMER_Layer_5']<>''  ? $item['ADMER_Layer_5']."%ADMER" : '').''.
                                                  ($item['LDPE_Layer_5']=='' && $item['LLDPE_Layer_5']=='' && $item['HDPE_Layer_5']=='' && $item['ADMER_Layer_5']=='' ? '-' : ''),
                "LAYER_6"                       => ($item['LLDPE_Layer_6']<>''  ? $item['LLDPE_Layer_6']."%LLDPE" : '').' '.                                 ($item['HDPE_Layer_6']<>''  && $item['HDPE_Layer_6']<>0 ? 
                                                   $item['HDPE_Layer_6']."%HDPE" : '').' '.($item['LDPE_Layer_6']<>''   ?  $item['LDPE_Layer_6']."%LDPE" : '').''.
                                                  ($item['LLDPE_Layer_6']=='' && $item['HDPE_Layer_6']=='' && $item['LDPE_Layer_6']=='' ? '-' : ''),
                "LAYER_7"                       => ($item['LDPE_Layer_7']<>''   ? $item['LDPE_Layer_7']."%LDPE" : '').' '.
                                                   ($item['LLDPE_Layer_7']<>''  ? $item['LLDPE_Layer_7']."%LLDPE" : '').' '.
                                                   ($item['HDPE_Layer_7']<>'' && $item['HDPE_Layer_7']<>0 ? $item['HDPE_Layer_7']."%HDPE" : '').''.
                                                  ($item['LDPE_Layer_7']=='' && $item['LLDPE_Layer_7']=='' && $item['HDPE_Layer_7']=='' ? '-' : ''),
               "GUAGE_Layer_1"                  =>($item['GUAGE_Layer_1']<>''   ? $item['GUAGE_Layer_1']."micron" : '-'),
               "GUAGE_Layer_2"                  =>($item['GUAGE_Layer_2']<>''   ? $item['GUAGE_Layer_2']."micron" : '-'),
               "GUAGE_Layer_3"                  =>($item['GUAGE_Layer_3']<>''   ? $item['GUAGE_Layer_3']."micron" : '-'),
               "GUAGE_Layer_4"                  =>($item['GUAGE_Layer_4']<>''   ? $item['GUAGE_Layer_4']."micron" : '-'),
               "GUAGE_Layer_5"                  =>($item['GUAGE_Layer_5']<>''   ? $item['GUAGE_Layer_5']."micron" : '-'),
               "GUAGE_Layer_6"                  =>($item['GUAGE_Layer_6']<>''   ? $item['GUAGE_Layer_6']."micron" : '-'),
               "GUAGE_Layer_7"                  =>($item['GUAGE_Layer_7']<>''   ? $item['GUAGE_Layer_7']."micron" : '-'),
            );            
        }
        return $resultdata;
    }*/
    
  public function get_coa_details_id($company,$certificate_no,$order_no,$product_no){
  $resultdata = array();

  $query = $this->db->query("SELECT coa.*, user.user_id,user.login_name as prepared_name_,users.user_id,users.login_name as approved_by_,aim.ar_invoice_no as aim_id, aim.invoice_date as in_date, aid.ar_invoice_no as aid_id, aid.ref_ord_no as ref_ord_id, aid.article_no as aid_article_no, om.order_no as om_ord_id, om.customer_no as om_customer_id, om.order_flag as order_type, od.order_no as ord_id, bm.bom_no as bom_id,bm.bom_version_no as version_no, bm.shoulder_code as shoulder_id, bm.sleeve_code as sleeve_id, bm.cap_code as cap_code_id , sd.layer_no as sd_layer_no,max(sdle.layer_no) as max_sleeve_layer_no,min(sdle.layer_no) as min_sleeve_layer_no,
    MAX(CASE WHEN sd.parameter_name='MASTER BATCH' THEN sd.mat_article_no END) AS 'SHOULDER_MASTER_BATCH_COLOR',

    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_1',
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_2',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_3',
    MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_4',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_5',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_6',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_article_no END) AS 'SLEEVE_LAYER_7',

    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_1',
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_2',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_3',
    MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_4',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_5',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_6',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='MASTER BATCH' THEN sdle.mat_info END) AS 'SLEEVE_LAYER_PER_7',

    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END)  AS 'LDPE_Layer_1',
    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_1',
    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END)  AS 'HDPE_Layer_1',    
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='ADMER' THEN sdle.mat_info END) AS 'ADMER_Layer_2',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='EVOH' THEN sdle.mat_info END)  AS 'EVOH_Layer_3',
    MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='ADMER' THEN sdle.mat_info END) AS 'ADMER_Layer_4',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END)  AS 'LDPE_Layer_5',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_5',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END) AS  'HDPE_Layer_5',
   
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END) AS  'LDPE_Layer_2',
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_2',
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END)  AS 'HDPE_Layer_2',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='ADMER' THEN sdle.mat_info END) AS 'ADMER_Layer_3',
    MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='EVOH' THEN sdle.mat_info END)  AS 'EVOH_Layer_4',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='ADMER' THEN sdle.mat_info END) AS 'ADMER_Layer_5',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_6',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END)  AS 'HDPE_Layer_6',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END)  AS 'LDPE_Layer_6',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END)  AS 'LDPE_Layer_7',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_7',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END)  AS 'HDPE_Layer_7',
   
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='HDPE' THEN sdle.mat_info END)  AS 'HDPE_Layer_3',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='LDPE' THEN sdle.mat_info END)  AS 'LDPE_Layer_3',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='LLDPE' THEN sdle.mat_info END) AS 'LLDPE_Layer_3',
   
    MAX(CASE WHEN sdle.layer_no='1' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_1',
    MAX(CASE WHEN sdle.layer_no='2' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_2',
    MAX(CASE WHEN sdle.layer_no='3' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_3',
    MAX(CASE WHEN sdle.layer_no='4' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_4',
    MAX(CASE WHEN sdle.layer_no='5' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_5',
    MAX(CASE WHEN sdle.layer_no='6' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_6',
    MAX(CASE WHEN sdle.layer_no='7' AND sdle.parameter_name='GUAGE' THEN sdle.parameter_value END) AS 'GUAGE_Layer_7'

    FROM certificate_of_analysis as coa
        LEFT JOIN user_master as user ON coa.user_id = user.user_id
        LEFT JOIN user_master as users ON coa.approved_by = users.user_id
        LEFT JOIN ar_invoice_master as aim ON coa.certificate_no = aim.ar_invoice_no
        LEFT JOIN ar_invoice_details as aid ON aim.ar_invoice_no = aid.ar_invoice_no
        LEFT JOIN order_master as om ON aid.ref_ord_no = om.order_no
        LEFT JOIN order_details as od ON om.order_no = od.order_no AND aid.ref_ord_no = coa.so_no AND aid.article_no = coa.product_name     
        LEFT JOIN bill_of_material as bm ON od.spec_id = bm.bom_no AND od.spec_version_no= bm.bom_version_no
        LEFT JOIN specification_sheet as ss ON bm.shoulder_code = ss.article_no
        LEFT JOIN specification_sheet as sl ON bm.sleeve_code = sl.article_no
        LEFT JOIN specification_sheet as sle ON bm.sleeve_code = sle.article_no
        LEFT JOIN specification_sheet as sc ON bm.cap_code = sc.article_no
        LEFT JOIN specification_sheet_details as sd ON ss.spec_id = sd.spec_id AND ss.spec_version_no = sd.spec_version_no
        LEFT JOIN specification_sheet_details as sdl ON sl.spec_id = sdl.spec_id AND sl.spec_version_no = sdl.spec_version_no AND sdl.mat_article_no
        LEFT JOIN specification_sheet_details as sdle ON sle.spec_id = sdle.spec_id AND sle.spec_version_no = sdle.spec_version_no
        LEFT JOIN specification_sheet_details as sdc ON sc.spec_id = sdc.spec_id AND sc.spec_version_no = sdc.spec_version_no AND sdl.relating_master_value
        WHERE coa.certificate_no = '$certificate_no' and coa.so_no = '$order_no' and coa.product_name = '$product_no' and coa.company_id = '$company' and (coa.archive<>'1') ORDER BY coa.coa_id desc LIMIT 1 ");
        if (!empty($query)) {
        $item=$query->row_array();
       
        $shoulder_master_batch_color=$this->common_model->get_article_name($item['SHOULDER_MASTER_BATCH_COLOR'],$this->session->userdata['logged_in']['company_id']);
          
           $sleeve_inner_layer='';
           $sleeve_outer_layer='';
           $sleeve_inner_per  ='';
           $sleeve_outer_per  ='';
           $sleeve_tolerance  ='';

          if($item['max_sleeve_layer_no'] == 1){
            $sleeve_inner_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_1'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_outer_layer='';
            $sleeve_inner_per=$item['SLEEVE_LAYER_PER_1'];
            $sleeve_outer_per='';
            $sleeve_tolerance='0.2';
          }elseif($item['max_sleeve_layer_no'] == 3){
            $sleeve_inner_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_1'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_outer_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_3'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_inner_per=$item['SLEEVE_LAYER_PER_1'];
            $sleeve_outer_per=$item['SLEEVE_LAYER_PER_3'];
            $sleeve_tolerance='0.2';
          }elseif($item['max_sleeve_layer_no'] == 5){
            $sleeve_inner_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_1'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_outer_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_5'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_inner_per=$item['SLEEVE_LAYER_PER_1'];
            $sleeve_outer_per=$item['SLEEVE_LAYER_PER_5'];
            $sleeve_tolerance='0.2';  
          }elseif($item['max_sleeve_layer_no'] == 7){
            $sleeve_inner_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_2'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_outer_layer=$this->common_model->get_article_name($item['SLEEVE_LAYER_6'],$this->session->userdata['logged_in']['company_id']);
            $sleeve_inner_per=$item['SLEEVE_LAYER_PER_2'];
            $sleeve_outer_per=$item['SLEEVE_LAYER_PER_6'];
            $sleeve_tolerance='0.3';
          }

        $resultdata = array(  
                "coa_id"                        => $item['coa_id'],
                "certificate_no"                => $item['certificate_no'],
                "inspection_date"               => $item['inspection_date'],
                "customer_name"                 => $item['customer_name'],
                "quality"                       => $item['quality'],
                "product_name"                  => $item['product_name'],
                "total_qty"                     => $item['total_qty'],
                "so_no"                         => $item['so_no'],
                "sample_size"                   => $item['sample_size'],
                "version_no"                    => $item['version_no'],
                "bom_no"                        => $item['bom_id'],
                "layer_no"                      => $item['sd_layer_no'],
                "specification_length"          => $item['specification_length'],
                "actual_length"                 => $item['actual_length'],
                "specification_inner_dia"       => $item['specification_inner_dia'],
                "actual_inner_dia"              => $item['actual_inner_dia'],
                "specification_outer_dia"       => $item['specification_outer_dia'],
                "actual_outer_dia"              => $item['actual_outer_dia'],
                "inner_tolerance"               => $item['inner_tolerance'],
                "outer_tolerance"               => $item['outer_tolerance'],                
                "shoulder_thread_type"          => $item['shoulder_thread_type'],
                "shoulder_master_batch"         => $item['shoulder_master_batch'],
                "specification_orifice"         => $item['specification_orifice'],
                "tolerance_orifice"             => $item['tolerance_orifice'],
                "actual_orifice"                => $item['actual_orifice'],
                "master_batch_orifice"          => $item['master_batch_orifice'],
                "cap_type"                      => $item['cap_type'],
                "cap_master_batch_colour"       => $item['cap_master_batch_colour'],
                "specification_diameter"        => $item['specification_diameter'],
                "actual_diameter"               => $item['actual_diameter'],
                "master_batch_diameter"         => $item['master_batch_diameter'],
                "specification_height"          => $item['specification_height'],
                "actual_height"                 => $item['actual_height'],
                "specification_cap_orifice"     => $item['specification_cap_orifice'],
                "actual_cap_orifice"            => $item['actual_cap_orifice'],
                "specification_shrink_sleeve"   => $item['specification_shrink_sleeve'],
                "actual_shrink_sleeve"          => $item['actual_shrink_sleeve'],
                "specification_print"           => $item['specification_print'],
                "actual_print"                  => $item['actual_print'],
                "lacquer_type"                  => $item['lacquer_type'],
                "lbl_specification"             => $item['lbl_specification'],
                "lbl_actual_print"              => $item['lbl_actual_print'],
                "lbl_lacquer_type"              => $item['lbl_lacquer_type'],
                "air_leakage_status"            => $item['air_leakage_status'],
                "sleeve_colour_opacity_status"  => $item['sleeve_colour_opacity_status'],
                "sleeve_colour_opacity_status"  => $item['sleeve_colour_opacity_status'],
                "water_package_status"          => $item['water_package_status'],
                "gliding_test_status"           => $item['gliding_test_status'],
                "cap_fitment_status"            => $item['cap_fitment_status'],
                "uv_test_status"                => $item['uv_test_status'],
                "shoulder_welding_test_status"  => $item['shoulder_welding_test_status'],
                "drop_test_status"              => $item['drop_test_status'],
                "tape_test_status"              => $item['tape_test_status'],
                "odour_test_status"             => $item['odour_test_status'],
                "rub_test_status"               => $item['rub_test_status'],
                "vertically_test_status"        => $item['vertically_test_status'],
                "sealing_test_status"           => $item['sealing_test_status'],
                "sleeve_colour_difference_status" => $item['sleeve_colour_difference_status'],
                "bar_code_test_status"          => $item['bar_code_test_status'],
                "welding_test_side_seam_status" => $item['welding_test_side_seam_status'],
                "coa_result_status"             => $item['coa_result_status'],
                "escr_test_status"              => $item['escr_test_status'],
                "total_number_of_pallets"       => $item['total_number_of_pallets'],
                "sample_per_pallets"            => $item['sample_per_pallets'],
                "number_of_pallets_rechecked"   => $item['number_of_pallets_rechecked'],
                "SHOULDER_MASTER_BATCH_COLOR"   => $shoulder_master_batch_color,
                "final_approval_flag"           => $item['final_approval_flag'],
                "prepared_name"                 => $item['prepared_name_'],
                "approval_username"             => $item['approved_by_'] != null ? $item['approved_by_'] : '-',
                "max_sleeve_layer_no"           => $item['max_sleeve_layer_no'],
                "SLEEVE_LAYER_1"                => $item['SLEEVE_LAYER_1'],
                "SLEEVE_LAYER_2"                => $item['SLEEVE_LAYER_2'],
                "SLEEVE_LAYER_3"                => $item['SLEEVE_LAYER_3'],
                "SLEEVE_LAYER_4"                => $item['SLEEVE_LAYER_4'],
                "SLEEVE_LAYER_5"                => $item['SLEEVE_LAYER_5'],
                "SLEEVE_LAYER_6"                => $item['SLEEVE_LAYER_6'],
                "SLEEVE_LAYER_7"                => $item['SLEEVE_LAYER_7'],
                "sleeve_inner_layer_color"      => $sleeve_inner_layer,
                "sleeve_outer_layer_color"      => $sleeve_outer_layer,
                "sleeve_inner_per"              => $sleeve_inner_per,
                "sleeve_outer_per"              => $sleeve_outer_per,
                "sleeve_tolerance"              => $sleeve_tolerance,
                "LAYER_1"                       
                => ($item['LDPE_Layer_1']<>'' && $item['LDPE_Layer_1']<>0 ? $item['LDPE_Layer_1']."%LDPE" : '').' '.($item['LLDPE_Layer_1']<>'' && $item['LLDPE_Layer_1']<>0 ? $item['LLDPE_Layer_1']."%LLDPE" : '').' '.($item['HDPE_Layer_1']<>'' && $item['HDPE_Layer_1']<>0 ? $item['HDPE_Layer_1']."%HDPE" : '').''.($item['LDPE_Layer_1']=='' && $item['LLDPE_Layer_1']=='' && $item['HDPE_Layer_1']=='' ? '-' : ''),                
                "LAYER_2"                       
                => ($item['LDPE_Layer_2']<>'' && $item['LDPE_Layer_2']<>0 ? $item['LDPE_Layer_2']."%LDPE" : '').' '.($item['LLDPE_Layer_2']<>'' && $item['LLDPE_Layer_2']<>0 ? $item['LLDPE_Layer_2']."%LLDPE" : '').' '.($item['HDPE_Layer_2']<>'' && $item['HDPE_Layer_2']<>0 ? $item['HDPE_Layer_2']."%HDPE" : '').' '.($item['ADMER_Layer_2']<>''  ? $item['ADMER_Layer_2']."%ADMER" : '').''.($item['LDPE_Layer_2']=='' && $item['LLDPE_Layer_2']=='' && $item['HDPE_Layer_2']=='' && $item['ADMER_Layer_2']==''? '-' : ''),
                "LAYER_3"                       
                => ($item['ADMER_Layer_3']<>'' ? $item['ADMER_Layer_3']."%ADMER" : '').' '.($item['EVOH_Layer_3']<>'' ? $item['EVOH_Layer_3']."%EVOH" : '').' '.($item['LDPE_Layer_3']<>'' && $item['LDPE_Layer_3']<>0 ? $item['LDPE_Layer_3']."%LDPE" : '').' '.($item['LLDPE_Layer_3']<>'' && $item['LLDPE_Layer_3']<>0 ? $item['LLDPE_Layer_3']."%LLDPE" : '').' '.($item['HDPE_Layer_3']<>'' && $item['HDPE_Layer_3']<>0 ? $item['HDPE_Layer_3']."%HDPE" : '').''.($item['ADMER_Layer_3']=='' && $item['EVOH_Layer_3']=='' && $item['LDPE_Layer_3']=='' && $item['LLDPE_Layer_3']=='' && $item['HDPE_Layer_3']==''? '-' : ''),
                "LAYER_4"                       
                => ($item['ADMER_Layer_4']<>'' ? $item['ADMER_Layer_4']."%ADMER" : '').' '.($item['EVOH_Layer_4']<>'' ? $item['EVOH_Layer_4']."%EVOH" : '').''.($item['ADMER_Layer_4']=='' && $item['EVOH_Layer_4']=='' ? '-' : ''),
                "LAYER_5"                       
                => ($item['LDPE_Layer_5']<>'' && $item['LDPE_Layer_5']<>0 ? $item['LDPE_Layer_5']."%LDPE" : '').' '.($item['LLDPE_Layer_5']<>'' && $item['LLDPE_Layer_5']<>0 ? $item['LLDPE_Layer_5']."%LLDPE" : '').' '.($item['HDPE_Layer_5']<>'' && $item['HDPE_Layer_5']<>0 ? $item['HDPE_Layer_5']."%HDPE" : '').' '.($item['ADMER_Layer_5']<>''  ? $item['ADMER_Layer_5']."%ADMER" : '').''.($item['LDPE_Layer_5']=='' && $item['LLDPE_Layer_5']=='' && $item['HDPE_Layer_5']=='' && $item['ADMER_Layer_5']=='' ? '-' : ''),
                "LAYER_6"                       
                => ($item['LLDPE_Layer_6']<>'' && $item['LLDPE_Layer_6']<>0 ? $item['LLDPE_Layer_6']."%LLDPE" : '').' '.($item['HDPE_Layer_6']<>'' && $item['HDPE_Layer_6']<>0 ? $item['HDPE_Layer_6']."%HDPE" : '').' '.($item['LDPE_Layer_6']<>'' && $item['LDPE_Layer_6']<>0 ? $item['LDPE_Layer_6']."%LDPE" : '').''.($item['LLDPE_Layer_6']=='' && $item['HDPE_Layer_6']=='' && $item['LDPE_Layer_6']=='' ? '-' : ''),
                "LAYER_7"                       
                => ($item['LDPE_Layer_7']<>'' && $item['LDPE_Layer_7']<>0 ? $item['LDPE_Layer_7']."%LDPE" : '').' '.($item['LLDPE_Layer_7']<>'' && $item['LLDPE_Layer_7']<>0 ? $item['LLDPE_Layer_7']."%LLDPE" : '').' '.($item['HDPE_Layer_7']<>'' && $item['HDPE_Layer_7']<>0 ? $item['HDPE_Layer_7']."%HDPE" : '').''.($item['LDPE_Layer_7']=='' && $item['LLDPE_Layer_7']=='' && $item['HDPE_Layer_7']=='' ? '-' : ''),
               "GUAGE_Layer_1"                  =>($item['GUAGE_Layer_1']<>''   ? $item['GUAGE_Layer_1']." Micron" : '-'),
               "GUAGE_Layer_2"                  =>($item['GUAGE_Layer_2']<>''   ? $item['GUAGE_Layer_2']." Micron" : '-'),
               "GUAGE_Layer_3"                  =>($item['GUAGE_Layer_3']<>''   ? $item['GUAGE_Layer_3']." Micron" : '-'),
               "GUAGE_Layer_4"                  =>($item['GUAGE_Layer_4']<>''   ? $item['GUAGE_Layer_4']." Micron" : '-'),
               "GUAGE_Layer_5"                  =>($item['GUAGE_Layer_5']<>''   ? $item['GUAGE_Layer_5']." Micron" : '-'),
               "GUAGE_Layer_6"                  =>($item['GUAGE_Layer_6']<>''   ? $item['GUAGE_Layer_6']." Micron" : '-'),
               "GUAGE_Layer_7"                  =>($item['GUAGE_Layer_7']<>''   ? $item['GUAGE_Layer_7']." Micron" : '-'),
            );            
        }
        return $resultdata;
    } 

  function get_layer_details($bom_no,$version_no,$layer_no,$parameter_data){

    $sql="SELECT bm.bom_no,bm.bom_version_no,ss.article_no,ss.spec_id,ss.spec_version_no,";
          if(!empty($parameter_data)){
              $abc ='';
                foreach($parameter_data as $parameter_data_value){
                  $abc.="MAX(CASE WHEN ssd.parameter_name='$parameter_data_value' THEN ssd.mat_article_no END) AS '$parameter_data_value', MAX(CASE WHEN ssd.parameter_name='$parameter_data_value' THEN ssd.parameter_value END) AS '$parameter_data_value',MAX(CASE WHEN ssd.parameter_name='$parameter_data_value' THEN ssd.mat_info END) AS " .$parameter_data_value."_PC," ;
              }
            $sql.=rtrim($abc,",");
          }


    $sql.=" FROM `bill_of_material` as bm LEFT JOIN specification_sheet as ss ON bm.sleeve_code=ss.article_no RIGHT JOIN specification_sheet_details as ssd ON ss.spec_id=ssd.spec_id AND ss.spec_version_no=ssd.spec_version_no WHERE bm.bom_no='$bom_no' AND bm.bom_version_no='$version_no' AND ssd.layer_no='$layer_no'";

    $query=$this->db->query($sql);
    //echo $this->db->last_query();
    return $result=$query->result();
}


function get_sholder_details($bom_no,$version_no,$layer_no){

    $sql="SELECT bm.bom_no,bm.bom_version_no,ss.article_no,ss.spec_id,ss.spec_version_no,MAX(CASE WHEN ssd.parameter_name='STYLE' THEN ssd.relating_master_value END) AS 'SHOULDER_STYLE' FROM `bill_of_material` as bm 
      LEFT JOIN specification_sheet as ss ON bm.shoulder_code=ss.article_no 
      RIGHT JOIN specification_sheet_details as ssd ON ss.spec_id=ssd.spec_id AND ss.spec_version_no=ssd.spec_version_no 
      WHERE bm.bom_no='$bom_no' AND bm.bom_version_no='$version_no' AND ssd.layer_no='$layer_no'";

    $query=$this->db->query($sql);
    return $result=$query->result();
}

public function get_coa_ajax_details($table,$company){
  $this->db->select($table.'.*,od.order_no,bm.bom_no,bm.bom_version_no,ssd.layer_no');
  $this->db->from($table);
  $this->db->join('order_details as od',$table.'.so_no= od.order_no','LEFT');
  $this->db->join('ar_invoice_details as aid','od'.'.order_no=aid.ref_ord_no','LEFT');
  $this->db->join('bill_of_material as bm','od'.'.spec_id=bm.bom_no','LEFT');
  $this->db->join('specification_sheet as ss','bm'.'.sleeve_code=ss.article_no','LEFT');
  $this->db->join('specification_sheet_details as ssd','ss'.'.spec_id=ssd.spec_id','LEFT');

  $this->db->where($table.'.company_id',$company);
  $this->db->where($pkey1,$edit1);
  //$this->db->limit($limit, $start);
  $query = $this->db->get();
  return $result=$query->result(); 
}


/*public function get_ajax_ar_invoice_no_id($ar_invoice_no_id,$ar_order_no_id,$ar_product_no_id){
  if($ar_invoice_no_id=='' && $ar_order_no_id=='' && $ar_product_no_id==''){
    header('Content-Type: application/json');
    echo json_encode(array('status' => 400, 'message' => 'Error! Order details not found, try later!'));
  }
  else{
    $query = $this->db->query("SELECT aim.ar_invoice_no as aim_id, aim.invoice_date as in_date, aid.ar_invoice_no as aid_id, aid.ref_ord_no as ref_ord_id, aid.article_no as aid_article_no, om.order_no as om_ord_id, om.customer_no as om_customer_id, om.order_flag as order_type, ode.order_no as ord_id, bm.bom_no as bom_id, bm.shoulder_code as shoulder_id, bm.sleeve_code as sleeve_id, bm.cap_code as cap_code_id, ss.article_no as article_id, ss.spec_id as ss_id, sd.spec_id as sd_id, ss.spec_version_no as sd_version,sdl.relating_master_value,sdm.sleeve_diameter as sleeve_diameter_id,artd.version_no as art_version_no,ode.version_no as order_version_no,artd.ad_id as art_ad_id,ode.ad_id as od_ad_id,sartd.ad_id as sart_ad_id,sartd.version_no as sart_version_no,

      MAX(CASE WHEN sd.parameter_name='STYLE' THEN sd.relating_master_value END) AS 'SHOULDER_STYLE',
      MAX(CASE WHEN sd.parameter_name='ORIFICE' THEN sd.relating_master_value END) AS 'SHOULDER_ORIFICE',
      MAX(CASE WHEN sd.parameter_name='MASTER BATCH' THEN sd.item_group_material END) AS 'SHOULDER_MASTER_BATCH',
      MAX(CASE WHEN sd.parameter_name='MASTER BATCH' THEN sd.mat_info END) AS 'SHOULDER_MASTER_BATCH_INFO',
      MAX(CASE WHEN sd.parameter_name='MASTER BATCH' THEN sd.mat_article_no END) AS 'SHOULDER_MASTER_BATCH_ARTICAL_NO',
       
      MAX(CASE WHEN sdl.parameter_name='DIA' THEN sdl.relating_master_value END) AS 'SLEEVE_DIA',
      MAX(CASE WHEN sdle.parameter_name='LENGTH' THEN sdle.parameter_value END) AS 'SLEEVE_LENGTH',

      IF( om.order_flag = 0, sdm.inner_diameter, sdm.inner_dia_spring ) AS INNER_DIA,
      IF( om.order_flag = 0, sdm.outer_diameter, sdm.outer_dia_spring ) AS OUTER_DIA,
      IF( om.order_flag = 0, sdm.in_coex_tolerance, sdm.out_spring_tolerance ) AS INNER_TOLERANCE,
      IF( om.order_flag = 0, sdm.out_coex_tolerance, sdm.out_spring_tolerance ) AS OUTER_TOLERANCE,

      MAX(CASE WHEN sdc.parameter_name='STYLE' THEN sdc.relating_master_value END) AS 'CAP_DIA',
      MAX(CASE WHEN sdc.parameter_name='DIAMETER' THEN sdc.relating_master_value END) AS 'CAP_DIAMETER',
      MAX(CASE WHEN sdc.parameter_name='ORIFICE' THEN sdc.relating_master_value END) AS 'CAP_ORIFICE',
      MAX(CASE WHEN sdc.parameter_name='SHRINK SLEEVE' THEN sdc.parameter_value END) AS 'CAP_SHRINK_SLEEVE',
      MAX(CASE WHEN sdc.parameter_name='MASTER BATCH' THEN sdc.item_group_material END) AS 'CAP_MASTER_BATCH',
      MAX(CASE WHEN sdc.parameter_name='MASTER BATCH' THEN sdc.mat_info END) AS 'CAP_MASTER_BATCH_INFO',
      MAX(CASE WHEN sdc.parameter_name='MASTER BATCH' THEN sdc.mat_article_no END) AS 'CAP_ARTICAL_NO',
      MAX(CASE WHEN artd.artwork_para_id='5' THEN artd.parameter_value END) AS 'ARTWORK_NON_LACQ_AREA_COEX',
      MAX(CASE WHEN sartd.artwork_para_id='16' THEN sartd.parameter_value END) AS 'ARTWORK_NON_LACQ_AREA_SPRING',
      MAX(CASE WHEN artd.artwork_para_id='27' THEN artd.parameter_value END) AS 'ARTWORK_LACQ_TYPE_COEX',
      MAX(CASE WHEN sartd.artwork_para_id='12' THEN sartd.parameter_value END) AS 'ARTWORK_LACQ_TYPE_SPRING'
      FROM ar_invoice_master as aim

      LEFT JOIN ar_invoice_details as aid ON aim.ar_invoice_no = aid.ar_invoice_no
      LEFT JOIN order_master as om ON aid.ref_ord_no = om.order_no
      LEFT JOIN order_details as ode ON om.order_no = ode.order_no
      LEFT JOIN artwork_devel_details as artd ON ode.ad_id =artd.ad_id  AND ode.version_no = artd.version_no
      LEFT JOIN artwork_parameter_master as artm ON artd.artwork_para_id =artm.artwork_para_id
      LEFT JOIN springtube_artwork_devel_details as sartd ON ode.ad_id =sartd.ad_id  AND ode.version_no = sartd.version_no
      LEFT JOIN springtube_artwork_parameter_master as sartm ON sartd.artwork_para_id =sartm.artwork_para_id
      LEFT JOIN bill_of_material as bm ON ode.spec_id = bm.bom_no AND ode.spec_version_no= bm.bom_version_no
      LEFT JOIN specification_sheet as ss ON bm.shoulder_code = ss.article_no
      LEFT JOIN specification_sheet as sl ON bm.sleeve_code = sl.article_no
      LEFT JOIN specification_sheet as sle ON bm.sleeve_code = sle.article_no
      LEFT JOIN specification_sheet as sc ON bm.cap_code = sc.article_no  
      LEFT JOIN specification_sheet_details as sd ON ss.spec_id = sd.spec_id AND ss.spec_version_no = sd.spec_version_no
      LEFT JOIN specification_sheet_details as sdl ON sl.spec_id = sdl.spec_id AND sl.spec_version_no = sdl.spec_version_no AND sdl.relating_master_value
      LEFT JOIN specification_sheet_details as sdle ON sle.spec_id = sdle.spec_id AND sle.spec_version_no = sdle.spec_version_no AND sdle.parameter_value
      LEFT JOIN specification_sheet_details as sdc ON sc.spec_id = sdc.spec_id AND sc.spec_version_no = sdc.spec_version_no AND sdl.relating_master_value
      LEFT JOIN sleeve_diameter_master as sdm ON sdl.relating_master_value = sdm.sleeve_diameter
      WHERE aim.ar_invoice_no = '$ar_invoice_no_id' and aid.ref_ord_no = '$ar_order_no_id' and aid.article_no = '$ar_product_no_id'");
 
  if(!empty($query)){  
      $item=$query->row_array();  
     
      $customer_name=$this->common_model->get_customer_name($item['om_customer_id'],$this->session->userdata['logged_in']['company_id']);
      $cap_master_batch_color=$this->common_model->get_article_name($item['CAP_ARTICAL_NO'],$this->session->userdata['logged_in']['company_id']);
      $shoulder_master_batch_color=$this->common_model->get_article_name($item['SHOULDER_MASTER_BATCH_ARTICAL_NO'],$this->session->userdata['logged_in']['company_id']);

      if ($item['CAP_SHRINK_SLEEVE']!='') {
        $cap_shrink_sleeve=" YES";
      }else{
        $cap_shrink_sleeve="No";
      }
     

      $ARTWORK_LACQ_TYPE = '';
      if (strpos($item['ARTWORK_LACQ_TYPE_COEX'], 'RM-LQ-GLAC') !== FALSE ) {
          $ARTWORK_LACQ_TYPE='GLOSS';
      }elseif (strpos($item['ARTWORK_LACQ_TYPE_COEX'], 'RM-LQ-MLAC') !== FALSE ) {
          $ARTWORK_LACQ_TYPE='MATT';
      }elseif (strpos($item['ARTWORK_LACQ_TYPE_SPRING'], 'RM-LQ-GLAC') !== FALSE  ) {
          $ARTWORK_LACQ_TYPE='GLOSS';
      }elseif (strpos($item['ARTWORK_LACQ_TYPE_SPRING'], 'RM-LQ-MLAC') !== FALSE ) {
        $ARTWORK_LACQ_TYPE="MATT";
      }
      $resultdata = array(  
          "ar_invoice_no"          => $item['aim_id'] != null ? $item['aim_id'] : '-',
          "invoice_date"           => $item['in_date'] != null ? $item['in_date'] : '-',
          "aid_article_no"         => $item['aid_article_no'] != null ? $item['aid_article_no'] : '-',
          "customer_no"            => $item['om_customer_id'] != null ? $item['om_customer_id'] : '-',
          "customer_name"          => $customer_name,
          "order_no"               => $item['ord_id'] != null ? $item['ord_id'] : '-',
          "shoulder_style"         => $item['SHOULDER_STYLE'] != null ? $item['SHOULDER_STYLE'] : '-',
          "shoulder_orifice"       => $item['SHOULDER_ORIFICE'] != null ? $item['SHOULDER_ORIFICE'] : '-',
          "shoulder_batch"         => $item['SHOULDER_MASTER_BATCH'] != null ? $item['SHOULDER_MASTER_BATCH'] : '-',
          "shoulder_info"          => $item['SHOULDER_MASTER_BATCH_INFO'] != null ? $item['SHOULDER_MASTER_BATCH_INFO'] : '-',
          "shoulder_artical_no"    => $shoulder_master_batch_color,
          "sleeve_dia"             => $item['SLEEVE_DIA'] != null ? $item['SLEEVE_DIA'] : '-',
          "sleeve_length"          => $item['SLEEVE_LENGTH'] != null ? $item['SLEEVE_LENGTH'] : '-',
          "inner_diameter"         => $item['INNER_DIA'] != null ? $item['INNER_DIA'] : '-',
          "outer_diameter"         => $item['OUTER_DIA'] != null ? $item['OUTER_DIA'] : '-',
          "inner_tolerance"        => $item['INNER_TOLERANCE'] != null ? $item['INNER_TOLERANCE'] : '-',
          "outer_tolerance"        => $item['OUTER_TOLERANCE'] != null ? $item['OUTER_TOLERANCE'] : '-',
          "cap_dia"                => $item['CAP_DIA'] != null ? $item['CAP_DIA'] : '-',
          "cap_diameter"           => $item['CAP_DIAMETER'] != null ? $item['CAP_DIAMETER'] : '-',
          "cap_orifice"            => $item['CAP_ORIFICE'] != null ? $item['CAP_ORIFICE'] : '-',
          "cap_shrink_sleeve"      => $cap_shrink_sleeve,
          "cap_master_batch"       => $item['CAP_MASTER_BATCH'] != null ? $item['CAP_MASTER_BATCH'] : '-',
          "cap_master_batch_info"  => $item['CAP_MASTER_BATCH_INFO'] != null ? $item['CAP_MASTER_BATCH_INFO'] : '-',
          "cap_artical_no"         => $item['CAP_ARTICAL_NO'] != null ? $item['CAP_ARTICAL_NO'] : '-',
          "cap_master_batch_color" => $cap_master_batch_color,
          "artwork_type"           => $ARTWORK_LACQ_TYPE,
          "artwork_name"           => ($item['ARTWORK_NON_LACQ_AREA_COEX']<>'' ? $item['ARTWORK_NON_LACQ_AREA_COEX'] : $item['ARTWORK_NON_LACQ_AREA_SPRING'])
      );
     
      header('Content-Type: application/json');
      echo json_encode(array('status' => 200,'message' => 'success','data' => $resultdata));
    }
    else{
      header('Content-Type: application/json');
      echo json_encode(array('status' => 400, 'message' => 'Error! Vessal details not found, try later!'));
    }    
  }
}*/



public function get_ajax_ar_invoice_no_id($ar_invoice_no_id,$ar_order_no_id,$ar_product_no_id){
  if($ar_invoice_no_id=='' && $ar_order_no_id=='' && $ar_product_no_id==''){
    header('Content-Type: application/json');
    echo json_encode(array('status' => 400, 'message' => 'Error! Order details not found, try later!'));
  }
  else{
    $query = $this->db->query("SELECT aim.ar_invoice_no as aim_id, aim.invoice_date as in_date, aid.ar_invoice_no as aid_id, aid.ref_ord_no as ref_ord_id, aid.article_no as aid_article_no, om.order_no as om_ord_id, om.customer_no as om_customer_id, om.order_flag as order_type, ode.order_no as ord_id, bm.bom_no as bom_id, bm.shoulder_code as shoulder_id, bm.sleeve_code as sleeve_id, bm.cap_code as cap_code_id, ss.article_no as article_id, ss.spec_id as ss_id, sd.spec_id as sd_id, ss.spec_version_no as sd_version,sdl.relating_master_value,sdm.sleeve_diameter as sleeve_diameter_id,artd.version_no as art_version_no,ode.version_no as order_version_no,artd.ad_id as art_ad_id,ode.ad_id as od_ad_id,sartd.ad_id as sart_ad_id,sartd.version_no as sart_version_no,

      MAX(CASE WHEN sd.parameter_name='STYLE' THEN sd.relating_master_value END) AS 'SHOULDER_STYLE',
      MAX(CASE WHEN sd.parameter_name='ORIFICE' THEN sd.relating_master_value END) AS 'SHOULDER_ORIFICE',
      MAX(CASE WHEN sd.parameter_name='MASTER BATCH' THEN sd.item_group_material END) AS 'SHOULDER_MASTER_BATCH',
      MAX(CASE WHEN sd.parameter_name='MASTER BATCH' THEN sd.mat_info END) AS 'SHOULDER_MASTER_BATCH_INFO',
      MAX(CASE WHEN sd.parameter_name='MASTER BATCH' THEN sd.mat_article_no END) AS 'SHOULDER_MASTER_BATCH_ARTICAL_NO',
       
      MAX(CASE WHEN sdl.parameter_name='DIA' THEN sdl.relating_master_value END) AS 'SLEEVE_DIA',
      MAX(CASE WHEN sdle.parameter_name='LENGTH' THEN sdle.parameter_value END) AS 'SLEEVE_LENGTH',

      IF( om.order_flag = 0, sdm.inner_diameter, sdm.inner_dia_spring ) AS INNER_DIA,
      IF( om.order_flag = 0, sdm.outer_diameter, sdm.outer_dia_spring ) AS OUTER_DIA,
      IF( om.order_flag = 0, sdm.in_coex_tolerance, sdm.out_spring_tolerance ) AS INNER_TOLERANCE,
      IF( om.order_flag = 0, sdm.out_coex_tolerance, sdm.out_spring_tolerance ) AS OUTER_TOLERANCE,

      MAX(CASE WHEN sdc.parameter_name='STYLE' THEN sdc.relating_master_value END) AS 'CAP_DIA',
      MAX(CASE WHEN sdc.parameter_name='DIAMETER' THEN sdc.relating_master_value END) AS 'CAP_DIAMETER',
      MAX(CASE WHEN sdc.parameter_name='ORIFICE' THEN sdc.relating_master_value END) AS 'CAP_ORIFICE',
      MAX(CASE WHEN sdc.parameter_name='SHRINK SLEEVE' THEN sdc.parameter_value END) AS 'CAP_SHRINK_SLEEVE',
      MAX(CASE WHEN sdc.parameter_name='MASTER BATCH' THEN sdc.item_group_material END) AS 'CAP_MASTER_BATCH',
      MAX(CASE WHEN sdc.parameter_name='MASTER BATCH' THEN sdc.mat_info END) AS 'CAP_MASTER_BATCH_INFO',
      MAX(CASE WHEN sdc.parameter_name='MASTER BATCH' THEN sdc.mat_article_no END) AS 'CAP_ARTICAL_NO',
    MAX(CASE WHEN sdlbl.parameter_name='LACQUER ONE' THEN sdlbl.mat_article_no END) AS 'LBL_LACQUER_ONE',
    MAX(CASE WHEN sdlbl.parameter_name='LACQUER TWO' THEN sdlbl.mat_article_no END) AS 'LBL_LACQUER_TWO',
    MAX(CASE WHEN sdlbl.parameter_name='NON LABELING HEIGHT' THEN sdlbl.parameter_value END) AS 'LBL_NON_LABELING_HEIGHT',
      MAX(CASE WHEN artd.artwork_para_id='5' THEN artd.parameter_value END) AS 'ARTWORK_NON_LACQ_AREA_COEX',
      MAX(CASE WHEN sartd.artwork_para_id='16' THEN sartd.parameter_value END) AS 'ARTWORK_NON_LACQ_AREA_SPRING',
      MAX(CASE WHEN artd.artwork_para_id='27' THEN artd.parameter_value END) AS 'ARTWORK_LACQ_TYPE_COEX',
      MAX(CASE WHEN sartd.artwork_para_id='12' THEN sartd.parameter_value END) AS 'ARTWORK_LACQ_TYPE_SPRING'
      FROM ar_invoice_master as aim

      LEFT JOIN ar_invoice_details as aid ON aim.ar_invoice_no = aid.ar_invoice_no
      LEFT JOIN order_master as om ON aid.ref_ord_no = om.order_no
      LEFT JOIN order_details as ode ON om.order_no = ode.order_no
      LEFT JOIN artwork_devel_details as artd ON ode.ad_id =artd.ad_id  AND ode.version_no = artd.version_no
      LEFT JOIN artwork_parameter_master as artm ON artd.artwork_para_id =artm.artwork_para_id
      LEFT JOIN springtube_artwork_devel_details as sartd ON ode.ad_id =sartd.ad_id  AND ode.version_no = sartd.version_no
      LEFT JOIN springtube_artwork_parameter_master as sartm ON sartd.artwork_para_id =sartm.artwork_para_id
      LEFT JOIN bill_of_material as bm ON ode.spec_id = bm.bom_no AND ode.spec_version_no= bm.bom_version_no
      LEFT JOIN specification_sheet as ss  ON bm.shoulder_code = ss.article_no
      LEFT JOIN specification_sheet as sl  ON bm.sleeve_code   = sl.article_no
      LEFT JOIN specification_sheet as sle ON bm.sleeve_code   = sle.article_no
      LEFT JOIN specification_sheet as sc  ON bm.cap_code      = sc.article_no  
      LEFT JOIN specification_sheet as lbl ON bm.label_code    = lbl.article_no 
      LEFT JOIN specification_sheet_details as sd ON ss.spec_id = sd.spec_id AND ss.spec_version_no = sd.spec_version_no
      LEFT JOIN specification_sheet_details as sdl ON sl.spec_id = sdl.spec_id AND sl.spec_version_no = sdl.spec_version_no AND sdl.relating_master_value
      LEFT JOIN specification_sheet_details as sdle ON sle.spec_id = sdle.spec_id AND sle.spec_version_no = sdle.spec_version_no AND sdle.parameter_value
      LEFT JOIN specification_sheet_details as sdc ON sc.spec_id = sdc.spec_id AND sc.spec_version_no = sdc.spec_version_no AND sdl.relating_master_value
    LEFT JOIN specification_sheet_details as sdlbl ON lbl.spec_id = sdlbl.spec_id AND lbl.spec_version_no = sdlbl.spec_version_no AND sdl.relating_master_value
      LEFT JOIN sleeve_diameter_master as sdm ON sdl.relating_master_value = sdm.sleeve_diameter

      
      WHERE aim.ar_invoice_no = '$ar_invoice_no_id' and aid.ref_ord_no = '$ar_order_no_id' and aid.article_no = '$ar_product_no_id'");
 
  if(!empty($query)){  
      $item=$query->row_array();  
     
      $customer_name=$this->common_model->get_customer_name($item['om_customer_id'],$this->session->userdata['logged_in']['company_id']);
      $cap_master_batch_color=$this->common_model->get_article_name($item['CAP_ARTICAL_NO'],$this->session->userdata['logged_in']['company_id']);
      $shoulder_master_batch_color=$this->common_model->get_article_name($item['SHOULDER_MASTER_BATCH_ARTICAL_NO'],$this->session->userdata['logged_in']['company_id']);
    
      $label_lacquer_one=$this->common_model->get_article_name($item['LBL_LACQUER_ONE'],$this->session->userdata['logged_in']['company_id']);
    
      $label_lacquer_two=$this->common_model->get_article_name($item['LBL_LACQUER_TWO'],$this->session->userdata['logged_in']['company_id']);

      if ($item['CAP_SHRINK_SLEEVE']!='') {
        $cap_shrink_sleeve=" YES";
      }else{
        $cap_shrink_sleeve="No";
      }
     

      $ARTWORK_LACQ_TYPE = '';
      if (strpos($item['ARTWORK_LACQ_TYPE_COEX'], 'RM-LQ-GLAC') !== FALSE ) {
          $ARTWORK_LACQ_TYPE='GLOSS';
      }elseif (strpos($item['ARTWORK_LACQ_TYPE_COEX'], 'RM-LQ-MLAC') !== FALSE ) {
          $ARTWORK_LACQ_TYPE='MATT';
      }elseif (strpos($item['ARTWORK_LACQ_TYPE_SPRING'], 'RM-LQ-GLAC') !== FALSE  ) {
          $ARTWORK_LACQ_TYPE='GLOSS';
      }elseif (strpos($item['ARTWORK_LACQ_TYPE_SPRING'], 'RM-LQ-MLAC') !== FALSE ) {
        $ARTWORK_LACQ_TYPE="MATT";
      }
    
    $LBL_LACQUER_TYPE = '';
    if(strpos($label_lacquer_one, 'GLOSS')){
      $LBL_LACQUER_TYPE ='GLOSS';
    }elseif(strpos($label_lacquer_one, 'MATT')){
      $LBL_LACQUER_TYPE ='MATT';
    }elseif($label_lacquer_one && $label_lacquer_two){
      $LBL_LACQUER_TYPE ='MATT';
    }
    
    
      $resultdata = array(  
          "ar_invoice_no"          => $item['aim_id'] != null ? $item['aim_id'] : '-',
          "invoice_date"           => $item['in_date'] != null ? $item['in_date'] : '-',
          "aid_article_no"         => $item['aid_article_no'] != null ? $item['aid_article_no'] : '-',
          "customer_no"            => $item['om_customer_id'] != null ? $item['om_customer_id'] : '-',
          "customer_name"          => $customer_name,
          "order_no"               => $item['ord_id'] != null ? $item['ord_id'] : '-',
          "shoulder_style"         => $item['SHOULDER_STYLE'] != null ? $item['SHOULDER_STYLE'] : '-',
          "shoulder_orifice"       => $item['SHOULDER_ORIFICE'] != null ? $item['SHOULDER_ORIFICE'] : '-',
          "shoulder_batch"         => $item['SHOULDER_MASTER_BATCH'] != null ? $item['SHOULDER_MASTER_BATCH'] : '-',
          "shoulder_info"          => $item['SHOULDER_MASTER_BATCH_INFO'] != null ? $item['SHOULDER_MASTER_BATCH_INFO'] : '-',
          "shoulder_artical_no"    => $shoulder_master_batch_color,
          "sleeve_dia"             => $item['SLEEVE_DIA'] != null ? $item['SLEEVE_DIA'] : '-',
          "sleeve_length"          => $item['SLEEVE_LENGTH'] != null ? $item['SLEEVE_LENGTH'] : '-',
          "inner_diameter"         => $item['INNER_DIA'] != null ? $item['INNER_DIA'] : '-',
          "outer_diameter"         => $item['OUTER_DIA'] != null ? $item['OUTER_DIA'] : '-',
          "inner_tolerance"        => $item['INNER_TOLERANCE'] != null ? $item['INNER_TOLERANCE'] : '-',
          "outer_tolerance"        => $item['OUTER_TOLERANCE'] != null ? $item['OUTER_TOLERANCE'] : '-',
          "cap_dia"                => $item['CAP_DIA'] != null ? $item['CAP_DIA'] : '-',
          "cap_diameter"           => $item['CAP_DIAMETER'] != null ? $item['CAP_DIAMETER'] : '-',
          "cap_orifice"            => $item['CAP_ORIFICE'] != null ? $item['CAP_ORIFICE'] : '-',
          "cap_shrink_sleeve"      => $cap_shrink_sleeve,
          "cap_master_batch"       => $item['CAP_MASTER_BATCH'] != null ? $item['CAP_MASTER_BATCH'] : '-',
          "cap_master_batch_info"  => $item['CAP_MASTER_BATCH_INFO'] != null ? $item['CAP_MASTER_BATCH_INFO'] : '-',
          "cap_artical_no"         => $item['CAP_ARTICAL_NO'] != null ? $item['CAP_ARTICAL_NO'] : '-',
          "cap_master_batch_color" => $cap_master_batch_color,          
          "label_type"             => $LBL_LACQUER_TYPE != null ? $LBL_LACQUER_TYPE : '-',
          "label_height"           => $item['LBL_NON_LABELING_HEIGHT'] != null ? $item['LBL_NON_LABELING_HEIGHT'] : '-',
          "artwork_type"           => $ARTWORK_LACQ_TYPE != null ? $ARTWORK_LACQ_TYPE : '-',
          "artwork_name"           => ($item['ARTWORK_NON_LACQ_AREA_COEX']<>'' ? $item['ARTWORK_NON_LACQ_AREA_COEX'] : $item['ARTWORK_NON_LACQ_AREA_SPRING'])
      );
     
      header('Content-Type: application/json');
      echo json_encode(array('status' => 200,'message' => 'success','data' => $resultdata));
    }
    else{
      header('Content-Type: application/json');
      echo json_encode(array('status' => 400, 'message' => 'Error! Vessal details not found, try later!'));
    }    
  }
}


public function active_record_search($table,$data,$from,$to,$company){
    $this->db->select('*');
    $this->db->from($table);
    $this->db->where($table.'.archive<>', '1');
    $this->db->where($table.'.company_id',$company);
    
    if(!empty($from) && !empty($to)){
      $this->db->where(''.$table.'.inspection_date >=', $from);
    $this->db->where(''.$table.'.inspection_date <=', $to);
    }
    foreach($data as $key => $value) {
      $this->db->where($key,$value);
    }
    $this->db->order_by('certificate_of_analysis.coa_id desc');
    $query = $this->db->get();
    return $result=$query->result();
  }

public function get_approval_authority(){
  $resultdata=array();
  $query = $this->db->query("SELECT id, state  FROM `state_list` ORDER BY id asc");
  if (!empty($query)) { 
  $data=array();
    foreach ($query->result_array() as $item) {
      $resultdata[] = array(
        "id"   => $item['id'],
        "name" => $item['state'],
      );
    }
  }
  return $resultdata;
}

  public function check_so_no_duplication($action = "", $field = "", $so_no = "") {
      $duplicate_so_no_check = $this->db->get_where('certificate_of_analysis', array(
          $field => $so_no
      ));
      
      if ($action == 'on_create') {
          if ($duplicate_so_no_check->num_rows() > 0) {
              return false;
          } else {
              return true;
          }
      }
  }

}
?>

