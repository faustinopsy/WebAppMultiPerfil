<?php
namespace App\Router;

use Bramus\Router\Router;
use App\Controller\PerfilPermissaoController;
use App\Controller\UsuarioPermissaoController;
use App\Model\Perfis;
use App\Model\Permissoes;
use App\Model\perfilpermissoes;

function addPerfilRoutes($router) {
    $router->mount('/Perfil', function () use ($router) {
    $router->get('/', function () {
        $permitido = new UsuarioPermissaoController();
        $permitido->autorizado();
        $perfil = new Perfis();
        $controller = new PerfilPermissaoController();
            $resultado = $controller->listarPerfis($perfil);
            if (!$resultado) {
                echo json_encode(["status" => false, "mensagem" => "Nenhum perfil encontrado"]);
                exit;
            } else {
                echo json_encode($resultado);
                exit;
            }     
    });
    $router->get('/(\d+)', function ($id) {
        $permitido = new UsuarioPermissaoController();
        $permitido->autorizado();
        $perfil = new Perfis();
        $permissoes = new Permissoes();
        $perfPermissoes = new perfilpermissoes();
        $perfil->setId($id);
        $controller = new PerfilPermissaoController();
        $resultado = $controller->obterPermissoesDoPerfil($perfPermissoes,$permissoes,$perfil);
        if (!$resultado) {
            echo json_encode(["status" => false, "mensagem" => "Nenhum resultado encontrado"]);
            exit;
        } else {
            echo json_encode($resultado);
            exit;
        }
    });
    $router->post('/', function () {
        $body = json_decode(file_get_contents('php://input'), true);
        $permitido = new UsuarioPermissaoController();
        $permitido->autorizado();
        $perfil = new Perfis();
        $perfil->setNome($body['nome']);
        $controller = new PerfilPermissaoController();
            $resultado = $controller->AddPerfil($perfil,$body['nome']);
            echo json_encode([$resultado]);
    });
});
}
