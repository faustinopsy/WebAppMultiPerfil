<?php

namespace App\Model;

class perfilpermissoes {
    private string $perfilid;
    private string $permissao_id;

    public function getPerfilid(): string
    {
        return $this->perfilid;
    }
    public function setPerfilid(string $perfilid): self
    {
        $this->perfilid = $perfilid;

        return $this;
    }
    public function getPermissaoId(): string
    {
        return $this->permissao_id;
    }
    public function setPermissaoId(string $permissao_id): self
    {
        $this->permissao_id = $permissao_id;

        return $this;
    }
}
