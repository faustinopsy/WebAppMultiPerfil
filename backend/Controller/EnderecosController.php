<?php

namespace App\Controller;
use App\Database\Crud;

class EnderecosController extends Crud{
    private $enderecos;
    
    public function __construct($enderecos)
    {
        parent::__construct();
        $this->enderecos=$enderecos;
       
    }
    
    public function adicionarEndereco(){
        if($this->insert($this->enderecos)){
            return ['status' => true, 'message' => 'Inserido com sucesso.'];
        }
    }
    
    public function listarEndereco(){
        $resultadon = $this->select($this->enderecos,[]);
        if(!$resultadon){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }else{
            return $resultadon;
        }
    }
    
    public function buscarPorId(int $id){
        $condicoes = ['id' => $id];
        $resultados = $this->select($this->enderecos, $condicoes);
        $resultadon = count($resultados) > 0 ? $resultados[0] : false;
        if(!$resultadon){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }else{
            return $resultadon;
        }
    }
    
    public function removerEndereco(){
        $condicoes = ['id' => $this->enderecos->getId()];
        $resultado = $this->delete($this->enderecos, $condicoes);
        if(!$resultado){
            return ['status' => false, 'message' => 'Não pode excluir.'];
        }else{
            return ['status' => true, 'message' => 'Excluido com sucesso.'];
        }
    }
}
