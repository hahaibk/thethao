<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<style>
body{font-family:Arial,sans-serif;background:#f5f5f5;margin:0;padding:0;}
.container{max-width:400px;margin:50px auto;background:#fff;padding:30px;border-radius:8px;box-shadow:0 0 10px rgba(0,0,0,0.1);}
h1{text-align:center;margin-bottom:20px;color:#333;}
label{display:block;margin-top:10px;color:#555;}
input{width:100%;padding:10px;margin-top:5px;border-radius:5px;border:1px solid #ccc;box-sizing:border-box;}
button{margin-top:20px;width:100%;padding:12px;background:#007bff;color:#fff;border:none;border-radius:6px;font-size:16px;cursor:pointer;}
button:hover{background:#0056b3;}
a{text-align:center;display:block;margin-top:15px;color:#007bff;text-decoration:none;}
a:hover{text-decoration:underline;}
.error{color:red;margin-top:10px;}
</style>
</head>
<body>
<div class="container">
<h1>Login</h1>

@if($errors->any())
<div class="error">
@foreach($errors->all() as $error)
<p>{{ $error }}</p>
@endforeach
</div>
@endif

<form method="POST" action="{{ url('/login') }}">
@csrf
<label>Email:</label>
<input type="email" name="email" required>

<label>Password:</label>
<input type="password" name="password" required>

<button type="submit">Login</button>
</form>
<a href="{{ url('/register') }}">Don't have an account? Register</a>
</div>
</body>
</html>
