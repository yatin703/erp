<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mail extends CI_Controller {
	
	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('currency_model');
      $this->load->model('sub_group_model');
      $this->load->model('second_sub_group_model');

    }else{
      redirect('login','refresh');
    }
  }
	
	public function index(){
    
// multiple recipients (note the commas)
$to = 'pravin.shinde@3dpackaging.in, ';
//$to .= 'jpattoncook@gmail.com';

// subject
$subject = 'Nonsensical Latin';

// compose message

$message = "
<html>
<head>
  <script type='text/javascript'
  src='https://www.gstatic.com/charts/loader.js'></script>
  <script type='text/javascript'>
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      // Define the chart to be drawn.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Element');
      data.addColumn('number', 'Percentage');
      data.addRows([
        ['Nitrogen', 0.78],
        ['Oxygen', 0.21],
        ['Other', 0.01]
      ]);

      // Instantiate and draw the chart.
      var chart = new
google.visualization.PieChart(document.getElementById('myPieChart'));
      chart.draw(data, null);
    }
  </script>
</head>
<body>
<!-- Identify where the chart should be drawn. -->

<div id='myPieChart'/>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";


mail($to,$subject,$message,$headers);
  }


  
}

?>