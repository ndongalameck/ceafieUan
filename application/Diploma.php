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

class Diploma implements Documento {

    private $titulo;
    private $css;
    private $bi;
    private $nome;
    private $curso;
    private $data;
    private $modulo;

    function getModulo() {
        return $this->modulo;
    }

    function setModulo($modulo) {
        $this->modulo = $modulo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getData() {
        return $this->data;
    }

    public function setBi($bi) {
        $this->bi = $bi;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function __construct($css = null, $titulo) {
        $this->titulo = $titulo;
        $this->setarCSS($css);
    }

    public function getBody($dados=FALSE) {

        $nome = $this->getNome();
        $data = date("d-m-Y",  strtotime($this->getData()));
        $modulo = $this->getModulo();


        $retorno = "
<div style=\"margin:0 auto; float:none;\">
<table class=\"table table-striped table-bordered\">
<caption class=\"text-center\"><h4> UNIVERSIDADE AGOSTINHO NETO REITORIA<br /> Curso de Agregação Pedagógica
</h4><br />
<h2 style=\"text-align:center; color: #69D2E7;\">DIPLOMA</h2>
</caption>

<tbody>
<br /><br />

</tbody>
</table>
</div>
<br /><br /><br />
<div style=\"margin-left:160px;\">
<div style=\"font-family: 'Helvetica Neue', Helvetica, Arial, Verdana, sans-serif; font-size: 16px;\">

<tr>
          <td colspan=\"2\"><p style=\"\">Para os devidos efeitos certificamos que <strong>$nome</strong> concluiu aos <strong>$data</strong> o curso de $modulo.</p> <p><br />Com um total de 320 horas, conforme consta do livro _______ folha ______ n.º ____.</p>
        <tr>
          <td colspan=\"2\" align=\"center\"><p>Feito  em Luanda, aos ______ de ________________________ de _____</p></td>
          </tr>
        <tr>
        <tr>
        <br /><br />
          <td align=\"center\"><strong><em>O Director dos Servi&ccedil;os  Acad&eacute;micos</em></strong></td>
          <td align=\"center\">&nbsp;</td>
        </tr>
        
          <td align=\"center\">______________________________</td>
          <td align=\"center\">&nbsp;</td>
        </tr>
<tr>
          <td align=\"center\">&nbsp;</td>
          <td align=\"center\"><em><strong><em>O Reitor</em></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em></td>
        </tr>
        <tr>        
<tr>
          <td>&nbsp;</td>
          <td align=\"center\">_______________________</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
     
</div>

</div>


";

        return $retorno;
    }

    public function getFooter() {
        $retorno = "Data: " . date('Y-m-d');
        return $retorno;
    }

    public function getHeader($header=FALSE) {
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
        $this->pdf->WriteHTML($this->css, 1);
        //$this->pdf->SetHTMLHeader($this->getHeader());
        $this->pdf->WriteHTML($this->getHeader());
        $this->pdf->WriteHTML($this->getBody());
        //$this->pdf->SetHTMLFooter($this->getFooter());
    }

    public function Exibir($name = null) {
        $this->pdf->Output($name, "I");
    }

}
