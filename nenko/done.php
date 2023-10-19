<?php
 session_start();
 header("Content-type: text/html;charset=utf-8");
 include_once('./class.php');

  $nenko_data_unserialize = unserialize($_SESSION['nenko_data']);

?>

<!doctype html>
<html>
<head>
<?php include_once('./gtm_head.php'); ?>
<?php 
 $title = '継続申込受付完了　｜　年度更新手続';
 $description = '';
 include_once('./head_settings.php');
 ?>
 
</head>

<body>
<?php include_once('./gtm_body.php'); ?>
<?php include_once('./body_settings.php'); ?>
<?php
 $logo_img = 'https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/logo_img/logo_hitorioyakata.png';
 $flow_class1 = '';
 $flow_class2 = '';
 $flow_class3 = 'flow_active';
 include_once('./header.php'); 
 ?>

  
 <div class="outer_box inner">
  <h2 class="outer_box_title">継続申込　受付完了</h2>
  <div class="outer_box_body">
   
   <div class="kingaku_box">
    <h3 class="keizokusyalist_header">
     <span class="keizokusyalist_header_title">継続申込を受付しました</span>
     <span class=""></span>
     <span class=""></span>
    </h3>
    
    <p>
     ご継続申込いただき、ありがとうございました。<br>
     お振込先のメールを送信しています。<br>
     期限内に必ず振込ください。<br>
     なお、会員カードは、お支払い完了から３週間以内に順次発送させていただきます。
    </p>
    
    <form name="form" method="post" action="trans.php">
     <input type="hidden" name="pagename" value="done">

     <input type="hidden" name="nenko_data" value="<?php echo base64_encode($_SESSION['nenko_data']);?>">

     <input type="submit" class="submit_button" name="submit_button" id="submit_button" value="マイページトップへ">
    </form>
   </div>
  </div>
 </div>
  
 
<?php include_once('./footer.php'); ?>
 
 <script>
 </script>
</body>
</html>
