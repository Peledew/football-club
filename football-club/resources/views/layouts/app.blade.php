<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <style>
        #app {
            display: flex;
            height: 100vh; /* Full height of the screen */
        }

        #sidebar {
            width: 250px;
            background-color: #f4f4f4;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        #content {
            flex: 1;
            padding: 20px;
        }

        nav a {
            display: block;
            margin: 10px 0;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }


        nav {
            background-color: transparent;
            box-shadow: none;

        }

        nav a:hover {
            color: #007bff;
        }
    </style>

</head>
<body>
<div id="app">
    <!-- Sidebar -->
    <aside id="sidebar">
        <h2>Menu</h2>
        <nav>
            <a href="{{ route('clubs.index') }}">Handle clubs</a>
            <a href="{{ route('places.index') }}">Handle places</a>
            <a href="{{ route('competitions.index') }}">Handle competition</a>
            <a href="{{ route('games.index') }}">Handle games</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div id="content">
        @yield('content')
    </div>
</div>



</body>
</html>
