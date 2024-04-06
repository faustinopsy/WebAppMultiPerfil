<?php

namespace App\Controller;
use App\Database\Crud;

class AnaliticosController extends Crud{
    private $analitico;
    
    public function __construct($analitico){
        parent::__construct();
        $this->analitico=$analitico;
       
    }
    public function adicionarAnalitico(){
        return $this->insert($this->analitico->getTable(),[$this->analitico->toArray()]);
    }
    public function listarAnalitico(){
        return $this->select($this->analitico->getTable(),[]);
    }
    public function buscarPorId(int $id){
        $condicoes = ['id' => $id];
        $resultados = $this->select($this->analitico->getTable(), $condicoes);
        return count($resultados) > 0 ? $resultados[0] : null;
    }
    public function removerAnalitico(){
        $condicoes = ['id' => $this->analitico->getId()];
        return $this->delete($this->analitico->getTable(), $condicoes);
    }
}
