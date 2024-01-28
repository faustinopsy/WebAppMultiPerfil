<?php

namespace App\Model;

class Produtos {
    private int $id;
    private string $nome;
    private string $preco;
    private int $quantidade;
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
    public function getPreco(): string
    {
        return $this->preco;
    }
    public function setPreco(string $preco): self
    {
        $this->preco = $preco;

        return $this;
    }
    public function getQuantidade(): int
    {
        return $this->quantidade;
    }
    public function setQuantidade(int $quantidade): self
    {
        $this->quantidade = $quantidade;

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
    