<?php

namespace application;

class Bootstrap {

    public static function run(Request $pedido) {

        $controller = ucfirst($pedido->getController());
        $caminho = ROOT . "controllers" . DS1 . $controller . DS1 . $controller . '.php';
//        print $caminho;
//        die;
        $metodo = $pedido->getMetodo();
        $parametro = $pedido->getParametros();

        if (is_readable($caminho)) {

            require $caminho;
            $controlador = ucfirst($controller);
            $namespace = "\\" . "controllers" . "\\" . $controlador;
            $controller = new $namespace;

            if (is_callable(array($controller, $metodo))) {

                $metodo = $pedido->getMetodo();
            } else {
                $metodo = "index";
            }

            if (isset($parametro)) {
                call_user_func_array(array($controller, $metodo), $parametro);
            } else {
                call_user_func(array($controller, $metodo));
            }
        } else {
            header("Location:" . URL . "error");
        }
    }

}
