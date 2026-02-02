@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Edit Book</h1>
    <a href="{{ route('books') }}" class="btn btn-secondary">Back to Books</a>
</div>

<div class="form-container">
    <form action="{{ route('books/update/' . $book['id']) }}" method="POST">
        @csrf
        
        <div class="form-row">
            <div class="form-group">
                <label for="isbn">ISBN *</label>
                <input type="text" id="isbn" name="isbn" value="{{ $book['isbn'] }}" required>
            </div>

            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" value="{{ $book['title'] }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="author_id">Author *</label>
                <select id="author_id" name="author_id" required>
                    <option value="">Select Author</option>
                    @foreach($authors as $author)
                        <option value="{{ $author['id'] }}" <?php echo ($book['author_id'] == $author['id']) ? 'selected' : ''; ?>>
                            {{ $author['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['id'] }}" <?php echo ($book['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                            {{ $category['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="publication_year">Publication Year</label>
                <input type="number" id="publication_year" name="publication_year" value="{{ $book['publication_year'] }}" min="1000" max="<?php echo date('Y'); ?>">
            </div>

            <div class="form-group">
                <label for="publisher">Publisher</label>
                <input type="text" id="publisher" name="publisher" value="{{ $book['publisher'] }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="pages">Pages</label>
                <input type="number" id="pages" name="pages" value="{{ $book['pages'] }}" min="1">
            </div>

            <div class="form-group">
                <label for="quantity">Quantity *</label>
                <input type="number" id="quantity" name="quantity" value="{{ $book['quantity'] }}" min="1" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="available_quantity">Available Quantity *</label>
                <input type="number" id="available_quantity" name="available_quantity" value="{{ $book['available_quantity'] }}" min="0" required>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4">{{ $book['description'] }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Update Book</button>
            <a href="{{ route('books') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection