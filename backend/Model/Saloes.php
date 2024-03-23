<?php

namespace App\Model;
use Ramsey\Uuid\Uuid;
class Saloes {
    private  $id;
    private string $nome;
    private string $idusuario;
    private string $servicos;
    private int $ativo;

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
    
    public function getIdusuario(): string
    {
        return $this->idusuario;
    }
    public function setIdusuario(string $idusuario): self
    {
        $this->idusuario = $idusuario;

        return $this;
    }
    public function getServicos(): string
    {
        return $this->servicos;
    }
    public function setServicos(string $servicos): self
    {
        $this->servicos = $servicos;

        return $this;
    }

    public function getAtivo(): int
    {
        return $this->ativo;
    }

    public function setAtivo(int $ativo): self
    {
        $this->ativo = $ativo;

        return $this;
    }
    }
    