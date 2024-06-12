<?php include('partials/menu.php'); ?>

<?php 
    //check whether id is sit or not
    if(isset($_GET['id']))
    {
        //get all the details
        $id = $_GET['id'];

        //SQL query to get the selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        //execute the query
        $res2 = mysqli_query($conn, $sql2);

        //get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //get the individual value of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];

    }
    else
    {
        //redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>

<div class="main-content">
    
    <div class="wrapper">
        
        <h1>Update Food</h1>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td> Title: </td>
                    <td> 
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                       <?php 
                        if($current_image == "")
                        {
                            //image not available
                            echo "<div class='error'> Image not Available. </div>";
                        }
                        else
                        {
                            //image available
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="100px" height="100px" >
                            <?php
                        }
                       ?>
                    </td>
                </tr>

                <tr>
                    <td>Select new Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                                //query to get active catergories 
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                //execute the query
                                $res = mysqli_query($conn, $sql);
                                //count rows
                                $count = mysqli_num_rows($res);

                                //check whether category available or not
                                if($count>0)
                                {
                                    //category available
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];

                                        //echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                        <option <?php if($current_category==$category_id){echo "Selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //category not available
                                    echo "<option value='0'>Category not available.<option>";
                                }
                            ?>

                            <option value="0"> Test category </option>
                        </select> 
                    </td>
                <tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                <tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                <tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php 
            
            if(isset($_POST['submit']))
            {
               // echo "buttom clicked";

               //1. get all the details from the form
               $id = $_POST['id'];
               $title = $_POST['title'];
               $description = $_POST['description'];
               $price = $_POST['price'];
               $current_image = $_POST['current_image'];
               $category = $_POST['category'];
               $featured = $_POST['featured'];
               $active = $_POST['active'];

               //2. upload the image if selected

               //checked whether upload image cliled or not
               if(isset($_FILES['image']['name']))
               {
                    //upload button clicked
                    $image_name = $_FILES['image']['name']; // new image name

                    //check whether file is available or not
                    if($image_name!="")
                    {
                        //image is available
                        //A. uploading new image
                        //rename the image
                        $tmp = explode('.', $image_name);
                        $ext = end($tmp);

                        $image_name = "Food_Name_".rand(0000, 9999).'.'.$ext;

                        //get the source  and destination
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;

                        //upload the image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        //checked whether the image is upload or not
                        if($upload==false)
                        {
                            //failed to upload
                            $_SESSION['upload'] ="<div class='error'>Failed to upload new Image. </div>";
                            //redirect to manage food
                            header('loaction:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die();
                        }

                                       //3. remove the image if new image is upload and currebt image wxists
                        //B.remove current image if available
                        if($current_image!="")
                        {
                            //current image is available
                            //remove the image
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            // check whether the image is removed or not
                            if($remove==false)
                            {
                                //fail to remove current image
                                $_SESSION['remove-failed'] = "<div class='error'>fail to remove image</div>";
                                //redirect to manage food
                                header('loaction:'.SITEURL.'admin/manage-food.php');
                                //stop the process
                                die();
                            }
                        }
                    }
                    else
                    {
                         $image_name = $current_image;
                    }
               }
               else
               {
                    $image_name = $current_image;
               }
               


               //4. update the food in database
               $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id =$id

               ";

               // execute the SQL query
               $res3 = mysqli_query($conn, $sql3);

               //check whether and food update
               if($res3==true)
               {
               //query exectued and food upload
                $_SESSION['update'] = "<div class='success'> food update sucessfully </div>";
                echo "<script>window.location.href= 'http://localhost:8080/food-order/admin/manage-food.php' </script>";

               }
               else
               {
                //fail to update food
                $_SESSION['update'] = "<div class='error'> fail to update food </div>";
                header('location:'.SITEURL.'admin/manage-food.php');
               }

            }

        ?>

    </div>

</div>

<?php include('partials/footer.php'); ?>