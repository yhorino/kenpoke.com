<?php

class Proxy
{
    public $host;
    public $port;
    public $login;
    public $password;

    function __construct($ini)
    {
        $this->host = $ini["proxy_host"];
        $this->port = intval($ini["proxy_port"]);
        $this->login = $ini["proxy_login"];
        $this->password = $ini["proxy_password"];
    }
}

?>
