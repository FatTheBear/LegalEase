@extends('layouts.app')
@section('title', 'Danh sách Lịch hẹn')

@section('content')
<h2>Lịch hẹn của bạn</h2>
<table class="table table-hover">
    <thead>
        <tr><th>#</th><th>Luật sư</th><th>Thời gian</th><th>Trạng thái</th></tr>
    </thead>
    <tbody>
        @foreach($appointments as $a)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $a->lawyer->name }}</td>
            <td>{{ $a->appointment_time }}</td>
            <td>{{ $a->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('appointments.create') }}" class="btn btn-success">+ Đặt lịch mới</a>
@endsection
