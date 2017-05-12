<!--UserEdit.php page-->

<div class="col-xs-12">
    <h1 class="page-header">Edit User</h1>

    <?php
        if (isset($_POST['updateuser'])) {
            //Function found in adminFunctionsUsers.php
            updateUser();
        }
    ?>

        <form action="" method="post">
            <?php

                //Populate user data.
                if(isset($_GET['edit'])) {
                    $userID = $_GET['edit'];
                    $query = "SELECT * FROM users WHERE userID = $userID ";
                    $uID = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($uID)) {
                        $userID = $row['userID'];
                        $firstName = $row['firstName'];
                        $lastName = $row['lastName'];
                        $uRoleID = $row['roleID'];
                        $userName = $row['username'];
                        $email = $row['email'];
                        $password = $row['password'];
                        $active = $row['active'];
                        $emailNot = $row['emailNotification'];
                        ?>

                    <div class="form-group col-xs-12 col-md-6">
                        <label for="title">First Name</label>
                        <input value = "<?php if(isset($firstName)) {echo htmlentities($firstName, ENT_QUOTES, 'UTF-8');} ?>" type="text" class="form-control" name="firstName">
                    </div>

                    <div class="form-group col-xs-12 col-md-6">
                        <label for="post_status">Last Name</label>
                        <input value = "<?php if(isset($lastName)) {echo htmlentities($lastName, ENT_QUOTES, 'UTF-8');} ?>" type="text" class="form-control" name="lastName">
                    </div>

                    <!-- User Role-->
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="user_role" data-toggle="tooltip" title="Determines which User Role the User will belong to, and what level of access they will have.">User Role</label>
                        <select class="form-control" name="roleID" id="role" onchange="emailNot()">

                            <option value="0">Select a User Role</option>
                                <?php
                                    $query = "SELECT * FROM roles";
                                    $selectRoles = mysqli_query($connection, $query);

                                    confirmQuery($selectRoles);

                                    while($row = mysqli_fetch_assoc($selectRoles)) {
                                        $roleID = $row['roleID'];
                                        $roleName = $row['roleName'];

                                        if ($uRoleID == $roleID)
                                            echo "<option value='$roleID' selected='selected'>{$roleName}</option>";
                                        else
                                            echo "<option value='$roleID'>{$roleName}</option>";
                                    }
                                ?>

                        </select>
                    </div>

                    <script>
                        function emailNot() {
                            if (document.getElementById("role").value != "2") { //Hide the email Notifications label/checkbox.
                                document.getElementById("emailNotification").style.display = 'none';
                                document.getElementById("emailCheck").checked = false;
                            } else { //Display the emailNotifications label/checkbox.
                                document.getElementById("emailNotification").style.display = 'block';
//                                document.getElementById("emailCheck").checked = true;
                            }
                        }
                    </script>

                    <div class="form-group col-xs-12 col-md-6">
                        <label for="post_tags">Username</label>
                        <input value = "<?php if(isset($userName)) {echo htmlentities($userName, ENT_QUOTES, 'UTF-8');} ?>" type="text" class="form-control" name="username">
                    </div>

                    <div class="form-group col-xs-12 col-md-6">
                        <label for="post_content">Email</label>
                        <input value = "<?php if(isset($email)) {echo htmlentities($email, ENT_QUOTES, 'UTF-8');} ?>"type="email" class="form-control" name="email">
                    </div>

                    <div class="form-group col-xs-12 col-md-6">
                        <label for="post_content">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <!--Active field-->
                    <div class="form-group">
                        <label for="post_content" data-toggle="tooltip" title="Determines if the User is active and allowed to access the system or not.">Active?</label>
                        <?php if ($active == 1)
                                echo "<input type='checkbox' name='active' checked>";
                              else
                                echo "<input type='checkbox' name='active'>"; ?>
                    </div>

                    <!--emailNotification field-->
                    <div class="form-group" id="emailNotification">
                        <label for="post_content" data-toggle=tooltip" title="Would you like to receive email notifications for pending updates within the system?">Receive Email Notifications?</label>
                            <?php if ($emailNot == 1)
                                echo "<input type='checkbox' name='emailNotification' id='emailCheck' onchange='emailNot()' checked>";
                            else
                                echo "<input type='checkbox' name='emailNotification' id='emailCheck' onchange='emailNot()'>";
                            ?>
                    </div>

                    <?php }
                    }
            ?>
            <div class="form-group">
                <input class = "btn btn-primary" type="submit" name="updateuser" value="Update User" data-toggle="tooltip" title="Update User">
                <input class = "btn btn-link" type="button" onclick="window.history.back()" value="Cancel" data-toggle="tooltip" title="Selecting this link will redirect you to the previous page and the User information will not be updated.">
            </div>
        </form>
</div>
