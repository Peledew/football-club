@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Competitions</h1>
        <a href="{{ route('competitions.create') }}" class="btn btn-primary">Create New Competition</a>
        <table class="table mt-3">
            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($competitions as $competition)
                <tr>
                    <td>{{ $competition->name }}</td>
                    <td>
                        <a href="{{ route('competitions.show', $competition->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('competitions.edit', $competition->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('competitions.destroy', $competition->id) }}" method="POST"
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
