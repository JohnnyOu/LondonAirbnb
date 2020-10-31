<?php
session_start();
$dbhost = '127.0.0.1';
$dbuname = 'root';
$dbpass = 'root';
$dbname = 'Airbnb';
$mysqli = new mysqli($dbhost, $dbuname, $dbpass, $dbname);
if ($mysqli -> connect_errno) {
  die("You died of a first staged accident, exiled from our DB! Never come back!" . mysqli_connect_error());
}
?>

<html>
<head>
  <title>London Airbnb Database | Host | Update finished</title>
</head>

<body>
  <?php
  $id = $_SESSION['id'];
  $name = $_POST["name"];
  $summary = $_POST["summary"];
  $space = $_POST["space"];
  $description = $_POST["description"];
  $house_rules = $_POST["house_rules"];
  $price = $_POST["price"];
  $security_deposit = $_POST["security_deposit"];
  $cleaning_fee = $_POST["cleaning_fee"];

  if (empty($name)) {
    $query_name = "SELECT name FROM listings_details WHERE id = $id";
    $res = mysqli_query($mysqli, $query_name);
    $name = mysqli_fetch_row($res)[0];
  }
  if (empty($summary)) {
    $query_summary = "SELECT summary FROM listings_details WHERE id = $id";
    $res = mysqli_query($mysqli, $query_summary);
    $summary = mysqli_fetch_row($res)[0];
  }
  if (empty($space)) {
    $query_space = "SELECT space FROM listings_details WHERE id = $id";
    $res = mysqli_query($mysqli, $query_space);
    $space = mysqli_fetch_row($res)[0];
  }
  if (empty($description)) {
    $query_description = "SELECT description FROM listings_details WHERE id = $id";
    $res = mysqli_query($mysqli, $query_description);
    $description = mysqli_fetch_row($res)[0];
  }
  if (empty($house_rules)) {
    $query_house_rules = "SELECT house_rules FROM listings_details WHERE id = $id";
    $res = mysqli_query($mysqli, $query_house_rules);
    $house_rules = mysqli_fetch_row($res)[0];
  }
  if (empty($price)) {
    $query_price = "SELECT price FROM listings_expenses WHERE id = $id";
    $res = mysqli_query($mysqli, $query_price);
    $price = mysqli_fetch_row($res)[0];
  }
  if (empty($security_deposit)) {
    $query_security_deposit = "SELECT security_deposit FROM listings_expenses WHERE id = $id";
    $res = mysqli_query($mysqli, $query_security_deposit);
    $security_deposit = mysqli_fetch_row($res)[0];
  }
  if (empty($cleaning_fee)) {
    $query_cleaning_fee = "SELECT cleaning_fee FROM listings_expenses WHERE id = $id";
    $res = mysqli_query($mysqli, $query_cleaning_fee);
    $cleaning_fee = mysqli_fetch_row($res)[0];
  }

  $query = "CALL update_listings($id, '$name', '$summary', '$space', '$description',
    '$house_rules', $price, $security_deposit, $cleaning_fee)";
  // $query = "CALL update_listings($id, '$name', '$summary', '$space', '$description',
  //   '$house_rules', $price, $security_deposit, $cleaning_fee)";
  $res = mysqli_query($mysqli, $query);
  if (!$res) {
    die("You died of a second staged accident, exiled from our DB! Never come back!");
  }
  echo "You have successfully changed your listing information. "; ?>
  <br><a href="update.php">Go back to update.php</a>
</body>
</html>
