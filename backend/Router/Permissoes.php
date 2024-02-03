<?php
namespace App\Router;

use App\Controller\PermissaoController;
use App\Controller\PerfilPermissaoController;
use App\Controller\TokenController;
use App\Model\Permissoes;
use App\Model\Perfis;
use App\Model\perfilpermissoes;

function addPermissaoRoutes($router) {
    $router->mount('/Permissoes', function () use ($router) {
        $router->get('/', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $permissoes = new Permissoes();
            $controller = new PermissaoController($permissoes);
            $resultado = $controller->listarPermissoes(); 
            if (!$resultado) {
                echo json_encode(["status" => false, "mensagem" => "Nenhuma Permissoes encontrado"]);
                exit;
            } else {
                echo json_encode($resultado);
                exit;
            }     
        });
        $router->post('/', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $permissoes = new Permissoes();
            $permissoes->setNome($body['nome']);
            $controller = new PermissaoController($permissoes);
            $resultado = $controller->adicionarPermissao(); 
            echo json_encode($resultado);
        });
        $router->delete('/(\d+)', function ($id) {
            $permitido = new TokenController();
            $permitido->autorizado();
            $permissoes = new Permissoes();
            $permissoes->setId($id);
            $controller = new PermissaoController($permissoes);
            $resultado = $controller->removerPermissao();
            echo json_encode($resultado);
        });
    });
}
