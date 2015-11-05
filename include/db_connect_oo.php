<?php // db_connect_oo.php ?>
<?php include "env.php" ?>
<?php
  // Create connection

  $conn = new mysqli($server, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit;
  } else {
    //echo "Success: connected to MySQL";
  }

  // $con->close();

?>
