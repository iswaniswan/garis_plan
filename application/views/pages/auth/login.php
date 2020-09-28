<style>
    #alert{
        position: absolute;
        top: 0;
        width: 100%;
    }
</style>
<div id="alert"></div>
<div id="app">
    <section class="section">
        <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
                <h1 class="lead text-primary">GARIS</h1>
                <!-- <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
            </div>

            <div class="card card-primary">
                <div class="card-header"><h4>Login</h4></div>

                <div class="card-body">
                <form method="POST" action="#" class="needs-validation" novalidate="" id="form_login">
                    <div class="form-group">
                    <label for="nik">NIK</label>
                    <input id="nik" type="text" class="form-control" name="nik" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                        Please fill in your email
                    </div>
                    </div>

                    <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                        <div class="float-right">
                        <!-- <a href="auth-forgot-password.html" class="text-small">
                            Forgot Password?
                        </a> -->
                        </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                        please fill in your password
                    </div>
                    </div>

                    <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                    </div>

                    <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                    </button>
                    </div>
                </form>

                </div>
            </div>
            <div class="simple-footer">
                IT Department &copy; PT. Cisangkan 2020
            </div>
            </div>
        </div>
        </div>
    </section>
</div>

<script src="<?= base_url('assets/vendor/jquery/jquery-3.3.1.min.js'); ?>"></script>
<script type="module" defer>
    import { Auth } from "/assets/js/modules/auth.js"
    
    $(document).ready(function(){

        $('#form_login').on('submit', async function(){
            event.preventDefault();
            let params = $(this).serializeArray().map(function(x){
                this[x.name] = x.value; return this;
            }.bind({}))[0];

            const login = await new Auth().login(params);
            if(login){
                let alert = `<div class="alert alert-success text-center" role="alert">success</div>`;
                $('#alert').empty().append(alert);
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }else{
                let alert = `<div class="alert alert-danger text-center" role="alert">Login failed</div>`;
                $('#alert').append(alert);
                setTimeout(() => {
                    $('#alert').empty()
                }, 2000);                
            }
        });
    });
</script>
