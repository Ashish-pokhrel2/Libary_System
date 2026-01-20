@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Authors</h1>
    @if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian')
        <a href="/authors/create" class="btn btn-success">Add New Author</a>
    @endif
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Nationality</th>
                <th>Birth Year</th>
                <th>Books Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(empty($authors))
                <tr>
                    <td colspan="5" class="text-center">No authors found.</td>
                </tr>
            @else
                @foreach($authors as $author)
                    <tr>
                        <td>{{ $author['name'] }}</td>
                        <td>{{ $author['nationality'] ?? 'N/A' }}</td>
                        <td>{{ $author['birth_year'] ?? 'N/A' }}</td>
                        <td>{{ $author['books_count'] ?? 0 }}</td>
                        <td class="actions">
                            @if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian')
                                <a href="/authors/edit/{{ $author['id'] }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="/authors/delete/{{ $author['id'] }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this author?')">Delete</a>
                            @else
                                <span class="text-muted">View Only</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection