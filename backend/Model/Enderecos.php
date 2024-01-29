<?php

namespace App\Model;

class Enderecos {
    private int $id;
    private string $cep;
    private string $rua;
    private int $bairro;
    private int $cidade;
    private int $estado;
    private int $latitude;
    private int $longitude;
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
    public function getBairro(): int
    {
        return $this->bairro;
    }
    public function setBairro(int $bairro): self
    {
        $this->bairro = $bairro;

        return $this;
    }
    public function getCidade(): int
    {
        return $this->cidade;
    }
    public function setCidade(int $cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }
    public function getEstado(): int
    {
        return $this->estado;
    }
    public function setEstado(int $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
    public function getLatitude(): int
    {
        return $this->latitude;
    }
    public function setLatitude(int $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
    public function getLongitude(): int
    {
        return $this->longitude;
    }
    public function setLongitude(int $longitude): self
    {
        $this->longitude = $longitude;

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
    