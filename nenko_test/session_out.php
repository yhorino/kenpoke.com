<?php
 include_once('./class.php');
 $top_url = '';
 if(isset($_COOKIE['type'])){
  if($_COOKIE['type'] == DATATYPE_OYAKATADAIRI || $_COOKIE['type'] == DATATYPE_OYAKATAKANYUSYA){
   $top_url = 'https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/';
  }
  if($_COOKIE['type'] == DATATYPE_JIMUKAISYA || $_COOKIE['type'] == DATATYPE_JIMUKANYUSYA){
   $top_url = 'https://www.xn--y5q0r2lqcz91qdrc.com/';
  }
 }
?>
<!doctype html>
<html>
<head>
<?php include_once('./gtm_head.php'); ?>
<?php 
 $title = 'セッション有効期限切れ　｜　年度更新手続';
 $description = '';
 include_once('./head_settings.php');
 ?>
 
</head>

<body>
<?php include_once('./gtm_body.php'); ?>
<?php include_once('./body_settings.php'); ?>
<?php
 $flow_class1 = '';
 $flow_class2 = '';
 $flow_class3 = '';
 include_once('./header.php'); 
 ?>

  
 <div class="outer_box inner">
  <h2 class="outer_box_title">セッション有効期限切れ</h2>
  <div class="outer_box_body">
   
   <div class="kingaku_box">
    <p>
     長時間無操作だったため、セッションの有効期限が切れました。
    </p>
    
    <a href="<?php echo $top_url;?>" class="submit_button" id="submit_button">トップページへ</a>
    
   </div>
  </div>
 </div>
  
 
<?php include_once('./footer.php'); ?>
 
 <script>
 </script>
</body>
</html>
