<div class="col-xs-12">
    <h3>Add User</h3>

    <?php
        if(isset($_POST['adduser'])) {
            //Function found in adminFunctions.php
            addUser();
        }
    ?>

    <form action="" method="post" enctype="multipart/form-data">

        <!--FirstName-->
        <div class="form-group col-xs-12 col-md-6">
            <label for="title">First Name</label>
            <input type="text" class="form-control" name="firstName">
        </div>

        <!--LastName-->
        <div class="form-group col-xs-12 col-md-6">
            <label for="post_status">Last Name</label>
            <input type="text" class="form-control" name="lastName">
        </div>

        <!--UserRole-->
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
                        echo "<option value='$roleID'>{$roleName}</option>";

                    }
                ?>

            </select>
        </div>

        <script>
            function emailNot() {
                if (document.getElementById("role").value != "2") { //Hide the email Notifications label/checkbox.
                    document.getElementById("emailNotification").style.display = 'none';
                } else { //Display the emailNotifications label/checkbox.
                    document.getElementById("emailNotification").style.display = 'block';
                }
            }
        </script>

        <!--Username-->
        <div class="form-group col-xs-12 col-md-6">
            <label for="post_tags">Username</label>
            <input type="text" class="form-control" name="username">
        </div>

        <!--Email-->
        <div class="form-group col-xs-12 col-md-6">
            <label for="post_content">Email</label>
            <input type="email" class="form-control" name="email">
        </div>

        <!--Password-->
        <div class="form-group col-xs-12 col-md-6">
            <label for="post_content">Password</label>
            <input type="password" class="form-control" name="password">
        </div>

        <!--emailNotification-->
        <div class="form-group" id="emailNotification">
            <label for="post_content" data-toggle="tooltip" title="Would you like this User to receive email notifications for pending updates within the system?">Receive Email Notifications?</label>
            <input type="checkbox" name="emailNotification">
        </div>

        <!--addUser/cancel buttons-->
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="adduser" value="Add User" data-toggle="tooltip" title="Add User">
            <input class = "btn btn-link" type="button" onclick="window.history.back()" value="Cancel" data-toggle="tooltip" title="Selecting this link will redirect you to the previous page and the User will not be added.">
        </div>
    </form>
</div>