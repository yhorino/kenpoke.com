<?php
if($nenko_data_unserialize->isTypeJimukumiai() == true){
 $logo_img = 'https://www.xn--y5q0r2lqcz91qdrc.com/wp-content/uploads/2023/05/logo_jimukumiai.png';
} else {
 $logo_img = 'https://www.xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo/logo_img/logo_hitorioyakata.png'; 
}
?>
<link rel="stylesheet" href="header.css">
<header>
 <div class="header_logobox">
  <div class="inner">
   <div class="header_logoimgbox">
    <img src="<?php echo $logo_img; ?>" alt="">
   </div>
  </div>
 </div>
 <div class="header_menubox">
  <div class="inner">
   <span class="header_menubox_name"><?php echo $nenko_data_unserialize->Name();?> 様</span>
  </div>
 </div>
</header>

<div class="flow_path">
 <div class="inner">
  <span class="flow_item <?php echo $flow_class1;?>">継続対象者選択</span>
  <span class="flow_item <?php echo $flow_class2;?>">支払金額選択</span>
  <span class="flow_item <?php echo $flow_class3;?>">継続手続完了</span>
 </div>
</div>
