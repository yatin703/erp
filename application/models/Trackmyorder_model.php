<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Trackmyorder_model extends CI_Model
{
    public function active_record_search(
        $table,
        $company,
        $customer_category,
        $data,
        $from,
        $to
    ) {
        $this->db->select(
            "distinct(order_no)order_no,springtube_printing_production_master.article_no,production_date"
        );

        if (!empty($customer_category)) {
            $this->db->join(
                "article_name_info",
                "springtube_printing_production_master.article_no=article_name_info.article_no",
                "LEFT"
            );
            //$this->db->join('address_category_master',''.$table.'.customer_category=address_category_master.adr_category_id','LEFT');
        }
        $this->db->from($table);
        $this->db->where($table . ".company_id", $company);
        $this->db->where($table . ".archive<>", "1");
        //	$this->db->where($table.'.status','0');
        if ($from != "" && $to != "") {
            $this->db->where("production_date>=", $from);
            $this->db->where("production_date<=", $to);
        }
        //print_r($data);
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $this->db->where($table . "." . $key, $value);
            }
        }

        if (!empty($customer_category)) {
            $this->db->where(
                "article_name_info.adr_category_id",
                $customer_category
            );
            $this->db->where("article_name_info.company_id", $company);
        }
        //$this->db->group_by('production_date');
        $this->db->group_by("order_no");
        $this->db->group_by("article_no");
        $this->db->order_by("production_date", "DESC");
        $this->db->order_by("shift", "DESC");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $result = $query->result();
    }

    public function active_record_list($from_date, $to_date)
    {
        $db2 = $this->load->database("another_db", true);

        $sql = "select twerp.extrusion.date,twerp.extrusion.so_no,twerp.extrusion.psp_psm_no,twerp.extrusion.job_order_quantity,twerp.extrusion.job_card_no,neo.order_master.customer_no, neo.address_master.name1,twerp.heading.job_card_no,twerp.heading.so_no,twerp.printing.so_no,twerp.printing.job_card_no,twerp.capping.so_no, twerp.capping.job_card_no,twerp.rfd.so_no,twerp.rfd.jobcard_no,sum(twerp.extrusion.sleeve_to_header) as ext_qty,sum(twerp.heading.heading_sleeves_to_next) as hed_qty, sum(twerp.printing.printing_sleeves_to_next) as print_qty,sum(twerp.capping.sleeves_to_next) as cap_qty,sum(twerp.rfd.ok_qty) as rfd_qty from twerp.extrusion LEFT JOIN twerp.heading on twerp.extrusion.job_card_no = twerp.heading.job_card_no LEFT JOIN twerp.printing on twerp.extrusion.job_card_no = twerp.printing.job_card_no LEFT JOIN twerp.capping on twerp.extrusion.job_card_no = twerp.capping.job_card_no LEFT JOIN twerp.rfd on twerp.extrusion.job_card_no = twerp.rfd.jobcard_no LEFT JOIN neo.order_master on twerp.extrusion.so_no = neo.order_master.order_no LEFT JOIN neo.address_master on neo.order_master.customer_no = neo.address_master.adr_company_id WHERE twerp.extrusion.date BETWEEN '$from_date' and '$to_date' group by twerp.extrusion.job_card_no,twerp.heading.job_card_no,
		    twerp.printing.job_card_no,twerp.capping.job_card_no,twerp.rfd.jobcard_no,twerp.extrusion.so_no";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function active_track_order_record()
    {
        $sql = "SELECT ce.extrusion_date,am.name1 as customer,ce.jobcard_no,ce.order_no,ce.article_no,ce.diameter,ce.length,od.total_order_quantity,od.print_type as print_type,sum(ce.ok_qty_no) as production_qty,sum(ce.scrap_tube_no) as production_scrap FROM
    `coex_extrusion` as ce
    LEFT JOIN order_master as om on ce.order_no = om.order_no
    LEFT JOIN order_details as od on ce.order_no = od.order_no
    LEFT JOIN address_master as am on om.customer_no =am.adr_company_id
    GROUP by ce.jobcard_no";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function active_coex_extrusion_track_order_record(
        $from_date,
        $to_date
    ) {
        $sql = "SELECT ce.extrusion_date,am.name1 as customer,ce.order_no,ce.article_no,ce.diameter,ce.length,od.total_order_quantity,od.print_type as print_type,sum(ce.ok_qty_no) as production_qty,sum(ce.scrap_tube_no) as production_scrap FROM
         `coex_extrusion` as ce
        LEFT JOIN order_master as om on ce.order_no = om.order_no
         LEFT JOIN order_details as od on ce.order_no = od.order_no
         LEFT JOIN address_master as am on om.customer_no =am.adr_company_id
        
         where ce.extrusion_date between '$from_date' and '$to_date'

         
         GROUP by ce.order_no order by ce.extrusion_date desc";

        $query = $this->db->query($sql);

        return $result = $query->result();
    }

    public function active_track_order_record_wip($order_no)
    {
        $sql = "SELECT sum(ok_by_qc) as ok_by_qc FROM `coex_extrusion_wip` WHERE `order_no`='$order_no' group by order_no";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function active_track_order_record_wip_scrap($order_no)
    {
        $sql = "SELECT sum(scrap_qty) as scrap_by_wip FROM `coex_extrusion_wip_scrap` WHERE `order_no`='$order_no' group by order_no";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function active_track_order_record_qc($order_no)
    {
        $sql = "SELECT sum(hold_by_qc) as hold_by_qc FROM `coex_extrusion_qc` WHERE `order_no`='$order_no' group by order_no";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }

    public function active_track_order_record_scrap($order_no)
    {
        $sql = "SELECT sum(scrap_by_qc) as scrap_by_qc FROM `coex_extrusion_scrap` WHERE `order_no`='$order_no' group by order_no";

        $query = $this->db->query($sql);
        return $result = $query->result();
    }    

    public function select_qc_hold_where($table, $company, $pkey, $edit)
    {
        $this->db->select("sum(hold_by_qc) as hold");
        $this->db->from($table);
        $this->db->where($table . ".company_id", $company);
        $this->db->where($table . ".archive<>", "1");
        $this->db->where($table . ".hold_by_qc<>", "0");
        $this->db->where($table . ".flag<>", "1");
        $this->db->where($pkey, $edit);
        $this->db->group_by("jobcard_no");
        $query = $this->db->get();
        return $query->result();
    }

    public function select_qc_released_where($table, $company, $pkey, $edit)
    {
        $this->db->select("sum(hold_by_qc) as qc_released");
        $this->db->from($table);
        $this->db->where($table . ".company_id", $company);
        $this->db->where($table . ".archive<>", "1");
        $this->db->where($table . ".flag<>", "0");
        $this->db->where($pkey, $edit);
        $this->db->group_by("jobcard_no");
        $query = $this->db->get();
        return $query->result();
    }

    public function select_qc_scrap_where($table, $company, $pkey, $edit)
    {
        $this->db->select("sum(scrap_by_qc) as scrap");
        $this->db->from($table);
        $this->db->where($table . ".company_id", $company);
        $this->db->where($table . ".archive<>", "1");
        $this->db->where($table . ".scrap_by_qc<>", "0");
        $this->db->where($pkey, $edit);
        $this->db->group_by("jobcard_no");
        $query = $this->db->get();
        return $query->result();
    }

    public function select_qc_flag_zero($table, $company, $pkey, $edit)
    {
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where($table . ".company_id", $company);
        $this->db->where($table . ".archive<>", "0");
        $this->db->where($table . ".flag<>", "0");
        $this->db->where($pkey, $edit);
        $this->db->group_by("jobcard_no");
        $query = $this->db->get();
        return $query->result();
    }
}

?>
