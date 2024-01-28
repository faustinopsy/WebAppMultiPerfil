<?php

namespace App\Model;

class perfilpermissoes {
    private int $perfilid;
    private int $permissao_id;

    public function getPerfilid(): int
    {
        return $this->perfilid;
    }
    public function setPerfilid(int $perfilid): self
    {
        $this->perfilid = $perfilid;

        return $this;
    }
    public function getPermissaoId(): int
    {
        return $this->permissao_id;
    }
    public function setPermissaoId(int $permissao_id): self
    {
        $this->permissao_id = $permissao_id;

        return $this;
    }
}
