<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model {

	public function cop_f_encrypt($password,$strtoencrypt,$ralphabet1="") 
   {
      $encrypted_string="";
      if($ralphabet1 != '')
         $ralphabet=$ralphabet1;
      else
         $ralphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-/.&=_";

      $alphabet = $ralphabet.$ralphabet;
      

      for( $i=0; $i<strlen($password); $i++ )
      {
         $cur_pswd_ltr = substr($password,$i,1);
         $pos_alpha_ary[] = substr(strstr($alphabet,$cur_pswd_ltr),0,strlen($ralphabet));
      }
      $i=0;
      $n = 0;
      $nn = strlen($password);
      $c = strlen($strtoencrypt);
      while($i<$c)
      {
         $encrypted_string .= substr($pos_alpha_ary[$n],strpos($ralphabet,substr($strtoencrypt,$i,1)),1);
         $n++;
         if($n==$nn) $n = 0;
         $i++;
      }
      return $encrypted_string;
   }


   function cop_f_decrypt($password,$strtodecrypt,$ralphabet1="") 
   {
   	$decrypted_string="";

      if($ralphabet1 != '')
         $ralphabet=$ralphabet1;
      else
         $ralphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-/.&=_";

      $alphabet = $ralphabet.$ralphabet;

/*      global $ralphabet;
      global $alphabet;    */
      for( $i=0; $i<strlen($password); $i++ )
      {
         $cur_pswd_ltr = substr($password,$i,1);
         $pos_alpha_ary[] = substr(strstr($alphabet,$cur_pswd_ltr),0,strlen($ralphabet));
      }
      $i=0;
      $n = 0;
      $nn = strlen($password);
      $c = strlen($strtodecrypt);
      while($i<$c) 
      {
         $decrypted_string .= substr($ralphabet,strpos($pos_alpha_ary[$n],substr($strtodecrypt,$i,1)),1);
         $n++;
         if($n==$nn) $n = 0;
         $i++;
      }
      return $decrypted_string;
   }

   function check_login_status($username,$password,$company){
      $this->db->select('*');
      $this->db->from('user_master');
      $this->db->where('user_id',$username);
      $this->db->where('password',$password);
      $this->db->where('company_id',$company);
      $this->db->where('archive<>','1');
      $this->db->limit(1);
      $query=$this->db->get();
       if($query->num_rows()==1){
        return $result=$query->result();
      }else{
         return FALSE;
      }
   }


   function login($username, $password,$company){
   $this -> db -> select('*');
   $this -> db -> from('user_master');
   $this -> db -> where('user_id', $username);
   $this -> db -> where('password', $password);
   $this -> db -> where('company_id', $company);
   $this -> db -> where('archive<>','1');
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();
    if($query -> num_rows() == 1){
     return $result=$query->result();
   }else{
     return false;
   }
 }

}
?>