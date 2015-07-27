<?php

namespace controllers;

use application\Controller;
use application\Session;
use application\Hash;
use application\Dao;

//use vendor\paginador\Paginador;

/*
 * @sam
 */

class Usuario extends Controller implements Dao {

//put your code here
    private $usuario;
    private $pessoa;

    public function __construct() {
        Session::nivelRestrito(array("administrador"));
        parent::__construct();
        $this->usuario = $this->LoadModelo("Usuario");
        $this->pessoa = $this->LoadModelo("Pessoa");
        $this->view->setJs(array("novo"));
        $this->view->setCss(array('amaran.min', 'animate.min', 'layout', 'ie'));
        $this->view->menu = $this->getFooter('menu');
    }

    /*
     * @funcão index
     */

    public function index() {
        Session::nivelRestrito(array("administrador"));

        if ($this->getInt('enviar') == 1) {
            $dados = $_POST;


            if (!$this->getSqlverifica('nome')) {
                $this->view->erro = "Porfavor Introduza um nome valido ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->getSqlverifica('login')) {
                $this->view->erro = "Porfavor Introduza um login valido ";
                $this->view->renderizar("novo");
                exit;
            }



            if (!$this->getSqlverifica('nivel')) {
                $this->view->erro = "Porfavor Selecciona um nivel para o usuario ";
                $this->view->renderizar("novo");
                exit;
            }

            if (!$this->alphaNumeric('senha')) {
                $this->view->erro = "Porfavor introduza uma senha valida para o  usuario ";
                $this->view->renderizar("novo");
                exit;
            }

            $c = $this->usuario->pesquisaPor($_POST['login']);
            if ($c) {
                $this->view->erro = "O usuario já esta registrado.";
                $this->view->renderizar("novo");
                exit;
            }

            $this->pessoa->setNome($dados['nome']);
            $r = $this->pessoa->adicionar($this->pessoa);
            if ($r) {

                $this->usuario->setLogin($dados['login']);
                $this->usuario->setNivel($dados['nivel']);
                $this->usuario->setSenha(Hash::getHash('md5', $dados['senha'], HASH_KEY));

                $ru = $this->usuario->adiciona($this->usuario, $r);
                if (!is_int($ru)) {
                    $this->view->erro = "Não Foi Possivel  Concretizar a operção  tenta mais tarde!";
                    $this->view->renderizar("index");
                    exit;
                } else {
                    $this->view->mensagem = "Registro  Efectuado com Sucesso";
                    $this->view->renderizar("novo");
                    exit;
                }
            }
        }

        $this->view->usuarios = $this->usuario->pesquisar();
        $this->view->renderizar("index");
    }

    public function adicionar($dados = FALSE) {
        $this->view->renderizar('novo');
    }

    public function editar($id = FALSE) {

        if ($this->filtraInt($id)) {
            $this->view->dados = $this->usuario->pesquisar($id);
        }
        if ($this->getInt('enviar') == 1) {
            $dados = $_POST;



            if (!$this->getSqlverifica('login')) {
                $this->view->erro = "Porfavor Introduza um login valido ";
                $this->view->renderizar("editarDados");
                exit;
            }
            if (!$this->getSqlverifica('nivel')) {
                $this->view->erro = "Porfavor Selecciona um nivel para o usuario ";
                $this->view->renderizar("editarDados");
                exit;
            }



            $this->usuario->setLogin($dados['login']);
            $this->usuario->setNivel($dados['nivel']);
            $this->usuario->setSenha(Hash:: getHash('md5', $dados ['senha'], HASH_KEY));
            $this->usuario->setId($dados['id']);

            if (!$this->usuario->editar($this->usuario)) {
                // $ret = Array("mensagem" => "Erro ao criar usuario");
                //echo json_encode($ret);
                $this->view->erro = "Erro ao alterar dados do usuario";
                $this->view->renderizar("editarDados");

                exit;
            } else {

                //$ret = Array("nome" => Session::get('nome'), "mensagem" => "Dados alterados com sucesso", "status" => "ok");
                //echo json_encode($ret);
                // $this->view->mensagem = "Dados alterados com sucesso";
                $this->redirecionar("usuario");
                exit;
            }
        }
        $this->view->renderizar("editarDados");
    }

    public function pesquisaPor($dados = FALSE) {
        $t = $this->pessoa->pesquisaPor();
        echo json_encode($t);
    }

    public function pesquisar($id = FALSE) {
        
    }

    public function remover($id = FALSE) {
        if ($this->filtraInt($id)) {
            $this->pessoa->remover($id);
            return TRUE;
        }
        $this->view->dados = $this->usuario->pesquisar();
        $this->view->renderizar("index");
    }

    public function editarDados($id = FALSE) {
        
    }

}
