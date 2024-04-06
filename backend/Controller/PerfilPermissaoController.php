<?php

namespace App\Controller;

use App\Database\Crud;

class PerfilPermissaoController extends Crud {
    private $perfis;
    private $perfilpermissoes;
    public function __construct($perfPermissoes){
        parent::__construct();
        $this->perfilpermissoes = $perfPermissoes;
    }
    public function addAssociarPermissaoPerfil(){
        $resultado=$this->select($this->perfilpermissoes->getTable(),['perfilid'=> $this->perfilpermissoes->getPerfilid(), 'permissao_id'=> $this->perfilpermissoes->getPermissaoId()]);
        if(!$resultado){
            $this->insert($this->perfilpermissoes->getTable(),['perfilid'=> $this->perfilpermissoes->getPerfilid(),'permissao_id'=>$this->perfilpermissoes->getPermissaoId() ]);
            return ['status' => true, 'message' => 'Inserido com sucesso.'];
        }else{
            return ['status' => false, 'message' => 'Associação já existe.'];
        }
    }
    public function removerPermissao(){
        $resultado=$this->delete($this->perfilpermissoes->getTable(),['perfilid'=> $this->perfilpermissoes->getPerfilid(), 'permissao_id'=> $this->perfilpermissoes->getPermissaoId()]);
        if(!$resultado){
            return ['status' => false, 'message' => 'Não pode excluir.'];
        }else{
            return ['status' => true, 'message' => 'Excluido com sucesso.'];
        }
    }

    public function obterPermissoesDoPerfil($permissoes){
         $resultado = $this->select($this->perfilpermissoes->getTable(),['perfilid'=> $this->perfilpermissoes->getPerfilid()]);
         $dados=[];
         foreach($resultado as $key => $value) {
            $dados[] = $this->select($permissoes->getTable(),['id'=> $value['permissao_id']]);
         }
         return $dados;
    }

}
