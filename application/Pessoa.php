<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pessoa
 *
 * @author sam
 */
abstract class Pessoa {
    //put your code here
    
    
    
    public function getNome() {
        return $this->nome;
    }

    public function getEndreco() {
        return $this->endreco;
    }

    public function getContacto() {
        return $this->contacto;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEndreco($endreco) {
        $this->endreco = $endreco;
    }

    public function setContacto($contacto) {
        $this->contacto = $contacto;
    }


}
