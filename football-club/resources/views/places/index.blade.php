@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Place Details</h1>


        <ul>
            @foreach ($places as $place)
                <li>{{ $place->name }}</li>
            @endforeach
        </ul>
    </div>
@endsection
