<?php

namespace App\Controller;
use App\Database\Crud;
use App\Model\Usuarioa;
use App\Model\PerfilPermissoes;
use App\Model\Permissoes;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;
use App\Cryptonita\Crypto;

class UsuarioController extends Crud{
    private $usuarios;
    private $PerfilPermissoes;
    private $permissoes;
    public function __construct($usuario)
    {
        parent::__construct();
        $this->usuarios=$usuario;
        $this->PerfilPermissoes = new PerfilPermissoes();
        $this->permissoes = new Permissoes();
    }
    public function idUser($token){
       
        $key = TOKEN;
        $algoritimo = 'HS256';
        try {
            $decoded = JWT::decode($token, new Key($key, $algoritimo));
            return $decoded->sub;
        } catch(Exception $e) {
            return ['status' => false, 'message' => 'Token inválido! Motivo: ' . $e->getMessage()];
        }
    }
    public function validarToken($token){
        $key = TOKEN;
        $algoritimo = 'HS256';
        try {
            $decoded = JWT::decode($token, new Key($key, $algoritimo));
            $condicoes = ['id' => $decoded->sub];
            $resultado = $this->select($this->usuarios, $condicoes);
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
    public function login($senha,$lembrar) {
        $condicoes = ['email' => $this->usuarios->getEmail(),'ativo' => 1];
        $resultado = $this->select($this->usuarios, $condicoes);
        $checado=$lembrar? 60*12 : 3;
        $permissoes=[];
        if (!$resultado) {
            return ['status' => false, 'message' => 'Usuário não encontrado ou bloqueado.'];
        }
        if (!password_verify($senha, $resultado[0]['senha'])) {
            return ['status' => false, 'message' => 'Senha incorreta.'];
        }
        $perfper = $this->select($this->PerfilPermissoes,['perfilid'=>$resultado[0]['perfilid']]);
        foreach($perfper as $key => $value){
            $permissoes[] = $this->select($this->permissoes,['id'=>$value['permissao_id']]);
        } 
        foreach ($permissoes as $permissaoArray) {
            foreach ($permissaoArray as $permissao) {
                if (isset($permissao['nome'])) {
                    $permissoesNomes[] = $permissao['nome'];
                }
            }
        }
        $key = TOKEN;
        $local=$_SERVER['HTTP_HOST'];
        $nome=$_SERVER['SERVER_NAME'];
        $algoritimo='HS256';
            $payload = [
                "iss" =>  $local,
                "aud" =>  $nome,
                "iat" => time(),
                "exp" => time() + (60 * $checado),  
                "sub" => $resultado[0]['id'],
                'telas'=>$permissoesNomes
            ];
            
            $jwt = JWT::encode($payload, $key,$algoritimo);
        return ['status' => true, 'message' => 'Login bem-sucedido!','token'=>$jwt,'telas'=>$permissoesNomes];
    }
    public function recupasenha(){
        $novasenha = $this->gerarStringAlfanumerica(8);
        $condicoes = ['email' => $this->usuarios->getEmail()];
        $resultado = $this->select($this->usuarios, $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Usuário não encontrado.'];
        }
        $email= new EnviaEMail();
        $dados=['email'=>$this->usuarios->getEmail(),'senha'=>$novasenha];
        $emailuser = $this->usuarios->getEmail();
        if($email->recupasenha($dados)){
            $senhacriptografada=password_hash($novasenha, PASSWORD_DEFAULT);
            $query = "UPDATE usuario SET senha=:senha WHERE email=:email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':senha', $senhacriptografada);
            $stmt->bindParam(':email', $emailuser);
            $stmt->execute();
            return ['status'=>true,'message'=>'E-mail enviado com sucesso!'];
        }else {
            return ['status'=>false,'message'=>'falha ao enviar email!'];
        }
    }
    public function adicionarUsuario(){
        return $this->insert($this->usuarios);
    }
    
    public function listarUsuarios(){
        $resultadon = $this->select($this->usuarios,[]);
        if(!$resultadon){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }else{
            return $resultadon;
        }
    }
    
    public function buscarPorEmail(string $email){
        $condicoes = ['email' => $email];
        $resultados = $this->select($this->usuarios, $condicoes);
        $resultadon = count($resultados) > 0 ? $resultados[0] : false;
        if(!$resultadon){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }else{
            return $resultadon;
        }
    }
    public function bloquearPorEmail(){
        $condicoes = ['email' => $this->usuarios->getEmail()];
        $resultado = $this->update($this->usuarios, $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Nenhum resultado a retornar'];
        }else{
            return ['status' => true, 'message' => 'BLoqueado com sucesso.'];
        }
        
    }
    public function buscarPorId(int $id){
        $condicoes = ['id' => $id];
        $resultados = $this->select($this->usuarios, $condicoes);
        $resultadon = count($resultados) > 0 ? $resultados[0] : null;
        if(!$resultadon){
            return ['status' => false, 'message' => 'Nenhum resultado a retornar'];
        }else{
            return $resultadon;
        }
    }
    
    public function removerUsuario(){
        $condicoes = ['email' => $this->usuarios->getEmail()];
        $resultado = $this->delete($this->usuarios, $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Não pode excluir.'];
        }else{
            return ['status' => true, 'message' => 'Excluido com sucesso.'];
        }
    }
    public function gerarStringAlfanumerica($tamanho) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringAleatoria = '';
        for ($i = 0; $i < $tamanho; $i++) {
            $index = rand(0, strlen($caracteres) - 1);
            $stringAleatoria .= $caracteres[$index];
        }
        return $stringAleatoria;
    }
    
    
}
