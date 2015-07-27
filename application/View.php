<?php

namespace application;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//require_once URL."libs".DS."libs".DS."Smarty".DS."libs".DS."Smarty.class.php.php";
/**
 * Description of View
 *
 * @author sam
 */
class View {

    private $_controller;
    private $_js;
    private $_css;

    //put your code here
    function __construct(Request $pedido) {
        //parent::__construct();
        $this->_controller = $pedido->getController();
//        print $this->_controller; exit;
        $this->_js = array();
        $this->_css = array();
    }

    public function renderizar($nome, $item = FALSE) {


        if (Session::get('autenticado')) {
            $menu[] = array(
                "id" => "",
                "titulo" => "",
                "link" => URL . ""
            );
        } else {
            $menu[] = array(
                "id" => "login",
                "titulo" => "Inciar Sessão",
                "link" => URL . "login"
            );
        }

        if (strcasecmp(Session::get('nivel'), 'administrador') == 0) {
            $admin = array(
                array(
                    "id" => "matricula",
                    "titulo" => "Matricula",
                    "link" => URL . "matricula"
                ),
                array(
                    "id" => "docente",
                    "titulo" => "Docente",
                    "link" => URL . "docente"
                ),
                array(
                    "id" => "curso",
                    "titulo" => "Curso",
                    "link" => URL . "curso"
                ),
                array(
                    "id" => "nota",
                    "titulo" => "Nota",
                    "link" => URL . "nota"
                ),
                array(
                    "id" => "programa",
                    "titulo" => "Programa",
                    "link" => URL . "programa"
                ),
                array(
                    "id" => "relatorio",
                    "titulo" => "Relatorio",
                    "link" => URL . "relatorio"
                ),
            );
        } else {
            $admin = "";
        }






        $js = array();
        if (count($this->_js)) {
            $js = $this->_js;
        }
        $css = array();
        if (count($this->_css)) {
            $css = $this->_css;
        }

        $_layoutParam = array(
            "caminho_css" => URL . "views/layout" . DS1 . DEFAULT_LAYOUT . "/bootstrap" . DS1 . "css/",
            "caminho_js" => URL . "views/layout" . DS1 . DEFAULT_LAYOUT . "/bootstrap" . DS1 . "js/",
            "caminho_images" => URL . "views/layout" . DS1 . DEFAULT_LAYOUT . "/images/",
            "caminho_vendores" => URL . "views/layout" . DS1 . DEFAULT_LAYOUT . "/vendors/",
            "caminho_assets" => URL . "views/layout" . DS1 . DEFAULT_LAYOUT . "/assets/",
            "menu" => $menu,
            "admin" => $admin,
            "js" => $js,
            "css" => $css,
        );


        $caminho = ROOT . "views" . DS1 . $this->_controller . DS1 . $nome . ".phtml"; //ou phtml
        $header = ROOT . "views" . DS1 . "layout" . DS1 . DEFAULT_LAYOUT . DS1 . "header.php";
        $footer = ROOT . "views" . DS1 . "layout" . DS1 . DEFAULT_LAYOUT . DS1 . "footer.php";
        if (is_readable($caminho)) {
            require $header;
            //$this->assign("conteudo",$caminho);
            require $caminho;
           require $footer;
        } else {

            throw new Exception("Erro ao incluir a view, verifique o arquivo View");
        }
    }

    public function setJs(array $js) {
        if (is_array($js) && count($js)) {
            for ($i = 0; $i < count($js); $i++) {
                $this->_js[] = URL . "views/" . $this->_controller . "/js/" . $js[$i] . ".js";
            }
        } else {
            throw new Exception("Erro ao insirir o arquivo  Javascript");
        }
    }
    
      public function setJs1(array $js) {
        if (is_array($js) && count($js)) {
            for ($i = 0; $i < count($js); $i++) {
                $this->_js[] = URL . "views/" . $this->_controller . "/js/js/" . $js[$i] . ".js";
            }
        } else {
            throw new Exception("Erro de Javascript");
        }
    }

    public function setCss(array $css) {
        if (is_array($css) && count($css)) {
            for ($i = 0; $i < count($css); $i++) {
                $this->_css[] = URL . "views/" . $this->_controller . "/css/" . $css[$i] . ".css";
            }
        } else {
            throw new Exception("Erro ao insirir o arquivo Css");
        }
    }
    
    public function setCss1(array $css) {
        if (is_array($css) && count($css)) {
            for ($i = 0; $i < count($css); $i++) {
                $this->_css[] = URL . "views/" . $this->_controller . "/css/css/" . $css[$i] . ".css";
            }
        } else {
            throw new Exception("Erro de Css");
        }
    }
    

}
