<?php

$db['db_host'] = "server here";
$db['db_user'] = "database user here";
$db['db_pass'] = "database pw here";
$db['db_name'] = "database name here";

#Changing values into constants.  Supposed to be more secure.
foreach($db as $key => $value){

    define(strtoupper($key), $value);
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($connection) {

    //echo "We are connected";
}

?>