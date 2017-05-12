<!--adminChangePassword.php page-->
<div class="col-xs-12">
    <h1 class="page-header">Change Password</h1>

    <form action="" method="post">
        <?php
            //Get user data, pulling it from the session.
        ?>

        <div class="form-group">
            <label for="post_content">New Password</label>
            <input type="password" class="form-control" name="newPassword">
        </div>

        <div class="form-group">
            <label for="post_content">Confirm Password</label>
            <input type="password" class="form-control" name="confirmPassword">
        </div>

        <div class="form-group">
            <input class = "btn btn-primary" type="submit" name="updatepassword" value="Update Password">
            <input class = "btn btn-link" type="button" onclick="window.history.back()" value="Cancel">
        </div>

        <?php
        if (isset($_POST['updatepassword'])) {
            //Function found in adminFunctionUsers.php
            updatePassword($_POST['newPassword'], $_POST['confirmPassword'], $_SESSION['userID']);
        }
        ?>

    </form>
</div>