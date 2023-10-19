 <form name="form" method="post" action="trans.php">
  
  <!-- https://www.sejuku.net/blog/104657 -->
  <style>
 .cal_div {
    text-align: center;
    padding: 20px;
}
.show_pc{
 display: block;
}
.hide_pc{
 display: none;
}
.popup {
  height: 100vh;
  width: 100%;
  background: rgba(0,0,0,0.5);
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 100;
}
.popup strong{
    font-size: 2em;
    margin: 0 auto;
    display: block;
    width: 13em;
    max-width: 100%;
    line-height: 1.2em;
}
.popup strong span{
 display: inline-block;
}
.content {
  max-width: 500px;
  opacity: 1;
  color: #000;
  font-size: 14px;
  line-height: 20px;
  text-align: left;
  position: relative;
 background-color: #fff;
 padding: 20px;
}
.content h2{
 text-align: center;
 color: #DF5656;
 font-size: 23px;
 font-weight: bold;
}
.content .p1{
 text-align: center;
 margin: 10px auto;
 font-size: 16px;
}
.content .p2{
 text-align: center;
 color: #DF5656;
 font-size: 23px;
 margin: 20px auto;
 line-height: 30px;
}
.content .p3{
 font-size: 13px;
 margin-top: 15px;
}
.content #symbol_a{
 position: absolute;
 top: -30px;
 left: -30px;
}
.popup_back{
 width: 100%;
}
#popup_button{
    margin: 1em auto 0;
    width: 300px;
    max-width: 90%;
}
.popup_button_div{
 display: flex;
 justify-content: center;
}   
#popup_kakutei,
#popup_yes,
#popup_no{
    text-decoration: none;
    display: inline-block;
    text-align: center;
    cursor: pointer;
 border: 1px solid #F8B736;
 padding: 10px 15px;
 border-radius: 20px;
 width: 100px;
}
#popup_yes{
 margin-right: 20px;
}
#popup_kakutei img,
#popup_yes img,
#popup_no img{
 width: 100%;
}
#popup_no{
}
#popup_kakutei{
 display: block;
 margin: 15px auto 0px;
}
#popup_close{
    position: absolute;
    color: #000;
 font-size: 20px;
 top: 2.5%;
 right: 2.5%;
 width: 3.5%;
 height: 8%;
 cursor: pointer;
}
@media screen and (max-width: 960px) {
.show_sp{
 display: block;
}
.hide_sp{
 display: none !important;
}
 .content {
  max-width: 400px;
  width: 85%;
 }
 .popup strong{
    width: 8em;
    text-align: center;
 }
 #popup_button{
  max-width: 20em;
 }
 #popup_yes{
 }
 #popup_no{
 }
}
@media screen and (max-width: 400px) {
 #popup_yes{
 }
 #popup_no{
 }
 .popup strong{
  font-size: 1.7em;
 }
 #popup_button{
  width: 215px;
 }
 #popup_close{
  right: 6%;
 }
 .content{
  padding: 12px;
 }
 .content .p1{
  font-size: 12px;
 }
 .content .p2{
  font-size: 16px;
  line-height: 20px;
 }
 .content .p3{
  font-size: 10px;
  line-height: 12px;
 }
 .content #symbol_a{
  top: -20px;
  left: -20px;
  width: 44px;
 }
}
  </style>
  <script>
	$(function(){
$("#popup_no").on("click", function() {
  $('#cal_div').show();
  $("#popup_no").css("background-color", "#F18C17");
  $("#popup_no").css("color", "#fff");
  $("#popup_yes").css("background-color", "#fff");
  $("#popup_yes").css("color", "#000");
//  $("#kakunin_bank").hide();
  // return false;
});
$("#popup_yes").on("click", function() {
  $("#kakunin_bank").hide();
  $("#kakunin_bank_kouza").show();
  $("#popup_yes").css("background-color", "#fff");
  $("#popup_yes").css("color", "#000");
  $("#popup_no").css("background-color", "#fff");
  $("#popup_no").css("color", "#000");
  $("#kigen_info").show();
  
var d = new Date("2023-10-22");
var gd = d.getDay();
var dow = [ "日", "月", "火", "水", "木", "金", "土" ][gd] ;

var fd = `
${d.getFullYear()}年
${(d.getMonth()+1)}月
${d.getDate()}日
(${dow})
`.replace(/\n|\r/g, '');
var fd2 = `${d.getFullYear()}-${(d.getMonth()+1)}-${d.getDate()}`;
  /// => 2019-01-04
  $("#bank_kigen").text(fd);
  $('input[name="kigen"]').val(fd);
  $('input[name="kigen_date"]').val(fd2);
  // return false;
});
$("#popup_close").on("click", function() {
  $("#kakunin_bank").hide();
  $('.kakunin_box').hide();
  $("#kakunin_bank_kouza").hide();
  $("#popup_yes").css("background-color", "#fff");
  $("#popup_yes").css("color", "#000");
  $("#popup_no").css("background-color", "#fff");
  $("#popup_no").css("color", "#000");
  // return false;
});
$("#popup_kakutei").on("click", function() {
var d = new Date($("#shiharai_day").val());
var gd = d.getDay();
var dow = [ "日", "月", "火", "水", "木", "金", "土" ][gd] ;
 
 var min = new Date("2023-10-22");
 var max = new Date("2023-10-31");

 if(d < min || d > max){
  $('#kigen_err').show();
 } else {
  $("#kakunin_bank").hide();
  $("#kakunin_bank_kouza").show();
  $("#popup_yes").css("background-color", "#fff");
  $("#popup_yes").css("color", "#000");
  $("#popup_no").css("background-color", "#fff");
  $("#popup_no").css("color", "#000");
  $("#kigen_info").hide();
  $('#kigen_err').hide();
  
var fd = `
${d.getFullYear()}年
${(d.getMonth()+1)}月
${d.getDate()}日
(${dow})
`.replace(/\n|\r/g, '');
var fd2 = `${d.getFullYear()}-${(d.getMonth()+1)}-${d.getDate()}`;
  /// => 2019-01-04
  $("#bank_kigen").text(fd);
  $("#bank_kigen2").text(fd);
  $('input[name="kigen"]').val(fd);
  $('input[name="kigen_date"]').val(fd2);
  // return false;
 }
 
});
$('#kigen_err').hide();
});
  </script>
  <!-- https://www.sejuku.net/blog/104657 -->
   <div class="popup" id="kakunin_bank">
     <div class="content">
      <img src="../mypage/image/symbol_a.png" alt="" id="symbol_a">
      <h2>お振込みのご注意</h2>
      <p class="p1">振込手数料は、お客様負担となります。<br>
       お振込み期限は、本日から3日以内です。<br>
       <!--お振込み期限は、3月6日（月）です。<br>-->
昨年度は99%の方が期限内にお振込みいただいております。</p>
      <p class="p2">2023年10月22日(日)までに<br>
お振込みできますか？</p>
      <div class="popup_button_div">
      <a id="popup_yes">できる</a>
      <a id="popup_no">できない</a>
      <a id="popup_close">×</a>
      </div>
      <div id="cal_div" class="cal_div">
       <p>お支払い可能な期限を<br>2023-10-22～2023-10-31<br>の間で選択してください。</p>
       <input type="date" name="shiharai_day" id="shiharai_day" min="2023-10-22" max="2023-10-31" value="2023-10-22"><br>
       <a id="popup_kakutei">確定</a>
       <p id="kigen_err">2023-10-22～2023-10-31の間で指定してください。</p>
      </div>
      <p class="p3">※ 一度振込期限を過ぎますと新規申込みとなります。<br>
　<span style="color: red;">新規申込では、継続特別価格は適用されません。</span><br>
　お振込みできるタイミングで再度お手続きいただくか、<br>　別のお支払方法を選択してください。</p>
     </div>
    
   </div>
   
   <div id="kakunin_bank_kouza" class="shiharai_box_text">
    <p><span style="color: red;">お振込み期限は、<span id="bank_kigen"></span>　までです。</span></p>
    <p>お振込先は、継続申込み受付完了後ご登録のメールアドレスへメールいたします。</p><br>

    <p>振込期限までにお支払いがない場合は、お申込みはキャンセルとさせていただきます。<br>
    <span style="color: red;">一度、キャンセルになりますと次回からお申込みは受付できません。</span></p><br>

    <p>また、お客様のご都合による保険料等入金後の加入取り消しは一切行っておりません。</p>
  </div>
  
  <input type="hidden" name="pagename" value="kingaku">
  <input type="hidden" name="shiharai_type" value="銀行振込">

  <input type="hidden" name="nenko_data" value="<?php echo base64_encode($_SESSION['nenko_data']);?>">
  <input type="hidden" name="nenko_kanyusya_data" value="<?php echo base64_encode($_SESSION['nenko_kanyusya_data']);?>">

  <input type="submit" class="submit_button" name="submit_button" id="submit_button" value="次へすすむ">
 </form>
