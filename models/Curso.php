<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
use application\Dao;
use config\Doctrine;
/**
 * Curso
 *
 * @ORM\Table(name="curso")
 * @ORM\Entity
 */
class Curso extends Doctrine implements Dao {
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
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
     */
    private $descricao;
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;
    function getNome() {
        return $this->nome;
    }
    function setNome($nome) {
        $this->nome = $nome;
    }
    function getId() {
        return $this->id;
    }
    function getDescricao() {
        return $this->descricao;
    }
    function setId($id) {
        $this->id = $id;
    }
    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    public function adicionar($dados = FALSE) {
        $this->em->persist($dados);
        $this->em->flush();
        return TRUE;
    }
    public function editar($id = FALSE) {
        $editar = $this->em->getRepository('models\Curso')->find(array('id' => $id->getId()));
        $editar->setNome($id->getNome());
        $editar->setDescricao($id->getDescricao());
        $this->em->flush();
        return TRUE;
    }
    public function pesquisaPor($dados = FALSE) {
        
    }
    public function pesquisar($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Curso')->findOneBy(array('id' => $id));
            $this->em->flush();
        } else {
            return $this->em->getRepository('models\Curso')->findby(array(), array('id' => "DESC"));
            $this->em->flush();
        }
    }
    public function pesquisarCurso($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Curso')->findOneBy(array('nome' => $id));
            $this->em->flush();
            return true;
        }
    }
    public function remover($id = FALSE) {
        $id = $this->em->getPartialReference('models\Curso', $id);
        $this->em->remove($id);
        $this->em->flush();
        return TRUE;
    }
    
    public function listagem() {
        $t = $this->em->getRepository('models\Curso');
        $qb = $t->createQueryBuilder('e');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}