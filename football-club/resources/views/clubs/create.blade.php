@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Club</h1>
        <form method="POST">
            @csrf
            <div class="form-group mt-3">
                <label for="club_name">Club Name</label>
                <input type="text" name="club_name" id="club_name" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label for="place_id">Place</label>
                <select name="place_id" id="place_id"></select>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success" id="create-club-button">
                    Create
                </button>
                <a href="{{ route('clubs.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let elems = document.querySelectorAll('select');
            let instances = M.FormSelect.init(elems);
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


            document.addEventListener('DOMContentLoaded', function () {
                const placeSelect = document.getElementById('place_id');

                fetch('/api/places', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (Array.isArray(data)) {
                            populateSelect(placeSelect, data);
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
            const createButton = document.getElementById('create-club-button');

            createButton.addEventListener('click', function (event) {
                event.preventDefault();
                const clubName = document.getElementById('club_name').value;
                const placeId = document.getElementById('place_id').value;

                const requestData = {
                    name: clubName,
                    place_id: placeId
                };

                fetch('{{ route('clubs.store') }}', {
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
                            window.location.href = '{{ route('clubs.index') }}';
                        } else {
                            console.error('Error creating club:', response);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while creating the club.');
                    });
            });
        });

    </script>



