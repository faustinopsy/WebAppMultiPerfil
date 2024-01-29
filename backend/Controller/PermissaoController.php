<?php

namespace App\Controller;
use App\Database\Crud;
class PermissaoController extends Crud{
    private $permissoes;
    public function __construct($permissoes){
        parent::__construct();
        $this->permissoes=$permissoes;
    }
    public function adicionarPermissao(){
        $resultado=$this->select($this->permissoes,['nome'=> $this->permissoes->getNome()]);
        if(!$resultado){
            $this->insert($this->permissoes);
            return ['status' => true, 'message' => 'Inserido com sucesso.'];
        }
        return ['status' => false, 'message' => 'Permissão já existe.'];
    }
    public function listarPermissoes(){
        $resultadon = $this->select($this->permissoes,[]);
        if(!$resultadon){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }else{
            return $resultadon;
        }
    }

}