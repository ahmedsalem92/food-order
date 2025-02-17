<?php include('partials-front/menu.php'); ?> 

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">

            <?php

                //            //Get the search keyword
                //$search = $_POST['search'];
                //$search = mysqli_real_escape_string($_POST['search']);
                $search = mysqli_real_escape_string($conn, $_POST['search']);

            ?>
            
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php  
            
            //SQL query to Get foods based on search keyword
            // $search = burger' drop database name;
            // Select * from tbl_food where title like '%burger'%' or decreption like '%burger'%'
            $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
            
            // Execute the query
            $res = mysqli_query($conn, $sql);

            //count Rows
            $count = mysqli_num_rows($res);

            //check whether food available of not
            if($count>0)
            {
                //food Available
                while($row=mysqli_fetch_assoc($res))
                {
                    //get the datails
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>

                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php 
                                    //check whether image available or not
                                    if($image_name=="")
                                    {
                                        //image not available
                                        echo "<div class='error'>Image not avaible</div>";
                                    }
                                    else
                                    {
                                        //image avaible
                                        ?>
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?> " alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price">LE <?php echo $price; ?></p>
                                    <p class="food-detail">
                                        <?php echo $description; ?>
                                    </p>
                                    <br>

                                    <a href="#" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>

                    <?php
                }
            }
            else
            {
                //food not Available
                echo "<div class='error'>Food not found.</div>";
            }

            ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?> 