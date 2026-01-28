<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Author extends Model
{
    protected $table = 'authors';

    public function find($id)
    {
        return $this->findById($id);
    }

    public function getBooksCount($authorId)
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM books WHERE author_id = ?");
            $stmt->execute([$authorId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (\PDOException $e) {
            $this->handleError('Failed to get books count for author', $e);
        }
    }

    public function getAllWithBooksCount()
    {
        try {
            $sql = "SELECT a.*, COUNT(b.id) as books_count 
                    FROM {$this->table} a
                    LEFT JOIN books b ON a.id = b.author_id
                    GROUP BY a.id
                    ORDER BY a.name ASC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->handleError('Failed to get all authors with books count', $e);
        }
    }
}
