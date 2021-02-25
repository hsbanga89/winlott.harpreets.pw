<?php

// Connection details changed due to security reasons 
function openCon(): mysqli
{
    $dbHost = "localhost";
    $dbUser = "user";
    $dbPass = "password";
    $db = "database";

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $db) or exit("Connect failed: %s\n" . $conn->error);

    return $conn;
}

function closeCon($conn)
{
    $conn->close();
}

