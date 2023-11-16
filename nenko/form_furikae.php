<?php if($nenko_data_unserialize->isTypeOyakata() == true){
 $furikae_date = '2月8日（木）';
 $telno = '0120-931-519';
} else {
 $furikae_date = '3月8日（金）';
 $telno = '0120-855-865';
}
?>
 <div id="kakunin_furikae_kouza" class="shiharai_box_text">
  <h3><?php echo $nenko_data_unserialize->Name();?>様は口座振替のご登録済みです。</h3>
  <p><span style="color: red;">振替日は、<?php echo $furikae_date;?>です。</span></p>
  <p>下記ご登録口座より振替となります。事前にご確認をお願いいたします。</p>
  <br>
  <p><?php echo nl2br($nenko_data_unserialize->getKozaJohoMasked());?></p>
  <br>
  <p>※ ご登録の口座情報を変更される場合は、必ず<?php echo $telno;?>までお電話ください。</p>
 </div>

 <form name="form" method="post" action="trans.php">
  <input type="hidden" name="pagename" value="kingaku">
  <input type="hidden" name="shiharai_type" value="<?php echo SHIHARAI_TYPE_FURIKAE;?>">

  <input type="hidden" name="nenko_data" value="<?php echo base64_encode($_SESSION['nenko_data']);?>">

  <input type="submit" class="submit_button" name="submit_button" id="submit_button" value="次へすすむ">
 </form>
