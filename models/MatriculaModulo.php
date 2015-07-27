<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use application\Dao;
use config\Doctrine;
use \Doctrine\Common\Util\Debug;

/**
 * MatriculaModulo
 *
 * @ORM\Table(name="matricula_modulo", indexes={@ORM\Index(name="fk_matricula_modulo_matricula1_idx", columns={"matricula_id"}), @ORM\Index(name="fk_matricula_modulo_modulo1_idx", columns={"modulo_id"})})
 * @ORM\Entity
 */
class MatriculaModulo extends Doctrine {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Matricula
     *
     * @ORM\ManyToOne(targetEntity="Matricula")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="matricula_id", referencedColumnName="id")
     * })
     */
    private $matricula;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="string", length=45, nullable=false)
     */
    private $data;

    /**
     * @var Modulo
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

    function getMatricula() {
        return $this->matricula;
    }

    function getModulo() {
        return $this->modulo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setMatricula(Matricula $matricula) {
        $this->matricula = $matricula;
    }

    function setModulo(Modulo $modulo) {
        $this->modulo = $modulo;
    }

    function getData() {
        return $this->data;
    }

    function setData($data) {
        $this->data = $data;
    }

    public function adiciona($id, $dados) {
        $m = $this->em->getRepository('models\Matricula')->findOneBy(array('id' => $id));
        $modulo = $this->em->getRepository('models\Modulo')->findOneBy(array('id' => $dados['modulo']));
        $this->setMatricula($m);
        $this->setModulo($modulo);
        $this->setData($dados['data']);
        $this->em->persist($this);
        $this->em->flush();
        return $this->getId();
    }

    function pesquisar($dados,$modulo) {
        return $this->em->getRepository('models\MatriculaModulo')->findOneBy(array('matricula' => $dados,'modulo'=>$modulo));
        $this->em->flush();
    }
    
       function pesquisarImprimi($id,$data) {
        return $this->em->getRepository('models\MatriculaModulo')->findOneBy(array('matricula' => $id,'data'=>$data));
        $this->em->flush();
    }

    function pesquisarPor($matricula) {
        return $this->em->getRepository('models\MatriculaModulo')->findBy(array('matricula' => $matricula),array('id'=>'DESC'));
        $this->em->flush();
    }

}
