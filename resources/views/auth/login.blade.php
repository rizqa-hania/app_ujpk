<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Kepegawaian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body{
            margin:0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .login-box{
            background:white;
            padding:40px;
            width:350px;
            border-radius:10px;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
        }

        h2{
            text-align:center;
            margin-bottom:25px;
        }

        input{
            width:100%;
            padding:10px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:5px;
        }

        button{
            width:100%;
            padding:10px;
            background:#007bff;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }

        button:hover{
            background:#0056b3;
        }

        .error{
            color:red;
            font-size:14px;
            margin-bottom:10px;
        }

        .success{
            color:green;
            font-size:14px;
            margin-bottom:10px;
        }

        .footer{
            text-align:center;
            margin-top:15px;
            font-size:14px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login Sistem</h2>

    {{-- ERROR SESSION --}}
    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ url('/login') }}" method="POST">
        @csrf

        <input type="email" name="email" placeholder="Masukkan Email" required>

        <input type="password" name="password" placeholder="Masukkan Password" required>

        <button type="submit">Login</button>
    </form>

    <div class="footer">
        Belum punya akun? 
        <a href="{{ url('/register') }}">Daftar</a>
    </div>

     <div class="footer">
        password salah? 
        <a href="{{ url('/forgot-password') }}">forgot password</a>
    </div>
</div>

</body>
</html>