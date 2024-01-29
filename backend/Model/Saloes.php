<?php

namespace App\Model;

class Saloes {
    private int $id;
    private string $nome;
    private int $idusuario;
    private int $idendereco;
    private int $ativo;

    public function __construct()
    {
       
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): self
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
    
    public function getIdusuario(): int
    {
        return $this->idusuario;
    }
    public function setIdusuario(int $idusuario): self
    {
        $this->idusuario = $idusuario;

        return $this;
    }
    public function getIdendereco(): int
    {
        return $this->idendereco;
    }
    public function setIdendereco(int $idendereco): self
    {
        $this->idendereco = $idendereco;

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
    