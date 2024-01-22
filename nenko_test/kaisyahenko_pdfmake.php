<script src='../pdfmake/pdfmake.min.js'></script>
<script src='../pdfmake/vfs_fonts.js'></script>
<script src="../js/jquery-1.9.1.min.js"></script>

<script>

function zth(text){
  var txt = String(text);
  var str = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
		return String.fromCharCode(s.charCodeAt(0) - 65248);
 });
 str = str.replace(/　/g,' ');
 str = str.replace(/－/g,'-');
 str = str.replace(/―/g,'-');
 str = str.replace(/—/g,'-');
 str = str.replace(/‐/g,'-');
 return str;
}
 
function outputPDF(){
 
  // ここでフォントを指定
  pdfMake.fonts = {
      GenShin: {
        normal: 'GenShinGothic-Normal-Sub.ttf',
        bold: 'GenShinGothic-Normal-Sub.ttf',
        italics: 'GenShinGothic-Normal-Sub.ttf',
        bolditalics: 'GenShinGothic-Normal-Sub.ttf'
      }
    }
 
 var kaisya_no = "<?php echo $nenko_data_unserialize->No();?>";
 var kaisya_name = "<?php echo $nenko_data_unserialize->Name();?>";
 var kaisya_kana = "<?php echo $nenko_data_unserialize->Kana();?>";
 var kaisya_address = "<?php echo $nenko_data_unserialize->Address();?>";
 var kaisya_daihyosya_name = "<?php echo $nenko_data_unserialize->DaihyosyaName();?>";
 var kaisya_daihyosya_kana = "<?php echo $nenko_data_unserialize->DaihyosyaKana();?>";
 var kaisya_tantosya_name = "<?php echo $nenko_data_unserialize->TantosyaName();?>";
 var kaisya_tantosya_kana = "<?php echo $nenko_data_unserialize->TantosyaKana();?>";
 var kaisya_phone = "<?php echo $nenko_data_unserialize->Phone();?>";
 var kaisya_fax = "<?php echo $nenko_data_unserialize->Fax();?>";
 var kaisya_tantosya_phone = "<?php echo $nenko_data_unserialize->TantosyaPhone();?>";
 var kaisya_email = "<?php echo $nenko_data_unserialize->Email();?>";
 
 var kaisya_no_name = kaisya_no + " " + kaisya_name;
 
 var doc_content = new Array();

  /* 注：全角数字、記号等は文字化けする？フォントの問題？ */
  
 doc_content.push({image: '<?php include 'kaisyahenko_pdfmake_bg1.php'; ?>', absolutePosition:{x:0,y:0}, width: 595});

 doc_content.push(
  /*
     {
      text: '100', absolutePosition:{x:0,y:100}, fontSize: 8
     },
     {
      text: '200', absolutePosition:{x:0,y:200}, fontSize: 8
     },
     {
      text: '300', absolutePosition:{x:0,y:300}, fontSize: 8
     },
     {
      text: '400', absolutePosition:{x:0,y:400}, fontSize: 8
     },
     {
      text: '500', absolutePosition:{x:0,y:500}, fontSize: 8
     },
     {
      text: '600', absolutePosition:{x:0,y:600}, fontSize: 8
     },
     {
      text: '700', absolutePosition:{x:0,y:700}, fontSize: 8
     },
     {
      text: '800', absolutePosition:{x:0,y:800}, fontSize: 8
     },
     {
      text: '100', absolutePosition:{x:100,y:0}, fontSize: 8
     },
     {
      text: '200', absolutePosition:{x:200,y:0}, fontSize: 8
     },
     {
      text: '300', absolutePosition:{x:300,y:0}, fontSize: 8
     },
     {
      text: '400', absolutePosition:{x:400,y:0}, fontSize: 8
     },
     {
      text: '500', absolutePosition:{x:500,y:0}, fontSize: 8
     },
     */
     {
      text: zth(kaisya_no), absolutePosition:{x:135,y:150}, fontSize: 10
     },
     {
      text: zth(kaisya_kana), absolutePosition:{x:135,y:175}, fontSize: 8
     },
     {
      text: zth(kaisya_name), absolutePosition:{x:135,y:195}, fontSize: 10
     },
     {
      text: zth(kaisya_address), absolutePosition:{x:135,y:225}, fontSize: 10
     },
     {
      text: zth(kaisya_daihyosya_kana), absolutePosition:{x:135,y:248}, fontSize: 8
     },
     {
      text: zth(kaisya_daihyosya_name), absolutePosition:{x:135,y:270}, fontSize: 10
     },
     {
      text: zth(kaisya_tantosya_kana), absolutePosition:{x:380,y:248}, fontSize: 8
     },
     {
      text: zth(kaisya_tantosya_name), absolutePosition:{x:380,y:270}, fontSize: 10
     },
     {
      text: zth(kaisya_phone), absolutePosition:{x:135,y:298}, fontSize: 10
     },
     {
      text: zth(kaisya_tantosya_phone), absolutePosition:{x:380,y:298}, fontSize: 10
     },
     {
      text: zth(kaisya_fax), absolutePosition:{x:135,y:329}, fontSize: 10
     },
     {
      text: zth(kaisya_email), absolutePosition:{x:380,y:329}, fontSize: 8
     },

 );
 
 doc_content.push({text: '', pageBreak: 'before'});
 doc_content.push({image: '<?php include 'kaisyahenko_pdfmake_bg2.php'; ?>', absolutePosition:{x:0,y:0}, width: 595});
 
 doc_content.push(
  /*
     {
      text: '100', absolutePosition:{x:0,y:100}, fontSize: 8
     },
     {
      text: '200', absolutePosition:{x:0,y:200}, fontSize: 8
     },
     {
      text: '300', absolutePosition:{x:0,y:300}, fontSize: 8
     },
     {
      text: '400', absolutePosition:{x:0,y:400}, fontSize: 8
     },
     {
      text: '500', absolutePosition:{x:0,y:500}, fontSize: 8
     },
     {
      text: '600', absolutePosition:{x:0,y:600}, fontSize: 8
     },
     {
      text: '700', absolutePosition:{x:0,y:700}, fontSize: 8
     },
     {
      text: '800', absolutePosition:{x:0,y:800}, fontSize: 8
     },
     {
      text: '100', absolutePosition:{x:100,y:0}, fontSize: 8
     },
     {
      text: '200', absolutePosition:{x:200,y:0}, fontSize: 8
     },
     {
      text: '300', absolutePosition:{x:300,y:0}, fontSize: 8
     },
     {
      text: '400', absolutePosition:{x:400,y:0}, fontSize: 8
     },
     {
      text: '500', absolutePosition:{x:500,y:0}, fontSize: 8
     },
     */
     {
      text: zth(kaisya_no_name), absolutePosition:{x:52,y:140}, fontSize: 10
     },

 );
 
 var docDefinition = {
    pageSize: 'A4',
    pageMargins: [0, 0, 0, 0],
    content: doc_content,
    defaultStyle:{
      font: 'GenShin'//ここでデフォルトのスタイル名を指定しています。
    },
    background: [ // https://hamayapp.appspot.com/static/data_uri_conv.html
        {
            image: '<?php include 'kaisyahenko_pdfmake_bg2.php'; ?>', width: 595
        }
    ]
};
 
  pdfMake.createPdf(docDefinition).open();
 
}
</script> 
