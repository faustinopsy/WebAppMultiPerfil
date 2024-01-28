<?php

namespace App\Controller;

use App\Model\Perfis;
use App\Model\perfilpermissoes;
use App\Database\Crud;

class PerfilPermissaoController extends Crud {
    private $perfis;
    private $perfilpermissoes;
    public function __construct(){
        parent::__construct();
    }
    public function AddPerfil($perfil,$dados){
        $resultado=$this->select($perfil,['nome'=> $dados]);
        if(!$resultado){
            $this->insert($perfil);
            return ['status' => true, 'message' => 'Inserido com sucesso.'];
        }
        return ['status' => false, 'message' => 'Perfil já existe.'];
        
    }
    public function addPermissao($permissoes,$dados){
        $resultado=$this->select($permissoes,['nome'=> $dados]);
        if(!$resultado){
            $this->insert($permissoes);
            return ['status' => true, 'message' => 'Inserido com sucesso.'];
        }
        return ['status' => false, 'message' => 'Permissão já existe.'];
        
    }
    public function addPermissaoPerfil($perfPermissoes,$chave1,$chave2){
        $resultado=$this->select($perfPermissoes,['perfilid'=> $chave1,'permissao_id'=> $chave2]);
        if(!$resultado){
            $this->insert($perfPermissoes);
            return ['status' => true, 'message' => 'Inserido com sucesso.'];
        }else{
            return ['status' => false, 'message' => 'Associação já existe.'];
        }
        
        
    }
    public function removerPermissao($perfPermissoes,$perfil, $permissoes){
        $resultado=$this->delete($perfPermissoes,['perfilid'=> $perfil->getId(), 'permissao_id'=> $permissoes->getId()]);
        if(!$resultado){
            return ['status' => false, 'message' => 'Não pode excluir.'];
        }else{
            return ['status' => true, 'message' => 'Excluido com sucesso.'];
        }
    }

    public function obterPermissoesDoPerfil($perfPermissoes,$permissoes,$perfil){
         $resultado = $this->select($perfPermissoes,['perfilid'=> $perfil->getId()]);
         $dados=[];
         foreach($resultado as $key => $value) {
            $dados[] = $this->select($permissoes,['id'=> $value['permissao_id']]);
         }
         return $dados;
    }

    public function obterPerfisDaPermissao(Permissoes $Permissoes){
        return $this->listarPerfisPorPermissao($Permissoes->getId());
    }
    public function listarPerfis($perfil){
        return $this->select($perfil,[]);
    }
    public function listarPermissoes($permissoes){
        return $this->select($permissoes,[]);
    }
    

}
