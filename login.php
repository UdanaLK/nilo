<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Default WAMP username
$password = "";     // Default WAMP password is empty
$dbname = "nilo_recipes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header("Location: welcome.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
} else {
    echo "Form not submitted correctly.";
}

$conn->close();
?>
