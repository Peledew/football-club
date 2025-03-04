@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Game</h1>
        <form action="{{ route('games.update', $game->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $game->title }}" required>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="{{ route('games.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
