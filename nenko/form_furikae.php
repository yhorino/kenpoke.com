 <div id="kakunin_furikae_kouza" class="shiharai_box_text">
  <p><span style="color: red;">振替日は、3月8日（金）です。</span></p>
  <p>下記ご登録口座より振替となります。事前にご確認をお願いいたします。</p>
  <br>
  <p>金融機関：XX銀行</p>
  <p>口座番号：***1234</p>
  <br>
  <p>※ ご登録の口座情報を変更される場合は、必ず0120-855-865までお電話ください。</p>
 </div>

 <form name="form" method="post" action="trans.php">
  <input type="hidden" name="pagename" value="kingaku">
  <input type="hidden" name="shiharai_type" value="口座振替">

  <input type="hidden" name="nenko_data" value="<?php echo base64_encode($_SESSION['nenko_data']);?>">

  <input type="submit" class="submit_button" name="submit_button" id="submit_button" value="次へすすむ">
 </form>
