<?php
 include_once('../bin/sf_Api.php');
 define('SELECT_DAIRI','Id,dairikaishamei__c,kofurikaishu__c,KouzaJyouhou__c,dairinenkotaishoninzu__c,waribikigokaihi__c');
 define('SELECT_KOJIN','Id,seirinumber__c,shimeisei__c,shimeimei__c,genzainonichigaku__c,kofurikaishu__c,KouzaJyouhou__c,SanteiKisogaku__c,HokenryoKanyusya__c,SougakuKanyusya__c,SanteiKisogaku3500__c,HokenryoKanyusya3500__c,SougakuKanyusya3500__c,SanteiKisogaku10000__c,HokenryoKanyusya10000__c,SougakuKanyusya10000__c,ordernumber__c,waribikigokaihi__c');

 define('SELECT_JIMUKAISYA','Id,dairikaishamei__c,kofurikaishu__c,KouzaJyouhou__c,Ryoritsu__c,waribikigokaihi__c,CardHakkohiyo__c,dairinenkotaishoninzu__c');
 define('SELECT_JIMUKANYUSYA','Id,seirinumber__c,shimeisei__c,shimeimei__c,genzainonichigaku__c,kofurikaishu__c,KouzaJyouhou__c,SanteiKisogaku__c,HokenryoKanyusya__c,SougakuKanyusya__c,SanteiKisogaku3500__c,HokenryoKanyusya3500__c,SougakuKanyusya3500__c,SanteiKisogaku10000__c,HokenryoKanyusya10000__c,SougakuKanyusya10000__c,waribikigokaihi__c,CardHakkohiyo__c,ordernumber__c');
 define('UPDATE_DAIRI','Id,dairihokenryooshiharaisogaku__c,dairinyukinshubetsu__c,trading_id__c,dairinyukikingaku__c,dairinyukinkakuninzumi__c,dairinyukinkigen__c,dairinenkotaishoninzu__c,shinchokujokyo__c,moshikomiuketsuke__c');
 define('UPDATE_KOJIN','Id,nenkojinichigaku__c,shinchokujokyo__c,moshikomiuketsuke__c,trading_id__c,dairinyukikingaku__c,dairinyukinkakuninzumi__c,dairinyukinkigen__c');
 define('UPDATE_JIMUKAISYA','Id,dairihokenryooshiharaisogaku__c,dairinyukinshubetsu__c,trading_id__c,dairinyukikingaku__c,dairinyukinkakuninzumi__c,dairinyukinkigen__c,dairinenkotaishoninzu__c,shinchokujokyo__c,moshikomiuketsuke__c');

 define('NENDO', '2024');

 define('SHIHARAI_TYPE_CARD', 'クレジットカード');
 define('SHIHARAI_TYPE_BANK', '銀行振込');
 define('SHIHARAI_TYPE_FURIKAE', '口座振替');

 define('DATATYPE_OYAKATADAIRI', '一人親方代理');
 define('DATATYPE_OYAKATAKANYUSYA', '一人親方加入者');
 define('DATATYPE_JIMUKAISYA', '事務組合会社');
 define('DATATYPE_JIMUKANYUSYA', '事務組合加入者');

 define('SF_OBJECT', 'nendokoshin__c');

 define('STATE_MOUSHIKOMI', '申込み受付済み');
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
  
  private $_KanyusyaData = [];
  
  public function __construct($type, $No){
   $this->_Type = $type;
   $this->_No = $No;
   $this->_Name = '';
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
  public function CustomerId(){return $this->_CustomerId;}
  
  /* 更新関数 */
  public function setKanyusyaKeizoku($idx, $val){
   $this->_KanyusyaData[$idx]->setKeizoku($val);
  }
  public function setKanyusyaNichigakuSel($idx, $val){
   $this->_KanyusyaData[$idx]->setNichigakuSel($val);
  }
  public function setKanyusyaKingakuSel($idx, $val){
   $this->_KanyusyaData[$idx]->setKingakuSel($val);
  }
  public function setSanteiKisogakuSel($idx, $val){
   $this->_KanyusyaData[$idx]->setSanteiKisogakuSel($val);
  }
  public function setSougaku($val){
   $this->_Sougaku = intval($val);
  }
  public function setShiharaiType($val){
   if($val != SHIHARAI_TYPE_CARD && $val != SHIHARAI_TYPE_BANK && $val != SHIHARAI_TYPE_FURIKAE) return;
   $this->_ShiharaiType = $val;
   for($i=0;$i<$this->getKanyusyaNum();$i++){
    if($this->getKanyusyaData($i)->isKeizoku()){
     $this->getKanyusyaData($i)->setShiharaiType($val);
    }
   }
  }
  public function setShiharaiKigen($val){
   $_date = date('Y-m-d', strtotime($val));
   $this->_ShiharaiKigen = $_date;
   for($i=0;$i<$this->getKanyusyaNum();$i++){
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
   
   return true;
  }
  private function _getNenkoRecordData_jimukaisya(){
   $_select = SELECT_JIMUKAISYA;
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
   $this->_Ryoritsu = $_row['Ryoritsu__c'];
   $this->_Kaihi = intval($_row['waribikigokaihi__c']);
   $this->_CustomerId = $_row['dairinenkotaishoninzu__c'];// 間違いではない
   
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
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   for($i=0;$i<count($_result);$i++){
    $_row = (array)$_result[$i]['fields'];
    $_nkd_record = new NenkoKanyusyaData($_type, $_row['seirinumber__c']);
    $_nkd_record->getNenkoRecordData();
    $this->_KanyusyaData[] = $_nkd_record;
   }
   
   return true;
  }
  private function _getNenkoKanyusyaRecordData_oyakatakanyusya(){
   $_type = DATATYPE_OYAKATAKANYUSYA;
   $_nkd_record = new NenkoKanyusyaData($_type, $this->_No);
   $_nkd_record->getNenkoRecordData();
   $this->_KanyusyaData[] = $_nkd_record;
   
   return true;
  }
  private function _getNenkoKanyusyaRecordData_jimukaisya(){
   $_type = DATATYPE_JIMUKANYUSYA;
   $_select = SELECT_JIMUKANYUSYA;
   $_from = SF_OBJECT;
   $_nendo = NENDO;
   $_where = "dairikaisha__c = '$this->_Id' AND Nendo__c = '$_nendo' AND Type__c = '$_type'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   for($i=0;$i<count($_result);$i++){
    $_row = (array)$_result[$i]['fields'];
    $_nkd_record = new NenkoKanyusyaData($_type, $_row['seirinumber__c']);
    $_nkd_record->getNenkoRecordData();
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
   $_where = "dairimadokuchikaishabango__c = '$this->_No' AND Nendo__c = '$_nendo' AND Type__c = '$this->_Type'";
   $_orderby = "";
   if($this->ShiharaiType()==''){
    $this->setShiharaiType(SHIHARAI_TYPE_CARD);
   }
   $updateitems=array(
    'dairishinchokujokyo__c'=>STATE_MOUSHIKOMI,
    'dairimoshikomihoho__c'=>MOUSHIKOMI_FROM,
    'dairihokenryooshiharaisogaku__c'=>$this->_Sougaku,
    'dairinyukinshubetsu__c'=>$this->ShiharaiType(),
    'trading_id__c'=>$this->_TradingId,
    'dairinenkotaishoninzu__c'=>$this->getKeizokusyaNum()
   );
   if($this->ShiharaiType() == SHIHARAI_TYPE_BANK){
    $_kigen_datetime = $this->_ShiharaiKigen."T00:00:00+09:00";
    $updateitems=array_merge($updateitems, array('dairinyukinkigen__c'=>$_kigen_datetime));
   }
   if($this->ShiharaiType() == SHIHARAI_TYPE_CARD){
    $updateitems=array_merge($updateitems, array('dairinyukikingaku__c'=>$this->_Sougaku));
    $updateitems=array_merge($updateitems, array('dairinyukinkakuninzumi__c'=>true));
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
   $_where = "dairimadokuchikaishabango__c = '$this->_No' AND Nendo__c = '$_nendo' AND Type__c = '$this->_Type'";
   $_orderby = "";
   $updateitems=array(
    'dairishinchokujokyo__c'=>STATE_MOUSHIKOMI,
    'dairimoshikomihoho__c'=>MOUSHIKOMI_FROM,
    'dairihokenryooshiharaisogaku__c'=>$this->_Sougaku,
    'dairinyukinshubetsu__c'=>$this->ShiharaiType(),
    'trading_id__c'=>$this->_TradingId,
    'dairinenkotaishoninzu__c'=>$this->getKeizokusyaNum()
   );
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
  private $_KingakuSel;
  private $_SanteiKisogaku;
  private $_SanteiKisogaku3500;
  private $_SanteiKisogaku10000;
  private $_SanteiKisogakuSel;
  private $_KozaJoho;
  private $_Kaihi;
  private $_ShiharaiType;
  private $_ShiharaiKigen;
  private $_TradingId;
  private $_CardHakkohiyo;

  private $_Keizoku;
  
  public function __construct($type, $No){
   $this->_Type = $type;
   $this->_No = $No;
   $this->_Name = '';
   $this->_Keizoku = 'keizoku';
  }
  
  /* 参照関数 */
  public function No(){return $this->_No;}
  public function Name(){return $this->_Name;}
  public function Nichigaku(){return $this->_Nichigaku;}
  public function NichigakuSel(){return $this->_NichigakuSel;}
  public function Kingaku(){return $this->_Kingaku;}
  public function Kingaku3500(){return $this->_Kingaku3500;}
  public function Kingaku10000(){return $this->_Kingaku10000;}
  public function KingakuSel(){return $this->_KingakuSel;}
  public function Keizoku(){return $this->_Keizoku;}
  public function SanteiKisogaku(){return $this->_SanteiKisogaku;}
  public function SanteiKisogaku3500(){return $this->_SanteiKisogaku3500;}
  public function SanteiKisogaku10000(){return $this->_SanteiKisogaku10000;}
  public function SanteiKisogakuSel(){return $this->_SanteiKisogakuSel;}
  public function KozaJoho(){return $this->_KozaJoho;}
  public function Kaihi(){return $this->_Kaihi;}
  public function CardHakkohiyo(){return $this->_CardHakkohiyo;}
  public function ShiharaiType(){return $this->_ShiharaiType;}

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
  public function setKingakuSel($val){
   $this->_KingakuSel = $val;
  }
  public function setSanteiKisogakuSel($val){
   $this->_SanteiKisogakuSel = $val;
  }
  public function setShiharaiType($val){
   if($val != SHIHARAI_TYPE_CARD && $val != SHIHARAI_TYPE_BANK && $val != SHIHARAI_TYPE_FURIKAE) return;
   $this->_ShiharaiType = $val;
  }
  public function setShiharaiKigen($val){
   $_date = date('Y-m-d', strtotime($val));
   $this->_ShiharaiKigen = $_date;
  }
  
  /* 判定関数 */
  public function isKeizoku(){
   if($this->_Keizoku == 'keizoku'){
    return true;
   }
   return false;
  }
  
  
  /* SFから加入者年更レコード取得 */  
  public function getNenkoRecordData(){
   if($this->_Type == DATATYPE_OYAKATAKANYUSYA){
    $_select = SELECT_KOJIN;
   }
   if($this->_Type == DATATYPE_JIMUKANYUSYA){
    $_select = SELECT_JIMUKANYUSYA;
   }
   $_from = SF_OBJECT;
   $_nendo = NENDO;
   $_where = "seirinumber__c = '$this->_No' AND Nendo__c = '$_nendo' AND Type__c = '$this->_Type'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
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
   
   return true;
  }
  public function updateNenkoRecordData(){
   $_select = UPDATE_KOJIN;
   $_from = SF_OBJECT;
   $_nendo = NENDO;
   $_where = "seirinumber__c = '$this->_No' AND Nendo__c = '$_nendo' AND Type__c = '$this->_Type'";
   $_orderby = "";
   if($this->isKeizoku()){
    $_keizoku = STATE_MOUSHIKOMI;
    if($this->ShiharaiType()==''){
     $this->setShiharaiType(SHIHARAI_TYPE_CARD);
    }
   } else {
    $_keizoku = STATE_DATTAI;
   }
   $updateitems=array(
    'shinchokujokyo__c'=>$_keizoku,
    'moshikomiuketsuke__c'=>MOUSHIKOMI_FROM,
    'nenkojinichigaku__c'=>$this->NichigakuSel(),
    'nyukinshubetsu__c'=>$this->ShiharaiType(),
    'trading_id__c'=>$this->_TradingId
   );
   if($this->isKeizoku()){
    if($this->ShiharaiType() == SHIHARAI_TYPE_BANK){
     $_kigen_datetime = $this->_ShiharaiKigen."T00:00:00+09:00";
     $updateitems=array_merge($updateitems, array('nyukinkigen__c'=>$_kigen_datetime));
    }
    if($this->ShiharaiType() == SHIHARAI_TYPE_CARD){
     $updateitems=array_merge($updateitems, array('nyukinkingaku__c'=>$this->_KingakuSel));
     $updateitems=array_merge($updateitems, array('nyukinkakuninzumi__c'=>true));
    }
   }
   
   sf_soql_update($_select, $_from, $_where, $_orderby, $updateitems);
   
   return true;
  }
  
 };


?>
