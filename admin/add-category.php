<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1> Add Category</h1>

        <br><br>

        <?php

            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

?>

        <br><br>


        <!-- add category from start -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Feature: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- add category from end -->

        <?php

            //check whether the submit button is clicked or not
            if (isset($_POST['submit'])) {
                //echo "clicked";

                //1.get the value from category form
                $title = $_POST['title'];

                // for radio input type we need whether the button is clicked or not
                if (isset($_POST['featured'])) {
                    // get the value from form
                    $featured = $_POST['featured'];
                } else {
                    // set the default value
                    $featured = "No";
                }

                if (isset($_POST['active'])) {
                    $active = $_POST['active'];
                } else {
                    $active = "No";
                }

                //check wheather the image are selected or not and set the value for image name according
                // print_r($_FILES['image']);

                // die(); // break the code here

                if (isset($_FILES['image']['name'])) {
                    //upload the image
                    // to upload the image we need image name , source path and destination path
                    $image_name = $_FILES['image']['name'];

                    // upload image only if image is selected
                    if($image_name != "")
                    {
                        //auto rename our images
                        //get the extenstion of our image (jpg, png ,gif, etc) e.g. "food1.jpg"
                        $tmp = explode('.', $image_name);
                        $ext = end($tmp);

                                //rename the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //e.g. Food_Category_834.jpg

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whethter the image is uploaded or not
                        // and if the image is not uploaded the we will stop the prosses and regirect with error message
                        if ($upload==false) {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image. </div>";
                            //redirect to ad category page
                            header('location:'.SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }
                    }
                } 
                else 
                {
                    //don't upload the image and set the image value is blank
                    $image_name="";
                }

                //2. create sql query to insert category in data base
                $sql = "INSERT INTO tbl_category SET
                            title = '$title',
                            image_name = '$image_name',
                            featured = '$featured',
                            active = '$active'
                        ";

                //3. execute the query and save in data base
                $res = mysqli_query($conn, $sql);

                //4. check wheather the query executed or not and data added or not
                if ($res==true) {
                    //query executed and category added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                    // redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                } else {
                    //fail to add category
                    $_SESSION['add'] = "<div class='error'>fail to Add category .</div>";
                    // redirect to manage category page
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }

?>

    </div>
</div>

<?php include('partials/footer.php');?>