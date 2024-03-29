<?php 
$kigen_last = date('2024-03-15');
$kigen = date('Y-m-d', strtotime('+3 days'));
if ($kigen > $kigen_last) { $kigen = $kigen_last; }
$kigen_max = date('Y-m-d', strtotime('+10 days'));
if ($kigen_max > $kigen_last) { $kigen_max = $kigen_last; }

$kigen_disp = date('Y年m月d日', strtotime($kigen));
$kigen_max_disp = date('Y年m月d日', strtotime($kigen_max));
setlocale(LC_TIME, 'ja_JP.UTF-8');
$kigen_dow = strftime("%a", strtotime($kigen));
$kigen_max_dow = strftime("%a", strtotime($kigen_max));
$kigen_disp = $kigen_disp.'('.$kigen_dow.')';
$kigen_max_disp = $kigen_max_disp.'('.$kigen_max_dow.')';
?>

 <form name="form" method="post" action="trans.php">
  
 <link rel="stylesheet" href="form_bank.css">
 <script src="form_bank.js"></script>

 <!-- https://www.sejuku.net/blog/104657 -->
 <div class="popup" id="kakunin_bank">
  <div class="content">
   <img src="/nenko/img/symbol_a.png" alt="" id="symbol_a">
   <h2>お振込みのご注意</h2>
   <p class="p1">振込手数料は、お客様負担となります。<br>
    お振込み期限は、本日から3日以内です。<br>
    （最終期限：3月15日（金））<br>
    <!--お振込み期限は、3月6日（月）です。<br>-->
    昨年度は99%の方が期限内にお振込みいただいております。</p>
   <p class="p2"><span id="bank_kigen2"><?php echo $kigen_disp;?></span>までに<br>
    お振込みできますか？</p>
   <div class="popup_button_div">
    <a id="popup_yes">できる</a>
    <a id="popup_no">できない</a>
    <a id="popup_close">×</a>
   </div>
   <div id="cal_div" class="cal_div">
    <p>お支払い可能な期限を<br><?php echo $kigen_disp;?>～<?php echo $kigen_max_disp;?><br>の間で選択してください。</p>
    <input type="date" name="shiharai_day" id="shiharai_day" min="<?php echo $kigen;?>" max="<?php echo $kigen_max;?>" value="<?php echo $kigen;?>"><br>
    <a id="popup_kakutei">確定</a>
    <p id="kigen_err"><?php echo $kigen_disp;?>～<?php echo $kigen_max_disp;?>の間で指定してください。</p>
   </div>
   <p class="p3 jimu_hide">※ 一度振込期限を過ぎますと新規申込みとなります。<br>
　 <span style="color: red;">新規申込では、継続特別価格は適用されません。</span><br>
    お振込みできるタイミングで再度お手続きいただくか、<br>　別のお支払方法を選択してください。</p>
  </div>
    
 </div>
   
 <div id="kakunin_bank_kouza" class="shiharai_box_text">
  <p><span style="color: red;">お振込み期限は、<span id="bank_kigen"><?php echo $kigen_disp;?></span>　までです。</span></p>
  <p>お振込先は、継続申込み受付完了後ご登録のメールアドレスへメールいたします。</p><br>

  <p>振込期限までにお支払いがない場合は、お申込みはキャンセルとさせていただきます。<br>
   <span style="color: red;">一度、キャンセルになりますと次回からお申込みは受付できません。</span></p><br>

  <p>また、お客様のご都合による保険料等入金後の加入取り消しは一切行っておりません。</p>
 </div>
  
 <input type="hidden" name="pagename" value="kingaku">
 <input type="hidden" name="shiharai_type" value="<?php echo SHIHARAI_TYPE_BANK;?>">

 <input type="hidden" name="nenko_data" value="<?php echo base64_encode($_SESSION['nenko_data']);?>">

 <div class="submit_box">
 <button class="back_button" onclick="goBack();">戻る</button>
 <input type="submit" class="submit_button" 　id="submit_button" name="submit_button" value="次へすすむ">
 </div>
  
 </form>
