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
  
  public function __construct($No){
   $this->_No = $No;
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
  
  public function Name(){return $this->_Name;}
 };

 class NenkoData{
  private $_Type;
  private $_RecordTypeId;
  private $_Nendo;
  private $_No;
  private $_Name;
  
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
  
  public function Name(){return $this->_Name;}
 };

?>
