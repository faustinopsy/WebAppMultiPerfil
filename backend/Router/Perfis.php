<?php
namespace App\Router;

use App\Controller\PerfilController;
use App\Controller\PerfilPermissaoController;
use App\Controller\TokenController;
use App\Model\Perfis;
use App\Model\Permissoes;
use App\Model\perfilpermissoes;

function addPerfilRoutes($router) {
    $router->mount('/Perfil', function () use ($router) {
    $router->get('/', function () {
        $permitido = new TokenController();
        $permitido->autorizado();
        $perfil = new Perfis();
        $controller = new PerfilController($perfil);
        $resultado = $controller->listarPerfis();
        echo json_encode($resultado);
    });
    
    $router->post('/', function () {
        $body = json_decode(file_get_contents('php://input'), true);
        $permitido = new TokenController();
        $permitido->autorizado();
        $perfil = new Perfis();
        $perfil->setNome($body['nome']);
        $controller = new PerfilController($perfil);
            $resultado = $controller->adicionarPerfil();
            echo json_encode($resultado);
    });
});
}
