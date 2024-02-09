<?php
namespace App\Router;

use App\Controller\SaloesController;
use App\Model\Saloes;
use App\Model\Enderecos;
use App\Controller\TokenController;
header('Content-Type: application/json');
function addSaloesRoutes($router) {
    $router->mount('/Saloes', function () use ($router) {
        $router->get('/', function () {
            $saloes = new Saloes();
            $saloesController = new SaloesController($saloes);
            $resultado = $saloesController->listarSalao(); 
            echo json_encode($resultado);
        });
        $router->get('/MeuSalao', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $iduser= $permitido->verIdUserToken();
            $saloes = new Saloes();
            if($iduser===1){
                $saloesController = new SaloesController($saloes);
                $resultado = $saloesController->listarSalao(); 
                echo json_encode($resultado);
                exit;
            }
            $saloes->setIdusuario($iduser);
            $enderecos = new Enderecos();
            $saloesController = new SaloesController($saloes);
            $resultado = $saloesController->listarMeuSalao($enderecos);  
            echo json_encode($resultado);
        });
        $router->get('/(\d+)', function ($id) {
            $permitido = new TokenController();
            $permitido->autorizado();
            $saloes = new Saloes();
            $saloesController = new SaloesController($saloes);
            $resultado = $saloesController->buscarPorId($id);
            echo json_encode($resultado);   
        });
        $router->post('/', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $iduser= $permitido->verIdUserToken();
            $body = json_decode(file_get_contents('php://input'), true);
            $saloes = new Saloes();
            $saloes->setNome($body['titulo']);
            $saloes->setServicos($body['servicos']);
            $saloes->setIdusuario($iduser);
            $saloes->setAtivo(1);
            $saloesController = new SaloesController($saloes);
            $resultado = $saloesController->adicionarSalao();
            echo json_encode($resultado);
        });
        $router->delete('/', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $saloes = new Saloes();
            $saloes->setId($body['id']);
            $saloesController = new SaloesController($saloes);
            $resultado = $saloesController->removerSalao();
            if(!$resultado){
                echo json_encode(['status' => false, 'message' => 'Não pode remover']);
               exit;
            }
            echo json_encode(['status' => true, 'message' => 'Removido com sucesso']);
            exit;
        });
    });
}

