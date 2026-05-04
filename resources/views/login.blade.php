<div>
    <h1>Login</h1>
    <form action='/login' method='post'>
        @csrf
        <label>email</label>
        <input type="text" name="email"><br>
        <label>password</label>
        <input type="text" name="password"><br>
        <input type="submit" value="Login">
</div>
