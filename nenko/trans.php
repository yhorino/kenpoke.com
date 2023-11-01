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
  $nenko_data = new NenkoData($type, $_GET['no']);
  $ret = $nenko_data->getNenkoRecordData();
  if($ret == false){header('Location: error.php');exit;}
  $ret = $nenko_data->getNenkoKanyusyaRecordData();
  if($ret == false){header('Location: error.php');exit;}

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
   
   $_nextpage = 'done.php';
   break;
  }
  case 'done':
  {
   $returl = '';
   if($nenko_data_unserialize->isTypeOyakata()){
    $returl = 'https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/';
   }
   if($nenko_data_unserialize->isTypeJimukumiai()){
    $returl = 'https://www.xn--y5q0r2lqcz91qdrc.com/';
   }
   
   //$_nextpage = $returl;
   $_nextpage = 'debugstart.php'; // DEBUG
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
  if($nenkodata->getKanyusyaData($i)->isKeizoku() == true){ continue;}

  $_riyu_selected = array();
  if($_POST['dattairiyu_1'] == DATTAIRIYU_1) $_riyu_selected[] = DATTAIRIYU_1;
  if($_POST['dattairiyu_2'] == DATTAIRIYU_2) $_riyu_selected[] = DATTAIRIYU_2;
  if($_POST['dattairiyu_3'] == DATTAIRIYU_3) $_riyu_selected[] = DATTAIRIYU_3;
  if($_POST['dattairiyu_4'] == DATTAIRIYU_4) $_riyu_selected[] = DATTAIRIYU_4;
  if($_POST['dattairiyu_5'] == DATTAIRIYU_5) $_riyu_selected[] = DATTAIRIYU_5;
  if($_POST['dattairiyu_6'] == DATTAIRIYU_6) $_riyu_selected[] = DATTAIRIYU_6;
  $_riyu = implode(';', $_riyu_selected);
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
 $_jimu_hokenryo = floor($_santeikisogaku_goukei * $_jimu_ryoritsu);
 
 $_sougaku = $_jimu_hokenryo + $_jimu_kaihi + $_cardhakkou_goukei;

 $nenkodata->setHokenryo($_jimu_hokenryo);
 $nenkodata->setSougaku($_sougaku);
 
 return $nenkodata;
}

?>
