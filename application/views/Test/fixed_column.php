<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Popup</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css');?>"/> -->

<style type="text/css">

    table {
    table-layout: fixed; 
    width: 90%;
    *margin-left: -100px;/*ie7*/
    }
    td, th {
      vertical-align: top;
      border-top: 1px solid #ccc;
      padding:10px;
      width:500px;
    }
    th {
    /*  position:absolute;
      *position: relative; /*ie7*/
    /*  left:0; */
      width:absolute;
    }
    .hard_left {
      position:absolute;
      *position: relative; /*ie7*/
      left:0; 
      width:100px;
    }
    .next_left {
      position:absolute;
      *position: relative; /*ie7*/
      left:100px; 
      width:500px;
    }
    .outer {position:relative}
    .inner {
      overflow-x:scroll;
      overflow-y:visible;
      width:100%; 
      margin-left:200px;
    }

</style>
    
       
</head>
     
<body>
    <div class="record_form_design">
    <div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
  <div class="outer">
  <div class="inner">
    <table class="record_table_design_without_fixed">
        <tr>
          <th class="hard_left">Header A</th>
          <th class="next_left">Header B</th>
          <th>Header C</th>
          <th>Header D</th>
          <th>Header E</th>
          <th>Header A</th>
          <th>Header B</th>
          <th>Header C</th>
          <th>Header D</th>
          <th>Header E</th>
        </tr>
        <tr>
          <td class="hard_left">col 1 - A</td>
          <td class="next_left">col 2 - A</td>
          <td>col 3 - A</td>
          <td>col 4 - A</td>
          <td>col 5 - A</td>
          <td>col 1 - A</td>
          <td>col 2 - A</td>
          <td>col 3 - A</td>
          <td>col 4 - A</td>
          <td>col 5 - A</td>
        </tr>
        <tr>
          
          <td class="hard_left">col 1 - B</td>
          <td class="next_left">col 2 - B</td>
          <td>col 3 - B</td>
          <td>col 4 - B</td>
          <td>col 5 - B</td>
          <td>col 1 - A</td>
          <td>col 2 - A</td>
          <td>col 3 - A</td>
          <td>col 4 - A</td>
          <td>col 5 - A</td>
        </tr>
        <tr>
          
          <td class="hard_left">col 1 - C</td>
          <td class="next_left">col 2 - C</td>
          <td>col 3 - C</td>
          <td>col 4 - C</td>
          <td>col 5 - C</td>
          <td>col 1 - A</td>
          <td>col 2 - A</td>
          <td>col 3 - A</td>
          <td>col 4 - A</td>
          <td>col 5 - A</td>
        </tr>
        <tr>
          <td class="hard_left">col 1 - A</td>
          <td class="next_left">col 2 - A</td>
          <td>col 3 - A</td>
          <td>col 4 - A</td>
          <td>col 5 - A</td>
          <td>col 1 - B</td>
          <td>col 2 - B</td>
          <td>col 3 - B</td>
          <td>col 4 - B</td>
          <td>col 5 - B</td>
        </tr>
        <tr>
          <td class="hard_left">col 1 - A</td>
          <td class="next_left">col 2 - A</td>
          <td>col 3 - A</td>
          <td>col 4 - A</td>
          <td>col 5 - A</td>
          <td>col 1 - C</td>
          <td>col 2 - C</td>
          <td>col 3 - C</td>
          <td>col 4 - C</td>
          <td>col 5 - C</td>
        </tr>
        <tr>
          <td class="hard_left">col 1 - A</td>
          <td class="next_left">col 2 - A</td>
          <td>col 3 - A</td>
          <td>col 4 - A</td>
          <td>col 5 - A</td>
          <td>col 1 - B</td>
          <td>col 2 - B</td>
          <td>col 3 - B</td>
          <td>col 4 - B</td>
          <td>col 5 - B</td>
        </tr>
        <tr>
          <td class="hard_left">col 1 - A</td>
          <td class="next_left">col 2 - A</td>
          <td>col 3 - A</td>
          <td>col 4 - A</td>
          <td>col 5 - A</td>
          <td>col 1 - C</td>
          <td>col 2 - C</td>
          <td>col 3 - C</td>
          <td>col 4 - C</td>
          <td>col 5 - C</td>
        </tr>
    </table>
  </div>
</div>
</div>
</div>

 
</body>
</html>
