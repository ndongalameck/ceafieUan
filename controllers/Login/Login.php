<?php

namespace controllers;

use application\Controller;
use application\Hash;
use application\Session;

/**
 * Description of loginController
 *
 * @author sam
 */
class Login extends Controller {

    //put your code here

    private $log;

    public function __construct() {
        parent::__construct();
        $this->log = $this->LoadModelo('Usuario');
    }

    public function index() {

        if (Session::get('id')) {
            $this->redirecionar("dashboard");
        } else {

            $this->view->setJs(array("novo"));
            $this->view->setCss(array("style"));
            $this->view->titulo = "Iniciar Sessão";


            if ($this->getInt('enviar') == 1) {
                $this->dados = $_POST;
                if (!$this->getSqlverifica('login')) {
                    $this->view->erro = "POrfavor Introduza um nome Valido";
                    $this->view->renderizar("index");
                    exit;
                }
                if (!$this->getSqlverifica('senha')) {
                    $this->view->erro = "POrfavor Introduza uma senha Valida";
                    $this->view->renderizar("index");
                    exit;
                }

                $this->log->setLogin($this->getSqlverifica('login'));
                $this->log->setSenha(Hash::getHash('md5', $this->alphaNumeric('senha'), HASH_KEY));
                // $this->log->setSenha($this->alphaNumeric('senha'));
                $linha = $this->log->Autenticar($this->log);
                if (!$linha) {
                    $this->view->erro = "Usuario ou Palavra Passe Incorreta";
                    $this->view->renderizar("index");
                    exit;
                }


                Session::set("autenticado", true);
                Session::set('nivel', $linha->getNivel());
                 Session::set('tema', $linha->getTema());
                Session::set('nome', $linha->getPessoa()->getNome());
                 Session::set('pessoa', $linha->getPessoa()->getId());
                Session::set('id', $linha->getId());
                Session::set('time', time());

                if (Session::get('nivel') == "gestor") {
                    $this->redirecionar('dashboard');
                }

                if (Session::get('nivel') == "aluno") {
                    $this->redirecionar("dashboard/aluno/");
                }

                if (Session::get('nivel') == "docente") {
                    $this->redirecionar("dashboard/docente/");
                }
                if (Session::get('nivel') == "administrador") {
                    $this->redirecionar("dashboard/admin/");
                }
                
                else {
                    $this->redirecionar('index');
                }
            }
        }


        $this->view->renderizar("index");
    }

    public function logof() {
        Session::destruir(array('autenticado', 'nivel', 'nome', 'id', 'time','pessoa'));
        $this->redirecionar("login");
    }

}
