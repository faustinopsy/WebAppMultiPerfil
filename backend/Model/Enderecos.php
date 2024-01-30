<?php

namespace App\Model;

class Enderecos {
    private int $id;
    private string $cep;
    private string $rua;
    private string $bairro;
    private string $cidade;
    private string $estado;
    private string $latitude;
    private string $longitude;
    private int $idusuario;

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
    public function getCep(): string
    {
        return $this->cep;
    }
    public function setCep(string $cep): self
    {
        $this->cep = $cep;

        return $this;
    }
    public function getRua(): string
    {
        return $this->rua;
    }
    public function setRua(string $rua): self
    {
        $this->rua = $rua;

        return $this;
    }
    public function getBairro(): string
    {
        return $this->bairro;
    }
    public function setBairro(string $bairro): self
    {
        $this->bairro = $bairro;

        return $this;
    }
    public function getCidade(): string
    {
        return $this->cidade;
    }
    public function setCidade(string $cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }
    public function getEstado(): string
    {
        return $this->estado;
    }
    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
    public function getLatitude(): string
    {
        return $this->latitude;
    }
    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
    public function getLongitude(): string
    {
        return $this->longitude;
    }
    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

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
}
    