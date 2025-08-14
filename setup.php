<?php
// Check if config.php exists
if (!file_exists('config.php')) {
    die('<h1>Error: config.php not found.</h1><p>Please rename <strong>config-sample.php</strong> to <strong>config.php</strong> and fill in your database details.</p>');
}

require_once('config.php');

// Check if database details are filled
if (DB_NAME === 'your_database_name' || DB_USER === 'your_username' || DB_PASSWORD === 'your_password') {
    die('<h1>Error: Database details not set.</h1><p>Please open <strong>config.php</strong> and fill in your MySQL database credentials.</p>');
}

// Establish connection to MySQL server
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

// Check connection
if ($conn->connect_error) {
    die("<h1>Database Connection Failed</h1><p>Could not connect to the MySQL server. Error: " . $conn->connect_error . "</p><p>Please check your credentials in <strong>config.php</strong>.</p>");
}

echo "<h1>Database Connection Successful!</h1>";

// Create the database if it doesn't exist
$db_creation_query = "CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET " . DB_CHARSET;
if ($conn->query($db_creation_query) === TRUE) {
    echo "<p>Database '" . DB_NAME . "' created successfully or already exists.</p>";
} else {
    die("<p>Error creating database: " . $conn->error . "</p>");
}

// Select the database
$conn->select_db(DB_NAME);

echo "<h1>Database Setup</h1>";

// Read the SQL file
$sql = file_get_contents('schema.sql');
if ($sql === false) {
    die("<p>Error: Cannot read <strong>schema.sql</strong>. Please make sure the file exists in the same directory.</p>");
}

// Execute multi-query
if ($conn->multi_query($sql)) {
    // Clear results from the buffer
    while ($conn->next_result()) {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    }
    echo "<p>Tables created successfully from <strong>schema.sql</strong>.</p>";
    echo "<h2>Setup is complete!</h2>";
    echo "<p>You can now delete this <strong>setup.php</strong> file for security.</p>";
    echo '<p><a href="index.php">Go to the application</a></p>';
} else {
    echo "<p>Error importing schema: " . $conn->error . "</p>";
}

$conn->close();
?>
