<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auto_mailer extends CI_Model
{

    public function jobcard_automailer()
    {

        $sql = "SELECT `manu_plan_date`,`mp_pos_no`,`actual_qty_manufactured`/100 as jobcard_qnt,`article_no`,`mp_qty`/100 as order_qnt,`sales_ord_no`,`mail_sent`,employee_master.name1,employee_master.name2 FROM `production_master` LEFT JOIN employee_master ON production_master.employee_id = employee_master.employee_id WHERE `mail_sent`<>1 AND `manu_plan_date` BETWEEN '2023-04-01' AND '2023-04-10'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function update_jobcardflag($job_card_no)
    {
        $this->db->where('mp_pos_no', $job_card_no);
        $result = $this->db->update('production_master', $data = array('mail_sent' => '1'));
        if ($result) {
            return $falg = 1;
        } else {
            return $falg = 0;
        }
    }
}
