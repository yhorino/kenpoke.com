<?php
 session_start();
 header("Content-type: text/html;charset=utf-8");
 include_once('./class.php');

 $nenko_data_unserialize = unserialize($_SESSION['nenko_data']);
 $nenko_data_unserialize->updateNenkoRecordData();

 if($nenko_data_unserialize->isTypeJimukumiai()){
  $box_title = '継続申込　受付完了';
  $header_title = '継続申込を受付しました';
  $body = '
      ご継続申込みいただき、ありがとうございました。<br>
      会員カードは、3月8日（金）の振替後、3週間以内に順次発送させていただきます。<br>
      <br>
      登録情報に変更がある場合は、<a href="https://www.xn--y5q0r2lqcz91qdrc.com/mypage/kaisya.php">こちら</a>から
  ';
  
  if($nenko_data_unserialize->getKeizokusyaNum() <= 0){
   $box_title = '脱退連絡受付しました';
   $header_title = '営業時間内にお電話ください';
   $body = '
   脱退のご連絡を受け付けました。<br>
   確認事項があります。<br>
   営業時間内に、<a href="tel:0120855865">0120-855-865</a>までお電話ください。<br>
   営業時間は、月曜日から金曜日（土日祝を除く）9:00～17:30までとなっております。
   ';
  }
 }




 if($nenko_data_unserialize->isTypeOyakataDairi()){
  $box_title = '継続申込　受付完了';
  $header_title = '継続申込を受付しました';
  $body = '
      ご継続申込いただき、ありがとうございました。<br>
      お振込先のメールを送信しています。<br>
      期限内に必ず振込ください。<br>
      なお、会員カードは、お支払い完了から３週間以内に順次発送させていただきます。<br>
      <br>
      登録情報に変更がある場合は、<a href="#" onclick="outputPDF();">こちら</a>から
  ';
  
  if($nenko_data_unserialize->getKeizokusyaNum() <= 0){
   $box_title = '脱退連絡受付しました';
   $header_title = '脱退のご連絡確認しました';
   $body = '
       一人親方労災保険RJCをご利用いただき、ありがとうございました。<br>
       一人親方労災保険が必要な時は、いつでも一人親方労災保険RJCにお声がけください。
   ';
  }
  if($nenko_data_unserialize->ShiharaiType() == SHIHARAI_TYPE_CARD){
   $box_title = '継続申込　受付完了';
   $header_title = '継続申込を受付しました';
   $body = '
       ご継続申込みいただき、ありがとうございました。<br>
       会員カードは、3週間以内に順次発送させていただきます。<br>
       <br>
       登録情報に変更がある場合は、<a href="#" onclick="outputPDF();">こちら</a>から
   ';
  }
  if($nenko_data_unserialize->ShiharaiType() == SHIHARAI_TYPE_FURIKAE){
   $box_title = '継続申込　受付完了';
   $header_title = '継続申込を受付しました';
   $body = '
       ご継続申込みいただき、ありがとうございました。<br>
       会員カードは、2月8日（木）の振替後、3週間以内に順次発送させていただきます。<br>
       <br>
       登録情報に変更がある場合は、<a href="#" onclick="outputPDF();">こちら</a>から
   ';
  }
 }




 if($nenko_data_unserialize->isTypeOyakataKanyusya()){
  $box_title = '継続申込　受付完了';
  $header_title = '継続申込を受付しました';
  $body = '
      ご継続申込いただき、ありがとうございました。<br>
      お振込先のメールを送信しています。<br>
      期限内に必ず振込ください。<br>
      なお、会員カードは、お支払い完了から３週間以内に順次発送させていただきます。<br>
      <br>
      登録情報に変更がある場合は、<a href="https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/mailform_new/mypage/editinfo.php">こちら</a>から
  ';
  
  if($nenko_data_unserialize->getKeizokusyaNum() <= 0){
   $box_title = '脱退連絡受付しました';
   $header_title = '脱退のご連絡確認しました';
   $body = '
       一人親方労災保険RJCをご利用いただき、ありがとうございました。<br>
       一人親方労災保険が必要な時は、いつでも一人親方労災保険RJCにお声がけください。
   ';
  }
  if($nenko_data_unserialize->ShiharaiType() == SHIHARAI_TYPE_CARD){
   $box_title = '継続申込　受付完了';
   $header_title = '継続申込を受付しました';
   $body = '
       ご継続申込みいただき、ありがとうございました。<br>
       会員カードは、3週間以内に順次発送させていただきます。<br>
       <br>
       登録情報に変更がある場合は、<a href="https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/mailform_new/mypage/editinfo.php">こちら</a>から
   ';
  }
  if($nenko_data_unserialize->ShiharaiType() == SHIHARAI_TYPE_FURIKAE){
   $box_title = '継続申込　受付完了';
   $header_title = '継続申込を受付しました';
   $body = '
       ご継続申込みいただき、ありがとうございました。<br>
       会員カードは、2月8日（木）の振替後、3週間以内に順次発送させていただきます。<br>
       <br>
       登録情報に変更がある場合は、<a href="https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/mailform_new/mypage/editinfo.php">こちら</a>から
   ';
  }
 }

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
 $flow_class1 = '';
 $flow_class2 = '';
 $flow_class3 = 'flow_active';
 include_once('./header.php'); 
 ?>

  
 <div class="outer_box inner">
  <h2 class="outer_box_title"><?php echo $box_title;?></h2>
  <div class="outer_box_body">
   
   <div class="kingaku_box">
    <h3 class="keizokusyalist_header oneline">
     <span class="keizokusyalist_header_title"><?php echo $header_title;?></span>
    </h3>
    
    <p>
     <?php echo $body;?>
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
 
<?php include_once('./kaisyahenko_pdfmake.php'); ?>
 
</body>
</html>
