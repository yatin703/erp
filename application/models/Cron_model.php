  <?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Cron_model extends CI_Model {

	public function ink_email_send($from_date,$to_date){

   $query =$this->db->query("SELECT aim.invoice_date, aim.ar_invoice_no, aid.ref_ord_no, aid.article_no, od.ad_id,od.version_no,cicm.artwork_no,cicm.artwork_version_no,od.print_type,cicm.flexo_ink_gm_tube,cicm.screen_ink_gm_tube,cicm.offset_ink_gm_tube,cicm.special_ink_gm_tube FROM `ar_invoice_master` as aim LEFT JOIN ar_invoice_details as aid on aim.ar_invoice_no = aid.ar_invoice_no LEFT JOIN order_master as om on om.order_no = aid.ref_ord_no LEFT JOIN order_details as od on od.order_no = om.order_no AND od.article_no=aid.article_no LEFT JOIN coex_ink_consumption_master as cicm on od.article_no = cicm.article_no WHERE aim.invoice_date BETWEEN '$from_date' AND '$to_date' AND od.ad_id IS NOT NULL AND cicm.flexo_ink_gm_tube ='' AND cicm.screen_ink_gm_tube ='' AND cicm.offset_ink_gm_tube ='' AND cicm.special_ink_gm_tube='' AND od.print_type<>'LABELING' AND od.print_type<>'LABEL'");

    return $result=$query->result();

	}


}
 