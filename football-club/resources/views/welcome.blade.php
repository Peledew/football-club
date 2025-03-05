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
                <button type="submit" class="btn btn-success" id="login_button">
                    Login
                </button>
            </div>
        </form>
    </div>
    <script>

        document.getElementById('login_button').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent form submission to allow custom logic
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (email && password) {
                fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({email, password})
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Login failed');
                        }
                        return response.json();
                    })
                    .then(data => {
                        localStorage.setItem('auth_token', data.token);
                        localStorage.setItem('role', data.user.role);
                        // console.log('Login successful:', data);
                        // console.log("ROLA:" ,data.user.role);
                         window.location.href = '/dashboard';


                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Invalid login credentials or an error occurred.');
                    });
            } else {
                alert('Please fill in both email and password fields.');
            }
        });

    </script>
@endsection


