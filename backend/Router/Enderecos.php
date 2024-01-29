<?php
namespace App\Router;

use App\Controller\EnderecosController;
use App\Model\Enderecos;
use App\Controller\TokenController;

function addEnderecosRoutes($router) {
    $router->mount('/Enderecos', function () use ($router) {
        $router->get('/', function () {
            $Enderecos = new Enderecos();
            $EnderecosController = new EnderecosController($Enderecos);
            $resultado = $EnderecosController->listarEndereco();
            if(!$resultado){
                echo json_encode(["status" => false, "Enderecos" => $resultado,"mensagem"=>"nenhum resultado encontrado"]);
                exit;
            }else{
                echo json_encode(["status" => true, "Enderecos" => $resultado]);
                exit;
            }
        });

        $router->get('/(\d+)', function ($id) {
            $permitido = new TokenController();
            $permitido->autorizado();
            $Enderecos = new Enderecos();
            $EnderecosController = new EnderecosController($Enderecos);
            $resultado = $EnderecosController->buscarPorId($id);
                if(!$resultado){
                    echo json_encode(["status" => false, "Enderecos" => $resultado,"mensagem"=>"nenhum resultado encontrado"]);
                    exit;
                }else{
                    echo json_encode(["status" => true, "Enderecos" => $resultado]);
                    exit;
                }
        });
        $router->post('/', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $Enderecos = new Enderecos();
            $Enderecos->setRua($body['nome']);
            
            $EnderecosController = new EnderecosController($Enderecos);
            $resultado = $EnderecosController->adicionarEndereco();
            echo json_encode(['status' => $resultado]);
        });
        $router->delete('/', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $Enderecos = new Enderecos();
            $Enderecos->setId($body['id']);
            $EnderecosController = new EnderecosController($Enderecos);
            $resultado = $EnderecosController->removerEndereco();
            if(!$resultado){
                echo json_encode(['status' => false, 'message' => 'Não pode remover']);
               exit;
            }
            echo json_encode(['status' => true, 'message' => 'Removido com sucesso']);
            exit;
        });
    });
}

