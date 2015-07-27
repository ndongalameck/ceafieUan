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
 * Description of Aluno
 *
 * @author sam
 */
class Aluno extends Controller {

    private $aluno;
    private $nota;
    private $materia;
    private $matricula;
    private $usuario;
    private $pessoa;
    private $curso;
    private $mm;

    public function __construct() {
        Session::nivelRestrito(array("aluno"));
        $this->pessoa = $this->LoadModelo('Pessoa');
        $this->aluno = $this->LoadModelo('Aluno');
        $this->curso = $this->LoadModelo('Curso');
        $this->matricula = $this->LoadModelo("Matricula");
        $this->nota = $this->LoadModelo("Nota");
        $this->usuario = $this->LoadModelo("Usuario");
        $this->materia = $this->LoadModelo("Materia");
        $this->mm = $this->LoadModelo('MatriculaModulo');

        parent::__construct();
        $this->view->setJs(array("novo"));
        $this->view->setCss(array('amaran.min', 'animate.min', 'layout', 'ie'));
        $this->view->menu = $this->getFooter('menu');
    }

    public function index() {
        
    }

    public function nota($id) {
        if ($id) {
            $id = $this->usuario->pesquisar($id);
            $id1 = $this->pessoa->pesquisar($id->getPessoa()->getId());
            $id2 = $this->aluno->pesquisaPor($id1->getId());
            $this->view->dados = $this->nota->pesquisaNota1($id2->getId());
            $this->view->renderizar('nota');
        } else {
            $this->redirecionar('dashboard/aluno');   
        }
    }

    public function materia($dados = FALSE) {
        if ($this->getInt('enviar')) {
            $this->materia->pesquisar($dados);
            $this->view->renderizar('materia');
        }
        $this->view->renderizar('materia');
    }

    public function matricula($id) {
        
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

            $this->view->dados = $this->materia->pesquisaPor($dados);
        }
        $this->view->renderizar('materia');
    }

    public function informacao($id) {
        $id = $this->usuario->pesquisar($id);
        $id1 = $this->pessoa->pesquisar($id->getPessoa()->getId());
        $id2 = $this->aluno->pesquisaPor($id1->getId());
        $this->view->dados = $this->matricula->pesquisar($id2);
        $this->view->modulo = $this->mm->pesquisarPor($this->view->dados->getId());

        $this->view->renderizar("informacao");
    }

    public function editar($id) {
        $this->view->dados = $this->usuario->pesquisar($id);
        $this->view->renderizar("editar");
    }

    public function alteraSenha() {

        if ($this->getInt('enviar') == 1) {

            $this->usuario->setSenha($_POST['senha']);
            $this->usuario->setId(Session::get('id'));
            if ($this->usuario->editarSenha($this->usuario)) {
                $this->view->mensagem = "Senha alterada com sucesso";
                $this->redirecionar("aluno/editar/" . Session::get('id'));
                exit;
            } else {
                $this->view->erro = "Erro ao alterar senha";
                $this->view->renderizar('senha');
                exit;
            }
        } else {
            $this->view->renderizar('senha');
        }
    }

}
