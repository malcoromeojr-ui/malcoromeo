<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Login Form</title>
<style>
    *{
        margin:0;
        padding:0;
        box-sizing:border-semi circle;
        font-family:Arial, Helvetica, sans-serif;
    }

body{
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    background:linear-gradient(135deg,#4facfe,#00f2fe);
}

.log-box{
    background: greenyellow;
    width:350px;
    padding:40px;
    border:radius 15px;
    box-shadow:0 10px 25px rgba(0, 0, 0, 0, 2);
    text-align:center;
}

.log-box h2{
    margin-bottom:25px;
    color:#333;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1 px solid#ccc;
    border-radius:8px;
    outline:none;
    font-size:15px;
}

input:focus{
    border-color #4facfe;
}

button{
    width:100%;
    padding:12px;
    margin-top:15px;
    background: #0d67b6;
    color: white;
    border:none;
    font-size:16px;
    cursor:pointer;
    transition:3s;
}

button:hover{
    background: #2d5279;
}

p{
    margin-top:18px;
    color: #111010;
    font-size:14px;
}

a{
    color: #6bc934;
    text-decoration:none;
}
</style>

</head>

<body>

<div class="log-box">
    <h2>Welcome to this page</h2>
<form action="check.php" method="post">
    <input type="text" name="username"
placeholder="username">

    <input type="password" name="password"
placeholder="password">

    <button type="submit">LOGIN</button>

    <p>Don't have an account?
        <a href="#">Sign Up</a>
    </p>
</div>
</form>
</body>
</html>