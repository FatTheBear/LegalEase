@extends('layouts.app')
@section('title', 'Danh sách Luật sư')

@section('content')
<h2 class="mb-3">Danh sách Luật sư</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th><th>Tên</th><th>Chuyên ngành</th><th>Kinh nghiệm</th><th>Thành phố</th><th>Đánh giá</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lawyers as $lawyer)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $lawyer->user->name }}</td>
            <td>{{ $lawyer->specialization }}</td>
            <td>{{ $lawyer->experience }} năm</td>
            <td>{{ $lawyer->province }}</td>
            <td>{{ $lawyer->rating }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
