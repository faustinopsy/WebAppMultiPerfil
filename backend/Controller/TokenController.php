<?php

namespace App\Controller;
use App\Model\Usuarios;
use App\Database\Crud;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Service\UsuarioFactory;
class TokenController {
    private $crud;
    private $ips_permitidos;
    private $origesPermitidas;
    public function __construct() {
        $this->ips_permitidos = ['::1', '123.123.123.124'];
        $this->origesPermitidas= ['http://localhost:5500','http://192.168.56.1'];
        $this->crud = new Crud();
    }
    public function validarToken($usuarios,$token){
        $key = TOKEN;
        $algoritimo = 'HS256';
        try {
            $decoded = JWT::decode($token, new Key($key, $algoritimo));
            $condicoes = ['id' => $decoded->sub];
            $resultado = $this->crud->select($usuarios->getTable(), $condicoes);
            $permissoes = $decoded->telas;
            if(!$resultado){
                return ['status' => false, 'message' => 'Token inválido! Motivo: usuário invalido'];
            }
            if($_SERVER['SERVER_NAME']==$decoded->aud){
                return ['status' => true, 'message' => 'Token válido!', 'telas'=>$permissoes];
            }else{
                return ['status' => false, 'message' => 'Token inválido! Motivo: dominio invalido' ];
            }
        } catch(Exception $e) {
            return ['status' => false, 'message' => 'Token inválido! Motivo: ' . $e->getMessage()];
        }
    }
    public function login($usuarios,$senha,$lembrar) {
        $condicoes = ['email' => $usuarios->getEmail(),'ativo' => 1];
        $resultado = $this->crud->select($usuarios->getTable(), $condicoes);
        $checado=$lembrar? 60*12 : 3;
        $permissoes=[];
        $permissoesNomes=[];
        if (!$resultado) {
            return ['status' => false, 'message' => 'Usuário não encontrado ou bloqueado.'];
        }
        if (!password_verify($senha, $resultado[0]['senha'])) {
            return ['status' => false, 'message' => 'Senha incorreta.'];
        }
        $twofactor = $resultado[0]['twofactor'];
        $perfil = UsuarioFactory::criarUsuario(
            $resultado[0]['perfil']
        );
    
        $permissoes = $perfil->getPermissoesTela();

        $key = TOKEN;
        $local=$_SERVER['HTTP_HOST'];
        $nome=$_SERVER['SERVER_NAME'];
        $userid= $resultado[0]['id'];
        $algoritimo='HS256';
            $payload = [
                "iss" =>  $local,
                "aud" =>  $nome,
                "iat" => time(),
                "exp" => time() + (60 * $checado),  
                "sub" => $userid,
                'telas'=>$permissoes
            ];
            if($twofactor===1){
                $this->enviarcodigo($usuarios);
            }
            $jwt = JWT::encode($payload, $key,$algoritimo);
        return ['status' => true, 'message' => 'Login bem-sucedido!','token'=>$jwt,'user'=> $userid,'twofactor'=> $twofactor,'telas'=>$permissoesNomes];
    }
    public function enviarcodigo($usuarios){
        $codigo = $this->gerarStringAlfanumerica(6);
        $condicoes = ['email' => $usuarios->getEmail()];
        $resultado = $this->crud->select($usuarios->getTable(), $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Usuário não encontrado.'];
        }
        $email= new EnviaEMail();
        $dados=['email'=>$usuarios->getEmail(),'codigo'=>$codigo];
        if($email->recupera($dados)){
            $this->crud->insert('codigo',['email'=>$usuarios->getEmail(),'codigo'=> $codigo]);
            return ['status'=>true,'message'=>'E-mail enviado com sucesso!'];
        }else {
            return ['status'=>false,'message'=>'falha ao enviar email!'];
        }
    }
    public function autorizado(){
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: * ');
        header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        //$this->verOrigem();
        $this->verIP();
        $this->Token();
    }
    public function verOrigem(){
        if(!in_array($_SERVER['HTTP_ORIGIN'], $this->origesPermitidas)){
            echo json_encode(['status'=>false,'mensagem' => 'Acesso não autorizado origem'], 403);
            exit;
        }
    }
    public function verIP(){
        if (!in_array($_SERVER['REMOTE_ADDR'], $this->ips_permitidos)) {
            echo json_encode(['status'=>false,'mensagem' => 'Acesso não autorizado ip'], 403);
            exit;
        }
    }
    public function verIdUserToken(){
        $usuario = new Usuarios();
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;
        $usuariosController = new UsuarioController($usuario);
        return $usuariosController->idUser($token);
    }
    public function Token(){
        $usuario = new Usuarios();
        $headers = getallheaders();
        if(!isset($headers['Authorization'])) {
            echo json_encode(['status' => false, 'message' => "sem token"]);
            exit;
        }
        $token = $headers['Authorization'] ?? null;
        $usuariosController = new UsuarioController($usuario);
        $validationResponse = $usuariosController->validarToken($token);
        if ($token === null || !$validationResponse['status']) {
            echo json_encode(['status' => false, 'message' => $validationResponse['message']]);
            exit;
        }
        
    }
    public function verToken(){
        $usuario = new Usuarios();
        $headers = getallheaders();
        if(!isset($headers['Authorization'])) {
            echo json_encode(['status' => false, 'message' => "sem token"]);
            exit;
        }
        $token = $headers['Authorization'] ?? null;
        $usuariosController = new UsuarioController($usuario);
        $validationResponse = $usuariosController->validarToken($token);
        if ($token === null || !$validationResponse['status']) {
            echo json_encode(['status' => false, 'message' => $validationResponse['message']]);
            exit;
        }
        echo json_encode(['status' => true, 'message' => 'Token válido','telas'=>$validationResponse['telas']]);
        exit;
    }
    public function gerarStringAlfanumerica($tamanho) {
        $numeros = '0123456789';
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringAleatoria = '';
        if($tamanho > 6){
            for ($i = 0; $i < $tamanho; $i++) {
                $index = rand(0, strlen($caracteres) - 1);
                $stringAleatoria .= $caracteres[$index];
            }
        }else{
            for ($i = 0; $i < $tamanho; $i++) {
                $index = rand(0, strlen($numeros) - 1);
                $stringAleatoria .= $numeros[$index];
                if($i==2){
                    $stringAleatoria .='-';
                }
            }
        }
        
        return $stringAleatoria;
    }
    
}