<?php defined('BASEPATH') OR exit('No direct script access allowed');

		require_once dirname(__FILE__).'/dompdf/autoload.inc.php';
		
		use  Dompdf\Dompdf;
		
		class Pdf extends Dompdf{ 
		
			public function __construct(){
				parent::__construct();
			} 
		} 
?>