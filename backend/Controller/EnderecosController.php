<?php

namespace App\Controller;
use App\Database\Crud;

class EnderecosController extends Crud{
    private $enderecos;
    private $saloes;
    public function __construct($enderecos, $saloes){
        parent::__construct();
        $this->enderecos = $enderecos;
        $this->saloes = $saloes;
    }
    
    public function adicionarEndereco(){
        if($this->insert($this->enderecos->getTable(),$this->enderecos->toArray())){
            return ['status' => true, 'message' => 'Inserido com sucesso.'];
        }
    }
    public function listarEndereco(){
        $conditions = ['bairro' => ['LIKE', $this->enderecos->getBairro()]];
        $resultadon = $this->select($this->enderecos->getTable(),$conditions);
        $dados=[];
        if(!$resultadon){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }else{
            foreach($resultadon as $value) {
                $dados[] = $this->select($this->saloes->getTable(),['id'=> $value['idsalao']]);
             }
             return  $dados ;
        }
    }
    public function listarEnderecoGEO($latMin, $latMax, $longMin, $longMax) {
        $conditions = ['latitude' => ['BETWEEN', [$latMin, $latMax]]];
        $resultadoEnderecos = $this->select($this->enderecos->getTable(), $conditions);
    
        if (!$resultadoEnderecos) {
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        } else {
            $dados = [];
            foreach ($resultadoEnderecos as $endereco) {
                $detalhesSalao = $this->select($this->saloes->getTable(), ['id' => $endereco['idsalao']]);
                $detalheSalao = $detalhesSalao[0] ?? null;
    
                if ($detalheSalao) {
                    $dadosUnidos = array_merge($endereco, $detalheSalao);
                    $dados[] = $dadosUnidos;
                }
            }
            return $dados;
        }
    }
    
    public function buscarPorBairro(){
        $condicoes = ['bairro' => $this->enderecos->getBairro()];
        $resultados = $this->select($this->enderecos->getTable(), $condicoes);
        $resultadon = count($resultados) > 0 ? $resultados[0] : false;
        if(!$resultadon){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }else{
            return $resultadon;
        }
    }
    public function buscarPorId(){
        $condicoes = ['id' => $this->enderecos->getId()];
        $resultados = $this->select($this->enderecos->getTable(), $condicoes);
        $resultadon = count($resultados) > 0 ? $resultados[0] : false;
        if(!$resultadon){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }else{
            return $resultadon;
        }
    }
    
    public function removerEndereco(){
        $condicoes = ['idsalao' => $this->saloes->getId()];
        $resultado = $this->delete($this->enderecos->getTable(), $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Não pode excluir.'];
        }else{
            return ['status' => true, 'message' => 'Excluido com sucesso.'];
        }
    }
}
