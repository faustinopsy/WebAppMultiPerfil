<?php
namespace App\Router;

use App\Controller\AnaliticosController;
use App\Model\Analiticos;
use App\Controller\UsuarioPermissaoController;

function addAnaliticosRoutes($router) {
    $router->mount('/Analitico', function () use ($router) {
        $router->get('/', function () {
            $analitico = new Analiticos();
            $analiticoController = new AnaliticosController($analitico);
            $resultado = $analiticoController->listarAnalitico();
            if(!$resultado){
                echo json_encode(["status" => false, "Analitico" => $resultado,"mensagem"=>"nenhum resultado encontrado"]);
                exit;
            }else{
                echo json_encode($resultado);
                exit;
            }
        });

        $router->get('/(\d+)', function ($id) {
            $permitido = new UsuarioPermissaoController();
            $permitido->autorizado();
            $analitico = new Analiticos();
            $analiticoController = new AnaliticosController($analitico);
            $resultado = $analiticoController->buscarPorId($id);
                if(!$resultado){
                    echo json_encode(["status" => false, "Analitico" => $resultado,"mensagem"=>"nenhum resultado encontrado"]);
                    exit;
                }else{
                    echo json_encode(["status" => true, "Analitico" => $resultado]);
                    exit;
                }
        });
        $router->post('/', function () {
            $body = json_decode(file_get_contents('php://input'), true);
            $analitico = new Analiticos();
            foreach ($body as $movement) {
                $timestampInSeconds = $movement['time'] / 1000;
                $mobile = $movement['isMobile'] ? 1 : 0;
                $mysqlDateTime = date('Y-m-d H:i:s', $timestampInSeconds);
                $analitico->setVisitorId($movement['visitor_id']);
                $analitico->setX($movement['x']);
                $analitico->setY($movement['y']);
                $analitico->setTime($mysqlDateTime);
                $analitico->setIsMobile($mobile);
                $analitico->setScreenWidth($movement['screenSize']['width']);
                $analitico->setScreenHeight($movement['screenSize']['height']);

                $analiticoController = new AnaliticosController($analitico);
                $resultado = $analiticoController->adicionarAnalitico();
                echo json_encode(['status' => $resultado]);
            }
        });
        
    });
}

