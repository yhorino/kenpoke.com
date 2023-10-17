<?php
 session_start();

 include_once('./class.php');

 if(isset($_GET['debugstart']) && $_GET['debugstart'] == 1){
  $nenko_data = new NenkoData("999988");
  $nenko_kanyusya_data = new NenkoKanyusyaData("00000003");

  $nenko_kanyusya_data->getNenkoRecordData();
  $nenko_data->getNenkoRecordData();

  $_SESSION['nenko_data'] = serialize($nenko_data);
  $_SESSION['nenko_kanyusya_data'] = serialize($nenko_kanyusya_data);

  header('Location: selkeizokusya.php');
 //var_dump($nenko_data);
 //var_dump($nenko_kanyusya_data);
  exit;
 }

 switch($_POST['pagename']){
  case 'selkeizokusya':
  {
   break;
  }
  case 'kingaku':
  {
   break;
  }
  case 'done':
  {
   break;
  }
 }

?>
