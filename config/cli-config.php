<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// cli-config.php
require 'Doctrine.php';

$d=new config\Doctrine();
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($d->em);
?>

