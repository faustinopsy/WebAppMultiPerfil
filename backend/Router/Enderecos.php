<?php
namespace App\Router;

use App\Controller\EnderecosController;
use App\Model\Enderecos;
use App\Model\Saloes;
use App\Controller\TokenController;

function addEnderecosRoutes($router) {
    $router->mount('/Enderecos', function () use ($router) {
        $router->get('/', function () {
            $enderecos = new Enderecos();
            $saloes = new Saloes();
            $bairro = filter_input(INPUT_GET, 'bairro', FILTER_SANITIZE_STRING);
            $enderecos->setBairro($bairro);
            $EnderecosController = new EnderecosController($enderecos, $saloes);
            $resultado = $EnderecosController->listarEndereco();
            echo json_encode($resultado);
        });
        $router->get('/geo', function () {
            $enderecos = new Enderecos();
            $saloes = new Saloes();
            $latitude = filter_input(INPUT_GET,  'lat', FILTER_VALIDATE_FLOAT);
            $longitude = filter_input(INPUT_GET,  'long', FILTER_VALIDATE_FLOAT);
            if ($latitude === false || $latitude < -90 || $latitude > 90) {
                echo json_encode(['status' => false, 'message' => 'Dados inválidos.']);
            }
            if ($longitude === false || $longitude < -180 || $longitude > 180) {
                echo json_encode(['status' => false, 'message' => 'Dados inválidos.']);
            }
            $latMin = (floor($latitude * 100) / 100) + 0.01; 
            $latMax = ($latMin + 0.008009) - 0.02; 
            $longMin = floor($longitude * 100) / 100; 
            $longMax = $longMin + 0.02;
            $enderecos->setLatitude($latitude);
            $enderecos->setLongitude($longitude);
            $EnderecosController = new EnderecosController($enderecos, $saloes);
            $resultado = $EnderecosController->listarEnderecoGEO($latMin,$latMax,$longMin,$longMax); 
            echo json_encode($resultado);  
        });
        
        $router->post('/', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $iduser= $permitido->verIdUserToken();
            $body = json_decode(file_get_contents('php://input'), true);
            $enderecos = new Enderecos();
            $saloes = new Saloes();
            $enderecos->setRua($body['rua']);
            $enderecos->setCep($body['cep']);
            $enderecos->setBairro($body['bairro']);
            $enderecos->setCidade($body['cidade']);
            $enderecos->setEstado($body['estado']);
            $enderecos->setLatitude($body['latitude']);
            $enderecos->setLongitude($body['longitude']);
            $enderecos->setSalao($body['idSalao']);
            $enderecos->setIdusuario($iduser);
            $EnderecosController = new EnderecosController($enderecos,$saloes );
            $resultado = $EnderecosController->adicionarEndereco();
            echo json_encode($resultado);
        });
        $router->delete('/(\d+)', function ($id) {
            $permitido = new TokenController();
            $permitido->autorizado();
            $enderecos = new Enderecos();
            $saloes = new Saloes();
            $saloes->setId($id);
            $EnderecosController = new EnderecosController($enderecos,$saloes );
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

