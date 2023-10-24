<?php
 session_start();
 header("Content-type: text/html;charset=utf-8");

 include_once('./class.php');

 /* DEBUG */
 if(isset($_GET['debugstart'])){
  if($_GET['debugstart'] == 1){$type = '一人親方代理';}
  if($_GET['debugstart'] == 2){$type = '一人親方加入者';}
  if($_GET['debugstart'] == 11){$type = '事務組合会社';}
  if($_GET['debugstart'] == 12){$type = '事務組合加入者';}
  $nenko_data = new NenkoData($type, $_GET['no']);
  $nenko_data->getNenkoRecordData();
  $nenko_data->getNenkoKanyusyaRecordData();

  $_SESSION['nenko_data'] = serialize($nenko_data);

  header('Location: selkeizokusya.php');
  exit;
 }
 /* DEBUG */


 // 再POSTされたシリアライズ済みオブジェクトデータをセッション変数に入れなおす
 $_SESSION['nenko_data'] = base64_decode($_POST['nenko_data']);

 switch($_POST['pagename']){
  case 'selkeizokusya':
  {
   $nenko_data_unserialize = unserialize($_SESSION['nenko_data']);

   /* 継続者確認 */
   $_sougaku = 0;
   $_santei_goukei = 0;
   for($i=0;$i<$nenko_data_unserialize->getKanyusyaNum();$i++){
    /* 継続/脱退　状態更新 */
    $nenko_data_unserialize->updateKanyusyaKeizoku($i, $_POST['keizokusel_'.$i]);
    
    if($nenko_data_unserialize->getKanyusyaData($i)->isKeizoku() == true){
     $_sougaku += $nenko_data_unserialize->getKanyusyaData($i)->Kingaku();
     //$_santei_goukei += 
    }
    
   }
   /* 合計金額の計算 */
   if($nenko_data_unserialize->isTypeOyakata() == true){
    /* 一人親方：保険料＋会費　の合計額 */
    $nenko_data_unserialize->updateSougaku($_sougaku);
   }
   if($nenko_data_unserialize->isTypeJimukumiai() == true){
    /* 事務組合： 
    ・日額×365×月数÷12＝1人当たりの算定基礎額
    ・SUM（算定基礎額）　→切り捨てる
    ・ここに料率をかける　→切り捨てる
    */
   }
   
   $_SESSION['nenko_data'] = serialize($nenko_data_unserialize);
   
   if($nenko_data_unserialize->getKeizokusyaNum() <= 0){
    header('Location: done.php');
   } else {
    header('Location: kingaku.php');
   }
   break;
  }
  case 'kingaku':
  {
   $nenko_data_unserialize = unserialize($_SESSION['nenko_data']);

   $nenko_data_unserialize->updateShiharaiType($_POST['shiharai_sel']);
   if($nenko_data_unserialize->ShiharaiType == '銀行振込'){
    $nenko_data_unserialize->updateShiharaiKigen($_POST['shiharai_day']);
   } else {
    $nenko_data_unserialize->updateShiharaiKigen('');
   }
   
   $_SESSION['nenko_data'] = serialize($nenko_data_unserialize);
   header('Location: done.php');
   break;
  }
  case 'done':
  {
   
   header('Location: debugstart.php');
   break;
  }
 }

?>
