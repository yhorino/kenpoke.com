<?php
/**
 * 初期設定処理
 *
 */
header('Content-Type: text/html; charset=UTF-8');
function init()
{
	global $_config;

	// Proxy の設定
	if (strlen($_config["proxy_host"]) > 0) {
		$_config["proxy"] = new Proxy($_config);
	} else {
		$_config["proxy"] = null;
	}

	// 言語の設定
	mb_language("ja");
	mb_internal_encoding($_config["script_encoding"]);
	mb_regex_encoding($_config["connection_Info"]["CharacterSet"]);


	// // キーの取得
	// if (!isset($_config["key_file"]) || !$_config["key_file"]) {
	// 	err_die(200, "init(): 設定ファイルのキーファイルの指定がありません");
	// }
	// $lines = file($_config["key_file"], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	// if ($lines === FALSE) {
	// 	err_die(200, "init(): キーファイルが読み込めません: " . $_config["key_file"]);
	// } else if (count($lines) <= 0) {
	// 	err_die(200, "init(): キーファイルの中にキーがありません");
	// }
	// $_config["key"] = $lines[0];
}


/**
 * タイムスタンプ取得
 *
 * @return string  タイムスタンプ
 */
function timestamp()
{
    list($usec, $sec) = explode(" ", microtime());
    return date("YmdHis", $sec) . substr($usec, 1);
}


$_mail_body = null;

function mimeAddr($addr) {
    $as = explode("<", $addr);
    if (count($as) == 2) {
        return mb_encode_mimeheader(mb_convert_encoding(trim($as[0]), 'JIS','auto')) . ' <' . $as[1];
    } else {
        return $addr;
    }
}

function getAddr($addr) {
    $as = explode("<", $addr);
    if (count($as) == 2) {
        $ret = explode(">", $as[1]);
        return trim($ret[0]);
    } else {
        return $addr;
    }
}


/**
 * エラーメールを送信する
 */
function sendErrorMail()
{
    global $_config;
    global $_mail_body;

    if (!isset($_mail_body) || !$_mail_body) {	// 送るべきメッセージがない
        return;
    }

    if (!isset($_config["mail_to"]) || !$_config["mail_to"]) {	// 宛先がない
        return;
    }

    // 本文を作成
    $body = "処理日時: " . date("Y/m/d H:i:s") . "\n" . "エラー内容:\n";
    $body .= $_mail_body;
    $msgs = explode("\n", $_mail_body);
    $lines = count($msgs) - 1;
    $body .= "\nメッセージ件数: $lines 件\n";

    // 送信先をエンコード
    $to = getAddr($_config["mail_to"]);
    $header = "To: " . mimeAddr($_config["mail_to"]) . "\n";

    // 送信元をエンコード
    $header .= "From: " . mimeAddr($_config["mail_from"]) . "\n";

    // メールを送信
    $r = mb_send_mail($to, $_config["mail_subject_err"], $body, $header);

    if ($r) {
        echo "Sent error mail.\n";
    } else {
        echo "Fail to send error mail.\n";
    }
}


/**
 * trim() の全角スペース対応版
 */
function mb_trim($str) {
    $str = preg_replace('/^[ 　]+/u', '', $str);
    $str = preg_replace('/[ 　]+$/u', '', $str);
    return $str;
}


// メールアドレスのチェック
function validateEmail($email) {
	if (is_null($email) || $email == "") {
		return TRUE;
	}

	if (strlen($email) > 80) {
		return FALSE;	// salesforce のメールアドレスは80文字まで
	}

	if (preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9])+([a-zA-Z0-9\.\-]+)*[.][a-zA-Z]{2,4}$/',$email)) {
		$email_parts = explode('@', $email);
		$domain_parts = explode('.', $email_parts[1]);
		foreach ($domain_parts as $part) {
			if (!preg_match('/^([a-zA-Z0-9])+(\-?[a-zA-Z0-9])*$/',$part)) {
				return FALSE;
			}
		}
		return TRUE;
	} else {
		return FALSE;
	}
}


// 住所から都道府県を返す（マッチしなかったら false を返す）
function getPrefecture($address) {
	$pattern = "(.+(?:都|道|府|県))?(.+)";
	mb_ereg($pattern, $address, $arr);
	return $arr[1];
}


// 暗号化された文字列の復号化
function decrypt($encText) {

	global $_config;
	// echo "$encText decrypt start!</br>";

	// key と initial vector を生成
	$td = mcrypt_module_open('des', '', 'ecb', '');
	$key = substr($_config["key"], 0, mcrypt_enc_get_key_size($td));
	$iv_size = mcrypt_enc_get_iv_size($td);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	// echo "decrypt ing!</br>".mcrypt_generic_init($td, $key, $iv) ."</br>";
	// 暗号化ハンドルを初期化
	if (mcrypt_generic_init($td, $key, $iv) != -1) {
		$plain_text = mdecrypt_generic($td, $encText);
		// モジュールを解放
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		// echo "decrypt -1!</br>".$plain_text;
		// echo $plain_text;
		return $plain_text;
	} else {
		err_die(200, "decrypt(): 暗号化モジュールの初期化に失敗しました");
	}
}

// 文字列の暗号化
function encrypt($encText) {

	global $_config;

	// Initial Vector を生成
	$td = mcrypt_module_open('des', '', 'ecb', '');
	$iv_size = mcrypt_enc_get_iv_size($td);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

	// キーを生成
	// $key = md5($_config["keyword"]);
	// echo $key."</br>";
	// $key = substr($key, 0, mcrypt_enc_get_key_size($td));
	$key = substr($_config["key"], 0, mcrypt_enc_get_key_size($td));

	if (mcrypt_generic_init($td, $key, $iv) != -1) {
		// データを暗号化
		$pw = mcrypt_generic($td, $encText);

		// モジュールを解放
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);

		// 結果の表示とキーファイルの作成
		// echo "password:" . base64_encode($pw) . "¥n";
		return base64_encode($pw);

	} else {
		err_die(200, "encrypt(): 暗号化モジュールの初期化に失敗しました");
	}

}

function checkCrypt(){
	/* データ */
    $key = 'this is a very long key, even too long for the cipher';
    $plain_text = 'very important data';

    /* モジュールをオープンし、IV を作成します */
    $td = mcrypt_module_open('des', '', 'ecb', '');
    $key = substr($key, 0, mcrypt_enc_get_key_size($td));
    $iv_size = mcrypt_enc_get_iv_size($td);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

    /* 暗号化ハンドルを初期化します */
    if (mcrypt_generic_init($td, $key, $iv) != -1) {

        /* データを暗号化します */
        $c_t = mcrypt_generic($td, $plain_text);
        mcrypt_generic_deinit($td);

        /* 復号のため、バッファを再度初期化します */
        mcrypt_generic_init($td, $key, $iv);
        $p_t = mdecrypt_generic($td, $c_t);

        /* 後始末をします */
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
    }

    if (strncmp($p_t, $plain_text, strlen($plain_text)) == 0) {
        echo "ok\n";
    } else {
        echo "error\n";
    }
}


// 特殊記号をエスケープし、コントロールコードを改行コードに変換する
function escapeChar($str) {
	// エスケープ処理
	$tmp = str_replace("&", "&amp;", $str);
	$tmp = str_replace("<", "&lt;", $tmp);
	$tmp = str_replace(">", "&gt;", $tmp);

	// コントロールコードを改行コードに変換する
	$ctrlChars = array("\0", "\x01", "\0x02", "\x03", "\0x04", "\x05", "\0x06", "\x07", "\0x08", "\x0b", "\0x0c", "\x0e", "\0x0f");
	$tmp = str_replace($ctrlChars, "\n", $tmp);
	return $tmp;
}

?>
