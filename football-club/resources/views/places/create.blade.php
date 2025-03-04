@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Place</h1>
        <form method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <label for="ptt">PTT</label>
                <input type="text" name="ptt" id="ptt" class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <button type="button" class="btn btn-success" id="create-place-button">
                    Create
                </button>
                <a href="{{ route('places.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const createButton = document.getElementById('create-place-button');

            createButton.addEventListener('click', function () {
                const name = document.getElementById('name').value;
                const ptt = document.getElementById('ptt').value;

                const requestData = {
                    name: name,
                    ptt: ptt
                };

                fetch('{{ route('places.store') }}', {
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
                            window.location.href = '{{ route('places.index') }}';
                        } else {
                            console.error('Error creating place:', response);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while creating the place.');
                    });
            });
        });
    </script>

@endsection

