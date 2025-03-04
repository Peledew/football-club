@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Game</h1>
        <form action="{{ route('games.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Create</button>
                <a href="{{ route('games.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
