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
//above is copy and paste from code prof provided

$usn = $_REQUEST["username"];
$pwd = $_REQUEST["Password"];
$sql ="SELECT * FROM CustomerInfo WHERE username LIKE '$usn' AND password LIKE '$pwd';";
// to check if the query is correct: echo $sql;

$results = $mysqli->query($sql);
if(!$results){die("Query failed: ".$mysqli->error);}

$num = $results->num_rows;

session_start();
if($num == 1){
    //you can also do $results->num_row > 0 instead of $num
    //good, the creds match 
    foreach($results as $result){
        //if the creds are correct, it will redirect the user to the homepage based on that cookie (the customer ID)
        $_SESSION["CustomerID"] = $result["CustomerID"]; //example: 1
        header("Location: homepage.php");
    }

    //this want show since it will redirect the using to the account page, it was originally used to indicate whether the code worked before we added the foreach above
    echo "successful";

    echo $_SESSION['CustomerID'];
}
else{
    //bad, creds are incorrect
    header("Location: LoginPage.php?error=incorrect_cred");
}


$mysqli->close();
?>