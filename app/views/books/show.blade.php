@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Book Details</h1>
    <div>
        @if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian')
            <a href="{{ route('books/edit/' . $book['id']) }}" class="btn btn-primary">Edit</a>
        @endif
        <a href="{{ route('books') }}" class="btn btn-secondary">Back to Books</a>
    </div>
</div>

<div class="details-container">
    <div class="details-section">
        <h3>Basic Information</h3>
        <div class="details-grid">
            <div class="detail-item">
                <strong>ISBN:</strong>
                <span>{{ $book['isbn'] }}</span>
            </div>
            <div class="detail-item">
                <strong>Title:</strong>
                <span>{{ $book['title'] }}</span>
            </div>
            <div class="detail-item">
                <strong>Author:</strong>
                <span>{{ $book['author_name'] ?? 'N/A' }}</span>
            </div>
            <div class="detail-item">
                <strong>Category:</strong>
                <span>{{ $book['category_name'] ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <div class="details-section">
        <h3>Publication Details</h3>
        <div class="details-grid">
            <div class="detail-item">
                <strong>Publication Year:</strong>
                <span>{{ $book['publication_year'] ?? 'N/A' }}</span>
            </div>
            <div class="detail-item">
                <strong>Publisher:</strong>
                <span>{{ $book['publisher'] ?? 'N/A' }}</span>
            </div>
            <div class="detail-item">
                <strong>Pages:</strong>
                <span>{{ $book['pages'] ?? 'N/A' }}</span>
            </div>
            <div class="detail-item">
                <strong>Nationality:</strong>
                <span>{{ $book['nationality'] ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <div class="details-section">
        <h3>Availability</h3>
        <div class="details-grid">
            <div class="detail-item">
                <strong>Total Quantity:</strong>
                <span>{{ $book['quantity'] }}</span>
            </div>
            <div class="detail-item">
                <strong>Available Quantity:</strong>
                <span class="<?php echo ($book['available_quantity'] > 0) ? 'text-success' : 'text-danger'; ?>">
                    {{ $book['available_quantity'] }}
                </span>
            </div>
        </div>
    </div>

    @if(!empty($book['description']))
        <div class="details-section">
            <h3>Description</h3>
            <p>{{ $book['description'] }}</p>
        </div>
    @endif
</div>
@endsection