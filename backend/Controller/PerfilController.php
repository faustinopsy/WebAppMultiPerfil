<?php

namespace App\Controller;

use App\Database\Crud;

class PerfilController extends Crud{
    private $perfil;
    public function __construct($perfil){
        parent::__construct();
        $this->perfil=$perfil;
    }
    public function adicionarPerfil(){
        $resultado=$this->select($this->perfil->getTable(),['nome'=> $this->perfil->getNome()]);
        if(!$resultado){
            $this->insert($this->perfil->getTable(),['id'=> $this->perfil->getId(),'nome'=> $this->perfil->getNome()]);
            return ['status' => true, 'message' => 'Inserido com sucesso.'];
        }
        return ['status' => false, 'message' => 'Perfil já existe.'];
    }
    public function listarPerfis(){
        $resultadon =  $this->select($this->perfil->getTable(),[]);
        if(!$resultadon){
            return ['status' => false, 'message' => 'Não existe dados a retornar.'];
        }else{
            return $resultadon;
        }
    }
    public function removerPerfil(){
        $resultado=$this->delete($this->perfil->getTable(),['id'=> $this->perfil->getId()]);
        if(!$resultado){
            return ['status' => false, 'message' => 'Não pode excluir.'];
        }else{
            return ['status' => true, 'message' => 'Excluido com sucesso.'];
        }
    }
}
