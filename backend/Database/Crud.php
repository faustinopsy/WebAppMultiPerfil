<?php
namespace App\Database;

use App\Cryptonita\Crypto;
use App\Database\Connection;
use Exception;
use PDO;
use ReflectionProperty;
class Crud extends Connection{
    public function __construct() {
        parent::__construct();
    }
    public function getLastInsertId() {
        return $this->conn->lastInsertId();
    }
    public function insert($object) {
    try{
        $reflectionClass = new \ReflectionClass($object);
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PRIVATE);
        $table = strtolower($reflectionClass->getShortName());
        $data = [];
        foreach ($properties as $property) {
            $property->setAccessible(true); 
            if ($property->getName() === 'id') { 
                continue;
            }
            $data[$property->getName()] = $property->getValue($object);
        }
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value); 
        }
        return $stmt->execute();
    }catch (Exception $exception) {
        echo "error: " . $exception->getMessage();
    }
    }
    public function select($object, $conditions = []) {
        try {
            $reflectionClass = new \ReflectionClass($object);
            $table = strtolower($reflectionClass->getShortName());
            $query = "SELECT * FROM $table";
    
            $conditionStrings = [];
    
            foreach ($conditions as $key => $condition) {
                if (is_array($condition) && count($condition) == 2) {
                    $operator = strtoupper($condition[0]);
                    
                    switch ($operator) {
                        case 'LIKE':
                            $conditionStrings[] = "$key LIKE :$key";
                            break;
                        case 'BETWEEN':
                            if (is_array($condition[1]) && count($condition[1]) == 2) {
                                $conditionStrings[] = "$key BETWEEN :{$key}_min AND :{$key}_max";
                            }
                            break;
                    }
                } else {
                    
                    $conditionStrings[] = "$key = :$key";
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
        } catch (Exception $exception) {
            echo "error: " . $exception->getMessage();
        }
    }
    
    
    public function update($object, $conditions) {
        try {
            $reflectionClass = new \ReflectionClass($object);
            $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PRIVATE);
            $table = strtolower($reflectionClass->getShortName());
            $data = [];
            foreach ($properties as $property) {
                $property->setAccessible(true);
                $propertyName = $property->getName();
                $propertyValue = $property->getValue($object);
    
                if ($propertyName === 'id' || $propertyValue === 0 || $propertyValue === '') {
                    continue;
                }
                $data[$propertyName] = $propertyValue;
            }
            
            if (count($data) === 0) {
                throw new Exception("Não há dados para atualizar.");
            }
    
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
        } catch (Exception $exception) {
            echo "error: " . $exception->getMessage();
        }
    }
    
    public function delete($object, $conditions) {
        $reflectionClass = new \ReflectionClass($object);
        $table = strtolower($reflectionClass->getShortName());
        $conditionsStr = implode(" AND ", array_map(function($item) {
            return "$item = :$item";
        }, array_keys($conditions)));
        $query = "DELETE FROM $table WHERE $conditionsStr";
        $stmt = $this->conn->prepare($query);
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
    }
   


}
