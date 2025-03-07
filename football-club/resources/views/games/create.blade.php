@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Game</h1>
        <form action="{{ route('games.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="date_of_event">Date of Event</label>
                <input type="date" name="date_of_event" id="date_of_event" class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <label for="competition_id">Competition</label>
                <select name="competition_id" id="competition_id" required></select>
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
                <button type="button" class="btn btn-success" id="create-game-button">
                    Create
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
            let elems = document.querySelectorAll('.datepicker');
            let instances = M.Datepicker.init(elems);
        });

        const formatDateToISO = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Adding leading zero to month
            const day = String(date.getDate()).padStart(2, '0'); // Adding leading zero to day
            return `${year}-${month}-${day}`;
        };

        // Example usage:
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('date_of_event');

            // Listen for changes in the date input (if needed promptly)
            dateInput.addEventListener('change', (e) => {
                const selectedDate = new Date(e.target.value);
                const formattedDate = formatDateToISO(selectedDate);
                console.log('Formatted date:', formattedDate);

                // Optionally, update the value in your app logic if needed
                e.target.value = formattedDate;
            });
        });


        // Utility function to populate a select element and reinitialize MaterializeCSS
        const populateSelect = (select, clubs) => {
            // Ensure the select is cleared
            select.innerHTML = '<option value="" disabled selected>Select a club</option>';

            clubs.forEach(club => {
                const option = document.createElement('option');
                option.value = club.id;
                option.textContent = club.name;
                select.appendChild(option);
            });

            // Reinitialize MaterializeCSS select after modifying options
            M.FormSelect.init(select);
        };

        // DOMContentLoaded to ensure elements are ready
        document.addEventListener('DOMContentLoaded', function () {
            const homeClubSelect = document.getElementById('home_club_id');
            const guestClubSelect = document.getElementById('guest_club_id');
            const competitionSelect = document.getElementById('competition_id');

            fetch('/api/clubs', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        populateSelect(homeClubSelect, data);
                        populateSelect(guestClubSelect, data);
                    } else {
                        console.error('Unexpected data format:', data);
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
                .then(data => {
                    if (Array.isArray(data)) {
                        populateSelect(competitionSelect, data);
                    } else {
                        console.error('Unexpected data format:', data);
                    }
                })
                .catch(error => console.error('Error fetching competitions:', error));

            // Initialize all select elements at the start
            const elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);
        });

        document.addEventListener('DOMContentLoaded', function () {
            const createButton = document.getElementById('create-game-button');

            createButton.addEventListener('click', function () {
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

                fetch('{{ route('games.store') }}', {
                    method: 'POST',
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
                            console.error('Error creating game:', response);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while creating the game.');
                    });
            });
        });
    </script>

@endsection

