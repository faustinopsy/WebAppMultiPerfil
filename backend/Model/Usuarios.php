<?php

namespace App\Model;
use Ramsey\Uuid\Uuid;
class Usuarios {
    private $id;
    private string $nome;
    private string $email;
    private string $senha;
    private string $perfilid;
    private int $ativo;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        if($nome == 0 || $nome=='0'){
            $this->nome = '';
            return;
        }
        $this->nome = $nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("E-mail inválido");
        }

        $this->email = $email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): void
    {
        if($senha == 0 || $senha=='0'){
            $this->senha = '';
            return;
        }
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }
    public function getPerfilId(): string
    {
        return $this->perfilid;
    }

    public function setPerfilId(string $perfilid): void
    {
        if($perfilid == 0 || $perfilid=='0'){
            $this->perfilid = '';
            return;
        }
        $this->perfilid = $perfilid;
    }
    public function getAtivo(): int
    {
        return $this->ativo;
    }

    public function setAtivo(int $ativo): void
    {
        $this->ativo = $ativo;
    }
}
