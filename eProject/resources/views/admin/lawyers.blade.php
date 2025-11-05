@extends('layouts.app')
@section('title', 'Quản lý Luật sư')

@section('content')
<h2>Danh sách Luật sư</h2>
<table class="table table-striped">
    <thead><tr><th>#</th><th>Tên</th><th>Email</th><th>Chuyên ngành</th><th>Trạng thái</th></tr></thead>
    <tbody>
        @foreach($lawyers as $l)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $l->user->name }}</td>
            <td>{{ $l->user->email }}</td>
            <td>{{ $l->specialization }}</td>
            <td>{{ $l->user->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
