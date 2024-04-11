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
            case '36da7520-db20-4963-807e-2d0a6ad938a2':
                return new UsuarioComum();
            case 'admin':
                return new UsuarioAdmin();
            case 'd448d881-a39a-4652-92b1-1359cd0dd8b2':
                return new AdministradorFull();
            case 'full':
                return new AdministradorFull();
            default:
                throw new InvalidArgumentException("Tipo de perfil inválido");
        }
    }
}

