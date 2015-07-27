<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace application;

use application\Session;

/**
 * Description of LogUso
 *
 * @author sam
 * 
 */
class LogUso implements Log {

    //put your code here
    private $arquivo;

    function getArquivo() {
        return $this->arquivo;
    }

    function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

    public function __construct($arquivo) {
        $dir = ROOT . "logs/";
        if (!stristr(PHP_OS, 'WIN')) {
            $this->arquivo = $dir . '.' . $arquivo;
        } else {
            $this->arquivo = $dir . $arquivo;
        }
    }

    public function gravar($mensagem) {
        $arquivo = $this->verificarArquivo();
        $texto = '---------Log Gerado em ' . date('d-m-Y H:m:s') . '------------'."\n";
        $texto1='IP da Maquina do Usuario: ' . $_SERVER['REMOTE_ADDR']."\n";
        $texto2='Usuario: ' . Session::get('nome')."\n";
        $texto3="Acção feita: " . $mensagem."\n";
        $texto4="-------------------------------------------------------------------------------------------------"."\n";
        $t=$texto.$texto1.$texto2.$texto3.$texto4;
        
        if (!fwrite($arquivo, $t)) {
            $retorno = TRUE;
        } else {
            $retorno = FALSE;
        }
        fclose($arquivo);
        return $retorno;
    }

    public function verificarArquivo() {

        if (!file_exists($this->getArquivo())) {
            $arquivo = fopen($this->arquivo, 'w');
        } else {
            $arquivo = fopen($this->arquivo, 'a');
        }
        return $arquivo;
    }

}
