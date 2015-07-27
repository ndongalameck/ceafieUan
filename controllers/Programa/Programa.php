<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controllers;

use application\Controller;
use application\Dao;
use DateTime;
use DateTimeZone;
use application\Session;

/**
 * Description of Programa
 *
 * @author sam
 */
class Programa extends Controller implements Dao {

    //put your code here
    private $programa;
    private $docente;

    public function __construct() {
        Session::nivelRestrito(array("gestor"));
        $this->programa = $this->LoadModelo('Programa');
        $this->docente = $this->LoadModelo('Docente');
        parent::__construct();
        $this->view->setJS(array('novo'));
        $this->view->setCss(array('amaran.min', 'animate.min', 'layout', 'ie'));
        $this->view->menu = $this->getFooter('menu');
    }

    public function index() {
        $this->view->dados = $this->programa->pesquisar();
        $this->view->renderizar("index");
    }

    public function adicionar($dados = FALSE) {

        if ($this->getInt('enviar')) {

            $this->view->dados = $_POST;
            if (!$this->getSqlverifica('curso')) {
                // $ret = Array("mensagem" => "Porfavor Escolha um curso");
                // echo json_encode($ret);
                $this->view->erro = "Porfavor Escolha um curso";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('modulo')) {
                //$ret = Array("Porfavor Escolha um modulo");
                //echo json_encode($ret);

                $this->view->erro = "Porfavor Escolha um modulo";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('docente')) {
                //$ret = Array("mensagem" => "Porfavor Escolha um docente");
                //echo json_encode($ret);

                $this->view->erro = "Porfavor Escolha um docente";
                $this->view->renderizar("novo");
                exit;
            }


            if (!$this->getSqlverifica('local')) {
                //$ret = Array("mensagem" => "Porfavor Escolha um local");
                //echo json_encode($ret);
                $this->view->erro = "Porfavor Escolha um local";
                $this->view->renderizar("novo");

                exit;
            }


            if (!$this->getSqlverifica('termino')) {
                //$ret = Array("mensagem" => "Porfavor Escolha uma data de termino");
                //echo json_encode($ret);

                $this->view->erro = "Porfavor Escolha uma data de termino";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('inicio')) {
                //$ret = Array("mensagem" => "Porfavor Escolha uma data de inicio");
                //echo json_encode($ret);
                $this->view->erro = "Porfavor Escolha uma data de inicio";
                $this->view->renderizar("novo");
                exit;
            }


            if (!$this->getSqlverifica('hora')) {
                //$ret = Array("mensagem" => "Porfavor Escolha uma hora");
                //echo json_encode($ret);

                $this->view->erro = "Porfavor Escolha uma hora";
                $this->view->renderizar("novo");
                exit;
            }


//            $format = 'd-m-Y';
//            $timeZone = new DateTimeZone('UTC');
//            $inicio = DateTime::createFromFormat($format, $dados['inicio'],$timeZone);
//            $fim = DateTime::createFromFormat($format, $dados['termino'],$timeZone);
//
//            if ($fim->format($format) < $inicio->format($format)) {
//                //$ret = Array("mensagem" => "Verifica as Datas");
//                //echo json_encode($ret);
//                $this->view->erro = "Verifica as Datas";
//                $this->view->renderizar("novo");
//
//                exit;
//            }

            if ($this->compararDatas($this->view->dados['inicio'], $this->view->dados['termino'])) {
                $this->view->erro = "Verifica as Datas";
                $this->view->renderizar("novo");
                exit;
            }

            $this->programa->setHoras($this->view->dados['hora']);
            $this->programa->setData($this->view->dados['inicio']);
            $this->programa->setLocal($this->view->dados['local']);
            $this->programa->setDatafinal($this->view->dados['termino']);

            if ($this->programa->adiciona($this->programa, $this->view->dados)) {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Dados guardados com sucesso");
                //echo json_encode($ret);
                $this->view->mensagem = "Dados guardados com sucesso";
                $this->view->renderizar("novo");
                exit;
            } else {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao guardar dados ");
                //echo json_encode($ret);
                $this->view->mensagem = "Erro ao guardar dados";
                $this->view->renderizar("novo");

                exit;
            }
        }


        $this->view->renderizar("novo");
    }

    public function editar1($dados = FALSE) {

        if ($this->getInt('enviar')) {

            $dados = $_POST;


            if (!$this->getSqlverifica('local')) {
                //$ret = Array("mensagem" => "Porfavor Escolha um local");
                //echo json_encode($ret);
                $this->view->erro = "Porfavor Escolha um local";
                $this->view->renderizar("novo");

                exit;
            }


            if (!$this->getSqlverifica('termino')) {
                //$ret = Array("mensagem" => "Porfavor Escolha uma data de termino");
                //echo json_encode($ret);

                $this->view->erro = "Porfavor Escolha uma data de termino";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('inicio')) {
                //$ret = Array("mensagem" => "Porfavor Escolha uma data de inicio");
                //echo json_encode($ret);
                $this->view->erro = "Porfavor Escolha uma data de inicio";
                $this->view->renderizar("novo");
                exit;
            }


            if (!$this->getSqlverifica('hora')) {
                //$ret = Array("mensagem" => "Porfavor Escolha uma hora");
                //echo json_encode($ret);

                $this->view->erro = "Porfavor Escolha uma hora";
                $this->view->renderizar("novo");
                exit;
            }

            $this->programa->setHoras($dados['hora']);
            $this->programa->setData($dados['inicio']);
            $this->programa->setLocal($dados['local']);
            $this->programa->setDatafinal($dados['termino']);

            if ($this->programa->editar1($this->programa, $dados)) {
                //    $ret = Array("nome" => Session::get('nome'), "mensagem" => "Dados guardados com sucesso");
                //   echo json_encode($ret);
                $this->view->mensagem = "Dados guardados com sucesso";
                $this->view->renderizar("novo");

                exit;
            } else {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao guardar dados ");
                //echo json_encode($ret);
                $this->view->erro = "Erro ao guardar dados";
                $this->view->renderizar("novo");

                exit;
            }
        }


        $this->view->renderizar("editar");
    }

    public function editar($id = FALSE) {
        $this->view->dados = $this->programa->pesquisar();
        $this->view->renderizar("editar");
    }

    public function pesquisaPor($dados = FALSE) {
        $t = $this->docente->listagem();
        echo json_encode($t);
    }

    public function pesquisar($id = FALSE) {
        
    }

    public function remover($id = FALSE) {
        if ($this->filtraInt($id)) {
            if ($this->programa->remover($id)) {
                return TRUE;
            }
        }
        $this->view->dados = $this->programa->pesquisar();
        $this->view->renderizar("remover");
    }

    public function editarDados($id = FALSE) {
        $this->view->dados = $this->programa->pesquisar($id);
        $this->view->renderizar('editarDados');
    }

    public function gerar($id) {

        $d = $this->programa->pesquisar($id);
        $css = "views/layout/default/bootstrap/css/bootstrap.min.css";
        $report = new \application\Recibo($css, 'sam');
        $report->BuildPDFPrograma($d);
        $report->Exibir();
    }

}
