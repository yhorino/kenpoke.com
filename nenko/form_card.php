<?php
  //$mode = -1; // DEBUG
  
  if($mode == -1){
   include "./pg_hash.php";
   $seq_merchant_id='50310';
   $paygent_url = 'https://sandbox.paygent.co.jp/v/u/request';
  } else {
   include "./pg_hash_h.php";   
   $seq_merchant_id='59965';
   $paygent_url = 'https://link.paygent.co.jp/v/u/request';
  }

  $trading_id = rand(0,99999999);/* 後ろに番号をつける */
  $payment_type = '02';
  $fix_params = '';
  $id = '30095';
  $payment_term_day='';
  $payment_term_min='';
  $payment_class='0';
  $use_card_conf_number='0';
/*
  $customer_id=$_SESSION['row_nk_madoguchi']['dairinenkotaishoninzu__c'];
  if($customer_id == ''){
   $_SESSION['row_nk_madoguchi']['dairinenkotaishoninzu__c'] = rand(0,99999999);
   $customer_id=$_SESSION['row_nk_madoguchi']['dairinenkotaishoninzu__c'];
  }
  */
  $threedsecure_ryaku='1';
  $stock_card_mode = 2;

  $hash = pg_hash($trading_id, $payment_type, $fix_params, $id, $seq_merchant_id, $payment_term_day, $payment_term_min, $payment_class, $use_card_conf_number, $customer_id, $threedsecure_ryaku);
?>

<form name="form" method="post" action="<?php echo $paygent_url;?>">
 <input type="hidden" name="shiharai_type" value="クレジットカード">

 <!-- 共通 -->
 <input type="hidden" name="trading_id" value="<?php echo $trading_id;?>">
 <input type="hidden" name="payment_type" value="<?php echo $payment_type;?>">
 <input type="hidden" name="fix_params" value="<?php echo $fix_params;?>">
 <input type="hidden" name="id" value="<?php echo $id;?>">
 <input type="hidden" name="hc" value="<?php echo $hash;?>">
 <input type="hidden" name="seq_merchant_id" value="<?php echo $seq_merchant_id;?>">
 <input type="hidden" name="merchant_name" value="一人親方労災保険ＲＪＣ">
 <input type="hidden" name="payment_detail" value="一人親方年度更新">
 <input type="hidden" name="payment_detail_kana" value="ﾋﾄﾘｵﾔｶﾀﾈﾝﾄﾞｺｳｼﾝ">
 <input type="hidden" name="payment_term_day" value="<?php echo $payment_term_day;?>">
 <input type="hidden" name="payment_term_min" value="<?php echo $payment_term_min;?>">
 <input type="hidden" name="banner_url" value="">
 <input type="hidden" name="free_memo" value="">
 <input type="hidden" name="return_url" value="https://www.kenpoke.com/nenko/done.php">
 <input type="hidden" name="stop_return_url" value="https://www.kenpoke.com/nenko/kingaku.php">
 <input type="hidden" name="copy_right" value="">
 <input type="hidden" name="customer_family_name" value="">
 <input type="hidden" name="customer_name" value="">
 <input type="hidden" name="customer_family_name_kana" value="">
 <input type="hidden" name="customer_name_kana" value="">
 <input type="hidden" name="isbtob" value="">
 <input type="hidden" name="site_id" value="">
 <input type="hidden" name="company_name" value="">
 <input type="hidden" name="finish_disable" value="1">
 <input type="hidden" name="mail_send_flg_success" value="">
 <input type="hidden" name="mail_send_flg_failure" value="">

 <!-- カード決済 -->
 <input type="hidden" name="payment_class" value="<?php echo $payment_class;?>">
 <input type="hidden" name="use_card_conf_number" value="<?php echo $use_card_conf_number;?>">
 <input type="hidden" name="stock_card_mode" value="<?php echo $stock_card_mode;?>">
 <input type="hidden" name="customer_id" value="<?php echo $customer_id:?>">
 <input type="hidden" name="threedsecure_ryaku" value="<?php echo $threedsecure_ryaku;?>">
 <input type="hidden" name="sales_flg" value="">
 <input type="hidden" name="appendix" value="">
 <input type="hidden" name="re_payment_type" value="">
 
 <p class="shiharai_box_text">
 「決済画面へすすむ」ボタンをクリックすると、ペイシェント決済画面（外部サイト）へ移動します。
 </p>
 <p class="shiharai_box_text">
 カード決済は、クレジットカード決済代行の株式会社ペイシェントの決済代行サービスを利用しております。<br>
 安心してお支払いをしていただくために、お客様の情報がペイシェントサイト経由で送信される際にはSSL(128bit)による暗号化通信で行い、クレジットカード情報は当サイトでは保有せず、同社で厳重に管理しております。
 </p>

 <div class="submit_box">
 <input type="submit" class="nenko_next button shadow" 　id="shiharai_card_next_button" name="shiharai_card_next_button" value="決済画面へすすむ">
 </div>

 <p class="card_submit_info">※ クレジットカード決済の画面から進まない場合は、<?php if($nenko_data_unserialize->isTypeOyakata() == true){echo '一人親方労災保険RJC（0120-931-519）';} else {echo '労働保険事務組合RJC（0120-855-865）';}?>までお電話ください。
 </p>

</form>
