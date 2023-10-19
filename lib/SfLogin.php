<?php

$_con;
define("SOAP_CLIENT_BASEDIR", "../../soapclient");

// SFDCにログイン
function sf_login()
{
    global $_config;
    global $_con;

    try {

      /********************************************
      * Destroy the old PHP session if one exists
      ********************************************/
      session_name("sf_SessionName");
      session_start();
     
/* 20201015 Y.Horino 他のSESSIONと干渉するのでコメントアウト
      if (isset($_SESSION["wsdl"])){
        session_unset();
        session_destroy();
        setcookie(session_name(), "", time() - 3600);
      }
*/
     
      /********************************************
      * Start a new session
      ********************************************/
      session_name("sf_SessionName");
      session_start();
      $_SESSION['wsdl'] = $_config["wsdl"];


    	// password の復号化
    	$_config["sf_password"] = decrypt(base64_decode($_config["sf_password"]));
//      echo "start<br/>";
    	// 接続
      $_con = new SforcePartnerClient();
      $_con->createConnection($_config["wsdl"]);
      // $_con->createConnection(SOAP_CLIENT_BASEDIR.'/partner.wsdl.xml');
      $_con->login($_config["sf_user"], $_config["sf_password"]);

      $_SESSION["location"] = $_con->getLocation();
      $_SESSION["sessionId"] = $_con->getSessionId();
    } catch (Exception $e) {
      err_die(__LINE__ ,　__FUNCTION__  . ": " . __LINE__ . "sf_login: " . $e->getMessage());
      // TODO: error 処理
    }
}

function retriveSession() {
  global $_config;
  global $_con;

  try {
    /********************************************
    * Reconnect to the old PHP session
    ********************************************/
    session_name("sf_SessionName");
    session_start();

    /********************************************
    * Reconnect to the Salesforce org
    *********************************************/
    $_con = new SforcePartnerClient();
    $_con->createConnection($_SESSION["wsdl"]);
    $_con->setSessionHeader($_SESSION["sessionId"]);
    $_con->setEndpoint($_SESSION["location"]);
  } catch (Exception $e) {
    err_die(__LINE__ ,　__FUNCTION__  . ": " . __LINE__ . "sf_login: " . $e->getMessage());
  }

}

function sf_logout() {
  global $_config;
  global $_con;

  try {
    /********************************************
    * Reconnect to the old PHP session
    ********************************************/
    session_name("sf_SessionName");
    session_start();

    /********************************************
    * Reconnect to the Salesforce org
    *********************************************/
    $_con = new SforcePartnerClient();
    $_con->createConnection($_SESSION["wsdl"]);
    $_con->setSessionHeader($_SESSION["sessionId"]);
    $_con->setEndpoint($_SESSION["location"]);
    $_con->logout();
  } catch (Exception $e) {
    err_die(__LINE__ ,　__FUNCTION__  . ": " . __LINE__ . "logout: " . $e->getMessage());
  }

}

/**
 * create / update の結果をDBの元レコードにセットする
 *
 * @param array $sobjs   SObjectの配列
 * @param array $r       createの結果
 * @return array         正常件数とエラー内容
 */
function sf_result($sobjs, $r)
{
    $create_count = 0;
    $error = array();
    $results = array();
    $s = "";

    if (!is_array($r)) $r = array($r);

    foreach ($r as $key => $val) {
        if (isset($val->success) && $val->success) {
            $create_count++;
            $results[$sobjs[$key]->sfimp_record_id] = TRUE;
        } else {
            if (isset($val->errors->statusCode)) $s = $val->errors->statusCode;
            if (isset($val->errors->fields)) $s .= ": " . $val->errors->fields;
            if (isset($val->errors->message)) $s .= ": " . $val->errors->message;
            $error[] = array("record_id" => $sobjs[$key]->sfimp_record_id, "message" => $s);
            $results[$sobjs[$key]->sfimp_record_id] = FALSE;
        }
    }
    db_result($results);  // 連携結果を元のレコードに書く
    return array("create_count" => $create_count, "error" => $error);
}


/**
 * SFDC にレコードを作成する
 *
 * @param array $sobjs   SObjectの配列
 * @return array         正常件数とエラー内容
 */
function sf_create($sobjs)
{
    global $_con;
    global $_error;
    $results = array();

    try {
        $r = $_con->create($sobjs);
        return sf_result($sobjs, $r);
    } catch (Exception $e) {
        err_die(__LINE__, __FUNCTION__ . ": " . __LINE__ . " sf_create error: " . $e->getMessage());
    }
}


/**
 * SFDC のレコードを更新する
 *
 * @param array $sobjs   SObjectの配列
 * @return array         正常件数とエラー内容
 */
function sf_update($sobjs)
{
    global $_con;
    global $_error;
    $results = array();

    try {
        $r = $_con->update($sobjs);
        return sf_result($sobjs, $r);
    } catch (Exception $e) {
        err_die(__LINE__, __FUNCTION__ . ": " . __LINE__ . " sf_update error: " . $e->getMessage());
    }
}


/**
 * sf_ceate() / sf_update() の結果を処理する
 *
 * @param integer $record_count
 * @param array $r                sf_create の結果
 * @param array $r2               処理結果を保持する配列
 */
function sf_import_result($record_count, &$r, &$r2)
{
    global $_error;

    if (!$r2) {
        $r["result"]["error_count"]++;
        err("import processing record: $record_count message: $_error");
    } else {
        $r["result"]["create_count"] += $r2["create_count"];
        $r["result"]["error_count"] += count($r2["error"]);
        foreach ($r2["error"] as $key => $val) {
            err("import processing record id: ${val["record_id"]} message: ${val["message"]}");
        }
    }
}


?>
