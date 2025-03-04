@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Game</h1>
        <form action="{{ route('games.update', $game->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="date_of_event">Date of Event</label>
                <input type="date" name="date_of_event" id="date_of_event" class="form-control"
                       value="{{ old('date_of_event', $game->date_of_event ?? '2023-10-25') }}" required>
            </div>
            <div class="form-group">
                <label for="competition_id">Competition</label>
                <select name="competition_id" id="competition_id" class="form-control" required></select>
            </div>
            <div class="form-group">
                <label for="home_club_id">Home Club</label>
                <select name="home_club_id" id="home_club_id" class="form-control" required></select>
            </div>
            <div class="form-group">
                <label for="guest_club_id">Guest Club</label>
                <select name="guest_club_id" id="guest_club_id" class="form-control" required></select>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="{{ route('games.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection



<script>
    document.addEventListener('DOMContentLoaded', function () {
        let elems = document.querySelectorAll('select');
        let instances = M.FormSelect.init(elems);
    });


</script>
