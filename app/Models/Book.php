<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Book extends Model
{
    protected $table = 'books';

    public function getAllWithDetails()
    {
        try {
            $sql = "SELECT b.*, a.name as author_name, c.name as category_name 
                    FROM {$this->table} b
                    LEFT JOIN authors a ON b.author_id = a.id
                    LEFT JOIN categories c ON b.category_id = c.id
                    ORDER BY b.created_at DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->handleError('Failed to fetch books with details', $e);
        }
    }

    public function getWithDetails($id)
    {
        try {
            $sql = "SELECT b.*, a.name as author_name, a.nationality, 
                    c.name as category_name, c.description as category_description
                    FROM {$this->table} b
                    LEFT JOIN authors a ON b.author_id = a.id
                    LEFT JOIN categories c ON b.category_id = c.id
                    WHERE b.id = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->handleError("Failed to fetch book details for ID {$id}", $e);
        }
    }

    public function search($params)
    {
        try {
            $conditions = [];
            $values = [];
            
            $sql = "SELECT b.*, a.name as author_name, c.name as category_name 
                    FROM {$this->table} b
                    LEFT JOIN authors a ON b.author_id = a.id
                    LEFT JOIN categories c ON b.category_id = c.id
                    WHERE 1=1";
            
            if (!empty($params['title'])) {
                $conditions[] = "b.title LIKE ?";
                $values[] = "%{$params['title']}%";
            }
            
            if (!empty($params['author'])) {
                $conditions[] = "a.name LIKE ?";
                $values[] = "%{$params['author']}%";
            }
            
            if (!empty($params['category_id'])) {
                $conditions[] = "b.category_id = ?";
                $values[] = $params['category_id'];
            }
            
            if (!empty($params['year_from'])) {
                $conditions[] = "b.publication_year >= ?";
                $values[] = $params['year_from'];
            }
            
            if (!empty($params['year_to'])) {
                $conditions[] = "b.publication_year <= ?";
                $values[] = $params['year_to'];
            }
            
            if (!empty($conditions)) {
                $sql .= " AND " . implode(" AND ", $conditions);
            }
            
            $sql .= " ORDER BY b.title ASC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->handleError('Failed to search books', $e);
        }
    }

    public function autocomplete($query)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT id, title, isbn FROM {$this->table} 
                 WHERE title LIKE ? 
                 ORDER BY title ASC 
                 LIMIT 10"
            );
            $stmt->execute(["%{$query}%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->handleError('Failed to autocomplete books', $e);
        }
    }
}
