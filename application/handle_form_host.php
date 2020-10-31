<?php
// include 'host.php';
?>

<html>
<head>
</head>

<body>
  <?php
    $name = $_POST["option"];
    if ($name == "view") {
      header('Location: view.php');
    } else if ($name == "insert") {
      header('Location: insert.php');
    } else if ($name == "update") {
      header('Location: update.php');
    } else {
      header('Location: delete.php');
    }
  ?>
</body>
</html>
