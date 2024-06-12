<?php

    // Start Session
    session_start();


    // create constant ot store Repating valuses
    define('SITEURL', 'http://localhost:8080/food-order/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-order');

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD); // ((AS: remove this part 9 [ or die(mysqli_error())  ]))
    $db_select = mysqli_select_db($conn, DB_NAME);
