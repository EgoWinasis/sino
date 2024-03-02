@extends('layouts.map_layout')

@section('title', 'Maps Customer')

@section('content')
<div class="container-fluid">
    <h3 class="text-center">Customer: {{ $customer->name }}</h3>
    <div id="map" style="height: 100vh;"></div>
</div>
@endsection

@section('js')
<script>
    var map = L.map('map').setView([{{ explode(',', $customer->maps)[0] }}, {{ explode(',', $customer->maps)[1] }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([{{ explode(',', $customer->maps)[0] }}, {{ explode(',', $customer->maps)[1] }}]).addTo(map);
        marker.bindPopup("<b>{{ $customer->name }}</b><br>{{ $customer->alamat }}").openPopup();
</script>
@endsection