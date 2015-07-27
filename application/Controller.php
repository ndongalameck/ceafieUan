<?php

namespace application;
error_reporting(0);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller
 *
 * @author sam
 */
abstract class Controller {

    //put your code here

    protected $view;
    protected $acl;

    public function __construct() {

        $this->view = new View(new Request);
    }

    protected function LoadModelo($modelo) {

        $caminho = ROOT . "models" . DS1 . $modelo . ".php";
        if (is_readable($caminho)):
            require $caminho;
            $modelo = "\\" . "models" . "\\" . $modelo;
            $modelo = new $modelo;
            /*
             * return \models\$modelo 
             */
            return $modelo;
        else :
            throw new Exception("Erro No Modelo");
        endif;
    }

    protected function getBibliotecas($folder, $lib) {
        $caminho = ROOT . "vendor" . DS1 . $folder . DS1 . $lib . ".php";
        if (is_readable($caminho)):
            require $caminho;
        else:
            throw new Exception("Erro ao Ler Biblioteca");
        endif;
    }

    protected function getTexto($chave) {
        if (isset($_POST[$chave]) && !empty($_POST[$chave])):
            $_POST[$chave] = htmlspecialchars($_POST[$chave], ENT_QUOTES);
            return $_POST[$chave];
        endif;
        return "";
    }

    protected function getInt($chave) {
        if (isset($_POST[$chave]) && !empty($_POST[$chave])):
            $_POST[$chave] = filter_input(INPUT_POST, $chave, FILTER_VALIDATE_INT);
            return $_POST[$chave];

        endif;

        return 0;
    }

    protected function filtraInt($int) {
        $int = (int) $int;
        if (is_int($int)):
            return $int;
        else:
            return 0;
        endif;
    }

    protected function getSqlverifica($chave) {
        if (isset($_POST[$chave]) && !empty($_POST[$chave])) {
            $_POST[$chave] = strip_tags($_POST[$chave]);
            if (!get_magic_quotes_gpc()) {
                $_POST[$chave] = addslashes($_POST[$chave]);
            }
            return trim($_POST[$chave]);
        }
    }

    protected function alphaNumeric($chave) {
        if (isset($_POST[$chave]) && !empty($_POST[$chave])) {
            $_POST[$chave] = (string) preg_replace('/[^A-Z0-9_]/i', '', $_POST[$chave]);
            return trim($_POST[$chave]);
        }
    }

    protected function verificarEmail($chave) {
        if (isset($_POST[$chave]) && !empty($_POST[$chave])) {
            if (filter_var($_POST[$chave], FILTER_VALIDATE_EMAIL)) {
                return trim($_POST[$chave]);
            }
        }
    }

    protected function getPostParam($param) {

        if (isset($_POST[$param])):
            return $_POST[$param];
        endif;
    }

    protected function redirecionar($caminho = FALSE) {
        if ($caminho) {
            header("location:" . URL . $caminho);
            exit;
        } else {
            header("location:" . URL);
            exit;
        }
    }

    public function getFooter($vista, $link = false) {
        $rutaView = ROOT . "views" . DS1 . "layout" . DS1 . DEFAULT_LAYOUT . DS1 . $vista . ".php";

        if ($link)
            $link = URL . $link . '/';

        if (is_readable($rutaView)) {
            ob_start();

            include $rutaView;

            $contenido = ob_get_contents();

            ob_end_clean();

            return $contenido;
        }

        throw new Exception('Erro ao inserir Rodape');
    }

    abstract public function index();

    static function SaveViaTempFile($objecto) {
        $caminho = '/tmp/' . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
        // $t=$objecto->save(str_replace('.php', '.xlsx', $caminho));
        return $objecto->save(str_replace('.php', '.xlsx', __FILE__));
        //var_dump($t);
        // var_dump(unlink($caminho));
    }

    
    /** função para verificar Bi*/
    public function verificarBi($bi) {
        $expressao_regular = "/^[0-9]{9}[A-Z]{2}[0-9]{3}$/";
        if (preg_match($expressao_regular, $bi)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Função para gerar senhas aleatórias
     *
     * @author    Thiago Belem <contato@thiagobelem.net>
     *
     * @param integer $tamanho Tamanho da senha a ser gerada
     * @param boolean $maiusculas Se terá letras maiúsculas
     * @param boolean $numeros Se terá números
     * @param boolean $simbolos Se terá símbolos
     *
     * @return string A senha gerada
     */
    function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
        $lmin = 'abcdefghijkmnpqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';
        $num = '23456789';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';

        $caracteres .= $lmin;
        if ($maiusculas)
            $caracteres .= $lmai;
        if ($numeros)
            $caracteres .= $num;
        if ($simbolos)
            $caracteres .= $simb;

        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }

    /** Função para comparar datas
     * receber 2 parametro
     * $dataInicio que é alternativo
     * $dataFim que é a data que queremos compara-lo
     * * */
    public function compararDatas($dataInicio = false, $dataFim) {

        if ($dataInicio) {
            $d1 = & explode('-', $dataInicio);
            $d2 = & explode('-', $dataFim);

            $t1 = & mktime(0, 0, 0, $d1[1], $d1[0], $d1[2]);
            $t2 = & mktime(0, 0, 0, $d2[1], $d2[0], $d2[2]);

            if ($t2 < $t1) {
                return TRUE;
            } else {
                return FALSE;    
            }
        } else {
            $dataInicio = date('d-m-Y');
            $d1 = & explode('-', $dataInicio);
            $d2 = & explode('-', $dataFim);

            $t1 = & mktime(0, 0, 0, $d1[1], $d1[0], $d1[2]);
            $t2 = & mktime(0, 0, 0, $d2[1], $d2[0], $d2[2]);

            if ($t2 < $t1) {
                return TRUE;
            }
        }
    }

}
