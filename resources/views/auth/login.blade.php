<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">



            <div class="card">
                <div class="card-header text-center">Đăng nhập</div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            Login failed! Please check your credentials.
                        </div>
                    @endif
                    
                    <form method="POST" action="/login">
                        @csrf
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>