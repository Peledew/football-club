@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h1 class="text-danger">An Error Occurred</h1>
        <p class="mt-3">We couldn't process your request.</p>

        @if (isset($id) && $id)
            <p class="text-muted">Invalid or missing information for ID: <strong>{{ $id }}</strong></p>
        @else
            <p class="text-muted">An unknown error occurred. Please try again later.</p>
        @endif

        <a href="{{ url()->previous() }}" class="btn btn-primary mt-4">Go Back</a>
    </div>
@endsection
