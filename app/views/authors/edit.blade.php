@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Edit Author</h1>
    <a href="/authors" class="btn btn-secondary">Back to Authors</a>
</div>

<div class="form-container">
    <form action="/authors/update/{{ $author['id'] }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" value="{{ $author['name'] }}" required autofocus>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="birth_year">Birth Year</label>
                <input type="number" id="birth_year" name="birth_year" value="{{ $author['birth_year'] }}" min="1000" max="<?php echo date('Y'); ?>">
            </div>

            <div class="form-group">
                <label for="nationality">Nationality</label>
                <input type="text" id="nationality" name="nationality" value="{{ $author['nationality'] }}">
            </div>
        </div>

        <div class="form-group">
            <label for="biography">Biography</label>
            <textarea id="biography" name="biography" rows="5">{{ $author['biography'] }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Update Author</button>
            <a href="/authors" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

