<?php
namespace App\Database;

use PDO;
use PDOException;
class Crud extends Connection {
    public function __construct() {
        parent::__construct();
    }
    public function getLastInsertId() {
        try {
            return $this->conn->lastInsertId();
        } catch (PDOException $exception) {
            throw new PDOException("Erro ao obter o último ID inserido: " . $exception->getMessage());
        }
    }
    public function insert($table, $data) {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($query);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            return $stmt->execute();
        } catch (PDOException $exception) {
            throw new PDOException("Erro ao criar registro: " . $exception->getMessage());
        }
    }
    public function select($table, $conditions = []) {
        try {
            $query = "SELECT * FROM $table";
            $conditionStrings = [];
            foreach ($conditions as $key => $condition) {
                $operator = is_array($condition) ? strtoupper($condition[0]) : '=';
                switch ($operator) {
                    case 'LIKE':
                        $conditionStrings[] = "$key LIKE :$key";
                        break;
                    case 'BETWEEN':
                        if (is_array($condition[1]) && count($condition[1]) == 2) {
                            $conditionStrings[] = "$key BETWEEN :{$key}_min AND :{$key}_max";
                        }
                        break;
                    default:
                        $conditionStrings[] = "$key = :$key";
                        break;
                }
            }
            if (!empty($conditionStrings)) {
                $query .= " WHERE " . implode(" AND ", $conditionStrings);
            }
            $stmt = $this->conn->prepare($query);
            foreach ($conditions as $key => $condition) {
                if (is_array($condition) && count($condition) == 2) {
                    $operator = strtoupper($condition[0]);
                    switch ($operator) {
                        case 'LIKE':
                            $stmt->bindValue(":$key", $condition[1]);
                            break;
                        case 'BETWEEN':
                            if (is_array($condition[1]) && count($condition[1]) == 2) {
                                $stmt->bindValue(":{$key}_min", $condition[1][0]);
                                $stmt->bindValue(":{$key}_max", $condition[1][1]);
                            }
                            break;
                    }
                } else {
                    $stmt->bindValue(":$key", $condition);
                }
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            throw new PDOException("Erro ao ler registros: " . $exception->getMessage());
        }
    }
    public function update($table, $data, $conditions) {
        try {
            $dataStr = implode(", ", array_map(function($item) {
                return "$item = :$item";
            }, array_keys($data)));
            $conditionsStr = implode(" AND ", array_map(function($item) {
                return "$item = :condition_$item";
            }, array_keys($conditions)));
            $query = "UPDATE $table SET $dataStr WHERE $conditionsStr";
            $stmt = $this->conn->prepare($query);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":condition_$key", $value);
            }
            return $stmt->execute();
        } catch (PDOException $exception) {
            throw new PDOException("Erro ao atualizar registro: " . $exception->getMessage());
        }
    }
    public function delete($table, $conditions) {
        try {
            $conditionsStr = implode(" AND ", array_map(function($item) {
                return "$item = :$item";
            }, array_keys($conditions)));
            $query = "DELETE FROM $table WHERE $conditionsStr";
            $stmt = $this->conn->prepare($query);
            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            return $stmt->execute();
        } catch (PDOException $exception) {
            throw new PDOException("Erro ao deletar registro: " . $exception->getMessage());
        }
    }
}
