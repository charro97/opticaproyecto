<?php

namespace Controllers;
use Lib\Pages;
use Models\LineaPedido;
use Utils\Utils;

class LineaPedidoController {


    private Pages $pages;

    public function __construct() {
        $this->pages = new Pages();
    }


}


?>