<?php
 session_start();
 header("Content-type: text/html;charset=utf-8");
 include_once('./class.php');

 $nenko_data_unserialize = unserialize($_SESSION['nenko_data']);
 include('./session_check.php');

?>

<!doctype html>
<html>
<head>
<?php include_once('./gtm_head.php'); ?>
<?php 
 $title = '継続者金額確認　｜　年度更新手続';
 $description = '';
 include_once('./head_settings.php');
 ?>
 
</head>

<body>
<?php include_once('./gtm_body.php'); ?>
<?php include_once('./body_settings.php'); ?>
<?php
 $flow_class1 = '';
 $flow_class2 = 'flow_active';
 $flow_class3 = '';
 include_once('./header.php'); 
 ?>

  
 <div class="outer_box inner">
  <h2 class="outer_box_title">継続対象者と金額を確認ください</h2>
  <div class="outer_box_body">
   
   <div class="kingaku_box" id="kingaku_box_mitsumori">
    <h3 class="keizokusyalist_header">
     <span class="keizokusyalist_header_title">継続される方：<?php echo $nenko_data_unserialize->getKeizokusyaNum();?>名</span>
     <span class="keizokusyalist_header_info">※ 明細が必要な方は、この画面を印刷ください。</span>
     <span class="keizokusyalist_header_button" onclick="window.print()">印刷する</span>
    </h3>
    
    <table class="keizokusyalist_table">
     <tr>
      <th>No.</th>
      <th>会員番号</th>
      <th>氏名</th>
      <th>給付基礎日額</th>
      <th class="jimu_hide">お支払総額</th>
     </tr>
     <?php 
     $keizoku_no = 0;
     for($i=0;$i<$nenko_data_unserialize->getKanyusyaNum();$i++){
      $kdata = $nenko_data_unserialize->getKanyusyaData($i);
      if($kdata->isKeizoku()){
       $keizoku_no++;
     ?>
     <tr>
      <td><?php echo $keizoku_no;?></td>
      <td><?php echo $kdata->No();?></td>
      <td><?php echo $kdata->Name();?></td>
      <td><?php echo number_format($kdata->NichigakuSel());?> 円</td>
      <td class="jimu_hide"><?php echo number_format($kdata->KingakuSel());?> 円</td>
     </tr>
     <?php } ?>
     <?php } ?>
    </table>
    
    <div class="keizokusya_mitsumori_box">
     <div class="keizokusya_mitsumori_sougaku">
      <span class="keizokusya_mitsumori_sougaku_title">保険料等のお支払い総額</span>
      <span class="keizokusya_mitsumori_sougaku_kingaku"><?php echo number_format($nenko_data_unserialize->Sougaku());?> 円</span>
     </div>
     <div class="keizokusya_mitsumori_info">
      <div class="keizokusya_mitsumori_info_line">
       <span class="keizokusya_mitsumori_info_line_title">継続期間</span>
       <span class="keizokusya_mitsumori_info_line_text">2024年4月1日　～　2025年3月31日</span>      
      </div>
      <div class="keizokusya_mitsumori_info_line">
       <span class="keizokusya_mitsumori_info_line_title">継続対象者</span>
       <span class="keizokusya_mitsumori_info_line_text"><?php echo $nenko_data_unserialize->getKeizokusyaNum();?> 名</span>
      </div>
     </div>
     <p class="keizokusya_mitsumori_addinfo">※ お支払総額には会費、保険料が含まれています。</p>
    </div>

    <div class="submit_box submit_box_show_shiharai">
     <input type="button" class="nenko_next button shadow" name="show_shiharai_button" id="show_shiharai_button" value="この内容ですすむ">
    </div>
    
   </div>
   
   <div class="kingaku_box" id="kingaku_box_shiharai">
    <h3 class="keizokusyalist_header">
     <span class="keizokusyalist_header_title">お支払方法</span>
     <span class=""></span>
     <span class=""></span>
    </h3>
    <div class="shiharai_buttons_box">
     <label class="shiharai_button" id="shiharai_card_label"><input type="radio" name="shiharai_sel" id="shiharai_card" value="<?php echo SHIHARAI_TYPE_CARD;?>" checked>クレジットカード</label>
     <label class="shiharai_button" id="shiharai_bank_label"><input type="radio" name="shiharai_sel" id="shiharai_bank" value="<?php echo SHIHARAI_TYPE_BANK;?>">銀行振込</label>
     <label class="shiharai_button" id="shiharai_furikae_label"><input type="radio" name="shiharai_sel" id="shiharai_furikae" value="<?php echo SHIHARAI_TYPE_FURIKAE;?>">口座振替</label>
    </div>
   
    <div id="shiharai_card_box" class="shiharai_card_box">
     <?php include('form_card.php'); ?>
    </div>
   
    <div id="shiharai_bank_box" class="shiharai_bank_box">
     <?php include('form_bank.php'); ?>
    </div>
    
    <div id="shiharai_furikae_box" class="shiharai_furikae_box">
     <?php include('form_furikae.php'); ?>
    </div>
    
  </div>
  
  </div>
 </div>
  
 
<?php include_once('./footer.php'); ?>
 
 <script>
  $furikae = <?php if($nenko_data_unserialize->isFurikae() == true){echo 'true';} else {echo 'false';}?>;
  $(function(){
   
   disp_init();
   $('#kingaku_box_shiharai').hide();
   
   if($furikae == true){
    $('#shiharai_furikae_box').show();    
    $('#shiharai_card_label').hide();
    $('#shiharai_bank_label').hide();
    $('#shiharai_furikae').prop('checked', true);
    $('.shiharai_buttons_box').addClass('buttons_furikae');
   } else {
    $('#shiharai_card_box').show();
    $('#shiharai_furikae_label').hide();
   }
   
   $('input[name="shiharai_sel"]').change(function(){
    $sel = $('input[name="shiharai_sel"]:checked').val();
    
    disp_init();
    if($sel == '<?php echo SHIHARAI_TYPE_CARD;?>'){
     $('#shiharai_card_box').show();
     return;
    }
    if($sel == '<?php echo SHIHARAI_TYPE_BANK;?>'){
     $('#shiharai_bank_box').show();
     $('#kakunin_bank').show()
     return;
    }
    if($sel == '<?php echo SHIHARAI_TYPE_FURIKAE;?>'){
     $('#shiharai_furikae_box').show();
     return;
    }
   });
   
   $('input[name="show_shiharai_button"]').click(function(){
    $('#kingaku_box_shiharai').show();
    $(this).hide();
   });
   
  });
  function disp_init(){
   $('#shiharai_card_box').hide();
   $('#shiharai_bank_box').hide();
   $('#shiharai_furikae_box').hide();
   $('#kakunin_bank').hide()
   $('#cal_div').hide();
  }
 </script>
</body>
</html>
