<x-layout>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h1>Login</h1>
                <form action='/login' method='post'>
                    @csrf
                    <label for="email" class="form-label">email</label>
                    <input type="text" class="form-control" name="email"><br>
                    <label for="passoword" class="form-label">password</label>
                    <input type="text" class="form-control" name="password"><br>
                    <input type="submit" class="btn-generic" value="Login">
                </form>
            </div>
        </div>
    </div>
</x-layout>
