<?php
namespace App\Router;

use App\Controller\ProdutoController;
use App\Model\Produtos;
use App\Controller\UsuarioPermissaoController;

function addProdutoRoutes($router) {
    $router->mount('/Produtos', function () use ($router) {
        $router->get('/', function () {
            $produto = new Produtos();
            $produtosController = new ProdutoController($produto);
            $resultado = $produtosController->listarProdutos();
            if(!$resultado){
                echo json_encode(["status" => false, "Produtos" => $resultado,"mensagem"=>"nenhum resultado encontrado"]);
                exit;
            }else{
                echo json_encode(["status" => true, "Produtos" => $resultado]);
                exit;
            }
        });

        $router->get('/(\d+)', function ($id) {
            $permitido = new UsuarioPermissaoController();
            $permitido->autorizado();
            $produto = new Produtos();
            $produtosController = new ProdutoController($produto);
            $resultado = $produtosController->buscarPorId($id);
                if(!$resultado){
                    echo json_encode(["status" => false, "Produtos" => $resultado,"mensagem"=>"nenhum resultado encontrado"]);
                    exit;
                }else{
                    echo json_encode(["status" => true, "Produtos" => $resultado]);
                    exit;
                }
        });
        $router->post('/', function () {
            $permitido = new UsuarioPermissaoController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $produto = new Produtos();
            $produto->setNome($body['nome']);
            $produto->setPreco($body['preco']);
            $produto->setQuantidade($body['quantidade']);
            $produtoController = new ProdutoController($produto);
            $resultado = $produtoController->adicionarProduto();
            echo json_encode(['status' => $resultado]);
        });
        $router->delete('/', function () {
            $permitido = new UsuarioPermissaoController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $produto = new Produtos();
            $produto->setId($body['id']);
            $produtoController = new ProdutoController($produto);
            $resultado = $produtoController->removerProduto();
            if(!$resultado){
                echo json_encode(['status' => false, 'message' => 'Não pode remover']);
               exit;
            }
            echo json_encode(['status' => true, 'message' => 'Removido com sucesso']);
            exit;
        });
    });
}

