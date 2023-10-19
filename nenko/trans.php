<?php
 session_start();
 header("Content-type: text/html;charset=utf-8");

 include_once('./class.php');

 /* DEBUG */
 if(isset($_GET['debugstart']) && $_GET['debugstart'] == 1){
  $nenko_data = new NenkoData("999888");
  $nenko_data->getNenkoRecordData();
  
  $nenko_kanyusya_data[] = new NenkoKanyusyaData("00000031");
  $nenko_kanyusya_data[] = new NenkoKanyusyaData("00000032");
  $nenko_kanyusya_data[0]->getNenkoRecordData();
  $nenko_kanyusya_data[1]->getNenkoRecordData();
  $nenko_data->addKanyusyaArray($nenko_kanyusya_data);

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
   for($i=0;$i<$nenko_data_unserialize->getKanyusyaNum();$i++){
    $nenko_data_unserialize->updateKanyusyaKeizoku($i, $_POST['keizokusel_'.$i]);
   }
   $_SESSION['nenko_data'] = serialize($nenko_data_unserialize);
   
   header('Location: kingaku.php');
   break;
  }
  case 'kingaku':
  {
   
   header('Location: done.php');
   break;
  }
  case 'done':
  {
   
   header('Location: trans.php?debugstart=1');
   break;
  }
 }

?>
