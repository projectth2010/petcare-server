<?php

include_once('./views/admin/_part/header_meta.php'); ?>

<body class="hold-transition login-page">
    <div class="login-box" style="background-color: #FFFFFF79 !important">
        <div class="login-logo">
            <a href="#"><b>Admin Friday</b>1.0</a>
        </div>
        <!-- /.login-logo -->
        <div class="card" style="background-color: #FFFFFF79 !important">
            <div class="card-body login-card-body" style="background-color: #FFFFFF79 !important">
                <p class="login-box-msg">Sign in to start your session</p>

                <form id="loginForm" action="login" method="post">

                    <div class="input-group mb-3">
                        <input type="text" id="u" name="u" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="p" name="p" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.social-auth-links -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    <style>
        /* General Styling */
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: url('https://img.freepik.com/free-photo/beautiful-retro-nature-with-cute-dog-field_23-2149681469.jpg?t=st=1734025336~exp=1734028936~hmac=39232ce9c6d97a6c6d6328b5709e4f095b039ce4448b1a76538ecc009d5ca092&w=740') no-repeat center;
            background-size: cover;
            height: 100vh;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Restore "Remember Me" checkbox state on page load
            const rememberMeChecked = localStorage.getItem('rememberMe') === 'true';
            document.getElementById('remember').checked = rememberMeChecked;
        });

        document.getElementById('loginForm').addEventListener('submit', function(event) {
            // Save "Remember Me" checkbox state when form is submitted
            const rememberMe = document.getElementById('remember').checked;
            localStorage.setItem('rememberMe', rememberMe);
        });
    </script>
</body>
<?php include_once('./views/admin/_part/footer_admin_lte_script.php');
include_once('./views/admin/_part/footer.php'); ?>