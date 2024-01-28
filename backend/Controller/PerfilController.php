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
        return $this->insert($this->perfil);
    }

}
