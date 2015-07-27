<?php
namespace application;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sms
 * Classe para envio de sms usando nowsms
 *
 * @author sam
 */
class Sms {

    public static function enviarSMS($host, $porta, $usuario, $senha, $contacto, $mensagem) {

        $fp = fsockopen($host, $porta, $errno, $errstr);
        if (!$fp) {
            echo "errno: $errno \n";
            echo "errstr: $errstr\n";
            return $result;
        }
        fwrite($fp, "GET /PhoneNumber=" . rawurlencode($contacto) . "&Text=" . rawurlencode($mensagem) . " HTTP/1.0\n");
      
        if ($usuario != "") {
            $auth = $usuario . ":" . $senha;
            echo "auth: $auth\n";
            $auth = base64_encode($auth);
            echo "auth: $auth\n";
            fwrite($fp, "Authorização: Basica " . $auth . "\n");
        }
        fwrite($fp, "\n");

        $res = "";

        while (!feof($fp)) {
            $res .= fread($fp, 1);
        }
        fclose($fp);


        return $res;
    }

}
