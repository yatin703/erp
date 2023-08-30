<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
   $(document).ready(function(){
      $("#loading").hide(); $("#cover").hide();

      $("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});


      $("#main_group").change(function(event) {
         var main_group = $('#main_group').val();
         $("#loading").show();
            $("#cover").show();
            $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
          $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/main_group_article",data: {main_group : $('#main_group').val()},cache: false,success: function(html){
               setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
             $("#article_no").html(html);
          } 
          });
         });

      $("#sleeve_dia").change(function(event) {
         $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
         if($("#sleeve_dia option:selected" ).val()!=''){
            var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0, 2);
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>");
            $("#loading").hide();$("#cover").hide();
         }else{
            $("#article_name").html('');
         }
         });

      $("#sleeve_length").live('keyup',function() {
         if($("#sleeve_dia option:selected" ).val()!='' && $("#sleeve_length" ).val()!=''){
            var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);
            var sleeve_length=$("#sleeve_length").val();
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span>");
         }else{
            $("#article_name").html('');
            
         }
         });


   $("#gauge").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

         if(gauge!=''){
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>");
         }else{
            $("#article_name").html('');
         }

   });



   $("#sl_masterbatch").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

         if(sl_masterbatch!=''){
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+"</span>");
         }else{
            $("#article_name").html('');
         }
      });


   $("#sl_mb_per").live('keyup',function(){

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

         if(sl_mb_per!=''){
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>");
         }else{
            $("#article_name").html('');
         }
      });


   $("#sl_ldpe").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{var sl_ldpe="";}

         if(sl_ldpe!=''){
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+"</span>");
         }else{
            $("#article_name").html('');
         }

   });


   $("#sl_ldpe_per").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

         if(sl_ldpe_per!=''){
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>");
         }else{
            $("#article_name").html('');
         }

   });


   $("#sl_lldpe").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

         if(sl_lldpe!=''){
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+"</span>");
         }else{
            $("#article_name").html('');
         }

   });


   $("#sl_lldpe_per").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

         if(sl_lldpe_per!=''){
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>");
         }else{
            $("#article_name").html('');
         }

   });


   $("#sl_hdpe").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

         if(sl_hdpe!=''){
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+"</span>+<span class='ui teal label'>"+sl_hdpe+"</span>");
         }else{
            $("#article_name").html('');
         }

   });


   $("#sl_hdpe_per").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

         if(sl_lldpe_per!=''){
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span>");
         }else{
            $("#article_name").html('');
         }

   });



$("#gauge_two").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

         if(gauge_two!=''){
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>");
         }else{
            $("#article_name").html('');
         }

   });




   $("#sl_admer_two").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

      if(sl_admer_two!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


   $("#sl_admer_per_two").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

      if(sl_hdpe_per_two!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


   $("#gauge_three").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

      if(gauge_three!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


$("#sl_evoh_three").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

      if(sl_evoh_three!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


$("#sl_evoh_per_three").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

      if(sl_evoh_per_three!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span>");
      }else{
            $("#article_name").html('');
      }

   });
   

   $("#gauge_four").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

      if(gauge_four!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>");
      }else{
            $("#article_name").html('');
      }

   });



 $("#sl_admer_four").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

      if(sl_admer_four!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>+<span class='ui teal label'>"+sl_admer_four+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


$("#sl_admer_per_four").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

   if($("#sl_admer_per_four").val()!=''){ var sl_admer_per_four=$("#sl_admer_per_four").val()+"%";}else{var sl_admer_per_four="";}

      if(sl_admer_per_four!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>+<span class='ui teal label'>"+sl_admer_four+" "+sl_admer_per_four+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


$("#gauge_five").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

   if($("#sl_admer_per_four").val()!=''){ var sl_admer_per_four=$("#sl_admer_per_four").val()+"%";}else{var sl_admer_per_four="";}

   if($("#gauge_five").val()!=''){ var gauge_five=$("#gauge_five").val()+"MIC";}else{var gauge_five="";}

      if(gauge_five!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>+<span class='ui teal label'>"+sl_admer_four+" "+sl_admer_per_four+"</span><br>+<br/><span class='ui teal label'>"+gauge_five+"</span>");
      }else{
            $("#article_name").html('');
      }

   });
   

   
$("#sl_masterbatch_five").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

   if($("#sl_admer_per_four").val()!=''){ var sl_admer_per_four=$("#sl_admer_per_four").val()+"%";}else{var sl_admer_per_four="";}

   if($("#gauge_five").val()!=''){ var gauge_five=$("#gauge_five").val()+"MIC";}else{var gauge_five="";}

   if($("#sl_masterbatch_five option:selected").val()!=''){ var sl_masterbatch_five=$("#sl_masterbatch_five option:selected").text();}else{ var sl_masterbatch_five="";}

      if(sl_masterbatch_five!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>+<span class='ui teal label'>"+sl_admer_four+" "+sl_admer_per_four+"</span><br>+<br/><span class='ui teal label'>"+gauge_five+"</span>+<span class='ui teal label'>"+sl_masterbatch_five+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


$("#sl_mb_per_five").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

   if($("#sl_admer_per_four").val()!=''){ var sl_admer_per_four=$("#sl_admer_per_four").val()+"%";}else{var sl_admer_per_four="";}

   if($("#gauge_five").val()!=''){ var gauge_five=$("#gauge_five").val()+"MIC";}else{var gauge_five="";}

   if($("#sl_masterbatch_five option:selected").val()!=''){ var sl_masterbatch_five=$("#sl_masterbatch_five option:selected").text();}else{ var sl_masterbatch_five="";}

   if($("#sl_mb_per_five").val()!=''){ var sl_mb_per_five=$("#sl_mb_per_five").val()+"%";}else{var sl_mb_per_five="";}

      if(sl_masterbatch_five!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>+<span class='ui teal label'>"+sl_admer_four+" "+sl_admer_per_four+"</span><br>+<br/><span class='ui teal label'>"+gauge_five+"</span>+<span class='ui teal label'>"+sl_masterbatch_five+" "+sl_mb_per_five+"</span>");
      }else{
            $("#article_name").html('');
      }

   });

$("#sl_ldpe_five").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

   if($("#sl_admer_per_four").val()!=''){ var sl_admer_per_four=$("#sl_admer_per_four").val()+"%";}else{var sl_admer_per_four="";}

   if($("#gauge_five").val()!=''){ var gauge_five=$("#gauge_five").val()+"MIC";}else{var gauge_five="";}

   if($("#sl_masterbatch_five option:selected").val()!=''){ var sl_masterbatch_five=$("#sl_masterbatch_five option:selected").text();}else{ var sl_masterbatch_five="";}

   if($("#sl_mb_per_five").val()!=''){ var sl_mb_per_five=$("#sl_mb_per_five").val()+"%";}else{var sl_mb_per_five="";}

   if($("#sl_ldpe_five option:selected").val()!=''){ var sl_ldpe_five=$("#sl_ldpe_five option:selected").text();}else{ var sl_ldpe_five="";}

      if(sl_ldpe_five!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>+<span class='ui teal label'>"+sl_admer_four+" "+sl_admer_per_four+"</span><br>+<br/><span class='ui teal label'>"+gauge_five+"</span>+<span class='ui teal label'>"+sl_masterbatch_five+" "+sl_mb_per_five+"</span>+<span class='ui teal label'>"+sl_ldpe_five+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


$("#sl_ldpe_per_five").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

   if($("#sl_admer_per_four").val()!=''){ var sl_admer_per_four=$("#sl_admer_per_four").val()+"%";}else{var sl_admer_per_four="";}

   if($("#gauge_five").val()!=''){ var gauge_five=$("#gauge_five").val()+"MIC";}else{var gauge_five="";}

   if($("#sl_masterbatch_five option:selected").val()!=''){ var sl_masterbatch_five=$("#sl_masterbatch_five option:selected").text();}else{ var sl_masterbatch_five="";}

   if($("#sl_mb_per_five").val()!=''){ var sl_mb_per_five=$("#sl_mb_per_five").val()+"%";}else{var sl_mb_per_five="";}

   if($("#sl_ldpe_five option:selected").val()!=''){ var sl_ldpe_five=$("#sl_ldpe_five option:selected").text();}else{ var sl_ldpe_five="";}

   if($("#sl_ldpe_per_five").val()!=''){ var sl_ldpe_per_five=$("#sl_ldpe_per_five").val()+"%";}else{var sl_ldpe_per_five="";}

      if(sl_ldpe_per_five!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>+<span class='ui teal label'>"+sl_admer_four+" "+sl_admer_per_four+"</span><br>+<br/><span class='ui teal label'>"+gauge_five+"</span>+<span class='ui teal label'>"+sl_masterbatch_five+" "+sl_mb_per_five+"</span>+"+sl_ldpe_five+" "+sl_ldpe_per_five+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


$("#sl_lldpe_five").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

   if($("#sl_admer_per_four").val()!=''){ var sl_admer_per_four=$("#sl_admer_per_four").val()+"%";}else{var sl_admer_per_four="";}

   if($("#gauge_five").val()!=''){ var gauge_five=$("#gauge_five").val()+"MIC";}else{var gauge_five="";}

   if($("#sl_masterbatch_five option:selected").val()!=''){ var sl_masterbatch_five=$("#sl_masterbatch_five option:selected").text();}else{ var sl_masterbatch_five="";}

   if($("#sl_mb_per_five").val()!=''){ var sl_mb_per_five=$("#sl_mb_per_five").val()+"%";}else{var sl_mb_per_five="";}

   if($("#sl_ldpe_five option:selected").val()!=''){ var sl_ldpe_five=$("#sl_ldpe_five option:selected").text();}else{ var sl_ldpe_five="";}

   if($("#sl_ldpe_per_five").val()!=''){ var sl_ldpe_per_five=$("#sl_ldpe_per_five").val()+"%";}else{var sl_ldpe_per_five="";}

   if($("#sl_lldpe_five option:selected").val()!=''){ var sl_lldpe_five=$("#sl_lldpe_five option:selected").text();}else{ var sl_lldpe_five="";}

      if(sl_lldpe_five!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>+<span class='ui teal label'>"+sl_admer_four+" "+sl_admer_per_four+"</span><br>+<br/><span class='ui teal label'>"+gauge_five+"</span>+<span class='ui teal label'>"+sl_masterbatch_five+" "+sl_mb_per_five+"</span>+<span class='ui teal label'>"+sl_ldpe_five+" "+sl_ldpe_per_five+"</span>+<span class='ui teal label'>"+sl_lldpe_five+"</span>");
      }else{
            $("#article_name").html('');
      }

   });



$("#sl_lldpe_per_five").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

   if($("#sl_admer_per_four").val()!=''){ var sl_admer_per_four=$("#sl_admer_per_four").val()+"%";}else{var sl_admer_per_four="";}

   if($("#gauge_five").val()!=''){ var gauge_five=$("#gauge_five").val()+"MIC";}else{var gauge_five="";}

   if($("#sl_masterbatch_five option:selected").val()!=''){ var sl_masterbatch_five=$("#sl_masterbatch_five option:selected").text();}else{ var sl_masterbatch_five="";}

   if($("#sl_mb_per_five").val()!=''){ var sl_mb_per_five=$("#sl_mb_per_five").val()+"%";}else{var sl_mb_per_five="";}

   if($("#sl_ldpe_five option:selected").val()!=''){ var sl_ldpe_five=$("#sl_ldpe_five option:selected").text();}else{ var sl_ldpe_five="";}

   if($("#sl_ldpe_per_five").val()!=''){ var sl_ldpe_per_five=$("#sl_ldpe_per_five").val()+"%";}else{var sl_ldpe_per_five="";}

   if($("#sl_lldpe_five option:selected").val()!=''){ var sl_lldpe_five=$("#sl_lldpe_five option:selected").text();}else{ var sl_lldpe_five="";}

   if($("#sl_lldpe_per_five").val()!=''){ var sl_lldpe_per_five=$("#sl_lldpe_per_five").val()+"%";}else{var sl_lldpe_per_five="";}

      if(sl_lldpe_per_five!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>+<span class='ui teal label'>"+sl_admer_four+" "+sl_admer_per_four+"</span><br>+<br/><span class='ui teal label'>"+gauge_five+"</span>+<span class='ui teal label'>"+sl_masterbatch_five+" "+sl_mb_per_five+"</span>+<span class='ui teal label'>"+sl_ldpe_five+" "+sl_ldpe_per_five+"</span>+<span class='ui teal label'>"+sl_lldpe_five+" "+sl_lldpe_per_five+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


$("#sl_hdpe_five").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

   if($("#sl_admer_per_four").val()!=''){ var sl_admer_per_four=$("#sl_admer_per_four").val()+"%";}else{var sl_admer_per_four="";}

   if($("#gauge_five").val()!=''){ var gauge_five=$("#gauge_five").val()+"MIC";}else{var gauge_five="";}

   if($("#sl_masterbatch_five option:selected").val()!=''){ var sl_masterbatch_five=$("#sl_masterbatch_five option:selected").text();}else{ var sl_masterbatch_five="";}

   if($("#sl_mb_per_five").val()!=''){ var sl_mb_per_five=$("#sl_mb_per_five").val()+"%";}else{var sl_mb_per_five="";}

   if($("#sl_ldpe_five option:selected").val()!=''){ var sl_ldpe_five=$("#sl_ldpe_five option:selected").text();}else{ var sl_ldpe_five="";}

   if($("#sl_ldpe_per_five").val()!=''){ var sl_ldpe_per_five=$("#sl_ldpe_per_five").val()+"%";}else{var sl_ldpe_per_five="";}

   if($("#sl_lldpe_five option:selected").val()!=''){ var sl_lldpe_five=$("#sl_lldpe_five option:selected").text();}else{ var sl_lldpe_five="";}

   if($("#sl_lldpe_per_five").val()!=''){ var sl_lldpe_per_five=$("#sl_lldpe_per_five").val()+"%";}else{var sl_lldpe_per_five="";}

   if($("#sl_hdpe_five option:selected").val()!=''){ var sl_hdpe_five=$("#sl_hdpe_five option:selected").text();}else{ var sl_hdpe_five="";}

      if(sl_hdpe_five!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>+<span class='ui teal label'>"+sl_admer_four+" "+sl_admer_per_four+"</span><br>+<br/><span class='ui teal label'>"+gauge_five+"</span>+<span class='ui teal label'>"+sl_masterbatch_five+" "+sl_mb_per_five+"</span>+<span class='ui teal label'>"+sl_ldpe_five+" "+sl_ldpe_per_five+"</span>+<span class='ui teal label'>"+sl_lldpe_five+" "+sl_lldpe_per_five+"</span>+<span class='ui teal label'>"+sl_hdpe_five+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


$("#sl_hdpe_per_five").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

   if($("#sl_admer_per_four").val()!=''){ var sl_admer_per_four=$("#sl_admer_per_four").val()+"%";}else{var sl_admer_per_four="";}

   if($("#gauge_five").val()!=''){ var gauge_five=$("#gauge_five").val()+"MIC";}else{var gauge_five="";}

   if($("#sl_masterbatch_five option:selected").val()!=''){ var sl_masterbatch_five=$("#sl_masterbatch_five option:selected").text();}else{ var sl_masterbatch_five="";}

   if($("#sl_mb_per_five").val()!=''){ var sl_mb_per_five=$("#sl_mb_per_five").val()+"%";}else{var sl_mb_per_five="";}

   if($("#sl_ldpe_five option:selected").val()!=''){ var sl_ldpe_five=$("#sl_ldpe_five option:selected").text();}else{ var sl_ldpe_five="";}

   if($("#sl_ldpe_per_five").val()!=''){ var sl_ldpe_per_five=$("#sl_ldpe_per_five").val()+"%";}else{var sl_ldpe_per_five="";}

   if($("#sl_lldpe_five option:selected").val()!=''){ var sl_lldpe_five=$("#sl_lldpe_five option:selected").text();}else{ var sl_lldpe_five="";}

   if($("#sl_lldpe_per_five").val()!=''){ var sl_lldpe_per_five=$("#sl_lldpe_per_five").val()+"%";}else{var sl_lldpe_per_five="";}

   if($("#sl_hdpe_five option:selected").val()!=''){ var sl_hdpe_five=$("#sl_hdpe_five option:selected").text();}else{ var sl_hdpe_five="";}

   if($("#sl_hdpe_per_five").val()!=''){ var sl_hdpe_per_five=$("#sl_hdpe_per_five").val()+"%";}else{var sl_hdpe_per_five="";}

      if(sl_hdpe_per_five!=''){
         $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span>+<span class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span>+<span class='ui teal label'>"+sl_admer_four+" "+sl_admer_per_four+"</span><br>+<br/><span class='ui teal label'>"+gauge_five+"</span>+<span class='ui teal label'>"+sl_masterbatch_five+" "+sl_mb_per_five+"</span>+<span class='ui teal label'>"+sl_ldpe_five+" "+sl_ldpe_per_five+"</span>+<span class='ui teal label'>"+sl_lldpe_five+" "+sl_lldpe_per_five+"</span>+<span class='ui teal label'>"+sl_hdpe_five+" "+sl_hdpe_per_five+"</span>");
      }else{
            $("#article_name").html('');
      }

   });


   $(".form_table_inner").live('mouseover',function(){

   if($("#sleeve_dia option:selected").val()!=''){

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   if($("#gauge_two").val()!=''){ var gauge_two=$("#gauge_two").val()+"MIC";}else{var gauge_two="";}

   if($("#sl_admer_two option:selected").val()!=''){ var sl_admer_two=$("#sl_admer_two option:selected").text();}else{ var sl_admer_two="";}

   if($("#sl_admer_per_two").val()!=''){ var sl_admer_per_two=$("#sl_admer_per_two").val()+"%";}else{var sl_admer_per_two="";}

   if($("#gauge_three").val()!=''){ var gauge_three=$("#gauge_three").val()+"MIC";}else{var gauge_three="";}

   if($("#sl_evoh_three option:selected").val()!=''){ var sl_evoh_three=$("#sl_evoh_three option:selected").text();}else{ var sl_evoh_three="";}

   if($("#sl_evoh_per_three").val()!=''){ var sl_evoh_per_three=$("#sl_evoh_per_three").val()+"%";}else{var sl_evoh_per_three="";}

   if($("#gauge_four").val()!=''){ var gauge_four=$("#gauge_four").val()+"MIC";}else{var gauge_four="";}

   if($("#sl_admer_four option:selected").val()!=''){ var sl_admer_four=$("#sl_admer_four option:selected").text();}else{ var sl_admer_four="";}

   if($("#sl_admer_per_four").val()!=''){ var sl_admer_per_four=$("#sl_admer_per_four").val()+"%";}else{var sl_admer_per_four="";}

   if($("#gauge_five").val()!=''){ var gauge_five=$("#gauge_five").val()+"MIC";}else{var gauge_five="";}

   if($("#sl_masterbatch_five option:selected").val()!=''){ var sl_masterbatch_five=$("#sl_masterbatch_five option:selected").text();}else{ var sl_masterbatch_five="";}

   if($("#sl_mb_per_five").val()!=''){ var sl_mb_per_five=$("#sl_mb_per_five").val()+"%";}else{var sl_mb_per_five="";}

   if($("#sl_ldpe_five option:selected").val()!=''){ var sl_ldpe_five=$("#sl_ldpe_five option:selected").text();}else{ var sl_ldpe_five="";}

   if($("#sl_ldpe_per_five").val()!=''){ var sl_ldpe_per_five=$("#sl_ldpe_per_five").val()+"%";}else{var sl_ldpe_per_five="";}

   if($("#sl_lldpe_five option:selected").val()!=''){ var sl_lldpe_five=$("#sl_lldpe_five option:selected").text();}else{ var sl_lldpe_five="";}

   if($("#sl_lldpe_per_five").val()!=''){ var sl_lldpe_per_five=$("#sl_lldpe_per_five").val()+"%";}else{var sl_lldpe_per_five="";}

   if($("#sl_hdpe_five option:selected").val()!=''){ var sl_hdpe_five=$("#sl_hdpe_five option:selected").text();}else{ var sl_hdpe_five="";}

   if($("#sl_hdpe_per_five").val()!=''){ var sl_hdpe_per_five=$("#sl_hdpe_per_five").val()+"%";}else{var sl_hdpe_per_five="";}

   $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>5 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>+<span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>+<span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>+<span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>+<span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span><br>+<br/><span class='ui teal label'>"+gauge_two+"</span>+<span class='ui teal label'>"+sl_admer_two+" "+sl_admer_per_two+"</span><br>+<br/><span class='ui teal label'>"+gauge_three+"</span><span  class='ui teal label'>"+sl_evoh_three+" "+sl_evoh_per_three+"</span><br>+<br/><span class='ui teal label'>"+gauge_four+"</span><span class='ui teal label'>"+sl_admer_four+" "+sl_admer_per_four+"</span><br>+<br/><span class='ui teal label'>"+gauge_five+"</span><span class='ui teal label'>"+sl_masterbatch_five+" "+sl_mb_per_five+"</span>+<span class='ui teal label'>"+sl_ldpe_five+" "+sl_ldpe_per_five+"</span>+<span class='ui teal label'>"+sl_lldpe_five+" "+sl_lldpe_per_five+"</span>+<span class='ui teal label'>"+sl_hdpe_five+" "+sl_hdpe_per_five+"</span>");
         }else{
            $("#article_name").html('');
         }
      });
   

   });
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_five_layer');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

									<tr>
										<td class="label" >Main Group <span style="color:red;">*</span> :</td>
										<td><select name="main_group" id="main_group" required><option value=''>--Select Main Group--</option>
                                 <option value="45">SLEEVE</option>
										<?php /*if($main_group==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($main_group as $main_group_row){
													echo "<option value='".$main_group_row->main_group_id."'  ".set_select('main_group',''.$main_group_row->main_group_id.'').">".strtoupper($main_group_row->lang_main_group_desc)."-".$main_group_row->main_group_id."</option>";
												}
										}*/?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Sleeve No <span style="color:red;">*</span> :</td>
										<td><select name="article_no" id="article_no" required>
										<?php if($this->input->post('article_no')){
											echo '<option value="'.$this->input->post('article_no').'">'.$this->input->post('article_no').'</option>';
										}else{
											echo '<option value="">--Select Article Code--</option>';
										}?>
														
										</select></td>
									</tr>


									<tr>
										<td class="label">Dia <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia" required><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select>&nbsp;Length <span style="color:red;">*</span> : <input type="number" name="sleeve_length" min="10"  max="300" step="0.5"  id="sleeve_length" size="5" maxlength="5" value="<?php echo set_value('sleeve_length');?>" required></td>
									</tr>

									<tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

									<tr><td class="label"><b>Outer Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="text" name="gauge" id="gauge" maxlength="5" size="5" value="<?php echo set_value('gauge');?>" required></td>
									</tr>

									<tr>
										<td class="label">MB <span style="color:red;">*</span> :</td>
										<td><select name="sl_masterbatch" id="sl_masterbatch" required><option value=''>--Select MB--</option>
										<?php foreach ($masterbatch as $masterbatch_row) {
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('sl_masterbatch',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}?></select></td>

										<td>
										<input type="number" name="sl_mb_per" id="sl_mb_per" min="0"  max="25" step="0.5"  maxlength="4" size="4" value="<?php echo set_value('sl_mb_per');?>" placeholder="%" required>
										<!--
										<input type="text" name="sl_mb_supplier" class="supplier" size="60"  value="<?php echo set_value('sl_mb_supplier');?>" placeholder="MB Supplier">-->
										</td>
										</tr>

										<tr>
										<td class="label">LDPE :</td>
										<td><select name="sl_ldpe" id="sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="sl_ldpe_per" min="0"  max="100" step="1"  id="sl_ldpe_per" maxlength="3" size="3" value="<?php echo set_value('sl_ldpe_per');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">LLDPE :</td>
										<td><select name="sl_lldpe" id="sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="sl_lldpe_per" min="0"  max="100" step="1" id="sl_lldpe_per" maxlength="3" size="3" value="<?php echo set_value('sl_lldpe_per');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">HDPE  :</td>
										<td><select name="sl_hdpe" id="sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="sl_hdpe_per" min="0"  max="100" step="1" id="sl_hdpe_per" maxlength="3" size="3" value="<?php echo set_value('sl_hdpe_per');?>" placeholder="%"></td>
										</tr>

										<tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

										<tr><td class="label"><b>Admer Layer</b></td></tr>


										<tr>
											<td class="label">Gauge <span style="color:red;">*</span> :</td>
											<td><input type="number" name="gauge_two" id="gauge_two" maxlength="2" size="2" value="<?php echo set_value('gauge_two');?>" required></td>
										</tr>

                              <tr>
                              <td class="label">Admer  <span style="color:red;">*</span> :</td>
                              <td><select name="sl_admer_two" id="sl_admer_two" required>
                              <option value=''>--Select Admer--</option>
                              <?php
                              foreach ($admer as $admer_row) {
                                 echo "<option value='".$admer_row->article_no."' ".set_select('sl_admer_two',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="sl_admer_per_two" min="100"  max="100" step="any"  id="sl_admer_per_two" maxlength="3" size="3" value="<?php echo set_value('sl_admer_per_two');?>" placeholder="%" required></td>
                              </tr>

										<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

                              <tr><td class="label"><b>Evoh Layer</b></td></tr>
                              <tr>
                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
                                 <td><input type="number" name="gauge_three"  id="gauge_three" maxlength="2" size="2" value="<?php echo set_value('gauge_three');?>" required></td>
                              </tr>

                              <tr>
                              <td class="label">Evoh <span style="color:red;">*</span> :</td>
                              <td><select name="sl_evoh_three" id="sl_evoh_three" required>
                              <option value=''>--Select Evoh--</option>
                              <?php
                              foreach ($evoh as $evoh_row) {
                                 echo "<option value='".$evoh_row->article_no."' ".set_select('sl_evoh_three',$evoh_row->article_no).">".$evoh_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="sl_evoh_per_three"  min="100" max="100" step="any" id="sl_evoh_per_three" maxlength="3" size="3" value="<?php echo set_value('sl_evoh_per_three');?>" placeholder="%" required></td>
                              </tr>


                              <tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

                              <tr><td class="label"><b>Admer Layer</b></td></tr>
                              <tr>
                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
                                 <td><input type="number" name="gauge_four"  id="gauge_four" maxlength="2" size="2" value="<?php echo set_value('gauge_four');?>" required></td>
                              </tr>

                              <tr>
                              <td class="label">Admer <span style="color:red;">*</span> :</td>
                              <td><select name="sl_admer_four" id="sl_admer_four" required>
                              <option value=''>--Select Admer--</option>
                              <?php
                              foreach ($admer as $admer_row) {
                                 echo "<option value='".$admer_row->article_no."' ".set_select('sl_admer_four',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="sl_admer_per_four" min="100" max="100" step="any" id="sl_admer_per_four" maxlength="3" size="3" value="<?php echo set_value('sl_admer_per_four');?>" placeholder="%" required></td>
                              </tr>


									<tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

								    <tr><td class="label"><b>Inner Layer</b></td></tr>

                            <tr>
                                 <td class="label">Gauge <span style="color:red;">*</span> :</td>
                                 <td><input type="text" name="gauge_five" id="gauge_five" maxlength="5" size="5" value="<?php echo set_value('gauge_five');?>" required></td>
                              </tr>

                           <tr>
                              <td class="label">MB <span style="color:red;">*</span> :</td>
                              <td><select name="sl_masterbatch_five" id="sl_masterbatch_five" required><option value=''>--Select MB--</option>
                              <?php foreach ($masterbatch as $masterbatch_row) {
                                 echo "<option value='".$masterbatch_row->article_no."' ".set_select('sl_masterbatch_five',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                              }?></select></td>

                              <td>
                              <input type="number" name="sl_mb_per_five" id="sl_mb_per_five"  min="0"  max="25" step="0.5" maxlength="4" size="4" value="<?php echo set_value('sl_mb_per_five');?>" placeholder="%" required>
                              
                              </td>
                              </tr>

                              <tr>
                              <td class="label">LDPE :</td>
                              <td><select name="sl_ldpe_five" id="sl_ldpe_five">
                              <option value=''>--Select LDPE--</option>
                              <?php
                              foreach ($ldpe as $ldpe_row) {
                                 echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe_five',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="sl_ldpe_per_five" min="0"  max="100" step="1" id="sl_ldpe_per_five" maxlength="3" size="3" value="<?php echo set_value('sl_ldpe_per_five');?>" placeholder="%"></td>
                              </tr>

                              <tr>
                              <td class="label">LLDPE :</td>
                              <td><select name="sl_lldpe_five" id="sl_lldpe_five">
                              <option value=''>--Select LLDPE--</option>
                              <?php
                              foreach ($lldpe as $lldpe_row) {
                                 echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe_five',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="sl_lldpe_per_five" min="0"  max="100" step="1" id="sl_lldpe_per_five" maxlength="3" size="3" value="<?php echo set_value('sl_lldpe_per_five');?>" placeholder="%"></td>
                              </tr>

                              <tr>
                              <td class="label">HDPE  :</td>
                              <td><select name="sl_hdpe_five" id="sl_hdpe_five">
                              <option value=''>--Select HDPE--</option>
                              <?php
                              foreach ($hdpe as $hdpe_row) {
                                 echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe_five',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
                              }
                              ?>
                              </select></td>
                              <td>
                              <input type="number" name="sl_hdpe_per_five" min="0"  max="100" step="1" id="sl_hdpe_per_five" maxlength="3" size="3" value="<?php echo set_value('sl_hdpe_per_five');?>" placeholder="%"></td>
                              </tr>
										
                              <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

										<tr>
											<td class="label"><b>Approval Authority</b> </td>
											<td><select name="approval_authority">
												<option value=''>--Select Authority--</option>
												<?php 
												foreach ($approval_authority as $approval_authority_row) {
								             echo "<option value='".$approval_authority_row->employee_id."' ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
								             }
								             ?>
								            </select></td>
								         </tr>
										
									
								</table>
							</td>
							<td rowspan="8">
								<table>
									<tr>
										<td class="label">Sleeve Name * :</td>
										<td><span id="article_name" style="color:green;font-weight: bold">
											<?php
												if(!empty($this->input->post('sleeve_dia'))){
								                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
								                echo "<span class='ui teal label'>$sleeve_dia[0]</span>";
								              }else{
								                $sleeve_dia[0]='';
								                $sleeve_dia[1]='';
								              }

								              if(!empty($this->input->post('sleeve_length'))){
								                $sleeve_length=$this->input->post('sleeve_length');
								                echo "<span class='ui teal label'>$sleeve_dia[0]X$sleeve_length</span>";
								                echo "+<span class='ui teal label'>5 Layer</span>";
								              }else{
								                $sleeve_lengthh='';
								              }

								              if(!empty($this->input->post('gauge'))){
								                $gauge=$this->input->post('gauge');
								                echo "<br/>+<br/><span class='ui teal label'>$gauge MIC</span>";
								              }else{
								                $gauge='';
								              }


								              if(!empty($this->input->post('sl_masterbatch')) || !empty($this->input->post('sl_mb_per'))){
								              $data['sl_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch'));

								              	foreach($data['sl_masterbatch'] as $sl_masterbatch_row){
								              	 $sl_mb_per=$this->input->post('sl_mb_per')."%";
								                $sl_masterbatch=$sl_masterbatch_row->article_name;
								                echo "+<span class='ui teal label'>".$sl_masterbatch." ".$sl_mb_per."</span>";

								              }
								             	}else{
								             		$sl_masterbatch="";
								             		$sl_mb_per="";
								             	}

								              if(!empty($this->input->post('sl_ldpe')) && !empty($this->input->post('sl_ldpe_per'))){

								              	$data['sl_ldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe'));
								              	if($data['sl_ldpe']==FALSE){
								                $sl_ldpe="";
								              	}else{
								                foreach($data['sl_ldpe'] as $sl_ldpe_row){
								                  $sl_ldpe=$sl_ldpe_row->article_name;
								                }
								              	}
								                $sl_ldpe_per=$this->input->post('sl_ldpe_per')."%";
								                echo "+<span class='ui teal label'>".$sl_ldpe." ".$sl_ldpe_per."</span>";
								              }else{
								                $sl_ldpe='';
								                $sl_ldpe_per='';
								              }


								              if(!empty($this->input->post('sl_lldpe')) && !empty($this->input->post('sl_lldpe_per'))){

								              	$data['sl_lldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe'));
								              	if($data['sl_lldpe']==FALSE){
								                $sl_lldpe="";
								              	}else{
								                foreach($data['sl_lldpe'] as $sl_lldpe_row){
								                  $sl_lldpe=$sl_lldpe_row->article_name;
								                }
								              	}
								                $sl_lldpe_per=$this->input->post('sl_lldpe_per')."%";
								                echo "+<span class='ui teal label'>".$sl_lldpe." ".$sl_lldpe_per."</span>";
								              }else{
								                $sl_lldpe='';
								                $sl_lldpe_per='';
								              }


								              if(!empty($this->input->post('sl_hdpe')) && !empty($this->input->post('sl_hdpe_per'))){

								              	$data['sl_hdpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe'));
								              	if($data['sl_hdpe']==FALSE){
								                $sl_hdpe="";
								              	}else{
								                foreach($data['sl_hdpe'] as $sl_hdpe_row){
								                  $sl_hdpe=$sl_hdpe_row->article_name;
								                }
								              	}
								                $sl_hdpe_per=$this->input->post('sl_hdpe_per')."%";
								                echo "+<span class='ui teal label'>".$sl_hdpe." ".$sl_hdpe_per."</span>";
								              }else{
								                $sl_hdpe='';
								                $sl_hdpe_per='';
								              }

                                      if(!empty($this->input->post('gauge_two'))){
                                        $gauge_two=$this->input->post('gauge_two');
                                        echo "<br/>+<br/><span class='ui teal label'>$gauge_two MIC</span>";
                                      }else{
                                        $gauge_two='';
                                      }


                                      if(!empty($this->input->post('sl_admer_two')) && !empty($this->input->post('sl_admer_per_two'))){

                                       $data['sl_admer_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_admer_two'));
                                       if($data['sl_admer_two']==FALSE){
                                        $sl_admer_two="";
                                       }else{
                                        foreach($data['sl_admer_two'] as $sl_admer_row_two){
                                          $sl_admer_two=$sl_admer_row_two->article_name;
                                        }
                                       }
                                        $sl_admer_per_two=$this->input->post('sl_admer_per_two');
                                        echo "+<span class='ui teal label'>".$sl_admer_two." ".$sl_admer_per_two."</span>";
                                      }else{
                                        $sl_admer_two='';
                                        $sl_admer_per_two='';
                                      }


                                      if(!empty($this->input->post('gauge_three'))){
                                        $gauge_three=$this->input->post('gauge_three');
                                        echo "<br/>+<br/><span class='ui teal label'>$gauge_three MIC</span>";
                                      }else{
                                        $gauge_three='';
                                      }


                                      if(!empty($this->input->post('sl_evoh_three')) && !empty($this->input->post('sl_evoh_per_three'))){

                                       $data['sl_evoh_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_evoh_three'));
                                       if($data['sl_evoh_three']==FALSE){
                                        $sl_evoh_three="";
                                       }else{
                                        foreach($data['sl_evoh_three'] as $sl_evoh_row_three){
                                          $sl_evoh_three=$sl_evoh_row_three->article_name;
                                        }
                                       }
                                        $sl_evoh_per_three=$this->input->post('sl_evoh_per_three');
                                        echo "+<span class='ui teal label'>".$sl_evoh_three." ".$sl_evoh_per_three."</span>";
                                      }else{
                                        $sl_evoh_three='';
                                        $sl_evoh_per_three='';
                                      }


                                      if(!empty($this->input->post('gauge_four'))){
                                        $gauge_four=$this->input->post('gauge_four');
                                        echo "<br/>+<br/><span class='ui teal label'>$gauge_four MIC</span>";
                                      }else{
                                        $gauge_four='';
                                      }


                                      if(!empty($this->input->post('sl_admer_four')) && !empty($this->input->post('sl_admer_per_four'))){

                                       $data['sl_admer_four']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_admer_four'));
                                       if($data['sl_admer_four']==FALSE){
                                        $sl_admer_four="";
                                       }else{
                                        foreach($data['sl_admer_four'] as $sl_admer_row_four){
                                          $sl_admer_four=$sl_admer_row_four->article_name;
                                        }
                                       }
                                        $sl_admer_per_four=$this->input->post('sl_admer_per_four');
                                        echo "+<span class='ui teal label'>".$sl_admer_four." ".$sl_admer_per_four."</span>";
                                      }else{
                                        $sl_admer_four='';
                                        $sl_admer_per_four='';
                                      }


                                      if(!empty($this->input->post('gauge_five'))){
                                        $gauge_five=$this->input->post('gauge_five');
                                        echo "<br/>+<br/><span class='ui teal label'>$gauge_five MIC</span>";
                                      }else{
                                        $gauge_five='';
                                      }

                                      if(!empty($this->input->post('sl_masterbatch_five')) || !empty($this->input->post('sl_mb_per_five'))!=0){
                                   $data['sl_masterbatch_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch_five'));

                                     foreach($data['sl_masterbatch_five'] as $sl_masterbatch_five_row){
                                       $sl_masterbatch_five=$sl_masterbatch_five_row->article_name;
                                     }


                                     if(!empty($this->input->post('sl_mb_per_five')) && $this->input->post('sl_mb_per_five')!=0){
                                       $sl_mb_per_five=$this->input->post('sl_mb_per_five')."%";
                                     }else{
                                       $sl_mb_per_five="";
                                     }

                                     echo "+<span class='ui teal label'>$sl_mb_per_five $sl_mb_per_five</span>";

                                    }else{
                                     $sl_masterbatch_five="";
                                     $sl_mb_per_five="";
                                   }



                                    if(!empty($this->input->post('sl_ldpe_five')) && !empty($this->input->post('sl_ldpe_per_five'))){

                                     $data['sl_ldpe_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe_five'));
                                     if($data['sl_ldpe_five']==FALSE){
                                     $sl_ldpe_five="";
                                     }else{
                                     foreach($data['sl_ldpe_five'] as $sl_ldpe_five_row){
                                       $sl_ldpe_five=$sl_ldpe_five_row->article_name;
                                       }
                                     }
                                     if(!empty($this->input->post('sl_ldpe_per_five')) && $this->input->post('sl_ldpe_per_five')!=0){
                                       $sl_ldpe_per_five=$this->input->post('sl_ldpe_per_five')."%";
                                     }else{
                                       $sl_ldpe_per_five="";
                                     }

                                     echo "+<span class='ui teal label'>$sl_ldpe_five $sl_ldpe_per_five</span>";
                                     
                                   }else{
                                     $sl_ldpe_five='';
                                     $sl_ldpe_per_five='';
                                   }


                                   if(!empty($this->input->post('sl_lldpe_five')) && !empty($this->input->post('sl_lldpe_per_five'))){

                                     $data['sl_lldpe_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe_five'));
                                     if($data['sl_lldpe_five']==FALSE){
                                     $sl_lldpe_five="";
                                     }else{
                                     foreach($data['sl_lldpe_five'] as $sl_lldpe_five_row){
                                       $sl_lldpe_five=$sl_lldpe_five_row->article_name;
                                       }
                                     }

                                     if(!empty($this->input->post('sl_lldpe_per_five')) && $this->input->post('sl_lldpe_per_five')!=0){
                                       $sl_lldpe_per_five=$this->input->post('sl_lldpe_per_five')."%";
                                     }else{
                                       $sl_lldpe_per_five="";
                                     }
                                     echo "+<span class='ui teal label'>$sl_lldpe_five $sl_lldpe_per_five</span>";
                                   }else{
                                     $sl_lldpe_five='';
                                     $sl_lldpe_per_five='';
                                   }

                                   if(!empty($this->input->post('sl_hdpe_five')) && !empty($this->input->post('sl_hdpe_per_five'))){

                                     $data['sl_hdpe_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe_five'));
                                     if($data['sl_hdpe_five']==FALSE){
                                     
                                     }else{
                                     foreach($data['sl_hdpe_five'] as $sl_hdpe_five_row){
                                       $sl_hdpe_five=$sl_hdpe_five_row->article_name;
                                       }
                                     }

                                     if(!empty($this->input->post('sl_hdpe_per_five')) && $this->input->post('sl_hdpe_per_five')!=0){
                                       $sl_hdpe_per_five=$this->input->post('sl_hdpe_per_five')."%";
                                     }else{
                                       $sl_hdpe_per_five="";
                                     }
                                     echo "+<span class='ui teal label'>$sl_hdpe_five $sl_hdpe_per_five</span>";
                                   }else{
                                     $sl_hdpe_five='';
                                     $sl_hdpe_per_five='';
                                   }
                                    ?>
										</span>
									</td>
								</tr>
								</table>
							</td>
						</tr>
			</table>
				
			

	</div>

	<div class="form_design">
		<div class="ui buttons">
	  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  <div class="or"></div>
	  <button class="ui positive button">Save</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			