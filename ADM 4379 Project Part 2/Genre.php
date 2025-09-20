<!DOCTYPE html>
<html>
<head>
    <!-- Linking the stylesheet -->
    <link rel="stylesheet" href="bingestylesheet.css" />

    <!-- Title of the page -->
    <title>Top Movies</title>
</head>

<?php
    $db_host = '127.0.0.1'; $db_user = 'root'; $db_db = 'Binge';
    // WAMPP, XAMPP
    // MAMP
    $db_password = 'root';
    $db_port = '8889';

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
                        echo '<a href="account.php">Account Profile</a>';
                        echo '<a href="LoginPage.php">Log Out</a>';
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

    <!-- Main content -->
    <br />
    <br />
    <hr />
    <div style="margin: 30px;">
        <h1>Top Movies by Genre</h1>
        <br />

        <h3>Click a genre to show movies</h3>

        <br />

        <!-- Displaying genres in a container -->
        <?php
        // Fetching distinct genres from the database
        $sql = "SELECT Distinct Genre  FROM movie_database ;";
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
    </div>
    <hr />

    <?php
    if(isset($_GET['genre'])){
        $year = $_GET['genre'];
        if(empty($genre)){
            echo "Please Select a Genre";
        }
        else{
            $genre = $_GET['genre'];
            $sql1 = "SELECT * FROM movie_database WHERE Genre = '$genre';";
            $results1 = $mysqli->query($sql1);
            if (!$results1) { die("Query failed: " . $mysqli->error); }
            echo '
            <div style="padding-top: 70px;">
                <div class="movie-list-container">
                <!-- Displaying the selected genre -->
                <h1>
                </div>
            </div>
                
                ';
                echo "$genre </h1>";
        }
    } else {
        echo "<p>Please Select a Genre</p>";
    }
    ?>
            <br><br>
            <p>
                <table style='width: 100%;'>
                    <tr>
                        <?php
                        if(isset($_GET['genre'])){
                            $year = $_GET['genre'];
                            if(empty($genre)){
                                echo "Please Select a Genre";
                            }
                            else{
                                foreach ($results1 as $result) {
                                    $name = $result['Name'];
                                    $description = $result['Description'];
                                    $cast = $result['Cast'];
                                    $age_rating = $result['Age Rating'];
                                    $rotten_tomatoes = $result['Rotten_tomatoes_link'];
                                    $youtube_link = $result['Youtube_link'];
                                    // Ensure YouTube link is properly formatted
                                    $youtube_embed_link = str_replace("watch?v=", "embed/", $youtube_link);
                                    // Displaying movie details
                                    if (isset($genre)) {
                                        echo "
                                        <td class='genre'>
                                            <b > $name </b><br>
                                            <br />
                                            <iframe width='570' height='510' src='$youtube_embed_link' frameborder='0' allowfullscreen></iframe><br>
                                            <br />
                                            <p class='genre'>
                                                <b>Description:</b> $description <br>
                                                <br />
                                                <b>Cast:</b> $cast <br>
                                                <br />
                                                <b>Age Rating:</b> $age_rating <br> 
                                                <br />
                                            </p>
                                            <a class='button' href='$rotten_tomatoes'>Rotten Tomatoes</a><br>
                                        </td>";
                                    }
                                }
                            }
                        }
                        ?>
                    </tr>
                </table>
                <br>
            </p>
            <br>
    <?php
    // Closing database connection
    $mysqli->close();
    ?>
</body>

</html>
