<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
//require_once APPPATH."/third_party/PHPExcel/Classes/PHPExcel.php"; 
require_once('PHPExcel/IOFactory');
 
class IOFactory extends PHPExcel_IOFactory { 
    public function __construct() { 
        parent::__construct(); 
    } 
}

?>
