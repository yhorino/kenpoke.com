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
