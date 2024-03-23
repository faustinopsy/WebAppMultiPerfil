<?php

namespace App\Controller;
use App\Database\Crud;

class SaloesController extends Crud{
    private $saloes;
    
    public function __construct($saloes)
    {
        parent::__construct();
        $this->saloes=$saloes;
       
    }
    
    public function adicionarSalao(){
        $resultado=$this->select($this->saloes,['nome'=> $this->saloes->getNome()]);
        if(!$resultado){
            $this->insert($this->saloes);
            $idSalao = $this->getLastInsertId();
            return ['status' => true, 'message' => 'Inserido com sucesso.', 'idSalao'=> $idSalao ];
        }
        return ['status' => false, 'message' => 'Salão já existe.'];
    }
    
    public function listarSalao(){
        $resultado = $this->select($this->saloes,[]);
        if(!$resultado){
            return $resultado;
        }else{
            return $resultado;
        }
    }
    public function listarMeuSalao($enderecos){
        $resultado = $this->select($this->saloes,['idusuario'=>$this->saloes->getIdusuario()]);
        if(!$resultado){
            return $resultado;
        }
        $condicoes = ['idsalao' => $resultado[0]["id"]];
        $resultados = $this->select($enderecos, $condicoes);
        $resultadon = count($resultados) > 0 ? ['endereco'=> true] : ['endereco'=> false] ;
        $novoarray[0] = array_merge($resultado[0],$resultadon);
        return $novoarray;
        
    }
    public function buscarPorId(int $id){
        $condicoes = ['id' => $id];
        $resultados = $this->select($this->saloes, $condicoes);
        $resultadon = count($resultados) > 0 ? $resultados[0] : null;
        if(!$resultadon){
            return ["status" => false, "Saloes" => $resultadon,"mensagem"=>"nenhum resultado encontrado"];
        }else{
            return $resultadon;
        }
    }
    
    public function removerSalao(){
        $condicoes = ['id' => $this->saloes->getId()];
        $resultado = $this->delete($this->saloes, $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Não pode excluir.'];
        }else{
            return ['status' => true, 'message' => 'Excluido com sucesso.'];
        }
    }
    
    
}
