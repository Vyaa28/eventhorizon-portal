<?php
$serverName = "tcp:eventhorizon-sqlserver-thivya.database.windows.net,1433";
$database   = "eventhorizon-db";
$username   = "sqladmin";
$password   = "Password@123";

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
