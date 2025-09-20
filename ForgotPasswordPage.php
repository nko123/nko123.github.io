
<html>

<head> 
    <title>Password Recovery</title>
    <link rel="stylesheet" href="bingestylesheet.css" />

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

</body>

<body class="f_orm">

    <div style="padding-top: 70px;">
        <form>
            <div class="colourbl">

                <h1 style="text-align: left; color:#AF29FF;"> Forgot Your Password? </h1>
                <p>Enter your email to reset your password</p>
            
                <b>Email:</b><br/><input type="email" name="email" placeholder="name@mail.com " required /> <br/>

            </div>
            
            
            <br/>
        

            <!--changing the name for submit isn't working :( -->

            <input  type="submit"/>   
            <button style="background-color: black; border-radius: 5px; width: 49.5%; padding: 12px 20px; margin: 8px 0; box-sizing: border-box; cursor:pointer;" 
            type="button" name="Cancel"> <a style="color: white;"href="homepage.html"> Cancel </a></button>
        </form>
    </div>



</body>


