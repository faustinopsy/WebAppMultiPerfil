<?php

namespace App\Service;
use App\Model\UsuarioComum;
use App\Model\UsuarioAdmin;
use App\Model\AdministradorFull;
use InvalidArgumentException;
class UsuarioFactory {
    public static function criarUsuario($tipoPerfil) {
        switch ($tipoPerfil) {
            case 'comum':
                return new UsuarioComum();
            case 'admin':
                return new UsuarioAdmin();
            case 'full':
                return new AdministradorFull();
            default:
                throw new InvalidArgumentException("Tipo de perfil inválido");
        }
    }
}

