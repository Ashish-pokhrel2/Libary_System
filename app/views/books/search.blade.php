@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Search Books</h1>
    <a href="{{ route('books') }}" class="btn btn-secondary">Back to Books</a>
</div>

<div class="search-container">
    <form action="{{ route('books/search') }}" method="POST" class="search-form">
        @csrf
        
        <div class="form-row">
            <div class="form-group autocomplete-container">
                <label for="title">Book Title</label>
                <input type="text" id="title" name="title" placeholder="Start typing to search..." autocomplete="off">
                <div id="autocomplete-results" class="autocomplete-results"></div>
            </div>

            <div class="form-group">
                <label for="author">Author Name</label>
                <input type="text" id="author" name="author" placeholder="Author name">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="year_from">Publication Year (From)</label>
                <input type="number" id="year_from" name="year_from" min="1000" max="<?php echo date('Y'); ?>">
            </div>

            <div class="form-group">
                <label for="year_to">Publication Year (To)</label>
                <input type="number" id="year_to" name="year_to" min="1000" max="<?php echo date('Y'); ?>">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Search</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
        </div>
    </form>
</div>

@if($searchPerformed)
    <div class="search-results">
        <h2>Search Results ({{ count($results) }} found)</h2>
        
        @if(empty($results))
            <p class="no-results">No books found matching your criteria.</p>
        @else
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Year</th>
                            <th>Available</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $book)
                            <tr>
                                <td>{{ $book['isbn'] }}</td>
                                <td>{{ $book['title'] }}</td>
                                <td>{{ $book['author_name'] ?? 'N/A' }}</td>
                                <td>{{ $book['category_name'] ?? 'N/A' }}</td>
                                <td>{{ $book['publication_year'] ?? 'N/A' }}</td>
                                <td>{{ $book['available_quantity'] }}/{{ $book['quantity'] }}</td>
                                <td class="actions">
                                    <a href="{{ route('books/show/' . $book['id']) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endif
@endsection