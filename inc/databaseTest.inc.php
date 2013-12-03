<!-- Sam Cussons Code -->
<?php
  $mysqlusername='root';      // MySQL Username
  $mysqlpassword='TTF43upc';  // MySQL Password
  $mysqldatabase="WebDev";   // MySQL Database Name
  $host='localhost';          // MySQL Location
  
  try {
    $dsn = "mysql:host=".$host.";dbname=".$mysqldatabase;
    // try connecting to the database
    $conn = new PDO($dsn, $mysqlusername, $mysqlpassword);
    // turn on PDO exception handling 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    // enter catch block in event of error in preceding try block
    echo "Connection failed: ".$e->getMessage();
  }
?>