<?php
include('header.php');
?>
<h1 class="text-hide">Signup for an account</h1>
<div class="container">
<h4 class="text-center">Register for an account</h4>
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card-1">
                <form action="process.signup.php" method="post" id="signup" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Username</span>
                        </div>
                        <input type="text" name="username" class="form-control" id="username">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Firstname</span>
                        </div>
                        <input type="text" name="firstname" maxlength="50" class="form-control" id="firstname">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Lastname</span>
                        </div>
                        <input type="text" name="lastname" maxlength="50" class="form-control" id="lastname">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Email</span>
                        </div>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Phone</span>
                        </div>
                        <input type="text" name="phone" id="phone" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Password</span>
                        </div>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <button name="signup" class="btn btn-primary btn-md mx-auto px-5" type="submit">Signup</button>

                </form>

            </div>
        </div>
    </div>
</div>
<script src="custom.js"></script>
<?php include('footer.php');
