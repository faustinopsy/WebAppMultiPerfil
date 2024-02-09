<?php
namespace App\Router;

use App\Controller\TokenController;

function addTokenRoutes($router) {
    $router->get('/token', function () {
        $permitido = new TokenController();
        $permitido->verToken();
    });
}
