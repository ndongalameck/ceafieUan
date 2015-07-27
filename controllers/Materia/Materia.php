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
 * Description of Materia
 *
 * @author sam
 */
class Materia extends Controller implements Dao {

    //put your code here


    private $materia;
    private $docente;

    public function __construct() {
        Session::nivelRestrito(array("docente", "aluno"));
        $this->materia = $this->LoadModelo('Materia');
        $this->docente = $this->LoadModelo('Docente');
        parent::__construct();
        $this->view->setJS(array('novo'));
        $this->view->setCss(array('amaran.min', 'animate.min', 'layout', 'ie'));
        $this->view->menu = $this->getFooter('menu');
    }

    public function index() {
        $this->view->dados = $this->materia->pesquisar();
        $this->view->renderizar("index");
    }

    public function adicionar($dados = FALSE) {
        if ($this->getInt('enviar')) {

            $dados = $_POST;
            if (!$this->getSqlverifica('curso')) {
                $this->view->erro = "Porfavor Selecciona um curso";
                $this->view->renderizar('novo');
                exit;
            }

            if (!$this->getSqlverifica('modulo')) {
                $this->view->erro = "Porfavor Selecciona um modulo";
                $this->view->renderizar('novo');
                exit;
            }

            if (!$this->getSqlverifica('docente')) {
                $this->view->erro = "Porfavor Selecciona um docente";
                $this->view->renderizar('adicionar');
                exit;
            }


            if (!$this->getSqlverifica('data')) {
                $this->view->erro = "Porfavor Selecciona uma data";
                $this->view->renderizar('novo');
                exit;
            }

            if (!isset($_FILES['arquivo']["name"]) && empty($_FILES['arquivo']["name"])) {
                $this->view->erro = "Porfavor Selecciona um arquivo";
                $this->view->renderizar('novo');
                exit;
            }

            $diretorio = "upload/";
            move_uploaded_file($_FILES['arquivo']["tmp_name"], $diretorio . $_FILES['arquivo']["name"]);


            $this->materia->setNome($diretorio . $_FILES['arquivo']["name"]);
            $this->materia->setData($dados['data']);

            $p = $this->materia->pesquisarNome($diretorio . $_FILES['arquivo']["name"]);
            if (!$p) {
                $this->view->sms = "Já foi publicado um arquivo com esse nome";
                $this->view->renderizar('novo1');
                exit;
            }
            if ($this->materia->adiciona($this->materia, $dados)) {
                $this->view->mensagem = "Dados guardado com sucesso";
                $this->view->renderizar('novo');
                exit;
            } else {
                $this->view->erro = "Erro ao guardar dados";
                $this->view->renderizar('novo');
                exit;
            }
        }
        $this->view->renderizar("novo");
    }

    public function editar($id = FALSE) {
        
    }

    public function pesquisaPor($dados = FALSE) {
        
    }

//     Materia do curso aluno
    public function aluno($dados = FALSE) {
        $id = $this->materia->buscaAluno(Session::get('pessoa'));
        \Doctrine\Common\Util\Debug::dump($id);
        echo $id->getId();
        exit;
        $this->view->dados = $this->materia->pesquisar($id->getMatricula()->getModulo()->getId());
        $this->view->renderizar("aluno");
    }

    public function pesquisar($id = FALSE) {
        
    }

    public function remover($id = FALSE) {
        
    }

    public function adicionar1($dados = FALSE) {
        if ($this->getInt('enviar')) {
            Session::get('pessoa');
            $id = $this->docente->pesquisar(Session::get('pessoa'));
            $_POST['docente'] = $id->getId();
            $dados = $_POST;
            if (!$this->getSqlverifica('curso')) {
                $this->view->erro = "Porfavor Selecciona um curso";
                $this->view->renderizar('novo1');
                exit;
            }

            if (!$this->getSqlverifica('modulo')) {
                $this->view->erro = "Porfavor Selecciona um modulo";
                $this->view->renderizar('novo1');
                exit;
            }


            if (!$this->getSqlverifica('data')) {
                $this->view->erro = "Porfavor Selecciona uma data";
                $this->view->renderizar('novo1');
                exit;
            }

            if (empty($_FILES['arquivo']["name"])) {
                $this->view->erro = "Porfavor Selecciona um arquivo";
                $this->view->renderizar('novo1');
                exit;
            }

            $diretorio = "upload/";
            move_uploaded_file($_FILES['arquivo']["tmp_name"], $diretorio . $_FILES['arquivo']["name"]);


            $this->materia->setNome($diretorio . $_FILES['arquivo']["name"]);
            $this->materia->setData($dados['data']);
            $p = $this->materia->pesquisarNome($diretorio . $_FILES['arquivo']["name"]);
            if ($p) {
                //$this->view->sms = "Já foi publicado um arquivo com esse nome";
                $this->view->renderizar('novo1');
                exit;
            }

            if ($this->materia->adiciona($this->materia, $dados)) {
                $this->view->mensagem = "Dados guardado com sucesso";
                $this->view->sms = "Dados guardado com sucesso";

                $this->view->renderizar('novo1');
                exit;
            } else {
                $this->view->sms = "Erro ao guardar dados";
                $this->view->renderizar('novo1');
                exit;
            }
        }
        $this->view->sms = "Adicionar Nova Matéria de Formação";

        $this->view->renderizar("novo1");
    }

}
