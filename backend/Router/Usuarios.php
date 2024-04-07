<?php
namespace App\Router;

use App\Controller\UsuarioController;
use App\Model\Usuarios;
use App\Controller\TokenController;
use App\Controller\PerfilController;
use App\Model\Perfis;
function addUsuarioRoutes($router) {
    $router->mount('/Usuarios', function () use ($router) {
        $router->get('/', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $usuario = new Usuarios();
            $usuariosController = new UsuarioController($usuario);
            $resultado = $usuariosController->listarUsuarios();
            
            if(!$resultado){
                echo json_encode(["status" => false, "Usuarios" => $resultado,"mensagem"=>"nenhum resultado encontrado"]);
                exit;
            }else{
                echo json_encode(["status" => true, "Usuarios" => $resultado]);
                exit;
            }
        });

        $router->get('/([a-z0-9_-]+)', function ($id) {
            $permitido = new TokenController();
            $permitido->autorizado();
            $usuario = new Usuarios();
            $usuariosController = new UsuarioController($usuario);
            $resultado = $usuariosController->buscarPorId($id);
                if(!$resultado){
                    echo json_encode(["status" => false, "Usuarios" => $resultado,"mensagem"=>"nenhum resultado encontrado"]);
                    exit;
                }else{
                    echo json_encode(["status" => true, "Usuario" => $resultado]);
                    exit;
                }
        });

        $router->put('/', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $usuario = new Usuarios();
            $usuario->setEmail($body['email']);
            $usuario->setAtivo($body['chk']);
            $usuariosController = new UsuarioController($usuario);
            $resultado = $usuariosController->bloquearPorEmail(); 
            echo json_encode(['status' => $resultado]);
        });
        $router->put('/perfil', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $usuario = new Usuarios();
            $usuario->setPerfilId($body['perf']);
            $usuario->setEmail($body['email']);
            $usuariosController = new UsuarioController($usuario);
            $resultado = $usuariosController->AlterarPerfil(); 
            echo json_encode(['status' => $resultado]);
        });
        $router->put('/trocasenha', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $novasenha = $body['resenha'];
            $usuario = new Usuarios();
            $usuario->setSenha($body['resenha']);
            $usuario->setEmail($body['email']);
            $usuariosController = new UsuarioController($usuario);
            $resultado = $usuariosController->Alterarsenha($body['senha'],$novasenha); 
            echo json_encode( $resultado);
        });
        $router->post('/Registrar', function () {
            $body = json_decode(file_get_contents('php://input'), true);
            $usuario = new Usuarios();
            $perfil = new Perfis();
            $Perfilcontroller = new PerfilController($perfil);
            $perfilresultado = $Perfilcontroller->listarPerfis();
            foreach($perfilresultado as $value){
                if ($value["nome"] === 'comum') { 
                    $usuario->setPerfilId($value["id"]);
                }
                
            }
            $usuario->setNome($body['nome']);
            $usuario->setEmail($body['email']);
            $usuario->setSenha($body['senha']);
            $usuario->setAtivo(1);
            $usuariosController = new UsuarioController($usuario);
            $resultado = $usuariosController->adicionarUsuario();
            echo json_encode(['status' => $resultado]);
        });
        $router->post('/login', function () {
            $body = json_decode(file_get_contents('php://input'), true);
            $usuario = new Usuarios();
            if (isset($body['email'])) {
                $usuario->setEmail($body['email']);
                $senha=$body['senha'];
                $lembrar=$body['lembrar'];
                $usuariosController = new UsuarioController($usuario);
                $resultado = $usuariosController->login($senha,$lembrar);
                if(!$resultado['status']){
                    echo json_encode(['status' => $resultado['status'], 'message' => $resultado['message']]);
                   exit;
                }
                echo json_encode(['status' => $resultado['status'], 'message' => $resultado['message'],'user'=>$resultado['user'],'token'=>$resultado['token']]);
                exit;
            }
        });
        $router->post('/recuperarsenha', function () {
            $body = json_decode(file_get_contents('php://input'), true);
            $usuario = new Usuarios();
            if (isset($body['email'])) {
                $usuario->setEmail($body['email']);
                $usuariosController = new UsuarioController($usuario);
                $resultado = $usuariosController->recupasenha();
                if(!$resultado['status']){
                    echo json_encode(['status' => $resultado['status'], 'message' => $resultado['message']]);
                   exit;
                }
                echo json_encode(['status' => $resultado['status'], 'message' => $resultado['message']]);
                exit;
            }
        });
        $router->post('/verificacodigo', function () {
            $body = json_decode(file_get_contents('php://input'), true);
            $usuario = new Usuarios();
            if (isset($body['email'])) {
                $codigo = $body['codigo'];
                $usuario->setEmail($body['email']);
                $usuariosController = new UsuarioController($usuario);
                $resultado = $usuariosController->verificacodigo($codigo);
                if(!$resultado['status']){
                    echo json_encode(['status' => $resultado['status'], 'message' => $resultado['message']]);
                   exit;
                }
                echo json_encode(['status' => $resultado['status'], 'message' => $resultado['message']]);
                exit;
            }
        });
        $router->delete('/', function () {
            $permitido = new TokenController();
            $permitido->autorizado();
            $body = json_decode(file_get_contents('php://input'), true);
            $usuario = new Usuarios();
            $usuario->setEmail($body['email']);
            $usuariosController = new UsuarioController($usuario);
            $resultado = $usuariosController->removerUsuario();
            if(!$resultado){
                echo json_encode(['status' => false, 'message' => 'Não pode remover']);
               exit;
            }
            echo json_encode(['status' => true, 'message' => 'Removido com sucesso']);
            exit;
        });
    });
}

