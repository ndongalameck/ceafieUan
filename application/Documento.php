<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author sam
 */

namespace application;



interface Documento  {
    /*
     * Método para   setarCss do relatório em PDF 
     */

    public function setarCSS($file=FALSE);



    /*
     * Método para montar o Header do relatório em PDF 
     */

    public function getHeader($header=FALSE);


    /*
     * Método para montar o Rodapé do relatório em PDF 
     */

    public function getFooter();




    /*
     * Método para montar o Corpo do relatório em PDF 
     */

    public function getBody($dados=FALSE);
}
