<?php
 session_start();
 header("Content-type: text/html;charset=utf-8");
 include_once('./class.php');

 $nenko_data_unserialize = unserialize($_SESSION['nenko_data']);
 include('./session_check.php');

 $keizokusya_itembox_class = '';
 if($nenko_data_unserialize->isTypeJimukumiai()){
  $keizokusya_itembox_class = ' jimu_itembox ';
 }

// 日額変更許可フラグ設定
define ('NICHIGAKU_CHANGE_OK', 1);
define ('NICHIGAKU_CHANGE_NG', -1);
$NICHIGAKU_CHANGE = NICHIGAKU_CHANGE_OK;

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
 $flow_class1 = 'flow_active';
 $flow_class2 = '';
 $flow_class3 = '';
 include_once('./header.php'); 
 ?>

 <form name="form" method="post" action="trans.php">
 <input type="hidden" name="pagename" value="selkeizokusya">
  
  <?php /* 見本 */ ?>
  <div class="inner">
    <div class="keizokusya_itembox keizokusya_itembox_mihon <?php echo $keizokusya_itembox_class;?>">
     <div class="mihon_title">見本</div>
     <div class="mihon_comment mihon_comment1">①「継続」「脱退」のどちらかを選択してください</div>
     <div class="mihon_comment mihon_comment2">②給付基礎日額の変更はこちらから</div>
     <div class="keizokusya_itembox_left">
      <span class="keizokusya_no">00000000</span>
      <span class="keizokusya_name">労災　太郎</span>
     </div>
     <div class="keizokusya_itembox_center">
      <label class="keizokusel_button"><input type="radio" name="keizokusel_9999" id="keizokusel_9999_keizoku" value="keizoku" checked>継続</label>
      <label class="keizokusel_button"><input type="radio" name="keizokusel_9999" id="keizokusel_9999_dattai" value="dattai">脱退</label>
     </div>
     <div class="keizokusya_itembox_right">
      <table class="keizokusya_kingaku_table">
       <tr>
        <th>給付基礎日額</th>
        <th class="jimu_hide">お支払い総額</th>
       </tr>
       <tr id="row9999_now" class="row9999">
        <td><span class="nichigaku">3,500</span> 円</td>
        <td class="jimu_hide">32,295 円</td>
       </tr>
      </table>
      <div class="change_nichigaku_box">
       
       <div id="nichigaku_title9999" class="change_nichigaku_title">給付基礎日額を変更する ▼</div>
       
       <!--<div class="change_nichigaku_body_mihon">
        
        <label id="cnb9999_3500" class="change_nichigaku_button buttonA"><input type="radio" name="change_nichigaku9999" value="3500">3,500円</label>
        
        <label id="cnb9999_10000" class="change_nichigaku_button buttonB"><input type="radio" name="change_nichigaku9999" value="10000" >10,000円</label>
        
        <label id="cnb9999_now" class="change_nichigaku_button buttonC"><input type="radio" name="change_nichigaku9999" value="3500" checked>現在の日額　3,500円</label>
        
       </div>-->
      
      </div>
     </div>
    </div>
  </div>
  <?php /* 見本 */ ?>
  
  
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
     $sel1=''; $sel2=''; $dattai_class='';
     if($kdata->isKeizoku()){ $sel1 = 'checked';}
     else { $sel2 = 'checked'; $dattai_class='dattai';}
    ?>
    <div class="keizokusya_itembox <?php echo $dattai_class;?> <?php echo $keizokusya_itembox_class;?>">
     <div class="keizokusya_itembox_left">
      <span class="keizokusya_no"><?php echo $kdata->No();?></span>
      <span class="keizokusya_name"><?php echo $kdata->Name();?></span>
     </div>
     <div class="keizokusya_itembox_center">
      <label class="keizokusel_button"><input type="radio" name="keizokusel_<?php echo $i;?>" id="keizokusel_<?php echo $i;?>_keizoku" value="keizoku" <?php echo $sel1;?> class="required keizoku_button">継続</label>
      <label class="keizokusel_button"><input type="radio" name="keizokusel_<?php echo $i;?>" id="keizokusel_<?php echo $i;?>_dattai" value="dattai" <?php echo $sel2;?> class="required dattai_button">脱退</label>
     </div>
     <div class="keizokusya_itembox_right">
      <table class="keizokusya_kingaku_table keizokuitem">
       <tr>
        <th>給付基礎日額</th>
        <th class="jimu_hide">お支払い総額</th>
       </tr>
       <tr id="row<?php echo $i;?>_now" class="row<?php echo $i;?>">
        <td><span class="nichigaku"><?php echo number_format($kdata->Nichigaku());?></span> 円</td>
        <td class="jimu_hide"><?php echo number_format($kdata->Kingaku());?> 円</td>
       </tr>
       <tr id="row<?php echo $i;?>_3500" class="row<?php echo $i;?>" style="display: none;">
        <td><span class="nichigaku">3,500</span> 円</td>
        <td class="jimu_hide"><?php echo number_format($kdata->Kingaku3500());?> 円</td>
       </tr>
       <tr id="row<?php echo $i;?>_10000" class="row<?php echo $i;?>" style="display: none;">
        <td><span class="nichigaku">10,000</span> 円</td>
        <td class="jimu_hide"><?php echo number_format($kdata->Kingaku10000());?> 円</td>
       </tr>
      </table>
      
      <input type="hidden" name="sel_nichigaku<?php echo $i;?>" value="<?php echo $kdata->Nichigaku();?>">
      
      <div class="change_nichigaku_box keizokuitem">
       
       <?php if($NICHIGAKU_CHANGE == NICHIGAKU_CHANGE_NG) { ?>
       <div id="nichigaku_title<?php echo $i;?>" class="change_nichigaku_title nochange" onclick="change_nichigaku_title_click('<?php echo $i;?>');">※ 給付基礎日額は変更できません ▼</div>
       
       <div class="change_nichigaku_body nochange">
        
        <p>
        更新期限後のため、変更できません。<br>次回更新時に変更することが可能です。
        </p>
        
       </div>
       <?php } else if($nenko_data_unserialize->isTypeJimukumiai() && $kdata->isKanyuThisYear()) { ?>
       <div id="nichigaku_title<?php echo $i;?>" class="change_nichigaku_title nochange" onclick="change_nichigaku_title_click('<?php echo $i;?>');">※ 給付基礎日額は変更できません ▼</div>
       
       <div class="change_nichigaku_body nochange">
        
        <p>
        加入期間が1年未満のため、変更できません。<br>次回更新時に変更することが可能です。
        </p>
        
       </div>
       <?php } else { ?>
       <div id="nichigaku_title<?php echo $i;?>" class="change_nichigaku_title" onclick="change_nichigaku_title_click('<?php echo $i;?>');">給付基礎日額を変更する ▼</div>
       
       <div class="change_nichigaku_body">
        
        <label id="cnb<?php echo $i;?>_3500" class="change_nichigaku_button buttonA" onclick="change_nichigaku_button_click(<?php echo $i;?>,'3500');"><input type="radio" name="change_nichigaku<?php echo $i;?>" value="3500">3,500円</label>
        
        <label id="cnb<?php echo $i;?>_10000" class="change_nichigaku_button buttonB " onclick="change_nichigaku_button_click(<?php echo $i;?>,'10000');"><input type="radio" name="change_nichigaku<?php echo $i;?>" value="10000" >10,000円</label>
        
        <label id="cnb<?php echo $i;?>_now" class="change_nichigaku_button buttonC" onclick="change_nichigaku_button_click(<?php echo $i;?>,'now');"><input type="radio" name="change_nichigaku<?php echo $i;?>" value="<?php echo $kdata->Nichigaku();?>" checked>現在の日額　<?php echo number_format($kdata->Nichigaku());?>円</label>
        
       </div>
       <?php } ?>
       
      </div>
      
      <div class="dattairiyu dattaiitem jimu_hide">
       <span class="dattairiyu_title">脱退理由 <span class="required_label">【必須】</span></span>
       <div class="dattairiyu_select">
        <?php 
         $items = $kdata->ItemDattaiRiyu();
         for($j=0;$j<count($items);$j++){
          ?>
        <label><input type="radio" name="dattairiyu_<?php echo $i;?>" value="<?php echo $items[$j];?>" class="required"> <?php echo $items[$j];?>　</label>
        <?php } ?>
       </div>
      </div>
      
     </div>
    </div>
    <?php } ?>

   </div>
   
   <div class="keizokusya_info_dispbox" id="keizokusya_info_dispbox">
   <div class="keizokusya_infobox">
    <div class="keizokusya_infobox_title">
     <img src="/nenko/img/symbol018.png" alt="" class="keizokusya_infobox_title_icon"><span class="keizokusya_infobox_title_text">年度途中の日額変更はできません。<br>ご確認ください。</span>
    </div>
    <div class="keizokusya_infobox_body">
     ご加入者さまから「日額を変更したい。次の現場は日額10,000円以上でないと入場できないと言われた」とお電話をいただく事例がございます。<br>
     厚生労働省より、給付基礎日額の変更は年1回（3/2～3/31）だけと定められています。年度途中の日額変更はできません。<br>
     新規で加入された際に「とにかく安く入りたい」と日額3,500円を選ばれた方は、この更新の機会に入場する工事現場の監督さんに「日額3,500円でもいいか」と確認することをお勧めしております。<br>
     なお、RJCに日額3,500円で加入したが、一旦脱退してほかの団体に新たに日額10,000円で加入しても、厚生労働省は把握しています。<br>
     万一事故にあったとき、旧の日額3,500円を元に休業補償等は支払われることになります。労災保険料は高くても支払いは低い日額で支払われることになりますのでご注意ください。
    </div>
   </div>
   
   <label class="info_check"><input type="checkbox" name="info_check" id="info_check" class="required"> 上記内容を確認しました</label>
   </div>
   
   <input type="hidden" name="nenko_data" value="<?php echo base64_encode($_SESSION['nenko_data']);?>">

   <div class="submit_box">
    <button class="back_button" onclick="goBack();">戻る</button>
    <input type="submit" class="submit_button" name="submit_button" id="submit_button" value="継続手続きを進める">
   </div>
   
  </div>
  
 </div>
  
 </form>
 
<?php include_once('./footer.php'); ?>
 
 <script>
  
  function goBack() {
   event.preventDefault();
   window.history.back();
  }
  
  // ページが読み込まれたら、チェックボックスの状態を初期化する
  window.addEventListener('load', function() {
    $('input[name="info_check"]').prop('checked', false);
  });
  
  $(function(){
   
<?php $sessionLifetime = ini_get('session.gc_maxlifetime'); echo('console.log("gc_maxlifetime='.$sessionLifetime.'");');?>
   
   $('.change_nichigaku_body').hide();
   //$('input[name="info_check"]').prop('checked', false);
   
   /*
   $('input[name="info_check"]').click(function(){
    if($(this).prop('checked') == true){
     $('input[name="submit_button"]').prop('disabled', false);
    } else {
     $('input[name="submit_button"]').prop('disabled', true);
    }
   });
   */
   $('.keizokusel_button input').click(function(){
    $(this).parents('.keizokusya_itembox').removeClass('dattai');
    $val = $(this).val();
    if($val == 'dattai'){
     $(this).parents('.keizokusya_itembox').addClass('dattai');
    }
    $keizoku_count = document.querySelectorAll('input.keizoku_button:checked').length;
    if($keizoku_count <= 0){
     $('#keizokusya_info_dispbox').hide();
     $("#submit_button").val('脱退手続きを進める');
    } else {
     $('#keizokusya_info_dispbox').show();
     $("#submit_button").val('継続手続きを進める');
    }
   });
   
   $('input').click(function(){
    $('input.required').each(function(){
     if($(this).is(':visible')){
      $(this).prop('required', true);
     } else {
      $(this).removeAttr('required');
     }
    });
   });

   /*
   $('.dattairiyu_select input').click(function(){
    var name = $(this).prop('name');
    var checkboxes = document.querySelectorAll('input[name="'+name+'"]');
    var selectedvalues = [];
    checkboxes.forEach(function(checkbox){
     if(checkbox.checked){
      selectedvalues.push(checkbox.value);
     }
    });
    if(selectedvalues.length <= 0){
     $(this).parents('.dattairiyu_select').find('.dattairiyu_sel').val('');
    } else {
     $(this).parents('.dattairiyu_select').find('.dattairiyu_sel').val(selectedvalues.join(';'));
    }
   });
  */
  });
  function change_nichigaku_title_click($idx){
   $('#nichigaku_title'+$idx).next('.change_nichigaku_body').toggle();
  }
  function change_nichigaku_button_click($idx, $name){
   $rowclass = '.row'+$idx;
   $rowid = '#row'+$idx+'_'+$name;
   $($rowclass).hide();
   $($rowid).show();
   
   $nichigaku = $($rowid+" .nichigaku").text();
   $nichigaku = $nichigaku.replace(',','');
   $('input[name="sel_nichigaku'+$idx+'"]').val($nichigaku);
  }
 </script>
</body>
</html>
