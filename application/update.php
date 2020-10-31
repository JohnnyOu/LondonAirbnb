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
  <title>London Airbnb Database | Host | Update listing</title>
  <style>
    table {
      border-collapse: collapse;
      border: 1px #000000 solid;
    }
    tr, td {
      border: 1px #000000 solid;
    }
    textarea {
      max-width: 100%;
    }
  </style>
</head>
<body>
  <?php $host_id = $_SESSION['host_id']; ?>
  Enter your listing ID you would like to update:
  <form method="post">
    <input name="id" value="id" type="number">
    <input type="submit" name="submit">
  </form>

  <?php if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $_SESSION['id'] = $id;
    $answer;

    $call = $mysqli->prepare("CALL check_id($host_id, $id, @answer)");
    $call->bind_param('ii', $host_id, $id);
    $call->execute();

    if (!$call) {
      die("You died of a second staged accident, exiled from our DB! Never come back!");
    }

    $select = $mysqli->query('SELECT @answer');
    $result = $select->fetch_assoc();
    $answer = $result['@answer'];

    if ($answer != 1) {
      echo "You are not authorized to change the listing with ID " . $id . ". "; ?>
      <br>Please only change your own listings.
    <?php } else {
      $attributes = "SELECT name, summary, space, description, house_rules,
        price, security_deposit, cleaning_fee
        FROM listings_details JOIN listings_expenses USING (id)
        WHERE id = $id";
      $res = mysqli_query($mysqli, $attributes);
      if (!$res) {
        die("You died of a second staged accident, exiled from our DB! Never come back!");
      }
      $row = mysqli_fetch_row($res); ?>

      <form method="post">
        <input type="submit" name="submit" formaction="update_finish.php">
        <input type="reset"><br><br>
        Name: <?php echo $row[0] ?><br>
        <textarea rows="1" cols="50" name="name" placeholder="Enter new name"></textarea><br><br>

        Summary: <?php echo $row[1] ?><br>
        <textarea rows = "10" cols = "100" name = "summary" placeholder="Enter new summary"></textarea><br><br>

        Space: <?php echo $row[2] ?><br>
        <textarea rows = "10" cols = "100" name = "space" placeholder="Enter new space"></textarea><br><br>

        Description: <?php echo $row[3] ?><br>
        <textarea rows = "10" cols = "100" name = "description" placeholder="Enter new description"></textarea><br><br>

        House rules: <?php echo $row[4] ?><br>
        <textarea rows = "10" cols = "100" name = "house_rules" placeholder="Enter new house rules"></textarea><br><br>

        Price: <?php echo $row[5] ?><br>
        <input type="number" name="price" placeholder="Enter new price"><br><br>

        Security deposit: <?php echo $row[6] ?><br>
        <input type="number" name="security_deposit" placeholder="Enter new security deposit"><br><br>

        Cleaning fee: <?php echo $row[7] ?><br>
        <input type="number" name="cleaning_fee" placeholder="Enter new cleaning fee"><br><br>

        <input type="submit" name="submit" formaction="update_finish.php">
        <input type="reset">
      </form>
    <?php }
  } ?>
</body>
</html>
