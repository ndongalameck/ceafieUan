<?php

namespace models;

use application\Dao;
use Doctrine\ORM\Mapping as ORM;
use config\Doctrine;

/**
 * Aluno
 *
 * @ORM\Table(name="aluno", indexes={@ORM\Index(name="fk_aluno_pessoa_idx", columns={"pessoa_id"})})
 * @ORM\Entity
 */
class Aluno extends Doctrine implements Dao {

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
     * @ORM\Column(name="graduacao", type="string", length=45, nullable=true)
     */
    private $graduacao;

    /**
     * @var string
     *
     * @ORM\Column(name="universidade", type="string", length=45, nullable=true)
     */
    private $universidade;

    /**
     * @var string
     *
     * @ORM\Column(name="unidade_organica", type="string", length=45, nullable=true)
     */
    private $unidadeOrganica;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria_docente", type="string", length=45, nullable=true)
     */
    private $categoriaDocente;

    /**
     * @var string
     *
     * @ORM\Column(name="funcao", type="string", length=45, nullable=true)
     */
    private $funcao;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria_cientifica", type="string", length=45, nullable=true)
     */
    private $categoriaCientifica;

    /**
     * @var \Pessoa
     *
     * @ORM\ManyToOne(targetEntity="Pessoa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     * })
     */
    private $pessoa;

    function getId() {
        return $this->id;
    }

    function getGraduacao() {
        return $this->graduacao;
    }

    function getUniversidade() {
        return $this->universidade;
    }

    function getUnidadeOrganica() {
        return $this->unidadeOrganica;
    }

    function getCategoriaDocente() {
        return $this->categoriaDocente;
    }

    function getFuncao() {
        return $this->funcao;
    }

    function getCategoriaCientifica() {
        return $this->categoriaCientifica;
    }

    function getPessoa() {
        return $this->pessoa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setGraduacao($graduacao) {
        $this->graduacao = $graduacao;
    }

    function setUniversidade($universidade) {
        $this->universidade = $universidade;
    }

    function setUnidadeOrganica($unidadeOrganica) {
        $this->unidadeOrganica = $unidadeOrganica;
    }

    function setCategoriaDocente($categoriaDocente) {
        $this->categoriaDocente = $categoriaDocente;
    }

    function setFuncao($funcao) {
        $this->funcao = $funcao;
    }

    function setCategoriaCientifica($categoriaCientifica) {
        $this->categoriaCientifica = $categoriaCientifica;
    }

    function setPessoa(Pessoa $pessoa) {
        $this->pessoa = $pessoa;
    }

    public function adicionar($dados = FALSE) {
        
    }

    public function adiciona($dados, $id) {
        $pessoa = $this->em->getRepository('models\Pessoa')->findOneBy(array('id' => $id));
        $dados->setPessoa($pessoa);
        $this->em->persist($dados);
        $this->em->flush();
        return $dados->getId();
    }

    public function editar($id = FALSE) {
        
    }

    public function edita($aluno, $pessoa) {
        $this->em->getConnection()->beginTransaction();
        try {

            $editar1 = $this->em->getRepository('models\Pessoa')->find(array('id' => $pessoa->getId()));
            $editar1->setNome($pessoa->getNome());
            $editar1->setGenero($pessoa->getGenero());
            $editar1->setNacionalidade($pessoa->getNacionalidade());
            $editar1->setTelefone($pessoa->getTelefone());
            $editar1->setEmail($pessoa->getEmail());
            $editar1->setBi($pessoa->getBi());
            $this->em->merge($editar1);
            $this->em->flush();

////aluno
            $editar = $this->em->getRepository('models\Aluno')->find(array('id' => $aluno->getId()));
            $editar->setGraduacao($aluno->getGraduacao());
            $editar->setUniversidade($aluno->getUniversidade());
            $editar->setUnidadeOrganica($aluno->getUnidadeOrganica());
            $editar->setCategoriaDocente($aluno->getCategoriaDocente());
            $editar->setFuncao($aluno->getFuncao());
            $editar->setCategoriaCientifica($aluno->getCategoriaCientifica());
            $this->em->merge($editar);
            $this->em->flush();
            $this->em->getConnection()->commit();
            return TRUE;
        } catch (Exception $exc) {
            $this->em->getConnection()->rollback();
            $this->em->close();
            throw $ex;
        }



        return TRUE;
    }

    public function pesquisaPor($id = FALSE) {

        if ($id) {
            return $this->em->getRepository('models\Aluno')->findOneBy(array('pessoa' => $id));
            $this->em->flush();
        }
    }

    public function pesquisar($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Aluno')->findOneBy(array('id' => $id));
            $this->em->flush();
        } else {
            return $this->em->getRepository('models\Aluno')->findby(array(), array('id' => "DESC"));
            $this->em->flush();
        }
    }

    public function remover($id = FALSE) {
        
    }

}
