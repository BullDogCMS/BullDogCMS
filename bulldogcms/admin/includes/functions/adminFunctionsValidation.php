<?php
//File which houses all global Validation calls.

function checkUserActive() {

    global $connection;
    $uID = $_SESSION['userID'];
    $query = "SELECT active FROM users WHERE userID = $uID";
    $activeQuery = mysqli_query($connection, $query);

    confirmQuery($activeQuery);

    $activeTest = "";

    while ($row = mysqli_fetch_assoc($activeQuery)) {
        $activeTest = $row['active'];
    }

    if ($activeTest == 0) {

        //Clear the Session variables
        $_SESSION['username'] = null;
        $_SESSION['firstName'] = null;
        $_SESSION['lastName'] = null;
        $_SESSION['roleID'] = null;
        $_SESSION['fullName'] = null;;
        ?>

        <!-- Redirect the User to the Login page, and inform them that their account has been deactivated.-->
        <script type="text/javascript">
            window.location = "./login.php";
            window.alert("This User is currently deactivated or doesn't exist within the system. Please contact a system Administrator.");
        </script>
        <?php
    }
}

function numberValidation($number)
{
    if(filter_var($number, FILTER_VALIDATE_INT) == false)
    {

        echo "Please only type a number.";
    }
}