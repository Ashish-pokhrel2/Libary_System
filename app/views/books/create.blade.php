@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Add New Book</h1>
    <a href="{{ route('books') }}" class="btn btn-secondary">Back to Books</a>
</div>

<div class="form-container">
    <form action="{{ route('books/store') }}" method="POST">
        @csrf
        
        <div class="form-row">
            <div class="form-group">
                <label for="isbn">ISBN *</label>
                <input type="text" id="isbn" name="isbn" required>
            </div>

            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="author_id">Author *</label>
                <select id="author_id" name="author_id" required>
                    <option value="">Select Author</option>
                    @foreach($authors as $author)
                        <option value="{{ $author['id'] }}">{{ $author['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="publication_year">Publication Year</label>
                <input type="number" id="publication_year" name="publication_year" min="1000" max="<?php echo date('Y'); ?>">
            </div>

            <div class="form-group">
                <label for="publisher">Publisher</label>
                <input type="text" id="publisher" name="publisher">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="pages">Pages</label>
                <input type="number" id="pages" name="pages" min="1">
            </div>

            <div class="form-group">
                <label for="quantity">Quantity *</label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" required>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Add Book</button>
            <a href="{{ route('books') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection