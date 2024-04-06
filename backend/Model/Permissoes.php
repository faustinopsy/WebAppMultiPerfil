<?php

namespace App\Model;
use Ramsey\Uuid\Uuid;
class Permissoes
{
    private string $id;
    private string $nome;
    private string $table='permissoes';
    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }
    public function getTable(): string
    {
        return $this->table;
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function getNome(): string
    {
        return $this->nome;
    }
    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    
}
