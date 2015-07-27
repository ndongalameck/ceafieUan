<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use application\Session;
use application\Bootstrap;
use application\Request;

require './vendor/autoload.php';
require 'config/config.php';
//require 'config/cli-config.php';
require './config/autoload.php';
require './config/Doctrine.php';


try {
    Session::iniciar();
    Bootstrap::run(new Request());
} catch (Exception $ex) {
    echo $ex->getMessage();
}


        
