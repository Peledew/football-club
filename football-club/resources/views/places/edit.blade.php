@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Place</h1>

        <form  method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Place Name</label>
                <input type="text" name="name" id="name" value="{{ $place->name }}" class="form-control" required>
                <label for="ptt">Place ptt</label>
                <input type="text" name="ptt" id="ptt" value="{{ $place->ptt }}" class="form-control" required>
            </div>

            <button id="update-place-button" type="button" class="btn btn-success mt-3">Save Changes</button>
            <a href="{{ route('places.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateButton = document.getElementById('update-place-button');
        updateButton.addEventListener('click', function () {
            const name = document.getElementById('name').value;
            const ptt = document.getElementById('ptt').value;
            const requestData = {
                name: name,
                ptt: ptt
            };

            fetch(`/places/{{ $place->id}}`, {
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
                        window.location.href = '{{ route('places.index') }}';
                    } else {
                        console.error('Error updating competition:', response);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>
