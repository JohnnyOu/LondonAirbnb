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
// include 'host.php';
?>

<html>
<head>
  <title>London Airbnb Database | Host | Insert listing</title>
  <style>
    table {
      border-collapse: collapse;
      border: 1px #000000 solid;
    }
    tr, td {
      border: 1px #000000 solid;
    }
  </style>
</head>
<body>
  <form method="post">
  Create a new listing:
  <br>ID (required): <input type="number" name="id" placeholder="Enter new ID" required>
  <br>Name: <input type="text" name="name" placeholder="Enter new name" required>
  <br>Summary:
  <br><textarea rows="10" cols="100" name="summary" placeholder="Enter new summary" required></textarea>
  <br>Space:
  <br><textarea rows="10" cols="100" name="space" placeholder="Enter new space" required></textarea>
  <br>Description:
  <br><textarea rows="10" cols="100" name="description" placeholder="Enter new description" required></textarea>
  <br>House rules:
  <br><textarea rows="10" cols="100" name="house_rules" placeholder="Enter new house rules" required></textarea>
  <br>Choose a neighbourhood: <select type="text" name="neighbourhood_cleansed">
    <option value="City of London">City of London</option>
    <option value="Barking and Dagenham">Barking and Dagenham</option>
    <option value="Barnet">Barnet</option>
    <option value="Bexley">Bexley</option>
    <option value="Brent">Brent</option>
    <option value="Bromley">Bromley</option>
    <option value="Camden">Camden</option>
    <option value="Croydon">Croydon</option>
    <option value="Ealing">Ealing</option>
    <option value="Enfield">Enfield</option>
    <option value="Greenwich">Greenwich</option>
    <option value="Hackney">Hackney</option>
    <option value="Hammersmith and Fulham">Hammersmith and Fulham</option>
    <option value="Haringey">Haringey</option>
    <option value="Harrow">Harrow</option>
    <option value="Havering">Havering</option>
    <option value="Hillingdon">Hillingdon</option>
    <option value="Hounslow">Hounslow</option>
    <option value="Islington">Islington</option>
    <option value="Kensington and Chelsea">Kensington and Chelsea</option>
    <option value="Kingston upon Thames">Kingston upon Thames</option>
    <option value="Lambeth">Lambeth</option>
    <option value="Lewisham">Lewisham</option>
    <option value="Merton">Merton</option>
    <option value="Newham">Newham</option>
    <option value="Redbridge">Redbridge</option>
    <option value="Richmond upon Thames">Richmond upon Thames</option>
    <option value="Southwark">Southwark</option>
    <option value="Sutton">Sutton</option>
    <option value="Tower Hamlets">Tower Hamlets</option>
    <option value="Waltham Forest">Waltham Forest</option>
    <option value="Wandsworth">Wandsworth</option>
    <option value="Westminster">Westminster</option>
  </select>
  <br>Availability in the next 365 days: <input type="number" name="availability_365"
    placeholder="0-365">
  <br>Price: <input type="text" name="price" placeholder="0-65535" required>
  <br>Security deposit: <input type="text" name="security_deposit" placeholder="0-65535" required>
  <br>Cleaning fee: <input type="text" name="cleaning_fee" placeholder="0-65535" required>
  <br>Choose cancellation policy: <select type="text" name="cancellation_policy">
    <option value="strict_14_with_grace_period">Strict 14 with grace period</option>
    <option value="super_strict_30">Super strict 30</option>
    <option value="flexible">Flexible</option>
    <option value="moderate">Moderate</option>
  </select><br><br><br>
  <input type="submit" name="submit">
</form>


  <?php
  if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $summary = $_POST["summary"];
    $space = $_POST["space"];
    $description = $_POST["description"];
    $house_rules = $_POST["house_rules"];
    $host_id = $_SESSION['host_id'];
    $neighbourhood_cleansed = $_POST["neighbourhood_cleansed"];
    $availability_365 = $_POST["availability_365"];
    $price = $_POST["price"];
    $security_deposit = $_POST["security_deposit"];
    $cleaning_fee = $_POST["cleaning_fee"];
    $cancellation_policy = $_POST["cancellation_policy"];
    $result;

    $call = $mysqli->prepare("CALL insert_listings($id, '$name', '$summary', '$space',
      '$description', '$house_rules', $host_id, '$neighbourhood_cleansed', $availability_365,
      $price, $security_deposit, $cleaning_fee, '$cancellation_policy', @result)");
    $call->bind_param('isssssisiiiis', $id, $name, $summary, $space, $description, $house_rules,
      $host_id, $neighbourhood_cleansed, $availability_365, $price, $security_deposit,
      $cleaning_fee, $cancellation_policy);
    $call->execute();
    if (!$call) {
      die("You died of a second staged accident, exiled from our DB! Never come back!");
    }
    $select = $mysqli->query("SELECT @result");
    $res = $select->fetch_assoc();
    $result = $res['@result'];
    if ($result == 'C') {
      echo "You have successfully inserted a new listing named " . $name . ".";
    } else {
      echo "Insertion failed.";
    }

  }?>

</body>
</html>
