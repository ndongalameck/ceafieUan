<?php

namespace controllers;

use application\Controller;
use application\Session;

/**
 * Description Dashboard
 *
 * @author sam
 */
class Dashboard extends Controller {

    private $nota;
    private $matricula;
    private $usuario;

    public function __construct() {
        $this->nota = $this->LoadModelo('Nota');
        $this->matricula = $this->LoadModelo('Matricula');
        $this->usuario = $this->LoadModelo('Usuario');
        parent::__construct();
        $this->view->setCss(array('amaran.min', 'animate.min', 'layout', 'ie'));
        $this->view->setJs(array("jquery.amaran.min", 'novo', 'hideshow', 'jquery.equalHeight'));
        $this->view->menu = $this->getFooter('menu');
        $this->view->menuVertical = $this->getFooter('menuVertical');
        $this->view->titulo = "Dashboard";
    }

    public function index() {

        if (Strcmp(Session::get('tema'), "default") == 0) {
            $this->view->titulo = "Dashboard";
            Session::nivelRestrito(array("gestor"));
            $this->view->titulo = "Pagina de Gestão";



            $this->view->renderizar('index');
        } else {
            $this->teste();
        }
    }

    public function docente() {
        Session::nivelRestrito(array("docente"));
        if (Strcmp(Session::get('tema'), "default") == 0) {
            $this->view->titulo = "Dashboard";
            $this->view->titulo = "Pagina de Docente";
            $this->view->renderizar('teste1');
        } else {
            $this->teste1();
        }
    }

    public function aluno() {
        Session::nivelRestrito(array("aluno"));
        if (Strcmp(Session::get('tema'), "default") == 0) {
            $this->view->titulo = "Dashboard";
            $this->view->titulo = "Pagina de Aluno";
            $this->view->renderizar('aluno');
        } else {
            $this->teste2();
        }
    }

    public function admin() {
         $this->view->titulo = "Pagina de Administrador";
        Session::nivelRestrito(array("administrador"));
        if (Strcmp(Session::get('tema'), "default") == 0) {
            $this->view->titulo = "Dashboard";
           $this->view->renderizar('admin');
        } else {
            $this->teste3();
        }
    }

    public function dados1() {
        //CAP
        $cap1 = $this->nota->buscarNota(array("nota" => "Excelente"));
        $cap2 = $this->nota->buscarNota(array("nota" => "Bom"));
        $cap3 = $this->nota->buscarNota(array("nota" => "Suficiente"));
        $cap = join(",", array($cap1, $cap2, $cap3));
        $dados = join(",", array("[[$cap]]"));

        echo json_encode($dados);
    }

    public function dados() {
        //CAP
        $cap1 = $this->nota->pesquisaCurso("CAP");
        $cap2 = $this->nota->pesquisaCurso("CEPAC");
        $cap3 = $this->nota->pesquisaCurso("CEPID");
        $cap = join(",", array($cap1, $cap2, $cap3));
        $dados = join(",", array("[[$cap]]"));

        echo json_encode($dados);
    }

    public function listarUsuario() {
        if (Session::get('id')) {
            $id = 1;
        }
        $ret = Array("nome" => Session::get('nome'), "mensagem" => "Seja bem vindo a pagina de Administração");
        echo json_encode($ret);
    }

    public function teste() {
        Session::nivelRestrito(array("gestor"));
        $this->view->setCss1(array('bootmetro-responsive', 'bootmetro', 'bootmetro-icons', 'bootmetro-ui-light', 'demo'));
        // $this->view->setJs1(array("bootmetro-panorama", 'bootmetro-pivot', 'bootmetro-charms', 'jquery.mousewheel.min', 'jquery.touchSwipe.min', 'holder'));
        $this->view->renderizar("teste");
    }

    //tema 2 docente
    public function teste1() {
        $this->view->titulo = "Pagina de Docente";
        Session::nivelRestrito(array("docente"));
        $this->view->setCss1(array('bootmetro-responsive', 'bootmetro', 'bootmetro-icons', 'bootmetro-ui-light', 'demo'));
        // $this->view->setJs1(array("bootmetro-panorama", 'bootmetro-pivot', 'bootmetro-charms', 'jquery.mousewheel.min', 'jquery.touchSwipe.min', 'holder'));
        $this->view->renderizar("teste1");
    }

    //tema 2 aluno
    public function teste2() {
        Session::nivelRestrito(array("aluno"));
        $this->view->setCss1(array('bootmetro-responsive', 'bootmetro', 'bootmetro-icons', 'bootmetro-ui-light', 'demo'));
        // $this->view->setJs1(array("bootmetro-panorama", 'bootmetro-pivot', 'bootmetro-charms', 'jquery.mousewheel.min', 'jquery.touchSwipe.min', 'holder'));
        $this->view->renderizar("teste2");
    }
    
    
      //tema 2 admin
    public function teste3() {
        Session::nivelRestrito(array("administrador"));
        $this->view->setCss1(array('bootmetro-responsive', 'bootmetro', 'bootmetro-icons', 'bootmetro-ui-light', 'demo'));
        // $this->view->setJs1(array("bootmetro-panorama", 'bootmetro-pivot', 'bootmetro-charms', 'jquery.mousewheel.min', 'jquery.touchSwipe.min', 'holder'));
        $this->view->renderizar("teste3");
    }

    public function alteraTema() {

        $this->usuario->setId(Session::get('id'));
        $this->usuario->setTema($_POST['tema']);
        if ($this->usuario->editarTema($this->usuario)) {

            echo json_encode(array("mensagem" => "Tema alterado. Reiniciando..."));
            Session::destruir();
        } else {
            echo json_encode(array("mensagem" => "Erro ao alterar Tema"));
        }
    }

}
