<?php

namespace App\Controller;
use App\Database\Crud;

class ProdutoController extends Crud{
    private $produtos;
    
    public function __construct($produto)
    {
        parent::__construct();
        $this->produtos=$produto;
       
    }
    
    public function adicionarProduto(){
        return $this->insert($this->produtos);
    }
    
    public function listarProdutos(){
        return $this->select($this->produtos,[]);
    }
    
    public function buscarPorId(int $id){
        $condicoes = ['id' => $id];
        $resultados = $this->select($this->produtos, $condicoes);
        return count($resultados) > 0 ? $resultados[0] : null;
    }
    
    public function removerProduto(){
        $condicoes = ['id' => $this->produtos->getId()];
        return $this->delete($this->produtos, $condicoes);
    }
    
    
}
