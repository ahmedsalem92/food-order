<?php include('partials/menu.php'); ?>

<div class="main-contant">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br /><br /><br />

        <?php
            if (isset($_SESSION['add'])) { // checking whether the session
                echo $_SESSION['add']; //displaying session message
                unset($_SESSION['add']); // removing session message
            }

?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                         <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>

                </tr>

            </table>

        </form>

    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
    //process the Value from the form and save it in database
    //check wether the Submit button is clicked or not

    if (isset($_POST['submit'])) {
        //Button Cliked
        //echo "Button clicked";

        //1. Get the Date from Form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. SQL Query to save the data into database
        $sql = "INSERT INTO tbl_admin SET
        full_name='$full_name',
        username='$username',
        password='$password'
        ";

        //3. Executing query and saving data into database
        $res = mysqli_query($conn, $sql); // ((AS: remove this part 9 [ or die(mysqli_error())  ]))

        //4. check whether the (Query is Executed) data is inserted or not and display approgritate message
        if ($res==true) {
            //Data Inserted
            //echo "Data Inserted";
            //Create a seesion Variable to Display massage
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
            //redirect page to manage admin
            header("location:" . SITEURL . 'admin/manage-admin.php');
        } else {
            //Failed to Insert data
            //echo "Failed to Insert data";
            //Create a seesion Variable to Display massage
            $_SESSION['add'] = "<div class='error'>Fail to add Admin</div>";
            //redirect page to Add admin
            header("location:" . SITEURL . 'admin/add-admin.php');
        }
    }
?>