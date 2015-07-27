<?php
namespace controllers;
use application\Controller;
use application\Session;
class Error extends Controller{
    
    
    public function __construct() {
        parent::__construct();
        
    }
    public function index() {
         $this->view->setJs(array("novo"));
          $this->view->setCss(array("style"));
        $this->view->titulo="Pagina de erro";
        $this->view->mensagem_erro=  $this->getError();
        $this->view->renderizar("index");
    }
    
    private function getError($codigo=FALSE){
        if($codigo){
        $codigo=  $this->filtraInt($codigo);
        if(is_int($codigo)){
            $codigo=$codigo;
        }
        }
         else {
             $codigo="default";
         }
        $erro['default']="Ocorreu um erro. A Pagina não pode ser mostrada";
        $erro['5050']="Acesso Restrito";
        $erro['8080']="Tempo da Sessão Expirou";
    
        if(array_key_exists($codigo, $erro)){
            
            return $erro[$codigo];
        }
        else{
             return $erro['default'];
        }
    }
    
    
    public function acesso($codigo){
        $this->view->setJs(array("novo"));
          $this->view->setCss(array("style"));
        $this->view->titulo="Pagina de erro de acesso";
        $this->view->mensagem_erro=  $this->getError($codigo);
        $this->view->renderizar("acesso");
    
        
    }
    
    
    
}


?>