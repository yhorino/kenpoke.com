<?php
 session_start();
 header("Content-type: text/html;charset=utf-8");

 include_once('./class.php');

/* 入口 *******************************************************/
 if(isset($_GET['type'])){

  if($_GET['type'] == 1){$type = DATATYPE_OYAKATADAIRI;}
  if($_GET['type'] == 2){$type = DATATYPE_OYAKATAKANYUSYA;}
  if($_GET['type'] == 11){$type = DATATYPE_JIMUKAISYA;}
  if($_GET['type'] == 12){$type = DATATYPE_JIMUKANYUSYA;}
  setcookie('type', $type);
  setcookie('errorlog', '');
  $nenko_data = new NenkoData($type, $_GET['no']);
  $ret = $nenko_data->getNenkoRecordData();
  if($ret == false){ setcookie('errorcode', 1);header('Location: error.php');exit;}
  $ret = $nenko_data->getNenkoKanyusyaRecordData();
  if($ret == false){ setcookie('errorcode', 2);header('Location: error.php');exit;}

  $_SESSION['nenko_data'] = serialize($nenko_data);

  header('Location: selkeizokusya.php');
  exit;

 }


/* 画面遷移 *******************************************************/

 $_nextpage = 'error.php';

 // 再POSTされたシリアライズ済みオブジェクトデータをセッション変数に入れなおす
 $_SESSION['nenko_data'] = base64_decode($_POST['nenko_data']);
 $nenko_data_unserialize = unserialize($_SESSION['nenko_data']);

 switch($_POST['pagename']){
  case 'selkeizokusya':
  {
   $nenko_data_unserialize = updateKeizokuState($nenko_data_unserialize, $_POST);
   $nenko_data_unserialize = updateDattaiRiyu($nenko_data_unserialize, $_POST);
   $nenko_data_unserialize = updateNichigakuSel($nenko_data_unserialize, $_POST);
   $nenko_data_unserialize = calcSougaku($nenko_data_unserialize, $_POST);
   
   if($nenko_data_unserialize->getKeizokusyaNum() <= 0){
    $_nextpage = 'done.php';
   } else {
    $_nextpage = 'kingaku.php';
   }
   break;
  }
  case 'kingaku':
  {
   $nenko_data_unserialize->setShiharaiType($_POST['shiharai_type']);
   if($nenko_data_unserialize->ShiharaiType() == SHIHARAI_TYPE_BANK){
    $nenko_data_unserialize->setShiharaiKigen($_POST['shiharai_day']);
   } else {
    $nenko_data_unserialize->setShiharaiKigen('');
   }
   
   //$_nextpage = 'done.php';
   $_nextpage = 'processing.php';
   break;
  }
  case 'done':
  {
   $returl = '';
   if($nenko_data_unserialize->isTypeOyakataDairi()){
    $returl = 'https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/mailform_new/dairi_mypage/top.php';
//    $returl = 'https://www.xn--u9j030g7pan0b35gwu1bj0pb79budya.tokyo/mailform_new/dairi_mypage/top.php';
   }
   if($nenko_data_unserialize->isTypeOyakataKanyusya()){
    $returl = 'https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/mailform_new/mypage/top.php';
//    $returl = 'https://www.xn--u9j030g7pan0b35gwu1bj0pb79budya.tokyo/mailform_new/mypage/top.php';
   }
   if($nenko_data_unserialize->isTypeJimukumiai()){
    $returl = 'https://www.xn--y5q0r2lqcz91qdrc.com/mypage/top.php';
   }
   
   $_nextpage = $returl;
   //$_nextpage = 'debugstart.php'; // DEBUG
   break;
  }
  default:{
   $_nextpage = 'error.php';
   break;
  }
 }

 $_SESSION['nenko_data'] = serialize($nenko_data_unserialize);

 header('Location: '.$_nextpage);
 exit;


/* 処理関数 *******************************************************/

function updateKeizokuState($nenkodata, $postdata){
 for($i=0;$i<$nenkodata->getKanyusyaNum();$i++){
  $nenkodata->getKanyusyaData($i)->setKeizoku($postdata['keizokusel_'.$i]);
 }
 return $nenkodata;
}

function updateDattaiRiyu($nenkodata, $postdata){
 for($i=0;$i<$nenkodata->getKanyusyaNum();$i++){
  $nenkodata->getKanyusyaData($i)->setDattaiRiyu('');
  if($nenkodata->getKanyusyaData($i)->isKeizoku() == true){ continue;}
  $items = $nenkodata->getKanyusyaData($i)->ItemDattaiRiyu();

  /*
  $_riyu_selected = array();
  for($j=0;$j<count($items);$j++){
   if($_POST['dattairiyu_'.$j] == $items[$j]) $_riyu_selected[] = $items[$j];
  }
  $_riyu = implode(';', $_riyu_selected);
  */
  $_riyu = $_POST['dattairiyu_'.$i];
  $nenkodata->getKanyusyaData($i)->setDattaiRiyu($_riyu);
 }
 return $nenkodata;
}

function updateNichigakuSel($nenkodata, $postdata){
 for($i=0;$i<$nenkodata->getKanyusyaNum();$i++){
  if($nenkodata->getKanyusyaData($i)->isKeizoku() != true){ continue;}

  $nenkodata->getKanyusyaData($i)->setNichigakuSel($postdata['sel_nichigaku'.$i]);
 }
 return $nenkodata;
}

function calcSougaku($nenkodata, $postdata){
 if($nenkodata->isTypeOyakata()){
  return calcSougaku_Oyakata($nenkodata, $postdata);
 }
 if($nenkodata->isTypeJimukumiai()){
  return calcSougaku_Jimukumiai($nenkodata, $postdata);
 }
}

function calcSougaku_Oyakata($nenkodata, $postdata){
 $_sougaku = 0;
 for($i=0;$i<$nenkodata->getKanyusyaNum();$i++){
  if($nenkodata->getKanyusyaData($i)->isKeizoku() != true){ continue;}

  $_sougaku += $nenkodata->getKanyusyaData($i)->getKingakuSel();
 }

 $nenkodata->setSougaku($_sougaku);
 
 return $nenkodata;
}

function calcSougaku_Jimukumiai($nenkodata, $postdata){
 $_sougaku = 0;
 $_santeikisogaku_goukei = 0;
 $_kaihi_goukei = 0;
 $_cardhakkou_goukei = 0;
 for($i=0;$i<$nenkodata->getKanyusyaNum();$i++){
  if($nenkodata->getKanyusyaData($i)->isKeizoku() != true){ continue;}

  $_santeikisogaku_goukei += $nenkodata->getKanyusyaData($i)->getSanteiKisogakuSel();
  $_kaihi_goukei += $nenkodata->getKanyusyaData($i)->Kaihi();
  $_cardhakkou_goukei += $nenkodata->getKanyusyaData($i)->CardHakkohiyo();
 }

 $_jimu_ryoritsu = $nenkodata->Ryoritsu();
 $_jimu_kaisya_kaihi = $nenkodata->Kaihi();
 
 $_jimu_kaihi = $_jimu_kaisya_kaihi + $_kaihi_goukei;
 $_jimu_hokenryo = floor(floor($_santeikisogaku_goukei/1000) * ($_jimu_ryoritsu*1000));
 $_koho_itakuhi = $nenkodata->KohoItakuhi();
 
 $_sougaku = $_jimu_hokenryo + $_jimu_kaihi + $_cardhakkou_goukei + $_koho_itakuhi;

 $nenkodata->setHokenryo($_jimu_hokenryo);
 $nenkodata->setSougaku($_sougaku);
 $nenkodata->setKaihiSougaku($_jimu_kaihi);
 $nenkodata->setCardSougaku($_cardhakkou_goukei);
 
 return $nenkodata;
}

?>
