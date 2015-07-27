<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
use config\Doctrine;
use application\Dao;
/**
 * Materia
 *
 * @ORM\Table(name="materia", indexes={@ORM\Index(name="fk_materia_curso1_idx", columns={"curso_id"}), @ORM\Index(name="fk_materia_modulo1_idx", columns={"modulo_id"}), @ORM\Index(name="fk_materia_docente1_idx", columns={"docente_id"})})
 * @ORM\Entity
 */
class Materia extends Doctrine implements Dao {
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
     * @ORM\Column(name="data", type="string", length=45, nullable=false)
     */
    private $data;
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=200, nullable=false)
     */
    private $nome;
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
    function getNome() {
        return $this->nome;
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
    function setNome($nome) {
        $this->nome = $nome;
    }
    function setCurso(Curso $curso) {
        $this->curso = $curso;
    }
    function setDocente(Docente $docente) {
        $this->docente = $docente;
    }
    function setModulo(Modulo $modulo) {
        $this->modulo = $modulo;
    }
    public function adicionar($dados = FALSE) {
        
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
        return TRUE;
    }
    public function editar($id = FALSE) {
        
    }
    public function pesquisaPor($dados = FALSE) {
        return $this->em->getRepository('models\Materia')->findBy(array('curso' => $dados['0'], 'modulo' => $dados['1']));
        $this->em->flush();
    }
    public function pesquisar($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Materia')->findBy(array('id' => $id));
            $this->em->flush();
        } else {
            return $this->em->getRepository('models\Materia')->findby(array(), array('id' => "DESC"));
            $this->em->flush();
        }
    }
//    Materia do aluno
    public function pesquisarMateriaAluno($id = FALSE) {
        return $this->em->getRepository('models\Materia')->findBy(array('modulo' => $id));
        $this->em->flush();
    }
    public function buscaAluno($id = FALSE) {
        return $this->em->getRepository('models\Aluno')->findBy(array('pessoa' => $id));
        $this->em->flush();
    }
    public function remover($id = FALSE) {
        
    }
    
    
        public function pesquisarNome($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Materia')->findOneBy(array('nome' => $id));
            $this->em->flush();
           
        } 
    }
}