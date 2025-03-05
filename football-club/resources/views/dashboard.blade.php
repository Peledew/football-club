@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <form id="logout-form"  method="POST">
        @method('POST')
        @csrf
        <button type="button" id="logout_button" class="btn btn-danger">Logout</button>
    </form>
</div>
<script>

    document.getElementById('logout_button').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent form submission to allow custom logic

        const token = localStorage.getItem('auth_token');

        if (!token) {
            console.error('No token found in local storage');
            return;
        }

            fetch('/api/logout', {
                method: 'POST',
                credentials: 'same-origin',

                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Authorization': 'Bearer ' + token,
                },

            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Logout failed');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Logout successful:', data);
                    window.location.href = '/';
                })
                .catch(error => {
                    console.error('Error:', error);
                });

    });
</script>
@endsection
