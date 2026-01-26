@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Categories</h1>
    @if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian')
        <a href="/categories/create" class="btn btn-success">Add New Category</a>
    @endif
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Books Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(empty($categories))
                <tr>
                    <td colspan="4" class="text-center">No categories found.</td>
                </tr>
            @else
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category['name'] }}</td>
                        <td>{{ $category['description'] ?? 'N/A' }}</td>
                        <td>{{ $category['books_count'] ?? 0 }}</td>
                        <td class="actions">
                            @if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian')
                                <a href="/categories/edit/{{ $category['id'] }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="/categories/delete/{{ $category['id'] }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
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