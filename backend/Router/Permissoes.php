<?php
namespace App\Router;

use App\Controller\PerfilPermissaoController;
use App\Controller\UsuarioPermissaoController;
use App\Model\Permissoes;
use App\Model\Perfis;
use App\Model\perfilpermissoes;

function addPermissaoRoutes($router) {
    $router->mount('/Permissoes', function () use ($router) {
        $router->get('/', function () {
            $permitido = new UsuarioPermissaoController();
            $permitido->autorizado();
            $permissoes = new Permissoes();
            $controller = new PerfilPermissaoController();
            $resultado = $controller->listarPermissoes($permissoes);
            if (!$resultado) {
                echo json_encode(["status" => false, "mensagem" => "Nenhuma Permissoes encontrado"]);
                exit;
            } else {
                echo json_encode($resultado);
                exit;
            }     
        });
        $router->post('/', function () {
            $permitido = new UsuarioPermissaoController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $permissoes = new Permissoes();
            $controller = new PerfilPermissaoController();
            $permissoes->setNome($body['nome']);
            $resultado = $controller->addPermissao($permissoes,$body['nome']);
            echo json_encode($resultado);
        });
        $router->post('/Perfil', function () {
            $permitido = new UsuarioPermissaoController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $perfPermissoes = new perfilpermissoes();
            $controller = new PerfilPermissaoController();
            $perfPermissoes->setPerfilid($body['perfilId']);
            $perfPermissoes->setPermissaoId($body['permissao_id']);
            $resultado = $controller->addPermissaoPerfil($perfPermissoes,$body['perfilId'],$body['permissao_id']);
            echo json_encode($resultado);
        });
       
        $router->put('/(\d+)', function ($id) {
            $permitido = new UsuarioPermissaoController();
            $permitido->autorizado();
            echo 'Update usuario id ' . htmlentities($id);
        });
        $router->delete('/(\d+)', function ($id) {
            $permitido = new UsuarioPermissaoController();
            $permitido->autorizado();
            $controller = new PerfilPermissaoController();
            $perfPermissoes = new perfilpermissoes();
            $perfil = new Perfis();
            $permissoes = new Permissoes();
            $body = json_decode(file_get_contents('php://input'), true);
            $perfil->setId($id);
            $permissoes->setId($body['permissao_id']);
            $resultado = $controller->removerPermissao($perfPermissoes, $perfil, $permissoes);
            echo json_encode($resultado);
        });
    });
}
