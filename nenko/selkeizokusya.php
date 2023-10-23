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
 $title = '継続者確認　｜　年度更新手続';
 $description = '';
 include_once('./head_settings.php');
 ?>
 
</head>

<body>
<?php include_once('./gtm_body.php'); ?>
<?php include_once('./body_settings.php'); ?>
<?php
 $logo_img = 'https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/logo_img/logo_hitorioyakata.png';
 $flow_class1 = 'flow_active';
 $flow_class2 = '';
 $flow_class3 = '';
 include_once('./header.php'); 
 ?>

 <form name="form" method="post" action="trans.php">
 <input type="hidden" name="pagename" value="selkeizokusya">
  
 <div class="outer_box inner">
  <h2 class="outer_box_title">継続する方をお選びください</h2>
  <div class="outer_box_body">
   
   <div class="keizokusya_itembox_header">
    <span class="keizokusya_itembox_header_label">継続対象者</span>
    <span class="keizokusya_itembox_header_ninzu"><?php echo $nenko_data_unserialize->getKanyusyaNum();?> 名</span>
   </div>
   
   <div class="keizokusya_itembox_grid">
    
    <?php 
    for($i=0;$i<$nenko_data_unserialize->getKanyusyaNum();$i++){
     $kdata = $nenko_data_unserialize->getKanyusyaData($i);
     $sel1=''; $sel2='';
     if($kdata->isKeizoku()){ $sel1 = 'checked';}
     else { $sel2 = 'checked';}
    ?>
    <div class="keizokusya_itembox">
     <div class="keizokusya_itembox_left">
      <span class="keizokusya_no"><?php echo $kdata->No();?></span>
      <span class="keizokusya_name"><?php echo $kdata->Name();?></span>
     </div>
     <div class="keizokusya_itembox_center">
      <label class="keizokusel_button"><input type="radio" name="keizokusel_<?php echo $i;?>" id="keizokusel_<?php echo $i;?>_keizoku" value="keizoku" <?php echo $sel1;?>>継続</label>
      <label class="keizokusel_button"><input type="radio" name="keizokusel_<?php echo $i;?>" id="keizokusel_<?php echo $i;?>_dattai" value="dattai" <?php echo $sel2;?>>脱退</label>
     </div>
     <div class="keizokusya_itembox_right">
      <table class="keizokusya_kingaku_table">
       <tr>
        <th>給付基礎日額</th>
        <th>保険料等</th>
       </tr>
       <tr>
        <td><?php echo number_format($kdata->Nichigaku());?> 円</td>
        <td><?php echo number_format($kdata->Kingaku());?> 円</td>
       </tr>
      </table>
      <div class="change_nichigaku_box">
       
       <div id="nichigaku_title<?php echo $i;?>" class="change_nichigaku_title" onclick="change_nichigaku_title_click('<?php echo $i;?>');">給付基礎日額を変更する ▼</div>
       
       <div class="change_nichigaku_body">
        
        <label id="cnb<?php echo $i;?>_3500" class="change_nichigaku_button buttonA" ><input type="radio" name="change_nichigaku<?php echo $i;?>" value="3500">3,500円</label>
        
        <label id="cnb<?php echo $i;?>_10000" class="change_nichigaku_button buttonB " onclick="change_nichigaku_button_click('cnb<?php echo $i;?>_10000');"><input type="radio" name="change_nichigaku<?php echo $i;?>" value="10000" >10,000円</label>
        
        <label id="cnb<?php echo $i;?>_now" class="change_nichigaku_button buttonC" onclick="change_nichigaku_button_click('cnb<?php echo $i;?>_now');"><input type="radio" name="change_nichigaku<?php echo $i;?>" value="<?php echo $kdata->Nichigaku();?>" checked>現在の日額　<?php echo number_format($kdata->Nichigaku());?>円</label>
        
       </div>
      
      </div>
     </div>
    </div>
    <?php } ?>

   </div>
   
   <div class="keizokusya_infobox">
    <div class="keizokusya_infobox_title">
     年度途中の日額変更はできません。<br>ご確認ください。
    </div>
    <div class="keizokusya_infobox_body">
     ご加入者さまから「日額を変更したい。次の現場は日額10,000円以上でないと入場できないと言われた」とお電話をいただく事例がございます。<br>
     厚生労働省より、給付基礎日額の変更は年1回（3/2～3/31）だけと定められています。年度途中の日額変更はできません。<br>
     新規で加入された際に「とにかく安く入りたい」と日額3,500円を選ばれた方は、この更新の機会に入場する工事現場の監督さんに「日額3,500円でもいいか」と確認することをお勧めしております。<br>
     なお、RJCに日額3,500円で加入したが、一旦脱退してほかの団体に新たに日額10,000円で加入しても、厚生労働省は把握しています。<br>
     万一事故にあったとき、旧の日額3,500円を元に休業補償等は支払われることになります。労災保険料は高くても支払いは低い日額で支払われることになりますのでご注意ください。
    </div>
   </div>
   
   <label class="info_check"><input type="checkbox" name="info_check" id="info_check"> 上記内容を確認しました</label>

   <input type="hidden" name="nenko_data" value="<?php echo base64_encode($_SESSION['nenko_data']);?>">

   <input type="submit" class="submit_button" name="submit_button" id="submit_button" value="継続手続きを進める" disabled>
  </div>
  
 </div>
  
 </form>
 
<?php include_once('./footer.php'); ?>
 
 <script>
  $(function(){
   $('.change_nichigaku_body').hide();
   $('input[name="info_check"]').prop('checked', false);
   
   $('input[name="info_check"]').click(function(){
    if($(this).prop('checked') == true){
     $('input[name="submit_button"]').prop('disabled', false);
    } else {
     $('input[name="submit_button"]').prop('disabled', true);
    }
   });
   $('.keizokusel_button input').click(function(){
    $(this).parents('.keizokusya_itembox').removeClass('dattai');
    $val = $(this).val();
    if($val == 'dattai'){
     $(this).parents('.keizokusya_itembox').addClass('dattai');
    }
   });
  });
  function change_nichigaku_title_click($idx){
   $('#nichigaku_title'+$idx).next('.change_nichigaku_body').toggle();
  }
 </script>
</body>
</html>
