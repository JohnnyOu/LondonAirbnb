<?php
session_start();
$dbhost = '127.0.0.1';
$dbuname = 'root';
$dbpass = 'root';
$dbname = 'Airbnb';
$mysqli = new mysqli($dbhost, $dbuname, $dbpass, $dbname);
if ($mysqli -> connect_errno) {
  die("You died of a first staged accident, exiled from our DB! Never come back!" . mysqli_connect_error());
} ?>

<html>
<head></head>

<body>
  <?php
  $response = $_POST["option"];
  if ($response == "no") {
    header('Location: host.php');
  } else {
    $id = $_SESSION['id'];
    $query = "DELETE FROM listings_location WHERE id = $id";
    $res = mysqli_query($mysqli, $query);
    if (!$res) {
      die("You died of a second staged accident, exiled from our DB! Never come back!");
    }
    echo "You have successfully deleted listing with ID " . $id . "."; ?>
    <br><a href="delete.php">Go back to delete.php</a>
  <?php } ?>
</body>
</html>
