<?php

$host = "localhost";
$user = "root";
$pass = "";
$name = "suratsdm";

$db=new mysqli($host, $user, $pass, $name);
if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}

?>