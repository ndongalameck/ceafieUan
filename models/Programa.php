<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use application\Dao;
use config\Doctrine;

/**
 * Programa
 *
 * @ORM\Table(name="programa", indexes={@ORM\Index(name="fk_programa_modulo1_idx", columns={"modulo_id"}), @ORM\Index(name="fk_programa_docente1_idx", columns={"docente_id"}), @ORM\Index(name="fk_programa_curso1_idx", columns={"curso_id"})})
 * @ORM\Entity
 */
class Programa extends Doctrine implements Dao {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="string", nullable=false)
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="datafinal", type="string", nullable=false)
     */
    private $datafinal;

    /**
     * @var string
     *
     * @ORM\Column(name="local", type="string", length=45, nullable=true)
     */
    private $local;

    /**
     * @var string
     *
     * @ORM\Column(name="hora", type="string", length=45, nullable=true)
     */
    private $hora;

    /**
     * @var \Curso
     *
     * @ORM\ManyToOne(targetEntity="Curso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
     * })
     */
    private $curso;

    /**
     * @var \Docente
     *
     * @ORM\ManyToOne(targetEntity="Docente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="docente_id", referencedColumnName="id")
     * })
     */
    private $docente;

    /**
     * @var \Modulo
     *
     * @ORM\ManyToOne(targetEntity="Modulo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modulo_id", referencedColumnName="id")
     * })
     */
    private $modulo;

    function getId() {
        return $this->id;
    }

    function getData() {
        return $this->data;
    }

    function getLocal() {
        return $this->local;
    }

    function getCurso() {
        return $this->curso;
    }

    function getDocente() {
        return $this->docente;
    }

    function getModulo() {
        return $this->modulo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setLocal($local) {
        $this->local = $local;
    }

    function setCurso(Curso $curso) {
        $this->curso = $curso;
    }

    function getDatafinal() {
        return $this->datafinal;
    }

    function setDatafinal($datafinal) {
        $this->datafinal = $datafinal;
    }

    function setDocente(Docente $docente) {
        $this->docente = $docente;
    }

    function setModulo(Modulo $modulo) {
        $this->modulo = $modulo;
    }

    public function adicionar($dados = FALSE) {
        
    }

    function getHoras() {
        return $this->hora;
    }

    function setHoras($hora) {
        $this->hora = $hora;
    }

    public function adiciona($dados = FALSE, $v) {
        $curso = $this->em->find('models\Curso', $v['curso']);
        $modulo = $this->em->find('models\Modulo', $v['modulo']);
        $docente = $this->em->find('models\Docente', $v['docente']);
        $dados->setCurso($curso);
        $dados->setModulo($modulo);
        $dados->setDocente($docente);
        $this->em->persist($dados);
        $this->em->flush();
        return $dados->getId();
    }

    public function editar($id = FALSE) {
        
    }

    public function editar1($d = FALSE, $v = FALSE) {
        //  var_dump($v);
//        $curso = $this->em->find('models\Curso', $v['curso']);
//        $modulo = $this->em->find('models\Modulo', $v['modulo']);
//        $docente = $this->em->find('models\Docente', $v['docente']);
        $editar = $this->em->getRepository('models\Programa')->find(array('id' => $v['id']));
        //\Doctrine\Common\Util\Debug::dump($editar); exit;
//        $editar->setCurso($curso);
//        $editar->setModulo($modulo);
//        $editar->setDocente($docente);
        $editar->setData($d->getData());
        $editar->setDatafinal($d->getDatafinal());
        $editar->setLocal($d->getLocal());
        $editar->setHoras($d->getHoras());
        $this->em->merge($editar);
        $this->em->flush();
        return TRUE;
    }

    public function pesquisaPor($dados = FALSE) {
        
    }

    public function pesquisar($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Programa')->findOneBy(array('id' => $id));
            $this->em->flush();
        } else {
            return $this->em->getRepository('models\Programa')->findby(array(), array('id' => "DESC"));
            $this->em->flush();
        }
    }

    public function remover($id = FALSE) {
        $id = $this->em->getPartialReference('models\Programa', $id);
        $this->em->remove($id);
        $this->em->flush();
        return TRUE;
    }

}
