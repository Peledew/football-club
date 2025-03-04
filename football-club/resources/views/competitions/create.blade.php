@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Competition</h1>
        <form action="{{ route('competitions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <button type="button" class="btn btn-success" id="create-competition-button">
                    Create
                </button>
                <a href="{{ route('competitions.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const createButton = document.getElementById('create-competition-button');

            createButton.addEventListener('click', function () {
                const name = document.getElementById('name').value;

                const requestData = {
                    name: name
                };

                fetch('{{ route('competitions.store') }}', {
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
                            window.location.href = '{{ route('competitions.index') }}';
                        } else {
                            console.error('Error creating competition:', response);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while creating the competition.');
                    });
            });
        });
    </script>

@endsection

