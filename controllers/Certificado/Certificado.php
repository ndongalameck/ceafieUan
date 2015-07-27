<?php

namespace controllers;

use application\Controller;
use application\Session;
use application\LogUso;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Diploma
 *
 * @author sam
 */
class Certificado extends Controller {

    //put your code here
    private $matricula;
    private $nota;
    private $mm;

    public function __construct() {
        Session::nivelRestrito(array("gestor"));
        $this->matricula = $this->LoadModelo("Matricula");
        $this->nota = $this->LoadModelo("Nota");
        $this->mm = $this->LoadModelo("MatriculaModulo");
        parent::__construct();
        $this->view->setJs(array("novo"));
        $this->view->setCss(array('amaran.min', 'animate.min', 'layout', 'ie'));
        $this->view->menu = $this->getFooter('menu');
    }

    public function index($id = FALSE) {

        $this->view->dados = $this->nota->verNota();
        $this->view->renderizar("index");
    }

    public function gerar($id,$modulo) {
        $d = $this->matricula->pesquisar($id);
        $r = $this->mm->pesquisar($d->getId(), $modulo);
        $n=  $this->nota->pesquisaNota($d->getAluno()->getId());
        $css = "views/layout/default/bootstrap/css/bootstrap.min.css";
        $report = new \application\Certificado($css, 'sam');
        $report->setData($r->getMatricula()->getData());
        $report->setNome($r->getMatricula()->getAluno()->getPessoa()->getNome());
        $report->setModulo($r->getModulo()->getNome());
        $report->setNota($n->getNota());
        $report->BuildPDF();
        $lo = new LogUso('log');
        $lo->verificarArquivo();
        $lo->gravar("Foi gerado um diploma" . '  nome de aluno : ' . $d->getAluno()->getPessoa()->getNome());

        $report->Exibir();
    }

}
