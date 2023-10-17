<?php
// あいち労災様 設定ファイル
//
// Last Modify: 2017/6/22 14:22:48
//
$_config = array(
//******************************* 環境関係 ***************************
		// SFDCアカウント
		//------------ 本番用 -------------
//		"sf_user"     => "aichirousai@sunbridge.com",
//		"sf_password" => "skp2jTwHPvZB7M1vM4kR+g==",

 // 20181031 サンブリッジ管理者ユーザ無効化し、堀野アカウントで設定
//		"sf_user"     => "aichirousai@sunbridge.com",
//		"sf_password" => "skp2jTwHPvZB7M1vM4kR+g==",
		"sf_user"     => "y_horino@tmgt.co.jp",
		"sf_password" => "NeaicbtOnEZpbjS2REcRlw==",


	//------------ Sandbox テスト環境 syu -------------
		// SFDCアカウント
		// "sf_user"     => "aichirousai@sunbridge.com.test",
		// "sf_password" => "sunbridge1705",
		// "sf_password" => "skp2jTwHPvZB7M1vM4kR+g==",


 
//******************************* 環境関係 ***************************

		// key file path
		"key_file" => "../etc/key.txt",
    "key" => "d41d8cd98f00b204e9800998ecf8427e",
    "keyword" => "xn--4gqprf2ac7ft97aryo6r5b3ov.tokyo",

    // wsdl
		"wsdl" => "$_sf_root/lib/wsdl/partner.xml", 		// 本番環境用
		// "wsdl" => "$_sf_root/lib/wsdl/partner-sandbox.xml", 	// Sandbox用

    // プロキシサ－バの設定（不要なら空のままにする）
    "proxy_host" => "",
    "proxy_port" => "",
    "proxy_login" => "",
    "proxy_password" => "",

    // 文字コード
		"script_encoding" => "UTF-8",



);

?>
