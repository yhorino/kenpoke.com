<?php
 include_once('../bin/sf_Api.php');

 class NenkoKanyusyaData{
  private $_Type;
  private $_RecordTypeId;
  private $_Nendo;
  private $_No;
  private $_Name;
  private $_Nichigaku;
  private $_Kingaku;

  private $_Keizoku;
  
  public function __construct($No){
   $this->_No = $No;
   $this->_Keizoku = 'keizoku';
  }
  public function getNenkoRecordData(){
   $_select = "Id,shimeisei__c,shimeimei__c,genzainonichigaku__c,hokenryooshiharaisogaku__c";
   $_from = "nendokoshin__c";
   $_where = "seirinumber__c = '$this->_No'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   $_row = (array)$_result[0]['fields'];
   $this->_Name = $_row['shimeisei__c'].'　'.$_row['shimeimei__c'];
   $this->_Nichigaku = intval($_row['genzainonichigaku__c']);
   $this->_Kingaku = intval($_row['hokenryooshiharaisogaku__c']);
  }
  
  public function No(){return $this->_No;}
  public function Name(){return $this->_Name;}
  public function Nichigaku(){return $this->_Nichigaku;}
  public function Kingaku(){return $this->_Kingaku;}
  public function Keizoku(){return $this->_Keizoku;}
  public function isKeizoku(){
   if($this->_Keizoku == 'keizoku'){
    return true;
   }
   return false;
  }
  
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
  
 };

 class NenkoData{
  private $_Type;
  private $_RecordTypeId;
  private $_Nendo;
  private $_No;
  private $_Name;
  
  private $_KanyusyaData = [];
  
  public function __construct($No){
   $this->_No = $No;
  }
  public function getNenkoRecordData(){
   $_select = "Id,dairikaishamei__c";
   $_from = "nendokoshin__c";
   $_where = "dairimadokuchikaishabango__c = '$this->_No'";
   $_orderby = "";
   
   $_result = (array)sf_soql_select($_select, $_from, $_where, $_orderby);
   $_row = (array)$_result[0]['fields'];
   $this->_Name = $_row['dairikaishamei__c'];
  }
  
  public function No(){return $this->_No;}
  public function Name(){return $this->_Name;}
  
  public function addKanyusyaArray(array $nkd){
   $this->_KanyusyaData = array_merge($this->_KanyusyaData, $nkd);
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
  
  public function updateKanyusyaKeizoku($idx, $val){
   $this->_KanyusyaData[$idx]->setKeizoku($val);
  }
 };

?>
