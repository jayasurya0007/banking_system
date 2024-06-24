<?php
$servername = "localhost";
$username = "root"; 
$password = "Jaya@2004"; 
$dbname = "sample"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username_input = $_POST['username'];
$password_input = $_POST['password'];

$validation_stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$validation_stmt->bind_param("s", $username_input);

if (!$validation_stmt->execute()) {
    die("Execute failed: " . $validation_stmt->error);
}
$validation_result = $validation_stmt->get_result();

if ($validation_result->num_rows > 0) {
    $row = $validation_result->fetch_assoc();
    $stored_password_hash = $row['password'];
    if ($password_input==$stored_password_hash) {
        echo "<script>alert('Login Successful');</script>";
    } else {
        echo "Error: Invalid username or password - Password does not match";
    }
} else {
    echo "Error: Invalid username or password - Username not found";
}
$validation_stmt->close();
$conn->close();
?>
