<?php
 include_once('../bin/sf_Api.php');
 define('SELECT_DAIRI','Id,dairikaishamei__c,kofurikaishu__c,KouzaJyouhou__c,dairinenkotaishoninzu__c,waribikigokaihi__c,dairikaishameifurigana__c,dairiyubimbango__c,dairitodofuken__c,dairishikugun__c,dairichomeibanchi__c,dairidaihyosha__c,dairidaihyoshafurigana__c,dairitantosha__c,dairitantoshafurigana__c,dairidenwabango__c,dairifuakkusubango__c,dairitantosharenrakusaki__c,dairimail__c');
 define('SELECT_KOJIN','Id,seirinumber__c,shimeisei__c,shimeimei__c,genzainonichigaku__c,kofurikaishu__c,KouzaJyouhou__c,SanteiKisogaku__c,SougakuKanyusya__c,SanteiKisogaku3500__c,SougakuKanyusya3500__c,SanteiKisogaku10000__c,SougakuKanyusya10000__c,ordernumber__c,waribikigokaihi__c,CardHakkohiyo__c,kanyubi__c');

 define('SELECT_JIMUKAISYA','Id,dairikaishamei__c,kofurikaishu__c,KouzaJyouhou__c,Ryoritsu__c,waribikigokaihi__c,CardHakkohiyo__c,dairinenkotaishoninzu__c,kohoitakuhi__c');
 define('SELECT_JIMUKANYUSYA','Id,seirinumber__c,shimeisei__c,shimeimei__c,genzainonichigaku__c,kofurikaishu__c,KouzaJyouhou__c,SanteiKisogaku__c,SougakuKanyusya__c,SanteiKisogaku3500__c,SougakuKanyusya3500__c,SanteiKisogaku10000__c,SougakuKanyusya10000__c,waribikigokaihi__c,CardHakkohiyo__c,ordernumber__c,dairikaisha__c,kanyubi__c');
 define('UPDATE_DAIRI','Id,dairihokenryooshiharaisogaku__c,dairinyukinshubetsu__c,trading_id__c,dairinyukikingaku__c,dairinyukinkakuninzumi__c,dairinyukinkigen__c,dairinenkotaishoninzu__c,shinchokujokyo__c,moshikomiuketsuke__c,dairikingakuannaisofuzumi__c,dairishinchokujokyo__c,dairimoshikomihoho__c');
 define('UPDATE_KOJIN','Id,nenkojinichigaku__c,shinchokujokyo__c,moshikomiuketsuke__c,trading_id__c,dairinyukikingaku__c,dairinyukinkakuninzumi__c,dairinyukinkigen__c,kingakuannaisofu__c');
 define('UPDATE_JIMUKAISYA','Id,dairihokenryooshiharaisogaku__c,dairinyukinshubetsu__c,trading_id__c,dairinyukikingaku__c,dairinyukinkakuninzumi__c,dairinyukinkigen__c,dairinenkotaishoninzu__c,shinchokujokyo__c,moshikomiuketsuke__c,hokenryo__c,dairishinchokujokyo__c,dairimoshikomihoho__c,jimukaisyapurasukanyusyagoukei__c,nenkoudairikaiinkadohakkouhiyou__c,tukikaihi__c');

 define('YEAR', '2023');
 define('NENDO', '2023年度確定2024年度概算');

 define('SHIHARAI_TYPE_CARD', 'クレジットカード');
 define('SHIHARAI_TYPE_BANK', '銀行振込');
 define('SHIHARAI_TYPE_FURIKAE', '口座振替');

 define('DATATYPE_OYAKATADAIRI', '一人親方代理');
 define('DATATYPE_OYAKATAKANYUSYA', '一人親方加入者');
 define('DATATYPE_JIMUKAISYA', '事務組合会社');
 define('DATATYPE_JIMUKANYUSYA', '事務組合加入者');

 define('SF_OBJECT', 'nendokoshin__c');

 define('STATE_MOUSHIKOMI', '申込み受付済み');
 define('STATE_NYUKINMACHI', '入金待ち');
 define('STATE_NYUKINZUMI', '入金済み');
 define('STATE_DATTAI', '脱退受付');

 define('MOUSHIKOMI_FROM', 'マイページ');

/**********************************************************************/
/* 代理・会社データ */
/**********************************************************************/
 class NenkoData{
  private $_Id;
  private $_Type;
  private $_RecordTypeId;
  private $_Nendo;
  private $_No;
  private $_Name;
  private $_Sougaku;
  private $_Furikae;
  private $_KozaJoho;
  private $_ShiharaiType;
  private $_ShiharaiKigen;
  private $_TradingId;
  private $_CustomerId;
  private $_Ryoritsu;
  private $_Kaihi;
  private $_KaihiSougaku;
  private $_CardSougaku;
  private $_Hokenryo;
  private $_Kana;
  private $_Address;
  private $_DaihyosyaName;
  private $_DaihyosyaKana;
  private $_TantosyaName;
  private $_TantosyaKana;
  private $_Phone;
  private $_Fax;
  private $_TantosyaPhone;
  private $_Email;
  private $_KohoItakuhi;
  
  private $_KanyusyaData = [];
  
  public function __construct($type, $No){
   $this->_Type = $type;
   $this->_No = $No;
   $this->_Name = '';
   $this->_TradingId = rand(0,99999999).$No;
   $this->_ShiharaiType = SHIHARAI_TYPE_CARD;
  }
  
  /* 参照関数 */
  public function No(){return $this->_No;}
  public function Name(){return $this->_Name;}
  public function Sougaku(){return $this->_Sougaku;}
  public function Type(){return $this->_Type;}
  public function KozaJoho(){return $this->_KozaJoho;}
  public function ShiharaiType(){return $this->_ShiharaiType;}
  public function ShiharaiKigen(){return $this->_ShiharaiKigen;}
  public function Ryoritsu(){return $this->_Ryoritsu;}
  public function Kaihi(){return $this->_Kaihi;}
  public function KaihiSougaku(){return $this->_KaihiSougaku;}
  public function CardSougaku(){return $this->_CardSougaku;}
  public function CustomerId(){return $this->_CustomerId;}
  public function TradingId(){return $this->_TradingId;}
  public function Hokenryo(){return $this->_Hokenryo;}
  public function Kana(){return $this->_Kana;}
  public function Address(){return $this->_Address;}
  public function DaihyosyaName(){return $this->_DaihyosyaName;}
  public function DaihyosyaKana(){return $this->_DaihyosyaKana;}
  public function TantosyaName(){return $this->_TantosyaName;}
  public function TantosyaKana(){return $this->_TantosyaKana;}
  public function Phone(){return $this->_Phone;}
  public function Fax(){return $this->_Fax;}
  public function TantosyaPhone(){return $this->_TantosyaPhone;}
  public function Email(){return $this->_Email;}
  public function KohoItakuhi(){return $this->_KohoItakuhi;}
  
  /* 更新関数 */
  public function setSougaku($val){
   $this->_Sougaku = intval($val);
  }
  public function setHokenryo($val){
   $this->_Hokenryo = intval($val);
  }
  public function setKaihiSougaku($val){
   $this->_KaihiSougaku = intval($val);
  }
  public function setCardSougaku($val){
   $this->_CardSougaku = intval($val);
  }
  public function setShiharaiType($val){
   if($val != SHIHARAI_TYPE_CARD && $val != SHIHARAI_TYPE_BANK && $val != SHIHARAI_TYPE_FURIKAE) return;
   $this->_ShiharaiType = $val;
   for($i=0;$i<$this->getKanyusyaNum();$i++){
    $this->getKanyusyaData($i)->setShiharaiType('');
    if($this->getKanyusyaData($i)->isKeizoku()){
     $this->getKanyusyaData($i)->setShiharaiType($val);
    }
   }
  }
  public function setShiharaiKigen($val){
   $_date = date('Y-m-d', strtotime($val));
   $this->_ShiharaiKigen = $_date;
   for($i=0;$i<$this->getKanyusyaNum();$i++){
    $this->getKanyusyaData($i)->setShiharaiKigen('');
    if($this->getKanyusyaData($i)->isKeizoku()){
     $this->getKanyusyaData($i)->setShiharaiKigen($_date);
    }
   }
  }
  
  /* 判定関数 */
  public function isTypeOyakata(){
   if($this->_Type == DATATYPE_OYAKATADAIRI || $this->_Type == DATATYPE_OYAKATAKANYUSYA){
    return true;
   } else {
    return false;
   }
  }
  public function isTypeOyakataDairi(){
   if($this->_Type == DATATYPE_OYAKATADAIRI){
    return true;
   } else {
    return false;
   }
  }
  public function isTypeOyakataKanyusya(){
   if($this->_Type == DATATYPE_OYAKATAKANYUSYA){
    return true;
   } else {
    return false;
   }
  }
  public function isTypeJimukumiai(){
   if($this->_Type == DATATYPE_JIMUKAISYA || $this->_Type == DATATYPE_JIMUKANYUSYA){
    return true;
   } else {
    return false;
   }
  }
  public function isFurikae(){
   if($this->_Furikae == 'true'){
    return true;
   } else {
    return false;
   }
  }
  

  public function getKanyusyaNum(){
   return count($this->_KanyusyaData);
  }
  public function getKanyusyaData($idx){
   return $this->_KanyusyaData[$idx];
  }
  public function getKeizokusyaNum(){
   $count = 0;
   for($i=0;$i<$this->getKanyusyaNum();$i++){
    if($this->getKanyusyaData($i)->isKeizoku()){
     $count++;
    }
   }
   return $count;
  }
  public function getKozaJohoMasked(){
   $_kj = $this->_KozaJoho;
   $_kj_mask = preg_replace('/番号：\K\b(\d{4})(\d+)\b/', '****$2', $_kj);
   return $_kj_mask;
  }
  
  /* SFから代理年更レコード取得 */  
  /* 個人のときは代理データにも個人データを入れる */
  public function getNenkoRecordData(){
   if($this->_Type == DATATYPE_OYAKATADAIRI){
    return $this->_getNenkoRecordData_oyakatadairi();
   }
   if($this->_Type == DATATYPE_OYAKATAKANYUSYA){
    return $this->_getNenkoRecordData_oyakatakanyusya();
   }
   if($this->_Type == DATATYPE_JIMUKAISYA){
    return $this->_getNenkoRecordData_jimukaisya();
   }
  }
  private function _getNenkoRecordData_oyakatadairi(){
   $_select = SELECT_DAIRI;
   $_from = SF_OBJECT;
   $_nendo = NENDO;
   $_where = "dairimadokuchikaishabango__c = '$this->_No' AND Nendo__c = '$_nendo' AND Type__c = '$this->_Type'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['dairikaishamei__c'];
   $this->_Furikae = $_row['kofurikaishu__c'];
   $this->_KozaJoho = $_row['KouzaJyouhou__c'];
   $this->_CustomerId = $_row['dairinenkotaishoninzu__c'];// 間違いではない
   if($this->_CustomerId == ''){$this->_CustomerId = $this->_TradingId;}
   
   $this->_Kana = $_row['dairikaishameifurigana__c'];
   $this->_Address = $_row['dairiyubimbango__c'].' '.$_row['dairitodofuken__c'].$_row['dairishikugun__c'].$_row['dairichomeibanchi__c'];
   $this->_DaihyosyaName = $_row['dairidaihyosha__c'];
   $this->_DaihyosyaKana = $_row['dairidaihyoshafurigana__c'];
   $this->_TantosyaName = $_row['dairitantosha__c'];
   $this->_TantosyaKana = $_row['dairitantoshafurigana__c'];
   $this->_Phone = $_row['dairidenwabango__c'];
   $this->_Fax = $_row['dairifuakkusubango__c'];
   $this->_TantosyaPhone = $_row['dairitantosharenrakusaki__c'];
   $this->_Email = $_row['dairimail__c'];
    
   return true;
  }
  private function _getNenkoRecordData_oyakatakanyusya(){
   $_select = SELECT_KOJIN;
   $_from = SF_OBJECT;
   $_nendo = NENDO;
   $_where = "seirinumber__c = '$this->_No' AND Nendo__c = '$_nendo' AND Type__c = '$this->_Type'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['shimeisei__c'].'　'.$_row['shimeimei__c'];
   $this->_Nichigaku = intval($_row['genzainonichigaku__c']);
   $this->_Kingaku = intval($_row['SougakuKanyusya__c']);
   $this->_Kingaku3500 = intval($_row['SougakuKanyusya3500__c']);
   $this->_Kingaku10000 = intval($_row['SougakuKanyusya10000__c']);
   $this->_SanteiKisogaku = intval($_row['SanteiKisogaku__c']);
   $this->_SanteiKisogaku3500 = intval($_row['SanteiKisogaku3500__c']);
   $this->_SanteiKisogaku10000 = intval($_row['SanteiKisogaku10000__c']);
   $this->_Furikae = $_row['kofurikaishu__c'];
   $this->_KozaJoho = $_row['KouzaJyouhou__c'];
   $this->_CustomerId = $_row['ordernumber__c'];
   if($this->_CustomerId == ''){$this->_CustomerId = $this->_TradingId;}
   
   return true;
  }
  private function _getNenkoRecordData_jimukaisya(){
   $_select = SELECT_JIMUKAISYA;
   $_from = SF_OBJECT;
   $_nendo = NENDO;
   $_where = "dairimadokuchikaishabango__c = '$this->_No' AND Nendo__c = '$_nendo' AND Type__c = '$this->_Type'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
  setcookie('errorlog', $_select.$_from.$_where);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['dairikaishamei__c'];
   $this->_Furikae = $_row['kofurikaishu__c'];
   $this->_KozaJoho = $_row['KouzaJyouhou__c'];
   $this->_Ryoritsu = $_row['Ryoritsu__c'];
   $this->_Kaihi = intval($_row['waribikigokaihi__c']);
   $this->_CustomerId = $_row['dairinenkotaishoninzu__c'];// 間違いではない
   if($this->_CustomerId == ''){$this->_CustomerId = $this->_TradingId;}
   $this->_KohoItakuhi = intval($_row['kohoitakuhi__c']);
   
   return true;
  }
  
  /* SFから代理に紐づく加入者年更レコード取得 */
  public function getNenkoKanyusyaRecordData(){
   if($this->_Type == DATATYPE_OYAKATADAIRI) {
    return $this->_getNenkoKanyusyaRecordData_oyakatadairi();
   }
   if($this->_Type == DATATYPE_OYAKATAKANYUSYA) {
    return $this->_getNenkoKanyusyaRecordData_oyakatakanyusya();
   }
   if($this->_Type == DATATYPE_JIMUKAISYA) {
    return $this->_getNenkoKanyusyaRecordData_jimukaisya();
   }
  }
  private function _getNenkoKanyusyaRecordData_oyakatadairi(){
   $_type = DATATYPE_OYAKATAKANYUSYA;
   $_select = SELECT_KOJIN;
   $_from = SF_OBJECT;
   $_nendo = NENDO;
   $_where = "dairikaisha__c = '$this->_Id' AND Nendo__c = '$_nendo' AND Type__c = '$_type'";
   $_orderby = " ORDER BY seirinumber__c ASC ";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   for($i=0;$i<count($_result);$i++){
    $_row = (array)$_result[$i]['fields'];
    $_nkd_record = new NenkoKanyusyaData($_type, $_row['seirinumber__c']);
    $_nkd_record->getNenkoRecordData();
    $_nkd_record->setTradingId($this->TradingId());
    $this->_KanyusyaData[] = $_nkd_record;
   }
   
   return true;
  }
  private function _getNenkoKanyusyaRecordData_oyakatakanyusya(){
   $_type = DATATYPE_OYAKATAKANYUSYA;
   $_nkd_record = new NenkoKanyusyaData($_type, $this->_No);
   $_nkd_record->getNenkoRecordData();
   $_nkd_record->setTradingId($this->TradingId());
   $this->_KanyusyaData[] = $_nkd_record;
   
   return true;
  }
  private function _getNenkoKanyusyaRecordData_jimukaisya(){
   $_type = DATATYPE_JIMUKANYUSYA;
   $_select = SELECT_JIMUKANYUSYA;
   $_from = SF_OBJECT;
   $_nendo = NENDO;
   $_where = "dairikaisha__c = '$this->_Id' AND Nendo__c = '$_nendo' AND Type__c = '$_type'";
   $_orderby = " ORDER BY seirinumber__c ASC ";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   for($i=0;$i<count($_result);$i++){
    $_row = (array)$_result[$i]['fields'];
    $_nkd_record = new NenkoKanyusyaData($_type, $_row['seirinumber__c']);
    $_nkd_record->setKaisyaId($this->_Id);
    $_nkd_record->getNenkoRecordData();
    $_nkd_record->setTradingId($this->TradingId());
    $this->_KanyusyaData[] = $_nkd_record;
   }
   
   return true;
  }
  
  /* 代理レコード更新 */
  /* 代理に紐づく加入者年更レコードも同時に更新 */
  public function updateNenkoRecordData(){
   if($this->_Type == DATATYPE_OYAKATADAIRI){
    return $this->_updateNenkoRecordData_oyakatadairi();
   }
   if($this->_Type == DATATYPE_OYAKATAKANYUSYA){
    return $this->_updateNenkoRecordData_oyakatakanyusya();
   }
   if($this->_Type == DATATYPE_JIMUKAISYA){
    return $this->_updateNenkoRecordData_jimukaisya();
   }
  }
  private function _updateNenkoRecordData_oyakatadairi(){
   $_select = UPDATE_DAIRI;
   $_from = SF_OBJECT;
   $_nendo = NENDO;
//   $_where = "dairimadokuchikaishabango__c = '$this->_No' AND Nendo__c = '$_nendo' AND Type__c = '$this->_Type'";
   $_where = "Id = '$this->_Id'";
   $_orderby = "";
   if($this->ShiharaiType()==''){
    $this->setShiharaiType(SHIHARAI_TYPE_CARD);
   }
   if($this->getKeizokusyaNum()>0){
    $_keizoku = STATE_MOUSHIKOMI;
    if($this->ShiharaiType() == SHIHARAI_TYPE_BANK){
     $_keizoku = STATE_NYUKINMACHI;
    }
    if($this->ShiharaiType() == SHIHARAI_TYPE_CARD){
     $_keizoku = STATE_NYUKINZUMI;
    }
    $updateitems=array(
     'dairishinchokujokyo__c'=>$_keizoku,
     'dairimoshikomihoho__c'=>MOUSHIKOMI_FROM,
     'dairihokenryooshiharaisogaku__c'=>$this->_Sougaku,
     'dairinyukinshubetsu__c'=>$this->ShiharaiType(),
     'dairinenkotaishoninzu__c'=>$this->CustomerId() // 間違いではない
    );
    if($this->ShiharaiType() == SHIHARAI_TYPE_BANK){
     $_kigen_datetime = $this->_ShiharaiKigen."T00:00:00+09:00";
     $updateitems=array_merge($updateitems, array('dairinyukinkigen__c'=>$_kigen_datetime));
     $updateitems=array_merge($updateitems, array('dairikingakuannaisofuzumi__c'=>true));
    }
    if($this->ShiharaiType() == SHIHARAI_TYPE_CARD){
     $updateitems=array_merge($updateitems, array('dairinyukikingaku__c'=>$this->_Sougaku));
     $updateitems=array_merge($updateitems, array('dairinyukinkakuninzumi__c'=>true));
     $updateitems=array_merge($updateitems, array('trading_id__c'=>$this->_TradingId));
    }
   } else {
    $_keizoku = STATE_DATTAI;
    $updateitems=array(
     'dairishinchokujokyo__c'=>$_keizoku,
     'dairimoshikomihoho__c'=>MOUSHIKOMI_FROM,
     'dattaiuketsuke__c'=>true
    );
   }
   sf_soql_update($_select, $_from, $_where, $_orderby, $updateitems);
   
   foreach($this->_KanyusyaData as $kd){
    $kd->updateNenkoRecordData();
   }
   
   return true;
  }
  private function _updateNenkoRecordData_oyakatakanyusya(){
   $this->_KanyusyaData[0]->updateNenkoRecordData();
   return true;
  }
  private function _updateNenkoRecordData_jimukaisya(){
   $_select = UPDATE_JIMUKAISYA;
   $_from = SF_OBJECT;
   $_nendo = NENDO;
//   $_where = "dairimadokuchikaishabango__c = '$this->_No' AND Nendo__c = '$_nendo' AND Type__c = '$this->_Type'";
   $_where = "Id = '$this->_Id'";
   $_orderby = "";
   if($this->getKeizokusyaNum()>0){
    $_keizoku = STATE_MOUSHIKOMI;
    $updateitems=array(
     'dairishinchokujokyo__c'=>$_keizoku,
     'dairimoshikomihoho__c'=>MOUSHIKOMI_FROM,
     'dairihokenryooshiharaisogaku__c'=>$this->_Sougaku,
     'hokenryo__c'=>$this->_Hokenryo,
     'jimukaisyapurasukanyusyagoukei__c'=>$this->_KaihiSougaku,
     'nenkoudairikaiinkadohakkouhiyou__c'=>$this->_CardSougaku,
     'dairinenkotaishoninzu__c'=>$this->CustomerId() // 間違いではない
    );
   } else {
    $_keizoku = STATE_DATTAI;
    $updateitems=array(
     'dairishinchokujokyo__c'=>$_keizoku,
     'dairimoshikomihoho__c'=>MOUSHIKOMI_FROM,
     'dattaiuketsuke__c'=>true
    );
   }
   if($this->ShiharaiType() == SHIHARAI_TYPE_BANK){
    $_kigen_datetime = $this->_ShiharaiKigen."T00:00:00+09:00";
    $updateitems=array_merge($updateitems, array('dairinyukinkigen__c'=>$_kigen_datetime));
    $updateitems=array_merge($updateitems, array('dairikingakuannaisofuzumi__c'=>true));
   }
   sf_soql_update($_select, $_from, $_where, $_orderby, $updateitems);
   
   foreach($this->_KanyusyaData as $kd){
    $kd->updateNenkoRecordData();
   }
   
   return true;
  }
  
 };



/**********************************************************************/
/* 加入者データ */
/**********************************************************************/
 class NenkoKanyusyaData{
  private $_Id;
  private $_Type;
  private $_RecordTypeId;
  private $_Nendo;
  private $_No;
  private $_Name;
  private $_Nichigaku;
  private $_NichigakuSel;
  private $_Kingaku;
  private $_Kingaku3500;
  private $_Kingaku10000;
  private $_SanteiKisogaku;
  private $_SanteiKisogaku3500;
  private $_SanteiKisogaku10000;
  private $_KozaJoho;
  private $_Kaihi;
  private $_ShiharaiType;
  private $_ShiharaiKigen;
  private $_TradingId;
  private $_CardHakkohiyo;
  private $_DattaiRiyu;
  private $_KaisyaId;
  private $_KanyuDate;

  private $_Keizoku;
  
  private $_ItemDattaiRiyu;
  
  public function __construct($type, $No){
   $this->_Type = $type;
   $this->_No = $No;
   $this->_Name = '';
   $this->_Keizoku = 'keizoku';
   $this->_TradingId = rand(0,99999999).$No;
   $this->_DattaiRiyu = '';
   $this->_ShiharaiType = SHIHARAI_TYPE_CARD;
   $this->_KaisyaId = '';
   // SFの「【年更】脱退理由」項目の選択肢に含まれているか確認すること
   if($this->_Type == DATATYPE_OYAKATAKANYUSYA){
    $this->_ItemDattaiRiyu = array('就職した','建設業をやめた','次の現場が決まってない','従業員を雇った','その他');
   }
   if($this->_Type == DATATYPE_JIMUKANYUSYA){
    $this->_ItemDattaiRiyu = array('就職した','建設業をやめた','次の現場が決まってない','従業員を雇った','その他');
   }
  }
  
  /* 参照関数 */
  public function No(){return $this->_No;}
  public function Name(){return $this->_Name;}
  public function Nichigaku(){return $this->_Nichigaku;}
  public function NichigakuSel(){return $this->_NichigakuSel;}
  public function Kingaku(){return $this->_Kingaku;}
  public function Kingaku3500(){return $this->_Kingaku3500;}
  public function Kingaku10000(){return $this->_Kingaku10000;}
  public function Keizoku(){return $this->_Keizoku;}
  public function KozaJoho(){return $this->_KozaJoho;}
  public function Kaihi(){return $this->_Kaihi;}
  public function CardHakkohiyo(){return $this->_CardHakkohiyo;}
  public function ShiharaiType(){return $this->_ShiharaiType;}
  public function TradingId(){return $this->_TradingId;}
  public function ItemDattaiRiyu(){return $this->_ItemDattaiRiyu;}
  public function KaisyaId(){return $this->_KaisyaId;}

  /* 更新関数 */
  public function setKeizoku($val){
   if($val == 'keizoku'){
    $this->_Keizoku = 'keizoku';
    return;
   }
   if($val == 'dattai'){
    $this->_Keizoku = 'dattai';
    return;
   }
  }
  public function setNichigakuSel($val){
   $this->_NichigakuSel = $val;
  }
  public function setShiharaiType($val){
   if($val != SHIHARAI_TYPE_CARD && $val != SHIHARAI_TYPE_BANK && $val != SHIHARAI_TYPE_FURIKAE) return;
   $this->_ShiharaiType = $val;
  }
  public function setShiharaiKigen($val){
   $_date = date('Y-m-d', strtotime($val));
   $this->_ShiharaiKigen = $_date;
  }
  public function setDattaiRiyu($val){
   $this->_DattaiRiyu = $val;
  }
  public function setTradingId($val){
   $this->_TradingId = $val;
  }
  public function setKaisyaId($val){
   $this->_KaisyaId = $val;
  }
  
  /* 判定関数 */
  public function isKeizoku(){
   if($this->_Keizoku == 'keizoku'){
    return true;
   }
   return false;
  }
  public function isKanyuThisYear(){
   $_kanyudate = explode('-', $this->_KanyuDate);
   $_kanyudate_year = intval($_kanyudate[0]);
   if($_kanyudate_year == intval(YEAR)) return true;
   else return false;
  }
  
  public function getKingakuSel(){
   $_kingakusel = $this->_Kingaku;
   if(intval($this->_NichigakuSel) == 3500) {
    $_kingakusel = $this->_Kingaku3500;
   }
   if(intval($this->_NichigakuSel) == 10000) {
    $_kingakusel = $this->_Kingaku10000;
   }
   return $_kingakusel;
  }
  public function getSanteiKisogakuSel(){
   $_santeikisogakusel = $this->_SanteiKisogaku;
   if(intval($this->_NichigakuSel) == 3500) {
    $_santeikisogakusel = $this->_SanteiKisogaku3500;
   }
   if(intval($this->_NichigakuSel) == 10000) {
    $_santeikisogakusel = $this->_SanteiKisogaku10000;
   }
   return $_santeikisogakusel;
  }
  public function getHokenryo(){
   return intval($this->getKingakuSel()) - intval($this->_Kaihi) - intval($this->_CardHakkohiyo);
  }
  
  
  /* SFから加入者年更レコード取得 */  
  public function getNenkoRecordData(){
   if($this->_Type == DATATYPE_OYAKATAKANYUSYA){
    $_select = SELECT_KOJIN;
    $_kaisyaid = '';
   }
   if($this->_Type == DATATYPE_JIMUKANYUSYA){
    $_select = SELECT_JIMUKANYUSYA;
    $_kaisyaid = ' AND dairikaisha__c = \''.$this->KaisyaId().'\' ';
   }
   $_from = SF_OBJECT;
   $_nendo = NENDO;
   $_where = "seirinumber__c = '$this->_No' AND Nendo__c = '$_nendo' AND Type__c = '$this->_Type'".$_kaisyaid;
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['shimeisei__c'].'　'.$_row['shimeimei__c'];
   $this->_Nichigaku = intval($_row['genzainonichigaku__c']);
   $this->_Kingaku = intval($_row['SougakuKanyusya__c']);
   $this->_Kingaku3500 = intval($_row['SougakuKanyusya3500__c']);
   $this->_Kingaku10000 = intval($_row['SougakuKanyusya10000__c']);
   $this->_SanteiKisogaku = intval($_row['SanteiKisogaku__c']);
   $this->_SanteiKisogaku3500 = intval($_row['SanteiKisogaku3500__c']);
   $this->_SanteiKisogaku10000 = intval($_row['SanteiKisogaku10000__c']);
   $this->_Furikae = $_row['kofurikaishu__c'];
   $this->_KozaJoho = $_row['KouzaJyouhou__c'];
   $this->_Kaihi = intval($_row['waribikigokaihi__c']);
   $this->_CardHakkohiyo = intval($_row['CardHakkohiyo__c']);
   $this->_KanyuDate = $_row['kanyubi__c'];
   
   return true;
  }
  public function updateNenkoRecordData(){
   $_select = UPDATE_KOJIN;
   $_from = SF_OBJECT;
   $_nendo = NENDO;
//   $_where = "seirinumber__c = '$this->_No' AND Nendo__c = '$_nendo' AND Type__c = '$this->_Type'";
   $_where = "Id = '$this->_Id'";
   $_orderby = "";
   
   if($this->isKeizoku()){
    if($this->ShiharaiType()==''){
     $this->setShiharaiType(SHIHARAI_TYPE_CARD);
    }
    $_keizoku = STATE_MOUSHIKOMI;
    if($this->ShiharaiType() == SHIHARAI_TYPE_BANK){
     $_keizoku = STATE_NYUKINMACHI;
    }
    if($this->ShiharaiType() == SHIHARAI_TYPE_CARD){
     $_keizoku = STATE_NYUKINZUMI;
    }
    $updateitems=array(
     'shinchokujokyo__c'=>$_keizoku,
     'moshikomiuketsuke__c'=>MOUSHIKOMI_FROM,
     'nenkojinichigaku__c'=>$this->NichigakuSel(),
     'nyukinshubetsu__c'=>$this->ShiharaiType()
    );
    if($this->ShiharaiType() == SHIHARAI_TYPE_BANK){
     $_kigen_datetime = $this->_ShiharaiKigen."T00:00:00+09:00";
     $updateitems=array_merge($updateitems, array('nyukinkigen__c'=>$_kigen_datetime));
     $updateitems=array_merge($updateitems, array('kingakuannaisofu__c'=>true));
    }
    if($this->ShiharaiType() == SHIHARAI_TYPE_CARD){
     $updateitems=array_merge($updateitems, array('nyukinkingaku__c'=>$this->getKingakuSel()));
     $updateitems=array_merge($updateitems, array('nyukinkakuninzumi__c'=>true));
     $updateitems=array_merge($updateitems, array('trading_id__c'=>$this->_TradingId));
    }
   } else {
    $updateitems=array(
     'shinchokujokyo__c'=>STATE_DATTAI,
     'moshikomiuketsuke__c'=>MOUSHIKOMI_FROM,
     'dattairiyu__c'=>$this->_DattaiRiyu,
     'dattaiuketsuke__c'=>true
    );
   }
   
   sf_soql_update($_select, $_from, $_where, $_orderby, $updateitems);
   
   return true;
  }
  
 };


?>
