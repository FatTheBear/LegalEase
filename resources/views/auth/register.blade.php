@extends('layouts.app')
@section('title', 'Đăng ký')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <h2 class="mb-4 text-center">Tạo tài khoản</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label>Tên:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mật khẩu:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Vai trò:</label>
                <select name="role" class="form-control">
                    <option value="customer">Khách hàng</option>
                    <option value="lawyer">Luật sư</option>
                </select>
            </div>
            <button class="btn btn-success w-100">Đăng ký</button>
        </form>
    </div>
</div>
@endsection
