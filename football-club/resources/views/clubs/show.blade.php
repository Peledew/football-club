@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Club Details</h1>

        <table class="table">
            <tr>
                <th>Name:</th>
                <td>{{ $club->name }}</td>
            </tr>
            <tr>
                <th>Place:</th>
                <td>{{ $club->place->name }}</td>
            </tr>
        </table>

        <h3>Players</h3>
        @if ($club->players->isEmpty())
            <p>No players assigned to this club.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Player Name</th>
                    <th>Position</th>
                    <th>Age</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($club->players as $player)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $player->name }}</td>
                        <td>{{ $player->position }}</td>
                        <td>{{ $player->age }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('clubs.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
@endsection
