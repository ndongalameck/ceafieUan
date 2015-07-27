<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use application\Dao;
use config\Doctrine;

/**
 * Pessoa
 *
 * @ORM\Table(name="pessoa", uniqueConstraints={@ORM\UniqueConstraint(name="telefone_UNIQUE", columns={"telefone"})})
 * @ORM\Entity
 */
class Pessoa extends Doctrine implements Dao {

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
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="genero", type="string", nullable=false)
     */
    private $genero;

    /**
     * @var string
     *
     * @ORM\Column(name="nacionalidade", type="string", length=45, nullable=false)
     */
    private $nacionalidade;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone", type="string", length=45, nullable=false)
     */
    private $telefone;

    /**
     * @var string
     *
     * @ORM\Column(name="imagem", type="string", length=45, nullable=true)
     */
    private $imagem;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="bi", type="string", length=45, nullable=false)
     */
    private $bi;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=45, nullable=false)
     */
    private $documento;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getGenero() {
        return $this->genero;
    }

    function getNacionalidade() {
        return $this->nacionalidade;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getImagem() {
        return $this->imagem;
    }

    function getEmail() {
        return $this->email;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setGenero($genero) {
        $this->genero = $genero;
    }

    function setNacionalidade($nacionalidade) {
        $this->nacionalidade = $nacionalidade;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getBi() {
        return $this->bi;
    }

    function getDocumento() {
        return $this->documento;
    }

    function setBi($bi) {
        $this->bi = $bi;
    }

    function setDocumento($documento) {
        $this->documento = $documento;
    }

    public function adicionar($dados = FALSE) {
        $this->em->persist($dados);
        $this->em->flush();
        return $dados->getId();
    }

    public function editar($id = FALSE) {
        $editar = $this->em->getRepository('models\Pessoa')->find(array('id' => $id->getId()));
        $editar->setImagem($id->getImagem());
        $this->em->flush();
        return TRUE;
    }

    public function editarDados($id = FALSE) {
        $editar = $this->em->getRepository('models\Pessoa')->find(array('id' => $id->getId()));
        $editar->setNome($id->getNome());
        $editar->setGenero($id->getGenero());
        $editar->setNacionalidade($id->getNacionalidade());
        $editar->setTelefone($id->getTelefone());
        $editar->setEmail($id->getEmail());
        $editar->setBi($id->getBi());
        $this->em->flush();
        return TRUE;
    }

    public function pesquisaPor($dados = FALSE) {
        $t = $this->em->getRepository('models\Pessoa');
        $qb = $t->createQueryBuilder('e');
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function pesquisar($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Pessoa')->findOneBy(array('id' => $id));
            $this->em->flush();
        } else {
            return $this->em->getRepository('models\Pessoa')->findby(array(), array('id' => "DESC"));
            $this->em->flush();
        }
    }

    public function pesquisarTelefone($id = FALSE) {
        if ($this->em->getRepository('models\Pessoa')->findOneBy(array('telefone' => $id))) {
            $this->em->flush();
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function pesquisarNome($id = FALSE) {
        if ($this->em->getRepository('models\Pessoa')->findOneBy(array('nome' => $id))) {
            $this->em->flush();
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function pesquisarEmail($id = FALSE) {
        if ($this->em->getRepository('models\Pessoa')->findOneBy(array('email' => $id))) {
            $this->em->flush();
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function pesquisarBi($id = FALSE) {
        if ($this->em->getRepository('models\Pessoa')->findOneBy(array('bi' => $id))) {
            $this->em->flush();
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function remover($id = FALSE) {
        $id = $this->em->getPartialReference('models\Pessoa', $id);
        $this->em->remove($id);
        $this->em->flush();
        return TRUE;
    }

}
