<?php

namespace controllers;

use application\Controller;
use application\Session;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author sam
 */
class Index extends Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (!Session::get('autenticado')) {
            $this->redirecionar('login');
        }
        $this->view->titulo = "Pagina Incial";
        $this->view->setCss(array("css"));
        $this->redirecionar('dashboard');
    }

}
