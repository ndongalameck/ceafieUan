<?php

namespace config;

// bootstrap.php
//vamos configurar a chamada ao Entity Manager, o mais importante do Doctrine
// o Autoload é responsável por carregar as classes sem necessidade de incluí-las previamente
//require_once "/var/www/html/noc/vendor/autoload.php";
// o Doctrine utiliza namespaces em sua estrutura, por isto estes uses

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\Common\ClassLoader;

class Doctrine {

    /**     * @property \Doctrine\ORM\EntityManager $em Gerenciador de Entidade */
    private $entidade;
    private $isDevMode;
    private $root;
    public $em;

    function getEntidade() {
        return $this->entidade;
    }

    function getIsDevMode() {
        return $this->isDevMode;
    }

    function setEntidade($entidade) {
        $this->entidade = $entidade;
    }

    function setIsDevMode($isDevMode) {
        $this->isDevMode = $isDevMode;
    }

    function getRoot() {
        return $this->root;
    }

    function setRoot($root) {
        $this->root = $root;
    }

//
////onde irão ficar as entidades do projeto? Defina o caminho aqui
//$entidades = array($root . "models/");
////
//$isDevMode = true;
//////setando as configurações definidas anteriormente

    public function __construct() {
        $this->setRoot("/var/www/html/uan/");
        $this->setEntidade(array($this->getRoot() . "models/"));
        $this->setIsDevMode(true);
        $mode = "DESENVOLVIMENTO";
        $config = Setup::createAnnotationMetadataConfiguration($this->getEntidade(), $this->getIsDevMode(), NULL, NULL, FALSE);
       

        if ($mode == "DESENVOLVIMENTO") {
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        } else {
            $cache = new \Doctrine\Common\Cache\ApcCache;
        }

        $config = new Configuration();
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver($this->getRoot() . 'models/');
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir($this->getRoot() . 'proxies/');
        $config->setProxyNamespace('proxies');

        if ($mode == "DESENVOLVIMENTO") {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }

        $config = Setup::createAnnotationMetadataConfiguration($this->getEntidade(), $this->getIsDevMode(), NULL, NULL, FALSE);



        $dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => '',
            'dbname' => 'ceafie',
            'charset' => 'utf8',
            'driverOptions' => array(1002 => 'SET NAMES utf8')
        );

        $this->em = EntityManager::create($dbParams, $config);
         $loader = new ClassLoader('Entity', __DIR__ . '/models');
        $loader->register();
    }

}

?>
