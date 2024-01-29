<?php
namespace App\Router;

use App\Controller\PerfilPermissaoController;
use App\Controller\TokenController;
use App\Model\Permissoes;
use App\Model\Perfis;
use App\Model\perfilpermissoes;

function addAssociarRoutes($router) {
    $router->mount('/Associar', function () use ($router) {
        $router->post('/', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $perfPermissoes = new perfilpermissoes();
            $perfPermissoes->setPerfilid($body['perfilId']);
            $perfPermissoes->setPermissaoId($body['permissao_id']);
            $controller = new PerfilPermissaoController($perfPermissoes);
            $resultado = $controller->addAssociarPermissaoPerfil(); 
            echo json_encode($resultado);
        });
        $router->get('/(\d+)', function ($id) {
            $permitido = new TokenController();
            $permitido->autorizado();
            $permissoes = new Permissoes();
            $perfPermissoes = new perfilpermissoes();
            $perfPermissoes->setPerfilid($id);
            $controller = new PerfilPermissaoController($perfPermissoes);
            $resultado = $controller->obterPermissoesDoPerfil($permissoes);
            echo json_encode($resultado);
        });
        $router->delete('/(\d+)', function ($id) {
            $permitido = new TokenController();
            $permitido->autorizado();
            $perfPermissoes = new perfilpermissoes();
            $permissoes = new Permissoes();
            $body = json_decode(file_get_contents('php://input'), true);
            $perfPermissoes->setPerfilid($id);
            $perfPermissoes->setPermissaoId($body['permissao_id']);
            $controller = new PerfilPermissaoController($perfPermissoes);
            $resultado = $controller->removerPermissao();
            echo json_encode($resultado);
        });
    });
}
