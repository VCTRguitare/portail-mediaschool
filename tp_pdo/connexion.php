<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "projet_victor_dutel";
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (\PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>