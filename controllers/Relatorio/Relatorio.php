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

namespace controllers;

use application\Controller;
use PHPlot;
use application\Session;

class Relatorio extends Controller {

    private $nota;

    public function __construct() {
        Session::nivelRestrito(array("gestor"));
        $this->nota = $this->LoadModelo('Nota');
        parent::__construct();
        $this->view->setCss(array('amaran.min', 'animate.min', 'layout', 'ie'));
        $this->view->setJs(array('novo', 'RGraph.bar', 'RGraph.common.core'));
        $this->view->menu = $this->getFooter('menu');
    }

    public function index() {

        $dados = $_POST;
        if (!$this->getInt('enviar')) {
            $this->view->renderizar("index");
            exit;
        }

        switch ($dados['opcao']) {
            case 'geral': $this->Matriculados();
                break;
            case 'CAP': $this->MatriculaPOrCurso($dados['opcao']);
                break;
            case 'CEPAC': $this->MatriculaPOrCurso($dados['opcao']);
                break;
            case 'CEPID': $this->MatriculaPOrCurso($dados['opcao']);
                break;
            default : $this->view->erro = "Escolha uma das opções";
                $this->view->renderizar("index");
                break;
        }
    }

    public function aproveitamentoGrafico() {

        $dados = $_POST;
        if (!$this->getInt('enviar')) {
            $this->view->renderizar("index1");
            exit;
        }

        switch ($dados['opcao']) {
            case 'geral': $this->aproveitamento();
                break;
            case 'CAP': $this->AproveitamentoPOrCurso($dados['opcao']);
                break;
            case 'CEPAC': $this->AproveitamentoPOrCurso($dados['opcao']);
                break;
            case 'CEPID': $this->AproveitamentoPOrCurso($dados['opcao']);
                break;
            default : $this->view->erro = "Escolha uma das opções";
                $this->view->renderizar("index1");
                break;
        }
    }

    public function graficoGeral() {

        $total = $this->nota->totalAlunos();
        $this->view->cap = $this->nota->pesquisaCurso("CAP") / ($total == 0 ? 1 : $total);
        $this->view->cepac = $this->nota->pesquisaCurso("CEPAC") / ($total == 0 ? 1 : $total);
        $this->view->cepid = $this->nota->pesquisaCurso("CEPID") / ($total == 0 ? 1 : $total);
        $this->view->excelente = $this->nota->buscarNota(array("nota" => "Excelente")) / ($total == 0 ? 1 : $total);
        $this->view->bom = $this->nota->buscarNota(array("nota" => "Bom")) / ($total == 0 ? 1 : $total);
        $this->view->suficiente = $this->nota->buscarNota(array("nota" => "Suficiente")) / ($total == 0 ? 1 : $total);
        $this->view->total = $this->view->cap + $this->view->cepac + $this->view->cepid;
        $this->view->total1 = $this->view->excelente + $this->view->bom;
        $this->view->renderizar("index2");
    }

    public function grafico($dados = FALSE) {

        $dado = array(
            array('Homens', $dados['homem']),
            array('Mulheres', $dados['mulher']),
                // array('Total de Alunos', $dados['homem'] + $dados['mulher']),
        );


// cria um objeto
        $MeuGrafico = new PHPlot(600, 400);

        $MeuGrafico->SetImageBorderType('plain');
        $MeuGrafico->SetPlotType('pie');
        $MeuGrafico->SetDataType('text-data-single');
        $MeuGrafico->SetDataValues($dado);
        $MeuGrafico->SetDataColors(array('red', 'green', 'blue', 'yellow', 'cyan',
            'magenta', 'brown', 'lavender', 'pink',
            'gray', 'orange'));
        $MeuGrafico->SetTitle("World Gold Production, 1990\n(1000s of Troy Ounces)");
        foreach ($dado as $row)
            $MeuGrafico->SetLegend(implode(': ', $row));
        $MeuGrafico->SetLegendPixels(5, 5);

// define o formato do arquivo da imagem
        $MeuGrafico->SetFileFormat("png");
// Define a fonte Padrão, nesse caso o arquivo ttf está no mesmo diretório
        $MeuGrafico->SetDefaultTTFont('public/fonte/Arial.ttf');
// define se as barras serão em 3D, valor 0 Imagem chamada
        $MeuGrafico->SetShading(1);
// definição do titulo do gráfico
// por questão da acentuação utilizar a função utf8_decode
        $titulo = utf8_decode("Alunos Matriculado no " . $dados['curso'] . " no Ano de 2015");

// chamada do titulo definindo o tamanho da fonte
//foi definido null no segundo parametro pois o tipo de fonte foi setado anteriomente 
// Setar o titulo definido na varieavel $titulo anteriomente
        $MeuGrafico->SetTitle($titulo);



//Por padrão é setado "marcas" das escalas do eixo x, none retira estas marcas.
        $MeuGrafico->SetXTickPos('none');

//ignora a saida para o browser e permite a saida em arquivo
        $MeuGrafico->SetIsInline(true);

//chama a saida para arquivo, no caso aqui no diretorio corrente
        $caminho = "upload/" . $dados['curso'];
        $MeuGrafico->SetOutputFile($caminho);

// desenha o grafico
        $MeuGrafico->DrawGraph();
    }

    public function imprimirAproveitamento() {

        $homem_excelente = array("genero" => "masculino", "nota" => "Excelente");
        $homem_bom = array("genero" => "masculino", "nota" => "Bom");
        $homem_suficiente = array("genero" => "masculino", "nota" => "Suficiente");
        //
        $mulher_excelente = array("genero" => "femenino", "nota" => "Excelente");
        $mulher_bom = array("genero" => "femenino", "nota" => "Bom");
        $mulher_suficiente = array("genero" => "femenino", "nota" => "Suficiente");


        $excelente_h = $this->nota->pesquisarNotas($homem_excelente);
        $bom_h = $this->nota->pesquisarNotas($homem_bom);
        $suficiente_h = $this->nota->pesquisarNotas($homem_suficiente);
//
        $excelente_m = $this->nota->pesquisarNotas($mulher_excelente);
        $bom_m = $this->nota->pesquisarNotas($mulher_bom);
        $suficiente_m = $this->nota->pesquisarNotas($mulher_suficiente);



        //$this->index();
        $css = "views/layout/default/bootstrap/css/bootstrap.min.css";
        $report = new \application\Relatorio($css, 'GERAL');
        /////

        $report->setBom_h($bom_h);
        $report->setExcelente_h($excelente_h);
        $report->setSuficiente_h($suficiente_h);
        //
        $report->setBom_m($bom_m);
        $report->setExcelente_m($excelente_m);
        $report->setSuficiente_m($suficiente_m);
        //
        $report->AproveitamentoPOrGenero();
        $report->Exibir();
    }

    public function aproveitamento() {

        $homem_excelente = array("genero" => "masculino", "nota" => "Excelente");
        $homem_bom = array("genero" => "masculino", "nota" => "Bom");
        $homem_suficiente = array("genero" => "masculino", "nota" => "Suficiente");
        //
        $mulher_excelente = array("genero" => "femenino", "nota" => "Excelente");
        $mulher_bom = array("genero" => "femenino", "nota" => "Bom");
        $mulher_suficiente = array("genero" => "femenino", "nota" => "Suficiente");


        $excelente_h = $this->nota->pesquisarNotas($homem_excelente);
        $bom_h = $this->nota->pesquisarNotas($homem_bom);
        $suficiente_h = $this->nota->pesquisarNotas($homem_suficiente);
//
        $excelente_m = $this->nota->pesquisarNotas($mulher_excelente);
        $bom_m = $this->nota->pesquisarNotas($mulher_bom);
        $suficiente_m = $this->nota->pesquisarNotas($mulher_suficiente);
        $total_ex = $excelente_h + $excelente_m;
        $total_suf = $suficiente_h + $suficiente_m;
        $total_bom = $bom_h + $bom_m;

        $dados = array("excelente_h" => $excelente_h,
            "bom_h" => $bom_h,
            'suficiente_h' => $suficiente_h,
            'excelente_m' => $excelente_m,
            'bom_m' => $bom_m,
            'suficiente_m' => $suficiente_m,
            'total_ex' => $total_ex,
            'total_suf' => $total_suf,
            'total_bom' => $total_bom
        );

        $this->view->dados = $dados;
        $this->view->renderizar('index1');
    }

    public function imprimirAproveitamentoPOrCurso($id = FALSE) {


        $homem_excelente_cap = array("genero" => "masculino", "nota" => "Excelente", "curso" => $id);
        $homem_bom_cap = array("genero" => "masculino", "nota" => "Bom", "curso" => $id);
        $homem_suficiente_cap = array("genero" => "masculino", "nota" => "Suficiente", "curso" => $id);
        //
        $mulher_excelente_cap = array("genero" => "femenino", "nota" => "Excelente", "curso" => $id);
        $mulher_bom_cap = array("genero" => "femenino", "nota" => "Bom", "curso" => "CAP");
        $mulher_suficiente_cap = array("genero" => "femenino", "nota" => "Suficiente", "curso" => $id);



        $excelente_h_cap = $this->nota->pesquisarNotasCurso($homem_excelente_cap);
        $bom_h_cap = $this->nota->pesquisarNotasCurso($homem_bom_cap);
        $suficiente_h_cap = $this->nota->pesquisarNotasCurso($homem_suficiente_cap);
//
        $excelente_m_cap = $this->nota->pesquisarNotasCurso($mulher_excelente_cap);
        $bom_m_cap = $this->nota->pesquisarNotasCurso($mulher_bom_cap);
        $suficiente_m_cap = $this->nota->pesquisarNotasCurso($mulher_suficiente_cap);
////////////////
        $css = "views/layout/default/bootstrap/css/bootstrap.min.css";
        $report = new \application\Relatorio($css, 'GERAL');
        $report->setBom_h($bom_h_cap);
        $report->setExcelente_h($excelente_h_cap);
        $report->setSuficiente_h($suficiente_h_cap);
        //
        $report->setBom_m($bom_m_cap);
        $report->setExcelente_m($excelente_m_cap);
        $report->setSuficiente_m($suficiente_m_cap);
        //
        $report->AproveitamentoPOrCurso($id);
        $report->Exibir();
    }

    public function AproveitamentoPOrCurso($id = FALSE) {


        $homem_excelente_cap = array("genero" => "masculino", "nota" => "Excelente", "curso" => $id);
        $homem_bom_cap = array("genero" => "masculino", "nota" => "Bom", "curso" => $id);
        $homem_suficiente_cap = array("genero" => "masculino", "nota" => "Suficiente", "curso" => $id);
        //
        $mulher_excelente_cap = array("genero" => "femenino", "nota" => "Excelente", "curso" => $id);
        $mulher_bom_cap = array("genero" => "femenino", "nota" => "Bom", "curso" => "CAP");
        $mulher_suficiente_cap = array("genero" => "femenino", "nota" => "Suficiente", "curso" => $id);



        $excelente_h_cap = $this->nota->pesquisarNotasCurso($homem_excelente_cap);
        $bom_h_cap = $this->nota->pesquisarNotasCurso($homem_bom_cap);
        $suficiente_h_cap = $this->nota->pesquisarNotasCurso($homem_suficiente_cap);
//
        $excelente_m_cap = $this->nota->pesquisarNotasCurso($mulher_excelente_cap);
        $bom_m_cap = $this->nota->pesquisarNotasCurso($mulher_bom_cap);
        $suficiente_m_cap = $this->nota->pesquisarNotasCurso($mulher_suficiente_cap);

        $total_ex = $excelente_h_cap + $excelente_m_cap;
        $total_suf = $suficiente_h_cap + $suficiente_m_cap;
        $total_bom = $bom_h_cap + $bom_m_cap;
        $total_h = $excelente_h_cap + $bom_h_cap + $suficiente_h_cap;
        $total_m = $excelente_m_cap + $bom_m_cap + $suficiente_m_cap;
        $total_geral = $total_h + $total_m;

        $dados = array(
            "excelente_h_cap" => $excelente_h_cap,
            'bom_h_cap' => $bom_h_cap,
            'suficiente_h_cap' => $suficiente_h_cap,
            'excelente_m_cap' => $excelente_m_cap,
            'bom_m_cap' => $bom_m_cap,
            'suficiente_m_cap' => $suficiente_m_cap,
            'total_bom' => $total_bom,
            'total_ex' => $total_ex,
            'total_suf' => $total_suf,
            'total_h' => $total_h,
            'total_m' => $total_m,
            'total_geral' => $total_geral,
            'id' => $id
        );

        $this->view->aproveitamento = $dados;
        $this->view->renderizar('index1');
    }

////////////




    public function Matriculados() {


        $homem_cap = array("genero" => "masculino", "curso" => "CAP");
        $homem_cepac = array("genero" => "masculino", "curso" => "CEPAC");
        $homem_cepid = array("genero" => "masculino", "curso" => "CEPID");
        //
        $mulher_cap = array("genero" => "femenino", "curso" => "CAP");
        $mulher_cepac = array("genero" => "femenino", "curso" => "CEPAC");
        $mulher_cepid = array("genero" => "femenino", "curso" => "CEPID");


        $h_cap = $this->nota->pesquisaGenero($homem_cap);
        $h_cepac = $this->nota->pesquisaGenero($homem_cepac);
        $h_cepid = $this->nota->pesquisaGenero($homem_cepid);
//
        $m_cap = $this->nota->pesquisaGenero($mulher_cap);
        $m_cepac = $this->nota->pesquisaGenero($mulher_cepac);
        $m_cepid = $this->nota->pesquisaGenero($mulher_cepid);
////////////////

        $total_cap = $h_cap + $m_cap;
        $total_cepac = $h_cepac + $m_cepac;
        $total_cepid = $h_cepid + $m_cepid;

        $total_h = $h_cap + $h_cepac + $h_cepid;
        $total_m = $m_cap + $m_cepac + $m_cepid;
        $total_geral = $total_h + $total_m;

        $this->view->mt = array(
            'h_c' => $h_cap,
            'm_c' => $m_cap,
            'm_cepac' => $m_cepac,
            'h_cepac' => $h_cepac,
            'h_cepid' => $h_cepid,
            'm_cepid' => $m_cepid,
            'total_cap' => $total_cap,
            'total_cepac' => $total_cepac,
            'total_cepid' => $total_cepid,
            'total_h' => $total_h,
            'total_m' => $total_m,
            'total_geral' => $total_geral
        );
        $this->view->renderizar('index');
    }

    //matriculados imprimir todos 

    public function matriculadosImprimir() {


        $homem_cap = array("genero" => "masculino", "curso" => "CAP");
        $homem_cepac = array("genero" => "masculino", "curso" => "CEPAC");
        $homem_cepid = array("genero" => "masculino", "curso" => "CEPID");
        //
        $mulher_cap = array("genero" => "femenino", "curso" => "CAP");
        $mulher_cepac = array("genero" => "femenino", "curso" => "CEPAC");
        $mulher_cepid = array("genero" => "femenino", "curso" => "CEPID");


        $h_cap = $this->nota->pesquisaGenero($homem_cap);
        $h_cepac = $this->nota->pesquisaGenero($homem_cepac);
        $h_cepid = $this->nota->pesquisaGenero($homem_cepid);
//
        $m_cap = $this->nota->pesquisaGenero($mulher_cap);
        $m_cepac = $this->nota->pesquisaGenero($mulher_cepac);
        $m_cepid = $this->nota->pesquisaGenero($mulher_cepid);
////////////////


        $css = "views/layout/default/bootstrap/css/bootstrap.min.css";
        $report = new \application\Relatorio($css, 'GERAL');
        //
        $report->setHomem_cap($h_cap);
        $report->setHomem_cepac($h_cepac);
        $report->setHomem_cepid($h_cepid);

        $report->setMulher_cap($m_cap);
        $report->setMulher_cepac($m_cepac);
        $report->setMulher_cepid($m_cepid);


//
        $report->Matriculados();
        $report->Exibir();
    }

    //gerar tabela html na pagina
    public function MatriculaPOrCurso($id = FALSE) {


        $homem_cap = array("genero" => "masculino", "curso" => $id);
        //
        $mulher_cap = array("genero" => "femenino", "curso" => $id);


        $h_cap = $this->nota->pesquisaGenero($homem_cap);

        $m_cap = $this->nota->pesquisaGenero($mulher_cap);


        $this->view->matricula = array('h_c' => $h_cap, 'm_c' => $m_cap, 'total' => $h_cap + $m_cap, 'curso' => $id);

        $this->view->renderizar('index');
    }

    //imprimir alunos matriculados por curso
    public function MatriculaPOrCursoImprimir($id = FALSE) {


        $homem_cap = array("genero" => "masculino", "curso" => $id);
        $homem_cepac = array("genero" => "masculino", "curso" => $id);
        $homem_cepid = array("genero" => "masculino", "curso" => $id);
        //
        $mulher_cap = array("genero" => "femenino", "curso" => $id);
        $mulher_cepac = array("genero" => "femenino", "curso" => $id);
        $mulher_cepid = array("genero" => "femenino", "curso" => $id);


        $h_cap = $this->nota->pesquisaGenero($homem_cap);
        $h_cepac = $this->nota->pesquisaGenero($homem_cepac);
        $h_cepid = $this->nota->pesquisaGenero($homem_cepid);
//
        $m_cap = $this->nota->pesquisaGenero($mulher_cap);
        $m_cepac = $this->nota->pesquisaGenero($mulher_cepac);
        $m_cepid = $this->nota->pesquisaGenero($mulher_cepid);
////////////////


        $css = "views/layout/default/bootstrap/css/bootstrap.min.css";
        $report = new \application\Relatorio($css, 'GERAL');
        //
        $report->setHomem_cap($h_cap);
        $report->setHomem_cepac($h_cepac);
        $report->setHomem_cepid($h_cepid);

        $report->setMulher_cap($m_cap);
        $report->setMulher_cepac($m_cepac);
        $report->setMulher_cepid($m_cepid);


//           
        $dados = array("homem" => $h_cap, "mulher" => $m_cap, "curso" => $id);

        $this->grafico($dados);

        $report->MatriculaPOrCurso($id);
        $report->Exibir();
    }

}
