@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Competition Details</h1>
        <p>Name: {{ $competition->name }}</p>

        <a href="{{ route('competitions.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
@endsection
