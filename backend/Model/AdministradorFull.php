<?php

namespace App\Model;
use Ramsey\Uuid\Uuid;
class AdministradorFull extends Usuarios {
    public function __construct(){
        $this->id = Uuid::uuid4()->toString();
    }
    public function getPermissoesTela() {
        return ['admin', 'mapa', 'minhaarea'];
    }
}