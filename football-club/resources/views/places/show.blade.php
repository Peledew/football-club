@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Place Details</h1>
        <p>Name: {{ $place->name }}</p>
        <p>PTT: {{ $place->ptt }}</p>

        <a href="{{ route('places.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
@endsection
