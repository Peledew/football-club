@extends('layouts.app')

@section('content')
    <div class="container">

        <form method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"  autofocus>
            </div>

            <div class="form-group">
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                </div>
            </div>
            <div class="form-group mt-3">
                <button type="button" class="btn btn-success" id="login_button">
                    Login
                </button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginButton = document.getElementById('login_button');

            loginButton.addEventListener('click', function (event) {
                event.preventDefault();
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                const requestData = {
                    email: email,
                    password: password
                };

                fetch('/api/login', {
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
                            console.log(response);
                            // window.location.href = '/dashboard';
                        } else {
                            console.error('Error login in: ', response);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while login in.');
                    });
            });
        });

    </script>
@endsection


