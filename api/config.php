<?php
// Database configuration
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$port = getenv('DB_PORT') ?: '5432'; // Default PostgreSQL port

// Validate port is numeric
if (!is_numeric($port)) {
    die("Invalid database port configuration");
}

// Create connection
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
$conn = pg_connect($connection_string);

// Check connection
if (!$conn) {
    die("PostgreSQL connection failed: " . pg_last_error($conn));
}

// Set error reporting
pg_set_error_verbosity($conn, PGSQL_ERRORS_VERBOSE);
?>