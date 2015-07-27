<?php

namespace controllers;

use application\Controller;
use application\Dao;
use application\Session;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modulo
 *
 * @author sam
 */
class Modulo extends Controller implements Dao {

    //put your code here


    private $modulo;
    private $curso;

    public function __construct() {

        $this->curso = $this->LoadModelo('Curso');
        $this->modulo = $this->LoadModelo('Modulo');
        parent::__construct();
        $this->view->setJs(array("novo"));
        $this->view->setCss(array('amaran.min', 'animate.min', 'layout', 'ie'));
        $this->view->menu = $this->getFooter('menu');
    }

    public function index() {
        $this->view->dados = $this->modulo->pesquisa();
        $this->view->renderizar('index');
    }

    public function adicionar($dados = FALSE) {
        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;

            if (!$this->getSqlverifica('nome')) {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Insira um nome");
                //echo json_encode($ret);
                $this->view->erro = "Porfavor Insira um nome";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('curso')) {
                // $ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Selecciona um dos cursos");
                // echo json_encode($ret);
                $this->view->erro = "Porfavor Selecciona um dos cursos";
                $this->view->renderizar("novo");
                exit;
            }

            $this->modulo->setNome($this->view->dados['nome']);

            //verificar se já existe um modulo com esse nome
            $p = $this->modulo->pesquisarModulo($this->view->dados['nome']);
            if ($p) {
                $this->view->erro = "Modulo já Existe";
                $this->view->renderizar("novo");
                exit;
            }

            //adiconando modulo
            $id = $this->modulo->adiciona($this->modulo, $this->view->dados);
            if ($id) {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Dados guardado com sucesso");
                //echo json_encode($ret);
                $this->view->mensagem = "Dados guardado com sucesso";
                $this->view->renderizar("novo");
                exit;
            } else {
                $this->view->erro = "Erro ao guardar dados";
                $this->view->renderizar("novo");
//$ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao guardar dados");
                //echo json_encode($ret);
                exit;
            }
        }

        $this->view->renderizar('novo');
    }

    public function editar($id = FALSE) {
        if ($this->getInt('id')) {
            if (!$this->getSqlverifica('nome')) {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Insira um nome");
                //echo json_encode($ret);
                $this->view->erro = "Porfavor Insira um nome";
                $this->view->renderizar("novo");
                exit;
            }

            $this->modulo->setNome($this->getSqlverifica('nome'));
            $this->modulo->setId($this->getInt('id'));
            $id = $this->modulo->editar($this->modulo);
            if (!$id) {
                // $ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao alterar dados");
                //echo json_encode($ret);
                $this->view->erro = "Erro ao guardar dados";
                $this->view->renderizar("novo");
                exit;
            } else {

                // $ret = Array("nome" => Session::get('nome'), "mensagem" => "Dados alterados com sucesso", "status" => "ok");
                // echo json_encode($ret);
                $this->view->mensagem = "Dados alterados com sucesso";
                $this->view->renderizar("novo");
                exit;
            }
        }
        $this->view->dados = $this->modulo->pesquisar();
        $this->view->renderizar("editar");
    }

    public function pesquisaPor($dados = FALSE) {
        $t = $this->modulo->pesquisar($_GET['id']);
        echo json_encode($t);
    }

    public function pesquisar($id = FALSE) {
        
    }

    public function remover($id = FALSE) {
        if ($this->filtraInt($id)) {
            if ($this->modulo->remover($id)) {
                return TRUE;
            }
        }
        $this->view->dados = $this->modulo->pesquisar();
        $this->view->renderizar("remover");
    }

    public function editarDados($id = FALSE) {
        $this->view->dados = $this->modulo->pesquisa1($id);
        $this->view->renderizar('editarDados');
    }

}
