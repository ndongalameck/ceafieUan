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
 * Description of Nota
 *
 * @author sam
 */
class Nota extends Controller implements Dao {

    //put your code here
    private $nota;
    private $dm;
    private $aluno;
    private $modulo;
    private $matricula;
    private $docente;

    public function __construct() {
        Session::nivelRestrito(array("gestor", "docente"));
        $this->nota = $this->LoadModelo('Nota');
        $this->dm = $this->LoadModelo('DocentModulo');
        $this->aluno = $this->LoadModelo('Aluno');
        $this->modulo = $this->LoadModelo('Modulo');
        $this->matricula = $this->LoadModelo('Matricula');
        $this->docente = $this->LoadModelo('Docente');
        parent::__construct();
        $this->view->setJs(array("novo"));
        $this->view->setCss(array('amaran.min', 'animate.min', 'layout', 'ie'));
        $this->view->menu = $this->getFooter('menu');
    }

    public function index() {
        $this->view->renderizar("index");
    }

    public function adicionar($dados = FALSE) {

        if ($this->getInt('enviar') == 1) {

            if (!$this->getSqlverifica('nota')) {
                $this->view->erro = "Porfavor Selecciona uma nota";
                $this->view->renderizar('index');
                exit;
            }

            $this->nota->setData(date('Y-m-d'));
            $aluno = $this->aluno->pesquisar($this->getInt('aluno'));
            $matricula = $this->matricula->pesquisar($aluno->getId());
            $modulo = $this->modulo->pesquisaPor($_POST['modulo']);
            $this->nota->setNota($this->getSqlverifica('nota'));
            $this->nota->setModulo($modulo);
            $this->nota->setAluno($aluno);

            $r = $this->nota->adicionar($this->nota);
            if ($r) {
                $this->view->mensagem = "Nota lançada com sucesso";
            } else {
                $this->view->erro = "Erro ao  lançar nota";
            }
        }

        $this->view->renderizar('index');
    }

    public function adicionarNotaDocente($dados = FALSE) {

        if ($this->getInt('enviar') == 1) {

            if (!$this->getSqlverifica('nota')) {
                $this->view->erro = "Porfavor Selecciona uma nota";
                $this->view->renderizar('docente');
                exit;
            }

            
            $this->nota->setData(date('Y-m-d'));
            $aluno = $this->aluno->pesquisar($this->getInt('aluno'));
            $matricula = $this->matricula->pesquisar($aluno->getId());
            $modulo = $this->modulo->pesquisaPor($_POST['modulo']);
            $this->nota->setNota($this->getSqlverifica('nota'));
            $this->nota->setModulo($modulo);
            $this->nota->setAluno($aluno);

            $r = $this->nota->adicionar($this->nota);
            if ($r) {
                $this->view->mensagem = "Nota lançada com sucesso";
            } else {
                $this->view->erro = "Erro ao  lançar nota";
            }
        }

        $this->view->renderizar('docente');
    }

    public function editar($id = FALSE) {


        if ($this->getInt('enviar') == 1) {
            if (!$this->getSqlverifica('nota')) {
                $this->view->erro = "Porfavor Selecciona uma nota";
                $this->view->renderizar('index');
                exit;
            }

            $this->nota->setNota($this->getSqlverifica('nota'));
            $this->nota->setId($this->getInt('id'));
            $this->nota->editar($this->nota);
        }

        $this->view->dados = $this->nota->pesquisar();
        $this->view->renderizar('editar');
    }

    public function pesquisaPor($dados = FALSE) {
        if ($this->getInt('enviar') == 1) {

            if (!$this->getSqlverifica('curso')) {
                $this->view->erro = "Porfavor Selecciona um dos cursos";
                $this->view->renderizar('index');
                exit;
            }

            if (!$this->getSqlverifica('modulo')) {
                $this->view->erro = "Porfavor Selecciona um dos modulos";
                $this->view->renderizar('index');
                exit;
            }

            $dados[] = $this->getInt('curso');
            $dados[] = $this->getInt('modulo');
            $dados[] = "FECHADO";
            $dados[] = $this->getSqlverifica('ano');
            $this->view->dados = $this->nota->pesquisaPorDOcente($dados);
        }
        $this->view->renderizar('index');
    }

    public function pesquisar($id = FALSE) {

        if ($this->getInt('enviar') == 1) {


            if (!$this->getSqlverifica('curso')) {
                $this->view->erro = "Porfavor Selecciona um dos cursos";
                $this->view->renderizar('index');
                exit;
            }

            if (!$this->getSqlverifica('modulo')) {
                $this->view->erro = "Porfavor Selecciona um dos modulos";
                $this->view->renderizar('index');
                exit;
            }


            $this->view->dados = $this->nota->pesquisar($this->getInt('modulo'));
        }
        $this->view->renderizar('editar');
    }

    public function remover($id = FALSE) {
        if ($this->getInt('id')) {
            if ($this->nota->remover($this->getInt('id'))) {
                $this->view->mensagem = "Nota Apagada com sucesso";
                $this->view->dados = $this->nota->pesquisar();
            }
        }
        $this->view->dados = $this->nota->pesquisar();
        $this->view->renderizar("remover");
    }

    public function docente() {

//        $id = $this->docente->pesquisar(Session::get('pessoa'));
//        $r = $this->dm->pesquisarPor($id->getId());
//        \Doctrine\Common\Util\Debug::dump($r); 
//        $dados = array("modulo" => $r->getModulo()->getId(), "estado" => "FECHADO");
//        if ($this->view->dados = $this->matricula->pesquisaPor($dados)) {
//            $this->view->renderizar("index1");
//        }
        $this->view->renderizar("docente");
    }

    public function pesquisaNotaDocente() {

        if ($this->getInt('enviar')) {
            $dados[] = '1';
            $dados[] = $_POST['modulo'];
            $dados[] = "FECHADO";
            $dados[] = $_POST['ano'];
            $this->view->dados = $this->nota->pesquisaPorDOcente($dados);
            $this->view->renderizar('docente');
        } else {
            $this->view->renderizar('docente'); 
        }
    }

    public function listar() {
        $this->view->nota = $this->nota->verNota();
        $this->view->renderizar("notas");
    }

    public function pesquisarPor($acao = FALSE, $modulo = FALSE, $ano = FALSE) {

        $dados[] = $acao;
        $dados[] = $modulo;
        $dados[] = "FECHADO";
        $dados[] = $ano;


        switch ($acao):

            case 'buscar': $this->view->nota = $this->nota->pesquisaPor($dados);


                $this->view->renderizar('ajax/lista');
                break;

        endswitch;
    }

    public function pesquisaDocenteNotas() {
        $id = $this->docente->pesquisar(Session::get('pessoa'));

        $t = $this->dm->listagem($id->getId());
        echo json_encode($t);
    }

}
