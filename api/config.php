<?php
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$port = getenv('DB_PORT') ?: '5432'; // Default PostgreSQL port

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$pass port=$port");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}