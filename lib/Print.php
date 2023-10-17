<?php
//

/**
 * php スクリプト名を返す
 *
 * @return string スクリプト名
 */
function getScriptName() {
    global $argv;

    $pname = explode('/', $argv[0]);
    return $pname[count($pname)-1];
}


function info($str)
{
    // print getScriptName() . ": " . getmypid() . " info " . "$str\n";
    echo "Info: " ."$str<br/>";
}


function warn($str)
{
    echo "Error: " . "$str\n";
}


function err($str)
{
    echo "Error: " . "$str\n";
}


function fatal($str)
{
    echo "Fatal Error: " . "$str\n";
}


/**
 * エラーメッセージを出して終了する
 *
 * @param string $code    終了コード
 * @param string $str     エラーメッセージ
 */
function err_die($code, $str)
{
    global $_config;

    // メッセージを表示（ログに残す）
    fatal($str);
    // 終了する
    exit($code);
}

?>
