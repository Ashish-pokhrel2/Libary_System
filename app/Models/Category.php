<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Category extends Model
{
    protected $table = 'categories';

    public function getBooksCount($categoryId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM books WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getAllWithBooksCount()
    {
        $sql = "SELECT c.*, COUNT(b.id) as books_count 
                FROM {$this->table} c
                LEFT JOIN books b ON c.id = b.category_id
                GROUP BY c.id
                ORDER BY c.name ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
