<?php

namespace App\Controller;
use App\Database\Crud;

class AnaliticosController extends Crud{
    private $analitico;
    
    public function __construct($analitico)
    {
        parent::__construct();
        $this->analitico=$analitico;
       
    }
    
    public function adicionarAnalitico(){
        return $this->insert($this->analitico);
    }
    
    public function listarAnalitico(){
        return $this->select($this->analitico,[]);
    }
    
    public function buscarPorId(int $id){
        $condicoes = ['id' => $id];
        $resultados = $this->select($this->analitico, $condicoes);
        return count($resultados) > 0 ? $resultados[0] : null;
    }
    
    public function removerAnalitico(){
        $condicoes = ['id' => $this->analitico->getId()];
        return $this->delete($this->analitico, $condicoes);
    }
    
    
}
