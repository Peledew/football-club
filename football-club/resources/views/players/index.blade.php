@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Players</h1>
        <a href="{{ route('players.create') }}" class="btn btn-primary">Create New Player</a>
        <table class="table mt-3">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Team</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($players as $player)
                <tr>
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->team }}</td>
                    <td>
                        <a href="{{ route('players.show', $player->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('players.edit', $player->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('players.destroy', $player->id) }}" method="POST"
                              style="display: inline-block;">
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
