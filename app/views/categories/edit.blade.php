@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Edit Category</h1>
    <a href="/categories" class="btn btn-secondary">Back to Categories</a>
</div>

<div class="form-container">
    <form action="/categories/update/{{ $category['id'] }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" value="{{ $category['name'] }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4">{{ $category['description'] }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Update Category</button>
            <a href="/categories" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection