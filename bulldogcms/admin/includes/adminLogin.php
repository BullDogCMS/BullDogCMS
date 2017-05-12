
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <img class="center-block" src="../admin/images/Logo2_v3.png" alt="bullDog CMS Logo" height="200">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title text-center">bullDog CMS Sign In</h1>
                </div>
                <div class="panel-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="username" value="<?php
                                echo $_COOKIE['remember_me']; ?>" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="<?php
                                echo $_COOKIE['remember_me1']; ?>" >
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" <?php if(isset($_COOKIE['remember_me'])) {
                                        echo 'checked="checked"';
                                    }
                                    else {
                                        echo '';
                                    }
                                    ?>> Remember me
                                </label>
                            </div>
                            <button class="btn btn-lg btn-success btn-block" name="login" type="submit"  <?php if($_POST['remember']) {
                            setcookie('remember_me', $_POST['username'], $year);
                            setcookie('remember_me1', $_POST['password'], $year);
                            }
                            elseif(!$_POST['remember']) {
                            if(isset($_COOKIE['remember_me'])) {
                            $past = time() - 31536000;
                            setcookie('remember_me', $_POST['username'], $past);
                            setcookie('remember_me1', $_POST['password'], $past);
                            }
                            }?>>Login
                            </button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php

if(isset($_POST['login'])) {
    //Function found in adminFunctions.php
    loginUser();
}
?>
