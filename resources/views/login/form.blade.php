<form id="login-form">
    @csrf
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="username" placeholder="Username" required>
        <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-user"></span>
        </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-lock"></span>
        </div>
        </div>
    </div>
    <div class="row">
        <!-- /.col -->
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" id="loginButton">Sign In</button>
        </div>
        <!-- /.col -->
        <p class="login-box-msg mt-3 text-red" id="loginResult"></p>
    </div>
</form>