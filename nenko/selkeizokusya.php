<?php
 session_start();
 include_once('./class.php');

  $nenko_data = unserialize($_SESSION['nenko_data']);
  $nenko_kanyusya_data = unserialize($_SESSION['nenko_kanyusya_data']);

 //var_dump($nenko_data);
 //var_dump($nenko_kanyusya_data);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無題ドキュメント</title>
</head>

<body>
 <p>NenkoData Name:<?php echo $nenko_data->Name();?></p>
 <p>NenkoKanyusyaData Name:<?php echo $nenko_kanyusya_data->Name();?></p>
 <p></p>
</body>
</html>
