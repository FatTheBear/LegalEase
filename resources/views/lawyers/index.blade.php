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
            <td>{{ $lawyer->name }}</td>
            <td>{{ $lawyer->lawyerProfile->specialization ?? 'N/A' }}</td>
            <td>{{ $lawyer->lawyerProfile->experience ?? 0 }} năm</td>
            <td>{{ $lawyer->lawyerProfile->province ?? 'N/A' }}</td>
            <td>{{ $lawyer->lawyerProfile->rating ?? 'Chưa có' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
