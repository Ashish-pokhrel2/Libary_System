@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Books</h1>
    @if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian')
        <a href="/books/create" class="btn btn-success">Add New Book</a>
    @endif
</div>

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
            @if(empty($books))
                <tr>
                    <td colspan="7" class="text-center">No books found.</td>
                </tr>
            @else
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book['isbn'] }}</td>
                        <td>{{ $book['title'] }}</td>
                        <td>{{ $book['author_name'] ?? 'N/A' }}</td>
                        <td>{{ $book['category_name'] ?? 'N/A' }}</td>
                        <td>{{ $book['publication_year'] ?? 'N/A' }}</td>
                        <td>{{ $book['available_quantity'] }}/{{ $book['quantity'] }}</td>
                        <td class="actions">
                            <a href="/books/show/{{ $book['id'] }}" class="btn btn-sm btn-info">View</a>
                            @if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian')
                                <a href="/books/edit/{{ $book['id'] }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="/books/delete/{{ $book['id'] }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection