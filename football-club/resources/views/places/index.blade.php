@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Places</h1>
        <a href="{{ route('places.create') }}" class="btn btn-primary">Create New Place</a>
        <table class="table mt-3">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>PTT</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($places as $place)
                <tr>
                    <td>{{ $place->id }}</td>
                    <td>{{ $place->name }}</td>
                    <td>{{ $place->ptt }}</td>
                    <td>
                        <a href="{{ route('places.show', $place->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('places.edit', $place->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('places.destroy', $place->id) }}" method="POST"
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
