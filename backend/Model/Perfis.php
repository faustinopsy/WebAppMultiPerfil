<?php

namespace App\Model;
use Ramsey\Uuid\Uuid;
class Perfis {
    private $id;
    private string $nome;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
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
