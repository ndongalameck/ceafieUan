<?php

namespace models;

use application\Dao;
use Doctrine\ORM\Mapping as ORM;
use config\Doctrine;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", indexes={@ORM\Index(name="fk_usuario_pessoa1_idx", columns={"pessoa_id"})})
 * @ORM\Entity
 */
class Usuario extends Doctrine implements Dao {

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
     * @ORM\Column(name="login", type="string", length=45, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="senha", type="string", length=45, nullable=false)
     */
    private $senha;

    /**
     * @var string
     *
     * @ORM\Column(name="nivel", type="string", nullable=false)
     */
    private $nivel;

    /**
     * @var string
     *
     * @ORM\Column(name="tema", type="string", nullable=false)
     */
    private $tema;

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

    function getLogin() {
        return $this->login;
    }

    function getSenha() {
        return $this->senha;
    }

    function getNivel() {
        return $this->nivel;
    }

    function getPessoa() {
        return $this->pessoa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function getTema() {
        return $this->tema;
    }

    function setTema($tema) {
        $this->tema = $tema;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setPessoa(Pessoa $pessoa) {
        $this->pessoa = $pessoa;
    }

    public function adicionar($dados = FALSE) {
        
    }

    public function adiciona($dados, $pessoa) {

        $pessoa = $this->em->getRepository('models\Pessoa')->findOneBy(array('id' => $pessoa));
        $dados->setPessoa($pessoa);
        $this->em->persist($dados);
        $this->em->flush();
        return $dados->getId();
    }

    public function editar($id = FALSE) {
        $editar = $this->em->getRepository('models\Usuario')->find(array('id' => $id->getId()));
        $editar->setLogin($id->getLogin());
        if (!empty($id->getSenha())) {
            $editar->setSenha($id->getSenha());
        }
        $editar->setNivel($id->getNivel());
        $this->em->merge($editar);
        $this->em->flush();
        return TRUE;
    }

    public function editarTema($id = FALSE) {
        $editar = $this->em->getRepository('models\Usuario')->find(array('id' => $id->getId()));
        $editar->setTema($id->getTema());
        $this->em->merge($editar);
        $this->em->flush();
        return TRUE;
    }

    public function editarSenha($id = FALSE) {
        $editar = $this->em->getRepository('models\Usuario')->find(array('id' => $id->getId()));
        $editar->setSenha(\application\Hash::getHash("md5", $id->getSenha(), HASH_KEY));
        $this->em->merge($editar);
        $this->em->flush();
        return TRUE;
    }

    public function pesquisaPor($dados = FALSE) {
        return $this->em->getRepository('models\Usuario')->findOneBy(array('login' => $dados));
        $this->em->flush();
    }

    public function pesquisar($id = FALSE) {
        if ($id) {
            return $this->em->getRepository('models\Usuario')->findOneBy(array('id' => $id));
            $this->em->flush();
        } else {
            return $this->em->getRepository('models\Usuario')->findby(array(), array('id' => "DESC"));
            $this->em->flush();
        }
    }

    public function remover($id = FALSE) {
        
    }

    function Autenticar($objecto) {
        return $this->em->getRepository('models\Usuario')->findOneBy(array('login' => $objecto->getLogin(), 'senha' => $objecto->getSenha()));
        $this->em->flush();
    }

}
