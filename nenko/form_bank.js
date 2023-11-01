	$(function(){
 const now = new Date();
 const kigen = new Date(now.getTime() + (3 * 24 * 60 * 60 * 1000));
 const kigen_max = new Date(now.getTime() + (10 * 24 * 60 * 60 * 1000));
  
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
  
var d = new Date(kigen);
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
 
 var min = new Date(kigen);
 var max = new Date(kigen_max);

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
