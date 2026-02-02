@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Add New Category</h1>
    <a href="{{ route('categories') }}" class="btn btn-secondary">Back to Categories</a>
</div>

<div class="form-container">
    <form action="{{ route('categories/store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" required autofocus>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Add Category</button>
            <a href="{{ route('categories') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection