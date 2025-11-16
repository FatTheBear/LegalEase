@extends('layouts.app')
@section('title', 'Quản lý người dùng')

@section('content')
<h2>Danh sách Người dùng</h2>
<table class="table table-bordered">
    <thead><tr><th>#</th><th>Tên</th><th>Email</th><th>Vai trò</th><th>Trạng thái</th></tr></thead>
    <tbody>
        @foreach($users as $u)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->role }}</td>
            <td>{{ $u->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
