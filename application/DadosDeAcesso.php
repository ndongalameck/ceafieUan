<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Recibo
 *
 * @author sam
 */

namespace application;

use application\Documento;
use mPDF;

class DadosDeAcesso implements Documento {

    private $titulo;
    private $css;
    private $nome;
    private $senha;

    function getNome() {
        return $this->nome;
    }

    function getSenha() {
        return $this->senha;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    public function __construct($css = False, $titulo) {

        $this->titulo = $titulo;
        $this->setarCSS($css);
    }

    public function getBody($dados = FALSE) {
        $nome = $this->getNome();
        $senha = $this->getSenha();

        $retorno = "
      <div style=\"margin:0 auto; float:none;\">
    <table class=\"table table-striped table-bordered\">
    <caption class=\"text-center\"><h4> UNIVERSIDADE AGOSTINHO NETO REITORIA<br /> Curso de Agregação Pedagógica<br /><br /> Dados de acesso
</h4>

</caption>

    <tbody>
  <tr>
    <td>Login</td>
    <td>Senha</td>
</tr>
    <tr>
    <td>$nome</td>
    <td>$senha</td>
   </tr>
      </tbody>
      </table>
      
</div>


";

        return $retorno;
    }

    public function getFooter() {
        $retorno = "Data: " . date('Y-m-d');
        return $retorno;
    }

    public function getHeader($header = FALSE) {
        $retorno = "<img src='public/img/UAN2.png' class='img-responsive' style='margin-left:500px;' />";

        return $retorno;
    }

    public function setarCSS($file = FALSE) {
        if (file_exists($file)):
            $this->css = file_get_contents($file);
        else:
            echo 'Arquivo inexistente!';
        endif;
    }

    public function BuildPDF() {
        $this->pdf = new mPDF('utf-8', 'A4-L');
        $pdf->debug = true;
        $this->pdf->WriteHTML($this->css, 1);
        //$this->pdf->SetHTMLHeader($this->getHeader());
        $this->pdf->WriteHTML($this->getHeader());
        $this->pdf->WriteHTML($this->getBody());
    }

    public function Exibir($name = FALSE) {
        $this->pdf->Output($name, 'D');
    }

}
