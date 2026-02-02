@extends('layouts.app')

@section('content')
<div class="dashboard">
    <h1>Reader Dashboard</h1>
    <p class="dashboard-subtitle">Welcome, {{ $_SESSION['full_name'] }}! Browse and search the library collection.</p>

    <div class="dashboard-cards">
        <div class="dashboard-card">
            <div class="card-icon">📚</div>
            <h3>Browse Books</h3>
            <p>View all books available in the library.</p>
            <div class="card-actions">
                <a href="{{ route('books') }}" class="btn btn-primary">View All Books</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-icon">✍️</div>
            <h3>Browse Authors</h3>
            <p>Explore books by different authors.</p>
            <div class="card-actions">
                <a href="{{ route('authors') }}" class="btn btn-primary">View All Authors</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-icon">🗂️</div>
            <h3>Browse Categories</h3>
            <p>Discover books in various categories.</p>
            <div class="card-actions">
                <a href="{{ route('categories') }}" class="btn btn-primary">View All Categories</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-icon">🔍</div>
            <h3>Search Books</h3>
            <p>Find books using advanced search filters.</p>
            <div class="card-actions">
                <a href="{{ route('books/search') }}" class="btn btn-primary">Search Books</a>
            </div>
        </div>
    </div>
</div>
@endsection
