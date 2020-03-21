<x-layout>
{{-- @extends('components.layout')

@section('content') --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Welcome</div>

                <div class="card-body">
                    
                    <p>This is a simple little tool to map a postcode using Leaflet and OpenStreetMap [Postcode -> Location -> Map]</p>

                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/home') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endauth

                </div>
            </div>
        </div>
    </div>
</div>

{{-- @endsection --}}

</x-layout>