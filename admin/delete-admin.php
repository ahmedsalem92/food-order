<?php

// include constants.php file
include('../config/constants.php');

//1. gett the IF of admin to be deleted
$id = $_GET['id'];

//2. create SQL Query to Delete Admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

// execute the query
$res = mysqli_query($conn, $sql);

//check wheather the query is executed scussefully or not
if ($res==true) {
    // query executed sucssefully and admin deleted
    //echo "admin deleted";
    //create session variable to display massage
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
    //redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
} else {
    // failed to deleted admin
    //echo "failed to delete admin";
    $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try again Later</div>";
    //redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}

//3. Redirect to Manage Admin page with message (sussess/error)

?>

<?php ?>