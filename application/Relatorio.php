<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Relatorio
 *
 * @author sam
 */

namespace application;

use application\Documento;
use mPDF;

class Relatorio implements Documento {

    //put your code here

    private $total;
    private $excelente_h;
    private $bom_h;
    private $suficiente_h;
    private $excelente_m;
    private $bom_m;
    private $suficiente_m;
    private $homem_cap;
    private $homem_cepac;
    private $homem_cepid;
    private $mulher_cap;
    private $mulher_cepac;
    private $mulher_cepid;

    function getHomem_cap() {
        return $this->homem_cap;
    }

    function getHomem_cepac() {
        return $this->homem_cepac;
    }

    function getHomem_cepid() {
        return $this->homem_cepid;
    }

    function getMulher_cap() {
        return $this->mulher_cap;
    }

    function getMulher_cepac() {
        return $this->mulher_cepac;
    }

    function getMulher_cepid() {
        return $this->mulher_cepid;
    }

    function setHomem_cap($homem_cap) {
        $this->homem_cap = $homem_cap;
    }

    function setHomem_cepac($homem_cepac) {
        $this->homem_cepac = $homem_cepac;
    }

    function setHomem_cepid($homem_cepid) {
        $this->homem_cepid = $homem_cepid;
    }

    function setMulher_cap($mulher_cap) {
        $this->mulher_cap = $mulher_cap;
    }

    function setMulher_cepac($mulher_cepac) {
        $this->mulher_cepac = $mulher_cepac;
    }

    function setMulher_cepid($mulher_cepid) {
        $this->mulher_cepid = $mulher_cepid;
    }

    function getExcelente_m() {
        return $this->excelente_m;
    }

    function getBom_m() {
        return $this->bom_m;
    }

    function getSuficiente_m() {
        return $this->suficiente_m;
    }

    function setExcelente_m($excelente_m) {
        $this->excelente_m = $excelente_m;
    }

    function setBom_m($bom_m) {
        $this->bom_m = $bom_m;
    }

    function setSuficiente_m($suficiente_m) {
        $this->suficiente_m = $suficiente_m;
    }

    function getExcelente_h() {
        return $this->excelente_h;
    }

    function getBom_h() {
        return $this->bom_h;
    }

    function getSuficiente_h() {
        return $this->suficiente_h;
    }

    function setExcelente_h($excelente_h) {
        $this->excelente_h = $excelente_h;
    }

    function setBom_h($bom_h) {
        $this->bom_h = $bom_h;
    }

    function setSuficiente_h($suficiente_h) {
        $this->suficiente_h = $suficiente_h;
    }

    function getTotal() {
        return $this->total;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    public function __construct($css = null, $titulo) {
        $this->titulo = $titulo;
        $this->setarCSS($css);
    }

    public function getBody($dados=FALSE) {
        
    }

    //////////////////




    public function getBodyCurso($curso = FALSE) {
        $excelente_h = $this->getExcelente_h();
        $suficiente_h = $this->getSuficiente_h();
        $bom_h = $this->getBom_h();

        $excelente_m = $this->getExcelente_m();
        $suficiente_m = $this->getSuficiente_m();
        $bom_m = $this->getBom_m();
        $total_ex = $excelente_h + $excelente_m;
        $total_suf = $suficiente_h + $suficiente_m;
        $total_bom = $bom_h + $bom_m;

        $total_h = $excelente_h + $bom_h + $suficiente_h;
        $total_m = $excelente_m + $bom_m + $suficiente_m;
        $total_geral = $total_bom + $total_ex + $total_suf;

        $retorno = "
<table class=\"table table-striped table-bordered\">
<caption class=\"text-center\"><h4> Relatório Gerado pelo Sistema<br /><br /> NUMERO TOTAL DE NOTAS NO $curso EM 2015<br />

</h4>
</caption>

<tbody>



</tr>
	<tr class=\"ro2\"><td style=\" \" class=\"Default\">
	 </td>
	<td rowspan=\"2\" style=\" \" class=\"ce2\"><p>NOTAS </p></td>
	<td colspan=\"2\" style=\" \" class=\"ce5\"><p>GENÉRO</p></td>
	</tr>
	<tr class=\"ro2\">
        <td style=\"\" class=\"Default\"> 
	</td>
	<td style=\" \" class=\"ce5\"><p>M</p></td><td style=\"text-align:left;width:2.258cm; \" class=\"ce5\"><p>F</p>
        </td>
        <td style=\" \" class=\"ce5\"><p>TOTAL</p>
        </td>
        </tr>
        <tr class=\"\">
     
<td style=\"\" class=\"\"> 
<td style=\"\" class=\"\"><p>EXCELENTE</p></td><td style=\" \" class=\"\"><p>$excelente_h</p></td>
<td style=\"\" class=\"\"><p>$excelente_m</p>
</td>
<td style=\" \" class=\"\"><p>$total_ex</p>
</td>
     </tr>

<tr class=\"\">
        <td style=\" \" class=\"Default\"> 
        </td>
        
<td style=\"\" class=\"\"><p>SUFICIENTE</p></td>
<td style=\" \" class=\"\"><p>$suficiente_h</p>
        </td>
        <td style=\"\" class=\"\"><p>$suficiente_m</p></td>
        <td style=\" \" class=\"\"><p>$total_suf</p>
        </td>
        <td style=\"\" class=\"\"> 
        </td>
        </tr>
        <tr class=\"\">
        <td style=\" \" class=\"Default\"> 
        </td>


<td style=\"\" class=\"\"><p>BOM </p>
        </td>
        <td style=\" \" class=\"\"><p>$bom_h</p>
        </td>
        <td style=\"\" class=\"\"><p>$bom_m</p>
        </td>
        <td style=\"\" class=\"\"><p>$total_bom</p>
        </td>
        

<tr class=\"\">
        <td style=\" \" class=\"Default\"> 
        </td>

<td style=\"\" class=\"ce3\"><p>TOTAL </p>
        </td><td style=\" \" class=\"ce3\"><p>$total_h</p>
        </td><td style=\"\" class=\"ce3\"><p>$total_m</p>
        </td><td style=\"\" class=\"ce5\"><p>$total_geral</p>
        </td>

</tbody>
</table>


";

        return $retorno;
    }

    /////////////////////////////////





    public function getBodygenero() {
        $excelente_h = $this->getExcelente_h();
        $suficiente_h = $this->getSuficiente_h();
        $bom_h = $this->getBom_h();

        $excelente_m = $this->getExcelente_m();
        $suficiente_m = $this->getSuficiente_m();
        $bom_m = $this->getBom_m();
        $total_ex = $excelente_h + $excelente_m;
        $total_suf = $suficiente_h + $suficiente_m;
        $total_bom = $bom_h + $bom_m;


        $retorno = "
<table class=\"table table-striped table-bordered\">
<caption class=\"text-center\"><h4> ESTATÍSTICA GERAL<br /><br /> NUMERO TOTAL DE NOTAS POR GENERO EM 2015<br />

</h4>
</caption>

<tbody>



</tr>
	<tr class=\"ro2\"><td style=\" \" class=\"Default\">
	 </td>
	<td rowspan=\"2\" style=\" \" class=\"ce2\"><strong>NOTAS </strong></td>
	<td colspan=\"2\" style=\" \" class=\"ce5\"><strong>GENÉRO</strong></td>
	</tr>
	<tr class=\"ro2\">
        <td style=\"\" class=\"Default\"> 
	</td>
	<td style=\" \" class=\"ce5\"><p>M</p></td><td style=\"text-align:left;width:2.258cm; \" class=\"ce5\"><p>F</p>
        </td>
        <td style=\" \" class=\"ce5\"><strong>TOTAL</strong>
        </td>
        </tr>
        <tr class=\"\">
     
<td style=\"\" class=\"\"> 
<td style=\"\" class=\"\"><p>EXCELENTE</p></td><td style=\" \" class=\"\"><p>$excelente_h</p></td>
<td style=\"\" class=\"\"><p>$excelente_m</p>
</td>
<td style=\" \" class=\"\"><p>$total_ex</p>
</td>
     </tr>

<tr class=\"\">
        <td style=\" \" class=\"Default\"> 
        </td>
        
<td style=\"\" class=\"\"><p>SUFICIENTE</p></td>
<td style=\" \" class=\"\"><p>$suficiente_h</p>
        </td>
        <td style=\"\" class=\"\"><p>$suficiente_m</p></td>
        <td style=\" \" class=\"\"><p>$total_suf</p>
        </td>
        <td style=\"\" class=\"\"> 
        </td>
        </tr>
        <tr class=\"\">
        <td style=\" \" class=\"Default\"> 
        </td>


<td style=\"\" class=\"ce3\"><p>BOM </p>
        </td><td style=\" \" class=\"ce3\"><p>$bom_m</p>
        </td><td style=\"\" class=\"ce3\"><p>$bom_h</p>
        </td><td style=\"\" class=\"ce5\"><p>$total_bom</p>
        </td>
        
</tbody>
</table>


";

        return $retorno;
    }

    /////////////////



    public function getBodyMatriculados() {
        $cap_h = $this->getHomem_cap();
        $cepac_h = $this->getHomem_cepac();
        $cepid_h = $this->getHomem_cepid();

        $cap_m = $this->getMulher_cap();
        $cepac_m = $this->getMulher_cepac();
        $cepid_m = $this->getMulher_cepid();

        $total_cap = $cap_h + $cap_m;
        $total_cepac = $cepac_h + $cepac_m;
        $total_cepid = $cepid_h + $cepid_m;

        $total_h = $cap_h + $cepac_h + $cepid_h;
        $total_m = $cap_m + $cepac_m + $cepid_m;
        $total_geral = $total_h + $total_m;


        $retorno = "
<table class=\"table table-striped table-bordered\">
<caption class=\"text-center\"><h4> ESTATÍSTICA GERAL<br /><br /> TOTAL DE ALUNOS MATRICULADOS NO CEAFIE EM 2015<br />

</h4>
</caption>

<tbody>



</tr>
	<tr class=\"ro2\"><td style=\" \" class=\"Default\">
	 </td>
	<td rowspan=\"2\" style=\" \" class=\"ce2\"><p>CURSO </p></td>
	<td colspan=\"2\" style=\" \" class=\"ce5\"><p>GENERO</p></td>
	</tr>
	<tr class=\"ro2\">
        <td style=\"\" class=\"Default\"> 
	</td>
	<td style=\" \" class=\"ce5\"><p>M</p></td><td style=\"text-align:left;width:2.258cm; \" class=\"ce5\"><p>F</p>
        </td>
        <td style=\" \" class=\"ce5\"><p>TOTAL</p>
        </td>
        </tr>
        <tr class=\"\">
     
<td style=\"\" class=\"\"> 
<td style=\"\" class=\"\"><p>CAP</p></td><td style=\" \" class=\"\"><p>$cap_h</p></td>
<td style=\"\" class=\"\"><p>$cap_m</p>
</td>
<td style=\" \" class=\"\"><p>$total_cap</p>
</td>
     </tr>

<tr class=\"\">
        <td style=\" \" class=\"Default\"> 
        </td>
        
<td style=\"\" class=\"\"><p>CEPAC</p></td>
<td style=\" \" class=\"\"><p>$cepac_h</p>
        </td>
        <td style=\"\" class=\"\"><p>$cepac_m</p></td>
        <td style=\" \" class=\"\"><p>$total_cepac</p>
        </td>
        <td style=\"\" class=\"\"> 
        </td>
        </tr>
        <tr class=\"\">
        <td style=\" \" class=\"Default\"> 
        </td>


<td style=\"\" class=\"ce3\"><p>CEPID </p>
        </td><td style=\" \" class=\"ce3\"><p>$cepid_h</p>
        </td><td style=\"\" class=\"ce3\"><p>$cepid_h</p>
        </td><td style=\"\" class=\"ce5\"><p>$total_cepid</p>
        </td>
        
<tr class=\"\">
        <td style=\" \" class=\"Default\"> 
        </td>

<td style=\"\" class=\"ce3\"><p>TOTAL </p>
        </td><td style=\" \" class=\"ce3\"><p>$total_h</p>
        </td><td style=\"\" class=\"ce3\"><p>$total_m</p>
        </td><td style=\"\" class=\"ce5\"><p>$total_geral</p>
        </td>
        
</tbody>
</table>


";

        return $retorno;
    }

    ////////////////////




    public function getBodyMatriculaNoCurso($id = FALSE) {
        $cap_h = $this->getHomem_cap();
        $cap_m = $this->getMulher_cap();


        $total_cap = $cap_h + $cap_m;


        $retorno = "
<table class=\"table table-striped table-bordered\">
<caption class=\"text-center\"><h4> Relatório Gerado pelo Sistema<br /><br /> TOTAL DE ALUNOS MATRICULADOS NO $id EM 2015<br />

</h4>
</caption>

<tbody>



</tr>
	<tr class=\"ro2\"><td style=\" \" class=\"Default\">
	 </td>
	<td rowspan=\"2\" style=\" \" class=\"ce2\"><p>CURSO </p></td>
	<td colspan=\"2\" style=\" \" class=\"ce5\"><p>GENERO</p></td>
	</tr>
	<tr class=\"ro2\">
        <td style=\"\" class=\"Default\"> 
	</td>
	<td style=\" \" class=\"ce5\"><p>M</p></td><td style=\"text-align:left;width:2.258cm; \" class=\"ce5\"><p>F</p>
        </td>
        <td style=\" \" class=\"ce5\"><p>TOTAL</p>
        </td>
        </tr>
        <tr class=\"\">
     
<td style=\"\" class=\"\"> 
<td style=\"\" class=\"\"><p>$id</p></td><td style=\" \" class=\"\"><p>$cap_h</p></td>
<td style=\"\" class=\"\"><p>$cap_m</p>
</td>
<td style=\" \" class=\"\"><p>$total_cap</p>
</td>
     </tr>

        
</tbody>
</table>


";

        return $retorno;
    }

    ////////////////////
    ///////////////////







    public function getFooter() {
        $retorno = "Data: " . date('d/m/Y');
        return $retorno;
    }

    public function getHeader($header = FALSE) {

        $retorno = "<br /><br /><br /><img src='$header' class='img-responsive' style=\"margin-left:200px;\"/>";

        return $retorno;
    }

    public function setarCSS($file = FALSE) {
        if (file_exists($file)):
            $this->css = file_get_contents($file);
        else:
            echo 'Arquivo inexistente!';
        endif;
    }

    public function BuildPDF($body = FALSE, $grafico = FALSE) {
        $this->pdf = new mPDF('utf-8', 'A4-L');
        $this->pdf->WriteHTML($this->css, 1);
        $this->pdf->WriteHTML($body);
        if (isset($grafico) && !empty($grafico)):
            $this->pdf->WriteHTML($this->getHeader($grafico));
        endif;
    }

    public function Exibir($name = null) {
        $this->pdf->Output($name, "I");
    }

    public function AproveitamentoPOrGenero() {
        $body = $this->getBodygenero();
        $this->BuildPDF($body);
    }

    public function AproveitamentoPOrCurso($curso = FALSE) {
        $body = $this->getBodyCurso($curso);
        $this->BuildPDF($body);
    }

    public function MatriculaPOrCurso($curso = FALSE) {
        $body = $this->getBodyMatriculaNoCurso($curso);
        $caminho = "upload/" . $curso;
        $this->BuildPDF($body, $caminho);
    }
    
    public function Matriculados() {
        $body = $this->getBodyMatriculados();
       $this->BuildPDF($body);
    }
    
    
    
   

}
