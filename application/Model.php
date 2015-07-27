<?php

namespace application;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author sam
 */

class Model {

    //put your code here
    protected $db;

    public function __construct() {
        $this->db = ROOT . "config/bootstrap.php";
        return $this->db;
    }

}
