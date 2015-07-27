<?php

namespace application;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author sam
 * Interface Dao
 * todos os controlores implementaram esta interface
 * 
 */
interface Dao{
    
    
    public function adicionar($dados=FALSE);

    public function editar($id=FALSE);

    public function pesquisar($id=FALSE);

    public function pesquisaPor($dados=FALSE);

    public function remover($id=FALSE);
}
