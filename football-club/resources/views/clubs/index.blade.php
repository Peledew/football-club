@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Clubs</h1>
        <a href="{{ route('clubs.create') }}" class="btn btn-primary">Create New Club</a>
        <table class="table mt-3">
            <thead>
            <tr>
                <th>Club name</th>
                <th>Place</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($clubs as $club)
                <tr>
                    <td>{{ $club->name }}</td>
                    <td>{{ $club->place->name }}</td>
                    <td>
                        <a href="{{ route('clubs.edit', $club->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="{{ route('clubs.show', $club->id) }}" class="btn btn-info btn-sm">View</a>
                        <form action="{{ route('clubs.destroy', $club->id) }}" method="POST"
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
