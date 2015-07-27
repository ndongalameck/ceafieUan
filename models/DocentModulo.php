<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use application\Dao;
use config\Doctrine;
use \Doctrine\Common\Util\Debug;

/**
 * DocentModulo
 *
 * @ORM\Table(name="docentmodulo", indexes={@ORM\Index(name="fk_docente_has_modulo_modulo1_idx", columns={"modulo_id"}), @ORM\Index(name="fk_docente_has_modulo_docente1_idx", columns={"docente_id"})})
 * @ORM\Entity
 */
class DocentModulo extends Doctrine implements Dao {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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

    function getDocente() {
        return $this->docente;
    }

    function getModulo() {
        return $this->modulo;
    }

    function setDocente(Docente $docente) {
        $this->docente = $docente;
    }

    function setModulo(Modulo $modulo) {
        $this->modulo = $modulo;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    public function adicionar($dados = FALSE) {
        
    }

    public function adiciona($id, $dados) {
        $batchSize = 5;

        if (is_array($dados)) {
            for ($i = 0; $i < count($dados); ++$i) {
                $docente = $this->em->getRepository('models\Docente')->findOneBy(array('id' => $id));
                $modulo = $this->em->getRepository('models\Modulo')->findOneBy(array('id' => $dados[$i]));
                $md = new DocentModulo();
                $md->setDocente($docente);
                $md->setModulo($modulo);
                $this->em->persist($md);
                $this->em->flush();

                if (($i % $batchSize) == 0) {
                    $this->em->flush();
                    $this->em->clear();
                }
            }
        } else {
            $docente = $this->em->getRepository('models\Docente')->findOneBy(array('id' => $id));
            $modulo = $this->em->getRepository('models\Modulo')->findOneBy(array('id' => $dados));
            $this->setDocente($docente);
            $this->setModulo($modulo);
            $this->em->persist($this);
            $this->em->flush();
            return $this->getId();
        }
    }

    public function editar($id = FALSE) {
        
    }

    public function pesquisaPor($dados = FALSE) {

        $qb = $this->em->createQueryBuilder()
                ->select('p.nome', 'p.bi', 'n.nota')
                ->from('models\Matricula', 'm')
                ->innerJoin('models\Aluno', 'a', 'WITH', 'm.aluno=a.id')
                ->innerJoin('models\Pessoa', 'p', 'WITH', 'a.pessoa=p.id')
                ->innerJoin('models\Nota', 'n', 'WITH', 'a.id=n.aluno')
                ->innerJoin('models\MatriculaModulo', 'md', 'WITH', 'm.id=md.matricula')
                ->andWhere("md.modulo =:modulo")
                ->andWhere('m.data LIKE :data')
                ->andWhere('n.nota=:nota')
                ->setParameter('data', '%' . $dados['ano'])
                ->setParameter('modulo', $dados['modulo'])
                ->setParameter('nota', 'NULL')
                ->orderBy('m.id', 'DESC');

        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function pesquisar($id = FALSE) {
        $qb = $this->em->createQueryBuilder()
                ->select('m.nome')
                ->from('models\DocentModulo', 'd')
                ->innerJoin('models\Modulo', 'm', 'WITH', 'd.modulo=m.id')
                ->innerJoin('models\Curso', 'c', 'WITH', 'm.curso=c.id')
                ->andWhere('d.docente =:id')
                ->setParameter(':id', $id)
                ->orderBy('d.id', 'DESC');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function pesquisarCurso($id = FALSE) {
        $qb = $this->em->createQueryBuilder()
                ->select('m.nome', 'p.nome', 'dc.grau','p.bi')
                ->from('models\DocentModulo', 'd')
                ->innerJoin('models\Modulo', 'm', 'WITH', 'd.modulo=m.id')
                ->innerJoin('models\Curso', 'c', 'WITH', 'm.curso=c.id')
                ->innerJoin('models\Docente', 'dc', 'WITH', 'd.docente=dc.id')
                ->innerJoin('models\Pessoa', 'p', 'WITH', 'dc.pessoa=p.id')
                ->andWhere('m.curso =:id')
                ->setParameter(':id', $id)
                ->orderBy('d.id', 'DESC');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function remover($id = FALSE) {
        
    }

    function pesquisarPor($docente) {
        return $this->em->getRepository('models\DocentModulo')->findBy(array('docente' => $docente));
        $this->em->flush();
    }

    public function listagem($id) {

        $qb = $this->em->createQueryBuilder()
                ->select('m.id', 'm.nome')
                ->from('models\Modulo', 'm')
                ->innerJoin('models\DocentModulo', 'dm', 'WITH', 'm.id=dm.modulo')
                ->andWhere('dm.docente =:id')
                ->setParameter('id', $id);
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}
