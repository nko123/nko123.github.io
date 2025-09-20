<?php
$db_host = '127.0.0.1'; $db_user = 'root'; $db_db = 'Binge'; // WAMPP, XAMPP
// MAMP
$db_password = 'root'; $db_port = '8889';
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_db, $db_port); if ($mysqli->connect_error) {
  echo 'Errno: '.$mysqli->connect_errno;
  echo '<br>';
  echo 'Error: '.$mysqli->connect_error;
  exit();
}

// Function to generate a unique customer ID
function generateCustomerID($mysqli) {
    $customer_id = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT); // Generate a random numeric ID with a maximum of 8 digits
    
    // Check if the generated ID already exists in the database
    $sql = "SELECT * FROM CustomerInfo WHERE CustomerID = '$customer_id'";
    $result = $mysqli->query($sql);
    
    // If the ID exists, generate a new one recursively until a unique one is found
    if ($result->num_rows > 0) {
        return generateCustomerID($mysqli);
    } else {
        return $customer_id;
    }
}

$usn = $_REQUEST["username"]; // ask the user to create its own username 
$fname = $_REQUEST["firstname"];
$lname = $_REQUEST["lastname"];
$email = $_REQUEST["email"];
$pwd = $_REQUEST["Password"];
$customer_id = generateCustomerID($mysqli);


$sql = "SELECT * FROM CustomerInfo WHERE email LIKE '$email' OR username LIKE '$usn'";
$results = $mysqli->query($sql);
if (!$results) { die("Query failed: " . $mysqli->error); }

// to check if user exists already 

$num = $results->num_rows;
if ($num == 1){

    header("Location: signuppage.php?error=already_exists");

} else { 
    $sql1 = "INSERT INTO CustomerInfo (CustomerID, Username, password, email, Firstname, Lastname) VALUES ( '$customer_id','$usn', '$pwd', '$email' ,'$fname', '$lname')"; 

    if ($mysqli->query($sql1) === TRUE) {

        header("Location: signuppage.php?success=signup_complete");
    }
        else { 
            echo "Error: " . $mysqli->error;
        }

    }

    // to insert the info into database 

$mysqli->close();
?>

