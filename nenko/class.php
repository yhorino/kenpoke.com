<?php
 include_once('../bin/sf_Api.php');

/* 代理・会社データ */
 class NenkoData{
  private $_Id;
  private $_Type;
  private $_RecordTypeId;
  private $_Nendo;
  private $_No;
  private $_Name;
  
  private $_KanyusyaData = [];
  
  public function __construct($type, $No){
   $this->_Type = $type;
   $this->_No = $No;
   $this->_Name = '';
  }
  
  /* 参照関数 */
  public function No(){return $this->_No;}
  public function Name(){return $this->_Name;}
  
  /* 更新関数 */
  public function updateKanyusyaKeizoku($idx, $val){
   $this->_KanyusyaData[$idx]->setKeizoku($val);
  }
  
  /*
  public function addKanyusyaArray(array $nkd){
   $this->_KanyusyaData = array_merge($this->_KanyusyaData, $nkd);
  }
  */
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
   if($this->_Type == '一人親方代理'){
    return $this->_getNenkoRecordData_oyakatadairi();
   }
   if($this->_Type == '一人親方加入者'){
    return $this->_getNenkoRecordData_oyakatakanyusya();
   }
  }
  private function _getNenkoRecordData_oyakatadairi(){
   $_select = "Id,dairikaishamei__c";
   $_from = "nendokoshin__c";
   $_where = "dairimadokuchikaishabango__c = '$this->_No' AND Nendo__c = '2024' AND Type__c = '$this->_Type'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['dairikaishamei__c'];
   
   return true;
  }
  private function _getNenkoRecordData_oyakatakanyusya(){
   $_select = "Id,shimeisei__c,shimeimei__c,genzainonichigaku__c,hokenryooshiharaisogaku__c";
   $_from = "nendokoshin__c";
   $_where = "seirinumber__c = '$this->_No' AND Nendo__c = '2024' AND Type__c = '$this->_Type'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Id = $_result[0]['Id'];
   $this->_Name = $_row['shimeisei__c'].'　'.$_row['shimeimei__c'];
   
   return true;
  }
  
  /* SFから代理に紐づく加入者年更レコード取得 */  
  public function getNenkoKanyusyaRecordData(){
   if($this->_Type == '一人親方代理') {
    return $this->_getNenkoKanyusyaRecordData_oyakatadairi();
   }
   if($this->_Type == '一人親方加入者') {
    return $this->_getNenkoKanyusyaRecordData_oyakatakanyusya();
   }
  }
  private function _getNenkoKanyusyaRecordData_oyakatadairi(){
   $_type = '一人親方加入者';
   $_select = "Id,seirinumber__c";
   $_from = "nendokoshin__c";
   $_where = "dairikaisha__c = '$this->_Id' AND Nendo__c = '2024' AND Type__c = '$_type'";
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
   $_type = '一人親方加入者';
   $_nkd_record = new NenkoKanyusyaData($_type, $this->_No);
   $_nkd_record->getNenkoRecordData();
   $this->_KanyusyaData[] = $_nkd_record;
   
   return true;
  }
  
 };




/* 加入者データ */
 class NenkoKanyusyaData{
  private $_Type;
  private $_RecordTypeId;
  private $_Nendo;
  private $_No;
  private $_Name;
  private $_Nichigaku;
  private $_Kingaku;

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
  public function Kingaku(){return $this->_Kingaku;}
  public function Keizoku(){return $this->_Keizoku;}

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
  
  public function isKeizoku(){
   if($this->_Keizoku == 'keizoku'){
    return true;
   }
   return false;
  }
  
  
  /* SFから加入者年更レコード取得 */  
  public function getNenkoRecordData(){
   $_select = "Id,shimeisei__c,shimeimei__c,genzainonichigaku__c,hokenryooshiharaisogaku__c";
   $_from = "nendokoshin__c";
   $_where = "seirinumber__c = '$this->_No' AND Nendo__c = '2024' AND Type__c = '$this->_Type'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   if(count($_result) <= 0) return false;
   
   $_row = (array)$_result[0]['fields'];
   $this->_Name = $_row['shimeisei__c'].'　'.$_row['shimeimei__c'];
   $this->_Nichigaku = intval($_row['genzainonichigaku__c']);
   $this->_Kingaku = intval($_row['hokenryooshiharaisogaku__c']);
   
   return true;
  }
  
 };


?>
