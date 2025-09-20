<html>

<head>

    <link rel="stylesheet" href="bingestylesheet.css" />
    <title>
        Binge
    </title>


</head>

<?php
    $db_host = '127.0.0.1'; $db_user='root'; $db_db = 'Binge';
    // MAMP
    $db_password = 'root'; $db_port = '8889';

    //WAMPP, XAMPP
    //$db_password = ''; $db_port = '3306';

    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_db, $db_port);
    if ($mysqli->connect_error) {
        echo 'Errno: '.$mysqli->connect_errno;
        echo '<br>';
        echo 'Error: '.$mysqli->connect_error;
        exit();
    }
?>  

<body>
    <!--The Navigation Bar that will be consistent for all pages-->
    <div class="navbar">
        <a href="homepage.php" class="logo"
            style="color: #AF29FF; font-size: large; background-color: black;">Binge</a>
        <a href="homepage.php">HOMEPAGE</a>
        <div class="dropdown">
            <button class="dropbtn">MOVIES</button>
            <div class="dropdown-content">
                <a href="Genre.php">Top Movies</a>
                <a href="oscarwinningmovies.php">Oscar Winning Movies</a>
            </div>
        </div>
        <a href="theaterlocator.php">THEATER LOCATOR</a>
        <div class="dropdown" style="float: right;">
            <button class="dropbtn">
            <?php  
            session_start();
            //isset <-checks if there is a customer ID or if a customer logged in (if there is a Customer id in session)
            if (isset($_SESSION["CustomerID"])) {
                $cID = $_SESSION["CustomerID"];

                $sql = "SELECT Firstname, Lastname FROM `CustomerInfo` WHERE CustomerID = $cID;";
                $results = $mysqli->query($sql);
                if (!$results) { die("Query failed: " . $mysqli->error); }

                foreach($results as $result){
                    $fname = $result["Firstname"];
                    $lname = $result["Lastname"];
                    echo "$fname $lname";
                }
            }
            else{
                echo "Signup | Login";
            }
            ?>
            </button>
            <div class="dropdown-content">
                <?php  
                    if (isset($_SESSION["CustomerID"])) {
                        //account profile page currently does not exist
                        //echo '<a href="account.php">Account Profile</a>';
                        echo '<a href="logout_handler.php">Log Out</a>';
                    }
                    else {
                        echo '<a href="signuppage.php">Signup</a>';
                        echo '<a href="LoginPage.php">Login</a>';
                    }
                ?>
                
            </div>
        </div>
        <!--Provide a search bar for users. Currently not function-->
        <div >
            <input style="width:200px; float: right; padding: 6px; border: 1px solid; border-color: #AF29FF; margin-top: 15px; margin-right: 16px;" 
            type="text" placeholder="Search...">
        </div>
        
    </div>

    <!-- hero image-->
    <div class="hero-image">
        <div class="hero-text">
            <?php 
                if(isset($_SESSION["CustomerID"])){
                    foreach($results as $result){
                        $fname = $result["Firstname"];
                        echo "<h3>Hello $fname,</h3>";
                    } 
                }?> 
            <h3>Welcome To</h3>
            <h1 class="logo" style="font-size: 50;">Binge</h1>
            <p>Dive into the magic of cinema with us!</p>
            <a class="button" href="theaterlocator.php" style="color: white;">Locate A Theater</a>
        </div>
    </div>

    <!--top movies by genre section-->
    <hr />
    <div style="margin: 30px;">
        <h1>Top Movies by Genre</h1>
        <p>Explore our Top 3 Movies by Genre, featuring the best in action, drama, and comedy</p>

        <br />
         <!-- Displaying genres in a container -->
         <?php
        // Fetching distinct genres from the database
        $sql = "SELECT Distinct Genre  FROM movie_database;";
        $results = $mysqli->query($sql);
        if (!$results) { 
            die("Query failed: " . $mysqli->error);
        }
        ?>
        <!-- Displaying genres as buttons -->
        <div class="genre_filter">
            <?php
            foreach ($results as $result) { 
                $genre = $result["Genre"];
                echo "<a class= 'button' href = 'Genre.php?genre=$genre'> $genre </a>" ;
            }
            ?>
        </div>
        <br />

        <table style="width: 100%;">
            <tr>
                <!--add proper stock photos after-->
                <td><img class="genre_img" src="dune.jpg"></td>
                <td><img class="genre_img" src="insideout2.jpg"></td>
                <td><img class="genre_img" src="MI.jpg"></td>
            
            </tr>
        </table>
        <br />
        <hr />
    </div>

    <br />

    <!--oscar winning movies section-->
    <div>
        <h1>Oscar Movies</h1>
        <img style="padding:15px;" src="stock_oscar.jpg">
        <br />
        <p>Discover Oscar Award Winning Movies of 2023</p>
        <br />
        <a class="button" href="oscarwinningmovies.php">Check The Out List</a>
    </div>

    <hr />

    <!--contact us section, currently not functional-->
    <div>
        <form style="color: black; text-align: left;">
            <h1 style="text-align: center;">CONTACT US</h1>
            <b>Name*</b><br /> <input type="text" name="contact_name" required><br />
            <b>Email*</b> <br /> <input type="text" name="contact_email" required><br />
            <br />
            <b>Questions or Comments*</b><br /><textarea name="contact_comment" cols="90" rows="10"></textarea><br />
            <input type="submit" value="Submit" class="button">
        </form>
    </div>
</body>

<?php $mysqli->close(); ?>

</html>