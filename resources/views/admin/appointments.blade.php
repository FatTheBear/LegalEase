@extends('layouts.app')
@section('title', 'Quản lý Lịch hẹn')

@section('content')
<h2>Danh sách Lịch hẹn</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th><th>Khách hàng</th><th>Luật sư</th><th>Thời gian</th><th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        @foreach($appointments as $a)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $a->customer->name }}</td>
            <td>{{ $a->lawyer->name }}</td>
            <td>{{ $a->appointment_time }}</td>
            <td>{{ $a->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
