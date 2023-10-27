<?php
 session_start();
 header("Content-type: text/html;charset=utf-8");

 include_once('./class.php');

 /* 入口 */
 if(isset($_GET['type'])){

  if($_GET['type'] == 1){$type = DATATYPE_OYAKATADAIRI;}
  if($_GET['type'] == 2){$type = DATATYPE_OYAKATAKANYUSYA;}
  if($_GET['type'] == 11){$type = DATATYPE_JIMUKAISYA;}
  if($_GET['type'] == 12){$type = DATATYPE_JIMUKANYUSYA;}
  setcookie('type', $type);
  $nenko_data = new NenkoData($type, $_GET['no']);
  $ret = $nenko_data->getNenkoRecordData();
  if($ret == false){
   header('Location: error.php');
   break;
  }
  $ret = $nenko_data->getNenkoKanyusyaRecordData();
  if($ret == false){
   header('Location: error.php');
   break;
  }

  $_SESSION['nenko_data'] = serialize($nenko_data);

  header('Location: selkeizokusya.php');
  exit;

 }


 // 再POSTされたシリアライズ済みオブジェクトデータをセッション変数に入れなおす
 $_SESSION['nenko_data'] = base64_decode($_POST['nenko_data']);

 switch($_POST['pagename']){
  case 'selkeizokusya':
  {
   $nenko_data_unserialize = unserialize($_SESSION['nenko_data']);

   /* 継続者確認 */
   $_sougaku = 0;
   $_santeikisogaku_goukei = 0;
   $_kaihi_goukei = 0;
   $_cardhakkou_goukei = 0;
   for($i=0;$i<$nenko_data_unserialize->getKanyusyaNum();$i++){
    /* 継続/脱退　状態更新 */
    $nenko_data_unserialize->setKanyusyaKeizoku($i, $_POST['keizokusel_'.$i]);
    /* 日額選択 */
    $nenko_data_unserialize->setKanyusyaNichigakuSel($i, $_POST['sel_nichigaku'.$i]);
    
    $_kingaku = $nenko_data_unserialize->getKanyusyaData($i)->Kingaku();
    $_santeikisogaku = $nenko_data_unserialize->getKanyusyaData($i)->SanteiKisogaku();
    switch($_POST['sel_nichigaku'.$i]){
     case '3500':
      {
       $_kingaku = $nenko_data_unserialize->getKanyusyaData($i)->Kingaku3500();
       $_santeikisogaku = $nenko_data_unserialize->getKanyusyaData($i)->SanteiKisogaku3500();
       break;
      }
     case '10000':
      {
       $_kingaku = $nenko_data_unserialize->getKanyusyaData($i)->Kingaku10000();
       $_santeikisogaku = $nenko_data_unserialize->getKanyusyaData($i)->SanteiKisogaku10000();
       break;
      }
     default:
      {
       break;
      }
    }
    
    if($nenko_data_unserialize->getKanyusyaData($i)->isKeizoku() == true){
     $nenko_data_unserialize->setKanyusyaKingakuSel($i, $_kingaku);
     $_sougaku += $_kingaku;
     $nenko_data_unserialize->setSanteiKisogakuSel($i, $_santeikisogaku);
     $_santeikisogaku_goukei += $_santeikisogaku;
     $_kaihi_goukei += $nenko_data_unserialize->getKanyusyaData($i)->Kaihi();
     $_cardhakkou_goukei += $nenko_data_unserialize->getKanyusyaData($i)->CardHakkohiyo();
    }
    
   }
   /* 合計金額の計算 */
   if($nenko_data_unserialize->isTypeOyakata() == true){
    /* 一人親方：保険料＋会費　の合計額 */
    $nenko_data_unserialize->setSougaku($_sougaku);
   }
   if($nenko_data_unserialize->isTypeJimukumiai() == true){
    /* 事務組合： 
    ・日額×365＝1人当たりの算定基礎額
    ・SUM（算定基礎額）×料率　→切り捨てる
    */
    $_jimu_ryoritsu = $nenko_data_unserialize->Ryoritsu();
    $_jimu_kaihi = $nenko_data_unserialize->Kaihi() + $_kaihi_goukei;
    $_jimu_hokenryo = floor($_santeikisogaku_goukei * $_jimu_ryoritsu);
    $_sougaku = $_jimu_hokenryo + $_jimu_kaihi + $_cardhakkou_goukei;
    $nenko_data_unserialize->setSougaku($_sougaku);
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
   
   $nenko_data_unserialize->setShiharaiType($_POST['shiharai_type']);
   if($nenko_data_unserialize->ShiharaiType() == SHIHARAI_TYPE_BANK){
    $nenko_data_unserialize->setShiharaiKigen($_POST['shiharai_day']);
   } else {
    $nenko_data_unserialize->setShiharaiKigen('');
   }
   
   $_SESSION['nenko_data'] = serialize($nenko_data_unserialize);
   header('Location: done.php');
   break;
  }
  case 'done':
  {
   $nenko_data_unserialize = unserialize($_SESSION['nenko_data']);
   $returl = '';
   if($nenko_data_unserialize->isTypeOyakata()){
    $returl = 'https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/';
   }
   if($nenko_data_unserialize->isTypeJimukumiai()){
    $returl = 'https://www.xn--y5q0r2lqcz91qdrc.com/';
   }
   $_SESSION['nenko_data'] = serialize($nenko_data_unserialize);
   
   //header('Location: '.$returl);
   
   header('Location: debugstart.php'); // DEBUG
   
   break;
  }
  default:{
   header('Location: error.php');
   break;
  }
 }

?>
