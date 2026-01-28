<?php

namespace App\Core;

use PDO;
use PDOException;

class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = $this->getConnection();
    }

    private function getConnection()
    {
        $config = require __DIR__ . '/../../config/database.php';
        
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
            $pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
            return $pdo;
        } catch (PDOException $e) {
            $this->logError('Database connection failed', $e);
            throw new \Exception('Unable to connect to the database. Please try again later.');
        }
    }

    protected function logError($message, $exception = null)
    {
        $logFile = __DIR__ . '/../../storage/logs/database_errors.log';
        $logDir = dirname($logFile);

        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] {$message}";
        
        if ($exception) {
            $logMessage .= " - Error: " . $exception->getMessage();
            $logMessage .= " in " . $exception->getFile() . " (Line: " . $exception->getLine() . ")";
        }
        
        $logMessage .= "\n";
        @file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    protected function handleError($message, $exception)
    {
        $this->logError($message, $exception);
        throw new \Exception($message);
    }

    public function create($data)
    {
        try {
            $fields = array_keys($data);
            $values = array_values($data);
            $placeholders = array_fill(0, count($fields), '?');
            
            $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);
            
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            $this->handleError("Failed to create record in {$this->table}", $e);
        }
    }

    public function findById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->handleError("Failed to find record by ID in {$this->table}", $e);
        }
    }

    public function find($id)
    {
        return $this->findById($id);
    }

    public function all()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM {$this->table}");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->handleError("Failed to fetch all records from {$this->table}", $e);
        }
    }

    public function update($id, $data)
    {
        try {
            $fields = [];
            foreach (array_keys($data) as $field) {
                $fields[] = "$field = ?";
            }
            
            $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = ?";
            
            $values = array_values($data);
            $values[] = $id;
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            $this->handleError("Failed to update record in {$this->table}", $e);
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            $this->handleError("Failed to delete record from {$this->table}", $e);
        }
    }
}
