<?php

namespace App\Controller;
use App\Model\Permissoes;
use App\Database\Crud;
class PermissaoController extends Crud{
    private $Permissoes;
    public function __construct($Permissoes){
        parent::__construct();
        $this->Permissoes=$Permissoes;
    }
    public function adicionarPermissao(){
        return $this->insert($this->Permissoes);
    }
    public function listarTodosOsPerfis()
{
    $query = "SELECT id, nome FROM perfil";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function listarTodasPermissoes()
{
    $query = "SELECT id, nome FROM permissoes";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function cadPermissao($Permissoes)
{
    $query = "
        INSERT INTO permissoes (nome) VALUES (:nome)
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":nome", $Permissoes);
    return $stmt->execute();
}
public function associar($perfilId, $permissaoId)
{
    $query = "
        INSERT INTO perfil_permissoes (perfilid, permissao_id) VALUES (:perfilid, :permissao_id)
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":perfilid", $perfilId);
    $stmt->bindParam(":permissao_id", $permissaoId);
    return $stmt->execute();
}

public function desassociar($perfilId, $permissaoId)
{
    $query = "
        DELETE FROM perfil_permissoes WHERE perfilid = :perfilid AND permissao_id = :permissao_id
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":perfilid", $perfilId);
    $stmt->bindParam(":permissao_id", $permissaoId);
    return $stmt->execute();
}
public function listarPermissao($Permissoes)
{
    $query = "
    SELECT id FROM permissoes where nome=:Permissoes
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":Permissoes", $Permissoes);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function listarPerfisPorPermissao($permissaoId)
{
    $query = "
        SELECT perfil.id, perfil.nome 
        FROM perfil_permissoes
        JOIN perfil ON perfil.id = perfil_permissoes.perfilid
        WHERE perfil_permissoes.permissao_id = :permissao_id
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":permissao_id", $permissaoId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}