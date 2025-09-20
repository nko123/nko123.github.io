<!DOCTYPE html>
<html>

<head> 
    <title>Customer Login</title>
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


    <div class="f_orm">
        <div style="padding-top: 70px;">
            <form action="LoginPage_handler.php" method="post">
                <div class="colourbl">
                    <h1> Login to your Account </h1>
                    <img src="login-user.png"><br />
                    <b>Username:</b><br/><input type="text" name="username" placeholder="Enter Username" required /> <br/>
                    <b>Password:</b><br/> <input type="password" name="Password" placeholder="Enter Password" required /> <br/>
                    <input type="checkbox" name="terms and conditions" value="Remember me" checked required/> Remember me <br/>
                
                </div>

                <p class="colourred">
                    <?php
                
                    if (isset($_GET['error'])) {
                        if($_GET['error'] == 'incorrect_cred') {
                            echo  "Incorrect Username or Password";
                        }
                    }
                    ?>
                </p>

                <input class="column2" type="submit"/> 
                <input class="column2" type="reset" name="reset" /> <br/>
                

                <button class="right" name="button" value="link" type="button"> <a href="ForgotPasswordPage.php">Forgot Password</a></button>

                <br/>
                <br/>
                <br/>

                <hr/>

                <p class="center_al" > OR<br/> </p>

                <p class="center_al">
                    <a href="signuppage.php">
                        <button style="color:white; border-radius: 5px; background-color: #AF29FF; border-style: solid; border-color:#AF29FF; padding: 12px 20px; cursor:pointer; width: 100%; " type="button">Sign Up</button>
                    </a>
                </p>
            </form>

        </div>
    </div>



</body>



</html>

