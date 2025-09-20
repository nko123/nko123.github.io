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

<body >
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
    
    
    <!-- Main content -->
    <br />
    <br />
    <hr />
    
    <div style="margin: 30px;">
        <h1 class="movie-list-title">Oscar Winning Movies by Year</h1>

        <br />
        <h3>Click a year to show Oscar winners</h3>

        <!-- Displaying genres in a container -->
        <?php
        // Fetching distinct genres from the database
        $sql = "SELECT DISTINCT year_film FROM oscar_award_excel_database WHERE year_film BETWEEN 2000 AND 2023 ORDER BY year_film DESC;";
        $results = $mysqli->query($sql);
        if (!$results) { 
            die("Query failed: " . $mysqli->error);
        }
        ?>
        <!-- Displaying genres as buttons -->
        <div class="genre_filter">
            <?php
            foreach ($results as $result) { 
                $year = $result["year_film"];
                echo "<a class= 'button' href = 'oscarwinningmovies.php?year=$year'> $year </a>" ;
            }
            ?>
        </div>
    </div>
    <hr />

    <!-- Fetching and displaying movies based on selected genre -->
    <?php
        if(isset($_GET['year'])){
            $year = $_GET['year'];
            if(empty($year)){
                echo "<p>Please Select a Year</p>";
                echo '
                <div style="padding-top: 10px;">
                    <div class="movie-list-container">
                </div>
                </div>    
                    ';
            }
            else{
                $sql1 = "SELECT * FROM oscar_award_excel_database WHERE year_film = '$year' AND winner = 'TRUE';";
                $results1 = $mysqli->query($sql1);
                if (!$results1) { die("Query failed: " . $mysqli->error); }
                echo '
                <div style="padding-top: 10px;">
                    <div class="movie-list-container">
                    <h1 class="movie-list-title">
                    </h1>
                    </div>
                </div>    
                    '; 
                    echo "$year </h1>
                    <hr />";
            }
        } else {
            echo "<p>Please Select a Year</p>";
        }
    ?>

        <div style="padding-top: 70px;">
            <div class="movie-list-container">
                <p>
                    <table style='width: 100%;'>
                        <?php
                            if(isset($_GET['year'])){
                                $year = $_GET['year'];
                                if(empty($year)){
                                    echo "<p>Please Select a Year</p>";
                                }
                                else{
                                    foreach ($results1 as $movie_row) {
                                        $category = $movie_row["category"];
                                        $movie_name = $movie_row["film"];
                                        $movie_actor = $movie_row['name'];
                                        $youtube_link = $movie_row['movie_trailer'];
                                        if (isset($year)) {
                                            echo 
                                            "
                                            <tr class='genre'>
                                                <h2> $category </h2>
                                            </tr>  
                                            <tr class='genre'>
                                                    Movie Name: <b>$movie_name</b><br>
                                                    <br/>
                                                    <b>
                                                    <iframe width='570' height='510' src='$youtube_link' frameborder='0' allowfullscreen></iframe><br>
                                                    Winner(s): </b>$movie_actor</br>
                                            </tr> 
                                            <hr />  
                                                
                                            ";
                                        }
                                    }
                                }
                            }
                        ?>
                    </table>
                </p>
            </div>
        </div>


</body>
</html>
