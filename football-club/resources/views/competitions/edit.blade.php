@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Competition</h1>

        <form action="{{ route('competitions.update', $competition->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Competition Name</label>
                <input type="text" name="name" id="name" value="{{ $competition->name }}" class="form-control" required>
            </div>

            <button id="update-competition-button" type="submit" class="btn btn-success mt-3">Save Changes</button>
            <a href="{{ route('competitions.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateButton = document.getElementById('update-competition-button');
        updateButton.addEventListener('click', function () {
            const name = document.getElementById('name').value;
            const requestData = { name: name };

            fetch(`/competitions/{{ $competition->id}}`, {
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
                        window.location.href = '{{ route('competitions.index') }}';
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
