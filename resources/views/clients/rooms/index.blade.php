@extends('layouts.client')

@section('content')
<h2>Tìm phòng trống</h2>

<form id="checkForm">
    <input type="date" name="check_in" required>
    <input type="date" name="check_out" required>
    <button type="submit">Kiểm tra</button>
</form>

<hr>

<h3>Danh sách phòng</h3>
<div id="roomList"></div>

<script>
document.getElementById('checkForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('/check-room', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        let html = '';

        data.forEach(room => {
            html += `
                <div>
                    <h4>${room.name}</h4>
                    <p>Giá: ${room.price}</p>
                    <button onclick="bookRoom(${room.id})">Đặt phòng</button>
                </div>
                <hr>
            `;
        });

        document.getElementById('roomList').innerHTML = html;
    });
});

function bookRoom(roomId) {
    alert("Đặt phòng ID: " + roomId);
}
</script>
@endsection