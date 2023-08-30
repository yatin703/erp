 <?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_process_wise_track_my_order_model extends CI_Model {


 public function active_record_search($from_date,$to_date){

		$DB2 = $this->load->database('another_db', TRUE);  
		
	$sql="select twerp.extrusion.date,twerp.extrusion.so_no,twerp.extrusion.psp_psm_no, twerp.extrusion.job_card_no, neo.address_master.name1 as customer,twerp.extrusion.job_order_quantity,neo.order_master.`order_no`, neo.order_details.print_type, sum(twerp.extrusion.sleeve_to_header) as ext_qty from twerp.extrusion LEFT JOIN neo.order_master on twerp.extrusion.so_no = neo.order_master.order_no LEFT JOIN neo.order_details on neo.order_master.order_no = neo.order_details.order_no LEFT JOIN neo.address_master on neo.order_master.customer_no = neo.address_master.adr_company_id WHERE twerp.extrusion.date BETWEEN '$from_date' AND '$to_date' and twerp.extrusion.so_no<>'' group by twerp.extrusion.job_card_no";
     $query=$this->db->query($sql);
	 return $result=$query->result(); 
 }

 public function active_record_search_heading($order_no){

		$DB2 = $this->load->database('another_db', TRUE);  
		
	$sql="select twerp.heading.date,twerp.heading.so_no,twerp.heading.`job_card_quantity`,sum(twerp.heading.`heading_sleeves_to_next`) as heading_qty from twerp.heading where twerp.heading.so_no='$order_no' and twerp.heading.so_no<>'' group by twerp.heading.so_no;
";
$query=$this->db->query($sql);
			return $result=$query->result(); 
 }

 public function active_record_search_capping($order_no){

		$DB2 = $this->load->database('another_db', TRUE);  
		
	$sql="select twerp.capping.date,twerp.capping.so_no,twerp.capping.`job_card_quantity`,sum(twerp.capping.`sleeves_to_next`) as capping_qty from twerp.capping where twerp.capping.so_no='$order_no' and twerp.capping.so_no<>'' group by twerp.capping.so_no"; 
$query=$this->db->query($sql);
			return $result=$query->result(); 
 }

 public function active_record_search_printing($order_no){

		$DB2 = $this->load->database('another_db', TRUE);  
		
	$sql="select twerp.printing.date,twerp.printing.so_no,twerp.printing.`job_card_quantity`,sum(twerp.printing.`printing_sleeves_to_next`) as printing_qty from twerp.printing where twerp.printing.so_no='$order_no' and twerp.printing.so_no<>'' group by twerp.printing.so_no";
$query=$this->db->query($sql);
			return $result=$query->result(); 
 }

  public function active_record_search_foiling($order_no){

		$DB2 = $this->load->database('another_db', TRUE);  
		
	$sql="select twerp.foiling.date,twerp.foiling.so_no,twerp.foiling.`job_card_quantity`,sum(twerp.foiling.`sleeves_to_next`) as foiling_qty from twerp.foiling where twerp.foiling.so_no='$order_no' and twerp.foiling.so_no<>'' group by twerp.foiling.so_no";
$query=$this->db->query($sql);
			return $result=$query->result();  
 }

 public function active_record_search_rfd($order_no){ 

		$DB2 = $this->load->database('another_db', TRUE);    
		
	$sql="select twerp.rfd.date,twerp.rfd.so_no,sum(twerp.rfd.`ok_qty`) as rfd_qty from twerp.rfd where twerp.rfd.so_no='$order_no' and twerp.rfd.so_no<>'' group by twerp.rfd.so_no";
$query=$this->db->query($sql);
			return $result=$query->result(); 
 }

public function active_record_search_dispatch($order_no){ 

		$DB2 = $this->load->database('another_db', TRUE);  
		
	$sql="select neo.ar_invoice_details.ref_ord_no,neo.ar_invoice_details.arid_qty,neo.ar_invoice_details.sleeve_dia,neo.ar_invoice_details.sleeve_length from neo.ar_invoice_details where neo.ar_invoice_details.ref_ord_no='$order_no' group by  neo.ar_invoice_details.ref_ord_no";
$query=$this->db->query($sql);
			return $result=$query->result(); 
 }

}