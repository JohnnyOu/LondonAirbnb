<?php $dbhost = '127.0.0.1';
$dbuname = 'root';
$dbpass = 'root';
$dbname = 'Airbnb';
$mysqli = new mysqli($dbhost, $dbuname, $dbpass, $dbname);
if ($mysqli -> connect_errno) {
  die("You died of a first staged accident, exiled from our DB! Never come back!" . mysqli_connect_error());
} ?>

<html>
<head>
  <title>London Airbnb Database | Guest</title>
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
  <h2> Welcome to Guest page!</h2>
  <a href="view_map.html">Click to view all listings on map</a><br><br><br>
  <form method="post">
    Search by keyword: <input type="text" name="keyword">
    <br>Choose a neighbourhood: <select type="text" name="neighbourhood_cleansed">
      <option value="%">Any</option>
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
    <br>Minimum price: <input type="number" name="min_price" value="min_price">
    <br>Maximum price: <input type="number" name="max_price" value="max_price">
    <br><input type="submit" name="submit"><input type="reset">
  </form>

  <?php if (isset($_POST["submit"])) {
    $keyword = $_POST["keyword"];
    $neighbourhood_cleansed = $_POST["neighbourhood_cleansed"];
    $min_price = $_POST["min_price"];
    $max_price = $_POST["max_price"];
    if (empty($min_price)) {
      $min_price = 0;
    }
    if (empty($max_price)) {
      $max_price = 65535;
    }
    $query = "CALL search('$keyword', '$neighbourhood_cleansed', $min_price, $max_price)";
    $res = mysqli_query($mysqli, $query);
    if (!$res) {
      die("You died of a second staged accident, exiled from our DB! Never come back!");
    } ?>
    <table>
      <thead>
        <th>Listing ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Host name</th>
        <th>Is superhost?</th>
        <th># of listings by same host</th>
        <th>Borough</th>
        <th>Availability for next 365 days</th>
        <th>Price</th>
        <th>Rating/100</th>
        <th># of reviews</th>
        <th>Cancellation policy</th>
      </thead>
      <?php $count = 0;
      while ($row = mysqli_fetch_row($res)) { ?>
        <tr>
          <?php for ($i = 0; $i < 12; $i++) { ?>
            <td><?php echo $row[$i]?></td>
          <?php } ?>
        </tr>
      <?php $count++;
    } ?>
    </table>
  <?php echo $count . " result(s) found.";
} ?>
</body>
</html>
