<?php


/*
 * arquivo de configuração da aplicação
 */
//error_reporting(E_ALL);
//ini_set("display_errors", 0);

define("URL", "https://localhost/uan/");

//define a pasta layout com a pagina padrão de layout
define("DEFAULT_LAYOUT", "default");
//define a empresa
define("COMPANY", "CEFIE");
define("SIGLA", "Copyright © 2015. Todos os Direitos Reservados.");
define("DESENVOLVEDOR", " Dario Germano & Duplesie Andrade.");
//define o grupo onde serão cadastrados todos os usuarios

//define o tempo de  sessão activa que o usuario tera
define("SESSION_TIME", "50");
//define o directorio padrão da aplicação
define("DS", DIRECTORY_SEPARATOR);
define("DS1", "/");
//define o caminho Root da aplicação
define("ROOT", realpath(dirname(__DIR__)) . DS1);
//define o caminho da pasta aplicação
define("HASH_KEY", "peixede234luanda1298");
define("APP_PATH",  "application" . DS1);
//define  nome do arquivo onde se encontra o arquivo de erro
define("DEFAULT_ERRO", "errorController");
define("DEFAULT_CONTROLLER", "index");




