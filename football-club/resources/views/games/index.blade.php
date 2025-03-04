@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Games</h1>
        <a href="{{ route('games.create') }}" class="btn btn-primary">Create New Game</a>
        <table class="table mt-3">
            <thead>
            <tr>
                <th>#</th>
                <th>Competition name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td>{{ $game->competition ? $game->competition->name : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('games.show', $game->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('games.edit', $game->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('games.destroy', $game->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
