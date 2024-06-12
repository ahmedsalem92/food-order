<?php

// include
include('../config/constants.php');

// 1. destroy the session
session_destroy(); // ussets $_SESSION['user']

//2. redirct to login page
header('location:'. SITEURL .'admin/login.php');
