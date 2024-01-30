<?php
 session_start();
 header("Content-type: text/html;charset=utf-8");
 include_once('./class.php');

 $nenko_data_unserialize = unserialize($_SESSION['nenko_data']);
 include('./session_check.php');

?>

<!doctype html>
<html>
<head>
<?php include_once('./gtm_head.php'); ?>
<?php 
 $title = '更新処理中　｜　年度更新手続';
 $description = '';
 include_once('./head_settings.php');
 ?>
 
</head>

<body>
 <div class="hide_on_print">
<?php include_once('./gtm_body.php'); ?>
<?php include_once('./body_settings.php'); ?>
<?php
 $flow_class1 = '';
 $flow_class2 = 'flow_active';
 $flow_class3 = '';
 include_once('./header.php'); 
 ?>

 <style>
/* CSS */

@keyframes dotAnimation {
    0%, 20% {
        content: '処理中です．　　';
    }
    40%, 60% {
        content: '処理中です．．　';
    }
    80%, 100% {
        content: '処理中です．．．';
    }
}

.processing_message::before {
    content: '処理中です．';
    animation: dotAnimation 1.5s infinite;
    display: inline-block;
}
 </style>
 <div class="outer_box inner">
  <p class="processing_message"></p>
 </div>
  
 
<?php include_once('./footer.php'); ?>
 </div>
 
<script>
window.onload = function() {
    window.location.href = 'done.php';
};
</script>
 
</body>
</html>
