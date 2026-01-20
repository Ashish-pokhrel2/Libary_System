<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Author;

class AuthorController extends Controller
{
    private $authorModel;

    public function __construct()
    {
        parent::__construct();
        $this->authorModel = new Author();
    }

    public function index()
    {
        $this->requireAuth();
        
        $authors = $this->authorModel->getAllWithBooksCount();
        
        $this->view('authors.index', [
            'authors' => $authors
        ]);
    }

    public function create()
    {
        $this->requireLibrarian();
        
        $this->view('authors.create');
    }

    public function store()
    {
        $this->requireLibrarian();
        $this->validateCsrf();
        
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'biography' => trim($_POST['biography'] ?? ''),
            'birth_year' => $_POST['birth_year'] ?? null,
            'nationality' => trim($_POST['nationality'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Author name is required.';
            $this->redirect('/authors/create');
        }
        
        try {
            $this->authorModel->create($data);
            $_SESSION['success'] = 'Author added successfully!';
            $this->redirect('/authors');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to add author.';
            $this->redirect('/authors/create');
        }
    }

    public function edit($id)
    {
        $this->requireLibrarian();
        
        $author = $this->authorModel->find($id);
        
        if (!$author) {
            $_SESSION['error'] = 'Author not found.';
            $this->redirect('/authors');
        }
        
        $this->view('authors.edit', [
            'author' => $author
        ]);
    }

    public function update($id)
    {
        $this->requireLibrarian();
        $this->validateCsrf();
        
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'biography' => trim($_POST['biography'] ?? ''),
            'birth_year' => $_POST['birth_year'] ?? null,
            'nationality' => trim($_POST['nationality'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Author name is required.';
            $this->redirect("/authors/edit/{$id}");
        }
        
        try {
            $this->authorModel->update($id, $data);
            $_SESSION['success'] = 'Author updated successfully!';
            $this->redirect('/authors');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to update author.';
            $this->redirect("/authors/edit/{$id}");
        }
    }

    public function delete($id)
    {
        $this->requireLibrarian();
        
        try {
            $booksCount = $this->authorModel->getBooksCount($id);
            
            if ($booksCount > 0) {
                $_SESSION['error'] = "Cannot delete author. There are {$booksCount} books associated with this author.";
            } else {
                $this->authorModel->delete($id);
                $_SESSION['success'] = 'Author deleted successfully!';
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to delete author.';
        }
        
        $this->redirect('/authors');
    }
}
