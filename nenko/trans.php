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
   for($i=0;$i<$nenko_data_unserialize->getKanyusyaNum();$i++){
    $nenko_data_unserialize->updateKanyusyaKeizoku($i, $_POST['keizokusel_'.$i]);
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
