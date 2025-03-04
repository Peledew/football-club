@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Game Details</h1>

        <table class="table">
            <tr>
                <th>Date:</th>
                <td>{{ $game->date }}</td>
            </tr>
            <tr>
                <th>Home Club:</th>
                <td>{{ $game->homeClub ? $game->homeClub->name : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Guest Club:</th>
                <td>{{ $game->guestClub ? $game->guestClub->name : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Competition:</th>
                <td>{{ $game->competition ? $game->competition->name : 'N/A' }}</td>
            </tr>
        </table>

        <h3>Performances</h3>
        @if ($game->performances->isEmpty())
            <p>No performances recorded for this game.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Player</th>
                    <th>Club</th>
                    <th>Performance Stats</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($game->performances as $performance)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $performance->player->name }}</td>
                        <td>{{ $performance->club->name }}</td>
                        <td>{{ $performance->stats }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('games.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
@endsection
