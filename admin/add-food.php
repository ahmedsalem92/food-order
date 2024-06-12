<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1> Add Food</h1>

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


        <!-- add food from start -->

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of food">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="description of food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" placeholder="Food price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

		<tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php 
                                // create php code to display the categories from data base
                                //1. create SQL to get all active categories from data base
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                //execute the query
                                $res = mysqli_query($conn, $sql);
                                //count rows to check whether we have catefories or not
                                $count = mysqli_num_rows($res);
                                //if count is greater that zero, we have categories else we don,t have category
                                if($count>0){
                                    //we have categories
                                    // using while loop to display all category
                                    while($row=mysqli_fetch_assoc($res)){
                                        // get the daties of categories
                                        $id = $row['id'];
                                        $title = $row['title'];?>
                                    <!-----//2. display on dropdown---->
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php 
                                    }
                                }
                                else
                                {
                                    ?>
                                    <option value="0">No category found</option>
                                    <?php
                                }
                                    ?>
                        </select>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
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
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

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
                        $tmp =explode('.', $image_name);
                        $ext = end($tmp);

                                //rename the image
                        $image_name = "Food_Name_".rand(0000, 9999).'.'.$ext; //e.g. Food_Category_834.jpg

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/food/".$image_name;

                        //finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whethter the image is uploaded or not
                        // and if the image is not uploaded the we will stop the prosses and regirect with error message
                        if ($upload==false) {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image. </div>";
                            //redirect to ad category page
                            header('location:'.SITEURL.'admin/add-food.php');
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
                $sql2 = "INSERT INTO tbl_food SET
                    		title = '$title',
                    		description = '$description',
                    		price = $price,
                    		image_name = '$image_name',
                    		category_id = $category,
                    		featured = '$featured',
                    		active= '$active'
                        ";

                //3. execute the query and save in data base
                $res2 = mysqli_query($conn, $sql2);

                //4. check wheather the query executed or not and data added or not
                if ($res2==true) {
                    //query executed and category added
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                    // redirect to manage category page
                    //header("location:".SITEURL."admin/manage-food.php");
                    //header('location:'.SITEURL.'/admin/manage-food.php');
                    //using JS to solve a debuging
                    echo "<script>window.location.href= 'http://localhost:8080/food-order/admin/manage-food.php' </script>";
                } else {
                    //fail to add category
                    $_SESSION['add'] = "<div class='error'>fail to Add food .</div>";
                    // redirect to manage category page
                    header("location:".SITEURL."admin/manage-food.php");
                }
            }

?>

    </div>
</div>

<?php include('partials/footer.php');?>