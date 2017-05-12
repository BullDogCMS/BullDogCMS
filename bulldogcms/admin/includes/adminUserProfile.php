<!--UserProfile.php page-->
<div class="col-xs-12">
    <h1 class="page-header">Edit Profile</h1>

    <?php
    if (isset($_POST['updateuser'])) {
        //Function found in adminFunctionsUsers.php
        updateProfile();
    }
    ?>

    <form action="" method="post">
        <?php

            //Populate user data based on the userID from the session object.
            $userID = $_SESSION['userID'];
            $query = "SELECT * FROM users WHERE userID = $userID ";
            $uID = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($uID)) {
                $userID = $row['userID'];
                $firstName = $row['firstName'];
                $lastName = $row['lastName'];
                $userName = $row['username'];
                $email = $row['email'];
                $password = $row['password'];
                $emailNot = $row['emailNotification'];
                $userRole = $row['roleID'];
                ?>

                <div class="form-group">
                    <label for="title">First Name</label>
                    <input value = "<?php if(isset($firstName)) {echo htmlentities($firstName, ENT_QUOTES, 'UTF-8');} ?>" type="text" class="form-control" name="firstName">
                </div>

                <div class="form-group">
                    <label for="post_status">Last Name</label>
                    <input value = "<?php if(isset($lastName)) {echo htmlentities($lastName, ENT_QUOTES, 'UTF-8');} ?>" type="text" class="form-control" name="lastName">
                </div>

                <div class="form-group">
                    <label for="post_tags">Username</label>
                    <input value = "<?php if(isset($userName)) {echo htmlentities($userName, ENT_QUOTES, 'UTF-8');} ?>" type="text" class="form-control" name="username">
                </div>

                <div class="form-group">
                    <label for="post_content">Email</label>
                    <input value = "<?php if(isset($email)) {echo htmlentities($email, ENT_QUOTES, 'UTF-8');} ?>"type="email" class="form-control" name="email">
                </div>

                <div class="form-group">
                    <label for="post_content" data-toggle="tooltip" title="Allows you to change your password.">Password</label>
                    <a href="index.php?view=changePassword" data-toggle="tooltip" title="Selecting this link allows you to change your password.">Change Password</a>
                </div>

                <!--emailNotification field-->
                <?php if ($userRole == 1) { //Contributor, don't display Email Notifications checkbox.
                    } else { //Admin user (userRole = 2)
                        echo "<div class='form-group'>";
                                echo "<label for='post_content' data-toggle='tooltip' title='Would you like to receive email notifications for pending updates within the system?'>Receive Email Notifications?</label>";
                        if ($emailNot == 1)
                            echo "<input type='checkbox' name='emailNotification' checked>";
                        else
                            echo "<input type='checkbox' name='emailNotification'>
                            </div>";
                    }
                ?>

            <?php
            }
        ?>
        <div class="form-group">
            <input class = "btn btn-primary" type="submit" name="updateuser" value="Update Profile" data-toggle="tooltip" title="Update Profile">
            <input class = "btn btn-link" type="button" onclick="window.history.back()" value="Cancel" data-toggle="tooltip" title="Selecting this link will redirect you to the previous page and the Profile information will not be updated.">
        </div>
    </form>
</div>