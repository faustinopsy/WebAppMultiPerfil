<?php

namespace App\Controller;
use App\Database\Crud;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class UsuarioController extends Crud{
    private $usuarios;
    public function __construct($usuario)
    {
        parent::__construct();
        $this->usuarios=$usuario;
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
    public function validarToken($token)
    {
        $authService = new TokenController();
        return $authService->validarToken($this->usuarios,$token);
    }

    public function login($senha, $lembrar)
    {
        $authService = new TokenController();
        return $authService->login($this->usuarios, $senha, $lembrar);
    }
    public function recupasenha(){
        $novasenha = $this->gerarStringAlfanumerica(8);
        $condicoes = ['email' => $this->usuarios->getEmail()];
        $resultado = $this->select($this->usuarios->getTable(), $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Usuário não encontrado.'];
        }
        $email= new EnviaEMail();
        $dados=['email'=>$this->usuarios->getEmail(),'senha'=>$novasenha];
        if($email->recupera($dados)){
            $senhacriptografada=password_hash($novasenha, PASSWORD_DEFAULT);
            $this->update($this->usuarios->getTable(),['senha'=> $senhacriptografada],$condicoes);
            return ['status'=>true,'message'=>'E-mail enviado com sucesso!'];
        }else {
            return ['status'=>false,'message'=>'falha ao enviar email!'];
        }
    }
    public function verificacodigo($codigo){
        $condicoes = ['email' => $this->usuarios->getEmail(), 'codigo'=> $codigo];
        $resultado = $this->select('codigo', $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Token não encontrado.'];
        }
        return ['status'=>true,'message'=>'Código validado com sucesso!'];
        
    }
    public function ativarTwoFactor(){
        $condicoes = ['email' => $this->usuarios->getEmail()];
        $resultado = $this->update($this->usuarios->getTable(),['twofactor'=>$this->usuarios->getTwoFactor()], $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Nenhum resultado a retornar'];
        }else{
            return ['status' => true, 'message' => 'ativado com sucesso.'];
        }
    }
    public function alterarSenha($senhaantiga,$novasenha){
        $novasenha = $this->gerarStringAlfanumerica(8);
        $condicoes = ['email' => $this->usuarios->getEmail()];
        $resultado = $this->select($this->usuarios->getTable(), $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Usuário não encontrado.'];
        }
        if (!password_verify($senhaantiga, $resultado[0]['senha'])) {
            return ['status' => false, 'message' => 'Senha incorreta.'];
        }
        if($this->update($this->usuarios->getTable(),['senha'=> $novasenha],$condicoes)){
            return ['status' => true, 'message' => 'senha alterada com sucesso'];
        }
        
    }
    public function adicionarUsuario(){
        return $this->insert($this->usuarios->getTable(),$this->usuarios->toArray());
    }
    public function listarUsuarios(){
        $resultados = $this->select($this->usuarios->getTable(),[]);
        if(empty($resultados)){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }
        foreach ($resultados as &$usuario) {
            unset($usuario['senha']);
        }
        return $resultados;
    }
    
    public function buscarPorEmail(string $email){
        $condicoes = ['email' => $email];
        $resultados = $this->select($this->usuarios->getTable(), $condicoes);
        $resultadon = count($resultados) > 0 ? $resultados[0] : false;
        if(!$resultadon){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }else{
            return $resultadon;
        }
    }
    public function bloquearPorEmail(){
        $condicoes = ['email' => $this->usuarios->getEmail()];
        $resultado = $this->update($this->usuarios->getTable(),['ativo'=>$this->usuarios->getAtivo()], $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Nenhum resultado a retornar'];
        }else{
            return ['status' => true, 'message' => 'BLoqueado com sucesso.'];
        }
    }
    public function AlterarPerfil(){
        $condicoes = ['email' => $this->usuarios->getEmail()];
        $resultado = $this->update($this->usuarios->getTable(), ['perfil'=>$this->usuarios->getPerfil()], $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Nenhum resultado a retornar'];
        }else{
            return ['status' => true, 'message' => 'Perfil Alterado com sucesso.'];
        }
        
    }
    public function buscarPorId(string $id){
        $condicoes = ['id' => $id];
        $resultados = $this->select($this->usuarios->getTable(), $condicoes);
        unset($resultados[0]['senha']);
        $resultadon = count($resultados) > 0 ? $resultados[0] : null;
        if(!$resultadon){
            return ['status' => false, 'message' => 'Nenhum resultado a retornar'];
        }else{
            return $resultadon;
        }
    }
    
    public function removerUsuario(){
        $condicoes = ['email' => $this->usuarios->getEmail()];
        $resultado = $this->delete($this->usuarios->getTable(), $condicoes);
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
