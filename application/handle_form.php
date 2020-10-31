<?php session_start(); ?>

<html>
<head>
</head>

<body>
  <?php
    $name_index = $_POST["name"];
    if ($name_index == "host") {
      header('Location: host.php');
    } else {
      header('Location: guest.php');
    }
  ?>
</body>
</html>
