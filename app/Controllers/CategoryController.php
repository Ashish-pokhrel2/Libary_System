<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $this->requireAuth();
        
        try {
            $categories = $this->categoryModel->getAllWithBooksCount();
            
            $this->view('categories.index', [
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to load categories. Please try again later.';
            $this->redirect('/dashboard');
        }
    }

    public function create()
    {
        $this->requireLibrarian();
        
        $this->view('categories.create');
    }

    public function store()
    {
        $this->requireLibrarian();
        $this->validateCsrf();
        
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Category name is required.';
            $this->redirect('/categories/create');
        }
        
        try {
            $this->categoryModel->create($data);
            $_SESSION['success'] = 'Category added successfully!';
            $this->redirect('/categories');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to add category. Name might already exist.';
            $this->redirect('/categories/create');
        }
    }

    public function edit($id)
    {
        $this->requireLibrarian();
        
        try {
            $category = $this->categoryModel->find($id);
            
            if (!$category) {
                $_SESSION['error'] = 'Category not found.';
                $this->redirect('/categories');
            }
            
            $this->view('categories.edit', [
                'category' => $category
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to load category data. Please try again later.';
            $this->redirect('/categories');
        }
    }

    public function update($id)
    {
        $this->requireLibrarian();
        $this->validateCsrf();
        
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Category name is required.';
            $this->redirect("/categories/edit/{$id}");
        }
        
        try {
            $this->categoryModel->update($id, $data);
            $_SESSION['success'] = 'Category updated successfully!';
            $this->redirect('/categories');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to update category.';
            $this->redirect("/categories/edit/{$id}");
        }
    }

    public function delete($id)
    {
        $this->requireLibrarian();
        
        try {
            $booksCount = $this->categoryModel->getBooksCount($id);
            
            if ($booksCount > 0) {
                $_SESSION['error'] = "Cannot delete category. There are {$booksCount} books in this category.";
            } else {
                $this->categoryModel->delete($id);
                $_SESSION['success'] = 'Category deleted successfully!';
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to delete category.';
        }
        
        $this->redirect('/categories');
    }
}
