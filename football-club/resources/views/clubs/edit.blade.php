@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit CLub</h1>

        <form method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Club Name</label>
                <input type="text" name="name" id="name" value="{{ $club->name }}" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label for="place_id">Place</label>
                <select name="place_id" id="place_id"></select>
            </div>

            <button id="update-club-button" type="button" class="btn btn-success mt-3">Save Changes</button>
            <a href="{{ route('clubs.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let elems = document.querySelectorAll('select');
        let instances = M.FormSelect.init(elems);
    });

    // Utility function to populate a select element and reinitialize MaterializeCSS
    const populateSelect = (select, places) => {
        // Ensure the select is cleared
        // select.innerHTML = '<option value="" disabled selected>Select a place</option>';

        places.forEach(place => {
            const option = document.createElement('option');
            option.value = place.id;
            option.textContent = place.name;
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
        const updateButton = document.getElementById('update-club-button');

        updateButton.addEventListener('click', function (event) {
            event.preventDefault();
            const clubName = document.getElementById('name').value;
            const placeId = document.getElementById('place_id').value;

            const requestData = {
                name: clubName,
                place_id: placeId
            };

            fetch(`/clubs/{{ $club->id}}`, {
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
