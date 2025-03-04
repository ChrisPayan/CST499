<?php
    // Database connection details
    $servername = "xxxx";
    $username = "xxxx";
    $password = "xxxx";
    $dbname = "xxxx"; 


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        echo"Connection Failed";
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $userId = $_POST['userID'];

    $password = $_POST['password'];


    // Validate input
    if (empty($userId) || empty($password)) {
        header("Location: login.php?error=emptyfields");
        exit();
    }
    // Prepare and execute SQL statement to retrieve user data
    $stmt = $conn->prepare("SELECT password FROM users WHERE userID = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();
 

    // Check if password matches
    echo gettype($password);
    echo gettype($storedPassword);

    if (password_verify($password, $storedPassword)) {
        // Start session and store user ID
        session_start();
        $_SESSION['userId'] = $userId;

        // Redirect to home page
        header("Location: index.php");
        exit();
    } else {
        //Handle login failure (e.g., display error message)
        header("Location: login.php?error=invalid");
        exit();
    }

    $stmt->close();
    $conn->close();
?>