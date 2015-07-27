<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use application\Dao;
use config\Doctrine;
use \Doctrine\Common\Util\Debug;

/**
 * Matricula
 *
 * @ORM\Table(name="matricula", indexes={@ORM\Index(name="fk_matricula_aluno1_idx", columns={"aluno_id"}),})
 * @ORM\Entity
 */
class Matricula extends Doctrine implements Dao {

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
     * @ORM\Column(name="estado", type="string", length=45, nullable=false)
     */
    private $estado;

    /**
     * @var \Aluno
     *
     * @ORM\ManyToOne(targetEntity="Aluno")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aluno_id", referencedColumnName="id")
     * })
     */
    private $aluno;

    function getId() {
        return $this->id;
    }

    function getData() {
        return $this->data;
    }

    function getEstado() {
        return $this->estado;
    }

    function getAluno() {
        return $this->aluno;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setAluno(Aluno $aluno) {
        $this->aluno = $aluno;
    }

    public function adicionar($dados = FALSE) {
        
    }

    public function adiciona($pessoa, $aluno, $matricula, $usuario, $dados) {

        $this->em->getConnection()->beginTransaction();

        try {

            $this->em->persist($pessoa);
            $this->em->flush();
            $pessoa1 = $this->em->getRepository('models\Pessoa')->findOneBy(array('id' => $pessoa->getId()));
            $aluno->setPessoa($pessoa1);
            $this->em->persist($aluno);
            $this->em->flush();
            $aluno1 = $this->em->getRepository('models\Aluno')->findOneBy(array('id' => $aluno->getId()));
            $matricula->setAluno($aluno1);
            $this->em->persist($matricula);
            $this->em->flush();

//adicionar aluno em curso
            $md = new MatriculaModulo();

            $m = $this->em->getRepository('models\Matricula')->findOneBy(array('id' => $matricula->getId()));
            $modulo = $this->em->getRepository('models\Modulo')->findOneBy(array('id' => $dados));
            $md->setMatricula($m);
            $md->setModulo($modulo);
            $md->setData($matricula->getData());
            $this->em->persist($md);

            $this->em->flush();


            $usuario->setPessoa($pessoa1);
            $this->em->merge($usuario);
            $this->em->flush();

            $this->em->getConnection()->commit();
            return $matricula->getId();
        } catch (Exception $ex) {
            $this->em->getConnection()->rollback();
            $this->em->close();
            throw $ex;
        }
    }

    public function editar($id = FALSE) {
        $editar = $this->em->getRepository('models\Matricula')->findOneBy(array('aluno' => $id->getId()));
        $editar->setEstado($id->getEstado());
        $this->em->flush();
        return TRUE;
    }

    public function pesquisaPor($dados = FALSE) {
        $qb = $this->em->createQueryBuilder()
                ->select('n.nota', 'p.nome', 'a.id')
                ->from('models\Matricula', 'm')
                ->innerJoin('models\Aluno', 'a', 'WITH', 'm.aluno=a.id')
                ->innerJoin('models\Pessoa', 'p', 'WITH', 'a.pessoa=p.id')
                ->leftJoin('models\Nota', 'n', 'WITH', 'n.aluno=a.id')
                ->andWhere('m.modulo =:modulo')
                ->andWhere('m.estado =:estado')
                ->orderBy('a.id', 'DESC')
                ->setParameter('modulo', $dados['modulo'])
                ->setParameter('estado', $dados['estado']);
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function pesquisaPorData($ano = FALSE, $modulo = FALSE) {

        if ($ano && $modulo) {
            $qb = $this->em->createQueryBuilder()
                    ->select('p.nome', 'p.bi', 'p.id as pessoa', 'm.estado', 'm.data', 'm.id', 'a.id as aluno')
                    ->from('models\Matricula', 'm')
                    ->innerJoin('models\Aluno', 'a', 'WITH', 'm.aluno=a.id')
                    ->innerJoin('models\Pessoa', 'p', 'WITH', 'a.pessoa=p.id')
                    ->innerJoin('models\MatriculaModulo', 'md', 'WITH', 'm.id=md.matricula')
                    ->andWhere("md.modulo =:modulo")
                    ->andWhere('m.data LIKE :data')
                    ->setParameter('data', '%' . $ano)
                    ->setParameter('modulo', $modulo)
                    ->orderBy('m.id', 'DESC');

            return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        } else {
            $qb = $this->em->createQueryBuilder()
                    ->select('p.nome', 'p.bi', 'p.id as pessoa', 'm.estado', 'm.data', 'm.id', 'a.id as aluno')
                    ->from('models\Matricula', 'm')
                    ->innerJoin('models\Aluno', 'a', 'WITH', 'm.aluno=a.id')
                    ->innerJoin('models\Pessoa', 'p', 'WITH', 'a.pessoa=p.id')
                    ->orderBy('m.id', 'DESC');
            return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        }
    }

    public function pesquisar($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Matricula')->findOneBy(array('aluno' => $id));
            $this->em->flush();
        } else {

            $qb = $this->em->createQueryBuilder()
                    ->select('p.nome', 'p.bi', 'p.id as pessoa', 'm.estado', 'm.data', 'm.id', 'a.id as aluno')
                    ->from('models\Matricula', 'm')
                    ->innerJoin('models\Aluno', 'a', 'WITH', 'm.aluno=a.id')
                    ->innerJoin('models\Pessoa', 'p', 'WITH', 'a.pessoa=p.id')
                    ->orderBy('m.id', 'DESC');
            return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
        }
    }

    public function remover($id = FALSE) {
        $id = $this->em->getPartialReference('models\Pessoa', $id);
        $this->em->remove($id);
        $this->em->flush();
        return TRUE;
    }

    //função que retorna os cursos e modulos onde um aluno foi matriculado
    public function buscaMatriculaMod($id) {
        $qb = $this->em->createQueryBuilder()
                ->select('m.nome')
                ->from('models\MatriculaModulo', 'md')
                ->innerJoin('models\Modulo', 'm', 'WITH', 'md.modulo=m.id')
                ->innerJoin('models\Curso', 'c', 'WITH', 'm.curso=c.id')
                ->andWhere('md.matricula =:id')
                ->setParameter(':id', $id)
                ->orderBy('md.id', 'DESC');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function pesquisaImpressao($id) {
        
        $qb = $this->em->createQueryBuilder()
                ->select('p.nome', 'p.bi', 'p.id as pessoa', 'm.estado', 'm.data', 'm.id', 'a.id as aluno')
                ->from('models\Matricula', 'm')
                ->innerJoin('models\Aluno', 'a', 'WITH', 'm.aluno=a.id')
                ->innerJoin('models\Pessoa', 'p', 'WITH', 'a.pessoa=p.id')
                ->andWhere('m.aluno =:id')
                ->setParameter('id', $id);
        $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}
