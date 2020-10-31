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
<head>
  <title>London Airbnb Database | Delete listing</title>
  <style>
  table {
    border-collapse: collapse;
    border: 1px #000000 solid;
  }
  th, td {
    border: 1px #000000 solid;
  }
  </style>
</head>

<body>
  <?php $host_id = $_SESSION['host_id']; ?>
  Enter your listing ID you would like to delete:
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
      echo "You are not authorized to delete the listing with ID " . $id . ". "; ?>
      <br>Please only change your own listings.
    <?php } else {
      $_SESSION['id'] = $id;
      echo "Are you sure you want to delete the following listing?";
      $query = "SELECT id, name, neighbourhood_cleansed, zipcode, listing_url
        FROM listings_host JOIN listings_details USING (host_id)
          JOIN listings_location USING (id) JOIN listings_url USING (id)
        WHERE id = $id";
      $res = mysqli_query($mysqli, $query);
      if (!$res) {
        die("You died of a second staged accident, exiled from our DB! Never come back!");
      }
      $row = mysqli_fetch_row($res); ?>
      <table>
        <thead>
        <tr>
          <th>Listing ID</th>
          <th>Name</th>
          <th>Borough</th>
          <th>Postal code</th>
          <th>Link</th>
        </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $row[0]?></td>
            <td><?php echo $row[1]?></td>
            <td><?php echo $row[2]?></td>
            <td><?php echo $row[3]?></td>
            <td><a href=<?php echo $row[4]?>><?php echo $row[4]?></a></td>
          </tr>
        </tbody>
      </table>
      <form action="delete_finish.php" method="post">
        <input type="radio" name="option" value="yes">Yes
        <input type="radio" name="option" value="no">No
        <input type="submit" name="submit">
      </form>
    <?php }
  } ?>
</body>
</html>
