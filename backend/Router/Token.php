<?php
namespace App\Router;

use App\Controller\UsuarioPermissaoController;

function addTokenRoutes($router) {
    $router->get('/token', function () {
        $permitido = new UsuarioPermissaoController();
        $permitido->verToken();
    });
}
