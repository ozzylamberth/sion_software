<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'emmanuelips');
define('DB_USERNAME','root');
define('DB_PASSWORD','515t3m45');


$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if( mysqli_connect_error()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
