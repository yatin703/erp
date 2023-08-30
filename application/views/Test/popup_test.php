<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Popup</title>

<style type="text/css">

    html {
      font-family: "Helvetica Neue", sans-serif;
      width: 100%;
      color: #666666;
      text-align: center;
    }

    .popup-overlay {
      /*Hides pop-up when there is no "active" class*/
      visibility: hidden;
      position: absolute;
      background: #ffffff;
      border: 3px solid #666666;
      width: 50%;
      height: 50%;
      left: 25%;
    }

    .popup-overlay.active {
      /*displays pop-up when "active" class is present*/
      visibility: visible;
      text-align: center;
    }

    .popup-content {
      /*Hides pop-up content when there is no "active" class */
      visibility: hidden;
    }

    .popup-content.active {
      /*Shows pop-up content when "active" class is present */
      visibility: visible;
    }

    button {
      display: inline-block;
      vertical-align: middle;
      border-radius: 30px;
      margin: .20rem;
      font-size: 1rem;
      color: #666666;
      background: #ffffff;
      border: 1px solid #666666;
    }

    button:hover {
      border: 1px solid #666666;
      background: #666666;
      color: #ffffff;
    }

</style>

<!-- <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous">
      
  </script>  -->   
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.3.1.min.js');?>"></script>





<script type="text/javascript">
    $(document).ready(function(){

        $(".open").on("click", function() {
            $(".popup-overlay, .popup-content").addClass("active");
        });

        //removes the "active" class to .popup and .popup-content when the "Close" button is clicked 
         $(".close, .popup-overlay").on("click", function() {
        $(".popup-overlay, .popup-content").removeClass("active");
        });
    });    
</script>     
       
</head>
     
<body>
   
         
   <!--Creates the popup body-->
    <div class="popup-overlay">
    <!--Creates the popup content-->
     <div class="popup-content">
        <h2>Pop-Up</h2>
        <p> This is an example pop-up that you can make using jQuery.</p>
       <!--popup's close button-->
        <button class="close">Close</button>    
    </div>
    </div>

    <h2>jQuery Pop-Up Example</h2>
    <button class="open">Open</button>

 
</body>
</html>
