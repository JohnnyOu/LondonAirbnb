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
  <title>London Airbnb Database | Host</title>
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

  <h2>Welcome to Host page!</h2>
  <form method="post">
    Enter your host ID: <input name="host_id" value="host_id" type="number">
    <input type="submit" name="submit">
  </form>

  <?php
    if (isset($_POST["submit"])) {
      $host_id = $_POST["host_id"];
      $_SESSION['host_id'] = $host_id;
      $query = "SELECT host_name, host_url, id, name, neighbourhood_cleansed, zipcode, listing_url
        FROM listings_host JOIN listings_details USING (host_id)
          JOIN listings_location USING (id) JOIN listings_url USING (id)
        WHERE host_id = $host_id";
      $res = mysqli_query($mysqli, $query);
      if (!$res) {
        die("You died of a second staged accident, exiled from our DB! Never come back!");
      }
      if ($row = mysqli_fetch_row($res)) {
        echo "Welcome, " . $row[0] . "! Here are your listings:"; ?>
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
          <?php do { ?>
            <tr>
              <td><?php echo $row[2]?></td>
              <td><?php echo $row[3]?></td>
              <td><?php echo $row[4]?></td>
              <td><?php echo $row[5]?></td>
              <td><a href=<?php echo $row[6]?>><?php echo $row[6]?></a></td>
            </tr>
          <?php } while ($row = mysqli_fetch_row($res)); ?>
          </tbody>
        </table>
        <?php echo "What would you like to do today?"; ?>
        <form action="handle_form_host.php" method="post">
          <input type="radio" name="option" value="view" />View my profile
          <input type="radio" name="option" value="insert" />Add another listing
          <input type="radio" name="option" value="update" />Change a listing
          <input type="radio" name="option" value="delete" />Delete a listing
          <input type="submit" />
        </form>
      <?php } else {
        echo "No results found.";
      }
      mysqli_free_result($res);
    } ?>
</body>
</html>
