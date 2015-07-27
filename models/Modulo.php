<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use application\Dao;
use config\Doctrine;

/**
 * Modulo
 *
 * @ORM\Table(name="modulo", indexes={@ORM\Index(name="fk_modulo_materia1_idx", columns={"materia_id"})})
 * @ORM\Entity
 */
class Modulo extends Doctrine implements Dao {

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
     * @ORM\Column(name="nome", type="string", length=30, nullable=false)
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

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getCurso() {
        return $this->curso;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCurso(Curso $curso) {
        $this->curso = $curso;
    }

    public function adicionar($dados = FALSE) {
        
    }

    public function adiciona($dados = FALSE, $valor = False) {
        $curso = $this->em->getRepository('models\Curso')->find(array('id' => $valor['curso']));
        $dados->setCurso($curso);
        $this->em->persist($dados);
        $this->em->flush();
        return TRUE;
    }

    public function editar($id = FALSE) {
        $editar = $this->em->getRepository('models\Modulo')->find(array('id' => $id->getId()));
        $editar->setNome($id->getNome());
        $this->em->flush();
        return TRUE;
    }

    public function pesquisaPor($dados = FALSE) {
        if ($dados) {
            return $this->em->getRepository('models\Modulo')->findOneBy(array('id' => $dados));
            $this->em->flush();
        }
    }

    public function pesquisar($id = FALSE) {
        if ($id) {
            $qb = $this->em->createQueryBuilder()
                    ->select('e.id,e.nome,c.nome as nome1')
                    ->from('models\Modulo', 'e')
                    ->innerJoin('models\Curso', 'c', 'WITH', 'e.curso=c.id')
                    ->where('e.curso = ?1')
                    ->setParameter(1, $id);
            return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        } else {
            return $this->em->getRepository('models\Modulo')->findby(array(), array('id' => "DESC"));
            $this->em->flush();
        }
    }

    public function remover($id = FALSE) {
        $id = $this->em->getPartialReference('models\Modulo', $id);
        $this->em->remove($id);
        $this->em->flush();
        return TRUE;
    }

    function listagem() {
        $t = $this->em->getRepository('models\Modulo');
        $qb = $t->createQueryBuilder('e');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function pesquisa($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Modulo')->findOneBy(array('aluno' => $id));
            $this->em->flush();
        } else {
            return $this->em->getRepository('models\Modulo')->findby(array(), array('id' => "DESC"));
            $this->em->flush();
        }
    }

    public function pesquisa1($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Modulo')->findOneBy(array('id' => $id));
            $this->em->flush();
        } else {
            return $this->em->getRepository('models\Modulo')->findby(array(), array('id' => "DESC"));
            $this->em->flush();
        }
    }
    
    
        public function pesquisarModulo($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Modulo')->findOneBy(array('nome' => $id));
            $this->em->flush();
            return true;
        }
    }

}
