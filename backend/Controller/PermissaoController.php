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
        $resultado=$this->select($this->permissoes->getTable(),['nome'=> $this->permissoes->getNome()]);
        if(!$resultado){
            $this->insert($this->permissoes->getTable(),['id'=> $this->permissoes->getId(),'nome'=> $this->permissoes->getNome()] );
            return ['status' => true, 'message' => 'Inserido com sucesso.'];
        }
        return ['status' => false, 'message' => 'Permissão já existe.'];
    }
    public function listarPermissoes(){
        $resultadon = $this->select($this->permissoes->getTable(),[]);
        if(!$resultadon){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }else{
            return $resultadon;
        }
    }
    public function removerPermissao(){
        $resultado=$this->delete($this->permissoes->getTable(),['id'=> $this->permissoes->getId()]);
        if(!$resultado){
            return ['status' => false, 'message' => 'Não pode excluir.'];
        }else{
            return ['status' => true, 'message' => 'Excluido com sucesso.'];
        }
    }
}