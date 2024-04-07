<?php

namespace App\Model;
use Ramsey\Uuid\Uuid;
class Usuarios {
    protected string $id;
    protected string $nome;
    protected string $email;
    protected string $senha;
    protected string $perfil;
    protected int $ativo;
    protected int $twofactor;
    protected string $table='usuarios';

    public function __construct(){
        $this->id = Uuid::uuid4()->toString();
    }
    public function getPermissoesTela() {
    }    public function getTable(): string
    {
        return $this->table;
    }
    public function getId(): string
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
    public function getPerfil(): string
    {
        return $this->perfil;
    }

    public function setPerfil(string $perfil): void
    {
        if($perfil == 0 || $perfil=='0'){
            $this->perfil = '';
            return;
        }
        $this->perfil = $perfil;
    }
    public function getAtivo(): int{
        return $this->ativo;
    }
    public function setAtivo(int $ativo): void{
        $this->ativo = $ativo;
    }
    public function getTwoFactor(): int{
        return $this->twofactor;
    }
    public function setTwoFactor(int $twofactor): void{
        $this->twofactor = $twofactor;
    }
    public function toArray() {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha,
            'ativo' => $this->ativo,
            'perfil' => $this->perfil,
            'twofactor' => $this->twofactor
        ];
    }
}
