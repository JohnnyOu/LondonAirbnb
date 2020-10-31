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
  <title>London Airbnb Database | Host | View Profile</title>
  <style>
    table {
      border-collapse: collapse;
      border: 1px #000000 solid;
    }
    tr, td {
      border: 1px #000000 solid;
    }
    /* th.About_Information {
      width: 50%;
    } */
  </style>
</head>
<body>
  <?php
  $host_id = $_SESSION['host_id'];
  $query = "SELECT * FROM listings_host WHERE host_id = $host_id";
  $res = mysqli_query($mysqli, $query);
  if (!$res) {
    die("You died of a second staged accident, exiled from our DB! Never come back!");
  }
  $row = mysqli_fetch_row($res); ?>

  <img src=<?php echo $row[11]?>>

  <table>
    <col width="20%">
    <col width="80%">
    <tr><td><b>Host ID</b></td><td><?php echo $row[0]?></td></tr>
    <tr><td><b>URL</b></td><td><a href=<?php echo $row[1]?>><?php echo $row[1]?></td></tr>
    <tr><td><b>Name</b></td><td><?php echo $row[2]?></td></tr>
    <tr><td><b>Host since</b></td><td><?php echo $row[3]?></td></tr>
    <tr><td><b>Location</b></td><td><?php echo $row[4]?></td></tr>
    <tr><td><b>About</b></td><td><?php echo $row[5]?></td></tr>
    <tr><td><b>Response time</b></td><td><?php echo $row[6]?></td></tr>
    <tr><td><b>Response rate</b></td><td><?php echo $row[7]?></td></tr>
    <tr><td><b>Acceptance rate</b></td><td><?php echo $row[8]?></td></tr>
    <tr><td><b><b>Is superhost?</b></td><td><?php echo $row[9]?></td></tr>
    <tr><td><b>Neighbourhood</b></td><td><?php echo $row[12]?></td></tr>
    <tr><td><b>Listings count</b></td><td><?php echo $row[13]?></td></tr>
    <tr><td><b>Total listings count</b></td><td><?php echo $row[14]?></td></tr>
    <tr><td><b>Verification</b></td><td><?php echo $row[15]?></td></tr>
    <tr><td><b>Has profile pic?</b></td><td><?php echo $row[16]?></td></tr>
    <tr><td><b>Identity verified?</b></td><td><?php echo $row[17]?></td></tr>
    <tr><td><b>Host listings count</b></td><td><?php echo $row[18]?></td></tr>
	  <tr><td><b>Host listings count (entire homes)</b></td><td><?php echo $row[19]?></td></tr>
	  <tr><td><b>Host listings count (private rooms)</b></td><td><?php echo $row[20]?></td></tr>
	  <tr><td><b>Host listings count (shared rooms)</b></td><td><?php echo $row[21]?></td></tr>
  </table>
</body>
</html>
