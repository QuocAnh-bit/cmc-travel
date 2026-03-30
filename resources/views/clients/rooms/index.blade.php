@extends('layouts.client')

@section('content')
    <h2>Danh sách phòng</h2>

    @foreach($rooms as $room)
        <p>
            {{ $room['name'] }} - {{ $room['price'] }} VND
        </p>
    @endforeach

@endsection