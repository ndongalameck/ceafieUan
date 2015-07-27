<?php

namespace controllers;

use application\Controller;
use application\Session;
use application\Dao;
use application\LogUso;

/**
 * Description of categoriaController
 *
 * @author sam
 */
class Curso extends Controller implements Dao {

    private $curso;

    public function __construct() {

        $this->curso = $this->LoadModelo('Curso');
        parent::__construct();
        $this->view->setJs(array("novo"));
        $this->view->menu = $this->getFooter('menu');
        $this->view->setCss(array('amaran.min', 'animate.min', 'layout', 'ie'));
    }

    public function index() {
        $this->view->dados = $this->curso->pesquisar();
        $this->view->renderizar('index');
    }

    public function adicionar($dados = FALSE) {
        if ($this->getInt('enviar') == 1) {
            $this->view->dados = $_POST;


            if (!$this->getSqlverifica('nome')) {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Insira um nome");
                //  echo json_encode($ret);
                $this->view->erro = "Porfavor Insira um nome";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('descricao')) {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Insira uma descrição");
                //echo json_encode($ret);
                $this->view->erro = "Porfavor Insira uma descrição";
                $this->view->renderizar("novo");
                exit;
            }

            $this->curso->setNome($this->view->dados['nome']);
            $this->curso->setDescricao($this->view->dados['descricao']);
            $p = $this->curso->pesquisarCurso($this->view->dados['nome']);
            if ($p) {
                $this->view->erro = "Curso já Existe";
                $this->view->renderizar("novo");
                exit;
            }
            $id = $this->curso->adicionar($this->curso);
            if ($id) {
                
                $lo=new LogUso('log');
                $lo->verificarArquivo();
                $lo->gravar("Foi criado um novo curso".'Com o nome de : '.$_POST['nome']);
                $this->view->mensagem = "Dados guardado com sucesso";
                $this->view->renderizar("novo");

                exit;
            } else {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao guardar dados");
                //echo json_encode($ret);
                $this->view->erro = "Erro ao guardar dados";
                $this->view->renderizar("novo");

                exit;
            }
        }

        $this->view->renderizar('novo');
    }

    public function editar($id = FALSE) {
        if ($this->getInt('id')) {


            if (!$this->getSqlverifica('nome')) {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Insira um nome");
                //  echo json_encode($ret);
                $this->view->erro = "Porfavor Insira um nome";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('descricao')) {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Porfavor Insira uma descrição");
                //echo json_encode($ret);
                $this->view->erro = "Porfavor Insira uma descrição";
                $this->view->renderizar("novo");
                exit;
            }
            $this->curso->setNome($this->getSqlverifica('nome'));
            $this->curso->setDescricao($this->getSqlverifica('descricao'));
            $this->curso->setId($this->getInt('id'));
            $id = $this->curso->editar($this->curso);
            if (!$id) {
                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Erro ao alterar dados");
                //echo json_encode($ret);
                $this->view->erro = "Erro ao alterar dados";
                $this->view->renderizar("novo");
                exit;
            } else {

                $lo=new LogUso('log');
                $lo->verificarArquivo();
                $lo->gravar("Foi Editado um curso".' Com o nome de : '.$_POST['nome']);
                $this->view->mensagem = "Dados alterados com sucesso";
                $this->view->renderizar("novo");

                exit;
            }
        }
        $this->view->dados = $this->curso->pesquisar();
        $this->view->renderizar("editar");
    }

    public function pesquisaPor($dados = FALSE) {
        $t = $this->curso->listagem();
        echo json_encode($t);
    }

    public function pesquisar($id = FALSE) {
        
    }

    public function remover($id = FALSE) {
        if ($this->filtraInt($id)) {
            if ($this->curso->remover($id)) {
                $lo=new LogUso('log');
                $lo->verificarArquivo();
                $lo->gravar("Foi apagado um  curso");
                return TRUE;
            }
        }
        $this->view->dados = $this->curso->pesquisar();
        $this->view->renderizar("remover");
    }

    public function editarDados($id = FALSE) {
        $this->view->dados = $this->curso->pesquisar($id);
        $this->view->renderizar('editarDados');
    }

}
