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
                       value="{{ $game->date_of_event }}" required>
            </div>
            <div class="form-group mt-3">
                <label for="competition_id">Competition</label>
                <select name="competition_id" id="competition_id" required>
                    <option value="" disabled>Select a competition</option>
                </select>
                @error('competition_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="home_club_id">Home Club</label>
                <select name="home_club_id" id="home_club_id"></select>
            </div>
            <div class="form-group mt-3">
                <label for="guest_club_id">Guest Club</label>
                <select name="guest_club_id" id="guest_club_id"></select>
            </div>
            <div class="form-group mt-3">
                <button type="button" class="btn btn-success" id="edit-game-button">
                    Update
                </button>
                <a href="{{ route('games.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let elems = document.querySelectorAll('select');
            let instances = M.FormSelect.init(elems);
        });

        document.addEventListener('DOMContentLoaded', function () {
            const competitionSelect = document.getElementById('competition_id');
            const homeClubSelect = document.getElementById('home_club_id');
            const guestClubSelect = document.getElementById('guest_club_id');

            fetch('/api/clubs', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(clubs => {
                    if (Array.isArray(clubs)) {
                        populateSelect(homeClubSelect, clubs);
                        homeClubSelect.value = {{ $game->home_club_id }};

                        populateSelect(guestClubSelect, clubs);
                        guestClubSelect.value = {{ $game->guest_club_id }};
                    }
                })
                .catch(error => console.error('Error fetching clubs:', error));

            fetch('/api/competitions', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(competitions => {
                    if (Array.isArray(competitions)) {
                        populateSelect(competitionSelect, competitions);
                        competitionSelect.value = {{ $game->competition_id }};
                    }
                })
                .catch(error => console.error('Error fetching competitions:', error));

            const editButton = document.getElementById('edit-game-button');

            editButton.addEventListener('click', function () {
                const dateOfEvent = document.getElementById('date_of_event').value;
                const competitionId = document.getElementById('competition_id').value;
                const homeClubId = document.getElementById('home_club_id').value;
                const guestClubId = document.getElementById('guest_club_id').value;

                const requestData = {
                    date_of_event: dateOfEvent,
                    competition_id: competitionId,
                    home_club_id: homeClubId,
                    guest_club_id: guestClubId,
                };

                fetch('{{ route('games.update', $game->id) }}', {
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(requestData),
                })
                    .then(response => {
                        if (response.ok) {
                            window.location.href = '{{ route('games.index') }}';
                        } else {
                            console.error('Error updating game:', response);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating the game.');
                    });
            });
        });
    </script>

@endsection

