<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;

class BookController extends Controller
{
    private $bookModel;
    private $authorModel;
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->bookModel = new Book();
        $this->authorModel = new Author();
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $this->requireAuth();
        
        try {
            $books = $this->bookModel->getAllWithDetails();
            
            $this->view('books.index', [
                'books' => $books
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to load books. Please try again later.';
            $this->redirect('/dashboard');
        }
    }

    public function create()
    {
        $this->requireLibrarian();
        
        try {
            $authors = $this->authorModel->all();
            $categories = $this->categoryModel->all();
            
            $this->view('books.create', [
                'authors' => $authors,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to load form data. Please try again later.';
            $this->redirect('/books');
        }
    }

    public function store()
    {
        $this->requireLibrarian();
        $this->validateCsrf();
        
        $data = [
            'isbn' => trim($_POST['isbn'] ?? ''),
            'title' => trim($_POST['title'] ?? ''),
            'author_id' => $_POST['author_id'] ?? null,
            'category_id' => $_POST['category_id'] ?? null,
            'publication_year' => $_POST['publication_year'] ?? null,
            'publisher' => trim($_POST['publisher'] ?? ''),
            'pages' => $_POST['pages'] ?? null,
            'quantity' => $_POST['quantity'] ?? 1,
            'available_quantity' => $_POST['quantity'] ?? 1,
            'description' => trim($_POST['description'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Validation
        if (empty($data['isbn']) || empty($data['title'])) {
            $_SESSION['error'] = 'ISBN and Title are required.';
            $this->redirect('/books/create');
        }
        
        try {
            $this->bookModel->create($data);
            $_SESSION['success'] = 'Book added successfully!';
            $this->redirect('/books');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to add book. ISBN might already exist.';
            $this->redirect('/books/create');
        }
    }

    public function show($id)
    {
        $this->requireAuth();
        
        try {
            $book = $this->bookModel->getWithDetails($id);
            
            if (!$book) {
                $_SESSION['error'] = 'Book not found.';
                $this->redirect('/books');
            }
            
            $this->view('books.show', [
                'book' => $book
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to load book details. Please try again later.';
            $this->redirect('/books');
        }
    }

    public function edit($id)
    {
        $this->requireLibrarian();
        
        try {
            $book = $this->bookModel->find($id);
            
            if (!$book) {
                $_SESSION['error'] = 'Book not found.';
                $this->redirect('/books');
            }
            
            $authors = $this->authorModel->all();
            $categories = $this->categoryModel->all();
            
            $this->view('books.edit', [
                'book' => $book,
                'authors' => $authors,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to load book data. Please try again later.';
            $this->redirect('/books');
        }
    }

    public function update($id)
    {
        $this->requireLibrarian();
        $this->validateCsrf();
        
        $data = [
            'isbn' => trim($_POST['isbn'] ?? ''),
            'title' => trim($_POST['title'] ?? ''),
            'author_id' => $_POST['author_id'] ?? null,
            'category_id' => $_POST['category_id'] ?? null,
            'publication_year' => $_POST['publication_year'] ?? null,
            'publisher' => trim($_POST['publisher'] ?? ''),
            'pages' => $_POST['pages'] ?? null,
            'quantity' => $_POST['quantity'] ?? 1,
            'available_quantity' => $_POST['available_quantity'] ?? 1,
            'description' => trim($_POST['description'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            $this->bookModel->update($id, $data);
            $_SESSION['success'] = 'Book updated successfully!';
            $this->redirect('/books');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to update book.';
            $this->redirect("/books/edit/{$id}");
        }
    }

    public function delete($id)
    {
        $this->requireLibrarian();
        
        try {
            $this->bookModel->delete($id);
            $_SESSION['success'] = 'Book deleted successfully!';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to delete book.';
        }
        
        $this->redirect('/books');
    }

    public function search()
    {
        $this->requireAuth();
        
        try {
            $categories = $this->categoryModel->all();
            $results = [];
            $searchPerformed = false;
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $searchPerformed = true;
                $params = [
                    'title' => trim($_POST['title'] ?? ''),
                    'author' => trim($_POST['author'] ?? ''),
                    'category_id' => $_POST['category_id'] ?? '',
                    'year_from' => $_POST['year_from'] ?? '',
                    'year_to' => $_POST['year_to'] ?? ''
                ];
                
                $results = $this->bookModel->search($params);
            }
            
            $this->view('books.search', [
                'categories' => $categories,
                'results' => $results,
                'searchPerformed' => $searchPerformed
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Search failed. Please try again later.';
            $this->view('books.search', [
                'categories' => [],
                'results' => [],
                'searchPerformed' => false
            ]);
        }
    }

    public function autocomplete()
    {
        header('Content-Type: application/json');
        
        try {
            $query = trim($_GET['query'] ?? '');
            
            if (strlen($query) < 2) {
                echo json_encode([]);
                exit;
            }
            
            $results = $this->bookModel->autocomplete($query);
            echo json_encode($results);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Autocomplete failed']);
        }
        exit;
    }
}
