<?php

function listUsers() {
    global $connection;

    //PAGINATION (REST OF NECESSARY CODE IS AT THE BOTTOM OF THE PAGE CALLING THIS FUNCTION (adminNavigations.php))
    $siteSettingsQuery = "SELECT * FROM siteSettings WHERE siteSettingID = '1'";
    $selectSiteSettings = mysqli_query($connection, $siteSettingsQuery);
    while($row = mysqli_fetch_assoc($selectSiteSettings)) {
        $perPage = $row['paginationLength']; //pulls how many results are displayed per page from database
    }
    if (isset($_GET['page']))
        $page = $_GET['page'];
    else
        $page = 1;

    if($page == "" || $page == 1)
        $page1 = 0;
    else
        $page1 = ($page * $perPage) - $perPage;

    $usersCountQuery = "SELECT * FROM users";
    $findCount = mysqli_query($connection, $usersCountQuery);
    $count = mysqli_num_rows($findCount);

    $numPages = ceil($count / $perPage);
    session_start();
    $_SESSION['numUsersPages'] = $numPages;//session variables passed to file calling this function
    $_SESSION['currentUsersPage'] = $page;
    //END PAGINATION

    //Get sort values
    if (isset($_GET['order'])) {
        $order = $_GET['order'];
    }

    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
    }

    $query = "SELECT *, DATE_FORMAT(userCreateDate, \"%m-%d-%Y\") AS userDate FROM users";

    //Modify query based on sort.
    switch($order) {
        case 'username';
            $query .= " ORDER BY username";
            break;
        case 'firstname';
            $query .= " ORDER BY firstname";
            break;
        case 'lastname';
            $query .= " ORDER BY lastname";
            break;
        case 'email';
            $query .= " ORDER BY email";
            break;
        case 'role';
            $query .= " ORDER BY roleID";
            break;
        case 'datecreated';
            $query .= " ORDER BY userCreateDate";
            break;
        default:
            $query .= " ORDER BY username";
            break;
    }

    switch($sort) {
        case 'asc';
            $query .= " asc LIMIT $page1, $perPage";
            break;
        case 'desc';
            $query .= " desc LIMIT $page1, $perPage";
            break;
        default:
            $query .= " desc LIMIT $page1, $perPage";
            break;

    }
    $selectUsers = mysqli_query($connection,$query);

    while($row = mysqli_fetch_assoc($selectUsers)) {
        $userID             = $row['userID'];
        $username           = $row['username'];
        $firstName          = $row['firstName'];
        $lastName           = $row['lastName'];
        $email              = $row['email'];
        $roleID             = $row['roleID'];
        $userCreateDate     = $row['userDate'];

        echo "<tr>";
            echo "<td><a href='index.php?view=useredit&edit={$userID}' data-toggle='tooltip' title='View & Edit User'><span class='glyphicon glyphicon-pencil'></span><span class='sr-only'>View and Edit</span></a>&nbsp; &nbsp;";
            if ($row['active'] == 0)
                echo "<a href='index.php?view=users&setactive=$userID' data-toggle='tooltip' title='Activate User'><span class='glyphicon glyphicon-eye-close'></span><span class='sr-only'>Activate</span></a>";
            else
                echo "<a href='index.php?view=users&setinactive=$userID' data-toggle='tooltip' title='Deactivate User'><span class='glyphicon glyphicon-eye-open'></span><span class='sr-only'>Deactivate</span></a></td>";
            echo "<td>$username</td>";
            echo "<td>$firstName</td>";
            echo "<td>$lastName</td>";
            echo "<td>$email</td>";

            if ($roleID == 1) //Converts numbers to actual User Roles
                echo "<td>Contributor</td>";
            else
                echo "<td>Admin</td>";

            echo "<td>$userCreateDate</td>";
        echo "</tr>";
    }
}

function addUser() {
    global $connection;

    $firstName    = mysqli_real_escape_string($connection,$_POST['firstName']);
    $lastName     = mysqli_real_escape_string($connection,$_POST['lastName']);
    $roleID       = $_POST['roleID'];
    $username     = mysqli_real_escape_string($connection,$_POST['username']);
    $email        = mysqli_real_escape_string($connection,$_POST['email']);
    $password     = mysqli_real_escape_string($connection,$_POST['password']);
    $active = '1'; //Set to enabled by default

    if (isset($_POST['emailNotification']))
        $emailNotification = 1;
    else
        $emailNotification = 0;

    //Using Blowfish algorithm.
    //http://php.net/manual/en/function.password-hash.php
    //Password validation check. If passes, hash the entered password, and continue.
    if ($password == "" || empty($password))
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter a Password.</div>';
    else {
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

        $query = "INSERT INTO users(roleID, firstName, lastName, email, username, password, active, emailNotification, userCreateDate) ";

        $query .= "VALUES('{$roleID}','{$firstName}','{$lastName}','{$email}','{$username}', '{$password}', '{$active}', '{$emailNotification}', now()) ";

        //Check if the entered username already exists in db.

//        $userNameCheck = "SELECT * FROM users WHERE username = '($username}'";
//        $resultUserName = mysqli_query($connection, $userNameCheck);

        $userNames = "SELECT * FROM users";
        $nameCheckQuery = mysqli_query($connection, $userNames);
        $usernameExists = False;
        while($row = mysqli_fetch_assoc($nameCheckQuery)){
            $eachName = $row['username'];
            if (strcasecmp($username, $eachName) == 0){
                $usernameExists = True;
                break;
            }
        }

        //Entered Email address check.
        $userEmailCheck = "SELECT * FROM users WHERE email = '{$email}'";
        $resultEmail = mysqli_query($connection, $userEmailCheck);

        //Validation Checks.
        if ($usernameExists == true)
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> A User with the entered Username already exists.</div>';
        else if (mysqli_num_rows($resultEmail)>=1)
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> A User with the entered email address already exists.</div>';
        else if ($roleID == 0)
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please select a User Role.</div>';
        else if ($username == "" || empty($username))
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter a Username.</div>';
        else { //Add the user, add a Changelog entry, and return to the View Users page.
            $addUser = mysqli_query($connection, $query);

            confirmQuery($addUser);

            //Insert into Changelog table, then safely close the db connection.
            $userID = $_SESSION['userID'];
            $changedTable = "users";
            $changeDetails = "Added User: {$username}";
            insertChangeLog($userID, $changedTable, $changeDetails);

            mysqli_close($connection);

            //Refreshes page back to User list
            ?>
            <script type="text/javascript">
                window.location = "index.php?view=users";
                window.alert("User was created successfully.");
            </script>
            <?php
        }
    }

}

function updateUser() {

    global $connection;

    $userID = $_GET['edit'];
    $firstName    = mysqli_real_escape_string($connection,$_POST['firstName']);
    $lastName     = mysqli_real_escape_string($connection,$_POST['lastName']);
    $roleID       = $_POST['roleID'];
    $username     = mysqli_real_escape_string($connection,$_POST['username']);
    $email        = mysqli_real_escape_string($connection,$_POST['email']);
    $password     = mysqli_real_escape_string($connection,$_POST['password']);

    //Set the active value.
    if (isset($_POST['active']))
        $active = 1;
    else
        $active = 0;

    //Set the emailNotification value.
    if (isset($_POST['emailNotification']))
        $emailNotification = 1;
    else
        $emailNotification = 0;

    //Using Blowfish algorithm.
    //http://php.net/manual/en/function.password-hash.php
    //Password validation check. If passes, hash the entered password, and continue.
    //If the user doesn't enter an updated password, then just use the previously saved one. Otherwise update it.
    if ($password == "" || empty($password)) {
        $query = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', roleID = '$roleID', username = '$username', email = '$email', active = '$active', emailNotification = '$emailNotification' WHERE userID = '$userID'";
    } else {
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
        $query = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', roleID = '$roleID', username = '$username', email = '$email', password = '$password', active = '$active', emailNotification = '$emailNotification' WHERE userID = '$userID'";
    }

    //Check if the entered username already exists in db.
    $userNameCheck = "SELECT * FROM users WHERE (username = '{$username}') AND (userID != '{$userID}')";
    $resultUserName = mysqli_query($connection, $userNameCheck);

    //Entered Email address check.
    $userEmailCheck = "SELECT * FROM users WHERE (email = '{$email}') AND (userID != '{$userID}')";
    $resultEmail = mysqli_query($connection, $userEmailCheck);

    //Validation Checks.
    if (mysqli_num_rows($resultUserName) >= 1)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>A User with the entered Username already exists.</div>';
    else if (mysqli_num_rows($resultEmail) >= 1)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>A User with the entered email address already exists.</div>';
    else if ($roleID == 0)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please select a User Role.</div>';
    else if ($username == "" || empty($username))
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter a Username.</div>';
    else { //Add the user, add a Changelog entry, and return to the View Users page.
        $updateUser = mysqli_query($connection, $query);
        confirmQuery($updateUser);

        //Insert into Changelog table, then safely close the db connection.
        $userID = $_SESSION['userID'];
        $changedTable = "users";
        $changeDetails = "Updated User: {$username}";
        insertChangeLog($userID, $changedTable, $changeDetails);

        mysqli_close($connection);

        //Refreshes page back to User list
        ?>
        <script type="text/javascript">
            window.location = "index.php?view=users";
            window.alert("User information updated successfully.");
        </script>
        <?php
    }
}

function updateProfile() {

    global $connection;

    $userID = $_SESSION['userID'];
    $firstName    = mysqli_real_escape_string($connection,$_POST['firstName']);
    $lastName     = mysqli_real_escape_string($connection,$_POST['lastName']);
    $username     = mysqli_real_escape_string($connection,$_POST['username']);
    $email        = mysqli_real_escape_string($connection,$_POST['email']);

    //Set the emailNotification value.
    if (isset($_POST['emailNotification']))
        $emailNotification = 1;
    else
        $emailNotification = 0;

    $query = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', username = '$username', email = '$email', emailNotification = '$emailNotification' WHERE userID = '$userID'";

    //Check if the entered username already exists in db.
    $userNameCheck = "SELECT * FROM users WHERE (username = '{$username}') AND (userID != '{$userID}')";
    $resultUserName = mysqli_query($connection, $userNameCheck);

    //Entered Email address check.
    $userEmailCheck = "SELECT * FROM users WHERE (email = '{$email}') AND (userID != '{$userID}')";
    $resultEmail = mysqli_query($connection, $userEmailCheck);

    //Validation Checks.
    if (mysqli_num_rows($resultUserName) >= 1)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>A User with the entered Username already exists.</div>';
    else if (mysqli_num_rows($resultEmail) >= 1)
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>A User with the entered email address already exists.</div>';
    else if ($username == "" || empty($username))
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter a Username.</div>';
    else { //Add the user, add a Changelog entry, and return to the View Users page.
        $updateUser = mysqli_query($connection, $query);

        confirmQuery($updateUser);

        //Insert into Changelog table, then safely close the db connection.
        $userID = $_SESSION['userID'];
        $changedTable = "users";
        $changeDetails = "Updated User: {$username}";
        insertChangeLog($userID, $changedTable, $changeDetails);

        mysqli_close($connection);

        //Update User Session variables.
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['fullName'] = $_SESSION['firstName'] . " " . $_SESSION['lastName'];

        //Refreshes page back to User list
        ?>
        <script type="text/javascript">
            window.location = "index.php?view=users";
            window.alert("User Profile information was updated successfully.");
        </script>
        <?php
    }

}

//Toggles 'active' value for users when an Admin clicks on the link from the View Users page.
function changeUserActive() {
    global $connection;

    if(isset($_GET['setactive'])) {

        $userID = $_GET['setactive'];
        $query = "UPDATE users SET active = '1' WHERE userID = $userID";
        mysqli_query($connection, $query);

        mysqli_close($connection);

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=users";
            window.alert("User account activated successfully.");
        </script>
        <?php
    }
    if (isset($_GET['setinactive'])) {

        $userID = $_GET['setinactive'];
        $query = "UPDATE users SET active = '0' WHERE userID = $userID";
        mysqli_query($connection, $query);

        mysqli_close($connection);

        ?>
        <script type="text/javascript">
            window.location = "index.php?view=users";
            window.alert("User account deactivated successfully.");
        </script>
        <?php
    }

}

//Called on the ChangePassword page within the CMS Admin.
//Asks User to enter their new password twice.
function updatePassword($newPassword, $confirmPassword, $userID) {

    global $connection;

    if ($newPassword == "" || empty($newPassword))
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>The New Passwords can\'t be blank. Please enter a value.</div>';
    else if ($confirmPassword == "" || empty($confirmPassword))
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>The New Passwords can\'t be blank. Please enter a value.</div>';
    else {
        if ($newPassword == $confirmPassword) {
            $newPassword = password_hash($newPassword, PASSWORD_BCRYPT, array('cost' => 10));
            $updateQuery = "UPDATE users SET password = '$newPassword' WHERE userID = '$userID'";
            mysqli_query($connection, $updateQuery);

            //update changelog, & redirect user back to the editProfile page. Insert into Changelog table, then safely close the db connection.
            $userID = $_SESSION['userID'];
            $changedTable = "users";
            $username = $_SESSION['username'];
            $changeDetails = "Updated Password for: {$username}";
            insertChangeLog($userID, $changedTable, $changeDetails);

            mysqli_close($connection);

            //Refreshes page back to the Edit User page.
            ?>
            <script type="text/javascript">
                window.location = "index.php?view=editProfile";
                window.alert("User password updated successfully.");
            </script>
            <?php
        }
        else
            echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span>The New Passwords don\'t match. Please try again.</div>';
    }
}

function loginUser() {
    global $connection;

    $username = $_POST['username'];
    $password = $_POST['password'];

    //Cleans up input to prevent hacking attempts
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $selectUserQuery = mysqli_query($connection, $query);

    confirmQuery($selectUserQuery);

    while ($row = mysqli_fetch_array($selectUserQuery)) {

        $db_userID = $row['userID'];
        $db_username = $row['username'];
        $db_userPassword = $row['password'];
        $db_userFirstName = $row['firstName'];
        $db_userLastName = $row['lastName'];
        $db_userRoleID = $row['roleID'];
        $db_userActive = $row['active'];
    }

    //Compares entered password with password in database
    //password_verify automatically checks the hash from the database
    //http://us3.php.net/manual/en/function.password-verify.php
    if ($db_userActive == 0) {
        ?>
        <script type="text/javascript">
            window.location = "index.php";
            window.alert("This User is currently deactivated or doesn't exist within the system. Please contact a system Administrator.");
        </script>
        <?php
    } else {
        if (password_verify($password,$db_userPassword)) {

            $_SESSION['userID'] = $db_userID;
            $_SESSION['username'] = $db_username;
            $_SESSION['firstName'] = $db_userFirstName;
            $_SESSION['lastName'] = $db_userLastName;
            $_SESSION['roleID'] = $db_userRoleID;
            $_SESSION['fullName'] = $_SESSION['firstName'] . " " . $_SESSION['lastName'];

            //Update the changelog, & redirect user to the index.php page.
            $userID = $_SESSION['userID'];
            $changedTable = "general";
            $username = $_SESSION['username'];
            $changeDetails = "{$username} logged into the system.";
            insertChangeLog($userID, $changedTable, $changeDetails);

            mysqli_close($connection);

            header("Location: ./index.php");
        } else {
            ?>
            <script type="text/javascript">
                window.location = "index.php";
                window.alert("Invalid Username or password. Please try again.");
            </script>
            <?php
        }
    }
}

?>