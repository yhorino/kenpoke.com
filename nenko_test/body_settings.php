<meta charset="utf-8">
<meta name="viewport" content="width=device-width">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<!--<script src="../js/jquery.cookie.js" type="text/javascript"></script>-->

<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">-->
<script src="https://kit.fontawesome.com/a366e23f99.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="normalize.css">
<?php
 $_css = '';
 if(isset($_COOKIE['type'])){
  if($_COOKIE['type'] == DATATYPE_OYAKATADAIRI || $_COOKIE['type'] == DATATYPE_OYAKATAKANYUSYA){
   $_css = 'colortable_oyakata.css';
  }
  if($_COOKIE['type'] == DATATYPE_JIMUKAISYA || $_COOKIE['type'] == DATATYPE_JIMUKANYUSYA){
   $_css = 'colortable_jimukumiai.css';
  }
 }
?>
<link rel="stylesheet" href="<?php echo $_css;?>">
<link rel="stylesheet" href="style.css">

