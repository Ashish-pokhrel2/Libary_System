@extends('layouts.app')

@section('content')
<div class="dashboard">
    <h1>Librarian Dashboard</h1>
    <p class="dashboard-subtitle">Welcome back, {{ $_SESSION['full_name'] }}! You have full access to manage the library system.</p>

    <div class="dashboard-cards">
        <div class="dashboard-card">
            <div class="card-icon">📚</div>
            <h3>Manage Books</h3>
            <p>Add, edit, or remove books from the library collection.</p>
            <div class="card-actions">
                <a href="{{ route('books') }}" class="btn btn-primary">View All Books</a>
                <a href="{{ route('books/create') }}" class="btn btn-success">Add New Book</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-icon">✍️</div>
            <h3>Manage Authors</h3>
            <p>Maintain the database of book authors.</p>
            <div class="card-actions">
                <a href="{{ route('authors') }}" class="btn btn-primary">View All Authors</a>
                <a href="{{ route('authors/create') }}" class="btn btn-success">Add New Author</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-icon">🗂️</div>
            <h3>Manage Categories</h3>
            <p>Organize books into different categories.</p>
            <div class="card-actions">
                <a href="{{ route('categories') }}" class="btn btn-primary">View All Categories</a>
                <a href="{{ route('categories/create') }}" class="btn btn-success">Add New Category</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-icon">🔍</div>
            <h3>Search Books</h3>
            <p>Advanced search with multiple filters and autocomplete.</p>
            <div class="card-actions">
                <a href="{{ route('books/search') }}" class="btn btn-primary">Search Books</a>
            </div>
        </div>
    </div>
</div>
@endsection
